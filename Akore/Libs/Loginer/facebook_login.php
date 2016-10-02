<?php defined('ROOT') || die('direct access not allowed');

/**
* @author Mohamed Elbahja <Mohamed@elbahja.me>
* @copyright 2016
* @version 2.0
* @package Loginer 
* @link http://www.elbahja.me
*/

if($social[$type] !== 'facebook') {

	exit('Login Type Not Exists');

} elseif(empty($social_config[$social[$type]]['app_id']) || empty($social_config[$social[$type]]['app_secret'])) {

	exit('app_id OR app_secret is empty');
}

require_once LOGINER_SRC_DIR . DS . 'facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => $social_config['facebook']['app_id'],
  'app_secret' => $social_config['facebook']['app_secret'],
  'default_graph_version' => $social_config['facebook']['graph_version'],
 ]);

$helper = $fb->getRedirectLoginHelper();

try {
 $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
   exit("<p>".$e->getMessage()."</p>");
} catch(Facebook\Exceptions\FacebookSDKException $e) {
   exit("<p>".$e->getMessage()."</p>");
}

if (isset($accessToken)) {

    $r = $fb->get('me?fields=id,name,email,gender,last_name,first_name,picture.height(200).width(200)', (string)$accessToken);
	$r = $r->getGraphNode()->asArray();

	$data = array(
		'is_verify' => 'YES',
		'type'      => 'facebook',
		'blocked'   => 'NO',
		'first_name' => $r['first_name'],
		'last_name'  => $r['last_name'],
		'gender'     => $r['gender'],
		'email'      => $r['email'],
		'usr_key'    => $r['id']
	);

	if($loginer->login_user($data) === true) {
		unset($_SESSION['FBRLH_state']);
	    header("location: ".WEB_URL);
	    exit();

	} else {

		exit('Error in facebook server');
	}

} else {
	$loginUrl = $helper->getLoginUrl(WEB_URL . "/oauth/fb", ['email']);
	header("location: ". $loginUrl);
	exit();	
}
