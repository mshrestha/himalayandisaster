<?php
include "../../system/config.php";

?>

<?php 

$qur = "select * from  " . $tableName['warehouse'];
$result = mysql_query($qur);

if($result){
$mainAry = array();
while($row = mysql_fetch_row($result)) {
	$ary = array();
	$ary["id"]=$row[0];
	$ary["place"]=$row[1];
	$ary["lat"]=$row[4];
	$ary["long"]=$row[5];
	$ary["location"]=$row[2];
	$ary["phone"]=$row[3];
	array_push($mainAry, $ary);
}
	$mainAry = json_encode($mainAry);
	echo $mainAry;
	}
	else 
		echo "Error :" . mysql_error();
?>