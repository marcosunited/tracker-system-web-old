<? while($row = mysqli_fetch_array($openresults)){?>
        <?
            $bg="";
            if($row["callout_status_id"]==1)
            {
                $bg="style=\"background-color:#fff9b3!important\" ";
            }
        ?>
    <tr>
        <td <?=$bg?> ><?=date("d-m-Y G:i",$row["callout_time"])?></td>

        <td <?=$bg?> ><?=$row["job_name"]?></td>
		<td <?=$bg?> ><?=$row["callout_id"]?></td>
        <td <?=$bg?> ><?=$row["job_address_number"]?> <?=$row["job_address"]?>, <?=$row["job_suburb"]?></td>
        <td <?=$bg?> class="liveField" lookup="callouts_view,<?=$row["callout_id"]?>,fault_name"><?=$row["fault_name"]?></td>
        <td <?=$bg?> ><?=liftNames($row["lift_ids"])?></td>
        <td <?=$bg?> class="liveField" lookup="callouts_view,<?=$row["callout_id"]?>,technician_name">
            <?=$row["technician_name"]?> 
        </td>
        <td <?=$bg?>><?=$row["priority_name"]?></td>
        <td <?=$bg?> ><?=$row["callout_status_name"]?></td>
        <td>
<?
	if(is_mobile()==true){
			$mobile="font-size:20px";
	}
?>            
			<a href="<?=app('url')?>/exec/callouts/form/?frm_callout_id=<?=$row['callout_id']?>" style="<?=$mobile?>">Edit</a> | 
            <!--a href="<?=app('url')?>/exec/callouts/printPdf/?frm_callout_id=<?=$row['callout_id']?>" target="_blank">Print</a!--> 
            <a href="<?=app('url')?>/exec/callouts/delete/?frm_callout_id=<?=$row['callout_id']?>" style="<?=$mobile?>" class="confirm">Delete</a>
        </td>
    </tr>
	<?$mobile="";?>
<? }?>