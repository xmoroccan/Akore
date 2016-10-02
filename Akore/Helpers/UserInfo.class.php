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

namespace Akore\Helpers;

class UserInfo {

	protected $n = array();

	protected $mobiles = '(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|webos|iPod|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino|bolt|boost|cricket|docomo|fone|mini|mobi|pie|tablet|wos';

	protected $OS = array(
	        'windows nt 10' =>  'Windows 10',
	        'windows nt 6.3' =>  'Windows 8.1',
	        'windows nt 6.2' =>  'Windows 8',
	        'windows nt 6.1' =>  'Windows 7',
	        'windows nt 6.0' =>  'Windows Vista',
	        'windows nt 5.2' =>  'Windows Server 2003/XP',
	        'windows nt 5.1' =>  'Windows XP',
	        'windows xp' =>  'Windows XP',
	        'windows nt 5.0' =>  'Windows 2000',
	        'windows me' =>  'Windows ME',
	        'macintosh|mac os x' =>  'Mac OS X',
	        'mac_powerpc' =>  'Mac OS 9',
	        'linux' =>  'Gnu/Linux',
	        'ubuntu' =>  'Ubuntu',
	        'iphone' =>  'iPhone',
	        'ipod' =>  'iPod',
	        'ipad' =>  'iPad',
	        'android' =>  'Android',
	        'blackberry|bBB10'  =>  'BlackBerry',
	        'webos' =>  'Mobile',
	        'palmos|avantgo|blazer|elaine' => 'Palm OS',
	        'symbian|symbos'  => 'Symbian OS',
	        'windows phone'  => 'Windows Phone',
	     ); 

	protected $browsers = array(
	        'msie' =>  'Internet Explorer',
	        'mobile' =>  'Handheld Browser',
	        'firefox|fennec' =>  'Firefox',
	        'safari|MobileSafari' =>  'Safari',
	        'chrome' =>  'Chrome',
	        'chromium' => 'Chromium',
	        'opera' =>  'Opera',
	        'netscape' =>  'Netscape',
	        'maxthon' =>  'Maxthon',
	        'konqueror' =>  'Konqueror',
	        'tizen' => 'Tizen Browser',
	        'obigo' =>  'Obigo Browser'
	    );

	protected $bots = 'Googlebot|facebookexternalhit|AdsBot-Google|Google Keyword Suggestion|Facebot|YandexBot|bingbot|ia_archiver|AhrefsBot|Ezooms|GSLFbot|WBSearchBot|Twitterbot|TweetmemeBot|Twikle|PaperLiBot|Wotbox|UnwindFetchor|Exabot|MJ12bot|YandexImages|TurnitinBot|Pingdom|Googlebot-Mobile|AdsBot-Google-Mobile|YahooSeeker';

    /**
     * Is mobile
     * @return bool
     */ 
	public function is_mobile() 
	{
        if ($this->_match($this->mobiles)){
        	return TRUE;
        }
       return FALSE; 
	}

    /**
     * Is bot
     * @return bool
     */ 
	public function is_bot() 
	{
        if ($this->_match(strtolower($this->bots))) {
        	return TRUE;
        }
       return FALSE; 
	}

	public function bot_name()
	{
		$this->is_bot();
		return (isset($this->n[0])) ? $this->n[0]: 'Unknown';
	}

    /** get User Agent **/ 
	public function ua() 
	{
	   return $_SERVER['HTTP_USER_AGENT'];
	}
    /** Get User System **/
	public function os() 
	{
		return $this->_loop_match($this->OS);
	}  
    /** Get User Browser **/
	public function br() 
	{
		return $this->_loop_match($this->browsers);
	}
    /** Get User IP (v4) **/
	protected function ip() 
	{
	  $ipaddress = 'Unknown';
      if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
          $ipaddress =  $_SERVER['HTTP_CF_CONNECTING_IP'];
      } else if (isset($_SERVER['HTTP_X_REAL_IP'])) { 
          $ipaddress = $_SERVER['HTTP_X_REAL_IP'];
      } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
          $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
      } else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
      } else if(isset($_SERVER['HTTP_X_FORWARDED'])) {
          $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
      } else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
          $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
      } else if(isset($_SERVER['HTTP_FORWARDED'])) {
          $ipaddress = $_SERVER['HTTP_FORWARDED'];
      } else if(isset($_SERVER['REMOTE_ADDR'])) {
          $ipaddress = $_SERVER['REMOTE_ADDR'];
      }
      return $ipaddress;
	}
    /** Get User Browser Lang **/
	public function hl() 
	{
		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
			foreach ($langs as $value){
				$hl = substr($value, 0, 2);
	            return $hl;
			 }
		}
	  return null;
	}	


    /**
     * get function
     * os = user System
     * br = user Browser
     * ip = user ip
     * hl = user browser lang
     * ua = http user agent
     * @return array
     */ 
	public function all() 
	{
		return array(
			'os'=> $this->os(), 
			'br'=> $this->br(),
			'ip'=> $this->ip(),
			'ua'=> $this->ua(),
			'hl'=> $this->hl()
		);
	}
  /**
   * Get User Info By IP 
   * @param str $ip
   * @return array
   */ 
  public function ip_info($ip = NULL) 
  {
		if ($ip === NULL) {
			$ip = $this->_userIP();
		}
		$decode = @json_decode(file_get_contents('http://www.geoplugin.net/json.gp?ip='.$ip));
		$jsdecode = @json_decode(file_get_contents('http://ip-api.com/json/'.$ip));
			@$return = array(
				"countryCode" => $decode->geoplugin_countryCode,
				"countryName" => $decode->geoplugin_countryName,
				"continentCode" => $decode->geoplugin_continentCode,
				"currencyCode" => $decode->geoplugin_currencyCode,
				"currencySymbol" => $decode->geoplugin_currencySymbol_UTF8,
				"city" => $jsdecode->city,
				"isp" => $jsdecode->isp,
				"lat" => $jsdecode->lat,
				"lon" => $jsdecode->lon,
				"org" => $jsdecode->org,
				"region" => $jsdecode->region,
				"timezone" => $jsdecode->timezone,
		    );
	   return $return;
	}

    /**
     * _loop_match
     * @param Str $data
     * @return str
     */ 
	protected function _loop_match($data) 
	{
		$return = 'Unknown';
          foreach ($data as $reg => $val) { 
	        if (preg_match('/'.$reg.'/i', strtolower($this->ua()))) {
	            $return = $val;
	        }
	      }   
	    return $return;
	}

    /**
     * _match
     * @param str $data
     * @return Bool
     */ 
	protected function _match($data) 
	{
		return preg_match('/'.$data.'/i', strtolower($this->ua()), $this->n);
	}


}