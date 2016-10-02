<?php defined('ROOT') || die('direct access not allowed');

/**
* @author Mohamed Elbahja <Mohamed@elbahja.me>
* @copyright 2016 Application Layout PHP
* @version 1.0
* @package AppLayout PHP 
* @subpackage Social Loginer 
* @link http://www.elbahja.me
*/


if($social[$type] !== 'google') {

	exit('Login Type Not Exists');

} elseif(empty($social_config['google']['client_id']) || empty($social_config['google']['client_secret'])) {

	exit('client_id or clieent_secret is empty');
}

include_once(LOGINER_SRC_DIR . DS . 'google/Google_Client.php');
include_once(LOGINER_SRC_DIR . DS . 'google/contrib/Google_Oauth2Service.php');

$gc = new Google_Client();
$gc->setApplicationName($social_config['google']['app_name']);
$gc->setClientId($social_config['google']['client_id']);
$gc->setClientSecret($social_config['google']['client_secret']);
$gc->setRedirectUri(WEB_URL .'/oauth/gp');
$go = new Google_Oauth2Service($gc);

if(isset($_GET['code'])){
	$gc->authenticate();
	$_SESSION['token'] = $gc->getAccessToken();
}

if (isset($_SESSION['token'])) {
	$gc->setAccessToken($_SESSION['token']);
}

if ($gc->getAccessToken()) {

	$r = $go->userinfo->get();

	$data = array(
		'is_verify' => 'YES',
		'type'      => 'google',
		'blocked'   => 'NO',
		'first_name' => $r['given_name'],
		'last_name'  => $r['family_name'],
		'gender'     => $r['gender'],
		'email'      => $r['email'],
		'usr_key'    => $r['id']
	);

	if($loginer->login_user($data) === true) {
		unset($_SESSION['token']);
	    header("location: ".WEB_URL);
	    exit();

	} else {

		exit('Error in facebook server');
	}

} else {
	$loginUrl = $gc->createAuthUrl();
	header("location: ". $loginUrl);
	exit();	
}