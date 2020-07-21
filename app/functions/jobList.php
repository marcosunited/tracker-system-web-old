<?
    function jobList($inputFieldName,$parentTable,$selectedId,$relation_name,$where){
		$relation_name = explode(",",$relation_name);
		$query = "select * from $parentTable $where ";
		$result = query($query);
		
		echo "<select name=\"$inputFieldName\" id=\"$inputFieldName\">";
		echo "<option value=''>SELECT</option>";
		while($row = mysqli_fetch_array($result)){
			
            $fieldValueName = str_replace("frm_","",$inputFieldName);
			
            $selected = "";
			
            if($row["$fieldValueName"] == $selectedId)
				$selected = "SELECTED";

                
			echo "<option $selected VALUE=\"".$row["$fieldValueName"]."\">".$row["job_address_number"]." ".$row["job_address"]." ".$row["job_suburb"]."</option>";
			$selected = "";
		}
		echo "</select>";
	}
?>