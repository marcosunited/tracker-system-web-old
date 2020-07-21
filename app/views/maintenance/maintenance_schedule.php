<h1>Maintenance Schedule</h1>


<table class='tablesorter'>
	<thead>
		<th>Date</th>
		<th>Technician id</th>
		<th>Job</th>
		<th>Lift Names</th>
		<th>Areas Serviced</th>
		<th>Service Type</th>
		<th></th>
	</thead>
	<tbody>
	<?foreach($calls as $call){
		if($call['lift_ids'] == "" || $call['lift_ids'] == null ) continue;		
		?>
		<tr>
			<td><?=toDate($call['maintenance_date'])?></td>
			<td><?=$call['technician_name']?></td>
			<td><?=$call['job_name']?></td>
			<td><?=liftNames($call['lift_ids'])?></td>
			<td><?=areaNames($call["service_area_ids"])?></td>
			<td><?=TypeNames($call["service_type_ids"])?></td>
			<td>
                <a href="<?=app('url')?>/exec/maintenance/form/?frm_maintenance_id=<?=$call['maintenance_id']?>">Edit</a> | 
                <a href="<?=app('url')?>/exec/maintenance/delete/?frm_maintenance_id=<?=$call["maintenance_id"]?>" class="confirm">Delete</a>
            </td>
            
		</tr>
	<?}?>		
	</tbody>
</table>
