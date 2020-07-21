<?
    /*
        Add / Edit Technician
        Cody Joyce
    */
?>
<h1>
    <?=$values["technician_id"] ? "Edit" : "Add New ";?>
    Technician
</h1>
<a href="<?=app("url")?>/exec/technicians/">Back to Technicians</a>
<form action="<?=app("url")?>/exec/technicians/action" id="technicianForm" name="technicianForm">
    <input type="hidden" name="frm_technician_id" id="technician_id" value="<?=$values["technician_id"]?>">
    <label>Name</label><input name="frm_technician_name"  id="frm_technician_name" value="<?=$values["technician_name"]?>" class="required"><br>
    <label>Phone</label><input name="frm_technician_phone"  id="frm_technician_phone" value="<?=$values["technician_phone"]?>"  class="required"><br>
    <label>Email</label><input name="frm_technician_email"  id="frm_technician_email" value="<?=$values["technician_email"]?>"><br>
    <label>Colour</label><input name="frm_technician_colour"  id="frm_technician_colour" value="<?=$values["technician_colour"]?>"><br>
    <label>Round id</label>
    
                <select name="frm_round_id" id="frm_round_id" style="color:#fff;background-image:none;background-color:#<?=$round["round_colour"]?>">
                <option  value="<?=$round["round_id"]?>"><?=$round["round_name"]?></option>
                <?php while($round = mysqli_fetch_array($allRounds)){?>
                    <?if($tech["round_id"] != $round["round_id"]){?>
                        <option style="background-color:#<?=$round["round_colour"]?>" value="<?=$round["round_id"]?>"><?=$round["round_name"]?></option>
                    <?}?>
                <?}?>
            </select><br>
    
    <label>Status id</label><?parentListReq("frm_status_id","_status",$values["status_id"],"status_name","")?><br>
    <label> </label><button id="formbutton">Submit</button>
</form>
<script>
    $(document).ready(function()
    {
        $("#technicianForm").validate();
        
        //get the color of the select option on mouseover before the "blue" default hover color.
        $("#frm_round_id").on("mouseover","option",function(e) {
            myVar = $(this).css("background-color");
        });
        
        //on click, change to the color
        $("#frm_round_id").on("click","option",function(e) {
            $("#frm_round_id").css("background-color",myVar);
        });        
    });
</script>
