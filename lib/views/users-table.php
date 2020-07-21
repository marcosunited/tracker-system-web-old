<h1>Users</h1> 

<p><a href="<?=app('url')?>/exec/users/form/">Add new user</a></p>

<?pager()?>

<table id='sortTable' class='tablesorter' border='0'>
    <thead>
        <tr>
            <th>Username</th>
            <th>Password</th>
            <th>Realname</th>
            <th>Auth level</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <? while($row = mysqli_fetch_array($result)){?>
            <tr>
                <td><?=$row["username"]?></td>
                <td>*****</td>
                <td><?=$row["realname"]?></td>
                <td><?=$row["auth_level"]?></td>
                <td><a href="<?=app('url')?>/exec/users/form?frm_user_id=<?=$row["user_id"]?>">Edit</a></td>
                <td><a href="<?=app('url')?>/exec/users/delete?frm_user_id=<?=$row["user_id"]?>" class="confirm">Delete</a></td>
            </tr>
        <? }?>
    </tbody>
</table>

