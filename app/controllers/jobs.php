<?php
        /*
                Jobs Controller
                Version: 14.2.24
                Cody Joyce
        */

        $jobs = new jobs();
        class jobs{
                function index()
                {
                        $where = "";
                        
                        if(req("round_id")){
                                $where = " where jobs.round_id = ".req("round_id");
                        }
                        
                        $data = array(
                                "result" => query("select *, case 
                                                        when contract_flag = 2 then 'contract_ok.svg'
                                                        when contract_flag = 1 then 'contract_coming_due.svg'
                                                        when contract_flag = 0 then 'contract_overdue.svg'
                                                        else 'no_information.svg'
                                                        end AS contract_icon

                                                        FROM (
                                                        select 
                                                                job_id,
                                                                job_suburb,
                                                                job_number,
                                                                job_agent_contact,
                                                                agent_name,
                                                                status_name,
                                                                job_name,
                                                                job_floors,
                                                                job_address,
                                                                job_address_number,
                                                                job_contact_details,
                                                                job_owner_details,
                                                                job_group,
                                                                round_name,
                                                                round_colour,
                                                                invoice_notes,
                                                                (select count(*) from lifts where lifts.job_id= jobs.job_id) as lift_count,
                                                                case 
                                                                        when DATE_SUB(DATE(FROM_UNIXTIME(finish_time)), INTERVAL 30 DAY) >= NOW() then 2
                                                                        when DATE_SUB(DATE(FROM_UNIXTIME(finish_time)), INTERVAL 30 DAY) < NOW() AND DATE(FROM_UNIXTIME(finish_time)) > DATE_SUB(NOW(), INTERVAL 1 DAY) then 1
                                                                        when DATE_SUB(DATE(FROM_UNIXTIME(finish_time)), INTERVAL 30 DAY) < NOW() then 0
                                                                else -1
                                                                end AS contract_flag
                                                        from jobs 
                                                        inner join agents on jobs.agent_id = agents.agent_id
                                                        inner join _status on jobs.status_id = _status.status_id
                                                        inner join rounds on jobs.round_id = rounds.round_id
                                                ) AS jobs
                                                $where
                                ")
                        );                      
                        view("jobs/jobs_table",$data);
                }
                
                function form()
                {
                        $job = _getValues("jobs_full","job_id");

                        $query = "select * from rounds";
                        $allRounds = query($query);

                        $result = query("select * from rounds where round_id = ".$job["round_id"]);
                        $round=null;
                        
                        if($job["start_time"] > 0)
                                $job["start_time"] = date("Y-m-d", $job["start_time"]);

                        if($job["finish_time"] > 0)
                                $job["finish_time"] = date("Y-m-d", $job["finish_time"]);
							
							if($job["cancel_time"] > 0)
                                $job["cancel_time"] = date("Y-m-d", $job["cancel_time"]);
							
						if($job["active_time"] > 0)
                                $job["active_time"] = date("Y-m-d", $job["active_time"]);
						
						if($job["inactive_time"] > 0)
                                $job["inactive_time"] = date("Y-m-d", $job["inactive_time"]);

                        if(is_object($result))
                                $round = mysqli_fetch_array($result);
							
						if($job["contract_flag"] == 2)
							$job["contract_status"] = "Active";
						elseif($job["contract_flag"] == 1)
							$job["contract_status"] = "About to due";
						elseif($job["contract_flag"] == 0)
							$job["contract_status"] = "Overdue";
						else
							$job["contract_status"] = "No information";

                        $data = array(
                                "job" => $job,
                                "round" =>$round,
                                "allRounds"=>$allRounds
                        );

                        view("jobs/jobs_form",$data);                                            
                }
                
                function printJobs()
                {
                        $where = "";
                        if(req("round_id")){
                        $where = " where jobs.round_id = ".req("round_id");
                        }
                        $data = array(
                        "result" => query("select 
                        job_id,job_suburb,job_number,jobs.status_id,job_agent_contact,job_key_access,agent_name,status_name,job_name,job_floors,job_address,job_address_number,job_contact_details,job_owner_details,job_group,round_name,round_colour,start_time,finish_time,price,
                        (select count(*) from lifts where lifts.job_id= jobs.job_id) as lift_count
                        from jobs 
                        inner join agents on jobs.agent_id = agents.agent_id
                        inner join _status on jobs.status_id = _status.status_id
                        inner join rounds on jobs.round_id = rounds.round_id
                        $where order by job_number,job_address,job_address_number ASC
                        ")
                        );                      
                        view_plain("jobs/jobs_print",$data);
                }
                
                function printAccess()
                {
                        $where = "";
                        
                        if(req("round_id")){
                                $where = " where jobs.round_id = ".req("round_id");
                        }

                        $orderby = "order by job_number ASC";

                        if(req('sort')){
                                $orderby = "order by job_address,job_address_number ASC";
                        }

                        $data = array(
                                "result" => query("select 
                                        job_id,job_suburb,job_number,jobs.status_id,job_agent_contact,job_key_access,agent_name,status_name,job_name,job_floors,job_address,job_address_number,job_contact_details,job_owner_details,job_email,job_group,round_name,round_colour,
                                        (select count(*) from lifts where lifts.job_id= jobs.job_id) as lift_count
                                        from jobs 
                                        inner join agents on jobs.agent_id = agents.agent_id
                                        inner join _status on jobs.status_id = _status.status_id
                                        inner join rounds on jobs.round_id = rounds.round_id
                                        where job_key_access <>  '' $orderby
                                ")
                        );                      
                        
                        view_plain("jobs/jobs_access",$data);
                }
                
                function callouts()
                {
                        $id = req("frm_job_id");
                        $query = "select * from callouts_view where job_id = $id order by callout_time DESC";
                        $results = query($query);
                        $data = array(
                                "results"=>$results
                        );
                        
                        view_plain("jobs/jobs_callouts",$data);
                }
                
                function maintenance()
                {
                        $id = req("frm_job_id");
                        $query = "select * from maintenance_view where job_id = $id AND (lift_id IS NULL OR  lift_id > 0) order by maintenance_date DESC";
                        $results = query($query);
                        $data = array(
                                "results"=>$results
                        );
                        
                        view_plain("jobs/jobs_maintenance",$data);                       
                }
				
                function repair()
                {
                        $id = req("frm_job_id");
                        $query = "select * from repairs where job_id = $id order by repair_time DESC
                                  ";
                        $results = query($query);
                        $data = array(
                                "results"=>$results
                        );
                        
                        view_plain("jobs/jobs_repair",$data);                       
                }
                
                function action()
                {
                        $url = app('url');
                        
                        
                        if(req("frm_notify_instant"))
                        {
                                req("frm_notify_instant",1);
                        }else{
                                $_REQUEST["frm_notify_instant"]=0;
                        }

                        req("frm_start_time",strtotime(req("frm_start_time")));   
                        req("frm_finish_time",strtotime(req("frm_finish_time")));
						req("frm_cancel_time",strtotime(req("frm_cancel_time")));
						req("frm_active_time",strtotime(req("frm_active_time")));
						req("frm_inactive_time",strtotime(req("frm_inactive_time")));
						
						       if($_FILES['file']){
                    if(uploadFile(app('app_path')."/uploads/")){
                        req("frm_job_attatch",basename($_FILES['file']['name']));
                    }
                }
				
								 if($_FILES['file2']){
                    if(uploadFile(app('app_path')."/uploads/")){
                        req("frm_cancel_file",basename($_FILES['file2']['name']));
                    }
                }
                        
                        //geolocate the address automagially if GPS coordinates are not included in the form submission
                        $gps_ok = false;
                        if(req("frm_job_latitude")==""){
                                $address = req("frm_job_address_number") ." ".req("frm_job_address") . " " . req("frm_job_suburb") . " Australia";
                                $geo = geolookup($address);
                                if($geo != "ERROR!"){
                                    $gps = explode(" ", $geo);
                                    $gps_ok = true;

                                    req("frm_job_latitude",$gps[1]);
                                    req("frm_job_longitude",$gps[0]);
                                }
                        }

                        if($gps_ok){
                            $alert = _submitForm("jobs","job_id");
                            if(req("frm_job_id")){
                                    redirect("$url/exec/jobs/form/?alert=$alert&frm_job_id=".req("frm_job_id"));
                            }else{
                                    redirect("$url/exec/jobs/?alert=$alert");
                            }
                        }else{
                            $alert = 'Invalid Address';
                            redirect("$url/exec/jobs/?alert=$alert");
                        }
                }
                
                function delete()
                {
                        $url = app("url");
                        $job_id = req("frm_job_id");
                        $query = "delete from jobs where job_id = $job_id";
                        query($query);
                        $query = "delete from callouts where job_id = $job_id";
                        query($query);
                        redirect("$url/exec/jobs/?alert=Job and callouts Deleted");
                }
        }
