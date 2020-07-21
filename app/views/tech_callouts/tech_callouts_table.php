    <ul id="tester" data-role="listview">
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
    </ul>  
    <p></p>
    <button id="submit1" value="submit" data-theme="b">New Callout</button>
<script>
    function reloadCalls(){
        $("#tester").load("<?=app('url')?>/exec/tech_callouts/tabledata/",function(){
                $("#tester").listview("refresh");
        });
    }
    $(document).ready(function(){
        setInterval("reloadCalls()",5000);
        $("#submit1").click(function(){
            $(location).attr('href',"<?=app('url')?>/exec/tech_rounds/");
        });
    });
</script>

