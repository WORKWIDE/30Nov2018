<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LoginModel extends MY_Model {

    function __construct() {
        parent::__construct();
         $this->load->library('PHPMailer');
        $this->load->library('SMTP');
    }

    public function login($username, $password) {         
        $query = $this->db->query('SELECT * FROM ' . QM_WEB_ACCESS . ' WHERE web_username = "' . $username . '"  AND web_password = "' . $password . '";');

        if ($query->num_rows() == 0) {
            $query = $this->db->query('SELECT * FROM ' . QM_WEB_ACCESS . ' WHERE web_username = "' . $username . '"  AND web_password = "' . md5($password) . '";');
            $row = $query->row_array();
           // print_r($row); echo 'dfdfsd'; exit; 
        } else {
            $row = $query->row_array();
        }
        if ($query->num_rows() == 1) {
            $session_data = $this->data;
            $session_data->user_id = $row['id'];
            $session_data->name = $row['web_name'];
            $session_data->branch_id = $row['branch_id'];
            $session_data->user_type = $row['user_type'];
            $entity_is_admin = NULL;
            $q = $this->db->query('SELECT user_id FROM ' . QM_USER_ASSIGN_ENTITY . ' WHERE entity_id = "' . $row['ent_id'] . '"  ORDER BY id DESC LIMIT 1;');
            if($q->num_rows() > 0){
            $p = $q->row_array();
            $session_data->entity_admin = $p['user_id'];
            $entity_is_admin = $p['user_id'];
            }else{$session_data->entity_admin = NULL;}
            if($entity_is_admin == $row['id'])
            {$session_data->is_entity_admin = 1;}else{$session_data->is_entity_admin = NULL;}
            $session_data->email = $row['web_email'];
            $session_data->ent_id = $row['ent_id'];
            $session_data->is_admin = $row['is_admin'];
            $this->session->set_userdata('session_data',$session_data);
            redirect('dashboard','refresh');
        } else {
            $this->session->set_flashdata('error', 'Check Username and Password !!!');
            redirect('/','refresh');
        }
    }

    public function check_user_email_exist($email='')
    {
     $result=  $this->db->select('id')->FROM(QM_WEB_ACCESS)->WHERE(QM_WEB_ACCESS.'.web_email',$email)->get()->result_array();
        if (count($result)>0) {
            return true;

        }else{

            return false; 

        }
    }

    public function forgot_password($email='')
    {
       if (empty($email)) {
           return false; 
       }
       $activation_code_part = "";
        if (function_exists("openssl_random_pseudo_bytes")) { 
            $activation_code_part = openssl_random_pseudo_bytes(128);            
        }
        for ($i = 0; $i < 1024; $i++) {
            $activation_code_part = sha1($activation_code_part . mt_rand() . microtime());
        }
        $key= $activation_code_part; 
        $user_email=$email; 
        // $key = $this->hash_code($activation_code_part . $email);
        //    echo $key; exit();
        // // If enable query strings is set, then we need to replace any unsafe characters so that the code can still work
        // if ($key != '' && $this->config->item('permitted_uri_chars') != '' && $this->config->item('enable_query_strings') == FALSE) {
        //     if (!preg_match("|^[" . str_replace(array('\\-', '\-'), '-', preg_quote($this->config->item('permitted_uri_chars'), '-')) . "]+$|i", $key)) {
        //         $key = preg_replace("/[^" . $this->config->item('permitted_uri_chars') . "]+/i", "-", $key);
        //     }
        // }

        $update = array(
            'forgotten_password_code' => $key,
            'forgotten_password_time' => time()
        );
        $this->db->WHERE(QM_WEB_ACCESS.'.web_email',$user_email);
        $this->db->update(QM_WEB_ACCESS,$update);

       
      

//        $config['useragent'] = 'CodeIgniter';
//        $config['protocol'] = 'smtp';
//        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
//        $config['smtp_user'] = 'mitroz.padamm@gmail.com'; // Your gmail id
//        $config['smtp_pass'] = 'maher0122'; // Your gmail Password
//        $config['smtp_port'] = 465;
//        $config['wordwrap'] = TRUE;
//        $config['wrapchars'] = 76;
//        $config['mailtype'] = 'html';
//        $config['charset'] = 'iso-8859-1';
//        $config['validate'] = FALSE;
//        $config['priority'] = 3;
//        $config['newline'] = "\r\n";
//        $config['crlf'] = "\r\n";
//        $this->load->library('email');
//        $this->email->initialize($config);
//
//        $this->email->from('mitroz.padamm@gmail.com', 'WorkWide');
//        $this->email->to($user_email);
//        $this->email->subject('Reset your password ');
//        $this->email->message('<!DOCTYPE html>
//        <html><head>
//          <title>Rating Reminder
//          </title>
//          <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
//          <meta content="width=device-width" name="viewport">
//        </head>
//        <body style="background-color: #f4f4f5;">
//        <table cellpadding="0" cellspacing="0" style="width: 100%; height: 100%; background-color: #f4f4f5; text-align: center;">
//            <tbody>
//              <tr>
//                <td style="text-align: center;">
//                  <table align="center" cellpadding="0" cellspacing="0" id="body" style="background-color: #fff; width: 100%; max-width: 680px; height: 100%;">
//                    <tbody>
//                      <tr>
//                        <td>
//                          <table align="center" cellpadding="0" cellspacing="0" class="page-center" style="text-align: left; padding-bottom: 88px; width: 100%; padding-left: 120px; padding-right: 120px;">
//                            <tbody>
//                             <tr>
//                                <td colspan="2" style="padding-top: 72px; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%; color: #000000; font-family: \'Postmates Std\', \'Helvetica\', -apple-system, BlinkMacSystemFont, \'Segoe UI\', \'Roboto\', \'Oxygen\', \'Ubuntu\', \'Cantarell\', \'Fira Sans\', \'Droid Sans\', \'Helvetica Neue\', sans-serif; font-size: 48px; font-smoothing: always; font-style: normal; font-weight: 600; letter-spacing: -2.6px; line-height: 52px; mso-line-height-rule: exactly; text-decoration: none;">Reset your password
//                             </td>
//                              <tr>
//                                <td style="padding-top: 48px; padding-bottom: 48px;">
//                                  <table cellpadding="0" cellspacing="0" style="width: 100%">
//                                    <tbody>
//                                      <tr>
//                                        <td style="width: 100%; height: 1px; max-height: 1px; background-color: #d9dbe0; opacity: 0.81">
//                                        </td>
//                                      </tr>
//                                    </tbody>
//                                  </table>
//                                </td>
//                              </tr>
//                              <tr>
//                                <td style="-ms-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%; color: #9095a2; font-family: \'Postmates Std\', \'Helvetica\', -apple-system, BlinkMacSystemFont, \'Segoe UI\', \'Roboto\', \'Oxygen\', \'Ubuntu\', \'Cantarell\', \'Fira Sans\', \'Droid Sans\', \'Helvetica Neue\', sans-serif; font-size: 16px; font-smoothing: always; font-style: normal; font-weight: 400; letter-spacing: -0.18px; line-height: 24px; mso-line-height-rule: exactly; text-decoration: none; vertical-align: top; width: 100%;">
//                                  You\'re receiving this e-mail because you requested a password reset for your Postmates account.
//                                </td>
//                              </tr>
//                              <tr>
//                                <td style="padding-top: 24px; -ms-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%; color: #9095a2; font-family: \'Postmates Std\', \'Helvetica\', -apple-system, BlinkMacSystemFont, \'Segoe UI\', \'Roboto\', \'Oxygen\', \'Ubuntu\', \'Cantarell\', \'Fira Sans\', \'Droid Sans\', \'Helvetica Neue\', sans-serif; font-size: 16px; font-smoothing: always; font-style: normal; font-weight: 400; letter-spacing: -0.18px; line-height: 24px; mso-line-height-rule: exactly; text-decoration: none; vertical-align: top; width: 100%;">
//                                  Please tap the button below to choose a new password.
//                                </td>
//                              </tr>
//                              <tr>
//                                <td>
//                                  <a data-click-track-id="37" href="'.base_url().'resetpassword/'.$key.'" style="margin-top: 36px; -ms-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%; color: #ffffff; font-family: \'Postmates Std\', \'Helvetica\', -apple-system, BlinkMacSystemFont, \'Segoe UI\', \'Roboto\', \'Oxygen\', \'Ubuntu\', \'Cantarell\', \'Fira Sans\', \'Droid Sans\', \'Helvetica Neue\', sans-serif; font-size: 12px; font-smoothing: always; font-style: normal; font-weight: 600; letter-spacing: 0.7px; line-height: 48px; mso-line-height-rule: exactly; text-decoration: none; vertical-align: top; width: 220px; background-color: #00cc99; border-radius: 28px; display: block; text-align: center; text-transform: uppercase" target="_blank">
//                                    Reset Password
//                                  </a>
//                                </td>
//                              </tr>
//                            </tbody>
//                          </table>
//                        </td>
//                      </tr>
//                    </tbody>
//                  </table>
//        </body></html>');
//        if ($this->email->send()&&$this->db->affected_rows() == 1) {
//            return true; 
//                    // $this->trigger_events(array('post_forgotten_password', 'post_forgotten_password_successful'));
//        }else{
//            return false;  
//           /// $this->trigger_events(array('post_forgotten_password', 'post_forgotten_password_unsuccessful'));
//        }
            $form_name = 'ABC';
            $enquirer_name = "Quintica";
            $company_name = "Work Wide";
            $retype = ucfirst(strtolower("SSS"));
            $enquirer_email = "Workwidemobile@quintica.com";
            $country = "india";
            $contact = "123698";
            $subject_title = "Email from Quintica credentials ";
            $mail_body = '<!DOCTYPE html>
        <html><head>
          <title>Rating Reminder
          </title>
          <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
          <meta content="width=device-width" name="viewport">
        </head>
        <body style="background-color: #f4f4f5;">
        <table cellpadding="0" cellspacing="0" style="width: 100%; height: 100%; background-color: #f4f4f5; text-align: center;">
            <tbody>
              <tr>
                <td style="text-align: center;">
                  <table align="center" cellpadding="0" cellspacing="0" id="body" style="background-color: #fff; width: 100%; max-width: 680px; height: 100%;">
                    <tbody>
                      <tr>
                        <td>
                          <table align="center" cellpadding="0" cellspacing="0" class="page-center" style="text-align: left; padding-bottom: 88px; width: 100%; padding-left: 120px; padding-right: 120px;">
                            <tbody>
                             <tr>
                                <td colspan="2" style="padding-top: 72px; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%; color: #000000; font-family: \'Postmates Std\', \'Helvetica\', -apple-system, BlinkMacSystemFont, \'Segoe UI\', \'Roboto\', \'Oxygen\', \'Ubuntu\', \'Cantarell\', \'Fira Sans\', \'Droid Sans\', \'Helvetica Neue\', sans-serif; font-size: 48px; font-smoothing: always; font-style: normal; font-weight: 600; letter-spacing: -2.6px; line-height: 52px; mso-line-height-rule: exactly; text-decoration: none;">Reset your password
                             </td>
                              <tr>
                                <td style="padding-top: 48px; padding-bottom: 48px;">
                                  <table cellpadding="0" cellspacing="0" style="width: 100%">
                                    <tbody>
                                      <tr>
                                        <td style="width: 100%; height: 1px; max-height: 1px; background-color: #d9dbe0; opacity: 0.81">
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td style="-ms-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%; color: #9095a2; font-family: \'Postmates Std\', \'Helvetica\', -apple-system, BlinkMacSystemFont, \'Segoe UI\', \'Roboto\', \'Oxygen\', \'Ubuntu\', \'Cantarell\', \'Fira Sans\', \'Droid Sans\', \'Helvetica Neue\', sans-serif; font-size: 16px; font-smoothing: always; font-style: normal; font-weight: 400; letter-spacing: -0.18px; line-height: 24px; mso-line-height-rule: exactly; text-decoration: none; vertical-align: top; width: 100%;">
                                  You\'re receiving this e-mail because you requested a password reset for your Postmates account.
                                </td>
                              </tr>
                              <tr>
                                <td style="padding-top: 24px; -ms-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%; color: #9095a2; font-family: \'Postmates Std\', \'Helvetica\', -apple-system, BlinkMacSystemFont, \'Segoe UI\', \'Roboto\', \'Oxygen\', \'Ubuntu\', \'Cantarell\', \'Fira Sans\', \'Droid Sans\', \'Helvetica Neue\', sans-serif; font-size: 16px; font-smoothing: always; font-style: normal; font-weight: 400; letter-spacing: -0.18px; line-height: 24px; mso-line-height-rule: exactly; text-decoration: none; vertical-align: top; width: 100%;">
                                  Please tap the button below to choose a new password.
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <a data-click-track-id="37" href="' . base_url() . 'resetpassword/' . $key . '" style="margin-top: 36px; -ms-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%; color: #ffffff; font-family: \'Postmates Std\', \'Helvetica\', -apple-system, BlinkMacSystemFont, \'Segoe UI\', \'Roboto\', \'Oxygen\', \'Ubuntu\', \'Cantarell\', \'Fira Sans\', \'Droid Sans\', \'Helvetica Neue\', sans-serif; font-size: 12px; font-smoothing: always; font-style: normal; font-weight: 600; letter-spacing: 0.7px; line-height: 48px; mso-line-height-rule: exactly; text-decoration: none; vertical-align: top; width: 220px; background-color: #00cc99; border-radius: 28px; display: block; text-align: center; text-transform: uppercase" target="_blank">
                                    Reset Password
                                  </a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
        </body></html>';
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';
            $mail->SMTPAuth = true; // turn on SMTP authentication
            $mail->Username = "Workwidemobile@quintica.com"; // SMTP username
            $mail->Password = "Qu1ntic@"; // SMTP password
            $webmaster_email = "Workwidemobile@quintica.com"; //Reply to this email ID
            $mail->Port = "587";
            $mail->Host = 'smtp.office365.com'; //hostname
            $name = "Work Wide"; 
            $mail->From = $enquirer_email;
            $mail->FromName = $enquirer_name;
            $mail->AddAddress($user_email, $name);
            $mail->AddReplyTo($enquirer_email, $enquirer_name);
            $mail->WordWrap = 50; // set word wrap
            $mail->IsHTML(false); // send as HTML
            $mail->Subject = $subject_title;
            $mail->MsgHTML($mail_body);
            $mail->AltBody = "This is the body when user views in plain text format"; //Text Body
            if ($mail->Send()&&$this->db->affected_rows() == 1) {
                return true;
            } else {
                return FALSE; 
            }
        
       
    }



     public function hash_code($password) {
        return $this->hash_password($password, FALSE, TRUE);
    }

     public function hash_password($password, $salt = false, $use_sha1_override = FALSE) {
        if (empty($password)) {
            return FALSE;
        }

        // bcrypt
        if ($use_sha1_override === FALSE) {
            return $this->bcrypt->hash($password);
        }


        if ($this->store_salt && $salt) {
            return sha1($password . $salt);
        } else {
            $salt = $this->salt();
            return $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
        }
    }


    public function forgotten_password_check($code='')
    {
       $result=  $this->db->select('id,web_email')->FROM(QM_WEB_ACCESS)->WHERE(QM_WEB_ACCESS.'.forgotten_password_code',$code)->get()->result_array();
       return  $result;
    } 

    public function clear_forgotten_password_code($code) {

        if (empty($code)) {
            return FALSE;
        }

        $this->db->where('forgotten_password_code', $code);

        if ($this->db->count_all_results(QM_WEB_ACCESS) > 0) {
            $data = array(
                'forgotten_password_code' => NULL,
                'forgotten_password_time' => NULL
            );

            $this->db->update(QM_WEB_ACCESS, $data);

            return TRUE;
        }

        return FALSE;
    }



    public function reset_password($identity, $new) {


        $result=  $this->db->select('id')->FROM(QM_WEB_ACCESS)->WHERE(QM_WEB_ACCESS.'.web_email',$identity)->get()->result_array();
        if (empty($result)) {
           return false; 
        }
        
        $new_password= md5($new); 
         $data = array(
            'web_password' => $new_password,
            'remember_code' => NULL,
            'forgotten_password_code' => NULL,
            'forgotten_password_time' => NULL,
        );

       $this->db->where('web_email', $identity);
       $this->db->update(QM_WEB_ACCESS, $data);

        if ($this->db->affected_rows() == 1) {
            $return=1; 
        } else { 
            $return='';
        }

        return $return;

    }

}
