<?php
//Includes
include("../includes/adminIncludes.php");
if(!$_SESSION['name'] || $_SESSION['userrole'] == 2) {
	header('Location:index.php');
}
include("../system/config.php");
include("../system/functions.php");
$_SESSION['page'] = "listpackage";
$page = ($_GET['page']) ? intval($_GET['page']) : 1;
$offset = " OFFSET " . intval((($page - 1 ) * 50));

//Body Begins
?>
<div class="wrapper">
	<?php getSegment("topbar"); ?>
	<div class=" col-sm-12">

		<div class="col-sm-12">
			<h1>Missions</h1>
			
			
			<?php 
			$collectiveWhere = '';
            $anotherWhere = "";
            $searchPart ='';
            $anoOrWhere='';
			$whereCondition = "and a.pkg_approval='1'";
            $ware_which = 'w.w_id=a.w_id';
			$anotherWhere = 'and a.pkg_status!=-1';
            if(isset($_GET)){
				if(trim($_GET['status']) == "0")
	            {
					$whereCondition = "and a.pkg_approval='0'";
				}
				if(trim($_GET['searchWarehouse'])){
					$ware_which=$_GET['searchWarehouse'];
					if($ware_which>0)
						$ware_which = "w.w_id=$ware_which";
				
				}
				}
				
				$qry2 = mysql_query("Select centerid from " . $tableName['admin_login'] . " where username = '$name'");
				$ary  = mysql_fetch_array($qry2);
				if(!empty($ary[0]) ){
					$where="a.w_id=$ary[0] and";
					$ware_which ='';
					}
					else{
						$where="";

				if(isset($_GET['searchName'])){

					$keyword = mysql_real_escape_string($_GET['searchName'] );
					$searchPart = "b.vdc_name like '%".$keyword."%'";
					if(trim($keyword) && $where)
						$searchPart .= " and ";
				}
				if($searchPart)
					$anoOrWhere='and';
		}
			$qur = "select a.pkg_count,w.w_name,a.pkg_id,a.pkg_count,a.pkg_timestamp,a.pkg_approval,b.vdc_name, b.district,c.agent_name,c.agent_email,c.agent_phone
					from ". $tableName['package'] ." a," . $tableName['vdc'] . " b," .$tableName['agent'] ." c,
					  ".$tableName['warehouse']." w where $searchPart $where $anoOrWhere a.agent_id=c.agent_id and a.help_call_id=b.vdc_code and $ware_which  $whereCondition  $anotherWhere order by a.pkg_count DESC LIMIT 50" . $offset;
			$result= mysql_query($qur);
			$count = 1;
    		$totalQuery = "select a.pkg_count,w.w_name,a.pkg_id,a.pkg_count,a.pkg_timestamp,a.pkg_approval,b.vdc_name, b.district,c.agent_name,c.agent_email,c.agent_phone
					from ". $tableName['package'] ." a," . $tableName['vdc'] . " b," .$tableName['agent'] ." c,
					  ".$tableName['warehouse']." w where $searchPart $where $anoOrWhere a.agent_id=c.agent_id and a.help_call_id=b.vdc_code and $ware_which  $whereCondition  $anotherWhere order by a.pkg_count DESC";

			$res= mysql_query($totalQuery);
			$total = mysql_num_rows($res);

			if(mysql_num_rows($result) >=1) { ?>

			
            <div class="row">
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET">
					<select name="status">
						<?php
						if(isset($_GET)){
						if(trim($_GET['status']) == "0"){
							?>
							<option value="0" selected>Pending</option>
							<option value="1">Approved</option>
							<?php
						}
						else{
							?>
							<option value="0">Pending</option>
							<option value="1" selected>Approved</option>
							
							<?php		
						}
					}
						?>
						
					</select>
					   <select name="searchWarehouse" class="">
                        	<option value="">Warehouse</option>
                        <?php 
                        	$selected = trim($_GET['searchWarehouse']);
                        	$res = mysql_query("Select * from ".$tableName['warehouse']);
                        	while ($row = mysql_fetch_array($res)) : ?>
                        	<option <?php if($row['w_id']==$selected) echo"selected";?>
                        	value="<?php echo $row['w_id'];?>"><?php echo $row['w_name'];?></option>	
                        	<?php endwhile ;?>


                        ?>
                    </select>
					<input type="text" class="form-control" name="searchName" placeholder="Enter Name of VDC" value="<?php echo ( !empty($_GET['searchName']) )? $_GET['searchName']:''; ?>" style="width:300px; float:left;">

					<input class="" type="submit" Value="Search" />
				</form>
			</div>
			<table cellspacing="5" cellpadding="5 " class="records_list table table-condensed table-hover table-striped">
				<thead>
                <tr class="success">
					<th>ID</th>
					<th>Created on</th>
					
					<th>Location</th>
					<th>Volunter</th>
					<th>Warehouse</th>
					<th>Phone</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
                    </thead>

				<?php while ($row = mysql_fetch_array($result)):
				?>
				<tr>
					<td><?php echo $row["pkg_count"] ?> </td>
					<td><?php echo $row["pkg_timestamp"]; ?> </td>

					
					<td><?php echo $row["vdc_name"] . ", " . $row["district"];?></td>
					<td><?php echo ucfirst($row["agent_name"]);?></td>
					<td><?php echo $row["w_name"];?></td>
					<td><?php echo $row["agent_phone"];?></td>
					<td>
						<?php
						if($row["pkg_approval"]=="0"){
							?>
							Pending
							<?php
						}
						else{
							?>
							Approved
							<?php	
						}
						?>
					</td>
					<td>
						<a href="<?php echo $config['adminUrl']. '/editPackage.php?id='.$row['pkg_count'];?>">
                        <button type="button" class="btn btn-xs btn-success">Edit</button>
                        </a>
						<a href="<?php echo $config['adminUrl']. '/packageDetail.php?id='.$row['pkg_count'];?>">
                        <button type="button" class="btn btn-xs btn-info">View</button>
                        </a>
					</td>
                    
				</tr>

			<?php endwhile; ?> 
			
			

		<?php 
			}
            else 
            {
                echo "No missions found"; //No missions found of the given search parameter
            }
		?>
	</table>
        
		

	<?php paginate($total, $page, $tableName['package']); ?>

</div>
</div>
</div>
</div>

<?php
//Includes
include("../includes/adminfooter.php");
?>

