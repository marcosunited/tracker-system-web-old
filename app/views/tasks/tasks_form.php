<h1>
    <?=$values["task_id"] ? "Edit " : "Add New ";?>
    task <?=$values["task_id"] ? ": ".$values["task_name"] : "";?>
</h1>
    
<form action='<?=app("url")?>/exec/tasks/action/' id='taskForm' name='taskForm'>
    <input type='hidden' name='frm_task_id' id='task_id' value='<?=$values["task_id"]?>'><br>
    <label>Service Area</label><?parentListReq("frm_service_area_id","_service_areas",$values["service_area_id"],"service_area_name","")?><br>
	<label>Service Type</label><?parentListReq("frm_service_type_id","_service_types",$values["service_type_id"],"service_type_name","")?><br>
	<label>Name</label><input name='frm_task_name'  id='frm_task_name' value='<?=$values["task_name"]?>'><br>
    <label> </label><button id='formbutton'>Submit</button>
</form>

<script>
    $(document).ready(function(){
          $('#taskForm').validate();
    });
</script>
