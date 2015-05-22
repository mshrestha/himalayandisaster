<?php 
include "../../includes/adminIncludes.php";
include "../../system/functions.php" ;
include "../../system/config.php";

function get_total_help_req(){
	global $tableName;
	$result = mysql_query( "select count(help_call_id) as num_rows from ".$tableName['helpCall'] );
	$row = mysql_fetch_object( $result );
	return $row->num_rows;
}

function get_total_pending_help(){
	global $tableName;

	$result = mysql_query( "select count(help.help_call_id) as num_rows from ".$tableName['helpCall'] ." as help
		JOIN ".$tableName['package'] ." as package
		ON help.help_call_id = package.help_call_id
		WHERE package.pkg_status = 0");
	$row = mysql_fetch_object( $result );
	return $row->num_rows;
}

function total_verified_requests(){
	global $tableName;
	$result = mysql_query( "select count(help_call_id) as num_rows from ".$tableName['helpCall'] ." where help_call_status ='Verified'");
	$row = mysql_fetch_object( $result );
	return $row->num_rows;	
}

function responded_requests(){
	global $tableName;

	$result = mysql_query( "select count(help.help_call_id) as num_rows from ".$tableName['helpCall'] ." as help
		JOIN ".$tableName['package'] ." as package
		ON help.help_call_id = package.help_call_id
		WHERE package.pkg_status = 1");
	$row = mysql_fetch_object( $result );
	return $row->num_rows;
}
?>