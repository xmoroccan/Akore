<?php
/**
 * Akore PHP Framework
 * @package   Akore
 * @author    Mohamed Elbahja <Mohamed@elbahja.me>
 * @copyright 2016 Akore
 * @version   1.0
 * @link      http://www.elbahja.me
 */

namespace Akore\Security;

class CSRF_Token
{

	protected $form_id    = '_Id';
	protected $token_name = '_CSRF_token'; 

	/**
	 * From CSRF Token Generator
	 * @param strin $name
	 * @return string 
	 */
	public function getToken($name) 
	{
		$token_name = $name . $this->token_name;
		$form_id    = $name . $this->form_id;
		$fid   = md5(uniqid() . time());
		$token = md5($fid . md5($name . @$_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']));
		$_SESSION[$form_id]    = $fid;
		$_SESSION[$token_name] = $token;
		return '<input name="'.$token_name.'" type="hidden" value="' . $token . '" /><input name="'.$form_id.'" type="hidden" value="'. base64_encode($fid) .'" />';
	}


	/**
	 * CSRF Token Validation
	 * @param  string $name 
	 * @param  array $method 
	 * @return boolean
	 */
	public function validToken($name)
	{

		$token_name = $name . $this->token_name;
		$form_id    = $name . $this->form_id;

		$method = '_' . $_SERVER['REQUEST_METHOD']; 

		if(!isset($method[$token_name]) || !isset($method[$form_id])) {
			return false; 
		} elseif(empty($method[$token_name]) || empty($method[$form_id])) {
			return false;
		} 

		$_fromid  = $method[$form_id];
		$_tokenid = $method[$token_name];

		if( base64_decode($_fromid) === $_SESSION[$form_id] && $_tokenid === $_SESSION[$token_name] && $_tokenid === md5(base64_decode($_fromid) . md5($name . @$_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'])) ) {
			return true;
		}

		return false;
	}

	public function del($name) 
	{
		unset($_SESSION[$name . $this->token_name], $_SESSION[$name . $this->form_id]);
	}

}
