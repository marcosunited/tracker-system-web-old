<?
	$tech_maintenance = new tech_maintenance();
	
	class tech_maintenance{
		function index()
		{
            $last_week = time() - 604800;
            $next_week = time() + 604800;
            
            $query = "select * from maintenance
									inner join jobs on maintenance.job_id = jobs.job_id
									inner join technicians on maintenance.technician_id = technicians.technician_id
									where maintenance_date > $last_week
                                    and maintenance_date < $next_week
                                    and (lift_id IS NULL OR  lift_id > 0)
                                    order by maintenance.maintenance_date ASC";
                                    
			$data = array(
				"results" => get_query($query)
			);		         
         
			view("tech_maintenance/maintenance_table",$data);			
		}
        
        function newCall()
        {
           $job_id = req('frm_job_id');
           $job = get_query("select * from jobs where job_id = $job_id");
           $tasks = get_query("select * from _new_tasks");
            
           $data = array(
                "job"=>$job,
                "tasks"=>$tasks
           );
           
           view("tech_maintenance/maintenance_new",$data);	 
        }
        
        function form()
        {
            $values = _getValues("maintenance_view","maintenance_id");
            $tasks = get_query("select * from _new_tasks");
            $data = array(
                "values"=>$values,
                "tasks"=>$tasks
            );
            
            view("tech_maintenance/maintenance_form",$data);
        }
        
        function getLifts()
        {
            $job_id = req("frm_job_id");
            $query = "select * from lifts where job_id = $job_id";
            $jobLifts = query($query);
            
            $i=0;
            $x=1;
            echo "<fieldset id='myLifts' data-role='controlgroup'>\n";
            echo "<legend>Lift</legend>\n";
            while($lift = mysqli_fetch_array($jobLifts))
            {
                $lift_name = $lift["lift_name"];
                $checked = "";
                
                if(strstr(req("frm_lift_names"),"|".$lift["lift_id"]."|")){
                    $checked = "CHECKED";   
                }

                //echo "<input class='check liftcheck' type='checkbox' $checked name='lift_$x' value='".$lift["lift_id"]."'>".$lift["lift_name"];
                echo "<input type='checkbox' $checked name='lift_$x' id='lift_$x' class='custom' value='".$lift["lift_id"]."'/>\n";
                echo "<label for='lift_$x'>".$lift["lift_name"]."</label>\n";
                $i++;
                $x++;

            }
            echo '</fieldset>';
        }
        
        function getAreas()
        {
            $areas = query("select * from _service_areas");
            
            echo "<fieldset id='myAreas' data-role='controlgroup'>\n";
            echo "<legend>Service Area</legend>\n";
            $x=1;
            while($area = mysqli_fetch_array($areas))
            {
                $area_name = $area["service_area_name"];
                $checked = "";
                
                if(strstr(req("frm_service_area_ids"),"|".$area["service_area_id"]."|")){
                    $checked = "CHECKED";   
                }
                echo "<input type='checkbox' $checked name='service_area_$x' id='service_area_$x' class='custom' value='".$area["service_area_id"]."'/>";
                echo "<label for='service_area_$x'>".$area["service_area_name"]."</label>\n";
                $x++;
            }
            echo "</fieldset>";
        }

        function getTypes()
        {
            $types = query("select * from _service_types");
            
            echo "<fieldset id='myAreas' data-role='controlgroup'>\n";
            echo "<legend>Service Type</legend>\n";
            
            $x=1;
            while($type = mysqli_fetch_array($types))
            {
                $type_name = $type["service_type_name"];
                $checked = "";
                
                if(strstr(req("frm_service_type_ids"),"|".$type["service_type_id"]."|")){
                    $checked = "CHECKED";   
                }
                echo "<input type='checkbox' $checked name='service_type_$x' id='service_type_$x' class='custom' value='".$type["service_type_id"]."'>";
                echo "<label for='service_type_$x'>".$type["service_type_name"]."</label>\n";
                $x++;
            } 
            echo "</fieldset>";
        }

        function action()
		{
				$url = app('url');
				req('frm_maintenance_date',time());
                req('frm_technician_id',sess('user_id'));
            //Do some work to get the checked lift boxes
                $lift_ids = "";
                foreach ($_REQUEST as $req_var => $req_val) {
                    if(strstr($req_var,"lift_")){
                        $lift_ids.= "|".$req_val."|";
                    }
                }
                $lift_ids = str_replace("||","|",$lift_ids);
                req("frm_lift_ids",$lift_ids);
                    
            //work out the service areas
                
                req("frm_service_area_ids","|0|");

            //work out the service types           
                req("frm_service_type_ids","|0|");                        
            
            
            //Work out the tasks
                $task_ids = "";
                foreach ($_REQUEST as $req_var => $req_val) {
                    if(strstr($req_var,"task_")){
                        $task_ids.= "|".$req_val."|";
                    }
                }
                $task_ids = str_replace("||","|",$task_ids); 
                req("frm_task_ids",$task_ids);                     
                    
                //change date strings to timestamp
                req('frm_maintenance_toa',strtotime(req('frm_maintenance_toa')));
                req('frm_maintenance_tod',strtotime(req('frm_maintenance_tod')));
                
				_submitForm("maintenance","maintenance_id");
				
				//now we add X days to the date according to the frequency specified initially
				if(req('schedule')>0){
                    req('frm_maintenance_date',strtotime(req('schedule')));
                    req('frm_completed_id',1);
                    //req('frm_maintenance_notes','');
                    req('frm_maintenance_toa',' ');
                    req('frm_maintenance_tod',' ');                    
                    $alert = _submitForm("maintenance","maintenance_id");
                }

				if(req("frm_maintenance_id")){ 
					redirect("$url/exec/rounds/");
				}else{     
					redirect("$url/exec/rounds/?alert=$alert");
				}
		}     
	}
?>
