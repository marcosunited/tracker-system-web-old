<?
    /*
        Rounds Job List - Show all jobs in a round
        Version: 14.2.24
        Cody Joyce
    */
?>
<?ob_start();?>

<style>
    *{
        font-family:sans-serif;
    }
    td{
        font-size:12px;
    }
</style>

<img src="<?=app("app_url")?>/images/logo.png">

<h1>Round Details: <?=$technician["round_name"]?></h1>

<p>
    <b>Technician: </b><?=$technician["technician_name"]?><br>
    <b>Total Lifts: </b><?=round_lift_count($technician["round_id"])?><br>

    <div style="width:50px;height:50px;background-color:#<?=$round["round_colour"]?>"></div>
</p>

<table width="100%" border="1" style="border-collapse:collapse">
    <tr>
        <td><b>Job No</b></td>
        <td><b>Name</b></td>
        <td><b>Address</b></td>
        <td><b>Frequency</b></td>
        <td><b>Last Visit</b></td>
        <td><b>Lifts</b></td>
        <td><b>Wk 1</b></td>
        <td><b>Wk 2</b></td>
        <td><b>Wk 3</b></td>
        <td><b>Wk 4</b></td>
    </tr>

    <?while($row = mysqli_fetch_array($result)){?>
         <tr>
         <td><?=$row["job_number"]?></td>
         <td><?=$row["job_name"]?></td>
         <td><?=$row["job_address_number"]?> <?=$row["job_address"]?></td>
         <td><?=$row["frequency_name"]?></td>
         <td><?=toDate(lastVisit($row["job_id"]))?></td>
         <td><?=job_lift_count($row["job_id"])?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>     
         </tr>
    <?}?>
</table>

<?
	$contents = ob_get_contents();
	ob_end_clean();
    
	require_once(app('lib_path')."/functions/dompdf/dompdf_config.inc.php");
	$dompdf = new DOMPDF();
	$dompdf->load_html($contents);
	$dompdf->render();
	$dompdf->stream($technician["technician_name"].".pdf"); 
?>