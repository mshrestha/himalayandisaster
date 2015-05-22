<?php 
include "../../../system/config.php";
?>

<?php 
if(isset($_POST['term']))
{	
	
	$keyword = $_POST['term'];
	$qur = "SELECT vdc_name, vdc_code, district FROM ".$tableName['vdc']." WHERE vdc_name LIKE '%". $keyword ."%' ORDER BY vdc_code ASC LIMIT 0, 20";

	$result = mysql_query($qur) or die(mysql_errno());
	if(mysql_num_rows($result)){
		$mainAry = array();
		while( $row = mysql_fetch_assoc($result) ) {
			$ary = array();
			$ary["help_call_id"] = $row["vdc_code"];
			$ary["help_call_name"] = $row["vdc_name"];
			$ary["help_call_location"] = $row["district"];
			array_push($mainAry, $ary);
		}

		$mainAry = json_encode($mainAry);
		echo $mainAry;

	}

}

?>

