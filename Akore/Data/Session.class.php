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

namespace Akore\Data;

class Session
{

	protected $userinfo = array();
	protected $sname;
	public $https = false;

	/**
	 * start Session
	 * @param  string  $name
	 * @param  integer $limit
	 * @param  string  $path 
	 * @param  string  $domain
	 * @return void
	 */
	public function start($name = 'ssid', $limit = 2592000, $path = '/', $domain = null)
	{

		$domain = ($domain === null) ? '.' . DOMAIN : $domain;

      $this->userinfo = (new \Akore\Helpers\UserInfo)->all();
      $this->sname = $name;

      ini_set('session.cookie_secure', 1); 
      ini_set('session.cookie_httponly', 1);
		session_name($this->sname);
		session_set_cookie_params($limit, $path, $domain, $this->https, true);
		session_start();

		if (!isset($_SESSION['_usrid'])) {

			$this->destroy();
		    $_SESSION['_usrid'] = $this->userid();

		}

		if ($this->valid() === false) $this->destroy();

	}

	/**
	 * __destruct session write close
	 */
	public function __destruct()
	{
		session_write_close();
	}

	/**
	 * check user
	 * @return boolean
	 */
	public function valid()
	{
		return (isset($_SESSION['_usrid']) && $_SESSION['_usrid'] === $this->userid());
	}

	/**
	 * destroy session
	 * @return void
	 */
	public function destroy()
	{
      session_unset();
      session_destroy();
	}

	/**
	 * __set session
	 * @param string || int $k [ key ]
	 * @param mixed $v [ value]
	 */
	public function __set($k, $v)
	{
		$_SESSION[$k] = $v;
	}

	/**
	 * __get value
	 * @param  string || int $k
	 * @return mixed
	 */
	public function __get($k)
	{
		return isset($_SESSION[$k]) ? $_SESSION[$k] : false;
	}

	/**
	 * del delete value session
	 * @param  mixed $name
	 * @return void
	 */
	public function del($name)
	{
		unset($_SESSION[$name]);
	}

	/**
	 * user id (not unique)
	 */
	protected function userid()
	{
		return md5(serialize($this->userinfo));
	}

}