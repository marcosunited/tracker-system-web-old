    <ul id="tester" data-role="listview">
        <li data-role="list-divider">Maintenance</l1>
        <?foreach( $results as $row){?>
            <li><a href="<?=app('url')?>/exec/tech_maintenance/form/?frm_maintenance_id=<?=$row['maintenance_id']?>" rel="external"><?=toDate($row["maintenance_date"])?> - <?=$row["job_name"]?></a></li>
        <?}?>
    </ul>
    <p></p>
    <button id="submit1" value="submit" data-theme="a">New Maintenance Visit</button>
    <script>
        $(document).ready(function(){
            $("#submit1").click(function(){
                $(location).attr('href',"<?=app('url')?>/exec/tech_rounds/");
            });
        });
    </script>