<?php
	//include required class files
	require_once("_dir_config.php");
	$page_title = "User List";
	
	if(isset($_POST['frm_disable'])){
		$bkr->record_event(sprintf($user_disable_note, $_POST['frm_uid'], $_POST['frm_user']));
		$edit_err = $user_obj->update_disable($_POST, 1);
	}else if(isset($_POST['frm_enable'])){
		$bkr->record_event(sprintf($user_enable_note, $_POST['frm_uid'], $_POST['frm_user']));
		$edit_err = $user_obj->update_disable($_POST, 0);
	}else if(isset($_POST['frm_delete'])){
		$bkr->record_event(sprintf($user_delete_note, $_POST['frm_uid'], $_POST['frm_user']));
		$edit_err = $user_obj->delete_user($_POST);
	}
?>
<html lang="EN">
<?php
	$tpl->loadTemplateFile($my_root."templates/all_pg_head.php");
	$tpl->loadVar("pg_title", $app_title.$app_copyright.$page_title);
	$tpl->loadVar("css", $my_root."css/cms.css");
	$tpl->parseTpl();
	echo $tpl->returnParsed();
	$tpl->unLoadTemplate();
?>
<body>
<table width="90%" border="0" cellpadding="2" cellspacing="0">
	<tr> 
		<td width="150" valign="top" align="center">
			<a href="<?php echo $my_root; ?>index.php"><img src="<?php echo $my_root; ?>images/cmslogo.gif" border="0"></a>
			<br>
<?php
	require_once($my_root."util/nav.php");
	require($my_root."inc/copynotice.php");
?>
		</td>
		<td valign="top"><h1>User List</h1>
		<p class="genText">You are now viewing all registered users.</p>
<?php
	if(isset($edit_err)){
		$tpl->loadTemplateFile($my_root."templates/user_alert_tpl.php");
		$tpl->loadVar("alert", $edit_err);
		$tpl->parseTpl();	
		echo $tpl->returnParsed();	
		$tpl->unLoadTemplate();
	}	
	
	include_once($my_root."inc/user_list_head.php");
	//load activity table body				
	$result = mysql_query($all_user_list);
	$tpl->loadTemplateFile($my_root."templates/user_list_tpl.php");
	while($row = mysql_fetch_assoc($result)){
		if(!$row['disabled']){
			$tpl->loadVar("sub_frm", "frm_disable");
			$tpl->loadVar("view", "Disable");
		}else{
			$tpl->loadVar("sub_frm", "frm_enable");
			$tpl->loadVar("view", "Enable");
		}
		$tpl->loadVar("u_id", $row['u_id']);
		$tpl->loadVar("username", stripslashes($row['username']));
		$tpl->loadVar("last_on", $row['last_on']);
		$tpl->loadVar("level", $user_obj->access_levels[$row['level']]);
		$tpl->loadVar("my_root", $my_root);
		$tpl->loadVar("self", $_SERVER['PHP_SELF']);
		
		$tpl->parseTpl();
		echo $tpl->returnParsed();
		$tpl->unLoadVars();
	}
	$tpl->unLoadTemplate();
	include_once($my_root."inc/user_list_foot.php");
?>
		<?php include($my_root."inc/copynotice.php"); ?></td>
	</tr>
</table>
</body>
</html>