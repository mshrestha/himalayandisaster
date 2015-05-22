<?php
//Includes
session_start();
include("system/config.php");
include("system/functions.php");
include("includes/header.php");

$_SESSION['page'] = 'iwanttohelp';
//Body Begins

?>
<div class="wrapper">
	<?php getSegment('top'); ?>
	<div class="container">
		<div class="content">
			<span class="form-info">
				<h3>I want to Help / मलाई सहायता चाहिन्छ</h3>
				<p>Please  give us the details listed below so we can reach out to you</p>	
			</span>
			<div class="form-component">
				<?php displayMsg();?>
				<form method="POST" action="<?php echo $config['controller'];?>/helpController.php ">
					<label>Full Name / पुरा नाम </label>
					<input type="text" name="name" class="form-group" required="required" />
					<label>Phone Number / फोन नम्बर</label>
					<input type="text" name="phonenumber" class="form-group" />
					<label>Email / ईमेल</label>
					<input type="email" name="email" class="form-group"/>
					<label>Type of Volunteer / स्वयंसेवक को प्रकार</label>
					<label><input type="radio" name="volunteer-type" value="technical"class="form-group" /> Technical Support / डिजिटल</label>
					<label><input type="radio" name="volunteer-type" value="ground" class="form-group" /> Field work / भू काम</label>
					<label><input type="radio" name="volunteer-type" value="resources" class="form-group" /> Provide Resource / स्रोत</label>

					<label>Current Location / वर्तमान स्थान</label>
					<input type="text" name="location" class="form-group" required="required" />
					<label>Willing to Travel / यात्रा गर्न इच्छुक</label>
					<label><input type="radio" name="travel" value="yes" class="form-group" /> Yes / हो</label>
					<label><input type="radio" name="travel" value="no" class="form-group" /> No / होइन</label>
					<label>Duration Available for? / उपलब्ध अवधि?</label>
					<input type="text" name="availability" class="form-group" />
					<label>Languages Known (Separate by comma)/ भाषा ज्ञात (अल्पविराम द्वारा अलग)</label>
					<input type="text" name="languages" class="form-group" />
					<label>Skills / कौशल</label>
					<label><input name="skills[]" type="checkbox" class="form-group" value="computer"> Basic Computer Skills / मूल कम्प्युटरकोक्षमता</label>
					<label><input name="skills[]" type="checkbox" class="form-group" value="analysis"> Data processing & analysis / डाटा प्रोसेसिङ</label>
					<label><input name="skills[]" type="checkbox" class="form-group" value="advanced-medical"> Doctor & Advanced Medical Skills / डाक्टर र विकसित चिकित्सा कौशल</label>
					<label><input name="skills[]" type="checkbox" class="form-group" value="basic-medical"> Basic Medical Training / मूल चिकित्सा प्रशिक्षण</label>
					<label><input name="skills[]" type="checkbox" class="form-group" value="translation"> English-Nepali Translation / अंग्रेजी - नेपाली अनुवाद</label>
					<label><input name="skills[]" type="checkbox" class="form-group" value="engineer"> Engineer & Structure Assessment / इन्जिनियर र संरचना आकलन</label>
					<label>Other Skills / अन्य कौशल</label>
					<textarea name="other-skills" placeholder="Other Skills" class="form-control"></textarea>
					<label>Vehicle</label>
					<label><input type="checkbox" name="vehicle[]" value="bike" class="form-group" /> Bike / बाइक</label>
					<label><input type="checkbox" name="vehicle[]" value="car" class="form-group" /> Car / कार</label>
					<label><input type="checkbox" name="vehicle[]" value="truck" class="form-group" /> Truck / ट्रक</label>
					<input type="hidden" name="help-type" value="volunteer-registration"/>

					<input type="submit" value="SUBMIT" class="blackbtn form-control" />
				</form>
			</div>
		</div>
	</div>
</div>
<?php
//Includes
include("includes/footer.php");
?>





