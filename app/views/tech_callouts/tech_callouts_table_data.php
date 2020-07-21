
    
        <li data-role="list-divider"><?=sess('realname')?>'s Callouts - Open Callouts</li>  
        <?while($row = mysqli_fetch_array($openresults)){?>
            <li>
                <a href="<?=app('url')?>/exec/tech_callouts/form/?frm_callout_id=<?=$row["callout_id"]?>" rel="external"><?=$row["job_address_number"]?> <?=$row["job_address"]?>, <?=$row["job_suburb"]?>
                    <?if($row['accepted_id']==1){?>
                     - <span style="color:green">Accepted</a>
                    <?}else{?>
                     - <span style="color:red">Awaiting Action</a>
                    <?}?>
                </a>
            </li>
        <?}?>
    


