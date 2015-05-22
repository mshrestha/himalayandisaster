
<?php
session_start();
include("system/config.php");
include("system/functions.php");
//include("includes/header.php");


//$_SESSION['page'] = "listpackage";


//Body Begins
?>
<div class="wrapper-mission">
	<?php 
	if(isset($_GET["id"]) ){
		$packageId = mysql_real_escape_string($_GET["id"]);
        $result = mysql_query("Select * from ". $tableName['package'] ." where pkg_count='$packageId'");
        $result = mysql_fetch_array($result);
        if($result['pkg_status']!= -1){
	?>
    
	
            
			
            
            <div class="col-lg-12">
    <div class="panel panel-info">
        <div class="panel-heading"><strong><i class="fa fa-building-o"></i> Mission Details</strong> 
            
            <?php if($approveStatus == 1): ?>
                <span class="badge badge-success">Approved</span>
            <?php endif; ?>
        </div>
        <div class="panel-body">
            <?php $packageQry = "select a.pkg_id,a.pkg_approval,a.pkg_timestamp,w.w_name,a.help_call_latlng,b.vdc_name,b.district,c.agent_name,c.agent_email,c.agent_phone from ". $tableName['package'] ." a," . $tableName['vdc'] . " b," .$tableName['agent']. " c," .$tableName['warehouse'] ." w where a.agent_id=c.agent_id and a.help_call_id=b.vdc_code and w.w_id=a.w_id and a.pkg_count='".$packageId."'";
				$packageResult= mysql_query($packageQry);
				if(mysql_num_rows($packageResult) >=1){
					while ($row = mysql_fetch_array($packageResult)):
                    
					    $approveStatus=$row["pkg_approval"];
                        $latlng = $row["help_call_latlng"];
					?>
            
            
            <h2><?php echo $row["vdc_name"];?>, <?php echo $row["district"];?></h2>
            <table class="record_properties">
            <tbody>
            
            
            <tr>
                <th>Date</th>
                <td><?php echo $row["pkg_timestamp"];?></td>
            </tr>
            <tr>
                <th>Mission Name</th>
                <td><?php echo $row["pkg_id"]; ?></td>
            </tr>
            <tr>
                <th>Group/Organization</th>
                <td><?php echo ucfirst($row["w_name"]);?></td>
            </tr>
            <tr>
                <th>Volunteer Name</th>
                <td><?php echo ucfirst($row["agent_name"]);?></td>
            </tr>
            <tr>
                <th>Volunteer Phone</th>
                <td><?php echo $row["agent_phone"];?></td>
            </tr>
            
        </tbody>
    </table>
            <br />
            <?php if($approveStatus=='0'): ?>
   <a href="<?php echo $config['adminController'].'/itemAccountController.php?action=approve&pkg_id='.$packageId;?>"><button type="button" class="btn btn-xs btn-success btn-lg"><i class="fa fa-plus"></i>Approve</button> </a> 
						<a href="<?php echo $config['adminController'].'/itemAccountController.php?action=remove&pkg_id='.$packageId;?>"><button type="button" class="btn btn-xs btn-warning btn-lg"><i class="fa fa-minus"></i>   Delete</button> </a>
          
            <?php endif; ?>
            <?php endwhile; ?>
            <br />
            <hr />
            <h2>Item List</h2>
            <?php
                    $pkg_id = "Select pkg_id from ".$tableName['package']." where pkg_count=$packageId";
                    $pkg_id = mysql_query($pkg_id) or die($pkg_id . mysql_error());
                    $pkg_id = mysql_fetch_array($pkg_id);
					$itemQry = "select * from ". $tableName['itemCluster'] . " where pkg_id='".$pkg_id['pkg_id']."'";
					$itemResult= mysql_query($itemQry);

					if(mysql_num_rows($itemResult) >=1){
					?>
						<table cellspacing="5" cellpadding="5 " class="records_list table table-condensed table-hover table-striped">
						<tr><th>Item Name</th><th>Quantity</th><th>Unit</th></tr>
					<?php
					while ($row = mysql_fetch_array($itemResult)):
						?>
						<tr>
							<td><?php echo ucfirst($row["item_name"]); 
                    $result = mysql_query("select item_unit from ".$tableName['item']." where  item_name='".$row["item_name"]."'");
                    $res = mysql_fetch_array($result);
                                ?></td>
							<td>
							<?php
									echo $row["cluster_item_qty"];
							?>
							</td>
                            <td>
                            <?php				
								echo ucfirst($res["item_unit"]) ;
				
							?>
							</td>
						</tr>
					<?php endwhile;
					?>
						</table>
            
        </div>
    </div>
    </div>
    
						
					
					
					
            <?php 		
					}
					else{
						echo "No Items For the Pacakge"; 
						echo "</br><a href=".$config["adminController"]."/itemAccountController.php?action=remove&pkg_id=".$packageId.'>Delete </a>';


					}
				}
				else {
					echo "No Package here";
				}
        
        }
        else 
//            echo "Package has been deleted";
            $message = "Package deleted sucessfully <br>".
                    '<a href="'.$config['adminUrl'].'/listPackage.php">Back</a>';
			echo $message;
        
		}
	?>
</div>


