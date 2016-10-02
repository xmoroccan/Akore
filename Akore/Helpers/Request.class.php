<?php 
/**
 * Akore PHP Framework
 * @package   Akore
 * @author    Mohamed Elbahja <Mohamed@elbahja.me>
 * @copyright 2016 Akore
 * @version   1.0
 * @link      http://www.elbahja.me
 */

namespace Core\Helpers;

class Request
{

	private $opts;

	/**
	 * @param string $method  POST or GET
	 * @param string $content request contect ex : qry=test&name=ss
	 */
	public function set_opt($method = 'POST', $content = '') 
	{

		$this->opts = array(
			      'http' => array(
                   	'method'  => $method,
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $content
                  )
        );
	}

	/**
	 * get data
	 * @param  string $url request url
	 * @return string
	 */
	public function get_data($url)  {

		return file_get_contents($url, false, stream_context_create($this->opts));
	}
}
