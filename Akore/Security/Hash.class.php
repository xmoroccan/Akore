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

namespace Akore\Security;

class Hash
{
	
	public function hash($data)
	{
		return md5(hash('SHA256', md5($data)));
	}

	public function verify($hash, $data)
	{
		return ($hash === $this->hash_pass($data));
	}
}