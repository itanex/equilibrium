<?php
	//include required class files
	require_once("_dir_config.php");
	$page_title = "Index/Login";
	
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
		<td valign="top"><h1>Welcome to Equilibrium</h1>
      <p class="genText">Thank you for choosing Equilibrium as your Content Management 
        System solution. You can view the activitity for the last day below. To 
        return here click the <span class="genText">Control Panel 
        Index menu</span> item to the left. The panel on the left provides you with 
        access to the features that will allow you to manage your website. There 
        are instructions on each page and an extended version in the help directory.</p>
      <p class="alert">Please note that this application requires the use of 
	 cookies. Please enable cookies before you attempt to log in.</p>
<?php
	//present login form if user is not logged in
	if(!$logged){
		require_once($my_root."inc/user_login.php");
		
		//present alert to user for errors
		if(isset($_SESSION['failed_log'])){
			require_once($my_root."inc/ntc_login_fail.php");
		}else if(isset($_SESSION['disabled_admin'])){
			require_once($my_root."inc/ntc_account_diabled.php");
		}else if(isset($_SESSION['accnt_update'])){
			require_once($my_root."inc/ntc_account_update.php");
		}
		
		$user_obj->kill_session();//kill session to prevent repeated alert on refresh
	}
	
	//present the activity table apropriate to user access
	if($logged){
		//load activity table heading
		$tpl->loadTemplateFile($my_root."templates/act_list_head_logged_tpl.php");
		$tpl->loadVar("heading", "Recent Activities");
		$tpl->parseTpl();
		echo $tpl->returnParsed();
		$tpl->unLoadTemplate();
		
		//load activity table body
		$result = mysql_query($current_act_list);
		$tpl->loadTemplateFile($my_root."templates/act_list_tpl.php");
		while($row = mysql_fetch_assoc($result)){
			if(date("M j, Y", strtotime($row['updated'])) == date("M j, Y")){
				$tpl->loadVar("username", stripslashes($row['username']));
				$tpl->loadVar("ipaddress", $row['ipaddress']);
				$tpl->loadVar("updated", $row['updated']);
				$tpl->loadVar("activity", stripslashes($row['activity']));
				
				$tpl->parseTpl();
				echo $tpl->returnParsed();
				$tpl->unLoadVars();
			}
		}
		$tpl->unLoadTemplate();
	}else{
		//load activity table heading
		$tpl->loadTemplateFile($my_root."templates/act_list_head_nolog_tpl.php");
		$tpl->loadVar("heading", "Recent Activities");
		$tpl->parseTpl();
		echo $tpl->returnParsed();
		$tpl->unLoadTemplate();
		require_once($my_root."inc/act_list_nolog.php");
	}
	
	//loaf activity table footer
	require_once($my_root."inc/act_list_foot.php");
?>
		<?php require($my_root."inc/copynotice.php"); ?></td>
	</tr>
</table>
</body>
</html>