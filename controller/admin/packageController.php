<?php 
session_start();
include '../../system/config.php';
include '../../system/functions.php' ;
?>

<?php
if(isset($_GET["action"]))
{	
	if($_GET["action"]=="append"){
		$volunteerId = mysql_real_escape_string($_POST["volunteerid"]);
		$warehouseId = mysql_real_escape_string($_POST["warehouseId"]);
		$zoneId = mysql_real_escape_string($_POST["victim_zone_id"]);
		if(empty($volunteerId) || empty($zoneId)){

			$errorMsg = (empty($volunteerId)) ? "Volunteer" : "Zone"; 
			logMsg( $errorMsg. " doesn't exists",0);
			return redirectPage($_SERVER['HTTP_REFERER']);
		}

		$packageId = mysql_real_escape_string($_POST["packageID"]);
		$itemName = $_POST["itemName"];
		$itemQty = $_POST["itemQty"];
		$itemId = $_POST["itemId"];
		$itemCount = count($itemName);
		$count =0;
		foreach ($itemId as $id ) {
			if(empty($id)){
				logMsg($itemName[$count] ." doesn't exists",0);
				return redirectPage($_SERVER['HTTP_REFERER']);
			}
		}
$qur ="Update ". $tableName['package'] . " set pkg_timestamp=now(),agent_id='$volunteerId',help_call_id='$zoneId',w_id='$warehouseId' where pkg_id='$packageId'";
		$result = mysql_query($qur) or die($qur . " " .mysql_error());
		if($result){
			$qur = "Update ".$tableName['itemCluster']. " SET pk_status = -1 where pkg_id='$packageId'";
			mysql_query($qur) or logMsg(mysql_error(),0);
			for($i=0;$i<$itemCount;$i++){
$qur = "Insert into ". $tableName['itemCluster'] . " values(null," . $itemId[$i] . "," . $itemQty[$i] . ",'" . $itemName[$i] . "','$packageId')";
				mysql_query($qur) or logMsg(mysql_error(),0);
			}
		}
logMsg("Package Updated",1);
}
if($_GET["action"]=="create"){

	$volunteerId = mysql_real_escape_string($_POST["volunteerid"]);

	$warehouseId = mysql_real_escape_string($_POST["warehouseId"]);
	$zoneId = mysql_real_escape_string($_POST["victim_zone_id"]);

	$latlng = mysql_real_escape_string($_POST["lat_lng"]);


	if(empty($volunteerId) || empty($zoneId)){
		$errorMsg = (empty($volunteerId)) ? "Volunteer" : "Zone"; 
		logMsg( $errorMsg. " doesn't exists",0);
		return redirectPage($_SERVER['HTTP_REFERER']);
	}

	$packageId = mysql_real_escape_string($_POST["randPackageID"]);
	$itemName = $_POST["itemName"];
	$itemQty = $_POST["itemQty"];
	$itemId = $_POST["itemId"];
	$itemCount = count($itemName);
	$count =0;
	foreach ($itemId as $id ) {
		if(empty($id)){
			logMsg($itemName[$count] ." doesn't exists",0);
			return redirectPage($_SERVER['HTTP_REFERER']);
		}
		$count++;

	}
    $res = mysql_query("Select vdc_name,district from vdc where vdc_code=$zoneId") or die(mysql_error());
    $result = mysql_fetch_assoc($res);

//    $latlng = lookup( $result['vdc_name'].','.$result['district'] );
//    if($latlng){
//        $latlng = $latlng['latitude'].','.$latlng['longitude'];
//    }
//    else
//    {
//        $latlng = '27.6701623,85.308871';
//    }
	$qur = "Insert into ". $tableName['package'] . " values('$packageId',null,'0',now(),'0',
                                                            $volunteerId,$zoneId,'".$latlng."',$warehouseId)";
    

	$result = mysql_query($qur) or die($qur . " " .mysql_error());
    $pkg_insert_id = mysql_insert_id();
	if($result)
    {
		for($i=0;$i<$itemCount;$i++){
			$qur = "Insert into ". $tableName['itemCluster'] . " values(null," . $itemId[$i] . "," . $itemQty[$i] . ",'" . $itemName[$i] . "','$packageId')";
			mysql_query($qur) or logMsg(mysql_error(),0);
		}
        $redirectLink = $config['adminUrl'] . "/packageDetail.php?id=".$pkg_insert_id;
        return redirectPage( $redirectLink ); // if package created sucessfully, redirect to packag detail
	}


}
else if($_GET["action"]=="update"){
	$itemClusterId = mysql_real_escape_string($_POST["itemClusterId"]);
	$itemQty = mysql_real_escape_string($_POST["itemQty"]);
	$qur = "update ". $tableName['itemCluster'] . " set cluster_item_qty='".$itemQty."' where item_cluster_id='".$itemClusterId."'";

	if( mysql_query($qur) )
		logMsg("Entry sucessfully updated",1);
	else
		logMsg( "Error : " . mysql_error(),0);
}
else if($_GET["action"]=="delete"){
	$itemClusterId = mysql_real_escape_string($_GET["itemClusterId"]);
	$qur = "Delete from ". $tableName['itemCluster'] . " where item_cluster_id='$itemClusterId'";
	if( mysql_query($qur) )
		logMsg("Entry sucessfully deleted",1);
	else
		logMsg( "Error : " . mysql_error(),0);
   return redirectPage($config['adminUrl'] . "/listPackage.php");
}
redirectPage($_SERVER['HTTP_REFERER']);
}
?>
