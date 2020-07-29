<?
        require 'vendor/autoload.php';
        $repairs = new repairs();
        
        class repairs
        {
                function index()
                {
                        $data = array();

                        view("repairs/repairs_table",$data);
                }

                function repaired()
                {
                        $data = array
                        (
                                "repairs" => query("select * from repairs
                                inner join jobs on repairs.job_id = jobs.job_id
                                inner join technicians on repairs.technician_id = technicians.technician_id
                                where repair_status_id = 1") 
                        );
                        view_plain("repairs/repairs_maintable",$data);
                }
                
                function closerepaired()
                {
                        $data = array
                        (
                                "repairs" => query("select * from repairs
                                inner join jobs on repairs.job_id = jobs.job_id
                                inner join technicians on repairs.technician_id = technicians.technician_id
                                where repair_status_id = 2") 
                        );
                        view_plain("repairs/repairs_maintable",$data);
                }



                function form()
                {
                        $values = _getValues("repairs","repair_id");

                        $jobQuery = query("select j.job_id, j.job_number , j.job_name, j.invoice_notes from jobs j WHERE j.job_id =".$values["job_id"]);
                        $job = mysqli_fetch_assoc($jobQuery);

                        if($values["repair_time"]=="")
                        {
                                $values["repair_time"] = toDateTime(time());
                                $values["repair_status_id"] = 1;
                                $values["chargeable_id"] = 2;
                        }else
                        {
                                $values["repair_time"] = toDateTime($values["repair_time"]);
                        }

                        if($values["time_of_arrival"] > 0)
                                $values["time_of_arrival"] = toDateTime($values["time_of_arrival"]);

                        if($values["time_of_departure"] > 0)
                                $values["time_of_departure"] = toDateTime($values["time_of_departure"]);		
							

                        
                        $data = array
                        (
                                "values"=>$values,
                                "job"=>$job
                        );

                        view("repairs/repairs_form",$data);                                            
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
                        req("frm_repair_time",strtotime(req("frm_repair_time")));
                        req("frm_time_of_arrival",strtotime(req("frm_time_of_arrival")));   
						req("frm_rectification_time",strtotime(req("frm_rectification_time")));  
                        req("frm_time_of_departure",strtotime(req("frm_time_of_departure")));
                        req("frm_user_id",sess("user_id"));
                        req("frm_updated",time());
                        
						if(req("frm_repair_status_id")!=2){
							//req("frm_is_printed","0");
						}
						
                        //Do some work to get the checked lift boxes
                        $lift_ids = "";
						
						if($_FILES['file']){
                                if(uploadFile(app('app_path')."/uploads/")){
                                req("frm_repair_attatch",basename($_FILES['file']['name']));
                                }
                            }

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
                       
                        $alert = _submitForm("repairs","repair_id");


                        $url = app('url');
                        if(req("frm_repair_id") != '')
                        {			
                                redirect("$url/exec/repairs/form/?alert=$alert&frm_repair_id=".req("frm_repair_id"));
                        }else
                        {
                                redirect("$url/exec/repairs/?alert=$alert");
                        }
                }

                function printPdf()
                {
                        $repair_id = req("frm_repair_id");
                        
                        $query = "select * from repairs 
                        inner join jobs on repairs.job_id = jobs.job_id
                        inner join technicians on repairs.technician_id = technicians.technician_id
                        inner join _chargeable on repairs.chargeable_id = _chargeable.chargeable_id
                        where repair_id = $repair_id";
                        

                        $repair = mysqli_fetch_array(query($query));
                        
                        $data = array
                        (
                                "repair" => $repair
                        );
                        
                        view_plain("repairs/repairs_print",$data);
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
                        $id = req('frm_repair_id');
                        $query = "delete from repairs where repair_id = $id";
                        query($query);
                        if(strstr($_SERVER['HTTP_REFERER'],'repairs/past')){
                                redirect(app('url')."/exec/repairs/past/?alert=Callout Deleted");
                        }else{
                                redirect(app('url')."/exec/repairs/?alert=Callout Deleted");
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
