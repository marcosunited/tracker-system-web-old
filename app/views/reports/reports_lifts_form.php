<h1>Generate a Lift Report</h1>

<form id="genForm" action="<?=app("url")?>/exec/reports/lifts_generate/" target="_blank">
    <label>Period Starting</label><input name="frm_start_date" id="frm_start_date" class="required"><br>
    <label>Period Ending</label><input name="frm_end_date" id="frm_end_date" class="required"><br>  
    <label>Show Round</label>
            <select name="frm_round_id" id="frm_round_id" style="color:#fff;background-image:none;background-color:#<?=$round['round_colour']?>">
                <option value="">SELECT</option>
                <?php while($round = mysqli_fetch_array($allRounds)){?>
                    <?if($tech['round_id'] != $round['round_id']){?>
                        <option style="background-color:#<?=$round['round_colour']?>" value="<?=$round['round_id']?>"><?=$round['round_name']?></option>
                    <?}?>
                <?}?>
            </select>
    <br>
    <label>Order Results By</label>
    <select name="frm_orderby">
        <option value="lift_count">Number of Lifts</option>
        <option value="call_count">Number of Callouts</option>
        <option value="call_average">Average Calls Per Unit</option>
    </select><br>
   <label>&nbsp;</label><button id='formbutton'>Generate Report</button>  
</form>

<script>
        $('#genForm').validate();

        $("#frm_start_date").datepicker({ dateFormat: 'dd-mm-yy' });
        $("#frm_end_date").datepicker({ dateFormat: 'dd-mm-yy' });

        //get the color of the select option on mouseover before the 'blue' default hover color.
        $('#frm_round_id').on('mouseover','option',function(e) {
            myVar = $(this).css("background-color");
        });
        
        //on click, change to the color
        $('#frm_round_id').on('click','option',function(e) {
            $('#frm_round_id').css("background-color",myVar);
        });        

</script>