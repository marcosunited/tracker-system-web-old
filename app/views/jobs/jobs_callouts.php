<h1>Job Callouts</h1>
<table id='sortTable' class='tablesorter' border='0'>
    <thead>
        <th>Time</th>
        <th>Tech</th>
        <th>Fault</th>
        <th>Lifts</th>
        <th></th>
    </thead>
    <tbody>
        <?while($row=mysqli_fetch_array($results)){?>
            <tr>
                <td><?=toDateTime($row["callout_time"])?></td>
                 <td><?=$row["technician_name"]?></td>
                  <td><?=$row["fault_name"]?></td>
                   <td><?=liftNames($row["lift_ids"])?></td>
                   <td>
                    <a href="<?=app('url')?>/exec/callouts/form/?frm_callout_id=<?=$row['callout_id']?>">View Callout</a>
                   </td>
            </tr>
        <?}?>
    </tbody>
</table>