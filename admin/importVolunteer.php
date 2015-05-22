<?php
//Includes
include("../includes/adminIncludes.php");
if(!$_SESSION['name']) {
	header('Location:index.php');
}
include("../system/config.php");
include("../system/functions.php");
$_SESSION['page'] = "importVolunteer";
//Body Begins

importInit(); 

function importInit() { 
	display_form();
	import_volunteers();
} 

function display_form(){
	ob_start(); ?>
	<div class="wrap">
		<h2>Volunteer Importer</h2>
		<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
			Choose Volunteer CSV file: 
			<input name="csv_volunteers" type="file" id="csv_volunteers" /> <br/>
			<input type="submit" name="Submit" value="Submit" /> 
		</form> 
	</div>
	<?php 
	echo  ob_get_clean();

}


function import_volunteers(){

	if ($_FILES[csv_volunteers][size] > 0) { 

		$file = $_FILES[csv_volunteers][tmp_name]; 

		$handle = fopen($file,"r"); 

		$row = 0; 
		global $tableName;
		$flag = false;
		while ( ($data = fgetcsv($handle, 1000, ",")) !== FALSE ) {

			if( $row > 0 ) {

				//I am assuring the data has been inserted from SN which has first value 1. 
				if( (!empty($data)) && ($data[0] == 1)){
					$flag = true; 
				}

				if( ( !empty($data) ) && ( true == $flag ) ) {

					$volunteer_type = 'want-volunteer';
					$name = $data[1];
					$phone = $data[2];
					$address = $data[3];
					$organization = $data[5];
					$i_can_provide = 'N/A';
					$status = 'idle';

					$qry = "Insert into ". $tableName['who_want_to_help']."  ( volunteer_type, name, phone, address, organization, i_can_provide, status, deployed_in ) VALUES ( '$volunteer_type', '$name', '$phone', '$address', '$organization', '$i_can_provide', '$status', ' ' )";
					// echo $qry; die;

					$result = mysql_query($qry) or die($qur. " " . mysql_error());

				}

			}

			$row++;
		}

		fclose($handle);
	}
	return true;
}
