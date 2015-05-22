<?php
//Includes
include("../includes/adminIncludes.php");
if(!$_SESSION['name']) {
	header('Location:index.php');
}
include("../system/config.php");
include("../system/functions.php");
$_SESSION['page'] = "stock";
$page = ($_GET['page']) ? intval($_GET['page']) : 1;
$offset = " OFFSET " . intval(($page - 1 ) * 50);
//Body Begins
?>
<div class="wrapper">
	<?php getSegment("topbar"); ?>
	<div class="login-centerize col-sm-4 col-sm-offset-4">
		<div class="row">
			<h4>Add New</h4>
			<p><?php displayMsg();?></p>
			<form method="POST" action="<?php echo $config['adminController'];?>/stockTypeController.php">
				<input placeholder="Stock Category" class="form-control" required="required" type="text" name="stocktype" />
				<input class="form-control" type="submit" Value="Save" />
			</form>
		</div>
		<div class="row">
			<h4>Registered Stock Types</h4>
				<table cellspacing="5" cellpadding="5 ">
					<tr><th>ID</th><th>Stock Category</th><th>Action</th></tr>
						<?php 
				$qur = "select * from ". $tableName['itemCategory'] . " LIMIT 50" . $offset;
				$result= mysql_query($qur);

				$count = 1;
				if(mysql_num_rows($result) >=1){
				while ($row = mysql_fetch_array($result)):
				?>
				<tr><td><?php echo $count++; ?> </td><td><?php echo $row["item_cat_name"]; ?></td><td><a href="<?php echo $config['adminController']. '/stockTypeController.php?id='. $row['item_cat_id'] . '&action=delete';?>">Delete</a></td></tr>
				<?php endwhile; ?> 
				<?php 
				}
				 else {
					echo "No entries yet";
				}
					
				?>
				</table>
				<?php paginate($total, $page, $tableName['itemCategory'], $whereCondition); ?>
			</div>
		</div>
	</div>
	<?php
//Includes
	include("../includes/adminfooter.php");
	?>


