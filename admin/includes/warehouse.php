<?php
include "../../system/config.php";
global $tableName;
if($_SESSION['userrole'] == 2) {
	$name = $_SESSION['name'];
	$qry2 = mysqli_query($GLOBALS['mysqli'], "Select centerid from " . $tableName['admin_login'] . " where username = '$name'");
	$ary = $qry2->fetch_array(MYSQLI_NUM);
	$whereCondition = " where w_id = $ary[0]";
}
else {
	$whereCondition = "";
}
$qry = mysqli_query($GLOBALS['mysqli'], "Select * from " . $tableName['warehouse'] . $whereCondition);
while($row = $qry->fetch_array(MYSQLI_NUM)) {
	echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
}
?>
