<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LoginController extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Data', 'data');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->load->model("LoginModel");
    }

    public function index() {
        $data['page'] = 'LoginView';
        $valid = $this->session->userdata('session_data');
        if (isset($valid)) {
            if ($valid->user_id != NULL && $valid->user_type != NULL) {
                redirect('dashboard', 'refresh');
            }
        }                
        $this->load->view("LoginView", $data);
    }

    public function check() {
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        $this->form_validation->set_rules('username', 'password', 'required');        
        if ($this->form_validation->run() == FALSE) {           
            $this->session->set_flashdata('error', 'Check Username and Password !!!');
            redirect('/','refresh');
        } else {
            $this->LoginModel->login($username, $password);
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('/','refresh');
    }
    
    public function locked() {
        redirect('/','refresh');
    }
    
    public function error_404() {
        $this->load->view("page_404");
    }

    public function forgot_password()
    {   
       // echo "string"; exit();

     $this->form_validation->set_rules('email', 'email', 'required');
           if ($this->form_validation->run() == false) {
                   $data['page'] = 'forgot_password';
                    $this->load->view("forgot_password", $data);
           }else{

            $email= $this->input->post('email');


             $checkexist= $this->LoginModel->check_user_email_exist($email); 

             if ($checkexist) {  
               $data= $this->LoginModel->forgot_password($email); 
                // echo "string"; exit();
               if ($data) {
                     $this->session->set_flashdata('success_message', 'Password Reset email send Sucessful');
                    redirect("/", 'refresh');
               }else
               {
                 $this->session->set_flashdata('error_message', 'Password Reset UnSuccessfully');
                  redirect("forgetpassword", 'refresh');
               }
                                
             }else{                   
                    $this->session->set_flashdata('error_message', 'Email id not Found');
                    redirect("forgetpassword", 'refresh');
             }

           }
    }

    public function Rest_password($code = NULL)
    { 
       if (!$code) {
            show_404();
        } 
       // print_r($_POST); exit() ;
        $user = $this->LoginModel->forgotten_password_check($code);
       // print_r($user[0]['id']); exit();
        if ($user) { 
         $this->form_validation->set_rules('new','new', 'required|min_length[8]|max_length[16]|matches[new_confirm]');
          $this->form_validation->set_rules('new_confirm','reset new password', 'required'); 
            if ($this->form_validation->run() == false) {    //print_r('dfdfdf'); exit();

                $data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'data-error' => '.errorTxtnew',
                );
               $data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{8}.*$',
                    'data-error' => '.errorconfirm',

                );
               $data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user[0]['id'],
                );
               $data['csrf'] = $this->_get_csrf_nonce();
                $data['code'] = $code;
                $data['page'] = 'reset_webuser_password';
              $this->load->view("reset_webuser_password", $data);
            }else{
                    if ($this->_valid_csrf_nonce() === FALSE || $user[0]['id'] != $this->input->post('user_id')) {
                        $this->LoginModel->clear_forgotten_password_code($code);
                        $this->session->set_flashdata('error_message', 'forgor password Link has been  is Expire');
                       redirect("forgetpassword", 'refresh');
                    }else{
                         $identity = $user[0]['web_email'];
                         $change = $this->LoginModel->reset_password($identity, $this->input->post('new'));
                          $this->session->set_flashdata('success_message', 'Password Reset Sucessful');
                           redirect("/", 'refresh');
                    }


                }//////elese end 
            }else{
                $this->session->set_flashdata('error_message', 'forgor password Link has been  is Expire');
                    redirect("forgetpassword", 'refresh');
            }
    }


     public function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    public function _valid_csrf_nonce() {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
