<?
    /*
        Init Function: Load all the javascript and CSS we need for the element framework.
        Cody Joyce
        
        Note that jquery mobile is not included on this init because of the additional load time. 
        It must be included manually if you wish to use it.
    */
    
    function js_init(){
        //to make inserting the variables easier, I will give them a direct name now
        $url = app("lib_url");
        
        $appurl = app("app_url");
            echo "
            <script src='$url/scripts/jquery-2.1.0.min.js'></script>
            <script src='$url/scripts/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js'></script>		
            <script src='$url/scripts/jquery.livequery.min.js'></script>
            <script src='$url/scripts/tablesorter/js/jquery.tablesorter.min.js'></script>
            <script src='$url/scripts/tablesorter/js/jquery.tablesorter.widgets.min.js'></script>
            <script src='$url/scripts/tablesorter/addons/pager/jquery.tablesorter.pager.min.js'></script> 		
            <script src='$url/scripts/jquery.validate.min.js'></script>
            <script src='$url/scripts/jquery-ui-timepicker-addon.js'></script>
            <script src='$url/scripts/mousetrap.min.js'></script>
            <script src='$url/scripts/core.js'></script>
            <script src='$appurl/scripts/jSignature/jSignature.min.js'></script>            
            ";
    }
    function css_init(){
        //to make inserting the variables easier, I will give them a direct name now
        $url = app("lib_url");
        $appurl = app("app_url");
        $template_url = app("template_url");
            echo "      
                <link rel='stylesheet' href='$url/scripts/jquery-ui-1.10.4/themes/base/jquery-ui.css' type='text/css'/>
                <link rel='stylesheet' href='$url/scripts/tablesorter/css/theme.ice.css' type='text/css' />
                <link rel='stylesheet' href='$url/scripts/jquery-ui-timepicker-addon.css' type='text/css' media='screen' />	
                <link rel='stylesheet' href='$template_url/style.css' type='text/css' media='screen' />
            ";
    }    
?>
