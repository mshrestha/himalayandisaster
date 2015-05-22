<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8 />
<title>Missions</title>
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
<script src='https://api.tiles.mapbox.com/mapbox.js/v2.1.9/mapbox.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox.js/v2.1.9/mapbox.css' rel='stylesheet' />
<style>
   <style>
        body {
            padding: 0;
            margin: 0;
        }
        html, body, #map {
            height: 100%;
            width: 100%;
        }
    </style>
</head>
<body>


<script src='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.css' rel='stylesheet' />
<link href='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.Default.css' rel='stylesheet' />


<script src = "https://code.jquery.com/jquery-2.1.4.min.js"></script>

<div id='map'></div>

<script>
L.mapbox.accessToken = 'pk.eyJ1Ijoic2hyZXN0aGEiLCJhIjoieG8wd2tpWSJ9.mCLCK1UOF0gijrPiU1FB0w';
    var map = L.mapbox.map('map', 'shrestha.m3i2pn4f')
        .setView([27.7089603,85.3261328], 14);

    var markers = new L.MarkerClusterGroup();

      map.featureLayer.on('click', function(e) {
        map.panTo(e.layer.getLatLng());
    });
        var post = {
      "mission_status": 1
    };

    var points = new Array();
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "../controller/map/getMarkers.php", //Relative or absolute path 
      data: post,
      success: function(data) {
        document.title = 'Missions ('+data.length+')';
        for (var i = 0; i < data.length; i++) {
            var point = new L.LatLng(data[i]["lat"], data[i]["lng"]);
            points.push(point);

			  var marker = L.marker(
                        point,
        {
            icon: L.mapbox.marker.icon(
                {'marker-symbol': 'post', 'marker-color': '0044FF'}),
                title: data[i]['mission']
        });
        marker.bindPopup(data[i]["mission"]);
        markers.addLayer(marker);

    }
        map.fitBounds(points);

    map.addLayer(markers);
		}
    
           });

</script>


</body>
</html>
