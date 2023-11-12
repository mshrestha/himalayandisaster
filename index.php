<?php
//Includes
session_start();
include("system/config.php");
include("system/functions.php");
include("includes/header.php");

//Body Begins
?>
<script src='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.css' rel='stylesheet' />
<link href='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.Default.css' rel='stylesheet' />

<h2>Himalayan Disaster</h2>
<?php 
			$whereCondition = "and a.pkg_approval='1'";
			if(trim($_GET['status']) == "0"){
				$whereCondition = "and a.pkg_approval='0'";
			}

			$qry2 = $mysqli->query("Select centerid from " . $tableName['admin_login'] . " where username = '$name'");
			
            //$ary  = mysqli_fetch_array($qry2);
            $ary = $qry2->fetch_array(MYSQLI_NUM);
            
			if(!empty($ary[0])){
				$where="a.w_id=$ary[0] and";
			}
			else{
				$where="";
			}
			$qur = "select w.w_name,a.help_call_latlng,a.help_call_id,a.pkg_count,a.pkg_id,a.pkg_count,a.pkg_timestamp,a.pkg_approval,a.help_call_latlng,b.vdc_name, b.district, c.agent_name,c.agent_email,c.agent_phone, a.w_id
					from ". $tableName['package'] ." a," . $tableName['vdc'] . " b," .$tableName['agent'] ." c, ". $tableName['warehouse'] . " w " .
					"where $where a.agent_id=c.agent_id and w.w_id = a.w_id and a.help_call_id=b.vdc_code ". $whereCondition . " order by a.pkg_count ASC" . $offset;
            // die($qur);
            $addressPoints = '';
			$result= mysqli_query($mysqli, $qur);
			$count = 1;
			if(mysqli_num_rows($result) >=1) { 
                                                
                while ($row = mysqli_fetch_array($result)){
                    //echo $row['vdc_name'];

                    if($count >1){
                        $addressPoints .=",\n";
                    }
                    $time = explode(' ', $row['pkg_timestamp']);
                    $time = parseDate($time[0]);

                     if($row['help_call_id']!=-1)
                        $location = $row['vdc_name'].', '.$row['district'];
                    else {
                        if(!empty($row['help_location']))
                            $location = $row['help_location'];
                        else 
                            $location = 'Location #'.$row['pkg_count'];
                    }   


                    $addressPoints .= '['.$row['help_call_latlng'].', "<a target=_blank href='. $config['homeUrl'] . '/missionDetail.php?id='.$row['pkg_count'].'>'.$location.' </a>","'. $row['w_name'].'","'. $time. '"]';
                    $count++;
                
                }
            }
             // echo( $addressPoints ); 
             // die();
          
            ?>

<div class="wrapper">
	<div  id="map"></div>
    <span id='coordinates' class='ui-coordinates'></span>
    <div class="page page-general ng-scope" id="heading-bar">
        <div class="container theme-showcase">
            <div class="col-md-6">
                <div class="panel panel-profile">
                    <div class="panel-heading text-center bg-info" id="panel-heading">
                        <h3 class="ng-binding"><a href="#" id="title-link">Himalayan Disaster</a></h3>
                        
                    </div>
                    <div class="list-justified-container" id="wcontainer">
                        <ul class="list-justified text-center">
                            <li class="btn" data-toggle="modal" data-target="#myModal">
                                <p class="size-h3">WANT TO HELP</p>
                                <p class="text-muted">म सहायता गर्न चाहन्छु</p>
                            </li>
                            <!--li>
                                <p class="size-h3"><a href="http://www.kathmandulivinglabs.org/earthquake/reports/submit" target="_blank">NEED HELP</a></p>
                                <p class="text-muted"><a href="http://www.kathmandulivinglabs.org/earthquake/reports/submit" target="_blank">सहायता चाहिन्छ</a></p>
                            </li -->
                            <li class="btn" id="about-link">
                                <p class="size-h3">ABOUT US</p>
                                <p class="text-muted">हाम्रो बारेमा</p>
                                
                            </li>
                            <li class="btn" id="contact-link">
                                <p class="size-h3">CONTACT US</p>
                                <p class="text-muted">सम्पर्क गर्नुहोस</p>
                                
                            </li>
                            
                        </ul><!-- End of list-justified ul -->
                        <?php  if($_SESSION['logs']['msg'] != null){ displayMsg(); } ?>
                        
                    </div><!-- End of list-justified-container class -->
                    <div class="panel-body" id="about-details">
                        <h1>About Us</h1>
                        <p>On the aftermath of the deadly earthquake disaster in Nepal, a lot of organizations and small impromptu groups of people have emerged to volunteer and help out in any way they can. The biggest problem everyone is having is coordinating between these different groups of people and resources on how to mobilize them efficiently.</p>

<p>HimalayanDisaster.org works on keeping track of an inventory of resources, volunteers and information on Who is doing What Where and When. We keep track of whats been done where.</p>

<p>We are also keeping track of volunteers, linking different places where help is required with volunteers. If you are looking to volunteer, please do sign up as a volunteer through our 'WANT TO HELP' link above.</p>
                       
                    </div>
                    <div class="panel-body" id="contact-details">
                        
                        <h1>Contact Details</h1>
                        <p>If you are an an organization or volunteer group who want to add your data to our list, please feel free to contact us at the address below. Also if you are looking to get more information about our coordination platform and our efforts, do feel free to contact us.</p>
                        <p>Kazi Studios <br /><a href="mailto:disaster@kazistudios.com">disaster@kazistudios.com</a><br />
                            (977) 1 5000520<br />(977) 9851122092</p>
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
L.mapbox.accessToken = 'pk.eyJ1Ijoic2hyZXN0aGEiLCJhIjoieG8wd2tpWSJ9.mCLCK1UOF0gijrPiU1FB0w';
var map = L.mapbox.map('map', 'mapbox.satellite').setView([27.707809112357083, 85.31574726104736], 10);

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

        
        // console.log(a);


        if(
            ($.trim(lat) != "" && $.trim(lng) != "")
            &&
            (decimal.test(lat) && decimal.test(lng) )
          )
        {
            var marker = L.marker(new L.LatLng(lat, lng),  {
                icon: L.mapbox.marker.icon({'marker-size':'medium',  'marker-color': '1087bf'}),
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


