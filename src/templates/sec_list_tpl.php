<table cellpadding="5" cellspacing="0" width="500" class="tblBorder">
	<tr class="tblRowContent">
		<td nowrap colspan="3"><p class="genText"><b>{TITLE}</b></p></td>
	</tr>
	<tr class="tblRowContent">
		<td nowrap colspan="3"><iframe height="300" width="475" src="{DEMO}"></iframe></td>
	</tr>
	<tr class="tblRowContent">
		<td colspan="3"><p class="genText"><hr></p></td>
	</tr>
	<tr class="tblRowContent">
		<td colspan="3"><p class="genText"><u>Image</u>: <img src="{IMAGE}"></p></td>
	</tr>
	<tr class="tblRowContent">
		<td nowrap colspan="3"><p class="genText"><u>Image Description</u>: {IMG_DESC}</p></td>
	</tr>
	<tr class="tblRowContent">
		<td nowrap colspan="3"><p class="genText"><u>Image Link</u>: {IMG_URL}</p></td>
	</tr>
	<tr class="tblRowContent">
		<td nowrap colspan="3"><p class="genText"><u>Section Template</u>: {TEMPLATE}</p></td>
	</tr>
	<tr class="tblRowContent">
		<td nowrap><p class="genText"><u>Updated</u>: {UPDATED}</p></td>
		<td nowrap align="right"><form action="section_man.php" method="post"><span class="genText">
			<input type="hidden" name="frm_pid" value="{PG_ID}">
			<input type="hidden" name="frm_sid" value="{PGSC_ID}">
			<input type="hidden" name="frm_page" value="{PG_NAME}">
			<input type="hidden" name="frm_edit" value="true">
			<input type="submit" name="frm_edit" value="Edit" class="submitButton">
		</span></form></td>
		<td nowrap><form action="{SELF}" method="post"><span class="genText">
			<input type="hidden" name="frm_pid" value="{PG_ID}">
			<input type="hidden" name="frm_sid" value="{PGSC_ID}">
			<input type="hidden" name="frm_page" value="{PG_NAME}">
			<input type="hidden" name="frm_edit" value="true">
			<input type="submit" name="frm_delete" value="Delete" class="submitButton">
			<input type="submit" name="{SUB_FRM}" value="{VIEW}" class="submitButton">
		</span></form></td>
	</tr>
</table>
<br>