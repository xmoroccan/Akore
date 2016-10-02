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

class Optimize
{
	public function ob_start() 
	{
		ob_start(function($data) 
        {
          return $this->html($data);
		});
	}

    public function html($data)
	{
		return preg_replace(['/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s'], ['>', '<', '\\1'], $data);
	}
}
