<?php
/**
* @author Mohamed Elbahja <Mohamed@elbahja.me>
* @copyright 2016 
* @version 2.0
* @package MySQLi_Manager 
* @category Database
*/

namespace Akore\Database; 

final class Mysqli extends \mysqli 
{

    /**
     * [$insert_ids get multiInsert() insert id's]
     * @var array
     */
	public $insert_ids = array();

	private $dbConnect, $dbName, $dbUser, $dbPass, $dbHost, $prefix;

    /**
     * __construct
     * @param string $db     database name
     * @param string $user   database username
     * @param string $pass   database password
     * @param string $host   database host
     * @param string $prefix tables prefix
     */
	public function __construct($db, $user, $pass, $host = 'localhost', $prefix = '') 
    {
        $this->dbName = $db;
        $this->dbUser = $user;
        $this->dbPass = $pass;
        $this->dbHost = $host;
        $this->prefix = $prefix;  
    }
     
    
    /**
     * Connect database
     * @return void
     */
    public function start() 
    {

        $this->dbConnect = parent::__construct($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);

        if ( $this->connect_error ) throw new \Exception(' Failed Connect to MySQL Database <br /> Error Info : ' . $this->connect_error);
        
        $this->set_charset('utf8');        
    }


    /**
     * [toUtf8 Convert String to utf8]
     * @param  string $String 
     * @return string
     */
	protected function toUtf8($String) 
    {
	    return mb_convert_encoding($String, 'UTF-8', mb_detect_encoding($String));     
    }
    
    /**
     * [escape : escape data]
     * @param  string $data
     * @return string
     */
	public function escape($data, $type = 'str') 
    {

        $data = $this->toUtf8($data);

        if( get_magic_quotes_gpc() ) {
            $data = stripslashes($data);
        }

        if( $type === 'int' ) {

            return (int) $this->real_escape_string($data);
        }

        return $this->real_escape_string($data);
    }

    /**
     * [select : select data]
     * @param  string $select [columns ex: username, pass, email ....]
     * @param  string $from   [table name]
     * @param  string $where  [optional  ex: WHERE id='1']
     * @return object
     */
    public function select($select, $from, $where = '') 
    {
        $sql = 'SELECT ' . $select . ' FROM ' . $this->prefix . $from . ' ' . $where;
   	  	return $this->query($sql);
    }

    /**
     * [selectOne : select 1 row]
     * @param  string $select [columns ex: website_name, website_url, description ....]
     * @param  string $from   [table name]
     * @param  string $where  [optional]
     * @param  string $fetch  [fetch_assoc() = assoc ; fetch_row = row ; fetch_object = object]
     * @return mixed [if $fetch == assoc || row, return array ; if $fetch == object, return object; if $data == false return null]
     */
    public function selectOne($select, $from, $where = '', $fetch = 'assoc') 
    {

        $fetch = 'fetch_' . $fetch;
        $return = null;

        if ($data = $this->select($select, $from,  $where . ' LIMIT 1')) {

        	$return = $data->$fetch();
            $data->close();
        }

        unset($select, $from, $where);
        return $return;	
    }

   /**
    * [insert : insert data]
    * @param  string $into  [table name]
    * @param  array  $array [data , associative array : key = column and value = column value]
    * @return boolean
    */
    public function insert($into, array $array) 
    {

        $data   = array();

		foreach ($array as $key => $value) {
			$data[] = $this->escape($key) . "='" . $this->escape($value) . "'";
		}

		$data = implode(', ', $data);

        $sql  = 'INSERT INTO ' . $this->prefix . $into . ' SET ' . $data;

        unset($into, $array, $data);

		if ( $this->query($sql) ) return true;

		return false;  
    }  

    /**
     * [multiInsert Multi Insert data]
     * @param  string $into  [tablse name]
     * @param  array  $array [data , Multidimensional Associative Array]
     * @return boolean
     */
 	public function multiInsert($into, array $array) 
    {

        foreach( $array as $val ) {

            if( !is_array($val) ) return false; 
        }

        foreach ( $array as $key => $value ) {

            $this->insert_ids[$key] = ( $this->insert($into, $value) === true ) ? $this->insert_id : false;
        }

		unset($into, $array, $ids);

        $fIds = array_filter($this->insert_ids);

		if ( !empty($fIds) ) return true;

	    return false; 		
	} 

    /**
     * [update : update data]
     * @param  string $table [table name]
     * @param  array $array  [data , associative array : key = column and value = column value]
     * @param  string $where [optional]
     * @return boolean
     */
	public function update($table, $array, $where = '') 
    {

        $data   = array();

		foreach ($array as $key => $value) {
			$data[] = $this->escape($key) . "='" . $this->escape($value) . "'";
		}

	   $data = implode(', ', $data);

       $sql  = 'UPDATE ' . $this->prefix . $table . ' SET ' . $data . ' ' . $where; 

       unset($table, $array, $where, $data);

       if ( $this->query($sql) ) return true;

	   return false;	   
	}

   /**
    * [delete : delete data]
    * @param  string $from  [tabel name]
    * @param  string $where [optional]
    * @return boolean
    */
	public function delete($from, $where = '') 
    {

		$sql = 'DELETE FROM ' . $this->prefix . $from . ' ' . $where;

        unset($from, $where);

        if ( $this->query($sql) ) return true;

        return false;
	}	 

 }