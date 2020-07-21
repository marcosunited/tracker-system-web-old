<h1>
    <?=$values["inventory_id"] ? "Edit " : "Create ";?>
    Item
</h1>
<p><a href="<?=app("url")?>/exec/inventory/">Back to Inventory List</a></p>
    
    <form action="<?=app("url")?>/exec/inventory/action/" id="inventoryForm" name="inventoryForm" enctype="multipart/form-data" method="post">
        <div class="left">
            
                <input type="hidden" name="frm_inventory_id" id="inventory_id" value="<?=$values["inventory_id"]?>">
                
                <label>Item name</label><input name="frm_inventory_item_name"  id="frm_inventory_item_name" value="<?=$values["inventory_item_name"]?>" class="required"><br>
                <label>No</label><input name="frm_inventory_no"  id="frm_inventory_no" value="<?=$values["inventory_no"]?>"><br>
                <label>Brand</label><input name="frm_inventory_brand"  id="frm_inventory_brand" value="<?=$values["inventory_brand"]?>" class="required"><br>
                <label>Supplier</label><?parentListReq('frm_supplier_id','suppliers',$values["supplier_id"],"supplier_name","")?><br>
                
                <label>Reorder details</label><input name="frm_inventory_reorder_details"  id="frm_inventory_reorder_details" value="<?=$values["inventory_reorder_details"]?>" class="required"><br>
                <label>Qty</label><input name="frm_inventory_qty"  id="frm_inventory_qty" value="<?=$values["inventory_qty"]?>" class="required"><br>
                <label>Warning qty</label><input name="frm_inventory_warning_qty"  id="frm_inventory_warning_qty" value="<?=$values["inventory_warning_qty"]?>" class="required"><br>
                <label>Photo</label><input type="file" name="file"  id="file"><br>
                <label>Shelf no</label><input name="frm_inventory_shelf_no"  id="frm_inventory_shelf_no" value="<?=$values["inventory_shelf_no"]?>" class="required"><br>
                
                <label> </label><button id="formbutton">Submit</button>
        </div>
        <div class="right">
            Additional Notes<br>
            <textarea name="frm_inventory_notes"  id="frm_inventory_notes" style="width:400px;height:200px;"><?=$values["inventory_notes"]?></textarea><br>
            <?if($values["inventory_photo"]){?>
                <h2>Photo</h2>
                <a href="<?=app('url')?>/app/uploads/<?=$values["inventory_photo"]?>"><img src="<?=app('url')?>/app/uploads/<?=$values["inventory_photo"]?>" width="250px" height="250px"></a>
            <?}?>
            <p></p>
            Barcode
            <img alt="<?=$values["inventory_id"]?>" src="<?=app('lib_url')?>/barcode.php?text=<?=$values["inventory_id"]?>&size=60">

       
        </div>
    </form>


<script>
    $(document).ready(function(){
          $("#inventoryForm").validate();
    });
</script>
