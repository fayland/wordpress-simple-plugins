<?php
/*
Plugin Name: Book a Pickup
Plugin URI: http://fayland.me/
Description: Book a pickup
Author: Fayland Lam
Author URI: http://fayland.me/
Version: 0.0.1
*/

if (! function_exists('add_shortcode')) die('&Delta;');

// shortcode to display contact form
add_shortcode('book_a_pickup','bap_shortcode');
function bap_shortcode() {
	$msg = bap_process_form();
	bap_display_form($msg);
}
function book_a_pickup() {
	bap_shortcode();
}

function bap_process_form() {
	if (!(isset($_POST['bap_submit']))) return;

	$name = htmlentities($_POST['bap_name']);
	$mobile = htmlentities($_POST['bap_mobile']);
	$number = htmlentities($_POST['bap_number']);
	$department = htmlentities($_POST['bap_derpartment']);
	$business_name = htmlentities($_POST['bap_business_name']);
	$address = htmlentities($_POST['bap_address']);
	$contact = htmlentities($_POST['bap_contact']);

	$admin_email = get_option( 'admin_email' );
	$fullmsg   = ("
Client:     $name
Mobile:     $mobile
Contact Number: $number
Department: $department
Business Name: $business_name
Address: $address
Contact person at pick: $contact

Items:
");

	$bap_item_number = (int) $_POST['bap_item_number'];
	if ($bap_item_number) {
		foreach (range(1, $bap_item_number) as $i) {
			$gender = $_POST['bap_gender'][$i];
			$colour = $_POST['bap_colour'][$i];
			$repair = $_POST['bap_repair'][$i];
			$brand  = $_POST['bap_brand'][$i];

			if ($gender != '' or $colour != '' or $repair != '' or $brand != '') {
				$fullmsg .= ("
Item $i:
	Gender: $gender
	Colour: $colour
	Repair: $repair
	Brand:  $brand
");
			}
		}
	}

	if (! wp_mail($admin_email, 'Book a Pickup', $fullmsg)) {
		return "Error when sending the email.";
	}

	return 'SUCCESS';
}

function bap_display_form($msg='') {

?>
<script>!window.jQuery && document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"><\/script>')</script>

<div id="form_messages" class="submit_message"><?php
	if ($msg == 'SUCCESS') {
		echo 'Your request is sent and thanks for contacting us.';
	} else {
		echo $msg;
	}
?></div>

<?php
	if ($msg != 'SUCCESS') {
?>
<div class="comment-form">
<form method="post">
<div class='row field_text alignleft'>
    <label class='label_title' for='bap_name'><strong>Client: </strong></label><br />
    <input type='text' style='width:443px;' class='inputtext input_middle' name='bap_name'/>
</div>
<div class='row field_text alignleft omega'>
    <label class='label_title' for='bap_mobile'><strong>Mobile: </strong></label><br />
    <input type='text' style='width:443px;' class='inputtext input_middle' name='bap_mobile'/>
</div>
<div class='row field_text alignleft'>
    <label class='label_title' for='bap_number'><strong>Contact Number:</strong></label><br />
    <input type='text' style='width:443px;' class='inputtext input_middle' name='bap_number'/>
</div>
<div class='row field_text alignleft omega'>
    <label class='label_title' for='bap_derpartment'><strong>Department: </strong></label><br />
    <input type='text' style='width:443px;' class='inputtext input_middle' name='bap_derpartment'/>
</div>
<div class='row field_text alignleft'>
    <label class='label_title' for='bap_business_name'><strong>Business Name: </strong></label><br />
    <input type='text' style='width:443px;' class='inputtext input_middle' name='bap_business_name'/>
</div>
<div class='row field_text alignleft omega'>
    <label class='label_title' for='bap_address'><strong>Address: </strong></label><br />
    <input type='text' style='width:443px;' class='inputtext input_middle' name='bap_address'/>
</div>
<div class='row field_text alignleft'>
    <label class='label_title' for='bap_contact'><strong>Contact person at pickup: </strong></label><br />
    <input type='text' style='width:443px;' class='inputtext input_middle' name='bap_contact'/>
</div>
<div class="clear"></div>
<input type='hidden' name='bap_item_number' id='bap_item_number' value='1' />
<div id='bap_items'>
	<div id='bap_tr_to_clone'>
<div class='row field_text alignleft' style="width:100%">
	<label class='label_title'><strong>Item 1</strong></label>
</div>
<div class="clear"></div>
<div class='row field_text alignleft'>
	<select name='bap_gender[1]' class='select_styled'>
	<option value=''>Gender Picklist</option>
	<option value='Mens'>Mens</option>
	<option value='Ladies'>Ladies</option>
	<option value='Other'>Other</option>
	</select>
</div>
<div class='row field_text alignleft omega'>
	<select name='bap_colour[1]' class='select_styled'>
	<option value=''>Colour Picklist</option>
	<option value='Black'>Black</option>
	<option value='White'>White</option>
	<option value='Brown'>Brown</option>
	<option value='Red'>Red</option>
	<option value='Green'>Green</option>
	<option value='Pink'>Pink</option>
	<option value='Silver'>Silver</option>
	<option value='Gold'>Gold</option>
	<option value='Grey'>Grey</option>
	<option value='Purple'>Purple</option>
	<option value='Yellow'>Yellow</option>
	<option value='Orange'>Orange</option>
	</select>
</div>
<div class="clear"></div>
<div class='row field_text alignleft'>
	<select name='bap_repair[1]' class='select_styled'>
	<option value=''>Repair Picklist</option>
	<option value='Heels'>Heels</option>
	<option value='Rubber Soles'>Rubber Soles</option>
	<option value='Leather Soles'>Leather Soles</option>
	<option value='Rubber Soles and Heels'>Rubber Soles and Heels</option>
	<option value='Leather Soles and Heels'>Leather Soles and Heels</option>
	<option value='Toes'>Toes</option>
	<option value='Patch / Tip Mending'>Patch / Tip Mending</option>
	<option value='Elastic'>Elastic</option>
	<option value='Shank'>Shank</option>
	<option value='Heel Secure'>Heel Secure</option>
	<option value='Back Linings'>Back Linings</option>
	<option value='Taylor Made Innersoles'>Taylor Made Innersoles</option>
	<option value='New Heel Blocks'>New Heel Blocks</option>
	<option value='Stretching'>Stretching</option>
	<option value='Other'>Other</option>
	</select>
</div>
<div class='row field_text alignleft omega'>
	<input type='text' class='inputtext' name='bap_brand[1]' placeholder='Brand' />
</div>
	</div>
</div>
<div class="clear"></div>
<div class='row field_text alignleft' style="width:100%; z-index:10">
	<a href='javascript: bap_new_item()'>Add New Item</a>
</div>
<div class="row rowSubmit alignleft">
	<input type="submit" class="btn-submit" name="bap_submit" title="Submit mesage" value="Request pickup" /><br />
</div>
</form>
</div>

<script>
(function() {
	var current_item_number = 1;
	window.bap_new_item = function () {
		current_item_number++;
		var tr_clone = $('#bap_tr_to_clone').html();
		tr_clone = tr_clone.replace(new RegExp("\\\[1\\\]","gm"), '[' + current_item_number + ']').replace('Item 1', 'Item ' + current_item_number);
		$("<div>" + tr_clone + "</div>").appendTo('#bap_items');
		$('#bap_item_number').val(current_item_number);
	};
}());
</script>

<?php
	} // ends for if ($msg != 'SUCCESS') {
} // ends for function bap_display_form
?>