<?php
session_start();
include("system/config.php");
include("system/functions.php");
include("includes/header.php");


//Body Begins
?>

<script src='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.css' rel='stylesheet' />
<link href='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.Default.css' rel='stylesheet' />

<?php

$latrines = array();
foreach($db->query('SELECT * FROM latrines') as $row) {
	array_push($latrines, $row);
}
?>

<div class="wrapper">
	<div  id="map"></div>
    <span id='coordinates' class='ui-coordinates'></span>
    <div class="page page-general ng-scope" id="heading-bar">
        <div class="container theme-showcase">
            <div class="col-md-6">
                <div class="panel panel-profile">
                    <div class="panel-heading text-center bg-info" id="panel-heading">
                        <h3 class="ng-binding"><a href="#" id="title-link">Laterine Distributer Information</a></h3>

                    </div>
                    <div class="list-justified-container" id="wcontainer">
                        <ul class="list-justified text-center">

                            <li class="btn" id="about-link">
                                <p class="size-h3">ABOUT US</p>


                            </li>
                            <li class="btn" id="contact-link">
                                <p class="size-h3">CONTACT US</p>


                            </li>

                        </ul><!-- End of list-justified ul -->
                        <?php  if($_SESSION['logs']['msg'] != null){ displayMsg(); } ?>

                    </div><!-- End of list-justified-container class -->
                    <div class="panel-body" id="about-details">
                        <h1>About Us</h1>
                        <p>
													Since 1984, iDE has created business opportunities for the private sector with the goal of improving income, livelihood, and well-being for low-income and marginalized communities.
												</p>
												<p>
													<h3>WATER, SANITATION & HYGIENE</h3>
													<p>While the public and development sectors have made tremendous progress in promoting hygienic water and sanitation practices in recent years, iDE focuses on catalyzing the country’s private sector to lead the delivery of sustainable WASH solutions for low-income consumers. To do so, we work with national companies that supply toilets and water filters to reconsider low-income people as viable, long-term customers.
													</p>
													<p>In parallel, we support over 1,000 entrepreneurs across the country in becoming more effective and profitable providers of affordable, aspirational, and effective WASH products and services.
												</p>


                    </div>
                    <div class="panel-body" id="contact-details">

                        <h1>Contact Details</h1>
                        <address><p><strong class="redactor-inline-converted"><strong class="redactor-inline-converted">Main Office<br></strong><strong class="redactor-inline-converted">—</strong></strong></p><p>House NEO 1/B (Level 4)<br>Road 90<br>Gulshan 2<br>Dhaka 1212, Bangladesh</p><p>p: +880 9678 333 777 (Ext. 100)<br>e: bangladesh@ideglobal.org</p></address>
                    </div>
                </div><!-- End of panel class -->
            </div><!-- End of col-md-6 class-->
        </div><!-- End of container class -->
    </div><!-- End of page class -->
</div><!-- End of Wrapper class -->



<!-- Begin Volunteer Form -->

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h1 class="modal-title" id="myModalLabel">Volunteer Sign up</h1>
      </div>
      <div class="modal-body">
        <form method="POST" action="/controller/helpController.php ">
					<label>Full Name / पुरा नाम </label>
					<input type="text" name="name" class="form-group" required="required"><br />
					<label>Phone Number / फोन नम्बर</label>
					<input type="text" name="phonenumber" class="form-group"><br />
					<label>Email / ईमेल</label>
					<input type="email" name="email" class="form-group"><br />
					<label>Type of Volunteer / स्वयंसेवक को प्रकार</label><br />
					<label><input type="radio" name="volunteer-type" value="technical" class="form-group"> Technical Support / डिजिटल</label><br />
					<label><input type="radio" name="volunteer-type" value="ground" class="form-group"> Field work / भू काम</label><br />
					<label><input type="radio" name="volunteer-type" value="resources" class="form-group"> Provide Resource / स्रोत</label><br />

					<label>Current Location / वर्तमान स्थान</label>
					<input type="text" name="location" class="form-group" required="required"><br />
					<label>Willing to Travel / यात्रा गर्न इच्छुक</label><br />
					<label><input type="radio" name="travel" value="yes" class="form-group"> Yes / हो</label>
					<label><input type="radio" name="travel" value="no" class="form-group"> No / होइन</label><br />
					<label>Duration Available for? / उपलब्ध अवधि?</label>
					<input type="text" name="availability" class="form-group"><br />
					<label>Languages Known (Separate by comma)/ भाषा ज्ञात (अल्पविराम द्वारा अलग)</label>
					<input type="text" name="languages" class="form-group"><br />
					<label>Skills / कौशल</label><br />
					<label><input name="skills[]" type="checkbox" class="form-group" value="computer"> Basic Computer Skills / मूल कम्प्युटरकोक्षमता</label><br />
					<label><input name="skills[]" type="checkbox" class="form-group" value="analysis"> Data processing &amp; analysis / डाटा प्रोसेसिङ</label><br />
					<label><input name="skills[]" type="checkbox" class="form-group" value="advanced-medical"> Doctor &amp; Advanced Medical Skills / डाक्टर र विकसित चिकित्सा कौशल</label><br />
					<label><input name="skills[]" type="checkbox" class="form-group" value="basic-medical"> Basic Medical Training / मूल चिकित्सा प्रशिक्षण</label><br />
					<label><input name="skills[]" type="checkbox" class="form-group" value="translation"> English-Nepali Translation / अंग्रेजी - नेपाली अनुवाद</label><br />
					<label><input name="skills[]" type="checkbox" class="form-group" value="engineer"> Engineer &amp; Structure Assessment / इन्जिनियर र संरचना आकलन</label><br />
					<label>Other Skills / अन्य कौशल</label><br />
					<textarea name="other-skills" placeholder="Other Skills" class="form-control"></textarea>
					<label>Vehicle</label>
					<label><input type="checkbox" name="vehicle[]" value="bike" class="form-group"> Bike / बाइक</label>
					<label><input type="checkbox" name="vehicle[]" value="car" class="form-group"> Car / कार</label>
					<label><input type="checkbox" name="vehicle[]" value="truck" class="form-group"> Truck / ट्रक</label>
					<input type="hidden" name="help-type" value="volunteer-registration">
                    <br /><br />
					<input type="submit" value="SUBMIT" class="btn btn-success">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</form>
      </div>

    </div>
  </div>
</div>


<!-- End volunteer Form -->
<!-- Begin Mission Display Div -->
<div id="mission-detail-div" style="position:fixed; top:0px; right:0px;">


</div>
<!-- End Mission Display Div -->

<?php
//Includes
include("includes/footer.php");
?>

<script type="text/javascript">
    var addressPoints = [
    <?php
       echo $addressPoints;
    ?>];
// Provide your access token
//L.mapbox.accessToken = 'pk.eyJ1Ijoic2hyZXN0aGEiLCJhIjoieG8wd2tpWSJ9.mCLCK1UOF0gijrPiU1FB0w';
L.mapbox.accessToken = 'pk.eyJ1Ijoia2F6aXN0dWRpb3MiLCJhIjoiY2luZnA2bjNhMTIyOXYwa3Z0djlhOXAwdiJ9.Vj88y39TP7LtFJ4uozO_bQ'
var map = L.mapbox.map('map', 'shrestha.m3i2pn4f').setView([21.647142, 91.924089], 11);
 var markers = new L.MarkerClusterGroup();
    var decimal=  /^[-+]?[0-9]+\.[0-9]+$/;

    for (var i = 0; i < addressPoints.length; i++) {
        var a = addressPoints[i];
        // console.log(a);
        var title = a[2];
        var lat = a[0];
        var lng = a[1];
        var warehouse= a[3];
        var date= a[4];

				//Test Until here

        if(
            ($.trim(lat) != "" && $.trim(lng) != "")
            &&
            (decimal.test(lat) && decimal.test(lng) )
          )
        {
            var marker = L.marker(new L.LatLng(lat, lng),  {
                icon: L.mapbox.marker.icon({'marker-size':'medium', 'marker-symbol': 'golf', 'marker-color': '1087bf'}),
                title: title
            });
            marker.bindPopup(title+ '<br>By ' + warehouse + '<br> On ' + date);
            markers.addLayer(marker);
            markers.on("click", function(e){
                $("#mission-detail-div").fadeOut();
            });
        }
    }
    map.addLayer(markers);

   function onmove() {
    // Get the map bounds - the top-left and bottom-right locations.
    var inBounds = [],
        bounds = map.getBounds();
    markers.eachLayer(function(marker) {
        // For each marker, consider whether it is currently visible by comparing
        // with the current map bounds.
        if (bounds.contains(marker.getLatLng())) {
            inBounds.push(marker.options.title);
        }
    });



       $("#mission-detail-div").fadeOut();
    // Display a list of markers.
    document.getElementById('coordinates').innerHTML = inBounds.join('<br>');
       $("#wcontainer").fadeOut('slow');
       $("#contact-details").hide();
       $("#about-details").hide();
       $( "#heading-bar" ).animate({
            'margin-top': '-72px',
            'width': '523px'

        }, 1000, function() {
    // Animation complete.
  });
}
//onmove();
map.on('move', onmove);

    $('#map').on('click', 'a', function() {

        $("#mission-detail-div").load($(this).attr('href'));
        $("#mission-detail-div").fadeIn();
        return false;

    });
    $('#coordinates').on('click', 'a', function() {

        $("#mission-detail-div").load($(this).attr('href'));
        $("#mission-detail-div").fadeIn();
        return false;

    });
    $( document ).ready(function() {
			onmove();
			<?php foreach($latrines as $latrine): ?>
			var marker = L.marker(new L.LatLng(<?php echo $latrine['lat']; ?>, <?php echo $latrine['lng']; ?>),  {
					icon: L.mapbox.marker.icon({'marker-size':'medium', 'marker-symbol': 'golf', 'marker-color': '1087bf'}),
					title: "<?php echo $latrine['business']; ?>"
			});
			marker.bindPopup("<?php echo $latrine['person']. ' <br />'. $latrine['business'] . '<br />'. $latrine['u_union'].', '.$latrine['upazila'].'<br />'.$latrine['phone']; ?>");
			markers.addLayer(marker);
			markers.on("click", function(e){
					$("#mission-detail-div").fadeOut();
			});
			<?php endforeach; ?>
    $("#contact-link").click(function(){
        $('#about-details').hide('fade');
        $('#contact-details').toggle('fade');
    });
    $("#about-link").click(function(){
        $('#contact-details').hide('fade');
        $('#about-details').toggle('fade');
    });

    $('#title-link').click(function(){

        $( "#heading-bar" ).animate({
            'margin-top': '0px',
            'width': '100%'

        }, 1000, function() {
    // Animation complete.
            $("#wcontainer").fadeIn('slow');
  });
    });
});

</script>
