
<div class="left">
    <h1>
        <?=$values["order_id"] ? "Edit " : "Create ";?>
        Order
    </h1>
    <p><a href="<?=app("url")?>/exec/orders/">Back to Orders</a></p>    
    <form action='<?=app("url")?>/exec/orders/action/' id='orderForm' name='orderForm'>
        <input type='hidden' name='frm_order_id' id='order_id' value='<?=$values["order_id"]?>'>
        
        <label>Supplier</label><?parentListReq('frm_supplier_id','suppliers',$values["supplier_id"],"supplier_name","")?><br>
        <label>Job no</label><input name='frm_job_no'  id='frm_job_no' value='<?=$values["job_no"]?>'><br>
        <label>Date</label><input name='frm_order_date'  id='frm_order_date' value='<?=$values["order_date"]?>'><br>
        <label>Comments</label><input name='frm_order_comments'  id='frm_order_comments' value='<?=$values["order_comments"]?>'><br>
        <label>Status id</label><?parentListReq('frm_order_status_id','_order_status',$values["order_status_id"],"order_status_name","")?><br>
        
        
        
        <label> </label><button id='formbutton'>Submit</button>
    </form>
</div>

<div class="right" id="order_items">
    <?if(req('frm_order_id')){?>
        <?$order_items = new order_items();?>
        <?$order_items->index()?>
    <?}?>
</div>

<script>
    $(document).ready(function(){
          $('#orderForm').validate();
          $("#frm_order_date").datepicker({ dateFormat: 'dd-mm-yy' });
    });
</script>
