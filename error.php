<?php
/**
 * Akore PHP Framework
 * @package   Akore
 * @author    Mohamed Elbahja <Mohamed@elbahja.me>
 * @copyright 2016 Dinital Production 
 * @version   1.1
 * @link http://www.dinital.com
 * @license http://opensource.org/licenses/MIT  MIT License
 */

error_reporting(0);

$errors = array(
      400 => array('400 Bad Request', 'You have provided a parameter that the function does not support.'),
      401 => array('401 Unauthorized', 'You have not provided a username/password or authkey.'),
      403 => array('403 Forbidden', 'The server has refused to fulfill your request.'),
      404 => array('404 Not Found', 'The document/file requested was not found on this server.'),
      405 => array('405 Method Not Allowed', 'The method specified in the Request-Line is not allowed for the specified resource.'),
      406 => array('406 Not Acceptable', 'The requested resource is capable of generating only content not acceptable according to the Accept headers sent in the request.'),
      408 => array('408 Request Timeout', 'Your browser failed to send a request in the time allowed by the server.'),
      429 => array('429 Too Many Requests', 'You have made too many requests.'),
      500 => array('500 Internal Server Error', 'The request was unsuccessful due to an unexpected condition encountered by the server.'),
      502 => array('502 Bad Gateway', 'The server received an invalid response from the upstream server while trying to fulfill the request.'),
      504 => array('504 Gateway Timeout', 'The upstream server failed to send a request in the time allowed by the server.'),
       'error' => array('Error', 'Oops !! Error'),
  );

$status = (isset($_SERVER['REDIRECT_STATUS']) && array_key_exists($_SERVER['REDIRECT_STATUS'], $errors)) ? $_SERVER['REDIRECT_STATUS'] : 'error';

if($status === 'error') {

	$status = (isset($_GET['err']) && array_key_exists($_GET['err'], $errors) ) ? $_GET['err'] : 'error';
}

?>
<!DOCTYPE html><html><head><meta charset=UTF-8><title><?=$errors[$status][0]?></title><style type=text/css>*{paading:0;margin:0}#oopss{text-align:center;margin-bottom:50px;font-weight:400;font-size:20px;font-family:'Open Sans',sans-serif;,sans-serif;position:fixed;width:100%;height:100%;line-height:1.5em;z-index:9999;left:0}#error-text{top:30%;position:relative;font-size:20px;color:#eee}#error-text a{color:#eee}#error-text a:hover{color:#f35d5c}#error-text p{color:#eee;margin:50px auto 0}p.errmdg{text-decoration:none;background:#d7401f;color:#fff;padding:30px 20px;font-size:30px;line-height:normal;border-radius:3px;-webkit-transform:scale(1);-moz-transform:scale(1);transform:scale(1);transition:all .5s ease-out}#error-text i{margin-left:10px}#error-text p.hmpg{margin:20px 0 0 0}#error-text span{position:relative;background:#ef4824;color:#fff;font-size:450%;padding:0 20px;border-radius:5px;font-family:'Roboto',sans-serif;,sans-serif;font-weight:bolder;transition:all .5s;cursor:pointer}#error-text span:hover{background:#d7401f;color:#fff;-webkit-animation:jelly .5s;-moz-animation:jelly .5s;-ms-animation:jelly .5s;-o-animation:jelly .5s;animation:jelly .5s}#error-text span:after{top:100%;left:50%;border:solid transparent;content:&quot;&quot;height:0;width:0;position:absolute;pointer-events:none;border-color:rgba(136,183,213,0);border-top-color:#ef4824;border-width:7px;margin-left:-7px}@-webkit-keyframes jelly{from,to{-webkit-transform:scale(1,1);transform:scale(1,1)}25%{-webkit-transform:scale(.9,1.1);transform:scale(.9,1.1)}50%{-webkit-transform:scale(1.1,.9);transform:scale(1.1,.9)}75%{-webkit-transform:scale(.95,1.05);transform:scale(.95,1.05)}}@keyframes jelly{from,to{-webkit-transform:scale(1,1);transform:scale(1,1)}25%{-webkit-transform:scale(.9,1.1);transform:scale(.9,1.1)}50%{-webkit-transform:scale(1.1,.9);transform:scale(1.1,.9)}75%{-webkit-transform:scale(.95,1.05);transform:scale(.95,1.05)}}@media only screen and (max-width:640px){#error-text span{font-size:200%}#error-text a:hover{color:#fff}}.back:active{-webkit-transform:scale(0.95);-moz-transform:scale(0.95);transform:scale(0.95);background:#f53b3b;color:#fff}.back:hover{background:#4c4c4c}.back{text-decoration:none;background:#5b5a5a;color:#fff;padding:10px 20px;font-size:20px;font-weight:700;line-height:normal;text-transform:uppercase;border-radius:3px;-webkit-transform:scale(1);-moz-transform:scale(1);transform:scale(1);transition:all .5s ease-out}</style></head><body><div id=oopss><div id=error-text><span><?=$errors[$status][0]?></span><p class=errmdg><?=$errors[$status][1]?></p><p class=hmpg><a href=//<?=$_SERVER['HTTP_HOST']?> class=back>Back To Homepage</a></p></div></div><script type=text/javascript>randColor="#"+("000000"+Math.floor(Math.random()*16777215).toString(16)).slice(-6);document.bgColor=randColor;</script></body></html>