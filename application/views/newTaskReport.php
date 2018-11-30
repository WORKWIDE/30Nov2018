<style>
    .container {
        /*width: 1400px !important;*/
        padding: 0;
    }
    a.btn.btn-default.btn-sm {
    background: #d61f27;
    border: none;
    padding: 5px 12px;
    color: #fff;
    margin-right: 6px;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div class="x_panelhold" style="min-height:600px; height: auto;">
    <div class="x_title">
        <h2>Task View </h2>  
        <!-- <a href="<?php echo base_url() ?>task" id="send"  class="btn btn-success" style="float:right;">Search</a> -->
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

<!--<table id="tasklist" class="table table-striped table-bordered nowrap x_panel tasklistviews" data-page-length='100' style="width:100%">-->
        <!--<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.1.min.js"></script>-->

        <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"/>-->

        <!--<script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>-->


        <div class="container">
            <div class="">

                <div class="">
                    <!--class="table table-striped table-bordered nowrap x_panel tasklistviews" data-page-length='100' style="width:100%"-->
                    <table id="employee_grid" class="table table-striped table-bordered nowrap x_panel tasklistviews display" data-page-length='10' width="100%" cellspacing="0">
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
                                <th>FSE Checklist</th>
                                <th>FSE Comments</th>
                                <th>FSE Reason</th>
                                <th>FSE Feedback</th>
                                <!--<th>Customer Sign</th>-->
                                <th>Start Trip</th>
                                <th>End Trip</th>
                                <th>Travel Time</th>
                                <th>Start Work</th>
                                <th>End Work</th>
                                <th>Repair Time</th>
                                <th>Travel KM</th>
                                <th>Created Date</th> 
                                

                                <th></th><th></th><th></th><th></th><th></th><th></th><th>Customer Sign</th><th>Action</th>
                            </tr>
                        </thead> 

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>  
<!--<div id="employee_grid_processing" class="dataTables_processing processingclass" style="display: block;">Processing...</div>-->
<div id="loadingDiv" class="ldiv" style="display: block;" ></div>

<style>

    #loadingDiv{
        position:fixed;
        top:0px;
        right:0px;
        width:100%;
        height:100%;
        background-color:#666;
        background-image:url('<?php echo base_url(); ?>assets/images/giphy.gif');
        background-repeat:no-repeat;
        background-position:center;
        z-index:10000000;
        opacity: 0.4;
        display:none;
        filter: alpha(opacity=40); /* For IE8 and earlier */
    }


    .overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        transition: opacity 500ms;
        visibility: hidden;
        opacity: 0;
        z-index: 10000;
    }
    .overlay:target {
        visibility: visible;
        opacity: 1;
    }

    .popup {
        margin: 70px auto;
        padding: 20px;
        background: #fff;
        border-radius: 5px;
        width: 600px;
        position: relative;
        transition: all 5s ease-in-out;

    }

    .popup h2 {
        margin-top: 0;
        color: #333;
        font-family: Tahoma, Arial, sans-serif;
    }
    .popup .close {
        position: absolute;
        top: 7px;
        right: 20px;
        transition: all 200ms;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        color: #333;
    }
    .popup .close:hover {
        color: #06D85F;
    }
    .popup .content {
        max-height: 30%;
        overflow: auto;

    }

    @media screen and (max-width: 700px){
        .box{
            width: 70%;
        }
        .popup{
            width: 70%;
        }
    }

</style>
<script type="text/javascript">
    $(document).ready(function () {
//          $('#loadingDiv').css("display", "block");
        $(".ldiv").css("display", "block");
        $('#employee_grid').DataTable({
            "bProcessing": true,
            "serverSide": true,
            rowId: 'staffId',
            "columnDefs": [
                {
                    "targets": [20,21, 22, 23, 24,25],
                    "visible": false,
                    "searchable": false
                },
            ],
            dom: 'Bfrtip',
        buttons: [{
                                    extend: "copy",
                                    className: "btn-sm"
                                }, {
                                    extend: "csv",
                                    className: "btn-sm"
                                }, {
                                    extend: "excel",
                                    className: "btn-sm"
                                }, {
                                    extend: "pdf",
                                    className: "btn-sm"
                                }, {
                                    extend: "print",
                                    className: "btn-sm"
                                }],


            "ajax": {
                url: "<?php echo base_url(); ?>TaskController/datatable_response", // json datasource
                type: "post", // type of method  ,GET/POST/DELETE
                cache: false,
                async: false,
                error: function () {
                    $(".ldiv").css("display", "none");
                    $(".ldiv").hide();
//                     $("#loadingDiv").css("display", "none");
//                    $("#loadingDiv").hide();

                    //$('#loadingDiv').css("display", "none");

                }

            },
            'fnCreatedRow': function (nRow, aData, iDataIndex) {
                var iDataIndex1 = iDataIndex + 1;
//                         $(nRow).attr('id', 'row_show_' + iDataIndex1); 
                addrowfun_or_id('row_show_' + iDataIndex, aData, iDataIndex, nRow);
                
            },
            success: function () {
                $(".ldiv").css("display", "none");
            },
        });
        $(".ldiv").css("display", "none");

    });
    
//    function loaddiv()
//    {
//        $('#loadingDiv').css("display", "block");
//    }
//------------Add new table row by dyanamically through ajax............................
    function addrowfun_or_id(row_id_fun, aData, iDataIndex, nRow)
    {
        var indexPlusCount = 1 + iDataIndex;
        var tempval = 1;
        
        $(nRow).attr({id: 'row_show_' + indexPlusCount, onclick: "taskdetail(this,'row_show_" + tempval + "" + tempval + "','edit_id'," + indexPlusCount + ",'task_type_id')"}); // or whatever you choose to set as the id
        $(".ldiv").css("display", "none");
        $(".ldiv").hide();
    }

</script>
<script>
    var handleDataTableButtons = function () {
        "use strict";
        0 !== $("#employee_grid").length && $("#employee_grid").DataTable({
            dom: "Bfrtip",
            buttons: [{
                    extend: "copy",
                    className: "btn-sm"
                }, {
                    extend: "csv",
                    className: "btn-sm"
                }, {
                    extend: "excel",
                    className: "btn-sm"
                }, {
                    extend: "pdf",
                    className: "btn-sm"
                }, {
                    extend: "print",
                    className: "btn-sm"
                }],
            responsive: !0
        })
    },
            TableManageButtons = function () {
                "use strict";
                return {
                    init: function () {
                        handleDataTableButtons()
                    }
                }
            }();
</script>
<script>
    $(document).ready(function () {
//    var table = $('#tasklist').DataTable( {
//        responsive: false
//    } );
// 
//    new $.fn.dataTable.FixedHeader( table );
    });

    $(document).ready(function () {
//    $('#employee_grid').DataTable( {
//        dom: 'Bfrtip',
//        buttons: [
//            'copy', 'csv', 'excel', 'pdf', 'print'
//        ]
//    } );
    });
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
<!--/-------------------------------============-->

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


<!-- pace -->
<script src="<?php echo base_url(); ?>assets/js/pace/pace.min.js"></script>

<script>
    function gmap(container, id, taskid) {
        // alert(taskid); alert(id); 
        var modal = document.getElementById('myModal');
        $.ajax({
            url: "<?php echo base_url() . 'TaskController/loadmap'; ?>",
            method: 'POST',
            //cache: false,
            data: {id: id, taskid: taskid},
            success: function (resp) {
                modal.style.display = "block";
                //$('#mapdataview').append(resp);
                $('#mapdataview').html(resp);

            }
        });

    }

    function taskdetail(currentrow, container, id, rnum, tasktypeid) {
        //$("#" + currentrow).remove();
        var removediv = '';

        var edit_id = $("#edit_id_" + rnum).val();
        var tasktypeid = document.getElementById("task_type_id_" + rnum).value;
//        alert(edit_id);
        var onclck = "remove_row(this,'row_show_11'," + edit_id + "," + rnum + "," + tasktypeid + ")";
        $("#row_show_" + rnum).removeAttr('onclick').attr({onclick: onclck});
        $("#row_show_11").closest('tr').remove();
        $.ajax({
            url: "<?php echo base_url() . 'index.php/TaskController/taskdetail'; ?>",
            type: 'POST',
            //cache: false,
            data: {id: edit_id, tasktypeid: tasktypeid, container: container},
            success: function (resp) {
                if ($("#row_show_11").length < 1)
                {
                    $(currentrow).closest('tr').after(resp);
                }
                else
                {
                    $("#row_show_11").closest('tr').remove();
                }

            }
        });
    }
    function remove_row(currentrow, container, id, rnum, tasktypeid)
    {

        var onclck1 = "taskdetail(this,'row_show_11'," + id + "," + rnum + "," + tasktypeid + ")";
        $("#row_show_11").closest('tr').remove();
        $("#row_show_" + rnum).removeAttr('onclick').attr({onclick: onclck1});

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

