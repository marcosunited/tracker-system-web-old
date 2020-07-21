<?
	function timeExceeded($fault,$callout_time,$toa){
		//echo date("D",$callout_time);
		if(date("G:i:s",$callout_time) > "16:30:00" && date("G:i:s",$callout_time) < "08:00:00"){
			//echo "after hours";
			$emergencyTime=3600; // 60 mins
			$normalTime=4800; // 80 mins	
			$minorTime = 14400; //4 hours
		}else{
			//echo "business hours";
			$emergencyTime = 2700; // 45 mins
			$normalTime =3600; // 60 mins
			$minorTime = 14400; //4 hours			
		}

		if(date("D",$callout_time) == "Sat" || date("D",$callout_time) == "Sun"){
			$emergencyTime=3600; // 60 mins
			$normalTime=4800; // 80 mins		
		}
		
		$responseTime = $toa - $callout_time;
		
		if( //if an emergency
			$fault == "SWP" ||
			$fault == "O.O.O"
		){
			if($responseTime > $emergencyTime){
				echo "YES";
			}else{
				echo "NO";
			}
		}elseif(
			$fault == "Stuck Button" ||
			$fault == "Noisy" ||
			$fault == "Doors opening and closing" ||
			$fault == "Running, not leveling" ||
			$fault == "Jerking"
		){
			if($responseTime > $normalTime){
				echo "YES";
			}else{
				echo "NO";
			}		
		}else{
			if($responseTime > $minorTime){
				echo "YES";
			}else{
				echo "NO";
			}			
		}
	}
?>