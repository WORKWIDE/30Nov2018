<!DOCTYPE html>
<html lang="ar">
<head>
    <title><?php echo (isset($taskdetail[0]['task_name']))?$taskdetail[0]['task_name']:'';?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="shortcut icon" type="image/png" href="http://icons.iconarchive.com/icons/tatice/operating-systems/256/Ubuntu-icon.png"/>
 <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">  
<style>
    .wrapper {
        width: 90%;
        margin: 0 auto;
        background: #efefef;
        padding: 4%;
    }
    .wrapper hr {
        border-top: 1px solid #dadada;
    }

  strong {
    margin-right: 10px;
}

.w-50 {
    width:48%;
    padding: 1%;
}
  </style>


<!-- Navbar -->


<!-- First Container -->
</head>
<body>
<div class="wrapper text-left">
    
   
  <div class="container mrb-20">
    <div class="navbar-header">
 <?php if ($tasktype) 
 foreach ($tasktype as $EntityLogos)
 { $encodedData=$EntityLogos['entity_logo'];
 ?>
        <img style="width: 20%; height: 30%;" src="<?php echo 'data:image/gif;base64,' .$encodedData;?>"  />
<?php }
 ?>     
        
    </div>
  
  </div>

       <hr/>
       
       <h3 class="mrb-20">Task report for task : <span><?php echo (isset($taskdetail[0]['task_name']))?$taskdetail[0]['task_name']:'';?></span></h3>
    
       <hr/>
   
    <div class="row text-left mrb-20">
        <div class="col-md-4">
            <strong>Task Type:</strong><?php echo (isset($tasktype[0]['task_type']))?$tasktype[0]['task_type']:'';?> 
        </div>
        
         <div class="col-md-4">
             <strong>Task Status:</strong> <?php  
             if(isset($taskdetail[0]['status_id'])){
             switch ($taskdetail[0]['status_id']) {
                case 1:
                       echo 'Assigned'; 
                    break;
                case 2:
                    echo 'On Hold';
                    break;
                case 3:
                     echo 'Accepted'; 
                    break;
                case 4:
                    echo 'Resolved';
                    break;
                case 5:
                   echo 'In Progress';
                    break;
                case 6:
                    echo "Canceled";
                    break;
                case 7:
                  echo "Reject";
                    break;
                default:
                    echo "not fount task status";
             } } ?> 
        </div>
        
         <div class="col-md-4">
             <strong>Task Priority:</strong>
             <?php  if(isset($taskdetail[0]['priority'])){
                switch ($taskdetail[0]['priority']) {
                    case 1:
                           echo 'Critical'; 
                        break;
                    case 2:
                        echo 'High';
                        break;
                    case 3:
                         echo 'Moderate'; 
                        break;
                    case 4:
                        echo 'Low';
                        break;
                    case 5:
                       echo 'Planning';
                        break;

                    default:
                        echo "not fount task priority";
             }  }   
                    ?>
        </div>        
    </div>
    <?php  if (isset($assignment)&&$assignment==1){ 
    if(count($taskdetail)>0){ ?> 
    <div class="row text-left mrb-20">
          <?php if(isset($taskdetail[0]['created_date'])){?>
        <div class="col-md-4">
            <strong>Create date:</strong><?php echo $taskdetail[0]['created_date'];?> 
        </div>
          <?php } if(isset($taskdetail[0]['assign_date'])){?>
         <div class="col-md-4">
             <strong>Assigned Date:</strong> <?php echo $taskdetail[0]['assign_date'];?>
        </div>   
          <?php } ?>
    
         <?php if(isset($taskdetail[0]['task_accept_date'])&&$taskdetail[0]['status_id']!=1){?>
        <div class="col-md-4">
            <strong>Accepted Date:</strong><?php echo $taskdetail[0]['task_accept_date'];?> 
        </div>
         <?php } if(isset($taskdetail[0]['Work_completed_time'])&&$taskdetail[0]['status_id']==4){?>
         <div class="col-md-4">
             <strong>Completed Date:</strong> <?php echo $taskdetail[0]['Work_completed_time'];?> 
        </div>           
        <?php }else if(isset($taskdetail[0]['end_date'])&&$taskdetail[0]['status_id']==4){ ?> 
          <div class="col-md-4">
             <strong>Completed Date:</strong> <?php echo $taskdetail[0]['end_date']; ?> 
          </div>        
       <?php  }else if (isset($taskdetail[0]['updated_date'])&&$taskdetail[0]['status_id']==4) { ?>
          <div class="col-md-4">
             <strong>Resolve Date:</strong> <?php echo $taskdetail[0]['updated_date']; ?> 
        </div>
      <?php  } ?> 
     </div>    
         <hr/> 
     <div class="row text-left mrb-20">
        <div class="col-md-6 ">
             <?php  if(isset($taskdetail[0]['fse_name'])){?>
            <strong>Person assigned:</strong><?php echo $taskdetail[0]['fse_name']; ?>  
             <?php } ?> 
        </div>
    </div>
    <hr/>
    <?php  }else
    { ?>
         <div class="col-md-6 mrb-20">
            <strong>Assignment :</strong> Not available
        </div>
    <?php }
    }?> 
    <?php if (isset($task_operations)&&$task_operations==1){?> 
      <div class="row text-left mrb-20">
          
          <div class="col-md-12 mrb-20">
              <strong>Task Operations:</strong> 
        </div>
          
        <div class="col-md-6 ">
            <strong>Travel Time:</strong> <?php echo ($taskdetail[0]['total_travel_time'])?$taskdetail[0]['total_travel_time']:'';?> 
        </div>
          
           <div class="col-md-6 ">
                <?php 
                
                $date_a = new DateTime($taskdetail[0]['assign_date']);
            $date_b = new DateTime(($taskdetail[0]['start_date'])?$taskdetail[0]['start_date']:date('Y-m-d h:m:sa'));
            if($date_a && $date_b){
             $inter = date_diff($date_a,$date_b);
            } else if(!$date_b) {
                 $date_b = new DateTime(date('Y-m-d h:m:s'));
                 $inter = date_diff($date_a,$date_b);
            }
           
            // echo date('Y-m-d h:m:s');
             ?> 
       
           <strong> Repair Time:</strong><?php echo $inter->format('%h:%i:%s'); ?> 
        </div>
         </div>
       <hr/>
    <?php } ?>
    
 
    <?php 
    if (isset($task_location)&&$task_location==1){  if($taskdetail[0]['task_address']){?> 
    <div class="row text-left mrb-20">
        <div class="col-md-12 mrb-20">
            <strong>Task Location:</strong><?php echo $taskdetail[0]['task_address']; ?>   
            <br>
        </div>
        
        <div class="col-md-12 ">
           <!--<iframe src="https://www.google.com/maps/d/embed?mid=1bf4qwgGAMWSKS2N2GnGJRONqRTs" width="100%" height="280"></iframe>-->
                     
           <?php
           
        $address = $taskdetail[0]['task_address']; /* Insert address Here */
        $ReplaceUnwantedSymbolsFromAddress1=preg_replace("/[^a-zA-Z0-9],/","+",$address);    
        $ReplaceUnwantedSymbolsFromAddress= str_replace(" ","+",$ReplaceUnwantedSymbolsFromAddress1);
//        $ReplaceUnwantedSymbolsFromAddress=preg_replace("/[^a-zA-Z0-9]/","_",$address);           
//        $skipUnwatedCharacterFromAddress=str_replace(',', '', str_replace(' ', '_', $ReplaceUnwantedSymbolsFromAddress));
//        $Create_map_image_url="http://maps.googleapis.com/maps/api/staticmap?center=".$ReplaceUnwantedSymbolsFromAddress . "&zoom=14&size=900x200&markers=color%3ablue%7Clabel%3aS%7C11211&sensor=false"; 
//        $create_imagename='./attachment/'.$ReplaceUnwantedSymbolsFromAddress.'.jpg';
//        $Created_imgPush_inDirectory=file_put_contents($create_imagename, file_get_contents($Create_map_image_url));
//        echo "<img style=\"width:auto; height:auto;\" src=".$create_imagename.">";
//            ?>
            <img width="600" src="https://maps.googleapis.com/maps/api/staticmap?center=&zoom=16&scale=1&size=600x300&maptype=roadmap&format=jpg&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7Clabel:A%7C<?php echo $ReplaceUnwantedSymbolsFromAddress; ?>" alt="Google Map of ">
        </div>
        
         </div> 
          <hr/>
    <?php }else
    { ?>
         <div class="col-md-6 mrb-20">
            <strong>Task Location :</strong> Not available
        </div>
    <?php } } ?> 
    
 
    <?php if(isset($create_Information)&&$create_Information==1){?> 
    <div class="row text-left mrb-20">
        <div class="col-md-12 mrb-20">
            <h4>Task information sent by Technician: </h4>
        </div>
     <?php   if($category){     
    foreach($category as $categoryRows)
    {?>       
        <div class="col-md-12 mrb-20">
            <strong>Task Title :</strong> <?php echo $categoryRows['category']; ?>
        </div>
        
        <?php  
// --------Start if label  condition --------------------------------------        

         $labelrowsArr='';
         foreach ($categoryRows['labels'] as $labelrows)
         { ?> 
         <div class="col-md-12 mrb-20">
             <strong><?php echo $labelrows['Ext_att_name']; ?> : </strong>
               <?php if($labelrows['Ext_att_type']=='CHECKBOX'){$type_option_value=json_decode($labelrows['Extra_attr_Values']); 
                  foreach ($type_option_value as $key=>$optionvalue) {?> 
                     <?php echo ($optionvalue)?$optionvalue:'Not availabel'; if (sizeof($type_option_value)!=$key) {
                      echo ",";
                     } ?> 
                <?php  }
                }else{
                    echo ($labelrows['Extra_attr_Values'])?$labelrows['Extra_attr_Values']:"Not availabel";
                } ?>             
         </div>      
           
       <?php }
      
            }  }else { ?>
                 <div class="col-md-6 mrb-20">
                    <strong>Asset :</strong> Not available
                </div>
            <?php } ?> 
        </div> 
    <hr/>
    <?php } ?> 

      <?php if(isset($update_information)&&$update_information==1){   ?>   
    <div class="row text-left mrb-20">
        <div class="col-md-12 mrb-20">
            <h4>Task Information updated by technician :</h4> 
        </div>
        <?php  if(count($category[0]['Updatedlabels'])>0){
            foreach($category as $updatecategoryRows)
            {
            $labelrowsArr=''; 
            if ($updatecategoryRows['Updatedlabels']) {
                 foreach ($updatecategoryRows['Updatedlabels'] as $updaterows)
                 { ?> 
                 <div class="col-md-12 mrb-20">
                     <strong><?php echo $updaterows['label']; ?> : </strong>
                       <?php if($updaterows['option_type']=='CHECKBOX'){$updatetype_option_value=json_decode($updaterows['value']); 
                          foreach ($updatetype_option_value as $key=>$upoptionvalue) {?> 
                             <?php echo ($upoptionvalue)?$upoptionvalue:'Not Available'; if (sizeof($updatetype_option_value)!=$key) {
                              echo ",";
                             } ?> 
                        <?php  }
                        }else{
                            echo ($updaterows['value'])?$updaterows['value']:"Not available";
                        } ?>             
                 </div>      
                   
               <?php }
                    }
            }

        }else{ ?>
            <div class="col-md-12 mrb-20">
                <strong>Fields :</strong> Not available
            </div>  
       <?php } ?>     
    </div>
     <hr/>
      <?php } ?> 
   
    
    <?php   if (isset($adminassets)&&$adminassets==1){ ?> 
    <div class="row text-left mrb-20">
        <div class="col-md-12 mrb-20">
         <h4>Assets / parts loaded against task : </h4>
        </div> 
         <?php   if (isset($assets) ){
         $assetscount=0;
        foreach ($assets as $assetRows)
        { 
          $assetdata=  json_decode($assetRows['capture_assets']);
          if (isset($assetdata))
           foreach ($assetdata as $key => $askey) { 
                $assetscount++; ?>  
        
        <div class="col-md-4 mrb-20">
            <strong>Asset Name  :</strong>  <?php  echo $askey->ID; ?>
        </div>
        <div class="col-md-4 mrb-20">
            <strong>Used :</strong> <?php echo $askey->used; ?>
        </div> 
         <div class="col-md-4 mrb-20">
            <strong>Awaiting :</strong>  <?php echo $askey->awaiting; ?>
        </div>  

        <?php  }
         }  
        
        }else
        { ?>
         <div class="col-md-6 mrb-20">
            <strong>Asset :</strong> Not available
        </div>
        <?php }?>
       
    </div>
       
    <?php if($assetscount==0){ ?> 
      <div class="col-md-6 mrb-20">
            <strong>Asset :</strong> Not available
        </div>
     
      <hr/>
        <?php } 
	} ?> 
 
    <?php if (isset($attachment)&&$attachment==1){ ?> 
     <div class="row text-left mrb-20">
        <div class="col-md-12 mrb-20">
            <h4> Attachments : </h4>
        </div>
      <?php 
      if($attachmentdata!=NULL) {
      foreach ($attachmentdata as $v)
      {  ?>
         
        <div class="col-md-6 mrb-20">
            <?php //$attimage= $v['customer_document']; 
            $attimage = "<img style=\"width: 97%; height:300px;\" src=\"data:image/jpeg;base64, ".$v['customer_document']."\"/>";

            echo $attimage; ?>

             
        </div>
         <div class="col-md-6 mrb-20">
        <?php if($v['created_date']){?>
                <h5 class="text-left"><b>Upload date:<b></h5>
                <h5 class="text-left"> <?php echo  $v['created_date']; ?></h5>
        <?php } ?>
        <?php if($v['latitude']&&$v['langitude'] && $v['upload_from_gallary']==1){ ?>
                <h5 class="text-left"><b>GEO Location<b></h5>
                <h5 class="text-left">  Latitude:<?php echo ($v['latitude'])?$v['latitude']:''; ?></h5>         
               <h5 class="text-left">  Longitude:<?php echo ($v['langitude'])?$v['langitude']:''; ?> </h5>
        <?php } else if($v['upload_from_gallary']==2) { ?>
                 <h5 class="text-left">This Image is uploaded from Gallery</h5>
        <?php }
           if($v['offline_mode']==1 &&$v['upload_from_gallary']!=2){ ?>
             <h5 class="text-left">User Offline when adding this attachment</h5>
        <?php } ?> 
        <?php if($v['attachment_value']){ $showlable=0; ?>
               <h5 class="text-left"><b>Metadata:<b></h5>
        <?php   foreach ($v['attachment_value'] as $key => $attach) {?> 

              <h5 class="text-left"><?php echo ($attach['label']&&$attach['value'])?$attach['label']:''; ?> <?php echo ($attach['label']&&$attach['value'])?":":''; ?>
            <?php echo ($attach['label']&&$attach['value'])?$attach['value']:''; if($attach['label']&&$attach['value']){ $showlable=1; } ?> 
            </h5>
        <?php  } } if($showlable==0){ ?><p style="font-size: 15px;">No record found <?php  } ?>         

                           </div>
         <div class="clearfix"></div>
         <hr/>
      <?php 
       }  
      } else
      { ?>
                                       
           <div class="col-md-6 mrb-20">
               <strong>No any attachments</strong>
        </div>
    <?php  }
      ?>        
       
         </div>
         <hr/>
    <?php } ?> 
    
   
    <?php  if (isset($customerinteraction)&&$customerinteraction==1){ ?> 
     <div class="row text-left mrb-20">
        <div class="col-md-12 mrb-20">
            <h4> Customer Interaction : </h4>
        </div>
        <?php if($taskdetail[0]['fseRating']||$taskdetail[0]['customer_sign']||$taskdetail[0]['fse_task_comments']){ ?> 
        <?php if($taskdetail[0]['customer_sign']){ ?>
         <div class="col-md-12 mrb-20 w-50">
           Customer Signature : <br/>
          <img src="<?php echo $taskdetail[0]['customer_sign'];?>" />
        </div>
        <?php }?> 
          <?php if( $taskdetail[0]['fseRating']){ ?>
         <div class="col-md-12 mrb-20">
             <strong>Customer rating : </strong><?php echo $taskdetail[0]['fseRating'];?>
          
        </div>
         <?php }?> 
          <?php if( $taskdetail[0]['fse_task_comments']){ ?>
         <div class="col-md-12 mrb-20">
             <strong> Customer comment :</strong> <?php echo $taskdetail[0]['fse_task_comments'];?>
         </div>
          <?php } }else{?>
         <div class="col-md-12 mrb-20">
                <strong>Fields :</strong> Not available
            </div> 
        <?php } ?> 
         </div>
    <?php } ?>
    
    <!-- Footer -->
<div class="text-right">
  <img src="<?php echo base_url('assets/images/bottom-logo.png');?>" />
</div>
    <?php 
 /*   $address='Palky Rd, Pune, Maharashtra 412308, India';
            
 
//           
           $ReplaceUnwantedSymbolsFromAddress=preg_replace("/[^a-zA-Z0-9]/","_",$address);           
           $skipUnwatedCharacterFromAddress=str_replace(',', '', str_replace(' ', '_', $ReplaceUnwantedSymbolsFromAddress));
           
        $Create_map_image_url="http://maps.googleapis.com/maps/api/staticmap?center=".$ReplaceUnwantedSymbolsFromAddress . "&zoom=14&size=900x200&markers=color%3ablue%7Clabel%3aS%7C11211&sensor=false"; 
        $path=  DOCUMENT_STORE_PATH;
        $Created_imgPush_inDirectory=file_put_contents($path.'/'.$ReplaceUnwantedSymbolsFromAddress.'.jpg', file_get_contents($Create_map_image_url));
        $imagename = base_url()."/attachment/".$skipUnwatedCharacterFromAddress.".jpg";
         echo "<img style=\"width:auto; height:auto;\" src=".$imagename.">";
  * 
  */
    ?>
    
    
</div>

<!-- Second Container -->




</body>
</html>


