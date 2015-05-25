<?php 
	include 'config.php';
	if(isset($_GET['wid'])){
	  $w_id = mysql_real_escape_string($_GET['wid']);

	$pkg_ids = mysql_query("Select pkg_id from package where w_id=$w_id") or die(mysql_error());
	$emptyPackage = [];
	while ($row = mysql_fetch_array($pkg_ids)) {
		$row[0] = mysql_real_escape_string($row[0]);
		$qur = "select * from item_cluster where pkg_id = '$row[0]'";
		$items = mysql_query($qur) or die(mysql_error());
		if(mysql_num_rows($items)<1)
			array_push($emptyPackage, $row[0]);
	
	}
	echo count($emptyPackage)." packages don't have any items recorded </br> ";
	$count = 0;
	foreach ($emptyPackage as $packageId) {
		echo ++$count . ') '. $packageId . '<br>';
	
	}
	
		
	
	}
?>