<?php 
include "../../includes/adminIncludes.php";
include "../../system/functions.php" ;
include "../../system/config.php";
?>

<?php 

	if(isset($_GET["action"]))
	{	
		
		
		$action = mysql_real_escape_string($_GET["action"]);
		$packageId = mysql_real_escape_string($_GET["pkg_id"]);

		if($action=="remove") // Delete the package from the order page
		{ 
			$qur="select * from ". $tableName['package']." where pkg_id='".$packageId."'";
			$result = mysql_query($qur) or logMsg($qur . " ".mysql_error(),1); 
			if( mysql_num_rows($result) ){
				while( $row = mysql_fetch_array($result) ){
					if($row["pkg_approval"]=="0"){
						logMsg( "Approved Package cannot be deleted. It is already approved" ,0);
						redirectPage($_SERVER['HTTP_REFERER']);
					}
				}
			}
//				$qur = "Delete from ". $tableName['itemCluster'] . " where pkg_id='".$packageId."'";
//					mysql_query($qur) or logMsg($qur . " ".mysql_error(),0);  
            
            //Don't delete from the cluster because we might need it in the future for reference
				$qur = "Update ". $tableName['package'] . " SET pkg_status=-1 where pkg_count='".$packageId."'";
					mysql_query($qur) or logMsg($qur . " ".mysql_error(),0); 
              
                return redirectPage($_SERVER['HTTP_REFERER']);
            
		}
		else if($action=="approve") // Approve the package from the order page
		{
			

			$qur="select * from ". $tableName['package']." where pkg_count='".$packageId."'";
			$result = mysql_query($qur) or die($qur . " ".mysqli_error()); 

			if( mysqli_num_rows($result) ){
				while( $row = mysql_fetch_array($result) ){
					if($row["pkg_approval"]!="1"){
						logMsg("Package Already Approved",0);
						redirectPage($_SERVER['HTTP_REFERER']);
					}
				}
			}
			$qur = "select a.cluster_item_qty,b.item_qty from ". $tableName['itemCluster']." a,". $tableName['item'] ." b where a.pkg_id='".$packageId."' and a.item_id=b.item_id";
			
			$result = mysql_query($qur) or die($qur . " ".mysqli_error()); 
			if( mysql_num_rows($result) ){
				while( $row = mysql_fetch_array($result) ){
					$itemClusterQty=$row["cluster_item_qty"];
					$itemQty=$row["item_qty"];
					if($itemQty<$itemClusterQty){
						logMsg("Stock Empty",0);
						redirectPage($_SERVER['HTTP_REFERER']);
					}
				}
			}
				$qur="update ". $tableName['package']." set pkg_approval='1' where pkg_count='".$packageId."'";
				
				mysql_query($qur) or die($qur . " ".mysql_error()); 
			
				$qur = "select a.item_id,a.cluster_item_qty,b.item_qty from ". $tableName['itemCluster']." a,". $tableName['item'] ." b where a.pkg_id='".$packageId."' and a.item_id=b.item_id";
				
				$result = mysql_query($qur) or die($qur . " ".mysql_error()); 
				if( mysql_num_rows($result) ){
				while( $row = mysql_fetch_array($result) ){
					$itemId=$row["item_id"];
					$itemClusterQty=$row["cluster_item_qty"];
					$itemQty=$row["item_qty"];
					$itemRemain=$itemQty-$itemClusterQty;
					// echo "Item Remain:".$itemRemain;
					$itemUpdateQuery="update ". $tableName['item']." set item_qty='".$itemRemain."' where item_id='".$itemId."'";
					// echo "Update query:". $itemUpdateQuery;
					mysql_query($itemUpdateQuery) or logMsg($itemUpdateQuery . " ".mysql_error(),0); 

					$itemAccountQuery="Insert into ". $tableName['itemAccount']." values (null,now(),'$itemId',
															'out','-$itemQty')";
					if( mysql_query($itemAccountQuery) )
						logMsg("Package Has Been Approved",1);
					else
						logMsg("Error : " . mysql_error(),0);
				}
			}
		}
	
		redirectPage($_SERVER['HTTP_REFERER']);

	}
?>