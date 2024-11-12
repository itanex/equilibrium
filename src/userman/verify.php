<?php
	//include required class files
	require_once("_dir_config.php");
	
	if(!$user_obj->check_session()){
		$user_obj->login($_POST['frm_user'], $_POST['frm_pass']);
	}
	header("Location: ".$my_root."index.php");
?>