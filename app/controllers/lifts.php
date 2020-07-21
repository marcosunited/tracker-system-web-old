<?php

    /*
        Lifts Controller
        Version: 14.2.24
        Cody Joyce
    */
    
	$lifts = new lifts();
	class lifts{
		function index()
		{
			$job_id = req("frm_job_id");
            $data = array(
				"result" => query("select * from lifts 
                inner join jobs on lifts.job_id = jobs.job_id
                inner join _status on lifts.status_id = _status.status_id
                where lifts.job_id = $job_id
                ")
			);			
			view_plain("lifts/lifts_table",$data);
		}
		function form()
		{
			$lift = _getValues("lifts","lift_id");
            
            if(req("frm_lift_id")){
                req("frm_job_id",$lift["job_id"]);
            }
            $data = array(
				"lift" => $lift
			);			
			view_plain("lifts/lifts_form",$data);                                            
		}
		function action()
		{
            $url = app('url');
            $alert = _submitForm("lifts","lift_id");           
            $job_id = req("frm_job_id");
            redirect("$url/exec/lifts/?alert=$alert&frm_job_id=$job_id");	
		}
        function delete()
        {
            $lift_id = req("frm_lift_id");
            $job_id = req("frm_job_id");
            $query = "delete from lifts where lift_id = $lift_id";
            query($query);
            
            redirect(app("url")."/exec/lifts/?frm_job_id=$job_id&alert=Lift Deleted");
        }
	}
?>