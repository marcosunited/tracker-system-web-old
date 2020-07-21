	<script src="<?=app('app_url')?>/scripts/jSignature/jSignature.min.js"></script>
    <ul data-role="listview" data-theme="c">
        <li data-role="list-divider">
            New Callout
        </li>
    </ul>

    <hr>
    
    <form name="calloutsForm" id="calloutsForm" action="<?=app('url')?>/exec/tech_callouts/action" method="post" data-ajax="false">
        <input type="hidden" name="frm_callout_status_id" id="frm_callout_status_id" value="2">
        <input type="hidden" name="frm_callout_id" id="frm_callout_id" value="">
        <input type="hidden" name="frm_technician_id" id="frm_technician_id" value="<?=sess('user_id')?>">       
        <input type="hidden" name="frm_customer_signature" id="frm_customer_signature" value="">
        <input type="hidden" name="frm_chargeable_id" id="frm_chargeable_id" value="2">
        <input type="hidden" name="frm_priority_id" id="frm_priority_id" value="2">
        <input type="hidden" name="frm_accepted_id" id="frm_accepted_id" value="1">
        <input type="hidden" name="frm_callout_time" id="frm_callout_time" value="<?=time()?>">
        
        <div id="job" data-role="fieldcontain">
            <label for="frm_job_id">Job:</label>
                <input type="hidden" name="frm_job_id" id="frm_job_id" value="<?=req('frm_job_id')?>">
                <?=req('job_name')?>
        </div>

        <div id="liftsDiv" data-role="fieldcontain">
            <fieldset id="myLifts" data-role="controlgroup">
            
            </fieldset>
        </div>

         

        <div data-role="fieldcontain">
           <label for="frm_fault_id" class="select">Fault Reported:</label>
		   <?parentListReq("frm_fault_id","_faults","","fault_name","")?>
        </div>
        
        <div data-role="fieldcontain">
           <label for="frm_technician_fault_id" class="select">Fault Found:</label>
		   <?parentListReq("frm_technician_fault_id","_technician_faults","","technician_fault_name","where tech_hidden is null")?>
        </div>
<div id="toa" data-role="fieldcontain">
            <label for="frm_time_of_arrival">Time Of Arrival:</label>
            <input type="datetime-local" name="frm_time_of_arrival" id="frm_time_of_arrival" value=""/>
        </div>		

        <div id="tod" data-role="fieldcontain">
            <label for="frm_time_of_departure">Time Of Departure:</label>
            <input type="datetime-local" name="frm_time_of_departure" id="frm_time_of_departure" value=""/>
        </div>        
        <div data-role="fieldcontain">
            <label for="frm_tech_description">Description of Work:</label>
            <textarea cols="40" rows="8" name="frm_tech_description" id="frm_tech_description"></textarea>
        </div>

        <label for="customer_signature">Customer Signature</label>
        <div id="customer_signature" name="customer_signature" style="border:1px solid #000;color:navy"></div>        

		
        <button id="submit1"  value="submit" data-theme="a">Close Call</button>
        <button id="submit2"  value="submit" data-theme="b">Follow Up Required</button>
        <button id="submit3"  value="submit" data-theme="e">Lift Shut Down</button>         
    </form>
    
    <script>
           $('document').ready(function(){ 

                //What do do when the selected job changes, Update the 'Lifts DIV'
                $("#frm_job_id").change(function(){
                    jobChange();
                });
                
                $("#customer_signature").jSignature();
                
                $("#customer_signature").bind('change', function(e){ 
                    var datapair = $("#customer_signature").jSignature("getData", "default");
                    $("#frm_customer_signature").val(datapair);
                });                       

				$("#frm_time_of_arrival").change(function(){
					$("#checkinbox").css("display","none");
				});
				
				$("#frm_time_of_departure").change(function(){
					$("#checkoutbox").css("display","none");
				})				
				//close
                $("#submit1").click(function(){
                    event.preventDefault();
                    $("#calloutsForm").submit();
                });
                //follow up req
                $("#submit2").click(function(){
                    event.preventDefault();
                    $("#frm_callout_status_id").val(4);
                    $("#calloutsForm").submit();
                });
                //shutdown
                $("#submit3").click(function(){
                    event.preventDefault();
                    $("#frm_callout_status_id").val(3);
                    $("#calloutsForm").submit();
                });                
                function jobChange()
                {			
                    //create the lift check boxes based on the selected job
                    
                    myURL = "<?=app('url')?>/exec/tech_callouts/getLifts/?frm_job_id="+$("#frm_job_id").val();
                    //alert(myURL);
                    $( "#myLifts" ).load(myURL,function(){
                        $("#myLifts").trigger("create");
                    });
                }
                
                jobChange();
           })
    </script>   