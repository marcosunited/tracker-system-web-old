<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us" lang="en-us">
	<head>
		<title><?=app('name')?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0, "/>
        <link rel="shortcut icon" href="<?=app('app_url')?>/images/favicon.ico" type="image/x-icon" /> 
        <?css_init();?>
        <?js_init() //Run the init function to include stylesheet and scripts?>
    </head>
	<body>
		<div class="wrapper white">
			<a href="<?=app('url')?>"><img src="<?=app('app_url')?>/images/logo.png" style="margin:10px"></a>
            <div id="topbar">
                <b>Logged in as:</b> <?=sess("username")?>
                <a href="<?=app("url")?>/exec/login/doLogout/">Logout</a><p>
                <div style="absolute">
                    <form action="<?=app('url')?>/exec/search">
                        <label>Super Search:</label><input name='search'>
                    </form>
                </div>
            </div>
			<?menu(); // Initiate the Element Menu?>
            <div id="container">