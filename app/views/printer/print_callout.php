<html>
<head>
    <style>
        body {
          background: #fff; 
		  margin:0px;
		  padding:0px;
        }
		
		#myDiv{
          width: 172mm;
          height: 262mm;			
		}
		
        page[size="A4"] {
          background: white;
          width: 210mm;
          height: 246mm;
          display: block;
          margin: 0 auto;
          box-shadow: 0 0 0.0cm rgba(0,0,0,0.5);
        }

        @media print {
          body, page[size="A4"] {
            margin: 0;
            box-shadow: 0;
          }
        }
        *{
            font-family:sans-serif;
            font-size:12px;
        }
        label{
            width:150px;
            float:left;
            font-weight:bold;
        }
        h2{
            padding:0px;
            margin:5px;
        }
        #tableborder{
            border:1px solid black;
            width:150mm;
            height:200mm;
            background-color:#faffb2;
            padding:10px;
        }
        .docketno{
            font-size:16px;
            color:#be0000;
        }
    </style>
</head>
<body>

    <div id="myDiv">
                <table width="100%">
            <tr>
                <td>
                    <img src="<?=app('url')?>/app/images/logo.png" >
                </td>
                <td style="text-align:center">
                    24 Hour Service, Phone 9687 9099<br>
                    <b><u>Customer Service Report</u></b>
                </td>
                <td  style="text-align:center">
                   <div class="docketno">#<?=$callout["callout_id"]?><br>P.<?=$callout["docket_number"]?> </div>
                </td>
                
            </tr>
        </table>
        <p>&nbsp;</p>
        <table width="100%">
            <tr>
                <td>
                    <p><label>Date:</label> <?=date(toDate($callout["callout_time"]))?></p>
                    <p><label>Client Name:</label> <?=$callout["job_name"]?></p>
                    <p><label>Address:</label> <?=$callout["job_address_number"]?> <?=$callout["job_address"]?> <?=$callout["job_suburb"]?></p>
                    <p><label>Contract No:</label> <?=$callout["job_number"]?></p>         
                </td>
                <td>
                    <p><label>Time of Call:</label> <?=toTime($callout["callout_time"])?></p>
                    <p><label>Time of Arrival:</label> <?=toTime($callout["time_of_arrival"])?></p>
                    <p><label>Time of Departure:</label> <?=toTime($callout["time_of_departure"])?></p>
                    <p><label>Order No:</label> <?=$callout["order_number"]?></p> 
                    <p><label>Chargeable</label> <?=$callout["chargeable_name"]?></p> <br>  
                </td>
            </tr>
            <tr>
                <td colspan="2">
                        <div style="border:1px solid black;height:300px;padding:10px;">
                                <p><b><u>CALL DETAILS</u></b></p>
                                
                                <p><b>Reported Fault (COMPLAINT): </b> <?=$callout["fault_name"]?></p>
                                <p><b>For Lifts: </b><?=liftNames($callout["lift_ids"])?></p>
                                
                                <p><b>Call Description:</b> <?=$callout["callout_description"]?></p>
                                
                                <div style="height:1px;width:100%;background-color:#000;margin-bottom:10px;"></div>
                                
                                <p><b><u>DESCRIPTION OF WORK</u></b></p>
                                <p><b>Fault Found (CAUSE):</b> <?=$callout["technician_fault_name"]?></p>
                                <p><b>Work Action (CORRECTION):</b><?=$callout["correction_name"]?></p>
                                <p><b>Work Decription:</b><br><?=$callout["tech_description"]?></p>
                        </div>
                </td>
            </tr>
            <tr>
                <td>
                    <p><b>Service Technician</b></p>
                    <?=$callout["technician_name"]?>
                    <?if($callout["technician_signature"] != ''){?>
                        <img src="<?=$callout["technician_signature"]?>" width="200px">
                    <?}?>
                    
                </td>
                <td>
                    <p><b>Customer Signature</b></p>
                    &nbsp;
                    <?if($callout["customer_signature"] != ''){?>
                        <img src="<?=$callout["customer_signature"]?>" width="200px">
                    <?}?>
                    
                </td>                
            </tr>                
        </table>
    </div>
</body>
</html>