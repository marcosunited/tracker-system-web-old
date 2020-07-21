<h1>Job Repairs</h1>
<table id='sortTable' class='tablesorter' border='0'>
    <thead>
        <th>Time</th>
        <th>Tech</th>
        <th>Lifts</th>
        <th></th>
    </thead>
    <tbody>
        <?while($row=mysqli_fetch_array($results)){?>
            <tr>
                <td><?=toDate($row["repair_time"])?></td>
                 <td><?=$row["technician_id"]?></td>         
                   <td><?=liftNames($row["lift_ids"])?></td>
                   <td>
                    <a href="<?=app('url')?>/exec/repairs/form/?frm_repair_id=<?=$row['repair_id']?>">View Repairs</a>
                   </td>
            </tr>
        <?}?>
    </tbody>
</table>