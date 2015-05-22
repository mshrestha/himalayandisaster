<?php
//Includes
include("../includes/adminIncludes.php");
if(!$_SESSION['name']) {
	header('Location:index.php');
}
include("../system/config.php");
include("../system/functions.php");
$_SESSION['page'] = "volunteer";
$page = ($_GET['page']) ? intval($_GET['page']) : 1;
$offset = " OFFSET " . intval(($page - 1 ) * 50);
//Body Begins

?>
<div class="wrapper">
	<?php getSegment("topbar"); ?>
	
		

		<div class="col-lg-8">
			<h4>Search Volunteers</h4>
			<div class="col-sm-4 col-sm-offset-4">
				<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<input type="text" class="form-control" name="searchName" placeholder="Enter name, skills, location" value="<?php echo ( !empty($_GET['searchName']) )? $_GET['searchName']:''; ?>">
					<select class="form-control" name="vstatus">
						<option value="">Status</option>
						<option value="Deployed" <?php echo ($_GET['vstatus'] == 'Deployed')? 'selected':''; ?>>Deployed</option>
						<option value="idle" <?php echo ($_GET['vstatus'] == 'idle')? 'selected':''; ?>>Idle</option>
					</select>
					<input type="submit" value="Search" class="form-control">
				</form>
			</div>
		</div>

		<div class="row col-lg-12">
			<h4>Registered Volunteers</h4>
			<table cellspacing="5" cellpadding="5" class="records_list table table-condensed table-hover table-striped" >
                <thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Phone</th>
					<th>Address</th>
					<th>Organization</th>
					<th>Volunteer Type</th>
					<th>Resource/Skill</th>
					<th>Available</th>
					<th>Status</th>
					<th>Deployed in</th>
				</tr>
                    </thead>
				<?php

				if( !empty( $_GET ) ){
					$keyword = mysql_real_escape_string( $_GET['searchName']);
					$status = mysql_real_escape_string( $_GET['vstatus']);
					
					$where_sql = ' ';

					if( !empty( $keyword ) ){
						$where_sql  .= 'WHERE name LIKE "%'. $keyword. '%" OR address LIKE "%'. $keyword .'%"  OR i_can_provide LIKE "%'.$keyword.'%" ';
					}

					if( !empty( $status ) && !empty( $keyword ) ){
						$where_sql .= 'AND status = "'.$status.'"';
					} elseif ( !empty( $status ) && empty( $keyword ) ){
						$where_sql .= 'WHERE status = "'.$status.'"';
					}


					$result = mysql_query('Select * from '. $tableName['who_want_to_help'].''.$where_sql . ' LIMIT 50' . $offset); 

				}else {

					$qur = "select * from ". $tableName['who_want_to_help'];
					$result= mysql_query($qur);
				}

				
				if(mysql_num_rows($result) >=1){
					$count = 0;
					while ($row = mysql_fetch_array($result)):
						$count++;
					?>
				</tr>
					<td><?php echo $count; ?></td>
					<td><?php echo $row["name"]; ?></td>
					<td><?php echo $row["phone"];?></td>
					<td><?php echo $row["address"];?></td>
					<td><?php echo $row["organization"];?></td>
					<td><?php echo $row["volunteer_type"] == 'want-volunteer' ? "Wants to volunteer":"Has resource";?></td>
					<td><?php echo $row["i_can_provide"]; ?></td>
					<td><?php echo $row["agent_duration_available"]; ?></td>

					<?php if( strtolower( $row["status"] )!="deployed") { ?>
					<td><a href="<?php echo $config['adminController'] .'/volunteerDeploy.php?id=' .$row['id']. '&name=' . $row["name"]. '&action=deploy'; ?>">Deploy</a></td>
					<?php } else {?>
					<td><a href="<?php echo $config['adminController'] .'/volunteerController.php?id=' .$row['id'].'&action=undeploy'; ?>">Un-Deploy</a></td>
					<?php } ?>
					<td>
						<?php echo trim($row["deployed_in"]);?>
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
	<?php paginate($total, $page, $tableName['who_want_to_help'], $whereCondition); ?>
</div>

</div>
<?php
//Includes
include("../includes/adminfooter.php");
?>


