<?
    $tech_rounds = new tech_rounds();
	
    class tech_rounds{
        function index()
        {
            $uid = sess('user_id');
            
            $query = "
                select * from rounds 
                inner join jobs on jobs.round_id = rounds.round_id 
                inner join technicians on technicians.round_id = rounds.round_id
                where technicians.technician_id = $uid 
                AND jobs.status_id = 1
                order by jobs.job_address, jobs.job_address_number asc";        
                    
            if(req("all")){
            $query = "
                select * from jobs
				inner join rounds on rounds.round_id = jobs.round_id 
                WHERE jobs.status_id = 1
                order by jobs.job_address, jobs.job_address_number asc";             
            }
            
            $data = array(
                "rounds" => query($query)
            );
            
            view("tech_rounds/tech_rounds_table",$data);
        }
        
        function form()
        {
            $job_id = req('frm_job_id');

			$job = mysqli_fetch_array(query("select * from jobs 
                        inner join _frequency on jobs.frequency_id = _frequency.frequency_id
						where jobs.job_id = $job_id"));
			
			$timesheet = get_query("select * from timesheet where job_id = $job_id AND timesheet_tod = 0");
		
            $data = array(
                "job"=>$job,
				"timesheet"=>$timesheet
            );
            view("tech_rounds/tech_rounds_form",$data);
        }
		

    }
?>