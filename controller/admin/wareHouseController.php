<?php 
include "../../includes/adminIncludes.php";
include "../../system/functions.php" ;
include "../../system/config.php";
?>
<?php
if( isset($_POST["name"]) )
{
	$name = mysql_real_escape_string($_POST["name"]);
	$address = mysql_real_escape_string($_POST["address"]);
	$email = mysql_real_escape_string($_POST["email"]);
	$phone = mysql_real_escape_string($_POST["phone"]);

	if( !checkPhoneNumber($phone)  ) {
		logMsg("Plese enter correct phone number",0);
		return redirectPage($_SERVER['HTTP_REFERER']);
	}
	
	$qur = "select * from ". $tableName['warehouse']. " where w_name='$name'";
	$result = mysql_query($qur);
	if(mysql_num_rows($result)>0)
		return logMsg("Warehouse already exists",0);
	$qur = "Insert into ".$tableName['warehouse'] ." values (null,'$name','$address','$email', '$phone')";
	if( mysql_query($qur) )
		logMsg("Entry sucessfully Inserted!",1);
	else
		logMsg("Error : " . mysql_error(),0);

	redirectPage($_SERVER['HTTP_REFERER']);
}
elseif(isset($_GET["action"])){
	$action = mysql_real_escape_string($_GET["action"]);
	$itemId = mysql_real_escape_string($_GET["id"]);

		if($action == "delete") {
			$qur = "Delete from ". $tableName["warehouse"]." where w_id = '$itemId'";	
			
		if( mysql_query($qur) )
			logMsg("Entry sucessfully deleted!",1);
		else
			logMsg( "Error : " . mysql_error(),0);
	}
	redirectPage($_SERVER['HTTP_REFERER']);
}
?>







	