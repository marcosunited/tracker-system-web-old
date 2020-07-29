<?
    $disabled = "";
    $color ="";
    if($values["repair_id"] == ''){
            $disabled = "DISABLED";
            $color = "style='background-color:grey;'";
    }
    
?>
<img src="<?= app('app_url') ?>/images/icons/stock_cell-phone.png" class="main_icon">
<h1>
    <?= $values["technician_id"] ? "Edit " : "Create "; ?>
    Repair
</h1>

<p>
    <a href="<?= app('url') ?>/exec/repairs/">Back to Repairs</a> |
    <a href="<?= app('url') ?>/exec/repairs/printPdf/?frm_repair_id=<?= $values['repair_id'] ?>" target="_blank">Print repair</a>
</p>
&nbsp;
<form action='<?= app("url") ?>/exec/repairs/action/' id='repairForm' name='repairForm' method="post" enctype="multipart/form-data">
    <div style="float:left;width:640px;background-color:#f9f9f9;padding:10px;border:1px solid #ccc;">
        <h2>Job Details</h2>

        <input type='hidden' name='frm_repair_id' id='repair_id' value='<?= $values["repair_id"] ?>'>
        <label>Status</label>
        <?parentListReq("frm_repair_status_id","_repair_status",$values["repair_status_id"],"repair_status_name","")?><br>
        <label>Notice Time</label><input type="datetime-local" name='frm_repair_time' id='frm_repair_time' value='<?= $values["repair_time"] ?>'><br>
        <label>Job</label><input id="job_name" autocomplete="off">

        <select id="frm_job_id" name="frm_job_id" class="required">
            <option value="">SELECT</option>
            <?$result = query("select * from jobs where status_id = 1 order by job_address,job_address_number asc")?>
            <?while($row=mysqli_fetch_array($result)){?>
            <option <?if ($row["job_id"]==$values["job_id"]){?>
                SELECTED
                <?}?>
                value="<?= $row["job_id"] ?>"><?= $row["job_address_number"] ?> <?= $row["job_address"] ?> (<?= $row["job_name"] ?>)</option>
            <?}?>
        </select><br>

        <label>Technician</label>
        <?parentListReq("frm_technician_id","technicians",$values["technician_id"],"technician_name","where technicians.status_id = 1 order by technician_name ASC")?><br>

        <label>Invoice notes</label><textarea name="frm_invoice_notes" disabled readonly><?= $job['invoice_notes'] ?></textarea><br>

        <h2>Repair Details</h2>
        <label>Lifts</label>

        <input style="opacity:0.0;width:0px;" id="liftcheck" class="required" <?if(req('frm_repair_id')){?>value='11'
        <?}?>>


        <!--Area to load LIFTS!-->
        <div id="liftsDiv" style="height:auto">
            <?if($values["job_id"]){
                        //copy some of the values to REQUEST for easy passing to getLifts Function.
                        req("frm_job_id",$values["job_id"]);
                        req("frm_lift_names",$values["lift_ids"]);
                        
                        $repairs = new repairs();
                        $repairs->getLifts();
                    }?>
        </div>

        <div class="break"><br></div>

        <label>Quote No</label>
        <input name="frm_quote_no" id="frm_quote_no" value='<?= $values["quote_no"] ?>'><br>
        <label>File: </label><input type="file" name="file" id="file"><a href="<?= app('url') ?>/app/uploads/<?= $values["repair_attatch"] ?>">Download</a><br>
        <label>Order No</label>
        <input name="frm_order_no" id="frm_order_no" value='<?= $values["order_no"] ?>'><br>
        <label>Description </label><textarea name='frm_repair_description' id='frm_repair_description' style="width:455px"><?= $values["repair_description"] ?></textarea><br>
        <label>Chargeable</label>

        <?parentListReq("frm_chargeable_id","_chargeable",$values["chargeable_id"],"chargeable_name","")?>
        <br>

        <label>Parts Description:</label><textarea name="frm_parts_description" id="frm_parts_description" style="width:455px"><?= $values["parts_description"] ?></textarea><br>
        <label>Email Notification</label>
        <input name="frm_notify_email" id="frm_notify_email" value='<?= $values["notify_email"] ?>'><br>
        <label></label><button id='formbutton'>Submit</button>
    </div>
    <div style="margin-left:5px;float:left;width:550px;background-color:#ADFF2F;padding:10px;border:1px solid #ccc;">
        <h2>Tech Details</h2>
        <div id="jobMap"></div>
        <label>Time of arrival</label><input type="datetime-local" name='frm_time_of_arrival' id='frm_time_of_arrival' value='<?= $values["time_of_arrival"] ?>'><br>
        <label>Time of departure</label><input type="datetime-local" name='frm_time_of_departure' id='frm_time_of_departure' value='<?= $values["time_of_departure"] ?>'><br>

        <label>Parts Required</label><textarea name="frm_parts_required" id="frm_parts_required" style="width:300px"><?= $values["parts_required"] ?></textarea><br>


        <div class="clear"></div><br>
        <label></label><button id='formbutton'>Submit</button>
    </div>
</form>
<!--Hidden Divs to easily store information!-->
<div id="techId" style="visibility:hidden"></div>
<div id="contactDetails" style="visibility:hidden"></div>
<div id="notify" style="visibility:hidden"></div>

<script>
    $(document).ready(function() {
        //Check if the docket exists
        // $('#frm_docket_number').on("change",function(){
        //         var frm_docket_number = $("#frm_docket_number").val(); 
        //         $.get('checkDocket?docket_number='+frm_docket_number, function (data) {
        //                 if(data==1){
        //                         alert("Docket Already Exists");
        //                 }
        //         });
        // });        

        //$(".liftcheck").on("click",function(){
        //console.log("Lift Checked");
        //})

        $(".liftcheck").livequery("click", function(event, ui) {
            $("#liftcheck").val(1).change();
        });


        //set the focus on the job search when the page loads
        document.getElementById("job_name").focus();

        if (isMobile() === false) {
            $('#frm_repair_time').datetimepicker({
                dateFormat: 'dd-mm-yy',
                timeFormat: 'HH:mm:ss',
                showSecond: false
            });
            $('#frm_time_of_arrival').datetimepicker({
                dateFormat: 'dd-mm-yy',
                timeFormat: 'HH:mm:ss',
                showSecond: false
            });
            $('#frm_time_of_departure').datetimepicker({
                dateFormat: 'dd-mm-yy',
                timeFormat: 'HH:mm:ss',
                showSecond: false
            });
        }
        //enable form validation
        $('#repairForm').validate();

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
                myURL = "<?= app('url') ?>/exec/repairs/getLifts/?frm_job_id=" + $("#frm_job_id").val();
                $("#liftsDiv").load(myURL, function() {});

                //here we will change the technician
                myURL = "<?= app('url') ?>/exec/repairs/getTech/?frm_job_id=" + $("#frm_job_id").val();
                $("#techId").load(myURL, function() {
                    $("#frm_technician_id").val($("#techId").html());
                });

                //contact details
                myURL = "<?= app('url') ?>/exec/repairs/getContact/?frm_job_id=" + $("#frm_job_id").val();
                $("#contactDetails").load(myURL, function() {
                    $("#frm_contact_details").val($("#contactDetails").html());
                });

                //email address
                myURL = "<?= app('url') ?>/exec/repairs/getEmail/?frm_job_id=" + $("#frm_job_id").val();
                $("#contactDetails").load(myURL, function() {
                    $("#frm_notify_email").val($("#contactDetails").html());
                });

                //Instant Notification Checkbox
                myURL = "<?= app('url') ?>/exec/repairs/getNotify/?frm_job_id=" + $("#frm_job_id").val();
                $("#notify").load(myURL, function() {
                    if ($("#notify").html() > 0) {
                        $('#chk_notify').prop('checked', true);
                    } else {
                        $('#chk_notify').prop('checked', false);
                    }
                    $("#notify").html("");
                });
            } else {
                $("#liftsDiv").html(null);
                $("#frm_technician_id").val(null);
                $("#contactDetails").val(null);
            }
        }

    });
</script>