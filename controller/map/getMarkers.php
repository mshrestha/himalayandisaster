<?php
include "../../system/config.php";
?>
<?php

    if(isset($_POST)){
        $status = $_POST["mission_status"] ;
        $res = mysql_query("select * from package where pkg_status = 2") or die(mysql_error());
        if(mysql_num_rows($res)>0){
            $main = array();
            while($row = mysql_fetch_array($res)){
                $ary = array();
                $ary["mission"]=$row["pkg_id"];
                $ary["mission_date"]=$row["pkg_timestamp"];
                $hold = explode(',',$row["help_call_latlng"]);
                $ary["lat"]= $hold[0];
                $ary["lng"]= $hold[1];
                array_push($main,$ary);
            }
            $main = json_encode($main);
            echo $main;
        }
    }
?>
