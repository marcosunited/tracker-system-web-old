<h1>
    <?=$values["order_item_id"] ? "Edit" : "Add New ";?>
    Order Item
</h1>

<a href="<?=app('url')?>/exec/order_items/?frm_order_id=<?=$values["order_id"]?>" class="ajaxlink" target="order_items">Back to Items</a>

<form action='<?=app("url")?>/exec/order_items/action' id='order_itemForm' name='order_itemForm' class="ajaxform" target="order_items">
    <input type='hidden' name='frm_order_item_id' id='order_item_id' value='<?=$values["order_item_id"]?>'>
    <input type="hidden" name='frm_order_id'  id='frm_order_id' value='<?=$values["order_id"]?>'>
   
    <label>Item</label><?parentListReq('frm_inventory_id','inventory',$values["inventory_id"],"inventory_item_name","")?><br>
    <label>Qty</label><input name='frm_order_item_qty'  id='frm_order_item_qty' value='<?=$values["order_item_qty"]?>' class="required"><br>
    <label>Cost Per Unit</label><input name='frm_order_item_cost'  id='frm_order_item_cost' value='<?=$values["order_item_cost"]?>' class="required"><br>
    <label> </label><button id='formbutton'>Submit</button>
</form>



<script>
    $(document).ready(function(){
          //$('#order_itemForm').validate();
    });
</script>
