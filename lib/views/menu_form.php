<h1>
    <?=$values['menu_name'] ? "Edit " : "Create ";?>
    Menu Item <?=$values['menu_name'] ? ": ".$values['menu_name'] : "";?>
</h1>

<p><a href="<?=app('url')?>/exec/menu/">Back to Menus</a></p> 
   
<form action="<?=app('url')?>/exec/menu/action/" id="menuForm" name="menuForm">
    <input type="hidden" name="formAction" value="submit">
    <input type="hidden" name="frm_menu_id" id="menu_id" value="<?=$values['menu_id']?>">
    
    <label>Name</label><input name="frm_menu_name"  id="frm_menu_name" value="<?=$values['menu_name']?>" class="required"><br>
    <label>Class name</label><input name="frm_class_name"  id="frm_class_name" value="<?=$values['class_name']?>" class="required"><br>
    <label>Auth level</label><input name="frm_auth_level"  id="frm_auth_level" value="<?=$values['auth_level']?>" class="required"><br>
    <label>Menu Order</label><input name="frm_menu_order"  id="frm_menu_order" value="<?=$values['menu_order']?>" ><br>
    <label>Menu Target</label><input name="frm_menu_target"  id="frm_menu_target" value="<?=$values['menu_target']?>"><br>
    <label>Menu Parent</label><input name="frm_menu_parent"  id="frm_menu_parent" value="<?=$values['menu_parent']?>"><br>
    <label>&nbsp;</label><button id="formbutton">Submit</button>
</form>

<script>
    $(document).ready(function()
    {
        $("#menuForm").validate();
    });
</script>
