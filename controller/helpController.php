<?php 
session_start();
require '../system/functions.php';
require '../system/config.php';
?>

<?php
$sender = "info@kazistudios.com";
if(isset($_POST["help-type"])){
	
	$needs = $_POST["needType"];	
	$help_type = mysqli_real_escape_string($mysqli, $_POST['help-type']);
	$name = mysqli_real_escape_string($mysqli, $_POST['name']);
	$address = mysqli_real_escape_string($mysqli, $_POST['location']);
	$phone = mysqli_real_escape_string($mysqli, $_POST['phonenumber']);
	$latlng = mysqli_real_escape_string($mysqli, $_POST['lat_lng']);
	$help_file = null;
	$error = 0;

	// file upload
	if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
		$targetDir = "../uploads/";

		// Get file extension
        $fileExtension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

		if (in_array($fileExtension, ['png', 'jpg', 'jpeg', 'webp'])) {
			$uniqueFileName = uniqid("file_", true) . '.' . $fileExtension;
			$targetFile = $targetDir . $uniqueFileName;

			// Move uploaded file
			if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
				$help_file = $uniqueFileName;
			}
		}
	}

	if($help_type=="help-want-guest" || $help_type=="help-want-admin"){   // Handles registarion of help calls from front end and back end

		$desc = mysqli_real_escape_string($mysqli, $_POST["description"] );
		if($needs != null){
			$needString = arrayToString($needs) ;
		}
		
		
		if($help_type=="help-want-guest"){
			$status="Not verified";
		}
		elseif($help_type=="help-want-admin"){
			$status="Verified";
		}
		if($action=="update"){
			$helpCallId = $_POST['help_call_id'];
		$qur = "UPDATE" . $tableName["helpCall"] . " SET help_call_name='$name',help_call_needs='$needs',help_call_phone='$phone',help_call_location='$address',help_call_other_needs='$desc',help_call_status='Verified',help_call_latlng='$latlng' where help_call_id='$helpCallId'" ;
		
		
		}else{
		$qur = "Insert into " . $tableName['helpCall'] . " (`help_call_name`, `help_call_needs`, `help_call_phone`, `help_call_location`, `help_call_other_needs`, `help_call_status`, `help_call_latlng`, `help_call_file`) VALUES ('$name', '$needString','$phone','$address','$desc','$status', '$latlng', '$help_file')";
		}
		
		$result = mysqli_query($mysqli, $qur) or die($qur. " " . mysqli_error());


		logMsg("Your request is added. We will get back to you soon as we can",1);

	}

	elseif($help_type == "volunteer-registration") {  //Handles Registration of Volunteers who wants to help (From front end)

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


// redirectPage( $_SERVER['HTTP_REFERER'] );
redirectPage( $config['homeUrl'] );


}
elseif($_GET["action"]){
	$action = $_GET["action"];

	$id = $_GET["id"];
	if($action=="verfiy"){
		$qur = "Update ". $tableName['helpCall'] . " SET help_call_status='Verified' where help_call_id='$id'";
		mysqli_query($mysqli, $qur) or die($qur . " " . mysqli_error());
		logMsg("Entry Verified",1);
	}
	// redirectPage( $_SERVER['HTTP_REFERER'] );
	redirectPage( $config['homeUrl'] );
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



