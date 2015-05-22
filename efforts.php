<?php
//Includes
include("system/config.php");
include("system/functions.php");
include("includes/header.php");
$_SESSION['page'] = 'efforts';
//Body Begins
?>
<div class="wrapper">
	<?php getSegment('top'); ?>
	<div class="container">
		<div class="content">
			<span class="form-info">
				<h3>Our Efforts / हाम्रो प्रयास </h3>
				<p>We are trying to accumulate data of organizations involved, the resources they have and where they are deployed so the efforts aren't duplicated</p>	
				<div class="row">
					<div class="col-xs-12 navbar">
						<ul class="nav navbar-nav subnav">
							<li><a href="#!" class="active" id="opt1">RESOURCE INVENTORY <br/> स्रोत सूची </a></li>
							<li><a href="#!" id="opt2">TOTAL LIST OF ALL RESOURCES <br/> सबै स्रोतको कुल सूची </a></li>
						</ul>	
					</div>
				</div>
			</span>
			<div class="opt-content1">
				<span class="form-info">
					<h3>RESOURCE INVENTORY / स्रोत सूची </h3>
				</span>
				<div class="form-component">
					<table>
					<tr>
						<th>Organization Name</th>
						<th>Resource Location</th>
						<th>Resource Details</th>
					</tr>
				<!-- 	<tr>
						<td>Kazi</td>
						<td>Ekantakuna</td>
						<td>adkngaksdgnad</td>
					</tr> -->
					<?php
						$qry = mysql_query("SELECT * FROM " . $tableName['warehouse']); 
						while($row = mysql_fetch_row($qry)):

					?>
					<tr>
						<td><?php echo $row['1']; ?> </td>
						<td><?php echo $row['2']; ?> </td>

						<td>
						<?php

							$qur2 = "select distinct(item_name),item_qty,item_unit from ". $tableName['item']. " where w_id=$row[0]";
							$result = mysql_query($qur2);
							while($row1 = mysql_fetch_row($result)):
						?>
							<?php echo '<b>'.ucfirst($row1[0]) .'</b> ' . $row1[1]. ' '.ucfirst($row1[2]) .'	</br>'; ?>
							<?php endwhile; ?>
						</td>
					</tr>
					<?php endwhile; ?>


						
					
					
				</table>
				</div>
			</div>
			<div class="opt-content2">
				<span class="form-info">
					<h3>TOTAL LIST OF ALL RESOURCES / सबै स्रोतको कुल सूची  </h3>
				</span>
				<div class="form-component">
				<table>
					<tr><th>Resources</th><th>Resource Amount</th><th>Location</th></tr>
					<!--Query runs here loop loop -->
					<?php

					$qry = mysql_query("SELECT * FROM " . $tableName['itemCategory']); 
					while($row = mysql_fetch_array($qry)) :?>
						<tr>
						<td><?php echo ucfirst($row['item_cat_name']); ?> </td>
						<?php
							$resources = "";
							$qry2 = mysql_query("SELECT sum(item_qty) FROM " . $tableName['item'] . " where item_cat_id = $row[0]") or die(mysql_error());
							$row2 = mysql_fetch_array($qry2);
						?>
						<td><?php echo $row2[0]; ?> </td>
						<?php
							$qry3 = mysql_query("SELECT distinct(t2.w_name), w_address, w_email, w_phone FROM " . $tableName['item'] . " as t1, " . $tableName['warehouse'] . " as t2 where t1.w_id = t2.w_id and t1.item_cat_id = $row[0]") or die(mysql_error()); 
							while($row3 = mysql_fetch_row($qry3)) 
								$resources .= "<b>Name:</b>$row3[0]<br/><b>Location:</b>$row3[1]<br/><b>Email:</b>$row[2]<br/><b>Phone:</b>$row3[3]<br/><br/>";
						?>
						<td><?php echo $resources ?> </td>
						</tr>

					<?php endwhile;?>
				</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php //Includes
include("includes/footer.php");
?>
<script type="text/javascript">
	$('#opt2').click(function() {
		$('#opt1').removeClass('active');
		$('#opt2').addClass('active');
		$('.opt-content1').hide();
		$('.opt-content2').show();
	});
	$('#opt1').click(function() {
		$('#opt2').removeClass('active');
		$('#opt1').addClass('active');
		$('.opt-content2').hide();
		$('.opt-content1').show();
	});
</script>