<?
        
        //Test Email
        if(req("chk_notify") == "on" && req("frm_completed_id")==2){

                $address = $job["job_address_number"]." ".$job["job_address"];
                $subject = "United Lifts Call Report";
                $description = str_replace("\r\n","<br>",req("frm_maintenance_notes"));
                
                $maintenance_date = toTime(req("frm_maintenance_date"));
                
                
                if(req('frm_maintenance_id') != "")
                {
                        $myID = req("frm_maintenance_id");
                }else
                {
                        $myID = mysqli_insert_id(db::$conn);
                }
                
                $message = "
                <p>
                        This notification is to advise completion of your maintenance call (reference: $myID) to lift(s)<br>
                        <b>$lift_names_clean</b> at <b>$address</b> on <b>$toc</b>.
                </p>

                <p>We trust our service was satisfactory, however we welcome your feedback to our office<br> via phone 9687 9099 or email info@unitedlifts.com.au.</p>
                <p><b>Maintenance Description:</b> $description</p>
                <p>Thankyou for your continued patronage.</p>

                <p>United Lift Services</p>               
                ";
                
                $emails = explode(";",req("frm_notify_email"));

                foreach($emails as $email){
                                mailer($email,"info@unitedlifts.com.au","unitedlifts.com.au",$subject,$message);
                }
                
        }
?>