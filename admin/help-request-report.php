<?php
//Includes
include("../includes/adminIncludes.php");
if(!$_SESSION['name']) {
	header('Location:index.php');
}
include("../system/config.php");
include("../system/functions.php");
$_SESSION['page'] = "help-request-report";
//Body Begins
// include("../includes/topbar.php");
include("../controller/admin/help-request-controller.php");

?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<div class='wrapper'>
	<div>
		<p>Total Help Requests: <?php echo get_total_help_req(); ?></p>
		<p>Total Pending Help Requests: <?php echo get_total_pending_help(); ?></p>
		<p>Total Verified Help Requests: <?php echo total_verified_requests(); ?></p>
		<p>Total Help Requests Responded with packages: <?php echo responded_requests(); ?></p>
	</div>
	
	<p>View help call records of date: <input type="text" id="datepicker"></p>
</div>
<?php//Includes
include("../includes/adminfooter.php");
?>
<script>
	$(function() {
		$( "#datepicker" ).datepicker({maxDate:'today'});
		$( '#datepicker').on('change', function(){
			var date = $( "#datepicker" ).val();
			window.location.href=window.self.location.href+'?date='+date;
		})
	});
</script>
