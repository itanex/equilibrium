<?php
	//include required class files
	require_once("_dir_config.php");
	$page_title = "User Activity";
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
		<td valign="top"><h1>User Activity</h1>
		
      <p class="genText">Select a user to display activity for that user.</p>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><p class="genText">Select a user </p></td>
			<td><p class="genText">
			<select name="frm_user" class="submitButton">
				<option value="0">View All Activities</option>
<?php
	$result = mysql_query($user_list_by_name);
	while($row = mysql_fetch_assoc($result)){
?>
				<option value="<?php echo $row['u_id']; ?>"<?php if(isset($_POST['frm_user']) && $_POST['frm_user'] == $row['u_id']){ echo " SELECTED"; } ?>><?php echo $row['username']; ?></option>
<?php
	}
?>
			</select>
			<input type="submit" name="frm_submit" value="Get User Activity" class="submitButton">
			</p></td>
		</tr>
	</table>
	</form>
<?php	
	//load activity table body
	$view_user = ((isset($_POST['frm_user'])) ? $_POST['frm_user'] : $_SESSION['u_id']);
	if($view_user == 0){
		//load activity table heading
		include_once($my_root."inc/user_act_head_all.php");
		$view_acts = $user_act_spc_all;
		$act_list_all = "user_act_list_all_tpl";
	}else{
		//load activity table heading
		include_once($my_root."inc/user_act_head.php");
		$act_list_all = "user_act_list_tpl";
		$view_acts = sprintf($user_act_spc, $view_user);
	}
	
	$result = mysql_query($view_acts);
	$tpl->loadTemplateFile($my_root."templates/".$act_list_all.".php");
	while($row = mysql_fetch_assoc($result)){
		$tpl->loadVar("username", stripslashes($row['username']));
		$tpl->loadVar("ipaddress", $row['ipaddress']);
		$tpl->loadVar("updated", $row['updated']);
		$tpl->loadVar("activity", stripslashes($row['activity']));
		
		$tpl->parseTpl();
		echo $tpl->returnParsed();
		$tpl->unLoadVars();
	}
	$tpl->unLoadTemplate();
	
	//load activity table footer
	include_once($my_root."inc/user_act_foot.php");
?>
		<?php include($my_root."inc/copynotice.php"); ?></td>
	</tr>
</table>
</body>
</html>