<?php 
session_start();
require '../system/functions.php';
require '../system/config.php';
?>
<?php
$sender = "sudomksandwich@gmail.com";
if(isset($_POST["help-type"])){
	
	$needs = $_POST["needType"];	
	$help_type = mysqli_real_escape_string($mysqli, $_POST['help-type']);
	$name = mysqli_real_escape_string($mysqli, $_POST['name']);
	$address = mysqli_real_escape_string($mysqli, $_POST['location']);
	$phone = mysqli_real_escape_string($mysqli, $_POST['phonenumber']);

	$error = 0;
	if($help_type=="help-want-guest" || $help_type=="help-want-admin"){   // Handles registarion of help calls from front end and back end

		$desc = mysqli_real_escape_string($mysqli, $_POST["description"] );
		$needString = arrayToString($needs) ;
		
		if($help_type=="help-want-guest"){
			$status="Not verified";
		}
		elseif($help_type=="help-want-admin"){
			$status="Verified";
		}

		$qur = "Insert into " . $tableName['helpCall'] . " values(null,'$name', '$needString','$phone','$address','$desc','$status','')";

		
		$result = mysqli_query($mysqli, $qur) or die($qur. " " . mysqli_error());


		logMsg("Your request is added. We will get back to you soon as we can",1);

	}

	elseif($help_type == "volunteer-registration"){  //Handles Registration of Volunteers who wants to help (From front end)

		$volunteer_type = mysqli_real_escape_string($mysqli, $_POST["volunteer-type"]);
		
		$available_for = mysqli_real_escape_string($mysqli, $_POST["availability"]);
		$ready_to_travel = mysqli_real_escape_string($mysqli, $_POST["travel"]);
		$language_known = mysqli_real_escape_string($mysqli, $_POST["languages"]);
		$skill_set = arrayToString($_POST["skills"]);
		$skill_set .= " | ". mysqli_real_escape_string($mysqli, $_POST["other-skills"]);
		$skill_set .= " | " . arrayToString( $_POST["vehicle"] );

		$email = mysqli_real_escape_string($mysqli, $_POST["email"]);


		$qur = "Insert into ". $tableName['agent']. " values (null,'$volunteer_type','$name','$phone','$email',
			'$address','self','$ready_to_travel','$available_for',
			'$language_known','$skill_set',0,'')";

		$result = mysqli_query($mysqli, $qur) or die(mysqli_error(). " ". $qur);
		
		logMsg("Your request is added. We will get back to you soon as we can.",1);

}


redirectPage( $_SERVER['HTTP_REFERER'] );


}
elseif($_GET["action"]){
	$action = $_GET["action"];

	$id = $_GET["id"];
	if($action=="verfiy"){
		$qur = "Update ". $tableName['helpCall'] . " SET help_call_status='Verified' where help_call_id='$id'";
		mysqli_query($mysqli, $qur) or die($qur . " " . mysqli_error());
		logMsg("Entry Verified",1);
	}
	redirectPage( $_SERVER['HTTP_REFERER'] );
}
function arrayToString($ary){
	$string = "";
	for ($i=0; $i<count($ary) ; $i++) { 
		if($i!=count($ary)-1)
			$concat = ',';
		else 
			$concat = '';

		$string .=  mysqli_real_escape_string($GLOBALS['mysqli'], $ary[$i] . $concat);
}
return $string;
}
?>



