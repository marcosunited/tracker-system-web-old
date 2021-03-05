<div style="float:left;width:600px;">
    <h1>
        <?=$job["job_id"] ? "Edit " : "Add New ";?>
        Job <?=$job["job_id"] ? ": ".$job["job_name"] : "";?>
    </h1>
    
    <p><a href="<?=app("url")?>/exec/jobs/" accesskey="z">Back to Jobs</a></p>
    
    <form action="<?=app("url")?>/exec/jobs/action/" id="jobForm" name="jobForm" enctype="multipart/form-data" method="post">
        <input type="hidden" name="formAction" value="submit">
        <input type="hidden" name="frm_job_id" id="job_id" value="<?=$job["job_id"]?>">           

        <label>Agent id </label><? parentListReq("frm_agent_id","agents",$job["agent_id"],"agent_name","order by agent_name ASC") ?><br>
        <label>Job Number</label><input name="frm_job_number" id="frm_job_number" value="<?=$job["job_number"]?>" class="required"><br>
        <label>Important notes</label><textarea name="frm_important_notes"><?=$job["important_notes"]?></textarea><br>
        <label>Contract</label><? parentListReq("frm_contract_id","_contract",$job["contract_id"],"contract_name","order by contract_id ASC") ?><br>
        <label>Contract status</label> <img style="width:26px" src="../../../app/images/icons/<?=$job["contract_icon"]?>" /> <label><?=$job["contract_status"]?></label><br>
        <label>Invoice notes</label><textarea name="frm_invoice_notes"><?=$job["invoice_notes"]?></textarea><br>
		<div id='1' style="display:block;margin-top:4px"><label>File: </label><input type="file" name="file"  id="file"><a href="<?=app('url')?>/app/uploads/<?=$job["job_attatch"]?>">Download</a><br>
        <label>Start Date</label><input type="date" name='frm_start_time'  id='frm_start_time' value='<?=$job["start_time"]?>'><br>
        <label>Finish Date</label><input type="date" name='frm_finish_time'  id='frm_finish_time' value='<?=$job["finish_time"]?>'><br>
        <label>Price</label><input name='frm_price'  id='frm_price' value='<?=$job["price"]?>'><br>
		<label>Cancellation Date</label><input type="datetime-local" name='frm_cancel_time'  id='frm_cancel_time' value='<?=$job["cancel_time"]?>'><br>
        <br></div>
		<label>CPI</label><input name='frm_cpi'  id='frm_cpi' value='<?=$job["cpi"]?>'><br>
        <label>Name <div class="desc">Street name and numbers</div></label>
            <input name="frm_job_name" id="frm_job_name" value="<?=$job["job_name"]?>" class="required"><br>
        <label>Address</label>
            <input name="frm_job_address_number" id="frm_job_address_number" value="<?=$job["job_address_number"]?>" class="required" style="width:34px">
            <input name="frm_job_address" id="frm_job_address" value="<?=$job["job_address"]?>" class="required" style="width:155px"><br>
        <label>Suburb</label><input name="frm_job_suburb" id="frm_job_suburb" value="<?=$job["job_suburb"]?>" class="required"><br> 
        <label>Floors <div class="desc">How many floors</div></label><input name="frm_job_floors" id="frm_job_floors" value="<?=$job["job_floors"]?>" class="required"><br>
        <label>Agent Details</label><input type="text" name="frm_job_agent_contact" id="frm_job_agent_contact" value="<?=$job['job_agent_contact']?>"><br>      
        <label>Contact details <div class="desc">Main contact numbers</div></label><input name="frm_job_contact_details" id="frm_job_contact_details" value="<?=$job["job_contact_details"]?>"><br>
        
        <label>Contact Email <div class="desc">Main contact email</div></label>
            <input name="frm_job_email" id="frm_job_email" value="<?=$job["job_email"]?>">
            <a href="mailto:<?=$job["job_email"]?>?subject=<?=$job["job_name"]?>"><img style="position:absolute;margin-left:10px;" src="<?=app('app_url')?>/images/email-icon.png"></a>
        <br>
        
        <label>Owner details </label><input name="frm_job_owner_details" id="frm_job_owner_details" value="<?=$job["job_owner_details"]?>"><br>
        <label>Round</label> 
            <select name="frm_round_id" id="frm_round_id" style="color:#fff;background-image:none;background-color:#<?=$round['round_colour']?>" class="required">
                <option  value="<?=$round['round_id']?>"><?=$round['round_name']?></option>
                <?php while($round = mysqli_fetch_array($allRounds)){?>
                    <?if($tech['round_id'] != $round['round_id']){?>
                        <option style="background-color:#<?=$round['round_colour']?>" value="<?=$round['round_id']?>"><?=$round['round_name']?></option>
                    <?}?>
                <?}?>
            </select>
        <br>         
        <label>Group <div class="desc">ie DHS,Stockland </div></label><input name="frm_job_group" id="frm_job_group" value="<?=$job["job_group"]?>"><br>            
        <label>Visit Frequency</label><? parentListReq("frm_frequency_id","_frequency",$job["frequency_id"],"frequency_name","order by frequency_order ASC") ?><br>
        <label>Status id</label><? parentListReq("frm_status_id","_status",$job["status_id"],"status_name","") ?><br>       
		<label>Active Date</label><input type="datetime-local" name='frm_active_time'  id='frm_active_time' value='<?=$job["active_time"]?>'><br>
		<label>Inactive Date</label><input type="datetime-local" name='frm_inactive_time'  id='frm_inactive_time' value='<?=$job["inactive_time"]?>'><br>			
        <label>Key Access</label><textarea name="frm_job_key_access"><?=$job["job_key_access"]?></textarea><br>
	<?
                $checked="";
                if($job["notify_instant"]==1){
                        $checked = "CHECKED";
                }
        ?>
        <label>Instant Notifications</label><input name="frm_notify_instant" type="checkbox" <?=$checked?>><br>	
        <input type="hidden" name="frm_job_latitude" id="job_latitude" value="<?=$job["job_latitude"]?>">
        <input type="hidden" name="frm_job_longitude" id="job_longitude" value="<?=$job["job_longitude"]?>">          
        <label>&nbsp;</label>
        <button id="formbutton">Save Job</button>
    </form>
    <?php //Include the lifts screen if a job_id has been specified
    if($job["job_id"]){
        echo "<h1>Location Map</h1>";
        //mapper($job["job_address"]." ".$job["job_suburb"]);
        mapper($job["job_latitude"],$job["job_longitude"],$job["job_name"]);
    }
    ?>    
</div>
<div style="float:left;width:600px;">

    <div id="communications">
        <?php //Include the communications screen if a job_id has been specified
        if($job["job_id"]){
            $communications = new communications();
            $communications->index();
        }
        ?>
    </div>

    <div id="lifts">
        <?php //Include the lifts screen if a job_id has been specified
        if($job["job_id"]){
            $lifts = new lifts();
            $lifts->index();
        }
        ?>
    </div>
    

    <div id="callouts">
        <?php //Include the lifts screen if a job_id has been specified
        if($job["job_id"]){
            $jobs = new jobs();
            $jobs->callouts();
        }
        ?>        
    </div>
    <div id="maintenance">
        <?php //Include the lifts screen if a job_id has been specified
        if($job["job_id"]){
            $jobs = new jobs();
            $jobs->maintenance();
        }
        ?>        
    </div>    
	
	<div id="repair">
        <?php //Include the lifts screen if a job_id has been specified
        if($job["job_id"]){
            $jobs = new jobs();
            $jobs->repair();
        }
        ?>        
    </div>  
    <div id="schedule">
        <?php 
        if($job["job_id"]){
            $schedule = new schedule();
            $schedule->index();
        }
        ?>       
    </div>

</div>
<div class="break"></div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApoWIL5n82jkYHO8lGc2SCPGhTNGUBhbU"
        type="text/javascript"></script>
<script>
    var geocoder;
    var map;


    function initializeMaps() {
        geocoder = new google.maps.Geocoder();							// create geocoder object
        var latlng = new google.maps.LatLng(51.520838, -0.140261);		// set default lat/long (new york city)
        var mapOptions = {												// options for map
            zoom: 15,
            center: latlng
        }
        //map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);	// create new map in the map-canvas div
    }

    function validateAddress(address){
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                const __form = document.getElementById('jobForm');
                __form.submit();
            } else {
                alert('Invalid Address ' + status);
            }
        });
    }

    google.maps.event.addDomListener(window, 'load', initializeMaps);

    $(document).ready(function(){

        function processForm(e) {
            if (e.preventDefault) e.preventDefault();
            const _form = document.getElementById('jobForm');

            const address = _form.elements["frm_job_address_number"].value + " " +
                _form.elements["frm_job_address"].value + " " +
                _form.elements["frm_job_suburb"].value + " Australia";

            validateAddress(address)
            return false;
        }
        /*
        var form = document.getElementById('jobForm');
        if (form.attachEvent) {
            form.attachEvent("submit", processForm);
        } else {
            form.addEventListener("submit", processForm);
        }*/



        <?if($job["job_id"]){?>
            //setInterval(updateTable,5000);
            function updateTable()
			{
				$("#communications").load("<?=app('url')?>/exec/communications/?frm_job_id=<?=$job["job_id"]?>",function()
				{
					//$("#sortTable1 tbody").html("");
					//$("#sortTable1 tbody").append($("#open").html()); 
					//$("#sortTable1").trigger("update"); 
				});
            }




        <?}?>
        
        
        //get the color of the select option on mouseover before the 'blue' default hover color.
        $('#frm_round_id').on('mouseover','option',function(e) {
            myVar = $(this).css("background-color");
        });

        
        //on click, change to the color
        $('#frm_round_id').on('click','option',function(e) {
            $('#frm_round_id').css("background-color",myVar);
        });
		
        if (<?=sess("auth_level")?> < 99){
			$('#1').css("display", "none");
			$('#2').css("display", "none");
			$('#3').css("display", "none");		
        }
        
        
        $("#jobForm").validate();
    });
</script>
