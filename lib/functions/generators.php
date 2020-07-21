<?	
    /*
        Table and Form generator functions
        14.2.22
        Cody Joyce
    */
	function genForm($query,$id,$prefix,$target)
    {
        global $values;
        $getCols = query($query);
        //$results = query($query);
        //$values = mysqli_fetch_array($results);

        $fields_num = mysqli_num_fields($getCols);
        echo '<textarea>';


        $formName = $prefix."Form";	
        echo "<form action='".'<?=app("url")?>'."/exec/$target' id='$formName' name='$formName'>\n";


        
        for($i=0; $i<$fields_num; $i++)
        {
            $field = mysqli_fetch_field($getCols);	
            
            if(strstr($id,$field->name)){
                echo "<input type='hidden' name='frm_$id' id='$id' value='".'<?=$values["'.$field->name.'"]?>'."'>\n";
            }else{
                //$colname[$y] = $field->name;
                $label = ucfirst(str_replace($prefix."_","",$field->name));

                echo "<label>".ucfirst(str_replace('_', ' ',$label))."</label>";
                echo "<input name='frm_$field->name'  id='frm_$field->name' value='".'<?=$values["'.$field->name.'"]?>'."'><br>\n";
            }
        }
        echo "<label>&nbsp;</label><button id='formbutton'>Submit</button>\n";
        echo "</form>\n";
        echo "\n<script>\n";
        echo "$(document).ready(function(){\n";
        echo "      $('#$formName').validate();\n";
        echo "});\n";
        echo "</script>\n";
        echo '</textarea>';
	}	
	function genTable($query,$id,$prefix,$target)
    {
		$result = query($query);
		$fields_num = mysqli_num_fields($result);
		
		echo "<textarea width='500px' height='500px'>";
		$tableName = $prefix."Table";
		echo "<table id='sortTable' class='tablesorter' border='0'>\n";
		echo "<thead>\n";
		echo "<tr>\n";
		$y=0;
		for($i=0; $i<$fields_num; $i++)
        {
			$field = mysqli_fetch_field($result);	
			if(!strstr($id,$field->name)){
				$colname[$y] = $field->name;
				$y++;
				$label = ucfirst(str_replace($prefix."_","",$field->name));
				echo "<th>".ucfirst(str_replace('_', ' ',$label))."</th>\n";
			}
		}
		echo "<th></th>";
		echo "</tr>\n";
		echo "</thead>\n";
		
		echo "<tbody>\n";
		
		echo '<? while($row = mysqli_fetch_array($result)){?>'."\n";
		echo "<tr>\n";
			for($x=0; $x<count($colname); $x++){		
				echo "<td>".'<?=$row["'.$colname[$x].'"]?>'."</td>\n";
			}
			$link = "<a href=\"$target"."?frm_".$id."=".'<?=$row["'.$id.'"]?>"'.">";
			$link2 = "</a>";			
			echo "<td>".$link."Edit".$link2."</td>\n";		
		echo "</tr>\n";
		echo "<? }?>\n";		
		echo "</tbody>\n";
		echo "</table>\n";		
		echo "</textarea>\n";
	}
	function generate($query,$id,$prefix,$target)
    {
        genTable($query,$id,$prefix,$target);		genForm($query,$id,$prefix,$target);
	}
?>