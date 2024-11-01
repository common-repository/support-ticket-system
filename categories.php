<?php

	global $wpdb;
	$table_name ="ticket_categories";
	extract($_POST);
	extract($_GET);
	global $menu_array;

    /* for file for edit & delete category name in admin panel */

	if($action=="edit")
	{
		$row = $wpdb->get_results("SELECT * FROM $table_name where id ='$cat_ID'");

		$data = $wpdb->get_results("SELECT * FROM $table_name order by name");



		for($i=0; $i<count($data); $i++)
		{
			$menu_array[$data[$i]->id] = array('name' =>$data[$i]->name,'parent' => $data[$i]->parent,'lavel' => $data[$i]->lavel);
		}
		include('view/categories_edit.php');
	}
	elseif($action=="delete")
	{
		$data = $wpdb->get_results("delete from $table_name  where id ='$cat_ID'");
		echo "<script type='text/javascript'>window.location = 'admin.php?page=support_categories';</script>";

	}
	elseif($action=="edit_tag")
	{

		$count = 0;
		if($parent==0)
		{
			$data = $wpdb->get_results("update $table_name  set
			name='$name',parent=0,lavel=0 where id ='$cat_ID'");
		}
		elseif($parent==$cat_ID)
		{

			$data = $wpdb->get_results("update $table_name  set
				name='$name' where id ='$cat_ID'");

		}
		else
		{
			$count++;
			$data = $wpdb->get_results("SELECT * FROM $table_name where id='".$parent."'");
			//calculate lavel
			while($data[0]->parent!=0)
			{
						$data = $wpdb->get_results("SELECT * FROM $table_name where id='".$data[0]->parent."'");
						$count++;
						//echo $count."<br/>";
			}
			$data = $wpdb->get_results("update $table_name  set
				name='$name',parent=$parent,lavel=$count where id ='$cat_ID'");
		}			
		echo "<script type='text/javascript'>window.location = 'admin.php?page=support_categories';</script>";
	}
	else
	{
	
		if($_POST['name']!=null)
		{
			$count=0;
			if($_POST['parent']!=0)
			{
				$count++;
				$data = $wpdb->get_results("SELECT * FROM $table_name where id='".$_POST[parent]."'");
				//calculate lavel 
				while($data[0]->parent!=0)
				{
					//echo $data[0]->parent."<br/>";
					$data = $wpdb->get_results("SELECT * FROM $table_name where id='".$data[0]->parent."'");
					$count++;
					//echo $count."<br/>";
				}
				//echo $count;
			}
			//for add new category and sub-category.
			$wpdb->insert( $table_name, array( 'name'=>$_POST['name'],'parent'=>$_POST['parent'],'lavel'=>$count));
		}

		$data = $wpdb->get_results("SELECT * FROM $table_name order by name");

		for($i=0; $i<count($data); $i++)
		{
			$menu_array[$data[$i]->id] = array('name' =>$data[$i]->name,'parent' => $data[$i]->parent,'lavel' => $data[$i]->lavel);
		}
		include('view/categories.php');
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

function generate_menu($parent)
{
	$space="&mdash;";

	//this prevents printing 'ul' if we don't have subcategories for this category

	global $menu_array;
	//use global array variable instead of a local variable to lower stack memory requierment

	if(count($menu_array)>0)
	{
			foreach($menu_array as $key => $value)
			{
				if ($value['parent'] == $parent)
				{

						if($value['parent']==0)
						{
							echo "<tr class=\"alternate\" id=\"tag-4\">
							<td class=\"name column-name\"><strong><a title=\"\" href=\"\" class=\"row-title\">".$value['name']."</a></strong><br>
								<div class=\"row-actions\">
									<span class=\"edit\"><a href=\"admin.php?page=support_categories&action=edit&opt=categories&cat_ID=".$key."\">Edit</a> | </span>
									<span class=\"delete\"><a href=\"admin.php?page=support_categories&action=delete&opt=categories&cat_ID=".$key."\" class=\"delete-tag\">Delete</a></span>
								</div>";

							generate_menu($key);

							echo "</td></tr>";
						}
						else
						{
							$pSpace ="";
							for($i=1; $i<=$value['lavel']; $i++) $pSpace.=$space;
							echo "<tr class=\"alternate\" id=\"tag-4\">
							<td class=\"name column-name\"><strong><a title=\"\" href=\"\" class=\"row-title\">".$pSpace.$value['name']."</a></strong><br>
								<div class=\"row-actions\">
									<span class=\"edit\"><a href=\"admin.php?page=support_categories&action=edit&opt=categories&cat_ID=".$key."\">Edit</a> | </span>
									<span class=\"delete\"><a href=\"admin.php?page=support_categories&action=delete&opt=categories&cat_ID=".$key."\" class=\"delete-tag\">Delete</a></span>
								</div>";
							generate_menu($key);
							echo "</td></tr>";
						}

				}
			}

	}
}


?>