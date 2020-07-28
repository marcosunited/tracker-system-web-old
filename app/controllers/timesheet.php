<?
	$timesheet = new timesheet();
	class timesheet{
		function index()
		{
			$data = array(
				"result" => query("select * from timesheet")
			);			
			view("timesheet/timesheet_form",$data);
		}
		
		function generate()
		{
			$start = strtotime(req('frm_start_date'));
			
			$end = strtotime(req('frm_end_date'));
			
			$tech_id = req('frm_technician_id');
			
			$tech = get_query("select * from technicians where technician_id = $tech_id");
			
			$query = "SELECT * FROM callouts_view 
						WHERE time_of_arrival >= $start 
						AND time_of_departure <= $end 
						AND time_of_departure <> 0
						AND technician_id = $tech_id";
			
			$callouts = get_query($query);
            
            $maintenance = get_query("select * from maintenance
									inner join jobs on maintenance.job_id = jobs.job_id
									inner join technicians on maintenance.technician_id = technicians.technician_id
									where maintenance.maintenance_toa >= $start 
									AND maintenance.maintenance_tod <= $end 
									AND maintenance.maintenance_tod <> 0
									AND ( maintenance.lift_id IS NULL OR  maintenance.lift_id > 0)
									AND maintenance.technician_id = $tech_id");
			
			$totalTime = 0;
			
			$chargeable = "";
			if($callout["chargeable_id"] = "1"){
				$chargeable = "Yes";
			}else{
				$chargeable = "No";
			};
			
			foreach($callouts as $callout)
			{
				$totalTime = $totalTime + ($callout["time_of_departure"] - $callout["time_of_arrival"]);
			}
			foreach($maintenance as $callout)
			{
				$totalTime = $totalTime + ($callout["maintenance_tod"] - $callout["maintenance_toa"]);
			}            
            
			
			$data = array(
				"callouts" => $callouts,
                "maintenance"=>$maintenance,
				"totalTime" => $totalTime,
				"tech"=>$tech,
				"chargeable" => $chargeable
			);
			
			view_plain("timesheet/timesheet_generate",$data);
		}
	}
?>
