<?php 
session_start();
include '../../system/config.php';
include '../../system/functions.php';
?>

<?php 
if(isset($_POST["itemQty"])){
	if(isset($_POST["action"])){
		$action=mysql_real_escape_string($_POST["action"]);
		if($action=="update")
        {
			$itemId=mysql_real_escape_string($_POST["itemId"]);
			$itemName= mysql_real_escape_string($_POST["itemName"]);
			$itemQty = mysql_real_escape_string($_POST["itemQty"]);
			$itemUnit = mysql_real_escape_string($_POST["itemUnit"]);
			$type = mysql_real_escape_string($_POST["type"]);
			$warehouse = mysql_real_escape_string($_POST["warehouse"]);
			$prevQty = mysql_real_escape_string($_POST["prevQty"]);
			$qur="select count(*) from ". $tableName['item']." where item_name='".$itemName."'";
			$result = mysql_query($qur) or logMsg($qur . " ".mysql_error(),1); 
			if( mysql_num_rows($result) ){
				while( $row = mysql_fetch_array($result) ){
					$count=$row[0];
				}
			}
			if($count==0){
				if($prevQty>$itemQty)
					$dir = "out";
				elseif($prevQty<$itemQty)
					$dir = "in";

				$qur = "Update ". $tableName["item"]." SET item_name='$itemName',item_qty='$itemQty',item_unit='$itemUnit',
                w_id='$warehouse',item_cat_id='$type' where item_id='$itemId' ";
				mysql_query($qur) or die($qur . " " . mysql_error());
				$qur = "Insert into ". $tableName["itemAccount"]." values(null,now(),$itemId,'$dir',($itemQty-$prevQty))";
				mysql_query($qur) or die($qur . " " . mysql_error());
				logMsg("Stock updated sucessfully",1);
			}
			else{
				logMsg("Duplicate Item name",0);
			}
			return redirectPage($_SERVER['HTTP_REFERER']);
		}
		else if($action=="create")
        {
			$name = mysql_real_escape_string($_POST["itemName"]);
			$qty = mysql_real_escape_string($_POST["itemQty"]);
			$unit = mysql_real_escape_string($_POST["itemUnit"]);
			$type = mysql_real_escape_string($_POST["type"]);
			$warehouseNo = mysql_real_escape_string($_POST["warehouse"]);

			if($qty<1 || strlen(trim($name))<=1 || !is_numeric($qty))
				logMsg("Error in data entry",0);
			else
            {

              if( !itemExists($name,$warehouseNo) )
                  {  //Only insert if new if the item doesn't exists
                      $name = strtolower(trim($name));
                      $qur = "Insert into ". $tableName["item"]." values (null,'$name',$qty,'$unit','$warehouseNo','$type')";
                      if( mysql_query($qur) )
                          logMsg("Entry sucessfully added!",1);
                      else
                         echo "Error : " . mysql_error();

                      $lastEntryId = mysqli_insert_id();

                      $qur = "Insert into ". $tableName["itemAccount"]." values (null,now(),'$lastEntryId','ins',$qty)";
                       mysql_query($qur) or die($qur . mysql_error());
                   }
             else
                    logMsg("Item already exists. Please, choose a different item name.",0);

            }

            redirectPage($_SERVER['HTTP_REFERER']);
                }
            }
        }
elseif(isset($_GET["action"]) ){
	$action = mysql_real_escape_string($_GET["action"]);
	$itemId = mysql_real_escape_string($_GET["id"]);
	$type = mysql_real_escape_string($_GET["typeid"]);


	if($action == "delete") {
		$name = mysql_real_escape_string($_GET["name"]);
		$qty = 	 mysql_real_escape_string($_GET["qty"]);

			$qur = "Delete from ". $tableName["item"]." where item_id = '$itemId'";	 // First delete from item table
			mysql_query($qur) or die($qur . " " . mysql_error());
            
			$qur = "Insert into ". $tableName["itemAccount"]." values(null,now(),$itemId,'dl',-$qty)";	

			mysql_query($qur) or die($qur ." " .mysql_error());
			
			logMsg("Item deleted from the stock",1);

		}
		elseif($action == "update") {
			$qty= mysql_real_escape_string($_GET["qty"]);
			$prevQty = mysql_real_escape_string($_GET["prevQty"]);
			if(!is_numeric($qty)){
				logMsg("Quantiy cannot contain letters",0);
				return redirectPage($_SERVER['HTTP_REFERER']);
			}
			if($prevQty>$qty)
				$dir = "out";
			elseif($prevQty<$qty)
				$dir = "in";

			$qur = "Update ". $tableName["item"]." SET item_qty=$qty where item_id=$itemId ";	
			
			mysql_query($qur) or die($qur . " " . mysql_error());

			
			$qur = "Insert into ". $tableName["itemAccount"]." values(null,now(),$itemId,'$dir',($qty-$prevQty))";	

			mysql_query($qur) or die($qur . " " . mysql_error());
			logMsg("Stock updated sucessfully",1);
		}
		redirectPage($_SERVER['HTTP_REFERER']);
	}

	function itemExists($itemName,$warehouseNo){
		
		global $tableName;

		$itemName = strtolower($itemName);
		$qur = "select * from ". $tableName['item']. " where item_name='$itemName' and w_id=$warehouseNo";

		
		if( $result = mysql_query($qur) ){
			
			if(mysql_num_rows($result) != 0)
	    		return 1; 						// Item does exists
	    	else 
	    		return 0;
	    }

	}

	?>
