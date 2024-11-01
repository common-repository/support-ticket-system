<div class="wrap">
	<div class="icon32" id="icon-options-general"><br></div>
<h2>Settings</h2>

<form action="" method="post">


<h3>General settings</h3>

<table class="form-table">
<tbody><tr valign="top">
<th scope="row"><label for="mailserver_url">Support title</label></th>
<td><input type="text" class="regular-text code" value="" id="mailserver_url" name="mailserver_url" gtbfieldid="4">
</td>
</tr>
<tr valign="top">
<th scope="row"><label for="mailserver_login">Support URL</label></th>
<td><input type="text" class="regular-text" value="yourdomain.com" id="mailserver_login" name="mailserver_login" gtbfieldid="6"></td>
</tr>
<tr valign="top">
<th scope="row"><label for="mailserver_pass">Support E-Mail</label></th>
<td>
<input type="text" class="regular-text" value="mail@mail.com" id="mailserver_pass" name="mailserver_pass" gtbfieldid="7">
</td>
</tr>
<tr valign="top">
<th scope="row"><label for="mailserver_pass">No Reply E-Mail</label></th>
<td>
<input type="text" class="regular-text" value="mail@mail.com" id="no_mailserver_pass" name="mailserver_pass" gtbfieldid="7">
</td>
</tr></tbody></table>

<h3>Language Settings</h3>

<table class="form-table">
<tbody><tr valign="top">
<th scope="row"><label for="mailserver_url">Default Language</label></th>
<td>	<select name="s_language">
	<option value="en|English" selected="selected">English</option>	</select>
</td>
</tr></tbody></table>	

<h3>Mail notifications signature</h3>
<table class="form-table">
<tbody><tr valign="top">
<th scope="row"><label for=""></label></th>
<td>
<textarea rows="5" cols="40" name="notification_signature" id="notification_signature">Regards,

Support Ticket Notification.</textarea>	
</td>
</tr></tbody></table>	

<h3>Help Desk Settings</h3>

<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row"><label for="mailserver_url">Help desk title</label></th>
<td><input type="text" name="s_hesk_title" size="40" maxlength="255" value="" /></td>
</tr>

<tr valign="top">
<th scope="row"><label for="mailserver_url">List usernames</label></th>
<td><label><input type="radio" name="s_list_users" value="0"  /> OFF</label> |
<label><input type="radio" name="s_list_users" value="1" checked="checked" /> ON</label></td>
</tr>

<tr valign="top">
<th scope="row"><label for="mailserver_url">Time Format</label></th>
<td><input type="text" name="s_timeformat" size="40" maxlength="255" value="" /></td>
</tr>

<tr valign="top">
<th scope="row"><label for="mailserver_url">Customer priority</label></th>
<td>
<label><input type="radio" name="s_cust_urgency" value="0"  /> OFF</label> |
<label><input type="radio" name="s_cust_urgency" value="1" checked="checked" /> ON</label>
</td>
</tr>
</tbody></table>


<h3>Ticket</h3>

<table class="form-table">
<tbody>

<tr valign="top">
<th scope="row"><label for="mailserver_url">Knowledgebase (KB)</label></th>
<td><label><input type="radio" name="s_list_users" value="0"  /> OFF</label> |
<label><input type="radio" name="s_list_users" value="1" checked="checked" /> ON</label></td>
</tr>

<tr valign="top">
<th scope="row"><label for="mailserver_url">Suggest KB articles</label></th>
<td><label><input type="radio" name="s_list_users" value="0"  /> OFF</label> |
<label><input type="radio" name="s_list_users" value="1" checked="checked" /> ON</label></td>
</tr>

<tr valign="top">
<th scope="row"><label for="mailserver_url">Enable KB rating</label></th>
<td><label><input type="radio" name="s_list_users" value="0"  /> OFF</label> |
<label><input type="radio" name="s_list_users" value="1" checked="checked" /> ON</label></td>
</tr>

<tr valign="top">
<th scope="row"><label for="mailserver_url">Enable KB search</label></th>
<td><label><input type="radio" name="s_list_users" value="0"  /> OFF</label> |
<label><input type="radio" name="s_list_users" value="1" checked="checked" /> ON</label></td>
</tr>

<tr valign="top">
<th scope="row"><label for="mailserver_url">Max search results</label></th>
<td><input type="text" name="s_timeformat" size="5" maxlength="255" value="" /></td>
</tr>

<tr valign="top">
<th scope="row"><label for="mailserver_url">Article preview length</label></th>
<td><input type="text" name="s_timeformat" size="5" maxlength="255" value="" /></td>
</tr>

<tr valign="top">
<th scope="row"><label for="mailserver_url">Categories in row</label></th>
<td><input type="text" name="s_timeformat" size="5" maxlength="255" value="" /></td>
</tr>


<tr valign="top">
<th scope="row"><label for="mailserver_url">Subcategory articles</label></th>
<td><input type="text" name="s_timeformat" size="5" maxlength="255" value="" /></td>
</tr>

<tr valign="top">
<th scope="row"><label for="mailserver_url">Show popular articles</label></th>
<td><input type="text" name="s_timeformat" size="5" maxlength="255" value="" /></td>
</tr>

<tr valign="top">
<th scope="row"><label for="mailserver_url">Show latest articles</label></th>
<td><input type="text" name="s_timeformat" size="5" maxlength="255" value="" /></td>
</tr>

</tbody></table>
	
<h3>Attachments</h3>

<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row"><label for="mailserver_url">Use attachments</label></th>
<td><label><input type="radio" name="s_list_users" value="0"  /> OFF</label> |
<label><input type="radio" name="s_list_users" value="1" checked="checked" /> ON</label></td>
</tr>

<tr valign="top">
<th scope="row"><label for="mailserver_url">Number per pos</label></th>
<td><input type="text" name="s_timeformat" size="5" maxlength="255" value="" /></td>
</tr>

<tr valign="top">
<th scope="row"><label for="mailserver_url">File size limit (KB)</label></th>
<td><input type="text" name="s_timeformat" size="5" maxlength="255" value="" /></td>
</tr>

<tr valign="top">
<th scope="row"><label for="mailserver_url">Allowed file types</label></th>
<td><input type="text" name="s_timeformat" size="40" maxlength="255" value="" /></td>
</tr>


</tbody></table>

<p class="submit">
	<input type="submit" value="Save Changes" class="button-primary" name="Submit">
</p>
</form>
</div>

