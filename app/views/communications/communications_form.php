<h1>
    <?=$values["communication_id"] ? "Edit " : "Add New ";?>
    Communication <?=$values["communication_id"]? ": ".$values["communication_subject"] : "";?>
</h1>
<p><a href="<?=app("url")?>/exec/communications/?frm_job_id=<?=$job_id?>" class="ajaxlink" target="communications">Back to Communication</a></p>  
<form action="<?=app("url")?>/exec/communications/action" id="communicationForm" name="communicationForm" class="ajaxform" target="communications">
    <input type="hidden" name="frm_communication_id" id="communication_id" value="<?=$values["communication_id"]?>">
    <input type="hidden" name="frm_job_id" value="<?=$job_id?>">
    <input name="frm_user_id" type="hidden" id="frm_user_id" value="<?=sess("user_id")?>"><br>
    <label>Time</label><input name="frm_communication_time"  id="frm_communication_time" value="<?=$values["communication_time"]?>"><br>
    <label>Subject</label><input name="frm_communication_subject"  id="frm_communication_subject" value="<?=$values["communication_subject"]?>"><br>
    <label>Body</label>
       
        <?if(!$values['communication_id']){?><textarea style="width:40%;height:400px" name="frm_communication_body" id="frm_communication_body"><?}?>
            <?=$values["communication_body"]?>
        <?if(!$values['communication_id']){?></textarea><?}?><br>

    

    <label>&nbsp;</label><button id="formbutton">Submit</button>
</form>

<script>
    $(document).ready(function(){
            $(".ajaxform").validate({
                submitHandler: function(form) {
                $.post($(form).attr("action"), $(form).serialize(), function(return_data) {
                  $("#"+$(form).attr("target")).html(return_data);
                });                  
            }
            });
          
          $("#frm_communication_time").datetimepicker({ dateFormat: "dd-mm-yy",timeFormat:"HH:mm:ss",showSecond: true });
         // new nicEditor().panelInstance("frm_communication_body");
    });
</script>
