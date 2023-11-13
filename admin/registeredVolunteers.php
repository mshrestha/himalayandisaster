<?php
//Includes
include("../includes/adminIncludes.php");
if(!$_SESSION['name']) {
	header('Location:index.php');
}
include("../system/config.php");
include("../system/functions.php");
$_SESSION['page'] = "volunteer-reg";
$page = ($_GET['page']) ? intval($_GET['page']) : 1;
$offset = " OFFSET " . intval((($page - 1 ) * 50));
//Body Begins
$insertMessage ='';
if( !empty( $_POST['newVolunteer']) ){
	$agent_type = 'N/A';
	$agent_name = mysql_real_escape_string($_POST['agent_name']);
	$agent_phone = 'N/A';
	$agent_email = 'N/A';
	$agent_address = mysql_real_escape_string($_POST['agent_address']);
	$agent_organization = 'N/A';
	$agent_can_travel= 'N/A';
	$agent_duration_available = 'N/A';
	$agent_language_known = 'N/A';
	$agent_can_provide = 'N/A';
	$agent_status = 0;
	$agent_deployed_in = 'N/A';

	$query = "INSERT INTO ".$tableName['agent']." VALUES (NULL, '$agent_type', '$agent_name', '$agent_phone', '$agent_email', '$agent_address', '$agent_organization', '$agent_can_travel', '$agent_duration_available', '$agent_language_known', '$agent_can_provide', '$agent_status', '$agent_deployed_in' ) ";
	
	$result = mysql_query($query )or die($qur. " " . mysql_error());
	if( $result ){
		logMsg( 'Volunteer added successfully',1 );
	}else {
		logMsg('Please try again later',0);
	}
}

?>
<div class="wrapper">
	<?php getSegment("topbar"); ?>
	
		<div class="row col-lg-12">
            <h1>Volunteers List </h1>
            
			<div class="col-lg-12">
                <button type="button" class="btn btn-xs btn-success btn-lg" data-toggle="modal" data-target=".bs-example-modal-sm">
                    <i class="fa fa-plus-square"></i>
                     Add Volunteers
                </button>
			<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Add Volunteer</strong></div>
                        <span class='insert-message'><?php echo $insertMessage; ?></span>
                        <form method='POST' action='<?php echo $_SERVER['PHP_SELF'];?>'>
                            <input type="text" class="" name="agent_name" placeholder="Enter Volunteer name" required>
                            <input class='' type='text' name='agent_address' placeholder="Volunteer's Location" required>
                            <input type='submit' name='newVolunteer' value='Add Volunteer' class='' />
                        </form>
                    </div>
                </div>
              </div>
            </div><br /><br />
					<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
						<input type="text" class="form-control" name="searchName" placeholder="Enter name, skills, location" value="<?php echo ( !empty($_GET['searchName']) )? $_GET['searchName']:''; ?>" style="width:300px; float:left;">
						<select class="form-control" name="vstatus" style="width:300px; float:left;">
							<option value="">Status</option>
							<option value="2" <?php echo ($_GET['vstatus'] == '2')? 'selected':''; ?>>Deployed</option>
							<option value="1" <?php echo ($_GET['vstatus'] == '1')? 'selected':''; ?>>Assigned</option>
							<option value="0" <?php echo ($_GET['vstatus'] == '0')? 'selected':''; ?>>Idle</option>
						</select>
						<input type="submit" value="Search" class="form-control"  style="width:100px;">
					</form>
				
			</div>
			<div class="row col-sm-12">
				
				<table cellspacing="1" cellpadding="1" class="records_list table table-condensed table-hover table-striped">
                    <thead>
					<tr class="success">
						<th>ID </th>
						<th>Name</th>
						<th>Phone</th>
						<th>Address</th>
						<th>Email</th>
						<th>Type</th>
						<th>Resource/Skill</th>
						<th>Travel</th>
						<th>Languages</th>
						<th>Availability</th>
						<th>Status </th>
						<th>Action </th>
					</tr>
                    </thead>
					<?php 
					if( !empty( $_GET ) ){
						$keyword = mysql_real_escape_string( $_GET['searchName']);
						$status = mysql_real_escape_string( $_GET['vstatus']);

						$where_sql = ' ';
						if( !empty( $keyword ) ){
							$where_sql  .= 'WHERE agent_name LIKE "%'. $keyword. '%" OR agent_address LIKE "%'. $keyword .'%"  OR agent_can_provide LIKE "%'.$keyword.'%" ';
						}

						if( !empty( $status ) && !empty( $keyword ) ){
							$where_sql .= 'AND agent_status = "'.$status.'"';
						} elseif ( ( !empty( $status ) ) && empty( $keyword ) ){
							$where_sql .= 'WHERE agent_status = "'.$status.'"';
						}


						$qur = "Select * from ". $tableName['agent'] . $where_sql . ' order by agent_id DESC LIMIT 50'. $offset;

					}
					else {
						$qur = "Select * from ".  $tableName['agent'] . " order by agent_id DESC LIMIT 50  " . $offset ;
					}
debug_data($qur);
					$result= mysql_query($qur);


					if(mysqli_num_rows($result) >=1){
						$count = 1;
						while ($row = $result->fetch_array()):
							?>
						<tr>
							<td> <?php echo $row[0]; ?> </td>
							<td><?php echo parseName($row["agent_name"]); ?></td>
							<td><?php echo $row["agent_phone"]; ?></td>
							<td><?php echo $row["agent_address"]; ?></td>
							<td><?php echo $row["agent_email"]; ?></td>
							<td><?php echo $row["agent_type"]; ?></td>
							<td><?php echo nl2br($row["agent_can_provide"]); ?></td>
							<td><?php echo $row["agent_can_travel"]; ?></td>
							<td><?php echo $row["agent_language_known"]; ?></td>	
							<td><?php echo $row["agent_duration_available"]; ?></td>	
							<td>
								<?php if($row["agent_status"] == 0): // This means the volunteer is idle ?>
									<?php echo "Idle";?>
								<?php elseif ($row["agent_status"]== 1): //This means the volunteer is already assigned ?>
									<?php echo "Assigned at " . $row['agent_deployed_in'];?>
								<?php elseif ($row["agent_status"]== 2): //This means the volunteer is Deployed ?>
									<?php echo "Deployed at " . $row['agent_deployed_in'];?>
								<?php endif; ?>	
							</td>	

							<td>
								<?php if($row["agent_status"] == 0): // This means the volunteer is idle ?>
									<a href="<?php echo $config['adminUrl'].'/volunteerDeploy.php?action=assign&id='.$row['agent_id'].'&name='.$row['agent_name']; ?>">Assign</a>
								<?php elseif ($row["agent_status"]== 1): //This means the volunteer is already assigned ?>
									<a href="<?php echo $config['adminUrl'].'/volunteerDeploy.php?action=unassign&id='.$row['agent_id'].'&name='.$row['agent_name']; ?>">Unassign</a>
									<a href="<?php echo $config['adminUrl'].'/volunteerDeploy.php?action=deploy&id='.$row['agent_id'].'&name='.$row['agent_name']; ?>">Deploy</a>
								<?php elseif ($row["agent_status"]== 2): //This means the volunteer is Deployed ?>
									<a href="<?php echo $config['adminUrl'].'/volunteerDeploy.php?action=release&id='.$row['agent_id'].'&name='.$row['agent_name']; ?>">Release</a>	
								<?php endif; ?>
							</td>
						</tr>
					<?php endwhile; 
				}
				else 
					echo "No entries yet";

				?>
			</table>

			<?php paginate($total, $page, $tableName['agent'], $where_sql); ?>

		</div>
	</div>

<?php
//Includes
include("../includes/adminfooter.php");
?>


