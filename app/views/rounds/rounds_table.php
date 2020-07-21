<?
    /*
        Rounds Table, Show all rounds    
        Version: 14.2.24
        Cody Joyce
    */
?>
<img src="<?=app('app_url')?>/images/icons/network_local.png" class="main_icon">
<h1>Rounds</h1>
<p><a href="<?=app("url")?>/exec/rounds/form">Add New Round</a> | <a href="<?=app("url")?>/exec/rounds/map" target="_blank">View All Rounds Map</a></p>
<?pager()?>
<table id='sortTable' class='tablesorter' border='0'>
    <thead>
    <tr>
        <th>Name</th>
        <th>Colour</th>
        <th>Status</th>
        <th>Job Count</th>
        <th>Lifts</th>
        <th>Technicians</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <? while($row = mysqli_fetch_array($result)){?>
    <tr>
    <td><?=$row["round_name"]?></td>
    <td style="background-color:#<?=$row["round_colour"]?>!important;color:#fff;">&nbsp;</td>
    <td><?=$row["status_name"]?></td>
    <th><?=$row["job_count"]?></th>
    <td>
        <?=round_lift_count($row["round_id"])?>
    </td>
    <td>
        <?list_round_techs($row["round_id"])?>
    </td>    
     <td><a href="<?=app("url")?>/exec/rounds/form/?frm_round_id=<?=$row["round_id"]?>">Edit</a></td>
     <td><a href="<?=app("url")?>/exec/rounds/jobslist/?frm_round_id=<?=$row["round_id"]?>" target="_blank">Show Jobs</a></td>
     <td><a href="<?=app("url")?>/exec/rounds/map/?frm_round_id=<?=$row["round_id"]?>" target="_blank">Map</a></td>
    </tr>
    <? }?>
    </tbody>
</table>
