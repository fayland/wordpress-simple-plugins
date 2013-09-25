<?php
/*
Plugin Name: Simple Paypal Form
Plugin URI: http://fayland.me/
Description: Simple Paypal Payment Form
Author: Fayland Lam
Author URI: http://fayland.me/
Version: 0.0.1
*/

if (! function_exists('add_shortcode')) die('&Delta;');

// shortcode to display contact form
add_shortcode('simple_paypal_form','spf_shortcode');
function spf_shortcode($atts) {
	if (! spf_process_form($atts)) {
		spf_display_form();
	}
}
function simple_paypal_form($atts) {
	if (! spf_process_form($atts)) {
		spf_display_form();
	}
}

function spf_process_form($atts) {
	if (!(isset($_POST['spf_submit']))) return false;
	$atts = shortcode_atts(
      array(
        'amount'	  => '',
        'email'	      => '',
        'currency_code' => 'AUD',
    ), $atts );

    if (! strlen($atts['email'])) {
    	die('[simple_paypal_form email=""] email is required.');
    }
    if (! strlen($atts['amount'])) {
    	die('[simple_paypal_form amount=""] amount is required.');
    }

    $spf_name = htmlentities($_POST['spf_name']);
    $spf_number = htmlentities($_POST['spf_number']);
    $spf_invnumber = htmlentities($_POST['spf_invnumber']);

?>

	<p>You're redirecting to Paypal site to continue.</p>
	<form name="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="business" value="<?php echo $atts['email']; ?>">
		<input type="hidden" name="currency_code" value="<?php echo $atts['currency_code']; ?>">
		<input type="hidden" name="item_name" value="<?php echo $spf_name; ?>">
		<input type="hidden" name="item_number" value="<?php echo $spf_number; ?>">
		<input type="hidden" name="amount" value="<?php echo $atts['amount']; ?>">
		<input type="hidden" name="return" value="" />
		<input type="hidden" name="on0" value="Invoice Number" />
		<input type="hidden" name="os0" value="<?php echo $spf_invnumber; ?>" />
	</form>
	<script>document.paypal.submit();</script>
<?php

	return true;
}

function spf_display_form() {

?>

<div class="comment-form">
<form method="post">
<div class='row field_text alignleft'>
    <label class='label_title' for='spf_name'><strong>Client: </strong></label><br />
    <input type='text' style='width:443px;' class='inputtext input_middle' name='spf_name'/>
</div>
<div class='row field_text alignleft'>
    <label class='label_title' for='spf_number'><strong>Contact Number:</strong></label><br />
    <input type='text' style='width:443px;' class='inputtext input_middle' name='spf_number'/>
</div>
<div class='row field_text alignleft'>
    <label class='label_title' for='spf_invnumber'><strong>Invoice Number: </strong></label><br />
    <input type='text' style='width:443px;' class='inputtext input_middle' name='spf_invnumber'/>
</div>
<div class="row rowSubmit alignleft">
	<input type="submit" class="btn-submit" name="spf_submit" title="Pay by PayPal" value="Pay by PayPal" /><br />
</div>
</form>
</div>

<?php
} // ends for function spf_display_form
?>