<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class EntitySettingController extends MY_Controller {


/* --- old code -------
    function __construct() {
        parent::__construct();
        $this->load->model("EntitySettingModel");
    }
 ---- new code as follows
 */ 
 
    function __construct() {
        parent::__construct();
        $this->load->model("EntitySettingModel");
         $this->load->model("ManagementModel");
        
    }

    public function index() {

        $data['menu'] = '';
        $data['title'] = 'Categories';
        $data['page'] = 'CategoriesView';

        $this->load->view("common/CommonView", $data);
    }

    public function category() {

        $data['result'] = $this->EntitySettingModel->getCategory();
        $data['menu'] = '';
        $data['title'] = 'Categories';
        $data['page'] = 'CategoryView';
        $this->load->view("common/CommonView", $data);
    }

    public function category_add() {
        if ($this->input->post('submit')) {
            $ent_id = $this->input->post("ent_id");
            $category = $this->input->post("category");
            $this->form_validation->set_rules('ent_id', 'Entity', 'trim|required');
            $this->form_validation->set_rules('category', 'Category', 'required');
            if ($this->form_validation->run() == TRUE) {
                $this->EntitySettingModel->category_add($this->input->post());
                $this->session->set_flashdata('success_msg', 'Successfully created Category');
                redirect('category');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        $this->load->model('ManagementModel');
        $data['result'] = $this->ManagementModel->company();
        $data['post'] = $this->input->post();
        $data['menu'] = '';
        $data['title'] = 'Categories';
        $data['page'] = 'CategoryAddView';
        $this->load->view("common/CommonView", $data);
    }

    public function category_update() {
        $id = $this->input->post('edit_id');
        if ($this->input->post('submit')) {
            $ent_id = $this->input->post("ent_id");
            $category = $this->input->post("category");
            $this->form_validation->set_rules('ent_id', 'Entity', 'required');
            $this->form_validation->set_rules('category', 'Category', 'required');
            if ($this->form_validation->run() == TRUE) {
                $data = $this->input->post();
                $datas = $this->EntitySettingModel->category_edit($this->input->post('id'), $data);
                $this->session->set_flashdata('success_msg', 'Successfully updated category');
                redirect('category');
            } else {
                $this->session->set_flashdata('error_msg', 'Could not be add ! Please try again');
            }
        }
        if ($this->input->post('edit')) {
            $data['result'] = $this->EntitySettingModel->category_update($id);
            $this->load->model('ManagementModel');
            $data['entities'] = $this->ManagementModel->company();
            $data['menu'] = '';
            $data['title'] = 'Categories';
            $data['page'] = 'CategoryEditView';
            $this->load->view("common/CommonView", $data);
        }
        if ($this->input->post('delete')) {
            $id = $this->input->post('edit_id');
            $data = array('category_status' => 0);
            $assetDelete = $this->EntitySettingModel->category_edit($id, $data);
            $this->session->set_flashdata('note_msg', 'Successfully deleted category');
            redirect('category');
        }
    }

    public function task_sheet() {
        $ent_id = $this->input->post("ent_id");
        if (isset($ent_id)) {
            $data['menu'] = '';
            $data['title'] = 'Task Sheet';
            $data['page'] = 'TaskSheet';
            $data['ent_id'] = $this->input->post("ent_id");
            $this->load->view("common/CommonView", $data);
        } else {
            redirect('entity');
        }
    }

    public function add_category() {
        $data = array();
        $category = $this->input->post("category");
        $ent_id = $this->input->post("ent_id");
        $task_type = $this->input->post("task_type");
        if (isset($category) && isset($ent_id)) {
            $categoryData = array();
            $categoryData['category'] = $category;
            $categoryData['ent_id'] = $ent_id;
            $categoryData['task_type'] = $task_type;
            $isUnique = $this->EntitySettingModel->checkUnique(QM_CATEGORY, $categoryData);
            if ($isUnique) {
                $data['error'] = 'Category name is already existed!';
            } else {
                $categoryData['id'] = $this->EntitySettingModel->category_add($categoryData);
                $categoryData['success'] = 'Category has been added successfully!';
                $data = $categoryData;
            }
        } else {
            $data['error'] = 'Something went wrong! Please try again!';
        }

        echo json_encode($data);
    }

    public function add_fsetype() {
        $data = array();
        $fse_type_id = $this->input->post("fse_type_id");
        $ent_id = $this->input->post("ent_id");
        $task_type = $this->input->post("task_type");

        $fse_type_Data = array();
        $fse_type_Data['fse_type_id'] = $fse_type_id;
        $fse_type_Data['ent_id'] = $ent_id;
        $fse_type_Data['isactive'] = 1;
        $fse_type_Data['task_type'] = $task_type;
        $fse_type_Data['id'] = $this->EntitySettingModel->fsetype_add($fse_type_Data);
    }

    public function get_category() {
        $data = array();
        $ent_id = $this->input->get('ent_id');
        if (isset($ent_id)) {
            $data['result'] = $this->EntitySettingModel->getCategory($ent_id);
        } else {
            $data['error'] = 'Something went wrong! Please try again!';
        }

        echo json_encode($data);
    }

    public function update_category() {
        $data = array();
        $cat_id = $this->input->post('cat_id');
        $remove_status = $this->input->post('rem');
        $separate_update_screen = $this->input->post('separate_update_screen');
        if (isset($cat_id) && isset($separate_update_screen)) {
            $catData = array();
            if (isset($remove_status) && !empty($remove_status)) {
                $catData['category_status'] = 0;
            } else {
                $catData['separate_update_screen'] = $separate_update_screen;
            }
            $this->EntitySettingModel->category_edit($cat_id, $catData);
            if (isset($remove_status) && !empty($remove_status)) {
                $data['success'] = 'Category has been deleted successfully!';
            } else {
                $data['success'] = 'Category has been updated successfully!';
            }
        } else {
            $data['error'] = 'Something went wrong! Please try again!';
        }

        echo json_encode($data);
    }

    public function update_fsetype() {
        $data = array();
        $fse_type_id = $this->input->post('fse_type_id');
        $ent_id = $this->input->post('ent_id');
        $task_type = $this->input->post('task_type');

        $fseData['isactive'] = 0;

        $this->EntitySettingModel->update_fsetype($fse_type_id, $ent_id, $task_type, $fseData);
    }
    
    public function saveReportFields() {     
        $field_name = $this->input->post('field_name');
        $ent_id = $this->input->post('ent_id');
        $task_type = $this->input->post('task_type_tbl_id');
        $task_report_id = $this->input->post('task_report_id');
        $updatedstatus = $this->input->post('updatedstatus');
        $flagstatus = $this->input->post('flagstatus');
        $newtask_or_not=$this->input->post('newtask_or_not');
        $this->EntitySettingModel->insert_or_update_reportFields($field_name, $ent_id, $task_type, $updatedstatus,$flagstatus,$task_report_id,$newtask_or_not);
        exit;
    }
    
// Start -------------******* save dropdown task report emails --------------------------
    public function saveTaskEmailReportFields() { 
//        echo "1";
        if(empty($this->input->post('actiontype')))
        {   
        $field_name = $this->input->post('field_name');
        $ent_id = $this->input->post('ent_id');
        $task_type = $this->input->post('task_type');
        
        $EmailFieldsId = $this->input->post('EmailFieldsId');
        $createdEmailfieldsTextName = $this->input->post('createdEmailfieldsTextName');
        $Reportid = $this->input->post('Reportid');
        
        }
        else
        {
            
            $EmailFieldsId = $this->input->post('EmailFieldsId');
            $actiontype = $this->input->post('actiontype');
             $createdEmailfieldsTextName='';
             $field_name='';
             $ent_id='';
             $task_type='';
             $Reportid='';
            
        }
        $this->EntitySettingModel->insert_or_update_EmailreportFields($EmailFieldsId, $createdEmailfieldsTextName, $field_name, $ent_id, $task_type,$Reportid,$actiontype);
//        EmailFieldsId: EmailFieldsId, createdEmailfieldsTextName : createfieldslabelsText, field_name: field_name, ent_id: ent_id, task_type: task_type
    }
// End -------------******* save dropdown task report emails --------------------------    
    public function saveReportFlag() {
        $data = array (
            'report_flag' => 1
        );
        $ent_id = $this->input->post('ent_id');
        $task_type = $this->input->post('task_type');
        $this->EntitySettingModel->update_reportflag($data, $ent_id, $task_type);
    }


    /*     * ***********  ChinnaRasu  ************ */
    

   public function create_not_integrated() {

        $ent_id = $this->input->post('ent_id');
        if (!empty($ent_id)) {
            $data = array(
                'ent_id' => $this->input->post('ent_id'),
                'Ext_att_name' => $this->input->post('label'),
                'Ext_att_type' => $this->input->post('field_type'),
                'Ext_att_size' => $this->input->post('limit'),
                'Ext_att_category_id' => $this->input->post('category'),
//                'Extra_attr_control' => $this->input->post('create_attri_control'),
                'Task_type_ID' => $this->input->post('task_id'),
                'extra_attr_option' => $this->input->post('value'),
                'dependent_value' => $this->input->post('dependent_value'),
                'qm_status_type_id' => 1,
                'qm_attr_addupdate_value'=>$this->input->post('create_addupdate_value')
            );

            $data_check = array(
                'ent_id' => $this->input->post('ent_id'),
                'Ext_att_name' => $this->input->post('label'),
                //     'Ext_att_type' => $this->input->post('field_type'),
                //     'Ext_att_size' => $this->input->post('limit'),
                //    'Ext_att_category_id' => $this->input->post('category'),
//                'Extra_attr_control' => $this->input->post('create_attri_control'),
                'Task_type_ID' => $this->input->post('task_id'),
                'qm_status_type_id' => 1
            );

            $check = $this->EntitySettingModel->checkUnique(QM_EXTRA_ATTR_DEFINITION, $data_check);
            if ($check == FALSE) {
                $data['extr_att_id'] = $this->EntitySettingModel->create_not_integrated($data);
                $data['success'] = 'Label has been added successfully!';
            } else {
                $data['error'] = 'Already exits in field list!';
            }
        } else {
            $data['error'] = 'Something went wrong! Please try again!';
        }

        echo json_encode($data);
    }

/* **** new code ************************** */    
    public function attachment_not_integrated() {

        $ent_id = $this->input->post('ent_id');
       
        if (!empty($ent_id)) {
/*            $data = array(
                'ent_id' => $this->input->post('ent_id'),
                'Atch_att_name' => $this->input->post('label'),
                'Atch_att_type' => $this->input->post('field_type'),
                'Atch_att_size' => $this->input->post('limit'),
                'Atch_att_category_id' => $this->input->post('category'),
//                'Attachment_attr_control' => $this->input->post('create_attri_control'),s
                'Task_type_ID' => $this->input->post('task_id'),
                'attachment_attr_option' => $this->input->post('value'),
                'dependent_value' => $this->input->post('dependent_value'),
                'qm_status_type_id' => 1,
                'attachment_mandatory'=>''
            );
*/   
            $current_date=date('Y-m-d H:i:s');
            $data = array(  'ent_id' => $this->input->post('ent_id'),
                            'task_type'=> $this->input->post('task_id'),    
                            'label' => $this->input->post('label'),
                            'option_type' => $this->input->post('field_type'),
                            'depondon'=>'',
                            'depondid'=>'',
                            'type_limit' => $this->input->post('limit'),
                            'category_id' => $this->input->post('category'),
                            'required_status'=>$this->input->post('attachment_mandatory'),
                            'type_values'=> $this->input->post('value'),
                            'api_data'=>'',
                            'map_data'=>'',
                            'created_date'=>$current_date
                        );

            $data_check = array(
                'ent_id' => $this->input->post('ent_id'),
                'label' => $this->input->post('label'),
                //     'Ext_att_type' => $this->input->post('field_type'),
                //     'Ext_att_size' => $this->input->post('limit'),
                //    'Ext_att_category_id' => $this->input->post('category'),
//                'Extra_attr_control' => $this->input->post('create_attri_control'),
                'task_type' => $this->input->post('task_id')                
            );
//            qm_attachment_attr_definition
//                qm_attachment_attr_update
            $check = $this->EntitySettingModel->checkUnique(QM_ATTACHMENT_ATTR_UPDATE, $data_check);
            if ($check == FALSE) {
                $data['attch_att_update_id'] = $this->EntitySettingModel->create_Attchment_not_integrated($data);
                $data['success'] = 'Label has been added successfully!';
            } else {
                $data['error'] = 'Already exits in field list!';
            }
        } else {
            $data['error'] = 'Something went wrong! Please try again!';
        }

        echo json_encode($data);
    }
/* ****end  new code ************************** */
    public function create_integrated() {

        $ent_id = $this->input->post('ent_id');
        if (!empty($ent_id)) {

        if ($this->input->post('tab_id') == 2 ) {

                $str = md5($this->input->post('task_type_id') . $this->input->post('ent_id') . $this->input->post('tab_id') . date('m/d/Y h:i:s a', time()));
                $data_show = array(
                    "apiKey" => $str,
                    "fseEmail" => "fseemail@mail.com",
                    "task_name" => "fixing Example",
                    "priority" => "HIGH",
                    "taskStatus" => "Assigned",
                    "taskLocationAddress" => "Full address",
                );
                $field = array();
                $qm_task_type_id = $this->input->post('task_type_id');
                $field_list = $this->EntitySettingModel->get_taskFelidsbyTaskType($qm_task_type_id);
                if (!empty($field_list)) {
                    foreach ($field_list as $data_result) {
                        $field[$data_result['Ext_att_name']] = $data_result['Ext_att_name'] . ' example_data';
                    }
                }
                $api_url = "Request URL (REST API) = " . base_url() . "TPServices/CreateTask";
                $sample_request = "  Sample JSON Request = " . json_encode(array_merge($data_show, $field));
                $method_data = $api_url . $sample_request;
                $API_Key = $str;
            } else {
                $method_data = $this->input->post('method');
                $API_Key = $this->input->post('api_key');
            }


            $data = array(
                'ent_id' => $this->input->post('ent_id'),
                'API_Method_Name' => $method_data,
                'API_End_point' => $this->input->post('endpoint'),
                'API_User_name' => $this->input->post('username'),
                'API_Password' => $this->input->post('password'),
//                'API_XML_File' => $this->input->post('xml_file'),
                'API_Task_Type_id' => $this->input->post('tab_id'),
                'Run_mode' => $this->input->post('api'),
                'API_Key' => $API_Key,
                'qm_task_type_id' => $this->input->post('task_type_id')
            );
            
            $api_exist = $this->EntitySettingModel->create_integrated_already_exist($data);
//            var_dump($api_exist);exit;
            if ($api_exist == FALSE) {
                $data['extr_att_id'] = $this->EntitySettingModel->create_integrated($data);
            } else {
                $data['extr_att_id'] = $this->EntitySettingModel->update_integrated($data, $api_exist);
            }

            $data['success'] = 'Api has been added successfully!';
        } else {
            $data['error'] = 'Something went wrong! Please try again!';
        }
        echo json_encode($data);
    }

    public function create_not_integrated_data() {
        $ent_id = $this->input->post('ent_id');


        $data = $this->EntitySettingModel->create_not_integrated_data($ent_id);
        echo json_encode($data);
    }

    public function create_not_integrated_delete() {
    
        $delete_id = $this->input->post('id');

        $data = array(
            'qm_status_type_id' => 0
        );

        $data = $this->EntitySettingModel->create_not_integrated_delete($delete_id, $data);

        echo 'success';
    }
    public function attachment_not_integrated_delete() {
    
        $delete_id = $this->input->post('id');

        $data = array(
            'qm_status_type_id' => 0
        );

        $data = $this->EntitySettingModel->create_attachment_not_integrated_delete($delete_id, $data);

        echo 'success';
    }

    public function create_integrated_delete() {
        $delete_id = $this->input->post('id');
        $data = $this->EntitySettingModel->create_integrated_delete($delete_id);

        echo 'success';
    }

    public function api_setting_save() {

        $map_fields = $this->input->post('map_fields');
        $end_point_control = $this->input->post('end_point_control');
        $api_settings_id = $this->input->post('api_settings_id');
        $Ent_id = $this->input->post('Ent_id');
        $Task_Type_id = $this->input->post('Task_Type_id');

        if ((!empty($map_fields)) && (!empty($end_point_control)) && (!empty($api_settings_id))) {
            $data = array(
                'API_Field' => $this->input->post('map_fields'),
                'End_Point' => $this->input->post('end_point_control'),
                'API_Settings_API_Settings_ID' => $this->input->post('api_settings_id'),
                'Ent_id' => $this->input->post('Ent_id'),
                'API_Task_Type_id' => $this->input->post('Task_Type_id')
            );
            $data['id'] = $this->EntitySettingModel->api_setting_save($data);
            $data['success'] = "successfully!";
        } else {
            $data['error'] = "Fail";
        }

        echo json_encode($data);
    }

    /*     * ***********  ChinnaRasu  ************ */

    public function add_asset() {
        $data = array();
        $ent_id = $this->input->post("ent_id");
        $task_type = $this->input->post("task_type");
        $display_name = $this->input->post("display_name");
        $type = $this->input->post("type");
        $description = $this->input->post("description");
        if (isset($ent_id) && isset($display_name) && isset($type) && isset($description)) {
            $assetData = array();
            $assetData['ent_id'] = $ent_id;
            $assetData['task_type'] = $task_type;
            $assetData['type'] = $type;
            $assetData['description'] = $description;
            $assetData['display_name'] = $display_name;
            $assetData['id'] = $this->EntitySettingModel->asset_add($assetData);
            $assetData['success'] = "Asset has been added successfully!";
            $data = $assetData;
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }
        echo json_encode($data);
    }
/* ******* old code ***************************
    public function getTabDetails() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        if (isset($ent_id)) {
            $tabs = $this->EntitySettingModel->getTaskType($ent_id);
            $tabDetails = array();
            foreach ($tabs as $tab) {
                $tabDetails[] = array(
                    'id' => $tab['id'],
                    'task_type' => $tab['task_type'],
                    'task_type_description' => $tab['task_type_description'],
                    'integrated_api' => json_decode($tab['integrated_api']),
                    'completed_screen' => json_decode($tab['completed_screen_data']),
                    'states_data' => json_decode($tab['states_data']),
                );
            }
            $data['task_type'] = $tabDetails;
            $data['categories'] = $this->EntitySettingModel->getCategory($ent_id);
            $data['getUpdateTabDepondOn'] = $this->EntitySettingModel->getUpdateTabDepondOn($ent_id);
            $data['create'] = $this->EntitySettingModel->create_not_integrated_data($ent_id);
            $apiData = $this->EntitySettingModel->create_integrated_data($ent_id);

            $data['api_data'] = $this->groupTabData($apiData, 'apiData');
            $integrateData = $this->EntitySettingModel->create_integrated_data_list($ent_id);
            $data['integrateData'] = $this->groupTabData($integrateData, 'integrateData');
            $tmp = $this->EntitySettingModel->getUpdateIntegrateData($ent_id);
            $updateintegrateData = array();
            foreach ($tmp as $value) {
                $type_value = json_decode($value['type_values']);
                $api_data = json_decode($value['api_data']);

                if ($value['required_status'] == 1) {
                    $required_status = "Yes";
                } else {
                    $required_status = "No";
                }

                if ($value['depondon'] == NULL) {
                    $depondon = "";
                } else {
                    $depondon = $value['depondon'];
                }

                $updateintegrateData[] = array(
                    'id' => $value['id'],
                    'task_type' => $value['task_type'],
                    'label' => $value['label'],
                    'option_type' => $value['option_type'],
                    'type_limit' => $value['type_limit'],
                    'category' => $value['category'],
                    'depondon' => $depondon,
                    'required_status' => $required_status,
                    'type_values' => (!empty($type_value)) ? implode(',', $type_value) : '',
                    'endpoint' => (!empty($api_data)) ? $api_data->endpoint : '',
                    'map_data' => $value['map_data']
                );
            }
            $data['updateintegrateData'] = $updateintegrateData;
            $data['assets'] = $this->EntitySettingModel->getAssets($ent_id);
            $commands = $this->EntitySettingModel->getCommands($ent_id);
            $data['commands'] = $this->groupTabData($commands, 'commandData');
            $data['success'] = 'success';
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }
        echo json_encode($data);
    }
 */   
/* *********** end old code************************ */
/* *********** start new code************************ */
    public function getTabDetails() {
        $allfsetypes=''; 
        $data = array();
        $ent_id = $this->input->post('ent_id');
        if (isset($ent_id)) {
            $tabs = $this->EntitySettingModel->getTaskType($ent_id);
            $tabDetails = array();
            foreach ($tabs as $tab) {
                $tabDetails[] = array(
                    'id' => $tab['id'],
                    'task_type' => $tab['task_type'],
                    'task_type_description' => $tab['task_type_description'],
                    'integrated_api' => json_decode($tab['integrated_api']),
                    'completed_screen' => json_decode($tab['completed_screen_data']),
                    'states_data' => json_decode($tab['states_data']),
                );
            }

            $data['task_type'] = $tabDetails;
            $data['categories'] = $this->EntitySettingModel->getCategory($ent_id);
            $data['getUpdateTabDepondOn'] = $this->EntitySettingModel->getUpdateTabDepondOn($ent_id);
            $data['create'] = $this->EntitySettingModel->create_not_integrated_data($ent_id);
            $apiData = $this->EntitySettingModel->create_integrated_data($ent_id);

            $data['api_data'] = $this->groupTabData($apiData, 'apiData');
            $integrateData = $this->EntitySettingModel->create_integrated_data_list($ent_id);
            $data['integrateData'] = $this->groupTabData($integrateData, 'integrateData');
            $tmp = $this->EntitySettingModel->getUpdateIntegrateData($ent_id);
            $updateintegrateData = array();
            foreach ($tmp as $value) {
                $type_value = json_decode($value['type_values']);
                $api_data = json_decode($value['api_data']);

                if ($value['required_status'] == 1) {
                    $required_status = "Yes";
                } else {
                    $required_status = "No";
                }

                if ($value['depondon'] == NULL) {
                    $depondon = "";
                } else {
                    $depondon = $value['depondon'];
                }

                $updateintegrateData[] = array(
                    'id' => $value['id'],
                    'task_type' => $value['task_type'],
                    'label' => $value['label'],
                    'option_type' => $value['option_type'],
                    'type_limit' => $value['type_limit'],
                    'category' => $value['category'],
                    'depondon' => $depondon,
                    'required_status' => $required_status,
                    'type_values' => (!empty($type_value)) ? implode(',', $type_value) : '',
                    'endpoint' => (!empty($api_data)) ? $api_data->endpoint : '',
                    'map_data' => $value['map_data']
                );
            }
            $data['updateintegrateData'] = $updateintegrateData;
            $data['assets'] = $this->EntitySettingModel->getAssets($ent_id);


            foreach ($tabDetails as $k => $tabdata) {
                $allfsetypes[$k]['task_type'] = $tabdata['id'];
                $allfsetypes[$k]['taskbylist'] = $this->EntitySettingModel->getEnityFSETypesByTaskType($ent_id, $tabdata['id']);
            } 
            $data['allfsetypes'] = $allfsetypes;
            $data['fse_type_id'] = $this->EntitySettingModel->getEnityFSETypes($ent_id);
            $data['reportflag'] = $this->EntitySettingModel->getReportFieldFlagForEnity($ent_id);
            $data['reportfields'] = $this->EntitySettingModel->getReportFieldForEnity($ent_id);
            $data['createfields'] = $this->EntitySettingModel->getCreateFields($ent_id);
            $RawDataOf_attachements = $this->EntitySettingModel->getCreatedAttachements($ent_id);
            
              $Attachmenmt_tabDetails = array();
            foreach ($RawDataOf_attachements as $Attachment_tab) {
                $Attachmenmt_tabDetails[] = array(
                    'id' => $Attachment_tab['id'],

                    'ent_id' => $Attachment_tab['ent_id'],
                    'task_type' => $Attachment_tab['task_type'],
                    'label' => $Attachment_tab['label'],
                    'option_type' => $Attachment_tab['option_type'],
                    'depondon' => $Attachment_tab['depondon'],
                    'depondid' => $Attachment_tab['depondid'],
                    'type_limit' => $Attachment_tab['type_limit'],
                    'category_id' => $Attachment_tab['category_id'],
                    'required_status' => $Attachment_tab['required_status'],
                    'type_values' => $Attachment_tab['type_values'],
                    'api_data' => $Attachment_tab['api_data'],
                    'map_data' => $Attachment_tab['map_data'],
                    'created_date' => $Attachment_tab['created_date'],
                    'qm_task_type_id' => $Attachment_tab['qm_task_type_id'],
                    'integrated_api' =>json_decode($Attachment_tab['integrated_api']),
                    'report_flag' => $Attachment_tab['report_flag'],
                    'category' => $Attachment_tab['category'],

                );
            }
            $data['attachements']=$Attachmenmt_tabDetails;
            $commands = $this->EntitySettingModel->getCommands($ent_id);
            $data['commands'] = $this->groupTabData($commands, 'commandData');
            $data['success'] = 'success';
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }
        echo json_encode($data);
    }

    /* *********** start new code************************ */
//============ load label in dropdown------------------------------------------------
    public function getTabLabelDetails() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        if (isset($ent_id)) {
        $tabs = $this->EntitySettingModel->getTaskType($ent_id);
            $tabDetails = array();
            foreach ($tabs as $tab) {
                $tabDetails[] = array(
                    'id' => $tab['id'],
                    'task_type' => $tab['task_type'],
                    'task_type_description' => $tab['task_type_description'],
                    'integrated_api' => json_decode($tab['integrated_api']),
                    'completed_screen' => json_decode($tab['completed_screen_data']),
                    'states_data' => json_decode($tab['states_data']),
                );
            }

            $data['task_type_for_report_fileds'] = $tabDetails;     
    // Start ========================================================================================== 
            
            $data['reportflag'] = $this->EntitySettingModel->getReportFieldFlagForEnity($ent_id);
    // End ==========================================================================================    
            $data['reportfields'] = $this->EntitySettingModel->getReportFieldForEnity($ent_id);
            $data['createfields'] = $this->EntitySettingModel->getCreateFields($ent_id);
            
            $data['oldcreatedEmailReportfields'] = $this->EntitySettingModel->getOldCreateEmailFields($ent_id);   
            
            $data['success'] = 'success';
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }
        echo json_encode($data);
    }
// End ------------------------------------------------------------------------------
    function deleteElement($element, &$array) {
        $index = array_search($element, $array);
        if ($index !== false) {
            unset($array[$index]);
        }
    }

    public function getsbOneList() {

        $task_type = $this->input->post('task_type');
        $allfsetypes = $this->EntitySettingModel->getFSETypes();
        $fse_type_id = $this->EntitySettingModel->getEnityFSETypesByTaskType($task_type);
        foreach ($allfsetypes as $i => $data2) {
            foreach ($fse_type_id as $k => $data1) {
                if ($data2['id'] == $data1['fse_type_id']) {
                    unset($allfsetypes[$i]);
                }
            }
        }
        $allfsetypes1 = array_values($allfsetypes);
        $data['allfsetypes'] = $allfsetypes1;
        $data['allfsetypes_cnt'] = count($allfsetypes);
        echo json_encode($data);
    }
/* ******** old code *************** */
/* 
 private function groupTabData($data = array(), $process = NULL) {
        $returnData = array();
        $defaultIndex = '';
        if ($process == 'apiData') {
            $defaultIndex = 'API_Task_Type_id';
        } elseif ($process == 'integrateData') {
            $defaultIndex = 'task_type_tab_id';
        } elseif ($process == 'commandData') {
            $defaultIndex = 'task_type_tab_id';
        } else {
            return false;
            exit;
        }
        foreach ($data as $value) {
            $index = '';
            if ($value[$defaultIndex] == 2) {
                $index = 'create';
            } else if ($value[$defaultIndex] == 3) {
                $index = 'update';
            } else if ($value[$defaultIndex] == 5) {
                $index = 'assets';
            } else if ($value[$defaultIndex] == 8) {
                $index = 'onhold';
            } else if ($value[$defaultIndex] == 9) {
                $index = 'reject';
            }
            if ($process == 'apiData') {
                $returnData[$index][] = array(
                    'API_Settings_ID' => $value['API_Settings_ID'],
                    'API_Method_Name' => $value['API_Method_Name'],
                    'API_End_point' => $value['API_End_point'],
                    'API_User_name' => $value['API_User_name'],
                    'API_Password' => $value['API_Password'],
//                    'API_XML_File' => $value['API_XML_File'],
                    'API_Key' => $value['API_Key'],
                    'API_Task_Type_id' => $value['API_Task_Type_id'],
                    'qm_task_type_id' => $value['qm_task_type_id'],
                );
            } elseif ($process == 'integrateData') {
                $returnData[$index][] = array(
                    'API_Mapping_Id' => $value['API_Mapping_Id'],
                    'API_Field' => $value['API_Field'],
                    'MapTo' => $value['MapTo'],
                    'End_Point' => $value['End_Point'],
                    'API_Settings_API_Settings_ID' => $value['API_Settings_API_Settings_ID'],
                    'task_type' => $value['task_type'],
                    'task_type_tab_id' => $value['task_type_tab_id'],
                );
            } elseif ($process == 'commandData') {
                $returnData[$index][] = array(
                    'id' => $value['id'],
                    'task_type' => $value['task_type'],
                    'task_type_tab_id' => $value['task_type_tab_id'],
                    'command' => $value['command']
                );
            }
        }

        return $returnData;
    }
    
*/ 
/* ****** end old code ************** */ 
/* ****** Start new code ************** */
     private function groupTabData($data = array(), $process = NULL) {
        $returnData = array();
        $defaultIndex = '';
        if ($process == 'apiData') {
            $defaultIndex = 'API_Task_Type_id';
        } elseif ($process == 'integrateData') {
            $defaultIndex = 'task_type_tab_id';
        } elseif ($process == 'commandData') {
            $defaultIndex = 'task_type_tab_id';
        } else {
            return false;
            exit;
        }
        foreach ($data as $value) {
            $index = '';
            if ($value[$defaultIndex] == 2) {
                $index = 'create';
            } else if ($value[$defaultIndex] == 3) {
                $index = 'update';
            } else if ($value[$defaultIndex] == 5) {
                $index = 'assets';
            } else if ($value[$defaultIndex] == 8) {
                $index = 'onhold';
            } else if ($value[$defaultIndex] == 9) {
                $index = 'reject';
            } else if ($value[$defaultIndex] == 10) {
                $index = 'engineertype';            
            } else if ($value[$defaultIndex] == 11) {
                $index = 'taskreport';            
            } else if ($value[$defaultIndex] == 12) {
                $index = 'attachment';
            }else if ($value[$defaultIndex] == 13) {
                $index = 'token_api';
            }else if ($value[$defaultIndex] == 14) {
                $index = 'authmach_api';
            }
            
            if ($process == 'apiData') {
                $returnData[$index][] = array(
                    'API_Settings_ID' => $value['API_Settings_ID'],
                    'API_Method_Name' => $value['API_Method_Name'],
                    'API_End_point' => $value['API_End_point'],
                    'API_User_name' => $value['API_User_name'],
                    'API_Password' => $value['API_Password'],
//                    'API_XML_File' => $value['API_XML_File'],
                    'API_Key' => $value['API_Key'],
                    'API_Task_Type_id' => $value['API_Task_Type_id'],
                    'qm_task_type_id' => $value['qm_task_type_id'],
                );
            } elseif ($process == 'integrateData') {
                $returnData[$index][] = array(
                    'API_Mapping_Id' => $value['API_Mapping_Id'],
                    'API_Field' => $value['API_Field'],
                    'MapTo' => $value['MapTo'],
                    'End_Point' => $value['End_Point'],
                    'API_Settings_API_Settings_ID' => $value['API_Settings_API_Settings_ID'],
                    'task_type' => $value['task_type'],
                    'task_type_tab_id' => $value['task_type_tab_id'],
                );
            } elseif ($process == 'commandData') {
                $returnData[$index][] = array(
                    'id' => $value['id'],
                    'task_type' => $value['task_type'],
                    'task_type_tab_id' => $value['task_type_tab_id'],
                    'command' => $value['command']
                );
            }
        }

        return $returnData;
    }

/* ****** end new code ************** */
/* ****** Start old code ************** */
/*
   public function add_task_type() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        $taskName = $this->input->post('task_type_name');
        if (isset($ent_id) && isset($taskName)) {
            $taskData = array();
            $taskData['ent_id'] = $ent_id;
            $taskData['task_type'] = $taskName;
            $isUnique = $this->EntitySettingModel->checkUnique(QM_TASK_TYPE, $taskData);
            if ($isUnique) {
                $data['error'] = "Task type name is already existed";
            } else {
                $integrated_api = array(
                    'create' => 0,
                    'update' => 0,
                    'asset' => 0,
                    'asset_status' => 0,
                    'allow_for' => 0,
                    'onhold' => 0,
                    'onhold_comment' => 0,
                    'reject' => 0,
                    'reject_comment' => 0
                );
                $completed_screen = array(
                    'signature' => 0,
                    'ratings' => 0,
                    'comments' => 0
                );
                $states_data = array(
                    'assigned' => 'Assigned',
                    'accepted' => 'Accepted',
                    'rejected' => 'Rejected',
                    'inprogress' => 'Inprogress',
                    'onhold' => 'Onhold',
                    'resolved' => 'Resolved'
                );
                $taskData['integrated_api'] = json_encode($integrated_api);
                $taskData['completed_screen_data'] = json_encode($completed_screen);
                $taskData['states_data'] = json_encode($states_data);
                $taskData['id'] = $this->EntitySettingModel->taskType_add($taskData);
                unset($taskData['integrated_api']);
                unset($taskData['states_data']);
                $taskData['integrated_api'] = $integrated_api;
                $taskData['states_data'] = $states_data;
                $data = $taskData;
            }
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }
        echo json_encode($data);
    }
*/
/* ****** end old code ************** */
/* ****** Start new code ************** */
     public function add_task_type() {
        $data = array();
        $allfsetypes=array();
        $ent_id = $this->input->post('ent_id');
        $taskName = $this->input->post('task_type_name');
        $fsetypes = $this->ManagementModel->getFSETypes(); 
        if (isset($ent_id) && isset($taskName)) {
            $taskData = array();
            $taskData['ent_id'] = $ent_id;
            $taskData['task_type'] = $taskName;
            $taskData['task_type_status'] = 1;
            $isUnique = $this->EntitySettingModel->checkUnique(QM_TASK_TYPE, $taskData);
            if ($isUnique) {
                $data['error'] = "Task Type already exists. Task type not added!";
            } else {
                $integrated_api = array(
                    'create' => 0,
                    'update' => 0,
                    'asset' => 0,
                    'asset_status' => 0,
                    'allow_for' => 0,
                    'onhold' => 0,
                    'onhold_comment' => 0,
                    'reject' => 0,
                    'reject_comment' => 0,
                    'attachment' => 0,
                    'attachment_status' => 0,
                    'authmach_update' => 0
                    
                );
                $completed_screen = array(
                    'signature' => 0,
                    'ratings' => 0,
                    'comments' => 0
                );
                $states_data = array(
                    'assigned' => 'Assigned',
                    'accepted' => 'Accepted',
                    'rejected' => 'Rejected',
                    'inprogress' => 'Inprogress',
                    'onhold' => 'Onhold',
                    'resolved' => 'Resolved'
                );
                $taskData['integrated_api'] = json_encode($integrated_api);
                $taskData['completed_screen_data'] = json_encode($completed_screen);
                $taskData['states_data'] = json_encode($states_data);
                $taskData['id'] = $entity_id = $this->EntitySettingModel->taskType_add($taskData);
                $taskData['last_old_task_report_id'] = $this->EntitySettingModel->Last_And_old_task_report_id($ent_id,$task_id);

                //$allfsetypes['allfsetypes'] = $this->EntitySettingModel->getEnityFSETypesByTaskType($ent_id, $taskData['id']);
                // $data=$allfsetypes;
                //$datafsetypes = $this->EntitySettingModel->getFSETypes();
//                foreach ($datafsetypes as $k => $data) {
//                    $insertdatafsetypes[$k]['fse_type_id'] = $data['id'];
//                    $insertdatafsetypes[$k]['ent_id'] = $entity_id;
//                    $insertdatafsetypes[$k]['isactive'] = 0;
//                }
//
//                foreach ($insertdatafsetypes as $data) {
//                    $this->EntitySettingModel->addEntityFSETypes($data);
//                }
                unset($taskData['integrated_api']);
                unset($taskData['states_data']);
                $taskData['integrated_api'] = $integrated_api;
                $taskData['states_data'] = $states_data;
                $taskData['fsetypes']=$fsetypes; 
                $data = $taskData;
            }
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }
/* ****** End new code ************** */
    public function remove_task_type() {
        $data = array();
        $task_id = $this->input->post('task_id');
        if (isset($task_id)) {
            $taskData = array();
            $taskData['task_type_status'] = 0;
            $this->EntitySettingModel->taskType_update($task_id, $taskData);
            $data['success'] = "Task type has been deleted successfully!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function remove_asset() {
        $data = array();
        $asset_id = $this->input->post('asset_id');
        if (isset($asset_id)) {
            $this->EntitySettingModel->asset_update($asset_id);
            $data['success'] = 'Asset has been removed successfully!';
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function upload_csv() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        if (isset($_FILES) && isset($ent_id)) {
            $ent_id = $this->input->post('ent_id');
            $task_type = $this->input->post('task_type');

            $file = fopen($_FILES[0]['tmp_name'], 'r');
            $bulkData = array();
            while (($assetData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $bulkData[] = array(
                    'ent_id' => $ent_id,
                    'task_type' => $task_type,
                    'type' => $assetData[0],
                    'u_is_serialised' => $assetData[1],
                    'display_name' => $assetData[2]
                );
            }
            fclose($file);
            $insertId = $this->EntitySettingModel->bulk_add(QM_SERVICE_NOW_ASSETS, $bulkData);
            if (!empty($insertId)) {
                $startCount = $insertId['first_id'];
                $count = $insertId['row_count'] + $startCount;
                foreach ($bulkData as $value) {
                    $data['data'][] = array(
                        'id' => $startCount,
                        'ent_id' => $value['ent_id'],
                        'task_type' => $value['task_type'],
                        'type' => $value['type'],
                        'u_is_serialised' => $value['u_is_serialised'],
                        'description' => $value['display_name'],
                        'display_name' => $value['display_name'],
                        'start' => $startCount,
                        'count' => $count
                    );
                    if ($count >= $startCount) {
                        $startCount++;
                    } else {
                        break;
                    }
                }
            }
            $data['success'] = 'Asset has been added successfully!';
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function update_task_type() {
        $data = array();
        $task_id = $this->input->post('task_id');
        $type = $this->input->post('type');
        $value = $this->input->post('value');
        if (isset($task_id) && isset($type) && isset($value)) {
            $row = $this->EntitySettingModel->getTaskType('', $task_id);
            $integrated_api = json_decode($row[0]['integrated_api']);
            $update_api = array();
            foreach ($integrated_api as $key => $api) {
                if ($key == $type) {
                    $update_api[$key] = $value;
                } else {
                    $update_api[$key] = $api;
                }
            }
            $taskData = array(
                'integrated_api' => json_encode($update_api)
            );
            $this->EntitySettingModel->taskType_update($task_id, $taskData);
            $data['success'] = strtoupper($type) . " integrated api settings has been updated successfully!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }
   /* public function update_attachment_status() {
        $data = array();
        $task_id = $this->input->post('task_id');
        $type = $this->input->post('type');
        $value = $this->input->post('value');
        if (isset($task_id) && isset($type) && isset($value)) {
            $row = $this->EntitySettingModel->getTaskType('', $task_id);
            $integrated_api = json_decode($row[0]['integrated_api']);
            $update_api = array();
            foreach ($integrated_api as $key => $api) {
                if ($key == $type) {
                    $update_api[$key] = $value;
                } else {
                    $update_api[$key] = $api;
                }
            }
            $taskData = array(
                'integrated_api' => json_encode($update_api)
            );
            $this->EntitySettingModel->taskType_update($task_id, $taskData);
            $data['success'] = strtoupper($type) . " integrated api settings has been updated successfully!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }*/

    public function add_map_fields() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        $api = $this->input->post('api');
        $text = $this->input->post('text');
        $end_point = $this->input->post('end_point');
        $api_id = $this->input->post('api_id');
        $task_type = $this->input->post('task_type');
        $task_type_tab = $this->input->post('task_type_tab');
        if (isset($end_point) && isset($api) && isset($text) && isset($end_point) && isset($api_id) && isset($task_type)) {
            $mapData = array(
                'ent_id' => $ent_id,
                'API_Field' => $api,
                'MapTo' => $text,
                'End_Point' => $end_point,
                'API_Settings_API_Settings_ID' => $api_id,
                'task_type' => $task_type,
                'task_type_tab_id' => $task_type_tab
            );
            $data = $mapData;
            $data['API_Mapping_Id'] = $this->EntitySettingModel->mapFields_add($mapData);
            $data['success'] = 'Mapping fields has been added successfully!';
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }
        echo json_encode($data);
    }

    public function remove_map_fields() {
        $data = array();
        $mapId = $this->input->post('map_id');
        if (isset($mapId)) {
            $this->EntitySettingModel->mapFields_remove($mapId);
            $data['success'] = 'Mapping fields has been deleted successfully!';
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function update_complete_screen() {
        $data = array();
        $task_id = $this->input->post('task_type');
        $type = $this->input->post('type');
        $value = $this->input->post('value');
        if (isset($task_id) && isset($type) && isset($value)) {
            $row = $this->EntitySettingModel->getTaskType('', $task_id);
            $completed_screen_data = json_decode($row[0]['completed_screen_data']);
            $update_data = array();
            foreach ($completed_screen_data as $key => $screenValue) {
                if ($key == $type) {
                    $update_data[$key] = $value;
                } else {
                    $update_data[$key] = $screenValue;
                }
            }
            $taskData = array(
                'completed_screen_data' => json_encode($update_data)
            );
            $this->EntitySettingModel->taskType_update($task_id, $taskData);
            $data['success'] = "Completed screen features has been updated!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function addCommands() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        $task_type = $this->input->post('task_type');
        $tab_id = $this->input->post('tab_id');
        $command = $this->input->post('command');
        if (isset($ent_id) && isset($task_type) && isset($tab_id) && isset($command)) {
            $commandData = array(
                'ent_id' => $ent_id,
                'task_type' => $task_type,
                'task_type_tab_id' => $tab_id,
                'command' => $command
            );

            $check_condition = $this->EntitySettingModel->checkUnique(QM_COMMANDS, $commandData);
            if ($check_condition == false) {
                $this->EntitySettingModel->addCommands($commandData);
                $data['success'] = "Command has been added successfully";
            } else {
                $data['error'] = "Already exits! Please try again!";
            }
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function deleteCommands() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        $task_type = $this->input->post('task_type');
        $tab_id = $this->input->post('tab_id');
        $command = $this->input->post('command');
        if (isset($ent_id) && isset($task_type) && isset($tab_id) && isset($command)) {
            $commandData = array(
                'ent_id' => $ent_id,
                'task_type' => $task_type,
                'task_type_tab_id' => $tab_id,
                'command' => $command
            );
            $this->EntitySettingModel->deleteCommands($commandData);
            $data['success'] = "Command has been added successfully";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function update_states() {
        $data = array();
        $task_id = $this->input->post('task_type');
        $assigned = $this->input->post('assigned');
        $accepted = $this->input->post('accepted');
        $rejected = $this->input->post('rejected');
        $inprogress = $this->input->post('inprogress');
        $onhold = $this->input->post('onhold');
        $resolved = $this->input->post('resolved');

        if (isset($task_id) && isset($assigned)) {
            $states_data = array(
                'assigned' => $assigned,
                'accepted' => $accepted,
                'rejected' => $rejected,
                'inprogress' => $inprogress,
                'onhold' => $onhold,
                'resolved' => $resolved
            );
            $taskData = array(
                'states_data' => json_encode($states_data)
            );
            $this->EntitySettingModel->taskType_update($task_id, $taskData);
            $data['success'] = "States has been updated!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function updateIntegrateData() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        $task_type = $this->input->post('task_type');
        $label = $this->input->post('label');
        $type = $this->input->post('type');
        $limit = $this->input->post('limit');
        $category = $this->input->post('category');
        $required = $this->input->post('required');
        $value = json_decode($this->input->post('value'));
        $depon = json_decode($this->input->post('depon'));
        $depond_on = $this->input->post('depond_on');
        if (isset($ent_id)) {


            if ($type == "SELECT") {
                $tabData = array(
                    'ent_id' => $ent_id,
                    'task_type' => $task_type,
                    'label' => $label,
                    'option_type' => $type,
                    'type_limit' => $limit,
                    'category_id' => $category,
                    'required_status' => $required,
                    'type_values' => json_encode($value)
                );
            } else {
                $tabData = array(
                    'ent_id' => $ent_id,
                    'task_type' => $task_type,
                    'label' => $label,
                    'option_type' => $type,
                    'type_limit' => $limit,
                    'category_id' => $category,
                    'depondon' => $depond_on,
                    'required_status' => $required,
                    'type_values' => json_encode($value)
                );
            }

            $success_res = $tabData_check = array(
                'ent_id' => $ent_id,
                'task_type' => $task_type,
                'label' => $label,
                'category_id' => $category,
            );

            $data_check = $this->EntitySettingModel->checkUnique(QM_EXTRA_ATTR_UPDATE, $tabData_check);
            if ($data_check == FALSE) {
                $data['id'] = $update_id = $this->EntitySettingModel->addUpdateIntegrateData($tabData);
                if ($type == "SELECT") {
                    $this->EntitySettingModel->updateIntegrateselectdata($update_id, $task_type, $value, $depon);
                }
                $data['getUpdateTabDepondOn'] = $this->EntitySettingModel->getUpdateTabDepondOn($ent_id);
                $data['success'] = "Data has been added successfully!";
            } else {
                $data['error'] = "Field name already in list";
            }
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

    public function deleteIntegrateData() {
        $data = array();
        $id = $this->input->post('id');
        if (isset($id)) {
            $this->EntitySettingModel->deleteIntegrateData($id);
            $data['success'] = "Data has been deleted successfully!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }


        echo json_encode($data);
    }

    public function updateApiData() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        $task_type = $this->input->post('task_type');
        $label = $this->input->post('label');
        $type = $this->input->post('type');
        $limit = $this->input->post('limit');
        $category = $this->input->post('category');
        $required = $this->input->post('required');
        $method = $this->input->post('method');
        $endpoint = $this->input->post('endpoint');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if (isset($ent_id)) {
            $apiData = array(
                'method' => $method,
                'endpoint' => $endpoint,
                'username' => $username,
                'password' => $password
            );

            $tabData = array(
                'ent_id' => $ent_id,
                'task_type' => $task_type,
                'label' => $label,
                'option_type' => $type,
                'type_limit' => $limit,
                'category_id' => $category,
                'required_status' => $required,
                'api_data' => json_encode($apiData)
            );
            $data['id'] = $this->EntitySettingModel->addUpdateIntegrateData($tabData);
            $data['success'] = "Data has been added successfully!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }

        public function Attachment_ApiData() {
        $data = array();
        $ent_id = $this->input->post('ent_id');
        $task_type = $this->input->post('task_type');
        $label = $this->input->post('label');
        $type = $this->input->post('type');
        $limit = $this->input->post('limit');
        $category = $this->input->post('category');
        $required = $this->input->post('required');
        $method = $this->input->post('method');
        $endpoint = $this->input->post('endpoint');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if (isset($ent_id)) {
            $apiData = array(
                'method' => $method,
                'endpoint' => $endpoint,
                'username' => $username,
                'password' => $password
            );

            $tabData = array(
                'ent_id' => $ent_id,
                'task_type' => $task_type,
                'label' => $label,
                'option_type' => $type,
                'type_limit' => $limit,
                'category_id' => $category,
                'required_status' => $required,
                'api_data' => json_encode($apiData)
            );
            $data['id'] = $this->EntitySettingModel->addAttachment_IntegrateData($tabData);
            $data['success'] = "Data has been added successfully!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }
    public function updateIntegrateMapData() {
        $data = array();
        $id = $this->input->post('id');
        $value = $this->input->post('value');

        if (isset($id) && isset($value)) {
            $mapData = array(
                'map_data' => $value
            );
            $this->EntitySettingModel->updateIntegrateMapData($id, $mapData);
            $data['success'] = "Data has been update successfully!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }
    
 public function AttachmentIntegrateMapData() {
        $data = array();
        $id = $this->input->post('id');
        $value = $this->input->post('value');

        if (isset($id) && isset($value)) {
            $mapData = array(
                'map_data' => $value
            );
            $this->EntitySettingModel->AttachmentIntegrateMapData($id, $mapData);
            $data['success'] = "Data has been update successfully!";
        } else {
            $data['error'] = "Something went wrong! Please try again!";
        }

        echo json_encode($data);
    }
    public function test() {
        $this->EntitySettingModel->get_taskFelidsbyTaskType(8);
    }

}
