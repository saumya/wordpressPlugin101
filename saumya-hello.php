<?php
/*
Plugin Name: Saumya Hello
Plugin URI: https://github.com/saumya
Description: Calling REST on another server. Shows how to load JS in Wordpress Plugin.
Version: 0.1.0
Author: saumya
Author URI: http://saumya.github.io/
License: MIT 
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
// We need some CSS to position the paragraph
function saumya_css() {
	// This makes sure that the positioning is also good for right-to-left languages
	$x = is_rtl() ? 'left' : 'right';
	echo "
	<style type='text/css'>
	#saumya_footer {
		float: $x;
		padding-$x: 15px;
		padding-top: 5px;	
		padding-left: 100px;	
		margin: 0;
		font-size: 11px;
	}
	</style>
	";
}
function saumya_press_notice(){
	echo "SaumyaPress-0.1.0 : Notice";
}
function saumya_press_footer(){
	echo "<p id='saumya_footer'>SaumyaPress-0.1.0 : Footer</p>";
}
function saumya_add_js_to_doc_head(){
	$jsSrc = plugins_url('saumyaSignal.js', __FILE__);
	wp_register_script( 'onSaumyaSingalProfileUpdate', $jsSrc );
	wp_enqueue_script( 'onSaumyaSingalProfileUpdate' );
}
function saumya_OnProfileUpdate($user_id, $old_user_data){
	// Calls OneSignal to get all the application details
	// https://onesignal.com

	// REST call using CURL
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/apps");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Authorization: Basic yourAuthIdProvidedByOneSignal'));
	curl_setopt($ch, CURLOPT_HTTPGET, true);
	$result = curl_exec($ch);
	print_r($result);
	curl_close($ch);
	
	
	// Transient API : http://codex.wordpress.org/Transients_API
	// inputs : string, Object, integer(number of seconds)
	// set : set_transient( $transient, $value, $expiration ); 
	// get : get_transient( $transient );
	
	set_transient( 'saumyaPress_profileUpdateId', $user_id, 60 );
}
//
function saumya_onPersonalOptions($user){
		// This shows on TOP of Profile
		echo "saumya_personal_options : TOP <br>";
	?>
	
	<script type="text/javascript">
		SaumyaSignal.onPersonalOptions();
	</script>

	<?php
}
function saumya_onBelowProfile(){
		// This is on BOTTOM of Profile
		echo "saumya_show_user_profile : BOTTOM <br>";
		$saumyaID = get_transient( 'saumyaPress_profileUpdateId' );
		echo "updated_id:$saumyaID <br>";
		if($saumyaID){
			echo "<script>console.log('ProfileUpdated:ID:$saumyaID')</script>";	
		}
		echo "<script>console.log('Done:ProfileUpdate')</script>";
	?>

	<script type="text/javascript">
		SaumyaSignal.onShowUserProfile();
		SaumyaSignal.onUpdatedProfile(<?php echo "$saumyaID" ?>);
	</script>
	
	<?php
}
// Finally the event handlers
add_action('init','saumya_add_js_to_doc_head');
add_action( 'profile_update', 'saumya_OnProfileUpdate', 10, 2 );
// just some admin UI updates
add_action( 'admin_notices', 'saumya_press_notice' );
add_action( 'admin_footer', 'saumya_press_footer' );
add_action( 'admin_head', 'saumya_css' );
//
add_action('personal_options', 'saumya_onPersonalOptions');
add_action('show_user_profile', 'saumya_onBelowProfile');
//EOF
?>
