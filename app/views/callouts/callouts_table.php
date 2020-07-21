<?$callouts = new callouts();?>    
<div id="open" style="display:none"></div>
<div id="shutdowns" style="display:none"></div>
<div id="followups" style="display:none"></div>
<div id="repairs" style="display:none"></div>

<img src="<?=app('app_url')?>/images/icons/stock_cell-phone.png" class="main_icon">

<h1>All Open Callouts</h1>

<p><a href="<?=app('url')?>/exec/callouts/form/">Create a new callout</a></p>

<?pager()?>

<table id='sortTable'  class="tablesorter" border='0'>
    <thead>
        <tr>
            <th width="80px">Time</th>
            <th width="200px">Job Name</th>
			<th width="80px">Callout ID</th>
            <th>Address</th>
            <th width="150px">Reported Fault</th>
            <th width="50px">Lifts</th>
            <th width="100px">Technician</th>
            <th width="40px">Priority</th>
            <th width="100px">Status</th>
            <th width="120px"></th>
        </tr>
    </thead>
    <tbody>
        <? $callouts->open()?>
    </tbody>
</table>

<div style="width:600px;float:left">
    <h1>Follow Up Required</h1>
    <table id='sortTable2' border="1"  class='tablesorter2'>
        <thead>
            <tr>
                <th width="80px">Time</th>
                <th width="200px">Job Name</th>
                <th width="50px">Lifts</th>
                <th width="100px">Technician</th>
                <th width="120px"></th>
            </tr>
        </thead>
        <tbody>
            <? $callouts->followups()?>
        </tbody>
    </table>
</div>

<div style="width:600px;float:left;margin-left:10px;">
    <h1>Lifts Shut Down</h1>
    <table id='sortTable3' border="1" class='tablesorter2'>
        <thead>
            <tr>
                <th width="80px">Time</th>
                <th width="200px">Job Name</th>
                <th width="50px">Lifts</th>
                <th width="100px">Technician</th>
                <th width="120px"></th>
            </tr>
        </thead>
        <tbody>
            <? $callouts->shutdowns()?>
        </tbody>
    </table>
</div>

<div class="break"></div>

<div style="width:600px;float:left;">
    <h1>Under Repairs</h1>
    <table id='sortTable4'  border="1" class='tablesorter2'>
        <thead>
            <tr>
                <th width="80px">Time</th>
                <th width="200px">Job Name</th>
                <th width="50px">Lifts</th>
                <th width="100px">Technician</th>
                <th width="120px"></th>
            </tr>
        </thead>
        <tbody>
            <? $callouts->repairs()?>
        </tbody>
    </table>
</div>

<div style="width:600px;float:left;margin-left:10px;">
    <h1>Watch List</h1>
    <table id='sortTable5'  border="1" class='tablesorter2'>
        <thead>
            <tr>
                <th width="80px">Time</th>
                <th width="200px">Job Name</th>
                <th width="50px">Lifts</th>
                <th width="100px">Technician</th>
                <th width="120px"></th>
            </tr>
        </thead>
        <tbody>
            <? $callouts->watchlist()?>
        </tbody>
    </table>
</div>




<script>
    $(document).ready(function(){
        //update the tables every 10 seconds
        setInterval(updateTables,10000);
        
        function updateTables(){
                $("#open").load("<?=app('url')?>/exec/callouts/open",function()
                {
                    $("#sortTable1 tbody").html("");
                    $("#sortTable1 tbody").append($("#open").html()); 
                    $("#sortTable1").trigger("update"); 
                });
                
                $("#followups").load("<?=app('url')?>/exec/callouts/followups",function(){
                    $("#sortTable2 tbody").html("");
                    $("#sortTable2 tbody").append($("#followups").html()); 
                    $("#sortTable2").trigger("update");                  
                });
                
                $("#shutdowns").load("<?=app('url')?>/exec/callouts/shutdowns",function()
                {
                    $("#sortTable3 tbody").html("");
                    $("#sortTable3 tbody").append($("#shutdowns").html()); 
                    $("#sortTable3").trigger("update");                 
                }); 
                
                $("#repairs").load("<?=app('url')?>/exec/callouts/repairs",function()
                {
                    $("#sortTable4 tbody").html("");
                    $("#sortTable4 tbody").append($("#repairs").html()); 
                    $("#sortTable4").trigger("update");                 
                }); 
                
                $("#watchlist").load("<?=app('url')?>/exec/callouts/watchlist",function()
                {
                    $("#sortTable5 tbody").html("");
                    $("#sortTable5 tbody").append($("#repairs").html()); 
                    $("#sortTable5").trigger("update");                 
                }); 				
        }
    })
</script>
