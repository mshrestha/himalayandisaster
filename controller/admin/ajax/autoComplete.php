<?php 
include "../../../system/config.php";
?>

<?php 
if(isset($_POST['term']))
{	
	// print_r($_POST);
	$keyword = mysqli_real_escape_string($GLOBALS['mysqli'], $_POST['term']);
	$warehouse_id = mysqli_real_escape_string($GLOBALS['mysqli'], $_POST['wid']);
	$qur = "SELECT item_id,item_name, item_qty FROM " . $tableName['item'] . " WHERE item_name LIKE '%". $keyword ."%' and w_id = '" . $warehouse_id . "' and item_qty > 0 ORDER BY item_id ASC LIMIT 0, 20";
	$result = mysqli_query($GLOBALS['mysqli'], $qur) or die(mysqli_errno());
	if(mysqli_num_rows($result)){
		$mainAry = array();
		while( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
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

