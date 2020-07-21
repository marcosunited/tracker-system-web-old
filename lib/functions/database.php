<?
    class db {
        public static $conn;
    }
    
	function db_connect(){
        db::$conn = new mysqli(app("db_server"), app("db_username"),app("db_password"),app("db_database"));
	}
	
	function query($query){
		$result = mysqli_query(db::$conn,$query);
		return $result;
	}

    function get_query($query)
    {
            $rows = array();
            
            $result = mysqli_query(db::$conn,$query);
            
            if(is_object($result)){
                while($row=mysqli_fetch_array($result)){
                    $rows[] = $row;
                }
            }
           
            return $rows;
    }     
?>
