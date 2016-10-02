<?php 
/**
 * Akore PHP Framework
 * @package   Akore
 * @author    Mohamed Elbahja <Mohamed@elbahja.me>
 * @copyright 2016 Akore
 * @version   1.0
 * @link      http://www.elbahja.me
 */

namespace Akore\Helpers;

class Curl
{

	protected $defaults = array(
        CURLOPT_HEADER => 0, 
        CURLOPT_RETURNTRANSFER => TRUE, 
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_RETURNTRANSFER => true,
	);

	/**
	 * @param  array  $opts curl_setopt_array
	 * @return mixed
	 */
	public function exec(array $opts)
	{
		$ch = curl_init();
		curl_setopt_array($ch, $opts);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}


	/**
	 *  GET Request
	 * @param  array  $opts curl_setopt_array
	 * @return string
	 */
	public function get(array $opts = array()) 
	{    
	    
	    $ch = curl_init(); 
	    curl_setopt_array($ch, ($opts + $this->defaults)); 
	    $data = curl_exec($ch);
	    curl_close($ch); 
	    return $data; 
	}

    /**
     * POST Request
     * @param  array  $opts 
     * @return mixed
     */
	public function post(array $opts = array()) {

	    $ch = curl_init(); 
	    $opts = array_merge($opts, [CURLOPT_POST => 1, CURLOPT_FRESH_CONNECT => 1]);
	    curl_setopt_array($ch, ($opts + $this->defaults)); 
	    $data = curl_exec($ch);
	    curl_close($ch); 
	    return $data; 
	}

}