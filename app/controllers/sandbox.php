<?
    $sandbox = new sandbox();
    class sandbox
    {
		
        function showRequest()
		{
			print_r($_REQUEST);
		}
		function addUsers(){
			$query = "INSERT INTO `users` (`user_id`, `username`, `password`, `realname`, `auth_level`, `image`) VALUES (NULL, '', '', '', '', NULL);";
			
			for($i=0;$i<10000;$i++){
				query($query);
			}
			
			//$query = "delete from users where user_id < 1000";
			//query($query);
		}
        function jobsearch(){
            view("job_search",null);
        }
        
        function docket_numbers(){
            for($i=0;$i<500000;$i++){
                $query = "INSERT INTO `service_tracking`.`callouts` (`callout_id`, `job_id`, `fault_id`, `technician_id`, `technician_fault_id`, `priority_id`, `callout_status_id`, `lift_names`, `floor_no`, `callout_description`, `tech_description`, `order_number`, `docket_number`, `contact_details`, `callout_time`, `time_of_arrival`, `time_of_departure`, `chargeable_id`) VALUES (NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');";
                query($query);
                echo "$i<br>";
            }
        }
        function populate_inventory(){
            $query="
                INSERT INTO `service_tracking`.`inventory` (`inventory_id`, `inventory_item_name`, `inventory_no`, `inventory_brand`, `supplier_id`, `inventory_reorder_details`, `inventory_qty`, `inventory_warning_qty`, `inventory_photo`, `inventory_shelf_no`, `inventory_notes`) VALUES (NULL, '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
            ";
            
            for($i=0;$i<1000;$i++){
                query($query);
            }
        }
        function add_numbers(){
            //get a list of all lifts and their job/lift numbers
            $query = "select * from jobs 
                inner join lifts on jobs.job_id = lifts.job_id";
            $result = query($query);
            
            //loop thru the list
            while($row = mysqli_fetch_array($result)){
                $job_no = $row["job_number"];
                $lift_id = $row['lift_id'];
                $lift_name = $row["lift_name"];
                
                //select the lift details from the phone_numbers table
                $query = "select * from phone_numbers where job_no = $job_no AND lift_no = $lift_name";
                $result2 = query($query);
                
                //if we have found a match, pop the data into the LIFTS table
                if(mysqli_num_rows(db::$conn,$result2)){
                    $row2=mysqli_fetch_array($result2);
                    $lift_phone = $row2["phone_no"];
                    query("update lifts set lift_phone = '$lift_phone' where lift_id = $lift_id");
                }
            }
        }
        function split_address()
        {
            $query = "select * from jobs";
            $result = query($query);

            $i=0;
            while($row=mysqli_fetch_array($result)){
                $job_id = $row["job_id"];
                $address = explode(' ', $row["job_address"], 2);
                $address_number = $address[0];
                $address_street = $address[1];
                $query = "update jobs 
                            set job_address = '$address_street',
                            job_address_number = '$address_number'
                            where job_id = $job_id
                         ";
                echo "$i: ".$query."<br>";
                $i++;
                query($query);
            }

            
        }
        function mailer()
        {

            $mail = imap_open('{mail.unitedlifts.com.au:993/novalidate-cert/imap/ssl}','system@unitedlifts.com.au', 'ClearSky2014');
            $headers = imap_headers($mail);
            $last = imap_num_msg($mail);
            
            //loop thru the emails
            for($x=1;$x<=$last;$x++){   
                //START EMAIL
                    $myMessage = "";
                    
                    $st = imap_fetchstructure($mail, $x);
                    $overview = imap_fetch_overview($mail,$x,0);
                    $headers = imap_headerinfo($mail,$x);
                    $sentfrom = $headers->from[0]->mailbox . "@" . $headers->from[0]->host;
                    $communication_time = time();
                    $subject = $overview[0]->subject;
                    
                    $subject = explode("||",$subject);
                    $job_number = $subject[0];
                    
                    $subject_name = $subject[1];
                    
                    $myMessage .= "<b>From: $sentfrom</b><br>";
                    $myMessage .= "<b>Subject:</b> " . $subject_name."<br>";
                    
                    $user = mysqli_fetch_array(query("select user_id from users where user_email = '$sentfrom'"));
                    $user_id = $user['user_id'];
                    
                    $job = mysqli_fetch_array(query("select job_id from jobs where job_number = $job_number"));
                    $job_id = $job['job_id'];
                    
                    //if the email is multipart (Which it usually is from outlook)
                    if (!empty($st->parts)) {
                        
                        //loop thru each part of the email, display the contents depending on the type of data
                        for($i=0;$i<count($st->parts);$i++) {
                            $part = $st->parts[$i];                        
                                //echo "<b>---------------------------".$part->subtype."-------------------------</b><br>";

                                
                                if($part->subtype == "ALTERNATIVE"){
                                    $myMessage .= str_replace("\n","<br>",imap_fetchbody($mail, $x, $i+1+".1"));
                                }elseif($part->subtype == "PLAIN"){
                                    $myMessage .= str_replace("\n","<br>",imap_fetchbody($mail, $x, $i+1));
                                }

                                //IMAGE PROCESS
                                if($part->subtype == "GIF"){
                                    $body = imap_fetchbody($mail, $x, $i+1);
                                    $myMessage .= "<img src=\"data:image/png;base64,$body\">";
                                }
                                
                                if($part->subtype == "JPEG"){
                                    $body = imap_fetchbody($mail, $x, $i+1);
                                    $myMessage .= "<img src=\"data:image/png;base64,$body\">";
                                }

                                
                        }
                        
                        //insert the message into the communications table
                        $query = "insert into communications (user_id,job_id,communication_time,communication_subject,communication_body)
                                VALUES ($user_id,$job_id,$communication_time,'$subject_name','$myMessage')";
                        query($query);
                        echo $query;
                        
                    }
                //END EMAIL
                imap_delete($mail,$x,0);
                
            }
            imap_expunge($mail);
            imap_close($mail);
        }
    }
?>
