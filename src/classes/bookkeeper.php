<?php
/*---------------------------------------------------------
/ Class: BookKeeper
/ Author: Bryan Wood
/ Date: October 18, 2004
/ 
/ To keep all the records of who and what they do this 
/ class will be utilized. Everytime a successfull event 
/ occurs a record of the user, what event, and when it
/ happened will be recorded into the database. This class
/ depends on the past_activity table to exist and that its 
/ version is compliant with the version of this class.
---------------------------------------------------------*/

class BookKeeper {
	//*****************************************************************************
	// Variable List Start
	//*****************************************************************************	
	var $insert_record_sql = "";
	//*****************************************************************************
	// Variable List End
	//*****************************************************************************
	
	/*-------------------------------------------
	/ Class constructor 
	/---------------
	/ ~Bryan Wood
	/------------------------------------------*/
	function BookKeeper(){
		$this->insert_record_sql = "INSERT INTO past_activity(u_id, activity, ipaddress, updated) VALUES('%s', '%s', '%s', NOW())";
	}
	
	function record_event($event){
		mysql_query(sprintf($this->insert_record_sql, $_SESSION['u_id'], addslashes($event), $_SERVER['REMOTE_ADDR'])) or die(mysql_error()."<br>".sprintf($this->insert_record_sql, $_SESSION['user'], $event, $_SERVER['REMOTE_ADDR']));
	}

}//end BookKeeper Class
?>