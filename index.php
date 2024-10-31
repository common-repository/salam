<?php
/**
 * Plugin Name: Salam
 * Plugin URI: http://peravel.ir/
 * Description: Create Simple Auth Ways  **  SMS - OTP  :)
 * Version: 1.0
 * Author: Ehsan Sattari
 * Author URI: hhttp://peravel.ir/
 */
  if (!defined('ABSPATH')) {
    exit;
}
global $wpdb;
$table_name = "otp";
function register_salamot_settings() {
	register_setting( 'salamot-settings-group', 'kavenegarapikey' );
	register_setting( 'salamot-settings-group', 'kavenegartemplate' );
	register_setting( 'salamot-settings-group', 'changewcl' );
	register_setting( 'salamot-settings-group', 'dchangewcl' );
}
function salamot_enqueue() {
   wp_enqueue_script( 'JQ3', 'https://lib.arvancloud.com/ar/jquery/3.3.1/jquery.min.js');
    wp_enqueue_script( 'logmein', plugin_dir_url( __FILE__ ).'assets/log-me-in.js');
}
add_action( 'wp_enqueue_scripts', 'salamot_enqueue' );
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
 $conn->close();
}else{
      $conn = new mysqli(constant("DB_HOST"), constant("DB_USER"), constant("DB_PASSWORD"), constant("DB_NAME"));
$result = mysqli_query($conn,"CREATE TABLE wsotp ( idd int(11) NOT NULL AUTO_INCREMENT, mobileno text NOT NULL, ccode int(11) NOT NULL, otp int(11) NOT NULL, expire timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY idd (idd) ) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1" );

	if ($conn->query($result) === TRUE) {
$conn->close();
}
$conn->close();
}
$chan = esc_attr( get_option('changewcl') ); 
function salamot_login_vars($vars) {
  $vars[] .= 'ccode';
  $vars[] .= 'mobile';
   $vars[] .= 'otpp';
      $vars[] .= 'type';
  return $vars;
}
add_filter( 'query_vars', 'salamot_login_vars' );
function salmtpsend() {
    if(isset($_GET['mobile']) ){
        $salamototp=    plugin_dir_path( __FILE__ ).'login-otp.php'; 
      include "$salamototp";
    }
}
add_action('wp_head', 'salmtpsend');
function salamot_login_form(  ) { 
if( get_option('changewcl')=='yes'){
    $salamwid=    plugin_dir_path( __FILE__ ).'template/login-widget.php'; 
      include "$salamwid";
?>
<div class="logmin" style="font-size:20px;">
 ✅ LOIGN BY SMS
</div><?}}; 
add_action( 'woocommerce_login_form', 'salamot_login_form', 10, 0 ); 
add_action('wp_footer', 'loginup');
add_action('admin_menu', 'salamot_create_menu');
function salamot_create_menu() {
	add_menu_page('SALAM Settings', 'Salam Setting', 'administrator', __FILE__, 'salamot_settings_page' , plugins_url('/images/icon.png', __FILE__) );
	add_action( 'admin_init', 'register_salamot_settings' );
}
function salamot_settings_page() {
?>
<div class="wrap">
<h1>SALAM OTP Setting Page </h1>
<form method="post" action="options.php">
    <?php settings_fields( 'salamot-settings-group' ); ?>
    <?php do_settings_sections( 'salamot-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
            <a href="https://kavenegar.com/"> KaveNEGAR API setting</a>
        <th scope="row">API KEY <a href="https://panel.kavenegar.com/client/setting/account"> KaveNEGAR API setting</a></th>
        <td><input type="text" name="kavenegarapikey" value="<?php echo esc_attr( get_option('kavenegarapikey') ); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">  <a href="https://panel.kavenegar.com/client/Verification">Verify Template Name </a></th>
        <td><input type="text" name="kavenegartemplate" value="<?php echo esc_attr( get_option('kavenegartemplate') ); ?>" /></td>
        </tr>
          <tr valign="top">
        <th scope="row">Change Woocomerce Login Form ? </th>
        <td>
            <input type="checkbox" name="changewcl" value="yes" <? if(get_option('changewcl')=='yes'){echo "checked='checked'";}?>>
            Yes
            </input>
             <input type="checkbox"  name="dchangewcl" value="no" <? if(get_option('dchangewcl')=='no'){echo "checked='checked'";}?> >
            NO
            </input>
            </td>
        </td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
</div>
<?php } ?>