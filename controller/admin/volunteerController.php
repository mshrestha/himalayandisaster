	<?php 
include "../../includes/adminIncludes.php";
include "../../system/config.php";
include "../../system/functions.php";
?>
<?php
if(isset($_POST["action"])){

	$action = $_POST["action"];
	if($action == "assign"){
		$id = mysql_real_escape_string($_POST["id"]);
		$name = mysql_real_escape_string($_POST["name"]);
		$location = mysql_real_escape_string($_POST["location"]);


		$qur = "Update ". $tableName['agent'] . " SET agent_status=1,agent_deployed_in='$location' where agent_id='$id'";
		mysql_query("Insert into ".$tableName["agentDetail"]." values(null,now(),'$id','$name',1,'$location')") or die(mysql_error());

		mysql_query($qur) or die($qur . " " . mysql_error());

		logMsg( "Volunteer assigned" ,1);
	}
}

redirectPage( $config['adminUrl'] . '/registeredVolunteers.php' );


?>

