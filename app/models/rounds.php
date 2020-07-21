<?
    /*
        These are some simple helpers for the rounds
        Version: 14.2.24
        Cody Joyce
    */
    
    //show all techs assigned to a round, as hrefs to the edit tech page
    function list_round_techs($round_id)
    {
        $query = "select * from technicians where round_id = $round_id AND status_id = 1";
        $techs = query($query);
        while($tech = mysqli_fetch_array($techs)){
            echo "<a href='".app('url')."/exec/technicians/form/?frm_technician_id=".$tech["technician_id"]."'>".$tech['technician_name']."</a> "; 
        }
    }
    
    //Do a count of all the lift units in a round
    function round_lift_count($round_id)
    {   
        
        $query="select * from jobs where round_id = $round_id and jobs.status_id = 1";
        $result = query($query);
        $lift_count = 0;
        while($row=mysqli_fetch_array($result)){
            $job_id = $row["job_id"];
            $query = "select count(*) as lift_count from lifts where job_id = $job_id";
            $lifts = mysqli_fetch_array(query($query));
            $lift_count = $lift_count + $lifts["lift_count"];
        }
        return $lift_count;
    }
    
    //Do a lift count for a Job
    function job_lift_count($job_id)
    {   
        $query="select * from jobs where job_id = $job_id and jobs.status_id=1";
        $result = query($query);
        $lift_count = 0;
        while($row=mysqli_fetch_array($result)){
            $job_id = $row["job_id"];
            $query = "select count(*) as lift_count from lifts where job_id = $job_id";
            $lifts = mysqli_fetch_array(query($query));
            $lift_count = $lift_count + $lifts["lift_count"];
        }
        return $lift_count;
    }        
?>