<?php
//Includes
include("../includes/adminIncludes.php");
if(!$_SESSION['name'] || $_SESSION['userrole'] == 2) {
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
	<div class="col-md-6">
		<div class="row">
		<?php
			if(isset($_GET["id"]) ){
		$packageId = mysql_real_escape_string($_GET["id"]);
		?>
			<h1>Edit Mission</h1>
			<p><?php displayMsg();?></p>
			<?php 
				$packageQry = "select a.w_id,b.vdc_code,b.vdc_name,b.district,c.agent_id,c.agent_name
					from ". $tableName['package'] ." a," . $tableName['vdc'] . " b," .$tableName['agent'] ." c 
					where $where a.agent_id=c.agent_id and a.help_call_id=b.vdc_code and a.pkg_count='$packageId'";
				$packageResult= mysql_query($packageQry);
				if(mysql_num_rows($packageResult) >=1){
					while ($row = mysql_fetch_array($packageResult)):
						$warehouseId=$row["w_id"];
						$vdcCode=$row["vdc_code"];
						$vdcName=$row["vdc_name"];
						$district=$row["district"];
						$agentId=$row["agent_id"];
						$agentName=$row["agent_name"];
			?>
			<form method="POST" action="<?php echo $config['adminController'];?>/packageController.php?action=append">
				
				<input type='text' name="volunteer"  class="form-control" id='volunterAutocomplete' placeholder='Type Volunter Name' value='<?php echo $agentName."(". $agentId.")";?>'>
				<input type='hidden' name="volunteerid" id="volunteerid"  class="form-control" value="<?php echo $agentId;?>">

				<select name="warehouseId" id="warehouse" required="required" class="form-control" onChange="showAddItem()">
					<option value="">Warehouse</option>
					<?php getSegment('warehouse'); ?>
				</select>
				
				<input class="form-control" type='text' id='victimzoneAutocomplete' name='victims_zone	' placeholder='Type affected Place name' value="<?php echo $vdcName.", ". $district." (".$vdcCode.")";?>">
				<input type='hidden' name="victim_zone_id"  id="victim_zone_id" class="form-control" value="<?php echo $vdcCode;?>">
                <br /><br />
					<?php
					$itemQry = "select * from ". $tableName['itemCluster'] . " where pkg_id='".$packageId."'";
					$itemResult= mysql_query($itemQry);
					if(mysql_num_rows($itemResult) >=1){
						while ($row = mysql_fetch_array($itemResult)):
					?>
                
				<div id="itemField" class="row nopadding">
					
                        
					<input class="form-group packageName ui-autocomplete-input" style="width:335px;"  id="name1" type="text" name="itemName[]" placeholder="Item Name" value="<?php echo $row['item_name']; ?>" autocomplete="off"/>	
                    
					<input class="form-group form-control packageQty" id="qty1" type="number" name="itemQty[]" placeholder="Qty" size="4" value="<?php echo $row['cluster_item_qty'];?>" style="width:50px;" />
						<input class="form-group form-control packageID" id="itemid1" type="hidden" name="itemId[]" value="<?php echo $row['item_id'];?>"/>
						<span><a href="<?php echo $config['adminController'].'/packageController.php?action=delete&itemClusterId='.$row["item_cluster_id"];?>"><button type="button" class="btn btn-xs btn-danger btn-lg"><i class="fa fa-times"></i>   </button></a></span>
					</div>
					<?php
						endwhile;
					}
					?>
				<span id="addField" class="pull-left"><button type="button" class="btn btn-xs btn-success btn-lg"><i class="fa fa-plus"></i>   Add More Items</button></span><br /><br />
				<input type="hidden" name ="packageID" value="<?php echo $packageId; ?>">
				<input class="form-control btn-sm btn-success btn-lg" type="submit" Value="Save Changes" style="width:200px;" />

			</form>
			<?php
					endwhile;
			}
		}
	?>
		
</div>
</div>
</div>

<?php
//Includes
include("../includes/adminfooter.php");
?>
<script type="text/javascript">
	var warehouseID = '<?php echo $warehouseId;?>';
	setSelected('warehouse',warehouseID);
</script>