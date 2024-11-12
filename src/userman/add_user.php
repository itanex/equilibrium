<?php
	//include required class files
	require_once("_dir_config.php");
	$page_title = "Create User";

	$valid_color = "genText";
	$invalid_color = "alert";
	
	$required = array(
		"frm_user",
		"frm_pass",
		"frm_email",
		"frm_phone",
		"frm_addr1",
		"frm_addr2",
		"frm_city",
		"frm_state",
		"frm_zip",
		"frm_level"
	);
	
	$regex = array(
		"frm_user" => "^[a-zA-Z0-9]{6,32}$",
		"frm_pass" => "^[a-zA-Z0-9]{6,32}$",
		"frm_email" => "^([-a-z0-9_:@&?=+,.!/~*'%$]+@[-a-z0-9_:@&?=+,.!/~*'%$]+.[-a-z0-9_:@&?=+,.!/~*'%$]+){0,1}$",
		"frm_phone" => "^[0-9]{0,15}$",
		"frm_addr1" => "^[-a-zA-Z0-9 #&]{0,32}$",
		"frm_addr2" => "^[-a-zA-Z0-9 #&]{0,32}$",
		"frm_city" => "^[a-zA-Z]{0,32}$",
		"frm_state" => "^[a-zA-Z]{0,2}$",
		"frm_zip" => "^[0-9]{0,9}$",
		"frm_level" => "^[0-9]{1}$"
	);
	
	$colors = array(
		"frm_user" => $valid_color,
		"frm_pass" => $valid_color,
		"frm_email" => $valid_color,
		"frm_phone" => $valid_color,
		"frm_addr1" => $valid_color,
		"frm_addr2" => $valid_color,
		"frm_city" => $valid_color,
		"frm_state" => $valid_color,
		"frm_zip" => $valid_color,
		"frm_level" => $valid_color
	);

	$contents = array();
	
	foreach($required as $req){
		$contents[$req] = "";
	}
	
	if(isset($_POST['frm_add'])){
		if(validate()){
			if(!$user_obj->unique_user($_POST['frm_user'])){
				$edit_err = $user_obj->add_user($_POST);
				$bkr->record_event(sprintf($user_create_note, $_POST['frm_user']));
				header("Location: user_list.php");
			}else{
				$bkr->record_event(sprintf($user_create_fail, $_POST['frm_user']));
				$edit_err = "The username ".$_POST['frm_user']." is already in use.";
			}
		}else{
			$edit_err = "Please insure that all fields contain a valid entry.";
		}
	}
	
	function validate(){
		global $required, $regex, $colors, $contents, $invalid_color;
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
		<td valign="top"><h1>Create User</h1>
		<p class="genText">Please complete the following fields to create a new user account.</p>
<?php
	if(isset($edit_err)){
		$tpl->loadTemplateFile($my_root."templates/user_alert_tpl.php");
		$tpl->loadVar("alert", $edit_err);
		$tpl->parseTpl();
		echo $tpl->returnParsed();
		$tpl->unLoadTemplate();
	}
?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td><p class="<?php echo $colors['frm_user']; ?>">Username: </p></td>
				<td><p class="<?php echo $colors['frm_user']; ?>"><input type="text" name="frm_user" size="32" maxlength="32" value="<?php echo $contents['frm_user']; ?>" class="dataField"> minimum of 6 alpha-numeric characters</p></td>
			</tr>
			<tr>
				<td><p class="<?php echo $colors['frm_pass']; ?>">Password: </p></td>
				<td><p class="<?php echo $colors['frm_pass']; ?>"><input type="password" name="frm_pass" size="32" maxlength="32" value="<?php echo $contents['frm_pass']; ?>" class="dataField"> minimum of 6 alpha-numeric characters</p></td>
			</tr>
			<tr>
				<td><p class="<?php echo $colors['frm_email']; ?>">Email: </p></td>
				<td><p class="<?php echo $colors['frm_email']; ?>"><input type="text" name="frm_email" size="32" maxlength="32" value="<?php echo $contents['frm_email']; ?>" class="dataField"></p></td>
			</tr>
			<tr>
				<td><p class="<?php echo $colors['frm_phone']; ?>">Phone: </p></td>
				<td><p class="<?php echo $colors['frm_phone']; ?>"><input type="text" name="frm_phone" size="32" maxlength="32" value="<?php echo $contents['frm_phone']; ?>" class="dataField"></p></td>
			</tr>
			<tr>
				<td><p class="<?php echo $colors['frm_addr1']; ?>">Address: </p></td>
				<td><p class="<?php echo $colors['frm_addr1']; ?>"><input type="text" name="frm_addr1" size="32" maxlength="32" value="<?php echo $contents['frm_addr1']; ?>" class="dataField"></p></td>
			</tr>
			<tr>
				<td><p class="<?php echo $colors['frm_addr2']; ?>">Address: </p></td>
				<td><p class="<?php echo $colors['frm_addr2']; ?>"><input type="text" name="frm_addr2" size="32" maxlength="32" value="<?php echo $contents['frm_addr2']; ?>" class="dataField"></p></td>
			</tr>
			<tr>
				<td><p class="<?php echo $colors['frm_city']; ?>">City: </p></td>
				<td><p class="<?php echo $colors['frm_city']; ?>"><input type="text" name="frm_city" size="32" maxlength="32" value="<?php echo $contents['frm_city']; ?>" class="dataField"></p></td>
			</tr>
			<tr>
				<td><p class="<?php echo $colors['frm_state']; ?>">State: </p></td>
				<td><p class="<?php echo $colors['frm_state']; ?>"><input type="text" name="frm_state" size="8" maxlength="2" value="<?php echo $contents['frm_state']; ?>" class="dataField"></p></td>
			</tr>
			<tr>
				<td><p class="<?php echo $colors['frm_zip']; ?>">Zip: </p></td>
				<td><p class="<?php echo $colors['frm_zip']; ?>"><input type="text" name="frm_zip" size="13" maxlength="10" value="<?php echo $contents['frm_zip']; ?>" class="dataField"></p></td>
			</tr>
			<tr>
				<td><p class="<?php echo $colors['frm_level']; ?>">User Level: </p></td>
				<td><p class="<?php echo $colors['frm_level']; ?>"><select name="frm_level" class="dataField">
						<option <?php if($contents['frm_level'] == ""){ echo  "SELECTED"; } ?>>Select a User Level</option>
						<option value="1" <?php if($contents['frm_level'] == 1){ echo  "SELECTED"; } ?>>Basic</option>
						<option value="2" <?php if($contents['frm_level'] == 2){ echo  "SELECTED"; } ?>>System Manager</option>
						<option value="3" <?php if($contents['frm_level'] == 3){ echo  "SELECTED"; } ?>>Administrator</option>
					</select></p></td>
			</tr>
			<tr>
				<td></td>
				<td height="30" valign="bottom"><input type="submit" name="frm_add" value="Submit User" class="submitButton"></td>
			</tr>
		</table>
		</form>
		<?php include($my_root."inc/copynotice.php"); ?></td>
	</tr>
</table>
</body>
</html>