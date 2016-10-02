<?php
/**
 * Akore PHP Framework
 * @package   Akore
 * @author    Mohamed Elbahja <Mohamed@elbahja.me>
 * @copyright 2016 Akore
 * @version   1.0
 * @link      http://www.elbahja.me
 */

namespace Akore\Libs\Loginer;

class Loginer
{

	protected $login_type, $users_table, $db, $userid;

	protected $config = array();

	public function __construct($login_type, $db)
	{
		$this->login_type = $login_type;
		$this->db = $db;
	}

	public function get_login_file()
	{

		if(file_exists(CORE_DIR . DS . 'Libs' . DS . 'Loginer' . DS . $this->login_type .'_login.php')) {

			return CORE_DIR . DS . 'Libs' . DS . 'Loginer' . DS . $this->login_type .'_login.php';

		} 

		return false;

	}

	public function login_user($data)
	{

		$email = $this->db->escape($data['email']);
		$id    = $this->db->escape($data['usr_key']); 
		$type  = $this->db->escape($data['type']); 
		$usr = $this->db->select_one('*', 'users', "WHERE type='$type' AND usr_key='" . $id . "'");

		if(is_null($usr)) {

			if($this->db->insert('users', $data)) {
				$_SESSION['user_id']   = $this->db->insert_id;
				$_SESSION['user_type'] = $type;
				return true;
			} else {
				return false;
			}

		} else {

			if($this->db->update('users', $data, "WHERE type='$type' AND email='" . $email . "' OR usr_key='" . $id . "'")) {
				$_SESSION['user_id']   = $usr['user_id'];
				$_SESSION['user_type'] = $type;
				return true;

			} else {

				return false;
			}
		}
	}

}