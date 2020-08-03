<?
    $reports = new reports();
    class reports{
        function index()
        {
            $data = array(
                "result" => query("select * from reports")
            );			
            view("reports/reports_home",$data);
        }
        
        function site()
        {
            $data = array(
                "jobs" => query("select * from jobs order by job_address,job_address_number asc")
            );			
            view("reports/reports_site_form",$data);
        }

        function group()
        
        {
            $query = "select distinct job_group from jobs where status_id = 1";
            $result = query($query);
            $group_list = array();
            
            //Generate a list of groups for the form
            while($row = mysqli_fetch_array($result)){
                $group_names = explode(",",$row["job_group"]);

                foreach($group_names as $group_name){
                    if($group_name){
                        $group_list["$group_name"] = $group_name;
                    }
                }
            };
            
            $data = array(
                "groups"=>$group_list
            );
            
            view("reports/reports_group_form",$data);
        }
        
        function callouts()
        {
            $data = array(
                "allRounds" => query("select * from rounds where status_id = 1")
            );

            view("reports/reports_callouts_form",$data);
        }
        
        function callouts_generate()
        {
            //Get the paramerers from the form
                $start_date = strtotime(req("frm_start_date"));
                $end_date = strtotime(req("frm_end_date"));
                $round_id = req("frm_round_id");
            
                $round = "";
                if(req("frm_round_id"))
                    $round = " AND round_id = $round_id ";     

            
            //create a temporary table for storing / sorting data
                $random = rand(1111,9999);
                $query ="CREATE TEMPORARY TABLE temp_callouts_report_$random(
                           `job_id` INT NULL,
                           `lift_count` INT NULL,
                           `call_count` INT NULL,
                           `call_average` DECIMAL(6,2) NULL
                        )";
                query($query);

            //Loop through each job
                $query = "select * from jobs where status_id = 1 $round";
                $result = query($query);
                $faults = array();
				$callCountTotal = 0;
				
                while($row = mysqli_fetch_array($result))
                {
                    $job_id = $row["job_id"];
                    
                    //number of lifts the job has
                    $query = "select * from lifts where job_id = $job_id";
                    $liftCount = mysqli_num_rows(query($query));
                    
                    //number of calls the job has
                    $query = "select * from callouts_view where job_id = $job_id and callout_time >= $start_date AND callout_time <= $end_date";
                    $callouts = get_query($query);
					$callCount = count($callouts);
					$callCountTotal = $callCountTotal + $callCount;
					
					foreach($callouts as $callout){
						if(isset($faults[$callout["fault_name"]])){
							$faults[$callout["fault_name"]]++;
						}else{
							$faults[$callout["fault_name"]]=1;
						}
					}
                    
                    //work out the call average per unit.
                   

                    //put the data we collected into the temporary table
                    $query ="insert into temp_callouts_report_$random 
                        (job_id,lift_count,call_count) 
                        VALUES
                        ($job_id,$liftCount,$callCount)";
                    
					if($callCount>0)
					query($query);
                }
            
            //select the temporary table by order
                $query = "select * from temp_callouts_report_$random 
                            inner join jobs on temp_callouts_report_$random.job_id = jobs.job_id
                            inner join rounds on jobs.round_id = rounds.round_id
                         ";
                $results = query($query);


                
                $data = array(
                    "results"=>$results,
					"faults"=>$faults,
					"callCountTotal"=>$callCountTotal
                    
                );
                view_plain("reports/reports_callouts_generate",$data);
        }
        
        function group_generate()
        {
            $group_name = req("frm_group_name");
            $start_date = strtotime(req("frm_start_date"));
            $end_date = strtotime(req("frm_end_date"));
            
            $query = "select * from callouts_view 
				where job_group like '%$group_name%' 
				AND callout_time >= $start_date 
				AND callout_time <= $end_date
				ORDER BY callout_time DESC
				";    
            // echo $query;
            
            if(req("frm_fault_id"))
                $query .= " AND fault_id = ".req("frm_fault_id");
            
            if(req("frm_order_by"))
                $query .=" order by ".req("frm_order_by")." ".req("frm_direction");
			
			$faults = array();
			
            $callouts = get_query($query);

            $query1 = "select * from repairs 
            inner join jobs on repairs.job_id = jobs.job_id
            where job_group like '%$group_name%' 
            AND repair_time >= $start_date 
            AND repair_time <= $end_date";   
            
            $repairs = get_query($query1);
            
            $maintenance = get_query("select * ,
                                            SUBSTRING( W.year_month_week ,1  ,4) yearVal, 
                                            CASE SUBSTRING( W.year_month_week ,5  ,2 )
                                            WHEN '01' THEN 'Jan' WHEN '02' THEN 'Feb' WHEN '03' THEN 'Mar' WHEN '04' THEN 'Apr' WHEN '05' THEN 'May'
                                            WHEN '06' THEN 'Jun' WHEN '07' THEN 'Jul' WHEN '08' THEN 'Aug' WHEN '09' THEN 'Sep' WHEN '10' THEN 'Oct'
                                            WHEN '11' THEN 'Nov' WHEN '12' THEN 'Dec' ELSE 'NA' END  monthVal ,SUBSTRING( W.year_month_week ,7  ,2 )  weekVal
                                         from maintenance_view M
                                        LEFT JOIN maintenance_tasks_weekly W ON M.maintenance_id = W.maintenance_id            
                                        where M.job_group like '%$group_name%' 
                                        AND M.maintenance_date >= $start_date 
                                        AND M.maintenance_date <= $end_date
                                        AND (M.lift_id IS NULL OR  M.lift_id > 0 )
                                        AND M.technician_id <> 41 order by M.job_address,M.job_address_number,M.maintenance_date");
                                                                             
			foreach($callouts as $callout){
				if(isset($faults[$callout["fault_name"]])){
					$faults[$callout["fault_name"]]++;
				}else{
					$faults[$callout["fault_name"]]=1;
				}
			}
			
            $data = array (
                "callouts"=>$callouts,
                "start_date"=>$start_date,
                "end_date"=>$end_date,
				"group_name"=>$group_name,
				"faults"=>$faults,
                "maintenance"=>$maintenance,
                "repairs"=>$repairs
            );

            view_plain("reports/reports_group_generate",$data);	
        }
        
        function group_maintenance_generate()
        {
            $group_name = req("frm_group_name");
            $start_date = strtotime(req("frm_start_date"));
            $end_date = strtotime(req("frm_end_date"));
            
            $task_id = req('frm_task_id');
            $tasks='';
            
            if(req('frm_task_id'))
                $tasks = "AND M.task_ids like '%|$task_id|%'";
            
            $query = "select * from maintenance_view M
                        LEFT JOIN maintenance_tasks_weekly W ON M.maintenance_id = W.maintenance_id
                                        where M.job_group like '%$group_name%' 
                                        AND (M.lift_id IS NULL OR M.lift_id > 0)
                                        AND M.maintenance_date >= $start_date 
                                        AND M.maintenance_date <= $end_date
                                        $tasks
                                        order by M.job_address,M.job_address_number";
           // echo $query;
            $maintenance = get_query($query);


            $data = array (
                "start_date"=>$start_date,
                "end_date"=>$end_date,
				"group_name"=>$group_name,
                "maintenance"=>$maintenance
            );

            view_plain("reports/reports_group_maintenance_generate",$data);
        }        

        function site_generate()
        {
            $job_id = req("frm_job_id");
            $job = mysqli_fetch_array(query("select * from jobs where job_id = $job_id"));
            
            $start_date = strtotime(req("frm_start_date"));
            $end_date = strtotime(req("frm_end_date"));
            $fault_id = req("frm_fault_id");
            
            $query = "select * from callouts_view where 
            callout_time >= $start_date AND 
            callout_time <= $end_date AND 
            job_id = $job_id";

            $query1 = "select * from repairs 
            inner join jobs where repairs.job_id = jobs.job_id
            job_id = $job_id
            AND repair_time >= $start_date 
            AND repair_time <= $end_date";   
            
            $repairs = get_query($query1);
            

            $maintenance = get_query("select * ,
            SUBSTRING( W.year_month_week ,1  ,4) yearVal, 
            CASE SUBSTRING( W.year_month_week ,5  ,2 )
            WHEN '01' THEN 'Jan' WHEN '02' THEN 'Feb' WHEN '03' THEN 'Mar' WHEN '04' THEN 'Apr' WHEN '05' THEN 'May'
            WHEN '06' THEN 'Jun' WHEN '07' THEN 'Jul' WHEN '08' THEN 'Aug' WHEN '09' THEN 'Sep' WHEN '10' THEN 'Oct'
            WHEN '11' THEN 'Nov' WHEN '12' THEN 'Dec' ELSE 'NA' END  monthVal ,SUBSTRING( W.year_month_week ,7  ,2 )  weekVal
         from maintenance_view M
        LEFT JOIN maintenance_tasks_weekly W ON M.maintenance_id = W.maintenance_id            
        where job_id = $job_id 
        AND M.maintenance_date >= $start_date 
        AND M.maintenance_date <= $end_date
        AND (M.lift_id IS NULL OR  M.lift_id > 0 )
        AND M.technician_id <> 41 order by M.job_address,M.job_address_number,M.maintenance_date");
            
            $agent_id = $job["agent_id"];
            $agent = mysqli_fetch_array(query("select * from agents where agent_id = $agent_id"));
			$result = get_query($query);
			$faults = array();
			
            foreach($result as $row)
            {
                if(!isset($faults[$row['fault_name']]))
                                $faults[$row['fault_name']] = 0;
				$faults[$row['fault_name']]++;
            }

            $data = array (
                "callouts"=>query($query),
                "job"=>$job,
                "maintenances"=>$maintenance,
                "repairs"=>$repairs,
                "agent"=>$agent,
                "start_date"=>$start_date,
                "end_date"=>$end_date,
                "faults"=>$faults
            );

            view_plain("reports/reports_site_generate",$data);
        }

        function maintenance()
        {

            
            $data = array(
               
                "jobs" => query("select * from jobs where status_id= 1 order by job_address,job_address_number asc")
            );			
            view("reports/reports_maintenance_form",$data);
        }        
        
        function maintenance_weekly()
        {

            
            $data = array(
               
                "jobs" => query("select * from jobs where status_id= 1 order by job_address,job_address_number asc")
            );			
            view("reports/reports_maintenance_form_weekly",$data);
        }  

        function maintenance_generate()
        {
            $job_id = req("frm_job_id");
            $job = mysqli_fetch_array(query("select * from jobs where job_id = $job_id"));
            
            $start_date = strtotime(req("frm_start_date"));
            $end_date = strtotime(req("frm_end_date"));
            $fault_id = req("frm_fault_id");
            
            $query = "select * from maintenance
            inner join technicians on maintenance.technician_id = technicians.technician_id
            where maintenance_date >= $start_date AND maintenance_date < $end_date AND job_id = $job_id  AND ( lift_id IS NULL OR  lift_id > 0)
            /*AND completed_id = 2*/";

            
            foreach($_REQUEST as $req=>$val)
            {
                if(strstr($req,"lift_")){
                    $query .= " AND lift_ids like '%|$val|%' ";
                }
            }
            
            if(req("frm_task_id"))
                $query .= " AND task_ids like '%|".req("frm_task_id")."|%'";
            
            if(req("frm_order_by"))
                $query .=" order by ".req("frm_order_by")." ".req("frm_direction");
            
            $agent_id = $job["agent_id"];
            $agent = mysqli_fetch_array(query("select * from agents where agent_id = $agent_id"));
            
            //get results for the graph

			$result = get_query($query);
            //echo $query;

            //echo $query;
            
            $data = array (
                "callouts"=>query($query),
                "job"=>$job,
                "agent"=>$agent,
                "start_date"=>$start_date,
                "end_date"=>$end_date
            );

            view_plain("reports/reports_maintenance_generate",$data);
        }
        
        function maintenance_generate_weekly()
        {
            $start_date = strtotime(req("frm_start_date"));
            $end_date = strtotime(req("frm_end_date"));

            $job_id = req("frm_job_id");
            
            $job = mysqli_fetch_array(query("select * from jobs where job_id = $job_id"));
            
            $startDay = substr(req("frm_start_date") ,0 ,2);            
            $startMonth = substr(req("frm_start_date") ,3 ,2);
            $startYear =substr(req("frm_start_date") ,6);

            $endDay = substr(req("frm_end_date") ,0 ,2);            
            $endMonth = substr(req("frm_end_date") ,3 ,2);
            $endYear =substr(req("frm_end_date") ,6);
            

            $start_week = 1;
            
            if( ( substr($startDay,0 ,1 ) =="0" )) $startDay = substr($startDay,1 ,1 );
            

            if( $startDay <= 7 )  $start_week = 1 ;
            else if( $startDay <= 14 )  $start_week = 2 ;
            else if( $startDay <= 21 )  $start_week = 3 ;
            else if( $startDay <= 28 )  $start_week = 4 ;
            else $start_week = 5 ;

            $startYearMonthWeek = $startYear . $startMonth .$start_week ;

            $end_week = 1;
            if( ( substr($endDay,0 ,1 ) =="0" )) $endDay = substr($endDay,1 ,1 );
            if( $endDay <= 7 )  $end_week = 1 ;
            else if( $endDay <= 14 )  $end_week = 2 ;
            else if( $endDay <= 21 )  $end_week = 3 ;
            else if( $endDay <= 28 )  $end_week = 4 ;
            else $end_week = 5 ;

            $endYearMonthWeek = $endYear . $endMonth .$end_week ;

            $query = "  SELECT W.* , 
                        getSplittedTasks( W.maintenance_id ,SUBSTRING( W.year_month_week ,1  ,4) ,SUBSTRING( W.year_month_week ,5  ,2 ) ,SUBSTRING( W.year_month_week ,7  ,2 ) ) weeklyTasks ,
                        getTaskName( getSplittedTasks( W.maintenance_id ,SUBSTRING( W.year_month_week ,1  ,4) ,SUBSTRING( W.year_month_week ,5  ,2 ) ,SUBSTRING( W.year_month_week ,7  ,2 ) ), L.lift_type) tasks,
                            M.lift_id ,M.maintenance_notes ,T.technician_name ,M.* ,SUBSTRING( W.year_month_week ,1  ,4) yearVal, 
                            CASE SUBSTRING( W.year_month_week ,5  ,2 )
                            WHEN '01' THEN 'Jan' WHEN '02' THEN 'Feb' WHEN '03' THEN 'Mar' WHEN '04' THEN 'Apr' WHEN '05' THEN 'May'
                            WHEN '06' THEN 'Jun' WHEN '07' THEN 'Jul' WHEN '08' THEN 'Aug' WHEN '09' THEN 'Sep' WHEN '10' THEN 'Oct'
                            WHEN '11' THEN 'Nov' WHEN '12' THEN 'Dec' ELSE 'NA' END  monthVal ,SUBSTRING( W.year_month_week ,7  ,2 )  weekVal
                        FROM maintenance_tasks_weekly W
                            JOIN maintenance M ON W.maintenance_id = M.maintenance_id
                            JOIN technicians T ON T.technician_id = M.technician_id
                            JOIN jobs J ON J.job_id = M.job_id
                            JOIN lifts L ON L.lift_id = M.lift_id
                            WHERE J.job_id = $job_id  AND
                                ( W.year_month_week BETWEEN $startYearMonthWeek AND $endYearMonthWeek )
                        ORDER BY W.maintenance_id ,W.year_month_week ,W.date ";

            
            $agent_id = $job["agent_id"];
            $agent = mysqli_fetch_array(query("select * from agents where agent_id = $agent_id"));
            
            //get results for the graph

			$result = get_query($query);
            
            $rows = mysqli_fetch_array(query($query));
            
            $data = array (
                "callouts"=>query($query),
                "job"=>$job ,
                "agent"=>$agent ,
                "start_date"=>$start_date,
                "end_date"=>$end_date
            );

            view_plain("reports/reports_maintenance_generate_weekly",$data);    
        }

        function pits()
        {		
            view("reports/reports_pits_form",null);
        }        
        
        function pits_generate()
        {

            $start_date = strtotime(req("frm_start_date"));
            $end_date = strtotime(req("frm_end_date"));

            
            $query = "select * from maintenance_view            
			where maintenance_date >= $start_date 
            AND maintenance_date < $end_date
            AND (lift_id IS NULL OR  lift_id > 0)
			AND job_group LIKE '%Pit Clean%'
			AND maintenance_notes like '%pits%'
			order by job_address,job_address_number ASC";


            $data = array (
                "callouts"=>query($query),
                "start_date"=>$start_date,
                "end_date"=>$end_date
            );

            view_plain("reports/reports_pits_generate",$data);
        }     


        function period()
        {		
            view("reports/reports_weekly_form",null);
        }    
        
        function period_generate()
        {
            $start_date = strtotime(req("frm_start_date"));
            $end_date = strtotime(req("frm_end_date"));

            
            $query = "select * from callouts_full cf
            inner join jobs on cf.job_id = jobs.job_id
			where cf.callout_time >= $start_date 
			AND cf.callout_time <= $end_date";

            //$num_rows = mysql_num_rows($query);

            $data = array (
                "callouts"=>query($query),
                "start_date"=>$start_date,
                "end_date"=>$end_date,
                //"num_rows"=>$num_rows
            );

            view_plain("reports/reports_weekly_generate",$data);
        }
        
        function weekly_generate()
        {
            $job_id = req("frm_job_id");
            $job = mysqli_fetch_array(query("select * from jobs where job_id = $job_id"));
            
            $startDay = substr(req("frm_start_date") ,0 ,2);            
            $startMonth = substr(req("frm_start_date") ,3 ,2);
            $startYear =substr(req("frm_start_date") ,6);

            $endDay = substr(req("frm_end_date") ,0 ,2);            
            $endMonth = substr(req("frm_end_date") ,3 ,2);
            $endYear =substr(req("frm_end_date") ,6);
            

            $start_week = 1;
            
            if( ( substr($startDay,0 ,1 ) =="0" )) $startDay = substr($startDay,1 ,1 );
            

            if( $startDay <= 7 )  $start_week = 1 ;
            else if( $startDay <= 14 )  $start_week = 2 ;
            else if( $startDay <= 21 )  $start_week = 3 ;
            else if( $startDay <= 28 )  $start_week = 4 ;
            else $start_week = 5 ;

            $startYearMonthWeek = $startYear . $startMonth .$start_week ;

            $end_week = 1;
            if( ( substr($endDay,0 ,1 ) =="0" )) $endDay = substr($endDay,1 ,1 );
            if( $endDay <= 7 )  $end_week = 1 ;
            else if( $endDay <= 14 )  $end_week = 2 ;
            else if( $endDay <= 21 )  $end_week = 3 ;
            else if( $endDay <= 28 )  $end_week = 4 ;
            else $end_week = 5 ;

            $endYearMonthWeek = $endYear . $endMonth .$end_week ;

            /*
            $query = "select * from callouts
            inner join jobs on callouts.job_id = jobs.job_id
			where callout_time >= $start_date 
            AND callout_time < $end_date"; */
            

            $query = "  SELECT W.* ,M.maintenance_date , 
                        getSplittedTasks( W.maintenance_id ,SUBSTRING( W.year_month_week ,1  ,4) ,SUBSTRING( W.year_month_week ,5  ,2 ) ,SUBSTRING( W.year_month_week ,7  ,2 ) ) weeklyTasks ,
                        getTaskName( getSplittedTasks( W.maintenance_id ,SUBSTRING( W.year_month_week ,1  ,4) ,SUBSTRING( W.year_month_week ,5  ,2 ) ,SUBSTRING( W.year_month_week ,7  ,2 ) ), L.lift_type) tasks,
                            M.lift_id ,M.maintenance_notes ,T.technician_name ,M.* ,SUBSTRING( W.year_month_week ,1  ,4) yearVal, 
                            CASE SUBSTRING( W.year_month_week ,5  ,2 )
                            WHEN '01' THEN 'Jan' WHEN '02' THEN 'Feb' WHEN '03' THEN 'Mar' WHEN '04' THEN 'Apr' WHEN '05' THEN 'May'
                            WHEN '06' THEN 'Jun' WHEN '07' THEN 'Jul' WHEN '08' THEN 'Aug' WHEN '09' THEN 'Sep' WHEN '10' THEN 'Oct'
                            WHEN '11' THEN 'Nov' WHEN '12' THEN 'Dec' ELSE 'NA' END  monthVal ,SUBSTRING( W.year_month_week ,7  ,2 )  weekVal
                        FROM maintenance_tasks_weekly W
                            JOIN maintenance M ON W.maintenance_id = M.maintenance_id
                            JOIN technicians T ON T.technician_id = M.technician_id
                            JOIN jobs J ON J.job_id = M.job_id
                            JOIN lifts L ON L.lift_id = M.lift_id
                            WHERE J.job_id = $job_id  AND
                                ( W.year_month_week BETWEEN $startYearMonthWeek AND $endYearMonthWeek )
                        ORDER BY W.maintenance_id ,W.year_month_week ,W.date ";



            //$num_rows = mysql_num_rows($query);

            $data = array (
                "callouts"=>query($query),
                "start_date"=>$start_date,
                "end_date"=>$end_date,
                //"num_rows"=>$num_rows
            );

            view_plain("reports/reports_",$data);
        }    
		
				
		function jobs(){
			
			$data = array(
				"allJobs" => query("select * from jobs")
			);
			
			view_plain("reports/reports_job_generate",$data);
		}
		
        function printReport()
        {
			//we use $_REQUEST here because we dont want any special filtering.
            $contents = $_REQUEST["frm_contents"];
            $contents = str_replace('\r\n',"",$contents);
            $contents = stripslashes($contents);

            define("DOMPDF_ENABLE_HTML5PARSER", true);
            define("DOMPDF_ENABLE_FONTSUBSETTING", true);
            define("DOMPDF_UNICODE_ENABLED", true);
            define("DOMPDF_DPI", 160);
            define("DOMPDF_ENABLE_REMOTE", true);

            require_once(app('lib_path')."/functions/dompdf/dompdf_config.inc.php");
            $dompdf = new DOMPDF();
            $dompdf->load_html($contents);
            $dompdf->set_paper('a4', 'landscape');
            $dompdf->render();
            $dompdf->stream(req("frm_filename"));         
        }         
    
        function lifts()
        {
            $data = array(
                "allRounds" => query("select * from rounds where status_id = 1")
            );

            view("reports/reports_lifts_form",$data);            
        }

        
        function lifts_generate()
        {
                //Get the parameters from the form
                $start_date = strtotime(req("frm_start_date"));
                $end_date = strtotime(req("frm_end_date"));

                //create a temporary table for storing / sorting data
                $random = rand(1111,9999);
                $query ="CREATE TEMPORARY TABLE temp_lifts_report_$random(
                           `lift_id` INT NULL,
                           `job_name` TEXT NULL,
                           `call_count` INT NULL
                        )";
                query($query);
                
                
                $result = query("
                    select * from lifts
                    inner join jobs on lifts.job_id = jobs.job_id 
                    where lifts.status_id = 1 
                    AND jobs.status_id = 1
                    order by lift_id ASC
                ");
                
                while($row = mysqli_fetch_array($result)){
                    $lift_id = $row["lift_id"];
                    $job_id = $row["job_id"];
                    
                    $callouts = query("select * from callouts 
                        inner join jobs on callouts.job_id = jobs.job_id
                        where callout_time >= $start_date
                        AND callout_time <= $end_date
                        AND lift_ids LIKE '%|$lift_id|%'
                    ");
                    
                    $call = mysqli_fetch_array($callouts);
                    $count = mysqli_num_rows($callouts);
                   
                    if($count > 0){
                        $lift_id = $row["lift_id"];
                        $job_name = $call["job_name"];
                       
                        
                        $query = "insert into temp_lifts_report_$random (lift_id,job_name,call_count)
                        VALUES ($lift_id,'$job_name',$count);";
                        query($query);
                    }
                }

                $data = array(
                    "liftcalls" => query("select * from temp_lifts_report_$random order by call_count DESC"),
                    "start_date" => $start_date,
                    "end_date" => $end_date
                );
                
                view_plain("reports/reports_lifts_generate",$data);    
        }
        
        
        function monthly()
        {
            $start_date = strtotime(req("frm_start_date"));
            $end_date = strtotime(req("frm_end_date"));
            
            $query = 
            "
                select 
                    job_id,
                    jobs.round_id,
                    jobs.frequency_id,
                    job_number,
                    job_address,
                    job_address_number,
                    job_name,
                    rounds.round_name,
                    rounds.round_colour,
                    _frequency.frequency_name,
                    _frequency.frequency_value,
                    
                    (select count(*) from callouts where job_id = jobs.job_id) as call_count,
                    (select maintenance_date from maintenance where job_id = jobs.job_id order by maintenance_date DESC limit 1) as last_serviced,
                    (select UNIX_TIMESTAMP(NOW())-last_serviced) as time_since_service
                from jobs 
                    inner join rounds on jobs.round_id = rounds.round_id
                    inner join _frequency on jobs.frequency_id = _frequency.frequency_id
                where 
                    jobs.status_id = 1
                order by 
                    job_address,job_address_number ASC
            ";
            
            $jobs=get_query($query);
            
            $data = array(
                "jobs" => $jobs
            );
            
            view_plain("reports/reports_monthly_generate",$data);    
        }
    }
    
?>