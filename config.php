<?php
	
    /*  
        Element Framework 
        Configuration File
    */
    
	//Overall Generic Application Vars
        $app["name"] = "Service Tracking";
        $app["version"] = "17.01.31";	 
        $root_folder = "/melbourne-tracker";
		
    /*Database Configuration Parameters*/
        $app["db_server"] = "localhost";
        $app["db_username"] = "root";
        $app["db_password"] = "Wdugags1";
        $app["db_database"] = "melbournemrs";

        
    //---------------Not really any need to edit below here--------------------------------
        
    /*Error reporting */
        error_reporting(E_ALL);
        setlocale(LC_MONETARY, 'en_AU');
        date_default_timezone_set('Australia/Melbourne');
		ini_set('display_errors', 'On');

        $library_folder = "/lib";
        $app_folder = "/app";
        $app["path"] = getcwd();	
        $app["url"]="http://".$_SERVER['HTTP_HOST'] . $root_folder;
    
    //Library Vars
        $app["lib_url"] = $app["url"] . $library_folder;
        $app["lib_path"] = $app["path"] . $library_folder;
    
    //App Vars
        $app["app_url"] = $app["url"] . $app_folder ;
        $app["app_path"] = $app["path"] . $app_folder ;
    
    //Template Vars
        $app["template_url"] = $app["url"] . $library_folder . "/template";
        $app["template_path"] = $app["path"] . $library_folder . "/template";
        
    //defaults if you need to change them
        $app['default_class'] = "login";
        $app['default_function'] = "index";
    
    //Doo da da da, Don't touch this!
        include ($app['lib_path']."/core.php");
?>
