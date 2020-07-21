    <img src="<?=app('app_url')?>/images/icons/stock_cell-phone.png" class="main_icon">
    <h1>Past / Closed Callouts</h1>
    <p>
        <a href="<?=app('url')?>/exec/callouts/form/">Create a new callout</a> | 
        <a href="<?=app('url')?>/exec/callouts/">Show Active Callouts</a>
    </p>
    <?pager()?>
    <table id='sortTable' class='tablesorter' border='0'>
        <thead>
            <tr>
                <th width="80px">Time</th>
                <th width="200px">Job Name</th>
				<th width="80px">Callout Id</th>
                <th>Address</th>
                <th width="150px">Reported Fault</th>
                <th width="50px">Lifts</th>
                <th width="100px">Technician</th>
                <th width="40px">Priority</th>
                <th width="40px">Status</th>
                <th width="100px"></th>
            </tr>
        </thead>
        <tbody>
            <? while($row = mysqli_fetch_array($results)){?>
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
                    <td <?=$bg?> ><?=$row["fault_name"]?></td>
                    <td <?=$bg?> ><?=liftNames($row["lift_ids"])?></td>
                    <td <?=$bg?> ><?=$row["technician_name"]?></td>
                    <td <?=$bg?> ><?=$row["priority_name"]?></td>
                    <td <?=$bg?> ><?=$row["callout_status_name"]?></td>
                    <td>

                        <a href="<?=app('url')?>/exec/callouts/form/?frm_callout_id=<?=$row['callout_id']?>">Edit</a> | 
                        <a href="<?=app('url')?>/exec/callouts/printPdf/?frm_callout_id=<?=$row['callout_id']?>" target="_blank">Print</a> | 
                        <a href="<?=app('url')?>/exec/callouts/delete/?frm_callout_id=<?=$row['callout_id']?>" class="confirm">Delete</a>
                    </td>
                </tr>
            <? }?>
        </tbody>
    </table>


