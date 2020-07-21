<ul data-role="listview">
    <li data-role="list-divider">
        <?=sess('username')?>'s Rounds
    </li>
</ul>
<br>&nbsp;<br>
<ul data-role="listview" data-filter="true">
    <?if(!req('all')){?>
    <li>
        <a href="<?=app('url')?>/exec/tech_rounds/?all=1" rel="external">Show Jobs from All Rounds</a>
    </li>
    <?}?>
    <?while($round = mysqli_fetch_array($rounds)){?>
        <li>
            <a href="<?=app('url')?>/exec/tech_rounds/form/?frm_job_id=<?=$round['job_id']?>" rel="external"><?=$round['job_address_number']?> <?=$round['job_address']?></a>
        </li>
    <?}?>
</ul>  


