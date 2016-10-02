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

class Crypt
{

    private $key, $cipher, $mode;

    /**
     * [__construct description]
     * @param string $key    crypt key
     * @param string $cipher cipher name
     * @param string $mode   mode name
     */
    public function __construct($key, $cipher = MCRYPT_RIJNDAEL_128, $mode = MCRYPT_MODE_CBC) 
    {
        $this->key    = md5($key);
        $this->cipher = $cipher;
        $this->mode   = $mode;
    }

    /**
     * encrypt
     * @param  string $str 
     * @return string
     */
    public function encrypt($str) 
    {
        $ivSize = mcrypt_get_iv_size($this->cipher, $this->mode);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_DEV_URANDOM);
        $cryptxt = mcrypt_encrypt($this->cipher, $this->key, $str, $this->mode, $iv);
        return $iv.$cryptxt;
    }

    /**
     * decrypt
     * @param  string $cryptxt 
     * @return string
     */
    public function decrypt($cryptxt) 
    {
        $ivSize = mcrypt_get_iv_size($this->cipher, $this->mode);
        if (strlen($cryptxt) < $ivSize) {
            throw new \Exception('Missing initialization vector');
        }

        $iv = substr($cryptxt, 0, $ivSize);
        $cryptxt = substr($cryptxt, $ivSize);
        $str = mcrypt_decrypt($this->cipher, $this->key, $cryptxt, $this->mode, $iv);
        return rtrim($str, "\0");
    }

}