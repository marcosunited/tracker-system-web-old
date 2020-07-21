<?
    $orders = new orders();
    class orders{

        function index()
        {
            $data = array(
                "result" => query("select * from orders
                                    inner join suppliers on orders.supplier_id = suppliers.supplier_id
                                    inner join _order_status where orders.order_status_id = _order_status.order_status_id
                ")
            );			
            view("orders/orders_table",$data);
        }
        function form()
        {
            $values = _getValues("orders","order_id");
            
            if($values['order_date']){
                $values['order_date'] = toDate($values['order_date']);
            }else{
                $values['order_date'] = toDate(time());
            }
                
            $data = array(
                "values" => $values
            );			
            view("orders/orders_form",$data);                                            
        }
        function action()
        {
            $url = app('url');
            
            if(req('frm_order_date')){
                req('frm_order_date',strtotime(req('frm_order_date')));
            }
            
            $alert = _submitForm("orders","order_id");
            
            $neworder = mysqli_fetch_array(query("select order_id from orders order by order_id DESC"));
            
            if(req("frm_order_id")){ 		//if an id was specified, we must have done an update. go back to the item we just updated
                redirect("$url/exec/orders/form/?alert=$alert&frm_order_id=".req("frm_order_id"));
            }else{ 		
                redirect("$url/exec/orders/form/?alert=$alert&frm_order_id=".$neworder['order_id']);
            }
        }
        function printOrder()
        {
            $id = req("frm_order_id");
            $query = "select * from orders 
                        inner join suppliers on orders.supplier_id = suppliers.supplier_id
                        inner join suburbs on suppliers.suburb_id = suburbs.suburb_id
                        where order_id = $id"; 
            $order = mysqli_fetch_array(query($query));
            
            $query = "select * from order_items 
                        inner join inventory on order_items.inventory_id = inventory.inventory_id
                        where order_id = $id";
            $items = query($query);
            
            $data = array(
                "order" => $order,
                "items" => $items
            );
            view("orders/orders_print",$data);
        }
        function delete()
        {
            $id = req('frm_order_id');
            $query = "delete from orders where order_id = $id";
            query($query);
            redirect(app('url')."/exec/orders/?alert=Order Deleted");
        }        
    }
?>