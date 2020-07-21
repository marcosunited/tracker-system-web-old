<style>
        *{
                font-family:sans-serif;
        }
</style>
<h1>Agents Report</h1>
Agent: <?=$agent["agent_name"]?>
<p></p>

<table border="1" style="border-collapse:collapse">
        <tr>
                <th>Job Name</th>
                <th>Address</th>
                <th>Lift Count</th>
				<th>Status</th>
        </tr>
        <tbody>
        <?$lift_count = 0?>
<?foreach($jobs as $job){?>
        <tr>
                <td><?=$job["job_name"]?></td>
                <td><?=$job["job_address_number"]?> <?=$job["job_address"]?> <?=$job["job_suburb"]?></td>
                <td style="text-align:center"><?=$job["lift_count"]?></td>
				<td><?=$job["status_name"]?></td>
        </tr>
        <?$lift_count = $lift_count + $job["lift_count"]?>
<?}?>
        <tr>
                <td></td>
                <td style="text-align:right"><b>Total Units</b></td>
                <td style="text-align:center"><?=$lift_count?></td>
        </tr>
        </tbody>
</table>