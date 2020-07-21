<?
    function liftNames($names,$return=null)
    {
        $ids = rtrim(ltrim($names,"|"),"|");
        $ids = explode("|",$ids);
        $string = "";
		
        $i=0;
        foreach($ids as $id){
            $row = get_query("select * from lifts where lift_id = $id");
            $string .= $row[0]["lift_name"];
            $i++;
            if($i<count($ids))
                $string .= ",";
        }
		if($return == null){
			echo $string;
		}else{
			return $string;
		}		
    }
    function areaNames($names)
    {
		if( $names == "") return "";
        $string = "";
        
        $ids = rtrim(ltrim($names,"|"),"|");
        $ids = explode("|",$ids);
        $k=0;
        $i=0;
        foreach($ids as $id){
            $row = get_query("select * from _service_areas where service_area_id = $id");
            $string .= $row[0]["service_area_name"];
            $i++;
            if($i<count($ids))
                $string .= ",";
        }
        return $string;
    }
    function typeNames($names)
    {
		if( $names == "") return "";
        
        $string = "";
        
        $ids = rtrim(ltrim($names,"|"),"|");
        $ids = explode("|",$ids);
        
        $i=0;
        foreach($ids as $id){
            $row = get_query("select * from _service_types where service_type_id = $id");
            $string .= $row[0]["service_type_name"];
            $i++;
            if($i<count($ids))
                $string .= ",";
                        
        }
        
        return $string;
    }
    function taskNames($ids)
    {
        $string = "";
        
        $ids = rtrim(ltrim($ids,"|"),"|");
        $ids = explode("|",$ids);
        
        $i=0;
        foreach($ids as $id){
            $row = get_query("select * from _new_tasks where task_id = $id");
            $string .= $row[0]["task_name"];
            $i++;
            if($i<count($ids))
                $string .= ",";
                        
        }
        
        return $string;
    }     
    function explodeIds($values)
    {
        $ids = rtrim(ltrim($values,"|"),"|");
        $ids = explode("|",$ids);
        return $ids;
    }
?>