<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class TaskModel extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function Task($search = NULL) {

        $this->db->select(QM_PROJECT . '.id as project_id,'
                . QM_INCIDENT . '.id as incident_id,'
                . QM_TASK . '.*,'
                . QM_TASK . '.id,'
                . QM_TASK . '.fse_id,'
                . QM_TASK . '.task_type_id,'
                . QM_TASK . '.task_name,'
                . QM_TASK . '.branch_id,'
                . QM_TASK . '.project_id,'
                . QM_TASK . '.incident_id,'
                . QM_TASK . '.customer_id,'
                . QM_TASK . '.web_user_id,'
                . QM_TASK . '.task_description,'
                . QM_TASK . '.start_date,'
                . QM_TASK . '.end_date,'
                . QM_TASK . '.status_id,'
                . QM_TASK . '.sla_id,'
                . QM_TASK . '.fse_feedback,'
                . QM_TASK . '.customer_sign,'
                . QM_TASK . '.task_status,'
                . QM_TASK . '.task_address,'
                . QM_TASK . '.product_name,'
                . QM_TASK . '.serial_number,'
                . QM_TASK . '.product_code,'
                . QM_TASK . '.book_code,'
                . QM_TASK . '.manual_docket_number,'
                . QM_TASK . '.call_number,'
                . QM_TASK . '.customer_name,'
                . QM_TASK . '.customer_contact_person,'
                . QM_TASK . '.customer_contact_number,'
                . QM_TASK . '.model,'
                . QM_TASK . '.problem,'
                . QM_TASK . '.message,'
                . QM_TASK . '.comment_charge,'
                . QM_TASK . '.previous_meter_reading,'
                . QM_TASK . '.previous_color_reading,'
                . QM_TASK . '.outstanding_calls,'
                . QM_TASK . '.created_date,'
                . QM_FSE_DETAILS . '.fse_name,'
                . QM_STATUS_TYPE . '.status_type,'
                . QM_BRANCH . '.branch_name,'
                . QM_ENTITY . '.ent_name,'
                . QM_TASK_LOCATION . '.task_location,'
                . QM_TASK_LOCATION . '.start_time,'
                . QM_TASK_LOCATION . '.reached_time,'
                . QM_TASK_LOCATION . '.total_travel_time,'
                . QM_TASK_LOCATION . '.start_to_work_time,'
                . QM_TASK_LOCATION . '.Work_completed_time,'
                . QM_TASK_LOCATION . '.total_worked_time,'
                . QM_TASK_LOCATION . '.geo_km,'
                . QM_SLA . '.sla_name,'
                . QM_TASK_TYPE . '.task_type,'
                . QM_PROJECT . '.proj_name,'
                . QM_INCIDENT . '.incident_name,'
                . QM_CALL_STATUS_TYPE . '.callstatus_type,'
                . QM_CALL_TYPE . '.calltype_type, '
                . QM_PRIORITY . '.priority_type');
        $this->db->from(QM_TASK);
        $this->db->join(QM_FSE_DETAILS, QM_TASK . '.fse_id = ' . QM_FSE_DETAILS . '.id', 'LEFT');
        $this->db->join(QM_TASK_TYPE, QM_TASK . '.task_type_id = ' . QM_TASK_TYPE . '.id', 'LEFT');
        $this->db->join(QM_STATUS_TYPE, QM_TASK . '.status_id = ' . QM_STATUS_TYPE . '.id', 'LEFT');
        $this->db->join(QM_BRANCH, QM_TASK . '.branch_id = ' . QM_BRANCH . '.id', 'LEFT');
        $this->db->join(QM_ENTITY, QM_TASK . '.ent_id = ' . QM_ENTITY . '.id', 'LEFT');
        $this->db->join(QM_PROJECT, QM_TASK . '.project_id = ' . QM_PROJECT . '.id', 'LEFT');
        $this->db->join(QM_INCIDENT, QM_TASK . '.incident_id = ' . QM_INCIDENT . '.id', 'LEFT');

        $this->db->join(QM_CALL_STATUS_TYPE, QM_TASK . '.call_status = ' . QM_CALL_STATUS_TYPE . '.id', 'LEFT');
        $this->db->join(QM_CALL_TYPE, QM_TASK . '.call_type = ' . QM_CALL_TYPE . '.id', 'LEFT');
        $this->db->join(QM_PRIORITY, QM_TASK . '.priority = ' . QM_PRIORITY . '.id', 'LEFT');

        //$this->db->join(QM_CUSTOMER_DETAILS, QM_TASK . '.customer_id = ' . QM_CUSTOMER_DETAILS . '.id', 'LEFT');
        $this->db->join(QM_SLA, QM_TASK . '.sla_id = ' . QM_SLA . '.id', 'LEFT');
        $this->db->join(QM_TASK_LOCATION, QM_TASK . '.id = ' . QM_TASK_LOCATION . '.task_id', 'LEFT');
        $this->db->order_by(QM_TASK . '.id', 'DESC');
        $this->db->where(QM_TASK . '.task_status', 1);
        if ($this->session->userdata('session_data')->is_admin != 1) {
            $this->db->where(QM_TASK . '.ent_id', $this->session->userdata('session_data')->ent_id);
        }

        if ($search != NULL) {
            $start_date = date('Y-m-d', strtotime($search['start_date']));
            $end_date = date('Y-m-d', strtotime($search['end_date']));
            $this->db->where('date(' . QM_TASK . '.created_date) >=', $start_date);
            $this->db->where('date(' . QM_TASK . '.created_date) <=', $start_date);
        } else {
            $this->db->limit('30');
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function updateTask($id = NULL) {

        $this->db->select(QM_TASK . '.*,'
                . QM_FSE_DETAILS . '.fse_name,'
       //         . QM_PROJECT . '.proj_name,'
              //  . QM_INCIDENT . '.incident_name'
                );
        $this->db->from(QM_TASK);
        $this->db->join(QM_FSE_DETAILS, QM_TASK . '.fse_id = ' . QM_FSE_DETAILS . '.id', 'LEFT');
     //   $this->db->join(QM_PROJECT, QM_TASK . '.project_id = ' . QM_PROJECT . '.id', 'LEFT');
     //   $this->db->join(QM_INCIDENT, QM_TASK . '.incident_id = ' . QM_INCIDENT . '.id', 'LEFT');
        $this->db->where(QM_TASK . '.id', $id);

        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function updateTaskScreen($taskid = NULL, $cat_id = NULL) {

        $this->db->select(QM_EXTRA_ATTR_UPDATE . '.*,'
                . QM_CATEGORY . '.category as category'
        );
        $this->db->from(QM_EXTRA_ATTR_UPDATE);
        $this->db->join(QM_TASK, QM_TASK . '.task_type_id = ' . QM_EXTRA_ATTR_UPDATE . '.task_type', 'LEFT');
        $this->db->join(QM_CATEGORY, QM_EXTRA_ATTR_UPDATE . '.category_id = ' . QM_CATEGORY . '.id', 'LEFT');
        $this->db->where(QM_TASK . '.id =', $taskid);
      //  $this->db->where(QM_EXTRA_ATTR_UPDATE . '.category_id =', $cat_id);
        $query = $this->db->get();
        $result = $query->result_array();
        $data = array();
        $i = 0;
//        echo "<pre>";
//        print_r($result);
//        
//        exit();
        if(empty($result)){return TRUE;}
        foreach ($result as $r) {

            $this->db->select(QM_EXTRA_ATTR_UPDATE_VALUE . '.value');
            $this->db->from(QM_EXTRA_ATTR_UPDATE_VALUE);
            $this->db->where('update_atr_id', $r['id']);
            $this->db->where('cat_id', $r['category_id']);
            $this->db->where('task_id', $taskid);
            $this->db->order_by(QM_EXTRA_ATTR_UPDATE_VALUE . '.id', 'DESC');
             $this->db->limit('1');
            $querys = $this->db->get();
            if ($querys->num_rows() == 1) {
                $post_values = $querys->row()->value;
            } else {
                $post_values = "";
            }

            $data[$i]['id'] = $r['id'];
            $data[$i]['label'] = $r['label'];
            $data[$i]['option_type'] = $r['option_type'];
            $data[$i]['type_limit'] = $r['type_limit'];
            $data[$i]['required_status'] = $r['required_status'];
            $data[$i]['type_values'] = json_decode($r['type_values']);
            $data[$i]['post_values'] = $post_values;
            $data[$i]['category'] = $r['category'];
            $i++;
        }
        //  echo $this->db->last_query();
        return $data;
    }
    

    public function taskUpdateView($task_id = NULL) {
        $this->db->select(QM_TASK . '.id as task_id,'
                . QM_TASK . '.task_type_id,'
                . QM_TASK . '.*,'
                . QM_CATEGORY . '.category,'
                . QM_CATEGORY . '.id as cat_id');
        $this->db->from(QM_TASK);
        $this->db->join(QM_CATEGORY, QM_CATEGORY . '.task_type = ' . QM_TASK . '.task_type_id');
        $this->db->where(QM_TASK . '.id', $task_id);
        $query = $this->db->get();
        $result = $query->result_array();
      //  echo "<pre>";
        $cat_array = $data = array();
        //print_r($result);
        if (!empty($result)) {
            foreach ($result as $r) {
                // print_r($r);
                $cat_array['category'] = $r['category'];
                $cat_array['cat_id'] = $r['cat_id'];
                $cat = $this->taskUpdateViewfieldMaping($r['task_id'], $r['cat_id'], $r['task_type_id']);
                $data[] = array_merge($cat_array,$cat);
            }
        }
        
        $datas['update_arr'] = $data;
          
        return array_merge($result[0],$datas);
    }

    public function taskUpdateViewfieldMaping($task_id = NULL, $cat_id = NULL, $task_type_id = NULL) {

        $this->db->select(QM_EXTRA_ATTR_UPDATE . '.id as update_field_id,'
                . QM_EXTRA_ATTR_UPDATE . '.label');
        $this->db->from(QM_EXTRA_ATTR_UPDATE);
        $this->db->where(QM_EXTRA_ATTR_UPDATE . '.category_id', $cat_id);
        $this->db->where(QM_EXTRA_ATTR_UPDATE . '.task_type', $task_type_id);
        $query = $this->db->get();
        $result = $query->result_array();
        
        $value = array();
        $i = 0;
        if (!empty($result)) {
            foreach ($result as $r) {
            $value[$i]['value'] =  $this->taskUpdateViewfieldMapingValue($task_id, $cat_id, $task_type_id,$r['update_field_id']);
            $value[$i]['label'] = $r['label'];
            $value[$i]['update_field_id'] =   $r['update_field_id'];     
             $i++;  
            }
        }
        //print_r($value);

        return $value;
    }
    
    public function DetailViewTaskDetails($task_id = NULL) {
       $this->db->select(QM_TASK . '.task_name,'
                . QM_TASK . '.task_address,'
                . QM_TASK . '.start_date,'
                . QM_TASK . '.id,'
                . QM_TASK . '.fse_checklist,'
                . QM_TASK . '.fse_task_comments,'
                . QM_TASK . '.fse_reason,'
                . QM_TASK . '.fse_feedback,'
                . QM_TASK . '.customer_sign,'
                . QM_TASK . '.task_type_id,'
                . QM_TASK . '.fse_id,'
                . QM_TASK . '.status_id,'
                . QM_TASK_LOCATION . '.task_location,'
                . QM_TASK_LOCATION . '.start_time,'
                . QM_TASK_LOCATION . '.reached_time,'
                . QM_TASK_LOCATION . '.total_travel_time,'
                . QM_TASK_LOCATION . '.start_to_work_time,'
                . QM_TASK_LOCATION . '.Work_completed_time,'
                . QM_TASK_LOCATION . '.total_worked_time,'
                . QM_TASK_LOCATION . '.geo_km,'
                . QM_TASK . '.created_date,'
                . QM_FSE_DETAILS . '.fse_name,'
                . QM_STATUS_TYPE . '.status_type,'
                . QM_TASK_TYPE . '.task_type,'
                . QM_PRIORITY . '.priority_type'
        );
        $this->db->from(QM_TASK);
        $this->db->join(QM_FSE_DETAILS, QM_TASK . '.fse_id = ' . QM_FSE_DETAILS . '.id', 'LEFT');
        $this->db->join(QM_STATUS_TYPE, QM_TASK . '.status_id = ' . QM_STATUS_TYPE . '.id', 'LEFT');
        $this->db->join(QM_PRIORITY, QM_TASK . '.priority = ' . QM_PRIORITY . '.id', 'LEFT');
        $this->db->join(QM_TASK_TYPE, QM_TASK . '.task_type_id = ' . QM_TASK_TYPE . '.id', 'LEFT');
        $this->db->join(QM_TASK_LOCATION, QM_TASK . '.id = ' . QM_TASK_LOCATION . '.task_id', 'LEFT');
       // $this->db->where(QM_TASK . '.task_status', 1);
        $this->db->where(QM_TASK . '.id', $task_id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function updateTaskScreenimage($task_id = NULL) {
       $this->db->select(QM_TASK_CUSTOMER_DOCUMENT . '.*');
        $this->db->from(QM_TASK_CUSTOMER_DOCUMENT);
        $this->db->where(QM_TASK_CUSTOMER_DOCUMENT . '.task_id', $task_id);
        $query = $this->db->get();
       //  echo $this->db->last_query();
        return $query->result_array();
    }
    
    
     public function taskUpdateViewfieldMapingValue($task_id = NULL, $cat_id = NULL, $task_type_id = NULL,$id_value) {

        $this->db->select(QM_EXTRA_ATTR_UPDATE_VALUE . '.value');
        $this->db->from(QM_EXTRA_ATTR_UPDATE_VALUE);
        $this->db->where(QM_EXTRA_ATTR_UPDATE_VALUE . '.cat_id', $cat_id);
        $this->db->where(QM_EXTRA_ATTR_UPDATE_VALUE . '.type_id', $task_type_id);
        $this->db->where(QM_EXTRA_ATTR_UPDATE_VALUE . '.task_id', $task_id);
        $this->db->where(QM_EXTRA_ATTR_UPDATE_VALUE . '.update_atr_id', $id_value);
        $query = $this->db->get();
        $result = $query->result_array();
        //print_r($result);
        if (!empty($result)) {
            return $result[0]['value'];
        }
        return; 
    }
    

    public function taskcreateFields() {
        $task_type_id = $this->session->userdata('session_data')->task_type_id;
        $this->db->select(QM_EXTRA_ATTR_DEFINITION . '.*,'
                . QM_CATEGORY . '.category');
        $this->db->from(QM_EXTRA_ATTR_DEFINITION);
        $this->db->join(QM_CATEGORY, QM_EXTRA_ATTR_DEFINITION . '.Ext_att_category_id = ' . QM_CATEGORY . '.id', 'LEFT');
        $this->db->where(QM_EXTRA_ATTR_DEFINITION . '.Task_type_ID', $task_type_id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function updateTasks($id) {
        $table = QM_TASK;
        $sql = $this->db->last_query();
        return $this->SelectWhere($id, $table);
    }

    public function typeDetails() {
        // $data['getFse'] = $this->getFse();
        //   $data['getProject'] = $this->getProject();
        //  $data['getIncident'] = $this->getIncident();
        //  $data['getCustomer'] = $this->getCustomer();
        $data['getStatus'] = $this->getStatus();
        //$data['getBranch'] = $this->getBranch();
        // $data['getEntity'] = $this->getEntity();
        //  $data['getTasktype'] = $this->getTasktype();
        //  $data['CallStatus'] = $this->getCallStatus();
        //  $data['CallType'] = $this->getCallType();
        $data['Priority'] = $this->getPriority();
        //  $data['getSla'] = $this->getSla();
        // $data['productline'] = $this->productline();
        // $data['closeCode'] = $this->closeCodeModel();
        return $data;
    }
    
    public function entityid(){
        $task_type_id = $this->session->userdata('session_data')->task_type_id;
        $this->db->select('ent_id');
        $this->db->from(QM_TASK_TYPE);
        $this->db->where('id', $task_type_id);
        $query = $this->db->get();
         if ($query->num_rows() == 1) {
                $result = $query->row();
                return $result->ent_id;
            } else {
                return FALSE;
            }
    }
    

    public function insertTaskCust($data) {

        $insertdata = array();
        $insertdata['task_name'] = $data['task_name'];
        $insertdata['fse_id'] = $data['fse_id'];
        $insertdata['status_id'] = $data['status_id'];
        $insertdata['priority'] = $data['priority'];
        $insertdata['task_address'] = $data['task_address'];
        $insertdata['start_date'] = $data['start_date'];
        $insertdata['ent_id'] = $data['ent_id'];
        $insertdata['task_type_id'] = $this->session->userdata('session_data')->task_type_id;
        $insert_id = $this->InsertData(QM_TASK, $insertdata, TRUE);

        // echo $sql = $this->db->last_query();

        if ($insert_id) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function insertTaskExtraFields($data, $taskid) {
        unset($data['task_name']);
        unset($data['fse_id']);
        unset($data['status_id']);
        unset($data['priority']);
        unset($data['task_address']);
        unset($data['start_date']);
        unset($data['ent_id']);
        unset($data['task_location']);
        unset($data['submit']);
        unset($data['fse_id_h']);
        if (empty($data)) {
            return FALSE;
        }
        $insertdata = array();
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
            }
            $insertdata['Extra_attr_Def_id'] = $key;
            $insertdata['Task_id'] = $taskid;
            $insertdata['Extra_attr_Values'] = $value;
            $insertdata['task_type_id'] = $this->session->userdata('session_data')->task_type_id;
            $this->InsertData(QM_EXTRA_ATTR_VALUES, $insertdata, TRUE);
        }
    }

    public function insertTask($data) {
        //$data['mytext'] = $this->input->post('mytext');
        if (isset($data['optButtonradio'])) {
            if ($data['optButtonradio'] == 'BranchDiv') {
                $data['ent_id'] = $this->branchToEntity($data['branch_id']);
            }
        } else {
            $data['ent_id'] = $this->session->userdata('session_data')->ent_id;
        }
        $taskchecklist = '';
        if (isset($data['taskchecklist'])) {
            if (count($data['taskchecklist']) > 0) {
                $taskchecklist = json_encode($data['taskchecklist']);
            } else {
                $taskchecklist = '';
            }
        }
        $table = QM_TASK;
        unset($data['optradio']);
        unset($data['optButtonradio']);
        unset($data['taskchecklist']);
        unset($data['task_location']);
        unset($data['submit']);
        unset($data['fse_id_h']);
        unset($data['project_id_h']);
        unset($data['incident_id_h']);
        $data['task_checklist'] = $taskchecklist;
        $data['web_user_id'] = $this->session->userdata('session_data')->user_id;
        $insert_id = $this->InsertData($table, $data, TRUE);

        if ($insert_id) {
            return $this->db->insert_id();
        } else {
            return false;
        }
        //$session_data = $this->session->userdata('session_data');
        //$session_data->last_insert_id = $insert_id;
        //$sql = $this->db->last_query();
    }

    public function insertTaskLocation($data) {
        $table = QM_TASK_LOCATION;
        $this->db->delete($table, array('task_id' => $data['task_id']));
        $insert_id = $this->InsertData($table, $data);
        if ($insert_id) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function updateTaskLocation($task_id) {
        $this->db->select('*');
        $this->db->from(QM_TASK_LOCATION);
        $this->db->where('task_id', $task_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = array();
            foreach ($query->result() as $row) {
                $result['task_id'] = $row->task_id;
                $result['start_time'] = $row->start_time;
                $result['task_location'] = $row->task_location;
            }
            return $result;
        }
    }

    public function editTask($id, $data) {

        $table = QM_TASK;
        $this->db->set('updated_date', 'NOW()', FALSE);
        /* $sql = $this->db->last_query(); */

        return $this->UpdateData($data, $id, $table);
        /* $sql1 = $this->db->last_query(); */
    }

    public function updateExtAtturTask($data) {

        $table = QM_EXTRA_ATTR_VALUES;

        unset($data['task_id']);
        unset($data['task_name']);
        unset($data['fse_id_h']);
        unset($data['fse_id']);
        unset($data['status_id']);
        unset($data['priority']);
        unset($data['task_address']);
        unset($data['task_location']);
        unset($data['start_date']);
        unset($data['submit']);

        if (empty($data)) {
            return FALSE;
        }
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
            }
            $this->db->set('Extra_attr_Values', $value); //value that used to update column  
            $this->db->where('Extra_attr_value_id', $key); //which row want to upgrade  
            $this->db->update($table);
        }
        return TRUE;
        /* $sql1 = $this->db->last_query(); */
    }

    function checkTaskName($task_name) {
        $result = $this->db->get_where(QM_TASK, array(
                    'task_name' => $task_name
                ))->result_array();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function editTaskLocation($id, $task_location) {

        $this->db->set('task_location', $task_location); //value that used to update column  
        $this->db->where('task_id', $id); //which row want to upgrade  			 
        $query = $this->db->update(QM_TASK_LOCATION);  //
//      echo  $sql = $this->db->last_query();
//        
//        exit;
    }

    public function cancelTask($id, $data) {
        $table = QM_TASK;
        unset($data['optradio']);
        unset($data['optButtonradio']);
        unset($data['id']);
        unset($data['submit']);
        $sql = $this->db->last_query();

        return $this->UpdateData($data, $id, $table);
    }

    public function taskType() {
        $query = $this->db->select(QM_TASK_TYPE . '.id,' . QM_TASK_TYPE . '.task_type,' . QM_TASK_TYPE . '.task_type_description');
        $query = $this->db->from(QM_TASK_TYPE);
        $this->db->order_by(QM_TASK_TYPE . '.id', 'DESC');
        $query = $this->db->where(QM_TASK_TYPE . '.task_type_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function entityFeilds() {
        if ($this->session->userdata('session_data')->is_admin == 1) {
            $s = 0;
            $e = 40;
            $r = array();
            while ($s <= $e) {
                array_push($r, $s);
                $s++;
            }
            return json_encode($r);
        }
        $id = $this->session->userdata('session_data')->ent_id;
        $this->db->select(QM_ENTITY . '.task_field');
        $this->db->from(QM_ENTITY);
        $this->db->where(QM_ENTITY . '.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $res = $query->result_array();
            return$res[0]['task_field'];
        } else {
            return FALSE;
        }
    }

    public function taskType_add($data) {
        $table = QM_TASK_TYPE;
        unset($data['user_id']);
        unset($data['submit']);
        $check = $this->InsertData($table, $data);
        /* if ($check == 1) {
          redirect('asset');
          } */
    }

    public function taskType_update($id) {
        $table = QM_TASK_TYPE;
        return $this->SelectWhere($id, $table);
    }

    public function taskType_edit($id, $data) {
        $table = QM_TASK_TYPE;
        unset($data['id']);
        unset($data['submit']);
        return $this->UpdateData($data, $id, $table);
    }

    function checkTaskType($task_type) {
        $result = $this->db->get_where(QM_TASK_TYPE, array(
                    'task_type' => $task_type
                ))->result_array();
        if (count($result) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getFseDeviceType($id = NULL) {
        if ($id != NULL) {
            $table = QM_FSE_DETAILS;
            $this->db->select('fse_device_os');
            $this->db->from($table);
            $this->db->where(QM_FSE_DETAILS . '.id', $id);
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                $result = $query->row();
                return $result->fse_device_os;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function problemOneModel($value) {
        $this->db->select('value');
        $this->db->from(QM_PROBLEM_ONE);
        $this->db->where('dependent_value', $value);
        $this->db->order_by('value', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function actionCodeModel($value) {
        $this->db->select('value');
        $this->db->from(QM_ACTION_CODE);
        $this->db->where('dependent_value', $value);
        $this->db->order_by('value', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function sectionCodeModel($value) {
        $this->db->select('value');
        $this->db->from(QM_SECTION_CODE);
        $this->db->where('dependent_value', $value);
        $this->db->order_by('value', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function problemTwoModel($value) {
        $this->db->select('value');
        $this->db->from(QM_PROBLEM_TWO);
        $this->db->where('dependent_value', $value);
        $this->db->order_by('value', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function snLocationModel($value) {
        $this->db->select('value');
        $this->db->from(QM_SN_LOCATION);
        $this->db->where('dependent_value', $value);
        $this->db->order_by('value', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function locationCodeModel($value) {
        $this->db->select('value');
        $this->db->from(QM_LOCATION_CODE);
        $this->db->where('dependent_value', $value);
        $this->db->order_by('value', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function closeCodeModel() {
        $this->db->select('close_code');
        $this->db->from(QM_CLOSE_CODE);
        $this->db->order_by('close_code', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function taskCustFieldReport($taskID = NULL, $tasktypeid = NULL, $start_date = NULL, $end_date = NULL) {

        $this->db->select("*"
        );
        $this->db->from(QM_TASK);
        //$this->db->join(QM_FSE_DETAILS, QM_TASK . '.fse_id = ' . QM_FSE_DETAILS . '.id', 'LEFT');
        $this->db->join(QM_STATUS_TYPE, QM_TASK . '.status_id = ' . QM_STATUS_TYPE . '.id', 'LEFT');
        $this->db->join(QM_PRIORITY, QM_TASK . '.priority = ' . QM_PRIORITY . '.id', 'LEFT');
        $this->db->join(QM_TASK_TYPE, QM_TASK . '.task_type_id = ' . QM_TASK_TYPE . '.id', 'LEFT');
        $this->db->join(QM_TASK_LOCATION, QM_TASK . '.id = ' . QM_TASK_LOCATION . '.task_id', 'LEFT');
        $this->db->where(QM_TASK . '.task_status', 1);
        if ($taskID != NULL) {
           // $this->db->where(QM_TASK . '.id', $taskID);
        }
        if ($tasktypeid != NULL) {
           // $this->db->where(QM_TASK . '.task_type_id', $tasktypeid);
        }
        if ($start_date != NULL) {
           // $this->db->where(QM_TASK . '.created_date >= ', date('Y-m-d H:i:s', strtotime($start_date)));
        }
        if ($end_date != NULL) {
            //$this->db->where(QM_TASK . '.created_date <=', date('Y-m-d H:i:s', strtotime($end_date) + 86400));
        }
        $query = $this->db->get();
        $result = $query->result_array();

        echo $this->db->last_query();
        exit();

        $data = array();
        $a2 = $i = 0;

        if (!empty($result)) {
            foreach ($result as $value) {
              //  $a2 = $this->reportsextrafeildValue($value['id'], $value['task_type_id']);
                $data[$i] = array_merge($value, $a2);
                $i++;
            }
        }
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        exit();
        return $data;
    }

    public function reportsextrafeildValue($taskid = NULL, $tasktypeid = NULL) {

        if ($taskid == NULL) {
            return array();
        }

        $this->db->select(
                QM_EXTRA_ATTR_DEFINITION . '.	Ext_att_name,'
                . QM_EXTRA_ATTR_DEFINITION . '.	Ext_att_type,'
                . QM_EXTRA_ATTR_DEFINITION . '.	Ext_att_size,'
                . QM_EXTRA_ATTR_DEFINITION . '.	extr_att_id,'
                . QM_EXTRA_ATTR_DEFINITION . '.	extra_attr_option,'
                . QM_EXTRA_ATTR_DEFINITION . '.	Task_type_ID'
        );
        $this->db->from(QM_EXTRA_ATTR_DEFINITION);
        $this->db->where(QM_EXTRA_ATTR_DEFINITION . '.Task_type_ID', $tasktypeid);
        $query = $this->db->get();

        $result = $query->result_array();


        $cutFieldsKeyValue = array();

        if (!empty($result)) {
            $i = 0;
            foreach ($result as $value) {
                $cutFieldsKeyValue[$value['Ext_att_name']] = $this->reportsgetatrvalueid($taskid, $value['extr_att_id'], $tasktypeid);
            }
        }

        $customFields = array();
        $customFields['customFields'] = $cutFieldsKeyValue;
        return $customFields;
    }

    public function reportsgetatrvalueid($taskid = NULL, $attrid = NULL, $tasktypeid = NULL) {
        $this->db->select(
                QM_EXTRA_ATTR_VALUES . '.	Extra_attr_Values,'
        );
        $this->db->from(QM_EXTRA_ATTR_VALUES);
        $this->db->where(QM_EXTRA_ATTR_VALUES . '.Extra_attr_Def_id', $attrid);
        $this->db->where(QM_EXTRA_ATTR_VALUES . '.Task_id', $taskid);
        $this->db->where(QM_EXTRA_ATTR_VALUES . '.task_type_id', $tasktypeid);
        $this->db->limit('1');
        $query = $this->db->get();
        // echo $this->db->last_query();
        $r = array();
        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0]['Extra_attr_Values'];
        } else {
            $datas = array();
            $datas['Extra_attr_Def_id'] = $attrid;
            $datas['Task_id'] = $taskid;
            $datas['task_type_id'] = $tasktypeid;
            $this->db->insert(QM_EXTRA_ATTR_VALUES, $datas);
            $r['Extra_attr_Values'] = "";
            return $r;
        }
    }

    public function extrafeildValueKey($taskid = NULL) {

        if ($taskid == NULL) {
            return array();
        }

        $this->db->select(
                QM_EXTRA_ATTR_VALUES . '.Extra_attr_Values,'
                . QM_EXTRA_ATTR_DEFINITION . '.	Ext_att_name,'
                . QM_EXTRA_ATTR_DEFINITION . '.	Task_type_ID'
        );
        $this->db->from(QM_EXTRA_ATTR_VALUES);
        $this->db->join(QM_EXTRA_ATTR_DEFINITION, QM_EXTRA_ATTR_VALUES . '.Extra_attr_Def_id = ' . QM_EXTRA_ATTR_DEFINITION . '.extr_att_id');
        $this->db->where(QM_EXTRA_ATTR_VALUES . '.Task_id', $taskid);
        $query = $this->db->get();
        $result = $query->result_array();
        $cutFieldsKeyValue = array();
        if (!empty($result)) {
            foreach ($result as $value) {
                $cutFieldsKeyValue[$value['Ext_att_name']] = $value['Extra_attr_Values'];
                $cutFieldsKeyValue['Task_type_ID'] = $value['Task_type_ID'];
            }
        }

        $customFields = array();
        $customFields['customFields'] = $cutFieldsKeyValue;

        return $customFields;
    }

    public function taskCustFieldupdate($taskID = NULL, $tasktypeid = NULL, $start_date = NULL, $end_date = NULL) {


        $this->db->select(QM_TASK . '.task_name,'
                . QM_TASK . '.task_address,'
                . QM_TASK . '.start_date,'
                . QM_TASK . '.id,'
                . QM_TASK . '.fse_checklist,'
                . QM_TASK . '.fse_task_comments,'
                . QM_TASK . '.fse_reason,'
                . QM_TASK . '.fse_feedback,'
                . QM_TASK . '.task_type_id,'
                . QM_TASK . '.fse_id,'
                . QM_TASK . '.ent_id,'
                . QM_TASK . '.status_id,'
                . QM_TASK_LOCATION . '.task_location,'
                . QM_TASK_LOCATION . '.start_time,'
                . QM_TASK_LOCATION . '.reached_time,'
                . QM_TASK_LOCATION . '.total_travel_time,'
                . QM_TASK_LOCATION . '.start_to_work_time,'
                . QM_TASK_LOCATION . '.Work_completed_time,'
                . QM_TASK_LOCATION . '.total_worked_time,'
                . QM_TASK_LOCATION . '.geo_km,'
                . QM_TASK . '.created_date,'
                . QM_FSE_DETAILS . '.fse_name,'
                . QM_STATUS_TYPE . '.status_type,'
                . QM_PRIORITY . '.priority_type'
        );
        $this->db->from(QM_TASK);
        $this->db->join(QM_FSE_DETAILS, QM_TASK . '.fse_id = ' . QM_FSE_DETAILS . '.id', 'LEFT');
        $this->db->join(QM_STATUS_TYPE, QM_TASK . '.status_id = ' . QM_STATUS_TYPE . '.id', 'LEFT');
        $this->db->join(QM_PRIORITY, QM_TASK . '.priority = ' . QM_PRIORITY . '.id', 'LEFT');
        $this->db->join(QM_TASK_LOCATION, QM_TASK . '.id = ' . QM_TASK_LOCATION . '.task_id', 'LEFT');
        $this->db->where(QM_TASK . '.task_status', 1);
        if ($taskID != NULL) {
            $this->db->where(QM_TASK . '.id', $taskID);
        }
        if ($tasktypeid != NULL) {
            $this->db->where(QM_TASK . '.task_type_id', $tasktypeid);
        }
        if ($start_date != NULL) {
            $this->db->where(QM_TASK . '.start_date>=', date('Y-m-d H:i:s', strtotime($start_date)));
        }
        if ($end_date != NULL) {
            $this->db->where(QM_TASK . '.start_date<=', date('Y-m-d H:i:s', strtotime($end_date)));
        }
        $query = $this->db->get();
        $result = $query->result_array();

//        echo $this->db->last_query();
//        exit();

        $data = array();
        $i = 0;

        if (!empty($result)) {
            foreach ($result as $value) {
                $a2 = $this->updateextrafeildValue($value['id'], $value['task_type_id']);
                // $a2 = $this->extrafeildValueKeyupdate($value['id']); 
                $data[$i] = array_merge($value, $a2);
                $i++;
            }
        }

        return $data;
    }

    public function updateextrafeildValue($taskid = NULL, $tasktypeid = NULL) {

        if ($taskid == NULL) {
            return array();
        }

        $this->db->select(
                QM_EXTRA_ATTR_DEFINITION . '.	Ext_att_name,'
                . QM_EXTRA_ATTR_DEFINITION . '.	Ext_att_type,'
                . QM_EXTRA_ATTR_DEFINITION . '.	Ext_att_size,'
                . QM_EXTRA_ATTR_DEFINITION . '.	extr_att_id,'
                . QM_EXTRA_ATTR_DEFINITION . '.	extra_attr_option,'
                . QM_EXTRA_ATTR_DEFINITION . '.	Task_type_ID'
        );
        $this->db->from(QM_EXTRA_ATTR_DEFINITION);
        $this->db->where(QM_EXTRA_ATTR_DEFINITION . '.Task_type_ID', $tasktypeid);
        $query = $this->db->get();

        $result = $query->result_array();


        $cutFieldsKeyValue = array();

        if (!empty($result)) {
            $i = 0;
            foreach ($result as $value) {
                $cutFieldsKeyValue[$i]['value'] = $this->getatrvalueid($taskid, $value['extr_att_id'], $tasktypeid);
                $cutFieldsKeyValue[$i]['att_field_id'] = $value['extr_att_id'];
                $cutFieldsKeyValue[$i]['type'] = $value['Ext_att_type'];
                $cutFieldsKeyValue[$i]['size'] = $value['Ext_att_size'];
                $cutFieldsKeyValue[$i]['attname'] = $value['Ext_att_name'];
                $cutFieldsKeyValue[$i]['option'] = $value['extra_attr_option'];
                $i++;
            }
        }

        $customFields = array();
        $customFields['customFields'] = $cutFieldsKeyValue;
        return $customFields;
    }

    public function getatrvalueid($taskid = NULL, $attrid = NULL, $tasktypeid = NULL) {
        $this->db->select(
                QM_EXTRA_ATTR_VALUES . '.	Extra_attr_value_id,'
                . QM_EXTRA_ATTR_VALUES . '.	Extra_attr_Values'
        );
        $this->db->from(QM_EXTRA_ATTR_VALUES);
        $this->db->where(QM_EXTRA_ATTR_VALUES . '.Extra_attr_Def_id', $attrid);
        $this->db->where(QM_EXTRA_ATTR_VALUES . '.Task_id', $taskid);
        $this->db->where(QM_EXTRA_ATTR_VALUES . '.task_type_id', $tasktypeid);
        $this->db->limit('1');
        $query = $this->db->get();
        // echo $this->db->last_query();
        $r = array();
        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0];
        } else {
            $datas = array();
            $datas['Extra_attr_Def_id'] = $attrid;
            $datas['Task_id'] = $taskid;
            $datas['task_type_id'] = $tasktypeid;
            $this->db->insert(QM_EXTRA_ATTR_VALUES, $datas);
            $r['Extra_attr_value_id'] = $this->db->insert_id();
            $r['Extra_attr_Values'] = '';
            return $r;
        }
    }

    public function extrafeildValueKeyupdate($taskid = NULL) {

        if ($taskid == NULL) {
            return array();
        }

        $this->db->select(
                QM_EXTRA_ATTR_VALUES . '.Extra_attr_Values,'
                . QM_EXTRA_ATTR_VALUES . '.Extra_attr_value_id,'
                . QM_EXTRA_ATTR_DEFINITION . '.	Ext_att_name,'
                . QM_EXTRA_ATTR_DEFINITION . '.	Ext_att_type,'
                . QM_EXTRA_ATTR_DEFINITION . '.	Ext_att_size,'
                . QM_EXTRA_ATTR_DEFINITION . '.	Task_type_ID'
        );
        $this->db->from(QM_EXTRA_ATTR_VALUES);
        $this->db->join(QM_EXTRA_ATTR_DEFINITION, QM_EXTRA_ATTR_VALUES . '.Extra_attr_Def_id = ' . QM_EXTRA_ATTR_DEFINITION . '.extr_att_id', 'LEFT');
        $this->db->where(QM_EXTRA_ATTR_VALUES . '.Task_id', $taskid);
        $query = $this->db->get();
        $result = $query->result_array();
        $cutFieldsKeyValue = array();

        if (!empty($result)) {
            foreach ($result as $value) {
                $cutFieldsKeyValue[$value['Ext_att_name']]['value'] = $value['Extra_attr_Values'];
                $cutFieldsKeyValue[$value['Ext_att_name']]['id'] = $value['Extra_attr_value_id'];
                $cutFieldsKeyValue[$value['Ext_att_name']]['type'] = $value['Ext_att_type'];
                $cutFieldsKeyValue[$value['Ext_att_name']]['size'] = $value['Ext_att_size'];
                //$cutFieldsKeyValue['Task_type_ID'] = $value['Task_type_ID'];
            }
        }

        $customFields = array();
        $customFields['customFields'] = $cutFieldsKeyValue;
        return $customFields;
    }

}
