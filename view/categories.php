<div class="wrap nosubsub">


	<div class="icon32" id="icon-edit"><br></div>
<h2>Categories</h2>


<div id="col-container">

<div id="col-right">
<div class="col-wrap">
<div class="tablenav">

<div class="alignleft actions">
</div>

<br class="clear">
</div>

<div class="clear"></div>
<table cellspacing="0" class="widefat tag fixed">
	<thead>
	<tr>
	<th id="name" >Name</th>
	</tr>
	</thead>

	<tfoot>
	<tr>
	<th style="" class="manage-column column-name" scope="col">Name</th>
	</tr>
	</tfoot>

	<tbody class="list:tag" id="the-list">


	<?php generate_menu(0);?>

	</tbody>
</table>


<div class="tablenav">

<div class="alignleft actions">
</div>

<br class="clear">
</div>

<br class="clear">


</div>
</div><!-- /col-right -->

<div id="col-left">
<div class="col-wrap">

	<div class="form-wrap">
<h3>Add New Category</h3>
<form class="validate" action="" method="post" id="addtag">
<div class="form-field form-required">
	<label>Name</label>
	<input type="text" aria-required="true" size="40" value="" id="name" name="name" gtbfieldid="5">
	<p>The name is how it appears on your support ticket.</p>
</div>

	<div class="form-field form-required">
		<label>Parent</label>

	<select name="parent">
	<option value="0">none</option>
	<?php generate_select_box(0,0);?>
	</select>
	</div>
	
<p class="submit"><input type="submit" value="Add New Category" id="submit" name="submit" class="button-primary""></p>
</form></div>

</div>
</div><!-- /col-left -->

</div><!-- /col-container -->
</div>



