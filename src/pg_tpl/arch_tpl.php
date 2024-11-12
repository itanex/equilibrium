<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td height="154" width="157"><a href="http://www.formarchitecture.net/index.php"><img src="img/arch/logo.gif" alt="" border="0" height="154" width="157"></a></td>
		<td></td>
	</tr>
	<tr>
		<td valign="top" width="157">
<?php require_once($my_root."inc/nav_arch.php"); ?>
		</td>
		<td style="background-repeat: no-repeat;" background="img/arch/back.jpg" bgcolor="#000000" height="458" valign="top" width="450">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="25"><img src="img/arch/side_blank.gif" alt="" border="0" width="25"></td>
					<td valign="top">
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td height="15"><img src="img/arch/top.gif" alt="" border="0" height="15" width="1"></td>
							</tr>
							<tr>
								<td valign="top">
									<table border="1" cellpadding="5" width="400">
										<tr>
											<td height="300" valign="top" style="background-repeat: no-repeat;" background="img/arch/back_light.jpg" bgcolor="#a38966">
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
	}
?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table border="0" cellpadding="0" cellspacing="0" width="600">
				<tr>
					<td class="form" align="right"><p> </p>Form Architecture Inc. - 1208 E 35th Ave - Spokane, WA 99203</td>
				</tr>
				<tr>
					<td><hr color="#ddab52" size="2" width="100%"></td>
				</tr>
				<tr>
					<td class="form" align="right">Website by <a href="http://www.spokaneweb.net/" class="nav">Spokane Web Communications</a> and <a href="http://www.designmonger.net/" class="nav">Designmonger.net</a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>