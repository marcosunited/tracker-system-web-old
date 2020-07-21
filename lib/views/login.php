<h1><?=app('appname')?> Login</h1>

<form action="<?=app('url')?>/exec/login/doLogin" method="post" id="login" data-ajax="false">
    <label>Username: </label><input name="username" class="required"><br>
    <label>Password: </label><input name="password" type="password" class="required"><br>
    <label>&nbsp;</label><button>Login</button>
</form>

<script>
    $(document).ready(function(){
        $("#login").validate();
    });
</script>