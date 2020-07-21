<?
    $disabled = "";
    $color ="";
    if($values["callout_id"] == ''){
            $disabled = "DISABLED";
            $color = "style='background-color:grey;'";
    }
    
?>
    <img src="<?=app('app_url')?>/images/icons/stock_cell-phone.png" class="main_icon">
    <h1>
        <?=$values["technician_id"] ? "Edit " : "Create ";?>
        Callout
    </h1>
	
    <p>
        <a href="<?=app('url')?>/exec/callouts/">Back to Callouts</a> | 
        <a href="<?=app('url')?>/exec/callouts/printPdf/?frm_callout_id=<?=$values['callout_id']?>" target="_blank">Print Callout</a>
    </p>
    &nbsp;
    <form action='<?=app("url")?>/exec/callouts/action/' id='calloutForm' name='calloutForm' method="post"  >
        <div style="float:left;width:640px;background-color:#f9f9f9;padding:10px;border:1px solid #ccc;">
                <h2>Job Details</h2>
                
				<input type='hidden' name='frm_callout_id' id='callout_id' value='<?=$values["callout_id"]?>'>
                <input type='hidden' name='frm_is_printed' id='is_printed' value='<?=$values["is_printed"]?>'>
                
				<label>Current Status</label><?parentListReq("frm_callout_status_id","_callout_status",$values["callout_status_id"],"callout_status_name","")?><br>
                <label>Time of Call</label><input type="datetime-local" name='frm_callout_time'  id='frm_callout_time' value='<?=$values["callout_time"]?>'><br>
                <label>Job</label><input id="job_name" autocomplete="off">
                
                <select id="frm_job_id" name="frm_job_id" class="required">
                    <option value="">SELECT</option>
                    <?$result = query("select * from jobs where status_id = 1 order by job_address,job_address_number asc")?>
                    <?while($row=mysqli_fetch_array($result)){?>
                            <option 
                            <?if ($row["job_id"] == $values["job_id"]){?>
                                SELECTED
                            <?}?>
                            value="<?=$row["job_id"]?>"><?=$row["job_address_number"]?> <?=$row["job_address"]?> (<?=$row["job_name"]?>)</option>
                    <?}?>        
                </select><br>
                
                <label>Technician</label><?parentListReq("frm_technician_id","technicians",$values["technician_id"],"technician_name","where technicians.status_id = 1 order by technician_name ASC")?><br>                
            
                <h2>Call Details</h2>
                <label>Lifts</label>
                
				<input style="opacity:0.0;width:0px;" id="liftcheck" class="required" <?if(req('frm_callout_id')){?>value='11'<?}?>>
                
				
				<!--Area to load LIFTS!-->
                <div id="liftsDiv" style="height:auto">
                    <?if($values["job_id"]){
                        //copy some of the values to REQUEST for easy passing to getLifts Function.
                        req("frm_job_id",$values["job_id"]);
                        req("frm_lift_names",$values["lift_ids"]);
                        
                        $callouts = new callouts();
                        $callouts->getLifts();
                    }?>
                </div>
                
                <div class="break"><br></div>
                <label>Floor no</label><input name='frm_floor_no'  id='frm_floor_no' value='<?=$values["floor_no"]?>'><br>
                        <label>Fault / Priority <b>(COMPLAINT)</b></label><?parentListReq("frm_fault_id","_faults",$values["fault_id"],"fault_name","")?>
                        <?parentListReq("frm_priority_id","_priorities",$values["priority_id"],"priority_name","")?>
                        <br>                
                
                <label>Description </label><textarea name='frm_callout_description'  id='frm_callout_description' style="width:455px"><?=$values["callout_description"]?></textarea><br>
                <label>Order No / Chargeable</label><input name='frm_order_number'  id='frm_order_number' value='<?=$values["order_number"]?>'>
                
                <?parentListReq("frm_chargeable_id","_chargeable",$values["chargeable_id"],"chargeable_name","")?>
                    <br>

                <label>Verify</label><input name='frm_verify'  id='frm_verify' value='<?=$values["verify"]?>'><br>
                <label>Attributable</label> <?parentListReq("frm_attributable_id","_attributable",$values["attributable_id"],"attributable_name","")?>
                <br>
                <?
                        $checked = "";
                        if($values["notify_email"]!=""){
                                $checked="CHECKED";
                        }?>
                        <label>Parts Description:</label><textarea name="frm_part_description" id="frm_part_description" style="width:455px"><?=$values["part_description"]?></textarea><br> 
                        <label>Contact Details</label><textarea name="frm_contact_details" id="frm_contact_details" style="width:455px"><?=$values["contact_details"]?></textarea><br>                
                <label>Email Notification</label><input <?=$checked?> name="chk_notify" id="chk_notify" type="checkbox">
                <input name="frm_notify_email" id="frm_notify_email" value='<?=$values["notify_email"]?>'><br>
				<label>Reported customer</label><input name="frm_reported_customer" id="frm_reported_customer" value='<?=$values["reported_customer"]?>'><br>
                
                <label></label><button id='formbutton'>Submit</button>   
                <label></label><button id='formbutton'<?=$disabled?> <?=$color?>>SMS</button>   
        </div>
        <div  style="margin-left:5px;float:left;width:550px;background-color:#faffb2;padding:10px;border:1px solid #ccc;">
                <h2>Tech Details</h2>
                <div id="jobMap"></div>
                <label>Docket number</label><input name='frm_docket_number' id='frm_docket_number' value='<?=$values["docket_number"]?>'><br>
                <label>Time of arrival</label><input type="datetime-local" name='frm_time_of_arrival'  id='frm_time_of_arrival' value='<?=$values["time_of_arrival"]?>'><br>
				<label>Rectification Time</label><input type="datetime-local" name='frm_rectification_time'  id='frm_rectification_time' value='<?=$values["rectification_time"]?>'><br>
                <label>Time of departure</label><input type="datetime-local" name='frm_time_of_departure'  id='frm_time_of_departure' value='<?=$values["time_of_departure"]?>'><br>
                
                <label>Fault Found <b>(CAUSE)</b></label><?parentList("frm_technician_fault_id","_technician_faults",$values["technician_fault_id"],"technician_fault_name","where tech_hidden is null order by technician_fault_name ASC")?><br>   
                
                <label>Work Done <b>(CORRECTION)</b></label><?parentList("frm_correction_id","_corrections",$values["correction_id"],"correction_name","")?><br>   
                <label>Description of Work</label><textarea name="frm_tech_description" id="frm_tech_description" style="width:300px"><?=$values["tech_description"]?></textarea><br>           
                
                <label>Technicians Signature</label>
                    
                    <?if($values["technician_signature"] !=""){?>
                        <img src="<?=$values['technician_signature']?>">
                    <?}?>&nbsp;<br>
                <div class="clear"></div><br>
                <label>Customers Signature</label>
                    
                    <?if($values["customer_signature"] !=""){?>
                        <img src="<?=$values['customer_signature']?>">
                    <?}?>&nbsp;<br>
                <div class="clear"></div><br>            
                <label></label><button id='formbutton'>Submit</button>  
        </div>
    </form>
    <img src="http://cloud.unitedlifts.com.au/melbournemrs/public/uploads/<?=$values['photo_name']?>" width="250px" height="250px">
    <!--Hidden Divs to easily store information!-->
    <div id="techId" style="visibility:hidden"></div>
    <div id="contactDetails" style="visibility:hidden"></div>
    <div id="notify" style="visibility:hidden"></div>

<script>
    $(document).ready(function(){
        //Check if the docket exists
        $('#frm_docket_number').on("change",function(){
                var frm_docket_number = $("#frm_docket_number").val(); 
                $.get('checkDocket?docket_number='+frm_docket_number, function (data) {
                        if(data==1){
                                alert("Docket Already Exists");
                        }
                });
        });        
        
        //$(".liftcheck").on("click",function(){
			//console.log("Lift Checked");
		//})
        
        $(".liftcheck").livequery("click",function(event,ui)
        {
			$("#liftcheck").val(1).change();
        });
		
		
	//set the focus on the job search when the page loads
        document.getElementById("job_name").focus();
        
        if(isMobile() === false){
			$('#frm_callout_time').datetimepicker({ dateFormat: 'dd-mm-yy',timeFormat:'HH:mm:ss',showSecond: false });
			$('#frm_time_of_arrival').datetimepicker({ dateFormat: 'dd-mm-yy',timeFormat:'HH:mm:ss',showSecond: false });
			$('#frm_rectification_time').datetimepicker({ dateFormat: 'dd-mm-yy',timeFormat:'HH:mm:ss',showSecond: false });
			$('#frm_time_of_departure').datetimepicker({ dateFormat: 'dd-mm-yy',timeFormat:'HH:mm:ss',showSecond: false });
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
				
                                //email address
				myURL = "<?=app('url')?>/exec/callouts/getEmail/?frm_job_id="+$("#frm_job_id").val();
				$("#contactDetails").load(myURL,function(){
					$("#frm_notify_email").val($("#contactDetails").html());
				});
                                
                                //Instant Notification Checkbox
				myURL = "<?=app('url')?>/exec/callouts/getNotify/?frm_job_id="+$("#frm_job_id").val();
				$("#notify").load(myURL,function(){
					if($("#notify").html() > 0){
                                                $('#chk_notify').prop('checked', true);
                                        }else{
                                                $('#chk_notify').prop('checked', false); 
                                        }
                                        $("#notify").html("");
				});                                  
            }else{
				$("#liftsDiv").html(null);
				$("#frm_technician_id").val(null);
				$("#contactDetails").val(null);
			}
        }
        
    });
</script>
