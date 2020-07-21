	<script src="<?=app('app_url')?>/scripts/jSignature/jSignature.min.js"></script>
     <ul data-role="listview" data-theme="c">
        <li>
            <?=$values['job_address_number']?> <?=$values['job_address']?> <?=$values['job_suburb']?>
        </li>
        <li data-role="list-divider">
            Time Of Call: <?=$values['callout_time']?><br>
            Lifts: <?=liftNames($values['lift_ids'])?><br> 
            Floor: <?=$values['floor_no']?><br> 
            Fault: <?=$values['fault_name']?><br>
            Description: <?=$values["callout_description"]?>
        </li>
    </ul>

    <hr>
    
    <form name="calloutsForm" id="calloutsForm" action="<?=app('url')?>/exec/tech_callouts/action" method="post" data-ajax="false">
        <input type="hidden" name="frm_callout_status_id" id="frm_callout_status_id" value="<?=$values['callout_status_id']?>">
        <input type="hidden" name="frm_callout_id" id="frm_callout_id" value="<?=$values['callout_id']?>">       
		<input type="hidden" id="timesheet_latitude" name="timesheet_latitude" value="<?=$values["time_of_arrival"]?>">
		<input type="hidden" id="timesheet_longitude" name="timesheet_longitude" value="<?=$values["time_of_departure"]?>">

        <?if($values['customer_signature']==''){?>
            <input type="hidden" name="frm_customer_signature" id="frm_customer_signature" value="<?=$values['customer_signature']?>">
        <?}?>

        <div data-role="fieldcontain">
           <label for="frm_technician_fault_id" class="select">Fault Found:</label>

		   <?parentListReq("technician_fault_id","_technician_faults","","technician_fault_name","where tech_hidden is null")?>
        </div>
        
        <?if($values["time_of_arrival"] == 0){?>
			<div id="toa" data-role="fieldcontain">
				<label for="frm_time_of_arrival">Time Of Arrival:</label>
				<input type="datetime-local" name="frm_time_of_arrival" id="frm_time_of_arrival" value="<?=$values["time_of_arrival"]?>"/>
				<div id="checkinbox">
					<input type="button" id="checkin" data-theme="a" value="Check In">
				</div>
			</div>		
		<?}?>

		<?if($values["time_of_departure"] == 0){?>
			<div id="tod" data-role="fieldcontain">
				<label for="frm_time_of_departure">Time Of Departure:</label>
				<input type="datetime-local" name="frm_time_of_departure" id="frm_time_of_departure" value="<?=$values["time_of_departure"]?>"/>
				<div id="checkoutbox">
					<input type="button" id="checkout"  data-theme="a" value="Check Out">
				</div>
			</div> 
		<?}?>
        
        <div data-role="fieldcontain">
            <label for="frm_tech_description">Description of Work:</label>
            <textarea cols="40" rows="8" name="frm_tech_description" id="frm_tech_description"><?=$values['tech_description']?></textarea>
        </div>

        <label for="customer_signature">Technician Signature</label>
        <?if($values['customer_signature']==''){?>
            <div id="customer_signature" name="customer_signature" style="border:1px solid #000;color:navy"></div>        
        <?}else{?>
            <img src="<?=$values['customer_signature']?>"><br>
        <?}?>
		
        <button id="submit1"  value="submit" data-theme="a">Close Call</button>
        <button id="submit2"  value="submit" data-theme="b">Follow Up Required</button>
        <button id="submit3"  value="submit" data-theme="e">Lift Shut Down</button> 
    </form>
    
    
    <script>
       $('document').ready(function(){ 
                

            <?if($values['customer_signature']==''){?>
                $("#customer_signature").jSignature();
                
                $("#customer_signature").bind('change', function(e){ 
                    var datapair = $("#customer_signature").jSignature("getData", "default");
                    $("#frm_customer_signature").val(datapair);
                });                       
            <?}?>
        
            $("#checkin").click(function(){
                $url = "<?=app("url")?>/exec/tech_callouts/checkin/?callout_id=<?=$values['callout_id']?>";
                $.get( $url, function( data ) {
                    $("#toa").css("display","none");
                });
            });
            
            $("#checkout").click(function(){
                $url = "<?=app("url")?>/exec/tech_callouts/checkout/?callout_id=<?=$values['callout_id']?>";
                $.get( $url, function( data ) {
                    $("#tod").css("display","none");
                });
            });				
            
            $("#frm_time_of_arrival").change(function(){
                $("#checkinbox").css("display","none");
            });
            
            $("#frm_time_of_departure").change(function(){
                $("#checkoutbox").css("display","none");
            })				
            
            $("#submit1").click(function(){
                event.preventDefault();
                $("#frm_callout_status_id").val('2');
                $("#calloutsForm").submit();
                
                
            });
         
            $("#submit2").click(function(){
                event.preventDefault();
                $("#frm_callout_status_id").val('4');
                $("#calloutsForm").submit();
            });

            $("#submit3").click(function(){
                event.preventDefault();
                $("#frm_callout_status_id").val('3');
                $("#calloutsForm").submit();
            });                   
       });
    </script>   