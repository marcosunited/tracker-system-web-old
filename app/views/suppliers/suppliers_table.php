<h1>Suppliers</h1>
<p>
<a href="<?=app('url')?>/exec/suppliers/form/">Add new supplier</a> | 
<a href="<?=app('url')?>/exec/inventory/">Back to Inventory</a>
</p>
<table id='sortTable' class='tablesorter' border='0'>
    <thead>
        <tr>
            <th>Name</th>
            <th>Address 1</th>
            <th>Address 2</th>
            <th>Suburb</th>
            <th>Attention</th>
            <th>Phone</th>
            <th>Fax</th>
            <th>Email</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <? while($row = mysqli_fetch_array($result)){?>
            <tr>
                <td><?=$row["supplier_name"]?></td>
                <td><?=$row["supplier_address_1"]?></td>
                <td><?=$row["supplier_address_2"]?></td>
                <td><?=$row["suburb_id"]?></td>
                <td><?=$row["supplier_attention"]?></td>
                <td><?=$row["supplier_phone"]?></td>
                <td><?=$row["supplier_fax"]?></td>
                <td><?=$row["supplier_email"]?></td>
                <td><a href="<?=app("url")?>/exec/suppliers/form/?frm_supplier_id=<?=$row["supplier_id"]?>">Edit</a></td>
            </tr>
        <? }?>
    </tbody>
</table>
