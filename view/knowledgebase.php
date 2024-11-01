<div class="wrap">
	<div class="icon32" id="icon-options-general"><br></div>
<h2>Settings</h2>

<form action="" method="post">
<h3>Manage knowledgebase</h3>

<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row"><label for="category">Category</label></th>
<td>
<select name="catid"><option value="1" id="option1">Knowledgebase </option><option value="2" id="option2" selected="selected">Bill</option><option value="3" id="option3">Support</option></select>	
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="mailserver_login">Type</label></th>
<td>
<label><input type="radio" name="type" value="0" checked="checked" /> <b><i>Published</i></b></label><br />
		The article is viewable to everyone in the knowledgebase.</p>
		<p><label><input type="radio" name="type" value="1"  /> <b><i>Private</i></b></label><br />
		Private articles can only be read by staff.</p>
		<p><label><input type="radio" name="type" value="2"  /> <b><i>Draft</i></b></label><br />
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="category">Subject</label></th>
<td><input type="text" name="subject" size="50" maxlength="255"/></td>
</tr>

<tr valign="top">
<th scope="row"><label for="category">Contents</label></th>
<td>
<label><input type="radio" name="html" value="0" checked="checked"/> This is plain text (links will be clickable)</label><br />
       <label><input type="radio" name="html" value="1"/> This is HTML code (I will enter valid (X)HTML code)</label><br />
<textarea name="content" rows="25" cols="70"></textarea></p>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="category">Attachments</label></th>
<td>
	<p><br />
	<input type="file" name="attachment[1]" size="50" /><br />
	<input type="file" name="attachment[2]" size="50" /><br />
	<input type="file" name="attachment[3]" size="50" /><br />
	Accepted file types: *.gif, *.jpg, *.png, *.zip, *.rar, *.csv, *.doc, *.docx, *.txt, *.pdf<br />
	Max. file size: 1024 Kb
	(1.00 Mb)
	</p>

</td>
</tr>
</tbody></table>


<p class="submit">
	<input type="submit" value="Save Article" class="button-primary" name="Submit">
</p>
</form>

<form action="" method="post">
<h3>New knowledgebase (sub)category</h3>

<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row"><label for="category">Category title</label></th>
<td><input type="text" name="title" size="70" maxlength="255" /></td>
</tr>
<tr valign="top">
<th scope="row"><label for="category">Parent category</label></th>
<td>
<select name="catid"><option value="1" id="option1">Knowledgebase </option><option value="2" id="option2" selected="selected">Bill</option><option value="3" id="option3">Support</option></select>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="category">Type</label></th>
<td>		<p><label><input type="radio" name="type" value="0" checked="checked" /> <b><i>Published</i></b></label><br />
		The category is viewable to everyone in the knowledgebase.</p>
		<p><label><input type="radio" name="type" value="1"  /> <b><i>Private</i></b></label><br />
		The category can only be read by staff.</p>
</td>
</tr>

</tbody></table>


<p class="submit">
	<input type="submit" value="Add Category" class="button-primary" name="Submit">
</p>
</form>	

</div>


