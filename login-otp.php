<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&      strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
//if(!IS_AJAX) {die('Restricted access');}
if(is_numeric($_GET['mobile'])){
     $mobi=sanitize_text_field($_GET['mobile']);
    $len =  strlen($mobi);
    if($len == 9 || $len ==10 || $len =11){
             $mobile=sanitize_text_field($_GET['mobile']);
        
    }
}
if(is_numeric($_GET['otpp'])){
     $ot=sanitize_text_field($_GET['mobile']);
    $leno =  strlen($ot);
    if($leno ==6 || $leno =7){
       $otpp =sanitize_text_field($_GET['otpp']);
        
    }
}
$ccode=sanitize_text_field($_GET['ccode']);
$type =sanitize_text_field($_GET['type']);
$kavenegarapikey =  esc_attr( get_option('kavenegarapikey') ); 
$kavenegartemplate = esc_attr( get_option('kavenegartemplate') );
$username = $mobile;
$conn = new mysqli(constant("DB_HOST"), constant("DB_USER"), constant("DB_PASSWORD"), constant("DB_NAME"));
$success = "";
$error_message = "";
if(!empty($mobile)) {
 if(!empty($_GET["otpp"])) {
	$result = mysqli_query($conn,"SELECT * FROM wsotp WHERE  wsotp.mobileno = $mobile AND  wsotp.otp =$otpp" );
	$count  = mysqli_num_rows($result);
	if(!empty($count)) {
// 	echo	$success = 2;	
// 	  $username = $mobile;
$username = $mobile;
 if($user=get_user_by('login',$username)){
 clean_user_cache($user->ID);
 wp_clear_auth_cookie();
        wp_set_current_user( $user->ID );
        wp_set_auth_cookie( $user->ID , true, false);
        update_user_caches($user);
        if(is_user_logged_in()){
echo $success ='owkey';

        //    $redirect_to = user_admin_url();
       //     wp_safe_redirect( 'https://peravel.ir/acc' );
       //     exit;
        }
    }else{
        

   $user_info = array(
	"user_login"    => "$mobile",
	"user_pass"     => "$otpp",
	"user_email"    => "$mobile@peravex.com",
);
$insert_user_result = wp_insert_user( $user_info );
$usern=get_user_by('login',$mobile);
 clean_user_cache($usern->ID);
 wp_clear_auth_cookie();
        wp_set_current_user( $usern->ID );
        wp_set_auth_cookie( $usern->ID , true, false);
        update_user_caches($usern);
        echo $success ='owkey';
    }
	} else {
		echo	$success ='Oh nO';
	}	
}
     
if($type==1 && is_numeric($mobile) ){
    
    if(strlen($mobile)==10 || strlen($mobile)==11){

	$otp = rand(100000,999999);
  $sqldel = "DELETE FROM wsotp WHERE mobileno = '$mobile'";
  if ($conn->query($sqldel) === TRUE) {
    }
$sql = "INSERT INTO wsotp (mobileno, ccode, otp) VALUES ('$mobile', '$ccode', '$otp')";

if ($conn->query($sql) === TRUE) {
  $smsproviderurl = "https://api.kavenegar.com/v1/$kavenegarapikey/verify/lookup.json?receptor=$mobile&token=$otp&template=$kavenegartemplate";
$sendit = file_get_contents($smsproviderurl);
echo "sent";
// $curl = curl_init();
// curl_setopt_array($curl, array(
//   CURLOPT_URL => $smsproviderurl,
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "GET"
// ));

// $response = curl_exec($curl);

// curl_close($curl);
}

}
} }

?>