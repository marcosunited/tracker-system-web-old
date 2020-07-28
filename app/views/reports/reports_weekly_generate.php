<?js_init()?>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.24/build/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/1.10.13/sorting/date-dd-MMM-yyyy.js"></script>

<div id="topbar">
    <a href="#" id="printPdf">Print As PDF </a>
</div>

<div id="printArea" contenteditable="true">
    <div id="logo">
        <img src="<?=app('app_url')?>/images/logobig.png" align="center" width="400">
    </div>

    <h1>Weekly Callout Report: </h1>
    
    <table width="100%" border="1" style="border-collapse:collapse" cellpadding="0" cellspacing="0" id="maintable">
    <thead>
        <tr>
            <td align="center"><strong>Job No</strong></td>
			<td align="center"><strong>Job Name</strong></td>
            <td align="center"><strong>Callout Description</strong></td>
            <td align="center"><strong>Date Of Call</strong></td>
            <td align="center"><strong>Time Of Call</strong></td>
            <td align="center"><strong>Docket No</strong></td>
			<td align="center"><strong>Status</strong></td>
			<td align="center"><strong>Callout Id</strong></td>
            <td align="center"><strong>Chargeable</strong></td>
            <td align="center"><strong>Verify</strong></td>
        </tr>
        </thead>
        <tbody>
        <?while($row=mysqli_fetch_array($callouts)){?>
        <tr>
			<td><?=$row['job_number']?></td>
            <td><?=$row['job_name']?></td>
            <td id="<?=$row['callout_id']?>" class="classID"><?=$row['callout_id']?></td>
            <td><?=$row['callout_description']?></td>
            <td><?=toDate($row["callout_time"])?></td>
            <td><?=toTime($row["callout_time"])?></td>
            <td><?=$row['docket_number']?></td>
			<td><?=$row['callout_status_name']?></td>
			<td><?=$row['chargeable_name']?></td>
            <td><?=$row['verify']?></td>
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
        .classID{
            text-decoration: underline;
            color: blue;
            cursor: pointer;
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
                    dom: 'Bfrtip',
                    buttons: [
                    'copy', 'excel', 
                         ],
					columnDefs: [
                    { type: 'date-dd-mmm-yyyy', targets: 3 }
                    ],

					
				} );
			} );
		</script>
<script>
    $(".classID").on('click',function() {   
    var id = $(this).attr('id');
    window.open("<?=app('url')?>/exec/callouts/form/?frm_callout_id=" + id);       
}); 
</script>