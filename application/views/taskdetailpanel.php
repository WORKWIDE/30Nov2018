<?php
$k = 1; //var_dump($result[0]['category']); 
foreach ($result as $r) {
?>
<tr class="<?php echo $result[0]['container'] ?>" id="<?php echo $result[0]['container'] ?>" >
  <td colspan="22">
      <div class="row col-md-5 maintabhold">
      <div class="col-md-6 col-sm-6 col-xs-12">
          <div id="rowtabs">
      <ul class="nav nav-tabs">
        <?php
        if ($r['category'] != null) { $i = 1;
            foreach ($r['category'] As $ltabname) {  ?>
        <li class="<?php echo ($i == 1) ? 'active' : ''; ?>">
          <a data-toggle="tab" href="#home<?php echo preg_replace('/[^A-Za-z0-9\-]/', '', $ltabname['category']); ?>"> 
            <?php echo $ltabname['category']; ?>
          </a>
        </li>  
        <?php  $i++; } } ?>
        
        <?php  if ($r['assets']) { ?>
        <li>
          <a data-toggle="tab" href="#menu3<?php echo $k ?>">Assets
          </a>
        </li>
        <?php } ?>
      <!--   <?php if ($r['document']) { ?>
        <li>
          <a data-toggle="tab" href="#menu4<?php echo $k ?>">Attachments
          </a>
        </li>
        <?php } ?> -->
        <?php if ($r['complete']) { ?>
        <li <?php  if ($r['category'] == null){?> class="active"<?php } ?>>
            <a data-toggle="tab" href="#menu5<?php echo $k ?>">Complete
          </a>
        </li>
        <?php } if ($r['tasklocation']) { ?>
<!--        <li>
          <a data-toggle="tab" href="#menu6<?php echo $k ?>"onclick="gmap('#map_wrapper<?php echo $r['tasklocation'][0]['id']; ?>', '<?php echo $r['tasklocation'][0]['id']; ?>', '<?php echo $r['tasklocation'][0]['task_id']; ?>')">Pending
          </a>
        </li>-->
        <?php } ?>
        <li>
          <a data-toggle="tab" href="#menu12<?php echo $k ?>">Admin
          </a>
        </li>
        <?php if ($r["attachment"]!=NULL) { ?> 
         <li>
             <a data-toggle="tab" href="#attachment">Attachment
          </a>
        </li>
      <?php }?> 
      </ul>
      <div class="tab-content scrollbar" id="style-2" style="display:block; height: 230px;">
        <?php if ($r['category']) { ?>
        <?php
        $i = 1;
        foreach ($r['category'] As $ltabname) {
        ?>
        <?php //var_dump($r['category']);     ?> 
        <div id="home<?php echo preg_replace('/[^A-Za-z0-9\-]/', '', $ltabname['category']); ?>" class="tab-pane fade in <?php echo ($i == 1) ? 'active' : ''; ?>">     
         <div class="col-sm-9 col-xs-12">
            <table class="table table-bordered">
            <tbody>
        <?php if (count($ltabname['labels']) > 0 ||count($ltabname['Updatedlabels']) > 0 ) {
                  if (count($ltabname['labels']) > 0){
                foreach ($ltabname['labels'] as $l) { ?>
              <tr>
                  <td width="200px"> <strong>
                  <?php echo $l['Ext_att_name']; ?> </strong>
                </td>               
                <td>
                  <?php  if($l['Extra_attr_Values']){ if($l['Ext_att_type']=='CHECKBOX'){

                    $type_option_value=json_decode($l['Extra_attr_Values']); 

                    if (json_last_error() === JSON_ERROR_NONE){ 

                  foreach ($type_option_value as $key=>$optionvalue) {?> 
                     <?php echo $optionvalue; if (sizeof($type_option_value)!=$key) {
                      echo ",";
                     } ?> 
                <?php  }
                 }else{
                    echo $l['Extra_attr_Values'];
                 }
                }else{
                    echo $l['Extra_attr_Values'];
                } }else{
                  echo "Not available";
                } ?>
                </td>
              </tr>
                  <?php } } 
              if(count($ltabname['Updatedlabels']) > 0){
              foreach ($ltabname['Updatedlabels'] as $ll) { ?>
              <tr>
                <td width="200px"> <strong>
                  <?php echo $ll['label']; ?></strong>
                </td>
               
                <td>
                <?php if($ll['value']){ if($ll['option_type']=='CHECKBOX'){ $update_type_option_value=json_decode($ll['value']);
                foreach ($update_type_option_value as $key=>$updateoptionvalue) {?> 
                     <?php echo $updateoptionvalue; if (sizeof($type_option_value)!=$key) {
                      echo ",";
                     } ?> 
                <?php  }
                }else{
                   echo ($ll['value']!=-1)?$ll['value']:'Not Available';      
                }
                }else{
                  echo "Not available";
                } ?>
                </td>
              </tr>
              <?php } } 
              
              } else { ?>  
              <p class="alert alert-q alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;
                </a>
                Details not available.
              </p> 
              <?php } ?>
            </tbody>
          </table>
         </div>
        </div>
        <?php
        $i++;
        }
        }
        ?>
        <div id="menu121" class="tab-pane repsect">
          <div class="col-md-12 sndtsk">
            <?php //var_dump($r['admindata']);    ?> 
            <div class="col-md-12 col-sm-12 col-xs-12">
              <form name="sendinfomail" id="sendinfomail" >
                <fieldset class="customLegend">
                  <legend>Report Sections
                  </legend>
                  <div class="row">                
                      <input type="hidden" value="<?php echo $r['taskId'];?>" id="id" name="id">                  
                    <label class="checkbox-inline col-md-6 col-xs-12">
                        <input type="checkbox" onclick="updatefiled(this)" value="1" id="hidefield" name="assignment"<?php if(isset($r['admindata'][0]['assignmnetinfo'])){ echo ($r['admindata'][0]['assignmnetinfo']==1)?'checked disabled="disabled"':''; } ?>> 
                      <span class="label-text">
                      </span>Assignment
                    </label>
                    <label class="checkbox-inline col-md-6 col-xs-12">
                      <input type="checkbox" id="hidefield" onclick="updatefiled(this)" value="1" name="task_operations" <?php  if(isset($r['admindata'][0]['assignmnetinfo'])){ echo ($r['admindata'][0]['operationinfo']==1)?'checked disabled="disabled"':''; } ?>> 
                      <span class="label-text">
                      </span>Task Operations
                    </label>
                    <label class="checkbox-inline col-md-6 col-xs-12">
                      <input type="checkbox" id="hidefield" onclick="updatefiled(this)" value="1" name="task_location" <?php  if(isset($r['admindata'][0]['assignmnetinfo'])){ echo($r['admindata'][0]['locationinfo']==1)?'checked disabled="disabled"':'';  } ?>> 
                      <span class="label-text">
                      </span>Task Location
                    </label>
                    <label class="checkbox-inline col-md-6 col-xs-12">
                      <input type="checkbox" id="hidefield" onclick="updatefiled(this)" value="1" name="create_Information" <?php  if(isset($r['admindata'][0]['assignmnetinfo'])){ echo ($r['admindata'][0]['createinfo']==1)?'checked disabled="disabled"':''; } ?>> 
                      <span class="label-text">
                      </span>Create Information
                    </label>
                 
                    <label class="checkbox-inline col-md-6 col-xs-12">
                      <input type="checkbox" id="hidefield" onclick="updatefiled(this)" value="1" name="update_information" <?php  if(isset($r['admindata'][0]['assignmnetinfo'])){ echo ($r['admindata'][0]['updateinfo']==1)?'checked disabled="disabled"':''; } ?>> 
                      <span class="label-text">
                      </span>Update Information
                    </label>
                    <label class="checkbox-inline col-md-6 col-xs-12">
                      <input type="checkbox" id="hidefield" onclick="updatefiled(this)" value="1" name="assets"  <?php  if(isset($r['admindata'][0]['assignmnetinfo'])){ echo ($r['admindata'][0]['assetinfo']==1)?'checked disabled="disabled"':''; } ?>> 
                      <span class="label-text">
                      </span>Assets/Parts
                    </label>
                    <label class="checkbox-inline col-md-6 col-xs-12">
                      <input type="checkbox" id="hidefield" onclick="updatefiled(this)" value="1" name="attachment" <?php  if(isset($r['admindata'][0]['assignmnetinfo'])){ echo ($r['admindata'][0]['attachmentinfo']==1)?'checked disabled="disabled"':''; } ?>> 
                      <span class="label-text">
                      </span>Attachment
                    </label>
                    <label class="checkbox-inline col-md-6 col-xs-12">
                      <input type="checkbox" id="hidefield" onclick="updatefiled(this)" value="1" name="customerinteraction" <?php  if(isset($r['admindata'][0]['assignmnetinfo'])){ echo ($r['admindata'][0]['customerinfo']==1)?'checked disabled="disabled"':''; } ?>> 
                      <span class="label-text">
                      </span>Customer Interaction
                    </label> 
                  </div>
                </fieldset>
                <div class="form-inline mobilemargintop">
                 <div class="form-group col-md-7 col-sm-7 col-xs-7">
                    <label for="email">Email this task:
                    </label>
                      <input type="text" class="form-control" id="emaillist" name="emaillist" placeholder="enter email address">
                  </div>
                   <div class="form-group col-md-3 col-sm-2 col-xs-12 mgtp25">
                      <button type="submit" id="sendemailbutton" class="btn btn-success align-middle mgtp5" disabled="true">Send </button> 
                    </div>
                    <div class="pull-right col-md-12 col-sm-12 mgtp5">
                        <a class="btn btn-success mgbtm20 mgtp5 align-middle" href="<?php base_url();?>TaskController/savepdf?tid=<?php echo $r['taskId'];?>">Save Task to PDF
                        </a>
                    </div>
                </div>
              </form>
                <div id="sucess">
                    <strong><span id="errormsg"> </span></strong> 
                  </div>
                 
          
              <?php if(isset($r['taskId'])){?> 
             
              <?php } ?>
            </div>
              
             
              
              
              
          </div>
        </div>
        <?php if ($r['assets'] != null) { $assetcount=0; ?>
        <div id="menu3<?php echo $k ?>" class="tab-pane fade">
            <div class="col-sm-9 col-xs-12">
          <table class="table table-bordered">
            <thead>
              <th>Assets Name
              </th>
              <th>Used
              </th>
              <th>Awaiting
              </th>
            </thead>
            <tbody>
              <?php 
               
              if (count($r['assets'][0]['capture_assets']) > 0) {
                foreach ($r['assets'] as $ass) {
                 $assetdata=  json_decode($ass['capture_assets']); 
                // print_r($assetdata); 
                 foreach ($assetdata as $key => $askey) { ?> 
                  <tr>
                    <td>
                      <?php  echo $askey->ID; ?>
                    </td>
                    <td>
                      <?php echo $askey->used; ?>
                    </td>
                    <td>
                      <?php echo $askey->awaiting; ?>
                    </td>
                    <!--  <td>
                      <?php echo $askey->description; ?>
                    </td> -->
                  </tr>  
               <?php   }
                }
            
                } else { ?> 
              <p class="alert alert-q alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;
                </a>
                No asset lable found                  
              </p>
              <?php } ?>  
              
              
              
            </tbody>
          </table>
            </div>
        </div>
        <?php } ?>
        <?php if ($r['document'] != null) { ?>
        <div id="menu4<?php echo $k ?>" class="tab-pane fade">
            <div class="col-sm-9 col-xs-12">
          <table class="table table-bordered">
            <tbody>
              <tr>                                                       
                <td>
                  <?php if (count($r["document"]) > 0) {
                        foreach ($r["document"] as $v) { ?>
                  <div class="placehold">
                    <img style="width:150px; height:150px;" src="<?php echo $v['customer_document']; ?>" class="img-responsive">
                    <h5 class="text-center">
                      <?php echo date('d F Y', strtotime($v['created_date'])); ?>
                    </h5>
                    <!--<h5 class="text-center">743mb</h5>-->
                  </div>
                  <?php }
                    } else { ?> 
                  <p style="color:red; font-size: 15px;">No record found 
                    <?php } ?>  
                  </p>
                </td>                                                     
              </tr>
            </tbody>
          </table>
            </div>
        </div>
        <?php } ?>
        <?php if ($r['complete'] != null) { $i=0; ?>
        <div id="menu5<?php echo $k ?>" class="tab-pane fade in  <?php  if ($r['category'] == null){ echo "active";  } ?>">
            <div class="col-sm-9 col-xs-12">
            <table class="table table-bordered">
            <tbody>
              <?php if (count($r['complete']) > 0) {
                foreach ($r["complete"] as $v) {       
                if($v['Work_completed_time']!=NULL){ $i=1; ?>
              <tr>
                <td width="200px"> <strong>Time Completed : </strong>
                </td>
                <td>
                  <?php  if(!empty($v['Work_completed_time']) && $v['Work_completed_time']!= '0000-00-00 00:00:00') { echo date('d F Y h:i:s', strtotime($v['Work_completed_time']));} ?>
                </td>
              </tr>
                <?php }
               if($v['customer_sign']!=NULL && $v['completescreen']->signature==1){ $i=1; ?>
              <tr>
                <td> <strong>Customer Signature : </strong>
                </td>
                <td>
                  <img src="<?php echo $v['customer_sign']; ?>" class="img-responsive">
                </td>
              </tr>
               <?php }   if($v['fseRating']!=NULL&&$v['completescreen']->ratings==1){ $i=1; ?> 
              <tr>  
                <td> <strong> Customer Rating : </strong>
                </td>
                <td>
                  <?php if($v['fseRating'] !=0) {echo $v['fseRating']; }?>
                </td>
              </tr>
               <?php }   if($v['fse_task_comments']!=NULL&&$v['completescreen']->comments==1){ $i=1;?> 
              <tr>
                <td> <strong> Customer Comment : </strong>
                </td>
                <td>
                  <div class="">
                    "<?php echo $v['fse_task_comments']; ?>"
                  </div>
                </td>
              </tr> 
               <?php } 
               if($i==0){?>
                <p class="alert alert-q alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;
                    </a>
                    Details not available.
                </p> 
              
               <?php }
               }
                } else  { ?> 
              <p style="color:red; font-size: 15px;">Details not available. 
                <?php } ?>  
              </p>
            </tbody>
          </table>
        </div>
        </div>
        <?php } ?>
        <div id="attachment" class="tab-pane fade">
          <table class="table table-bordered" cellpadding="20" cellspacing="60">
            <tbody>
              <tr>                                                       
                  <td class="col-container">
                  <?php if ($r["attachment"]!=NULL) {
                        foreach ($r["attachment"] as $v) { ?>
                  <div class="col-md-6 col-xs-12">
                      <div class="placehold">
                    <img class="img-responsive img-object" src="<?php echo 'data:image/gif;base64,' .$v['customer_document'];?>" class="img-responsive">
                   
                    <br>

                    
                      <?php if($v['created_date']){?> 
                      <h5 class="text-left lftlabs">Upload date:</h5>
                      <h5 class="text-left"> <?php echo  $v['created_date']; ?></h5> <?php } ?> 
                      <?php if($v['latitude']&&$v['langitude']&&$v['upload_from_gallary']==1){?> 
                      <h5 class="text-left lftlabs">GEO Location</h5>
                       <h5 class="text-left">  Latitude: 
                      <?php echo ($v['latitude'])?$v['latitude']:''; ?> 
                    </h5>
                      <h5 class="text-left">  Longitude: </h5>
                      <h5 class="text-left"> <?php echo ($v['langitude'])?$v['langitude']:''; ?> </h5>
                    </h5>
                  <?php }
                   if($v['offline_mode']==1 &&$v['upload_from_gallary']!=2){ ?>
                    
                      <h5 class="text-left">User Offline when adding this attachment</h5>
                  <?php } 
                  if($v['upload_from_gallary']==2){ ?>
                        <h5 class="text-left">This Image is uploaded from Gallery</h5>
                       <?php } 
                      ?><h5 class="text-left lftlabs">Metadata:</h5><?php 
                   if($v['attachment_value']){  $showlable=0; ?>
                     
                    <?php   foreach ($v['attachment_value'] as $key => $attach) {?> 
                       <h5 class="text-left"><?php echo ($attach['label']&&$attach['value'])?$attach['label']:''; ?> <?php echo ($attach['label']&&$attach['value'])?':':''; ?>
                      <?php echo ($attach['value'])?$attach['value']:'';  if($attach['label']&&$attach['value']){ $showlable=1; } ?> 
                    </h5>
                   <?php  } } if($showlable==0){ ?><p style="font-size: 15px;">No record found <?php  }  ?> 
                    <!--<h5 class="text-center">743mb</h5>-->
                  </div>
                      </div>
                  <?php }
                    } else { ?> 
                  <p style="color:red; font-size: 15px;">No record found 
                    <?php } ?>  
                  </p>
                </td>                                                     
              </tr>
            </tbody>
          </table>
        </div>
        <?php if (isset($r['tasklocation'])) { ?>
        <div id="menu6<?php echo $k ?>" class="tab-pane fade">
          <div id="map_wrapper<?php echo $r['tasklocation'][0]['id']; ?> ">
          </div>
        </div>
        <?php } ?>
      </div>
          </div>
    </div>
      
       <div class="col-md-6 col-sm-6 col-xs-12">
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
                   <?php        // print_r($r['showmap']['tasklocation']);         echo 'string';

                 $address1='';
                  $address='';
                if(isset($r['showmap']['taskallcationfse'][0]['fse_lat'])&&isset($r['showmap']['taskallcationfse'][0]['fse_lat'])){
                $latt = (float) $r['showmap']['taskallcationfse'][0]['fse_lat'];
                $langitude = (float) $r['showmap']['taskallcationfse'][0]['fse_long'];

              // $address = getaddress($lat,$lng); 
                }
                if(isset($r['showmap']['tasklocation'][0]['task_location']))
                {
                $locationarray = explode(',', $r['showmap']['tasklocation'][0]['task_location']);
                $lati =  str_replace("(","",$locationarray[0]);
                $lang =  str_replace(")","",$locationarray[1]);
                $lat2 = (float) $lati;
                $lng2 = (float) $lang;
              //  $address1 = getaddress($lat2,$lng2);
               //exit(); 
                }?> 
                 <div id="map" style="height: 300px;"></div>
            <script>
              function initMap() {
                var task_status= <?php echo $r['showmap'][0]['status_id'] ?>;

                if(task_status==1){
                   loadMap(<?php echo ($lat2)?trim($lat2):1; ?>,<?php echo ($lng2)?$lng2:1;?>); 
                 }else{

                var directionsDisplay = new google.maps.DirectionsRenderer;
                var directionsService = new google.maps.DirectionsService;
                var map = new google.maps.Map(document.getElementById('map'), {
                  zoom: 14,
                  center: {lat: 37.77, lng: -122.447}
                });
                directionsDisplay.setMap(map);

                calculateAndDisplayRoute(directionsService, directionsDisplay);
        //        document.getElementById('mode').addEventListener('change', function() {
        //          calculateAndDisplayRoute(directionsService, directionsDisplay);
        //        });
              }
              }

              function calculateAndDisplayRoute(directionsService, directionsDisplay) {
                var selectedMode = 'DRIVING';
                directionsService.route({ 
                  origin: {lat: <?php echo ($latt)?trim($latt):$lat2; ?>, lng: <?php echo ($langitude)?$langitude:$lng2;?> },  // Haight.
                  destination: {lat: <?php echo ($lat2)?trim($lat2):'1.017291';?>, lng: <?php echo ($lng2)?trim($lng2):'7.843486';?> },  // Ocean Beach.
                  // Note that Javascript allows us to access the constant
                  // using square brackets and a string value as its
                  // "property."
                  travelMode: google.maps.TravelMode[selectedMode]
                }, function(response, status) {
                  if (status == 'OK') {
                    directionsDisplay.setDirections(response);
                  } else {
                    loadMap(<?php echo ($lat2)?trim($lat2):1; ?>,<?php echo ($lng2)?trim($lng2):1;?>); 
                    //window.alert('Directions request failed due to ' + status);
                  }
                });
              }
            </script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbSoQMawAVbWOO52sO-opzsuXgje50YyQ&callback=initMap">
                </script>


                 <script type="text/javascript">
                    var map;
                    var geocoder;
                    function loadMap(lattitude,langittude) {
                        // Using the lat and lng of Dehradun.
                       if(lattitude!=1||langittude!=1){
                            var latitude = lattitude; 
                        var longitude = langittude;
                        var latlng = new google.maps.LatLng(latitude,longitude);
                        var feature = {
                            zoom: 10,
                            center: latlng,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        };
                         var contentString = "<?php echo ($r['showmap'][0]['task_address'])?$r['showmap'][0]['task_address']:'';?>" 
                          var infowindow = new google.maps.InfoWindow({
                            content: contentString
                          });

                        map = new google.maps.Map(document.getElementById("map"), feature);
                        geocoder = new google.maps.Geocoder();
                        console.log(geocoder);
                        var marker = new google.maps.Marker({
                            position: latlng,
                            map: map,
                            title: "Test for Location"
                        });
                         marker.addListener('click', function() {
                            infowindow.open(map, marker);
                          });
                       }else{
//                           alert('address not available'); 
                       } 

                    }
                </script>

              </div>
  </div>
      
  </td>
</tr>
<?php $k++;
} ?> 
<script> 
    $(document).keypress(
    function(event){
     if (event.which == '13') {
        event.preventDefault();
      }


});
  $( "#sendinfomail" ).submit(function( event ) {
    event.preventDefault();
    var email = document.getElementById('email').value; 
     if(email){
         
    var data= $("#sendinfomail").serialize();
//    alert(data);
    $.ajax({
      url: "<?php echo base_url() . 'index.php/TaskController/sendemail'; ?>",
      type: 'POST',
      //cache: false,
      data: data,
      success: function (resp) {
           if(resp!=1)
          {   
                $('#sucess').addClass("alert alert-danger");
                $('#sucess').css('display','block');
                $('#errormsg').html("email send fail"); 
                setTimeout(function(){   $('#sucess').css('display','none');  }, 5000);
          }else{
                $('#sendinfomail').find('input[name=email]').val('');
                $('#sucess').addClass("alert alert-success");
                $('#sucess').css('display','block');
                $('#errormsg').html("Thank you! Email has been sent successfully."); 
               setTimeout(function(){   $('#sucess').css('display','none');  }, 5000);
            } 
           
      }
    });
    }else{ alert('please enter email');
        // $('#sucess').html("please enter email"); 
    }
  });
  
 
</script> 
<script>
  function updatefiled(data)
  {
   var taskid=<?php echo $r['taskId'];?>; 
     var name=  $(data).attr("name"); 
        $.ajax({
      url: "<?php echo base_url() . 'index.php/TaskController/updatereport'; ?>",
      type: 'POST',
      //cache: false,
      data: {name:name,id:taskid},
      success: function (resp) {
           
      }
    });
      
  }
  </script>
  <style>
      .modal-content .close{
          color:red;
          opacity: 0.8;
          margin-top: -20px;
          margin-right: -10px;
      }
  </style>

  
  

  <script>
    function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}
(function( $ ){
     $.fn.multipleInput = function() {
          return this.each(function() {
               // list of email addresses as unordered list
               $list = $('<ul/>');
               // input
               var $input = $('<input type="email" name="email_search" id="email_search" class="email_search multiemail"/>').keyup(function(event) { 
                    if(event.which == 13 || event.which == 32 || event.which == 188) {                        
                         if(event.which==188){
                           var val = $(this).val().slice(0, -1);// remove space/comma from value
                         }
                         else{
                         var val = $(this).val(); // key press is space or comma                        
                         }                         
                         if(validateEmail(val)){
                             var listid= 'email'+val; 
                           if(document.getElementById(listid)==null){ 
                               $('#sendemailbutton').removeAttr('disabled');
                         // append to list of emails with remove button
                         $list.append($('<li class="multipleInput-email" id="email'+val+'"><span> <input type="hidden" id="email" name="email[]" value="' + val + '">' + val + '</span></li>')
                              .append($('<a href="#" class="multipleInput-close" title="Remove"><i class="glyphicon glyphicon-remove-sign"></i></a>')
                                   .click(function(e) {
                                        $(this).parent().remove();
                                        e.preventDefault();
                                   })
                              )
                         );
                         $(this).attr('placeholder', '');
                         // empty input
                         $(this).val('');  
                        }else{  alert('same email id not allowed !'); }
                          }
                          else{
                            alert('Please enter valid email id, Thanks!');
                          }
                    }
               });
               // container div
               var $container = $('<div class="multipleInput-container" />').click(function() {
                    $input.focus();
               });
               // insert elements into DOM
               $container.append($list).append($input).insertAfter($(this));
               return $(this).hide();
          });
     };
})( jQuery );
$('#emaillist').multipleInput();
</script>

