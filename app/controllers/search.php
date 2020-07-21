<?
        $search = new search();
        class search{
                function index()
                {
                        $string = req("search");
                        
                        $call_docket_numbers = "select * from callouts where docket_number LIKE '%$string%'";
                        $maint_docket_numbers = "select * from maintenance where docket_no LIKE '%$string%'";
                        $phone_numbers = "select * from lifts where lift_phone LIKE '%$string%'";
                        $address = "select * from jobs where job_address LIKE '%$string%' OR job_address_number LIKE '%$string%'";
                        $job_name = "select * from jobs where job_name LIKE '%$string%'";
            
                        $data = array(
                                "call_docket_numbers" => query($call_docket_numbers),
                                "maint_docket_numbers" => query($maint_docket_numbers),
                                "phone_numbers"=>query($phone_numbers),
                                "address" => query($address),
                                "job_name" => query($job_name)
                        );
                        	
	
                        view("search/search_results",$data);

                }
        }
?>
