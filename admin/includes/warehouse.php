<?php
include "../../system/config.php";
global $tableName;
if($_SESSION['userrole'] == 2) {
	$name = $_SESSION['name'];
	$qry2 = mysql_query("Select centerid from " . $tableName['admin_login'] . " where username = '$name'");
	$ary = mysql_fetch_array($qry2);
	$whereCondition = " where w_id = $ary[0]";
}
else {
	$whereCondition = "";
}
$qry = mysql_query("Select * from " . $tableName['warehouse'] . $whereCondition);
while($row = mysql_fetch_array($qry)) {
	echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
}
?>
