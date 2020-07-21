<h1>
    <?=$values['username'] ? "Edit " : "Create ";?>
    User <?=$values['username'] ? ": ".$values['username'] : "";?>
</h1>

<p><a href="<?=app('url')?>/exec/users/">Back to users</a></p>

<form action="<?=app('url')?>/exec/users/action" id="userForm" name="userForm">
    <input type="hidden" name="formAction" value="submit">
    <input type="hidden" name="frm_user_id" id="user_id" value="<?=$values['user_id']?>">
    <label>Username</label><input name="frm_username"  id="frm_username" value="<?=$values['username']?>" class="required"><br>
    <label>Password</label><input name="frm_password"  id="frm_password" type="password" value="654321"><br>
    <label>Password</label><input name="frm_password1"  id="frm_password" type="password" value="123456"><br>
    <label>Realname</label><input name="frm_realname"  id="frm_realname" value="<?=$values['realname']?>" class="required"><br>
    <label>Auth level</label><input name="frm_auth_level"  id="frm_auth_level" value="<?=$values['auth_level']?>" class="required"><br>
    <label> </label><button id="formbutton">Submit</button>
</form>

<script>
    $(document).ready(function()
    {
        $("#userForm").validate();
    });
</script> 
