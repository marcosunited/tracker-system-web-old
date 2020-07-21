<h1>Inventory</h1>

<p>
    <a href="<?=app('url')?>/exec/inventory/form/">Add New Item</a> | 
    <a href="<?=app('url')?>/exec/suppliers/">Suppliers Details</a> | 
    <a href="<?=app('url')?>/exec/orders/form">Create Order</a>
</a>
<br>
<?pager()?>
<table id='sortTable' class='tablesorter' border='0'>
    <thead>
        <tr>
            <th>Item name</th>
            <th>No</th>
            <th>Brand</th>
            <th>Supplier</th>
            <th>Reorder details</th>
            <th>Qty</th>
            <th>Warning qty</th>
            <th>Photo</th>
            <th>Shelf no</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <? while($row = mysqli_fetch_array($result)){?>
            <tr
                <?if($row["inventory_qty"]<=$row["inventory_warning_qty"]){?>
                    bgcolor="#ffddd2"
                <?}?>
            >
                <td><?=$row["inventory_item_name"]?></td>
                <td><?=$row["inventory_no"]?></td>
                <td><?=$row["inventory_brand"]?></td>
                <td><?=$row["supplier_name"]?></td>
                <td><?=$row["inventory_reorder_details"]?></td>
                <td><?=$row["inventory_qty"]?></td>
                <td><?=$row["inventory_warning_qty"]?></td>
                <td><a href="<?=app('url')?>/app/uploads/<?=$row["inventory_photo"]?>"><img src="<?=app('url')?>/app/uploads/<?=$row["inventory_photo"]?>" width="50px" height="50px"></a></td>
                <td><?=$row["inventory_shelf_no"]?></td>
                <td>
                    <a href="<?=app("url")?>/exec/inventory/form/?frm_inventory_id=<?=$row["inventory_id"]?>">Edit</a> | 
                    <a href="<?=app("url")?>/exec/inventory/delete/?frm_inventory_id=<?=$row["inventory_id"]?>" class='confirm'>Delete</a><br>
                </td>
            </tr>
        <? }?>
    </tbody>
</table>
