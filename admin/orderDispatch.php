<?php 
include("../includes/adminIncludes.php");

include("../system/config.php");
include("../system/functions.php");
$page = ($_GET['page']) ? intval($_GET['page']) : 1;
$offset = " OFFSET " . intval(($page - 1 ) * 50);

?>

<div class="wrapper">
	<?php getSegment('topbar'); ?>
	<div class="login-centerize col-sm-4 col-sm-offset-4">
		<div class="row">
			<h4>Order dispatch</h4>
			<table cellspacing="5" cellpadding="5 ">
				<tr>
					<th>ID</th>
					<th>Victim Zone</th>
					<th>Volunteers</th>
					<th>Action</th>
					<th>More</th>
				</tr>
				<?php 

				$qur = "select a.pkg_id,b.help_call_location,b.help_call_phone,c.agent_name,c.agent_email,c.agent_phone from package   a," . $tableName['helpCall'] . " b, " .$tableName['agent'] ." c 
				where a.agent_id=c.agent_id and a.help_call_id=b.help_call_id and a.pkg_approval='0' LIMIT 50" . $offset;
				
								// w_id needed so that only particular ware house admin can see the package listing

				$result = mysql_query($qur) or die(mysql_error());

				if(mysql_num_rows($result)){
					while($row = mysql_fetch_array($result)):
						?>
					<tr>
						<td> <?php echo $row["0"]; ?> </td>
						<td> 
							<?php echo $row["1"]; ?> 
						</td>

						<td> 
							<?php echo '<b>'. $row["agent_name"] . '</b>'.
							'</br>'. $row["agent_phone"]; ?> 
						</td>

						<td> 
							<a href="<?php echo $config['adminController'].'/itemAccountController.php?action=approve&id='.$row['pkg_id'];?>">Approve </a> 
							<a href="<?php echo $config['adminController'].'/itemAccountController.php?action=remove&id='.$row['pkg_id'];?>">Delete </a> 
						</td>

						<td>
							<a href="<?php echo $config['adminUrl'].'/packageDetail.php?id='.$row['pkg_id'];?>">View </a> 
						</td>
					</tr>
				<?php endwhile; ?>
				<?php } ?>
			</table>
			<?php //paginate($total, $page, $tableName['item'], $whereCondition); ?>
		</div>
	</div>
</div>
<?php
//Includes
include("../includes/adminfooter.php");
?>
