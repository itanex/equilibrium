<?php
/*---------------------------------------------------------
/ Class: Database Manager
/ Author: Bryan Wood
/ Date: February 16, 2004
/ Updated: February 23, 2005
/
/ DEVELOPER NOTE: This class is designed to work with any
/ site using the MySQL database. Currently it has only been
/ tested on 4.2.x versions of MySQL. I would enjoy feedback
/ and any notes for expanding the support and functionality
/ of this database manager class.
/
/ This class is designed to manage any interaction with
/ a websites database. I have set aside function that will
/ manage the basic query string types (SELECT, INSERT,
/ UPDATE, DELETE). My goal was to develop a set of functions
/ wrapped into a class that I could use to trap database errors
/ and prevent overloading website access via a page with
/ unneeded tests for success and appropriate return values.
---------------------------------------------------------*/

	class Database_Manager{
		//required database variables
		var $ip_address = "";
		var $db_user = "";
		var $db_pass = "";

		//database used
		var $database = array();

		function database_manager(){
			$this->db_user[0] = "dbusername";
			$this->db_pass[0] = "dbuserpass";
			$this->database[0] = "dbname";
			$this->db_user[1] = "dbusername2";
			$this->db_pass[1] = "dbuserpass2";
			$this->database[1] = "dbname2";
			$this->db_host = "dbhostip";
		}

		function connect($use_db = 1){
			if(mysql_connect($this->db_host, $this->db_user[0], $this->db_pass[0])){
				return $this->use_db($use_db);
			}
			return false;
		}

		function use_db($db_ref){
			if(mysql_select_db($this->database[$db_ref])){
				return true;
			}
			return false;
		}

		function add_db_ref($db_name){
			array_push($this->database, $db_name);
		}

		function run_select($query_string){
			if($result = mysql_query($query_string)){
				return $result;
			}
			return false;
		}

		function run_insert($query_string){
			if($result = mysql_query($query_string)){
				return $result;
			}
			return false;
		}

		function run_update($query_string){
			if($result = mysql_query($query_string)){
				return $result;
			}
			return false;
		}
	}
?>