
<? while($row = mysqli_fetch_array($followups)){?>
    <?
        $bgcolor="";
        if($row["callout_status_id"]==3)
        {
            $bgcolor="style=\"background-color:red\" ";
        }
    ?>
    <tr>
        <td><?=date("d-m-Y G:i",$row["callout_time"])?></td>
        <td><?=$row["job_name"]?></td>
        <td><?=liftNames($row["lift_ids"])?></td>
        <td <?=$bgcolor?>><?=$row["technician_name"]?></td>
        <td>
            <a href="<?=app('url')?>/exec/callouts/form/?frm_callout_id=<?=$row['callout_id']?>">Edit</a> | 
            <a href="<?=app('url')?>/exec/callouts/printPdf/?frm_callout_id=<?=$row['callout_id']?>" target="_blank">Print</a> | 
            <a href="<?=app('url')?>/exec/callouts/delete/?frm_callout_id=<?=$row['callout_id']?>" class="confirm">Delete</a>
        </td>
    </tr>
<? }?>
