<?php
//Includes
include("../includes/adminIncludes.php");
if(!$_SESSION['name']) {
	header('Location:index.php');
}
include("../system/config.php");
include("../system/functions.php");
$_SESSION['page'] = "helprequest";
$page = ($_GET['page']) ? intval($_GET['page']) : 1;
$offset = " OFFSET " . intval(($page - 1 ) * 50);
//Body Begins
?>
<div class="wrapper">
	<?php getSegment("topbar"); 
    if(isset($_GET["id"]) ){
		$helpId = mysql_real_escape_string($_GET["id"]);
	?>
	<div class="row">
		<div class="col-lg-12">
		<?php 
			$newPackageID = generatePackageId();
			$suggestLocation = '28.4719709,84.9678058';
			?>
			<h1>Help Required</h1>
			<p><?php displayMsg();?></p>
			<?php if($_SESSION['userrole'] != 2): ?>
                <?php 
				$qry = "select * from ". $tableName['helpCall'] ." where help_call_id='". $helpId."' LIMIT 1";
				$result= mysql_query($qry);
				if(mysql_num_rows($result) >=1){
					while ($row = mysql_fetch_array($result)):
						
					
					?>

				<div class="row col-lg-4 ">
					<form method="POST" action="<?php echo $config['controller'];?>/helpController.php ">
						<input type="text" placeholder="Name"name="name" class="form-control" value="<?php echo ucfirst($row["help_call_name"]); ?>" />
						<input type="text" placeholder="Phone number" name="phonenumber" value="<?php echo ucfirst($row["help_call_phone"]); ?>" class="form-control" />
						
						<input class="form-control" type='text' id='victimzoneAutocomplete' name='victims_zone' placeholder='Type affected Place name'>
						<input type='hidden' name="victim_zone_id"  id="victim_zone_id" class="form-control">	
						<input type='text' required name="lat_lng" readonly id="lat_lng" class="form-control" placeholder="Latitude, Longitude"  value="<?php echo ucfirst($row["help_call_latlng"]); ?>" >	
						<input type="text" placeholder="Location" name="location" value="<?php echo ucfirst($row["help_call_location"]); ?>" class="form-control" />
						
						<p>Category</p>
						<label><input name="needType[]" type="radio" class="form-group" value="Road Network" <?php if ($row['help_call_needs'] == 'Road Network'){echo "checked"; } ?>/> Road Network </label>
						<label><input name="needType[]" type="radio" class="form-group" value="Trails" <?php if ($row['help_call_needs'] == 'Trails'){echo "checked"; } ?> /> Trails </label>
						<label><input name="needType[]" type="radio" class="form-group" value="Attractions" <?php if ($row['help_call_needs'] == 'Attractions'){echo "checked"; } ?> /> Attractions </label>
						<label><input name="needType[]" type="radio" class="form-group" value="Accomodations" <?php if ($row['help_call_needs'] == 'Accomodations'){echo "checked"; } ?> /> Accomodations </label>
						<label><input name="needType[]" type="radio" class="form-group" value="Flights" <?php if ($row['help_call_needs'] == 'Flights'){echo "checked"; } ?> /> Flights </label>
						<label><input name="needType[]" type="radio" class="form-group" value="Weather" <?php if ($row['help_call_needs'] == 'Weather'){echo "checked"; } ?> /> Weather </label>
						<label><input name="needType[]" type="radio" class="form-group" value="Others" <?php if ($row['help_call_needs'] == 'Others'){echo "checked"; } ?> /> Others </label>
						
						<p>
							<label>
								<textarea name="description" class="" style="width:500px;height:150px;" rows="8"><?php echo ucfirst($row["help_call_other_needs"]); ?></textarea>
								<input type="hidden" name="help-type" value="help-want-admin"/><br/>
								Other(please write above) </label>
							</p>
                            <input class="form-control" type="hidden" name="help_call_id" Value="<?php echo $row["help_call_id"]; ?>" />
                            <input class="form-control" type="hidden" name="action" Value="update" />
							<input class="form-control" type="submit" value="Update"  />
						</form>
					</div>
					<div class="col-lg-8">
						<div id="side-map"></div>
					</div>
                </div>
                <?php endwhile; 
                }
            
                ?>
				<?php endif;  }?>
                
				
			</div>
		</div>
	</div>
	<?php
//Includes
	include("../includes/adminfooter.php");
	?>
<script>
    
	// Provide your access token
	L.mapbox.accessToken = 'pk.eyJ1Ijoic2hyZXN0aGEiLCJhIjoiY2w3ODQ4dm1rMDYydTNvbWNvcXlwMjBmNSJ9.tigRSYQjUwFZE0zSLd7Onw';
	var map = L.mapbox.map('side-map', 'mapbox.satellite')
		.setView([<?php echo $suggestLocation; ?>], 13);
	
	// L.marker is a low-level marker constructor in Leaflet.
	var marker = L.marker([<?php echo $suggestLocation; ?>], {
		icon: L.mapbox.marker.icon(
			{
				'marker-size': 'medium',
				'marker-symbol': '',
				'marker-color': '#ff0000'
			}),
		draggable: true
		
	}).addTo(map);
	
	var coordinates = document.getElementById('lat_lng');
	
	marker.on('dragend', ondragend);
	
	// Set the initial marker coordinate on load.
	ondragend();
	
	function ondragend() {
		var m = marker.getLatLng();
		console.log(m);
		coordinates.value =  m.lat.toFixed(7) + ',' + m.lng.toFixed(7);
	}
	
	
		
	</script>

