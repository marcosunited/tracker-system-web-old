<?

    //this class is still here for historic purposes and if we need it again.
    $techupdate = new techupdate();
    class techupdate
    {
        function index(){
            /*
                Codys Technician Updater Script
                14.3.14
            */
            
            $query = "SELECT * FROM `jobs` 
                    inner join rounds on jobs.round_id = rounds.round_id
                    inner join technicians on rounds.round_id = technicians.round_id";
            $newjobs = query($query);

            while($newjob = mysqli_fetch_array($newjobs))
            {
                $job_number = $newjob["job_number"];
                $new_tech_id = $newjob["technician_id"];
                
                $oldjob = query("select * from oldjobs where job_no = $job_number");
                
                //check to make sure the job is there before we do any updating
                if(mysqli_num_rows($oldjob)>0){
                    $query = "update oldjobs set technician_id = $new_tech_id where job_no = $job_number";
                    query($query);
                    echo $query . "<br>";
                    //echo "Updated: " . $job_number . "<br>";
                }
            }
        }
    }
?>