<?php
/**
 * @package Support Ticket system
 * @author Shaon, Sajib
 * @version 1.0.0
 */
/*
Plugin Name: Support Ticket
Plugin URI: http://www.wpdownloadmanager.com
Description: Support ticket plugin for wordpress
Author: Shaon, Sajib
Version: 1.0.0
Author URI: http://www.wpdownloadmanager.com
*/
global $wp_version;
$exit_msg = '#';
if (version_compare($wp_version,"2.5","<"))
{
	exit($exit_msg);
}
if ( is_admin())
{
	add_action('admin_menu', 'Ticket_plugin_menu');

}

##installer code into database...and crate directory##
global $jal_db_version;
$jal_db_version = "1.0";

function jal_install () {
   global $wpdb;
   global $jal_db_version;

   $table_name = "tickets";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name)
   {

      $sql = "CREATE TABLE " . $table_name . " (
      subject varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '[No Subject]',
      name varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
      email varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
      phone varchar(20) CHARACTER SET latin1 DEFAULT NULL,
      status enum('new','onhold','custreplied','awaitingcustomer','reopened','closed') CHARACTER SET latin1 NOT NULL DEFAULT 'new',
      ID int(6) NOT NULL DEFAULT '0',
      category int(5) NOT NULL DEFAULT '0',
      rep int(5) DEFAULT '0',
      priority tinyint(1) NOT NULL DEFAULT '2',
      ip varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
      url varchar(100) NOT NULL,
      ticket_datetime timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (ID),
      KEY timestamp (ticket_datetime)
	);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

      dbDelta("ALTER TABLE $table_name DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");

      add_option("st_db_version", $jal_db_version);

   }

   $table_name = "ticket_answers";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name)
   {

      $sql = "CREATE TABLE " . $table_name . " (
      answer_id int(7) NOT NULL AUTO_INCREMENT,
      ticket int(6) DEFAULT '0',
      answer_message text CHARACTER SET latin1,
      rep int(5) NOT NULL DEFAULT '0',
      reference int(7) DEFAULT NULL,
      answers_timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (answer_id),
      KEY ticket (ticket),
      KEY timestamp (answers_timestamp)
	);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

      dbDelta("ALTER TABLE $table_name DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");

      add_option("st_db_version", $jal_db_version);

   }

   $table_name = "ticket_messages";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name)
   {

      $sql = "CREATE TABLE " . $table_name . " (
      message_id int(7) NOT NULL AUTO_INCREMENT,
      ticket int(6) NOT NULL DEFAULT '0',
      ticket_message text CHARACTER SET latin1,
      attachment varchar(50) NOT NULL DEFAULT 'NULL',
      headers text CHARACTER SET latin1,
      message_timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (message_id),
      KEY ticket (ticket)
	);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

      dbDelta("ALTER TABLE $table_name DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");

      add_option("st_db_version", $jal_db_version);

   }

   $table_name = "ticket_categories";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name)
   {

      $sql = "CREATE TABLE " . $table_name . " (
      id int(11) NOT NULL AUTO_INCREMENT,
      name varchar(50) CHARACTER SET latin1 NOT NULL,
      parent int(11) NOT NULL DEFAULT '0',
      lavel int(2) NOT NULL DEFAULT '0',
      PRIMARY KEY (id),
      KEY id (id)
	);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

      dbDelta("ALTER TABLE $table_name DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");

      add_option("st_db_version", $jal_db_version);

   }

    //make directory for upload and store support ticket attachment.
    $dir =  str_replace("/","\\",ABSPATH."wp-content/uploads");
    $dir = ABSPATH."wp-content/uploads";
    if(is_dir($dir))
    {
        if(!is_dir($dir."/support-ticket"))
            mkdir($dir."/support-ticket",0755);

        $uploaddir = $dir."/support-ticket/";
    }
    else
    {
        //if uloads  and support-ticket folder not exists.
        if(!is_dir($dir))
            mkdir($dir,0755);
        if(!is_dir($dir."/support-ticket"))
               mkdir($dir."/support-ticket",0755);

        $uploaddir = $dir."/support-ticket/";
    }
    //end



}

register_activation_hook(__FILE__,'jal_install');

###end install code##



add_shortcode("support-interface", "support_ticket_userInterface");


function support_ticket_userInterface() {

    $dir =  "wp-content/uploads/support-ticket/";
  
    if($_FILES['file']['type']=='image/jpeg')
            $ext = ".jpg";
    elseif($_FILES['file']['type']=='image/gif')
            $ext  =".gif";
    elseif($_FILES['file']['type']=='image/png')
            $ext = ".png";
    elseif($_FILES['file']['type']=='application/octet-stream')
            $ext = ".zip";

    $filename = uniqid().$ext;
    if($_FILES['file']['type']=='application/octet-stream')
        $imageinfo = getimagesize($_FILES['file']['tmp_name']);


    $uploadfile = $dir.$filename;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {

    }
    else{
        $filename='';
    }
    
$dir =  get_bloginfo('url')."/wp-content/uploads/support-ticket/";


	$priority = array(1=>'Low', 2=>'Medium',3=>'High');
	global $wpdb;
	global $menu_array;
	$table_name = "ticket_categories";

	$data = $wpdb->get_results("SELECT * FROM $table_name order by name");
	include('userInterface.php');

	if($_POST['support_ticket']=="new_ticket") // insert into data base for new ticket.
	{

			$ticket = get_rand_numbers(6);
            $wpdb->insert( "tickets", array(    'name'=>$_POST['full_name'],
											    'subject'=>$_POST['subject'],
												'email'=>$_POST['email'],
												'category'=>$_POST['category'],
												'priority'=>$_POST['priority'],
												'ID'=>$ticket,
                                                'url'=>$dynamic_url,
												'ip'=>getRealIpAddr()));


		$wpdb->insert( "ticket_messages", array(	'ticket'=>$ticket,
										   			'ticket_message'=>$_POST['message'],
										   			'attachment'=>$filename));

        //for mail user account....
        if($chrposition!="")
        {
         
            $url = $dynamic_url."&ticket_id={$ticket}&support_ticket=ticket_details";

            $to      =  $_POST['email'];
            $subject = "[#{$ticket}]: ".$_POST['subject'];
            $headers = 'From: '.get_bloginfo('admin_email'). "\r\n" .
            'Reply-To: '.get_bloginfo('admin_email')."\r\n";
            $message = "{$_POST['full_name']},
            Thank you for contacting us. This is an automated response confirming the receipt of your ticket. One of our agents will get back to you as soon as possible. For your records, the details of the ticket are listed below. When replying, please make sure that the ticket ID is kept in the subject line to ensure that your replies are tracked appropriately.

            Ticket ID: {$ticket}
            Subject: {$subject}
            Department: {$domain_name}  - {$menu_array[$_POST['category']]['name']}
            Priority: {$priority[$_POST['priority']]}
            Status: Open

            You can check the status of or reply to this ticket online at: {$url}
            Kind regards,";

            @mail($to, $subject, $message, $headers);
        }
        else
        {
            $url = $dynamic_url."?ticket_id={$ticket}&support_ticket=ticket_details";

            $to      =  $_POST['email'];
            $subject = "[#{$ticket}]: ".$_POST['subject'];
            $headers = 'From: '.get_bloginfo('admin_email'). "\r\n" .
            'Reply-To: '.get_bloginfo('admin_email')."\r\n";
            $message = "{$_POST['full_name']},
            Thank you for contacting us. This is an automated response confirming the receipt of your ticket. One of our agents will get back to you as soon as possible. For your records, the details of the ticket are listed below. When replying, please make sure that the ticket ID is kept in the subject line to ensure that your replies are tracked appropriately.

            Ticket ID: {$ticket}
            Subject: {$subject}
            Department: {$domain_name}  - {$menu_array[$_POST['category']]['name']}
            Priority: {$priority[$_POST['priority']]}
            Status: Open

            You can check the status of or reply to this ticket online at: {$url}
            Kind regards,";

            
            @mail($to, $subject, $message, $headers);


        }
      
        //end mail

	$new_ticket = "<style>
    #fromcontainer{
    font:13px Trebuchet MS, Arial, Helvetica, Sans-Serif;
    color:#00000;
    margin:0 auto;
	background:#fff;
	width:600px;
	text-align:left;
	}


	#form1{

		margin:1em 0;
		padding-top:10px;
		background:url(".$image_path."form_top.gif) no-repeat 0 0;
		}
	#form1 fieldset{
		margin:0;
		padding:0;
		border:none;
		float:left;
		display:inline;
		width:260px;
		margin-left:25px;
		}
	#form1 legend{display:none;}
	#form1 p{margin:.5em 0;}
	#form1 label{display:block;color:black;}
	#form1 input, #form1 textarea{
		width:252px;
		border:1px solid #ddd;
		background:#fff url(".$image_path."form_input.gif) repeat-x;
		padding:3px;
		}
	#form1 textarea{
		height:125px;
        width:540px;
		overflow:auto;
		}
	#form1 p.submit{
		clear:both;
		background:url(".$image_path."form_bottom.gif) no-repeat 0 100%;
		padding:0 25px 20px 25px;
		margin:0;
		text-align:right;
		}
	#form1 button{
		width:150px;
		height:37px;
		line-height:37px;
		border:none;
		background:url(".$image_path."form_button.gif) no-repeat 0 0;
		color:#fff;
		cursor:pointer;
		text-align:center;
		}


</style>

<div id='fromcontainer'>
<form id='form1'>
				<fieldset>
				<legend>Ticket information: </legend>
				<p class='first'>
				<label>Ticket ID: ".$ticket."</label><br/>
				<label>Department: ".$menu_array[$_POST['category']]['name']."</label><br/>
				<label>Full Name: ".$_POST['full_name']."</label><br/>
				<label>Email: ".$_POST['email']."</label><br/>
				<label>Priority: ".$priority[$_POST['priority']]."</label><br/>
				</p>
				</fieldset>

				<fieldset>
				<p><label>Subject: ".$_POST['subject']."</label><p/>
				</fieldset>
				<fieldset>
				<p><label>Message: ".$_POST['message']."</label><p/>
				</fieldset>

                <p class='submit'></p>
				</form>
				</div>";


		return ($new_ticket);

	}
	elseif($_GET['support_ticket']=="ticket_status") //load customer ticket status.
	{
        return ($ticket_status);
	}
    elseif($_GET['support_ticket']=="ticket_details") //load customer ticket status.
    {
        $ticket_id = $_GET['ticket_id'];

       
        if($_POST['replay_method']=="custreplied")
        {
            $data = $wpdb->get_results("update tickets set status='custreplied' where ID ='".$ticket_id."'");

            $wpdb->insert( "ticket_messages", array(	'ticket'=>$ticket_id,
                                                       'ticket_message'=>$_POST['message'],
                                                        'attachment'=>$filename));
            $data = $wpdb->get_results("SELECT * FROM tickets  WHERE ID ='$ticket_id'");

        }
        elseif($_POST['replay_method']=="new_value")
        {

            $data = $wpdb->get_results("update tickets set status='".$_POST['status']."',
                                        priority='".$_POST['priority']."' where ID ='".$ticket_id."'");

            $data = $wpdb->get_results("SELECT * FROM tickets  WHERE ID ='$ticket_id'");

        }
        else
        {
            $data = $wpdb->get_results("SELECT * FROM tickets  WHERE ID ='$ticket_id'");

            //print_r($data);
            if(count($data)==0)
            {

             if($_GET['page_id']!='')
            {
               $wps="?page_id=$_GET[page_id]&support_ticket=create_ticket&ticket=invalid";

            }
            elseif($_GET['p']!="")
            {
                $wps="p=$_GET[page_id]&support_ticket=create_ticket&ticket=invalid";
            }
            else
            {
                $wps.=$dynamic_ur."?support_ticket=create_ticket&ticket=invalid";
            }

                echo "<script type=''text/javascript'> window.location = '$wps'; </script>";

            }
        }
      



        $sql = "SELECT * FROM ticket_messages AS t1
        LEFT JOIN ticket_answers AS t2 ON (t1.message_id = t2.reference)
        WHERE t1.ticket = '".$ticket_id."' ORDER BY t1.message_id, t2.answer_id";

        $data_details = $wpdb->get_results($sql);

   // print_r($data_details);

        
                $ticket_status= "<style>
#fromcontainer{
    font:13px Trebuchet MS, Arial, Helvetica, Sans-Serif;
    color:#00000;
    margin:0 auto;
	background:#fff;
	width:600px;
	text-align:left;
	}


	#form1{

		margin:1em 0;
		padding-top:10px;
		background:url(".$image_path."form_top.gif) no-repeat 0 0;
		}
	#form1 fieldset{
		margin:0;
		padding:0;
		border:none;
		float:left;
		display:inline;
		width:260px;
		margin-left:25px;
		}


	#form1 #form3{
		margin:1em 0;

		}
	#form1 #form3 fieldset{
		margin:0;
		padding:0;
		border:none;
		float:left;
		display:inline;
		width:560px;
		margin-left:25px;
		}

    #form1 #form3 p{margin:.5em 0;}
	#form1 #form3 label{display:block;color:black;}

	#form1 legend{display:none;}
	#form1 p{margin:.5em 0;}
	#form1 label{display:block;color:black;}
	#form1 input, #form1 textarea{
		width:252px;
		border:1px solid #ddd;
		background:#fff url(".$image_path."form_input.gif) repeat-x;
		padding:3px;
		}
	#form1 textarea{
		height:125px;
        width:540px;
		overflow:auto;
		}
	#form1 p.submit{
		clear:both;
		background:url(".$image_path."form_bottom.gif) no-repeat 0 100%;
		padding:0 25px 20px 25px;
		margin:0;
		text-align:right;
		}
	#form1 button{
		width:150px;
		height:37px;
		line-height:37px;
		border:none;
		background:url(".$image_path."form_button.gif) no-repeat 0 0;
		color:#fff;
		cursor:pointer;
		text-align:center;
		}
	#form1 h2{
		padding-left: 20px;
		}
	#form1 table{
	    border:none;
		padding-left: 20px;
		}
	#form1 p.br{
		clear:both;
		margin:0px;
		}

#formcontainer2{
    font:13px Trebuchet MS, Arial, Helvetica, Sans-Serif;
    color: #999999;
    background:#fff;
    width:600px;
    height:43px;
    text-align:left;
    border: 1px solid #bbb;
    -moz-border-radius:7px;
    -webkit-border-radius:7px;
     border-radius: 7px;
    margin-left:20px;
    margin-top:5px;
        -moz-box-shadow: inset 0 0 5px #999999;
-webkit-box-shadow: inset 0 0 5px#999999;
box-shadow: inner 0 0 5px #999999;
    }



    #form2{
        margin:0.5em 0;
        padding-left: 8px;
        }
        
.button{
background: #6db3f2; /* old browsers */

background: -moz-linear-gradient(top, #6db3f2 0%, #3690f0 51%, #1e69de 100%); /* firefox */

background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#6db3f2), color-stop(51%,#3690f0), color-stop(100%,#1e69de)); /* webkit */

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6db3f2', endColorstr='#1e69de',GradientType=0 ); /* ie */
            
background: -o-linear-gradient(top, #6db3f2 0%,#3690f0 51%,#1e69de 100%); /* opera */
display:inline-block;
padding:5px 10px;
border:0px;
color: #FFF !important;
cursor:pointer;
text-decoration:none;
}        		

</style>



<div id='formcontainer2'>
<div id='form2'>
           <form  method='get' action=''>
            <a class=button class='' href='".$button_url."create_ticket'>Create Ticket</a> 
            <div style='margin-right:10px;float:right'>
            <strong style='color:black;'>Check Status </strong> <input style='margin-top:3px; width:150px;'onFocus=\"if(this.value==' Ticket ID')this.value='';\" value=' Ticket ID'  type='text' name='ticket_id' /> ".$hbutton."
            <input type='hidden' name='support_ticket' value='ticket_details'/>
            <button class='button'  type='submit' value='View Status'>Go</button>
            </div>
            </form>

</div>
</div>

<div id='fromcontainer'>

<div id='form1'>

	<form  method='post' action='' enctype='multipart/form-data'>
			<fieldset>
			<p class='first'>
					<label>Ticket ID: ".$data[0]->ID."</label>
			</p>
			</fieldset>

		<fieldset>
			<p>
					<label>Department: ".$menu_array[$data[0]->category]['name']."</label>
			</p>
			</fieldset>

		<fieldset>
			<p>
					 <label>Status: ";
                if($data[0]->status!="closed")
                    $ticket_status.="Open";
                else
                    $ticket_status.="Closed";
                $ticket_status.="</label>
			</p>
			</fieldset>

		<fieldset>
			<p>
					<label>Priority: ".$priority[$data[0]->priority]."</label>
			</p>
			</fieldset>

		   <fieldset>
			<p>
				<label>Created On: ".$data[0]->ticket_datetime ."</label>
			</p>
			</fieldset>

            <fieldset>
	        <p>
    		<label>&nbsp;</label>
    		</p>
    		</fieldset>


    <form  method='post' action='' enctype='multipart/form-data'>
                <input type='hidden' name='replay_method' value='new_value'>
                <input type=\"hidden\" name=\"support_ticket\" value='ticket_details'>
                    <input type='hidden' name='ticket_id' value='".$data[0]->ID."'>
        <fieldset>
	    	<p>
                <label>Status <select name='status'>";

                if($data[0]->status!="closed")
                    $ticket_status.="<option value='reopened' selected='selected'>Open</option><option value='closed'>Closed</option></select></label></p></fieldset>";
                else
                    $ticket_status.="<option value='reopened'>Open</option><option selected='selected' value='closed'>Closed</option></select></label></p></fieldset>";

                  if($data[0]->priority==1)
                {
                    $ticket_status.="<fieldset><p><label>Priority <select name='priority'>
                    <option  value='1' selected='selected' style='COLOR:#8A8A8A;'>Low</option>
                    <option value='2'>Medium</option>
                    <option value='3' style='COLOR:#F07D18;'>High</option>
                    </select></label>";

                }
                elseif($data[0]->priority==2)
                {
                    $ticket_status.="<fieldset><p><label>Priority <select name='priority'>
                    <option  value='1' style='COLOR:#8A8A8A;;'>Low</option>
                    <option value='2' selected='selected'>Medium</option>
                    <option value='3' style='COLOR:#F07D18;'>High</option>
                    </select></label>";
                }
                else
                {
                    $ticket_status.="<fieldset><p><label>Priority <select name='priority'>
                    <option  value='1' style='COLOR:#8A8A8A;'>Low</option>
                    <option value='2'>Medium</option>
                    <option value='3' selected='selected' style='COLOR:#F07D18;'>High</option>
                    </select></label>";
                }

            $ticket_status.="<button type='submit' value='Change' id='submit' name='submit'>Change</button></p></fieldset></form>";


        $ticket_status.="<h2>Conversation</h2><div id='form3'>";

                  for($i=0; $i<count($data_details); $i++)
                         {
                            if($data_details[$i]->reference=="")
                             {

                                $ticket_status.="<fieldset><p><label style='background:#5C5858;padding:5px;color:#FFFFFF;'>".$data[0]->name." ".date("d-M-Y h:i:s A",strtotime($data_details[$i]->message_timestamp))."</label></p></fieldset>
                                <fieldset><p><label>".$data_details[$i]->ticket_message."</label></p></fieldset>";
                                  if($data_details[$i]->attachment!="")
                                  {
                                    $ticket_status.="<fieldset><label>Attachment: <a href='".$dir.$data_details[$i]->attachment."'> Download </a></label></p></fieldset>";
                                  }
                                if($data_details[$i]->answer_message!="")
                                {
                                    $ticket_status.="<fieldset><p><label style='background:#5C5858;padding:5px;color:#FFFFFF'>Admin ".date("d-M-Y h:i:s A",strtotime($data_details[$i]->message_timestamp))."</label></p></fieldset>
                                    <fieldset><p><label>".$data_details[$i]->answer_message."</label></p></fieldset>";
                                 }
                             }
                            elseif($data_details[$i]->reference!=$data_details[$i-1]->reference)
                            {
                                $ticket_status.="<fieldset><p><label style='background:#5C5858;padding:5px;color:#FFFFFF'>".$data[0]->name." ".date("d-M-Y h:i:s A",strtotime($data_details[$i]->message_timestamp))."</label></p></fieldset>
                                <fieldset><p><label>".$data_details[$i]->ticket_message."</label></p></fieldset>";
                                if($data_details[$i]->attachment!="")
                                 {
                                   $ticket_status.="<fieldset><p><label>Attachment: <a href='".$dir.$data_details[$i]->attachment."'> Download </a></label></p></fieldset>";
                                 }

                                if($data_details[$i]->answer_message!="")
                                {
                                    $ticket_status.="<fieldset><p><label style='background:#5C5858;padding:5px;color:#FFFFFF'>Admin ".date("d-M-Y h:i:s A",strtotime($data_details[$i]->message_timestamp))."</label></p></fieldset>
                                    <fieldset><p><label>".$data_details[$i]->answer_message."</label></p></fieldset>";
                                }
                            }
                            else
                            {

                                $ticket_status.="<fieldset><label style='background:#5C5858;padding:5px;color:#FFFFFF'>Admin ".date("d-M-Y h:i:s A",strtotime($data_details[$i]->message_timestamp))."</label></p></fieldset>
                                <fieldset><p><label>".$data_details[$i]->answer_message."</label></p></fieldset>";



                            }
                         }

                  


           $ticket_status.="

            

    <fieldset><label style='background:#5C5858;padding:5px;color:#FFFFFF'>Reply</label></p></fieldset>

</div><form  method='post' action='' enctype='multipart/form-data'>
            <fieldset><p><label><textarea name='message'></textarea></label></p></fieldset>

            <p class='br'></p>
        <fieldset><p><label>

                <input type='hidden' name='replay_method' value='custreplied'>
                <input type='hidden' name='support_ticket' value='ticket_status\">
                <input type='hidden' name='ticket_id' value='".$data[0]->ID."'>
				Attachment
				<input type='file' name='file'>
				</label></p></fieldset>

    <p class='br'></p>


                	<p class='submit'><button type='submit' id='submit' name='submit'>Reply</button></p>









		</form>

</div>

</div>";

        
            return($ticket_status);

    }
    elseif($_GET['support_ticket']=="create_ticket")
    {
        return  $create_ticket;

    }
    else // load first interface for user.
	{

        return $first_interface;

		//return $create_ticket;
	}

}


function Ticket_plugin_menu()
{
  $icon_path = get_option('siteurl').'/wp-content/plugins/'.basename(dirname(__FILE__)).'/icon';
	add_menu_page('Support Ticket', 'Support Ticket','support-ticket-page','support-ticket-page','',$icon_path.'/icon.png');
 //add_submenu_page( 'support-ticket-page', 'Settings', 'Settings', 'administrator', 'support_settings', 'settings');
    add_submenu_page( 'support-ticket-page', 'Tickets', 'Tickets', 'administrator', 'support_tickets', 'tickets');
	add_submenu_page( 'support-ticket-page', 'Categories', 'Categories', 'administrator', 'support_categories','categories');
    //add_submenu_page( 'support-ticket-page', 'Knowledgebase', 'Knowledgebase', 'administrator', 'support_knowledgebase', 'knowledgebase');
 }

function categories()
{
	include('categories.php');
}
function Tickets()
{
	
	include('ticket.php');
}
function knowledgebase()
{
	global $wpdb;
	global $menu_array;
	$data = $wpdb->get_results("SELECT * FROM ticket_categories order by name");

	for($i=0; $i<count($data); $i++)
	{
		$menu_array[$data[$i]->id] = array('name' =>$data[$i]->name,'parent' => $data[$i]->parent,'lavel' => $data[$i]->lavel);
	}


function generate_select_box($parent,$selected)
{
	$space="&nbsp;&nbsp;&nbsp;";
	//this prevents printing 'ul' if we don't have subcategories for this category
	global $menu_array;
  //use global array variable instead of a local variable to lower stack memory requierment
	foreach($menu_array as $key => $value)
	{
		if ($value['parent'] == $parent)
		{
				if($value['parent']==0)
				{
					if($selected==$key)
						echo "<option selected=\"$selected\" value=".$key.">".$value['name'];
					else
						echo "<option value=".$key.">".$value['name'];

					generate_select_box($key,$selected);
					//call function again to generate nested list for subcategories belonging to this category
					echo "</option>";
				}
				else
				{
					$pSpace ="";
					for($i=1; $i<=$value['lavel']; $i++) $pSpace.=$space;
					if($selected==$key)
						echo "<option selected=\"$selected\" value=".$key.">".$space.$value['name'];
					else
						echo "<option value=".$key.">".$pSpace.$value['name'];
					generate_select_box($key,$selected);
					//call function again to generate nested list for subcategories belonging to this category
					echo "</option>";
				}

		}
	}

}

generate_select_box(0,0);

	//include ('view/knowledgebase.php');
}
function settings()
{
	include('view/settings.php');
}
?>