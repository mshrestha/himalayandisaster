<?php 
session_start();
require '../system/functions.php';
require '../system/config.php';
?>
<?php
$sender = "sudomksandwich@gmail.com";
if(isset($_POST["help-type"])){
	
	$needs = $_POST["needType"];	
	$help_type = mysql_real_escape_string($_POST['help-type']);
	$name = mysql_real_escape_string($_POST['name']);
	$address = mysql_real_escape_string($_POST['location']);
	$phone = mysql_real_escape_string($_POST['phonenumber']);

	$error = 0;
	if($help_type=="help-want-guest" || $help_type=="help-want-admin"){   // Handles registarion of help calls from front end and back end

		$desc = mysql_real_escape_string( $_POST["description"] );
		$needString = arrayToString($needs) ;
		
		if($help_type=="help-want-guest"){
			$status="Not verified";
		}
		elseif($help_type=="help-want-admin"){
			$status="Verified";
		}

		$qur = "Insert into " . $tableName['helpCall'] . " values(null,'$name', '$needString','$phone','$address','$desc','$status','')";

		$result = mysql_query($qur) or die($qur. " " . mysql_error());


		logMsg("Your request is added. We will get back to you soon as we can",1);

	}

	elseif($help_type == "volunteer-registration"){  //Handles Registration of Volunteers who wants to help (From front end)

		$volunteer_type = mysql_real_escape_string($_POST["volunteer-type"]);
		
		$available_for = mysql_real_escape_string($_POST["availability"]);
		$ready_to_travel = mysql_real_escape_string($_POST["travel"]);
		$language_known = mysql_real_escape_string($_POST["languages"]);
		$skill_set = arrayToString($_POST["skills"]);
		$skill_set .= " | ". mysql_real_escape_string($_POST["other-skills"]);
		$skill_set .= " | " . arrayToString( $_POST["vehicle"] );

		$email = mysql_real_escape_string($_POST["email"]);


		$qur = "Insert into ". $tableName['agent']. " values (null,'$volunteer_type','$name','$phone','$email',
			'$address','self','$ready_to_travel','$available_for',
			'$language_known','$skill_set',0,'')";

		$result = mysql_query($qur) or die(mysql_error(). " ". $qur);
		
		logMsg("Your request is added. We will get back to you soon as we can.",1);

}


redirectPage( $_SERVER['HTTP_REFERER'] );


}
elseif($_GET["action"]){
	$action = $_GET["action"];

	$id = $_GET["id"];
	if($action=="verfiy"){
		$qur = "Update ". $tableName['helpCall'] . " SET help_call_status='Verified' where help_call_id='$id'";
		mysql_query($qur) or die($qur . " " . mysql_error());
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

		$string .=  mysql_real_escape_string($ary[$i] . $concat);
}
return $string;
}
?>



