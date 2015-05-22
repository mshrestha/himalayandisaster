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
$offset = " OFFSET " . intval(($page - 1 ) * 50);
//Body Begins
$insertMessage ='';
if( !empty( $_POST['newVolunteer']) ){
	$agent_type = 'N/A';
	$agent_name = $_POST['agent_name'];
	$agent_phone = 'N/A';
	$agent_email = 'N/A';
	$agent_address = $_POST['agent_address'];
	$agent_organization = 'N/A';
	$agent_can_travel= 'N/A';
	$agent_duration_available = 'N/A';
	$agent_language_known = 'N/A';
	$agent_can_provide = 'N/A';
	$agent_status = 0;
	$agent_deployed_in = 'N/A';

	$query = "INSERT INTO ".$tableName['agent']." VALUES (NULL, '$agent_type', '$agent_name', '$agent_phone', '$agent_email', '$agent_address', '$agent_organization', '$agent_can_travel', '$agent_duration_available', '$agent_language_known', '$agent_can_provide', '$agent_status', '$agent_deployed_in' )";
	
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
	
		<div class="row col-sm-12">
			<div class='col-sm-offset-2 col-sm-8'>
				<span class='insert-message'><?php echo $insertMessage; ?></span>
				<form method='POST' action='<?php echo $_SERVER['PHP_SELF'];?>'>
					<input type="text" class="form-control" name="agent_name" placeholder="Enter Volunteer name" required>
					<input class='form-control' type='text' name='agent_address' placeholder="Volunteer's Location" required>
					<input type='submit' name='newVolunteer' value='Add Volunteer' class='form-control' />
				</form>
			</div>
	   </div>

<?php
//Includes
include("../includes/adminfooter.php");
?>


