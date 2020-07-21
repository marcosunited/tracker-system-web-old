	<h1>Generate Timesheet</h1>	
	
	<form action="<?=app('url')?>/exec/timesheet/generate/" method="post" target="_blank">
		<label>Period Starting</label><input name="frm_start_date" id="frm_start_date" class="required"><br>
		<label>Period Ending</label><input name="frm_end_date" id="frm_end_date" class="required"><br>
		<label>Technician</label><?parentListReq("frm_technician_id","technicians","","technician_name","where technicians.status_id = 1 order by technician_name ASC")?><br>
		<label>&nbsp;</label><button>Generate Timesheet</button>
	</form>
	<script>
		$(document).ready(function(){
			$("#frm_start_date").datepicker({ dateFormat: 'dd-mm-yy' });
			$("#frm_end_date").datepicker({ dateFormat: 'dd-mm-yy' });	
		});
	</script>	
