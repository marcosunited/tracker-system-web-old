<h1>Generate a Group Report (Callouts + Maintenance)</h1>
<form id="genForm" action="<?=app("url")?>/exec/reports/group_generate" method="GET" target="_blank">
    <label>Group</label>
    
    <select id="frm_group_name" name="frm_group_name" class="required">
        <option value="">SELECT</option>
        <?foreach($groups as $group){?>
            <option value="<?=$group?>"><?=$group?></option>
        <?}?>
    </select><br>
                
    <label>Period Starting</label><input name="frm_start_date" id="frm_start_date" class="required"><br>
    <label>Period Ending</label><input name="frm_end_date" id="frm_end_date" class="required"><br>
       
    <label>For Fault</label><?parentList("frm_fault_id","_faults",null,"fault_name","")?><br>

    <label>Include Tech Description</label>
    <input type="checkbox" name="advanced"><br>
    <label>&nbsp;</label><button id='formbutton'>Generate Group Report</button>  
</form>


<!--h1>Generate a Group Report (Maintenance)</h1>
<form id="genForm" action="<?=app("url")?>/exec/reports/group_maintenance_generate" method="POST" target="_blank">
    <label>Group</label>
    
    <select id="frm_group_name" name="frm_group_name" class="required">
        <option value="">SELECT</option>
        <?foreach($groups as $group){?>
            <option value="<?=$group?>"><?=$group?></option>
        <?}?>
    </select><br>
                
    <label>Period Starting</label><input name="frm_start_date" id="frm_start_date2" class="required"><br>
    <label>Period Ending</label><input name="frm_end_date" id="frm_end_date2" class="required"><br>
       
    <label>For Task</label><?parentList("frm_task_id","_new_tasks",null,"task_name","")?><br>
    <label>Order By</label>
    <select name="frm_order_by">
        <option value="">SELECT</option>
        <option value="callout_time">Date</option>
        <option value="fault_name">Fault</option>
        <option value="lift_names">Lifts</option>
        <option value="technician_name">Technician</option>
    </select>
    <select name="frm_direction">
        <option value="ASC">Ascending Order</option>
        <option value="DESC">Decending Order</option>
    </select>
    <br>
    <label>&nbsp;</label><button id='formbutton'>Generate Site Report</button>  
</form!-->
<script>
        $('#genForm').validate();

        $("#frm_start_date").datepicker({ dateFormat: 'dd-mm-yy' });
        $("#frm_end_date").datepicker({ dateFormat: 'dd-mm-yy' });
        
        $("#frm_start_date2").datepicker({ dateFormat: 'dd-mm-yy' });
        $("#frm_end_date2").datepicker({ dateFormat: 'dd-mm-yy' });

</script>