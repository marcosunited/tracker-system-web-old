<?
    $order_items = new order_items();
    class order_items
    {

        function index()
        {
            $query = "select * from order_items 
                        inner join inventory on order_items.inventory_id = inventory.inventory_id
                        where order_id=".req('frm_order_id');
            $result = query($query);
            $data = array(
                "result" => $result
            );
            view_plain("orders/order_items/order_items_table",$data);
        }
        function form()
        {
            $data = array(
                "values" => _getValues("order_items","order_item_id")
            );			
            view_plain("orders/order_items/order_items_form",$data);                                            
        }
        function action()
        {
            $url = app('url');
            $alert = _submitForm("order_items","order_item_id");
            if(req("frm_order_item_id") != ''){ 					//if an id was specified, we must have done an update. go back to the item we just updated
                redirect("$url/exec/order_items/form/?alert=$alert"."&frm_order_id=".req('frm_order_id'));
            }else{ 													//no field id? then it must be a new record, lets go back to create another new record.
                redirect("$url/exec/order_items/?alert=$alert"."&frm_order_id=".req('frm_order_id'));
            }
        }
        function delete()
        {
            $item_id = req('frm_order_item_id');
            $order_id = req('frm_order_id');
            
            $query = "delete from order_items where order_item_id = $item_id";
            query($query);
            redirect(app('url')."/exec/order_items/?frm_order_id=$order_id&alert=Item Deleted");
        }
    }
?>