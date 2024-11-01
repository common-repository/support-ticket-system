<div class="wrap">
	<div class="icon32" id="icon-edit"><br></div>
<h2>Edit Category</h2>
<div id="ajax-response"></div>
<form class="validate" action="admin.php?page=support_categories" method="post">
<input type="hidden" value="edit_tag" name="action">
<input type="hidden" value="<?php echo $row[0]->id; ?>" name="cat_ID">
		<tbody>
		<tr class="form-field form-required">
			<th valign="top" scope="row"><label for="name">Name</label></th>
			<td><input type="text" aria-required="true" size="40" value="<?php echo $row[0]->name; ?>" id="name" name="name">
			<p class="description">The name is how it appears on your site.</p></td>
		</tr>

		<tr><th><label>Parent</label></th>
	<td>
	<select name="parent">
	<option value="0">none</option>
	<?php generate_select_box(0,$row[0]->parent);?>
	</select>
	</td></tr>

		</tbody></table>
<p class="submit"><input type="submit" value="Update" name="submit" class="button-primary"></p>
</form>
</div>