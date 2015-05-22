<?php 
include "../../../system/config.php";
?>

<?php 
if(isset($_POST['term']))
{	
	// print_r($_POST);
	$keyword = mysql_real_escape_string($_POST['term']);
	$warehouse_id = mysql_real_escape_string($_POST['wid']);
	$qur = "SELECT item_id,item_name, item_qty FROM " . $tableName['item'] . " WHERE item_name LIKE '%". $keyword ."%' and w_id = '" . $warehouse_id . "' and item_qty > 0 ORDER BY item_id ASC LIMIT 0, 20";
	$result = mysql_query($qur) or die(mysql_errno());
	if(mysql_num_rows($result)){
		$mainAry = array();
		while( $row = mysql_fetch_assoc($result) ) {
			$ary = array();
			$ary["item_name"] = ucfirst($row["item_name"]);
			$ary["item_id"] = $row["item_id"];
			$ary["item_qty"] = $row["item_qty"];
			array_push($mainAry, $ary);
		}

		$mainAry = json_encode($mainAry);
		echo $mainAry;

	}

}

?>

