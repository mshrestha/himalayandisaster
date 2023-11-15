
<?php
//Includes
include("../includes/adminIncludes.php");
if(!$_SESSION['name'] ) {
	header('Location:index.php');
}
include("../system/config.php");
include("../system/functions.php");
$_SESSION['page'] = "package";
$page = ($_GET['page']) ? intval($_GET['page']) : 1;
$offset = " OFFSET " . intval(($page - 1 ) * 50);
//Body Begins
?>
<div class="wrapper">
	<?php getSegment("topbar"); ?>
	<div class="col-md-12">
		<div class="row col-md-4">
			<?php 
			$newPackageID = generatePackageId();
			$suggestLocation = '28.4719709,84.9678058';
			?>

			<h1>Add Mission</h1>

			

			<p><?php displayMsg();?></p>
			<form method="POST" action="<?php echo $config['adminController'];?>/packageController.php?action=create">
				
				<input type='text' name="volunteer"  class="form-control" id='volunterAutocomplete' placeholder='Type Volunter Name'>
				<input type='hidden' name="volunteerid" id="volunteerid"  class="form-control">

				<select name="warehouseId" id="warehouse" required="required" class="form-control" onChange="showAddItem()">
					<option value="">Organization</option>
					<?php getSegment('warehouse'); ?>
				</select>
				
				<input class="form-control" type='text' id='victimzoneAutocomplete' name='victims_zone' placeholder='Type affected Place name'>
				<input type='hidden' name="victim_zone_id"  id="victim_zone_id" class="form-control">	
				<input type='text' required name="lat_lng" readonly id="lat_lng" class="form-control" placeholder="Latitude, Longitude">	
				
				<div id="itemField" class="hidden row nopadding">
					
					<input class="form-group packageName" id="name1" type="text" name="itemName[]" placeholder="Item Name"/>					<input class="form-group packageQty" id="qty1" type="number" name="itemQty[]" placeholder="Quantity" size="4"/>

					<input class="form-group packageID" id="itemid1" type="hidden" value="" name="itemId[]" />
				</div>
				<span id="addField" class="hidden pull-left">
                <button type="button" class="btn btn-xs btn-success btn-lg"><i class="fa fa-plus"></i>   Add More Items</button>
                </span><br /><br />
				<input type="hidden" name ="randPackageID" value="<?php echo $newPackageID; ?>">
				<input class="form-control" type="submit" Value="Create Mission" />

			</form>
</div>			

			   <div class="col-md-8">
        		
        		<div id="side-map"></div>
                
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
	        'marker-symbol': 'golf',
	        'marker-color': '#1087bf'
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


