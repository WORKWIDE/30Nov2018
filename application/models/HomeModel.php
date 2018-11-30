<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class HomeModel extends MY_Model {

    function __construct() {
        parent::__construct();
        
    }

    public function taskStatusNotification($user_id = NULL) {

        $table = QM_NOTIFICATION;
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join(QM_TASK, QM_NOTIFICATION . '.task_id = ' . QM_TASK . '.id');
        $this->db->join(QM_STATUS_TYPE, QM_NOTIFICATION . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->where($table . '.user_id', $user_id);
        $this->db->order_by(QM_NOTIFICATION . ".id", "desc");
        $this->db->limit(6);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function taskStatusNotificationCount($user_id = NULL) {

        $table = QM_NOTIFICATION;
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join(QM_TASK, QM_NOTIFICATION . '.task_id = ' . QM_TASK . '.id');
        $this->db->join(QM_STATUS_TYPE, QM_NOTIFICATION . '.status_id = ' . QM_STATUS_TYPE . '.id');
        $this->db->where($table . '.user_id', $user_id);
        $this->db->where($table . '.notification_status', 0);
        $this->db->order_by(QM_NOTIFICATION . ".id", "desc");
        $this->db->limit(6);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = $query->num_rows();
        return $data;
    }

    public function taskStatusnotificationCheck($userid) {
        $data = array('notification_status' => 1);
        $this->db->where('user_id', $userid);
        $this->db->update(QM_NOTIFICATION, $data);
        //echo $this->db->last_query();
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function totalwebuser() {
        $this->db->select('count(id) as totalwebuser');
        $this->db->from(QM_WEB_ACCESS);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->totalwebuser;
        }
        return null;
    }

    public function totalfse() {
        $this->db->select('count(id) as totalfse');
        $this->db->from(QM_FSE_DETAILS);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->totalfse;
        }
        return null;
    }

    public function totalentity() {
        $this->db->select('count(id) as totalentity');
        $this->db->from(QM_ENTITY);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->totalentity;
        }
        return null;
    }

    public function totalbranch() {
        $this->db->select('count(id) as totalbranch');
        $this->db->from(QM_BRANCH);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->totalbranch;
        }
        return null;
    }

    public function totalprojectincident() {
        $this->db->select('count(id) as totalprojectincident');
        $this->db->from(QM_PROJECT);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->totalprojectincident;
        }
        return null;
    }

    public function totaltask() {
        $this->db->select('count(id) as totaltask');
        $this->db->from(QM_TASK);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->totaltask;
        }
        return null;
    }

    public function ProjectCount() {
        $data_project = array();
        $i = 0;
        $this->db->select('id,status_type');
        $this->db->from(QM_STATUS_TYPE);
//        if ($this->session->userdata('session_data')->is_admin != 1) {
//            $this->db->where(QM_STATUS_TYPE . '.ent_id', $this->session->userdata('session_data')->ent_id);
//        }
        $this->db->where('status_stat', 1);
        $status_type_q = $this->db->get();
        if ($status_type_q->num_rows() > 0) {
            $status_type = $status_type_q->result_array();
            foreach ($status_type AS $st) {
                $this->db->select('count(id) as totaltask');
                $this->db->from(QM_TASK);
                $this->db->where(QM_TASK . '.status_id', $st['id']);
                $this->db->where(QM_TASK . '.project_id != ', 0, FALSE);
                if ($this->session->userdata('session_data')->is_admin != 1) {
                 $this->db->where(QM_TASK . '.ent_id', $this->session->userdata('session_data')->ent_id);
                }
                $query = $this->db->get();
                if ($query->num_rows() > 0) {

                    $row = $query->row();
                    $data_project[$i]['label'] = $st['status_type'];
                    $data_project[$i]['value'] = $row->totaltask;
                    $i++;
                }
            }
        } else {
            $data_project[0]['label'] = '';
            $data_project[0]['value'] = '';
        }
        return json_encode($data_project);
    }

    public function IncidentCount() {
        $data_project = array();
        $i = 0;
        $this->db->select('id,status_type');
        $this->db->from(QM_STATUS_TYPE);
        
        $this->db->where('status_stat', 1);
        $status_type_q = $this->db->get();
        if ($status_type_q->num_rows() > 0) {
            $status_type = $status_type_q->result_array();
            foreach ($status_type AS $st) {
                $this->db->select('count(id) as totaltask');
                $this->db->from(QM_TASK);
                $this->db->where(QM_TASK . '.status_id', $st['id']);
                $this->db->where(QM_TASK . '.incident_id != ', 0, FALSE);
                if ($this->session->userdata('session_data')->is_admin != 1) {
                 $this->db->where(QM_TASK . '.ent_id', $this->session->userdata('session_data')->ent_id);
                }
                $query = $this->db->get();
                if ($query->num_rows() > 0) {

                    $row = $query->row();
                    $data_project[$i]['label'] = $st['status_type'];
                    $data_project[$i]['value'] = $row->totaltask;
                    $i++;
                }
            }
        } else {
            $data_project[0]['label'] = '';
            $data_project[0]['value'] = '';
        }
        return json_encode($data_project);
    }

    public function TaskCount() {
        $data_project = array();
        $i = 0;
        $this->db->select('id,status_type');
        $this->db->from(QM_STATUS_TYPE);
        $this->db->where('status_stat', 1);
        $status_type_q = $this->db->get();
        if ($status_type_q->num_rows() > 0) {
            $status_type = $status_type_q->result_array();
            foreach ($status_type AS $st) {
                $this->db->select('count(id) as totaltask');
                $this->db->from(QM_TASK);
                $this->db->where(QM_TASK . '.status_id', $st['id']);
                if ($this->session->userdata('session_data')->is_admin != 1) {
                 $this->db->where(QM_TASK . '.ent_id', $this->session->userdata('session_data')->ent_id);
                }
                $query = $this->db->get();
                if ($query->num_rows() > 0) {

                    $row = $query->row();
                    $data_project[$i]['label'] = $st['status_type'];
                    $data_project[$i]['value'] = $row->totaltask;
                    $i++;
                }
            }
        } else {
            $data_project[0]['label'] = '';
            $data_project[0]['value'] = '';
        }
        return json_encode($data_project);
    }

    public function fseTaskComplete() {
        $i = 0;
        $data = array();
        $this->db->select('count(status_id) as total,fse_username');
        $this->db->from(QM_TASK);
        $this->db->join(QM_FSE_DETAILS, QM_FSE_DETAILS . '.id = ' . QM_TASK . '.fse_id');
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_TASK . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }
        $this->db->order_by('total', 'desc');
        $this->db->group_by(QM_FSE_DETAILS . '.id');
        //$this->db->where('status_id', 4);
        $this->db->limit(6);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $datas = $query->result_array();
            foreach ($datas AS $d) {
                 $data[$i]['label'] = $d['fse_username'];
                 $data[$i]['value'] = $d['total'];
                 $i++;
            }
        }else {
            $data[0]['label'] = '';
            $data[0]['value'] = '';
        }
        return json_encode($data);
    }
    
    
    public function user_list($limit="") 
    { 
     $LogginUserid=$this->session->userdata('session_data')->user_id;
        
      $CheckUserType=$this->db->select(QM_WEB_ACCESS.'.id as `qm_web_access_id`,'.QM_WEB_USER_TYPE.'.web_user_type')
                            ->from(QM_FSE_DETAILS)
                            ->join(QM_WEB_ACCESS,QM_FSE_DETAILS.'.ent_id='.QM_WEB_ACCESS.'.ent_id')
                            ->join(QM_WEB_USER_TYPE,QM_WEB_ACCESS.'.user_type='.QM_WEB_USER_TYPE.'.id')
                            ->where(QM_WEB_ACCESS.'.id',$LogginUserid)
                            ->get();
        
        $Result_CheckUserType=$CheckUserType->result_array();
        
        if($Result_CheckUserType[0]['web_user_type'] == 'Administrator' || $Result_CheckUserType[0]['web_user_type']== 'administrator')
        {           
        
                  $this->db->select(QM_FSE_DETAILS.'.fse_name,'.QM_FSE_DETAILS.'.fse_address,'.QM_FSE_DETAILS.'.fse_email,'.QM_FSE_DETAILS.'.id,'.QM_FSE_TYPE.'.fse_type');
                $this->db->select(QM_FSE_LOCATION.'.fse_lat,'.QM_FSE_LOCATION.'.fse_long,'.QM_FSE_LOCATION.'.locationaddress,');
                $this->db->from(QM_FSE_DETAILS);
                $this->db->join(QM_FSE_LOCATION, QM_FSE_DETAILS.'.id = '.QM_FSE_LOCATION.'.Fse_id', 'left');
                $this->db->join(QM_FSE_TYPE, QM_FSE_DETAILS.'.fse_type_id = '.QM_FSE_TYPE.'.id', 'left');
                $this->db->order_by(QM_FSE_LOCATION.'.LocationTime', 'DESC');
                $query = $this->db->get();
                $d = $query->result_array();
                return $d;                     
        }
        else
        {
              $query=$this->db->query("SELECT ".QM_FSE_DETAILS.".ent_id,".QM_FSE_DETAILS.".id,".QM_FSE_DETAILS.".fse_name,".QM_FSE_LOCATION.".fse_lat,".QM_FSE_LOCATION.".fse_long,".QM_FSE_LOCATION.".locationaddress FROM ".QM_FSE_DETAILS."                                         
                                    left join ".QM_WEB_ACCESS." on ".QM_WEB_ACCESS.".ent_id=".QM_FSE_DETAILS.".ent_id
                                    left join ".QM_FSE_LOCATION." on ".QM_FSE_LOCATION.".Fse_id=".QM_FSE_DETAILS.".id                                    
                                    where ".QM_WEB_ACCESS.".id=".$LogginUserid." ORDER BY ".QM_FSE_LOCATION.".LocationTime DESC");
              $result= $query->result_array(); 
              return $result;
        }
      
       
    }
    
      public function filterdata1()
    {
          
           $LogginUserid=$this->session->userdata('session_data')->user_id;
        
      $CheckUserType=$this->db->select(QM_WEB_ACCESS.'.id as `qm_web_access_id`,'.QM_WEB_USER_TYPE.'.web_user_type,'.QM_WEB_ACCESS.'.user_type')
                            ->from(QM_FSE_DETAILS)
                            ->join(QM_WEB_ACCESS,QM_FSE_DETAILS.'.ent_id='.QM_WEB_ACCESS.'.ent_id')
                            ->join(QM_WEB_USER_TYPE,QM_WEB_ACCESS.'.user_type='.QM_WEB_USER_TYPE.'.id')
                            ->where(QM_WEB_ACCESS.'.id',$LogginUserid)
                            ->get();
        
        $Result_CheckUserType=$CheckUserType->result_array();
       // print_r($Result_CheckUserType);        exit(); 
        
       $sql="SELECT qm_fse_details.fse_name,qm_fse_details.fse_address,qm_fse_details.fse_email,qm_fse_details.id,qm_fse_location.fse_lat,qm_fse_location.fse_long,qm_fse_location.locationaddress From qm_fse_details LEFT JOIN qm_fse_location ON qm_fse_details.id = qm_fse_location.fse_id";
        if($this->input->post('skill_set')) 
            $sql.=" LEFT JOIN qm_fse_type ON qm_fse_details.fse_type_id = qm_fse_type.id ";
        
        if($this->input->post('Status')){
             $sql.=" LEFT JOIN qm_status_type ON qm_fse_details.fse_status = qm_status_type.id";
            
        }
        if($Result_CheckUserType[0]['user_type'] != 1 || $Result_CheckUserType[0]['user_type']!= 1)
        {           
            $sql.=" left join qm_web_access on qm_web_access.ent_id=qm_fse_details.ent_id "; 
        }
        $sql.=" where 1 AND qm_fse_details.duty_mode=1";
        if($Result_CheckUserType[0]['user_type'] != 1 || $Result_CheckUserType[0]['user_type']!= 1)
        {
            $sql.=" AND qm_web_access.id=$LogginUserid"; 
        }   
        if($this->input->post('name_fse'))
        {      $uname= trim($this->input->post('name_fse'));
            $sql.=" AND qm_fse_details.fse_name LIKE '%$uname%'";
        }  
         if($this->input->post('address')){
             $address=  trim ($this->input->post('address'));
             $sql.=" AND qm_fse_location.locationaddress LIKE '%$address%'";
         }
         if($this->input->post('Status')){
            $ustatus= trim ($this->input->post('Status')); 
             $sql.=" AND qm_fse_details.id IN (select fse_id from qm_task where status_id IN (select id from qm_status_type where status_type like '%$ustatus%'))";
         } 
       //echo  $this->db->get_compiled_select();          exit(); 
        if($this->input->post('skill_set')) 
        {
            $skillss= trim ($this->input->post('skill_set')); 
            $sql.=" AND qm_fse_details.id IN (SELECT qm_fse_details_engineer_types.fse_details_id From qm_fse_details_engineer_types where qm_fse_details_engineer_types.fse_type_id IN (SELECT qm_fse_type.id From qm_fse_type where qm_fse_type.fse_type LIKE '%$skillss%'))";
        }
               
        if($this->input->post('Redius'))
        {
            $ids= $this->get_redius($this->input->post('latitude'),$this->input->post('langitude'),$this->input->post('Redius')); 
           if($ids)
           $sql.=" AND qm_fse_details.id IN ($ids)" ;
        }
        if($this->input->post('Priority')) {
           $fse_id_data = $this->get_fseId_By_Task($this->input->post('Priority'));
           //print_r($fse_id_data);           exit(); 
           
         $tuser=  count($fse_id_data)-1; 
        // print_r($tuser);         exit(); 
           if($fse_id_data)
            $sql.=" AND qm_fse_details.id BETWEEN $fse_id_data[0] AND $fse_id_data[$tuser]" ;
         } 
         //$sql.=" LIMIT 5";  
       
      //print_r($sql); exit(); 
        $query = $this->db->query($sql);
         if($query->num_rows()>0){
            $d = $query->result_array();
            return $d;
        }
        
    }
    
    
    public function get_redius($lat,$lng,$miles)
    {
        if(isset($lat)&&isset($lang)&& isset($miles)){
                $sql="SELECT
                        qm_fse_location.fse_id, (
                          3959 * acos (
                            cos ( radians(" . $lat . ") )
                            * cos( radians(qm_fse_location.fse_lat) )
                            * cos( radians( qm_fse_location.fse_long ) - radians(" . $lng . ") )
                            + sin ( radians(" . $lat . ") )
                            * sin( radians( qm_fse_location.fse_lat ) )
                          )
                        ) AS distance
                      FROM qm_fse_location
                      LEFT JOIN qm_task ON qm_task.fse_id = qm_fse_location.fse_id
                      HAVING distance < ".$miles;
            //$sql="SELECT *,( 6371 * acos( cos( radians(41.989597) ) * cos( radians( `fse_lat` ) ) * cos( radians( `fse_long` ) - radians(-87.659934) ) + sin( radians(41.989597) ) * sin( radians( `fse_lat` ) ) ) ) AS distance FROM `qm_fse_location` HAVING distance <= 3 ORDER BY distance ASC ";
       $query = $this->db->query($sql);
        if($query->num_rows()>0)
        { $b = $query->result_array();
            foreach($b as $bb)
            {
                $data[]=$bb['fse_id']; 
            }
          return implode(',',$data); 
        }
        
        }else{            return false; }
      
        
    }

    public function get_fseId_By_Task($priority)
    {       
          $this->db->distinct();
          $this->db->select(QM_TASK.'.fse_id');
          $this->db->from(QM_TASK);
          $this->db->where(QM_TASK.'.priority',$priority);
       //   echo $this->db->get_compiled_select();          exit(); 
         // $this->db->limit(300);
          $query=$this->db->get(); 
//        $sql="SELECT qm_task.fse_id from qm_task where priority ='".$priority."' LIMIT 10";
//       $query = $this->db->query($sql);
        $a = $query->result_array();
       // print_r(count($a)); exit(); 
        foreach($a as $aa)
        {
            $data[]=$aa['fse_id']; 
        }
      //  print_r($data);        exit(); 
        if($query->num_rows()>0){
            return $data;
            // return implode(',',$data); 
        }
        
      
        
        
    }
    
    public function getuserdetail()
    {
         $this->db->select(QM_FSE_DETAILS.'.id,'.QM_FSE_DETAILS.'.fse_name,'.QM_FSE_DETAILS.'.fse_address,'.QM_FSE_DETAILS.'.fse_email,'.QM_FSE_DETAILS.'.id');
         $this->db->select(QM_TASK.'.*');
         $this->db->from(QM_FSE_DETAILS);
         $this->db->join(QM_TASK, QM_FSE_DETAILS.'.id ='.QM_TASK.'.fse_id', 'left');
         if($this->input->post('id')){
            $this->db->where(QM_FSE_DETAILS.'.id',$this->input->post('id'));
             $this->db->where(QM_FSE_DETAILS.'.duty_mode', 1);
           $this->db->order_by(QM_TASK.".updated_date", "desc");
            
         }
        
        $query = $this->db->get();
        $a = $query->result_array();
        $i=0; 
        foreach ($a As $aa) 
        {           
          $a[$i]['taskType']= $this->getta($aa['task_type_id']);
          $a[$i]['FesType']= $this->FesType($aa['fse_id']);
          $i++; 
        }
      return $a; 
    }
    public function FesType($typeid)
    {
        $this->db->select(QM_FSE_TYPE.'.fse_type');
        $this->db->from(QM_FSE_DETAILS_ENGINEERS);
         $this->db->join(QM_FSE_TYPE, QM_FSE_TYPE.'.id ='.QM_FSE_DETAILS_ENGINEERS.'.fse_type_id', 'left');
        $this->db->where(QM_FSE_DETAILS_ENGINEERS.'.fse_details_id',$typeid);
        $query = $this->db->get();
        $a = $query->result_array();
        return $a;
    }

    public function getta($Tid)
    {
        $this->db->select(QM_STATUS_TYPE.'.status_type');
        $this->db->from(QM_STATUS_TYPE);
        $this->db->where(QM_STATUS_TYPE.'.id',$Tid);
        $query = $this->db->get();
        $a = $query->result_array();
        return $a;
        
    }
    public function get_skill_set()
    {
        $LogginUserid=$this->session->userdata('session_data')->user_id;
        
              $CheckUserType=$this->db->select(QM_WEB_ACCESS.'.id as `qm_web_access_id`,'.QM_WEB_USER_TYPE.'.web_user_type,'
                                               .QM_FSE_TYPE.'.ent_id,'.QM_FSE_TYPE.'.fse_type')
                            ->from(QM_FSE_TYPE)
                            ->join(QM_WEB_ACCESS,QM_FSE_TYPE.'.ent_id='.QM_WEB_ACCESS.'.ent_id')
                            ->join(QM_WEB_USER_TYPE,QM_WEB_ACCESS.'.user_type='.QM_WEB_USER_TYPE.'.id')
                            ->where(QM_WEB_ACCESS.'.id',$LogginUserid)
                            ->get();
        
        $Result_CheckUserType=$CheckUserType->result_array();
        
        if($Result_CheckUserType[0]['web_user_type'] == 'Administrator' || $Result_CheckUserType[0]['web_user_type']== 'administrator')
        { 
            $this->db->select(QM_FSE_TYPE.'.fse_type');
            $this->db->from(QM_FSE_TYPE);        
            $this->db->where(QM_FSE_TYPE.'.fse_type_status',1);  
            
        }else {
              $this->db->select(QM_FSE_TYPE.'.fse_type');
            $this->db->from(QM_FSE_TYPE);
            $this->db->join(QM_WEB_ACCESS,QM_FSE_TYPE.'.ent_id='.QM_WEB_ACCESS.'.ent_id');
            $this->db->where(QM_FSE_TYPE.'.fse_type_status',1);
            $this->db->where(QM_WEB_ACCESS.'.id',$LogginUserid);
        }
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $datas = $query->result_array();
            return $datas;
            
        }
    }
    public function get_status_set()
    {
        $this->db->select(QM_STATUS_TYPE.'.status_type');
        $this->db->from(QM_STATUS_TYPE);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $datas = $query->result_array();
          //  print_r($datas);            die(); 
            return $datas;
            
        }
    }
    public function get_priority_set()
    {
        $this->db->select(QM_PRIORITY.'.priority_type,'.QM_PRIORITY.'.id');
        $this->db->from(QM_PRIORITY);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $datas = $query->result_array();
           // print_r($datas);            die(); 
            return $datas;
            
        }
    }
    
    
}
