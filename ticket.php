<?php
/**
 * Created by Sajib.
 * User: sajib
 * Date: Mar 26, 2011
 * Time: 4:16:57 AM
 * To change this template use File | Settings | File Templates.
 */

	global $wpdb;
	$table_name = "tickets";
	$priority = array(1=>'Low', 2=>'Medium',3=>'High');

    function curPageURL() {
     $pageURL = 'http';
     if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
     $pageURL .= "://";
     if ($_SERVER["SERVER_PORT"] != "80") {
      $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
     } else {
      $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
     }
     return $pageURL;
    }

    $url_parts = parse_url(curPageURL());
    
    $domain_name = $url_parts[host];



    $dynamic_url = curPageURL();

    $chrposition = strrpos($dynamic_url, "?");



	global $menu_array;
	$ticket_id = $_GET['ticket_id'];


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


		$data = $wpdb->get_results("SELECT * FROM ticket_categories order by name");
	
		for($i=0; $i<count($data); $i++)
		{
			$menu_array[$data[$i]->id] = array('name' =>$data[$i]->name,'parent' => $data[$i]->parent,'lavel' => $data[$i]->lavel);
		}



	if(count($_POST)>0)
	{
		if($_POST['message_id']!="")
		{
			$wpdb->insert( "ticket_answers", array(	'ticket'=>$_POST['ticket_id'],
													 'reference'=>$_POST['message_id'],
													 'answer_message'=>$_POST['message']));
			$data = $wpdb->get_results("update tickets set status='awaitingcustomer' where ID='$ticket_id'");

           	$userdata = $wpdb->get_results("SELECT * FROM tickets where ID='$ticket_id'");

            //print_r($userdata);

		 $dynamic_url = $userdata[0]->url;

    		$chrposition = strrpos($dynamic_url, "?");

             if($chrposition!="")
            {
                $url = $dynamic_url."&ticket_id={$userdata[0]->ID}&support_ticket=ticket_details";
            }
            else
            {
                $url = $dynamic_url."?ticket_id={$userdata[0]->ID}&support_ticket=ticket_details";
            }

            $to      =  $userdata[0]->email;
            $subject = "[#{$userdata[0]->ID}]: ".$userdata[0]->subject;
	    $headers = 'From: '.get_bloginfo('admin_email'). "\r\n" .
            'Reply-To: '.get_bloginfo('admin_email')."\r\n";
            $message = "Hello,

            {$_POST['message']}.

            Ticket Details
            ===================
            Ticket ID: {$userdata[0]->ID}
            Department: {$domain_name}  - {$menu_array[$userdata[0]->category]['name']}
            Priority: {$priority[$userdata[0]->priority]} 
            Status: Open

            You can check the status of or reply to this ticket online at: {$url}";

            mail($to, $subject, $message, $headers);





		}
		elseif($_POST['newstatus']!="")
		{
			$data = $wpdb->get_results("update tickets set status='".$_POST['newstatus']."' where ID='$ticket_id'");

		}
		elseif($_POST['priority']!="")
		{
			$data = $wpdb->get_results("update tickets set priority='".$_POST['priority']."',
			category='".$_POST['category']."' where ID='$ticket_id'");
		}
		
	}

	if($_GET['opt']!="details")
	{

        $id = $_POST['ticket_id'];

        if(count($id)>0)
        {
	    $dir = ABSPATH.'wp-content/uploads/support-ticket/';
	
            //$dir =  str_replace("/","\\",ABSPATH."wp-content/uploads/support-ticket/");
            foreach($id as $key=>$value)
            {
                $data = $wpdb->get_results("SELECT message_id,attachment FROM ticket_messages WHERE ticket='$value'");
                for($i=0; $i<count($data); $i++)
                {
                    $wpdb->query("DELETE FROM ticket_answers WHERE reference='".$data[$i]->message_id."'");
                    if($data[$i]->attachment!="")
                    {
                        @unlink($dir.$data[$i]->attachment);
			//echo $dir."/".$data[$i]->attachment;
                    }
                }

                $wpdb->query("DELETE FROM ticket_messages WHERE ticket='$value'");
                $wpdb->query("DELETE FROM tickets WHERE ID='$value'");
            }
        }       //echo ABSPATH.'wp-content/uploads/support-ticket/';
		$data = $wpdb->get_results("SELECT * FROM $table_name order by ticket_datetime");
		include ('view/ticket.php');
	}
	else
	{

		$data = $wpdb->get_results("SELECT * FROM $table_name where ID='".$_GET['ticket_id']."'");

		$sql = "SELECT * FROM ticket_messages AS t1
				LEFT JOIN ticket_answers AS t2 ON (t1.message_id = t2.reference)
				WHERE t1.ticket = '".$_GET['ticket_id']."' ORDER BY t1.message_id, t2.answer_id";

		$data_details = $wpdb->get_results($sql);

		//print_r($data_details);
		include('view/ticket_details.php');
		//print_r($_POST);



	}

       
?>