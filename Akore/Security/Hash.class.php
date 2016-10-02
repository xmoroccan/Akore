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