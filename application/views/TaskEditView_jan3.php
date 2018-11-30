<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.css"/>
<style type="text/css">
    #Edit_Task label.error {
        color: #FB3A3A;
        display: inline-block;
        padding: 0;
        text-align: left;
        width: 220px;
    }
</style>
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<script type="text/javascript">

    (function ($, W, D)
    {
        var JQUERY4U = {};

        JQUERY4U.UTIL =
                {
                    setupFormValidation: function ()
                    {
                        //form validation rules
                        $("#Edit_Task").validate({
                            rules: {
                                task_type_id: "required",
                                task_name: "required",
                                fse_id: "required",
                                branch_id: "required",
                                ent_id: "required",
                                project_id: "required",
                                incident_id: "required",
                                customer_id: "required",
                                status_id: "required",
                                sla_id: "required",
                                task_description: "required",
                                datetimepicker_start: "required",
                                datetimepicker_end: "required",
                                task_address: "required",
                                product_name: "required",
                                serial_number: "required",
                                product_code: "required",
                                book_code: "required",
                                manual_docket_number: "required",
                                customer_contact_person: "required",
                                customer_contact_number: "required",
                                model: "required",
                                problem: "required",
                                location: "required",
                                call_status: "required",
                                customerAddress: "required",
                                call_type: "required",
                                priority: "required",
                                message: "required",
                                comment_charge: "required",
                                previous_meter_reading: "required",
                                previous_color_reading: "required",
                                customer_order_number: "required",
                                outstanding_calls: "required",
                                productline: "required",
                                sn_problem1: "required",
                                sn_problem2: "required",
                            },
                            messages: {
                                task_type_id: "Please Select Task Type",
                                task_name: "Please Enter Task Name",
                                fse_id: "Please Select FSE Name",
                                branch_id: "Please Select Branch Name",
                                ent_id: "Please Select Entity Name",
                                project_id: "Please Select Project Name",
                                incident_id: "Please Select Incident Name",
                                customer_id: "Please Select Customer Name",
                                status_id: "Please Select Status Type",
                                sla_id: "Please Select SLA Name",
                                task_description: "Please Enter the Task Description",
                                datetimepicker_start: "Please Select logged Date",
                                customerAddress: "Please Enter the Customer Address",
                                datetimepicker_end: "Please Select End Date",
                                task_address: "Please Select Task Address",
                                product_name: "Please Enter Product Name",
                                serial_number: "Please Enter Product Serial Number",
                                product_code: "Please Enter Product Code",
                                book_code: "Please Enter Book code",
                                manual_docket_number: "Please Enter manual docket number ",
                                customer_contact_person: "Please Enter customer contact person",
                                customer_contact_number: "Please Enter customer contact number",
                                model: "Please Enter model",
                                problem: "Please Enter problem",
                                location: "Please Enter location",
                                call_status: "Please Enter call status",
                                call_type: "Please Enter call type",
                                priority: "Please Enter priority",
                                message: "Please Enter message",
                                comment_charge: "Please Enter comment charge",
                                previous_meter_reading: "Please Enter previous meter reading",
                                previous_color_reading: "Please Enter previous color reading",
                                customer_order_number: "Please Enter customer order number",
                                outstanding_calls: "Please Enter outstanding calls",
                                productline: "Please Select Product Line",
                                sn_problem1: "Please Select Problem 1",
                                sn_problem2: "Please Select Problem 2",
                            },
                            submitHandler: function (form) {
                                form.submit();
                            }
                        });
                    }
                }

        //when the dom has loaded setup form validation rules
        $(D).ready(function ($) {
            JQUERY4U.UTIL.setupFormValidation();
        });

    })(jQuery, window, document);
</script>
<script>
    $(document).ready(function () {
        //$("div.desc").hide();
        $("input[name$='optradio']").click(function () {
            var test = $(this).val();
            $("div.desc").hide();
            $("#" + test).show();
        });
        $("input[name$='optButtonradio']").click(function () {
            var test_desc = $(this).val();
            $("div.desc_entity").hide();
            $("#" + test_desc).show();
        });
    });
</script>
<div class="x_panel"  style="min-height:600px;">
    <div class="x_title">
        <h2>Edit Task<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Edit_Task" name="Edit_Task" data-parsley-validate class="form-horizontal form-label-left" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
            <!--            <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Task Type <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control col-md-7 col-xs-12" name="task_type_id" id="task_type_id">
                                    <option value="">Select</option>
            <?php
            //foreach ($results['getTasktype'] AS $getTasktype) {
            //  $selected = ($getTasktype['id'] == $result[0]['task_type_id']) ? 'selected' : null;
            // echo '<option value="' . $getTasktype['id'] . '" echo ' . $selected . '>' . $getTasktype['task_type'] . '</option>';
            //   }
            ?>
                                </select>
                                <span class="text-danger"><?php //echo form_error('task_type_id');   ?></span>
                            </div>
                        </div> -->
            <?php
            if ($entityFeilds != FALSE) {
                $task_field = json_decode($entityFeilds);
            } else {
                $task_field = array();
            }
            ?>
            <?php if (in_array(0, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Task Name <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="task_name" name="task_name" value="<?php echo $result[0]['task_name']; ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('task_name'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (FALSE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Field Engineer <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="fse_id" id="fse_id">
                            <option value="">Select</option>
                            <?php
                            foreach ($results['getFse'] AS $getFse) {
                                $selected = ($getFse['id'] == $result[0]['fse_id']) ? 'selected' : null;
                                echo '<option value="' . $getFse['id'] . '" echo ' . $selected . '>' . $getFse['fse_name'] . '</option>';
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('fse_id'); ?></span>
                    </div>
                </div>
            <?php } ?>
                   
            
            
            <?php if (in_array(1, $task_field)) { ?>
                 <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Field Engineer <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="fse_id_h" id="fse_id_h" value="<?php echo $result[0]['fse_name']; ?>" class="form-control col-md-7 col-xs-12" style="float: left;" />
                        <input type="hidden" name = "fse_id" id="fse_id" value="<?php echo $result[0]['fse_id']; ?>"/>
                        <div id="autocomplete-container" style="position: relative; float: left; width: 400px; margin: 10px;"></div>
                        <span class="text-danger"><?php echo form_error('fse_id'); ?></span>
                    </div>
                </div>
            <?php } ?>
            
            <script type="text/javascript">
                $(function () {
                    $("#fse_id_h").autocomplete({
                        source: function (request, response) {
                            $.ajax({
                                url: "<?php echo base_url(); ?>TaskController/getFse_autocomplete_c",
                                dataType: "json",
                                type: "POST",
                                data: request,
                                success: function (data) {
                                    response(data);
                                }
                            });
                        },
                        focus: function (event, ui) {
                            $("#fse_id_h").val(ui.item.label);
                            return false;
                        },
                        select: function (event, ui) {
                            $('#fse_id').val(ui.item.value);
                            return false;
                        },
                        change: function (e, u) {
                            if (u.item == null) {
                                $(this).val("");
                                return false;
                            }
                        },
                        appendTo: '#autocomplete-container',
                        minLength: 2
                    });
                });
            </script>
            
            
            <?php if (in_array(2, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Choose Entity / Branch
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="radio">
                            <label><input type="radio" name="optButtonradio" checked="checked" <?php if ($result[0]['ent_id'] != 0) { ?> checked="checked" <?php } ?> value="EntityDiv">Entity</label> 
                            <label><input type="radio" name="optButtonradio" <?php if ($result[0]['branch_id'] != 0) { ?> checked="checked" <?php } ?> value="BranchDiv">Branch</label>
                        </div>
                    </div>
                </div>	
                <div class="form-group desc_entity" id="EntityDiv" <?php if ($result[0]['ent_id'] != 0) { ?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?>>
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Entity <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="ent_id" id="ent_id">
                            <option value="">Select</option>
                            <?php
                            foreach ($results['getEntity'] AS $getEntity) {
                                $selected = ($getEntity['id'] == $result[0]['ent_id']) ? 'selected' : null;
                                echo '<option value="' . $getEntity['id'] . '" echo ' . $selected . '>' . $getEntity['ent_name'] . '</option>';
                            }
                            ?>
                        </select>

                        <span class="text-danger"><?php echo form_error('ent_id'); ?></span>
                    </div>
                </div>			
                <div class="form-group desc_entity" id="BranchDiv" <?php if ($result[0]['branch_id'] != 0) { ?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?>>
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Branch <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <select class="form-control col-md-7 col-xs-12" name="branch_id" id="branch_id">
                            <option value="">Select</option>
                            <?php
                            foreach ($results['getBranch'] AS $getBranch) {
                                $selected = ($getBranch['id'] == $result[0]['branch_id']) ? 'selected' : null;
                                echo '<option value="' . $getBranch['id'] . '" echo ' . $selected . '>' . $getBranch['branch_name'] . '</option>';
                            }
                            ?>
                        </select>

                        <span class="text-danger"><?php echo form_error('branch_id'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (FALSE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Choose Project / Incident
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="radio">
                            <label><input type="radio" name="optradio" <?php if ($result[0]['project_id'] != 0) { ?> checked="checked" <?php } ?> value="projectDiv">Project</label> 
                            <label><input type="radio" name="optradio" <?php if ($result[0]['incident_id'] != 0) { ?> checked="checked" <?php } ?> value="incidentDiv">Incident</label>
                        </div>
                    </div>
                </div> 
                <div class="form-group desc" id="projectDiv" <?php if ($result[0]['project_id'] != 0) { ?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?>> 
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Project <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="project_id" id="project_id">
                            <option value="">Select</option>
                            <?php
                            foreach ($results['getProject'] AS $getProject) {
                                $selected = ($getProject['id'] == $result[0]['project_id']) ? 'selected' : null;
                                echo '<option value="' . $getProject['id'] . '" echo ' . $selected . '>' . $getProject['proj_name'] . '</option>';
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('project_id'); ?></span>
                    </div>
                </div>  

                <div class="form-group desc"  id="incidentDiv" <?php if ($result[0]['incident_id'] != 0) { ?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?>>
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Incident <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="incident_id" id="incident_id">
                            <option value="">Select</option>
                            <?php
                            foreach ($results['getIncident'] AS $getIncident) {
                                $selected = ($getIncident['id'] == $result[0]['incident_id']) ? 'selected' : null;
                                echo '<option value="' . $getIncident['id'] . '" echo ' . $selected . '>' . $getIncident['incident_name'] . '</option>';
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('incident_id'); ?></span>
                    </div>
                </div> 
            <?php } ?>
            
            <?php if (in_array(3, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Choose Project / Incident
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="radio">
                            <label><input type="radio" name="optradio" <?php if ($result[0]['project_id'] != 0) { ?> checked="checked" <?php } ?> value="projectDiv">Project</label> 
                            <label><input type="radio" name="optradio" <?php if ($result[0]['incident_id'] != 0) { ?> checked="checked" <?php } ?> value="incidentDiv">Incident</label>
                        </div>
                    </div>
                </div> 
                <div class="form-group desc" id="projectDiv" <?php if ($result[0]['project_id'] != 0) { ?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?>> 
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Project <span class="required">*</span>
                    </label>
                    
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="project_id_h" id="project_id_h" value="<?php echo $result[0]['proj_name']; ?>" class="form-control col-md-7 col-xs-12" style="float: left;" />
                        <div id="autocomplete-container-project_id" style="position: relative; float: left; width: 400px; margin: 10px;"></div>
                        <input type="hidden" name = "project_id" id="project_id" value="<?php echo $result[0]['project_id']; ?>"/>
                        <span class="text-danger"><?php echo form_error('project_id'); ?></span>
                    </div>                                     
                </div>  
                <script type="text/javascript">
                    $(function () {
                        $("#project_id_h").autocomplete({
                            source: function (request, response) {
                                $.ajax({
                                    url: "<?php echo base_url(); ?>TaskController/getProject_autocomplete_c",
                                    dataType: "json",
                                    type: "POST",
                                    data: request,
                                    success: function (data) {
                                        response(data);
                                    }
                                });
                            },
                            focus: function (event, ui) {
                                $("#project_id_h").val(ui.item.label);
                                return false;
                            },
                            select: function (event, ui) {
                                $('#project_id').val(ui.item.value);
                                $('#incident_id').val('');
                                return false;
                            },
                            change: function (e, u) {
                            if (u.item == null) {
                                $(this).val("");
                                return false;
                            }
                            },
                            appendTo: '#autocomplete-container-project_id',
                            minLength: 2
                        });
                    });
                </script>
                <div class="form-group desc"  id="incidentDiv" <?php if ($result[0]['incident_id'] != 0) { ?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?>>
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Incident <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="incident_id_h" id="incident_id_h" value="<?php echo $result[0]['incident_name']; ?>" class="form-control col-md-7 col-xs-12" style="float: left;" />
                        <div id="autocomplete-container-incident_id" style="position: relative; float: left; width: 400px; margin: 10px;"></div>
                        <input type="hidden" name = "incident_id" id="incident_id" value="<?php echo $result[0]['incident_id']; ?>"/>
                        <span class="text-danger"><?php echo form_error('incident_id'); ?></span>
                        
                    </div>
                </div> 
                
                <script type="text/javascript">
                    $(function () {
                        $("#incident_id_h").autocomplete({
                            source: function (request, response) {
                                $.ajax({
                                    url: "<?php echo base_url(); ?>TaskController/getIncident_autocomplete_c",
                                    dataType: "json",
                                    type: "POST",
                                    data: request,
                                    success: function (data) {
                                        response(data);
                                    }
                                });
                            },
                            focus: function (event, ui) {
                                $("#incident_id_h").val(ui.item.label);
                                return false;
                            },
                            select: function (event, ui) {
                                $('#incident_id').val(ui.item.value);
                                $('#project_id').val('');
                                return false;
                            },
                            change: function (e, u) {
                            if (u.item == null) {
                                $(this).val("");
                                return false;
                            }
                            },
                            appendTo: '#autocomplete-container-incident_id',
                            minLength: 2
                        });
                    });
                </script>
                
            <?php } ?>
            
            
            <?php if (in_array(4, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Call Number  <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="task_name" name="call_number" value="<?php echo @$result[0]['call_number'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('call_number'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <!--            <div class="form-group desc" style="display:none;">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Customer <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control col-md-7 col-xs-12" name="customer_id" id="customer_id">
                                    <option value="">Select</option>
            <?php
            // foreach ($results['getCustomer'] AS $getCustomer) {
            //    $selected = ($getCustomer['id'] == $result[0]['customer_id']) ? 'selected' : null;
            //    echo '<option value="' . $getCustomer['id'] . '" echo ' . $selected . '>' . $getCustomer['cus_name'] . '</option>';
            // }
            ?>
                                </select>
                                <span class="text-danger"><?php // echo form_error('customer_id');   ?></span>
                            </div>
            if (in_array(5, $task_field))
                        </div> -->
            <?php if (TRUE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="status_id" id="status_id">
                            <option value="">Select</option>
                            <?php
                            foreach ($results['getStatus'] AS $getStatus) {
                                $selected = ($getStatus['id'] == $result[0]['status_id']) ? 'selected' : null;
                                echo '<option value="' . $getStatus['id'] . '" echo ' . $selected . '>' . $getStatus['status_type'] . '</option>';
                            }
                            ?>  
                        </select>
                        <span class="text-danger"><?php echo form_error('status_id'); ?></span>
                    </div>
                </div> 
            <?php } ?>
            <?php if (in_array(6, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">SLA <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="sla_id" id="sla_id">
                            <option value="">Select</option>
                            <?php
                            foreach ($results['getSla'] AS $getSla) {
                                $selected = ($getSla['id'] == $result[0]['sla_id']) ? 'selected' : null;
                                echo '<option value="' . $getSla['id'] . '" echo ' . $selected . '>' . $getSla['sla_name'] . '</option>';
                            }
                            ?>  
                        </select>
                        <span class="text-danger"><?php echo form_error('sla_id'); ?></span>
                    </div>
                </div> 
            <?php } ?>
            <?php if (in_array(7, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Task Description <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control col-md-7 col-xs-12" name="task_description" id="task_description"><?php echo $result[0]['task_description']; ?></textarea>
                        <span class="text-danger"><?php echo form_error('task_description'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(8, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Logged <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12 controls input-append date form_datetime"  data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                        <input size="16" type="text" value="<?php echo $result[0]['start_date']; ?>" name="start_date" id="datetimepicker_start"   class="form-control col-md-7 col-xs-12">
                        <span class="add-on"><i class="icon-remove"></i></span>
                        <span class="add-on"><i class="icon-th"></i></span>
                        <span class="text-danger"><?php echo form_error('datetimepicker_start'); ?></span>
                    </div>
                    <input type="hidden" id="dtp_input1" value="" /><br/>
                </div>
            <?php } ?>
            <!--            <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">End Date <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12 controls input-append date form_datetime"  data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                                <input size="16" type="text" value="<?php //echo $result[0]['end_date'];   ?>" name="end_date" id="datetimepicker_end" class="form-control col-md-7 col-xs-12">
                                <span class="add-on"><i class="icon-remove"></i></span>
                                <span class="add-on"><i class="icon-th"></i></span>
                                <span class="text-danger"><?php //echo form_error('datetimepicker_end');   ?></span>
                            </div>
                            <input type="hidden" id="dtp_input1" value="" /><br/>
                        </div>-->
            <?php if (in_array(9, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control col-md-7 col-xs-12" name="task_address" id="task_address"><?php echo $result[0]['task_address']; ?></textarea>
                        <span class="text-danger"><?php echo form_error('task_address'); ?></span>
                        <input type="hidden" id="task_location" name="task_location" value="<?php echo $resultLoc['task_location'] ?>"  />
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(10, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Product Name <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="product_name" name="product_name" value="<?php echo $result[0]['product_name']; ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('product_name'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(11, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Serial Number <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="serial_number" name="serial_number" value="<?php echo $result[0]['serial_number']; ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('serial_number'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(12, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Product Code <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="product_code" name="product_code" value="<?php echo $result[0]['product_code']; ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('product_code'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(13, $task_field)) { ?>
                <div class="form-group input_fields_wrap"> 
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Check List <span class="required">*</span></label> 
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                        //$task_checklist = json_encode(explode(',', substr($result[0]['task_checklist'], 1, -1)));
                        //echo $task_checklist; 
                        $json = $result[0]['task_checklist'];
                        if ($json != '') {
                            $resultchecklist = json_decode($json);
                            $resultlist = trim(implode(",", $resultchecklist), ",");
                        } else {
                            $resultlist = '';
                        }
                        ?>
                        <input type="text"  name="taskchecklist[]" value="<?php echo $resultlist; ?>" class="form-control col-md-7 col-xs-12">
                    </div>
                    <div style="display:inline;"><button class="add_field_button btn btn-success">Add</button></div>
                </div>
            <?php } ?>
            <?php if (in_array(14, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Book Code  <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="book_code" name="book_code" value="<?php echo @$result[0]['book_code'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('book_code'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(15, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Manual Docket Number  <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="manual_docket_number" name="manual_docket_number" value="<?php echo @$result[0]['manual_docket_number'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('manual_docket_number'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(29, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Customer Name<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="customer_name" name="customer_name" value="<?php echo @$result[0]['customer_name'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('customer_name'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(32, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Customer Address <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control col-md-7 col-xs-12" name="customerAddress" id="customerAddress" ><?php echo @$result[0]['customerAddress'] ?></textarea>
                        <!--<input type="text" id="problem" name="problem" value="<?php //echo @$result[0]['problem'] ?>" class="form-control col-md-7 col-xs-12">-->
                        <span class="text-danger"><?php echo form_error('customerAddress'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(16, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Customer Contact Person<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="customer_contact_person" name="customer_contact_person" value="<?php echo @$result[0]['customer_contact_person'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('customer_contact_person'); ?></span>
                    </div>
                </div>
            <?php } ?>
            
            <?php if (in_array(17, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Customer Contact Number <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="customer_contact_number" name="customer_contact_number" value="<?php echo @$result[0]['customer_contact_number'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('customer_contact_number'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(18, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Model <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="model" name="model" value="<?php echo @$result[0]['model'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('model'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(19, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Problem 1 <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control col-md-7 col-xs-12" name="problem" id="problem" ><?php echo @$result[0]['problem'] ?></textarea>
                        <!--<input type="text" id="problem" name="problem" value="<?php //echo @$result[0]['problem'] ?>" class="form-control col-md-7 col-xs-12">-->
                        <span class="text-danger"><?php echo form_error('problem'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(30, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Problem 2 <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control col-md-7 col-xs-12" name="problem1" id="problem1" ><?php echo @$result[0]['problem1'] ?></textarea>
                        <!--<input type="text" id="problem" name="problem" value="<?php //echo @$result[0]['problem'] ?>" class="form-control col-md-7 col-xs-12">-->
                        <span class="text-danger"><?php echo form_error('problem1'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(31, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Location <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea class="form-control col-md-7 col-xs-12" name="location" id="location" ><?php echo @$result[0]['location'] ?></textarea>
                        <!--<input type="text" id="problem" name="problem" value="<?php //echo @$result[0]['problem'] ?>" class="form-control col-md-7 col-xs-12">-->
                        <span class="text-danger"><?php echo form_error('location'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(20, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Call Status <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="call_status" id="call_status">
                            <option value="">Select</option>
                            <?php
                            foreach ($results['CallStatus'] AS $CallStatus) {
                                $selected = ($CallStatus['id'] == $result[0]['call_status']) ? 'selected' : null;
                                echo '<option value="' . $CallStatus['id'] . '" '.$selected.'  >' . $CallStatus['callstatus_type'] . '</option>';
                            }
                            ?> 
                        </select>
                        <span class="text-danger"><?php echo form_error('call_status'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(21, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Call Type <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="call_type" id="call_type">
                            <option value="">Select</option>
                            <?php
                            foreach ($results['CallType'] AS $CallType) {
                                $selected = ($CallType['id'] == $result[0]['call_type']) ? 'selected' : null;
                                echo '<option value="' . $CallType['id'] . '" '.$selected.'>' . $CallType['calltype_type'] . '</option>';
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('call_type'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php //if (in_array(22, $task_field)) 
                   if(TRUE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Priority <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="priority" id="priority">
                            <option value="">Select</option>
                            <?php
                            foreach ($results['Priority'] AS $Priority) {
                                 $selected = ($Priority['id'] == $result[0]['priority']) ? 'selected' : null;
                                echo '<option value="' . $Priority['id'] . '" '.$selected.'>' . $Priority['priority_type'] . '</option>';
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('priority'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(23, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Message <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="message" name="message" value="<?php echo @$result[0]['message'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('message'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(24, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Comment Charge <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="comment_charge" name="comment_charge" value="<?php echo @$result[0]['comment_charge'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('comment_charge'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(25, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Previous Meter Reading <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="previous_meter_reading" name="previous_meter_reading" value="<?php echo @$result[0]['previous_meter_reading'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('previous_meter_reading'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(26, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Previous Color Reading <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="previous_color_reading" name="previous_color_reading" value="<?php echo @$result[0]['previous_color_reading'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('previous_color_reading'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(27, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Customer Order Number <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="customer_order_number" name="customer_order_number" value="<?php echo @$result[0]['customer_order_number'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('customer_order_number'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array(28, $task_field)) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Outstanding Calls <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="outstanding_calls" name="outstanding_calls" value="<?php echo @$result[0]['outstanding_calls'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('outstanding_calls'); ?></span>
                    </div>
                </div>
            <?php } ?>
            <?php if (FALSE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Line <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="productline" id="productline">
                            <option value="">Select</option>
                            <?php
                            foreach ($results['productline'] AS $productline) {
                                if($productline['value'] == $result[0]['productline']){
                                echo '<option value="' . $productline['value'] . '" selected>' . $productline['value'] . '</option>';
                                }else{
                                echo '<option value="' . $productline['value'] . '">' . $productline['value'] . '</option>';    
                                }
                                }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('productline'); ?></span>
                    </div>
                </div> 
            <?php } ?>
            
            <?php if (TRUE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Line <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
    <!--                        <select class="form-control col-md-7 col-xs-12" name="productline" id="productline">
                            <option value="">Select</option>
                        <?php
                        //foreach ($result['productline'] AS $productline) {
                        //   echo '<option value="' . $productline['value'] . '">' . $productline['value'] . '</option>';
                        // }
                        ?>
                        </select>-->

                        <input type="text" name="productline" id="productline" value = "<?php echo $result[0]['productline']; ?>" class="form-control col-md-7 col-xs-12" style="float: left;" />
                        <div id="autocomplete-container-productline" style="position: relative; float: left; width: 400px; margin: 10px;"></div>


                        <span class="text-danger"><?php echo form_error('productline'); ?></span>
                    </div>
                </div> 

                <script type="text/javascript">
                    $(function () {
                        $("#productline").autocomplete({
                            source: function (request, response) {
                                $.ajax({
                                    url: "<?php echo base_url(); ?>TaskController/productline_autocomplete_c",
                                    dataType: "json",
                                    type: "POST",
                                    data: request,
                                    success: function (data) {
                                        response($.map(data, function (item) {
                                            return {
                                                label: item,
                                                value: item
                                            }
                                        }));
                                    }
                                });
                            },
                            appendTo: '#autocomplete-container-productline',
                            minLength: 2,
                            select: function (event, ui) {
                                AutoCompleteSelectHandler(event, ui)
                            },
                            change: function (e, u) {
                            if (u.item == null) {
                                $(this).val("");
                                return false;
                            }
                            }
                        });
                    });
                    function AutoCompleteSelectHandler(event, ui)
                    {
                        var selectedObj = ui.item;
                        var productline = selectedObj.value;
                        actionCodeGet(productline);
                        sectionCodeGet(productline);
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>TaskController/problemOne",
                            data: {productline: productline}
                        }).done(function (data) {
                            $("#sn_problem1").html(data);
                        });
                    }
                </script>

            <?php } ?>
            
            
            <?php if (TRUE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Problem 1<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="sn_problem1" id="sn_problem1">
                            <option value="">Select</option>
                            <?php
                            foreach ($problemOneModel AS $problemOne) {
                                if($problemOne['value'] == $result[0]['sn_problem1']){
                                echo '<option value="' . $problemOne['value'] . '" selected>' . $problemOne['value'] . '</option>';
                                }else{
                                echo '<option value="' . $problemOne['value'] . '">' . $problemOne['value'] . '</option>';    
                                }
                                }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('sn_problem1'); ?></span>
                    </div>
                </div> 
            <?php } ?>
            <?php if (TRUE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Problem 2<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="sn_problem2" id="sn_problem2">
                            <option value="">Select</option>
                            <?php
                            foreach ($problemTwoModel AS $problemTwo) {
                                if($problemTwo['value'] == $result[0]['sn_problem2']){
                                echo '<option value="' . $problemTwo['value'] . '" selected>' . $problemTwo['value'] . '</option>';
                                }else{
                                echo '<option value="' . $problemTwo['value'] . '">' . $problemTwo['value'] . '</option>';    
                                }
                                }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('sn_problem2'); ?></span>
                    </div>
                </div> 
            <?php } ?>
            
            <?php if (TRUE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Location<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="sn_location" id="sn_location">
                            <option value="">Select</option>
                            <?php
                            foreach ($snLocationModel AS $snLocation) {
                                if($snLocation['value'] == $result[0]['sn_location']){
                                echo '<option value="' . $snLocation['value'] . '" selected>' . $snLocation['value'] . '</option>';
                                }else{
                                echo '<option value="' . $snLocation['value'] . '">' . $snLocation['value'] . '</option>';    
                                }
                                }
                            ?>
                            
                        </select>
                        <span class="text-danger"><?php echo form_error('sn_location'); ?></span>
                    </div>
                </div> 
            <?php } ?>
            
            <?php if (TRUE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Action Code<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="action_code" id="action_code">
                            <option value="">Select</option>
                            <?php
                            foreach ($actionCodeModel AS $actionCode) {
                                if($actionCode['value'] == $result[0]['action_code']){
                                echo '<option value="' . $actionCode['value'] . '" selected>' . $actionCode['value'] . '</option>';
                                }else{
                                echo '<option value="' . $actionCode['value'] . '">' . $actionCode['value'] . '</option>';    
                                }
                                }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('action_code'); ?></span>
                    </div>
                </div> 
            <?php } ?>
            
            <?php if (TRUE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Section Code<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="section_code" id="section_code">
                            <option value="">Select</option>
                            <?php
                            foreach ($sectionCodeModel AS $sectionCode) {
                                if($sectionCode['value'] == $result[0]['section_code']){
                                echo '<option value="' . $sectionCode['value'] . '" selected>' . $sectionCode['value'] . '</option>';
                                }else{
                                echo '<option value="' . $sectionCode['value'] . '">' . $sectionCode['value'] . '</option>';    
                                }
                                }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('section_code'); ?></span>
                    </div>
                </div> 
            <?php } ?>
                       
            <?php if (TRUE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Location Code<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="location_code" id="location_code">
                            <option value="">Select</option>
                            <?php
                            foreach ($locationCodeModel AS $locationCode) {
                                if($locationCode['value'] == $result[0]['location_code']){
                                echo '<option value="' . $locationCode['value'] . '" selected>' . $locationCode['value'] . '</option>';
                                }else{
                                echo '<option value="' . $locationCode['value'] . '">' . $locationCode['value'] . '</option>';    
                                }
                                }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('location_code'); ?></span>
                    </div>
                </div> 
            <?php } ?>
            
            <?php if (TRUE) { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Close Code<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="close_code" id="close_code">
                            <option value="">Select</option>
                            <?php
                            foreach ($closeCodeModel AS $closeCode) {
                                if($closeCode['close_code'] == $result[0]['close_code']){
                                echo '<option value="' . $closeCode['close_code'] . '" selected>' . $closeCode['close_code'] . '</option>';
                                }else{
                                echo '<option value="' . $closeCode['close_code'] . '">' . $closeCode['close_code'] . '</option>';    
                                }
                                }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('close_code'); ?></span>
                    </div>
                </div> 
            <?php } ?>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="<?php echo base_url() ?>task" class="btn btn-primary">Cancel</a>  
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>
        </form>

    </div>
</div>
<script src="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.full.js"></script>
<script>
    
    $("select#section_code").change(function(){
        var section_code = $("#section_code option:selected").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>TaskController/locationCode",
            data: { section_code : section_code } 
        }).done(function(data){
            $("#location_code").html(data);
        });
    });
    
    $("select#sn_problem1").change(function(){
        var sn_problem1 = $("#sn_problem1 option:selected").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>TaskController/problemTwo",
            data: { sn_problem1 : sn_problem1 } 
        }).done(function(data){
            $("#sn_problem2").html(data);
        });
    });
    
    $("select#sn_problem2").change(function(){
        var sn_problem2 = $("#sn_problem2 option:selected").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>TaskController/snLocation",
            data: { sn_problem2 : sn_problem2 } 
        }).done(function(data){
            $("#sn_location").html(data);
        });
    });
    
    
    $("select#productline").change(function(){
        
        var productline = $("#productline option:selected").val();
        actionCodeGet(productline);
        sectionCodeGet(productline);
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>TaskController/problemOne",
            data: { productline : productline } 
        }).done(function(data){
            $("#sn_problem1").html(data);
        });
    });
    
    function actionCodeGet(productline) {
     // alert(productline);
       $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>TaskController/actionCode",
            data: { productline : productline } 
        }).done(function(data){
            $("#action_code").html(data);
        });
      
    }
    
    function sectionCodeGet(productline) {
     // alert(productline);
       $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>TaskController/sectionCode",
            data: { productline : productline } 
        }).done(function(data){
            $("#section_code").html(data);
        });
    }
    
    
    $("#datetimepicker_start").datetimepicker({
        //dateFormat :'dd M yy',
        value: '<?php echo $result[0]['start_date']; ?>',
        mask: '9999/19/39',
    });

    $("#datetimepicker_end").datetimepicker({
        //dateFormat :'dd M yy',
        value: '<?php echo $result[0]['end_date']; ?>',
        mask: '9999/19/39',
    });


</script>

<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
        height: 100%;
        width: 100%;
        top: -6px;
    }
    .modal-body
    {
        padding: 0px;
    }

    #floating-panel {
        position: absolute;


        z-index: 5;
        background-color: #fff;


        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        /*padding-left: 10px;*/
        width: 350px;
        background: none;
        padding-top: 5px;
        left:35%;
    }
    .addBar
    {
        height: 28px;padding: 0px 6px;line-height: 10px;
    }
</style>


<!-- <script
    src="https://code.jquery.com/jquery-1.12.4.min.js"
    integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
crossorigin="anonymous"></script> -->
<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            center: {lat: -31.20340495091738, lng: 24.547855854034424}
        });
        var geocoder = new google.maps.Geocoder();


        // Try HTML5 geolocation.
        /*
         if (navigator.geolocation) {
         navigator.geolocation.getCurrentPosition(function(position) {
         var pos = {
         lat: position.coords.latitude,
         lng: position.coords.longitude
         };
         
         //infoWindow.setPosition(pos);
         //infoWindow.setContent('Location found.');
         map.setCenter(pos);
         }, function() {
         handleLocationError(true, infoWindow, map.getCenter());
         });
         } else {
         // Browser doesn't support Geolocation
         handleLocationError(false, infoWindow, map.getCenter());
         }
         */



        document.getElementById('submit').addEventListener('click', function () {
            geocodeAddress(geocoder, map);
        });

        //Add listener
        google.maps.event.addListener(map, "click", function (event) {
            var latitude = event.latLng.lat();
            var longitude = event.latLng.lng();
            console.log(latitude + ', ' + longitude);
            var point = new google.maps.LatLng(latitude, longitude);
            // alert(point);
            $('#task_location').val(point);
            findAddress(point);

        }); //end addListener

    }

    function findAddress(point) {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({latLng: point}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    // infoWindow.setContent(results[0].formatted_address);
                    // infoWindow.setPosition(point);
                    // infoWindow.open(map);
                    // alert(results[0].formatted_address);
                    $('#task_address').val(results[0].formatted_address);
                    $('#myModal').css('display', 'none');
                }
            }
        });
    }

    function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function (results, status) {
            if (status === 'OK') {
                resultsMap.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location
                });



            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeubS8KjHiTu2TI7I5X_4IjGZCI0zeKGY&callback=initMap">
</script>
<style>
    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 50px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        position: relative;
        background-color: #fefefe;
        margin: auto;
        padding: 0;
        border: 1px solid #888;
        width: 80%;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s
    }



    /* The Close Button */
    .close {
        color: white;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-header {
        /*padding: 2px 16px;*/
        background-color: #172d44;
        color: white;
        font-size: 14px;
    }
    .modal-header h2 {
        margin: 0px !important;
        padding: 5px !important;
        font-size: 14px;
    }
    .modal-body {padding: 0px; height: 400px;}

    .modal-footer {
        padding: 2px 16px;
        background-color: #5cb85c;
        color: white;
    }
</style>



<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close" id="close_map">&times;</span>
            <h2>Select Address from Google Map</h2>
        </div>
        <div class="modal-body">
            <div id="floating-panel">
                <input id="address" type="textbox" class="addBar" value="">
                <input id="submit" type="button" class="addBar" value="Get Address">
            </div>

            <div id="map"></div>
        </div>

    </div>

</div>

<script>
// Get the modal
    var modal = document.getElementById('myModal');

// Get the button that opens the modal
    var btn = document.getElementById("task_address");

// Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

    var spanId = document.getElementById("close_map");

// When the user clicks the button, open the modal 
    btn.onclick = function () {
        modal.style.display = "block";
        google.maps.event.trigger(map, "resize");
    }

// When the user clicks on <span> (x), close the modal
// span.onclick = function() {
//     modal.style.display = "none";
// }

    spanId.onclick = function () {
        modal.style.display = "none";
    }

// When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var max_fields = 20; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button "); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="form-group"> <label for="last-name" class="control-label col-md-3 col-sm-3 col-xs-12"></label> <div class="col-md-6 col-sm-6 col-xs-12"><input type="text" name="taskchecklist[]" class="form-control col-md-7 col-xs-12"></div><a class="btn btn-primary remove_field" href="#">Remove</a></div>'); //add input box
            }
        });

        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });
</script>

