<?php
//Includes
session_start();
include("system/config.php");
include("system/functions.php");
include("includes/header.php");

//Body Begins
?>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>


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
            "where $where a.agent_id=c.agent_id and w.w_id = a.w_id and a.help_call_id=b.vdc_code ". $whereCondition . "order by a.pkg_count ASC" . $offset;
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
    $whereConditionHelp =' where updated_at > DATE_SUB(NOW(), INTERVAL 2 DAY)';
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
            } else {
                if(!empty($row['help_call_location'])){
                    $location = $row['help_call_location'];
                    echo "GETS INSIDE IF";
                }else{
                    echo "GETS OUTSIDE IF";
                    $location = 'Location #'.$row['help_call_id'];
                }                     
            } 
            $timestamp = date('Y-m-d - h:i A', strtotime($row['updated_at']));
            if ($row['help_call_latlng'] != ''){
                if($row['help_call_file'] == ''){
                    $helpAddressPoints .= '['.$row['help_call_latlng'].', "<a target=_blank href='. $config['homeUrl'] . '/helpDetail.php?id='.$row['help_call_id'].'>'.$location.' </a><br />'. $timestamp .'<br />'. $row['help_call_status'] .'<br />'.str_replace(array("\r", "\n"), '', addslashes(preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1">$1</a>', $row['help_call_other_needs']))).'","'. $row['help_call_name']. '", "'. $row['help_call_needs'] . '", "'. $row['help_call_status'] .'"]';
                }else{
                    $helpAddressPoints .= '['.$row['help_call_latlng'].', "<a target=_blank href='. $config['homeUrl'] . '/helpDetail.php?id='.$row['help_call_id'].'>'.$location.' </a><br />'. $timestamp .'<br />'. $row['help_call_status'] .'<br /><img src=\"/uploads/'.$row['help_call_file'] .'\" width=\"200px\" />'.'<br />'.str_replace(array("\r", "\n"), '', addslashes(preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1">$1</a>', $row['help_call_other_needs']))).'","'. $row['help_call_name']. '", "'. $row['help_call_needs'] . '", "'. $row['help_call_status'] .'"]';
                }
                
                $count++;
            }
            
        }
    }
//End of Help Requests
?>

<div class="wrapper">
	<div  id="map"></div>
    <span id='coordinates' class='ui-coordinates'></span>
    <div class="page page-general ng-scope" id="heading-bar">
        <div class="container theme-showcase">
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-profile">
                        <div class="panel-heading text-center bg-info" id="panel-heading">
                            <h3 class="ng-binding page-title-heading">NepalNow Travel Situation Report</h3>
                            
                        </div>
                        <div class="list-justified-container" id="wcontainer">
                            <ul class="list-justified text-center">

                                <li id="openHelpBtn" class="btn">
                                    <p class="size-h3">REPORT</p>
                                    <p class="text-muted">रिपोर्त गर्नुहोस</p>
                                </li>
                                <li class="btn" id="about-link">
                                    <p class="size-h3">ABOUT</p>
                                    <p class="text-muted">हाम्रो बारेमा</p>
                                    
                                </li>
                                <li class="btn" id="about-link">
                                    
                                    <p class="size-h3"><a href="/list">Summary</a></p>
                                    <p class="text-muted"><a href="/list">सरान्श</a></p>
            
                                    
                                </li>
                            </ul><!-- End of list-justified ul -->
                            <?php  if($_SESSION['logs']['msg'] != null){ displayMsg(); } ?>
                            
                        </div><!-- End of list-justified-container class -->
                        <div class="panel-body" id="about-details">
                            <p>The NepalNOW Travel Situation Report is a community effort to keep everyone updated about travel conditions in Nepal. Information is gathered from industry professionals, the government, tourism board, police, locals, and travelers. Both verified and unverified reports are shared here, with the help of a small IT team.</p>
                            <p>Each piece of information is time-stamped and will expire after a while. If you don't see any data on this map, you can assume that everything is okay in those areas.</p>
                            <p>This is just a quick overview of the travel situation and may not cover everything. For the most accurate updates, it's best to contact local companies, as they have the latest information on the ground.</p>
                            <p>Safe travels!</p>    
                        </div>
                        <div class="panel-body" id="contact-details">
                            
                            <h1>Contact Details</h1>
                            <p>If you are an an organization or volunteer group who want to add your data to our list, please feel free to contact us at the address below. Also if you are looking to get more information about our coordination platform and our efforts, do feel free to contact us.</p>
                            <p>Kazi Studios <br /><a href="mailto:disaster@kazistudios.com">disaster@kazistudios.com</a><br />
                                (977) 1 5000520<br />(977) 9851122092</p>
                        </div>
                    </div><!-- End of panel class -->
                </div><!-- End of col-md-6 class-->
            </div>
        </div><!-- End of container class -->
    </div><!-- End of page class -->
</div><!-- End of Wrapper class -->

<!-- Modal -->
<div class="modal" id="myModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h1 class="modal-title" id="myModalLabel">Report</h1>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo $config['controller'];?>/helpController.php" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-5">
                    <div class="form-group">
                        <label class="form-label-control">Full Name / पुरा नाम *</label>
                        <input type="text" name="name" class="form-control" required />
                    </div>

                    <div class="form-group">
                        <label class="form-label-control">Phone Number / फोन नम्बर *</label>
                        <input type="text" name="phonenumber" class="form-control" required />
                    </div>

                    <div class="form-group">
                        <label class="form-label-control">Location & Status / स्थान र स्थिति *</label>
                        <input type="text" name="location" class="form-control" required />
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label-control">Category *</label>
                        <div>
                            <div>
                                <label class="form-label-control">
                                    <input name="needType[]" type="radio" class="form-group" value="Road Network" required /> Road Network
                                </label>
                            </div>    
                            <div>
                                <label class="form-label-control">
                                    <input name="needType[]" type="radio" class="form-group" value="Trails" required /> Trails 
                                </label>
                            </div>
                            <div>
                                <label class="form-label-control">
                                    <input name="needType[]" type="radio" class="form-group" value="Attractions" required /> Attractions
                                </label>
                            </div>
                            <div>
                                <label class="form-label-control">
                                    <input name="needType[]" type="radio" class="form-group" value="Accomodations" required /> Accomodations
                                </label>
                            </div>
                            <div>
                                <label class="form-label-control">
                                    <input name="needType[]" type="radio" class="form-group" value="Flights" required /> Flights
                                </label>
                            </div>
                            <div>
                                <label class="form-label-control">
                                    <input name="needType[]" type="radio" class="form-group" value="Others" required /> Others
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label-control">Image (png, jpg, jpeg, webp)</label>
                        <input type="file" name="file" class="form-control" >
                    </div>

                    <div class="form-group">
                        <label class="form-label-control">Useful Information or Tips / उपयोगी जानकारी</label><br />
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    
                    <input type="hidden" name="help-type" value="help-want-guest"/>
                </div>
                <div class="col-lg-7">
                    <div id="side-map"></div>

                    <div class="form-group" style="margin-top: 20px;">
                        <label class="form-label-control">Lat Lng *</label>
                        <input required type="text" name="lat_lng" id="help_call_latlng" class="form-control readonly" >
                        
                        <small class="text-danger">Select location on map</small>
                    </div>
                </div>
            </div>
            <input type="hidden" name="verifySubmission" value="1" />
            <input type="submit" value="SUBMIT" class="blackbtn" />
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

    var helpAddressPoints = [
    <?php                                              
       echo $helpAddressPoints; 
    ?>];


    /* LEAFLET STARTS HERE */

    // Provide your access token
    L.mapbox.accessToken = 'pk.eyJ1Ijoic2hyZXN0aGEiLCJhIjoiY2w3ODQ4dm1rMDYydTNvbWNvcXlwMjBmNSJ9.tigRSYQjUwFZE0zSLd7Onw';
    var map = L.mapbox.map('map', 'mapbox.streets', { zoomControl: false }).setView([27.68814328468732, 85.3184506743254], 8);
    const zoomControl = L.control.zoom({
        position: 'bottomright'
    }).addTo(map);
    var markers = new L.MarkerClusterGroup();
    var decimal=  /^[-+]?[0-9]+\.[0-9]+$/;
    
       
    

    //For Help Markers
    var helpMarkers = new L.MarkerClusterGroup();
    for (var i = 0; i < helpAddressPoints.length; i++) {
        var b = helpAddressPoints[i];

        var title = b[2];
        var lat = b[0];
        var lng = b[1];
        var warehouse= b[3];
        var type = b[4];
        
        var icon = L.mapbox.marker.icon({
            'marker-size':'medium',  
            'marker-color': 'orange'
        });

        // change icon
        if(type == 'Road Network') {
            icon = L.icon({
                iconUrl: 'images/marker-car.png',
                iconSize: [50, 50],
                iconAnchor: [25, 50]
            });
        } else if (type == 'Trails') {
            icon = L.icon({
                iconUrl: 'images/trail-marker.png',
                iconSize: [50, 50],
                iconAnchor: [25, 50]
            });
        } else if (type == 'Attractions') {
            icon = L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/256/3536/3536102.png',
                iconSize: [50, 50],
                iconAnchor: [25, 50]
            });
        } else if (type == 'Accomodations') {
            icon = L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/256/11790/11790453.png',
                iconSize: [50, 50],
                iconAnchor: [25, 50]
            });
        } else if (type == 'Flights') {
            icon = L.icon({
                iconUrl: 'images/marker-plane.png',
                iconSize: [50, 50],
                iconAnchor: [25, 50]
            });
        } else if (type == 'Others') {
            icon = L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/256/10036/10036401.png',
                iconSize: [50, 50],
                iconAnchor: [25, 50]
            });
        }

        if(
            ($.trim(lat) != "" && $.trim(lng) != "")
            &&
            (decimal.test(lat) && decimal.test(lng) )
          )
        {
            var marker = L.marker(new L.LatLng(lat, lng),  {
                icon: icon,
                title: title 
            });
            
            marker.bindPopup(title + '<br>- By ' + warehouse + '<br> ');
            helpMarkers.addLayer(marker);
            helpMarkers.on("click", function(e){
                $("#mission-detail-div").fadeOut();
            });
        }
    }
    
    
    map.addLayer(helpMarkers);

    $('#openHelpBtn').on('click',function(){
        $('#myModal').modal({show:true});
        //For modal window markers
        var sideMap = L.mapbox.map('side-map', 'mapbox.satellite', { zoomControl: false }).setView([27.68814328468732, 85.3184506743254], 14);
        var marker = L.marker([27.68814328468732, 85.3184506743254], { icon: L.mapbox.marker.icon({'marker-color': '#1087bf'}), draggable: true }).addTo(sideMap);

        marker.on('dragend', function(event) {
            var latlng = event.target.getLatLng();

            $('#help_call_latlng').val(latlng.lat + ', ' + latlng.lng);
            console.log('Event Triggered');
        });

        let geoCoderOptions = {
            collapsed: false,
            defaultMarkGeocode: false,
            geocoder: L.Control.Geocoder.nominatim({
                geocodingQueryParams: {
                    countrycodes: 'np'
                }
            })
        }

        L.Control.geocoder(geoCoderOptions)
        .on('markgeocode', function(e) {
            // Get the location found by the geocoder
            var latlng = e.geocode.center; // Get the latitude and longitude

            // Move the camera to the found location
            sideMap.setView(latlng, 13); // Adjust the zoom level as needed
            
            marker.setLatLng(latlng);

            $('#help_call_latlng').val(latlng.lat + ', ' + latlng.lng);
        })
        .addTo(sideMap);
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
    }
    
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
        
        $('#panel-heading').click(function(){
            $("#wcontainer").slideDown();
            $("#heading-bar" ).animate({
                'margin-top': '0px',
                'width': '100%'
            }, 300, function() {});

        });

        $('#map').on('click', function() {
            if (!$(event.target).closest('.panel-profile').length) {
                $("#contact-details").hide();
                $("#about-details").hide();
                $("#wcontainer").slideUp();
                $( "#heading-bar" ).animate({ 'margin-top': '-50px', 'width': '100%' }, 300, function() {});
            }
        })
    });
    $(".readonly").on('keydown paste focus mousedown', function(e){
        if(e.keyCode != 9) // ignore tab
            e.preventDefault();
    });
</script>


