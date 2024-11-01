<div class="wrap nosubsub">
	<div class="icon32" id="icon-edit"><br></div>
<h2>Tickets</h2>
<div id="message" style="padding: 5px 10px" class="message updated"> Copy this code and paste it into your post or page <input type="text" value="[support-interface]" size="20" onfocus="this.select()" /></b></div>
<div id="col-container">

    <form action="admin.php?page=support_tickets" method="post">
	<table cellspacing="0" class="widefat tag fixed">
		<thead>
		<tr>
		<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
		<th id="name">Ticket</th>
		<th id="name">Date</th>
		<th id="name">Subject</th>
		<th id="name">Category</th>
		<th id="name">Representative</th>
		<th id="name">Priority</th>
		<th id="name">From</th>
		<th id="name">Status</th>
		</tr>
		</thead>

		<tfoot>
		<tr>
		<th id="cb" class="manage-column column-cb check-column" scope="col" style=""><input type="checkbox"></th>
		<th style="" class="manage-column column-name" scope="col">Ticket</th>
		<th style="" class="manage-column column-name" scope="col">Date</th>
		<th style="" class="manage-column column-name" scope="col">Subject</th>
		<th style="" class="manage-column column-name" scope="col">Category</th>
		<th style="" class="manage-column column-name" scope="col">Representative</th>
		<th style="" class="manage-column column-name" scope="col">Priority</th>
		<th style="" class="manage-column column-name" scope="col">From</th>
		<th style="" class="manage-column column-name" scope="col">Status</th>
		</tr>
		</tfoot>

		<tbody class="list:tag" id="the-list">

		<?php for($i=0; $i<count($data); $i++){?>

		<tr>
        <th scope="row" class="check-column"><input type="checkbox" name="ticket_id[]" value="<?php echo $data[$i]->ID;?>"></th>
        <td class="name column-name"><strong><a class="row-title" href="admin.php?page=support_tickets&ticket_id=<?php echo $data[$i]->ID;?>&opt=details" title=""><?php echo $data[$i]->ID;?></a></strong><br></td>
		<td class="name column-name"><strong><?php echo date("d M Y h:i:s A",strtotime($data[$i]->ticket_datetime));?></strong><br></td>
		<td class="name column-name"><strong><a class="row-title" href="admin.php?page=support_tickets&ticket_id=<?php echo $data[$i]->ID;?>&opt=details" title=""><?php echo $data[$i]->subject;?></a></strong><br></td>
		<td class="name column-name"><strong><?php echo $menu_array[$data[$i]->category]['name'];?></strong><br></td>
		<td class="name column-name"><strong><?php echo $data[$i]->rep;?></strong><br></td>
		<td class="name column-name"><strong><?php echo $priority[$data[$i]->priority]; ?></strong><br></td>
		<td class="name column-name"><strong><?php echo $data[$i]->name;?></strong><br></td>
		<td class="name column-name"><strong><?php echo $data[$i]->status;?></strong><br></td>
		</tr>
		<?php }?>




		</tbody>
	</table>


</div><!-- /col-container -->
</div>
    <div class="tablenav">


<div class="alignleft actions">
<input type="submit" value="Delete" onclick="alert('Are you sure you wish to Delete?'); return true" class="button-secondary action">
</div>

<br class="clear">
</div>


</form>

