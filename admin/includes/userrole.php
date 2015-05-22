<?php
include "../../system/config.php";
global $tableName;
$qry = mysql_query("Select * from " . $tableName['userrole']);
while($row = mysql_fetch_array($qry)) {
	echo "<option value='" . $row['id'] . "'>" . $row['role'] . "</option>";
}
?>