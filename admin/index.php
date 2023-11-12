	<?php
    error_reporting(1);
    include("../includes/adminIncludes.php");
    include("../system/config.php");
    include("../system/functions.php");
    $_SESSION['page'] = "home";
    ?>

<?php 
			$whereCondition = "and a.pkg_approval='1'";
			if(trim($_GET['status']) == "0"){
				$whereCondition = "and a.pkg_approval='0'";
			}
			$qry2 = mysqli_query($mysqli, "Select centerid from " . $tableName['admin_login'] . " where username = '$name'");
			$ary  = $qry2->fetch_array(MYSQLI_NUM);
			if(!empty($ary[0])){
				$where="a.w_id=$ary[0] and";
			}
			else{
				$where="";
			}
			$qur = "select a.pkg_count,a.help_call_latlng,a.help_call_id,a.pkg_id,a.pkg_count,a.pkg_timestamp,a.pkg_approval,a.help_call_latlng,b.vdc_name, b.district, c.agent_name,c.agent_email,c.agent_phone
					from ". $tableName['package'] ." a," . $tableName['vdc'] . " b," .$tableName['agent'] ." c 
					where $where a.agent_id=c.agent_id and a.help_call_id=b.vdc_code ". $whereCondition . " order by a.pkg_count ASC" . $offset;
            // die($qur);
            $addressPoints = '';
			$result= mysqli_query($mysqli, $qur);
			$count = 1;
			if(mysqli_num_rows($result) >=1) { 
                                                
                while ($row = $result->fetch_array(MYSQLI_NUM)){
                    //echo $row['vdc_name'];
                    if($count >1){
                        $addressPoints .=",\n";
                    }
                    if($row['help_call_id']!=-1)
                        $location = $row['vdc_name'].', '.$row['district'];
                    else 
                        $location = $row['help_location'];

                    $addressPoints .= '['.$row['help_call_latlng'].', "<a href=\"packageDetail.php?id='.$row['pkg_count'].'\">'.$location.'</a><br />"]';
                    $count++;
                
                }
				debug_data($addressPoints);
            }

            ?>


    <?php getSegment('topbar'); ?>
    
<script src='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.css' rel='stylesheet' />
<link href='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.Default.css' rel='stylesheet' />

    <div class="login-centerize col-lg-12 ">
      <?php 
      if(!$_SESSION['name']): ?>
      <div class="row">
        
        <?php displayMsg(); ?>
        <form method="POST" action="<?php echo $config['adminController'];?>/indexController.php">
         <input placeholder="Username" class="form-control" required="required" type="text" name="username" />
         <input placeholder="Password" class="form-control" required="required" type="password" name="password" />
         <input type="hidden" value="login" name="type" />
         <input class="form-control" type="submit" Value="Login" />
     </form>
 </div>
<?php else: 
  $user = $_SESSION['name'];

  ?>
  <!-- profile panel -->
  <div class="panel panel-profile relative">
    <div class="panel-heading text-center bg-info">

        <h3 class="ng-binding">Himalayan Disaster Relief Effort Areas</h3>

    </div>
    <div id="map">
        
    </div>
      <span id='coordinates' class='ui-coordinates'></span>
</div>
<!-- end profile panel -->

<!-- mini box -->
<div class="row">
    <div class="col-sm-6">
        <div class="panel mini-box">
            <span class="box-icon bg-danger">
                <i class="fa fa-film"></i>
            </span>
            <div class="box-info">
                <?php 
                $qur = "select distinct(help_call_location) from ".$tableName['helpCall'] . "   ";
                $result = mysqli_query($mysqli, $qur);
                $cityCount = mysqli_num_rows($result)? mysqli_num_rows($result):0 ;
		$cc = 1;
                ?>
                <p class="size-h2"><?php echo $cityCount;?></p>
                <p class="text-muted">
                    
                    
                    <?php if($cityCount > 0): ?>
                        <a href="<?php echo $config['adminurl']?>helpRequests.php";?>place(s) need help</a></p>
                    <?php else: ?>
                        <p class="text-muted"> place(s) need help</p>
                    <?php endif; ?>
                </p>
            </div>
        </div>                    
    </div>
    <div class="col-sm-6">
        <div class="panel mini-box">
            <span class="box-icon bg-warning">
                <i class="fa fa-camera"></i>
            </span>
            <?php $qry = mysqli_query($mysqli, "Select distinct(item_name) from " . $tableName['item'] . " where item_qty <= 0");
            $count = mysqli_num_rows($qry);
		$cc = 1;
            ?>
            <div class="box-info">
                <p class="size-h2"><?php echo $count;?></p>
                <p class="text-muted">
                 item(s) are out of stock
                 <ul class="listclass">
                     <?php while($ary = $qry->fetch_array(MYSQLI_NUM)) 
                	if($cc++  <6)     echo "<li>$ary[0]</li>";
                     ?>
                 </ul>
                 <?php if($count > 0): ?>
                     <a href="<?php echo $config['adminurl']?>addEditItems.php?searchName=&qtySearch=1&typeSearch=&searchWarehouse=";?>View All</a></p>
                 <?php endif; ?>
             </div>
         </div>                    
     </div>
 </div>
 <div class="row">
    <div class="col-sm-6">
        <div class="panel mini-box">
            <span class="box-icon bg-success">
                <i class="fa fa-bookmark-o"></i>
            </span>
            <div class="box-info">
                <?php $qry = mysqli_query($mysqli, "Select distinct(item_name) from " . $tableName['item'] . " where item_qty between 1 and 10");
                $count = mysqli_num_rows($qry);
		$cc = 1;
                ?>
                <p class="size-h2"><?php echo $count;?></p>
                <p class="text-muted">
                 item(s) are going be out of stock
                 <ul class="listclass">
                     <?php while($ary = $qry->fetch_array(MYSQLI_NUM)) 
                     if($cc++ < 6) echo "<li>$ary[0]</li>";
                     ?>
                 </ul>
                 <?php if($count > 0): ?>
                     <a href="<?php echo $config['adminurl']?>addEditItems.php?searchName=&qtySearch=2&typeSearch=&searchWarehouse=";?>View All</a></p>
                 <?php endif; ?>
             </div>
         </div>
     </div>
     <div class="col-sm-6">
        <div class="panel mini-box">
            <span class="box-icon bg-info">
                <i class="fa fa-check"></i>
            </span>
            <div class="box-info">
                <?php $now = date('Y-m-d');
                $fromDate = $now . " 00:00:00";
                $toDate = $now . " 11:59:59";
                $qry = mysqli_query($mysqli, "Select sum(delta_qty) from " . $tableName['itemAccount'] . " where item_account_date between '$fromDate' and '$toDate' and item_direction in( 'in', 'ins')");
                $qry2 = mysqli_query($mysqli, "Select sum(delta_qty) from " . $tableName['itemAccount'] . " where item_account_date between '$fromDate' and '$toDate' and item_direction in( 'dl', 'out')");
                $ary = $qry->fetch_array(MYSQLI_NUM);
                $ary2 = $qry2->fetch_array(MYSQLI_NUM);
                ?>
                <p class="size-h2"><?php echo abs($ary[0]);?></p>
                <p class="text-muted">

                 item(s) brought in today
                 <?php echo abs($ary2[0]);?> item(s) given today
             </p>
         </div>
     </div>
 </div>
</div>
<!-- end mini box -->

<?php endif; ?>

</div>

<?php
//Includes
include("../includes/adminfooter.php");
?>

					

<script type="text/javascript">
    var addressPoints = [
    <?php                                              
       echo $addressPoints; 
    ?>];
// Provide your access token
    console.log(addressPoints);
L.mapbox.accessToken = 'pk.eyJ1Ijoic2hyZXN0aGEiLCJhIjoieG8wd2tpWSJ9.mCLCK1UOF0gijrPiU1FB0w';
var map = L.mapbox.map('map', 'mapbox.satellite').setView([27.707809112357083, 85.31574726104736], 9);

var markers = new L.MarkerClusterGroup();
var decimal=  /^[-+]?[0-9]+\.[0-9]+$/;
    for (var i = 0; i < addressPoints.length; i++) {
        
        var a = addressPoints[i];
        var title = a[2];
        var lat = a[0];
        var lng = a[1];
     if(
            ($.trim(lat) != "" && $.trim(lng) != "")
            &&
            (decimal.test(lat) && decimal.test(lng) )
          )
        {
        var marker = L.marker(new L.LatLng(lat, lng), {
            icon: L.mapbox.marker.icon({'marker-size':'medium', 'marker-symbol': 'golf', 'marker-color': '1087bf'}),
            title: title
        });
        marker.bindPopup(title);
        markers.addLayer(marker);
	
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
    // Display a list of markers.
    document.getElementById('coordinates').innerHTML = inBounds.join('\n');
}
onmove();
map.on('move', onmove);
</script>
