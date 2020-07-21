<?
    /*
        Add /Edit Rounds Form
        Version: 14.2.24
        Cody Joyce
    */
?>

<img src="<?=app('app_url')?>/images/icons/network_local.png" class="main_icon">
<h1>
<?=$values["round_id"] ? "Edit " : "Add New "?>
Round
</h1>
<p><a href="<?=app("url")?>/exec/rounds">Back to Rounds</a></p>
<form action="<?=app("url")?>/exec/rounds/action/" id="roundForm" name="roundForm">
    <input type="hidden" name="frm_round_id" id="round_id" value="<?=$values["round_id"]?>">
    <label>Name</label><input name="frm_round_name"  id="frm_round_name" value="<?=$values["round_name"]?>" class="required"><br>
    <label>Colour<div class="desc">Do not include the #</div></label><input name="frm_round_colour"  id="frm_round_colour" class="required" value="<?=$values["round_colour"]?>"><br>
    <label>Status id</label> <?parentListReq("frm_status_id","_status",$values["status_id"],"status_name","") ?><br>
    
    <label> </label><button id="formbutton">Submit</button>
</form>

<script>
    $(document).ready(function(){
        $("#roundForm").validate();
        
        $("#frm_round_colour").css("background-image","none");
        bgColor = "#"+$("#frm_round_colour").val();
        $("#frm_round_colour").css("background-color",bgColor); 
        
        $("#frm_round_colour").keyup(function(){
            $("#frm_round_colour").css("background-image","none");
            bgColor = "#"+$("#frm_round_colour").val();
            $("#frm_round_colour").css("background-color",bgColor); 
            
        })
    });
</script>