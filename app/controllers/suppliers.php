<?php
    $suppliers = new suppliers();
    class suppliers
    {
        function index()
        {
            $data = array(
                "result" => query("select * from suppliers")
            );			
            view("suppliers/suppliers_table",$data);
        }
        function form()
        {
            $data = array(
                "values" => _getValues("suppliers","supplier_id")
            );			
            view("suppliers/suppliers_form",$data);                                            
        }
        function action()
        {
                $url = app('url');
                $alert = _submitForm("suppliers","supplier_id");
                if(req("frm_supplier_id") != ''){ 					//if an id was specified, we must have done an update. go back to the item we just updated
                    redirect("$url/exec/suppliers/form/?alert=$alert&frm_supplier_id=".req("frm_supplier_id"));
                }else{ 													//no field id? then it must be a new record, lets go back to create another new record.
                    redirect("$url/exec/suppliers/?alert=$alert");
                }
        }
    }
?>