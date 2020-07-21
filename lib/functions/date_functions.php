<?
    /*
        Version: 14.2.22
        Cody Joyce
        ToDate Function: Convert a timestamp into a human readable date
    */
    function toDate($timestring){
        if($timestring){
            return date("d-m-Y",$timestring);
        }else{
            return null;
        }
    }
	
	    function toDay($timestring){
        if($timestring){
            return date("D",$timestring);
        }else{
            return null;
        }
    }
	
    function toTime($timestring){
        if($timestring){
            return date("H:i",$timestring);
        }else{
            return null;
        }
    }     
    function toDateTime($timestring){
        if($timestring){
            if(is_mobile() == true){
				$mydate = date("Y-m-d H:i:s",$timestring);
				$mydate = str_replace(" ","T",$mydate);
				return $mydate;
			}else{
				return date("d-m-Y H:i:s",$timestring);
			}
			
        }else{
            return null;
        }
    }
        function toDuration($time){
	  if(is_numeric($time)){
		$value = array(
		  "years" => 0, "days" => 0, "hours" => 0,
		  "minutes" => 0, "seconds" => 0,
		);
		if($time >= 31556926){
		  $value["years"] = floor($time/31556926);
		  $time = ($time%31556926);
		}
		if($time >= 86400){
		  $value["days"] = floor($time/86400);
		  $time = ($time%86400);
		}
		if($time >= 3600){
		  $value["hours"] = floor($time/3600);
		  $time = ($time%3600);
		}
		if($time >= 60){
		  $value["minutes"] = floor($time/60);
		  if ($value["minutes"] < 10)
			$value["minutes"] = "0".$value["minutes"];
		  $time = ($time%60);
		}
		
		$value["seconds"] = floor($time);
		if ($value["seconds"] < 10)
			$value["seconds"] = "0".$value["seconds"];
		
		$value["hours"] = $value["hours"] + ($value["days"] * 24);
		return $value["hours"].":".$value["minutes"];
          }else{
	        return (bool) FALSE;
          }
        }
        function toDuration2($time){
	  if(is_numeric($time)){
		$value = array(
		  "years" => '', "days" => '', "hours" => 0,
		  "minutes" => 0, "seconds" => 0,
		);
		if($time >= 31556926){
		  $value["years"] = floor($time/31556926);
		  $time = ($time%31556926);
		}
		if($time >= 86400){
		  $value["days"] = floor($time/86400);
		  $time = ($time%86400);
		}
		if($time >= 3600){
		  $value["hours"] = floor($time/3600);
		  $time = ($time%3600);
		}
		if($time >= 60){
		  $value["minutes"] = floor($time/60);
		  if ($value["minutes"] < 10)
			$value["minutes"] = "0".$value["minutes"];
		  $time = ($time%60);
		}
		
		$value["seconds"] = floor($time);
		if ($value["seconds"] < 10)
			$value["seconds"] = "0".$value["seconds"];
		
		//$value["hours"] = $value["hours"] + ($value["days"] * 24);
		return $value["days"]." Days, ".$value["hours"]." Hours, ".$value["minutes"]." Mins";
          }else{
	        return (bool) FALSE;
          }
        }	
	     
?>
