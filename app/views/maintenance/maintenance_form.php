<img src="<?= app('app_url') ?>/images/icons/stock_cell-phone.png" class="main_icon">
<h1>
    <?= $values["technician_id"] ? "Edit " : "Create "; ?>
    Maintenance Visit
</h1>

<p>
    <a href="<?= app('url') ?>/exec/maintenance/">Back to Callouts</a> |
    <a href="<?= app('url') ?>/exec/maintenance/printPdf/?frm_maintenance_id=<?= $values['maintenance_id'] ?>" target="_blank">Print Maintenance Visit</a>
</p>
&nbsp;
<form action='<?= app("url") ?>/exec/maintenance/action/' id='maintenanceForm' name='maintenanceForm' method="post">
    <div style="float:left;width:640px;background-color:#f9f9f9;padding:10px;border:1px solid #ccc;">
        <h2>Job Details</h2>

        <input type='hidden' name='frm_maintenance_id' id='maintenance_id' value='<?= $values["maintenance_id"] ?>'>
        <label>Maintenance Date</label><input type="datetime-local" name='frm_maintenance_date' id='frm_maintenance_date' value='<?= $values["maintenance_date"] ?>'><br>
        <label>Job</label><input id="job_name" autocomplete="off">

        <select id="frm_job_id" name="frm_job_id" class="required">
            <option value="">SELECT</option>
            <?$result = query("select * from jobs where status_id = 1 order by job_address,job_address_number asc")?>
            <?while($row=mysqli_fetch_array($result)){?>
            <option <?if ($row["job_id"]==$values["job_id"]){?>
                SELECTED
                <?}?>
                value="<?= $row["job_id"] ?>"><?= $row["job_address_number"] ?> <?= $row["job_address"] ?>(<?= $row["job_name"] ?>)</option>
            <?}?>
        </select><br>

        <label>Technician</label>
        <?parentListReq("frm_technician_id","technicians",$values["technician_id"],"technician_name","where technicians.status_id = 1 order by technician_name ASC")?><br>

        <label>Invoice notes</label><textarea name="frm_invoice_notes" disabled readonly><?= $job['invoice_notes'] ?></textarea><br>

        <h2>Call Details</h2>
        <label>Lifts</label>

        <input style="opacity:0.0;width:0px;" id="liftcheck" class="required" <?if(req('frm_maintenance_id')){?>value='1'
        <?}?>>


        <!--Area to load LIFTS!-->
        <div id="liftsDiv" style="height:auto;">
            <?if($values["job_id"]){
                        //copy some of the values to REQUEST for easy passing to getLifts Function.
                        req("frm_job_id",$values["job_id"]);
                        req("frm_lift_names",$values["lift_ids"]);
                        
                        $callouts = new callouts();
                        $callouts->getLifts();
                    }?>
        </div>

        <label></label><button id='formbutton'>Submit</button>
    </div>
    <div style="margin-left:5px;float:left;width:550px;background-color:#dceeff;padding:10px;border:1px solid #ccc;">
        <h2>Tech Details</h2>
        <div id="jobMap"></div>

        <label>Docket No</label><input name="frm_docket_no" id="frm_docket_no" value="<?= $values['docket_no'] ?>"><br>

        <label>Order No</label><input name="frm_order_no" id="frm_order_no" value="<?= $values['order_no'] ?>"><br>

        <label>Time of arrival</label><input type="datetime-local" name='frm_maintenance_toa' id='frm_maintenance_toa' value='<?= $values["maintenance_toa"] ?>' class="required"><br>
        <label>Time of departure</label><input type="datetime-local" name='frm_maintenance_tod' id='frm_maintenance_tod' value='<?= $values["maintenance_tod"] ?>' class="required"><br>

        <label>Tasks Completed</label>


        <div style="margin-left:140px;">
            <?$x=1?>
            <?foreach($tasks as $task){?>
            <?
                            $checked="";
                            if(strstr($values['task_ids'],"|".$task['task_id']."|"))
                            $checked = "CHECKED";   
                        ?>
            <input <?= $checked ?> class='check liftcheck' type='checkbox' name='task_<?= $x ?>' value='<?= $task['task_id'] ?>'><?= $x ?>. <?= $task['task_name'] ?> <br>
            <?$x++?>
            <?}?>
        </div>


        <label>Technician Notes</label><textarea name="frm_maintenance_notes" id="frm_maintenance_notes" style="width:300px"><?= $values["maintenance_notes"] ?></textarea><br>
        <label>Schedule Next Visit</label><input name="schedule" id="schedule"><br>
        <label>Technicians Signature</label>

        <?if($values["technician_signature"] !=""){?>
        <img src="data:<?= $values["technician_signature"] ?>">
        <?}?>&nbsp;<br>
        <div class="clear"></div><br>
        <label>Customers Signature</label>
        <?if($values["customer_signature"] !=""){?>
        <img src="data:<?= $values["customer_signature"] ?>">
        <?}?>&nbsp;<br>
        <div class="clear"></div><br>
        <label></label><button id='formbutton'>Submit</button>
    </div>
</form>

<!--Hidden Divs to easily store information!-->
<div id="techId" style="visibility:hidden">

</div>
<div id="contactDetails" style="visibility:hidden">

</div>

<script>
    $(document).ready(function() {

        //show busy indicator
        function submitListener(event) {
            busyi = new busy_indicator(document.getElementById("busybox"),
                document.querySelector("#busybox div"));
            busyi.show();

            document.getElementById('maintenanceForm').submit();
            event.preventDefault();

        }
        const form = document.getElementById('maintenanceForm');
        form.addEventListener('submit', submitListener);

        //Check if the docket exists
        $('#frm_docket_no').on("change", function() {
            var frm_docket_number = $("#frm_docket_no").val();
            $.get('checkDocket?docket_number=' + frm_docket_number, function(data) {
                if (data == 1) {
                    alert("Docket Already Exists");
                }
            });
        });

        //$("#technician_signature").jSignature();

        $(".liftcheck").livequery("click", function(event, ui) {
            $("#liftcheck").val(1).change();
        });


        //set the focus on the job search when the page loads
        document.getElementById("job_name").focus();

        $('#schedule').datepicker({
            dateFormat: 'dd-mm-yy'
        });

        if (isMobile() == false) {
            $('#frm_maintenance_date').datepicker({
                dateFormat: 'dd-mm-yy'
            });
            $('#frm_maintenance_toa').datetimepicker({
                dateFormat: 'dd-mm-yy',
                timeFormat: 'HH:mm:ss',
                showSecond: false
            });
            $('#frm_maintenance_tod').datetimepicker({
                dateFormat: 'dd-mm-yy',
                timeFormat: 'HH:mm:ss',
                showSecond: false
            });
        }

        //enable form validation
        $('#maintenanceForm').validate();

        //What do do when the selected job changes, Update the 'Lifts DIV'
        $("#frm_job_id").change(function() {
            $("#job_name").val(null);
            jobChange();
        });

        //What do do when the selected job changes, Update the 'Lifts DIV'
        $("#frm_job_id").keyup(function() {
            $("#job_name").val(null);
            jobChange();
        });

        //keyup event for the search box,, Update the 'Lifts DIV'
        var timer;
        $("#job_name").on('keyup', function() {
            timer && clearTimeout(timer);
            timer = setTimeout(searchJobs, 400);
        });


        //Disable lift checking
        function disableLifts() {
            var checkboxes = $("input:checkbox");
            var i;
            for (i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].name.startsWith("lift")) {
                    checkboxes[i].disabled = true;
                }
            }
        }

        //loop thru each job in the select dropdown. If it matches the job_name search it will select it.
        //then run the jobChange function to update lifts DIV
        function searchJobs() {
            typedName = $("#job_name").val().toLowerCase();

            if (typedName.length >= 3) {
                $("#frm_job_id > option").each(function() {
                    optString = this.text.toLowerCase();
                    s = optString.search(typedName);
                    if (s >= 0) {
                        $("#frm_job_id").val(this.value);
                        //$("#job_name").val(optString);
                        //alert(optString);
                        jobChange();
                        return false;
                    }
                });
            } else {
                //$("#frm_job_id").val(null);
            }
        }

        //What do do when the selected job changes, Update the 'Lifts DIV'
        function jobChange() {
            if ($("#frm_job_id").val() != "") {
                //create the lift check boxes based on the selected job
                myURL = "<?= app('url') ?>/exec/callouts/getLifts/?frm_job_id=" + $("#frm_job_id").val();
                $("#liftsDiv").load(myURL, function() {});

                //here we will change the technician
                myURL = "<?= app('url') ?>/exec/callouts/getTech/?frm_job_id=" + $("#frm_job_id").val();
                $("#techId").load(myURL, function() {
                    $("#frm_technician_id").val($("#techId").html());
                });

                //contact details
                myURL = "<?= app('url') ?>/exec/callouts/getContact/?frm_job_id=" + $("#frm_job_id").val();
                $("#contactDetails").load(myURL, function() {
                    $("#frm_contact_details").val($("#contactDetails").html());
                });
            } else {
                $("#liftsDiv").html(null);
                $("#frm_technician_id").val(null);
                $("#contactDetails").val(null);
            }
        }

    });
</script>
