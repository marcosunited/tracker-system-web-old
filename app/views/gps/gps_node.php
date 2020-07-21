<?
    /*
        Cody's GPS node. This script will update every 5 seconds and send off the current GPS details to the tracker, alongside a unique ID
        Version: 14.2.24
        Cody Joyce
    */
    
    //initialize the Element Framework javascript so we can do some ajax pushes
    js_init();
?>
    <h1>GPS Tracker Running</h1>
    
    <!--This div is what loads the ajax request as HTML, it remains hidden!-->
    <div id="nulldiv" style="width:0px;height:0px;"></div>
    
     <!--This div is where we show our update log. prefixing each time!-->
    <div id="updatediv" style="width:500px"></div>
    
    
<script>
    function getLocation()
    {
        if (navigator.geolocation)
        {
            navigator.geolocation.getCurrentPosition(showPosition);
        }
    }

    function showPosition(position)
    {
      //alert( position.coords.latitude + "," +position.coords.longitude);
      $loadString = "<?=app("url")?>/exec/gps/tracker/?user_id=<?=sess("user_id")?>&lat="+position.coords.latitude+"&long="+position.coords.longitude;
      $("#nulldiv").load($loadString,function(){
        $("#updatediv").html(Date()+" "+position.coords.latitude+" "+position.coords.longitude+"<br>"+$("#updatediv").html());
      });
    }


    // set interval
    var tid = setInterval(mycode, 5000);
    
    function mycode() {
        getLocation()
    }
    
    </script>

