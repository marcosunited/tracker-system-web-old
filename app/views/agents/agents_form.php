<?
    /*
        Add / Edit Agents Form
        Version: 14.2.24
        Cody Joyce
    */
?>
<h1>
    <?=$values["agent_id"] ? "Edit " : "Create ";?>
    Agent
</h1>
<a href="<?=app("url")?>/exec/agents/">Back to Agents</a>
<form action="<?=app("url")?>/exec/agents/action" id="agentForm" name="agentForm">
    <input type="hidden" name="frm_agent_id"  id="frm_agent_id" value="<?=$values["agent_id"]?>">
    <label>Name</label><input name="frm_agent_name"  id="frm_agent_name" value="<?=$values["agent_name"]?>" class="required"><br>
    <label>Address</label><input name="frm_agent_address"  id="frm_agent_address" value="<?=$values["agent_address"]?>"><br>
    <label>Phone</label><input name="frm_agent_phone"  id="frm_agent_phone" value="<?=$values["agent_phone"]?>" class="required"><br>
    <label>Fax</label><input name="frm_agent_fax"  id="frm_agent_fax" value="<?=$values["agent_fax"]?>"><br>
    <label> </label><button id="formbutton">Submit</button>
</form>

<script>
    $(document).ready(function(){
          $("#agentForm").validate();
    });
</script>
