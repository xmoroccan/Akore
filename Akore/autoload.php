<?php defined('ROOT') || exit;
/**
 * Akore PHP Framework
 * @package   Akore
 * @author    Mohamed Elbahja <Mohamed@elbahja.me>
 * @copyright 2016 Dinital Production 
 * @version   1.1
 * @link http://www.dinital.com
 * @license http://opensource.org/licenses/MIT  MIT License
 */

spl_autoload_register(function ($obj) {
   
   $class = ROOT . DS . str_replace('\\', DS, $obj) . '.class.php';

   if( file_exists($class) && !class_exists($obj) ) {

     require_once($class);

     unset($obj, $class);
   }

});