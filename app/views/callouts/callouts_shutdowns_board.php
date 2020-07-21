<table width="100%" border="1" style="border-collapse:collapse">
<tr>
        <th>Lift Shut Down On</td>
        <th>Job Name</td>
        <th>Lift Numbers</td>
        <th>Technician</td>
        <th>
                Time Off
        </th>
</tr>
<? while($row = mysqli_fetch_array($shutdowns)){?>
    <?
        $bgcolor="";
        if($row["callout_status_id"]==3)
        {
            $bgcolor="style=\"background-color:red\" ";
        }
    ?>
    <tr>
        <td><?=date("d F Y, G:i",$row["callout_time"])?></td>
        <td><?=$row["job_name"]?></td>
        <td><?=liftNames($row["lift_ids"])?></td>
        <td ><?=$row["technician_name"]?></td>
        <td>
                <?$myTime = time()-$row['time_of_departure']?>
                <?=toDuration2($myTime)?>  
        </td>
    </tr>
<? }?>
</table>
