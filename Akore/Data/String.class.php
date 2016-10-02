<?php 
/**
 * Akore PHP Framework
 * @package   Akore
 * @author    Mohamed Elbahja <Mohamed@elbahja.me>
 * @copyright 2016 Akore
 * @version   1.0
 * @link      http://www.elbahja.me
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