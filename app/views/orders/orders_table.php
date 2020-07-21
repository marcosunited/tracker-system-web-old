<?//generate("select * from orders","order_id","order","");?>

<h1>Orders</h1>
<p><a href="<?=app('url')?>/exec/orders/form/">Add New Order</a></a>
<?pager()?>
<table id='sortTable' class='tablesorter' border='0'>
    <thead>
        <tr>
        <th>Order to</th>
        <th>Job no</th>
        <th>Date</th>
        <th>Comments</th>
        <th>Status id</th>
        <th></th></tr>
    </thead>
    <tbody>
        <? while($row = mysqli_fetch_array($result)){?>
            <tr>
                <td><?=$row["supplier_name"]?></td>
                <td><?=$row["job_no"]?></td>
                <td><?=toDate($row["order_date"])?></td>
                <td><?=$row["order_comments"]?></td>
                <td><?=$row["order_status_name"]?></td>
                <td>
                    <a href="<?=app('url')?>/exec/orders/form/?frm_order_id=<?=$row["order_id"]?>">Edit</a> | 
                    <a href="<?=app('url')?>/exec/orders/printOrder/?frm_order_id=<?=$row["order_id"]?>">Print</a> | 
                    <a href="<?=app('url')?>/exec/orders/delete/?frm_order_id=<?=$row["order_id"]?>" class="confirm">Delete</a>
                </td>
            </tr>
        <? }?>
    </tbody>
</table>
