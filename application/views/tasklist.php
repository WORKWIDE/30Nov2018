<style>
    .container {
    /*width: 1400px !important;*/
    padding: 0;
}
</style>
<!--add task report search form functionality--> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.css"/>
<style type="text/css">
    #Generate_Report label.error {
        color: #FB3A3A;
        display: inline-block;
        padding: 0;
        text-align: left;
        width: 220px;
    }	
    .customReportForm select {
        -webkit-appearance: none;
        -moz-appearance:    none;
        appearance:         none;
        position:relative;
        line-height:1;
        background:url('<?php echo base_url(); ?>assets/images/down-arrow.png') no-repeat 98% center;	   
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
                        $("#Generate_Report").validate({
                            rules: {
                                tasktypeid: "required",
                            },
                            messages: {
                                tasktypeid: "Please Select Task Type",
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

<!--add task report search form functionality--> 


<div class="x_panelhold" style="min-height:600px; height: auto;">
    <div class="x_title">
        <h2>Task View </h2>  <a href="<?php echo base_url() ?>task" id="send"  class="btn btn-success" style="float:right;">Search</a>
         <?php 
    if ($entityFeilds != FALSE) {
        if (!empty($entityFeilds)) {
            $task_field = json_decode($entityFeilds);
        } else {
            $task_field = array();
        }
    } else {
        $task_field = array();
    }
    ?>
    <?php $k = 1; ?>
        <div class="clearfix"></div>
 </div>
    <div class="x_content"> 

<table id="tasklist" class="table table-striped table-bordered nowrap x_panel tasklistviews" data-page-length='10' style="width:100%">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Task Name</th>
                <th>Task Type</th>
                <th>Field Engineer</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Address</th>
                <th>Date Logged</th>
                 <?php
                    if (isset($result[0]['customFields'])) {
                        if (!empty($result[0]['customFields'])) {
                            foreach ($result[0]['customFields'] as $key => $value) {
                                echo "<th>" . $key . "</th>";
                            }
                        }
                    }
                    ?>                
                <th>FSE Checklist</th>
                <th>FSE Comments</th>
                <th>FSE Reason</th>
                <th>FSE Feedback</th>
                <th>Customer Sign</th>
                <th>Start Trip</th>
                <th>End Trip</th>
                <th>Travel Time</th>
                <th>Start Work</th>
                <th>End Work</th>
                <th>Repair Time</th>
                <th>Travel KM</th>
                <th>Created Date</th>
                <th hidden>Action</th>
            </tr>
            
        </thead>
        <tbody>
             <?php
                $i = 1;
                
                
                foreach ($result AS $r) {                   // var_dump($result); exit;
                    
                    ?>
             <tr class="row_show_<?php echo $k ?>"  id="row_show_<?php echo $r['id'] ?>"  onclick="taskdetail(this,'row_show_<?php echo $k.''.$k ?>','<?php echo $r['id']; ?>','<?php echo $i; ?>','<?php echo $r['task_type_id']; ?>')">
                 <td><?php echo $i++ ?></td>
                        <td id="taskname"><?php echo $r['task_name']; ?></td>
                        <td><?php echo (isset($r['task_type']))?$r['task_type']:''; ?></td>
                        <td><?php echo (isset($r['fse_name']))?$r['fse_name']:''; ?></td>
                        <td><?php echo (isset($r['status_type']))?$r['status_type']:''; ?></td>
                        <td><?php echo (isset($r['priority_type']))?$r['priority_type']:''; ?></td>
                        <td><?php echo (isset($r['task_address']))?$r['task_address']:''; ?></td>
                        <td><?php echo (isset($r['start_date']))?$r['start_date']:''; ?></td>


                        <td><?php echo (isset($r['fse_checklist']))?$r['fse_checklist']:''; ?></td>
                        <td><?php echo (isset($r['fse_task_comments']))?$r['fse_task_comments']:''; ?></td>
                        <td><?php echo (isset($r['fse_reason']))?$r['fse_reason']:''; ?></td>
                        <td><?php echo (isset($r['fse_feedback']))?$r['fse_feedback']:''; ?></td>
                        <td> <?php if(isset($r['customer_sign'])&&$r['customer_sign'] != NULL ) { ?>
                                <img alt="" src="<?php echo (isset($r['customer_sign']))?$r['customer_sign']:''; ?>" style="height:100px; width:100px">
                            <?php } ?>
                        </td>
                        <td><?php echo (isset($r['start_time']))?$r['start_time']:''; ?></td>
                        <td><?php echo (isset($r['reached_time']))?$r['reached_time']:''; ?></td>
                        <td><?php echo (isset($r['total_travel_time']))?$r['total_travel_time']:''; ?></td>
                        <td><?php echo (isset($r['start_to_work_time']))?$r['start_to_work_time']:''; ?></td>
                        <td><?php echo (isset($r['Work_completed_time']))?$r['Work_completed_time']:''; ?></td>
                        <?php
                            $date_a = new DateTime($r['assign_date']);
                            $date_b = new DateTime(($r['start_date']) ? $r['start_date'] : date('Y-m-d h:m:sa'));
                            if ($date_a && $date_b) {
                                $inter = date_diff($date_a, $date_b);
                            } else if (!$date_b) {
                                $date_b = new DateTime(date('Y-m-d h:m:s'));
                                $inter = date_diff($date_a, $date_b);
                            }
                            ?>

                        <td><?php echo (isset($inter->format('%h:%i:%s')))?$inter->format('%h:%i:%s'):''; ?></td>
                        <td><?php echo (isset($r['geo_km']))?$r['geo_km']:''; ?></td>
                        <td><?php echo (isset($r['created_date']))?$r['created_date']:''; ?></td>
                        <td>
                            <form action="<?php echo base_url(); ?>updateTask" method="post">
                                <input type="hidden" value="<?php echo (isset($r['id']))?$r['id']:''; ?>" name="edit_id"  /> 
                                <input type="hidden" value="<?php echo (isset($r['task_type_id']))?$r['task_type_id']:''; ?>" name="task_type_id"  /> 
                                <input type="hidden" value="<?php echo (isset($r['fse_id']))?$r['fse_id']:''; ?>" name="fse_id"  />
                                <input type="hidden" value="<?php echo (isset($r['status_id']))?$r['status_id']:''; ?>" name="status_id"  />  
                                <input type="hidden" value="<?php echo (isset($r['task_location']))?$r['task_location']:''; ?>" name="task_location"  /> 
                                <button class="fa fa-edit" name="edit" title="Edit" value="edit"></button>
                                <button class="fa fa-tasks" name="updateView" title="Update" value="updateView"></button>
                                <button class="fa fa-trash" name="delete" value="delete" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"></button>
                            </form>
                        </td>
                    </tr>
         <?php } ?>
        </tfoot>
    </table>
    </div>
</div>
<script>
    $(document).ready(function() {
//    var table = $('#tasklist').DataTable( {
//        responsive: false
//    } );
// 
//    new $.fn.dataTable.FixedHeader( table );
} );

$(document).ready(function() {
    $('#tasklist').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>

<!--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.4/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.2/js/responsive.bootstrap.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>-->

<!-----------========***********=========------------------>
<script src="<?php echo base_url(); ?>assets/js/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/responsive.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datatables/dataTables.scroller.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pace/pace.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datapicker/jquery.datetimepicker.full.js"></script>

<script>
                            $('#datetimepicker_start').datetimepicker({
                                value: '<?php echo date("Y/m/d H:i", strtotime("-1 day")); ?>',
                                mask: '9999/19/39 29:59'
                            });
                            $('#datetimepicker_end').datetimepicker({
                                value: '<?php echo date("Y/m/d H:i"); ?>',
                                mask: '9999/19/39 29:59'
                            });
                            
                            $('#datetimepicker_start').change(function(){
                                var startDate = new Date($('#datetimepicker_start').val());
                                var endDate = new Date($('#datetimepicker_end').val());

                                if (startDate > endDate){
                                     $('#searchtask').prop('disabled', true);
                                   $('#error').css('display','block'); 
                                }else{
                                     $('#searchtask').prop('disabled', false);
                                    $('#error').css('display','none'); 
                                } 
                            }); 
                             $('#datetimepicker_end').change(function(){
                                var startDate = new Date($('#datetimepicker_start').val());
                                var endDate = new Date($('#datetimepicker_end').val());

                                if (startDate > endDate){
                                   $('#searchtask').prop('disabled', true);
                                   $('#error').css('display','block'); 
                                }else{
                                     $('#searchtask').prop('disabled', false);
                                    $('#error').css('display','none'); 
                                } 
                            }); 
</script>
<!-----------========***********=========------------------>
<script>
    function gmap(container,id,taskid) {
      // alert(taskid); alert(id); 
       var modal = document.getElementById('myModal');
        $.ajax({
            url: "<?php echo base_url() . 'TaskController/loadmap'; ?>",
            method: 'POST',
            //cache: false,
           data: {id: id,taskid:taskid },
            success: function (resp) {                
                  modal.style.display = "block";
                 //$('#mapdataview').append(resp);
                 $('#mapdataview').html(resp);
                
            }
        });

    }

function taskdetail(currentrow,container,id,rnum,tasktypeid) {
                    $("#"+container).remove();
        var onclck="remove_row(this,'row_show_11'," + id + ","+rnum+","+tasktypeid+")";
            $("#row_show_"+id).removeAttr('onclick').attr({onclick:onclck});    
            $("#row_show_11").closest('tr').remove();
        $.ajax({ 
                url: "<?php echo base_url() . 'index.php/TaskController/taskdetail'; ?>",
                type: 'POST',
                //cache: false,
                data: { id: id,tasktypeid:tasktypeid,container:container} ,
                success: function (resp) {  
//                    alert($("#row_show_11").length);
                    if($("#row_show_11").length < 1)
                    {
                    $(currentrow).after(resp);         
                    }
                    else
                    {
                         $("#row_show_11").closest('tr').remove();
                    }
                }  
              });
           
  }
  function remove_row(currentrow,container,id,rnum,tasktypeid)
  {

       var onclck1="taskdetail(this,'row_show_11'," + id + ","+rnum+","+tasktypeid+")";
        $("#row_show_11").closest('tr').remove();
       $("#row_show_"+id).removeAttr('onclick').attr({onclick:onclck1});   
    
  }
</script>

<script>
var modal = document.getElementById('myModal');
var span = document.getElementsByClassName("close")[0];
function closepopup() {
    var modal = document.getElementById('myModal');
     $('#mapdataview').html('');
    modal.style.display = "none";
    
}

</script>

<div id="myModal" class="modal">
  <div class="modal-content" >
      <span class="close" onclick="closepopup()">&times;</span>
    <div id="mapdataview"></div>
    
  </div>
</div>

<style>
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
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
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
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
</style>

