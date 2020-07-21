<? js_init();?>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
<div id="topbar">
    <a href="#" id="printPdf">Print Page</a>
</div>
		<style>
		
			@media print
			{
				#topbar { display: none; }
			}			
			body{
				margin:0px;
				font-size:12px;
			}		
			*{
				font-family:arial;
				font-size:12px;
			}
			#border{
				border:1px solid black;
				width:320mm;
				height:182mm;
			}
			#maintable{
				border-collapse:collapse;
				border:1px solid black;
				border-left:0px;
				border-right:0px;
				width:100%;
			}
			h2{
				margin-left:20px;
			}
			#logo{
				float:right;
				margin-right:20px;
				margin-top:15px;
			}	
			#namebox{
				border-collapse:collapse;
				border:1px solid black;
				border-left:0px;
				width:125mm;
				line-height:7mm;
				
				border-bottom:0px;
			}
			#weekending{
				width:70mm;
				line-height:7mm;
				float:left;
				border-top:1px solid black;
				border-bottom:1px solid black;
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
			#authby{
				float:left;
				width:110mm;
				border:1px solid black;
				line-height:7mm;
			}
			#page{
				width:50mm;
				border:1px solid black;
				line-height:7mm;
				float:right;
				margin-left:20mm;
			}
		</style>
		<div id="border">
			<div id="logo">
				<img src="<?=app('app_url')?>/images/logo.png">
			</div>
			<br>
			<h2>TIME SHEETS</h2>

			<div id="namebox">
				&nbsp;NAME: <?=$tech[0]["technician_name"]?>
			</div>
			<div id="weekending">
				&nbsp;WEEK ENDING: <?=req('frm_end_date')?>
			</div>
			<div id="authby">
				&nbsp;AUTHORIZED BY: 
			</div>
			<div id="page">
				&nbsp;PAGE............OF............ 
			</div>	
			<p>&nbsp;</p>
			
			<table border="1" id="maintable">
			<thead>
				<tr>
					<th>Date</th>
					<th>Day</th>
					<th>Job No</th>
					<th>Job</th>
                    <th>Type</th>
					<th>Chargeable</th>
					<th>DocketNo</th>
					<th>Start Time</th>
					<th>Finish Time</th>
					<th>Time On Site</th>
					<th>NORM HRs</th>
					<th>O/T 1.5</th>
					<th>O/T 2</th>
					<th>O/T 2.5</th>
					<th>Site Allow</th>
					<th>FARES</th>
				</tr>
			</thead>
			<tbody>

			<?foreach($callouts as $callout){?>
				<tr>
					<td><?=toDate($callout["time_of_arrival"])?></td>
					<td><?=toDay($callout["time_of_arrival"])?></td>
					<td><?=$callout["job_number"]?></td>
					<td><?=$callout["job_name"]?></td>
                    <td>Callout</td>
					<td><?=$callout["chargeable_id"]?></td</td>
					<td><?=$callout["docket_number"]?></td>
					<td><?=toTime($callout["time_of_arrival"])?></td>
					<td><?=toTime($callout["time_of_departure"])?></td>
					<td><?=toDuration($callout["time_of_departure"] - $callout["time_of_arrival"])?></td>
					<td><?=toDuration($callout["time_of_departure"] - $callout["time_of_arrival"])?></td>
					<td>  </td>
					<td>  </td>
					<td>  </td>
					<td>  </td>
					<td>  </td>

				</tr>
			<?}?>
			<?foreach($maintenance as $callout){?>
				<tr>
					<td><?=toDate($callout["maintenance_date"])?></td>
					<td><?=toDay($callout["maintenance_date"])?></td>
					<td><?=$callout["job_number"]?></td>
					<td><?=$callout["job_name"]?></td>
                    <td>Maintenance</td>
					<td></td>
					<td><?=$callout["docket_no"]?></td>
					<td><?=toTime($callout["maintenance_toa"])?></td>
					<td><?=toTime($callout["maintenance_tod"])?></td>
					<td><?=toDuration($callout["maintenance_tod"] - $callout["maintenance_toa"])?></td>
					<td><?=toDuration($callout["maintenance_tod"] - $callout["maintenance_toa"])?></td>
					<td>  </td>
					<td>  </td>
					<td>  </td>
					<td>  </td>
					<td>  </td>
				</tr>
			<?}?>  
						</tbody>          
				<tr>
					<td colspan="5" style="text-align:right"><b>Totals</b></td>
					<td><?=toDuration($totalTime)?></td>
				</tr>
			</table>	
		</div>
		
		<script>
			$(document).ready(function(){
				$("#topbar").click(function(){
					window.print();
				})
				
			})
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
