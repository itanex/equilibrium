<?php
	//include required class files
	require_once("_dir_config.php");
	
	if($logged){
		$user_obj->kill_session();
	}
	
	header("Location: ".$my_root."index.php");
?>