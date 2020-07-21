<?
    /*
        Lifts Table
        Version: 14.2.24
        Cody Joyce
    */
?>
<h1>Job Lifts</h1>
<p><a href="<?=app("url")?>/exec/lifts/form/?frm_job_id=<?=req('frm_job_id')?>" class="ajaxlink" target="lifts">Add Lift</a></p>

<table id='sortTable' class='tablesorter' border='0'>
<thead>
<tr>
    <th>Status</th>
    <th>Name</th>
    <th>Phone</th>
    
    <th></th>
    <th></th>
</tr>
</thead>
    <tbody>
    
    <? while($row = mysqli_fetch_array($result)){?>
        <tr>
        <td><?=$row["status_name"]?></td>
        <td><?=$row["lift_name"]?></td>
        <td><?=$row["lift_phone"]?></td>
        
        <td><a href="<?=app('url')?>/exec/lifts/form/?frm_lift_id=<?=$row["lift_id"]?>" class="ajaxlink" target="lifts">Edit</a></td>
        <td><a href="<?=app('url')?>/exec/lifts/delete/?frm_job_id=<?=$row["job_id"]?>&frm_lift_id=<?=$row["lift_id"]?>" class="ajaxlinkconfirm" target="lifts">Delete</a></td>
        </tr>
    <? }?>
    </tbody>
</table>


