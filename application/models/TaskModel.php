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
                . QM_TASK_LOCATION . '.total_travel_time,'
                . QM_TASK_LOCATION.'.total_worked_time,'
                . QM_TASK_LOCATION . '.Work_completed_time,'
                . QM_TASK_LOCATION . '.reached_time,'
                . QM_TASK_LOCATION . '.updated_date,'
                //         . QM_PROJECT . '.proj_name,'
                //  . QM_INCIDENT . '.incident_name'
        );
        $this->db->from(QM_TASK);
        $this->db->join(QM_FSE_DETAILS, QM_TASK . '.fse_id = ' . QM_FSE_DETAILS . '.id', 'LEFT');
        $this->db->join(QM_TASK_LOCATION, QM_TASK . '.id = ' . QM_TASK_LOCATION . '.task_id', 'LEFT');
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
        if (empty($result)) {
            return TRUE;
        }
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
                $data[] = array_merge($cat_array, $cat);
            }
        }

        $datas['update_arr'] = $data;

        return array_merge($result[0], $datas);
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
                $value[$i]['value'] = $this->taskUpdateViewfieldMapingValue($task_id, $cat_id, $task_type_id, $r['update_field_id']);
                $value[$i]['label'] = $r['label'];
                $value[$i]['update_field_id'] = $r['update_field_id'];
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

    public function checkReportFlag($task_type) {
        $this->db->select(QM_TASK_TYPE . '.report_flag');
        $this->db->from(QM_TASK_TYPE);
        $this->db->where(QM_TASK_TYPE . '.id', $task_type);
        $query = $this->db->get();
        //  echo $this->db->last_query();
        $obj = $query->result_array();
        return $obj[0]['report_flag'];
    }

    public function getReportFields($task_type) {
        $this->db->select(QM_TASK_REPORT . '.*');
        $this->db->from(QM_TASK_REPORT);
        $this->db->where(QM_TASK_REPORT . '.task_type_id', $task_type);
        $this->db->where(QM_TASK_REPORT . '.task_id', 0);

        $query = $this->db->get();
        //echo $this->db->last_query();        exit(); 
        $obj = $query->result_array();
        return $obj;
    }

    public function taskUpdateViewfieldMapingValue($task_id = NULL, $cat_id = NULL, $task_type_id = NULL, $id_value) {

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

    public function entityid() {
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
        $insertdata['assign_date'] = date('Y-m-d H:i:s');
        $insertdata['ent_id'] = $data['ent_id'];
        $insertdata['auto_route_flag'] = $data['auto_route_flag'];
        $insertdata['report_flag'] = $data['report_flag'];
        $insertdata['task_type_id'] = $this->session->userdata('session_data')->task_type_id;
        $insert_id = $this->InsertData(QM_TASK, $insertdata, TRUE);

//         echo $sql = $this->db->last_query();
//exit;
        if ($insert_id) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function insertTaskReportFields($dataTaskReportFields) {
        $insert_id = $this->InsertData(QM_TASK_REPORT, $dataTaskReportFields, TRUE);

        //  echo $sql = $this->db->last_query();die;

        if ($insert_id) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

//$ins_data, $taskID,$retrundata,$this->input->post()
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
        $numeric_element = array();
        if (empty($data)) {
            return FALSE;
        }
        $insertdata = array();
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
            }
            if (is_int($key)) {
                $numeric_element = $value;
                if (!empty($numeric_element)) {
                    $insertdata['Extra_attr_Def_id'] = $key;
                    $insertdata['Task_id'] = $taskid;
//OLD CODE LINE		    
//                    $insertdata['Extra_attr_Values'] = $value;
//====================================================================		    
//NEW CODE LINE			    
                    $insertdata['Extra_attr_Values'] = $numeric_element;
//====================================================================
                    $insertdata['task_type_id'] = $this->session->userdata('session_data')->task_type_id;
                    $this->InsertData(QM_EXTRA_ATTR_VALUES, $insertdata, TRUE);
                }
            }
        }
    }

//insertTaskEmailReportFields($ins_data, $taskID,$dataTaskReportFields,$retrundata)
    public function insertTaskEmailReportFields($data, $taskid, $retrundata) {
        $id = '';
        $insertdata = array();
        $numeric_element = array();
        $table = QM_TASK_REPORT_EMAILS;
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
            }

            if (ctype_digit($key)) {
                $numeric_element = $value;
//                    echo "The string $numeric_element consists of all digits.\n";


                if (!empty($numeric_element)) {

//            
//                                        $insertdata['task_id']=$taskid;
//                                        $insertdata['task_type_id']=$this->session->userdata('session_data')->task_type_id;
//                                        $insertdata['ent_id']=$retrundata['ent_id'];
//                                        $insertdata['task_report_id']=$retrundata['reportid'];
//                                        $insertdata['email']=$numeric_element;
//                                        $insertdata['emialfield']=$key;
//                                        $insertdata['createdat']=date('Y-m-d');
//                                        $insertdata['createdby']='';
//                                        $insertdata['modifiedat']='';
//                                        $insertdata['modifiedby']='';
//            $this->InsertData('QM_TASK_REPORT_EMAILS', $insertdata, TRUE);

                    $SqlSelectEmailField = $this->db->select(QM_TASK_REPORT_EMAILS . '.id')
                            ->from(QM_TASK_REPORT_EMAILS)
                            ->where(QM_TASK_REPORT_EMAILS . '.emialfield', $key)
                            ->where(QM_TASK_REPORT_EMAILS . '.task_type_id', $this->session->userdata('session_data')->task_type_id)
                            ->get();

//                            $query = $this->db->select(QM_TASK_REPORT_EMAILS . '.id');
//                            $query = $this->db->from(QM_TASK_REPORT_EMAILS);
//                            $query = $this->db->where(QM_TASK_REPORT_EMAILS . '.emialfield', $key);
//                            $query = $this->db->where(QM_TASK_REPORT_EMAILS . '.emialfield', $key);
//                            $query = $this->db->get();
                    foreach ($SqlSelectEmailField->result_array() as $row) {
                        $id = $row['id'];
                    }
                    if ($id) {
                        $reportupdateData = array('task_id' => $taskid,
                            'task_type_id' => $this->session->userdata('session_data')->task_type_id,
                            'email' => $numeric_element,
                            'emialfield' => $key,
                            'modifiedat' => date('Y-m-d')
                        );
                        return $this->UpdateData($reportupdateData, $id, $table);
                    }
                }
            }
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

    public function editTask($id, $data,$oldstatus_id) {

        $table = QM_TASK;
      /*  $QuerySql=$this->db->select(QM_TASK.'.status_id')
                           ->from(QM_TASK) 
                           ->where(QM_TASK.'id',$task_id)
                           ->get();
                $QuerySqlRes=$QuerySql->result_array();*/
         if($oldstatus_id != $data['status_id'] && $data['status_id'] ==1)
        {
            $data['fse_task_comments']='';
            $data['fseRating']='';
            $data['customer_sign']='';
            // $data['start_date']='';
            // $data['servicenow_api_request']='';
            $data['customer_sign_upload']=0;
            $data['kilometer_travelled']='';
        } 
//        echo "<pre>"
//        print_r($data);
//        exit;
        $this->db->set('updated_date', 'NOW()', FALSE);
        // echo "<pre>";
        // print_r($data);exit;
         // echo $sql = $this->db->last_query(); exit;

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
// Start ============================ update qm_task_report_emails tables ====================================== 
            $emailreportSql = $this->db->select(QM_TASK_REPORT_EMAILS . '.id,' . $table . '.Extra_attr_Def_id')
                    ->from($table)
                    ->join(QM_TASK_REPORT_EMAILS, QM_TASK_REPORT_EMAILS . '.emialfield=' . $table . '.Extra_attr_Def_id')
                    ->where($table . '.Extra_attr_value_id', $key)
                    ->get();

            $emailid = '';
            if ($emailreportSql->num_rows() > 0) {

                foreach ($emailreportSql->result() as $row) {
                    echo $emailid = $row->id;
                }

                $this->db->set('email', $value); //value that used to update column  
                $this->db->where('id', $emailid); //which row want to upgrade  
                $this->db->update(QM_TASK_REPORT_EMAILS);
            }
        }
//        exit;
// End ============================ update qm_task_report_emails tables ====================================== 
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

    public function editTaskLocation($id, $task_location,$data,$oldstatus_id) {
        $table=QM_TASK_LOCATION;

    if($oldstatus_id != $data['status_id'] && $data['status_id'] ==1)
        {
            $this->db->where('task_id', $id); 
                     $dbdata = array('task_id' => $id,
                                'geo_km' => '',
                                'start_time' => '0000-00-00 00:00:00',
                                'reached_time' => '0000-00-00 00:00:00',
                                'end_trip_check' => 0,                                
                                'total_travel_time'=>'',
                                'start_to_work_time'=>'0000-00-00 00:00:00',                                
                                'Work_completed_time'=>'0000-00-00 00:00:00',
                                'total_worked_time'=>'',
                                'task_location'=>$task_location
                     ); 
                 $this->db->update($table, $dbdata);
        }else {         

        $this->db->set('task_location', $task_location); //value that used to update column  
        $this->db->where('task_id', $id); //which row want to upgrade  			 
        $query = $this->db->update(QM_TASK_LOCATION);  //
//      echo  $sql = $this->db->last_query();
     }  
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
        $this->db->limit(10);
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
//        task_type_id
        /*        $tasktypQuery=$this->db->select('qm_task_type.*,`qm_entity`.`user_id`,
          `qm_entity`.`entity_logo`,
          `qm_entity`.`entity_color`,
          `qm_entity`.`flow`')
          ->from($table)
          ->join('qm_entity','qm_entity.id=qm_task_type.ent_id','left')
          ->where('qm_task_type.id',$id)
         */
        $tasktypQuery = $this->db->select(QM_TASK_TYPE . '.*,'
                        . QM_ENTITY . '.user_id,'
                        . QM_ENTITY . '.entity_logo,'
                        . QM_ENTITY . '.entity_color,'
                        . QM_ENTITY . '.flow')
                ->from($table)
                ->join(QM_ENTITY, QM_ENTITY . '.id=' . QM_TASK_TYPE . '.ent_id', 'left')
                ->where(QM_TASK_TYPE . '.id', $id)
                ->get();
        return $tasktypQueryRes = $tasktypQuery->result_array();
//        return $this->SelectWhere($id, $table);
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

    public function getEngineer($string, $taskLocation) {
        $LogginUserid = $this->session->userdata('session_data')->user_id;
        $locdata = explode(',', str_replace(array('(', ')'), '', $taskLocation));
        if ($locdata[0]) {
            $latitude = $locdata[0];
//            echo "<br> ";
            $longitude = $locdata[1];
        }

        $CheckUserType = $this->db->select(QM_WEB_ACCESS . '.id as `qm_web_access_id`,' . QM_WEB_USER_TYPE . '.web_user_type')
                ->from(QM_WEB_ACCESS)
                ->join(QM_WEB_USER_TYPE, QM_WEB_ACCESS . '.user_type=' . QM_WEB_USER_TYPE . '.id', 'INNER')
                ->where(QM_WEB_ACCESS . '.id', $LogginUserid)
                ->get();
//                    echo $this->db->last_query(); exit;

        $Result_CheckUserType = $CheckUserType->result_array();


        if ($Result_CheckUserType[0]['web_user_type'] == 'Administrator' || $Result_CheckUserType[0]['web_user_type'] == 'administrator') {
            $query = "SELECT (
                          3959 * acos (
                            cos ( radians(" . $latitude . ") )
                            * cos( radians(qm_fse_location.fse_lat) )
                            * cos( radians( qm_fse_location.fse_long ) - radians(" . $longitude . ") )
                            + sin ( radians(" . $latitude . ") )
                            * sin( radians( qm_fse_location.fse_lat ) )
                          )
                        ) AS distance,qm_fse_location.fse_id
                                             FROM qm_fse_details
                                             left join qm_fse_location on qm_fse_location.fse_id=qm_fse_details.id
                                             left join qm_web_access on qm_web_access.ent_id=qm_fse_details.ent_id
                                             left join qm_task ON qm_task.fse_id = qm_fse_location.fse_id
                                            where qm_fse_details.duty_mode=1 AND qm_task.status_id 
                      Not IN (5, 6, 7)            
                      AND (DATE_ADD(NOW(), INTERVAL 2 HOUR) > qm_task.assign_date)   
                      HAVING distance < 30
                      order by distance
                      LIMIT 0 , 1";
        } else {

            if ($string != '')
                $query_part = "AND `qm_fse_location`.`fse_type_id` IN(" . $string . ") ";
            else
                $query_part = '';
            $query = "select (
                          3959 * acos (
                            cos ( radians(" . $lat . ") )
                            * cos( radians(qm_fse_location.fse_lat) )
                            * cos( radians( qm_fse_location.fse_long ) - radians(" . $long . ") )
                            + sin ( radians(" . $lat . ") )
                            * sin( radians( qm_fse_location.fse_lat ) )
                          )
                        ) AS distance,
IF((select count(qm_task.status_id) from qm_task where qm_task.fse_id=qm_fse_location.fse_id and qm_task.status_id=5 ) <= 0,qm_fse_location.fse_id,'') as 'fse_id'
 from qm_web_access
inner join qm_fse_details on qm_fse_details.user_id=qm_web_access.id
inner join qm_fse_location on qm_fse_location.fse_id=qm_fse_details.id
inner join qm_task on qm_task.ent_id=qm_fse_details.ent_id
<<<<<<< HEAD
where qm_web_access.id=" . $LogginUserid . " and qm_task.status_id 
=======
where qm_fse_details.duty_mode=1 AND qm_web_access.id=".$LogginUserid." and qm_task.status_id 
>>>>>>> af136318e03d336a323b6f7a2356ce5ae401b9bc
                      Not IN (5, 6, 7)            
                      AND (DATE_ADD(NOW(), INTERVAL 2 HOUR) > qm_task.assign_date)   
                      HAVING distance < 30
                      order by distance
                      LIMIT 0 , 1;";
        }
        $res = $this->db->query($query);
        $obj = $res->result_array();
        if (isset($obj)) {
            $result = $obj[0]['fse_id'];
        }

        return $obj;
    }

    public function gettonearfseEngineer($lat, $long,$ent_id) {
        $LogginUserid = $this->session->userdata('session_data')->user_id;
        $CheckUserType = $this->db->select(QM_WEB_ACCESS . '.id as `qm_web_access_id`,' . QM_WEB_USER_TYPE . '.web_user_type')
                ->from(QM_WEB_ACCESS)
                ->join(QM_WEB_USER_TYPE, QM_WEB_ACCESS . '.user_type=' . QM_WEB_USER_TYPE . '.id', 'INNER')
                ->where(QM_WEB_ACCESS . '.id', $LogginUserid)
                ->get();
//                    echo $this->db->last_query(); exit;

        $Result_CheckUserType = $CheckUserType->result_array();


        if ($Result_CheckUserType[0]['web_user_type'] == 'Administrator' || $Result_CheckUserType[0]['web_user_type'] == 'administrator') {
            $query="SELECT (
 
                          3959 * acos (
                            cos ( radians(" . $lat . ") )
                            * cos( radians(qm_fse_location.fse_lat) )
                            * cos( radians( qm_fse_location.fse_long ) - radians(" . $long . ") )
                            + sin ( radians(" . $lat . ") )
                            * sin( radians( qm_fse_location.fse_lat ) )
                          )
                        ) AS distance,qm_fse_location.fse_id FROM qm_fse_details
                        inner join qm_web_access ON qm_web_access.id= qm_fse_details.user_id
                        left join qm_task on qm_task.fse_id=qm_fse_details.id and qm_task.status_id not in (5) and (DATE_ADD(NOW(), INTERVAL 2 HOUR) > qm_task.assign_date)
                        left JOIN qm_fse_location ON qm_fse_details.id = qm_fse_location.fse_id
                        where qm_fse_details.duty_mode=1   
                      GROUP BY qm_fse_location.fse_id
                      HAVING distance < 30
                      order by distance
                      LIMIT 0 , 1";
        } else {

            $query="SELECT qm_fse_location.fse_id, (
                                3959 * acos (
                                  cos ( radians(" . $lat . ") )
                                  * cos( radians(qm_fse_location.fse_lat) )
                                  * cos( radians( qm_fse_location.fse_long ) - radians(" . $long . ") )
                                  + sin ( radians(" . $lat . ") )
                                  * sin( radians( qm_fse_location.fse_lat ) )
                                )
                              ) AS distance
                                 FROM qm_fse_details
                                inner join qm_web_access ON qm_web_access.id= qm_fse_details.user_id
                                left join qm_task on qm_task.fse_id=qm_fse_details.id and qm_task.status_id not in (5) and (DATE_ADD(NOW(), INTERVAL 2 HOUR) > qm_task.assign_date)
                                left JOIN qm_fse_location ON qm_fse_details.id = qm_fse_location.fse_id
                                where qm_web_access.id=".$LogginUserid." and qm_fse_details.duty_mode=1 
                                GROUP BY qm_fse_location.fse_id
                              HAVING distance < 30 
                              ORDER BY distance               
                              LIMIT 0 , 1";
        }
               
        $res = $this->db->query($query);
//        echo $this->db->last_query(); exit;
        $obj = $res->result_array();
        if (isset($obj)) {
            $result = $obj[0]['fse_id'];
        }

        return $obj;
    }

    public function CheckAutoFseAvailable_Model() {
        $LogginUserid = $this->session->userdata('session_data')->user_id;
//                print_r($this->session->userdata('session_data')); exit;
        $CheckUserType = $this->db->select(QM_WEB_ACCESS . '.id as `qm_web_access_id`,' . QM_WEB_USER_TYPE . '.web_user_type')
                ->from(QM_WEB_ACCESS)
                ->join(QM_WEB_USER_TYPE, QM_WEB_ACCESS . '.user_type=' . QM_WEB_USER_TYPE . '.id', 'INNER')
                ->where(QM_WEB_ACCESS . '.id', $LogginUserid)
                ->get();


        $Result_CheckUserType = $CheckUserType->result_array();


        if ($Result_CheckUserType[0]['web_user_type'] == 'Administrator' || $Result_CheckUserType[0]['web_user_type'] == 'administrator') {
            $Fse_query = "SELECT qm_fse_details.id,qm_fse_details.fse_name,qm_fse_details.ent_id,
                                            qm_fse_location.fse_id,qm_task.assign_date
                                             FROM qm_fse_details
                                             left join qm_fse_location on qm_fse_location.fse_id=qm_fse_details.id
                                             left join qm_web_access on qm_web_access.ent_id=qm_fse_details.ent_id
                                             left join qm_task ON qm_task.fse_id = qm_fse_location.fse_id
                                            where qm_fse_details.duty_mode=1 AND qm_task.status_id 
                      Not IN (5, 6, 7)            
                      AND (DATE_ADD(NOW(), INTERVAL 2 HOUR) > qm_task.assign_date) LIMIT 0 , 1";
        } else {
            $Fse_query = "SELECT qm_fse_details.id,qm_fse_details.fse_name,qm_fse_details.ent_id,
                                            qm_fse_location.fse_id,qm_task.assign_date
                                             FROM qm_fse_details
                                             left join qm_fse_location on qm_fse_location.fse_id=qm_fse_details.id
                                             left join qm_web_access on qm_web_access.ent_id=qm_fse_details.ent_id
                                             left join qm_task ON qm_task.fse_id = qm_fse_location.fse_id
//<<<<<<< HEAD
                                            where qm_web_access.id=" . $LogginUserid . " ";
        }
        $res_Fse_query = $this->db->query($Fse_query);
        $obj = $res_Fse_query->result();

        return $obj;
/*** last confilct code []=======
                                            where qm_fse_details.duty_mode=1 AND qm_web_access.id=".$LogginUserid." ";
                    }
                    $res_Fse_query = $this->db->query($Fse_query);
                    $obj = $res_Fse_query->result();
                    
                    return $obj;
>>>>>>> af136318e03d336a323b6f7a2356ce5ae401b9bc
*/
//             return $result=1;
    }

    public function getEngineerType($task_type, $taskLocation) {
        $this->db->select(QM_ENTITY_FSE_TYPE . '.fse_type_id');
        $this->db->from(QM_ENTITY_FSE_TYPE);
        $this->db->where(QM_ENTITY_FSE_TYPE . '.task_type', $task_type);
        $query = $this->db->get();
        $obj = $query->result_array();
        $array = array();
        foreach ($obj as $data) {
            $array[] = $data['fse_type_id'];
        }
        $array = array_unique($array);

        $string = implode(',', $array);

        $res = $this->getEngineer($string, $taskLocation);
        return $res;
    }

    public function getAutoFse($task_type, $taskLocation) {
        $result = $this->getEngineerType($task_type, $taskLocation);
        if (isset($result)) {
            $result = $result[0]['fse_id'];
        }
        return $result;
    }

    public function getFse_autocomplete($searchTerm) {
        //->where(QM_WEB_ACCESS .'.duty_mode',1)
        $where = "duty_mode='1' and fse_name like '%" . $searchTerm . "%'";
        $Like_where = '%" . $searchTerm . "%';
//<<<<<<< HEAD
        $LogginUserid = $this->session->userdata('session_data')->user_id;

        $CheckUserType = $this->db->select(QM_WEB_ACCESS . '.id as `qm_web_access_id`,' . QM_WEB_USER_TYPE . '.web_user_type')
                ->from(QM_FSE_DETAILS)
                ->join(QM_WEB_ACCESS, QM_FSE_DETAILS . '.ent_id=' . QM_WEB_ACCESS . '.ent_id')
                ->join(QM_WEB_USER_TYPE, QM_WEB_ACCESS . '.user_type=' . QM_WEB_USER_TYPE . '.id')
                ->where(QM_WEB_ACCESS . '.id', $LogginUserid)                
                ->get();
/** last conflicted code =======
        
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
        
            $query = $this->db->query("SELECT id,fse_name FROM " . QM_FSE_DETAILS . " WHERE " . $where ."AND duty_mode=1");                       
        }
        else
        {
/*            $query=$this->db->select(QM_FSE_DETAILS.'.id,'.QM_FSE_DETAILS.'.ent_id,'.QM_FSE_DETAILS.'.fse_name')
                         ->from(QM_FSE_DETAILS)
                         ->join(QM_WEB_ACCESS,QM_FSE_DETAILS.'.ent_id='.QM_WEB_ACCESS.'.ent_id')                        
                         ->where(QM_WEB_ACCESS.'.id',$LogginUserid)
                         ->like(QM_FSE_DETAILS.'.fse_name',$Like_where)                    
                         ->get();
 */ /*           
            $query=$this->db->query("SELECT ".QM_FSE_DETAILS.".ent_id,".QM_FSE_DETAILS.".id,".QM_FSE_DETAILS.".fse_name FROM ".QM_FSE_DETAILS."
                                    left join ".QM_WEB_ACCESS." on ".QM_WEB_ACCESS.".ent_id=".QM_FSE_DETAILS.".ent_id
                                    where ".QM_FSE_DETAILS."duty_mode=1 AND".QM_WEB_ACCESS.".id=".$LogginUserid." and ".$where);
>>>>>>> af136318e03d336a323b6f7a2356ce5ae401b9bc
            
            
*/        

        $Result_CheckUserType = $CheckUserType->result_array();

        if ($Result_CheckUserType[0]['web_user_type'] == 'Administrator' || $Result_CheckUserType[0]['web_user_type'] == 'administrator') {

            $query = $this->db->query("SELECT id,fse_name FROM " . QM_FSE_DETAILS . " WHERE " . $where);
        } else {
            /*            $query=$this->db->select(QM_FSE_DETAILS.'.id,'.QM_FSE_DETAILS.'.ent_id,'.QM_FSE_DETAILS.'.fse_name')
              ->from(QM_FSE_DETAILS)
              ->join(QM_WEB_ACCESS,QM_FSE_DETAILS.'.ent_id='.QM_WEB_ACCESS.'.ent_id')
              ->where(QM_WEB_ACCESS.'.id',$LogginUserid)
              ->like(QM_FSE_DETAILS.'.fse_name',$Like_where)
              ->get();
             */
            $query = $this->db->query("SELECT " . QM_FSE_DETAILS . ".ent_id," . QM_FSE_DETAILS . ".id," . QM_FSE_DETAILS . ".fse_name FROM " . QM_FSE_DETAILS . "
                                    left join " . QM_WEB_ACCESS . " on " . QM_WEB_ACCESS . ".ent_id=" . QM_FSE_DETAILS . ".ent_id
                                    where " . QM_WEB_ACCESS . ".id=" . $LogginUserid . " and " . $where);
        }
        foreach ($query->result_array() as $k => $row) {
            $row_set[$k]['label'] = htmlentities(stripslashes($row['fse_name']));
            $row_set[$k]['key'] = htmlentities(stripslashes($row['id']));
        }
        echo json_encode($row_set);
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
        $user_type_data = '';
        $LogginUserid = $this->session->userdata('session_data')->user_id;
        $user_type_data = $this->check_user_type($LogginUserid);

        $this->db->select(QM_TASK . '.task_name,'
                . QM_TASK . '.task_address,'
                . QM_TASK . '.start_date,'
                . QM_TASK . '.id,'
                . QM_TASK . '.fse_checklist,'
                . QM_TASK . '.fse_task_comments,'
                . QM_TASK . '.fse_reason,'
                . QM_TASK . '.fse_feedback,'
//   . QM_TASK . '.customer_sign,'
                . QM_TASK . '.task_type_id,'
                . QM_TASK . '.fse_id,'
                . QM_TASK . '.status_id,'
//                . QM_TASK_LOCATION . '.task_location,'
//                . QM_TASK_LOCATION . '.start_time,'
//                . QM_TASK_LOCATION . '.reached_time,'
//                . QM_TASK_LOCATION . '.total_travel_time,'
//                . QM_TASK_LOCATION . '.start_to_work_time,'
//                . QM_TASK_LOCATION . '.Work_completed_time,'
//                . QM_TASK_LOCATION . '.total_worked_time,'
//                . QM_TASK_LOCATION . '.geo_km,'
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
// $this->db->join(QM_TASK_LOCATION, QM_TASK . '.id = ' . QM_TASK_LOCATION . '.task_id', 'LEFT');
        $this->db->where(QM_TASK . '.task_status', 1);
        if ($taskID != NULL) {
            $this->db->where(QM_TASK . '.id', $taskID);
        }
        if ($tasktypeid != NULL) {
            $this->db->where(QM_TASK . '.task_type_id', $tasktypeid);
        }
        if ($start_date != NULL) {
            $this->db->where(QM_TASK . '.created_date>=', date('Y-m-d H:i:s', strtotime($start_date)));
        }
        if ($end_date != NULL) {
            $this->db->where(QM_TASK . '.created_date<=', date('Y-m-d H:i:s', strtotime($end_date) + 86400));
        }
        $this->db->order_by('id', "DESC");
        $this->db->limit(10);
        if ($user_type_data[0]['user_type'] != 1) {
//            $this->db->where(QM_TASK.'.ent_id');
        }
        $query = $this->db->get();
        $result = $query->result_array();
        $data = array();
        $i = 0;

        if (!empty($result)) {
            foreach ($result as $value) {
// $a2 = $this->reportsextrafeildValue($value['id'], $value['task_type_id']);
                $a2 = array();
                $value['customer_sign'] = "";
                $value['start_time'] = "";
                $value['task_location'] = "";
                $value['reached_time'] = "";
                $value['total_travel_time'] = "";
                $value['start_to_work_time'] = "";
                $value['Work_completed_time'] = "";
                $value['total_worked_time'] = "";
                $value['geo_km'] = "";

                $data[$i] = array_merge($value, $a2);
                $i++;
            }
        }
//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
//        exit();
        return $data;
    }

    public function getDocuments($id) {
        if ($id != '')
            $this->db->select('*');
        $this->db->from(QM_TASK_CUSTOMER_DOCUMENT);
        $this->db->where('task_id', $id);
        $this->db->limit(10);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
    }

    public function getCategories($id, $task_id = '') {
        if ($id != '') {
            $this->db->select('*');
            $this->db->from(QM_CATEGORY);
            $this->db->where('task_type', $id);
            $this->db->where('category_status', 1);
            $this->db->where('separate_update_screen', 1);

            $this->db->limit(10);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                //  var_dump($result);        exit(); 
                foreach ($result as $k => $data) {
                    $result[$k]['labels'] = $this->getlabels($data['ent_id'], $data['id'], $task_id);
                    $result[$k]['Updatedlabels'] = $this->getUpdatedlabels($data['ent_id'], $data['id'], $task_id);
                }
                return $result;
            }
        }
        return FALSE;
    }

    public function getlabels($id, $cat_type_id, $task_id) {
        $this->db->select(QM_EXTRA_ATTR_DEFINITION . '.*,' . QM_EXTRA_ATTR_VALUES . '.Extra_attr_Values');
        $this->db->from(QM_EXTRA_ATTR_DEFINITION);
        $this->db->join(QM_EXTRA_ATTR_VALUES, QM_EXTRA_ATTR_DEFINITION . '.extr_att_id = ' . QM_EXTRA_ATTR_VALUES . '.Extra_attr_Def_id', 'LEFT');
        $this->db->where(QM_EXTRA_ATTR_DEFINITION . '.ent_id', $id);
        $this->db->where(QM_EXTRA_ATTR_DEFINITION . '.Ext_att_category_id', $cat_type_id);
        $this->db->where(QM_EXTRA_ATTR_VALUES . '.Task_id', $task_id);
        $this->db->limit(10);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

//    ----------- Load Task Information updated by technician :
    public function getUpdatedlabels($id, $cat_type_id, $task_id) {
        $this->db->select(QM_EXTRA_ATTR_UPDATE_VALUE . '.value,' . QM_EXTRA_ATTR_UPDATE_VALUE . '.task_id,');
        $this->db->select(QM_EXTRA_ATTR_UPDATE . '.*');
        $this->db->from(QM_EXTRA_ATTR_UPDATE);
        $this->db->join(QM_EXTRA_ATTR_UPDATE_VALUE, QM_EXTRA_ATTR_UPDATE . '.id = ' . QM_EXTRA_ATTR_UPDATE_VALUE . '.update_atr_id', 'LEFT');
        $this->db->where(QM_EXTRA_ATTR_UPDATE . '.ent_id', $id);
        $this->db->where(QM_EXTRA_ATTR_UPDATE . '.category_id', $cat_type_id);
        $this->db->where(QM_EXTRA_ATTR_UPDATE_VALUE . '.task_id', $task_id);
        $this->db->limit(10);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    //    -----------End Load Task Information updated by technician :
    public function getAssets($id) {
        if ($id != '') {
            $this->db->select(QM_TASK . '.capture_assets');
            $this->db->from(QM_TASK);
            $this->db->where(QM_TASK . '.id', $id);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result;
            }
        }
    }

    public function getComplete($id) {
        if ($id != '') {
            $this->db->select(QM_TASK . '.*,' . QM_TASK_LOCATION . '.Work_completed_time');
            $this->db->from(QM_TASK);
            $this->db->join(QM_TASK_LOCATION, QM_TASK . '.id = ' . QM_TASK_LOCATION . '.task_id', 'LEFT');
            $this->db->where(QM_TASK . '.id', $id);
            $this->db->limit(10);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                //print_r($result); exit(); 
                foreach ($result as $key => $value) {
                    $completscreendata = $this->getcompleteScreenData($value['task_type_id']);
                    $result[$key]['completescreen'] = $completscreendata;
                }
                return $result;
            }
        }
        return false;
    }

    public function getcompleteScreenData($id = '') {
        $query = $this->db->select(QM_TASK_TYPE . '.id,' . QM_TASK_TYPE . '.task_type,' . QM_TASK_TYPE . '.completed_screen_data');
        $query = $this->db->from(QM_TASK_TYPE);
        $this->db->order_by(QM_TASK_TYPE . '.id', 'DESC');
        $query = $this->db->where(QM_TASK_TYPE . '.task_type_status', 1);
        $query = $this->db->where(QM_TASK_TYPE . '.id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        return json_decode($result[0]['completed_screen_data']);
    }

    public function gettasklocation($id) {
        //echo $id;        exit(); 
        if ($id != '') {

            $this->db->select(QM_TASK_LOCATION . '.id,' . QM_TASK_LOCATION . '.task_id,' . QM_TASK_LOCATION . '.Work_completed_time,' . QM_TASK_LOCATION . '.task_location');
            $this->db->from(QM_TASK);
            $this->db->join(QM_TASK_LOCATION, QM_TASK . '.id = ' . QM_TASK_LOCATION . '.task_id', 'LEFT');
            $this->db->where(QM_TASK . '.id', $id);
            // $this->db->where(QM_TASK . '.status_id = ', 5);
            $this->db->limit(10);
            $query = $this->db->get();
            $result = $query->result_array();
            return $result;
        }
    }

    function check_user_type($loginuserid) {
        $this->db->select(QM_WEB_ACCESS . '.ent_id,' . QM_WEB_ACCESS . '.user_type');
        $this->db->from(QM_WEB_ACCESS);
        $this->db->where(QM_WEB_ACCESS . '.id', $loginuserid);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function taskListReport() {
        $LogginUserid = $this->session->userdata('session_data')->user_id;
        $user_type_data = $this->check_user_type($LogginUserid);

        $this->db->distinct(QM_TASK . '.task_type_id,');
        $this->db->select(QM_TASK . ' .task_type_id,'
                . QM_TASK . '.task_name,'
                . QM_TASK . '.assign_date,' 
                . QM_TASK . '.task_status,'
                . QM_TASK . '.task_address,'
                . QM_TASK . '.start_date,'
                . QM_TASK . '.id,'
                . QM_TASK . '.fse_checklist,'
                . QM_TASK . '.fse_task_comments,'
                . QM_TASK . '.fse_reason,'
                . QM_TASK . '.fse_feedback,'
                . QM_TASK . '.fse_id,'
                . QM_TASK . '.status_id,'
                . QM_TASK . '.priority,'
                . QM_TASK . '.created_date,'
                . QM_TASK . '.customer_sign,'
                .QM_TASK_LOCATION.'.start_time,'
                .QM_TASK_LOCATION.'.reached_time,'
                .QM_TASK_LOCATION.'.total_travel_time,'
                .QM_TASK_LOCATION.'.start_to_work_time,'
                .QM_TASK_LOCATION.'.Work_completed_time,'
                .QM_TASK_LOCATION.'.total_worked_time,'
                .QM_TASK_LOCATION.'.geo_km,'
                .QM_TASK_LOCATION.'.task_location,'                
                . QM_FSE_DETAILS . '.fse_name,'
                . QM_STATUS_TYPE . '.status_type,'
                . QM_TASK_TYPE . '.task_type,'
                . QM_PRIORITY . '.priority_type'
        );
        $this->db->from(QM_TASK);
        $this->db->join(QM_FSE_DETAILS, QM_TASK . '.fse_id = ' . QM_FSE_DETAILS . '.id', 'INNER');
        $this->db->join(QM_STATUS_TYPE, QM_TASK . '.status_id = ' . QM_STATUS_TYPE . '.id', 'INNER');
        $this->db->join(QM_PRIORITY, QM_TASK . '.priority = ' . QM_PRIORITY . '.id', 'INNER');
        $this->db->join(QM_TASK_TYPE, QM_TASK . '.task_type_id = ' . QM_TASK_TYPE . '.id', 'INNER');
        $this->db->join(QM_TASK_LOCATION, QM_TASK . '.id = ' . QM_TASK_LOCATION . '.task_id', 'INNER');
//<<<<<<< HEAD
        $this->db->where(QM_TASK . '.task_status', 1);
        if ($user_type_data[0]['user_type'] != 1) {
            $this->db->where(QM_TASK . '.ent_id', $user_type_data[0]['ent_id']);
        }
/* **** last confilcted code=======
        $this->db->join(QM_TASK_LOCATION, QM_TASK . '.id = ' . QM_TASK_LOCATION . '.task_id', 'INNER');
        $this->db->where(QM_TASK.'.task_status',1);
        if($user_type_data[0]['user_type']!=1)     
         {
           $this->db->where(QM_TASK . '.ent_id',$user_type_data[0]['ent_id']); 
         }
>>>>>>> af136318e03d336a323b6f7a2356ce5ae401b9bc
 * 
 */
        $this->db->order_by(QM_TASK . '.created_date', 'DESC');
        $this->db->limit(300);

        $query = $this->db->get();
        $result = $query->result_array();
        $limit = count($result);
//        for ($i = 0; $i < $limit; $i++) {
//
//            //var_dump($result[$i]['task_type_id']); task_id
//            $result[$i]['document'] = $this->getDocuments($result[$i]['id']); // ok 
//            $result[$i]['category'] = $this->getCategories($result[$i]['task_type_id'],$result[$i]['id']);
//            $result[$i]['assets'] = $this->getAssets($result[$i]['task_type_id']);
//            $result[$i]['complete'] = $this->getComplete($result[$i]['id']);
//            if ($result[$i]['status_id'] == 5) {
//              $result[$i]['tasklocation'] = $this->gettasklocation($result[$i]['id']);
//            }
//        }
//        $data = array();
//        $i = 0;
//
//        if (!empty($result)) {
//            foreach ($result as $value) {
//                $a2 = $this->reportsextrafeildValue($value['id'], $value['task_type_id']);
//                $a2 = array();
//                $value['customer_sign'] = "";
//                $value['start_time'] = "";
//                $value['task_location'] = "";
//                $value['reached_time'] = "";
//                $value['total_travel_time'] = "";
//                $value['start_to_work_time'] = "";
//                $value['Work_completed_time'] = "";
//                $value['total_worked_time'] = "";
//                $value['geo_km'] = "";
//
//                $data[$i] = array_merge($value, $a2);
//                $i++;
//            }
//        }

        return $result;
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

    public function get_tasklocation($task_id = '') {
//        if($this->input->post('taskid'))
//        {
//              $task_id = $this->input->post('taskid');
//        }else{
//             $task_id = $this->input->get('taskid');
//        }
        $this->db->select(QM_TASK . '.id,' . QM_TASK . '.fse_id,' . QM_TASK . '.status_id,' . QM_TASK . '.task_address');
        $this->db->from(QM_TASK);
        $this->db->where(QM_TASK . '.id', $task_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $a = $query->result_array();
            $a['tasklocation'] = $this->get_task_location($a[0]['id']);
            $a['taskallcationfse'] = $this->get_task_allocated_fse($a[0]['fse_id']);
            return $a;
        }
    }

    public function get_task_location($id) {
        $this->db->select(QM_TASK_LOCATION . '.task_location');
        $this->db->from(QM_TASK_LOCATION);
        $this->db->where(QM_TASK_LOCATION . '.task_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
    }

    public function get_task_allocated_fse($id) {
        $this->db->select(QM_FSE_LOCATION . '.fse_lat,' . QM_FSE_LOCATION . '.fse_long');
        $this->db->from(QM_FSE_LOCATION);
        $this->db->where(QM_FSE_LOCATION . '.fse_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }
    }

    function getaddress($lat, $lng) {
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim($lat) . ',' . trim($lng) . '&sensor=false';
        $json = @file_get_contents($url);
        $data = json_decode($json);
        $status = $data->status;
        if ($status == "OK") {
            return $data->results[1]->address_components[2]->long_name . ',' . $data->results[1]->address_components[4]->short_name;
            // return $data->results[0]->formatted_address;
        } else {
            return false;
        }
    }

    public function getAdminsection($id) {
        $this->db->from(QM_TASK_REPORT);
        $this->db->where(QM_TASK_REPORT . '.task_id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function get_task_status($task_id) {
        $this->db->select(QM_TASK . '.status_id');
        $this->db->from(QM_TASK);
        $this->db->where(QM_TASK . '.id', $task_id);
        $query = $this->db->get();
        $result = $query->result_array();
        //print_r($result);        exit(); 
        return $result[0]['status_id'];
    }

    public function report_history($record, $email) {
        $data['task_id'] = $record[0]['id'];
        $data['task_type_id'] = $record[0]['task_type_id'];
        $data['ent_id'] = $record[0]['ent_id'];
        $data['task_report_id'] = $this->input->post('report_id');
        $data['email'] = $email;
        $data['createdat'] = date('Y-m-d');
        $data['createdby'] = $record[0]['fse_id'];
        $data['modifiedat'] = date('Y-m-d');
        $data['modifiedby'] = $record[0]['fse_id'];
        $this->db->insert(QM_TASK_REPORT_EMAILS, $data);
        return TRUE;
    }

    public function update_taskreport($tasktypeid, $ent_id) {
        $id = '';
        if ($this->input->post('id'))
            $id = $data['task_id'] = $this->input->post('id');
        if ($ent_id)
            $data['ent_id'] = $ent_id;
        if ($tasktypeid)
            $data['task_type_id'] = ($tasktypeid) ? $tasktypeid : 0;
        if ($this->input->post('assignment'))
            $data['assignmnetinfo'] = $this->input->post('assignment');
        if ($this->input->post('task_operations'))
            $data['operationinfo'] = $this->input->post('task_operations');
        if ($this->input->post('task_location'))
            $data['locationinfo'] = $this->input->post('task_location');
        if ($this->input->post('create_Information'))
            $data['createinfo'] = $this->input->post('create_Information');
        if ($this->input->post('update_information'))
            $data['updateinfo'] = $this->input->post('update_information');
        if ($this->input->post('assets'))
            $data['assetinfo'] = $this->input->post('assets');
        if ($this->input->post('attachment'))
            $data['attachmentinfo'] = $this->input->post('attachment');
        if ($this->input->post('customerinteraction'))
            $data['customerinfo'] = $this->input->post('customerinteraction');

        // print_r($data);                exit(); 
        if ($id) {
            $query = $this->db->select(QM_TASK_REPORT . '.id')->from(QM_TASK_REPORT)->where(QM_TASK_REPORT . '.task_id', $id)->get();
            if ($query->num_rows() > 0) {
                $this->db->where(QM_TASK_REPORT . '.task_id', $id); //which row want to upgrade  
                $this->db->update(QM_TASK_REPORT, $data);
            } else {
                $this->db->insert(QM_TASK_REPORT, $data);
            }
        } else {
            return FALSE;
        }
    }

    public function getAttachment($task_id = '', $task_type_id) {
        $this->db->select(QM_TASK_CUSTOMER_DOCUMENT . '.*');
        $this->db->from(QM_TASK_CUSTOMER_DOCUMENT);
        $this->db->where(QM_TASK_CUSTOMER_DOCUMENT . '.task_id', $task_id);
        $this->db->limit(10);
        $query = $this->db->get();
        $result = $query->result_array();
        foreach ($result as $key => $dk) {
            $result[$key]['attachment_value'] = $this->get_attachment_lable($task_type_id, $task_id, $dk['id']);
        }
        return $result;
    }

    /* public function getAttachment_value($taskdocument_id='')
      {

      $this->db->select(QM_ATTACHMENT_ATTR_UPDATE_VALUE.'.value,'.QM_ATTACHMENT_ATTR_UPDATE_VALUE.'.update_date,'.
      QM_ATTACHMENT_ATTR_UPDATE_VALUE.'.latitude,'.
      QM_ATTACHMENT_ATTR_UPDATE_VALUE.'.langitude,');
      $this->db->select(QM_ATTACHMENT_ATTR_UPDATE.'.*');
      $this->db->from(QM_ATTACHMENT_ATTR_UPDATE_VALUE);
      $this->db->join(QM_ATTACHMENT_ATTR_UPDATE, QM_ATTACHMENT_ATTR_UPDATE_VALUE . '.update_atr_id = ' . QM_ATTACHMENT_ATTR_UPDATE . '.id', 'LEFT');
      $this->db->where(QM_ATTACHMENT_ATTR_UPDATE_VALUE . '.task_dacument_id', $taskdocument_id);
      $query = $this->db->get();
      if ($query->num_rows()>0) {
      return $query->result_array();
      }else{
      return false;
      }


      } */

    public function getAttachment_update_value($updateAttrid = '', $task_id = '', $task_doc_id = '') {

        $this->db->select(QM_ATTACHMENT_ATTR_UPDATE_VALUE . '.id,' . QM_ATTACHMENT_ATTR_UPDATE_VALUE . '.value,' . QM_ATTACHMENT_ATTR_UPDATE_VALUE . '.id,' . QM_ATTACHMENT_ATTR_UPDATE_VALUE . '.latitude,' . QM_ATTACHMENT_ATTR_UPDATE_VALUE . '.langitude,');
        $this->db->from(QM_ATTACHMENT_ATTR_UPDATE_VALUE);
        $this->db->where(QM_ATTACHMENT_ATTR_UPDATE_VALUE . '.update_atr_id', $updateAttrid);
        $this->db->where(QM_ATTACHMENT_ATTR_UPDATE_VALUE . '.task_id', $task_id);
        $this->db->where(QM_ATTACHMENT_ATTR_UPDATE_VALUE . '.task_dacument_id', $task_doc_id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_attachment_lable($tasktypeid = '', $task_id, $task_doc_id = '') {
        $result_update_data = array();
        $attachvalue = array();

        $this->db->select(QM_ATTACHMENT_ATTR_UPDATE . '.id,' . QM_ATTACHMENT_ATTR_UPDATE . '.label,' . QM_ATTACHMENT_ATTR_UPDATE . '.option_type,' . QM_ATTACHMENT_ATTR_UPDATE . '.required_status,' . QM_ATTACHMENT_ATTR_UPDATE . '.type_values,');
        $this->db->from(QM_ATTACHMENT_ATTR_UPDATE);
        $this->db->where(QM_ATTACHMENT_ATTR_UPDATE . '.task_type', $tasktypeid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result_update_data = $query->result_array();
            foreach ($result_update_data as $key => $update_att) {
                $attachvalue = $this->getAttachment_update_value($update_att['id'], $task_id, $task_doc_id);
                if (count($attachvalue) > 0) {
                    $result_update_data[$key]['value'] = ($attachvalue[0]['value']) ? $attachvalue[0]['value'] : '';
                    $result_update_data[$key]['id'] = ($attachvalue[0]['id']) ? $attachvalue[0]['id'] : '';
                    $result_update_data[$key]['latitude'] = ($attachvalue[0]['latitude']) ? $attachvalue[0]['latitude'] : '';
                    $result_update_data[$key]['langitude'] = ($attachvalue[0]['langitude']) ? $attachvalue[0]['langitude'] : '';
                }
            }
            return $result_update_data;
        } else {
            return false;
        }
    }

    public function datatable_response($firstload) {
        $params = $columns = $totalRecords = $data = array();
        $LogginUserid = $this->session->userdata('session_data')->user_id;
        $user_type_data = $this->check_user_type($LogginUserid);

       
//        $this->db->order_by(QM_TASK . '.created_date', 'DESC');
//        $this->db->limit(300);
        $params = $_REQUEST;
        $params['order'][0]['dir']='desc';
//        print_r($params['order'][0]['dir']);
//        die;
        //define index of column
        $columns = array(
            0 => QM_TASK . '.id',
            1 => QM_TASK . '.task_name',
            2 => QM_FSE_DETAILS . '.fse_name',
            4 => QM_STATUS_TYPE . '.status_type',
            5 => QM_PRIORITY . '.priority_type',
            6 => QM_TASK . '.task_address',
            7 => QM_TASK . '.fse_reason',
        );
        $Login_wisewhereCond="";
        $where = $sqlTot = $sqlRec = "";

        // check search value exist
        if (!empty($params['search']['value'])) {
            $where .=" and ";
            $where .=" ( " . QM_TASK . ".task_name LIKE '" . $params['search']['value'] . "%' ";
            $where .=" OR " . QM_FSE_DETAILS . ".fse_name LIKE '" . $params['search']['value'] . "%' ";
            $where .=" OR " . QM_STATUS_TYPE . ".status_type LIKE '" . $params['search']['value'] . "%' ";
            $where .=" OR " . QM_PRIORITY . ".priority_type LIKE '" . $params['search']['value'] . "%' ";
            $where .=" OR " . QM_TASK . ".task_address LIKE '" . $params['search']['value'] . "%' ";
            $where .=" OR " . QM_TASK . ".fse_reason LIKE '" . $params['search']['value'] . "%' )";
        }

        // getting total number records without any search

//----- ********user login wise show records using this statement -------------
       if ($user_type_data[0]['user_type'] != 1) {
           $Login_wisewhereCond=" and ". QM_TASK . '.ent_id='.$user_type_data[0]['ent_id'];
        }
        
//--end --- ********user login wise show records using this statement -------------        
        $autoncnt = "(@cnt := @cnt + 1) AS `serial_number`,";
        $subQ = '(SELECT @a:= 0) AS a';
//       $OrderByCount=" (SELECT ".QM_TASK.".id FROM " .QM_TASK." ";
//       $OrderByCountClsBra=" ) ";
//        $sql = "SELECT " . $autoncnt . "" . QM_TASK . " .task_name,
//                                " . QM_TASK_TYPE . " .task_type,
//                                " . QM_FSE_DETAILS . " .fse_name,
//                                " . QM_STATUS_TYPE . " .status_type,
//                                " . QM_PRIORITY . " .priority_type,
//                                " . QM_TASK . " .task_address,
//                                " . QM_TASK . " .start_date,
//                                " . QM_TASK . " .fse_checklist,
//                                " . QM_TASK . " .fse_task_comments,
//                                " . QM_TASK . " .fse_reason,
//                                " . QM_TASK . " .fse_feedback,
//                                " . QM_TASK . " .created_date,
//                                " . QM_TASK . " .id,
//                                " . QM_TASK . " .task_type_id,
//                                " . QM_TASK . " .task_status,
//                                " . QM_TASK . " .fse_id,
//                                " . QM_TASK . " .status_id,                                    
//                                " . QM_TASK . " .priority FROM " . QM_TASK . "
//                                CROSS JOIN (SELECT @cnt := 0) AS dummy
//                                inner join " . QM_FSE_DETAILS . " ON " . QM_TASK . ".fse_id = " . QM_FSE_DETAILS . ".id
//                                inner join " . QM_STATUS_TYPE . " ON " . QM_TASK . ".status_id = " . QM_STATUS_TYPE . ".id
//                                inner join " . QM_PRIORITY . " ON " . QM_TASK . " .priority = " . QM_PRIORITY . ".id
//                                Inner join " . QM_TASK_TYPE . " ON " . QM_TASK . ".task_type_id = " . QM_TASK_TYPE . ".id
        	$sql = "SELECT " . $autoncnt . "" . QM_TASK . " .task_name,
                                " . QM_TASK_TYPE . " .task_type,
                                " . QM_FSE_DETAILS . " .fse_name,
                                " . QM_STATUS_TYPE . " .status_type,
                                " . QM_PRIORITY . " .priority_type,
                                " . QM_TASK . " .task_address,
                                " . QM_TASK . " .start_date,
                                " . QM_TASK . " .fse_checklist,
                                " . QM_TASK . " .fse_task_comments,
                                " . QM_TASK . " .fse_reason,
                                " . QM_TASK . " .fse_feedback,
                                ".QM_TASK_LOCATION.".start_time,
                                ".QM_TASK_LOCATION.".reached_time,
                                ".QM_TASK_LOCATION.".total_travel_time,
                                ".QM_TASK_LOCATION.".start_to_work_time,
                                ".QM_TASK_LOCATION.".Work_completed_time,
                                ".QM_TASK_LOCATION.".total_worked_time,
                                ".QM_TASK_LOCATION.".geo_km,                                
                                " . QM_TASK . " .created_date,
                                    
                                " . QM_TASK . " .id,
                                " . QM_TASK . " .task_type_id,
                                " . QM_TASK . " .task_status,
                                " . QM_TASK . " .fse_id,
                                " . QM_TASK . " .status_id,                                    
                                " . QM_TASK . " .priority
                                 FROM " . QM_TASK . "
                        CROSS JOIN (SELECT @cnt := 0) AS dummy
                        inner join " . QM_FSE_DETAILS . " ON " . QM_TASK . ".fse_id = " . QM_FSE_DETAILS . ".id
                        inner join " . QM_STATUS_TYPE . " ON " . QM_TASK . ".status_id = " . QM_STATUS_TYPE . ".id
                        inner join " . QM_PRIORITY . " ON " . QM_TASK . " .priority = " . QM_PRIORITY . ".id
                        Inner join " . QM_TASK_TYPE . " ON " . QM_TASK . ".task_type_id = " . QM_TASK_TYPE . ".id
                        Inner join " . QM_TASK_LOCATION . " ON " . QM_TASK . ".id = " . QM_TASK_LOCATION . ".task_id
                        where " . QM_TASK . ".task_status=1";

//       echo $sql; die;
//                    $sql=$this->db->select(QM_TASK . ' .task_name,
//                                            '. QM_TASK_TYPE . ' .task_type,
//                                            '. QM_FSE_DETAILS . ' .fse_name,
//                                            '. QM_STATUS_TYPE . ' .status_type,
//                                            '. QM_PRIORITY . ' .priority_type,
//                                            '. QM_TASK . ' .task_address,
//                                            '. QM_TASK . ' .start_date,
//                                            '. QM_TASK . ' .fse_checklist,
//                                            '. QM_TASK . ' .fse_task_comments,
//                                            '. QM_TASK . ' .fse_reason,
//                                            '. QM_TASK . ' .fse_feedback,
//                                            '. QM_TASK . ' .created_date,
//                                            '. QM_TASK . ' .id,
//                                            '. QM_TASK . ' .task_type_id,
//                                            '. QM_TASK . ' .task_status,
//                                            '. QM_TASK . ' .fse_id,
//                                            '. QM_TASK . ' .status_id,
//                                            '. QM_TASK . ' .priority')
//                                    ->from(QM_TASK)                             
//        ->join(QM_FSE_DETAILS, QM_TASK . '.fse_id = ' . QM_FSE_DETAILS . '.id', 'INNER')
//        ->join(QM_STATUS_TYPE, QM_TASK . '.status_id = ' . QM_STATUS_TYPE . '.id', 'INNER')
//        ->join(QM_PRIORITY, QM_TASK . '.priority = ' . QM_PRIORITY . '.id', 'INNER')
//        ->join(QM_TASK_TYPE, QM_TASK . '.task_type_id = ' . QM_TASK_TYPE . '.id', 'INNER')
//        ->where(QM_TASK.'.task_status',1);       
//        ->order_by(QM_TASK . '.created_date', 'DESC');
//        $this->db->limit(300);
//echo "12123".$sql;die;
        $sqlTot .= $sql;
        $sqlRec .= $sql;

        //concatenate search sql if value exist
        if (isset($where) && $where != '') {

            $sqlTot .= $where;
            $sqlRec .= $where;
        }
        if(isset($Login_wisewhereCond) && $Login_wisewhereCond != '')
        {
             $sqlTot .= $Login_wisewhereCond;
             $sqlRec .= $Login_wisewhereCond;
        }


        $sqlRec .= " ORDER BY " . $columns[$params['order'][0]['column']] . "  " . $params['order'][0]['dir'] . "  LIMIT " . $params['start'] . " ," . $params['length'] . " ";
//        echo $sqlRec;die;
        $queryTot = $this->db->query($sqlTot);

        $totalRecords = $queryTot->num_rows();
        $queryRec = $this->db->query($sqlRec);

        $queryRecords = $queryRec->result_array();

        $i = 1;
        $k = 1;
//        print_r($queryRecords);
        $customer_sign='';
        foreach ($queryRecords as $key => $queryRecords_value) {

        $customer_signQuery=$this->db->select(QM_TASK . ".customer_sign")
                                     ->from(QM_TASK)
                                     ->where(QM_TASK.".id",$queryRecords_value['id'])
                                     ->get();
        $customer_signRes=$customer_signQuery->result_array();

        if(!empty($customer_signRes))
                {
                    // $rowdata[]=$abc_row;
                    $customer_sign=$customer_signRes[0]['customer_sign'];
                       
                     
                }
                else{
                // $rowdata[]=$abc_row;
                     $customer_sign='';
                }
                
            $rowdata = array();
            $rowdata1 = array();
            $rowdata2 = array();
            $rowdata3 = array();
            foreach ($queryRecords_value as $r => $abc_row) {
                
                $onclick = "taskdetail(this,'row_show_" . $k . "" . $k . "'," . $queryRecords_value['id'] . "," . $i . "," . $queryRecords_value['task_type_id'] . ")";

                /*if ($abc_row != $queryRecords_value['id'] && $abc_row != $queryRecords_value['task_type_id'] && $abc_row != $queryRecords_value['task_status'] && $abc_row != $queryRecords_value['fse_id'] && $abc_row != $queryRecords_value['status_id'] && $abc_row != $queryRecords_value['priority']) {

                   
                }*/
               //  $rowdata[][] = 11;
                // " . QM_TASK . ".customer_sign,
                 $rowdata[]=$abc_row;
                
                 

//                 $rowdata[] = "<div class='row_show" . $k . "' id='row_show_" . $queryRecords_value['id'] . "' onclick=$onclick>" . $abc_row . "</div>";
              
            }
            if (count($rowdata)) {
                $rowdata[]='<img alt="" src='.$customer_sign.' style="height:50px; width:100px">';;

                $confirmmsg = "'Are you sure you want to delete this item?'";
                $rowdata[] = ' <form action="' . base_url() . 'updateTask" method="post"><input type="hidden" value="' . $queryRecords_value['id'] . '" name="edit_id"  id="edit_id_'.$i.'" />'
                        . '     <input type="hidden" value="' . $queryRecords_value['task_type_id'] . '" name="task_type_id" id="task_type_id_'.$i.'"  /> 
                                <input type="hidden" value=' . $queryRecords_value['fse_id'] . ' name="fse_id" id="fse_id_'.$i.'"  />
                                <input type="hidden" value=' . $queryRecords_value['status_id'] . ' name="status_id"  />  
                                <input type="hidden" value=' . $queryRecords_value['task_location'] . ' name="task_location"  />'
                        . ' <button class="fa fa-edit" name="edit" title="Edit" value="edit"></button>'
                        . '<button class="fa fa-tasks" name="updateView" title="Update" value="updateView"></button>'
                        . '<button class="fa fa-trash" name="delete" value="delete" title="Delete" onclick="return confirm(' . $confirmmsg . ')"></button></form>';
            }
            $data[] = $rowdata;
            $i++;
        }
          

        $json_data = array(
            "draw" => intval($params['draw']),
            "recordsTotal" => intval($totalRecords),
            "recordsFiltered" => intval($totalRecords),
            "data" => $data   // total data array
        );


        echo json_encode($json_data);
    }

    //-----------------------------------------------------------------
     public function load_Taskid_tasktype($id = NULL) {

        $this->db->select(QM_TASK . '.*,'
                . QM_FSE_DETAILS . '.fse_name,'
                . QM_TASK_LOCATION . '.total_travel_time,'
                . QM_TASK_LOCATION . '.Work_completed_time,'
                . QM_TASK_LOCATION . '.reached_time,'
                . QM_TASK_LOCATION . '.updated_date,'
                //         . QM_PROJECT . '.proj_name,'
                //  . QM_INCIDENT . '.incident_name'
        );
        $this->db->from(QM_TASK);
        $this->db->join(QM_FSE_DETAILS, QM_TASK . '.fse_id = ' . QM_FSE_DETAILS . '.id', 'LEFT');
        $this->db->join(QM_TASK_LOCATION, QM_TASK . '.id = ' . QM_TASK_LOCATION . '.task_id', 'LEFT');
        //   $this->db->join(QM_PROJECT, QM_TASK . '.project_id = ' . QM_PROJECT . '.id', 'LEFT');
        //   $this->db->join(QM_INCIDENT, QM_TASK . '.incident_id = ' . QM_INCIDENT . '.id', 'LEFT');
        $this->db->where(QM_TASK . '.id', $id);

        $query = $this->db->get();
        return $query->result_array();
    }
}
