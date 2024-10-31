<?php  
/* 
Plugin Name: PayDay Loan Application 
Plugin URI: http://www.sms-affiliate.co.uk/plugin/
Description: Easily add a PayDay Loan application form to your site and earn 70% commission on your referrals. Commission is paid fortnightly direct to your bank account. Create your affiliate account quickly and easily at <a href="http://www.sms-affiliate.co.uk/plugin/" target="_blank">http://www.sms-affiliate.co.uk/plugin/</a> .This is a UK affiliate plugin which offers Wordpress site owners the ability to earn 70% commission income from their applications. No coding necessary, simply use our [payday] shortcode.
Version: 1.0 
Author: Gary Solomon 
Author URI: http://www.sms-affiliate.co.uk/plugin/
License: GPLv2 or later
*/ 

add_shortcode('payday', 'droppaydaycode');

function droppaydaycode($atts,$content = null){
extract(shortcode_atts(array(
    	'affiliate' => '',
	'height' => '1300',	
	'width' => '600',
	), $atts));

$return_string = '<iframe src="https://m.mobi-money.co.uk/plugin/apply.php?height='.$height.'&width='.$width.'&affiliate='.get_option('paydayloanaffiliate').'" width="'.$width.'" height="'.$height.'" frameborder="false" scrolling="no"></iframe>';
return $return_string;
}

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'paydayloan_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'paydayloan_remove' );

function paydayloan_install() {
/* Creates new database field */
add_option("paydayloanaffiliate", 'Default', '', 'yes');
}

function paydayloan_remove() {
/* Deletes the database field */
delete_option('paydayloanaffiliate');
}
if ( is_admin() ){

/* Call the html code */
add_action('admin_menu', 'paydayloanadminmenu');

function paydayloanadminmenu() {
add_options_page('Pay Day Loans', 'Pay Day Loans', 'administrator',
'paydayloansaffiliate', 'paydayloans_html_page');
}
}
function paydayloans_html_page() {
?>
<div class="wrap">
<?php screen_icon(); ?>
<h2>Pay Day Loans Options</h2>
<BR><BR>
<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<table width="800">
<tr valign="top">
<th width="92" scope="row">Enter Affiliate ID</th>
<td width="600">
<input name="paydayloanaffiliate" type="text" id="paydayloanaffiliate"
value="<?php echo get_option('paydayloanaffiliate'); ?>" />
(ex. WEBS0001)<BR><BR>If you don't yet have an affiliate account with us, simply visit <nobr><a href="http://www.sms-affiliate.co.uk/plugin/" target="_blank">http://www.sms-affiliate.co.uk/plugin/</a>.</nobr><BR>We pay 70% commission every 2 weeks.<BR><BR><BR>Useage : Simply add the shortcode <strong>[payday]</strong> to any page or post. You can also control the size by adding width and height attributes e.g <strong>[payday width="800" height="1200"]</strong> Simply omit these attributes to use the default sizing</td>
</tr>
</table>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="paydayloanaffiliate" />

<p class="submit"> 
<?php submit_button(); ?>
</p>

</form>
</div>
<?php
}
?>