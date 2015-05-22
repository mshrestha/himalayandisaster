
<?php
include("../system/config.php");
$qryArray = array();
$queries = array();
/* Samarpan Bro array_push here */
$queries[0] = "Select * from warehouse;";
foreach ($queries as $query)
  array_push($qryArray,$query);


foreach($qryArray as $qry) {
  $query = mysql_query($qry) or die(mysql_error());
  if($query) echo "<br/>Successfully runned <br/>" . $qry . "<br/> by <b>Samarpan</b> Good job Babu"; else "<br/>Call Samarpan";
}
echo "<br/>Ok Samarpan that's it :)";
?>
