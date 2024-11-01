<?php

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

if($chrposition!="")
{

    $button_url = $dynamic_url."&support_ticket=";
}
else
{

    $button_url = $dynamic_url."?support_ticket=";
}


if($_GET['page_id']!='')
{
    $hbutton="<input type='hidden' name='page_id' value='$_GET[page_id]'>";

}
elseif($_GET['p']!="")
{
    $hbutton="<input type='hidden' name='p' value='$_GET[p]'>";
}

function assign_rand_value($num)
{
// accepts 1 - 36
  switch($num)
  {
    case "1":
     $rand_value = "a";
    break;
    case "2":
     $rand_value = "b";
    break;
    case "3":
     $rand_value = "c";
    break;
    case "4":
     $rand_value = "d";
    break;
    case "5":
     $rand_value = "e";
    break;
    case "6":
     $rand_value = "f";
    break;
    case "7":
     $rand_value = "g";
    break;
    case "8":
     $rand_value = "h";
    break;
    case "9":
     $rand_value = "i";
    break;
    case "10":
     $rand_value = "j";
    break;
    case "11":
     $rand_value = "k";
    break;
    case "12":
     $rand_value = "l";
    break;
    case "13":
     $rand_value = "m";
    break;
    case "14":
     $rand_value = "n";
    break;
    case "15":
     $rand_value = "o";
    break;
    case "16":
     $rand_value = "p";
    break;
    case "17":
     $rand_value = "q";
    break;
    case "18":
     $rand_value = "r";
    break;
    case "19":
     $rand_value = "s";
    break;
    case "20":
     $rand_value = "t";
    break;
    case "21":
     $rand_value = "u";
    break;
    case "22":
     $rand_value = "v";
    break;
    case "23":
     $rand_value = "w";
    break;
    case "24":
     $rand_value = "x";
    break;
    case "25":
     $rand_value = "y";
    break;
    case "26":
     $rand_value = "z";
    break;
    case "27":
     $rand_value = "0";
    break;
    case "28":
     $rand_value = "1";
    break;
    case "29":
     $rand_value = "2";
    break;
    case "30":
     $rand_value = "3";
    break;
    case "31":
     $rand_value = "4";
    break;
    case "32":
     $rand_value = "5";
    break;
    case "33":
     $rand_value = "6";
    break;
    case "34":
     $rand_value = "7";
    break;
    case "35":
     $rand_value = "8";
    break;
    case "36":
     $rand_value = "9";
    break;
  }
return $rand_value;
}
function get_rand_numbers($length)
{
  if($length>0)
  {
  $rand_id="";
   for($i=1; $i<=$length; $i++)
   {
   mt_srand((double)microtime() * 1000000);
   $num = mt_rand(27,36);
   $rand_id .= assign_rand_value($num);
   }
  }
return $rand_id;
}

function getRealIpAddr()
{
if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
{
  $ip=$_SERVER['HTTP_CLIENT_IP'];
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
{
  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
}
else
{
  $ip=$_SERVER['REMOTE_ADDR'];
}
return $ip;
}

	for($i=0; $i<count($data); $i++)
	{
			$menu_array[$data[$i]->id] = array('name' =>$data[$i]->name,'parent' => $data[$i]->parent,'lavel' => $data[$i]->lavel);
	}

function generate_select_box($parent,$selected)
	{
	$space="&nbsp;&nbsp;&nbsp;";
	//this prevents printing 'ul' if we don't have subcategories for this category
	global $menu_array;
 	global $str;
	if(count($menu_array)>0)
	{
		//use global array variable instead of a local variable to lower stack memory requierment
		foreach($menu_array as $key => $value)
		{
			if ($value['parent'] == $parent)
			{

					if($value['parent']==0)
					{
						$str.="<option value=".$key.">".$value['name'];

						generate_select_box($key,$selected);
						//call function again to generate nested list for subcategories belonging to this category
						$str.="</option>";
					}
					else
					{
						$pSpace ="";
						for($i=1; $i<=$value['lavel']; $i++) $pSpace.=$space;
						$str.="<option value=".$key.">".$pSpace.$value['name'];
						generate_select_box($key,$selected);
						//call function again to generate nested list for subcategories belonging to this category
						$str.="</option>";
					}

			}
		}
		return $str;

	}
}

$image_path = get_option('siteurl').'/wp-content/plugins/'.basename(dirname(__FILE__)).'/images/';


	$create_ticket = "
	<style>
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

	#form1 p.br{
		clear:both;

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
	<form enctype='multipart/form-data' action='' method='post'>

			<fieldset>
			<p class='first'>
					<label for='full_name'>Your Name</label>
					<input type='text' name='full_name' id='full_name' size='30' />
					<input type='hidden' name='support_ticket' value='new_ticket'>
			</p>
			</fieldset>

            <fieldset>
            <p>
					<label for='email'>Email Address</label>
					<input type='text' name='email' id='email' size='30' />
    		</p>
			</fieldset>

            <fieldset class='first'>
            <p>
                    <label for='name'>Department</label>
                    <select name='category'>".generate_select_box(0,0)."</select>
            </p>
            </fieldset>

            <fieldset>
            <p>
                    <label for='subject'>Subject</label>
                    <input type='text' name='subject' id='subject' size='30' />
            </p>
            </fieldset>

			<fieldset>
				<p>
					<label for='message'>Message</label>
					<textarea name='message' id='message' cols='30' rows='10'></textarea>
				</p>
			</fieldset>

            <p class='br'></p>

            <fieldset class='first'>
            <p>
					<label for='priority'>Priority</label>
					<select name='priority'>
                    <option value='1' selected='' style='COLOR:#8A8A8A;'>Low</option>
                    <option value='2'>Medium</option>
        	        <option value='3' style='COLOR:#F07D18;'>High</option>
                    </select>
    		</p>
			</fieldset>

            <fieldset>
            <p>
                    <label for='name'>Attachment</label>
                    <input type='file' name='file'>
            </p>
            </fieldset>

			<p class='submit'><button type='submit' id='submit' class='button' name='submit'>Create Ticket</button></p>

		</form>

</div>
</div>

";





$ticket_details="";



$first_interface = "
<style>
#formcontainer{
    font:13px Trebuchet MS, Arial, Helvetica, Sans-Serif;
    color: #999999;
	background:#fff;
	width:390px;
	height:43px;
	text-align:left;
	border:#676C77 1px solid;
	-moz-border-radius:7px;
	-webkit-border-radius:7px;
     border-radius: 15px;
	margin-left:120px;
	margin-top:5px;
	}



	#form1{
		margin:0.5em 0;
		padding-left: 8px;
		}

	.sptable
		{
		    border: none;
		    width:100%;
		}

     .button_style{
		width:150px;
		height:37px;
        display:-moz-inline-stack;
        display:inline-block;
		background:url(".$image_path."form_button.gif) no-repeat 0 0;
		text-align:center;
        padding:8px 0px 0px 0px;
        color:#fff;

		}

    .button_style:link{
        text-decoration:none;
        color: #fff;
    }
    .button_style:visited{
       text-decoration:none;
       color: #fff;
    }


#formerror{
    font:15px Trebuchet MS, Arial, Helvetica, Sans-Serif;
    background:#fff;
	width:490px;
	height:30px;
	text-align:center;
	border: 1px solid red;
	margin-left:120px;
    text-align: center;
	}
#forme{
	margin:0.25em 0;
	padding-left: 8px;
}


</style>";

if($_GET['ticket']=="invalid")
    $first_interface.= "<div id='formerror'><div id='forme'><strong>Invalid Ticket ID</strong></div></div>";

$first_interface.="<div id='formcontainer'>
<div id='form1'>
           <form  method='get' action=''>
			<a class='' href='".$button_url."create_ticket'>Create Ticket</a>
			<strong style='color:black;'>Check Status </strong> <input style='margin-top:3px; width:150px;'onFocus=\"if(this.value==' Ticket ID')this.value='';\" value=' Ticket ID'  type='text' name='ticket_id' /> ".$hbutton."
            <input type='hidden' name='support_ticket' value='ticket_details'/>
			<button  type='submit' value='View Status'>Go</button>
			</form>

</div>
</div> 
         
";




?>