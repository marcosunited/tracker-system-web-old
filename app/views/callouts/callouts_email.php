<?
        
        //Test Email
        if(req("chk_notify") == "on" && req("frm_callout_status_id")==2){

                $address = $job["job_address_number"]." ".$job["job_address"];
                $subject = "United Lifts Call Report";
                
				$description = str_replace('\r\n',"<br>",req("frm_callout_description"));
                
				$fault = $fault['fault_name'];
                $technician_fault = $technician_fault['technician_fault_name'];
                
                $tech_description = str_replace('\r\n',"<br>",req("frm_tech_description"));
                
				

				$toc = date("d-m-Y G:i:s",req("frm_callout_time"));
                
				$toa = date("d-m-Y G:i:s",req("frm_time_of_arrival"));
                
				$tod = date("d-m-Y G:i:s",req("frm_time_of_departure"));
                
				$order_number = req("frm_order_number");
                                if($order_number == ""){
                                                $order_number = "N/A";
                                }
				
				$myID = req("frm_docket_number");
				
				if($myID == ''){
					$myID = "N/A";
				}
                
                $message = "
                <p>
                    This notification is to advise completion of your call out (Docket Number: $myID, Order Number: $order_number) to Unit(s)<br>
                    <b>$lift_names</b> at <b>$address</b> on <b>$toc</b>.
                </p>

                <p>The fault as reported to us was '<b>$fault</b>' - '<b>$description</b>'. Our technician attended at <b>$toa</b>.</p>

                <p>The cause of the fault was '<b>$technician_fault</b>', and the technicians rectification was '<b>$tech_description</b>'. Our technician departed at <b>$tod</b>.</p>
				
                <p>We trust our service was satisfactory, however we welcome your feedback to our office<br> via phone 9687 9099 or email info@unitedlifts.com.au.</p>

                <p>Thankyou for your continued patronage.</p>

                <p>United Lift Services</p>               
                ";
                
                $emails = explode(";",req("frm_notify_email"));

                foreach($emails as $email){
                                mailer($email,"info@unitedlifts.com.au","unitedlifts.com.au",$subject,$message);
                }
                
        }
?>