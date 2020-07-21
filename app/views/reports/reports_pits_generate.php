<?js_init()?>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/1.10.13/sorting/date-dd-MMM-yyyy.js"></script>

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

    <h1>Pit Clean Report: </h1>



    <div id="disclaimer">
        This document is confidential. It is intended exclusively for the use of the addressee. 
        Any form of disclosure is unauthorised. Please advise the sender
        if you recieve this in error. Your reasonable cost in advising us of the error will be reimbursed.
    </div>

    <div id="dear">
        Dear Customer,
        <p>Please find detailed below a list of the calls and routine maintenance we attended between <b><?=date("d/M/Y",$start_date)?></b> and <b><?=date("d/M/Y",$end_date)?></b>.</p>
    </div>
    
    <table width="100%" border="1" style="border-collapse:collapse" cellpadding="0" cellspacing="0" id="maintable">
    <thead>
        <tr>
			<td align="center"><strong>Job Name</strong></td>
            <td align="center" width="200px"><strong>Date</strong></td>
            <td align="center" width="150px"><strong>Lifts</strong></td>
            <td align="center" width="200px"><strong>Service Area</strong></td>
            <td align="center"><strong>Service Type</strong></td>
            <td align="center"><strong>Notes</strong></td>
            <td align="center" width="100px"><strong>Technician</strong></td>
        </tr>
        </thead>
        <tbody>
        <?while($row=mysqli_fetch_array($callouts)){?>
        <tr>
			<td><?=$row['job_address_number']?> <?=$row['job_address']?> <?=$row['job_suburb']?></td>
            <td align="center">
                <?=date("d-M-y",$row["maintenance_date"])?>
            </td>
            <td align="center"><?=liftNames($row["lift_ids"])?></td>
            <td align="center">
                    <?=areaNames($row["service_area_ids"])?>
            </td>
            <td align=""><div style="margin-left:5px;margin-right:5px"><?=typeNames($row["service_type_ids"])?></div></td>
            <td align=""><div style="margin-left:5px;margin-right:5px"><?=$row["maintenance_notes"]?></div></td>
            <td align="center" width="15%"> <?=$row["technician_name"]?></td>
        </tr>
        <?}?>
        </tbody>
    </table>

    <style>   
        body{
            margin:0px;
            font-size:12px;
        }
        td{
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
    <input type="hidden" name="frm_filename" value="Site Report-<?=$job["job_name"].".pdf"?>">
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
		<script>
			$(document).ready(function() {
				$('#maintable').DataTable( {
					"order": [[ 0, "asc" ]],
					paging: false,
					searching: false,
					columnDefs: [
       { type: 'date-dd-mmm-yyyy', targets: 1 }
     ]
					
				} );
			} );
		</script>
