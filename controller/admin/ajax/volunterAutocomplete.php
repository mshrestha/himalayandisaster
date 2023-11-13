<?php 
include "../../../system/config.php";
?>

<?php 
if(isset($_POST['term']))
{	
	
	$keyword = $_POST['term'];
	$qur = "SELECT agent_id, agent_name FROM ".$tableName['agent']." WHERE agent_name LIKE '%". $keyword ."%' and agent_status = 0 ORDER BY agent_name ASC LIMIT 0, 20";
	
	$result = mysqli_query($GLOBALS['mysqli'], $qur) or die(mysqli_errno());
	if(mysqli_num_rows($result)){
		$mainAry = array();
		while( $row = $result->fetch_array(MYSQLI_ASSOC) ) {
			$ary = array();
			$ary["agent_name"] = $row["agent_name"];
			$ary["agent_id"] = $row["agent_id"];
			array_push($mainAry, $ary);
		}

		$mainAry = json_encode($mainAry);
		echo $mainAry;

	}

}

?>

