		<tr class="tblRowContent">
			<td nowrap><span class="genText">{PG_NAME}</span></td>
			<td nowrap><span class="genText">{LOCATION}</span></td>
			<td nowrap><span class="genText">{UPDATED}</span></td>
			<td nowrap><span class="genText">{CHECKED_OUT}</span></td>
			<td nowrap><form action="section_list.php" method="post"><span class="genText">
				<input type="hidden" name="frm_pid" value="{PG_ID}">
				<input type="hidden" name="frm_page" value="{LOCATION}">
				<input type="submit" name="frm_edit" value="Edit" class="submitButton">
			</span></form></td>
			<td nowrap><form action="{SELF}" method="post"><span class="genText">
				<input type="hidden" name="frm_pid" value="{PG_ID}">
				<input type="hidden" name="frm_page" value="{LOCATION}">
				<input type="submit" name="frm_delete" value="Delete" class="submitButton">
				<input type="submit" name="{SUB_FRM}" value="{VIEW}" class="submitButton">
			</span></form></td>
		</tr>