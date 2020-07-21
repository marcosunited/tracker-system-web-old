<?
        require 'vendor/autoload.php';
        $callouts = new callouts();
        
        class callouts
        {
                function index()
                {
                        $data = array();

                        view("callouts/callouts_table",$data);
                }

                function open()
                {   
                        $start =  strtotime(date('d-m-Y',time()));
                        $end = $start + 86400;

                        $data = array
                        (
                                "openresults" => query("select * from callouts_view where callout_status_id = 1 order by callout_time DESC")  
                        );

                        view_plain("callouts/callouts_open",$data);
                }

                function shutdowns()
                {
                        $data = array
                        (
                                "shutdowns" => query("select * from callouts_view where callout_status_id = 3 order by callout_time DESC")   
                        );

                        view_plain("callouts/callouts_shutdowns",$data);
                }
                
                function shutdowns_board()
                {
                        $data = array(
                                "shutdowns" => query("select * from callouts_view where callout_status_id = 3 order by callout_time DESC")   
                        );

                        view_plain("callouts/callouts_shutdowns_board",$data);
                }
                
                function followups()
                {
                        $data = array
                        (
                                "followups" => query("select * from callouts_view where callout_status_id = 4 order by callout_time DESC")   
                        );
                        
                        view_plain("callouts/callouts_followups",$data);
                }

                function repairs()
                {
                        $data = array
                        (
                                "repairs" => query("select * from callouts_view where callout_status_id = 5")   
                        );
                        
                        view_plain("callouts/callouts_repairs",$data);
                }

                function watchlist()
                {
                        $today = time();
                        $last_week = $today - 604800;

                        $data = array
                        (
                                "watchlist" => query("select * from callouts_view where callout_time > $last_week  AND job_group like '%WATCHLIST%'")
                        );
                        
                        view_plain("callouts/callouts_watchlist",$data);
                }

                function past()
                {
                        $today =  strtotime(date('d-m-Y',time()));

                        $data = array(
                        "results" => query("select * from callouts_view where callout_status_id != 1 order by callout_time DESC limit 0,1000")
                        );

                        view("callouts/callouts_past",$data);
                }

                function form()
                {
                        $values = _getValues("callouts","callout_id");

                        if($values["callout_time"]=="")
                        {
                                $values["callout_time"] = toDateTime(time());
                                $values["callout_status_id"] = 1;
                                $values["chargeable_id"] = 2;
                                $values["attributable_id"] = 1;
                                $values["priority_id"] = 1;
                        }else
                        {
                                $values["callout_time"] = toDateTime($values["callout_time"]);
                        }

                        if($values["time_of_arrival"] > 0)
                                $values["time_of_arrival"] = toDateTime($values["time_of_arrival"]);

                        if($values["time_of_departure"] > 0)
                                $values["time_of_departure"] = toDateTime($values["time_of_departure"]);		

						if($values["rectification_time"] > 0)
                                $values["rectification_time"] = toDateTime($values["rectification_time"]);								

                        
                        $data = array
                        (
                                "values"=>$values
                        );

                        view("callouts/callouts_form",$data);                                            
                }


                function action()
                {			
                        //If the notify button is not checked, then clear the email
                        if(req('chk_notify')=="")
                        {
                                //destroy the variuable and it wont update the db, which is what we want
                                req("frm_notify_email","");
                        }

                        //Set some more variables for entry to the callouts table
                        req("frm_callout_time",strtotime(req("frm_callout_time")));
                        req("frm_time_of_arrival",strtotime(req("frm_time_of_arrival")));   
						req("frm_rectification_time",strtotime(req("frm_rectification_time")));  
                        req("frm_time_of_departure",strtotime(req("frm_time_of_departure")));
                        req("frm_user_id",sess("user_id"));
                        req("frm_updated",time());
                        
						if(req("frm_callout_status_id")!=2){
							//req("frm_is_printed","0");
						}
						
                        //Do some work to get the checked lift boxes
                        $lift_ids = "";

                        foreach ($_REQUEST as $req_var => $req_val) 
                        {
                                if(strstr($req_var,"lift_"))
                                {
                                        $lift_ids.= "|".$req_val."|";
                                }
                        }

                        $lift_ids = str_replace("||","|",$lift_ids);
                        $lift_names = liftNames($lift_ids,$return = true);
                        
						
                        req("frm_lift_ids",$lift_ids);

                        //Get the job information
                        $job = mysqli_fetch_array(query("select * from jobs where job_id = ".req("frm_job_id")));
                        $fault = mysqli_fetch_array(query("select * from _faults where fault_id = ".req('frm_fault_id')));
                        $technician_fault = mysqli_fetch_array(query("select * from _technician_faults where technician_fault_id = ".req('frm_technician_fault_id')));
                
                        $alert = _submitForm("callouts","callout_id");


                        $callout_id = req("frm_callout_id");

                        $job_message = mysqli_fetch_array(query("select * from jobs where job_id = ".req("frm_job_id")));
                        $fault_message = mysqli_fetch_array(query("select * from _faults where fault_id = ".req('frm_fault_id')));
                        $job_message1 = $job_message["job_name"];
                        $fault_message1 = $fault_message["fault_name"];
						$tech_info = mysqli_fetch_array(query("select * from callouts where callout_id = $callout_id"));
                        $tech_id = $tech_info["technician_id"];
                        $tech_phone = mysqli_fetch_array(query("select * from technicians where technician_id = $tech_id"));
                        $tech_phone1 = $tech_phone["technician_phone"];


                        //EMAIL PART Disabled until my brain is working to fix it.						
						//include(app('path')."\\app\\views\\callouts\\callouts_email.php");

                        if(req("frm_callout_status_id")==1 && req("frm_callout_id") != ''){
                        try {

                                // Prepare ClickSend client.
                                $client = new \ClickSendLib\ClickSendClient('thom@unitedlifts.com.au', '248CAD71-79B9-AC88-BBBE-DC59D28A51D4');

                                // Get SMS instance.
                                $sms = $client->getSMS();

                                // The payload.
                                $messages =  [
                                        [
                                        "source" => "php",
                                        "from" => "UnitedLift",
                                        "body" => "Hi please check the link and close the Callout cloud.unitedlifts.com.au/melbournemrs/callouts/form/$callout_id
                                                   Lift Number is:$lift_names 
                                                   Job Name is:$job_message1
                                                   Fault Name is:$fault_message1
												   Please do NOT reply this message",
                                        "to" => "$tech_phone1",
                                        ]
                                ];

                                // Send SMS.
                                $response = $sms->sendSms(['messages' => $messages]);

                                print_r($response);

                                } catch(\ClickSendLib\APIException $e) {

                                print_r($e->getResponseBody());

                                }
                        }

                        $url = app('url');
                        if(req("frm_callout_id") != '')
                        {			
                                redirect("$url/exec/callouts/form/?alert=$alert&frm_callout_id=".req("frm_callout_id"));
                        }else
                        {
                                redirect("$url/exec/callouts/?alert=$alert");
                        }
                }

                function printPdf()
                {
                        $callout_id = req("frm_callout_id");
                        
                        $query = "select * from callouts 
                        inner join jobs on callouts.job_id = jobs.job_id
                        inner join technicians on callouts.technician_id = technicians.technician_id
                        inner join _faults on callouts.fault_id = _faults.fault_id
			inner join _technician_faults on callouts.technician_fault_id = _technician_faults.technician_fault_id
                        inner join _corrections on callouts.correction_id = _corrections.correction_id
                        inner join _chargeable on callouts.chargeable_id = _chargeable.chargeable_id
                        where callout_id = $callout_id";
                        

                        $callout = mysqli_fetch_array(query($query));
                        
                        $data = array
                        (
                                "callout" => $callout
                        );
                        
                        view_plain("callouts/callouts_print",$data);
                }

                function getLifts()
                {
                        $job_id = req("frm_job_id");
                        $query = "select * from lifts where job_id = $job_id order by lift_name asc";
                        $jobLifts = query($query);

                        $i=0;
                        $x=1;
                        while($lift = mysqli_fetch_array($jobLifts))
                        {
                                $lift_name = $lift["lift_name"];
                                $checked = "";

                                if(strstr(req("frm_lift_names"),"|".$lift["lift_id"]."|"))
                                {
                                        $checked = "CHECKED";   
                                }
                                
                                echo "<div style='float:left;min-width:200px'><input class='check liftcheck' type='checkbox' $checked name='lift_$x' value='".$lift["lift_id"]."'>".$lift["lift_name"]."</div>";
                                $i++;
                                $x++;
                                if($i==2)
                                        {
                                                $i=0;
                                                echo "<div class='break'></div>";
                                        }
                        }
                }

                function getMap()
                {
                        $job_id = req("frm_job_id");
                        $job = mysqli_fetch_array(query("select * from jobs where job_id = $job_id"));
                        mapper($job["job_latitude"],$job["job_longitude"],$job["job_name"]);
                }
                
                function getTech()
                {
                        $job_id = req("frm_job_id");
                        $job = mysqli_fetch_array(query("select * from jobs 
                        inner join rounds on rounds.round_id = jobs.round_id
                        inner join technicians on rounds.round_id = technicians.round_id
                        where job_id = $job_id"));
                        echo $job["technician_id"];
                }
                function getContact()
                {
                        $job_id = req("frm_job_id");
                        $contact = mysqli_fetch_array(query("select job_contact_details from jobs where job_id = $job_id"));
                        echo $contact["job_contact_details"];
                }
                
                function getEmail()
                {
                        $job_id = req("frm_job_id");
                        $contact = mysqli_fetch_array(query("select job_email from jobs where job_id = $job_id"));
                        echo $contact["job_email"];
                }
                
                function getNotify()
                {
                        $job_id = req("frm_job_id");
                        $contact = mysqli_fetch_array(query("select notify_instant from jobs where job_id = $job_id"));
                        echo $contact["notify_instant"];
                } 
                
                function delete()
                {
                        $id = req('frm_callout_id');
                        $query = "delete from callouts where callout_id = $id";
                        query($query);
                        if(strstr($_SERVER['HTTP_REFERER'],'callouts/past')){
                                redirect(app('url')."/exec/callouts/past/?alert=Callout Deleted");
                        }else{
                                redirect(app('url')."/exec/callouts/?alert=Callout Deleted");
                        }
                }
                function checkDocket()
                {
                        $docket_number = req('docket_number');
                        $query = "select * from callouts where docket_number = '$docket_number'";
                        $result = get_query($query);
                        if(sizeof($result)>0){
                                echo "1";
                        }else{
                                echo 0;
                        }
                }                
        }
?>
