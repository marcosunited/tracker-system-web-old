<?
    /*
        Technicians Table - Show Techs
        Version: 14.2.24
        Cody Joyce
    */
?>

<img src="<?=app('app_url')?>/images/icons/config-users.png" class="main_icon">

<h1>Technicians</h1>

<p><a href="<?=app('url')?>/exec/technicians/form/">Add New Technician</a></p>

<?pager()?>
<table id='sortTable' class='tablesorter' border='0'>
    <thead>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Round</th>
            <th>Status</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <? while($row = mysqli_fetch_array($result)){?>
            <tr>
                <td><?=$row["technician_name"]?></td>
                <td><?=$row["technician_phone"]?></td>
                <td><?=$row["technician_email"]?></td>
                <td style="background-color:#<?=$row["round_colour"]?>!important;color:#fff;"><?=$row["round_name"]?></td>
                <td><?=$row["status_name"]?></td>
                <td><a href="<?=app("url")?>/exec/technicians/form/?frm_technician_id=<?=$row["technician_id"]?>">Edit</a></td>
                <td><a href="<?=app("url")?>/exec/schedules/table/?frm_technician_id=<?=$row["technician_id"]?>">Schedule</a></td>
            </tr>
        <? }?>
    </tbody>
</table>
