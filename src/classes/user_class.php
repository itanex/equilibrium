<?php
/*---------------------------------------------------------
/ Class: User
/ Author: Bryan Wood
/ Date: September 9, 2004
/ Updated: January 24, 2004
/ 
/ This class is used to manage any user that is active on 
/ the site. This class also manages the login of user.
---------------------------------------------------------*/

class User {
	  
	var $check_sql;          //Access an user account
	var $unique_sql;         //Identify a user in the database
	
	var $create_insert_sql;  //Adds an user account
	var $profile_insert_sql; //Adds the associated user profile to the database
	
	var $name_update_sql;    //update the specific user name
	var $pass_update_sql;    //update the password for a specific user
	var $level_update_sql;   //update the access level for a specific user
	var $disable_update_sql; //update the disable status of a specific user

	var $profile_update_sql; //update a specific user profile
	var $laston_update_sql;  //update the last on record for a user
	
	var $delete_user_sql;    //delete a specified user account
	var $delete_user_profile_sql; //delete a specified user profile
	
	//Unique string used to secure session  
	var $secure_str;
		
	//The time in which a cookie will expire after login has been established in seconds
	var $cookie_exp;
	
	var $index_redirect;
	
	//The user priviledge level
	// 0 = NONE - provides error traping
	// 1 = BASIC - allow page editing
	// 2 = SYSTEM MANAGER - allow Basic and modification management
	// 3 = ADMINISTRATOR - full access priviledges
	var $access_level;
	var $access_levels = array("NONE", "BASIC", "SYSTEM", "ADMIN");
	
	/*-------------------------------------------
	/ Constructor
	/------------------------------------------*/
	function user($idx_rd, $c_xp = 30){
		//sql statements for user management
		$this->check_sql = "SELECT * FROM user_accts WHERE username='%s' AND password='%s'";
		$this->unique_sql = "SELECT u_id FROM user_accts WHERE username='%s'";
		
		$this->create_insert_sql = "INSERT INTO user_accts(username, password, last_on, level, disabled) VALUES('%s', '%s', NOW(), '%s', '0')";
		$this->profile_insert_sql = "INSERT INTO user_profile(u_id, email, phone, address1, address2, city, state, zip) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";
		
		$this->name_update_sql = "UPDATE user_accts SET username='%s' WHERE u_id='%s'";
		$this->pass_update_sql = "UPDATE user_accts SET password='%s' WHERE u_id='%s'";
		$this->level_update_sql = "UPDATE user_accts SET level='%s' WHERE u_id='%s'";
		$this->disable_update_sql = "UPDATE user_accts SET disabled='%s' WHERE u_id='%s'";
		
		$this->profile_update_sql = "UPDATE user_profile SET email='%s', phone='%s', address1='%s', address2='%s', city='%s', state='%s', zip='%s' WHERE u_id='%s'";
		$this->laston_update_sql = "UPDATE user_accts SET last_on=NOW() WHERE u_id='%s'";
		
		$this->delete_user_sql = "DELETE FROM user_accts WHERE u_id='%s'";
		$this->delete_user_profile_sql = "DELETE FROM user_profile WHERE u_id='%s'";
		
		//security string
		$this->secure_str = "What a wonderful life";
		
		//changable cookie length (default = 30) passed as minutes
		$this->cookie_exp = $c_xp * 60;
		
		//default = 0, does not allow page until check_session sets this value
		$this->access_level = 0;
		
		//location ofindex page to redirect to on expired or illegal access
		$this->index_redirect = $idx_rd;
	
		//initialize the session
		session_start();
	}
	
	/*-------------------------------------------
	/ log in the administrator
	/------------------------------------------*/
	function login($username, $password){
		//insure that the username is legal
		if(ereg("^[a-zA-Z0-9]+$", $username)){
			//encode password with md5
			$password = md5($password);
			
			//find login user
			$result = mysql_query(sprintf($this->check_sql, $username, $password)) or die(mysql_error()."<br>".sprintf($this->check_sql, $username, $password));
			if(mysql_num_rows($result) == 1){
				$row = mysql_fetch_array($result);
				if($row['disabled']){
					$_SESSION['disabled_admin'] = true;
				}else{
					unset($_SESSION['failed_log']);
					$this->create_session($row['u_id'], $row['username'], $row['level']);
				}
			}else{
				$_SESSION['failed_log'] = true;
			}
		}else{
			$_SESSION['failed_log'] = true;
		}
		return false;
	}
		
	/*-------------------------------------------
	/ creates required session variables  
	/ creates cookies.
	/------------------------------------------*/
	function create_session($u_id, $username, $level){		
		$_SESSION['u_id'] = $u_id;
		$_SESSION['user'] = $username;
		$_SESSION['level'] = $level;
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['secure_str'] = md5($username.$this->secure_str);
		$_SESSION['s_id'] = session_id();
	
		$this->prep_cookies();
		$this->update_laston($username);
	}
	
	/*-------------------------------------------
	/ Insures that the required session variables exist
	/ Verifies the session against the stored cookies
	/------------------------------------------*/
	function check_session($redirect = true){
		global $my_root;
		
		if(session_is_registered("user") && session_is_registered("secure_str") && session_is_registered("level") && session_is_registered("ip")){
			if(($_COOKIE['user'] == $_SESSION['user']) && 
			   ($_COOKIE['secure_str'] == $_SESSION['secure_str']) && 
			   ($_COOKIE['level'] == $_SESSION['level']) &&
			   ($_SESSION['ip'] == $_SERVER['REMOTE_ADDR'])){
			   
				$this->access_level = $_SESSION['level'];
				$this->prep_cookies();
				$this->update_laston();
				return true;
			}else{
				return false;
			}
		}else{
			/*if($redirect){
				if($_SERVER['PHP_SELF'] != $this->index_redirect){
					header("Location: ".$my_root."index.php");
				}
			}*/
		}
	}
		
	/*-------------------------------------------
	/ Prepares appropriate cookies
	/------------------------------------------*/
	function prep_cookies(){
		setcookie("user", $_SESSION['user'], time() + $this->cookie_exp, "/");
		setcookie("secure_str", $_SESSION['secure_str'], time() + $this->cookie_exp, "/");
		setcookie("level", $_SESSION['level'], time() + $this->cookie_exp, "/");
	}
	
	/*-------------------------------------------
	/ Unregisters session variables
	/ Deletes cookies
	/------------------------------------------*/
	function kill_session(){
		session_unset();
		session_destroy();
	
		unset($_COOKIE['user']);
		unset($_COOKIE['secure_str']);
		unset($_COOKIE['level']);
	
		return false;
	}
	
	/*-------------------------------------------
	/ updates the the user's last on record
	/------------------------------------------*/
	function update_laston(){
		$result = mysql_query(sprintf($this->laston_update_sql, $_SESSION['u_id']));
		if(mysql_affected_rows() == 1){
			return true;
		}else{
			return false;
		}
	}
	
	/*-------------------------------------------
	/ updates the the user record
	/------------------------------------------*/
	function unique_user($username){
		$result = mysql_query(sprintf($this->unique_sql, addslashes($username))) or die(mysql_error()."<br>".sprintf($this->unique_sql, addslashes($username)));
		if(mysql_num_rows($result) == 1){
			return true;
		}
		return false;
	}
	
	/*-------------------------------------------
	/ Adds a new user to the database
	/------------------------------------------*/
	function add_user($post_vars){
		extract($post_vars); //creates individual variables based on the assoc array name
		$err_str = "";
		
		$result = mysql_query(sprintf($this->create_insert_sql, addslashes($frm_user), md5($frm_pass), $frm_level));
		if(mysql_affected_rows() == 1){
			$err_str = "The user ".$frm_user." was successfully created.";
			$result = mysql_query(sprintf($this->profile_insert_sql, mysql_insert_id(),
				addslashes($frm_email), $frm_phone, addslashes($frm_addr1), addslashes($frm_addr2), 
				addslashes($frm_city), addslashes($frm_state), $frm_zip));
			if(mysql_affected_rows() == 1){
				$err_str .= "<br>The associated profile was created successfully.";
			}else{
				$err_str .= "<br>An error occured creating the associated profile.";
			}
		}else{
			$err_str = "An error occured creating an account for ".$frm_user.".";
		}
		return $err_str;
	}
	
	/*-------------------------------------------
	/ updates a user name in the database
	/------------------------------------------*/
	function update_name($post_vars){
		extract($post_vars); //creates individual variables based on the assoc array name
		$err_str = "You do not have privledges to modify this account.";
		
		//must be an administrator or your own account
		if($this->access_level == 3 || $frm_uid == $_SESSION['u_id']){
			$result = mysql_query(sprintf($this->name_update_sql, $frm_user, $frm_uid));
			if(mysql_affected_rows() > -1){
				$err_str = $frm_username." has been changed to ".$frm_user.".";
				if($frm_uid == $_SESSION['u_id']){
					$_SESSION['user'] = $frm_user;
					$_SESSION['secure_str'] = md5($frm_user.$this->secure_str);
				}
			}else{
				$err_str = "An error occured while attempting to change the username for ".$frm_username.".";
			}
		}
		return $err_str;		
	}
	
	/*-------------------------------------------
	/ updates a user name in the database
	/------------------------------------------*/
	function update_password($post_vars){
		extract($post_vars); //creates individual variables based on the assoc array name
		$err_str = "You do not have privledges to modify this account.";
		
		//must be an administrator or your own account
		if($this->access_level == 3 || $frm_uid == $_SESSION['u_id']){
			$result = mysql_query(sprintf($this->pass_update_sql, md5($frm_pass), $frm_uid));
			if(mysql_affected_rows() > -1){
				$err_str = "The password for ".$frm_user." has been changed.";
			}else{
				$err_str = "An error occured while attempting to change the password for ".$frm_user.".";
			}
		}
		return $err_str;
	}
	
	/*-------------------------------------------
	/ updates a user profile in the database
	/------------------------------------------*/
	function update_profile($post_vars){
		extract($post_vars); //creates individual variables based on the assoc array name
		$err_str = "You do not have privledges to modify this account.";
		
		//must be an administrator or your own account
		if($this->access_level == 3 || $frm_uid == $_SESSION['u_id']){
			$result = mysql_query(sprintf($this->profile_update_sql, $frm_email, $frm_phone, $frm_addr1, $frm_addr2, $frm_city, $frm_state, $frm_zip, $frm_uid));
			if(mysql_affected_rows() > -1){
				$err_str = "The profile for ".$frm_user." was updated successfully.";
			}else{
				$err_str = "An error occured while attempting to update the profile for ".$frm_user.".";
			}
		}
		return $err_str;
	}
	
	/*-------------------------------------------
	/ updates a user access level in the database
	/------------------------------------------*/
	function update_level($post_vars){
		extract($post_vars); //creates individual variables based on the assoc array name
		$err_str = "You do not have privledges to modify this account.";
		
		//must be an administrator and cannot change your own account
		if($this->access_level == 3 && $frm_uid != $_SESSION['u_id']){
			$result = mysql_query(sprintf($this->level_update_sql, $frm_level, $frm_uid));
			if(mysql_affected_rows() > -1){
				$err_str = $frm_user." access level is now ".$this->access_levels[$frm_level].".";
			}else{
				$err_str = "An error occured while attempting to change the account level for ".$frm_user.".";
			}
		}
		return $err_str;
	}
	
	/*-------------------------------------------
	/ updates a user name in the database
	/------------------------------------------*/
	function update_disable($post_vars, $disable){
		extract($post_vars); //creates individual variables based on the assoc array name
		$err_str = "You do not have privledges to modify this account.";
		
		//must be an administrator and cannot disable your own account
		if($this->access_level == 3 && $frm_uid != $_SESSION['u_id']){
			$result = mysql_query(sprintf($this->disable_update_sql, $disable, $frm_uid));
			if(mysql_affected_rows() == 1 and $disable == 1){
				$err_str = $frm_user." has now been deavctivated.";
			}else if(mysql_affected_rows() == 1 and $disable == 0){
				$err_str = $frm_user." has now been reactivated.";
			}else{
				if($disable == 1){
					$err_str = "An error occured while attempting to deactivate the account ".$frm_user.".";
				}else{
					$err_str = "An error occured while attempting to reactivate the account ".$frm_user.".";
				}
			}
		
		}
		return $err_str;
	}
	
	/*-------------------------------------------
	/ deletes a specified user from the database
	/------------------------------------------*/
	function delete_user($post_vars){
		extract($post_vars); //creates individual variables based on the assoc array name
		$err_str = "You do not have privledges to modify this account.";
		
		//must be an administrator and cannot delete your own account
		if($this->access_level == 3 && $frm_uid != $_SESSION['u_id']){
			$result = mysql_query(sprintf($this->delete_user_sql, $frm_uid));
			if(mysql_affected_rows() == 1){
				$err_str = $frm_user." has now been deleted.";
				$result = mysql_query(sprintf($this->delete_user_profile_sql, $frm_uid));
				if(mysql_affected_rows() == 1){
					$err_str .= "<br>The associated profile was successfully deleted.";
				}else{
					$err_str .= "<br>However, an error occured while attempting to delete the associated profile. Please contact the system administrator.";
				}
			}else{
				$err_str = "An error occured while attempting to delete the account ".$frm_user.".";
			}
		
		}
		return $err_str;
	}
}
?>