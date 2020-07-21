<h1>Home</h1>

<p>Welcome: <?=sess("username")?></p>

<p>You have security level <?=sess("auth_level")?></p>

<a href="<?=app('url')?>/exec/login/doLogout/?>">Log Out</a>
