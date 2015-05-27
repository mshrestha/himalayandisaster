<?php 
//Includes
include( "../includes/adminIncludes.php"); 
if(!$_SESSION[ 'name'] ) { 
    header( 'Location:index.php');
}
include( "../system/config.php");
include( "../system/functions.php");
$_SESSION['page']="item";
$page=($_GET['page']) ? intval($_GET['page']) : 1;
$offset=" OFFSET " . intval(($page - 1 ) * 50);
//Body Begins
?>
<div class="wrapper">
    <?php getSegment( 'topbar'); ?>
    <div class="col-md-8">

        <div class="row">
            <h1>Stock Inventory</h1>
                    
            <div class="row">
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET">
                    <input type="text" placeholder="Name" name="searchName" />
                    <select name="qtySearch">
                        <option value="">Quantity Search</option>
                        <option value="1">Expired</option>
                        <option value="2">Expiring</option>
                        <option value="3">In Stock</option>
                    </select>
                    <select name="typeSearch">
                        <option value="">Stock Type</option>
                        <?php getSegment( 'stock'); ?>
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
                    <input class="" type="submit" Value="Search" />
                </form>
            </div>
            <br />
            <div class="row">
                <table cellspacing="5" cellpadding="5 " class="records_list table table-condensed table-hover table-striped">

                    <thead>
                        <tr class="success">
                            <th>Name</th>
                            <th>Current Quantity</th>
                            <th>Blocked Quantity</th>
                            <th>Unit </th>
                            <th>Warehouse Name</th>
                            <th>Item Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <?php //Search Condition 
                            $whereCondition="" ; 
                            if(trim($_GET[ 'searchName']) !="" || trim($_GET[ 'searchWarehouse']) !="" ||
                               trim($_GET[ 'typeSearch'] !="" ) || trim($_GET[ 'qtySearch'] !="" ))
                            {
                                $whereCondition=" where item_id > 0 " ; 
                            }
                            if(trim($_GET[ 'searchName']) !="" )
                            {
                                $name=mysql_real_escape_string(urldecode($_GET[ 'searchName'])); 
                                $whereCondition .=" and item_name like '%$name%' " ;
                            }
                            if(trim($_GET[ 'searchWarehouse']) !="" ) 
                            { 
                                $cid=mysql_real_escape_string(urldecode($_GET[ 'searchWarehouse'])); 
                                $whereCondition .=" and w_id = '$cid' " ;
                            } 
                            if(trim($_GET[ 'typeSearch']) !="" )
                            { 
                                $tid=mysql_real_escape_string(urldecode($_GET[ 'typeSearch']));
                                $whereCondition .=" and item_cat_id = '$tid' " ; 
                            } 
                            if(trim($_GET[ 'qtySearch']) !="" ) 
                            {
                                $qid=mysql_real_escape_string(urldecode($_GET[ 'qtySearch']));
                                switch ($qid) 
                                { 
                                    case '1': $whereCondition .=" and item_qty <= '0' " ; break;
                                    case '2': $whereCondition .=" and item_qty <= '10' " ; break;
                                    case '3': $whereCondition .=" and item_qty > '10' " ; break;
                                    default: $whereCondition .=" and item_qty > '10' " ; break; }
                                }
                            if($_SESSION[ 'userrole']==2 ) 
                            {
                                $name=$_SESSION[ 'name']; 
                                $qry2=mysql_query( "Select centerid from " . $tableName[ 'admin_login'] .
                                                  " where username = '$name'");
                                $ary=mysql_fetch_array($qry2);
                                if($whereCondition=="" )
                                { $whereCondition=" where item_id > 0 " ; } $whereCondition .=" and w_id = $ary[0]";
                                //getting the blocked quantity of items
                                $BlockedQuery="select * from " . $tableName[ 'package'] . " where w_id=$ary[0]";
                                $pkg_ids=mysql_query($BlockedQuery) or die(mysql_error());
                                $pkg_avail=0;
                                if(mysql_num_rows($pkg_ids)>0)
                                {
                                    $pkg_avail=1; 
                                    $mainAry = array();
                                    while($result = mysql_fetch_array($pkg_ids) )
                                    {
                                        $qur = "select item_id,cluster_item_qty from item_cluster
                                                    where pkg_id='".$result['pkg_id']."'";
                                        $result = mysql_query($qur);
                                        while($row = mysql_fetch_assoc($result))
                                        {
                                        $ary = array();
                                         $ary[$row["item_id"]] = $row["cluster_item_qty"];
                                         array_push($mainAry, $ary);
                                        }
                                    }
                                }
                            }
                            $qur = "select * from ". $tableName['item'] . $whereCondition .
                                " order by item_id LIMIT 50" . $offset; $result= mysql_query($qur);
                            while ($row = mysql_fetch_array($result)): ?>
                        <tr>
                            <td>
                                <?php echo parseName($row[ "item_name"]); ?>
                            </td>
                        <td>
                            <input type="text" value="<?php echo $row['item_qty'];?>" size="4" id="type<?php echo $row[0];?>" />&nbsp;

                            <?php if($role !=1 ) { ?>
                            <span style="cursor:pointer;" 
                                  onclick="runUpdate(<?php echo $row['item_id']; ?>,<?php echo  $row['item_qty']; ?>)"
                                >
                                <button type="button" class="btn btn-xs btn-info">Update</button>                                                               </span>
                            <?php } ?>

                        </td>
                        <td>
                            <?php $blockedQty=0; ?>
                            <?php if($_SESSION[ 'userrole']==2 && $pkg_avail==1)
                            {
                                for($i=0;$i<count($mainAry);$i++)
                                {
                                    $singQty=$mainAry[$i][$row[ 'item_id']]; 
                                    if($singQty)
                                    {
                                        $blockedQty +=intval($singQty); 
                                    }
                                }
                                echo $blockedQty; 
                            }
                                else echo "N/A"; 
                            ?>
                        </td>

                        <td>
                            <?php echo parseName($row[ 'item_unit']); ?>
                        </td>
                        <td>
                            <?php
                            $qry2=mysql_query( "Select w_name from " . $tableName['warehouse'] . " where w_id = " . $row['w_id']);                                   $row2=mysql_fetch_assoc($qry2);
                            echo $row2['w_name'];?>
                        </td>
                        <td>
                            <?php 
                            $qry2=mysql_query( "Select item_cat_name from " . 
                            $tableName['itemCategory'] . " where item_cat_id = " . $row[ 'item_cat_id']);                                                       $row2=mysql_fetch_array($qry2);
                            echo parseName($row2['item_cat_name']);
                            ?>
                        </td>
                        <td>

                            <a href="<?php echo $config['adminUrl']?>/editItems.php?id=<?php echo $row["item_id"];?>">
                                <button type="button" class="btn btn-xs btn-success">Edit</button>
                            </a>
                            <a href="<?php echo $config['adminController']?>/itemController.php?id=<?php echo $row["item_id"] . 
                                '&qty=' . $row['item_qty']; ?>&action=delete">
                                <button type="button" class="btn btn-xs btn-warning">Delete</button>
                            </a>
                        </td>
                    </tr>

                    <?php endwhile;?>

                </table>
                <?php paginate($total, $page, $tableName['item'], $whereCondition); ?>
            </div>
        </div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-2">
      <?php displayMsg(); ?>
        <div class="row">
            <h4>Add new Item</h4>
            
            
            <form method="POST" action="<?php echo $config['adminController'];?>/itemController.php">
                <input placeholder="Item Name" class="form-control" required="required" type="text" name="itemName" />
                <input placeholder="Item Quantity" class="form-control" required="required" type="text" name="itemQty" />
                <input placeholder="Item Unit" class="form-control" required="required" type="text" name="itemUnit" />
                <select name="type" class="form-control" required="required">
                    <option value="">Stock Type</option>
                    <?php getSegment( 'stock'); ?>
                </select>
                <select name="warehouse" class="form-control" required="required">
                    <option value="#">Warehouse</option>
                    <?php getSegment( 'warehouse'); ?>
                </select>
                <input class="form-control" type="hidden" name="action" Value="create" />
                <input class="form-control" type="submit" Value="Add" />
            </form>
        </div>
    </div>
</div>
<?php include( "../includes/adminfooter.php"); ?>
<script type="text/javascript">
    function runUpdate(ids, prevqty) {
        var value = $('#type' + ids).val();
        if (prevqty != value) {
            window.location = "<?php echo $config['adminController'];?>" + "/itemController.php?id=" + ids + "&action=update&qty=" + value + "&prevQty=" + prevqty;
        } else {
            alert("Same Quantity as before");
        }
    }
</script>