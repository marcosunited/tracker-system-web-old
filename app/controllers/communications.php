<?
    $communications = new communications();
    class communications
    {
        function index()
        {
            $job_id = req("frm_job_id");
            $query = "select * from communications 
            inner join users on communications.user_id = users.user_id
            inner join jobs on communications.job_id = jobs.job_id
            where communications.job_id = $job_id";
            
            $data = array(
                "result" => query($query),
                "job_id" => $job_id
            );			
            view_plain("communications/communications_table",$data);
        }

        function form()
        {
            $values = _getValues("communications","communication_id");
            
            if($values["communication_time"] == ""){
                $values["communication_time"] = toDateTime(time());
            }else{
                 $values["communication_time"] = toDateTime($values["communication_time"]);
            }

            if(strlen(req("frm_job_id"))>0){
                $values["job_id"] = req("frm_job_id");
            }
            
            $data = array(
                "values" => $values,
                "job_id" => $values["job_id"]
            );			
            view_plain("communications/communications_form",$data);                                            
        }

        function action()
        {
            if(req("frm_communication_time")){
                req("frm_communication_time",strtotime(req("frm_communication_time")));
            }
            
            $url = app('url');
            $alert = _submitForm("communications","communication_id");
            if(req("frm_communication_id") != ''){ 					//if an id was specified, we must have done an update. go back to the item we just updated
                redirect("$url/exec/communications/?alert=$alert&frm_job_id=".req("frm_job_id"));
            }else{ 													//no field id? then it must be a new record, lets go back to create another new record.
                redirect("$url/exec/communications/?alert=$alert&frm_job_id=".req("frm_job_id"));
            }
        }
        function delete(){
            $communication_id = req("frm_communication_id");
            $url = app('url');
            $query = "delete from communications where communication_id = $communication_id";
            query($query);
            redirect("$url/exec/communications/?alert=Communication Deleted&frm_job_id=".req("frm_job_id"));
            
        }
    }
?>