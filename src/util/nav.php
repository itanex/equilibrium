<?php
	function make_mnu_link($root, $filename){
		return (file_exists($root.$filename)) ? $root.$filename : $root."no_file_page.php";
	}
?>
			<table width="140" cellpadding="0" cellspacing="0" class="tblBorder">
<?php
$menu_content = array(
	array(
		"sec_head" => "Control Pannel",
		"section" => array(
			array("Control Panel Index", "index.php", "locked" => false),
			array("Preview Sample", "../index.php", "locked" => false),
			array("Help Desk", "help/main.php", "locked" => false),
			array("Credits", "help/credits.php", "locked" => false)
		)
	),
	array(
		"sec_head" => "Page Management",
		"section" => array(
			array("Create A Page", "site/create_page.php", "locked" => true),
			array("View Page List", "site/page_list.php", "locked" => true),
			//array("New CSS", "site/upload_css.php", "locked" => true),
			//array("View CSS List", "site/css_list.php", "locked" => true),
			array("New Page Template", "site/upload_pg_tpl.php", "locked" => true),
			array("View Page Templates", "site/tpl_pg_list.php", "locked" => true),
			array("New Section Template", "site/upload_sc_tpl.php", "locked" => true),
			array("View Section Templates", "site/tpl_sc_list.php", "locked" => true)
		)
	),
	array(
		"sec_head" => "Mod Management",
		"section" => array(
			array("Install Modification", "mods/upload_mod.php", "locked" => false),
			array("View Mod List", "mods/mod_list.php", "locked" => false)
		)
	),
	array(
		"sec_head" => "User Preferences",
		"section" => array(
			array("Create New User", "userman/add_user.php", "locked" => true),
			array("View User List", "userman/user_list.php", "locked" => true),
			array("User Activity Log", "userman/user_activity.php", "locked" => true),
			array("Logout", "userman/logout.php", "locked" => true)
		)
	)
);
	
	for($i = 0; $i < count($menu_content); $i++){ //runs through each section
		foreach($menu_content[$i] as $item){
			if(is_array($item)){
				foreach($item as $sub_item){
					$tpl->loadVar("link_title", $sub_item[0]);
					if($logged){
						$tpl->loadTemplateFile($my_root."templates/nav_sec_item_linked.php");
						$tpl->loadVar("link", make_mnu_link($my_root, $sub_item[1]));
						$tpl->parseTpl();
					}else{
						if(!$sub_item['locked']){
							$tpl->loadTemplateFile($my_root."templates/nav_sec_item_linked.php");
							$tpl->loadVar("link", make_mnu_link($my_root, $sub_item[1]));
							$tpl->parseTpl();
						}else{
							$tpl->loadTemplateFile($my_root."templates/nav_sec_item.php");
							$tpl->parseTpl();
						}
					}
						echo $tpl->returnParsed();
				}
				$tpl->unLoadTemplate();
			}else{
				$tpl->loadTemplateFile($my_root."templates/nav_sec_head.php");
				$tpl->loadVar("section_head", $item);
				$tpl->parseTpl();
				echo $tpl->returnParsed();
				$tpl->unLoadTemplate();
			}
		}
	}
?>
			</table>