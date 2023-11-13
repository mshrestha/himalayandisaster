<?php
//Includes
include("../includes/adminIncludes.php");
if(!$_SESSION['name'] || $_SESSION['userrole'] == 2) {
	header('Location:index.php');
}
include("../system/config.php");
include("../system/functions.php");
$_SESSION['page'] = "warehouse";
$page = ($_GET['page']) ? intval($_GET['page']) : 1;
$offset = " OFFSET " . intval(($page - 1 ) * 50);

//Body Begins
?>
<div class="wrapper">
	<?php getSegment("topbar"); ?>
	<div class="login-centerize col-sm-4 col-sm-offset-4">
		<div class="row">
			<h4>New WareHouse</h4>
			<p><?php displayMsg();?></p>
			<form method="POST" action="<?php echo $config['adminController'];?>/wareHouseController.php">
				<input placeholder="Name" class="form-control"  type="text" name="name" />
				<input placeholder="Address" class="form-control" type="text" name="address" />
				<input placeholder="Email" class="form-control"  type="email" name="email" />
				<input placeholder="Phone Number" class="form-control"  type="text" name="phone" />
				<!-- <input placeholder="Latitude (26.12467)" class="form-control" required="required" type="text" name="latitude" />
				<input placeholder="Longitude (86.12441)" class="form-control" required="required" type="text" name="longitude" /> -->
				<input class="form-control" type="submit" Value="Register" />
			</form>
		</div>
		<div class="row">
			<h4>Registered WareHouse</h4>
			<table cellspacing="5" cellpadding="5 ">
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Location</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Action</th>
				</tr>
				<?php 
				$qur = "select * from ". $tableName['warehouse'] . " LIMIT 50" . $offset;
				$result= mysql_query($qur);

				$count = 1;
				if(mysqli_num_rows($result) >=1){
					while ($row = mysql_fetch_array($result)):
						?>
					<tr>
						<td><?php echo $row['w_id'] ?> </td>
						<td><?php echo ucfirst($row["w_name"]); ?></td>
						<td><?php echo $row["w_address"];?></td>
						<td><?php echo $row["w_email"];?></td>
						<td><?php echo $row["w_phone"];?></td>
						<td>
							<a href="<?php echo $config['adminController']. '/wareHouseController.php?id='. $row['w_id'] . '&action=delete';?>">Delete</a>
						</td>
					</tr>
				<?php endwhile; ?> 
				<?php 
			}
			else {
				echo "No entries yet";
			}

			?>
		</table>
		<?php paginate($total, $page, $tableName['warehouse'], $whereCondition); ?>
	</div>
</div>
</div>
<?php
//Includes
include("../includes/adminfooter.php");
?>


