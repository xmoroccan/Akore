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

class String 
{

	public function htmlEncode($str)
	{
		return html_entity_decode($str, ENT_COMPAT | ENT_HTML5, 'UTF-8');
	}

	public function htmlDecode($str)
	{
		return json_decode(preg_replace('/\\\u([0-9a-z]{4})/', '&#x$1;', json_encode($str)));
	}
}