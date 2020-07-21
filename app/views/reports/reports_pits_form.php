<h1>Generate a Pit Cleaning Report</h1>

<form id="genForm" action="<?=app("url")?>/exec/reports/pits_generate" method="POST" target="_blank">
             
    <label>Period Starting</label><input name="frm_start_date" id="frm_start_date" class="required"><br>
    <label>Period Ending</label><input name="frm_end_date" id="frm_end_date" class="required"><br>
    <label>&nbsp;</label><button id='formbutton'>Generate Pit Report</button>  
</form>

<script>
        $('#genForm').validate();
        
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
        
        $("#frm_start_date").datepicker({ dateFormat: 'dd-mm-yy' });
        $("#frm_end_date").datepicker({ dateFormat: 'dd-mm-yy' });
        
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
            }else{
				$("#liftsDiv").html(null);
			}
        }
</script>