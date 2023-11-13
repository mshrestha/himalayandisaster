<?php
include("config.php");




function checkEmail($email) {
  return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $email);
}

function logMsg($msg,$status){
  $logs = array();
  $logs["msg"] = $msg;
  $logs["status"] = $status;
  $logs["msgLoc"] = $_SESSION["page"];

  $_SESSION['logs'] = $logs;
}

function parseName($item){
  $itemName = '';
  $itemNameParts = explode(' ', $item);
  if(count($itemNameParts)>0){
    foreach ($itemNameParts as $itemNamePart ) {
      $itemName .= ucfirst($itemNamePart) . ' ';
    }
  }
  return $itemName;
}

 function parseDate($date)
 {
    $data = explode('-', $date);
    $month = $data[1];
    $year = $data[0];
    $day = $data[2];
    switch ($month) {
      case 1:
        $month = "January";
        break;
      case 2:
        $month = "Feburary";
        break;
      case 3:
        $month = "March";
        break;
      case 4:
        $month = "April";
        break;
      case 5:
        $month = "May";
        break;
      case 6:
        $month = "June";
        break;
      case 7:
        $month = "July";
        break;
      case 8:
        $month = "August";
        break;
      case 9:
        $month = "September";
        break;
      case 10:
        $month = "October";
        break;
      case 11:
        $month = "November";
        break;
      case 12:
        $month = "December";
        break;
      default:
        $month = "May'";
        break;
    }

    
    switch ($day) {
      case 1:
        $day = '1st';
        break;
      case 2:
        $day = '2nd';
        break;
      case 3:
        $day = '3rd';
        break;
      default:
        $day = $day.'th';
        break;
    }
    return $day . " " . $month . " " . $year;
 }

function getPasswordHash($password) {
  global $user_salt;
  $password = base64_encode($password);
  $password = strrev($password);
  $password = md5($password);
  $password = strrev($password);
  $password = md5($password . $user_salt);
  return $password;
}


function redirectPage($page) {
  if (!empty($page)) { 
    $redirectTime = 0;
    echo "<meta http-equiv='refresh' content='".$redirectTime.";url=". $page ."'>";

  }
}

function getSegment($name) {
  include("includes/" . $name . ".php");
}

function lookup($string){

 $string = str_replace (" ", "+", urlencode($string));
 $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$string."&sensor=false";
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $details_url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 $response = json_decode(curl_exec($ch), true);
   // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
 if ($response['status'] != 'OK') {
  return null;
}


$geometry = $response['results'][0]['geometry'];

$longitude = $geometry['location']['lat'];
$latitude = $geometry['location']['lng'];

$array = array(
  'latitude' => $geometry['location']['lng'],
  'longitude' => $geometry['location']['lat'],
  'location_type' => $geometry['location_type'],
  );

return $array;

}
    function msg($message){
    echo $message;
    while (ob_get_level()) ob_end_flush();
    ob_implicit_flush(true);
}


//Report page
function get_item_category(){
  global $tableName;
  $qry = mysqli_query($GLOBALS['mysqli'], "Select * from " . $tableName['itemCategory']);
  $stock = array(); 
  while($row = $qry->fetch_array(MYSQLI_ASSOC)) {
    array_push($stock, $row);
  }
  return $stock;
}
//Report page
function get_item_incoming_outgoing( $item_cat_id ){
  global $tableName;
  $qry = mysqli_query($GLOBALS['mysqli'], "Select * from ". $tableName['itemAccount']. " as itemAccount
    JOIN ". $tableName['item']." as item
    ON itemAccount.item_id = item.item_id 
    WHERE item.item_cat_id= ". $item_cat_id );
  
  $incoming = NULL;
  $outgoing = NULL;
  while( $row = $qry->fetch_array( MYSQLI_ASSOC )){

    switch( $row['item_direction']){
      case 'ins': 
      $incoming+= $row['delta_qty'];
      break;
      case 'in':
      $incoming+= $row['delta_qty'];
      break;
      case 'out':
      $outgoing += abs($row['delta_qty']);
      break;
      case 'dl':
      break;
      default:
      $outgoing ='N/A';
      $incoming = 'N/A'; break;
    }
    
  }
  
  if( empty( $incoming ) ){
    $incoming = 'N/A';
  }

  if( empty( $outgoing ) ) {
    $outgoing = 'N/A';
  }
  $stockRate = array('incoming'=>$incoming, 'outgoing'=>$outgoing );
  
  return $stockRate;
}



function debug_data( $data ) {
  //echo "<pre class='hidden'>"; print_r( $data ); echo "</pre>"; 
}
function get_warehouses(){
  global $tableName;
  $qry = mysqli_query($GLOBALS['mysqli'], "Select * from " . $tableName['warehouse']);
  $warehouse = array(); 
  while($row = $qry->fetch_array(MYSQLI_ASSOC)) {
    array_push($warehouse, $row);
  }
  return $warehouse;
}

function get_warehouse_stocks( $warehouse_id ){
  global $tableName;
  $qur = "SELECT * from ". $tableName['item']. " as items 
    JOIN ".$tableName['itemCategory']. " itemCategory
    ON items.item_cat_id = itemCategory.item_cat_id 
    JOIN ( select * from ". $tableName['itemAccount']. " ORDER by item_account_id ASC) as itemAccount
    ON items.item_id = itemAccount.item_id
    WHERE items.w_id =".$warehouse_id;
  $qry = mysqli_query($GLOBALS['mysqli'], $qur);
  // die();
  $warelists = array();

  while( $row = $qry->fetch_array( MYSQLI_ASSOC ) ) {
// debug_data($row);

    if( empty( $warelists[ $row['item_cat_name'] ]) ){
      $warelists[ $row['item_cat_name'] ] = array();

    }
    array_push( $warelists[ $row['item_cat_name'] ], $row );

  }

  return $warelists;

}

$formats = array(
    "/^[0-9]{10}$/", // 5555555555
    "/^[0-9]{9}$/" //014491234

    );

function checkPhoneNumber( $phone_number ) {

 return 1;


/*
  if(strlen($phone_number)>6 && is_numeric($phone_number) ) 
    return 1;
  else 
    return 0;
  */

  }

  function stock_history( $stock ){

    switch( $stock['item_direction'] ){

      case 'ins': 
      $adding+= $stock['delta_qty'];

      return '<li>' .$adding.' '.$stock['item_unit'].' <strong>'.$stock['item_name']. '</strong> Added on <span>'. date('F j, Y', strtotime($stock['item_account_date'])).'</strong></li>';
      break;
      
      case 'in':
      $incoming += $stock['delta_qty'];
      return '<li>' .$incoming.' '.$stock['item_unit'].' <strong>'.$stock['item_name']. '</strong> Added on <span>'. date('F j, Y', strtotime($stock['item_account_date'])).'</strong></li>';
      break;
      
      case 'out':
      $outgoing += abs($stock['delta_qty']);
      return '<li>' .$outgoing.' '.$stock['item_unit'].' <strong>'.$stock['item_name']. '</strong> Dispatched on <span>'. date('F j, Y', strtotime($stock['item_account_date'])).'</strong></li>';
      break;
      
      case 'dl':
      return '<li><strong>'.$stock['item_name']. '</strong> Removed <span> on '. date('F j, Y', strtotime($stock['item_account_date'])).'</strong></li>';
      break;

      default:
      return '<li>N/A</li>';
      break;
    }

  }
  function curPageURL() {
   $pageURL = 'http';
   if ($_SERVER["HTTPS"] == "on") {
    $pageURL .= "s";
  }
  $pageURL .= "://";
  $pageURL .= $_SERVER["SERVER_NAME"] . strtok($_SERVER["REQUEST_URI"],'?');
  $pageParameters = $_SERVER['QUERY_STRING'];
  $ary = explode('&', $pageParameters);
  $param = "";
  $i = 0;
  foreach ($ary as $pageParameter) {
    if(!strstr($pageParameter,'page') && $pageParameter != "") {
      if($i++ == 0)
        $param .= "?";
	else
$param .="&";
      $param .= $pageParameter;
    }
  }
  return $pageURL . $param;
}
function generatePackageId() {
  $unique = 0;
  $pkgid = "";
  while(!$unique) {
    $a = mt_rand(10000,99999);
    $pkgid = crypt($a . date('Ymdhis'),"pk");
    //$pkgid= mysqli_real_escape_string($mysqli, $pkgid);
    $qur = mysqli_query($GLOBALS['mysqli'], "SELECT * FROM package WHERE pkg_id = '$pkgid'");
    if(mysqli_num_rows($qur) == 0)
      $unique = 1;
  }
  return $pkgid;
}
function paginate($total, $pagenum, $tableName, $whereCondition) {
  $getPage = curPageURL();
  $separator = (!strstr($getPage,'?')) ? '?' : '&';
  $prevPage = "";
  $nextPage = "";
  if(!$total){
  $qur ="select * from ". $tableName . " ". $whereCondition;
//  die($qur);
  $qur = mysqli_query($GLOBALS['mysqli'], $qur) or die($qur . " " .mysqli_error());
  $total = mysqli_num_rows($qur);
  }
  if($pagenum > 1) {
    $prevPage .= '<span class="pull-left"><a href="' . $getPage . $separator . 'page=' . intval($pagenum - 1) . '">Prev</a></span>';
  }
  if(($pagenum * 50) < $total+1) {
    $nextPage .= '<span class="pull-right"><a href="' . $getPage . $separator . 'page=' . intval($pagenum + 1) . '">Next</a></span>';
  }
  echo '<div class="paginate">' . $prevPage . $nextPage . '</div>';
}

function enqueueScripts(){
  ob_start(); ?>
  
  <?php 
  echo ob_get_clean();
}
function displayMsg() {
  if($_SESSION['logs']['msgLoc'] == $_SESSION['page']) {
    $class = ($_SESSION['logs']['status']) ? 'success-msg' : '';
      echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'
      .nl2br($_SESSION['logs']['msg']).'</div>';
    
  }

  unset($_SESSION['logs']['msg']);
  unset($_SESSION['logs']['status']);
  unset($_SESSION['logs']['msgLoc']);
}
function mysql_query($query){
  return mysqli_query($GLOBALS['mysqli'], $query);
}

?>
