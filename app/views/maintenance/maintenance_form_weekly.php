
    <img src="<?=app('app_url')?>/images/icons/stock_cell-phone.png" class="main_icon">
    <h1>
        
        Maintenance Visit Edit Date
    </h1>
	
    <p>
        <a href="<?=app('url')?>/exec/maintenance/">Back to Callouts</a> | 
    </p>
    &nbsp;
    <form action='<?=app("url")?>/exec/maintenance/actionWeekly/' id='calloutForm' name='calloutForm' method="post"  >
        <div style="float:left;width:640px;background-color:#f9f9f9;padding:10px;border:1px solid #ccc;">
                <h2>Job Details</h2>
                
				<input type='hidden' name='frm_maintenance_id' id='maintenance_id' value='<?=$values["maintenance_id"]?>'>  
                <label>Maintenance Date</label><input type="datetime-local" name='frm_maintenance_date'  id='frm_maintenance_date' value='<?= toDateTime($values["maintenance_date"]);?>'><br>
                
                <label>Job</label><input id="job_name" autocomplete="off">
                
                <select id="frm_job_id" name="frm_job_id" class="required">
                    <option value="">SELECT</option>
                    <?$result = query("select * from jobs where status_id = 1 order by job_address,job_address_number asc")?>
                    <?while($row=mysqli_fetch_array($result)){?>
                            <option 
                            <?if ($row["job_id"] == $values["job_id"]){?>
                                SELECTED
                            <?}?>
                            value="<?=$row["job_id"]?>"><?=$row["job_address_number"]?> <?=$row["job_address"]?>(<?=$row["job_name"]?>)</option>
                    <?}?>        
                </select><br>
                
                <label>Technician</label><?parentListReq("frm_technician_id","technicians",$values["technician_id"],"technician_name","where technicians.status_id = 1 order by technician_name ASC")?><br>                
            
                <h2>Call Details</h2>
                <label>Lifts</label>
                
		<input style="opacity:0.0;width:0px;" id="liftcheck" class="required" <?if(req('frm_maintenance_id')){?>value='1'<?}?>>
                
				
				<!--Area to load LIFTS!-->
                <div id="liftsDiv" style="height:auto;">
                    <?if($values["job_id"]){
                        //copy some of the values to REQUEST for easy passing to getLifts Function.
                        req("frm_job_id",$values["job_id"]);
                        req("frm_lift_names",$values["lift_ids"]);
                        
                        $callouts = new callouts();
                        $callouts->getLifts();
                    }?>
                </div>

                
        </div>
        <div  style="margin-left:5px;float:left;width:550px;background-color:#dceeff;padding:10px;border:1px solid #ccc;">
                <h2>Weekly Maintenance Tech Details</h2>
                
                <br>
                <div style="margin-left:40px;">
                    <?$x=1?>
                    <?foreach($maintenanceWeeklyRows as $maintenanceWeek){
                        $weekId = $maintenanceWeek['id'];
                        ?>
                        
                        <label>Date </label><input type="datetime-local" name='frm_date_<?=$weekId?>'  id='frm_date_<?=$weekId?>' value='<?=$maintenanceWeek["date"]?>' class="required">
                        <input type='hidden' name="frm_id_<?=$weekId?>" id="frm_id_<?=$weekId?>"  value="<?=$maintenanceWeek['id']?>">
                        <input type='hidden' name="frm_maintenance_id" id="frm_maintenance_id" value="<?=$maintenanceWeek['maintenance_id']?>">
                        <label>month:</label><input name="frm_maintenance_year_month_week" id="frm_maintenance_year_month_week" disabled value="<?=substr( $maintenanceWeek['year_month_week'] ,4 ,2) ?>"><br>                
                        <label>week:</label><input name="frm_maintenance_year_month_week" id="frm_maintenance_year_month_week" disabled value="<?=substr( $maintenanceWeek['year_month_week'] ,6 ,1) ?>"><br>            
                        
                        <div style="margin-left:140px;">
                        <?$y=1?>
                        <?foreach($tasks as $task){?>
                            <?
                                $checked="";
                                if(strstr($maintenanceWeek['task_ids'],"|".$task['task_id']."|"))
                                $checked = "CHECKED";   
                            ?>           
                            <input <?=$checked?> class='check liftcheck' type='checkbox' name='task_<?=$y?>' disabled value='<?=$task['task_id']?>'><?=$y?>. <?=$task['task_name']?>  <br>             
                            <?$y++?>
                        <?}?>
                    </div>


                        <?$x++?>
                    <?}?>
                </div>

                
                
                
                <label></label><button id='formbutton'>Submit</button>  
        </div>
    </form>
    
    <!--Hidden Divs to easily store information!-->
    <div id="techId" style="visibility:hidden">
    
    </div>
    <div id="contactDetails" style="visibility:hidden">
    
    </div>

<script>
    $(document).ready(function(){
        
        //Check if the docket exists
        $('#frm_docket_no').on("change",function(){
                var frm_docket_number = $("#frm_docket_no").val(); 
                $.get('checkDocket?docket_number='+frm_docket_number, function (data) {
                        if(data==1){
                                alert("Docket Already Exists");
                        }
                });
        });
        
        //$("#technician_signature").jSignature();
        
        $(".liftcheck").livequery("click",function(event,ui)
        {
				$("#liftcheck").val(1).change();
        });
		
		
		//set the focus on the job search when the page loads
        document.getElementById("job_name").focus();
        
        $('#schedule').datepicker({ dateFormat: 'dd-mm-yy' });
        
		if(isMobile()==false){
		$('#frm_maintenance_date').datepicker({ dateFormat: 'dd-mm-yy' });
        $('#frm_maintenance_toa').datetimepicker({ dateFormat: 'dd-mm-yy',timeFormat:'HH:mm:ss',showSecond: false });
        $('#frm_maintenance_tod').datetimepicker({ dateFormat: 'dd-mm-yy',timeFormat:'HH:mm:ss',showSecond: false });
        }
		
        //enable form validation
        $('#calloutForm').validate();

        //What do do when the selected job changes, Update the 'Lifts DIV'
        $("#frm_job_id").change(function(){
            $("#job_name").val(null);
            jobChange();
        });

        //What do do when the selected job changes, Update the 'Lifts DIV'
        $("#frm_job_id").keyup(function(){
            $("#job_name").val(null);
            jobChange();
        });
        
        //keyup event for the search box,, Update the 'Lifts DIV'
        var timer;
        $("#job_name").on('keyup',function()
        {
            timer && clearTimeout(timer);
            timer = setTimeout(searchJobs, 400);
        });

        disableLifts();

        document.getElementById("job_name").disabled =true ;
        document.getElementById("frm_job_id").disabled =true ;
        

        //Disable lift checking
        function disableLifts()
        {
            var checkboxes = $("input:checkbox"); 
            var i;
            for (i = 0; i < checkboxes.length; i++) 
            {
                if ( checkboxes[i].name.startsWith("lift") ) 
                {
                    checkboxes[i].disabled = true;                
                }
            }
        }
        
        //loop thru each job in the select dropdown. If it matches the job_name search it will select it.
        //then run the jobChange function to update lifts DIV
        function searchJobs()
        {
            typedName = $("#job_name").val().toLowerCase();
            
            if(typedName.length >= 3){
                $("#frm_job_id > option").each(function() {
                    optString = this.text.toLowerCase();
                    s = optString.search(typedName);
                    if (s>=0){
                        $("#frm_job_id").val(this.value);
						//$("#job_name").val(optString);
						//alert(optString);
                        jobChange();
                        return false;
                    }
                });
            }else{
                //$("#frm_job_id").val(null);
            }
        }
        
        //What do do when the selected job changes, Update the 'Lifts DIV'
        function jobChange()
		{			
			if($("#frm_job_id").val() != "")
			{
				//create the lift check boxes based on the selected job
				myURL = "<?=app('url')?>/exec/callouts/getLifts/?frm_job_id="+$("#frm_job_id").val();
				$( "#liftsDiv" ).load(myURL,function(){});
                
                disableLifts();

				//here we will change the technician
				myURL = "<?=app('url')?>/exec/callouts/getTech/?frm_job_id="+$("#frm_job_id").val();
				$("#techId").load(myURL,function(){
					$("#frm_technician_id").val($("#techId").html());
				});
				
				//contact details
				myURL = "<?=app('url')?>/exec/callouts/getContact/?frm_job_id="+$("#frm_job_id").val();
				$("#contactDetails").load(myURL,function(){
					$("#frm_contact_details").val($("#contactDetails").html());
				});
            }else{
				$("#liftsDiv").html(null);
				$("#frm_technician_id").val(null);
				$("#contactDetails").val(null);
			}
        }
        
    });
</script>
