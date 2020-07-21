<?
    /* 
        ULS Service Tracking
        Technicians Controller
    */
    
    $technicians = new technicians();
    class technicians{

        function index()
        {
            $data = array(
                "result" => query("select 
                technician_id,technician_name,technician_phone,technician_email,round_name,round_colour,status_name from technicians
                   inner join rounds on technicians.round_id = rounds.round_id
                   inner join _status on technicians.status_id = _status.status_id
				   
                ")
            );			
            view("technicians/technicians_table",$data);
        }
        function form()
        {
            $values = _getValues("technicians","technician_id");
            
            $result = query("select * from rounds where round_id = ".$values["round_id"]);
            
            if(is_object($result)){
            $round = mysqli_fetch_array($result);
            }else{
                $round = null;
            }
            
            $allRounds = query("select * from rounds");
            $data = array(
                "values" => $values,
                "round" => $round,
                "allRounds" => $allRounds
            );			
            view("technicians/technicians_form",$data);                                            
        }
        function action()
        {
                
				$url = app('url');
                $alert = _submitForm("technicians","technician_id");
                
				//Add the technician as a user with a default password, keep the ID's Consistant between technicians and users
				$query = "select * from technicians order by technician_id DESC";
				$result = 
				$row = mysqli_fetch_array(query($query));
				
				$user_id = $row['technician_id'];
				$username = $row['technician_name'];
				$password = md5('ClearSky2015');
				$realname = $row['technician_name'];
				$auth_level = 10;
				$image = "fry.png";
				
				$query = "insert into users (user_id,username,password,realname,auth_level,image,user_email)
					VALUES ($user_id,'$username','$password','$realname',$auth_level,'$image','')
				";
				query($query);
				//echo $query;
				//End add user
				
				if(req("frm_technician_id") != '')
                { 					//if an id was specified, we must have done an update. go back to the item we just updated
                    redirect("$url/exec/technicians/form/?alert=$alert&frm_technician_id=".req("frm_technician_id"));
                }else{ 													//no field id? then it must be a new record, lets go back to create another new record.
                    redirect("$url/exec/technicians/?alert=$alert");
                }
        }
    }
?>