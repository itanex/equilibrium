<?php
	//include required class files
	require_once("_dir_config.php");
	$page_title = "Edit User Profile";

	$valid_color = "genText";
	$invalid_color = "alert";
	
	$required1 = array("frm_user");
	$regex1 = array("frm_user" => "^[a-zA-Z0-9]{6,32}$");	
	$colors1 = array("frm_user" => $valid_color);
	
	$required2 = array("frm_pass");	
	$regex2 = array("frm_pass" => "^[a-zA-Z0-9]{6,32}$");	
	$colors2 = array("frm_pass" => $valid_color);
	
	$required3 = array(
		"frm_email",
		"frm_phone",
		"frm_addr1",
		"frm_addr2",
		"frm_city",
		"frm_state",
		"frm_zip"
	);	
	$regex3 = array(
		"frm_email" => "^([-a-z0-9_:@&?=+,.!/~*'%$]+@[-a-z0-9_:@&?=+,.!/~*'%$]+.[-a-z0-9_:@&?=+,.!/~*'%$]+){0,1}$",
		"frm_phone" => "^[0-9]{0,15}$",
		"frm_addr1" => "^[-a-zA-Z0-9 #&,.]{0,32}$",
		"frm_addr2" => "^[-a-zA-Z0-9 #&,.]{0,32}$",
		"frm_city" => "^[a-zA-Z ]{0,32}$",
		"frm_state" => "^[a-zA-Z]{0,2}$",
		"frm_zip" => "^[0-9]{0,9}$"
	);	
	$colors3 = array(
		"frm_email" => $valid_color,
		"frm_phone" => $valid_color,
		"frm_addr1" => $valid_color,
		"frm_addr2" => $valid_color,
		"frm_city" => $valid_color,
		"frm_state" => $valid_color,
		"frm_zip" => $valid_color
	);
	
	$required4 = array("frm_level");	
	$regex4 = array("frm_level" => "^[0-9]{1}$");	
	$colors4 = array("frm_level" => $valid_color);
	
	$contents = array(
		"frm_user" => "",		
		"frm_pass" => "",
		"frm_email" => "",
		"frm_phone" => "",
		"frm_addr1" => "",
		"frm_addr2" => "",
		"frm_city" => "",
		"frm_state" => "",
		"frm_zip" => "",
		"frm_level" => ""
	);
		
	function validate($required, $regex, &$colors){
		global $contents, $invalid_color;
		$validated = true;
		
		foreach($required as $req){
			if(!ereg($regex[$req], $_POST[$req])){
				$validated = false;
				$colors[$req] = $invalid_color;
			}
			$contents[$req] = $_POST[$req];
		}
		return $validated;
	}
	
	$result = mysql_query(sprintf($get_all_user_sql, $_POST['frm_uid']));
	if(mysql_num_rows($result) == 1){
		$row = mysql_fetch_assoc($result);
		$contents['frm_user'] = $row['username'];
		$contents['frm_email'] = $row['email'];
		$contents['frm_phone'] = $row['phone'];
		$contents['frm_addr1'] = $row['address1'];
		$contents['frm_addr2'] = $row['address2'];
		$contents['frm_city'] = $row['city'];
		$contents['frm_state'] = $row['state'];
		$contents['frm_zip'] = $row['zip'];
		$contents['frm_level'] = $row['level'];
	}else{
		$edit_err = "There was an error retrieving the user account from the database.";
	}
		
	if(isset($_POST['frm_edit_name'])){
		if(validate($required1, $regex1, $colors1, $contents1)){
			if(!$user_obj->unique_user($_POST['frm_user'])){
				$bkr->record_event(sprintf($user_edit_name_note, $_POST['frm_uid'], $_POST['frm_user']));
				$edit_err = $user_obj->update_name($_POST);
			}else{
				$bkr->record_event(sprintf($user_edit_name_fail, $_POST['frm_uid'], $_POST['frm_user']));
				$edit_err = "The username ".$_POST['frm_user']." is already in use.";
			}
		}else{
			$edit_err = "Please insure that fields labeled in red contain a valid entry.";
		}
	}else if(isset($_POST['frm_edit_pass'])){
		if(validate($required2, $regex2, $colors2, $contents2)){
			$bkr->record_event(sprintf($user_edit_pass_note, $_POST['frm_uid'], $_POST['frm_user']));
			$edit_err = $user_obj->update_password($_POST);
		}else{
			$bkr->record_event(sprintf($user_edit_pass_fail, $_POST['frm_uid'], $_POST['frm_user']));
			$edit_err = "Please insure that fields labeled in red contain a valid entry.";
		}
	}else if(isset($_POST['frm_edit_profile'])){
		if(validate($required3, $regex3, $colors3, $contents3)){
			$bkr->record_event(sprintf($user_edit_prof_note, $_POST['frm_uid'], $_POST['frm_user']));
			$edit_err = $user_obj->update_profile($_POST);
		}else{
			$bkr->record_event(sprintf($user_edit_prof_fail, $_POST['frm_uid'], $_POST['frm_user']));
			$edit_err = "Please insure that fields labeled in red contain a valid entry.";
		}
	}else if(isset($_POST['frm_edit_level'])){
		if(validate($required4, $regex4, $colors4, $contents4)){
			$bkr->record_event(sprintf($user_edit_level_note, $_POST['frm_uid'], $_POST['frm_user']));
			$edit_err = $user_obj->update_level($_POST);
		}else{
			$bkr->record_event(sprintf($user_edit_level_fail, $_POST['frm_uid'], $_POST['frm_user']));
			$edit_err = "Please insure that fields labeled in red contain a valid entry.";
		}
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
		<td valign="top"><h1>Edit User Profile</h1>
		<p class="genText">Use the following fields to update any information for this user profile.</p>
<?php
	if(isset($edit_err)){
		$tpl->loadTemplateFile($my_root."templates/user_alert_tpl.php");
		$tpl->loadVar("alert", $edit_err);
		$tpl->parseTpl();
		echo $tpl->returnParsed();
		$tpl->unLoadTemplate();
	}
?>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
		<input type="hidden" name="frm_uid" value="<?php echo $_POST['frm_uid']; ?>">
		<input type="hidden" name="frm_username" value="<?php echo $row['username']; ?>">
			<tr>
				<td width="20%"><p class="<?php echo $colors1['frm_user']; ?>">Username: </p></td>
				<td width="80%"><p class="<?php echo $colors1['frm_user']; ?>"><input type="text" name="frm_user" size="32" maxlength="32" value="<?php echo $contents['frm_user']; ?>" class="dataField"> minimum of 6 alpha-numeric characters</p></td>
			</tr>
			<tr>
				<td height="30" align="right" valign="bottom" colspan="2"><input type="submit" name="frm_edit_name" value="Update Username" class="submitButton"></td>
			</tr>
		</form>
			<tr>
				<td colspan="2"><hr></td>
			</tr>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
		<input type="hidden" name="frm_uid" value="<?php echo $_POST['frm_uid']; ?>">
		<input type="hidden" name="frm_user" value="<?php echo $row['username']; ?>">
			<tr>
				<td><p class="<?php echo $colors2['frm_pass']; ?>">Password: </p></td>
				<td><p class="<?php echo $colors2['frm_pass']; ?>"><input type="password" name="frm_pass" size="32" maxlength="32" class="submitButton"> minimum of 6 alpha-numeric characters</p></td>
			</tr>
			<tr>
				<td height="30" align="right" valign="bottom" colspan="2"><input type="submit" name="frm_edit_pass" value="Update Password" class="submitButton"></td>
			</tr>
		</form>
			<tr>
				<td colspan="2"><hr></td>
			</tr>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
		<input type="hidden" name="frm_uid" value="<?php echo $_POST['frm_uid']; ?>">
		<input type="hidden" name="frm_user" value="<?php echo $row['username']; ?>">
			<tr>
				<td><p class="<?php echo $colors3['frm_email']; ?>">Email: </p></td>
				<td><p class="<?php echo $colors3['frm_email']; ?>"><input type="text" name="frm_email" size="32" maxlength="32" value="<?php echo $contents['frm_email']; ?>" class="submitButton"></p></td>
			</tr>
			<tr>
				<td><p class="<?php echo $colors3['frm_phone']; ?>">Phone: </p></td>
				<td><p class="<?php echo $colors3['frm_phone']; ?>"><input type="text" name="frm_phone" size="32" maxlength="32" value="<?php echo $contents['frm_phone']; ?>" class="submitButton"></p></td>
			</tr>
			<tr>
				<td><p class="<?php echo $colors3['frm_addr1']; ?>">Address: </p></td>
				<td><p class="<?php echo $colors3['frm_addr1']; ?>"><input type="text" name="frm_addr1" size="32" maxlength="32" value="<?php echo $contents['frm_addr1']; ?>" class="submitButton"></p></td>
			</tr>
			<tr>
				<td><p class="<?php echo $colors3['frm_addr2']; ?>">Address: </p></td>
				<td><p class="<?php echo $colors3['frm_addr2']; ?>"><input type="text" name="frm_addr2" size="32" maxlength="32" value="<?php echo $contents['frm_addr2']; ?>" class="submitButton"></p></td>
			</tr>
			<tr>
				<td><p class="<?php echo $colors3['frm_city']; ?>">City: </p></td>
				<td><p class="<?php echo $colors3['frm_city']; ?>"><input type="text" name="frm_city" size="32" maxlength="32" value="<?php echo $contents['frm_city']; ?>" class="submitButton"></p></td>
			</tr>
			<tr>
				<td><p class="<?php echo $colors3['frm_state']; ?>">State: </p></td>
				<td><p class="<?php echo $colors3['frm_state']; ?>"><input type="text" name="frm_state" size="4" maxlength="2" value="<?php echo $contents['frm_state']; ?>" class="submitButton"></p></td>
			</tr>
			<tr>
				<td><p class="<?php echo $colors3['frm_zip']; ?>">Zip: </p></td>
				<td><p class="<?php echo $colors3['frm_zip']; ?>"><input type="text" name="frm_zip" size="12" maxlength="10" value="<?php echo $contents['frm_zip']; ?>" class="submitButton"></p></td>
			</tr>
			<tr>
				<td height="30" align="right" valign="bottom" colspan="2"><input type="submit" name="frm_edit_profile" value="Update Profile" class="submitButton"></td>
			</tr>
		</form>
			<tr>
				<td colspan="2"><hr></td>
			</tr>
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
		<input type="hidden" name="frm_uid" value="<?php echo $_POST['frm_uid']; ?>">
		<input type="hidden" name="frm_user" value="<?php echo $row['username']; ?>">
			<tr>
				<td><p class="<?php echo $colors4['frm_level']; ?>">User Level: </p></td>
				<td><p class="<?php echo $colors4['frm_level']; ?>"><select name="frm_level" class="submitButton">
						<option value="1" <?php if($row['level'] == 1){ echo "SELECTED"; } ?>>Basic</option>
						<option value="2" <?php if($row['level'] == 2){ echo "SELECTED"; } ?>>System Manager</option>
						<option value="3" <?php if($row['level'] == 3){ echo "SELECTED"; } ?>>Administrator</option>
					</select></p></td>
			</tr>
			<tr>
				<td height="30" align="right" valign="bottom" colspan="2"><input type="submit" name="frm_edit_level" value="Update Access Level" class="submitButton"></td>
			</tr>
		</form>
		</table>
		<?php include($my_root."inc/copynotice.php"); ?></td>
	</tr>
</table>
</body>
</html>