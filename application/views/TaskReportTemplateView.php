<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Workwide PDF</title>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style>
            * {
                box-sizing: border-box;
                text-align: left !important;
            }
            body {
                
                text-align: left !important;
            }
          
            .footer {
                background-color: #ffffff;
                padding: 10px;
                text-align: center;
                margin-top: 15px;
            }
            .wrapper {

                background: #eaeaea;
                margin: 0 auto;
                padding: 15px;
            }
            .text-right {
                text-align: right;
            }
            .text-left {
                text-align: left;
            }
            h2 {
                font-size: 16px;
                color: #e00000;
            }
            h4 {
                font-size: 14px;
                font-weight: normal;
                margin-bottom: 5px;
                margin-top: 8px;
            }
            h4 span {
                font-weight: normal;
            }
            .clearfix {
                clear: both;
            }
            td, div {
                font-size: 14px;
            }
            @media (max-width: 600px) {
                .column {
                    width: 100%;
                }
            }
        </style>
    </head>

    <body style=" font-family: 'Open Sans', sans-serif;
          text-align: left !important;">
        <div class="wrapper" style="width:1000px; margin:0 auto;">
            <div class="header" style=" background-color: #fff; padding: 10px; text-align: center;">
                <div class="row" style="clear: both; width: 100%;">
                    <div style=" float: left; padding: 15px; border-right: 1px solid #ccc; width: 23%;  ">
                        <?php
                        if ($tasktype)
                            foreach ($tasktype as $EntityLogos) {
                                $encodedData = $EntityLogos['entity_logo'];
                                ?>
                                <img src="<?php echo 'data:image/gif;base64,' . $encodedData; ?>" style="height: 100px; width: 150px; object-fit: contain;">
                            <?php }
                        ?>
                        <?php if (isset($taskdetail[0]['fse_name'])) { ?>            
                            <h4><b> Person Assigned :</b> <?php echo $taskdetail[0]['fse_name']; ?> </h4>
                        <?php } ?> 

                    </div>
                    <div style="float: left; width: 70%; margin-left: 2%;">
                        <h2 style="text-align:left;">Task report for task : <span><?php echo (isset($taskdetail[0]['task_name'])) ? $taskdetail[0]['task_name'] : ''; ?></span></h2>                    
                        <div style="float: left; width: 40%;">


                            <div style="word-break: break-all;text-align: left;"><b>Task Type:</b> <?php echo (isset($tasktype[0]['task_type'])) ? $tasktype[0]['task_type'] : ''; ?> </div>





                            <div style="word-break: break-all;text-align: left;"><b>Task Status: </b> <?php echo $status; ?> </div>

                            <div style="word-break: break-all;text-align: left;"><b>Task Priority:</b><?php echo (isset($priority_status)) ? $priority_status : ''; ?>  </div>


                        </div>
                        <div style="float: left; width: 60%;"><td> 

                                <?php
                                if (isset($assignment) && $assignment == 1) {
                                    if (count($taskdetail) > 0) {
                                        ?> 
                                        <?php if (isset($taskdetail[0]['created_date'])) { ?>
                                            <div style="word-break: break-all;text-align: left"><b>Created Date:</b> <?php echo date("j F, Y H:i", strtotime($taskdetail[0]['created_date'])); ?> </div>

                                        <?php } if (isset($taskdetail[0]['assign_date'])) { ?>
                                            <div style="word-break: break-all;text-align: left;"><b>Assigned Date: </b> <?php echo date("j F, Y H:i", strtotime($taskdetail[0]['assign_date'])); ?>  </div>

                                        <?php } ?> 
                                        <?php if (isset($taskdetail[0]['task_accept_date']) && $taskdetail[0]['status_id'] != 1) { ?>
                                            <div style="word-break: break-all;text-align: left;"><b>Accepted Date: </b><?php echo date("j F, Y H:i", strtotime($taskdetail[0]['task_accept_date'])); ?> </div>

                                        <?php } ?> 
                                        <?php if (isset($taskdetail[0]['Work_completed_time']) && $taskdetail[0]['status_id'] == 4) { ?>

                                            <div style="word-break: break-all;text-align: left;"><b>Completed Date: </b><?php echo date("j F, Y H:i", strtotime($taskdetail[0]['Work_completed_time'])); ?> </div>

                                        <?php } ?> 
                                        <?php
                                    } else {
                                        ?>
                                        <div style="word-break: break-all;text-align: left;"><b>Assignment: </b> Not available </div>                                              
                                        <?php
                                    }
                                }
                                ?> 

                        </div>
                    </div>
                    <div class = "clearfix"></div>
                    <hr/>

                </div>
            </div>
            <?php if (isset($task_operations) && $task_operations == 1) { ?> 
                <div class = "row" style = "background: #fff; margin-bottom: 15px; padding: 2px 10px; margin-top: 15px; text-align:left;">
                    <span style="float:left; display:inline; font-size: 16px; color: #e00000; font-weight: bold; margin-right:20px;">Task Operations: </span>
                    <span style="float:left; display:inline; margin-right:20px;"><b> Travel Time:</b></span> <?php echo ($taskdetail[0]['total_travel_time']) ? $taskdetail[0]['total_travel_time'] : ''; ?> </td>
                    <?php
                    $date_a = new DateTime($taskdetail[0]['assign_date']);
                    $date_b = new DateTime(($taskdetail[0]['start_date']) ? $taskdetail[0]['start_date'] : date('Y-m-d h:m:sa'));
                    if ($date_a && $date_b) {
                        $inter = date_diff($date_a, $date_b);
                    } else if (!$date_b) {
                        $date_b = new DateTime(date('Y-m-d h:m:s'));
                        $inter = date_diff($date_a, $date_b);
                    }
                    ?>
               <!--  <span style="float:left; display:inline; margin-right:20px;"><b> Repair Time:</b> <?php echo $inter->format('%h:%i:%s'); ?></span> -->
                    <span style="float:left; display:inline; margin-right:20px;"><b> Repair Time:</b> <?php echo (isset($taskdetail[0]['total_worked_time'])) ? $taskdetail[0]['total_worked_time'] : ''; ?></span>
                </div>
            <?php }            


    ?>
        
            
            <?php if (isset($taskdetail[0]['task_address']) && !empty($taskdetail[0]['task_address'])) { ?>
                <div class = "row text-left" style = "background-color:#ccc; padding:15px;">
                    
                    
                    <?php
                    if ($taskdetail[0]['task_address']) {
                        ?> 
                        <div style="float:left; width:22%; background:#fff; padding: 15px; height: 210px;">
                            <span style="float:left; display:inline; font-size: 16px; color: #e00000; font-weight: bold; margin-right:20px;">Task Location:</span>
                            <p><?php echo $taskdetail[0]['task_address']; ?></p>
                        </div>

                        <div style="float:left; width:70%">
                            <?php
                          $address1 = $taskdetail[0]['task_address']; /* Insert address Here */ 

                            
                     //   $address='Palky Rd, Pune, Maharashtra 412308, India';
            
 
//           
           $ReplaceUnwantedSymbolsFromAddress=preg_replace("/[^a-zA-Z0-9]/","_",$address1);           
           $skipUnwatedCharacterFromAddress=str_replace(',', '', str_replace(' ', '_', $ReplaceUnwantedSymbolsFromAddress));
           
        //$Create_map_image_url="http://maps.googleapis.com/maps/api/staticmap?center=".$ReplaceUnwantedSymbolsFromAddress . "&zoom=14&size=900x200&markers=color%3ablue%7Clabel%3aS%7C11211&sensor=false"; 
        $Create_map_image_url="https://maps.googleapis.com/maps/api/staticmap?center=".$ReplaceUnwantedSymbolsFromAddress.   "&zoom=14&size=900x200&size=900x200&markers=color%3ablue%7Clabel%3aS%7C11211&sensor=false&key=AIzaSyA5a1O0rEsC2x-UQAQ_0gj94u1RveFIOs4&sensor=false";
        $path=  DOCUMENT_STORE_PATH;
                //DOCUMENT_STORE_PATH;
        $Created_imgPush_inDirectory=file_put_contents($path.'/'.$ReplaceUnwantedSymbolsFromAddress.'.jpg', file_get_contents($Create_map_image_url));
        $imagename = $path."".$skipUnwatedCharacterFromAddress.".jpg";
        // echo "<img style=\"width:auto; height:auto;\" src=".$imagename.">";

    ?>
        <img width="500" src="<?php echo $imagename; ?>" height="240" alt="Google Map of ">
        <!--<img width="500" src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $ReplaceUnwantedSymbolsFromAddress; ?>&maptype=roadmap&format=jpg&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7Clabel:A%7C&zoom=12&scale=1&size=500x250&key=AIzaSyA5a1O0rEsC2x-UQAQ_0gj94u1RveFIOs4" height="240" alt="Google Map of ">-->
         
                        </div>
                    <?php } else {
                        ?>
                        <div style="float:left; width:70%">
                            <h2>No Task Location Available</h2>
                        </div>
                    <?php } ?> 



                </div>
            <?php } ?>
            <div class = "row">
                <div style = "width:100%; background:#fff; margin-top:15px; text-align: left;">
                    <?php if (isset($create_Information) && $create_Information == 1) { ?> 
                        <div style = " float:left; width: 28%; vertical-align: top; text-align: left; padding: 15px; border-right: 1px solid #ccc; padding-right: 0;">
                            <h2>Task information sent by technician: </h2>

                            <?php
                            if ($category) {
                                foreach ($category as $categoryRows) {
                                    ?>   
                                    <h4><b> Task Title :</b>  <?php echo $categoryRows['category']; ?></h4>
                                    <?php
                                    $labelrowsArr = '';
                                    foreach ($categoryRows['labels'] as $labelrows) {
                                        ?> 

                                        <h4><b> <?php echo $labelrows['Ext_att_name']; ?>  :</b>
                                            <?php
                                            if ($labelrows['Ext_att_type'] == 'CHECKBOX') {
                                                $type_option_value = json_decode($labelrows['Extra_attr_Values']);
                                                foreach ($type_option_value as $key => $optionvalue) {
                                                    ?> 
                                                    <?php
                                                    echo ($optionvalue) ? $optionvalue : 'Not availabel';
                                                    if (sizeof($type_option_value) != $key) {
                                                        echo ",";
                                                    }
                                                    ?> 
                                                    <?php
                                                }
                                            } else {
                                                echo ($labelrows['Extra_attr_Values']) ? $labelrows['Extra_attr_Values'] : "Not availabel";
                                            }
                                            ?> 
                                        </h4>

                                    <?php } ?> 
                                    <?php
                                }
                            } else {
                                ?> 
                                <strong>Asset :</strong> Not available
                            <?php }
                            ?> 
                        </div>
                    <?php } ?>

                    <?php if (isset($update_information) && $update_information == 1) { ?>   
                        <div style = "width:28%; float:left; vertical-align:top; padding:15px; text-align: left;">
                            <h2>Task information updated by technician : </h2>
                            <?php
                            if (count($category[0]['Updatedlabels']) > 0) {
                                foreach ($category as $updatecategoryRows) {
                                    $labelrowsArr = '';
                                    if ($updatecategoryRows['Updatedlabels']) {
                                        foreach ($updatecategoryRows['Updatedlabels'] as $updaterows) {
                                            ?> 
                                            <h4><b><?php echo $updaterows['label']; ?> :</b>
                                                <?php
                                                if ($updaterows['option_type'] == 'CHECKBOX') {
                                                    $updatetype_option_value = json_decode($updaterows['value']);
                                                    foreach ($updatetype_option_value as $key => $upoptionvalue) {
                                                        ?> 
                                                        <?php
                                                        echo ($upoptionvalue) ? $upoptionvalue : 'Not Available';
                                                        if (sizeof($updatetype_option_value) != $key) {
                                                            echo ",";
                                                        }
                                                        ?> 
                                                        <?php
                                                    }
                                                } else {
                                                    echo ($updaterows['value'] && $updaterows['value'] != -1) ? $updaterows['value'] : "Not available";
                                                }
                                                ?>    
                                            </h4>

                                            <?php
                                        }
                                    }
                                }
                            } else {
                                ?>                           
                                <strong>Fields :</strong> Not available                           
                            <?php } ?> 
                        </div>
                    <?php } ?> 

                    <?php if (isset($adminassets) && $adminassets == 1) { ?> 
                        <div style = "float:left; width: 28%; vertical-align: top; padding: 15px; border-left: 1px solid #ccc;">
                            <h2>Assets / parts loaded against task : </h2>
                            <?php
                            if ($assets) {
                                $assetscount = 0;
                                foreach ($assets as $assetRows) {
                                    $assetdata = json_decode($assetRows['capture_assets']);
                                    if (isset($assetdata))
                                        foreach ($assetdata as $key => $askey) {
                                            $assetscount++;
                                            ?> 
                                            <h4><b> Asset Name :</b>  <?php echo $askey->ID; ?> </h4>
                                            <h4><b> Used : </b> <?php echo $askey->used; ?> </h4>
                                            <h4><b> Awaiting :</b>  <?php echo $askey->awaiting; ?> </h4>

                                            <?php
                                        }
                                }
                            } else {
                                ?> 
                                <strong>Asset :</strong> Not available    
                                <?php
                            }
                            if ($assetscount == 0) {
                                ?> 
                                <strong>Asset :</strong> Not available
                            <?php }
                            ?>
                        </div>
                    <?php } ?> 
                </div>
            </div>
            <?php if (isset($attachment) && $attachment == 1) { ?> 
                <div class = "row" style = "background-color: #fff; border:8px solid #ccc;  padding: 15px; margin-top:20px; text-align:left;">
                    <h2>Task Attachments :</h2>
                    <?php
                    $i = 1;
                    if ($attachmentdata != NULL) {
                        foreach ($attachmentdata as $v) {
                            if ($i == 4) {
                                $i = 1;
                            }
                            ?>
                            <?php if ($i == 1) { ?>   
                            <?php } ?> 
                            <div style = "vertical-align:top; padding:15px; background-color:#f3f3f3; float:left; width:28%; text-align:left;">
                                <img src = "data:image/jpeg;base64, <?php echo $v['customer_document'] ?>" style = "height: 200px; width: 100%; object-fit: cover;">
                                <?php if ($v['created_date']) { ?>
                                    <h3 style="text-align:left; "><b> Upload Date: </b></h3>
                                    <h4 style="text-align:left; "> <?php echo $v['created_date']; ?></h4>
                                <?php } ?>
                                <?php if ($v['latitude'] && $v['langitude'] && $v['upload_from_gallary'] == 1) { ?>
                                    <h3 style="text-align:left; "><b> GEO Location :</b></h3>
                                    <h4 style="text-align:left; "> Latitude :  <?php echo ($v['latitude']) ? $v['latitude'] : ''; ?></h4>
                                    <h4 style="text-align:left; "> Longitude :<?php echo ($v['langitude']) ? $v['langitude'] : ''; ?></h4>
                                <?php } else if ($v['upload_from_gallary'] == 2) { ?>
                                    <h5 style="text-align:left; ">This Image is uploaded from Gallery</h5>
                                <?php } ?>

                                <?php
                                if ($v['attachment_value']) {
                                    $showlable = 0;
                                    ?>
                                    <h3 style="text-align:left; "><b> Metadata :</b> </h3>
                                    <?php foreach ($v['attachment_value'] as $key => $attach) { ?>
                                        <h4 style="text-align:left;"><?php echo ($attach['label'] && $attach['value']) ? $attach['label'] : ''; ?> <?php echo ($attach['label'] && $attach['value']) ? ":" : ''; ?><?php
                                            echo ($attach['label'] && $attach['value']) ? $attach['value'] : '';
                                            if ($attach['label'] && $attach['value']) {
                                                $showlable = 1;
                                            }
                                            ?>  </h4>

                                    <?php } ?>
                                    <?php if ($showlable == 0) { ?><h4  style="text-align:left;">No record found</h4>  
                                        <?php
                                        }
                                    }
                                ?>
                            </div>

                            <?php if ($i == 3) { ?>   

                            <?php } ?> 
                            <?php
                            $i++;
                        }
                    } else {
                        ?> 
                        <strong>No Any Attachment found</strong>   
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if (isset($customerinteraction) && $customerinteraction == 1) { ?> 
                <div class = "footer text-left">
                    <div style = " vertical-align:top; padding:0 15px; text-align: left;">
                        <h2 style="text-align: left;">Customer Interaction :</h2></div>
                    <?php if ($taskdetail[0]['fseRating'] || $taskdetail[0]['customer_sign'] || $taskdetail[0]['fse_task_comments']) { ?> 
                        <div style = " vertical-align:top; padding:8px 15px; text-align: left; float:left; width:40%">
                            <?php if ($taskdetail[0]['fseRating']) { ?>
                                <h4  style="text-align: left;"><b>Customer rating : </b> <?php echo $taskdetail[0]['fseRating']; ?> </h4>
                            <?php } ?>
                            <?php if ($taskdetail[0]['fse_task_comments']) { ?>
                                <h4 style="text-align: left;"><b>Customer comment : </b> <?php echo $taskdetail[0]['fse_task_comments']; ?></h4>
                            <?php } ?>
                        </div>
                        <?php if ($taskdetail[0]['customer_sign']) { ?>
                            <div style = " vertical-align:top; padding:8px 15px; text-align: left; float:left; width:50%">
                                <h4 style="text-align: left;"><b>Customer signature : </b></h4>
                                <img src = "<?php echo $taskdetail[0]['customer_sign']; ?>" style="width:120px;">
                            </div>
                        <?php } ?>
                    <?php } else { ?> 
                        <strong>Fields :</strong> Not available
                    <?php } ?>
                </div>
            <?php } ?>
            <div style = "text-align:center;  padding:0 15px; border-top:1px solid #ddd;"><img src = "http://qwork-demo.quintica.com/assets/images/WorkWide.png" style = "width: 160px; margin-top: 10px;"></div>
        </div>
          <?php 
   

    ?>
      
    
    </body>

</html>                                        