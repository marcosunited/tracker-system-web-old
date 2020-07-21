<? while($row = mysqli_fetch_array($repairs)){?>
    <?
                    $bg="";
                    if($row["repair_status_id"]==1)
                    {
                        $bg="style=\"background-color:#fff9b3!important\" ";
                    }
                ?>
    <tr>
        <td><?=date("d-m-Y G:i",$row["repair_time"])?></td>
        <td><?=$row["job_name"]?></td>
        <td><?=$row["repair_id"]?></td>
        <td><?=liftNames($row["lift_ids"])?></td>
        <td><?=$row["technician_name"]?></td>
        <td><?=$row["quote_no"]?></td>
        <td>
            <a href="<?=app('url')?>/exec/repairs/form/?frm_repair_id=<?=$row['repair_id']?>">Edit</a> | 
            <a href="<?=app('url')?>/exec/repairs/printPdf/?frm_repair_id=<?=$row['repair_id']?>" target="_blank">Print</a> | 
            <a href="<?=app('url')?>/exec/repairs/delete/?frm_repair_id=<?=$row['repair_id']?>" class="confirm">Delete</a>
        </td>
    </tr>
<? }?>

