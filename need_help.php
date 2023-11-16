<?php
//Includes
include("system/config.php");
include("system/functions.php");

$_SESSION['page'] = 'ineedhelp';
//Body Begins
?>
<div class="wrapper">
	
	<div class="container">
		<div class="content">
			<span class="form-info">
				<h3>I Need Help / मलाई सहायता चाहिन्छ</h3>
				<p>Please  give us the details listed below so we can help.</p>	
			</span>
			<div class="form-component">
				<form method="POST" action="<?php echo $config['controller'];?>/helpController.php ">
				<label>Full Name / पुरा नाम </label><input type="text" name="name" class="form-group" /><br />
				<label>Phone Number / फोन नम्बर</label><input type="text" name="phonenumber" class="form-group" /><br />
				<label>Location help is needed (village, district) / स्थान (गाँउ / जिल्ला)</label><input type="text" name="location" class="form-group" />
				<label>What do you need? / तपाईंलाई के चाहिन्छ <br/>Please check what you need / तपाईंलाई के चाहिन्छ चिन्ह लगाउनुहोस </label><br />
				<div class="row">
					<div class="col-lg-12">
						<label><input name="needType[]" type="checkbox" class="form-group" value="water" /> Water / पानी</label>
						<label><input name="needType[]" type="checkbox" class="form-group" value="medicine" /> Medicine / औखधि </label>
						<label><input name="needType[]" type="checkbox" class="form-group" value="tent" /> Tent / पाल</label>
					</div><br />
					<div class="col-lg-12">
						<label><input name="needType[]" type="checkbox" class="form-group" value="food" /> Food / खाना</label>
						<label><input name="needType[]" type="checkbox" class="form-group" value="doctors" /> Doctors / डाक्टर</label>
						<label><input name="needType[]" type="checkbox" class="form-group" value="volunteer" /> Volunteer Clean up / स्वयंसेवी</label>
					</div>
					<div class="col-lg-12">
						<label> Other Information (please write Location and need information) / अन्य</label><br />
						<textarea style="width: 400px;" name="description" class="form-group leftshift"></textarea>
					</div>
					<input type="hidden" name="help-type" value="help-want-guest"/>
					<input type="submit" value="SUBMIT" class="blackbtn" />
				</div>
				
			</form>
			</div>
		</div>
	</div>
</div>
<?php
//Includes
include("includes/footer.php");
?>





