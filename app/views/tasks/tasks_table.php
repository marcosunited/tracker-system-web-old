<h1>Maintenance Tasks</h1>
<p><a href="<?=app('url')?>/exec/tasks/form/">Add new Task</a></p>
<?pager()?>
<table id='sortTable' class='tablesorter' border='0'>
    <thead>
        <tr>
			<th>Service Area</th>
			<th>Service Type</th>
            <th>Name</th>
        <th></th>
		<th></th>
		</tr>
    </thead>
    <tbody>
        <? while($row = mysqli_fetch_array($result)){?>
            <tr>
                <td><?=$row["task_name"]?></td>
				<td><?=$row["service_area_name"]?></td>
				<td><?=$row["service_type_name"]?></td>
                <td><a href="<?=app("url")?>/exec/tasks/form/?frm_task_id=<?=$row["task_id"]?>">Edit</a></td>
				<td><a href="<?=app("url")?>/exec/tasks/delete/?frm_task_id=<?=$row["task_id"]?>" class="confirm">Delete</a></td>
            </tr>
        <? }?>
    </tbody>
</table>
