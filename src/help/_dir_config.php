<?php
/*---------------------------------------------------
/ This file holds all the special variables and 
/ configurations that are required for this dirctory
---------------------------------------------------*/
	$my_root = "../";
	
	/*---------------------------------------------------
	/ include all required files
	---------------------------------------------------*/
	require_once($my_root."_config.php");
	
	/*---------------------------------------------------
	/ define all required sql statements 
	---------------------------------------------------*/

	/*---------------------------------------------------
	/ create all required variables
	---------------------------------------------------*/
	$logged = $user_obj->check_session(false); //generate a logged var
?>