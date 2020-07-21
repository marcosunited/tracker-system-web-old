<?ob_start();?>
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
        body{
            
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
            background-color:#fff;
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
                   <div class="docketno">#<?=$visit["maintenance_id"]?></div>
                </td>
                
            </tr>
        </table>
        <p>&nbsp;</p>
        <table width="100%">
            <tr>
                <td>
                    <p><label>Date:</label><?=date(toDate($visit["maintenance_date"]))?></p>
                    <p><label>Client Name:</label><?=$visit["job_name"]?></p>
                    <p><label>Address:</label><?=$visit["job_address_number"]?> <?=$visit["job_address"]?> <?=$visit["job_suburb"]?></p>
                    <p><label>Contract No:</label><?=$visit["job_number"]?></p>         
                </td>
                <td>
                    <p><label>Visit Date:</label> <?=toTime($visit["maintenance_toa"])?></p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>&nbsp;</p>
                    <p><b>Maintenance Tasks:</b></p>
                    
                        <table width="100%" border="1" style="border-collapse:collapse">
                            <tr>
                                <th>Maintenance Task</th>
                                <?foreach($lifts as $lift){?>
                                    <th><?=$lift['lift_name']?></th>
                                <?}?>
                            </tr>
							<?
								//Manual entry here because my brain is not fucking working today. Needs to be done tho
								$tasks = trim($visit["task_ids"],"|");
								$tasks = explode("|",$tasks);
							?>
							
							<?foreach($tasks as $task){?>
								<?$task_name = get_query("select * from _new_tasks where task_id =".$task["task_id"]);?>
								<?$task_name = $task_name[0]?>
								<tr>
									<td><?=$task_name["task_name"]?></td>
									<?foreach($lifts as $lift){?>
										<td>
                                                                                        <?if (strstr($visit["lift_ids"],$lift['lift_id'])){?>
                                                                                                &#10004;      
                                                                                        <?}?>
                                                                                </td>
									<?}?>									
								</tr>
							<?}?>
							
							
                        </table>

                </td>
            </tr>
            <tr>
                <td>
                    <p><b>Service Technician</b></p>
                    <?=$visit["technician_name"]?>
                    <?if($visit["technician_signature"] != ''){?>
                        <img src="<?=$visit["technician_signature"]?>" width="200px">
                    <?}?>
                    
                </td>
                <td>
                    <p><b>Customer Signature</b></p>
                    &nbsp;
                    <?if($visit["customer_signature"] != ''){?>
                        <img src="<?=$visit["customer_signature"]?>" width="200px">
                    <?}?>
                    
                </td>                
            </tr>                
        </table>
    </div>
</body>

</html>
