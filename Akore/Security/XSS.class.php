<?php

namespace Akore\Security; 

class XSS
{

	protected $attrsRegex = '/on(.+?)=/is';

	protected $htmlRegex = '/<script[^\>]*>|<\/script>|<script\b[^>]*>(.*?)<\/script>|<script\b[^>]*>|<\/script>/is';

	protected $URLRegex = 'javascript\s*:', 'expression\s*(\(|&\#40;)', 'vbscript\s*:';

	protected $badWords = array('document.cookie', 'document.write', 'document.', 'window.', 'window.location');

	protected $elements = 'base64', '.parentNode', '.innerHTML', 'window.location', '-moz-binding', '<!--', '-->', '#', '<![CDATA[', 'javascript', 'expression', 'vbscript', 'script', 'applet', 'alert', 'document', 'write', 'cookie', 'window', 'frame', 'iframe' , 'livescript', 'vbscript', 'blink', 'embed', 'object', 'frameset', 'ilayer', 'layer', 'bgsound', 'base', 'eval';


	/**
	 * [filterHTML : filter HTML code ]
	 * @param  string $data 
	 * @return string
	 */
	public function filterHTML($data)
	{
		$data = preg_replace($this->attrsRegex, 'x', $data);
		$data = preg_replace($this->$htmlRegex, '', $data);
		return str_replace($this->badWords, '', preg_replace($this->$URLRegex, 'x', $data));
	} 

	/**
	 * [clean : filter and clean html]
	 * @param  [string $data 
	 * @return string
	 */
	public function clean($data)
	{
		$data = $this->filterHTML($data);
		return str_replace($this->elements, '', $data);
	}

	/**
	 * [block : block XSS]
	 * @param  string $data 
	 * @return string
	 */
	public function block($data)
	{
		return htmlspecialchars($this->clean($data), ENT_QUOTES, 'UTF-8');
	} 

}