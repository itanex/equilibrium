<table width="90%" height="100%" cellpadding="0" cellspacing="0" border="0">
	<!-- HEADER -->
	<tr>
		<td colspan="2" height="75">{HEADER}</td>
	</tr>
	<tr>
		<!-- MENU -->
		<td width="150"><?php include_once("inc/nav_default.php"); ?></td>
		<!-- BODY -->
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
<?php
	$fetch_sections = "
		SELECT title, content, tpl_file , img_name, img_desc, img_url
		FROM pg_section
		LEFT JOIN tpl_sc_list ON pg_section.tpl_sc_id=tpl_sc_list.tpl_sc_id
		WHERE p_id='%s' and view='1'
		ORDER BY pgsc_id";
		
	//get section count
	$result = mysql_query(sprintf($fetch_sections, $my_id));
	if(mysql_num_rows($result) > 0){
		while($row = mysql_fetch_assoc($result)){
			$tpl->loadTemplateFile("cms/sc_tpl/".$row['tpl_file']);
			$tpl->loadVar("sec_title", stripslashes($row['title']));
			$tpl->loadVar("sec_body", stripslashes($row['content']));
			$tpl->loadVar("image", stripslashes($row['img_name']));
			$tpl->loadVar("link", stripslashes($row['img_url']));
			$tpl->loadVar("alt_text", stripslashes($row['img_desc']));
			$tpl->parseTpl();
			echo $tpl->returnParsed();
		}
	}else{
?>
<p class="alert">There are no sections or there was an error with the database(<?php echo $my_id; ?>).<br>[Database Error: <?php echo mysql_error(); ?>]</p>
<?php
	}
?></td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- FOOTER -->
	<tr>
		<td colspan="2" height="75">{FOOTER}</td>
	</tr>
</table>