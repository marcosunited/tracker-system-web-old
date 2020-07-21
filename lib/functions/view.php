<?
    /*
        Element Framework
        View header / footer functions for template/
    */
    
    //Normal View, showing HEADER -> INCLUDE -> FOOTER
    function view($inc,$data)
    {
        if(is_array($data))
            extract($data);
        
        //check if mobile
        $header = "header.php";
        $footer = "footer.php";
        if(is_mobile()){
            //$header = "touch-$header";
            //$footer = "touch-$footer";
        }
        
        include(app('template_path')."/$header");
        
        if(req("alert")){
            echo "<div class='alert'>".req("alert")."</div>";
            req('alert',''); //unset the alert so he cant bother anyone else
        }	        
        include(app('app_path')."/views/$inc.php");
        include(app('template_path')."/$footer");
    }
    
    //A special view for the core controllers and screens, as the $inc is in the library and not the custom app
    function view_core($inc,$data)
    {
        if(is_array($data))
            extract($data);
        
        //check if mobile
        $header = "header.php";
        $footer = "footer.php";
        if(is_mobile()){
            //$header = "touch-$header";
            //$footer = "touch-$footer";
        }
        
        include(app('template_path')."/$header");
        if(req("alert"))
            echo "<div class='alert'>".req("alert")."</div>";        
        include(app('lib_path')."/views/$inc.php");
        include(app('template_path')."/$footer");
    }	

    //view just the header
    function view_header()
    {
        //check if mobile
        $header = "header.php";
        $footer = "footer.php";
        if(is_mobile()){
            //$header = "touch-$header";
        }		
        include(app("template_path")."/$header");		
    }

    //view the footer
    function view_footer()
    {
        //check if mobile
        $footer = "footer.php";
        if(is_mobile()){
            //$footer = "touch-$footer";
        }	
        include(app("template_path")."/$footer");
    }

    //show page without templates or init JS
    function view_plain($inc,$data)
    {
        if(is_array($data))
            extract($data);
        
        if(req("alert"))
            echo "<div class='alert'>".req("alert")."</div>";    
            
        include(app('app_path')."/views/$inc.php");	
    }
?>