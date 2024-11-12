<?php
/*---------------------------------------------------------
/ Class: page
/ Author: Bryan Wood
/ Date: September 9, 2004
/
/ this class manages the complete set of pages within the
/ CMS as well as the pages of the associated site
---------------------------------------------------------*/

class Page{
		var $add_basic_page_sql;
		var $add_sect_page_sql;
	
		var $visible_update_sql;
		var $visible_check_sql;
		
		var $page_delete_sql;
	
	/*-------------------------------------------
	/ constructor
	-------------------------------------------*/
	function Page(){
		$this->add_basic_page_sql = "INSERT INTO pg_list(tpl_pg_id, filename, title, view, updated, updated_by) VALUES('%s', '%s', '%s', '%s', NOW(), '".$_SESSION['u_id']."')";
		$this->add_sect_page_sql = "INSERT INTO pg_section(p_id, tpl_sc_id, title, content, img_name, img_desc, img_url) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s')";
	
		$this->visible_update_sql = "UPDATE pg_list SET view='%s' WHERE p_id='%s'";
		$this->visible_check_sql = "SELECT view FROM pg_list WHERE p_id='%s'";
		
		$this->page_delete_sql = "DELETE FROM pg_list, pg_section WHERE p_id='%s'";
	}

	/*-------------------------------------------
	/ adds a page to the database
	-------------------------------------------*/
	function add_page_basic(){
		extract($post_vars); //creates individual variables based on the assoc array name

		$result = mysql_query(sprintf($this->$add_basic_page_sql, $frm_tpid, $frm_file, $frm_title, $frm_vis));
		if(mysql_affected_rows() == 1){
			return true;
		}
		return false;
	}

	/*-------------------------------------------
	/ adds a page to the database
	-------------------------------------------*/
	function add_page_sec(){
		extract($post_vars); //creates individual variables based on the assoc array name

		$result = mysql_query(sprintf($this->$add_sect_page_sql, $frm_pid, $frm_ts_id, $frm_title, $frm_content, $frm_img_name, $frm_img_desc, $frm_img_url));
		if(mysql_affected_rows() == 1){
			return true;
		}
		return false;
	}
	
	function fetch_section($sec_id){
		$result = mysql_query(sprintf($this->$fetch_section, $sec_id));
		if(mysql_num_rows() == 1){
			
		}
	}
	
	/*-------------------------------------------
	/ adjusts the accessablity of a page
	-------------------------------------------*/
	function visbile_page($post_vars){
		extract($post_vars); //creates individual variables based on the assoc array name

		$result = mysql_query(sprintf($this->$visible_update_sql, $frm_vis, $frm_pid));
		if(mysql_affected_rows() == 1){
			if($frm_vis){
				$err_str = $frm_name." has been hidden from general users.";
			}else{
				$err_str = $frm_name." has been revealed to general users.";
			}
		}else{
			$err_str = "An error occured while attempting to adjust the visibility of ".$frm_name.".";
		}
		return $err_str;
	}
	
	/*-------------------------------------------
	/ deletes a page
	-------------------------------------------*/
	function delete_page($post_vars){		
		$err_str = "You do not have privledges to delete pages.";
		
		//must be an administrator
		if($_SESSION['level'] == 3){
			extract($post_vars); //creates individual variables based on the assoc array name	
			mysql_query(sprintf($this->$page_delete_sql, $frm_pid));
			if(mysql_affected_rows() == 1){
				$err_str = $frm_name." has now been deleted.";
			}else{
				$err_str = "An error occured while attempting to delete the page ".$frm_name.".";
			}
		
		}
		return $err_str;
	}
	
	/*-------------------------------------------
	/ check a pages view setting and redirect back if this page is suppose to be hidden
	-------------------------------------------*/
	function can_view($page_id){
		$result = mysql_query(sprintf($this->visible_check_sql, $page_id));
		if(mysql_num_rows($result) == 1){
			return true;
		}
		return false;
	}
}
?>