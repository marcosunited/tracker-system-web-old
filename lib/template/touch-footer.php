        
        </div>
    </body>
    <?if(sess('user_id')>0){?>
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
				$.get( $loadString, function( data ) {
				//alert( "Data Loaded: " + data );
				});
			}


			// set interval
			//var tid = setInterval(mycode, 30000);
			

			getLocation()

			
		</script>
    <?}?>
</html>



