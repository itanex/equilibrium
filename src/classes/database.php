<?php
	define("DB_DATABASE", "dbname"); //database name

	function connect_mysql($dbname = DB_DATABASE){
		mysql_connect("dbhostip", "dbusername", "dbuserpass") or die("DATABASE FAILURE: Connection refused.<br>".mysql_error());
		mysql_select_db($dbname) or die("DATABASE FAILURE: Database unavailable.<br>".mysql_error());
	}
?>
