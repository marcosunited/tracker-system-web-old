<?
    $printer = new printer();
    
    class printer{
        function index(){
                
                
        //Callout Docket printer        
                $printMe = 0;
				
				$query = "select * from callouts 
                        inner join jobs on callouts.job_id = jobs.job_id
                        inner join technicians on callouts.technician_id = technicians.technician_id
                        inner join _faults on callouts.fault_id = _faults.fault_id
                        inner join _corrections on callouts.correction_id = _corrections.correction_id
						inner join _technician_faults on callouts.technician_fault_id = _technician_faults.technician_fault_id
						where callout_status_id = 2
						AND is_printed is null
						OR is_printed = 0";
                $results = query($query);
                
                view_plain("printer/refresher",null);

                while($callout = mysqli_fetch_array($results)){
                        $data = array(
                                "callout"=>$callout
                        );
                        
                        view_plain("printer/print_callout",$data);
                        
                        $id = $callout["callout_id"];
                        $query = "update callouts set is_printed = 1 where callout_id=$id";
                        query($query);
                        $printMe = 1;
                }
        
        //Maintenance Docket Printer - NEW AND IMPROVED......Hmmmmmmm SQUIRES!!
            $query = "select * from maintenance 
                inner join jobs on maintenance.job_id = jobs.job_id
                inner join technicians on maintenance.technician_id = technicians.technician_id
                where is_printed is null /* and completed_id = 2 */";
            $results = query($query);
            
            while($maintenance = mysqli_fetch_array($results))
            {
                    $maintenance_id = $maintenance["maintenance_id"];
                    
                    $query = "select * from maintenance_view where maintenance_id = $maintenance_id";
                    $visit = mysqli_fetch_array(query($query));
                    
                    $job_id = $visit['job_id'];
                    $lifts = get_query("select * from lifts where job_id = $job_id");

                    $data = array(
                                        "visit" => $visit,
                                        "lifts"=>$lifts
                    );
                    
                    view_plain("printer/print_maintenance",$data);
                        
                        $id = $maintenance["maintenance_id"];
                        $query = "update maintenance set is_printed = 1 where maintenance_id=$id";
                        query($query);
                        $printMe = 1;                    
            }
            
            if($printMe == 1){
            view_plain("printer/printer",null);
                }
        }
    }
?>