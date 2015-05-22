<?php
include("../system/config.php");
include("../system/functions.php");

$name = mysql_real_escape_string($_POST['sqlfile']);
mysql_query("Truncate agent_debug") or die(mysql_error());
msg( "Agent Debug Truncated<br/>" );
mysql_query("Truncate item_debug") or die(mysql_error());
msg("Item Debug Truncated<br/>");
mysql_query("Truncate agent_detail_debug") or die(mysql_error());
msg("agent_detail Debug Truncated<br/>");
mysql_query("Truncate item_account_debug") or die(mysql_error());
msg("Item Account Debug Truncated<br/>");
mysql_query("Truncate item_cluster_debug") or die(mysql_error());
msg("Item Cluster Debug Truncated<br/>");
mysql_query("Truncate package_debug");
msg("Package Debug Truncated<br/>");
mysql_query("Truncate item_category_debug");
msg("Package Debug Truncated<br/>");
//system("mysql savenepal < " . $name . " -u ".$usernam." -p".$password."" );
msg("mysql savenepal < " . $name . " -u ".$usernam." -p".$password."");
msg("<br>Sql Imported<br/>");
mysql_query("INSERT INTO `agent`(`agent_type`, `agent_name`, `agent_phone`, `agent_email`, `agent_address`, `agent_organization`, `agent_can_travel`, `agent_duration_available`, `agent_language_known`, `agent_can_provide`, `agent_status`, `agent_deployed_in`) Select `agent_type`, `agent_name`, `agent_phone`, `agent_email`, `agent_address`, `agent_organization`, `agent_can_travel`, `agent_duration_available`, `agent_language_known`, `agent_can_provide`, `agent_status`, `agent_deployed_in` from agent_debug") or die(mysql_error());
msg("Insert into agent <br/>");
mysql_query("INSERT INTO `agent_detail`(`agent_detail_timestamp`, `agent_id`, `agent_name`, `agent_status`, `agent_location`) Select `agent_detail_timestamp`, `agent_id`, `agent_name`, `agent_status`, `agent_location` from agent_detail_debug") or die(mysql_error());
msg("Insert into agent detail<br/>");

mysql_query("INSERT INTO `item_category`(`item_cat_name`) select `item_cat_name` from item_item_category_debug") or die(mysql_error());
msg("Insert into item_category<br/>");

mysql_query("INSERT INTO `item`(`item_name`, `item_qty`, `item_unit`, `w_id`, `item_cat_id`) select `item_name`, `item_qty`, `item_unit`, `w_id`, `item_cat_id` from item_debug") or die(mysql_error());
msg("Insert into item <br/>");
mysql_query("INSERT INTO `item_account`(`item_account_date`, `item_id`, `item_direction`, `delta_qty`) select `item_account_date`, `item_id`, `item_direction`, `delta_qty` from item_account_debug") or die(mysql_error());
msg("Insert into item_account <br/>");
mysql_query("INSERT INTO `item_cluster`(`item_id`, `cluster_item_qty`, `item_name`, `pkg_id`) select `item_id`, `cluster_item_qty`, `item_name`, `pkg_id` from item_cluster_debug") or die(mysql_error());
msg("Insert into item_cluster <br/>");
mysql_query("INSERT INTO `package`(`pkg_id`, `pkg_status`, `pkg_timestamp`, `pkg_approval`, `agent_id`, `help_call_id`, `help_call_latlng`, `w_id`)  select `pkg_id`, `pkg_status`, `pkg_timestamp`, `pkg_approval`, `agent_id`, `help_call_id`, `help_call_latlng`, `w_id` from package_debug") or die(mysql_error());
msg("Insert into package<br/><br/> <br/>");
msg("done!");
?>
