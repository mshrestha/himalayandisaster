<?php
//Includes
include("../includes/adminIncludes.php");
if(!$_SESSION['name'] || $_SESSION['userrole'] != 1) {
	header('Location:index.php');
}
include("../system/config.php");
include("../system/functions.php");
$_SESSION['page'] = "item";


//Body Begins
?>
<div class="wrapper">
	<?php getSegment("topbar");
	if(isset($_GET["id"]) ){
		$itemId = mysql_real_escape_string($_GET["id"]);
		?>
		<div class="login-centerize col-sm-4 col-sm-offset-4">
			<div class="row">
				<h4>Item</h4>
				<p><?php displayMsg();?>    </p>
				<?php 
				$qry = "select * from ". $tableName['item'] ." where item_id='". $itemId."' LIMIT 1";
				$result= mysql_query($qry);
				if(mysql_num_rows($result) >=1){
					while ($row = mysql_fetch_array($result)):
						$warehouseID = $row['w_id'];
					$item_cat_id = $row['item_cat_id'];
					?>
					<form method="POST" action="<?php echo $config['adminController'];?>/itemController.php">
				     <input placeholder="Item Name" class="form-control" required="required" type="text" name="itemName" 
                            value="<?php echo ucfirst($row["item_name"]); ?>"/>
                     <input placeholder="Item Quantity" class="form-control" required="required" type="text" name="itemQty" 
                            value="<?php echo $row["item_qty"]; ?>"/>
				     <input placeholder="Item Unit" class="form-control" required="required" type="text" name="itemUnit"
                            value="<?php echo ucfirst($row["item_unit"]); ?>"/>
						<select id="stock" name="type" class="form-control" required="required">
							<option value="">Stock Type</option>
							<?php getSegment('stock'); ?>
						</select>
						<select id="warehouse" name="warehouse" class="form-control" required="required">
							<option value="#">Warehouse</option>
							<?php getSegment('warehouse'); ?>
						</select>
						<input class="form-control" type="hidden" name="prevQty" Value="<?php echo $row["item_qty"]; ?>" />
						<input class="form-control" type="hidden" name="itemId" Value="<?php echo $row["item_id"]; ?>" />
						<input class="form-control" type="hidden" name="action" Value="update" />
						<input class="form-control" type="submit" Value="Update" />
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
	var warehouseID = '<?php echo $warehouseID;?>';
	var stockId = '<?php echo $item_cat_id;?>';
	setSelected('warehouse',warehouseID);
	setSelected('stock',stockId);
</script>