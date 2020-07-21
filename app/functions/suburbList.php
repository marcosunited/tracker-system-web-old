<?
	/*
        Suburb List - A Parentlist rewrite for suburbs
        Version: 14.2.24
        Cody Joyce
		  
    */
    
    function suburbListReq($inputFieldName,$parentTable,$selectedId,$relation_name,$where){
		$relation_name = explode(",",$relation_name);
		$query = "select * from $parentTable $where ";
		$result = query($query);
		//echo "<input name='$inputFieldName' type='hidden' >";
		echo "<select name=\"$inputFieldName\" id=\"$inputFieldName\" class='required'>";
		echo "<option value=''>SELECT</option>";
		while($row = mysqli_fetch_array($result)){
			$fieldValueName = str_replace("frm_","",$inputFieldName);
			$selected = "";
			if($row["$fieldValueName"] == $selectedId)
				$selected = "SELECTED";
			$relation_name_o = "";
			foreach($relation_name as $value){
				echo $row["$value"];
				$relation_name_o = $relation_name_o . " " .$row["$value"];
			}
			echo "<option $selected VALUE=\"".$row["$fieldValueName"]."\">".$relation_name_o." - ".$row['suburb_postcode']." ".$row['suburb_state']."</option>";
			$selected = "";
		}
		echo "</select>";
	}
?>