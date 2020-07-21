<?
    /*
        Rounds Controller
        14.2.24
        Cody Joyce
    */

    $rounds = new rounds();
    class rounds{
        //show a list of all rounds in table form
        function index()
        {
            $data = array(
                "result" => query("select *,(select count(*) from jobs where jobs.round_id = rounds.round_id AND jobs.status_id=1) 
                    as job_count from rounds inner join _status on rounds.status_id = _status.status_id")
            );			
            view("rounds/rounds_table",$data);
        }
        function form()
        {
            $data = array(
                "values" => _getValues("rounds","round_id")
            );			
            view("rounds/rounds_form",$data);                                            
                            }
        function action()
        {
                $url = app('url');
                $alert = _submitForm("rounds","round_id");
                if(req("frm_round_id") != ''){ 					//if an id was specified, we must have done an update. go back to the item we just updated
                    redirect("$url/exec/rounds/form/?alert=$alert&frm_round_id=".req("frm_round_id"));
                }else{ 													//no field id? then it must be a new record, lets go back to create another new record.
                    redirect("$url/exec/rounds/?alert=$alert");
                }
        }
        
        //This will print a table list of all jobs in a round.
        function jobslist()
        {
            $round_id = req("frm_round_id");
    
            $query = "select * from technicians 
                inner join rounds on technicians.round_id = rounds.round_id 
                where technicians.round_id = $round_id";
            $technician = mysqli_fetch_array(query($query));
            
            $round = mysqli_fetch_array(query("select * from rounds where round_id = $round_id"));
            
            $query = "  select * from jobs
                        inner join rounds on jobs.round_id = rounds.round_id
                        inner join _frequency on jobs.frequency_id = _frequency.frequency_id
                        where jobs.round_id = $round_id 
                        AND jobs.status_id = 1 
                        order by job_name asc";
            $result = query($query);
            
            $data = array(
                "result"=>$result,
                "technician"=>$technician,
                "round"=>$round
            );
            view_plain("rounds/rounds_jobs_list",$data);
        }
        
        //This will show a map with coloured markers for rounds, if no round_id is specified, all rounds are shown.
        function map()
        {
            if(req("frm_round_id")){
                $round_id = req("frm_round_id");
                $query = "select * from jobs inner join rounds on jobs.round_id = rounds.round_id where jobs.round_id = $round_id and jobs.status_id = 1";     
            }else{
                $query = "select * from jobs inner join rounds on jobs.round_id = rounds.round_id  WHERE jobs.status_id = 1";
            }
            $jobs = query($query);
            $data = array(
                "jobs" => $jobs
            );
            view_plain("rounds/rounds_map",$data);
        }
    }
?>