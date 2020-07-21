    <h1><?=$job['job_name']?></h1>
    
    <button id="submit1" value="submit" data-theme="b">New Callout</button>
    <button id="submit2" value="submit" data-theme="e">New Maintenance Visit</button>
    <button id="submit3" value="submit" data-theme="a">Save Notes / Photo</button>
    

    <p><?=$job['job_address_number']?> <?=$job['job_address']?> <?=$job['job_suburb']?></p>
    <p><b>Agent: </b><br><?=$job['job_agent_contact']?></p>
    <p><b>Site Contact: </b><br><?=$job['job_contact_details']?></p>
    <p><b>Visit Frequency:</b><?=$job["frequency_name"]?></p>
    <p><b>Key Access:</b><?=$job["job_key_access"]?></p>
    <p><b>Location Map:</b><br>

    <?mapperMobile($job["job_latitude"],$job["job_longitude"],$job["job_name"]);?></p>
    <script>
        $(document).ready(function(){
            setInterval("reloadCalls()",5000);
            $("#submit1").click(function(){
                $(location).attr('href',"<?=app('url')?>/exec/tech_callouts/newCall/?frm_job_id=<?=$job['job_id']?>&job_name=<?=$job['job_name']?>");
            });
            $("#submit2").click(function(){
                $(location).attr('href',"<?=app('url')?>/exec/tech_maintenance/newCall/?frm_job_id=<?=$job['job_id']?>&job_name=<?=$job['job_name']?>");
            });
            $("#submit3").click(function(){
                $(location).attr('href',"mailto:system@unitedlifts.com.au?subject=<?=$job['job_number']?>||Tech Note");
            });                 
        });
    </script>

        


        