<h1>Menu Items</h1>

<p><a href="<?=app('url')?>/exec/menu/form/">Add new Menu Item</a></p>

<?pager()?>

<table id='sortTable' class='tablesorter' border='0'>
    <thead>
        <tr>
            <th>Name</th>
            <th>Class name</th>
            <th>Auth level</th>
            <th>Menu Order</th>
            <th>Target</th>
            <th>Parent</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <? while($row = mysqli_fetch_array($result)){?>
        <tr>
            <td><?=$row["menu_name"]?></td>
            <td><?=$row["class_name"]?></td>
            <td><?=$row["auth_level"]?></td>
            <td><?=$row["menu_order"]?></td>
            <td><?=$row["menu_target"]?></td>
            <td><?=$row["menu_parent"]?></td>
            <td><a href="<?=app('url')?>/exec/menu/form/?frm_menu_id=<?=$row["menu_id"]?>">Edit</a></td>
            <td><a href="<?=app('url')?>/exec/menu/delete/?frm_menu_id=<?=$row["menu_id"]?>" class="confirm">Delete</a></td>
        </tr>
    <? }?>
    </tbody>
</table>
