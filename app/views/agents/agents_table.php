<?
    /*
        Agents Table
        Version: 14.2.24
        Cody Joyce
    */
?>

<h1>Agents</h1>

<p><a href="<?=app('url')?>/exec/agents/form/">Add New Agent</a></a>

<?pager()?>

<table id='sortTable' class='tablesorter' border='0' >
    <thead>
        <tr>
            <th>Agent Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Fax</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <? foreach($agents as $agent){?>
        <tr>
            <td><?=$agent["agent_name"]?></td>
            <td><?=$agent["agent_address"]?></td>
            <td><?=$agent["agent_phone"]?></td>
            <td><?=$agent["agent_fax"]?></td>
            <td><a href="<?=app("url")?>/exec/agents/form?frm_agent_id=<?=$agent["agent_id"]?>">Edit</a></td>
            <td><a href="<?=app("url")?>/exec/agents/report?frm_agent_id=<?=$agent["agent_id"]?>" target="_blank">Report</a></td>
        </tr>
    <? }?>
    </tbody>
</table>
