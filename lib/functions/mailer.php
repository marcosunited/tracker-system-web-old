<?
        function mailer($mailto,$from,$domain,$mysubject,$message)
        {
                $message = str_replace("\n", "<br>", $message);
                $headers = "From: $from\r\n";
                $headers .= "Reply-To: $mailto\r\n";
                $headers .= "Return-Path: $domain\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                //send the message
                mail($mailto, $mysubject, $message, $headers);            
        }
?>