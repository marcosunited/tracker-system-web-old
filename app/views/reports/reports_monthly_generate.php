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
    
    <table width="100%" border="1" style="border-collapse:collapse" id="maintable">
        <thead>
            <th>Job #</th>
            <th>Name</th>
            <th>Address</th>
            <th>Frequency</th>
            <th>Last Serviced</th>
            <th>Round</th>
        </thead>
        <tbody>
            <?foreach($jobs as $job){?>
                <?$bgcolor=""?>
                <?$time_since_visit = time() - $job['last_serviced']?>
                <?$frequency_time = $job['frequency_value'] * 86400?>
                <?if($time_since_visit > $frequency_time){$bgcolor="red";}?>
                <tr style="background-color:<?=$bgcolor?>">
                <td><?=$job['job_number']?></td>
                <td><?=$job['job_name']?></td>
                <td><?=$job['job_address_number']?> <?=$job['job_address']?></td>
                <td><?=$job['frequency_name']?></td>
                <td><?=toDate($job['last_serviced'])?></td>
                <td style="background-color:#<?=$job['round_colour']?>"><?=$job['round_name']?></td>
                </tr>
            <?}?>
        <tbody>
    </table>
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
</div><!--end print area!-->

<form id="printForm" action="<?=app('url')?>/exec/reports/printReport/" method="post">
    <input type="hidden" name="frm_contents" id="frm_contents" value="">
    <input type="hidden" name="frm_filename" value="ULS-Jobs-List.pdf">
    <input type="hidden" name="print" value="1">
</form>

<script>
    $(document).ready(function(){        
        $("#printPdf").click(function(){
            $("#topbar").hide(function(){
                window.print();
            });
            
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
