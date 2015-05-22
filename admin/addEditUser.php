<?php
//Includes
include("../includes/adminIncludes.php");
if(!$_SESSION['name'] || $_SESSION['userrole'] != 1) {
	header('Location:index.php');
}
include("../system/config.php");
include("../system/functions.php");
$_SESSION['page'] = "user";
$page = ($_GET['page']) ? intval($_GET['page']) : 1;
$offset = " OFFSET " . intval(($page - 1 ) * 50);
//Body Begins
?>
<div class="wrapper">
	<?php getSegment("topbar"); ?>
	<div class="col-md-6">
		
		<div class="row">
			<h4>Registered Users Search</h4>
			<div class="row">
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET">
					<input type="text" placeholder="Name" name="searchName" />
					<select name="searchWarehouse" class="form-control small-select">
						<option value="">Warehouse</option>
						<?php getSegment('warehouse'); ?>
					</select>
					<input class="" type="submit" Value="Search" />
				</form>
			</div>
			<div class="row">
				<table cellspacing="5" cellpadding="5 ">
					<tr><th>Username</th><th>E-mail</th><th>WareHouse</th><th>Role</th><th>Action</th></tr>
					<?php
					$whereCondition = "";
					if(trim($_GET['searchName']) != "" || trim($_GET['searchWarehouse']) != "") {
						$whereCondition = " where id > 0 ";
					}
					if(trim($_GET['searchName']) != "") {
						$name = mysql_real_escape_string(urldecode($_GET['searchName']));
						$whereCondition .= " and username like '%$name%' ";
					}
					if(trim($_GET['searchWarehouse']) != "") {
						$cid = mysql_real_escape_string(urldecode($_GET['searchWarehouse']));
						$whereCondition .= " and centerid = '$cid' ";
					}
					$qry = mysql_query("Select * from " . $tableName['admin_login'] . $whereCondition . " order by id  LIMIT 50" . $offset);
					while ($row = mysql_fetch_array($qry)):
						?><tr><td><?php echo $row[1];?></td><td><?php echo $row[3];?></td><td>
					<?php
					switch($row['userrole']) {
						case 1: $role = 'Admin';break;
						case 2: $role = 'WareHouse';break;
						case 3: $role = 'Super Volunteer';break;
						default: $role = '';
					}
					$qry2 = mysql_query("Select * from " . $tableName['warehouse'] . " where w_id = " . $row['centerid']);
					$row2 = mysql_fetch_array($qry2);
					echo (empty($row2['w_name']) )? 'N/A': $row2['w_name'];
					?>
				</td><td><?php echo $role;?></td><td><a href='<?php echo $config["adminController"]?>/indexController.php?id=<?php echo $row["id"]?>&action=delete'>Delete</a></td></tr>
			<?php endwhile;?>
		</table>
		<?php paginate($total, $page, $tableName['admin_login'], $whereCondition); ?>
	</div>
</div>
</div>
    <div class="col-sm-2">
    </div>
    <div class="col-sm-3">
    <div class="row">
        
            
        
                <h3 class="ng-binding">Register New User</h3>
        
            
            <div class="">
                
			<p><?php displayMsg();?></p>
			<form method="POST" action="<?php echo $config['adminController'];?>/indexController.php">
				<input placeholder="Username" class="form-control" required="required" type="text" name="username" />
				<input placeholder="Password" class="form-control" required="required" type="password" name="password" />
				<input placeholder="E-mail" class="form-control" required="required" type="email" name="email" />
				
				<select class="form-control" required="required" name="userrole">
					<option value="">User role</option>
					<?php getSegment('userrole'); ?>
				</select>

				<select name="warehouse" class="form-control">
					<option value="">Warehouse</option>
					<?php getSegment('warehouse'); ?>
				</select>

				<input type="hidden" value="register" name="type" />
				<input class="form-control" type="submit" Value="Register" />
			</form>
            </div>
        
			
		  </div>
    </div>
</div>
<?php
//Includes
include("../includes/adminfooter.php");
?>


