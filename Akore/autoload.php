<?php defined('ROOT') || exit;

spl_autoload_register(function ($obj) {
   
   $class = ROOT . DS . str_replace('\\', DS, $obj) . '.class.php';

   if( file_exists($class) && !class_exists($obj) ) {

     require_once($class);

     unset($obj, $class);
   }

});