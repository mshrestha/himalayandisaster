<?php

	include 'config.php';

	$qur = "Select w_id, agent_id from ". $tableName['package'];
	$ids = mysql_query($qur) or die(mysql_error());
	while ( $row = mysql_fetch_row($ids) ) {
		$qur = "Select w_name from ". $tableName['warehouse'] . " where w_id = $row[0]";
		$w_name = mysql_query($qur) or die($qur. mysql_error());
		$w_name = mysql_fetch_array($w_name);
		$w_name = $w_name['w_name'];

    	$w_name = preg_replace('/\s+/','',$w_name);


    	$qur = "Select agent_email from ".$tableName['agent'] ." where agent_id =$row[1]";
		$agent_email = mysql_query($qur) or die(mysql_error());
		$agent_email = mysql_fetch_array($agent_email);
		$agent_email = $agent_email['agent_email'];

		$email = explode('@', $agent_email);
		$newEmail = $email[0].'@'.$w_name.'.com';
		mysql_query("Update ".$tableName['agent']." SET agent_email='$newEmail' where agent_id =$row[1]")  or die(mysql_error());



	}
?>