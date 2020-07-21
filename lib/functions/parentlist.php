<?
    /*
        Parentlist: Generate a dropdown SELECT based on the parametres provided.
        14.2.22
        Cody Joyce
    */
    
    function parentList($inputFieldName,$parentTable,$selectedId,$relation_name,$where){
		$relation_name = explode(",",$relation_name);
		$query = "select * from $parentTable $where ";
		$result = query($query);
		//echo "<input name='$inputFieldName' type='hidden' >";
		echo "<select name=\"$inputFieldName\" id=\"$inputFieldName\">";
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
			echo "<option $selected VALUE=\"".$row["$fieldValueName"]."\">".$relation_name_o."</option>";
			$selected = "";
		}
		echo "</select>";
	}
	
	function parentListReq($inputFieldName,$parentTable,$selectedId,$relation_name,$where){
		$relation_name = explode(",",$relation_name);
		$query = "select * from $parentTable $where ";
		$result = query($query);
		//echo "<input name='$inputFieldName' type='hidden' >";
		echo "<select class='required' name=\"$inputFieldName\" id=\"$inputFieldName\" class=\"required\">";
		echo "<option value=''>SELECT</option>";
		while($row = mysqli_fetch_array($result)){
			$fieldValueName = str_replace("frm_","",$inputFieldName);
			$selected = "";
			if($row["$fieldValueName"] == $selectedId)
				$selected = "SELECTED";
			$relation_name_o = "";
			foreach($relation_name as $value){
				//echo $row["$value"];
				$relation_name_o = $relation_name_o . " " .$row["$value"];
			}
			echo "<option $selected VALUE=\"".$row["$fieldValueName"]."\">".$relation_name_o."</option>";
			$selected = "";
		}
		echo "</select>";
	}
?>