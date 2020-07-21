<?
    /*
        Add / Edit Lifts Form
        Version: 14.2.24
        Cody Joyce
    */
?>
<h1>
    <?=$lift["lift_id"] ? "Edit " : 'Add New';?>
    Lift <?=$lift["lift_id"] ? ": ".$lift['lift_name'] : '';?>
</h1>

<p><a href="<?=app("url")?>/exec/lifts/?frm_job_id=<?=req("frm_job_id")?>" class="ajaxlink" target="lifts">Back to lifts</a></p>

<form action='<?=app('url')?>/exec/lifts/action/' id='liftForm' name='liftForm' class="ajaxform" target="lifts">
    <input type='hidden' name='frm_lift_id' id='lift_id' value='<?=$lift["lift_id"]?>'>
    <input type="hidden" name="frm_job_id" value="<?=req("frm_job_id")?>">
    <label>Status id</label><?parentListReq("frm_status_id","_status",$lift["status_id"],"status_name","")?><br>
    <label>Lift type </label>
        <select class='required' name="frm_lift_type" id="frm_lift_type" >
            <option value=''>SELECT</option>
            <option value='L'>Lift</option>
            <option value='E'>Escalator</option>        
        </select>    
    <br>    
    <label>Name</label><input name='frm_lift_name'  id='frm_lift_name' value='<?=$lift["lift_name"]?>' class="required"><br>
    <label>Phone</label><input name='frm_lift_phone'  id='frm_lift_phone' value='<?=$lift["lift_phone"]?>' class="required"><br>
    <label>Controller</label><input name='frm_lift_controller'  id='frm_lift_controller' value='<?=$lift["lift_controller"]?>'><br>
    <label>Reg number</label><input name='frm_lift_reg_number'  id='frm_lift_reg_number' value='<?=$lift["lift_reg_number"]?>'><br>
    <label>Specifications</label><input name='frm_lift_specifications'  id='frm_lift_specifications' value='<?=$lift["lift_specifications"]?>'><br>
    <label>Installed by</label><input name='frm_lift_installed_by'  id='frm_lift_installed_by' value='<?=$lift["lift_installed_by"]?>'><br>
    <label>Drive</label><input name='frm_lift_drive'  id='frm_lift_drive' value='<?=$lift["lift_drive"]?>'><br>
    <label>Light rays</label><input name='frm_lift_light_rays'  id='frm_lift_light_rays' value='<?=$lift["lift_light_rays"]?>'><br>
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
     
    });
</script>


