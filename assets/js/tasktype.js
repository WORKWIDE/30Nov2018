var categories = [], fse_types = [], fse_types_arr = [], fse_types1 = [], assets = [], tabs = [], create_no = [], create_yes = [], update_yes = [], assets_yes = [], onhold_yes = [], reject_yes = [], engineertype_yes = [], taskreport_yes = [];
var create_yes_list = [], update_yes_list = [], assets_yes_list = [], onhold_yes_list = [], engineertype_yes_list = [], taskreport_yes_list = [], reject_yes_list = [], update_integrateData = [];
var tab_status = 0, task_type_id, fse_cnt;
var attachment_no = [], attachment_yes = [], attachment_yes_list = [];
$(window).load(function () {
    getTabDetails();
});

$('.add-task-type').on('click', function () {
    var ent_id = $('#ent_id').val();
    var emptyvar='';
    var task_type_name = $('#task_type_name').val();   
    if (task_type_name) {
        $('#task_type_name').css('border-color', '');
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/add_task_type',
            type: 'post',
            dataType: 'json',
            data: {ent_id: ent_id, task_type_name: task_type_name},
            success: function (res) {
//                alert(res.id+'===,'+res.task_type+',,='+res.ent_id);
                if (res.error) {
                    showInformation('error', res.error);
                    $('#divLoading').removeClass('show');
                } else {
                    //fse_types1 = res.allfsetypes;
                    // alert(Last_And_old_task_report_id);
                    //fse_types1 = res.allfsetypes;
                    var tmpTabs = {id: res.id, task_type: res.task_type, task_type_description: res.task_type_description, integrated_api: res.integrated_api};
                    tabs.push(tmpTabs);
                   emptyvar= res.last_old_task_report_id;
                   // alert(emptyvar);
                    cloneTask(res.id, res.task_type,emptyvar);
                    selectedOptions(res.id, res.integrated_api);
                    appendTaskDependency('', true);
                    stateValues(res.id, res.states_data);
                    $('#task_type_name').val('');
                    $('#divLoading').removeClass('show');
                    
                    showEngineerRelatedFields();
                    // showFseTypes1();
                      //showFseTypes();
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            },
        });
    } else {
        $('#task_type_name').css('border-color', 'red');
    }
});

function cloneTask(id, task_type,report_ids) {
   // alert(id+', '+task_type+','+report_ids);
    var tabId = 'tasktype_' + id;
    $('#parent_nav').append('<li data-tab="' + id + '"><a href="#' + tabId + '" data-toggle="tab" id="task_tab_' + id + '">' + task_type + '</a><span><b>X</b></span></li>');
    var clone_div = $('#clone').clone();
    clone_div.removeAttr('style');
    clone_div.removeAttr('id');
    clone_div.attr('id', tabId);
    clone_div.find('.categories1').attr({href: "#categories_" + id, class: "categories_" + id});
    clone_div.find('.create1').attr({href: "#create_" + id});
    clone_div.find('.update1').attr({href: "#update_" + id});
    clone_div.find('.complete1').attr({href: "#complete_" + id});
    clone_div.find('.assets1').attr({href: "#assets_" + id});
    //-----------------------------------------------
    clone_div.find('.attachment1').attr({href: "#attachment_" + id});
   //-----------------------------------------------
    clone_div.find('.states1').attr({href: "#states_" + id});
    clone_div.find('.flow1').attr({href: "#flow_" + id});
    clone_div.find('.onhold1').attr({href: "#onhold_" + id});
    clone_div.find('.reject1').attr({href: "#reject_" + id});
    clone_div.find('.engineertype1').attr({href: "#engineertype_" + id});
    clone_div.find('.taskreport1').attr({href: "#taskreport_" + id});

    clone_div.find('#categories1').attr({id: "categories_" + id, class: "tab-pane active"});
    clone_div.find('#create1').attr({id: "create_" + id});
    clone_div.find('#update1').attr({id: "update_" + id});
    clone_div.find('#complete1').attr({id: "complete_" + id});
    clone_div.find('#assets1').attr({id: "assets_" + id});
    clone_div.find('#states1').attr({id: "states_" + id});
    //-----------------------------------------------
    clone_div.find('#attachment1').attr({id: "attachment_" + id});
    //-----------------------------------------------
    clone_div.find('#reject1').attr({id: "reject_" + id});
    
    clone_div.find('#flow1').attr({id: "flow_" + id});
    clone_div.find('#onhold1').attr({id: "onhold_" + id});
    clone_div.find('#engineertype1').attr({id: "engineertype_" + id});
    clone_div.find('#taskreport1').attr({id: "taskreport_" + id});    
    clone_div.find('#taskreport1').attr({id: "taskreport_" + id});

    clone_div.find('#category_add1').attr({id: "category_add_" + id});
    clone_div.find('#category_add_button1').attr({id: "category_add_button_" + id, 'data-category': id, onclick: "addCategory(" + id + ")"});
    clone_div.find('#category_table1').attr({id: "category_table_" + id});

    clone_div.find('.create_api1').attr({name: "create_api_" + id, onchange: "togIntegratedApi('create', " + id + ", true)", class: ''});
    clone_div.find('#task_dependency1').attr({id: "task_dependency_" + id});
    clone_div.find('#create_integrated_api1').attr({id: "create_integrated_api_" + id});
    clone_div.find('#create_integrated_api_no1').attr({id: "create_integrated_api_no_" + id});

    clone_div.find('#created_add_not_integrated1').attr({id: "created_add_not_integrated" + id, onclick: "create_not_integrate(" + id + ")"});

    clone_div.find('#create_label').attr({id: "create_label" + id + "",onkeyup:"allowcharaFunction(this)"});
    //clone_div.find('#create_field_type').attr({id: "create_field_type" + id + ""});
    clone_div.find('#create_field_type').attr({id: "create_field_type" + id, onchange: "createSelectIntegrated(" + id + ")"});
    clone_div.find('#create_limit').attr({id: "create_limit" + id + ""});
    clone_div.find('#create_category').attr({id: "create_category" + id + ""});
    clone_div.find('#create_attri_control').attr({id: "create_attri_control" + id + ""});
    clone_div.find('#create_test').attr({id: "create_test_" + id + ""});
    clone_div.find('#select_integrated_create').attr({id: "select_integrated_create_" + id, class: "select_pane_" + id});


    clone_div.find('#label').attr({id: "label" + id + ""});
    clone_div.find('#field_type').attr({id: "field_type" + id + ""});
    clone_div.find('#limit').attr({id: "limit" + id + ""});
    clone_div.find('#category').attr({id: "category" + id + ""});
    clone_div.find('#create_addtoupdate_api').attr({id: "create_addtoupdate_api" + id + ""});    
    clone_div.find('#create_table').attr({id: "create_table_" + id + ""});
    /**********************satart*************************/

    clone_div.find('#attachment_add1').attr({id: "attachment_add_" + id});
    clone_div.find('#attachment_add_button1').attr({id: "attachment_add_button_" + id, 'data-category': id, onclick: "addAttachment(" + id + ")"});
    clone_div.find('#attachment_table1').attr({id: "attachment_table_" + id});
    
    clone_div.find('.attachment_status').attr({name: "attachment_status" + id, id: '', onchange: "changeIntegratedApi(" + id + ", 'attachment_status', '')"});
   // clone_div.find('#asset_status').attr({name: "asset_status" + id, id: '', onchange: "changeIntegratedApi(" + id + ", 'asset_status', '')"});
//    clone_div.find('#attachment_status').attr({name: "attachment_status" + id, onchange: "togAttach_IntegratedApi('attachment_status', " + id + ", true)", class: ''});
//    clone_div.find('.attachment_api1').attr({name: "attachment_api_" + id, onchange: "togAttach_IntegratedApi('attachment', " + id + ", true)", class: ''});
    clone_div.find('.attachment_api1').attr({name: "attachment_api_" + id, onchange: "togIntegratedApi('attachment', " + id + ", true)", class: ''});
   // clone_div.find('#create_integrated_api1').attr({id: "create_integrated_api_" + id});
    //clone_div.find('#create_integrated_api_no1').attr({id: "create_integrated_api_no_" + id});
    clone_div.find('#attachment_integrated_api1').attr({id: "attachment_integrated_api_" + id});
    clone_div.find('#attachment_integrated_api_no1').attr({id: "attachment_integrated_api_no_" + id});

    clone_div.find('#attachment_add_not_integrated1').attr({id: "attachment_add_not_integrated" + id, onclick: "attachment_not_integrate(" + id + ")"});

    clone_div.find('#attachment_label').attr({id: "attachment_label" + id, class: "form-control attachment-yes-validate" + id});
    //clone_div.find('#create_field_type').attr({id: "create_field_type" + id + ""});
    clone_div.find('#attachment_field_type').attr({id: "attachment_field_type" + id, class: "form-control attachment-yes-validate" + id,onchange: "attachmentSelectIntegrated(" + id + ")"});
    clone_div.find('#attachment_limit').attr({id: "attachment_limit" + id + ""});
    clone_div.find('#attachment_mandatory').attr({id: "attachment_mandatory" + id});
    clone_div.find('#attachment_field_dependOn').attr({id: "attachment_field_dependOn_" + id, class: "form-control"});
    clone_div.find('.attachment_available_api1').attr({name: "attachment_available_api_" + id, onchange: "changeSelIntegrated(" + id + ")", class: ''});
   
    
   // clone_div.find('#attachment_category').attr({id: "attachment_category" + id, class: "form-control attachment-yes-validate" + id});

    clone_div.find('#attachment_attri_control').attr({id: "attachment_attri_control" + id + ""});
    clone_div.find('#attachment_test').attr({id: "attachment_test_" + id + ""});
    clone_div.find('#select_integrated_attachment').attr({id: "select_integrated_attachment_" + id, class: "select_pane_" + id});


    clone_div.find('#label').attr({id: "label" + id + ""});
    clone_div.find('#field_type').attr({id: "field_type" + id + ""});
    clone_div.find('#limit').attr({id: "limit" + id + ""});
    clone_div.find('#category').attr({id: "category" + id + ""});
    clone_div.find('#attachment_table').attr({id: "attachment_table_" + id + ""});


/******************end**********************/
    clone_div.find('.update_api1').attr({name: "update_api_" + id, onchange: "togIntegratedApi('update', " + id + ", true)", class: ''});
    clone_div.find('#update_api_settings_id').attr({id: "update_api_settings_id_" + id});
    clone_div.find('#update_method1').attr({id: "update_method_" + id, class: "form-control update-validate" + id});
    clone_div.find('#update_endpoint1').attr({id: "update_endpoint_" + id, class: "form-control update-validate" + id});
    clone_div.find('#update_username1').attr({id: "update_username_" + id, class: "form-control update-validate" + id});
    clone_div.find('#update_password1').attr({id: "update_password_" + id, class: "form-control update-validate" + id});
//    clone_div.find('#update_xml_file1').attr({id: "update_xml_file_" + id, class: "form-control update-validate" + id});
    clone_div.find('#update_api_key1').attr({id: "update_api_key_" + id, class: "form-control update-validate" + id});

    
/******************new screen start**********************/    
// authmachanism_postbacklabel_div
// authmachanism_postback_div
    // authmach_update_api1

clone_div.find('.authmach_update_api1').attr({name: "authmach_update_api_" + id, onchange: "togIntegratedApi('authmach_update', " + id + ", true)", class: ''});
clone_div.find('#authmach_update_api_settings_id').attr({id: "authmach_update_api_settings_id_" + id});
clone_div.find('#authmach_update_integrated_api').attr({id: "authmach_update_integrated_api_" + id});
clone_div.find('#authmach_update_t_integrated_api').attr({id: "authmach_update_t_integrated_api_" + id});

    clone_div.find('#authmach_update_method1').attr({id: "authmach_update_method_" + id, class: "form-control authmach-update-validate" + id});
    clone_div.find('#authmach_update_endpoint1').attr({id: "authmach_update_endpoint_" + id, class: "form-control authmach-update-validate" + id});    
    clone_div.find('#authmach_update_api_key1').attr({id: "authmach_update_api_key_" + id, class: "form-control authmach-update-validate" + id});
    clone_div.find('#openfieldlist').attr({id: "openfieldlist_" + id, class: "form-control" + id,onclick:"addendplbl("+id+")"});
    clone_div.find('#create_listitem').attr({id: "create_listitem_" + id, class: "form-control" + id,onclick:"add("+id+")"});    
    clone_div.find('#new_list_fields').attr({id: "new_list_fields_" + id, class: "form-control new_list_fields"});
    clone_div.find('#authmach_add_update_api').attr({id: "authmach_add_update_api_" + id, onclick: "add_api_data('authmach_update', " + id + ")"});
    
    

    clone_div.find('#t_update_method1').attr({id: "t_update_method_" + id, class: "form-control t-update-validate" + id});
    clone_div.find('#t_update_endpoint1').attr({id: "t_update_endpoint_" + id, class: "form-control t-update-validate" + id});
    clone_div.find('#t_update_username1').attr({id: "t_update_username_" + id, class: "form-control t-update-validate" + id});
    clone_div.find('#t_update_password1').attr({id: "t_update_password_" + id, class: "form-control t-update-validate" + id});
    clone_div.find('#t_update_api_cont_type').attr({id: "t_update_api_key_" + id, class: "form-control t-update-validate" + id});
//    clone_div.find('#submit_api_data').attr({id: "submit_api_data_" + id, onclick: "submitApiData(" + id + ")"});
    clone_div.find('#t_add_update_api').attr({id: "t_add_update_api_" + id, onclick: "add_api_data('t_update', " + id + ")"});
    
/******************new screen end**********************/    
    clone_div.find('#select_update_method').attr({id: "select_update_method_" + id, class: "form-control select-update-validate" + id});
    clone_div.find('#select_update_endpoint').attr({id: "select_update_endpoint_" + id, class: "form-control select-update-validate" + id});
    clone_div.find('#select_update_username').attr({id: "select_update_username_" + id, class: "form-control select-update-validate" + id});
    clone_div.find('#select_update_password').attr({id: "select_update_password_" + id, class: "form-control select-update-validate" + id});
    clone_div.find('#select_update_api_key').attr({id: "select_update_api_key_" + id, class: "form-control select-update-validate" + id});
    clone_div.find('#submit_api_data').attr({id: "submit_api_data_" + id, onclick: "submitApiData(" + id + ")"});

    clone_div.find('#update_integrated_api').attr({id: "update_integrated_api_" + id});
    clone_div.find('#update_integrated_api_no').attr({id: "update_integrated_api_no_" + id});
    clone_div.find('#div_update_integrated_api').attr({id: "div_update_integrated_api_" + id});
    

    clone_div.find('#update_label').attr({id: "update_label_" + id, class: "form-control update-yes-validate" + id});
    clone_div.find('#update_field_type').attr({id: "update_field_type_" + id, onchange: "selectIntegrated(" + id + ")", class: "form-control update-yes-validate" + id});
    clone_div.find('#update_field_dependOn').attr({id: "update_field_dependOn_" + id, class: "form-control"});
    clone_div.find('#update_limit').attr({id: "update_limit_" + id, class: "form-control"});
    clone_div.find('#update_tab_category').attr({id: "update_tab_category_" + id, class: "form-control update-yes-validate" + id});
    clone_div.find('#update_required').attr({id: "update_required_" + id});
    clone_div.find('.update_available_api1').attr({name: "update_available_api_" + id, onchange: "changeSelIntegrated(" + id + ")", class: ''});
    clone_div.find('#add_update_api').attr({id: "add_update_api_" + id, onclick: "add_api_data('update', " + id + ")"});
    clone_div.find('#append_update_data').attr({id: "append_update_data_" + id});
    clone_div.find('.append_update_data').attr({class: "append_update_data_" + id});
//  clone_div.find('#append_update_map_data').attr({id: "append_update_map_data_" + id});

    clone_div.find('#create_select_integrated').attr({id: "create_select_integrated_" + id, class: "input-group radio create_select_pane_" + id});
    clone_div.find('#create_select_integrated_yes').attr({id: "create_select_integrated_yes_" + id, class: "create_select_pane_" + id});
    clone_div.find('#create_select_integrated_no').attr({id: "create_select_integrated_no_" + id, class: "create_select_pane_" + id});
    clone_div.find('#create_select_integrated_text').attr({id: "create_select_integrated_text_" + id, class: "form-control create_select-options-" + id});
    clone_div.find('#create_select_data').attr({id: "create_select_data_" + id});
    clone_div.find('#create_select_add_more').attr({id: "create_select_add_more_" + id, onclick: "createtoggleIntegrate('select', " + id + ")"});
    clone_div.find('#create_complete_select_integrate').attr({id: "create_complete_select_integrate_" + id, onclick: "createaddIntegrateData('select', " + id + ")", class: "btn btn-success create_select-options-" + id});
    clone_div.find('#create_add_select_integrated').attr({id: "create_add_select_integrated_" + id, onclick: "createappendUpdateData('select', " + id + ")", class: "btn btn-success create_select-options-" + id});
    clone_div.find('#create_add_select_integrate_data').attr({id: "create_add_select_integrate_data_" + id, onclick: "create_not_integrate(" + id + ")"});
    clone_div.find('#attachment_select_integrated').attr({id: "attachment_select_integrated_" + id, class: "input-group radio create_select_pane_" + id});
    clone_div.find('#attachment_select_integrated_yes').attr({id: "attachment_select_integrated_yes_" + id, class: "attachment_select_pane_" + id});
    clone_div.find('#attachment_select_integrated_no').attr({id: "attachment_select_integrated_no_" + id, class: "attachment_select_pane_" + id});
    clone_div.find('#attachment_select_integrated_text').attr({id: "attachment_select_integrated_text_" + id, class: "form-control attachment_select-options-" + id});
    clone_div.find('#attachment_select_data').attr({id: "attachment_select_data_" + id});
    clone_div.find('#attachment_select_add_more').attr({id: "attachment_select_add_more_" + id, onclick: "attachmenttoggleIntegrate('select', " + id + ")"});
    clone_div.find('#attachment_complete_select_integrate').attr({id: "attachment_complete_select_integrate_" + id, onclick: "attachmentcreateIntegrateData('select', " + id + ")", class: "btn btn-success attachment_select-options-" + id});
    clone_div.find('#attachment_add_select_integrated').attr({id: "attachment_add_select_integrated_" + id, onclick: "attachmentappendUpdateData('select', " + id + ")", class: "btn btn-success attachment_select-options-" + id});
    clone_div.find('#attachment_add_select_integrate_data').attr({id: "attachment_add_select_integrate_data_" + id, onclick: "attachment_not_integrate(" + id + ")"});
//------------------------------------------------------------------------------
    clone_div.find('#select_attachment_method').attr({id: "select_attachment_method_" + id, class: "form-control select-attachment-validate" + id});
    clone_div.find('#select_attachment_endpoint').attr({id: "select_attachment_endpoint_" + id, class: "form-control select-attachment-validate" + id});
    clone_div.find('#select_attachment_username').attr({id: "select_attachment_username_" + id, class: "form-control select-attachment-validate" + id});
    clone_div.find('#select_attachment_password').attr({id: "select_attachment_password_" + id, class: "form-control select-attachment-validate" + id});
    clone_div.find('#select_attachment_api_key').attr({id: "select_attachment_api_key_" + id, class: "form-control select-attachment-validate" + id});
    clone_div.find('#submitAttachment_api_data').attr({id: "submitAttachment_api_data" + id, onclick: "submitAttachment_ApiData(" + id + ")"});
//------------------------------------------------------------------------------

    //  clone_div.find('#select_field_dependOn').attr({id: "select_field_dependOn_" + id, class: "form-control"});
    clone_div.find('#select_integrated').attr({id: "select_integrated_" + id, class: "input-group radio select_pane_" + id});
    clone_div.find('#select_integrated_yes').attr({id: "select_integrated_yes_" + id, class: "select_pane_" + id});
    clone_div.find('#select_integrated_no').attr({id: "select_integrated_no_" + id, class: "select_pane_" + id});
    clone_div.find('#select_integrated_text').attr({id: "select_integrated_text_" + id, class: "form-control select-options-" + id});
    clone_div.find('#select_data').attr({id: "select_data_" + id});
    clone_div.find('#select_add_more').attr({id: "select_add_more_" + id, onclick: "toggleIntegrate('select', " + id + ")"});
    clone_div.find('#complete_select_integrate').attr({id: "complete_select_integrate_" + id, onclick: "addIntegrateData('select', " + id + ")", class: "btn btn-success select-options-" + id});
    clone_div.find('#add_select_integrated').attr({id: "add_select_integrated_" + id, onclick: "appendUpdateData('select', " + id + ")", class: "btn btn-success select-options-" + id});
    clone_div.find('#add_select_integrate_data').attr({id: "add_select_integrate_data_" + id, onclick: "submitIntegrateData('select', " + id + ")"});

    clone_div.find('#radio_integrated').attr({id: "radio_integrated_" + id, class: "radio_pane_" + id});
    clone_div.find('#radio_integrated_text').attr({id: "radio_integrated_text_" + id, class: "form-control radio-options-" + id});
    clone_div.find('#radio_data').attr({id: "radio_data_" + id});
    clone_div.find('#radio_add_more').attr({id: "radio_add_more_" + id, onclick: "toggleIntegrate('radio', " + id + ")"});
    clone_div.find('#complete_radio_integrate').attr({id: "complete_radio_integrate_" + id, onclick: "addIntegrateData('radio', " + id + ")", class: "btn btn-success radio-options-" + id});
    clone_div.find('#add_radio_integrated').attr({id: "add_radio_integrated_" + id, onclick: "appendUpdateData('radio', " + id + ")", class: "btn btn-success radio-options-" + id});
    clone_div.find('#add_radio_integrate_data').attr({id: "add_radio_integrate_data_" + id, onclick: "submitIntegrateData('radio', " + id + ")"});

    clone_div.find('#checkbox_integrated').attr({id: "checkbox_integrated_" + id, class: "checkbox_pane_" + id});
//  clone_div.find('#radio_integrated').attr({id: "radio_integrated_" + id, class: "radio_pane_" + id});
    clone_div.find('#checkbox_integrated_text').attr({id: "checkbox_integrated_text_" + id, class: "form-control checkbox-options-" + id});
    clone_div.find('#checkbox_data').attr({id: "checkbox_data_" + id});
    clone_div.find('#checkbox_add_more').attr({id: "checkbox_add_more_" + id, onclick: "toggleIntegrate('checkbox', " + id + ")"});
    clone_div.find('#complete_checkbox_integrate').attr({id: "complete_checkbox_integrate_" + id, onclick: "addIntegrateData('checkbox', " + id + ")", class: "btn btn-success checkbox-options-" + id});
    clone_div.find('#add_checkbox_integrated').attr({id: "add_checkbox_integrated_" + id, onclick: "appendUpdateData('checkbox', " + id + ")", class: "btn btn-success checkbox-options-" + id});
    clone_div.find('#add_checkbox_integrate_data').attr({id: "add_checkbox_integrate_data_" + id, onclick: "submitIntegrateData('checkbox', " + id + ")"});
    clone_div.find('#add_other_integrate').attr({id: "add_other_integrate_" + id});
    clone_div.find('#add_other_integrate_data').attr({id: "add_other_integrate_data_" + id, onclick: "submitIntegrateData('other', " + id + ")"});

    clone_div.find('.complete_api').attr({name: "complete_api_" + id, class: ''});
    clone_div.find('.signature').attr({id: "signature_" + id, class: '', onchange: "changeCompletedScreen('signature', " + id + ")"});
    clone_div.find('.ratings').attr({id: "ratings_" + id, class: '', onchange: "changeCompletedScreen('ratings', " + id + ")"});
    clone_div.find('.comments').attr({id: "comments_" + id, class: '', onchange: "changeCompletedScreen('comments', " + id + ")"});

    clone_div.find('#asset_integrated_api1').attr({id: "asset_integrated_api_" + id});
    clone_div.find('#asset_integrated_api_no1').attr({id: "asset_integrated_api_no_" + id});

    clone_div.find('#add_assets_api').attr({id: "add_assets_api_" + id, onclick: "add_api_data('assets', " + id + ")"});
    clone_div.find('#assets_api_settings_id').attr({id: "assets_api_settings_id_" + id});
    clone_div.find('#assets_method1').attr({id: "assets_method_" + id, class: "form-control assets-validate" + id});
    clone_div.find('#assets_endpoint1').attr({id: "assets_endpoint_" + id, class: "form-control assets-validate" + id});
    clone_div.find('#assets_username1').attr({id: "assets_username_" + id, class: "form-control assets-validate" + id});
    clone_div.find('#assets_password1').attr({id: "assets_password_" + id, class: "form-control assets-validate" + id});
//    clone_div.find('#assets_xml_file1').attr({id: "assets_xml_file_" + id, class: "form-control assets-validate" + id});
    clone_div.find('#assets_api_key1').attr({id: "assets_api_key_" + id, class: "form-control assets-validate" + id});

    clone_div.find('#asset_status').attr({name: "asset_status" + id, id: '', onchange: "changeIntegratedApi(" + id + ", 'asset_status', '')"});
    clone_div.find('.asset_api1').attr({name: "asset_api_" + id, onchange: "togIntegratedApi('asset', " + id + ", true)", class: ''});
    clone_div.find('#asset_upload1').attr({id: "asset_upload_" + id});
    clone_div.find('#asset_upload_csv1').attr({id: "asset_upload_csv_" + id, onchange: "upload_csv(" + id + ")"});
    clone_div.find('#asset_display_name1').attr({id: "asset_display_name_" + id, class: "form-control assets-no-validate" + id});
    clone_div.find('#asset_type1').attr({id: "asset_type_" + id, class: "form-control assets-no-validate" + id});
    clone_div.find('#asset_description1').attr({id: "asset_description_" + id, class: "form-control assets-no-validate" + id});
    clone_div.find('#add_asset_value1').attr({onclick: "add_asset_value(" + id + ")", id: ''});
    clone_div.find('#append_asset_data1').attr({id: "append_asset_data_" + id});

    clone_div.find('#create_method').attr({id: "create_method_" + id, class: "form-control create-validate" + id});
    //   clone_div.find('#create_endpoint').attr({id: "create_endpoint_" + id, class: "form-control create-validate" + id});
    //   clone_div.find('#create_username').attr({id: "create_username_" + id, class: "form-control create-validate" + id});
    //   clone_div.find('#create_password').attr({id: "create_password_" + id, class: "form-control create-validate" + id});
//    clone_div.find('#create_xml_file').attr({id: "create_xml_file_" + id, class: "form-control create-validate" + id});
    //   clone_div.find('#create_api_key').attr({id: "create_api_key_" + id, class: "form-control create-validate" + id});

    clone_div.find('#add_create_api').attr({id: "add_create_api_" + id, onclick: "add_api_data('create', " + id + ")"});

    clone_div.find('#create_yes_addbutton').attr({id: "create_yes_addbutton" + id, onclick: "addMapFields('create', " + id + ")"});
    clone_div.find('#append_create_yes_data').attr({id: "append_create_yes_data" + id});
    clone_div.find('#create_api_settings_id').attr({id: "create_api_settings_id_" + id});

    clone_div.find('#create_map_fields').attr({id: "create_map_fields" + id, class: "form-control create_validate_map" + id});
    clone_div.find('#create_end_point_control').attr({id: "create_end_point_control" + id, class: "form-control create_validate_map" + id});

    /*
     clone_div.find('#update_map_fields').attr({id: "update_map_fields" + id, class: "form-control update_validate_map" + id});
     clone_div.find('#update_end_point_control').attr({id: "update_end_point_control" + id, class: "form-control update_validate_map" + id});
     clone_div.find('#update_yes_addbutton').attr({id: "update_yes_addbutton" + id, onclick: "addMapFields('update', " + id + ")"});
     clone_div.find('#append_update_yes_data').attr({id: "append_update_yes_data" + id});
     */
    clone_div.find('#attachment_method').attr({id: "attachment_method_" + id, class: "form-control attachment-validate" + id});
     clone_div.find('#add_attachment_api').attr({id: "add_attachment_api_" + id, onclick: "add_api_data('attachment', " + id + ")"});

    clone_div.find('#attachment_yes_addbutton').attr({id: "attachment_yes_addbutton" + id, onclick: "addMapFields('attachment', " + id + ")"});
    clone_div.find('#append_attachment_yes_data').attr({id: "append_attachment_yes_data" + id});
    clone_div.find('#attachment_api_settings_id').attr({id: "attachment_api_settings_id_" + id});

//--------------------------------------------------
    clone_div.find('#attachment_method1').attr({id: "attachment_method_" + id, class: "form-control attachment-validate" + id});
    clone_div.find('#attachment_endpoint1').attr({id: "attachment_endpoint_" + id, class: "form-control attachment-validate" + id});
    clone_div.find('#attachment_username1').attr({id: "attachment_username_" + id, class: "form-control attachment-validate" + id});
    clone_div.find('#attachment_password1').attr({id: "attachment_password_" + id, class: "form-control attachment-validate" + id});
//    clone_div.find('#assets_xml_file1').attr({id: "assets_xml_file_" + id, class: "form-control assets-validate" + id});
    clone_div.find('#attachment_api_key1').attr({id: "attachment_api_key_" + id, class: "form-control attachment-validate" + id});
//--------------------------------------------------
    clone_div.find('#attachment_map_fields').attr({id: "attachment_map_fields" + id, class: "form-control attachment_validate_map" + id});
    clone_div.find('#attachment_end_point_control').attr({id: "attachment_end_point_control" + id, class: "form-control attachment_validate_map" + id});

    clone_div.find('#assets_map_fields').attr({id: "assets_map_fields" + id, class: "form-control assets_validate_map" + id});
    clone_div.find('#assets_end_point_control').attr({id: "assets_end_point_control" + id, class: "form-control assets_validate_map" + id});
    clone_div.find('#assets_yes_addbutton').attr({id: "assets_yes_addbutton" + id, onclick: "addMapFields('assets', " + id + ")"});
    clone_div.find('#append_assets_yes_data').attr({id: "append_assets_yes_data" + id});

    clone_div.find('#assigned_state').attr({id: "assigned_state_" + id, class: "form-control states-validate" + id});
    clone_div.find('#accepted_state').attr({id: "accepted_state_" + id, class: "form-control states-validate" + id});
    clone_div.find('#rejected_state').attr({id: "rejected_state_" + id, class: "form-control states-validate" + id});
    clone_div.find('#inprogress_state').attr({id: "inprogress_state_" + id, class: "form-control states-validate" + id});
    clone_div.find('#onhold_state').attr({id: "onhold_state_" + id, class: "form-control states-validate" + id});
    clone_div.find('#resolved_state').attr({id: "resolved_state_" + id, class: "form-control states-validate" + id});
    clone_div.find('#submit_state').attr({id: "submit_state_" + id, onclick: "updateStates(" + id + ")"});

    clone_div.find('.allow_for').attr({name: "allow_for" + id, class: '', onchange: "changeIntegratedApi(" + id + ", 'allow_for', '')"});

    clone_div.find('#onhold_map_fields').attr({id: "onhold_map_fields" + id, class: "form-control onhold_validate_map" + id});
    clone_div.find('#onhold_end_point_control').attr({id: "onhold_end_point_control" + id, class: "form-control onhold_validate_map" + id});
    clone_div.find('#onhold_yes_addbutton').attr({id: "onhold_yes_addbutton" + id, onclick: "addMapFields('onhold', " + id + ")"});
    clone_div.find('#append_onhold_yes_data').attr({id: "append_onhold_yes_data" + id});

    clone_div.find('#reject_map_fields').attr({id: "reject_map_fields" + id, class: "form-control reject_validate_map" + id});
    clone_div.find('#reject_end_point_control').attr({id: "reject_end_point_control" + id, class: "form-control reject_validate_map" + id});
    clone_div.find('#reject_yes_addbutton').attr({id: "reject_yes_addbutton" + id, onclick: "addMapFields('reject', " + id + ")"});
    clone_div.find('#append_reject_yes_data').attr({id: "append_reject_yes_data" + id});

    clone_div.find('#onhold_api_settings_id').attr({id: "onhold_api_settings_id_" + id});
    clone_div.find('#onhold_method').attr({id: "onhold_method_" + id, class: "form-control onhold-validate" + id});
    clone_div.find('#onhold_endpoint').attr({id: "onhold_endpoint_" + id, class: "form-control onhold-validate" + id});
    clone_div.find('#onhold_username').attr({id: "onhold_username_" + id, class: "form-control onhold-validate" + id});
    clone_div.find('#onhold_password').attr({id: "onhold_password_" + id, class: "form-control onhold-validate" + id});
//  clone_div.find('#onhold_xml_file').attr({id: "onhold_xml_file_" + id, class: "form-control onhold-validate" + id});
    clone_div.find('#onhold_api_key').attr({id: "onhold_api_key_" + id, class: "form-control onhold-validate" + id});

    clone_div.find('#onhold_integrated_api1').attr({id: "onhold_integrated_api_" + id});
    clone_div.find('#add_onhold_api').attr({id: "add_onhold_api_" + id, onclick: "add_api_data('onhold', " + id + ")"});
    clone_div.find('.onhold_api1').attr({name: "onhold_api_" + id, onchange: "togIntegratedApi('onhold', " + id + ", true)", class: ''});
    clone_div.find('#onhold_integrated_api_no1').attr({id: "onhold_integrated_api_no_" + id});
    clone_div.find('#onhold_command').attr({id: "onhold_command_" + id});
    clone_div.find('#onhold_command_list').attr({id: "onhold_command_list_" + id});
    clone_div.find('#onhold_command_submit').attr({id: "onhold_command_submit_" + id, onclick: "appendCommandData('onhold', " + id + ")"});
    clone_div.find('.onhold_comment').attr({name: "onhold_comment" + id, onchange: "changeIntegratedApi(" + id + ", 'onhold_comment', '')", class: ''});

    clone_div.find('#reject_api_settings_id').attr({id: "reject_api_settings_id_" + id});
    clone_div.find('#reject_method').attr({id: "reject_method_" + id, class: "form-control reject-validate" + id});
    clone_div.find('#reject_endpoint').attr({id: "reject_endpoint_" + id, class: "form-control reject-validate" + id});
    clone_div.find('#reject_username').attr({id: "reject_username_" + id, class: "form-control reject-validate" + id});
    clone_div.find('#reject_password').attr({id: "reject_password_" + id, class: "form-control reject-validate" + id});
//    clone_div.find('#reject_xml_file').attr({id: "reject_xml_file_" + id, class: "form-control reject-validate" + id});
    clone_div.find('#reject_api_key').attr({id: "reject_api_key_" + id, class: "form-control reject-validate" + id});

    clone_div.find('#reject_integrated_api1').attr({id: "reject_integrated_api_" + id});
    clone_div.find('#add_reject_api').attr({id: "add_reject_api_" + id, onclick: "add_api_data('reject', " + id + ")"});
    clone_div.find('.reject_api1').attr({name: "reject_api_" + id, onchange: "togIntegratedApi('reject', " + id + ", true)", class: ''});
    clone_div.find('#reject_command').attr({id: "reject_command_" + id});
    clone_div.find('#reject_command_list').attr({id: "reject_command_list_" + id});
    clone_div.find('#reject_command_submit').attr({id: "reject_command_submit_" + id, onclick: "appendCommandData('reject', " + id + ")"});
    clone_div.find('.reject_comment').attr({name: "reject_comment" + id, onchange: "changeIntegratedApi(" + id + ", 'reject_comment', '')", class: ''});

    clone_div.find('#reject_integrated_api_no1').attr({id: "reject_integrated_api_no_" + id});

    clone_div.find('#sbOne').attr({id: "sbOne_" + id});
    clone_div.find('#sbTwo').attr({id: "sbTwo_" + id});
    clone_div.find('#left').attr({id: "left_" + id, onclick: "leftClick(" + id + ")"});
    clone_div.find('#right').attr({id: "right_" + id, onclick: "rightClick(" + id + ")"});
    clone_div.find('#leftall').attr({id: "leftall_" + id, onclick: "leftall(" + id + ")"});
    clone_div.find('#rightall').attr({id: "rightall_" + id, onclick: "rightAll(" + id + ")"});
    
    var report_ids_or_task_id=id;
    // report_ids_or_task_id=report_ids == ''? id:report_ids;
    if(report_ids == ""){
    clone_div.find('#sendtasks').attr({id: "sendtasks_" + id, onclick: "togtaskreport('"+id+"')",class:"new"});
     }
     else{
      clone_div.find('#sendtasks').attr({id: "sendtasks_" + id, onclick: "togtaskreport('"+id+"')"});  
     }   
    // clone_div.find('.onhold_api1').attr({name: "onhold_api_" + id, onchange: "togIntegratedApi(, true)", class: ''});
    clone_div.find('#sndtsks').attr({id: "sndtsks_" + id});
    
    clone_div.find('#assignmnetinfo').attr({id: "assignmnetinfo_" +report_ids_or_task_id, class:"CheckBoxClass_"+id, onclick: "saveReportFields()"});
    clone_div.find('#operationinfo').attr({id: "operationinfo_" +report_ids_or_task_id, class:"CheckBoxClass_"+id, onclick: "saveReportFields()"});
    clone_div.find('#locationinfo').attr({id: "locationinfo_" +report_ids_or_task_id, class:"CheckBoxClass_"+id, onclick: "saveReportFields()"});
    clone_div.find('#createinfo').attr({id: "createinfo_" +report_ids_or_task_id, class:"CheckBoxClass_"+id, onclick: "saveReportFields()"});
    clone_div.find('#updateinfo').attr({id: "updateinfo_" +report_ids_or_task_id, class:"CheckBoxClass_"+id, onclick: "saveReportFields()"});
    clone_div.find('#assetinfo').attr({id: "assetinfo_" +report_ids_or_task_id, class:"CheckBoxClass_"+id, onclick: "saveReportFields()"});
    clone_div.find('#attachmentinfo').attr({id: "attachmentinfo_" +report_ids_or_task_id, class:"CheckBoxClass_"+id, onclick: "saveReportFields()"});
    clone_div.find('#customerinfo').attr({id: "customerinfo_" +report_ids_or_task_id, class:"CheckBoxClass_"+id, onclick: "saveReportFields()"});
    

    clone_div.find('#createfieldsDiv').attr({id: "createfieldsDiv" + id + ""});
    
    clone_div.find('#create_fields').attr({id: "create_fields" + id + "", onchange: "ShowSelectedEmailCategory(this)"});
    
    $('#parent_tab.tab-content').append(clone_div);
    $('#task_tab_' + id).click();
    
//   clone_div.find($('#sendtasks').attr({id: "sendtasks_" + id, onclick: "togtaskreport(id)"}));
}

function saveReportFields() {
    var name = saveReportFields.caller.arguments[0].target.id;
    var field_name = name.split('_')[0];
    
    var class_full_name = $("#"+name).attr('class');
    var class_name=class_full_name.split('_')[1];
    
    var task_type = (name.match(/\d+/g).map(Number)).toString();
    var ent_id = $('#ent_id').val();
   
        var updatedstatus='';
        var flagstatus='';
        var newtask_or_not='';
        newtask_or_not=$("#sendtasks_"+class_name).attr('class');
        
    if($('input[class="CheckBoxClass_'+class_name+'"]:checked').length > 0)
    {
        $('input[id=sendtasks_'+class_name+']').prop("checked",true);

        $("#createfieldsDiv"+class_name).attr("style", "display:block");
        
        flagstatus=1;
    }
    else
    {
        $('input[id=sendtasks_'+class_name+']').prop("checked",false);

        $("#createfieldsDiv"+class_name).attr("style", "display:none");

            flagstatus=0;
            $('label[name*="createfieldsLabel'+class_name+'"]').remove();
            $('label[name*="dub_createfieldsLabel'+class_name+'"]').remove();
        $("#create_fields"+class_name).find('option:first').attr('selected', 'selected');

    }

    if($('input[id='+name+']').is(":checked") == true) {

            updatedstatus=1
           }
           else if($('input[id='+name+']').is(":not(:checked)"))
           {
              updatedstatus=0;
           }
//    alert(updatedstatus);
    $.ajax({
        url: url + 'EntitySettingController/saveReportFields',
        type: 'post',
        data: {field_name: field_name, ent_id: ent_id, task_report_id: task_type, updatedstatus: updatedstatus,flagstatus:flagstatus,task_type_tbl_id:class_name,newtask_or_not:newtask_or_not},
        dataType: 'json',
        success: function (res) {
            alert(res);
        }
    });
}

function moveItems(origin, dest) {
    $(origin).find(':selected').appendTo(dest);
}

function moveAllItems(origin, dest) {
    $(origin).children().appendTo(dest);
}

function leftClick(id) {
    var ent_id = $('#ent_id').val();
    $('select#sbTwo_' + id + ' option:selected').each(function (i, sel) {
        var fse_type_id = $(sel).val();
        $.ajax({
            url: url + 'EntitySettingController/update_fsetype',
            type: 'post',
            data: {fse_type_id: fse_type_id, ent_id: ent_id, task_type: id},
            dataType: 'json',
            success: function (res) {
            }
        });
    });
    moveItems('#sbTwo_' + id, '#sbOne_' + id);
}
function rightClick(id) {
    var ent_id = $('#ent_id').val();
    $('select#sbOne_' + id + ' option:selected').each(function (i, sel) {
        var fse_type_id = $(sel).val();
        $.ajax({
            url: url + 'EntitySettingController/add_fsetype',
            type: 'post',
            data: {fse_type_id: fse_type_id, ent_id: ent_id, task_type: id},
            dataType: 'json',
            success: function (res) {
            }
        });
    });
    moveItems('#sbOne_' + id, '#sbTwo_' + id);
}

function leftAll(id) {
    moveAllItems('#sbTwo_' + id, '#sbOne_' + id);
}

function rightAll(id) {
    moveAllItems('#sbOne', '#sbTwo');
}

$("#parent_nav.nav-tabs").on("click", "span", function () {
    if (confirm('Are you sure you want to delete this item?')) {
        var that = $(this);

        var task_id = $(this).parent().data('tab');
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/remove_task_type',
            type: 'post',
            dataType: 'json',
            data: {task_id: task_id},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    var anchor = that.siblings('a');
                    $(anchor.attr('href')).remove();
                    $(".nav-tabs li").children('a').first().click();
                    for (var j = 0; j < tabs.length; j++) {
                        if (task_id == tabs[j].id) {
                            tabs.splice(j, 1);
                            that.parent().remove();
                            break;
                        }
                    }
                    appendTaskDependency('', true);
                    showInformation('success', res.success);
                } else {
                    showInformation('error', res.error);
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
});

function addCategory(id) {
    var category = $('#category_add_' + id).val();
    var ent_id = $('#ent_id').val();
    if (category) {
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/add_category',
            type: 'post',
            data: {category: category, ent_id: ent_id, task_type: id},
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    $('#category_add_' + id).css('border-color', '');
                    $('#category_add_' + id).val('');
                    var cat = {id: res.id, category: res.category, ent_id: ent_id, task_type: res.task_type};
                    categories.unshift(cat);
                    showCategories();
                    showInformation('success', res.success);
                } else {
                    showInformation('error', res.error);
                }
                $('#divLoading').removeClass('show');
            },
            error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    } else {
        $('#category_add_' + id).css('border-color', 'red');
    }
// Start =================== add this function for without refreshing page the get content    
//    getTabDetails();
//    showReportFields();
// end ===============================================================================
}
function addAttachment(id) {
    var category = $('#attachment_add_' + id).val();
    var ent_id = $('#ent_id').val();
    if (category) {
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/add_category',
            type: 'post',
            data: {category: category, ent_id: ent_id, task_type: id},
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    $('#category_add_' + id).css('border-color', '');
                    $('#category_add_' + id).val('');
                    var cat = {id: res.id, category: res.category, ent_id: ent_id, task_type: res.task_type};
                    categories.unshift(cat);
                    showCategories();
                    showInformation('success', res.success);
                } else {
                    showInformation('error', res.error);
                }
                $('#divLoading').removeClass('show');
            },
            error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    } else {
        $('#category_add_' + id).css('border-color', 'red');
    }
}

$('body').on('click', ".removecategory", function () {
    if (confirm('Are you sure you want to delete this category?')) {
        var that = $(this).closest('tr');
        var cat_id = $(this).data('category_id');
        var separate_update_screen = 0;
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/update_category',
            type: 'post',
            data: {cat_id: cat_id, separate_update_screen: separate_update_screen, rem: 1},
            dataType: 'json',
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.error) {
                    showInformation('error', res.error);
                } else {
                    for (var j = 0; j < categories.length; j++) {
                        if (cat_id == categories[j].id) {
                            categories.splice(j, 1);
                            that.remove();
                            break;
                        }
                    }
                    showCategories();
                    showMappingData(cat_id, 'category');
                    showInformation('success', res.success);
                }
            },
            error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
});

function showMappingData(id, type) {
    var option = '', attr_id = [], extr_att_id = [];

    var j = create_no.length;
    while (j--) {
        if (attr_id.indexOf(create_no[j].Task_type_ID) == -1) {
            $("#create_map_fields" + create_no[j].Task_type_ID).find('option').not(':first').remove();
//            $("#update_map_fields" + create_no[j].Task_type_ID).find('option').not(':first').remove();
            $("#assets_map_fields" + create_no[j].Task_type_ID).find('option').not(':first').remove();
            $("#onhold_map_fields" + create_no[j].Task_type_ID).find('option').not(':first').remove();
            $("#reject_map_fields" + create_no[j].Task_type_ID).find('option').not(':first').remove();
            attr_id.push(create_no[j].Task_type_ID);
        }

        /*var tmp_id = '';
         if (type == 'category') {
         tmp_id = create_no[j].Ext_att_category_id;
         } else if (type == 'create') {
         tmp_id = create_no[j].extr_att_id;
         if (extr_att_id.length == 0) {
         extr_att_id.push(id);
         }
         }
         
         if (id == tmp_id) {
         $("#remove_id" + create_no[j].extr_att_id + "").closest("tr").remove();
         if (type == 'category') {
         extr_att_id.push(create_no[j].extr_att_id);
         }
         create_no.splice(j, 1);
         } else {
         option += "<option value='" + create_no[j].extr_att_id + "'>" + create_no[j].Ext_att_name + "</option>";
         }*/

        if (id == create_no[j].Ext_att_category_id) {
            $("#remove_id" + create_no[j].extr_att_id + "").closest("tr").remove();
            extr_att_id.push(create_no[j].extr_att_id);
            create_no.splice(j, 1);
        } else {
            option += "<option value='" + create_no[j].extr_att_id + "'>" + create_no[j].Ext_att_name + "</option>";
        }
    }

    option += '<option value="" selected>Select</option>';
    mapSelAlign(option);

    var k = create_yes_list.length;
    while (k--) {
        for (var i in extr_att_id) {
            if (extr_att_id[i] == create_yes_list[k].API_Field) {
                $('#append_create_yes_data' + create_yes_list[k].task_type).find('tr').slice(1).remove();
                create_yes_list.splice(k, 1);
                showMapFields('create', create_yes_list);
                break;
            }
        }
    }
    /*var k = update_yes_list.length;
     while (k--) {
     for (var i in extr_att_id) {
     if (extr_att_id[i] == update_yes_list[k].API_Field) {
     $('#append_update_yes_data' + update_yes_list[k].task_type).find('tr').slice(1).remove();
     update_yes_list.splice(k, 1);
     showMapFields('update', update_yes_list);
     break;
     }
     }
     }*/
    var k = assets_yes_list.length;
    while (k--) {
        for (var i in extr_att_id) {
            if (extr_att_id[i] == assets_yes_list[k].API_Field) {
                $('#append_assets_yes_data' + assets_yes_list[k].task_type).find('tr').slice(1).remove();
                assets_yes_list.splice(k, 1);
                showMapFields('assets', assets_yes_list);
                break;
            }
        }
    }
    var k = onhold_yes_list.length;
    while (k--) {
        for (var i in extr_att_id) {
            if (extr_att_id[i] == onhold_yes_list[k].API_Field) {
                $('#append_onhold_yes_data' + onhold_yes_list[k].task_type).find('tr').slice(1).remove();
                onhold_yes_list.splice(k, 1);
                showMapFields('onhold', onhold_yes_list);
                break;
            }
        }
    }
    var k = reject_yes_list.length;
    while (k--) {
        for (var i in extr_att_id) {
            if (extr_att_id[i] == reject_yes_list[k].API_Field) {
                $('#append_reject_yes_data' + reject_yes_list[k].task_type).find('tr').slice(1).remove();
                reject_yes_list.splice(k, 1);
                showMapFields('reject', reject_yes_list);
                break;
            }
        }
    }

    var k = engineertype_yes_list.length;
    while (k--) {
        for (var i in extr_att_id) {
            if (extr_att_id[i] == engineertype_yes_list[k].API_Field) {
                $('#append_engineertype_yes_data' + engineertype_yes_list[k].task_type).find('tr').slice(1).remove();
                engineertype_yes_list.splice(k, 1);
                showMapFields('engineertype', engineertype_yes_list);
                break;
            }
        }
    }
    var k = taskreport_yes_list.length;
    while (k--) {
        for (var i in extr_att_id) {
            if (extr_att_id[i] == taskreport_yes_list[k].API_Field) {
                $('#append_taskreport_yes_data' + taskreport_yes_list[k].task_type).find('tr').slice(1).remove();
                taskreport_yes_list.splice(k, 1);
                showMapFields('taskreport', taskreport_yes_list);
                break;
            }
        }
    }
}

function mapSelAlign(option) {
    for (var i = 0; i < create_no.length; i++) {
        $("#create_map_fields" + create_no[i].Task_type_ID).html(option);
        var create_map_fields = $("#create_map_fields" + create_no[i].Task_type_ID);
        var c_opt = create_map_fields.children().toArray().reverse();
        create_map_fields.html(c_opt);

        /*$("#update_map_fields" + create_no[i].Task_type_ID).html(option);
         var update_map_fields = $("#update_map_fields" + create_no[i].Task_type_ID);
         var u_opt = update_map_fields.children().toArray().reverse();
         update_map_fields.html(u_opt);*/

        $("#assets_map_fields" + create_no[i].Task_type_ID).html(option);
        var assets_map_fields = $("#assets_map_fields" + create_no[i].Task_type_ID);
        var a_opt = assets_map_fields.children().toArray().reverse();
        assets_map_fields.html(a_opt);

        $("#onhold_map_fields" + create_no[i].Task_type_ID).html(option);
        var onhold_map_fields = $("#onhold_map_fields" + create_no[i].Task_type_ID);
        var o_opt = onhold_map_fields.children().toArray().reverse();
        onhold_map_fields.html(o_opt);

        $("#reject_map_fields" + create_no[i].Task_type_ID).html(option);
        var reject_map_fields = $("#reject_map_fields" + create_no[i].Task_type_ID);
        var r_opt = reject_map_fields.children().toArray().reverse();
        reject_map_fields.html(r_opt);
    }
}
function togAttach_IntegratedApi(type, id, updateStatus) {
//    alert($("input[name=" + type + "_api_" + id + "]").is(":checked"));
    
    var value2='';
    var value = $("input[name=" + type + "_api_" + id + "]:checked").val();
    if (type != '' && id != '') {
//        alert($("input[name=" + type + "_api_" + id + "]").is(":checked"))
     if($("input[name=" + type + "_api_" + id + "]").is(":checked"))
        {
            value2=1;
        }
        else if($("input[name=" + type + "_api_" + id + "]").is(":not(:checked)"))
        {
            value2=0;
        }
//        attachment_status
 if($("input[name=" + type + "" + id + "]").is(":checked"))
        {
            value2=1;
        }
        else if($("input[name=" + type + "" + id + "]").is(":not(:checked)"))
        {
            value2=0;
        }        
//        alert("value2--"+value2);
            if (updateStatus) {
             changeIntegratedApi(id, type, value2);
         }
         if (value2 == 1) {
            $('#' + type + '_integrated_api_no_' + id).hide();
            $('#' + type + '_integrated_api_' + id).show();
        } else {
            $('#' + type + '_integrated_api_' + id).hide();
            $('#' + type + '_integrated_api_no_' + id).show();
        }
        
        if (type == 'create') {
            $("input[name=complete_api_" + id + "][value=" + value + "]").prop('checked', true);
        }
        if (type == 'update') {
            if (value == 1) {
                $('table .append_update_data_' + id).show();
            } else {
                $('table .append_update_data_' + id).hide();
            }
        }
    }
}

function togIntegratedApi(type, id, updateStatus) {
    if (type != '' && id != '') {
        var value = $("input[name=" + type + "_api_" + id + "]:checked").val();
// alert(type+'---'+id);
        if (updateStatus) {
            changeIntegratedApi(id, type, value);
        }

        if (value == 1) { 
            // update_integrated_api
            $('#' + type + '_integrated_api_no_' + id).hide();
            $('#' + type + '_integrated_api_' + id).show();
           
                    if(type == "authmach_update")
                    {
                        $('#div_update_integrated_api_' + id).hide();
                        $('#' + type + '_t_integrated_api_' + id).show();
                    }
            
        } else {
            $('#' + type + '_integrated_api_' + id).hide();
            $('#' + type + '_integrated_api_no_' + id).show();
                    if(type == "authmach_update")
                    {   
                         // $('#' + type + '_integrated_api_' + id).show();             
                         $('#div_update_integrated_api_' + id).show();
                        $('#' + type + '_t_integrated_api_' + id).hide();
                    }
        }

        if (type == 'create') {
            $("input[name=complete_api_" + id + "][value=" + value + "]").prop('checked', true);
        }
        if (type == 'update') {
            if (value == 1) {
                $('table .append_update_data_' + id).show();
            } else {
                $('table .append_update_data_' + id).hide();
            }
        }
        // if (type == 'authmach_update') {
        //     if (value == 1) {
        //         $('table .append_update_data_' + id).show();
        //     } else {
        //         $('table .append_update_data_' + id).hide();
        //     }
        // }
        // authmachanism_postback_update_div_
        // authmach_update_api_
        // authmach_update
    }
}

function changeIntegratedApi(id, type, value) {
//    alert(value)

    if (value == null || value == '') {
        var value = $("input[name=" + type + "" + id + "]:checked").val();
    }
    //alert(value);
    $('#divLoading').addClass('show');
    $.ajax({
        url: url + 'EntitySettingController/update_task_type',
        type: 'post',
        dataType: 'json',
        data: {task_id: id, type: type, value: value},
        success: function (res) { 
            $('#divLoading').removeClass('show');
            if (res.success) {
                showInformation('success', res.success);
            } else {
                showInformation('error', 'Something went wrong! Please try again!');
            }
        }, error: function (error) {
            $('#divLoading').removeClass('show');
            showInformation('error', 'Something went wrong! Please try again!');
        }
    });
}

function add_asset_value(id) {
    var error = 0;
    $("input.assets-no-validate" + id).each(function () {
        if (this.value == "") {
            $(this).css('border-color', 'red');
            error = 1;
        } else {
            $(this).css('border-color', '');
        }
    });

    if (error == 0) {
        $('#divLoading').addClass('show');

        var ent_id = $('#ent_id').val();
        var asset_display_name = $("#asset_display_name_" + id).val();
        var asset_type = $("#asset_type_" + id).val();
        var asset_description = $("#asset_description_" + id).val();

        $.ajax({
            url: url + 'EntitySettingController/add_asset',
            type: 'post',
            data: {ent_id: ent_id, task_type: id, display_name: asset_display_name, type: asset_type, description: asset_description},
            dataType: 'json',
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.error) {
                    showInformation('error', res.error);
                } else {
                    var asset_html = "<tr><td>" + asset_display_name + "</td><td>" + asset_type + "</td><td>" + asset_description + "</td><td><span class='glyphicon glyphicon-remove removeasset' data-asset='" + res.id + "'></span></td></tr>"
                    $('#append_asset_data_' + id).append(asset_html);
                    /*$("#asset_display_name_" + id).val('');
                     $("#asset_type_" + id).val('');
                     $("#asset_description_" + id).val('');*/
                    $("input.assets-no-validate" + id).val('');
                    showInformation('success', res.success);
                }
            },
            error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
}

function showDepondOn() {

    var table_id = [];
    for (var j = 0; j < getUpdateTabDepondOn.length; j++) {
        if (table_id.indexOf(getUpdateTabDepondOn[j].task_type) == -1) {
            table_id.push(getUpdateTabDepondOn[j].task_type);
            $('#update_field_dependOn_' + getUpdateTabDepondOn[j].task_type).empty().append('<option value="">Select Depond On</option>');
        }
        var update_field_dependOn_html = '';
        var id = getUpdateTabDepondOn[j].task_type;
        update_field_dependOn_html += '<option value="' + getUpdateTabDepondOn[j].label + '">' + getUpdateTabDepondOn[j].label + '</option>';
        $('#update_field_dependOn_' + id).append(update_field_dependOn_html);
    }
}

function showCategories() {
    var table_id = [];
    for (var j = 0; j < categories.length; j++) {
        if (table_id.indexOf(categories[j].task_type) == -1) {
            table_id.push(categories[j].task_type);
            $('#category_table_' + categories[j].task_type).find("tr:not(:first)").remove();
            $('#create_category' + categories[j].task_type).empty().append('<option value="">Select Category</option>');
            $('#update_tab_category_' + categories[j].task_type).empty().append('<option value="">Select Category</option>');
           // $('#attachment_category' + categories[j].task_type).empty().append('<option value="">Select Category</option>');
            
        }
        var htm = '', category_select_htm = '';
        var id = categories[j].task_type;
        htm += '<tr><td>' + categories[j].category + '</td>';
        htm += '<td><input type="checkbox" class="separate_update_screen" data-category_id ="' + categories[j].id + '"';
        category_select_htm += '<option value="' + categories[j].id + '">' + categories[j].category + '</option>';

        if (categories[j].separate_update_screen > 0) {
            htm += ' checked ';
        }
        htm += '></td>';
        htm += '<td><span class="glyphicon glyphicon-remove removecategory" data-category_id ="' + categories[j].id + '"></span></td></tr>';
        $('#category_table_' + id).append(htm);
        $('#create_category' + id).append(category_select_htm);
        $('#update_tab_category_' + id).append(category_select_htm);
       // $('#attachment_category' + id).append(category_select_htm);
        
    }
}

function showFseTypes1() {

    for (var k = 0; k < fse_types1.length; k++) {
        var id = fse_types1[k].task_type;
//        alert("id"+id);
        fse_types_arr = fse_types1[k].taskbylist;
        var category_select_htm = '';

        for (var p = 0; p < fse_types_arr.length; p++) {
            var category_select_htm = '';
            
            category_select_htm += '<option value="' + fse_types_arr[p].id + '">' + fse_types_arr[p].fse_type + '</option>';
            $('#sbOne_' + id).append(category_select_htm);
        }
//        alert(fse_types_arr[p].id);
    }

}

function showFseTypes() {
    for (var j = 0; j < fse_types.length; j++) {
        var id = fse_types[j].task_type;
        var category_select_htm = '';
        category_select_htm += '<option value="' + fse_types[j].fse_type_id + '">' + fse_types[j].fse_type + '</option>';
        $('#sbTwo_' + id).append(category_select_htm);
    }
}



//setInterval(function(){showReportFields();}, 1000);
function showReportFields() { 
        var setreportflagIsZero = 0;
    var table_id = [];
// =====================================    
        var ent_id = $('#ent_id').val();
    $.ajax({
        url: url + 'EntitySettingController/getTabLabelDetails',
        type: 'post',
        data: {ent_id: ent_id},
        dataType: 'json',
        success: function (res) {           
            if (res.error) {
                showInformation('error', res.error);
            } else {
                tabs = res.task_type_for_report_fileds;                    
                reportflag = res.reportflag;
                reportfields = res.reportfields;
                createfields = res.createfields;
                oldcreatedEmailReportfields = res.oldcreatedEmailReportfields;

                    // End ======================================    
//                        alert("fdfdfdf"+createfields.length);
                        for (var j = 0; j < createfields.length; j++) {
                            if (table_id.indexOf(createfields[j].task_type) == -1) {
                                table_id.push(createfields[j].task_type);
                                $('#create_fields' + createfields[j].task_type).empty().append('<option value="">Choose fields containing email address</option>');
                            }
                            var createfields_select_htm = '';
                            var id = createfields[j].task_type;
                            createfields_select_htm += '<option id="' + createfields[j].id + '" value="' + createfields[j].extr_att_id + '">' + createfields[j].Ext_att_name + '</option>';    
                            $('#create_fields' + id).append(createfields_select_htm);
//                            alert(createfields[j].Ext_att_name);
//                            $("#create_fieldsLabel").attr({id : "create_fieldsLabel_"+id});
//                            $("#create_fields" + id).after('<label class="createfieldslabels" id="create_fieldsLabel'+createfields[j].extr_att_id+'" name="createfieldsLabel[]" onclick="deletethis(this);"  style="display:none;"><i class="fa fa-remove"></i></label>');
//                            $("#create_fields" + id).after('<label class="dub_createfieldslabels" id="dub_create_fieldsLabel'+createfields[j].extr_att_id+'" name="createfieldsLabel[]" onclick="deletethis(this);" style="display:none;" > </label>');
                        }

  //==============================================================================================================                        
                         for (var l = 0; l < oldcreatedEmailReportfields.length; l++) {  
                             var oldEmailid = oldcreatedEmailReportfields[l].task_type_id;
//                             
                            $("#create_fields" + oldEmailid).after('<label class="createfieldslabels" id="create_fieldsLabel'+oldcreatedEmailReportfields[l].extr_att_id+'" name="createfieldsLabel'+oldEmailid+'" >'+oldcreatedEmailReportfields[l].Ext_att_name+' <i class="fa fa-remove emaillabelremove" id='+oldcreatedEmailReportfields[l].extr_att_id+'_'+oldEmailid+' name='+oldEmailid+' onclick="deletethis(this);"></i></label>');
                            $("#create_fields" + oldEmailid).after('<label class="dub_createfieldslabels" id="dub_create_fieldsLabel'+oldcreatedEmailReportfields[l].extr_att_id+'" name="dub_createfieldsLabel'+oldEmailid+'" onclick="deletethis1(this);" style="display:none" hidden>'+oldcreatedEmailReportfields[l].extr_att_id+' </label>');
                            $("#createfieldsDiv"+reportflagid).attr("style", "display:block");
   
    }
                                     
  //==============================================================================================================
                        // var ids = '';
//                         alert(reportfields.length);
                        //for (var i = 0; i < tabs.length; i++) {
                        for (var rp = 0; rp < reportfields.length; rp++) {
                             var ids = reportfields[rp].task_type_id;

                           //alert(rp+'-'+ids+','+reportfields[rp].assignmnetinfo);
                    //============= old code issue in assetinfo ...is getting wrong status value......
                    //        $('#assignmnetinfo_' + ids).attr('checked', reportfields[j].assetinfo == 1 ? true : false);
                    //============= new code issue solve in assetinfo ...is getting wrong status value......
                            $('#assignmnetinfo_' + ids).attr('checked', reportfields[rp].assignmnetinfo == 1 ? true : false);
                    //============= ===============================......        
                    // alert($('#assignmnetinfo_' + ids).is("checked"));
                            $('#operationinfo_' + ids).attr('checked', reportfields[rp].operationinfo == 1 ? true : false);
                            $('#locationinfo_' + ids).attr('checked', reportfields[rp].locationinfo == 1 ? true : false);
                            $('#createinfo_' + ids).attr('checked', reportfields[rp].createinfo == 1 ? true : false);
                            $('#updateinfo_' + ids).attr('checked', reportfields[rp].updateinfo == 1 ? true : false);
                            $('#assetinfo_' + ids).attr('checked', reportfields[rp].assetinfo == 1 ? true : false);
                            $('#attachmentinfo_' + ids).attr('checked', reportfields[rp].attachmentinfo == 1 ? true : false);
                            $('#customerinfo_' + ids).attr('checked', reportfields[rp].customerinfo == 1 ? true : false);
                    //        alert( id);
                    
                        }
                        var reportflagid = ''; 
                        //==============================================================================================================
                     for (var k = 0; k < reportflag.length; k++) {
                              
                           
//                         if (reportflag[k].report_flag > 0) {
                            
//                              reportflagid = reportflag[k].task_type_id;
// //                            alert(reportflag[k].task_type_id);
//                             $('input[id=sendtasks_'+reportflag[k].task_type_id+']').prop("checked",true);

//                             $('#sendtasks_'+reportflag[k].task_type_id).attr({onclick: "togtaskreport('"+reportflagid+"')", checked: "checked",obj:reportflag[k].task_type_id });
                            
//                     //        clone_div.find('#sendtasks').attr({id: "sendtasks_" + id, onclick: "togtaskreport(id)", checked: "checked"});
//                         }
//                         else 
//                         {
//                             reportflagid = reportflag[k].task_type_id;
//                     //        alert(reportflagid);
//                               $('input[id=sendtasks_'+reportflag[k].task_type_id+']').prop("checked",false);
//                             $('#sendtasks_'+reportflag[k].task_type_id).attr({onclick: "togtaskreport('"+reportflagid+"')", checked: "unchecked",obj:reportflag[k].task_type_id });
                            
//                         }

//                     //    $('#sndtsks').attr({id: "sndtsks_" + reportflagid});
                   
//                         if ($('input[id=sendtasks_'+reportflag[k].task_type_id+']').is(":checked"))   {

//                             $("#sndtsks_" + reportflag[k].task_type_id).attr("style", "display:block");
//                             $("#createfieldsDiv"+reportflag[k].task_type_id).attr("style", "display:block");

//                         }
//                         else if ($('input[id=sendtasks_'+reportflag[k].task_type_id+']').is(":not(:checked)"))
//                         {
//                             $("#sndtsks_" + reportflag[k].task_type_id).attr("style", "display:none");
//                             $("#createfieldsDiv"+reportflag[k].task_type_id).attr("style", "display:none");
//                         }
                         // createfieldsDiv
                           if (reportflag[k].report_flag > 0) {
                            reportflagid = reportflag[k].task_type_id;
//                            alert(reportflag[k].task_type_id);
                            $('input[id=sendtasks_'+reportflag[k].task_type_id+']').prop("checked",true);

                            $('#sendtasks_'+reportflag[k].task_type_id).attr({onclick: "togtaskreport('"+reportflagid+"')", checked: "checked",obj:reportflag[k].task_type_id });
                            
                    //        clone_div.find('#sendtasks').attr({id: "sendtasks_" + id, onclick: "togtaskreport(id)", checked: "checked"});
                        }
                        else 
                        {
                            reportflagid = reportflag[k].task_type_id;
                    //        alert(reportflagid);
                              $('input[id=sendtasks_'+reportflag[k].task_type_id+']').prop("checked",false);
                            $('#sendtasks_'+reportflag[k].task_type_id).attr({onclick: "togtaskreport('"+reportflagid+"')", checked: "unchecked",obj:reportflag[k].task_type_id });
                            
                        }

                    //    $('#sndtsks').attr({id: "sndtsks_" + reportflagid});
                   
                        if ($('input[id=sendtasks_'+reportflagid+']').is(":checked"))   {

                            $("#sndtsks_" + reportflagid).attr("style", "display:block");
                            $("#createfieldsDiv"+reportflagid).attr("style", "display:block");

                        }
                        else if ($('input[id=sendtasks_'+reportflagid+']').is(":not(:checked)"))
                        {
                            $("#sndtsks_" + reportflagid).attr("style", "display:none");
                            $("#createfieldsDiv"+reportflagid).attr("style", "display:none");
                        }
                     }
 
             }
        }, error: function (error) {
//            $('#divLoading').removeClass('show');
//            showInformation('error', 'Something went wrong! Please try again!');
        },
    });
//==============================================================================================================
}
//-----------------------------------------------------
function showEngineerRelatedFields() { 

       $('#divLoading').addClass('show');
    var ent_id = $('#ent_id').val();
//    alert(ent_id);
    $.ajax({
        url: url + 'EntitySettingController/getTabDetails',
        type: 'post',
        data: {ent_id: ent_id},
        dataType: 'json',
        success: function (res) {
            $('#divLoading').removeClass('show');
            if (res.error) {
                showInformation('error', res.error);
            } else {

                fse_types1 = res.allfsetypes;
                fse_cnt = res.allfsetypes_cnt;
                fse_types = res.fse_type_id;

                showFseTypes1();
                showFseTypes();

            }
        }, error: function (error) {
            $('#divLoading').removeClass('show');
            showInformation('error', 'Something went wrong! Please try again!');
        },
    });
}
//==============================================================================================================

// Start ===============  create email attachments label =======================================
 function ShowSelectedEmailCategory(emailCate) 
 {
var addmorefields='';
var createfieldslabelsText='';
var flagforrepeatedFields="false";
var createfieldslabelslenth=$(".dub_createfieldslabels");
   
   var selectedText = $("#"+emailCate.id).find("option:selected").text();
//   var dropd = v("#"+emailCate.id);
   var Reportid = $("#"+emailCate.id+" option:selected").attr("id");



//alert(emailCate.id);
     if(emailCate.value != "")
     {
         var splitFields=createfieldslabelslenth.text().split(' ');
         for(i=0; i < createfieldslabelslenth.length; i++)
         {            
//         alert(splitFields[i]);
         if(emailCate.value === splitFields[i])
         {
              flagforrepeatedFields="true";
              return false;
         }         
         else
         {
              flagforrepeatedFields="false";
         }

     }
//         alert(flagforrepeatedFields); 
         if(flagforrepeatedFields == "false"){
             
createfieldslabelsText= $("#"+emailCate.id).find("option:selected").text();   
         addmorefields=emailCate.value;
         
 var name = ShowSelectedEmailCategory.caller.arguments[0].target.id;
    var EmailFieldsId=addmorefields;
    var field_name = name.split('_')[0];
    var task_type = (name.match(/\d+/g).map(Number)).toString();
             
          
           $("#"+emailCate.id).after('<label class="createfieldslabels" id="create_fieldsLabel'+emailCate.value+'" name="createfieldsLabel'+task_type+'" >'+createfieldslabelsText+' <i class="fa fa-remove emaillabelremove" id='+emailCate.value+'_'+task_type+' name='+task_type+' onclick="deletethis(this);"></i></label>');
           $("#"+emailCate.id).after('<label class="dub_createfieldslabels" id="dub_create_fieldsLabel'+emailCate.value+'" name="dub_createfieldsLabel'+task_type+'" onclick="deletethis1(this);" style="display:none" hidden>'+addmorefields+' </label>');

             //-------------------------- new vars===================================

    var ent_id = $('#ent_id').val();
//   alert("1-"+EmailFieldsId+",-- 2-"+createfieldslabelsText+",-- 3-"+field_name+",-- 4-"+ent_id+",-- 5-"+task_type);
            $.ajax({
                url: url + 'EntitySettingController/saveTaskEmailReportFields',
                type: 'post',
                data: {EmailFieldsId: EmailFieldsId, createdEmailfieldsTextName : createfieldslabelsText, field_name: field_name, ent_id: ent_id, task_type: task_type, Reportid: Reportid},
                dataType: 'json',
                success: function (res) {
                    alert(res);
                }
            });
       }
 
       
     }
     else
     {
//       alert("empty");  
     }
 }
 function deletethis(del)
 {


//    var name = ShowSelectedEmailCategory.caller.arguments[0].target.id;
//    var EmailFieldsId=addmorefields;
    var idval = del.id;
    var field_id1 = idval.split('_')[0];
    var field_id2 = idval.split('_')[1];     
    var EmailFieldsId = (field_id1.match(/\d+/g).map(Number)).toString();
    
    var task_type2 = (field_id2.match(/\d+/g).map(Number)).toString();
//    alert(task_type1+'--'+task_type2);
     $("#create_fieldsLabel"+EmailFieldsId).remove();
     $("#dub_create_fieldsLabel"+EmailFieldsId).remove();

    var actiontype='delete';
    var ent_id = $('#ent_id').val();
//    $("#create_fields"+name).val()
//    document.getElementById("create_fields"+name).value="";
    $("#create_fields"+task_type2).find('option:first').attr('selected', 'selected');
//    $("#create_fields"+del.name).get(0).selectedIndex = 0;

            $.ajax({
                url: url + 'EntitySettingController/saveTaskEmailReportFields',
                type: 'post',
                data: {EmailFieldsId: EmailFieldsId, actiontype :actiontype },
                dataType: 'json',
                success: function (res) {
                    alert(res);                    
                }
            });
            
 }
// end ===============  create email attachments label =======================================
$('body').on('click', '.separate_update_screen', function () {
    var cat_id = $(this).data('category_id');
    var separate_update_screen = 0;
    if ($(this).prop('checked')) {
        separate_update_screen = 1;
    }
    $('#divLoading').addClass('show');
    $.ajax({
        url: url + 'EntitySettingController/update_category',
        type: 'post',
        data: {cat_id: cat_id, separate_update_screen: separate_update_screen},
        dataType: 'json',
        success: function (res) {
            $('#divLoading').removeClass('show');
            if (res.error) {
                showInformation('error', res.error);
            } else {
                showInformation('success', res.success);
            }
        },
        error: function (error) {
            $('#divLoading').removeClass('show');
            showInformation('error', 'Something went wrong! Please try again!');
        }
    });
});

function upload_csv(id) {
    var ent_id = $('#ent_id').val();
    var files = $('#asset_upload_csv_' + id)[0].files;
    var file_name = $('#asset_upload_csv_' + id)[0].files[0].name;
    var ext = file_name.split('.');
    if (ext[1].toLowerCase() == 'csv') {
        $('#asset_upload_csv_' + id).css('border-color', '');
        var formData = new FormData();
        $.each(files, function (key, value)
        {
            formData.append(key, value);
        });
        formData.append('ent_id', ent_id);
        formData.append('task_type', id);

        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/upload_csv',
            enctype: 'multipart/form-data',
            type: 'post',
            data: formData,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    var htm = '';
                    for (var i = 0; i < res.data.length; i++) {
                        htm += "<tr><td>" + res.data[i].display_name + "</td><td>" + res.data[i].type + "</td><td>" + res.data[i].description + "</td><td><span class='glyphicon glyphicon-remove removeasset' data-asset='" + res.data[i].id + "'></span></td></tr>";
                    }
                    $('#append_asset_data_' + id).append(htm);
                    showInformation('success', res.success);
                } else {
                    showInformation('error', 'Something went wrong! Please try again!');
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    } else {
        $('#asset_upload_csv_' + id).css('border-color', 'red');
    }
}

function create_not_integrate(id) {
    var create_label = document.getElementById("create_label" + id).value;
    var dependent_value = document.getElementById("task_dependency_" + id).value;
    var create_field_type = document.getElementById("create_field_type" + id).value;
    var create_limit = document.getElementById("create_limit" + id).value;
    var create_category = document.getElementById("create_category" + id).value;
    var create_category = document.getElementById("create_category" + id).value;
    var ent_id = $('#ent_id').val();
    if (create_label == "") {
        $("#create_label" + id).css('border-color', 'red');
        error = 1;
    } else {
        $("#create_label" + id).css('border-color', '');
    }
    if (create_field_type == "") {
        $("#create_field_type" + id).css('border-color', 'red');
        error = 2;
    } else {
        $("#create_field_type" + id).css('border-color', '');
    }
    if (create_limit == "") {
        $("#create_limit" + id).css('border-color', '');
        //  $("#create_limit" + id).css('border-color', 'red');
        //  error = 3;
    } else {
        $("#create_limit" + id).css('border-color', '');
    }
    if (create_category == "") {
        $("#create_category" + id).css('border-color', 'red');
        error = 4;
    } else {
        $("#create_category" + id).css('border-color', '');
    }

    if (create_label != "" && create_field_type != "" && create_category != "") {
        var create_addupdate_value = '';
        var tmps = [];
        if (create_field_type == "SELECT" || create_field_type == "CHECKBOX" || create_field_type == "RADIO") {
            tmps = create_update_select_data;
        }
//----------------------------------------------------------
              if ($("#create_addtoupdate_api"+ id).is(":not(:checked)")) {
            //        $("#attachment_mandatory" + temp_id).css('border-color', 'red');
                   create_addupdate_value=0;
            //        error = 4;
                } else if ($("#create_addtoupdate_api"+ id).is(":checked")) {
            //        $("#attachment_mandatory" + temp_id).css('border-color', '');
                        create_addupdate_value=1;
                }
                // alert(create_addupdate_value);
//----------------------------------------------------------
        var formData = {
            'ent_id': ent_id,
            'task_id': id,
            'label': create_label,
            'field_type': create_field_type,
            'limit': create_limit,
            'category': create_category,
            'task_type': id,
            'value': JSON.stringify(tmps),
            'dependent_value': dependent_value,
            'create_addupdate_value':create_addupdate_value
        };


        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/create_not_integrated',
            type: 'post',
            data: formData,
            async: true, //blocks window close
            dataType: 'json',
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    var selCategoryText = $("#create_category" + id + " option:selected").text();
                    
                    var res_qm_attr_addupdate_value='';
                    create_no.push(res);
                    if(res.qm_attr_addupdate_value == '1') {res_qm_attr_addupdate_value='Y';}else {res_qm_attr_addupdate_value='N';}
                    
                    var htm = '<tr><td>' + res.Ext_att_name + '</td><td>' + res.Ext_att_type + '</td><td>' + res.Ext_att_size + '</td><td>' + selCategoryText + '</td><td>'+res_qm_attr_addupdate_value+'</td><td><span id="remove_id' + res.extr_att_id + '" onclick="remove_row(' + res.extr_att_id + ')" name='+id+' class="glyphicon glyphicon-remove"></span></td></tr>';
                    $("#create_table_" + id + "  tbody").append(htm);

                    document.getElementById("create_label" + id).value = "";
                    document.getElementById("create_field_type" + id).value = "";
                    document.getElementById("create_limit" + id).value = "";
                    document.getElementById("create_category" + id).value = "";
                    var option = '<option value="' + res.extr_att_id + '">' + res.Ext_att_name + '</option>';
                    
                     var createfields_select_htm = '<option id="' + res.Ext_att_category_id + '" value="' + res.extr_att_id + '">' + res.Ext_att_name + '</option>';    
                    $("#create_map_fields" + id).append(option);
//                    $("#update_map_fields" + id).append(option);
                    $("#assets_map_fields" + id).append(option);
                    $("#onhold_map_fields" + id).append(option);
                    $("#reject_map_fields" + id).append(option);
                    $("#create_fields" + id).append(createfields_select_htm);
                    create_update_select_data = [];
                    $('#create_select_integrated_no_' + id).hide();
                    $('#created_add_not_integrated' + id).show();
                    $('#create_select_data_' + id).html('');
                    createtoggleIntegrate('select', id)
                    
                   
                } else {
                    showInformation('error', 'Something went wrong! Please try again!');
                }
//                 $("#create_fieldsLabel"+id).remove();
//                    $("#dub_create_fieldsLabel"+id).remove();
//                showReportFields();
            },
            error: function () {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
}
function attachment_not_integrate(temp_id) {
    var attachment_label = document.getElementById("attachment_label" + temp_id).value;
//   alert(id);
    var attachment_field_type = document.getElementById("attachment_field_type" + temp_id).value;
    var attachment_limit = document.getElementById("attachment_limit" + temp_id).value;
    var attachment_mandatory = document.getElementById("attachment_mandatory" + temp_id);
//    attachment_limit
//    alert($("#attachment_mandatory"+ temp_id).is(":checked"));
   // var attachment_category = document.getElementById("attachment_category" +temp_id).value;
    var attachment_category = '0';
    var attachment_mandatory = '0';
//    alert(attachment_category);
//    document.getElementById("attachment_category" ).value;
    var ent_id = $('#ent_id').val();
//    alert(ent_id);
    if (attachment_label == "") {
        $("#attachment_label" + temp_id).css('border-color', 'red');
        error = 1;
    } else {
        $("#attachment_label" + temp_id).css('border-color', '');
    }
    if (attachment_field_type == "") {
        $("#attachment_field_type" + temp_id).css('border-color', 'red');
        error = 2;
    } else {
        $("#attachment_field_type" + temp_id).css('border-color', '');
    }
    if (attachment_limit == "") {
        $("#attachment_limit" + temp_id).css('border-color', '');
        //  $("#create_limit" + temp_id).css('border-color', 'red');
          error = 3;
    } else {
        $("#attachment_limit" + temp_id).css('border-color', '');
    } 
/*      if (attachment_category == "") {
        $("#attachment_category" + temp_id).css('border-color', 'red');
        error = 4;
    } else {
        $("#attachment_category" + temp_id).css('border-color', '');
    }
*/    
    if ($("#attachment_mandatory"+ temp_id).is(":not(:checked)")) {
//        $("#attachment_mandatory" + temp_id).css('border-color', 'red');
       attachment_mandatory=0;
//        error = 4;
    } else if ($("#attachment_mandatory"+ temp_id).is(":checked")) {
//        $("#attachment_mandatory" + temp_id).css('border-color', '');
            attachment_mandatory=1
    }


    if (attachment_label != "" && attachment_field_type != "") {

        var tmps = [];
        if (attachment_field_type == "SELECT" || attachment_field_type == "CHECKBOX" || attachment_field_type == "RADIO") {
            tmps = attachment_update_select_data;
        }
        var formData = {
            'ent_id': ent_id,
            'task_id': temp_id,
            'label': attachment_label,
            'field_type': attachment_field_type,
            'limit': attachment_limit,
            'category': attachment_category,
            'task_type': temp_id,
            'value': JSON.stringify(tmps),
            'dependent_value': '0',
            'attachment_mandatory': attachment_mandatory
        };
        
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/attachment_not_integrated',
            type: 'post',
            data: formData,
            async: true, //blocks window close
            dataType: 'json',
            success: function (res) {
                $('#divLoading').removeClass('show');
                
                if (res.success) {
                   // alert(res['success']);
                    var selCategoryText = '0';
                   // var selCategoryText = $("#attachment_category" + temp_id + " option:selected").text();
                   var htm= "";
                     attachment_no.push(res);
//                     alert( res.option_type);
                    htm = '<tr><td>' + res.label + '</td><td>' + res.option_type + '</td><td>' + res.type_limit + '</td><td hidden>' + selCategoryText + '</td><td hidden>Null</td><td>' + res.required_status + '</td><td>' + res.type_values + '</td><td>Null</td><td><span id="Attchment_remove_id' + res.attch_att_update_id + '" onclick="remove_row_attachment(' + res.attch_att_update_id + ')" name='+temp_id+' class="glyphicon glyphicon-remove"></span></td></tr>';
                    $("#attachment_table_" + temp_id).append(htm);
        
                    document.getElementById("attachment_label" + temp_id).value = "";
                    document.getElementById("attachment_field_type" + temp_id).value = "";
                    document.getElementById("attachment_limit" + temp_id).value = "";
//                    $("#attachment_mandatory"+ temp_id).is(":checked")
                    $("#attachment_mandatory"+ temp_id).prop('checked', false);
                   // document.getElementById("attachment_category" + temp_id).value = "";
                    var option = '<option value="' + res.attch_att_update_id + '">' + res['label']+ '</option>';
                    $("#attachment_map_fields" + temp_id).append(option);
//                    $("#update_map_fields" + temp_id).append(option);
//                    $("#assets_map_fields" + temp_id).append(option);
//                    $("#onhold_map_fields" + temp_id).append(option);
//                    $("#reject_map_fields" + temp_id).append(option);
//var attachment_update_select_data = [], attachment_update_radio_data = [], attachment_update_check_data = [];
                    attachment_update_select_data = [];
                    $('#attachment_select_integrated_no_' + temp_id).hide();
                    $('#attachment_add_not_integrated' + temp_id).show();
                    $('#attachment_select_data_' + temp_id).html('');
                    attachmenttoggleIntegrate('select', temp_id)

                } else {
                    showInformation('error', 'Something went wrong! Please try again!');
                }

            },
            error: function () {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
        //--------------------------------------------
    }
}

function remove_row(id) {
    if (confirm('Are you sure you want to delete this item?')) {
        $('#divLoading').addClass('show');
        var span_type_id=$("#remove_id"+id).attr('name');
//        alert($("#remove_id"+id).attr('name'));

        
        $.ajax({
            url: url + 'EntitySettingController/create_not_integrated_delete',
            type: 'post',
            data: {id: id},
            success: function (data) {
                $('#divLoading').removeClass('show');
                if (data == 'success') {
                    var option = '',option1 = '', attr_id = [];

                    var j = create_no.length;
                    while (j--) {
                        if (attr_id.indexOf(create_no[j].Task_type_ID) == -1) {
                            $("#create_map_fields" + create_no[j].Task_type_ID).find('option').not(':first').remove();
//                            $("#update_map_fields" + create_no[j].Task_type_ID).find('option').not(':first').remove();
                            $("#assets_map_fields" + create_no[j].Task_type_ID).find('option').not(':first').remove();
                            $("#onhold_map_fields" + create_no[j].Task_type_ID).find('option').not(':first').remove();
                            $("#reject_map_fields" + create_no[j].Task_type_ID).find('option').not(':first').remove();
//                           
                            attr_id.push(create_no[j].Task_type_ID);
//                            alert(create_no[j].Task_type_ID);
                        }
                        if (id == create_no[j].extr_att_id) {
                            create_no.splice(j, 1);
                            $("#remove_id" + id + "").closest("tr").remove();
                        } else {
                            option += "<option value='" + create_no[j].extr_att_id + "'>" + create_no[j].Ext_att_name + "</option>";
                            
                        }
                    }
                    
                    
                    option += '<option value="" selected>Select</option>';
                    mapSelAlign(option);
                    
                    
                    var k = create_yes_list.length;
                    while (k--) {
                        if (id == create_yes_list[k].API_Field) {
                            $('#append_create_yes_data' + create_yes_list[k].task_type).find('tr').slice(1).remove();
                            create_yes_list.splice(k, 1);
                            showMapFields('create', create_yes_list);
                        }
                    }
                    /*var k = update_yes_list.length;
                     while (k--) {
                     if (id == update_yes_list[k].API_Field) {
                     $('#append_update_yes_data' + update_yes_list[k].task_type).find('tr').slice(1).remove();
                     update_yes_list.splice(k, 1);
                     showMapFields('update', update_yes_list);
                     }
                     }*/
                    var k = assets_yes_list.length;
                    while (k--) {
                        if (id == assets_yes_list[k].API_Field) {
                            $('#append_assets_yes_data' + assets_yes_list[k].task_type).find('tr').slice(1).remove();
                            assets_yes_list.splice(k, 1);
                            showMapFields('assets', assets_yes_list);
                        }
                    }
                    var k = onhold_yes_list.length;
                    while (k--) {
                        if (id == onhold_yes_list[k].API_Field) {
                            $('#append_onhold_yes_data' + onhold_yes_list[k].task_type).find('tr').slice(1).remove();
                            onhold_yes_list.splice(k, 1);
                            showMapFields('onhold', onhold_yes_list);
                        }
                    }
                    var k = reject_yes_list.length;
                    while (k--) {
                        if (id == reject_yes_list[k].API_Field) {
                            $('#append_reject_yes_data' + reject_yes_list[k].task_type).find('tr').slice(1).remove();
                            reject_yes_list.splice(k, 1);
                            showMapFields('reject', reject_yes_list);
                        }
                    }
                    var k = engineertype_yes_list.length;
                    while (k--) {
                        if (id == engineertype_yes_list[k].API_Field) {
                            $('#append_engineertype_yes_data' + engineertype_yes_list[k].task_type).find('tr').slice(1).remove();
                            engineertype_yes_list.splice(k, 1);
                            showMapFields('engineertype', engineertype_yes_list);
                        }
                    }
                    var k = taskreport_yes_list.length;
                    while (k--) {
                        if (id == taskreport_yes_list[k].API_Field) {
                            $('#append_taskreport_yes_data' + taskreport_yes_list[k].task_type).find('tr').slice(1).remove();
                            taskreport_yes_list.splice(k, 1);
                            showMapFields('taskreport', taskreport_yes_list);
                        }
                    }
                    
                 
//  ----------------------------========================================
                           var table_id=[];
                           var dropdown=$("#create_fields"+span_type_id);
//                           alert("dropdown--"+dropdown.length)
//                    for (var op = 0; op < dropdown.length; op++) {
//                            if (table_id.indexOf(createfields[op].task_type) == -1) {
//                                 if (id == createfields[op].extr_att_id) {
                                     $("#create_fields" + span_type_id+" option[value='"+id+"']").remove();
//
//                                table_id.push(createfields[op].task_type);
//                            }
//                        }
//                        }
//  ----------------------------========================================                        
                           $("#create_fieldsLabel"+id).remove();
                    $("#dub_create_fieldsLabel"+id).remove(); 
                }
//                showReportFields();
            }
            ,
            error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
}


function remove_row_attachment(temp_id) {
    if (confirm('Are you sure you want to delete this item?')) {
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/attachment_not_integrated_delete',
            type: 'post',
            data: {id: temp_id},
            success: function (data) {
                $('#divLoading').removeClass('show');
                if (data == 'success') {
                    var option = '', attr_id = [];

                    var j = attachment_no.length;
                    while (j--) { 
                        if (attr_id.indexOf(attachment_no[j].task_type) == -1) {
                            $("#attachment_map_fields" + attachment_no[j].task_type).find('option').not(':first').remove();
//                            $("#update_map_fields" + create_no[j].Task_type_ID).find('option').not(':first').remove();
                           // $("#assets_map_fields" + attachment_no[j].task_type).find('option').not(':first').remove();
                           // $("#onhold_map_fields" + attachment_no[j].task_type).find('option').not(':first').remove();
                           // $("#reject_map_fields" + attachment_no[j].task_type).find('option').not(':first').remove();
                            attr_id.push(attachment_no[j].task_type);
                            
                             attachment_no.splice(j, 1);
                            $("#Attchment_remove_id" + temp_id).closest("tr").remove();
                        } 
//                        alert(attachment_no[j].id+'----'+attachment_no[j].task_type+'----'+temp_id);
//                        if (temp_id == attachment_no[j].id) {
                           
//                        } else {
                           // option += "<option value='" + attachment_no[j].extr_att_id + "'>" + attachment_no[j].Ext_att_name + "</option>";
//                        }
                    }
 /*                   option += '<option value="" selected>Select</option>';
                    mapSelAlign(option);

                    var k = create_yes_list.length;
                    while (k--) {
                        if (id == create_yes_list[k].API_Field) {
                            $('#append_create_yes_data' + create_yes_list[k].task_type).find('tr').slice(1).remove();
                            create_yes_list.splice(k, 1);
                            showMapFields('create', create_yes_list);
                        }
                    }
                   
                    var k = assets_yes_list.length;
                    while (k--) {
                        if (id == assets_yes_list[k].API_Field) {
                            $('#append_assets_yes_data' + assets_yes_list[k].task_type).find('tr').slice(1).remove();
                            assets_yes_list.splice(k, 1);
                            showMapFields('assets', assets_yes_list);
                        }
                    }
                    var k = onhold_yes_list.length;
                    while (k--) {
                        if (id == onhold_yes_list[k].API_Field) {
                            $('#append_onhold_yes_data' + onhold_yes_list[k].task_type).find('tr').slice(1).remove();
                            onhold_yes_list.splice(k, 1);
                            showMapFields('onhold', onhold_yes_list);
                        }
                    }
                    var k = reject_yes_list.length;
                    while (k--) {
                        if (id == reject_yes_list[k].API_Field) {
                            $('#append_reject_yes_data' + reject_yes_list[k].task_type).find('tr').slice(1).remove();
                            reject_yes_list.splice(k, 1);
                            showMapFields('reject', reject_yes_list);
                        }
                    }
                    var k = engineertype_yes_list.length;
                    while (k--) {
                        if (id == engineertype_yes_list[k].API_Field) {
                            $('#append_engineertype_yes_data' + engineertype_yes_list[k].task_type).find('tr').slice(1).remove();
                            engineertype_yes_list.splice(k, 1);
                            showMapFields('engineertype', engineertype_yes_list);
                        }
                    }
                    var k = taskreport_yes_list.length;
                    while (k--) {
                        if (id == taskreport_yes_list[k].API_Field) {
                            $('#append_taskreport_yes_data' + taskreport_yes_list[k].task_type).find('tr').slice(1).remove();
                            taskreport_yes_list.splice(k, 1);
                            showMapFields('taskreport', taskreport_yes_list);
                        }
                    } */
                }
            },
            error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
}

function printObject(o) {
    var out = '';
    for (var p in o) {
        out += p + ': ' + o[p] + '\n';
    }
    //alert(out);
}
function getTabDetails() {

//alert("gggg");
    $('#divLoading').addClass('show');
    var ent_id = $('#ent_id').val();
   // alert(ent_id);
    $.ajax({
        url: url + 'EntitySettingController/getTabDetails',
        type: 'post',
        data: {ent_id: ent_id},
        dataType: 'json',
        success: function (res) {
            $('#divLoading').removeClass('show');
            if (res.error) {
                showInformation('error', res.error);
            } else {
                tabs = res.task_type;
                categories = res.categories;
                fse_types1 = res.allfsetypes;
                fse_cnt = res.allfsetypes_cnt;
                fse_types = res.fse_type_id;
                getUpdateTabDepondOn = res.getUpdateTabDepondOn;
                assets = res.assets;
                create_no = res.create;
                api_data = res.api_data;
                integrateData = res.integrateData;
                update_integrateData = res.updateintegrateData;
                reportflag = res.reportflag;
                reportfields = res.reportfields;
                createfields = res.createfields;
                attachment_no = res.attachements;
                
                var task_tblr_ids='';
                
                if (tabs.length > 0) {
                    var htm = '<option>Loading....</option>';
                    for (var i = 0; i < tabs.length; i++) {
                        
                       /* if(reportfields != ''){                           
                            alert(reportfields[i].task_type_id);
                            task_tblr_ids=reportfields[i].task_type_id;
                        }else{                             
                            task_tblr_ids=tabs[i].id;
                        }
                        */
                       task_tblr_ids=tabs[i].id;                      
                        cloneTask(tabs[i].id, tabs[i].task_type,task_tblr_ids);
                        htm += '<option value="' + tabs[i].id + '">' + tabs[i].task_type + '</option>';
                        selectedOptions(tabs[i].id, tabs[i].integrated_api);
                        completedScreen(tabs[i].id, tabs[i].completed_screen);
                        stateValues(tabs[i].id, tabs[i].states_data);
//                        alert(reportfields[i].id);
                    }
                    appendTaskDependency(htm, false);
                }
                $('#parent_nav.nav-tabs li:nth-child(1) a').click();

                if (res.api_data.create) {
                    showApiData('create', res.api_data.create);
                }
                if (res.api_data.update) {
                    showApiData('update', res.api_data.update);
                }
                if (res.api_data.assets) {
                    showApiData('assets', res.api_data.assets);
                }
                if (res.api_data.onhold) {
                    showApiData('onhold', res.api_data.onhold);
                }
                if (res.api_data.reject) {
                    showApiData('reject', res.api_data.reject);
                }
                if (res.api_data.engineertype) {
                    showApiData('engineertype', res.api_data.engineertype);
                }
                if (res.api_data.taskreport) {
                    showApiData('taskreport', res.api_data.taskreport);
                }
//                res.attachements
//---------------- attachment
                if (res.api_data.attachment) {
                    showApiData('attachment', res.api_data.attachment);
                }
//---------------- attachment
//---------------- Token
                if (res.api_data.token_api) {
                    showApiData('t_update', res.api_data.token_api);
                }
                if (res.api_data.token_api) {
                    showApiData('authmach_update', res.api_data.authmach_api);
                }
                
//---------------- End Token
                if (res.integrateData.create) {
                    create_yes_list = res.integrateData.create;
                    showMapFields('create', res.integrateData.create);
                }
                if (res.integrateData.update) {
                    update_yes_list = res.integrateData.update;
                    showMapFields('update', res.integrateData.update);
                }
                if (res.integrateData.assets) {
                    assets_yes_list = res.integrateData.assets;
                    showMapFields('assets', res.integrateData.assets);
                }
                if (res.integrateData.onhold) {
                    onhold_yes_list = res.integrateData.onhold;
                    showMapFields('onhold', res.integrateData.onhold);
                }

                if (res.integrateData.reject) {
                    reject_yes_list = res.integrateData.reject;
                    showMapFields('reject', res.integrateData.reject);
                }

                if (res.integrateData.engineertype) {
                    engineertype_yes_list = res.integrateData.engineertype;
                    showMapFields('engineertype', res.integrateData.engineertype);
                }
                if (res.integrateData.taskreport) {
                    taskreport_yes_list = res.integrateData.taskreport;
                    showMapFields('taskreport', res.integrateData.taskreport);
                }
                
                


                if (res.commands.onhold) {
                    showCommands('onhold', res.commands.onhold);
                }
                if (res.commands.reject) {
                    showCommands('reject', res.commands.reject);
                }

                if (update_integrateData) {
                    showUpdateData();
                }

                showCategories();
                showFseTypes1();
                showFseTypes();
                showDepondOn();
                showAssets();
                showCreate_Api_No();
                showAttachment_Api_No();
                showReportFields();
            }
        }, error: function (error) {
            $('#divLoading').removeClass('show');
            showInformation('error', 'Something went wrong! Please try again!');
        },
    });
}

function stateValues(id, data) {
    $('#assigned_state_' + id).val(data.assigned);
    $('#accepted_state_' + id).val(data.accepted);
    $('#rejected_state_' + id).val(data.rejected);
    $('#inprogress_state_' + id).val(data.inprogress);
    $('#onhold_state_' + id).val(data.onhold);
    $('#resolved_state_' + id).val(data.resolved);
}

function showApiData(type, data) {
    for (var i = 0; i < data.length; i++) {
//        alert(type);
        $("#" + type + "_method_" + data[i].qm_task_type_id).val(data[i].API_Method_Name);
        $("#" + type + "_endpoint_" + data[i].qm_task_type_id).val(data[i].API_End_point);
        $("#" + type + "_username_" + data[i].qm_task_type_id).val(data[i].API_User_name);
        $("#" + type + "_password_" + data[i].qm_task_type_id).val(data[i].API_Password);
//        $("#" + type + "_xml_file_" + data[i].qm_task_type_id).val(data[i].API_XML_File);
        $("#" + type + "_api_key_" + data[i].qm_task_type_id).val(data[i].API_Key);
        $("#" + type + "_api_settings_id_" + data[i].qm_task_type_id).val(data[i].API_Settings_ID);

//        $("#add_" + type + "_api_" + data[i].qm_task_type_id).hide();
    }
}

function showMapFields(type, data) {
    for (var i = 0; i < data.length; i++) {
        var html = '';
        html = "<tr id=remove_map_fields" + data[i].API_Mapping_Id + "><td>" + data[i].MapTo + "</td><td>" + data[i].End_Point + "</td><td><span id=remove_ele_id" + data[i].API_Mapping_Id + " data-map_id='" + data[i].API_Mapping_Id +
                "' style='margin-top: 11px;' class='glyphicon glyphicon-remove remove_map_fields'></span></td></tr>";
        $('#append_' + type + '_yes_data' + data[i].task_type).append(html);
    }
}

function showCommands(type, data) {
    for (var i = 0; i < data.length; i++) {
        var html = '';
        html += '<tr id = "' + data[i].command + '_' + data[i].task_type + '_' + type + '"><td>' + data[i].command + '</td>';
        html += '<td><span class="glyphicon glyphicon-remove" data-' + type + '_type= "' + data[i].task_type + '" data-' + type + '= "' + data[i].command + '" id="' + type + '_value"></span></td></tr>';
        $('#' + type + '_command_list_' + data[i].task_type).append(html);
    }
}

function showCommandss(type, data) {
    for (var i = 0; i < data.length; i++) {
        $('#' + type + '_command_list_' + data[i].task_type).append('<div style="cursor: pointer;" id="' + type + '_value">' + data[i].command + '</div>');
    }
}

function appendTaskDependency(htm, status) {
    var count = 1;
    if (status) {
        count = 2;
        htm = '<option>Loading....</option>';
    }
    while (count > 0) {
        for (var i = 0; i < tabs.length; i++) {
            if (count == 1) {
                $('#task_dependency_' + tabs[i].id).html(htm);
            } else {
//                if(tabs[i].id)
                htm += '<option value="' + tabs[i].id + '">' + tabs[i].task_type + '</option>';
            }
            $("#task_dependency_" + tabs[i].id+" option[value='"+tabs[i].id+"']").remove();
        }
        count--;
    }
}

function showAssets() {
    for (var i = 0; i < assets.length; i++) {
        var htm = '';
        htm += "<tr><td>" + assets[i].display_name + "</td><td>" + assets[i].type + "</td><td>" + assets[i].description + "</td><td><span class='glyphicon glyphicon-remove removeasset' data-asset='" + assets[i].id + "'></span></td></tr>";
        $('#append_asset_data_' + assets[i].task_type).append(htm);
    }
}

function selectedOptions(id, values) {
    $("input[name=create_api_" + id + "][value=" + values.create + "]").attr('checked', 'checked');
    togIntegratedApi('create', id, '');
    $("input[name=authmach_update_api_" + id + "][value=" + values.authmach_update + "]").attr('checked', 'checked');
    togIntegratedApi('authmach_update', id, '');
//===========================
$("input[name=update_api_" + id + "][value=" + values.update + "]").attr('checked', 'checked');
    togIntegratedApi('update', id, '');
//===========================
    $("input[name=attachment_status" + id + "][value=" + values.attachment_status + "]").attr('checked', 'checked');
    $("input[name=attachment_api_" + id + "][value=" + values.attachment + "]").attr('checked', 'checked');    
    togIntegratedApi('attachment', id, '');    
//===========================    
    $("input[name=asset_api_" + id + "][value=" + values.asset + "]").attr('checked', 'checked');
    $("input[name=asset_status" + id + "][value=" + values.asset_status + "]").attr('checked', 'checked');
    togIntegratedApi('asset', id, '');
    $("input[name=allow_for" + id + "][value=" + values.allow_for + "]").attr('checked', 'checked');
    $("input[name=onhold_api_" + id + "][value=" + values.onhold + "]").attr('checked', 'checked');
    togIntegratedApi('onhold', id, '');
    $("input[name=onhold_comment" + id + "][value=" + values.onhold_comment + "]").attr('checked', 'checked');
    $("input[name=reject_api_" + id + "][value=" + values.reject + "]").attr('checked', 'checked');
    togIntegratedApi('reject', id, '');
    $("input[name=reject_comment" + id + "][value=" + values.reject_comment + "]").attr('checked', 'checked');
}

function showCreate_Api_No() {
    for (var i = 0; i < create_no.length; i++) {
        
        var htm = '', option = '';
         var res_qm_attr_addupdate_value='';
         // alert(create_no[i].qm_attr_addupdate_value);
          if(create_no[i].qm_attr_addupdate_value == '1') {res_qm_attr_addupdate_value='Y';}else {res_qm_attr_addupdate_value='N';}
        htm += '<tr><td>' + create_no[i].Ext_att_name + '</td><td>' + create_no[i].Ext_att_type + '</td><td>' + create_no[i].Ext_att_size + '</td><td>' + create_no[i].category + '</td><td>'+res_qm_attr_addupdate_value+'</td><td><span id="remove_id' + create_no[i].extr_att_id + '" onclick="remove_row(' + create_no[i].extr_att_id + ')" name="'+create_no[i].Task_type_ID+'" class="glyphicon glyphicon-remove"></span></td></tr>';
        $("#create_table_" + create_no[i].Task_type_ID).append(htm);
        option += "<option value='" + create_no[i].extr_att_id + "'>" + create_no[i].Ext_att_name + "</option>";
        $("#create_map_fields" + create_no[i].Task_type_ID).append(option);
//        $("#update_map_fields" + create_no[i].Task_type_ID).append(option);
        $("#assets_map_fields" + create_no[i].Task_type_ID).append(option);
        $("#onhold_map_fields" + create_no[i].Task_type_ID).append(option);
        $("#reject_map_fields" + create_no[i].Task_type_ID).append(option);
    }
}
function showAttachment_Api_No() {
    for (var i = 0; i < attachment_no.length; i++) {
        var htm = '', option = '';      
        
        //var htm = '<tr><td>' + label + '</td><td>' + type + '</td><td>' + limit + '</td><td>' + category_txt + '<td></td>' + tmp.toString() + '</td><td>' + required_check + '</td><td>' + depond_on + '</td><td></td><td><span class="glyphicon glyphicon-remove removeupdatedata" data-id ="' + res.id + '"></span></td><td class="append_update_data_' + id + '"><input id="map_data_value_' + res.id + '" type="text" value=""></td><td class="append_update_data_' + id + '"><span class="fa fa-archive" aria-hidden="true" onclick="updateMapData(' + res.id + ')"></span></td></tr>';
        
        htm += '<tr><td>' + attachment_no[i].label + '</td><td>' + attachment_no[i].option_type + '</td><td>' + attachment_no[i].type_limit + '</td><td hidden>' + attachment_no[i].category + '</td><td hidden>Null</td><td>' + attachment_no[i].required_status + '</td><td>' + attachment_no[i].type_values + '</td><td>Null</td><td><span id="Attchment_remove_id' + attachment_no[i].id + '" onclick="remove_row_attachment(' + attachment_no[i].id + ')" name="'+attachment_no[i].task_type+'" class="glyphicon glyphicon-remove"></span></td><td class="append_attachment_data_' + attachment_no[i].task_type + '"><input id="Attachment_map_data_value_' + attachment_no[i].id + '" type="text" value="' + attachment_no[i].map_data + '"></td><td class="append_attachment_data_' + attachment_no[i].task_type + '"><span class="fa fa-archive" aria-hidden="true" onclick="updateAttachmentMapData(' + attachment_no[i].id + ')"></span></td></tr>';
        $("#attachment_table_" + attachment_no[i].task_type).append(htm);
        option += "<option value='" + attachment_no[i].id + "'>" + attachment_no[i].label + "</option>";
        $("#create_map_fields" + attachment_no[i].task_type).append(option);
//        $("#update_map_fields" + create_no[i].task_type).append(option);
        $("#assets_map_fields" + attachment_no[i].task_type).append(option);
        $("#onhold_map_fields" + attachment_no[i].task_type).append(option);
        $("#reject_map_fields" + attachment_no[i].task_type).append(option);
    }
}

function showInformation(type, msg) {
    var txt = '', className = '';
    $('#msgPane').attr({class: "alert fade in"});
    if (type == 'success') {
        className = 'alert-success';
        txt = '<strong>Success!</strong> ' + msg;
    } else {
        className = 'alert-danger';
        txt = '<strong>Error!</strong> ' + msg;
    }
    $('#msgPane').addClass(className);

    $('#msgPane').show();
    $('#msg').html(txt);
    $('#msgPane').fadeOut(2000);
}

$('body').on('click', '.removeasset', function () {
    if (confirm('Are you sure you want to delete this item?')) {
        $('#divLoading').addClass('show');
        var that = $(this).closest('tr')
        var asset_id = $(this).data('asset');
        $.ajax({
            url: url + 'EntitySettingController/remove_asset',
            type: 'post',
            dataType: 'json',
            data: {asset_id: asset_id},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    that.remove();
                    showInformation('success', res.success);
                } else {
                    showInformation('error', 'Something went wrong! Please try again!');
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
});

function addMapFields(type, id) {
    var map_field = $('#' + type + '_map_fields' + id).val();
    var end_point = $('#' + type + '_end_point_control' + id).val();
    var api_id = $('#' + type + '_api_settings_id_' + id).val();
    var error = 0;
    if (map_field == '') {
        $('#' + type + '_map_fields' + id).css('border-color', 'red');
        error = 1;
    } else {
        $('#' + type + '_map_fields' + id).css('border-color', '');
    }

    if (end_point == '') {
        $('#' + type + '_end_point_control' + id).css('border-color', 'red');
        error = 1;
    } else {
        $('#' + type + '_end_point_control' + id).css('border-color', '');
    }
    if (api_id == '') {
        error = 1;
        add_api_data(type, id);
    }

    if (error == 0) {
        var text = $('#' + type + '_map_fields' + id + ' option:selected').text();
        var ent_id = $('#ent_id').val();

        var tab_id = '';
        if (type == 'create') {
            tab_id = 2;
        } else if (type == 'update') {
            tab_id = 3;
        } else if (type == 'assets') {
            tab_id = 5;
        } else if (type == 'onhold') {
            tab_id = 8;
        } else if (type == 'reject') {
            tab_id = 9;
        } else if (type == 'attachment') {
            tab_id = 12;
        }
        

        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/add_map_fields',
            type: 'post',
            dataType: 'json',
            data: {ent_id: ent_id, api: map_field, text: text, end_point: end_point, api_id: api_id, task_type: id, task_type_tab: tab_id},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    $('#' + type + '_map_fields' + id).val('');
                    $('#' + type + '_end_point_control' + id).val('');

                    var html = "<tr id=remove_map_fields" + res.API_Mapping_Id + "><td>" + res.MapTo + "</td><td>" + res.End_Point + "</td><td><span id=remove_ele_id" + res.API_Mapping_Id + " data-map_id='" + res.API_Mapping_Id +
                            "' style='margin-top: 11px;' class='glyphicon glyphicon-remove remove_map_fields'></span></td></tr>";
                    $('#append_' + type + '_yes_data' + res.task_type).append(html);

                    showInformation('success', res.success);
                    delete res.success;
                    if (type == 'create') {
                        create_yes_list.push(res);
                    } else if (type == 'update') {
                        update_yes_list.push(res);
                    } else if (type == 'assets') {
                        assets_yes_list.push(res);
                    } else if (type == 'onhold') {
                        onhold_yes_list.push(res);
                    } else if (type == 'reject') {
                        reject_yes_list.push(res);
                    }
                    else if (type == 'engineertype') {
                        engineertype_yes_list.push(res);
                    }
                    else if (type == 'taskreport') {
                        taskreport_yes_list.push(res);
                    }
                } else {
                    showInformation('error', 'Something went wrong! Please try again!');
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            },
        });
    }
}

$('body').on('click', '.remove_map_fields', function () {
    if (confirm('Are you sure?')) {
        $('#divLoading').addClass('show');
        var id = $(this).data('map_id');
        var that = $(this);
        $.ajax({
            url: url + 'EntitySettingController/remove_map_fields',
            type: 'post',
            dataType: 'json',
            data: {map_id: id},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    that.closest("tr").remove();
                    showInformation('success', res.success);
                } else {
                    showInformation('error', 'Something went wrong! Please try again!');
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            },
        });
    }
});

function changeCompletedScreen(type, id) {
    var value = 0;
    if ($('#' + type + '_' + id).is(":checked")) {
        value = 1;
    }
    $('#divLoading').addClass('show');
    $.ajax({
        url: url + 'EntitySettingController/update_complete_screen',
        type: 'post',
        dataType: 'json',
        data: {task_type: id, type: type, value: value},
        success: function (res) {
            $('#divLoading').removeClass('show');
            if (res.success) {
                showInformation('success', res.success);
            } else {
                showInformation('error', 'Something went wrong! Please try again!');
            }
        }, error: function (error) {
            $('#divLoading').removeClass('show');
            showInformation('error', 'Something went wrong! Please try again!');
        }
    });
}

function completedScreen(id, values) {
    if (values.signature == 1)
        $('#signature_' + id).prop('checked', true);
    if (values.ratings == 1)
        $('#ratings_' + id).prop('checked', true);
    if (values.comments == 1)
        $('#comments_' + id).prop('checked', true);
}

function createSelectIntegrated(id) {
    var selValue = $('#create_field_type' + id).val();
    if (selValue == 'TEXT') {
        $('#create_select_integrated_no_' + id).hide();
        $('#created_add_not_integrated' + id).show();
        $("#create_limit" + id).removeAttr("disabled");
    } else if (selValue == 'NUMBER') {
        $('#create_select_integrated_no_' + id).hide();
        $('#created_add_not_integrated' + id).show();
        $("#create_limit" + id).removeAttr("disabled");
    } else if (selValue == 'RADIO') {
        $('#create_select_integrated_no_' + id).show();
        $('#created_add_not_integrated' + id).hide();
        $("#create_limit" + id).attr("disabled", "disabled");
    } else if (selValue == 'CHECKBOX') {
        $('#create_select_integrated_no_' + id).show();
        $('#created_add_not_integrated' + id).hide();
        $("#create_limit" + id).attr("disabled", "disabled");
    } else if (selValue == 'TEXTAREA') {
        $('#create_select_integrated_no_' + id).hide();
        $('#created_add_not_integrated' + id).show();
        $("#create_limit" + id).removeAttr("disabled");
    } else if (selValue == 'SELECT') {
        $('#create_select_integrated_no_' + id).show();
        $('#created_add_not_integrated' + id).hide();
        $("#create_limit" + id).attr("disabled", "disabled");
    } else {
        $('#create_select_integrated_no_' + id).hide();
        $('#created_add_not_integrated' + id).show();
    }
}

/*function attachmentSelectIntegrated(id) {
    var selValue = $('#attachment_field_type' + id).val();
    if (selValue == 'TEXT') {
        $('#attachment_select_integrated_no_' + id).hide();
        $('#attachment_add_not_integrated' + id).show();
        $("#attachment_limit" + id).removeAttr("disabled");
    } else if (selValue == 'NUMBER') {
        $('#attachment_select_integrated_no_' + id).hide();
        $('#attachment_add_not_integrated' + id).show();
        $("#attachment_limit" + id).removeAttr("disabled");
    } else if (selValue == 'RADIO') {
        $('#attachment_select_integrated_no_' + id).show();
        $('#attachment_add_not_integrated' + id).hide();
        $("#attachment_limit" + id).attr("disabled", "disabled");
    } else if (selValue == 'CHECKBOX') {
        $('#attachment_select_integrated_no_' + id).show();
        $('#attachment_add_not_integrated' + id).hide();
        $("#attachment_limit" + id).attr("disabled", "disabled");
    } else if (selValue == 'TEXTAREA') {
        $('#attachment_select_integrated_no_' + id).hide();
        $('#attachment_add_not_integrated' + id).show();
        $("#attachment_limit" + id).removeAttr("disabled");
    } else if (selValue == 'SELECT') {
        $('#attachment_select_integrated_no_' + id).show();
        $('#attachment_add_not_integrated' + id).hide();
        $("#attachment_limit" + id).attr("disabled", "disabled");
    } else {
        $('#attachment_select_integrated_no_' + id).hide();
        $('#attachment_add_not_integrated' + id).show();
    }
}
*/
function attachmentSelectIntegrated(id) {
    var selValue = $('#attachment_field_type' + id).val();
    if (selValue == 'TEXT') {
        $('#attachment_select_integrated_' + id).hide();
        $('#attachment_select_integrated_no_' + id).hide();
        $('#attachment_field_dependOn_' + id).hide();
        $('#attachment_add_not_integrated' + id).show();
        $("#attachment_limit" + id).removeAttr("disabled");
    } else if (selValue == 'NUMBER') {
        $('#attachment_select_integrated_' + id).hide();
        $('#attachment_select_integrated_no_' + id).hide();
        $('#attachment_field_dependOn_' + id).hide();
        $('#attachment_add_not_integrated' + id).show();
        $("#attachment_limit" + id).removeAttr("disabled");
    } else if (selValue == 'RADIO') {
        $('#attachment_select_integrated_' + id).hide();
        $('#attachment_select_integrated_no_' + id).show();
        $('#attachment_field_dependOn_' + id).hide();
        $('#attachment_add_not_integrated' + id).hide();
        $("#attachment_limit" + id).attr("disabled", "disabled");
    } else if (selValue == 'CHECKBOX') {
        $('#attachment_select_integrated_' + id).hide();
        $('#attachment_select_integrated_no_' + id).show();
        $('#attachment_field_dependOn_' + id).hide();
        $('#attachment_add_not_integrated' + id).hide();
        $("#attachment_limit" + id).attr("disabled", "disabled");
    } else if (selValue == 'TEXTAREA') {
        $('#attachment_select_integrated_' + id).hide();
        $('#attachment_select_integrated_no_' + id).hide();
        $('#attachment_field_dependOn_' + id).hide();
        $('#attachment_add_not_integrated' + id).show();
        $("#attachment_limit" + id).removeAttr("disabled");
    } else if (selValue == 'SELECT') {
       $("input[name=attachment_available_api_" + id + "]").prop("checked", false);
        $('.radio_pane_' + id).hide();
        $('#checkbox_integrated_' + id).hide();
        $('#attachment_add_not_integrated' + id).hide(); 
        $('#attachment_select_integrated_' + id).hide();
        $('#attachment_select_integrated_no_' + id).show(); 
        $('#attachment_field_dependOn_' + id).hide();
        $("#attachment_limit" + id).attr("disabled", "disabled");
	
	
    } else {
        $('#attachment_select_integrated_' + id).hide();
        $('#attachment_select_integrated_no_' + id).hide();
        $('#attachment_field_dependOn_' + id).hide();
        $('#attachment_add_not_integrated' + id).show();
    }
}
//alert("fddfdfd")
function selectIntegrated(id) {
    
    var selValue = $('#update_field_type_' + id).val();
//   alert(selValue);
    if (selValue == 'SELECT') {
        $("input[name=update_available_api_" + id + "]").prop("checked", false);
        $('.radio_pane_' + id).hide();
        $('#checkbox_integrated_' + id).hide();
        $('#add_other_integrate_' + id).hide();
        $('#select_integrated_' + id).show();
        $('#update_field_dependOn_' + id).show();
        $("#update_limit_" + id).attr("disabled", "disabled");
    } else if (selValue == 'RADIOLIST') {
        $('.select_pane_' + id).hide();
        $('#checkbox_integrated_' + id).hide();
        $('#add_other_integrate_' + id).hide();
        $('#radio_integrated_' + id).show();
        $('#update_field_dependOn_' + id).hide();
        $("#update_limit_" + id).attr("disabled", "disabled");
    } else if (selValue == 'CHECKBOX') {
        $('.select_pane_' + id).hide();
        $('.radio_pane_' + id).hide();
        $('#add_other_integrate_' + id).hide();
        $('#checkbox_integrated_' + id).show();
        $('#update_field_dependOn_' + id).hide();
        $("#update_limit_" + id).attr("disabled", "disabled");
    } else if (selValue == 'TEXT') {
        $('.select_pane_' + id).hide();
        $('.radio_pane_' + id).hide();
        $('#checkbox_integrated_' + id).hide();
        $('#add_other_integrate_' + id).show();
        $('#update_field_dependOn_' + id).hide();
        $("#update_limit_" + id).removeAttr("disabled");
    } else if (selValue == 'SWITCH') {
        $("#update_limit_" + id).attr("disabled", "disabled");
         $('.select_pane_' + id).hide();
        $('.radio_pane_' + id).hide();
        $('#checkbox_integrated_' + id).hide();
        $('#add_other_integrate_' + id).show();
        $('#update_field_dependOn_' + id).hide();
    } else if (selValue == 'NUMBER') {
        $('.select_pane_' + id).hide();
        $('.radio_pane_' + id).hide();
        $('#checkbox_integrated_' + id).hide();
        $('#add_other_integrate_' + id).show();
        $('#update_field_dependOn_' + id).hide();
        $("#update_limit_" + id).removeAttr("disabled");
    } else if (selValue == 'TEXTAREA') {
        $('.select_pane_' + id).hide();
        $('.radio_pane_' + id).hide();
        $('#checkbox_integrated_' + id).hide();
        $('#add_other_integrate_' + id).show();
        $('#update_field_dependOn_' + id).hide();
        $("#update_limit_" + id).removeAttr("disabled");
    } else {
        $('.select_pane_' + id).hide();
        $('.radio_pane_' + id).hide();
        $('#checkbox_integrated_' + id).hide();
        $('#add_other_integrate_' + id).show();
        $('#update_field_dependOn_' + id).hide();
        $("#update_limit_" + id).removeAttr("disabled");
    }
}

function changeSelIntegrated(id) {
    var value = $("input[name=update_available_api_" + id + "]:checked").val();
//    var value1 = $("input[name=attachment_available_api_" + id + "]:checked").val();
//    alert(value1);
    if (value == 1) {
        $('#select_integrated_no_' + id).hide();
        $('#select_integrated_yes_' + id).show();
    }
    
    else
    {
        $('#select_integrated_no_' + id).show();
        $('#select_integrated_yes_' + id).hide();
    }
//    if (value1 == 1) {
//        $('#attachment_select_integrated_yes_' + id).hide();
//        $('#attachment_select_integrated_no_' + id).hide();
//    }
//    else
//    {
//        $('#attachment_select_integrated_yes_' + id).hide();
//        $('#attachment_select_integrated_no_' + id).hide();
//    }
}



function add_api_data(type, id) {
//    alert(type+"-validate"+id);
    var error = 0;
    var type2 = '';
    if(type=="t_update" ){ type2="t-update";}else if(type=="authmach_update"){type2="authmach-update";}else {type2=type;}
    $("input." + type2 + "-validate" + id).each(function () {
//        alert(this.value);
        if (this.value == "") {
            $(this).css('border-color', 'red');
            error = 1;
        } else {
            $(this).css('border-color', '');
        }
    });

    if (error == 0) {
        var method = $("#" + type + "_method_" + id).val();        
        var endpoint = $("#" + type + "_endpoint_" + id).val();
        var username = $("#" + type + "_username_" + id).val();
        var password = $("#" + type + "_password_" + id).val();
//        var xml_file = $("#" + type + "_xml_file_" + id).val();
        var api_key = $("#" + type + "_api_key_" + id).val();
        var api = 1;
        var ent_id = $('#ent_id').val();
        var tab_id = 0;

        if (type == 'create') {
            tab_id = 2;
        } else if (type == 'update') {
            tab_id = 3;
        } else if (type == 'assets') {
            tab_id = 5;
        } else if (type == 'onhold') {
            tab_id = 8;
        } else if (type == 'reject') {
            tab_id = 9;
        } else if (type == 'attachment') {
            tab_id = 12;
        }else if (type == 't_update') {
            tab_id = 13;
        }
        else if (type == 'authmach_update') {
            tab_id = 14;
        }
        

        var formData = {
            'ent_id': ent_id,
            'tab_id': tab_id,
            'task_type_id': id,
            'method': method,
            'endpoint': endpoint,
            'username': username,
            'password': password,
//            'xml_file': xml_file,
            'api_key': api_key,
            'api': api
            
        };
        
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/create_integrated',
            type: 'post',
            data: formData,
            async: true,
            dataType: 'json',
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
//                    $("#add_" + type + "_api_" + id).hide();
                    // alert("#" + type + "_api_settings_id_" + id);
                    // alert(res.extr_att_id);
                    $("#" + type + "_method_" + id).val(res.API_Method_Name);
                    $("#" + type + "_api_settings_id_" + id).val(res.extr_att_id);
                    showInformation('success', res.success);
                } else {
                    showInformation('error', 'Something went wrong! Please try again!');
                }
            },
            error: function () {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
}

function appendCommandData(type, id) {
    var value = $('#' + type + '_command_' + id).val();
    if (value) {
        $('#' + type + '_command_' + id).css('border-color', '');

        var ent_id = $('#ent_id').val();
        var tab_id = '';
        if (type == 'onhold') {
            tab_id = 8;
        } else if (type == 'reject') {
            tab_id = 9;
        }
        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/addCommands',
            type: 'post',
            dataType: 'json',
            data: {ent_id: ent_id, task_type: id, tab_id: tab_id, command: value},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {

                    var html = '';
                    html += '<tr id = "' + value + '_' + id + '_' + type + '"><td>' + value + '</td>';
                    html += '<td><span class="glyphicon glyphicon-remove" data-' + type + '_type= "' + id + '" data-' + type + '= "' + value + '" id ="' + type + '_value" ></span></td></tr>';
                    $('#' + type + '_command_list_' + id).append(html);

                    //$('#' + type + '_command_list_' + id).append('<div style="cursor: pointer;" id="'+type+'_value">' + value + '</div>');
                    $('#' + type + '_command_' + id).val('');
                    showInformation('success', res.success);
                } else {
                    showInformation('error', 'Something went wrong! Please try again!');
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    } else {
        $('#' + type + '_command_' + id).css('border-color', 'red');
    }
}

function updateStates(id) {
    var error = 0;
    $("input.states-validate" + id).each(function () {
        if (this.value == "") {
            $(this).css('border-color', 'red');
            error = 1;
        } else {
            $(this).css('border-color', '');
        }
    });

    if (error == 0) {
        var assigned = $('#assigned_state_' + id).val();
        var accepted = $('#accepted_state_' + id).val();
        var rejected = $('#rejected_state_' + id).val();
        var inprogress = $('#inprogress_state_' + id).val();
        var onhold = $('#onhold_state_' + id).val();
        var resolved = $('#resolved_state_' + id).val();

        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/update_states',
            type: 'post',
            dataType: 'json',
            data: {task_type: id, assigned: assigned, accepted: accepted, rejected: rejected, inprogress: inprogress, onhold: onhold, resolved: resolved},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    showInformation('success', res.success);
                } else {
                    showInformation('success', res.error);
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            },
        });
    }
}

var create_update_select_data = [], create_update_radio_data = [], create_update_check_data = [];
function createappendUpdateData(name, id) {
//    alert(name);
    var create_selectcount='',create_radiocount='',create_checkcount='';
    var value = $('#create_' + name + '_integrated_text_' + id).val();
    if (value) {
        $('#create_' + name + '_integrated_text_' + id).css('border-color', '');
        

        if (name == 'select') {
            create_update_select_data.push(value);
            create_selectcount=create_update_select_data.length;  
        } else if (name == 'radio') {
            create_update_radio_data.push(value);
            create_selectcount=create_update_select_data.length;  
        } else if (name == 'checkbox') {
            create_update_check_data.push(value);
            create_selectcount=create_update_select_data.length;  
        }
//$('#create_' + name + '_data_' + id).append('<div contentEditable id="create_Opttype_div_'+name+'_'+id+'" name='+name+' onblur=addeditedvalue(this) style="border: 1px solid #ccc;width: inherit;margin-bottom:2px">' + value + '</div>');
$('#create_' + name + '_data_' + id).append('<div contentEditable id="create_Opttype_div_'+name+'_'+id+'_'+create_selectcount+'" name='+name+' onblur=addeditedvalue(this,'+create_selectcount+') style="border: 1px solid #ccc;width: inherit;margin-bottom:2px">' + value + '</div>');
        $('#create_' + name + '_integrated_text_' + id).val('');
    } else {
        $('#create_' + name + '_integrated_text_' + id).css('border-color', 'red');
    }
}
var attachment_update_select_data = [], attachment_update_radio_data = [], attachment_update_check_data = [];
function attachmentappendUpdateData(name, id) {
var attch_selectcount='',attch_radiocount='',attch_checkcount='';
    var value = $('#attachment_' + name + '_integrated_text_' + id).val();
//alert(value);
//    attcount++; 
    if (value) {
        $('#attachment_' + name + '_integrated_text_' + id).css('border-color', '');
        

        if (name == 'select') {
            
            attachment_update_select_data.push(value);            
            attch_selectcount=attachment_update_select_data.length;                        
        } else if (name == 'radio') {            
            attachment_update_radio_data.push(value);
            attch_selectcount=attachment_update_radio_data.length;
        } else if (name == 'checkbox') {
            attachment_update_check_data.push(value);
            attch_selectcount=attachment_update_check_data.length;
        }
        $('#attachment_' + name + '_data_' + id).append('<div contentEditable id="attachment_Opttype_div_'+name+'_'+id+'_'+attch_selectcount+'" name='+name+' onblur=addeditedvalue(this,'+attch_selectcount+') style="border: 1px solid #ccc;width: inherit;margin-bottom:2px">' + value + '</div>');
        $('#attachment_' + name + '_integrated_text_' + id).val('');
    } else {
        $('#attachment_' + name + '_integrated_text_' + id).css('border-color', 'red');
    }
}


var update_select_data = [], update_radio_data = [], update_check_data = [];
function appendUpdateData(name, id) {
    var update_selectcount='',update_selectcount='',update_selectcount='';
    var value = $('#' + name + '_integrated_text_' + id).val();
    if (value) {
        $('#' + name + '_integrated_text_' + id).css('border-color', '');
//        $('#' + name + '_data_' + id).append('<div contentEditable id="update_Opttype_div_'+name+'_'+id+'" name='+name+' onblur=addeditedvalue(this) style="border: 1px solid #ccc;width: inherit;margin-bottom:2px">' + value + '</div>');

        if (name == 'select') {
            update_selectcount=update_select_data.length;
            update_select_data.push(value);            
        } else if (name == 'radio') {
            update_selectcount=update_radio_data.length;
            update_radio_data.push(value);
        } else if (name == 'checkbox') {
            update_selectcount=update_check_data.length;
            update_check_data.push(value);
        }
//$('#' + name + '_data_' + id).append('<div contentEditable id="update_Opttype_div_'+name+'_'+id+'" name='+name+' onblur=addeditedvalue(this) style="border: 1px solid #ccc;width: inherit;margin-bottom:2px">' + value + '</div>');        
$('#' + name + '_data_' + id).append('<div contentEditable id="update_Opttype_div_'+name+'_'+id+'_'+update_selectcount+'" name='+name+' onblur=addeditedvalue(this,'+update_selectcount+') style="border: 1px solid #ccc;width: inherit;margin-bottom:2px">' + value + '</div>');
        $('#' + name + '_integrated_text_' + id).val('');
    } else {
        $('#' + name + '_integrated_text_' + id).css('border-color', 'red');
    }
}


function addeditedvalue(opttype,arrayno)
{
    var otpname=$(opttype).attr('name');
    var value=opttype.innerText;
    var tabopttype=opttype.id.split("_")[0];
//    alert(arrayno);
//    alert(tabopttype);
    if(tabopttype == 'create')
    {
        
            if (otpname == 'select') {
create_update_select_data.splice( create_update_select_data.indexOf(create_update_select_data[arrayno-1]), 1 );        
                    create_update_select_data.push(value);
                } else if (otpname == 'radio') {
create_update_radio_data.splice( create_update_radio_data.indexOf(create_update_radio_data[arrayno-1]), 1 );    
                    create_update_radio_data.push(value);
                } else if (otpname == 'checkbox') {
create_update_check_data.splice( create_update_check_data.indexOf(create_update_check_data[arrayno-1]), 1 );    
                    create_update_check_data.push(value);
                }
            
    }
    else if(tabopttype == 'update')
    {        
            if (otpname == 'select') {
                    update_select_data.pop();
                    update_select_data.push(value);
                } else if (otpname == 'radio') {
                    update_radio_data.pop();
                    update_radio_data.push(value);
                } else if (otpname == 'checkbox') {
                    update_check_data.pop();
                    update_check_data.push(value);
                }
    }
         if(tabopttype == 'attachment')
    {        

            if (otpname == 'select') {
attachment_update_select_data.splice( attachment_update_select_data.indexOf(attachment_update_select_data[arrayno-1]), 1 );        

                    attachment_update_select_data.push(value);
                } else if (otpname == 'radio') {
attachment_update_radio_data.splice( attachment_update_radio_data.indexOf(attachment_update_radio_data[arrayno-1]), 1 );                                        
                    attachment_update_radio_data.push(value);
                } else if (otpname == 'checkbox') {
attachment_update_check_data.splice( attachment_update_check_data.indexOf(attachment_update_check_data[arrayno-1]), 1 );  
                    attachment_update_check_data.push(value);
                }
                
    }
}

function createaddIntegrateData(name, id) {
    var ele = $('#create_' + name + '_data_' + id);
//    alert(ele);
    if (ele.children().length == 0) {
        $('#create_' + name + '_integrated_text_' + id).css('border-color', 'red');
    } else {
        $('#create_' + name + '_add_more_' + id).parent().show();
        $('.create_' + name + '-options-' + id).parent().hide();
        $('#create_add_' + name + '_integrate_data_' + id).removeAttr('disabled');
    }
}
function attachmentcreateIntegrateData(name, id) {
    var ele = $('#attachment_' + name + '_data_' + id);
//    alert(ele);
    if (ele.children().length == 0) {
        $('#attachment_' + name + '_integrated_text_' + id).css('border-color', 'red');
    } else {
        $('#attachment_' + name + '_add_more_' + id).parent().show();
        $('.attachment_' + name + '-options-' + id).parent().hide();
        $('#attachment_add_' + name + '_integrate_data_' + id).removeAttr('disabled');
//        attachment_add_select_integrated
//attachment_add_select_integrated
//attachment_add_select_integrated_424
    }
}


function addIntegrateData(name, id) {
    var ele = $('#' + name + '_data_' + id);
    if (ele.children().length == 0) {
        $('#' + name + '_integrated_text_' + id).css('border-color', 'red');
    } else {
        $('#' + name + '_add_more_' + id).parent().show();
        $('.' + name + '-options-' + id).parent().hide();
        $('#add_' + name + '_integrate_data_' + id).removeAttr('disabled');
    }
}

function createtoggleIntegrate(name, id) {
    $('#create_' + name + '_add_more_' + id).parent().hide();
    $('.create_' + name + '-options-' + id).parent().show();
    if (name != 'other') {
        $('#create_add_' + name + '_integrate_data_' + id).attr('disabled', true);
    }
}
function attachmenttoggleIntegrate(name, id) {
    $('#attachment_' + name + '_add_more_' + id).parent().hide();
    $('.attachment_' + name + '-options-' + id).parent().show();
    if (name != 'other') {
        $('#attachment_add_' + name + '_integrate_data_' + id).attr('disabled', true);
    }
    
}

function toggleIntegrate(name, id) {
    $('#' + name + '_add_more_' + id).parent().hide();
    $('.' + name + '-options-' + id).parent().show();
    if (name != 'other') {
        $('#add_' + name + '_integrate_data_' + id).attr('disabled', true);
    }
}

function submitIntegrateData(name, id) {
    var error = 0;
    $(".update-yes-validate" + id).each(function () {
        if (this.value == "") {
            $(this).css('border-color', 'red');
            error = 1;
        } else {
            $(this).css('border-color', '');
        }
    });

    if (error == 0) {
        var tmp = [];
        if (name == 'select') {
            tmp = update_select_data;
        } else if (name == 'radio') {
            tmp = update_radio_data;
        } else if (name == 'checkbox') {
            tmp = update_check_data;
        }

        var ent_id = $('#ent_id').val();
        var label = $('#update_label_' + id).val();
        var type = $('#update_field_type_' + id).val();
        var limit = $('#update_limit_' + id).val();
        var category = $('#update_tab_category_' + id).val();
        var depond_on = $('#update_field_dependOn_' + id).val();
        var category_txt = $('#update_tab_category_' + id + ' option:selected').text();
//        radio_data_
        var required = 0;
        if ($('#update_required_' + id).is(":checked")) {
            required = 1;
        }

        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/updateIntegrateData',
            type: 'post',
            dataType: 'json',
            data: {ent_id: ent_id, task_type: id, label: label, type: type, limit: limit, category: category, required: required, depond_on: depond_on, value: JSON.stringify(tmp)},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {

                    getUpdateTabDepondOn = res.getUpdateTabDepondOn;
                    showDepondOn();
                    var required_check = 'No';
                    if (required == 1) {
                        required_check = 'Yes';
                    }

                    var htm = '<tr><td>' + label + '</td><td>' + type + '</td><td>' + limit + '</td><td>' + category_txt + '<td></td>' + tmp.toString() + '</td><td>' + required_check + '</td><td>' + depond_on + '</td><td></td><td><span class="glyphicon glyphicon-remove removeupdatedata" data-id ="' + res.id + '"></span></td><td class="append_update_data_' + id + '"><input id="map_data_value_' + res.id + '" type="text" value=""></td><td class="append_update_data_' + id + '"><span class="fa fa-archive" aria-hidden="true" onclick="updateMapData(' + res.id + ')"></span></td></tr>';
                    $('#append_update_data_' + id).append(htm);
                    /*var htm1 = '<tr id="update_map_data_' + res.id + '"><td><input id="map_data_value_' + res.id + '" type="text" value=""></td><td><span class="fa fa-archive" aria-hidden="true" onclick="updateMapData(' + res.id + ')"></span></td></tr>';
                     $('#append_update_map_data_' + id).append(htm1);*/
                    if ($("input[name=update_api_" + id + "]:checked").val() == 1) {
                        $('table .append_update_data_' + id).show();
                    } else {
                        $('table .append_update_data_' + id).hide();
                    }
                    $('#' + name + '_data_' + id).html('');
                    $(".update-yes-validate" + id).val('');
                    $("#update_limit_"+id).val('');
                    toggleIntegrate(name, id);
                    if (name == 'select') {
                        update_select_data = [];
                    } else if (name == 'radio') {
                        update_radio_data = [];
                    } else if (name == 'checkbox') {
                        update_check_data = [];
                    }


                    showInformation('success', res.success);
                } else {
                    showInformation('error', res.error);
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
}

function showUpdateData() {
    for (var i = 0; i < update_integrateData.length; i++) {
        var htm = '<tr><td>' + update_integrateData[i].label + '</td><td>' + update_integrateData[i].option_type + '</td><td>' + update_integrateData[i].type_limit + '</td><td>' + update_integrateData[i].category + '</td><td>' + update_integrateData[i].type_values + '</td><td>' + update_integrateData[i].required_status + '</td><td>' + update_integrateData[i].depondon + '</td><td>' + update_integrateData[i].endpoint + '</td><td><span class="glyphicon glyphicon-remove removeupdatedata" data-id ="' + update_integrateData[i].id + '"></span></td><td class="append_update_data_' + update_integrateData[i].task_type + '"><input type="text" id="map_data_value_' + update_integrateData[i].id + '" value="' + update_integrateData[i].map_data + '"></td><td class="append_update_data_' + update_integrateData[i].task_type + '"><span class="fa fa-archive" aria-hidden="true" onclick="updateMapData(' + update_integrateData[i].id + ')"></span></td></tr>';
        $('#append_update_data_' + update_integrateData[i].task_type).append(htm);
        /*var htm1 = '<tr id="update_map_data_' + update_integrateData[i].id + '"><td><input type="text" id="map_data_value_' + update_integrateData[i].id + '" value="' + update_integrateData[i].map_data + '"></td><td><span class="fa fa-archive" aria-hidden="true" onclick="updateMapData(' + update_integrateData[i].id + ')"></span></td></tr>';
         $('#append_update_map_data_' + update_integrateData[i].task_type).append(htm1);*/
        if ($("input[name=update_api_" + update_integrateData[i].task_type + "]:checked").val() == 1) {
            $('table .append_update_data_' + update_integrateData[i].task_type).show();
        } else {
            $('table .append_update_data_' + update_integrateData[i].task_type).hide();
        }
    }
} 

function updateMapData(id) {
    var value = $('#map_data_value_' + id).val();
    if (value) {
        $('#map_data_value_' + id).css('border-color', '');

        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/updateIntegrateMapData',
            type: 'post',
            dataType: 'json',
            data: {id: id, value: value},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    showInformation('success', res.success);
                } else {
                    showInformation('error', res.error);
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    } else {
        $('#map_data_value_' + id).css('border-color', 'red');
    }
}

function updateAttachmentMapData(id) {
//    Attachment_map_data_value_106
    var value = $('#Attachment_map_data_value_' + id).val();
    if (value) {
        $('#Attachment_map_data_value_' + id).css('border-color', '');

        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/AttachmentIntegrateMapData',
            type: 'post',
            dataType: 'json',
            data: {id: id, value: value},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    showInformation('success', res.success);
                } else {
                    showInformation('error', res.error);
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    } else {
        $('#Attachment_map_data_value_' + id).css('border-color', 'red');
    }
}

$('body').on('click', '.removeupdatedata', function () {
    if (confirm('Are you sure you want to delete this item?')) {
        $('#divLoading').addClass('show');
        var id = $(this).data('id');
        var that = $(this);

        $.ajax({
            url: url + 'EntitySettingController/deleteIntegrateData',
            type: 'post',
            dataType: 'json',
            data: {id: id},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    that.closest("tr").remove();
                    $('#update_map_data_' + id).remove();
                    showInformation('success', res.success);
                } else {
                    showInformation('error', res.error);
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
});

function submitApiData(id) {
    var error = 0;
    $(".update-yes-validate" + id).each(function () {
        if (this.value == "") {
            $(this).css('border-color', 'red');
            error = 1;
        } else {
            $(this).css('border-color', '');
        }
    });

    $(".select-update-validate" + id).each(function () {
        if (this.value == "") {
            $(this).css('border-color', 'red');
            error = 1;
        } else {
            $(this).css('border-color', '');
        }
    });

    if (error == 0) {
        var ent_id = $('#ent_id').val();
        var label = $('#update_label_' + id).val();
        var type = $('#update_field_type_' + id).val();
        var limit = $('#update_limit_' + id).val();
        var category = $('#update_tab_category_' + id).val();
        var category_txt = $('#update_tab_category_' + id + ' option:selected').text();
        var required = 0;
        if ($('#update_required_' + id).is(":checked")) {
            required = 1;
        }

        var method = $('#select_update_method_' + id).val();
        var endpoint = $('#select_update_endpoint_' + id).val();
        var username = $('#select_update_username_' + id).val();
        var password = $('#select_update_password_' + id).val();
        var key = $('#select_update_api_key_' + id).val();

        $('#divLoading').addClass('show');
        $.ajax({
            url: url + 'EntitySettingController/updateApiData',
            type: 'post',
            dataType: 'json',
            data: {ent_id: ent_id, task_type: id, label: label, type: type, limit: limit, category: category, required: required, method: method, endpoint: endpoint, username: username, password: password, key: key},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    var htm = '<tr><td>' + label + '</td><td>' + type + '</td><td>' + limit + '</td><td>' + category_txt + '</td><td></td><td></td><td></td><td>' + endpoint + '</td><td><span class="glyphicon glyphicon-remove removeupdatedata" data-id ="' + res.id + '"></span></td></tr>';
                    $('#append_update_data_' + id).append(htm);
                    showInformation('success', res.success);
                    $(".select-update-validate" + id).val('');
                } else {
                    showInformation('error', res.error);
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
}

//----------------------- attachment api data------------------------------------------------
function submitAttachment_ApiData(id) {
    var error = 0;
    $(".attachment-yes-validate" + id).each(function () {
        if (this.value == "") {
            $(this).css('border-color', 'red');
            error = 1;
        } else {
            $(this).css('border-color', '');
        }
    });

    $(".select-attachment-validate" + id).each(function () {
        if (this.value == "") {
            $(this).css('border-color', 'red');
            error = 1;
        } else {
            $(this).css('border-color', '');
        }
    });

    if (error == 0) {
        var ent_id = $('#ent_id').val();
        var label = $('#attachment_label' + id).val();
        var type = $('#attachment_field_type' + id).val();
        var limit = $('#attachment_limit' + id).val();
        var category = '';
//        $('#attachment_mandatory' + id).val();
        var category_txt = '';
//        $('#update_tab_category_' + id + ' option:selected').text();
        var required = 0;
        if ($('#attachment_mandatory' + id).is(":checked")) {
            required = 1;
        }

        var method = $('#select_attachment_method_' + id).val();
        var endpoint = $('#select_attachment_endpoint_' + id).val();
        var username = $('#select_attachment_username_' + id).val();
        var password = $('#select_attachment_password_' + id).val();
        var key = $('#select_attachment_api_key_' + id).val();

        $('#divLoading').addClass('show');
//        alert(method+',--'+endpoint+',---'+username+',----'+password+',----'+key);
        $.ajax({
            url: url + 'EntitySettingController/Attachment_ApiData',
            type: 'post',
            dataType: 'json',
            data: {ent_id: ent_id, task_type: id, label: label, type: type, limit: limit, category: category, required: required, method: method, endpoint: endpoint, username: username, password: password, key: key},
            success: function (res) {
                $('#divLoading').removeClass('show');
                if (res.success) {
                    var htm = '<tr><td>' + label + '</td><td>' + type + '</td><td>' + limit + '</td><td></td><td>'+required+'</td><td></td><td>' + endpoint + '</td><td><span class="glyphicon glyphicon-remove removeupdatedata" data-id ="' + res.id + '"></span></td></tr>';
                    $('#attachment_table_' + id).append(htm);
//                    showInformation('success', res.success);
                    $(".select-attachment-validate" + id).val('');
                } else {
                    showInformation('error', res.error);
                }
            }, error: function (error) {
                $('#divLoading').removeClass('show');
                showInformation('error', 'Something went wrong! Please try again!');
            }
        });
    }
}
//=------------------------------------------------------------------------------------------------
$(document).on("click", "#onhold_value", function () {

    var onhold = $(this).data('onhold');
    var onhold_type = $(this).data('onhold_type');
    var ent_id = $('#ent_id').val();
    var tab_id = 9;
    //  $('#onhold_command_'+task_type_id).val(text_val);
    var ent_id = $('#ent_id').val();
    var tab_id = 8;
    $('#divLoading').addClass('show');
    $.ajax({
        url: url + 'EntitySettingController/deleteCommands',
        type: 'post',
        dataType: 'json',
        data: {ent_id: ent_id, task_type: onhold_type, tab_id: tab_id, command: onhold},
        success: function (res) {



            $("#" + onhold + "_" + onhold_type + "_onhold").remove();
            $('#divLoading').removeClass('show');
        }, error: function (error) {
            $('#divLoading').removeClass('show');
            showInformation('error', 'Something went wrong! Please try again!');
        }
    });

    //alert($(this).text());

});

$(document).on("click", "#reject_value", function () {

    var reject = $(this).data('reject');
    var reject_type = $(this).data('reject_type');
    var ent_id = $('#ent_id').val();
    var tab_id = 9;
    $('#divLoading').addClass('show');
    $.ajax({
        url: url + 'EntitySettingController/deleteCommands',
        type: 'post',
        dataType: 'json',
        data: {ent_id: ent_id, task_type: reject_type, tab_id: tab_id, command: reject},
        success: function (res) {
            $("#" + reject + "_" + reject_type + "_reject").closest('tr').remove();
            $('#divLoading').removeClass('show');
        }, error: function (error) {
            $('#divLoading').removeClass('show');
            showInformation('error', 'Something went wrong! Please try again!');
        }
    });

    //alert($(this).text());

});
function addendplbl(value){
    $('#create_listitem_'+value).toggle();
    // $('.add_new_end_point').after('<div class="col-md-10"> <input type="text" id="authmach_update_endpoint1" name=""  placeholder="Endpoint" class="form-control"></div>'); 

}
$('body').on('keypress','.new_list_fields',function(e) {
//alert(this.id);
    var splitval = this.id.split('_')[3];
//    alert(splitval);
//    function addlabel(valuee){
     if(e.which === 13){
    var value= $('#new_list_fields_'+splitval).val(); 
    if(value){
        if($('#create_listitem_'+splitval+' li:contains('+value+')').length==0){
            $('#new_list_fields_'+splitval).val('');
            $('#create_listitem_'+splitval).append('<li class="fieldItems_'+splitval+'" onclick="addfieldlbl(this,'+splitval+')">'+value+'</li>'); 
        }else{
            alert('Feild already exist')
        }
   } else{ 
    alert("Feild can't be empty"); 
    }
}
});
function addlabel(valuee){
    
}

//$('body').on('click','.fieldItems',function(e) {
function addfieldlbl(thisvv,vall){
//    alert(vall);
  var currentvalue=$(thisvv).text(); 
//  alert(currentvalue)
  var existValue=  $('#authmach_update_endpoint_'+vall).val(); 
  if(existValue.length!==0){
    var myarray = existValue.split('/');

    if(jQuery.inArray(currentvalue, myarray) == -1) {
        if(existValue.substr(-1)=='/'){
            $('#authmach_update_endpoint_'+vall).val(existValue+currentvalue);
        }else{
             $('#authmach_update_endpoint_'+vall).val(existValue+'/'+currentvalue);
        }
      }else{
          myarray.splice( $.inArray(currentvalue, myarray), 1 );
        var arraystirng= myarray.join("/");
       $('#authmach_update_endpoint_'+vall).val(arraystirng);
      } 
    }
 }

function togtaskreport(id) {
    var task_type = (id.match(/\d+/g).map(Number)).toString();
//    alert(id);
//    $('#sndtsks_' + task_type).toggle(600);
//    alert($('input[id='+id+']').obj);
//alert($('#sendtasks_'+id).val());
     var ent_id = $('#ent_id').val();   
         if($('input[id=sendtasks_'+id+']').is(":checked") == true) {

                    $("#sndtsks_" + task_type).attr("style", "display:block");
//                        $.ajax({
//                      url: url + 'EntitySettingController/saveReportFlag',
//                      type: 'post',
//                      data: {ent_id: ent_id, task_type: task_type},
//                      dataType: 'json',
//                      success: function (res) {
//                          // alert(res);
//                      }
//                  });         
           }
           else if($('input[id=sendtasks_'+id+']').is(":not(:checked)"))
           {
//               $('input[id='+id+']').prop("checked", true);
            $("#sndtsks_" + task_type).attr("style", "display:none");          
           }
           
             function allowcharaFunction(charr)
           {
            var decimal = /^[a-zA-Z]+$/;
        if(!/^[a-zA-Z\s]+$/.test(charr.value))
        {
//            alert(charr.id);
//             alert('Enter Alpha numeric Number');
            document.getElementById(charr.id).value = '';
            return false;
        }

        return true;
           }
}
