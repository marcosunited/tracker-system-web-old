<h1>
    <?=$values["schedule_id"] ? "Edit " : "Create ";?>
    Scheduled Visit
</h1>

<p><a href="<?=app('url')?>/exec/schedule/?frm_job_id=<?=$job_id?>" class='ajaxlink' target='schedule'>Back to Schedule</a></p>

<form action='<?=app("url")?>/exec/schedule/action/' id='scheduleForm' name='scheduleForm' class='ajaxform' target='schedule'>
	<input type='hidden' name='frm_schedule_id' id='schedule_id' value='<?=$values["schedule_id"]?>'>
	<input type="hidden" name="job_id" value="<?=$job_id?>">
	<label>Lift name</label>
		<?//parentListReq("frm_lift_id","lifts",$values["lift_id"],"lift_name","where job_id = $job_id")?>
		<select>
		<?foreach($lifts as $lift){?>
			<option value="<?=$lift["lift_id"]?>"><?=$lift["lift_name"]?></option>
		<?}?>
			<option value="All">All</option>
		</select><br>
	<label>Service area</label><?parentListReq("frm_service_area_id","_service_areas",$values["service_area_id"],"service_area_name","")?><br>
	<label>Service type</label><?parentListReq("frm_service_type_id","_service_types",$values["service_type_id"],"service_type_name","")?><br>
	<label>Frequency id</label><?parentListReq("frm_frequency_id","_frequency",$values["frequency_id"],"frequency_name","")?><br>
	<label>Last completed</label><input name='frm_last_completed'  id='frm_last_completed' value='<?=$values["last_completed"]?>'><br>
	<label> </label><button id='formbutton'>Submit</button>
</form>

<script>
    $(document).ready(function()
    {
        $(".ajaxform").validate(
        {
            submitHandler: function(form) 
            {
                $.post($(form).attr("action"), $(form).serialize(), function(return_data) {
                  $("#"+$(form).attr("target")).html(return_data);
                });                  
            }
        });
     
		$("#frm_last_completed").datepicker({ dateFormat: 'dd-mm-yy' });
    });
</script>
