<?
    /*
        Jobs Table
        Version: 14.2.24
        Cody Joyce
    */
?>
<img src="<?=app('app_url')?>/images/icons/web-google-play-books.png" class="main_icon">

<h1>Jobs</h1>

<p>
    <a href="<?=app("url")?>/exec/jobs/form/">Add Job</a> | 
    <a href="<?=app("url")?>/exec/jobs/printJobs/">Print All Jobs</a>
	<a href="<?=app("url")?>/exec/jobs/printAccess/">Print Access</a>
</p>

<?pager()?>
<table id='sortTable' class='tablesorter' border='0'>
    <thead>
        <tr>
            <th width="50">Job No</th>
			<th width="50">Contract status</th>
            <th width="50">Lifts</th>
            <th width="300">Job Name</th>
            <th width="50">Number</th>
            <th width="300">Address</th>
            <th width="150">Suburb</th>
            <th width="100">Group</th>
            <th width="100">Round</th>        
            <th width="30"></th>
            
        </tr>
    </thead>
    <tbody>
        <? while($row = mysqli_fetch_array($result)){?>
            <tr>
                <td><?=$row["job_number"]?></td>
				<td style="text-align:center"><img style="width:20px" src="../app/images/icons/<?=$row["contract_icon"]?>" /></td>
                <td><?=$row["lift_count"]?></td>  
                <td><?=$row["job_name"]?></td>
                <td><?=$row["job_address_number"]?> </td>
                <td><?=$row["job_address"]?></td>
                <td><?=$row["job_suburb"]?></td>  
                <td><?=$row["job_group"]?></td>
                <td style="background-color:#<?=$row["round_colour"]?>;color:#fff;"><?=$row["round_name"]?></td>                
                <td><a href="<?=app('url')?>/exec/jobs/form/?frm_job_id=<?=$row["job_id"]?>">Edit</a></td>
                
            </tr>
        <? }?>
    </tbody>
</table>


