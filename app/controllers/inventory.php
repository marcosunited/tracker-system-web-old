<?php
    $inventory = new inventory();
    class inventory
    {
        function index()
        {
            $data = array(
                "result" => query("select * from inventory
                                    inner join suppliers on inventory.supplier_id = suppliers.supplier_id
                ")
            );			
            view("inventory/inventory_table",$data);
        }
        
        
        function form()
        {
            $data = array(
                "values" => _getValues("inventory","inventory_id")
            );			
            view("inventory/inventory_form",$data);                                            
        }
        
        
        function reorder()
        {
            $inventory_id = req('frm_inventory_id'); 
            $query = "select * from inventory 
                        inner join suppliers on inventory.supplier_id = suppliers.supplier_id
                        inner join suburbs on suppliers.suburb_id = suburbs.suburb_id
            where inventory_id = $inventory_id"; 
            $results = mysqli_fetch_array(query($query));
            $data = array(
                "results" => $results
            );
            view_plain("inventory/inventory_reorder",$data);
        }
        
        
        function action()
        {
                $url = app('url');
                
                if($_FILES['file']){
                    if(uploadFile(app('app_path')."/uploads/")){
                        req("frm_inventory_photo",basename($_FILES['file']['name']));
                    }
                }

                $alert = _submitForm("inventory","inventory_id");
                
                if(req("frm_inventory_id") != ''){ 					//if an id was specified, we must have done an update. go back to the item we just updated
                    redirect("$url/exec/inventory/form/?alert=$alert&frm_inventory_id=".req("frm_inventory_id"));
                }else{ 													//no field id? then it must be a new record, lets go back to create another new record.
                    redirect("$url/exec/inventory/?alert=$alert");
                }
        }
        
        
        function delete(){
            $inventory_id = req('frm_inventory_id');
            query("delete from inventory where inventory_id = $inventory_id");
            redirect(app('url')."/exec/inventory/?alert=Inventory Item Deleted");
        }
    }
?>