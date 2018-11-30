<style type="text/css">
    #Add_Entity label.error {
        color: #FB3A3A;
        display: inline-block;
        padding: 0;
        text-align: left;
        width: 220px;
    }

    /*Check box*/
   
    .hidefieldhold .brd1 {
    border: 1px solid #ddd;
    margin-top: 12px;
    margin-bottom: 18px;
    padding: 8px;
    }
    
    .hidefieldhold .form-control {
    border: none;
    margin-bottom: 0px;
    clear: both;
    }

    .advancedbtn {
    /* color: #337ab7; */
    font-size: 15px;
    border-bottom: 1px solid #337ab7;
    padding-bottom: 2px;
}
    
       .form-check label{
        position: relative;
        cursor: pointer;
        color: #666;
        font-size: 22px;
    }
    
    input[type="checkbox"], input[type="radio"]{
        position: absolute;
        right: 9000px;
    }

    /*Check box*/
    input[type="checkbox"] + .label-text:before{
        content: "\f096";
        font-family: "FontAwesome";
        speak: none;
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        -webkit-font-smoothing:antialiased;
        width: 1em;
        display: inline-block;
        margin-right: 5px;
    }

    input[type="checkbox"]:checked + .label-text:before{
        content: "\f14a";
        color: #2a3f54;
        animation: effect 250ms ease-in;
    }

    input[type="checkbox"]:disabled + .label-text{
        color: #aaa;
    }

    input[type="checkbox"]:disabled + .label-text:before{
        content: "\f0c8";
        color: #ccc;
    }

    @keyframes effect{
        0%{transform: scale(0);}
        25%{transform: scale(1.3);}
        75%{transform: scale(1.4);}
        100%{transform: scale(1);}
    }
</style>
<script type="text/javascript">

    (function ($, W, D)
    {
        var JQUERY4U = {};

        JQUERY4U.UTIL =
                {
                    setupFormValidation: function ()
                    {
                        //form validation rules
                        $("#Add_Entity").validate({
                            rules: {
                                ent_name: "required",
                                ent_address: "required",
                                ent_year: "required",
                                flow: "required",
                                entity_color: "required",
                                entity_secondary_color: "required",
                                ent_type: {
                                    required: true
                                }
                            },
                            messages: {
                                ent_name: "Please Enter Your Entity Name",
                                ent_address: "Please Enter Your Address",
                                ent_year: "Please Enter Your Entity Year",
                                ent_type: "Please Select Entity Type",
                                flow: "Please Select flow",
                                entity_color: "Please Select Entity Color",
                                entity_secondary_color: "Please Select Entity secondary color",
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

<div class="x_panel"  style="min-width:1100px;height-min:600px;">
    <div class="x_title">
        <h2>Add Entity<small></small></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form id="Add_Entity" name="Add_Entity" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url() ?>addEntity" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Entity Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="ent_name" name="ent_name" value="<?php echo @$post['ent_name'] ?>" class="form-control col-md-7 col-xs-12">
                    <span class="text-danger"><?php echo form_error('ent_name'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control col-md-7 col-xs-12" name="ent_address" id="ent_address"><?php echo @$post['ent_address'] ?></textarea>
                    <span class="text-danger"><?php echo form_error('ent_address'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Year <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="ent_year" name="ent_year" readonly value="<?php echo @$post['ent_year'] ?>" class="date-picker form-control col-md-7 col-xs-12"  type="text">
                    <span class="text-danger"><?php echo form_error('ent_year'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Entity Logo <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="file" name="file" id="file"> 
                    <span class="text-danger"><?php echo form_error('upload'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Entity Color <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="demo1 form-control colorpicker-element" value="#fffff" type="text" name="entity_color">
                    <span class="text-danger"><?php echo form_error('entity_color'); ?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Secondary Color <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="demo1 form-control colorpicker-element" value="#fffff" type="text" name="entity_secondary_color">
                    <span class="text-danger"><?php echo form_error('entity_color'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Flow <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control col-md-7 col-xs-12" name="flow" id="flow">
                        <option value="">Select</option>
                        <option value="0">Single Acceptance</option>
                        <option value="1">Multiple Acceptance</option>
                    </select>

                    <span class="text-danger"><?php echo form_error('flow'); ?></span>
                </div>
            </div>
<!--//--start - ------old code by dev.com-->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Upload Document 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="radio">
                        <label><input type="radio" name="thirdPartyoption" id="thirdPartyoption" value="1">Yes</label> 
                        <label><input type="radio" name="thirdPartyoption" id="thirdPartyoption" checked="checked" value="0">No</label>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $("input[name$='thirdPartyoption']").click(function () {
                    var optionvalue = $(this).val();
                    $("#t_document_upload").val(optionvalue);
                    if (optionvalue == 1) {
                        $("#thirdPartydocument_upload").css("display", "block");
                    } else {
                        $("#thirdPartydocument_upload").css("display", "none");
                    }
                });
            </script>

            <input type="hidden" name="tp_document_upload" id="t_document_upload" value=""/>

            <div id="thirdPartydocument_upload" style="display:none;">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Method <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="tp_method" name="tp_method" value="<?php echo @$post['tp_method'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('tp_method'); ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">End Point <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="ent_name" name="tp_endpoint" value="<?php echo @$post['tp_endpoint'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('tp_endpoint'); ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Username <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="ent_name" name="tp_username" value="<?php echo @$post['tp_username'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('tp_username'); ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Password <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="ent_name" name="tp_password" value="<?php echo @$post['tp_password'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('tp_password'); ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">API Key <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="ent_name" name="tp_apikey" value="<?php echo @$post['tp_apikey'] ?>" class="form-control col-md-7 col-xs-12">
                        <span class="text-danger"><?php echo form_error('tp_apikey'); ?></span>
                    </div>
                </div>
            </div>
<!--//-end -----------old code by dev.com-->
<!--//-start -----------new code added-->
<?php if ($Admin_check == TRUE || $SuperAdmin_check == TRUE) { ?>
            <div class="form-group advance">
                <label class="control-labels col-md-3 col-sm-3 col-xs-12 text-right"><a class="advancedbtn" href="#">Advanced</a>
                </label>

                <div class="col-md-6 col-sm-6 col-xs-12 hidefieldhold" style="display:none;">
                    <div class="brd1">
                        <p>Configure active modules for this Entity:</p>
                        <div class="form-group form-control">
                            <div class="form-check pull-left">
                                <label>
                                    <input class="" type="checkbox" id="hidefield" name="check">
                                    <span class="label-text"></span>
                                </label>
                            </div>

                            <label class="pull-left text-left" for="last-name">Advanced Map Functionality
                            </label>
                        </div>
                        
                        <div class="form-group form-control">
                            <div class="form-check pull-left">
                                <label>
                                    <input class="" type="checkbox" id="hidefield" name="check" >
                                    <span class="label-text"></span>
                                </label>
                            </div>

                            <label class="pull-left text-left" for="last-name">Scheduling
                            </label>
                        </div>
                        
                        <div class="form-group form-control">
                            <div class="form-check pull-left">
                                <label>
                                    <input class="" type="checkbox" id="hidefield" name="check">
                                    <span class="label-text"></span>
                                </label>
                            </div>

                            <label class="pull-left text-left" for="last-name">Advanced Reporting
                            </label>
                        </div>

                    </div>
                </div>
            </div>
<?php } ?>
                <div class="clearfix"></div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <a href="<?php echo base_url() ?>entity" class="btn btn-primary">Cancel</a>  
                        <input type="submit" class="btn btn-success" name="submit" value="Submit">
                    </div>
                </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        <?php if($Admin_check == TRUE && $SuperAdmin_check == FALSE ){ ?>
        $('.advance :input').prop("disabled", true);
        <?php } ?>
        $('#ent_year').daterangepicker({
            singleDatePicker: true,
            calender_style: "picker_4"
        }, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });


    $(".control-labels").click(function(){
             $('.hidefieldhold').toggle(600);
      });
      
      
   var uploadField = document.getElementById("file");

uploadField.onchange = function() {
    if(this.files[0].size > 2e+6){
       alert("File is too big! You have to upload max 2mb size logo");
       this.value = "";
    };
};   
      
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datepicker/daterangepicker.js"></script>      
<style>
   .advance input[type="checkbox"]:disabled { 
    color : darkGray;
    font-style: italic;
}
</style>