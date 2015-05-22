<?php 

include '../../system/config.php';
include '../../system/functions.php' ;

?>

<?php

if(isset($_POST['city'])){
	$needType = array();
	$city = mysql_real_escape_string($_POST["city"]);
	$district = mysql_real_escape_string($_POST["district"]);
	
	$needType = $_POST["needType"];
	$needString = "";
	foreach ($needType as $need) {
		$needString .= $need . ",";
	}
	$desc = mysql_real_escape_string($_POST["description"]);
	$lat = mysql_real_escape_string($_POST["latitude"]);
	$lon = mysql_real_escape_string($_POST["longitude"]);

	$qur = "Insert into ". $tableName['victim_table']." values (null,'$district','$city',
															'$needString','$desc','$lat','$lon')";
	if( mysql_query($qur) )
			logMsg( "Entry sucessfully added!",1);
		else
			logMsg("Error : " . mysql_error(),0);
	
	redirectPage($_SERVER['HTTP_REFERER']);

}
elseif(isset($_GET["action"])){
	$action = mysql_real_escape_string($_GET["action"]);
	$itemId = mysql_real_escape_string($_GET["id"]);

		if($action == "delete") {
			$qur = "Delete from ". $tableName["victim_table"]." where id = '$itemId'";	
			
		if( mysql_query($qur) )
			logMsg("Entry sucessfully deleted!",1);
		else
			logMsg( "Error : " . mysql_error(),0);

	redirectPage($_SERVER['HTTP_REFERER']);
	}
}

?>