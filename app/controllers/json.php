<?
	$json = new json();
	class json{
	    function index(){
	        $this->users();
	    }
	    function users(){
            header("Access-Control-Allow-Origin: *");
			$sth = query("SELECT * from users");
            $rows = array();
            while($r = mysqli_fetch_assoc($sth)) {
                $rows[] = $r;
            }
            print json_encode($rows);	        
	        
	    }
	    function jobs(){
            header("Access-Control-Allow-Origin: *");
			$sth = query("SELECT * from jobs where status_id = 1 order by job_address,job_address_number asc");
            $rows = array();
            while($r = mysqli_fetch_assoc($sth)) {
                $rows[] = $r;
            }
            print json_encode($rows);	        
	        
	    }	    
	}
?>
