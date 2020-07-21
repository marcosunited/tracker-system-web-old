<h1>Maintenance Visits</h1>
<table id='maintenance' class='tablesorter' border='0'>
    <thead>
        <th>Date</th>
        <th>Tech</th>
        <th>Lifts</th>
        <th></th>
    </thead>
    <tbody>
        <?while($row=mysqli_fetch_array($results)){?>
            <tr>
                <td><?=toDate($row["maintenance_date"])?></td>
                 <td><?=$row["technician_name"]?></td>
                   <td><?=liftNames($row["lift_ids"])?></td>
                   <td>
                    <a href="<?=app('url')?>/exec/maintenance/form/?frm_maintenance_id=<?=$row['maintenance_id']?>">View Visit</a>
                   </td>
            </tr>
        <?}?>
    </tbody>
</table>