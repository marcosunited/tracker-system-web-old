<?js_init()?>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/1.10.13/sorting/date-dd-MMM-yyyy.js"></script>
<div id="topbar">
    <a href="#" id="printPdf">Print As PDF</a>
</div>

    <div id="printArea" contenteditable="true">
        <div style="text-align:center;"><img src="<?=app('app_url')?>/images/logobig.png" width="400"></div>
        <h1>Lift Ranking</h1>
        From: <?=toDate($start_date)?><br>
        To: <?=toDate($end_date)?><br>
        <table width="100%" border="1" style="border-collapse:collapse" id="maintable">
        <thead>
            <tr>
                <th>Lift Name</th>
                <th>Job Name</th>
                <th>Calls</th>
            </tr>
            </thead>
            <tbody>
            <?while ($lift = mysqli_fetch_array($liftcalls)){?>
                <tr>
                    <td><?=liftNames($lift['lift_id'])?></td>
                    <td><?=$lift['job_name']?></td>
                    <td><?=$lift['call_count']?></td>
                </tr>
            <?}?>
            </tbody>
        </table>
        <style>   
            body{
                margin:0px;
                font-size:12px;
            }
            #table{
                width:100%;
                border-collapse:collapse;
            }
            td{
                font-size:12px;
                text-align:center;
            }
            th{
                font-weight:bold;
                font-size:12px;
                padding:5px;
                text-align:center;
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
            h1{
                text-align:center;
                font-size:28px;
            }

            a{
                color:#000;
                text-decoration:none
            }
        </style>
    </div>
    <form id="printForm" action="<?=app('url')?>/exec/reports/printReport/" method="post">
        <input type="hidden" name="frm_contents" id="frm_contents" value="">
        <input type="hidden" name="frm_filename" value="Lift Report-<?=date("d-m-y").".pdf"?>">
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
					
				} );
			} );
		</script>