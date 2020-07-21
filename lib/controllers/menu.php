<?php
    /*
        Menu's Screen Controller - The ability to add and edit menus from the app
        Cody Joyce
    */
    
    $menu = new menu();
    class menu
    {
        function index()
        {
            $data = array(
                "result" => query("select * from menu")
            );			
            view_core("menu_table",$data);    
        }
        function form()
        {
            $data = array(
                "values" => _getValues("menu","menu_id")
            );			
            view_core("menu_form",$data);    
        }
        function action()
        {
            $alert = _submitForm("menu","menu_id");
            if(req("frm_menu_id") != ''){
                redirect(app('url')."/exec/menu/form/?alert=$alert&frm_menu_id=".req("frm_menu_id"));
            }else{ 
                redirect(app('url')."/exec/menu/?alert=$alert");
            }    
        }
        function delete()
        {
            $menuid = req("frm_menu_id");
            $query = "delete from menu where menu_id = '$menuid'";
            query($query);
            redirect(app('url')."/exec/menu/?alert=Menu Item Deleted");
        }
    }
?>
