		<tr class="tblRowContent"> 
			<td nowrap><p class="genText">{NAME}</p></td>
			<td nowrap><p class="genText">{FILE}</p></td>
			<td nowrap><p class="genText">{UPDATED}</p></td>
			<td nowrap><p class="genText">{AUTHOR}</p></td>
			<td nowrap><form action="{EDIT}" method="post"><span class="genText">
				<input type="hidden" name="frm_tpl_id" value="{TPL_ID}" />
				<input type="hidden" name="frm_name" value="{NAME}" />
				<input type="hidden" name="frm_file" value="{FILE}" />
				<input type="submit" name="frm_edit" value="Edit" class="submitButton" />
			</span></form></td>
			<td nowrap><form action="{SELF}" method="post"><span class="genText">
				<input type="hidden" name="frm_tpl_id" value="{TPL_ID}" />
				<input type="hidden" name="frm_name" value="{NAME}" />
				<input type="hidden" name="frm_file" value="{FILE}" />
				<input type="submit" name="frm_delete" value="Delete" class="submitButton" />
				<input type="submit" name="{SUB_FRM}" value="{VIEW}" class="submitButton" />
			</span></form></td>
		</tr>		