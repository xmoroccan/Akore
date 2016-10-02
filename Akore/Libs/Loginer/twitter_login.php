<?php defined('ROOT') || die('diredct access not allowed');

/**
* @author Mohamed Elbahja <Mohamed@elbahja.me>
* @copyright 2016 Application Layout PHP
* @version 1.0
* @package AppLayout PHP 
* @subpackage Social Loginer 
* @link http://www.elbahja.me
*/

if($social[$type] !== 'twitter') {

	exit('Login Type Not Exists');

} elseif(empty($social_config[$social[$type]]['consumer_key']) || empty($social_config[$social[$type]]['consumer_secret'])) {

	exit('consumer_key OR consumer_secret is empty');
}

//error_reporting(0);

require_once(LOGINER_SRC_DIR . DS . 'twitter/autoload.php');

use Abraham\TwitterOAuth\TwitterOAuth;

if(isset($_GET['oauth_token']) || $_GET['oauth_verifier']) {	

	$tw = new TwitterOAuth($social_config['twitter']['consumer_key'], $social_config['twitter']['consumer_secret'], $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

	$access_token = $tw->oauth('oauth/access_token', array('oauth_verifier' => $_GET['oauth_verifier'], 'oauth_token'=> $_GET['oauth_token']));

	$tw = new TwitterOAuth($social_config['twitter']['consumer_key'], $social_config['twitter']['consumer_secret'], $access_token['oauth_token'], $access_token['oauth_token_secret']);

	$r = $tw->get('account/verify_credentials');
	$uname = explode(' ', $r->name);

	$data = array(
		'is_verify' => 'YES',
		'type'      => 'twitter',
		'blocked'   => 'NO',
		'first_name' => isset($uname[0]) ? $uname[0] :'',
		'last_name'  => isset($uname[1]) ? $uname[1] :'',
		'gender'     => '',
		'email'      => '',
		'usr_key'    => $r->id
	);

	var_dump($data);


	if($loginer->login_user($data) === true) {
		unset($_SESSION['oauth_token_secret']);
	    unset($_SESSION['oauth_token']);
	    header('location: '. WEB_URL);
	    exit;	

	} else {

		exit('Error in facebook server');
	}

} else {
	
$tw = new TwitterOAuth($social_config['twitter']['consumer_key'], $social_config['twitter']['consumer_secret']);
$request_token = $tw->oauth("oauth/request_token", array("oauth_callback" => WEB_URL ."/oauth/tw"));
$_SESSION['oauth_token']       = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
$loginUrl = $tw->url("oauth/authorize", array("oauth_token" => $request_token['oauth_token']));
header("Location: " . $loginUrl);
exit();
}
