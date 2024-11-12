		<tr class="tblRowContent"> 
			<td nowrap><span class="genText">{USERNAME}</span></td>
			<td nowrap><span class="genText">{LAST_ON}</span></td>
			<td nowrap><span class="genText">{LEVEL}</span></td>
			<td nowrap><form action="user_edit.php" method="post"><span class="genText">
				<input type="hidden" name="frm_uid" value="{U_ID}">
				<input type="hidden" name="frm_user" value="{USERNAME}">
				<input type="submit" name="frm_edit" value="Edit" class="submitButton">
			</span></form></td>
			<td nowrap><form action="{SELF}" method="post"><span class="genText">
				<input type="hidden" name="frm_uid" value="{U_ID}">
				<input type="hidden" name="frm_user" value="{USERNAME}">
				<input type="submit" name="frm_delete" value="Delete" class="submitButton">
				<input type="submit" name="{SUB_FRM}" value="{VIEW}" class="submitButton">
			</span></form></td>
		</tr>