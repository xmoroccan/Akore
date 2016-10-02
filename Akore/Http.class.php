<?php 

namespace Akore;

class Http
{

	/**
	 * Http Headers 
	 * @var array
	 */
	protected $safeHeader = array(
		'X-XSS-Protection'        => '1; mode=block',
		'X-Content-Type-Options'  => 'nosniff',
		'X-Download-Options'      => 'noopen',
		'X-Frame-Options'         => 'DENY',
		'Content-Security-Policy' => "default-src 'none'; script-src 'self' 'unsafe-inline' unsafe-eval'; object-src 'self'; style-src 'self' 'unsafe-inline'; font-src 'self'; connect-src 'self'; form-action 'self'; reflected-xss block"
		);

	/**
	 * Get $_SERVER
	 * @param  string $k _SERVER key 
	 * @return mixed
	 */
	public function __get($k) {

		return (isset($_SERVER[$k])) ? $_SERVER[$k] : false;
	}

	/**
	 * __call set Header 
	 * @param  string $k 
	 * @param  array $v
	 * @return void
	 */
	public function __call($k, $v)
	{
		header($k . ':' . $v[0]);
	}
	
	/**
	 * Get Requqest method
	 * @return string
	 */
	public function method()
	{
		return $this->REQUEST_METHOD;
	}

	/**
	 * is Headers Sent
	 * @return boolean
	 */
	public function sent()
	{
		return headers_sent();
	}

	/**
	 * get request URI
	 * @return string 
	 */
	public function URI()
	{
		return urldecode($this->REQUEST_URI);
	}

	/**
	 * safeHeader 
	 * @param  array  $opts 
	 * @return void
	 */
	public function safeHeader(array $opts = array())
	{
		$opts = array_merge($this->$safeHeader, $opts);

		foreach ( $opts as $k => $v ) {
			header($k . ': ' . $v);
		} 
	}

}