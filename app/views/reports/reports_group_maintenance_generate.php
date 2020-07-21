<?js_init()?>

<div id="topbar">
    <a href="#" id="printPdf">Print As PDF</a>
</div>

<div id="printArea" contenteditable="true">
    <div id="logo">
        <img src="<?=app('app_url')?>/images/logobig.png" align="center" width="400">
    </div>

    <table width="100%" border="0">
        <tr>
            <td class="postal">A.C.N 082 447 658</td>
            <td class="postal">ABN 81 082 447 658</td>
            <td class="postal">
                <div style="">
                Postal Address:<br>
                P.O.Box 280<br>
                KEW VIC 3101<br>
                Telephone: 9687 9099<br>
                Facsimile: 9687 9094
                </div>
            </td>
        </tr>
    </table>

    <h1>Group Report: <?=$group_name?></h1>
         
     <h1>Maintenance</h1>
    <table width="100%" border="1" style="border-collapse:collapse">
    <thead>
        <tr>
            <th>Date</th>
            <th>Job Address</th>
            <th>Lifts</th>
            <th>Technician</th>
            <th>Task Completed</th>
			<th>Tech Notes</th>


        </tr>
    </thead>
	<tbody>
		<?foreach ($maintenance as $row){?>
			<tr>
			<td><?=toDate($row["maintenance_date"])?></td>
			
			
            <td><?=$row["job_address_number"]?> <?=$row["job_address"]?>, <?=$row["job_suburb"]?></td>
			<td><?=liftNames($row["lift_ids"])?></td>
            <td><?=$row["technician_name"]?></td>
			<td><?=taskNames($row["task_ids"])?></td>
            <td><?=$row["maintenance_notes"]?></td>
			</tr>
		<? }?>
	</tbody>
</table>

        
        <div style="text-align:center;padding-top:20px;">
            <b>Printed:</b> <?=toDateTime(time())?>
        </div>
        
        <style>   
                body{
                    margin:0px;
                    font-size:12px;
                }
                td{
                    font-size:12px;
                    text-align:center;
                }
                th{
                    font-weight:bold;
                    font-size:12px;
                }
                *{
                    font-family:sans-serif;

                }
                #topbar, #topbar a{
                    background-color:blue;
                    color:#fff;
                    padding:5px;
                    
                    background: #7abcff; /* Old browsers */
                    background: -moz-linear-gradient(top,  #7abcff 0%, #60abf8 44%, #4096ee 100%); /* FF3.6+ */
                    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#7abcff), color-stop(44%,#60abf8), color-stop(100%,#4096ee)); /* Chrome,Safari4+ */
                    background: -webkit-linear-gradient(top,  #7abcff 0%,#60abf8 44%,#4096ee 100%); /* Chrome10+,Safari5.1+ */
                    background: -o-linear-gradient(top,  #7abcff 0%,#60abf8 44%,#4096ee 100%); /* Opera 11.10+ */
                    background: -ms-linear-gradient(top,  #7abcff 0%,#60abf8 44%,#4096ee 100%); /* IE10+ */
                    background: linear-gradient(to bottom,  #7abcff 0%,#60abf8 44%,#4096ee 100%); /* W3C */
                    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7abcff', endColorstr='#4096ee',GradientType=0 ); /* IE6-9 */
                                
                }
                #logo{
                    text-align:center;
                    padding:10px;
                    
                }
                #disclaimer{
                    padding-top:10px;
                }
                #dear{
                    padding-bottom:10px;
                }        
                .postal{
                    font-weight:bold;
                    text-align:center;
                    vertical-align:top;
                }
                .address{
                    width:200px;
                    text-align:left;
                }
                h1{
                    text-align:center;
                    font-size:28px;
                }
                #disclaimer{
                    margin:10px 0px 10px 0px;
                }
                a{
                    color:#000;
                    text-decoration:none
                }
            </style>
</div><!--End Print Area!-->    


    <form id="printForm" action="<?=app('url')?>/exec/reports/printReport/" method="post">
        <input type="hidden" name="frm_contents" id="frm_contents" value="">
        <input type="hidden" name="frm_filename" value="Group Report-<?=req("frm_group_name").".pdf"?>">
        <input type="hidden" name="print" value="1">
    </form>

    <script>
        $(document).ready(function(){
            $("#printPdf").click(function(){
                $myVar = $("#printArea").html();
                $("#frm_contents").val($myVar);
                $("#printForm").submit();
            });
        });
    </script>
