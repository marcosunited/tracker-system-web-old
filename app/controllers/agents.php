<?
    /*
        Agents Controller
        Version 14.2.24
        Cody Joyce
    */
    
    $agents = new agents();
    class agents{
        function index()
        {
            $data = array(
                "agents" => get_query("select * from agents")
            );
            
            view("agents/agents_table",$data);
        }
        
        function form(){
            $data = array(
                "values" => _getValues("agents","agent_id")
            );			
            view("agents/agents_form",$data);                                           
        }
        
        function action()
        {
                $url = app('url');
                $alert = _submitForm("agents","agent_id");
                if(req("frm_agent_id") != ''){ 	//if an id was specified, we must have done an update. go back to the item we just updated
                    redirect("$url/exec/agents/form/?alert=$alert&frm_agent_id=".req("frm_agent_id"));
                }else{ 													//no field id? then it must be a new record, lets go back to create another new record.
                    redirect("$url/exec/agents/?alert=$alert");
                }
        }
        
        function report()
        {
            $agent = _getValues("agents","agent_id");
            
            $query = "select *,(select count(*) from lifts where lifts.job_id = jobs.job_id) 
                    as lift_count from jobs inner join _status on jobs.status_id = _status.status_id where agent_id = ".req("frm_agent_id");
            $jobs = get_query($query);

            $data = array(
                "agent" => _getValues("agents","agent_id"),
                "jobs"=>$jobs
            );
            
            view_plain("agents/agents_report",$data); 
        }
    }
?>