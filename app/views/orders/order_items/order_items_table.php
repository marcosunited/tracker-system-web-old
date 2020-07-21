
<h1>Order Items</h1>

<p><a href="<?=app('url')?>/exec/order_items/form/?frm_order_id=<?=req('frm_order_id')?>" class="ajaxlink" target="order_items">Add new Item</a></p>
<?pager()?>
<table id='sortTable' class='tablesorter' border='0'>
    <thead>
        <tr>
        <th>Item</th>
        <th>Qty</th>
        <th>Cost Per Unit</th>
        <th></th></tr>
    </thead>
    <tbody>
        <? while($row = mysqli_fetch_array($result)){?>
            <tr>
                <td><?=$row["inventory_item_name"]?></td>
                <td><?=$row["order_item_qty"]?></td>
                <td><?=$row["order_item_cost"]?></td>
                <td>
                    <a href="<?=app('url')?>/exec/order_items/form/?frm_order_item_id=<?=$row["order_item_id"]?>" class="ajaxlink" target="order_items">Edit</a> | 
                    <a href="<?=app('url')?>/exec/order_items/delete/?frm_order_item_id=<?=$row["order_item_id"]?>&frm_order_id=<?=$row['order_id']?>" class="ajaxlinkconfirm" target="order_items">Delete</a>
                </td>
            </tr>
        <? }?>
    </tbody>
</table>
