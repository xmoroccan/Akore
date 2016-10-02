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

namespace Core\Helpers;

class FileUpload
{

	protected $input;

	/**
	 * setInput file input name
	 * @param string $input 
	 */
	public function setInput($input)
	{
		$this->input = $input;
	}

	/**
	 * isValidMime 
	 * @param  array   $mimes 
	 * @return boolean 
	 */
	public function isValidMime(array $mimes)
	{
		return in_array($this->getMime(), $mimes);
	}

	/**
	 * getMime
	 * @param  string $file 
	 * @return string
	 */
	public function getMime($file = null)
	{

		if(is_null($file)) $file = $_FILES[$this->input]['tmp_name'];

		if(class_exists('finfo')) {

			$mime = new \finfo(FILEINFO_MIME_TYPE);
			$mime = $mime->file($file);

		} elseif(function_exists('finfo_open')) {

			$f = finfo_open(FILEINFO_MIME_TYPE);
			$mime = finfo_file($mime, $file);
			finfo_close($f);

		} else {

			$mime = 'unknown';
		}

		return $mime;
	}

	/**
	 * upload
	 * @param  string $name [ path / file name ]
	 * @return boolean
	 */
	public function upload($name)
	{
		return move_uploaded_file($_FILES[$this->input]['tmp_name'], $name);
	}

}