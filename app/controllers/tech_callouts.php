<?
    $tech_callouts = new tech_callouts();
    class tech_callouts{
        function index()
        {
            $data = array(
                "openresults" => query("select * from callouts_view where callout_status_id=1 and technician_id = ".sess('user_id'))               
            );			
            view("tech_callouts/tech_callouts_table",$data);
        }
        
        function tabledata()
        {
            $data = array(
                "openresults" => query("select * from callouts_view where callout_status_id=1 and technician_id = ".sess('user_id'))               
            );			
            view_plain("tech_callouts/tech_callouts_table_data",$data);
        }  
        
        function newCall()
        {
            
            
            view("tech_callouts/tech_callouts_new",null);
        }
        
        function form()
        {
            $id = req('frm_callout_id');
			
            $query = "select * from callouts_view 
            inner join callouts on callouts_view.callout_id = callouts.callout_id
            where callouts.callout_id = $id";
            
            $values = mysqli_fetch_array(query($query));

            $values["callout_time"] = date("d-m-Y G:i:s",($values["callout_time"]));
            			
			$now = str_replace(" ","T",date("Y-m-d G:i:s",(time())));
			
			$job_id = $values["job_id"];
			$timesheet = get_query("select * from timesheet where job_id = $job_id AND timesheet_tod = 0");

            $data = array(
               "values"=>$values,
			   "timesheet"=>$timesheet,
			   "now"=>$now
            );			

			
            if($values["accepted_id"]==0){
                view("tech_callouts/tech_callouts_accept",$data); 
            }else{
                view("tech_callouts/tech_callouts_form",$data); 
            }
        }

        
        function action()
        {
            $url = app('url');
 
            //Do some work to get the checked lift boxes
                $lift_ids = "";
                foreach ($_REQUEST as $req_var => $req_val) {
                    if(strstr($req_var,"lift_")){
                        $lift_ids.= "|".$req_val."|";
                    }
                }
                $lift_ids = str_replace("||","|",$lift_ids);

                req("frm_lift_ids",$lift_ids);
            //end lifts
            
            req("frm_time_of_arrival",strtotime(req("frm_time_of_arrival")));
            req("frm_time_of_departure",strtotime(req("frm_time_of_departure")));
			req('frm_technician_fault_id',req('fault_id'));
			
            //echo req("frm_lift_ids");
            $alert = _submitForm("callouts","callout_id");
            
            redirect(app("url")."/exec/tech_callouts/");
        }
        
        function accept()
        {
            $callout_id = req("frm_callout_id");
            if(req("frm_callout_accepted")==1){ //accepted the call
                query("update callouts set accepted_id = 1 where callout_id = $callout_id");
                redirect(app('url')."/exec/tech_callouts/");
            }else{  //denied the call
                query("update callouts set technician_id = 20 where callout_id = $callout_id");
                redirect(app('url')."/exec/tech_callouts/");
            }
        }
		
		function checkin()
		{
			$callout_id = req('callout_id');
			$toa = time();
			
			$query = "update callouts set time_of_arrival = $toa where callout_id = $callout_id";
			query($query);
		}
		
		function checkout()
		{
			$callout_id = req('callout_id');
			$tod = time();
			
			$query = "update callouts set time_of_departure = $tod where callout_id = $callout_id";
			query($query);
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
                
                if(strstr(req("frm_lift_ids"),"|".$lift["lift_id"]."|")){
                    $checked = "CHECKED";   
                }

                //echo "<input class='check liftcheck' type='checkbox' $checked name='lift_$x' value='".$lift["lift_id"]."'>".$lift["lift_name"];
                echo "<input $checked type='checkbox' name='lift_$x' id='lift_$x' class='custom' value='".$lift["lift_id"]."'/>\n";
                echo "<label for='lift_$x'>".$lift["lift_name"]."</label>\n";
                $i++;
                $x++;

            }
            echo '</fieldset>';
        }		
    }
?>
