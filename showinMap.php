<?php
include 'system/config.php';
?>

<html>
<head>
<title> Drop point Location </title>
 <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
	
  <script src="http://maps.google.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>
  <script src="js/jquery-1.11.2.min.js"></script> 

   <script>
	var map;
	var currentPopup;
	var markers= [];

	function initialize() {
  var mapOptions = {
    zoom: 8,
    center: new google.maps.LatLng(27.6431649,85.3277502)
  };
  	map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);
 google.maps.event.addListenerOnce(map, 'tilesloaded', initializeDataPoints);

	}

function addMarker( lat, lng, location,place,phone) {

  var pt = new google.maps.LatLng(lat, lng); 
  
  var marker = new google.maps.Marker({
    position: pt,
    map: map
  });

  var content = "<b>"+ place + "</b>" + "</br><i>" + location + "</i></br>" + phone;
  addInfoWindow(marker,content);
  markers.push(marker);


}


 function addInfoWindow(marker, message) {

  var infoWindow = new google.maps.InfoWindow({
    content: message
  });

  google.maps.event.addListener(marker, 'click', function () {
   if (currentPopup != null) {
    currentPopup.close();
    currentPopup = null;
  }   

  infoWindow.open(map, marker);
  currentPopup = infoWindow;
});
  google.maps.event.addListener(infoWindow, "closeclick", function() {
    currentPopup = null;
  });

  

}

function initializeDataPoints (){
     var request = $.ajax({
        url: "controller/map/getDropoints.php",
        type: "post"
      });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        console.log(response);
        var data =  eval('(' + response + ')');
        
            deleteMarkers();

           for(var i=0;i<data.length;i++){  // showing in map
             addMarker(data[i]["lat"],data[i]["long"],data[i]["location"], data[i]["place"],data[i]["phone"]);
           }
           
           AutoCenter();  
           
         });
	}


 // Removes the markers from the map, but keeps them in the array.
  function clearMarkers() {
   setAllMap(null);
 }
 

      // Sets the map on all markers in the array.
      function setAllMap(map) {
       for (var i = 0; i < markers.length; i++) {
         markers[i].setMap(map);
       }
     }
     
         // Shows any markers currently in the array.
         function showMarkers() {
           setAllMap(map);
         }
         
 // Deletes all markers in the array by removing references to them.
 function deleteMarkers() {
   clearMarkers();
   markers = [];
 }
       function AutoCenter() {
    //  Create a new viewpoint bound
    var bounds = new google.maps.LatLngBounds();
    //  Go through each...
    $.each(markers, function (index, marker) {
      bounds.extend(marker.position);
    });
    //  Fit these bounds to the map
    map.fitBounds(bounds);
  }
google.maps.event.addDomListener(window, 'load', initialize);

</script>
</head>
 <body>
    <div id="map-canvas"></div>
 </body>


</html>