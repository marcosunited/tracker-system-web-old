<h1>Schedule</h1>

<p><a href="<?=app('url')?>/exec/schedule/form/?frm_job_id=<?=req('frm_job_id')?>" class="ajaxlink" target="schedule">Add New Visit</a></p>

<table id='sortTable' class='tablesorter' border='0'>
	<thead>
		<tr>
			<th>Lift</th>
			<th>Service Area</th>
			<th>Service Type</th>
			<th>Frequency</th>
			<th>Last completed</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? while($row = mysqli_fetch_array($result)){?>
			<tr>
				<td><?=liftNames($row["lift_id"])?></td>
				<td><?=$row["service_area_name"]?></td>
				<td><?=$row["service_type_name"]?></td>
				<td><?=$row["frequency_name"]?></td>
				<td><?=toDate($row["last_completed"])?></td>
				<td><a href="<?=app('url')?>/exec/schedule/form/?frm_schedule_id=<?=$row["schedule_id"]?>&frm_job_id=<?=req('frm_job_id')?>" class="ajaxlink" target="schedule">Edit</a></td>
				<td><a href="<?=app('url')?>/exec/schedule/delete/?frm_schedule_id=<?=$row["schedule_id"]?>&frm_job_id=<?=req('frm_job_id')?>" class="ajaxlinkconfirm" target="schedule" >Delete</a></td>
			</tr>
		<? }?>
	</tbody>
</table>
