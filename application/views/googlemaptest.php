<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <title>Directions service</title>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    </head>
    <body>
         <?php
        
         $address1='';
          $address='';
        if(isset($showmap['taskallcationfse'][0]['fse_lat'])&&isset($showmap['taskallcationfse'][0]['fse_lat'])){
        $latt = (float) $showmap['taskallcationfse'][0]['fse_lat'];
        $langitude = (float) $showmap['taskallcationfse'][0]['fse_long'];
      
      // $address = getaddress($lat,$lng); 
        }
        if(isset($showmap['tasklocation'][0]['task_location']))
        {
        $locationarray = explode(',', $showmap['tasklocation'][0]['task_location']);
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
        var task_status= <?php echo $showmap[0]['status_id'] ?>;
        
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
          origin: {lat: <?php echo ($latt)?trim($latt):($lat2)?$lat2:'1.017291'; ?>, lng: <?php echo ($langitude)?$langitude:($lng2)?$lng2:'7.843486';?> },  // Haight.
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
                 var contentString = "<?php echo ($showmap[0]['task_address'])?$showmap[0]['task_address']:'';?>" 
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
                   alert('location value not available'); 
               } 
               
            }
        </script>
  </body>
</html>