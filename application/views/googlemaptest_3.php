
  <div id="map_canvas"></div>

  <div id="map_canvas_2"></div>
  <div id="map_canvas_3"></div>
  <div id="map_canvas_4"></div>
  <div id="map_canvas_5"></div>
  <div id="map_canvas_6"></div>
  <div id="map_canvas_7"></div>

<style>
    .google-maps {
  width: 100%;
  height: 400px;
}
</style>
<script> 
        jQuery(function($) {
    // Asynchronously Load the map API 
    var script = document.createElement('script');
    script.src = "//maps.googleapis.com/maps/api/js?key=AIzaSyDbSoQMawAVbWOO52sO-opzsuXgje50YyQ&callback=initialize";
    document.body.appendChild(script);
});
</script>

<script>
function initialize()
{
    var latlng = new google.maps.LatLng(28.561287,-81.444465);
    var latlng2 = new google.maps.LatLng(28.507561,-81.482359);
    var latlng3 = new google.maps.LatLng(29.125285,-82.048823);
    var latlng4 = new google.maps.LatLng(28.593716,-81.531086);
    var latlng5 = new google.maps.LatLng(29.139155,-82.064699);
    var latlng6 = new google.maps.LatLng(28.592492,-81.537612);
    var latlng7 = new google.maps.LatLng(28.490363,-81.379598);
    var myOptions =
    {
        zoom: 13,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var myOptions2 =
    {
        zoom: 13,
        center: latlng2,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var myOptions3 =
    {
        zoom: 13,
        center: latlng3,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var myOptions4 =
    {
        zoom: 13,
        center: latlng4,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var myOptions5 =
    {
        zoom: 13,
        center: latlng5,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var myOptions6 =
    {
        zoom: 13,
        center: latlng6,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var myOptions7 =
    {
        zoom: 13,
        center: latlng7,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    var map2 = new google.maps.Map(document.getElementById("map_canvas_2"), myOptions2);

    var map3 = new google.maps.Map(document.getElementById("map_canvas_3"), myOptions3);

    var map4 = new google.maps.Map(document.getElementById("map_canvas_4"), myOptions4);

    var map5 = new google.maps.Map(document.getElementById("map_canvas_5"), myOptions5);

    var map6 = new google.maps.Map(document.getElementById("map_canvas_6"), myOptions6);

    var map7 = new google.maps.Map(document.getElementById("map_canvas_7"), myOptions7);

    var myMarker = new google.maps.Marker(
    {
        position: latlng,
        map: map,
        title:"Barnett Park"
   });

    var myMarker2 = new google.maps.Marker(
    {
        position: latlng2,
        map: map2,
        title:"Bill Fredrick Park at Turkey Lake"
    });

    var myMarker3 = new google.maps.Marker(
    {
        position: latlng3,
        map: map3,
        title:"Dogwood Park"
    });

    var myMarker4 = new google.maps.Marker(
    {
        position: latlng4,
        map: map4,
        title:"Jim Beech Recreation Center"
    });

    var myMarker5 = new google.maps.Marker(
    {
        position: latlng5,
        map: map5,
        title:"Ocala Rotary Sportsplex"
    });

    var myMarker6 = new google.maps.Marker(
    {
        position: latlng6,
        map: map6,
        title:"Vignetti Park"
    });

    var myMarker7 = new google.maps.Marker(
    {
        position: latlng7,
        map: map7,
        title:"Cypress Grove Park"
    });
}
</script> 