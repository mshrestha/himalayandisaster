<?php
//Includes
include("../includes/adminIncludes.php");
if(!$_SESSION['name']) {
	header('Location:index.php');
}
include("../system/config.php");
include("../system/functions.php");
$_SESSION['page'] = "volunteer";
//Body Begins
?>
<div class="wrapper">
	<?php getSegment("topbar"); ?>
	<div class="login-centerize col-sm-4 col-sm-offset-4">
		<?php if($_SESSION['userrole'] != 2): 
		/*-------
		READ THIS
		when user submits the form add them to a new table having [id,userid,who_needs_help ko id]
		after submitting the form go to volunteerList page, the current user is now deployed
		when undeployed just delete the above entry from db ;)------*/
if(isset($_GET["action"])) {			
	$action = $_GET["action"];
	$user = mysql_real_escape_string($_GET['name']);
	$id = mysql_real_escape_string($_GET['id']);

	
	
	if ($action == "assign"){
		?>

		<p>Deploy <?php echo $user; ?> to </p>

		<form action="<?php echo $config['adminController'];?>/volunteerController.php" method="POST">
			<input type="hidden" class="form-control" name="name" value="<?php echo $user;?>" />
			<input type="hidden" class="form-control" name="id" value="<?php echo $id;?>" />
			<input type="hidden" class="form-control" name="action" value="<?php echo $action;?>"  />
			<input class="form-control" type='text' id='victimzoneAutocomplete' name='location' placeholder='Type affected Place name'>
			<input type='hidden' name="victim_zone_id"  id="victim_zone_id" class="form-control">	
			<input type="submit" class="form-control" value="assign">
		</form>
		<?php 
	} 
	elseif ($action == "deploy") {
		$location = getDeployedLocation($id);
		mysql_query("Update ".$tableName["agent"]." SET agent_status=2 where agent_id=".$id) or die(mysql_error());
		mysql_query("Insert into ".$tableName["agentDetail"]." values(null,now(),'$id','$user',2,'$location')") or die(mysql_error());
		
		logMsg("volunteer deployed",1);
	}
	elseif ($action=="release" || $action=="unassign") {
		$location = getDeployedLocation($id);
		mysql_query("Update ".$tableName["agent"]." SET agent_status=0 where agent_id=".$id) or die(mysql_error());
		mysql_query("Insert into ".$tableName["agentDetail"]." values(null,now(),'$id','$user',0,'$location')") or die(mysql_error());
		logMsg( "Volunteer free" ,1);
	}
	?>
	<?php } 
	if($action != 'assign') {
		redirectPage($_SERVER['HTTP_REFERER']);
	}
	endif; 
	?>
</div>
</div>
<?php

function getDeployedLocation($id){
	global $tableName;
	$result = mysql_query("Select agent_deployed_in from ".$tableName["agent"]." where agent_id='$id'") or die( mysql_error());
	$location = mysql_fetch_array($result);
	return $location[0];
	
}
//Includes
include("../includes/adminfooter.php");
?>


