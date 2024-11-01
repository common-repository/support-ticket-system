<style>
.wrap *{
    font-family: Tahoma;
    letter-spacing: 1px;
}

input[type=text],textarea{
    width:500px;
    padding:5px;
}

input{
   padding: 7px;
}
</style>

<div class="wrap">
    <div class="icon32" id="icon-edit"><br></div>
<h2>Tickets</h2>
<form action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo $file[id]; ?>" />
<table cellpadding="5" cellspacing="5">
<tr>
<td width="70">Ticket ID:</td>
<td><?php echo $data[0]->ID;?></td>
</tr>
<tr>
<td width="70">Status:</td>
<td><?php echo $data[0]->status;?></td>
</tr>

<tr>
<td width="70" valign="top">Date:</td>
<td><?php echo date("d-m-Y h:m:s",strtotime($data[0]->ticket_datetime));?></td>
</tr>

<tr>
<td width="70">Subject:</td>
<td><?php echo $data[0]->subject;?></td>
</tr>

<tr>
<td width="70">Name: </td>
<td><?php echo $data[0]->name;?></td>
</tr>

<tr>
<td width="70">Email: </td>
<td><?php echo $data[0]->email;?></td>
</tr>


<tr>
<td width="70">IP: </td>
<td><?php echo $data[0]->ip;?></td>
</tr>


<form id="addtag" method="post" action="" class="validate">
<tr>
<td width="70">Priority:</td>
<td><select name="priority">
	<option <?php if($data[0]->priority==1) echo "selected=\"selected\""; ?> value="1">Low</option>
	<option <?php if($data[0]->priority==2) echo "selected=\"selected\""; ?> value="2">Medium</option>
	<option <?php if($data[0]->priority==3) echo "selected=\"selected\""; ?> value="3">High</option>
</select></td>

</tr>

<tr>
<td width="70">Category: </td>
<td>
    <select name="category"><?php generate_select_box(0,$data[0]->category);?></select>
    <input type="submit" class="button-primary" size="10px" name="submit" value="Transfer">
</td>
</tr>
</form>


<tr>
<td colspan="2"><h2>Conversation</h2></td>
</tr>

<?php $dir =  get_bloginfo('url')."/wp-content/uploads/support-ticket/";?>

    <?php for($i=0; $i<count($data_details); $i++){?>

    <?php if($data_details[$i]->reference==""){?>

    <tr><td colspan="2" align="left"><label><b>Customer</b> (<?php echo date("D, M d-Y h:i:s A",strtotime($data_details[$i]->message_timestamp));?>)</label></td>
    <tr><td colspan="2" align="left"><?php echo $data_details[$i]->ticket_message; ?></td></tr>

    <?php if($data_details[$i]->attachment!=""){?>
    <tr><td colspan="2" align="left">Attachment: <a href="<?php echo $dir.$data_details[$i]->attachment; ?>"> Download </a></td></tr>
    <?php }?>

    <?php if($data_details[$i]->answer_message!=""){?>
    <tr><td colspan="2" align="left"><label><b>Admin</b> (<?php echo $data_details[$i]->answers_timestamp; ?>)</label></td></tr>
    <tr><td colspan="2" align="left"><?php echo $data_details[$i]->answer_message; ?></td></tr>

    <?php if($data_details[$i]->attachment!=""){?>
    <tr><td colspan="2" align="left"><strong>Attachment </strong><a href="<?php echo $dir.$data_details[$i]->attachment; ?>"> Download </a></td></tr>
    <?php }?>


    <?php }} elseif($data_details[$i]->reference!=$data_details[$i-1]->reference){?>

    <tr><td colspan="2" align="left"><label><b>Customer</b> (<?php echo date("D, M d-Y h:i:s A",strtotime($data_details[$i]->message_timestamp));?>)</label></td></tr>
    <tr><td colspan="2" align="left"><?php echo $data_details[$i]->ticket_message; ?></td></tr>

    <?php if($data_details[$i]->attachment!=""){?>
    <tr><td colspan="2" align="left">Attachment: <a href="<?php echo $dir.$data_details[$i]->attachment; ?>"> Download </a></td></tr>
    <?php }?>

    <?php if($data_details[$i]->answer_message!=""){?>
    <tr><td colspan="2" align="left"><label><b>Admin</b> (<?php echo $data_details[$i]->answers_timestamp; ?>)</label></td></tr>
    <tr><td colspan="2" align="left"><?php echo $data_details[$i]->answer_message; ?></td></tr>

    <?php } }else{?>

        <tr><td colspan="2" align="left"><label><b>Admin</b> (<?php echo $data_details[$i]->answers_timestamp; ?>)</label></td></tr>
        <tr><td colspan="2" align="left"><?php echo $data_details[$i]->answer_message; ?></td></tr>



    <?php } }?>


<form id="addtag" method="post" action="" class="validate">

<tr>
<td width="70">New status:</td>
<td><select name="newstatus" size="1">
                <option value="awaitingcustomer">Awaiting Customer</option>
                <option value="onhold">On-Hold</option>
                <option value="closed">Closed</option>
                </select>
<input type="submit" class="button-primary" name="submit" id="submit" value="Set New Status Without Replaying">
</td>
</tr>
</form>

<form  method="post" action="" class="validate">
<tr>
<td width="70" colspan="2">Message</td>
</tr>

    <tr>
    <td colspan="2">
        <input type="hidden" name="message_id" value="<?php echo $data_details[$i-1]->message_id; ?>">
        <textarea cols="73" rows="6" name="message"></textarea>
    </td>
</tr>



<tr>
    <td colspan="2"><input type="submit" class="button-primary" name="submit" id="submit" value="Reply To Message"></td>
</tr>


</form>

    

</table>


</form>
</div>
     


