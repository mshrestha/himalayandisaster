<?php
//Includes
include("../includes/adminIncludes.php");
if(!$_SESSION['name']) {
	header('Location:index.php');
}
include("../system/config.php");
include("../system/functions.php");
$_SESSION['page'] = "reports";
//Body Begins

// debug_data(get_warehouse_stocks( get_warehouses()[0]['w_id'] ) );
?>
<div class="wrapper">
	<?php getSegment("topbar"); ?>
	<div class="col-sm-12">
		<!-- Discrete Report -->
		<div class="col-sm-8">
			<h3>Warehouse stock Report</h3>
			<?php $warehouses = get_warehouses(); ?>
			<?php foreach( $warehouses as $warehouse): ?>
				<div class="row orgitems">
					<h4><?php echo $warehouse['w_name']; ?></h4>
					<?php $warehouse_stock_items = get_warehouse_stocks( $warehouse['w_id'] ); ?>
					<?php if( empty( $warehouse_stock_items ) ) echo 'There are no aid stocks.'; ?>
					<?php foreach( $warehouse_stock_items as $stock_type=>$warehouse_items): ?>
						<div class="items">
							<h5><u><?php echo $stock_type; ?></u></h5>
							<ul class="list-unstyled">
								<?php 
								if(empty($items)){ 'There are no items.'; }

								foreach( $warehouse_items as $items): echo stock_history($items);	?>
								<?php endforeach;?>
							</ul>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<!-- Overall report -->
		<div class="col-sm-4">
			<h3>Over all stock Report</h3>
			<table>
				<tr><th>Aid Category</th><th>Incoming</th><th>Outgoing</th></tr>

				<?php $item_category = get_item_category();
				// debug_data($item_category);

				foreach( $item_category as $category ):

					$flowRate = get_item_incoming_outgoing( $category['item_cat_id'] );
				?>
				<tr><td><?php echo ucfirst($category['item_cat_name']); ?></td><td><?php echo $flowRate['incoming']; ?></td><td><?php echo $flowRate['outgoing']; ?></td></tr>
			<?php endforeach; ?>
		</table>
	</div>

</div>
</div>
<?php
//Includes
include("../includes/adminfooter.php");
?>


