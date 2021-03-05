<h1>Communications</h1>

<p><a href="<?= app('url') ?>/exec/communications/form/?frm_job_id=<?= $job_id ?>" class="ajaxlink" target="communications">Add New Communication</a></p>
<?pager('communicationsPager')?>
<table id='sortTable' class='tablesorter' border='0' data-pager="communicationsPager">
    <thead>
        <tr>
            <th>User</th>
            <th>Time</th>
            <th>Subject</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <? while($row = mysqli_fetch_array($result)){?>
        <tr>
            <td><?= $row["username"] ?></td>
            <td><?= toDateTime($row["communication_time"]) ?></td>
            <td><?= $row["communication_subject"] ?></td>
            <td><a href="<?= app('url') ?>/exec/communications/form/?frm_communication_id=<?= $row["communication_id"] ?>" class="ajaxlink" target="communications">Edit</a></td>
            <td><a href="<?= app('url') ?>/exec/communications/delete/?frm_communication_id=<?= $row["communication_id"] ?>&frm_job_id=<?= $row["job_id"] ?>" class="ajaxlinkconfirm" target="communications">Delete</a></td>
        </tr>
        <? }?>
    </tbody>
</table>