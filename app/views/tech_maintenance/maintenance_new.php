    <script src="<?=app('app_url')?>/scripts/jSignature/jSignature.min.js"></script>
    
    <ul data-role="listview" data-theme="c">
        <li data-role="list-divider">
            New Maintenance Visit
        </li>
    </ul>
    
    <hr>
    
    <form name="maintenanceForm" id="maintenanceForm" action="<?=app('url')?>/exec/tech_maintenance/action/" method="post" data-ajax="false">
        
        <input  type="hidden" name="frm_job_id" id="frm_job_id" value="<?=$job[0]["job_id"]?>">
        <input  type="hidden" name="frm_completed_id" id="frm_completed_id" value="2">
        <input type="hidden" name="frm_customer_signature" id="frm_customer_signature">
        
        
        <div id="job" data-role="fieldcontain">
            <label for="frm_job_id">Job:</label> <?=$job[0]["job_name"]?>
        </div>
        
        <div id="toa" data-role="fieldcontain">
            <label for="frm_maintenance_toa">Time Of Arrival:</label>
            <input type="datetime-local" name="frm_maintenance_toa" id="frm_maintenance_toa" value=""/>
        </div>		

        <div id="tod" data-role="fieldcontain">
            <label for="frm_maintenance_tod">Time Of Departure:</label>
            <input type="datetime-local" name="frm_maintenance_tod" id="frm_maintenance_tod" value=""/>
        </div> 
        
        <div id="liftsDiv" data-role="fieldcontain">
            <fieldset id="myLifts" data-role="controlgroup"></fieldset>
        </div>

        <div id="tasksDiv" data-role="fieldcontain">
            
            <fieldset data-role="controlgroup">
            <legend>Tasks</legend>
                <?$x=1?>
                <?foreach($tasks as $task){?>     
                    <input type='checkbox' class='custom' id='task_<?=$x?>' name='task_<?=$x?>' value='<?=$task['task_id']?>'>           
                    <label for='task_<?=$x?>'><?=$x?>. <?=$task['task_name']?></label><?$x++?>
                <?}?>
             </fieldset>
        </div>


        <div data-role="fieldcontain">
            <label for="frm_tech_description">Notes:</label>
            <textarea cols="40" rows="8" name="frm_maintenance_notes" id="frm_maintenance_notes"></textarea>
        </div>
        
        <div id="toa" data-role="fieldcontain">
            <label for="frm_maintenance_toa">Schedule Next Visit:</label>
            <input type="datetime-local" name="schedule" id="schedule"/>
        </div>		        

        <label for="customer_signature">Customer Signature</label>
        <div id="customer_signature" name="customer_signature" style="border:1px solid #000;color:navy"></div>  
        
        <button id="submit1"  value="submit" data-theme="a">Close Visit</button>
    </form>
    
    <script>
        $('document').ready(function()
        {     
            
            $("#customer_signature").jSignature();
            $("#customer_signature").bind('change', function(e){ 
                var datapair = $("#customer_signature").jSignature("getData", "default");
                $("#frm_customer_signature").val(datapair);
            });   

                
            $("#submit1").click(function(){
                event.preventDefault();
                $("#maintenanceForm").submit();
            });
            
            function jobChange()
            {			
                myURL = "<?=app('url')?>/exec/tech_maintenance/getLifts/?frm_job_id="+$("#frm_job_id").val();
                $( "#myLifts" ).load(myURL,function(){
                    $("#myLifts").trigger("create");
                });
            }
        
            jobChange();
        });    
    </script>
