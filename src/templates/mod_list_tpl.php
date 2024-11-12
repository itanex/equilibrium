		<tr class="tblRowContent">
			<td nowrap><span class="genText">{MOD_NAME}</span></td>
			<td nowrap><span class="genText">{LOCATION}</span></td>
			<td nowrap><span class="genText">{UPDATED}</span></td>
			<td nowrap align="right"><form action="{SELF}" method="post"><span class="genText">
				<input type="hidden" name="frm_mid" value="{MOD_ID}">
				<input type="hidden" name="frm_mod" value="{LOCATION}">
				<input type="submit" name="frm_delete" value="Delete" class="submitButton">
			</span></form></td>
			<td nowrap align="right"><form action="{SELF}" method="post"><span class="genText">
				<input type="hidden" name="frm_mid" value="{MOD_ID}">
				<input type="hidden" name="frm_mod" value="{LOCATION}">
				<input type="submit" name="{SUB_FRM}" value="{VIEW}" class="submitButton">
			</span></form></td>
		</tr>