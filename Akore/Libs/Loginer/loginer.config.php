<?php defined('ROOT') || die('direct access not allowed');

/**
 * allowed Social Media oAuth Loginer
 * @var array
 */
$social = array(
	'gp' => 'google',
	'fb' => 'facebook',
	'tw' => 'twitter'
);

$social_config = array(
	'google' => array(
		'client_id'    => '109326047974s3u00lai3aa420c8231ot4j3v2qpdri.apps.googleusercontent.com',
		'client_secret' => 'ErEcnUptfdvxzXP0FO2-15Xt',
		'app_name'      => 'LOginer'
	),

	'facebook' => array(
		'app_id'        => '167885971357352',
		'app_secret'    => '70cdc645915df653ce8327fe5ece09f',
		'graph_version' => 'v2.0'
	),

	'twitter' => array(
		'consumer_key'    => 'iZO5Ln9bcIXdmF1mXOqIiODN',
		'consumer_secret' => '9vPPjgkSbfEA7fV5YxOwD26Z8gn2kAlnrB6ntAAHqsknHTfsR'
	)
);

$loginer_config = array(
	'login_url'  => WEB_URL . '/oauth/fb',
	'return_url' => ''
);

define('LOGINER_SRC_DIR', CORE_DIR . DS . 'Libs');
