     <ul data-role="listview" data-theme="c">
        <li>
            Callout: <?=$values['job_address_number']?> <?=$values['job_address']?> <?=$values['job_suburb']?>
        </li>
        <li data-role="list-divider">
            Time Of Call: <?=$values['callout_time']?><br>
            Lifts: <?=liftNames($values['lift_ids'])?><br>
            Floor: <?=$values['floor_no']?><br>
            Fault: <?=$values['fault_name']?><br>
            Description: <?=$values["callout_description"]?>
        </li>
    </ul>
    
    <p></p>
    
    <form id="acceptForm" action="<?=app('url')?>/exec/tech_callouts/accept/" data-ajax="false">
        <input name="frm_callout_id" id="frm_callout_id" type="hidden" value="<?=$values["callout_id"]?>">
        <input name="frm_callout_accepted" id="frm_callout_accepted" type="hidden">
        <button id="submit1" value="submit" data-theme="a">I Accept</button>
        <button id="submit2" value="submit" data-theme="e">I Don't Accept</button>
    </form>
    
    <script>
        $(document).ready(function(){
            $("#submit1").click(function(){
                event.preventDefault();
                $("#frm_callout_accepted").val('1'); //accepted
                $("#acceptForm").submit();
            }); 
            $("#submit2").click(function(){
                event.preventDefault();
                $("#frm_callout_accepted").val('0'); //denied
                $("#acceptForm").submit();
            });                  
        });
    </script>