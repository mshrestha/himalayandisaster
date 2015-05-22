<?php 

include '../../system/config.php';
include '../../system/functions.php' ;

?>

<?php

if(isset($_POST["stocktype"])){
	$stocktype = mysql_real_escape_string($_POST["stocktype"]);
	if(!is_numeric($stocktype) || strlen(trim($stocktype))<=3 ){
	$qur = "Insert into ". $tableName['itemCategory'] . " values(null,'$stocktype')";
		if(mysql_query($qur))
			logMsg("Stock sucessfully updated",1);
		else 
			echo "Error " . mysql_error();
	}	
	else
	{
		logMsg( "Error in the entry" ,0);
	}
	redirectPage($_SERVER['HTTP_REFERER']);
}
elseif(isset($_GET["action"])){
	$action = mysql_real_escape_string($_GET["action"]);
	$itemId = mysql_real_escape_string($_GET["id"]);

		if($action == "delete") {
			$qur = "Delete from ". $tableName["itemCategory"]." where item_cat_id = '$itemId'";	
			
		if( mysql_query($qur) )
			logMsg("Entry sucessfully deleted!",1);
		else
			echo "Error : " . mysql_error();
	}
	redirectPage($_SERVER['HTTP_REFERER']);
}
?>