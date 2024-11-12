<?php
/*---------------------------------------------------
/ This file holds all the special variables and 
/ configurations that are required for this dirctory
---------------------------------------------------*/
	$my_root = "";
	
	/*---------------------------------------------------
	/ include all required files
	---------------------------------------------------*/
	require_once($my_root."_config.php");
	
	/*---------------------------------------------------
	/ define all required sql statements 
	---------------------------------------------------*/
	$current_act_list = "SELECT * FROM past_activity, user_accts WHERE past_activity.u_id=user_accts.u_id ORDER BY updated DESC LIMIT 15";

	/*---------------------------------------------------
	/ create all required variables
	---------------------------------------------------*/
	$logged = $user_obj->check_session(); //generate a logged var
?>