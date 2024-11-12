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
	$user_act_spc = "SELECT * FROM past_activity WHERE u_id='%s' ORDER BY updated DESC";
	$user_act_spc_all = "SELECT * FROM past_activity LEFT JOIN user_accts ON user_accts.u_id=past_activity.u_id ORDER BY updated DESC";
	$user_list_by_name = "SELECT u_id, username FROM user_accts ORDER BY username";	
	$all_user_list = "SELECT * FROM user_accts";
	$get_all_user_sql = "SELECT * FROM user_accts LEFT JOIN user_profile ON user_accts.u_id=user_profile.u_id WHERE user_accts.u_id='%s'";

	/*---------------------------------------------------
	/ create all required variables
	---------------------------------------------------*/
	$logged = $user_obj->check_session(); //generate a logged var
	
	/*---------------------------------------------------
	/ bookkeeper strings
	---------------------------------------------------*/
	$user_create_note = "<b>USER MANAGEMENT</b>: <b>%s</b> was created.";
	$user_create_fail = "<b>USER MANAGEMENT</b>: <b>%s</b> was not created.";
	$user_delete_note = "<b>USER MANAGEMENT</b>: <b>%s</b> was deleted.";
	$user_delete_fail = "<b>USER MANAGEMENT</b>: <b>%s</b> was not deleted.";
	
	$user_disable_note = "<b>USER MANAGEMENT</b>: user(%s) - <b>%s</b> was disable.";
	$user_disable_fail = "<b>USER MANAGEMENT</b>: user(%s) - <b>%s</b> was not disable.";	
	$user_enable_note = "<b>USER MANAGEMENT</b>: user(%s) - <b>%s</b> was enabled.";
	$user_disable_fail = "<b>USER MANAGEMENT</b>: user(%s) - <b>%s</b> was not enabled.";
	
	$user_edit_name_note = "<b>USER MANAGEMENT</b>: user(%s) - <b>%s</b> username was updated.";
	$user_edit_name_fail = "<b>USER MANAGEMENT</b>: user(%s) - <b>%s</b> username was not updated.";
	$user_edit_pass_note = "<b>USER MANAGEMENT</b>: user(%s) - <b>%s</b> password was updated.";
	$user_edit_pass_fail = "<b>USER MANAGEMENT</b>: user(%s) - <b>%s</b> password was not updated.";
	
	$user_edit_prof_note = "<b>USER MANAGEMENT</b>: user(%s) - <b>%s</b> profile was updated.";
	$user_edit_prof_fail = "<b>USER MANAGEMENT</b>: user(%s) - <b>%s</b> profile was not updated.";
	$user_edit_level_note = "<b>USER MANAGEMENT</b>: user(%s) - <b>%s</b> level was updated.";
	$user_edit_level_fail = "<b>USER MANAGEMENT</b>: user(%s) - <b>%s</b> level was not updated.";
	
?>