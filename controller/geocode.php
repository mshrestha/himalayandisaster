<?php

if(isset($_GET["address"])){

	$address = $_GET["address"];

	$reqURL = "https://maps.googleapis.com/maps/api/geocode/json?address=";

	$url = $reqURL . $address;

	$url = urlencode($url);

	$result = file_get_contents($url);

	print_r( $result);
}

?>
