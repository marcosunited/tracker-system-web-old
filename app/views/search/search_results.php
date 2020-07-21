<h1>Search Results</h1>
        <h3>Callout Docket Numbers Found:</h3>
        <table>
        <?while($row = mysqli_fetch_array($call_docket_numbers)){?>
                <a href="callouts/form/?frm_callout_id=<?=$row['callout_id']?>"><?=$row['docket_number']?></a>, 
        <?}?>
        </table>
        
        
        <h3>Maintenance Docket Numbers Found:</h3>
        <table>
        <?while($row = mysqli_fetch_array($maint_docket_numbers)){?>
                <a href="maintenance/form/?frm_maintenance_id=<?=$row['maintenance_id']?>"><?=$row['docket_no']?></a>, 
        <?}?>
        </table> 
        
        <h3>Lift Phone Numbers Found:</h3>
        <table>
        <?while($row = mysqli_fetch_array($phone_numbers)){?>
                <?=$row['lift_phone']?> - <a href="jobs/form/?frm_job_id=<?=$row['job_id']?>">Go to Job</a><br>
        <?}?>
        </table>         
        
        <h3>Job Addresses Found:</h3>
        <table>
        <?while($row = mysqli_fetch_array($address)){?>
                <a href="jobs/form/?frm_job_id=<?=$row['job_id']?>"><?=$row['job_address_number']?> <?=$row['job_address']?></a><br> 
        <?}?>
        </table>                  
        
        <h3>Job names Found:</h3>
        <table>
        <?while($row = mysqli_fetch_array($job_name)){?>
                <a href="jobs/form/?frm_job_id=<?=$row['job_id']?>"><?=$row['job_name']?></a><br> 
        <?}?>
        </table>            
