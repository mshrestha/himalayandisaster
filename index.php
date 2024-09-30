<?php
//Includes
session_start();
include("system/config.php");
include("system/functions.php");
include("includes/header.php");

//Body Begins
?>
<style>
    .form-label-control {
        margin: 0;
        margin-bottom: 5px;
    }
</style>
<script src='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.css' rel='stylesheet' />
<link href='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.Default.css' rel='stylesheet' />

<?php 
            $newPackageID = generatePackageId();
            $suggestLocation = '28.4719709,84.9678058';

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
                        if(!empty($row['help_call_location']))
                            $location = $row['help_call_location'];
                        else 
                            $location = 'Location #'.$row['pkg_count'];
                    }   


                    $addressPoints .= '['.$row['help_call_latlng'].', "<a target=_blank href='. $config['homeUrl'] . '/missionDetail.php?id='.$row['pkg_count'].'>'.$location.' </a>","'. $row['w_name'].'","'. $time. '"]';
                    $count++;
                
                }
            }

            //List for Help Requests starts here
            $whereConditionHelp ='';
            $qur2 = "select * from ". $tableName['helpCall'] . $whereConditionHelp;	
            $resultHelp= mysql_query($qur2);
            $helpAddressPoints = '';
            
            if(mysqli_num_rows($resultHelp) >=1){
                $count = 1;
                while ($row = mysql_fetch_array($resultHelp)){
                    if($count >1){
                        $helpAddressPoints .=",\n";
                    }
                    

                     if($row['help_call_id']!=-1){
                        $location = $row['help_call_location'];
                     }
                    else {
                        if(!empty($row['help_call_location'])){
                            $location = $row['help_call_location'];
                            echo "GETS INSIDE IF";
                        }else{
                            echo "GETS OUTSIDE IF";
                            $location = 'Location #'.$row['help_call_id'];
                        } 
                            
                    }   


                    $helpAddressPoints .= '['.$row['help_call_latlng'].', "<a target=_blank href='. $config['homeUrl'] . '/helpDetail.php?id='.$row['help_call_id'].'>'.$location.' </a><br />'.str_replace(array("\r", "\n"), '', addslashes(preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1">$1</a>', $row['help_call_other_needs']))).'","'. $row['help_call_name']. '"]';
                    $count++;
                }
            }
            
                
                    
            //End of Help Requests
            ?>

<div class="wrapper">
	<div  id="map"></div>
    <span id='coordinates' class='ui-coordinates'></span>
    <div class="page page-general ng-scope" id="heading-bar">
        <div class="container theme-showcase">
            <div class="col-md-6">
                <div class="panel panel-profile">
                    <div class="panel-heading text-center bg-info" id="panel-heading">
                        <h3 class="ng-binding"><a href="#" id="title-link">Nepal Situation Report</a></h3>
                        
                    </div>
                    <div class="list-justified-container" id="wcontainer">
                        <ul class="list-justified text-center">
                            <!-- li class="btn" data-toggle="modal" data-target="#myModal">
                                <p class="size-h3">WANT TO HELP</p>
                                <p class="text-muted">म सहायता गर्न चाहन्छु</p>
                            </li -->
                            <li id="openHelpBtn" class="btn">
                                <p class="size-h3">Incident Report</p>
                                <p class="text-muted">रिपोर्त गर्नुहोस</p>
                            </li>
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
                        <p>This Situation report is a collection of incident reporting and its mapping collected from a public forum and validated by our team.</p>

                        <p>HimalayanDisaster.org works on keeping track of an inventory of resources, volunteers and information on Who is doing What Where and When. We keep track of whats been done where.</p>

                        
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
<div class="modal" id="myModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h1 class="modal-title" id="myModalLabel">Need Help?</h1>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-5">
                <form method="POST" action="<?php echo $config['controller'];?>/helpController.php ">
                    <div class="form-group">
                        <label class="form-label-control">Full Name / पुरा नाम </label>
                        <input type="text" name="name" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label class="form-label-control">Phone Number / फोन नम्बर</label>
                        <input type="text" name="phonenumber" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label class="form-label-control">Location help is needed  / स्थान</label>
                        <input type="text" name="location" class="form-control" >
                    </div>
                    
                    <!-- <div class="form-group">
                        <label class="form-label-control">What you need / तपाईंलाई के चाहिन्छ चिन्ह लगाउनुहोस </label>
                        <div>
                            <div><label class="form-label-control"><input name="needType[]" type="checkbox" class="form-group" value="water" /> Water / पानी</label></div>    
                            <div><label class="form-label-control"><input name="needType[]" type="checkbox" class="form-group" value="medicine" /> Medicine / औखधि </label></div>
                            <div><label class="form-label-control"><input name="needType[]" type="checkbox" class="form-group" value="tent" /> Tent / पाल</label></div>
                            <div><label class="form-label-control"><input name="needType[]" type="checkbox" class="form-group" value="food" /> Food / खाना</label></div>
                            <div><label class="form-label-control"><input name="needType[]" type="checkbox" class="form-group" value="doctors" /> Doctors / डाक्टर</label></div>
                            <div><label class="form-label-control"><input name="needType[]" type="checkbox" class="form-group" value="volunteer" /> Volunteer Clean up / स्वयंसेवी</label></div>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label class="form-label-control">Other Information (please write details of all information, including links to pictures or more information) / अन्य</label><br />
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    
                    <input type="hidden" name="help-type" value="help-want-guest"/>
                    <input type="hidden" name="lat_lng" id="help_call_latlng" required>

                    <input type="submit" value="SUBMIT" class="blackbtn" />
                </form>
            </div>
            <div class="col-lg-7">
                <div id="side-map"></div>
            </div>
        </div>
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

var helpAddressPoints = [
    <?php                                              
       echo $helpAddressPoints; 
    ?>];
/*

LEAFLET STARTS HERE

*/



    // Provide your access token
    L.mapbox.accessToken = 'pk.eyJ1Ijoic2hyZXN0aGEiLCJhIjoiY2w3ODQ4dm1rMDYydTNvbWNvcXlwMjBmNSJ9.tigRSYQjUwFZE0zSLd7Onw';
    //var map = L.mapbox.map('map', 'mapbox.satellite').setView([28.52872,82.25730], 10);
    var map = L.mapbox.map('map', 'mapbox.satellite').setView([27.68814328468732, 85.3184506743254], 8);
    var markers = new L.MarkerClusterGroup();
    var decimal=  /^[-+]?[0-9]+\.[0-9]+$/;
    
    for (var i = 0; i < addressPoints.length; i++) {
        
        var a = addressPoints[i];
        
       //  console.log(a);
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
    

    //For Help Markers
    var helpMarkers = new L.MarkerClusterGroup();
    for (var i = 0; i < helpAddressPoints.length; i++) {
        var b = helpAddressPoints[i];

        //console.log(b);
        var title = b[2];
        var lat = b[0];
        var lng = b[1];
        var warehouse= b[3];
        //var rdate= b[4];

        
        

        if(
            ($.trim(lat) != "" && $.trim(lng) != "")
            &&
            (decimal.test(lat) && decimal.test(lng) )
          )
        {
            var marker = L.marker(new L.LatLng(lat, lng),  {
                icon: L.mapbox.marker.icon({'marker-size':'medium',  'marker-color': 'ff0000'}),
                title: title 
            });
            
            marker.bindPopup(title + '<br>- By ' + warehouse + '<br> ');
            helpMarkers.addLayer(marker);
            helpMarkers.on("click", function(e){
                $("#mission-detail-div").fadeOut();
            });
        }
    }
    
    map.addLayer(markers);
    map.addLayer(helpMarkers);

    $('#openHelpBtn').on('click',function(){
        $('#myModal').modal({show:true});
        //For modal window markers
        var sideMap = L.mapbox.map('side-map', 'mapbox.satellite').setView([27.68814328468732, 85.3184506743254], 14);
        var marker = L.marker([27.68814328468732, 85.3184506743254], { icon: L.mapbox.marker.icon({'marker-color': '#1087bf'}), draggable: true }).addTo(sideMap);

        marker.on('dragend', function(event) {
            var latlng = event.target.getLatLng();
            $('#help_call_latlng').val(latlng.lat + ', ' + latlng.lng);
        });
    });

   

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
        $( "#heading-bar" ).animate({ 'margin-top': '-72px', 'width': '523px' }, 1000, function() {
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


