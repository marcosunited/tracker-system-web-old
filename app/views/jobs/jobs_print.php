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
    <a href="#" id="printPdf">Print As PDF</a>
</div>

<div id="printArea" contenteditable="true">
    <h1>Jobs</h1>
    <p>This list was generated on <?=toDateTime(time())?></p>
    <table border='1' width="100%" style="border:1px solid;border-collapse:collapse" id="maintable">
        <thead>
            <tr>
                <th width="50">Job No</th>
                <th width="20" >Number</th>
                <th width="300">Address</th>
                <th width="100">Round</th>
                <th width="50">Lifts</th>
                <th width="100"></th>
				<th width="100">Start Date</th>
				<th width="100">Finish Date</th>
				<th width="100">Price</th>
				
            </tr>
        </thead>
        <tbody>
            <?$bg = "bgcolor='#eee'";?>
            <?$i=0;?>
            <? while($row = mysqli_fetch_array($result)){?>
                <?
                    if($row["status_id"]==2)
                    $bg = "bgcolor='#c6c6c6'";
                ?>
                <tr <?=$bg?>>
                    <td><?=$row["job_number"]?></td>
                    <td align="right"><?=$row["job_address_number"]?>&nbsp;</td>
                    <td><?=$row["job_address"]?>, <?=$row["job_suburb"]?></td>
                    <td style="background-color:#<?=$row["round_colour"]?>;color:#fff;"><?=$row["round_name"]?></td>
                    <td align="center"><?=$row["lift_count"]?></td>  
                    <td><?=$row["status_name"]?></td>
					<td><?=toDate($row["start_time"])?></td>
					<td><?=toDate($row["finish_time"])?></td>
					<td><?=$row["price"]?></td>
                </tr>
                <?
                    if($i==1){
                        $i=0;
                        $bg = "bgcolor='#eee'";
                    }else{
                        $i++;
                        $bg = "bgcolor='#fff'";
                    }
                ?>
            <? }?>
        </tbody>
    </table>
    <style>
        *{
            font-family:arial;
            margin:0px;
            
        }
        td,th{
            font-size:11px;
        }
        p{
        font-size:11px;
        }
        #topbar, #topbar a{
            background-color:blue;
            color:#fff;
            padding:5px;
            font-size:12px;
            background: #7abcff; /* Old browsers */
            background: -moz-linear-gradient(top,  #7abcff 0%, #60abf8 44%, #4096ee 100%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#7abcff), color-stop(44%,#60abf8), color-stop(100%,#4096ee)); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top,  #7abcff 0%,#60abf8 44%,#4096ee 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top,  #7abcff 0%,#60abf8 44%,#4096ee 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(top,  #7abcff 0%,#60abf8 44%,#4096ee 100%); /* IE10+ */
            background: linear-gradient(to bottom,  #7abcff 0%,#60abf8 44%,#4096ee 100%); /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7abcff', endColorstr='#4096ee',GradientType=0 ); /* IE6-9 */
                        
        }    
    </style>    
</div>

<form id="printForm" action="<?=app('url')?>/exec/reports/printReport/" method="post">
    <input type="hidden" name="frm_contents" id="frm_contents" value="">
    <input type="hidden" name="frm_filename" value="ULS-Jobs-List.pdf">
    <input type="hidden" name="print" value="1">
</form>

<script>
    $(document).ready(function(){
        /*$("#printPdf").click(function(){
            $myVar = $("#printArea").html();
            $("#frm_contents").val($myVar);
            $("#printForm").submit();
        });*/
        
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