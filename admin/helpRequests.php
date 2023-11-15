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
	<?php getSegment("topbar"); ?>
	<div class="row">
		<div class="col-lg-12">
		<?php 
			$newPackageID = generatePackageId();
			$suggestLocation = '28.4719709,84.9678058';
			?>
			<h1>Help Required</h1>
			<p><?php displayMsg();?></p>
			<?php if($_SESSION['userrole'] != 2): ?>
				<div class="row col-lg-4 ">
					<form method="POST" action="<?php echo $config['controller'];?>/helpController.php ">
						<input type="text" placeholder="Name"name="name" class="form-control" />
						<input type="text" placeholder="Phone number" name="phonenumber" class="form-control" />
						
						<input class="form-control" type='text' id='victimzoneAutocomplete' name='victims_zone' placeholder='Type affected Place name'>
						<input type='hidden' name="victim_zone_id"  id="victim_zone_id" class="form-control">	
						<input type='text' required name="lat_lng" readonly id="lat_lng" class="form-control" placeholder="Latitude, Longitude">	
						<input type="text" placeholder="Address Note" name="location" class="form-control" />
						<p>Need Type</p>
						<label><input name="needType[]" type="checkbox" class="form-group" value="water" /> Water </label>
						<label><input name="needType[]" type="checkbox" class="form-group" value="food" /> Food </label>
						<label><input name="needType[]" type="checkbox" class="form-group" value="medicine" /> Medicine </label>
						<label><input name="needType[]" type="checkbox" class="form-group" value="tent" /> Tent </label>
						<label><input name="needType[]" type="checkbox" class="form-group" value="doctors" /> Doctors </label>
						<label><input name="needType[]" type="checkbox" class="form-group" value="volunteer" /> Volunteer </label>
						
						<p>
							<label>
								<textarea name="description" class="" style="width:500px;height:150px;" rows="8"></textarea>
								<input type="hidden" name="help-type" value="help-want-admin"/><br/>
								Other(please write above) </label>
							</p>
							<input type="submit" value="SUBMIT"  />
						</form>
					</div>
					<div class="col-lg-8">
						<div id="side-map"></div>
					</div>
				<?php endif; ?>
				<div class="row col-sm-6 col-sm-offset-3">
					<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET">
						<select name="citySearch">
							<option value="">Need Search</option>
							<?php $qry = mysql_query("Select distinct(help_call_needs) from " . $tableName['helpCall']);
							$needs = array();
							while($row = mysql_fetch_array($qry)) {
								$ary = explode(',',$row[0]);
								foreach ($ary as $value) {
							// echo $value . strlen($value) . " ";
							// echo in_array(trim($value), $needs) . "<br/>";
									if(!in_array(trim($value), $needs) && strlen(trim($value)) > 2) 
										array_push($needs, $value);
								}
							}
							foreach ($needs as $need){ ?>
							<option value="<?php echo $need;?>"><?php echo $need;?></option>
							<?php }?>
						</select>
						<select name="locationSearch">
							<option value="">Location Search</option>
							<?php $qry = mysql_query("Select distinct(help_call_location) from " . $tableName['helpCall']);
							while($row = mysql_fetch_array($qry)) { ?>
							<option value="<?php echo $row[0];?>"><?php echo $row[0];?></option>
							<?php }?>
						</select>
						<input class="" type="submit" Value="Search" />
					</form>
                    </div>
                    <div class="row col-lg-12">
					<table cellspacing="5" cellpadding="5 " class="records_list table table-condensed table-hover table-striped">
                        <thead>
						<tr class="success">
							<th>ID</th>
							<th>Name</th>
							<th>Needs</th>
							<th>Description</th>
							<th>Phone</th>
							<th>Address</th>
							<th>Status</th>
							<th>Help status</th>
						</tr>
                        </thead>
						<?php
						$whereCondition = "";
						if(trim($_GET['citySearch']) != "" || trim($_GET['locationSearch'] != "")) {
							$whereCondition = " where help_call_id > 0 ";
						}
						if(trim($_GET['locationSearch']) != "") {
							$name = mysql_real_escape_string(urldecode($_GET['locationSearch']));
							$whereCondition .= " and help_call_location like '%$name%' ";
						}
						if(trim($_GET['citySearch']) != "") {
							$need = mysql_real_escape_string(urldecode($_GET['citySearch']));
							$whereCondition .= " and help_call_needs like '%$need%' ";
						}

						if( ( trim( $_GET['status'] ) == 'pending') && (empty($_POST['citSearch'])) ){

							$status = mysql_real_escape_string(urldecode($_GET['status']));
							$whereCondition .=" WHERE help_call_status = 'Not verified'";
						}

						$qur = "select * from ". $tableName['helpCall'] . $whereCondition . " order by help_call_id ASC  LIMIT 50" . $offset;
						
						$result= mysql_query($qur);

						if(mysql_num_rows($result) >=1){
							$count = 1;
							while ($row = mysql_fetch_array($result)):
								?>
							<td><?php echo $row[0]; ?></td><td><?php echo $row["help_call_name"]; ?></td><td><?php echo $row["help_call_needs"]; ?></td><td><?php echo $row["help_call_other_needs"];?></td><td><?php echo $row["help_call_phone"];?></td>
							<td><?php echo $row["help_call_location"];?></td>
							<?php if( strtolower( $row["help_call_status"] )!="verified"){?>
							<td><a href="<?php echo $config['controller'].'/helpController.php?id=' .$row['help_call_id'].'&action=verfiy'; ?>">Verify</a></td>
							<?php } else{echo "<td> Verified </td>";} ?>

							<td><?php echo $row["help_call_deployment_status"]; ?> </td></tr>
						<?php endwhile;?>

						<?php }
						else {
							echo "No entries yet";
						}

						?>
					</table>
            
					<?php paginate($total, $page, $tableName['helpCall'], $whereCondition); ?>
				</div>
			</div>
		</div>
	</div>
	<?php
//Includes
	include("../includes/adminfooter.php");
	?>
<script>
    
	// Provide your access token
	L.mapbox.accessToken = 'pk.eyJ1Ijoic2hyZXN0aGEiLCJhIjoieG8wd2tpWSJ9.mCLCK1UOF0gijrPiU1FB0w';
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

