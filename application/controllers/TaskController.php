<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class TaskController extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('PHPMailer');
        $this->load->library('SMTP');
        $this->load->model("TaskModel");
        $this->load->model("MY_Model");
        $this->load->model("TPServicesModel");

        $CI = & get_instance();
    }

    /* This controller is using for display task details */

    public function taskList() {

        if ($this->input->post('submit')) {
            $session_data = $this->session->userdata('session_data');
            $session_data->task_type_id = $this->input->post('tasktypeid');
            $session_data->start_date_search = $this->input->post('start_date');
            $session_data->end_date_search = $this->input->post('end_date');
            $this->session->set_userdata('session_data', $session_data);
        }


        $start_date = $this->session->userdata('session_data')->start_date_search;
        $end_date = $this->session->userdata('session_data')->end_date_search;
        $tasktypeid = $this->session->userdata('session_data')->task_type_id;

        $start_date = "2018-01-06 11:48:44";
        $end_date == "2018-02-06 11:48:44";
        $tasktypeid == "1";

        if ($start_date == "" || $end_date == "" || $tasktypeid == "") {
            redirect('task');
        }
        $data['entityFeilds'] = $this->TaskModel->entityFeilds();
        $data['result'] = $this->TaskModel->taskCustFieldReport(NULL, $tasktypeid, $start_date, $end_date);
        $data['menu'] = '';
        $data['title'] = 'Task';
//        $data['page'] = 'TaskView';
//        $data['page'] = 'newTaskReport';
//        //        print_r($data['result']);
//        exit;
        $this->load->view("common/CommonView", $data);
    }

//-start- added new function---------------------
    public function alltasks() {

        $data['entityFeilds'] = $this->TaskModel->entityFeilds();

        $data['result'] = $this->TaskModel->taskListReport();
//        print_r($data['result']);        exit(); 

        $data['menu'] = '';
        $data['title'] = 'Task';
        $data['page'] = 'tasklist';
//        $data['page'] = 'TaskReportTemplateView';
//        echo "<pre>";
//        print_r($data['result']);
        $this->load->view("common/CommonView", $data);
    }

//-end- added new function---------------------
    public function task() {
        $firstload = 'firstload';
//        $data['result'] = $this->TaskModel->gettasktypeHeaderModel();
        $data['entityFeilds'] = $this->TaskModel->entityFeilds();
        $data['result'] = $this->TaskModel->taskListReport();
//        $data = $this->TaskModel->datatable_response($firstload); 
        $data['menu'] = '';
        $data['title'] = 'Task';
//        $data['page'] = 'TaskSearchView';
        $data['page'] = 'newTaskReport';
        $this->load->view("common/CommonView", $data);
    }

    function datatable_response() {
        $data = $this->TaskModel->datatable_response();
    }

    public function getTask_autocomplete_c() {
        $keyword = $this->input->post('term');
        $this->TaskModel->getTask_autocomplete($keyword);
    }

    public function getFse_autocomplete_c() {
        $keyword = $this->input->post('term');
        $this->TaskModel->getFse_autocomplete($keyword);
    }

    public function getIncident_autocomplete_c() {
        $keyword = $this->input->post('term');
        $this->TaskModel->getIncident_autocomplete($keyword);
    }

    public function getProject_autocomplete_c() {
        $keyword = $this->input->post('term');
        $this->TaskModel->getProject_autocomplete($keyword);
    }

    public function productline_autocomplete_c() {
        $keyword = $this->input->post('term');
        $this->TaskModel->productline_autocomplete($keyword);
    }

    public function settasktype() {
        $id = $this->input->post('id');
        $session_data = $this->session->userdata('session_data');
        $session_data->task_type_id = $id;
        $session_data->form_submit_check = 1;
        $this->session->set_userdata('session_data', $session_data);
        return TRUE;
    }

    /* This controller is using for add task details */

    public function addTask() {

        $taskLocation = NULL;
        $valid = $this->session->userdata('session_data');
        if ($this->session->userdata('session_data')->task_type_id == "") {
            redirect('task', 'refresh');
        }

        if ($valid->form_submit_check != 1) {
            redirect('task', 'refresh');
        }
//-start- added new line ---------------------	
        $task_type = $valid->task_type_id;
//        echo $task_type;

        $data['check_report_flag'] = $this->TaskModel->checkReportFlag($task_type);
        if ($data['check_report_flag']) {
            $data['report_fields'] = $this->TaskModel->getReportFields($task_type);
        }

//        echo  $data['check_report_flag'];
//        if( $data['check_report_flag']){
//            $data['report_fields'] = $this->TaskModel->getReportFields($task_type);
//        }
//-end- added new line ---------------------
        $data['entityid'] = $this->TaskModel->entityid();
        $data['entitycreateFilds'] = $this->TaskModel->taskcreateFields();
        $data['result'] = $this->TaskModel->typeDetails();
        $data['entityFeilds'] = $this->TaskModel->entityFeilds();
        // $data['fse_User_data'] = $this->TaskModel->CheckAutoFseAvailable_Model();
        $data['menu'] = '';
        $data['title'] = 'Task';
        $data['page'] = 'AddTaskView';

        if ($this->input->post('submit')) {
//-start- added new line by dev.com---------------------	
            $session_data = $this->session->userdata('session_data');
            $session_data->form_submit_check = 0;
            $this->session->set_userdata('session_data', $session_data);

            $this->form_validation->set_rules('task_name', 'Task Name', 'trim|required|callback_checkTaskName');
            $this->form_validation->set_rules('fse_id', 'FSE Name', 'required');
            $this->form_validation->set_rules('status_id', 'Status', 'required');
            $this->form_validation->set_rules('priority', 'priority', 'required');
            $this->form_validation->set_rules('start_date', 'Start Date', 'required');
            $this->form_validation->set_rules('task_address', 'Task Address', 'required');
            $this->form_validation->set_rules('task_location', 'Task Location', 'required');
            $ins_data = $this->input->post();
//-end- added new line by dev.com--------------------
            $value_post = $this->input->post();
//-start- added new line by dev.com---------------------

            $fse_id = $this->input->post('fse_id');
            $task_name = $this->input->post('task_name');
            $statusid = $this->input->post('status_id');
//            $taskID = $this->TaskModel->insertTaskCust($ins_data);
//            $this->TaskModel->insertTaskExtraFields($ins_data, $taskID);
//-end- added new line by dev.com---------------------
            if (isset($value_post['task_address'])) {
                $address_lang = NULL;
                $address = urldecode($this->input->post('task_address'));
                $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');
                $geo = json_decode($geo, true);
                if ($geo['status'] == 'OK') {
                    $latitude = $geo['results'][0]['geometry']['location']['lat'];
                    $longitude = $geo['results'][0]['geometry']['location']['lng'];
                    $taskLocation = '(' . $latitude . ', ' . $longitude . ')';
                } else {
                    $taskLocation = $this->input->post('task_location');
                }
            }

//            $session_data = $this->session->userdata('session_data');
//            $session_data->form_submit_check = 0;
//            $this->session->set_userdata('session_data', $session_data);
//            
//            $this->form_validation->set_rules('task_name', 'Task Name', 'trim|required|callback_checkTaskName');
//            $this->form_validation->set_rules('fse_id', 'FSE Name', 'required');
//            $this->form_validation->set_rules('status_id', 'Status', 'required');
//            $this->form_validation->set_rules('priority', 'priority', 'required');
//            $this->form_validation->set_rules('start_date', 'Start Date', 'required');
//            $this->form_validation->set_rules('task_address', 'Task Address', 'required');
//            $this->form_validation->set_rules('task_location', 'Task Location', 'required');
//            $ins_data = $this->input->post();      
// -start -- added some line code---------------

            if ($this->input->post('auto_routecheck') == 'on' && $this->input->post('fse_id') == '') {
                //$fse_id = $this->TaskModel->getAutoFse($task_type, $taskLocation);
                $fse_id = $this->input->post('loadfseidfrommap');
                $ins_data['auto_route_flag'] = 1;
            } else {
                $fse_id = $this->input->post('fse_id');
                $ins_data['auto_route_flag'] = 0;
            }



            $task_name = $this->input->post('task_name');
            $statusid = $this->input->post('status_id');
            $ins_data['fse_id'] = $fse_id;
            if ($this->input->post('send_taskreport') == 'on') {
                $ins_data['report_flag'] = 1;
            } else if ($this->input->post('TxtReportFlag') == 1) {
                $ins_data['report_flag'] = 1;
            } else {
                $ins_data['report_flag'] = 0;
            }
//            echo $fse_id; print_r($ins_data);
//if(empty($fse_id))
//{
////    echo "empty";
//    $this->session->set_flashdata('error_msg', 'fse user not available for this location..! Please try again');
//     $data['title'] = 'Task';
//        $data['page'] = 'AddTaskView';
//     $this->load->view("common/CommonView", $data);
//    return true;
//}
//exit;
            $taskID = $this->TaskModel->insertTaskCust($ins_data);
            //            echo "<pre>";
//            print_r($ins_data);
//            exit;
            $retrundata['ent_id'] = $this->input->post('ent_id');
            $this->TaskModel->insertTaskExtraFields($ins_data, $taskID);
            $this->session->set_flashdata('success_msg', 'Successfully create task');
//            $taskLocation = NULL;
//            $this->TaskModel->insertTaskEmailReportFields($this->input->post(), $taskID,$this->input->post('ent_id'));
//            exit;
//            $retrundata['reportid']='0';
//               if ($this->input->post('send_taskreport') == 'on') {
            $dataTaskReportFields['task_id'] = $taskID;
            $dataTaskReportFields['ent_id'] = $this->input->post('ent_id');
            $dataTaskReportFields['task_type_id'] = $this->session->userdata('session_data')->task_type_id;

            if ($this->input->post('TxtReportFlag') == 1) {
//                $dataTaskReportFields['TxtReportFlag'] = $this->input->post('TxtReportFlag');        
                $dataTaskReportFields['assignmnetinfo'] = $this->input->post('TxtassReportFlag');
                $dataTaskReportFields['operationinfo'] = $this->input->post('TxttskopReportFlag');
                $dataTaskReportFields['locationinfo'] = $this->input->post('TxttsklocReportFlag');
                $dataTaskReportFields['createinfo'] = $this->input->post('TxtcinfoReportFlag');
                $dataTaskReportFields['updateinfo'] = $this->input->post('TxtuinfoReportFlag');
                $dataTaskReportFields['assetinfo'] = $this->input->post('TxtassetsReportFlag');
                $dataTaskReportFields['attachmentinfo'] = $this->input->post('TxtattachReportFlag');
                $dataTaskReportFields['customerinfo'] = $this->input->post('TxtcintractReportFlag');
            } else {
//                 $dataTaskReportFields['TxtReportFlag'] = 0;   
                $dataTaskReportFields['assignmnetinfo'] = $this->input->post('assignmnetinfo') == 'on' ? 1 : 0;
                $dataTaskReportFields['operationinfo'] = $this->input->post('operationinfo') == 'on' ? 1 : 0;
                $dataTaskReportFields['locationinfo'] = $this->input->post('locationinfo') == 'on' ? 1 : 0;
                $dataTaskReportFields['createinfo'] = $this->input->post('createinfo') == 'on' ? 1 : 0;
                $dataTaskReportFields['updateinfo'] = $this->input->post('updateinfo') == 'on' ? 1 : 0;
                $dataTaskReportFields['assetinfo'] = $this->input->post('assetinfo') == 'on' ? 1 : 0;
                $dataTaskReportFields['attachmentinfo'] = $this->input->post('attachmentinfo') == 'on' ? 1 : 0;
                $dataTaskReportFields['customerinfo'] = $this->input->post('customerinfo') == 'on' ? 1 : 0;
            }
            $retrundata['reportid'] = $this->TaskModel->insertTaskReportFields($dataTaskReportFields);

            $this->TaskModel->insertTaskEmailReportFields($this->input->post(), $taskID, $retrundata);
//            $retrundata['reportid'];
            $this->session->set_flashdata('success_msg', 'Successfully create task');
// -end -- added some line code---------------
            $data = array(
                'task_id' => $taskID,
                'start_time' => '',
                'task_location' => $taskLocation
            );
            $device_type = $this->TaskModel->getFseDeviceType($fse_id);
            if (trim($device_type) == "iOS") {
                $this->MY_Model->send_ios_push($fse_id, $this->input->post(), $taskID);
            } else {
                $this->MY_Model->send_android_push($fse_id, $this->input->post(), $taskID);
            }
            $this->TaskModel->insertTaskLocation($data);
            $this->MY_Model->WebInsertPushNotification($taskID, $task_name, $statusid);
//            exit;
//-start---old code---------------
            // redirect('tasklist');
//-end---old code---------------	    
//-start---new code---------------
            redirect('task');
//-end---new code---------------	    
        }

        $this->load->view("common/CommonView", $data);
    }

    public function GetAutoFseUser_is_to_near() {
        $result = '';
        
        $ent_id = $this->input->post('ent_id');
        $lat = $this->input->post('lat');
        $long = $this->input->post('long');

////                        '18.51297934522157, 73.87131198220914';
////                        $this->input->post('lat_long');
//                $address=$this->input->post('address');
//                $string='';
        $Autofse_data = $this->TaskModel->gettonearfseEngineer($lat, $long);
        foreach ($Autofse_data as $Autofse_datarow) {
            $result = $Autofse_datarow;
        }

        echo json_encode($result);
        exit;
    }

    /* This controller is using for edit and delete task details  */

    public function updateTask() {
        //  print_r($_POST); exit;
        $id = $this->input->post('edit_id');
        $task_location = $this->input->post('task_location');
        $data['results'] = $this->TaskModel->typeDetails();
        $data['entityFeilds'] = $this->TaskModel->entityFeilds();
        if ($this->input->post('submit')) {
            // echo "submit";exit;
            //     $this->session->set_flashdata('success_msg', 'Successfully updated task');
            //     redirect('task');
            $session_data = $this->session->userdata('session_data');
            $session_data->form_submit_check = 0;
            $this->session->set_userdata('session_data', $session_data);

            $fse_id = $this->input->post('fse_id');
            $task_id = $this->input->post('task_id');
            $task_name = $this->input->post('task_name');
            $statusid = $this->input->post('status_id');
            $insert['task_name'] = $this->input->post('task_name');
            $insert['fse_id'] = $this->input->post('fse_id');
            $insert['status_id'] = $this->input->post('status_id');
            $insert['priority'] = $this->input->post('priority');
            $oldstatus_id=$this->input->post('oldstatus_id');
            
            $insert['start_date'] = date('Y-m-d H:i:s', strtotime($this->input->post('start_date')));
            $insert['task_address'] = $this->input->post('task_address');
            $taskLocation = $this->input->post('task_location');
            if ($task_location == "") {
                $address_lang = NULL;
                $address = urldecode($this->input->post('task_address'));
                $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');
                $geo = json_decode($geo, true);
                if ($geo['status'] == 'OK') {
                    $latitude = $geo['results'][0]['geometry']['location']['lat'];
                    $longitude = $geo['results'][0]['geometry']['location']['lng'];
                    $taskLocation = '(' . $latitude . ', ' . $longitude . ')';
                } else {
                    $taskLocation = $this->input->post('task_location');
                }
            }
//            echo $taskLocation;
//            exit;
            $datas = $this->TaskModel->editTask($task_id, $insert,$oldstatus_id);
            $datas = $this->TaskModel->updateExtAtturTask($this->input->post());
            $this->TaskModel->editTaskLocation($task_id, $taskLocation,$insert,$oldstatus_id);
            $device_type = $this->TaskModel->getFseDeviceType($fse_id);
            if (trim($device_type) == "iOS") {

                $this->MY_Model->send_ios_push($fse_id, $this->input->post(), $task_id);
            } else {
                $this->MY_Model->send_android_push($fse_id, $this->input->post(), $task_id);
            }
            $this->MY_Model->WebInsertPushNotification($task_id, $task_name, $statusid);
            //$sql = $this->db->last_query();
            $this->session->set_flashdata('success_msg', 'Successfully updated task');
            redirect('task');
        }

        if ($this->input->post('updateView')) {
            // $data['results'] = $this->TaskModel->typeDetails();
            $id = $this->input->post('edit_id');
            if ($id == NULL) {
                redirect('task');
            }
            $data['task_details'] = $this->TaskModel->DetailViewTaskDetails($id);
            $data['results'] = $this->TaskModel->updateTaskScreen($id);
            $data['customer_document'] = $this->TaskModel->updateTaskScreenimage($id);
            $data['menu'] = '';
            $data['title'] = 'Task Update View';
            $data['page'] = 'TaskUpdateView';
            $this->load->view("common/CommonView", $data);
        }

        if ($this->input->post('edit')) {
            // echo "edit";
            // exit;
            $session_data = $this->session->userdata('session_data');
            $session_data->form_submit_check = 1;
            $this->session->set_userdata('session_data', $session_data);
            $valid = $this->session->userdata('session_data');
            if ($valid->form_submit_check != 1) {
                redirect('task', 'refresh');
            }
            $id = $this->input->post('edit_id');
            $data['entitycreateFilds'] = $this->TaskModel->taskCustFieldupdate($id);
            $data['resultset'] = $this->TaskModel->typeDetails();
            $data['entityFeilds'] = $this->TaskModel->entityFeilds();
            $data['results'] = $this->TaskModel->typeDetails();
            $data['result'] = $plcode = $this->TaskModel->updateTask($id);
            $data['resultLoc'] = $this->TaskModel->updateTaskLocation($id);
            $data['entityFeilds'] = $this->TaskModel->entityFeilds();
            $data['menu'] = '';
            $data['title'] = 'Task';
            $data['page'] = 'TaskEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data['entityFeilds'] = $this->TaskModel->entityFeilds();
            $data = array('task_status' => 0);
            $aa = $this->TaskModel->editTask($id, $data);
            $sql = $this->db->last_query();
            $this->session->set_flashdata('note_msg', 'Successfully deleted task');
            redirect('task');
        }
        if ($this->input->post('assign')) {
            $data['results'] = $this->TaskModel->typeDetails();
            $data['result'] = $this->TaskModel->updateTask($id);
            $data['resultLoc'] = $this->TaskModel->updateTaskLocation($id);
            $data['entityFeilds'] = $this->TaskModel->entityFeilds();
            $this->session->set_flashdata('note_msg', 'Successfully Assigned tasks');
            $data['menu'] = '';
            $data['title'] = 'Task';
            $data['page'] = 'TaskEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('reassign')) {
            $data['results'] = $this->TaskModel->typeDetails();
            $data['result'] = $this->TaskModel->updateTask($id);
            $data['resultLoc'] = $this->TaskModel->updateTaskLocation($id);
            $data['entityFeilds'] = $this->TaskModel->entityFeilds();
            $this->session->set_flashdata('note_msg', 'Successfully Reassigned tasks');
            $data['menu'] = '';
            $data['title'] = 'Task';
            $data['page'] = 'TaskEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('cancel')) {
            $id = $this->input->post('edit_id');
            $data = array('status_id' => 6);
            $aa = $this->TaskModel->cancelTask($id, $data);
            $sql = $this->db->last_query();
            $this->session->set_flashdata('note_msg', 'Successfully Canceled task');
            redirect('task');
        }
    }

    /* This controller is using for check task name already exists or not */

    public function checkTaskName($task_name) {
        $count = $this->TaskModel->checkTaskName($task_name);
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkTaskName", 'This task name already exists...');
            return FALSE;
        }
    }

    /* This controller is using for display task type */

    public function taskType() {
        $data['result'] = $this->TaskModel->taskType();
        $data['menu'] = '';
        $data['title'] = 'Task Type';
        $data['page'] = 'TaskTypeView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for add task type */

    public function taskType_add() {
        if ($this->input->post('submit')) {
            $task_type = $this->input->post("task_type");
            $task_type_description = $this->input->post("task_type_description");
            $this->form_validation->set_rules('task_type', 'Task Type', 'trim|required|callback_checkTaskType');
            $this->form_validation->set_rules('task_type_description', 'Task Type Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->TaskModel->taskType_add($this->input->post());
                $this->session->set_flashdata('success_msg', 'Successfully created task type');
                redirect('taskType');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Task Type';
        $data['page'] = 'TaskTypeAddView';
        $this->load->view("common/CommonView", $data);
    }

    /* This controller is using for edit and delete task type details */

    public function taskType_update() {
        $id = $this->input->post('edit_id');
        if ($this->input->post('submit')) {
            $task_type = $this->input->post("task_type");
            $task_type_description = $this->input->post("task_type_description");
            $this->form_validation->set_rules('task_type', 'Task Type', 'required');
            $this->form_validation->set_rules('task_type_description', 'Task Type Description', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                $datas = $this->TaskModel->taskType_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated task type');
                redirect('taskType');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        if ($this->input->post('edit')) {
            $data['result'] = $this->TaskModel->taskType_update($id);
            $data['menu'] = '';
            $data['title'] = 'Task Type';
            $data['page'] = 'TaskTypeEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = array('task_type_status' => 0);
            $assetDelete = $this->TaskModel->taskType_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Successfully deleted task type');
            redirect('taskType');
        }
    }

    /* This controller is using for check task type already exists or not  */

    public function checkTaskType($task_type) {
        $count = $this->TaskModel->checkTaskType($task_type);
        if ($count == 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message("checkTaskType", 'This task type already exists...');
            return FALSE;
        }
    }

    public function problemOne() {
        $productline = $this->input->post('productline');
        $data = $this->TaskModel->problemOneModel($productline);
//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
        echo '<option value="">Select</option>';
        foreach ($data as $value) {
            echo '<option value="' . $value['value'] . '">' . $value['value'] . '</option>';
        }
    }

    public function actionCode() {
        $productline = $this->input->post('productline');
        $data = $this->TaskModel->actionCodeModel($productline);
//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
        echo '<option value="">Select</option>';
        foreach ($data as $value) {
            echo '<option value="' . $value['value'] . '">' . $value['value'] . '</option>';
        }
    }

    public function sectionCode() {
        $productline = $this->input->post('productline');
        $data = $this->TaskModel->sectionCodeModel($productline);
//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
        echo '<option value="">Select</option>';
        foreach ($data as $value) {
            echo '<option value="' . $value['value'] . '">' . $value['value'] . '</option>';
        }
    }

    public function problemTwo() {
        $productline = $this->input->post('sn_problem1');
        $data = $this->TaskModel->problemTwoModel($productline);
//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
        echo '<option value="">Select</option>';
        foreach ($data as $value) {
            echo '<option value="' . $value['value'] . '">' . $value['value'] . '</option>';
        }
    }

    public function snLocation() {
        $productline = $this->input->post('sn_problem2');
        $data = $this->TaskModel->snLocationModel($productline);
        echo '<option value="">Select</option>';
        foreach ($data as $value) {
            echo '<option value="' . $value['value'] . '">' . $value['value'] . '</option>';
        }
    }

    public function locationCode() {
        $productline = $this->input->post('section_code');
        $data = $this->TaskModel->locationCodeModel($productline);
        echo '<option value="">Select</option>';
        foreach ($data as $value) {
            echo '<option value="' . $value['value'] . '">' . $value['value'] . '</option>';
        }
    }

    public function form_test() {

        $data['results'] = $this->TaskModel->updateTaskScreen(124);

        echo "<pre>";

        print_r($data);

        $data['menu'] = '';
        $data['title'] = 'Task';
        $data['page'] = 'form';
        //$this->load->view("common/CommonView", $data);
        // $this->load->view("form");
    }

// -start---added some functions--------------------------
    public function maptest() {
        //$this->TaskModel->get_tasklocation();   
        $data['divid'] = $this->input->post('id');
        $data['title'] = 'Task Type';
        $data['page'] = 'googlemaptest';
        $this->load->view("googlemaptest", $data);
    }

    public function loadmap() {
        if ($this->input->post('taskid')) {
            $taskid = $this->input->post('taskid');
        } else {
            $taskid = $this->input->get('taskid');
        }

        $data['showmap'] = $this->TaskModel->get_tasklocation();
        $data['title'] = 'Task Type';
        $data['page'] = 'googlemaptest';
        if ($this->input->post('id')) {
            $data['divID'] = $this->input->post('id');
        } else {
            $data['divID'] = $this->input->get('id');
        }
        $this->load->view("googlemaptest", $data);
    }

    public function taskdetail() {

        if ($this->input->post('id')) {
            $id = $this->input->post('id');
        } else {
            $id = $this->input->get('id');
        }
        if ($this->input->post('tasktypeid')) {
            $tasktypeid = $this->input->post('tasktypeid');
        } else {
            $tasktypeid = $this->input->get('tasktypeid');
        }
        if ($this->input->post('container')) {
            $data['container'] = $this->input->post('container');
        } else {
            $data['container'] = $this->input->get('container');
        }

        // print_r( $data['container']);            exit();

        $data['taskId'] = $id;
        $data['tasktypeid'] = $tasktypeid;
        $data['status_id'] = $this->TaskModel->get_task_status($id);
        $data['document'] = $this->TaskModel->getDocuments($id);
        $data['category'] = $this->TaskModel->getCategories($tasktypeid, $id);
        $data['assets'] = $this->TaskModel->getAssets($id);
        $data['complete'] = $this->TaskModel->getComplete($id);
        $data['tasklocation'] = $this->TaskModel->gettasklocation($id);
        $data['admindata'] = $this->TaskModel->getAdminsection($id);
        $data['attachment'] = $this->TaskModel->getAttachment($id, $tasktypeid);
        $data['showmap'] = $this->TaskModel->get_tasklocation($id);
        //  print_r($data['showmap']['taskallcationfse']);        exit(); 
        //$data['divID'] = $this->input->post('id');
        $d['result'][] = $data;
//        echo "<pre>";
//        print_r($data);
//         echo "string"; exit();
        $this->load->view("taskdetailpanel", $d);
    }

    public function updatereport() {
        if ($this->input->post('name'))
            $fieldname = $this->input->post('name');
        else
            $fieldname = $this->input->get('name');

        if ($this->input->post('id'))
            $id = $data['task_id'] = $this->input->post('id');
        else
            $id = $data['task_id'] = $this->input->get('id');


        $query = $this->db->from('qm_task_report')->where('task_id', $id)->get();
        if ($query->num_rows() > 0) {
            if ($fieldname == 'assignment') {
                $query = $this->db->from('qm_task_report')->where('task_id', $id)->get();
                $re = $query->result_array();
                if ($re[0]['assignmnetinfo'] == 1) {
                    $data['assignmnetinfo'] = 0;
                } else {
                    $data['assignmnetinfo'] = 1;
                }
            }

            if ($fieldname == 'task_operations') {
                $query = $this->db->from('qm_task_report')->where('task_id', $id)->get();
                $re = $query->result_array();
                if (isset($re) && $re[0]['operationinfo'] == 1) {
                    $data['operationinfo'] = 0;
                } else {
                    $data['operationinfo'] = 1;
                }
            }

            if ($fieldname == 'task_location') {
                $query = $this->db->from('qm_task_report')->where('task_id', $id)->get();
                $re = $query->result_array();
                if (isset($re) && $re[0]['locationinfo'] == 1) {
                    $data['locationinfo'] = 0;
                } else {
                    $data['locationinfo'] = 1;
                }
            }

            if ($fieldname == 'create_Information') {
                $query = $this->db->from('qm_task_report')->where('task_id', $id)->get();
                $re = $query->result_array();
                if (isset($re) && $re[0]['createinfo'] == 1) {
                    $data['createinfo'] = 0;
                } else {
                    $data['createinfo'] = 1;
                }
            }

            if ($fieldname == 'update_information') {
                $query = $this->db->from('qm_task_report')->where('task_id', $id)->get();
                $re = $query->result_array();
                if (isset($re) && $re[0]['updateinfo'] == 1) {
                    $data['updateinfo'] = 0;
                } else {
                    $data['updateinfo'] = 1;
                }
            }

            if ($fieldname == 'assets') {
                $query = $this->db->from('qm_task_report')->where('task_id', $id)->get();
                $re = $query->result_array();
                if (isset($re) && $re[0]['assetinfo'] == 1) {
                    $data['assetinfo'] = 0;
                } else {
                    $data['assetinfo'] = 1;
                }
            }

            if ($fieldname == 'attachment') {
                $query = $this->db->from('qm_task_report')->where('task_id', $id)->get();
                $re = $query->result_array();
                if (isset($re) && $re[0]['attachmentinfo'] == 1) {
                    $data['attachmentinfo'] = 0;
                } else {
                    $data['attachmentinfo'] = 1;
                }
            }

            if ($fieldname == 'customerinteraction') {
                $query = $this->db->from('qm_task_report')->where('task_id', $id)->get();
                $re = $query->result_array();
                if (isset($re) && $re[0]['customerinfo'] == 1) {
                    $data['customerinfo'] = 0;
                } else {
                    $data['customerinfo'] = 1;
                }
            }
        } else {
            if ($fieldname == 'assignment') {
                $data['assignmnetinfo'] = 1;
            }
            if ($fieldname == 'task_operations') {
                $data['operationinfo'] = 1;
            }
            if ($fieldname == 'task_location') {
                $data['locationinfo'] = 1;
            }
            if ($fieldname == 'create_Information') {
                $data['createinfo'] = 1;
            }
            if ($fieldname == 'update_information') {
                $data['updateinfo'] = 1;
            }
            if ($fieldname == 'assets') {
                $data['assetinfo'] = 1;
            }
            if ($fieldname == 'attachment') {
                $data['attachmentinfo'] = 1;
            }
            if ($fieldname == 'customerinteraction') {
                $data['customerinfo'] = 1;
            }
        }

        if ($id) {
            $query = $this->db->select('id')->from('qm_task_report')->where('task_id', $id)->get();

            if ($query->num_rows() > 0) {
                $this->db->where('task_id', $id); //which row want to upgrade  
                $this->db->update('qm_task_report', $data);
            } else {
                $this->db->insert('qm_task_report', $data);
            }
        } else {
            return FALSE;
        }
    }

    /* public function taskreporttemplate() {

      $data['taskdetail'] = $taskdata = $this->TaskModel->updateTask(136963);
      $data['tasktype'] = $this->TaskModel->taskType_update($taskdata[0]['task_type_id']);
      $data['document'] = $this->TaskModel->getDocuments($taskdata[0]['id']);
      $data['category'] = $this->TaskModel->getCategories($taskdata[0]['task_type_id']);
      $data['assets'] = $this->TaskModel->getAssets($taskdata[0]['task_type_id']);
      $data['complete'] = $this->TaskModel->getComplete($taskdata[0]['id']);

      $data['menu'] = '';
      $data['title'] = 'Task Type';
      $data['page'] = 'TaskReportTemplateView';
      $this->load->view("common/CommonView", $data);
      } */

    public function savepdf() {

        $admindata = '';
        $data = array();
        if ($this->input->post('tid'))
            $taskid = $this->input->post('tid');
        else
            $taskid = $this->input->get('tid');
//        $taskid = '137588';
        //$taskid='137656'; 
        $data['taskdetail'] = $taskdata = $this->TaskModel->updateTask($taskid);
        $tasktype = $data['tasktype'] = $this->TaskModel->taskType_update($taskdata[0]['task_type_id']);
        $data['category'] = $this->TaskModel->getCategories($taskdata[0]['task_type_id'], $taskid);
        $data['assets'] = $this->TaskModel->getAssets($taskid);
        $data['attachmentdata'] = $this->TaskModel->getAttachment($taskid, $taskdata[0]['task_type_id']);
        $data['complete'] = $this->TaskModel->getComplete($taskdata[0]['id']);
        //$data['document'] = $this->TaskModel->getDocuments($taskdata[0]['id']); 
        $admindata = $this->TaskModel->getAdminsection($taskid);
        //if($admindata){}else{$admindata=$this->TaskModel->getAdminsectionbytasktypeid($taskdata[0]['task_type_id']); }
        if ($admindata) {
            $data['assignment'] = $admindata[0]['assignmnetinfo'];
            $data['task_operations'] = $admindata[0]['operationinfo'];
            $data['task_location'] = $admindata[0]['locationinfo'];
            $data['create_Information'] = $admindata[0]['createinfo'];
            $data['update_information'] = $admindata[0]['updateinfo'];
            $data['adminassets'] = $admindata[0]['assetinfo'];
            $data['attachment'] = $admindata[0]['attachmentinfo'];
            $data['customerinteraction'] = $admindata[0]['customerinfo'];
        } else {
            $data['assignment'] = 0;
            $data['task_operations'] = 0;
            $data['task_location'] = 0;
            $data['create_Information'] = 0;
            $data['update_information'] = 0;
            $data['adminassets'] = 0;
            $data['attachment'] = 0;
            $data['customerinteraction'] = 0;
        }


        if (isset($data['taskdetail'][0]['status_id'])) {
            switch ($data['taskdetail'][0]['status_id']) {
                case 1:
                    $data['status'] = 'Assigned';
                    break;
                case 2:
                    $data['status'] = 'On Hold';
                    break;
                case 3:
                    $data['status'] = 'Accepted';
                    break;
                case 4:
                    $data['status'] = 'Resolved';
                    break;
                case 5:
                    $data['status'] = 'In Progress';
                    break;
                case 6:
                    $data['status'] = "Canceled";
                    break;
                case 7:
                    $data['status'] = "Reject";
                    break;
                default:
                    $data['status'] = "not fount task status";
            }
        }

        if (isset($data['taskdetail'][0]['priority'])) {
            switch ($data['taskdetail'][0]['priority']) {
                case 1:
                    $data['priority_status'] = 'Critical';
                    break;
                case 2:
                    $data['priority_status'] = 'High';
                    break;
                case 3:
                    $data['priority_status'] = 'Moderate';
                    break;
                case 4:
                    $data['priority_status'] = 'Low';
                    break;
                case 5:
                    $data['priority_status'] = 'Planning';
                    break;

                default:
                    $data['priority_status'] = "not fount task priority";
            }
        }
        $webpage = $this->load->view("TaskReportTemplateView", $data, true);
//        print_r($webpage);
//      exit;
        $this->load->library('m_pdf');
        $pdfFilePath = $taskdata[0]['task_name'] . '.PDF';        //actually, you can pass mPDF parameter on this load() function
        $pdf = $this->m_pdf->load();
        $pdf->allow_charset_conversion = true;  // Set by default to TRUE
        $pdf->charset_in = 'UTF-8';
        $pdf->SetDirectionality('rtl');
        $pdf->autoLangToFont = true;
        $pdf->WriteHTML($webpage);
        $pdf->Output($pdfFilePath, "D");
        exit();
        
        //$this->load->view("TaskReportTemplateView", $data);
    }

    public function sendemail11() {

        $data = array();
        $admindata = '';
        $emailArray = array();
        if ($this->input->post('email')) {
            $receiver_email = $this->input->post('email');
        } else {
            $receiver_email = $this->input->get('email');
        }
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
        } else {
            $id = $this->input->get('id');
        }

        $data['taskdetail'] = $taskdata = $this->TaskModel->updateTask($id);
        if ($taskdata) {
            $data['tasktype'] = $this->TaskModel->taskType_update($taskdata[0]['task_type_id']);
            $data['document'] = $this->TaskModel->getDocuments($taskdata[0]['id']);
            $data['category'] = $this->TaskModel->getCategories($taskdata[0]['task_type_id'], $id);
            $data['assets'] = $this->TaskModel->getAssets($id);
            $data['complete'] = $this->TaskModel->getComplete($taskdata[0]['id']);
            $data['attachmentdata'] = $this->TaskModel->getAttachment($id, $taskdata[0]['task_type_id']);
            $this->TaskModel->update_taskreport($taskdata[0]['task_type_id'], $taskdata[0]['ent_id']);
        }
        $admindata = $this->TaskModel->getAdminsection($id);
        //if($admindata){}else{$admindata=$this->TaskModel->getAdminsectionbytasktypeid($taskdata[0]['task_type_id']); }
        if ($admindata) {
            $data['assignment'] = $admindata[0]['assignmnetinfo'];
            $data['task_operations'] = $admindata[0]['operationinfo'];
            $data['task_location'] = $admindata[0]['locationinfo'];
            $data['create_Information'] = $admindata[0]['createinfo'];
            $data['update_information'] = $admindata[0]['updateinfo'];
            $data['adminassets'] = $admindata[0]['assetinfo'];
            $data['attachment'] = $admindata[0]['attachmentinfo'];
            $data['customerinteraction'] = $admindata[0]['customerinfo'];
        } else {
            $data['assignment'] = 0;
            $data['task_operations'] = 0;
            $data['task_location'] = 0;
            $data['create_Information'] = 0;
            $data['update_information'] = 0;
            $data['adminassets'] = 0;
            $data['attachment'] = 0;
            $data['customerinteraction'] = 0;
        }
        if (isset($data['taskdetail'][0]['status_id'])) {
            switch ($data['taskdetail'][0]['status_id']) {
                case 1:
                    $data['status'] = 'Assigned';
                    break;
                case 2:
                    $data['status'] = 'On Hold';
                    break;
                case 3:
                    $data['status'] = 'Accepted';
                    break;
                case 4:
                    $data['status'] = 'Resolved';
                    break;
                case 5:
                    $data['status'] = 'In Progress';
                    break;
                case 6:
                    $data['status'] = "Canceled";
                    break;
                case 7:
                    $data['status'] = "Reject";
                    break;
                default:
                    $data['status'] = "not fount task status";
            }
        }

        if (isset($data['taskdetail'][0]['priority'])) {
            switch ($data['taskdetail'][0]['priority']) {
                case 1:
                    $data['priority_status'] = 'Critical';
                    break;
                case 2:
                    $data['priority_status'] = 'High';
                    break;
                case 3:
                    $data['priority_status'] = 'Moderate';
                    break;
                case 4:
                    $data['priority_status'] = 'Low';
                    break;
                case 5:
                    $data['priority_status'] = 'Planning';
                    break;

                default:
                    $data['priority_status'] = "not fount task priority";
            }
        }


        $webpage = $this->load->view("TaskReportTemplateView", $data, true);
        //print_r($webpage);
        //exit;
        $this->load->library('m_pdf');
        $file_name = $taskdata[0]['task_name'] . '.PDF';
        $pdf = $this->m_pdf->load();
        $pdf->allow_charset_conversion = true;
        $pdf->charset_in = 'UTF-8';
        $pdf->SetDirectionality('rtl');
        $pdf->autoLangToFont = true;
        $pdf->WriteHTML($webpage);
        $pdfdoc = $pdf->Output($file_name, "S");
        file_put_contents(APPPATH . '/attachment/' . $file_name, $pdfdoc);
        $getemail = implode(',', $receiver_email);

        $emailArray = explode(',', $getemail);

        foreach ($emailArray as $emailhistory) {
            $singleemail = $emailhistory;
            $result = $this->TaskModel->report_history($taskdata, $singleemail);
            $config['useragent'] = 'CodeIgniter';
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://smtp.googlemail.com';
            $config['smtp_user'] = 'mitroz.padamm@gmail.com'; // Your gmail id
            $config['smtp_pass'] = 'maher0122'; // Your gmail Password
            $config['smtp_port'] = 465;
            $config['wordwrap'] = TRUE;
            $config['wrapchars'] = 76;
            $config['mailtype'] = 'html';
            $config['charset'] = 'iso-8859-1';
            $config['validate'] = FALSE;
            $config['priority'] = 3;
            $config['newline'] = "\r\n";
            $config['crlf'] = "\r\n";

            $this->load->library('email');
            $this->email->initialize($config);

            $this->email->from('mitroz.padamm@gmail.com', 'WorkWide');
            $this->email->to($singleemail);
            //$this->email->cc('trimantra@gmail.com'); 
            $this->email->attach(APPPATH . '/attachment/' . $file_name);
            $this->email->subject('Task Status');
            $this->email->message('WorkWide Task Report Status.');
            if (!$this->email->send()) {
                $a = 0;
            } else {

                $a = 1;
            }
//            $form_name = 'ABC';
//            $enquirer_name = "Quintica";
//            $company_name = "Work Wide";
//            $retype = ucfirst(strtolower("SSS"));
//            $enquirer_email = "mitroz.padamm@gmail.com";
//            $country = "india";
//            $contact = "123698";
//                $subject_title = "Email from Quintica credentials " ;
//            $mail_body = 'Task Report';
//            $mail = new PHPMailer();
//            //$mail->IsSendmail(); // send via SMTP
//            $mail->IsSMTP();
//            $mail->SMTPDebug  = 0;
//            //Ask for HTML-friendly debug output
//            $mail->Debugoutput = 'html';
//            //Set the hostname of the mail server
//            $mail->SMTPAuth = true; // turn on SMTP authentication
//
//
//            $mail->Username = "mitroz.padamm@gmail.com"; // SMTP username
//            $mail->Password = "maher0122"; // SMTP password
//            $webmaster_email = "mitroz.padamm@gmail.com"; //Reply to this email ID
//            //$mail->SMTPSecure = 'ssl';
//            $mail->Port = "587";
//            $mail->Host = 'smtp.gmail.com'; //hostname
//
//            $receiver_email = $singleemail;
//            $email = $receiver_email; // Recipients email ID //inquiry@mindworx.in
//
//            $name = "Work Wide"; // Recipient's name
//
//
//            $mail->From = $enquirer_email;
//            $mail->FromName = $enquirer_name;
//            $mail->AddAddress($email, $name);
//            $mail->AddReplyTo($enquirer_email, $enquirer_name);
//             $mail->AddAttachment(APPPATH.'/attachment/'.$file_name);
//            $mail->WordWrap = 50; // set word wrap
//            $mail->IsHTML(false); // send as HTML
//            $mail->Subject = $subject_title;
//            $mail->MsgHTML($mail_body);
//            $mail->AltBody = "This is the body when user views in plain text format"; //Text Body
//            if (!$mail->Send()) {
//               // echo "Mailer Error: " . $mail->ErrorInfo;
//                 $a=0;
//            } else {
//
//               $a=1;
//            }
        }

        if ($a == 0) {
            echo $a;
        } else {
            echo $a;
        }
    }

    function send_android_push($fseid = NULL, $insert = NULL, $taskId = NULL) {

        //exit();
        // echo "test";
        if ($fseid == NULL) {
            // return;
        }
        if ($insert == NULL) {
            // return;
        }
        if ($taskId == NULL) {
            //return;
        }
        $registrationIds = $this->MY_Model->getFseDeviceID($fseid);

        //print_r($registrationIds->fse_device_id);


        if (isset($registrationIds->fse_device_id)) {
            $registrationIdss = $registrationIds->fse_device_id;
            if ($registrationIdss == "") {
                
            }
        } else {
            return;
        }
        if (isset($insert['status_id'])) {
            $status_id = $insert['status_id'];
        } else {
            $status_id = 1;
        }
        $device_token = $registrationIds->fse_device_id;
        $status_types = $this->MY_Model->getGoogleStatustypes($status_id);
        if (isset($status_types->status_type)) {
            $status_types = $status_types->status_type;
        } else {
            $status_types = "Assigned";
        }
        if (isset($insert['taskDescription'])) {
            $task_description = $insert['taskDescription'];
        } else {
            $task_description = "New Task";
        }
        if (isset($insert['taskLocationAddress'])) {
            $task_address = $insert['taskLocationAddress'];
        } else {
            $task_address = "New Task";
        }
        if (isset($insert['taskTitle'])) {
            $task_name = $insert['taskTitle'];
        } else {
            $task_name = "New Task";
        }


        $registrationIds = $registrationIds->fse_device_id;
        $status_types = $this->MY_Model->getGoogleStatustypes($status_id);
        $status_types = $status_types->status_type;
        $message = "Task Description " . $task_description . '. Task Status ' . $status_types . '. Task Address ' . $task_address;

        $table = QM_MOBILE_NOTIFICATION;
        $data = array('task_id' => $taskId,
            'fse_id' => $fseid,
            'message' => $message,
            'title' => $task_name,
            'status_types' => $status_types,
            'status_id' => $status_id
        );

        $this->MY_Model->InsertPushNotification($table, $data, $taskId);

        $msg = array
            (
            'body' => "Task Description " . $task_description . '. Task Status ' . $status_types . '. Task Address ' . $task_address,
            'title' => $task_name,
            'taskId' => $taskId,
            'status_types' => $status_types,
            'status_id' => $status_types,
            'icon' => 'myicon', /* Default Icon */
            'sound' => 'mySound'/* Default sound */
        );

        $fields = array
            (
            'to' => 'd-zNQXKQx0o:APA91bHxpYYVdRZRiGStQeHZ1M3-9RyT7eX9jzbTTsySn74jOAW1arULB17HDMyk6Ho3rZdzlOTBGG6J3Sgy47UfIRvOTioFFstKjoO4elgV0xYimLrCFpinwgZEu-jzZWfj9e4svLBMk7Fs8sIxsZXmXQ7lQwP3_w',
            'notification' => $msg
        );


        $headers = array
            (
            'Authorization: key=' . ANDROID_API_ACCESS_KEY_FOR_PUSH_NOTIFICATION,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

//        echo $result;
//        exit();
    }

    //Android push notification
    public function send_ios_push($fseid = NULL, $insert = NULL, $taskId = NULL) {

        if ($fseid == NULL) {
            return;
        }
        if ($insert == NULL) {
            return;
        }
        if ($taskId == NULL) {
            return;
        }
        $registrationIds = ($this->TaskModel->getFseDeviceID($fseid));
        if (!isset($registrationIds->fse_device_id)) {
            return;
        }
        if (isset($insert['status_id'])) {
            $status_id = $insert['status_id'];
        } else {
            $status_id = 1;
        }
        $device_token = $registrationIds->fse_device_id;
        $status_types = $this->TaskModel->getGoogleStatustypes($status_id);
        if (isset($status_types->status_type)) {
            $status_types = $status_types->status_type;
        } else {
            $status_types = "Assigned";
        }
        if (isset($insert['task_description'])) {
            $task_description = $insert['taskDescription'];
        } else {
            $task_description = "New Task";
        }
        if (isset($insert['taskLocationAddress'])) {
            $task_address = $insert['taskLocationAddress'];
        } else {
            $task_address = "New Task";
        }
        if (isset($insert['taskTitle'])) {
            $task_name = $insert['taskTitle'];
        } else {
            $task_name = "New Task";
        }
        $message = "Task Description " . $task_description . '. Task Status ' . $status_types . '. Task Address ' . $task_address;
        $table = QM_MOBILE_NOTIFICATION;
        $data = array('task_id' => $taskId,
            'fse_id' => $fseid,
            'message' => $message,
            'title' => $task_name,
            'status_types' => $status_types,
            'status_id' => $status_id
        );
        $this->TaskModel->InsertPushNotification($table, $data, $taskId);
        // $this->MY_Model->InsertData($table, $data);
        // Put your private key's passphrase here:
        $passphrase = 'cgvak123';

        ////////////////////////////////////////////////////////////////////////////////
        $dirName = dirname(__FILE__);
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $dirName . '/Certificates.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        // Open a connection to the APNS server

//        $fp = stream_socket_client(
//                'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

    $fp = stream_socket_client(
        'ssl://gateway.push.apple.com:2195', $err,
        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

        //echo 'Connected to APNS' . PHP_EOL;
        // Create the payload body
        /* $body['aps'] = array(
          'alert' => $message,
          'sound' => 'default'
          ); */

        $body = array(
            'aps' => array(
                'alert' => $message,
                'sound' => 'default'
            ),
            'status_types' => $status_types,
            'status_id' => $status_id,
        );

        // Encode the payload as JSON
        $payload = json_encode($body);

        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $device_token) . pack('n', strlen($payload)) . $payload;

        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));


        //   print_r($payload);
//    if (!$result)
//        echo 'Message not delivered' . PHP_EOL;
//    else
//        echo 'Message successfully delivered' . PHP_EOL;
        // Close the connection to the server
        fclose($fp);
    }

    public function sendnew() {
        $deviceToken = '0608bc5f2ed1f91c6d1426fbf3ac668cacae86a612b0a793593503e6b4fb9c8b'; //  iPad 5s Gold prod
        $passphrase = 'QuinticaPassword@1';
        //'zFaMRvDh7vGTPqh3k+72uz0SzOh3knVZc99OPqkJ3llbYWbpQnRNAKY7TGJu7kg8'; //QuinticaPassword@1
        $message = 'Hello Push Notification';
        $dirName = dirname(__FILE__);
//            echo $dirName.'/Certificates.pem';
        $ctx = stream_context_create();
        //stream_context_set_option($ctx, 'ssl', 'local_cert', 'E:\pros\quintica\application\controllers\Certificates.pem'); // Pem file to generated // openssl pkcs12 -in pushcert.p12 -out pushcert.pem -nodes -clcerts // .p12 private key generated from Apple Developer Account
        stream_context_set_option($ctx, 'ssl', 'local_cert', $dirName . '/Certificates.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

//            $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); // production
        $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx); // developement
        echo "<p>Connection Open</p>";
        if (!$fp) {
            exit("Failed to connect: $err $errstr" . PHP_EOL);
            echo "<p>Failed to connect!<br />Error Number: " . $err . " <br />Code: " . $errstrn . "</p>";
            return;
        } else {
            echo "<p>Sending notification!</p>";
        }
        $body['aps'] = array('alert' => $message, 'sound' => 'default', 'extra1' => '10', 'extra2' => 'value');
        $payload = json_encode($body);
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
        //var_dump($msg)
        $result = fwrite($fp, $msg, strlen($msg));
        if (!$result)
            echo '<p>Message not delivered ' . PHP_EOL . '!</p>';
        else
            echo '<p>Message successfully delivered ' . PHP_EOL . '!</p>';
        fclose($fp);
    }

    public function sendios() {
        $deviceToken = '9e9155219fd6606a96e8a67d21a2108e936adfebb5ad16057506acc963313d0a';
//$deviceToken = '44fb58e8011392a1569ddc73ff96d028b5d78739258678455a16abf4e55fa1c1';
// Put your private key's passphrase here:
        $passphrase = 'zFaMRvDh7vGTPqh3k+72uz0SzOh3knVZc99OPqkJ3llbYWbpQnRNAKY7TGJu7kg8';

// Put your alert message here:
        $message = 'Thank you for Trying Arial 1. Do not forget to enter your feedback to earn TNB points within 10 days';

////////////////////////////////////////////////////////////////////////////////
        $dirName = dirname(__FILE__);
        $ctx = stream_context_create();

        stream_context_set_option($ctx, 'ssl', 'local_cert', $dirName . '/Certificates.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
        $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);
    }

    public function send() {
        // Build the payload
        $payload['aps'] = array('alert' => 'hello', 'badge' => '3', 'sound' => 'default');
        $payload = json_encode($payload);
        $idd = '9e9155219fd6606a96e8a67d21a2108e936adfebb5ad16057506acc963313d0a';
        $port = 2195;
        $host = 'gateway.sandbox.push.apple.com';
        $dirName = dirname(__FILE__);
//        $ctx = stream_context_create();
        $stream_context = stream_context_create();
        //stream_context_set_option($ctx, 'ssl', 'local_cert', $dirName . '/Certificates.pem');
        stream_context_set_option($stream_context, 'ssl', 'local_cert', $dirName . '/Certificates.pem');
        $apns = stream_socket_client('ssl://' . $host . ':' . $port, $error, $error_string, 2, STREAM_CLIENT_CONNECT, $stream_context);
        $message = chr(0) . chr(0) . chr(32) . pack('H*', $idd) . chr(0) . chr(strlen($payload)) . $payload;
//                $msg = chr(0) . pack('n', 32) . pack('H*', $device_token) . pack('n', strlen($payload)) . $payload;
        fwrite($apns, $message);
        //socket_close($apns);
        echo $dirName . '/Certificates.pem';
//                print_r($stream_context);
        fclose($apns);
    }

// -end---added some functions--------------------------    
//    function  sendemailtest(){      //  echo 'ssss';        exit(); 
    public function sendemail() {

        $data = array();
        $admindata = '';
        $emailArray = array();
        if ($this->input->post('email')) {
            $receiver_email = $this->input->post('email');
        } else {
            $receiver_email = $this->input->get('email');
        }
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
        } else {
            $id = $this->input->get('id');
        }

        $data['taskdetail'] = $taskdata = $this->TaskModel->updateTask($id);
        if ($taskdata) {
            $data['tasktype'] = $this->TaskModel->taskType_update($taskdata[0]['task_type_id']);
            $data['document'] = $this->TaskModel->getDocuments($taskdata[0]['id']);
            $data['category'] = $this->TaskModel->getCategories($taskdata[0]['task_type_id'], $id);
            $data['assets'] = $this->TaskModel->getAssets($id);
            $data['complete'] = $this->TaskModel->getComplete($taskdata[0]['id']);
            $data['attachmentdata'] = $this->TaskModel->getAttachment($id, $taskdata[0]['task_type_id']);
            $this->TaskModel->update_taskreport($taskdata[0]['task_type_id'], $taskdata[0]['ent_id']);
        }
        $admindata = $this->TaskModel->getAdminsection($id);
        //if($admindata){}else{$admindata=$this->TaskModel->getAdminsectionbytasktypeid($taskdata[0]['task_type_id']); }
        if ($admindata) {
            $data['assignment'] = $admindata[0]['assignmnetinfo'];
            $data['task_operations'] = $admindata[0]['operationinfo'];
            $data['task_location'] = $admindata[0]['locationinfo'];
            $data['create_Information'] = $admindata[0]['createinfo'];
            $data['update_information'] = $admindata[0]['updateinfo'];
            $data['adminassets'] = $admindata[0]['assetinfo'];
            $data['attachment'] = $admindata[0]['attachmentinfo'];
            $data['customerinteraction'] = $admindata[0]['customerinfo'];
        } else {
            $data['assignment'] = 0;
            $data['task_operations'] = 0;
            $data['task_location'] = 0;
            $data['create_Information'] = 0;
            $data['update_information'] = 0;
            $data['adminassets'] = 0;
            $data['attachment'] = 0;
            $data['customerinteraction'] = 0;
        }
        if (isset($data['taskdetail'][0]['status_id'])) {
            switch ($data['taskdetail'][0]['status_id']) {
                case 1:
                    $data['status'] = 'Assigned';
                    break;
                case 2:
                    $data['status'] = 'On Hold';
                    break;
                case 3:
                    $data['status'] = 'Accepted';
                    break;
                case 4:
                    $data['status'] = 'Resolved';
                    break;
                case 5:
                    $data['status'] = 'In Progress';
                    break;
                case 6:
                    $data['status'] = "Canceled";
                    break;
                case 7:
                    $data['status'] = "Reject";
                    break;
                default:
                    $data['status'] = "not fount task status";
            }
        }

        if (isset($data['taskdetail'][0]['priority'])) {
            switch ($data['taskdetail'][0]['priority']) {
                case 1:
                    $data['priority_status'] = 'Critical';
                    break;
                case 2:
                    $data['priority_status'] = 'High';
                    break;
                case 3:
                    $data['priority_status'] = 'Moderate';
                    break;
                case 4:
                    $data['priority_status'] = 'Low';
                    break;
                case 5:
                    $data['priority_status'] = 'Planning';
                    break;

                default:
                    $data['priority_status'] = "not fount task priority";
            }
        }

        $webpage = $this->load->view("TaskReportTemplateView", $data, true);
        //print_r($webpage);
        //exit;
        $this->load->library('m_pdf');
        $file_name = $taskdata[0]['task_name'] . '.PDF';
        $pdf = $this->m_pdf->load();
        $pdf->allow_charset_conversion = true;
        $pdf->charset_in = 'UTF-8';
        $pdf->SetDirectionality('rtl');
        $pdf->autoLangToFont = true;
        $pdf->WriteHTML($webpage);
        $pdfdoc = $pdf->Output($file_name, "S");
        file_put_contents(DOCUMENT_STORE_PATH . $file_name, $pdfdoc);
        $getemail = implode(',', $receiver_email);

        $emailArray = explode(',', $getemail);
//       
        foreach ($emailArray as $emailhistory) {
            $singleemail = $emailhistory;
            $result = $this->TaskModel->report_history($taskdata, $singleemail);
//             $form_name = 'ABC';
//             $enquirer_name = "Quintica";
//             $company_name = "Work Wide";
//             $retype = ucfirst(strtolower("SSS"));
//             $enquirer_email = "Workwidemobile@quintica.com";
//             $country = "india";
//             $contact = "123698";
//             $subject_title = "Email from Quintica credentials ";
//             $mail_body = 'Task Report';
//             $mail = new PHPMailer();
//             //$mail->IsSendmail(); // send via SMTP
//             $mail->IsSMTP();
//             $mail->SMTPDebug = 0;
//             //Ask for HTML-friendly debug output
//             $mail->Debugoutput = 'html';
//             //Set the hostname of the mail server
//             $mail->SMTPAuth = true; // turn on SMTP authentication


//             $mail->Username = "Workwidemobile@quintica.com"; // SMTP username
//             $mail->Password = "Qu1ntic@"; // SMTP password
//             $webmaster_email = "Workwidemobile@quintica.com"; //Reply to this email ID
//             //$mail->SMTPSecure = 'ssl';
//             $mail->Port = "587";
//             $mail->Host = 'smtp.office365.com'; //hostname

//             $receiver_email = $singleemail;
// //                    \$singleemail;
// //                    $singleemail;
//             $email = $receiver_email; // Recipients email ID //inquiry@mindworx.in

//             $name = "Work Wide"; // Recipient's name


//             $mail->From = $enquirer_email;
//             $mail->FromName = $enquirer_name;
//             $mail->AddAddress($email, $name);
//             $mail->AddReplyTo($enquirer_email, $enquirer_name);
//             $mail->AddAttachment(DOCUMENT_STORE_PATH . $file_name);
//             $mail->WordWrap = 50; // set word wrap
//             $mail->IsHTML(false); // send as HTML
//             $mail->Subject = $subject_title;
//             $mail->MsgHTML($mail_body);
//             $mail->AltBody = "This is the body when user views in plain text format"; //Text Body
//             if (!$mail->Send()) {
//                 $a = 0;
//             } else {
//                 $a = 1;
//             }
//         }

//---------------------------------------------------
                   $form_name = 'ABC';
           $enquirer_name = "Quintica";
           $company_name = "Work Wide";
           $retype = ucfirst(strtolower("SSS"));
           $enquirer_email = "mitroz.padamm@gmail.com";
           $country = "india";
           $contact = "123698";
               $subject_title = "Email from Quintica credentials " ;
           $mail_body = 'Task Report';
           $mail = new PHPMailer();
           //$mail->IsSendmail(); // send via SMTP
           $mail->IsSMTP();
           $mail->SMTPDebug  = 0;
           //Ask for HTML-friendly debug output
           $mail->Debugoutput = 'html';
           //Set the hostname of the mail server
           $mail->SMTPAuth = true; // turn on SMTP authentication


           $mail->Username = "mitroz.padamm@gmail.com"; // SMTP username
           $mail->Password = "maher0122"; // SMTP password
           $webmaster_email = "mitroz.padamm@gmail.com"; //Reply to this email ID
           //$mail->SMTPSecure = 'ssl';
           $mail->Port = "587";
           $mail->Host = 'smtp.gmail.com'; //hostname

           $receiver_email = $singleemail;
           $email = $receiver_email; // Recipients email ID //inquiry@mindworx.in

           $name = "Work Wide"; // Recipient's name



  //$mail->From = $enquirer_email;
//             $mail->FromName = $enquirer_name;
//             $mail->AddAddress($email, $name);
//             $mail->AddReplyTo($enquirer_email, $enquirer_name);
//             $mail->AddAttachment(DOCUMENT_STORE_PATH . $file_name);
//             $mail->WordWrap = 50; // set word wrap
//             $mail->IsHTML(false); // send as HTML
//             $mail->Subject = $subject_title;
//             $mail->MsgHTML($mail_body);
//             $mail->AltBody = "This is the body when user views in plain text format"; //Text Body


           $mail->From = $enquirer_email;
           $mail->FromName = $enquirer_name;
           $mail->AddAddress($email, $name);
           $mail->AddReplyTo($enquirer_email, $enquirer_name);
            $mail->AddAttachment(DOCUMENT_STORE_PATH.$file_name);
           $mail->WordWrap = 50; // set word wrap
           $mail->IsHTML(false); // send as HTML
           $mail->Subject = $subject_title;
           $mail->MsgHTML($mail_body);
           $mail->AltBody = "This is the body when user views in plain text format"; //Text Body
           if (!$mail->Send()) {
              // echo "Mailer Error: " . $mail->ErrorInfo;
                $a=0;
           } else {

              $a=1;
           }
//---------------------------------------------------        

//        echo $a;

        if ($a == 0) {
            echo $a;
        } else {
            echo $a;
             unlink(DOCUMENT_STORE_PATH . $file_name); 
        }
      }
    }

}
