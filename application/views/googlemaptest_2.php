<div id="map_canvas"></div><div id="route"></div>

<script type="text/javascript">
// Create a directions object and register a map and DIV to hold the 
// resulting computed directions

    var map;
    var directionsPanel;
    var directions;

    function initialize() {
        map = new GMap(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(41.1255275, -73.6964801), 15);
        directionsPanel = document.getElementById("route");
        directions = new GDirections(map, directionsPanel);
        directions.load("from: Armonk Fire Department, Armonk NY to:  ");

        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
    }

</script> 


<div id="map_canvas2" style="width:200px; height:200px;"></div>
<div id="route2"></div>

<script type="text/javascript">
// Create a directions object and register a map and DIV to hold the 
// resulting computed directions

    var map2;
    var directionsPanel2;
    var directions2;

    function initialize2() {
        map2 = new GMap(document.getElementById("map_canvas2"));
        map2.setCenter(new GLatLng(41.1255275, -73.6964801), 15);
        directionsPanel2 = document.getElementById("route2");
        directions2 = new GDirections(map2, directionsPanel2);
        directions2.load("from: ADDRESS1 to: ADDRESS2 ");

        map2.addControl(new GSmallMapControl());
        map2.addControl(new GMapTypeControl());
    }

</script> 

<script type="text/javascript">
    function loadmaps() {
        initialize();
        initialize2();
    }
    $(document).ready(function () {
        loadmaps();

    });
</script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="https://raw.github.com/HPNeo/gmaps/master/gmaps.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps4rails/2.1.2/gmaps4rails.min.js" type="text/javascript"></script>
<script src="//maps.google.com/maps/api/js?v=3.13&amp;sensor=false&amp;libraries=geometry" type="text/javascript"></script>
<script src='//google-maps-utility-library-v3.googlecode.com/svn/tags/markerclustererplus/2.0.14/src/markerclusterer_packed.js' type='text/javascript'></script>
