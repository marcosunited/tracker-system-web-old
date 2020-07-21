<!DOCTYPE html> 
<html> 
<head> 
	<title>United Lifts</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"> 
	<meta name="mobile-web-app-capable" content="yes">
    
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
 
</head> 
    <body>

    <div data-role="page" id="callouts">    
        <div data-role="header">
            <h1>ULS Service Tracking</h1> 
            <?if(sess('auth_level')>0){?>
            <a href="<?=app('url')?>/exec/login/doLogout/" data-icon="check" class="ui-btn-right" rel="external">LogOff</a>
            <?}?>
            
        </div><!-- /header -->    
        <div data-role="navbar">
            <?menu()?>
        </div><!-- /navbar -->  
        <div data-role="content">
        <div id="new" style="display:none"></div>