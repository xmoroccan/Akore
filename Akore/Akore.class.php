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

namespace Akore;

final class Akore 
{

	private $http, $session, $database;

	private $uri, $requestURI, $requestKey, $path1, $path2, $isIndex;

	private $uriArray = array();

	private $routeType = 1;

  /**
   * __construct Akore
   * @param array $routes
   */
	public function __construct(array $routes) 
   {

   	/**
   	 * unset _REQUEST, _ENV, GLOBALS
   	 */
		unset($_REQUEST, $_ENV, $GLOBALS);

		/**
		 * Http 
		 * @var Object
		 */
		$this->http = new Http;

		/**
		 * Request URI
		 * @var string
		 */
		$this->uri = $this->http->URI();

		/**
		 * is valid URI
		 */
		if ( !preg_match('/^[A-Za-z0-9-_.?=&\/]+$/', $this->uri) || preg_match('/\/\//', $this->uri) ) {

			$this->err(406);
			exit;
		}

		/**
		 * Parse Request URI
		 * @var string
		 */
		$this->uri = parse_url($this->uri, PHP_URL_PATH);

		/**
		 * Remove end /
		 * @var string
		 */
		$this->requestURI = rtrim($this->uri, '/');

		/**
		 * URI Array 
		 * @var Array
		 */
		$this->uriArray = explode('/', $this->requestURI);
		unset($this->uriArray[0]);

		/**
		 * Request Path 1
		 * @var string
		 */
		$this->path1 = $this->path(1);

		/**
		 * Is index
		 * @var boolean
		 */
		$this->isIndex = is_null($this->path1) || empty($this->path1);

		/**
		 * Request key 
		 * @var string
		 */
		$this->requestKey = ($this->isIndex === true) ? '/' : $this->path1;

		/**
		 * is valid Request
		 */
		if ( !array_key_exists($this->requestKey, $routes) ) {

			$this->err(404);
			exit;

		} 

		/**
		 * is valid method
		 */
		if ( is_array($routes[$this->requestKey][0]) ) {

			if ( !in_array($this->http->REQUEST_METHOD, $routes[$this->requestKey][0]) ) {

	         $this->err(405);
				exit;
		   }
		
		} elseif ( $routes[$this->requestKey][0] !==  $this->http->REQUEST_METHOD ) {

         $this->err(405);
			exit; 
		}

		/**
		 * is valid Request
		 */
		if ( is_array($routes[$this->requestKey][1]) ) {

			$this->routeType = 2;
			$this->path2     = $this->path(2);
			$this->path2     = (is_null($this->path2) || empty($this->path2)) ? '/' : $this->path2; 

			if ( !array_key_exists($this->path2, $routes[$this->requestKey][1]) ) {

				$this->err(404);
				exit;
			
			} 

		} 

		/**
		 * path limit
		 */
		if ( count($this->uriArray) > $routes[$this->requestKey][2] + 1 ) {

			$this->err(404);
			exit;
		}

		/**
		 * Start
		 */
		$this->start($routes);

	}


	/**
	 * Start App
	 * @return void
	 */
	private function start($routes)
	{  

		$requestlower = strtolower($this->http->REQUEST_METHOD);
		$requestFile  = APP_DIR . DS . 'Requests' . DS; 
		$requestFile .= ( $this->routeType === 2 ) ? ucfirst($this->path1) . DS . $requestlower . '.' . $routes[$this->requestKey][1][$this->path2] : $requestlower . '.' . $routes[$this->requestKey][1];
		$requestFile .= '.php';

		unset($this->routeType, $this->path1, $requestlower, $routes, $this->requestKey);

	   if ( file_exists($requestFile) === true ) {

	   	$this->session  = new \Akore\Data\Session;
		   $this->database = new \Akore\Database\Mysqli(DB_NAME, DB_USER, DB_PASS, DB_HOST, DB_PREFIX);
		   require_once($requestFile);
      	unset($requestFile, $this->database, $this->session);

      } else {

      	$this->err();
      	exit;
      }

	}

  /**
   * redirect 
   * @param  string  $url
   * @param  string  $type
   * @param  integer $refresh
   * @return void
   */
	public function redirect($url, $type = 'header', $refresh = 0) 
  {

		switch ($type) {

		case 'header':

			if ( !$this->http->sent() ) {

				$this->http->Location($url);

			} else {

				echo '<script type="text/javascript">window.location.href="' . $url . '"</script>';
			}

			break;
		case 'js':

			echo '<script type="text/javascript">window.location.href="' . $url . '"</script>';

			break;
		case 'html':

			echo '<meta http-equiv="refresh" content="' . $refresh . '; url=' . $url . '" />';

			break;
		}

	}

  /**
   * err [redirect to error page]
   * @param  string $err 
   * @return void
   */
	public function err($err = 'error') 
   {
		$this->redirect(WEB_URL . '/error.php?err=' . $err);
	}

  /**
   * toUtf8 [ convert string to utf-8]
   * @param  string $str 
   * @return string
   */
	public function toUtf8($str)
   {
		return mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
	}

  /**
   * get Page URL
   * @param  boolean $q [ return page url & query]
   * @return string
   */
	public function pageURL($query = false) 
   {
		return ($query === true) ? WEB_URL . $this->http->URI()  : WEB_URL . $this->requestURI;
	}

  /**
   * get path
   * @param  integer $id 
   * @return string || null
   */
	public function path($id) 
  {

		if (isset($this->uriArray[$id]) && !empty($this->uriArray[$id])) {

			return str_replace(array('"', "'", '&', '*', '--', '<', '>', '@', '!', '`', '(', ')', '..', ';', ',', '|', '\\', ' ', '[', ']'), '', $this->uriArray[$id]);
		}

		return null;
	}

}