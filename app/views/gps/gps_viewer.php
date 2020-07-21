<?
    /*
        GPS Tracker Map Viewer
        14.2.24
        Cody Joyce
    */
?>
<!DOCTYPE html> 
<html> 
    <head> 
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> 
        <style type="text/css"> 
            html { height: 100% } 
            body { height: 100%; margin: 0; padding: 0 } 
            #map_canvas { height: 100% }
            #diag{height:100px;background-color:#666;display:none}
        </style> 
        <?js_init()?>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script> 
        <script type="text/javascript"> 

            var markers = [];

            // Standard google maps function 
            function init() 
            { 
                var myLatlng = new google.maps.LatLng(-37.8136, 144.9631);
                var myOptions = { 
                zoom: 5, 
                center: myLatlng, 
                mapTypeId: google.maps.MapTypeId.MAP
                } 
                map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
				
				var tid = setTimeout(mycode, 1000);
            } 

            // Function for adding a marker to the page. 
            function addMarker(note,lat,lon,image) 
            { 
                var infowindow = new google.maps.InfoWindow({maxWidth: 500,maxHeight:500});
                loc=new google.maps.LatLng(lat,lon)
                marker = new google.maps.Marker(
                { 
                    position: loc, 
                    // icon: "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2%7C"+colour,
                    icon: "<?=app('app_url')?>/images/"+image,
                    map: map
                });

				markers.push(marker);

                google.maps.event.addListener(marker, 'click', (function(marker, i) 
                {
                    return function() 
                    {
                        infowindow.setContent(note);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
	
            } 

            function getMarkers()
            {
                $("#diag").load("<?=app('url')?>/exec/gps/markers",function()
                {
                    myMarks = $("#diag").html().split(";");
                    for(i=0;i<myMarks.length;i++)
                    {
						myMark = myMarks[i].split(",");
                        addMarker(myMark[0],myMark[1],myMark[2],myMark[3]);
						console.log("Marker");
                    }            
                });
            }

            // Sets the map on all markers in the array.
            function setAllMap(map) 
            {
                for (var i = 0; i < markers.length; i++) 
                {
                    markers[i].setMap(map);
                }
            }

            // Removes the markers from the map, but keeps them in the array.
            function clearMarkers() 
            {
                setAllMap(null);
            }
            
            // Deletes all markers in the array by removing references to them.
            function deleteMarkers() 
            {
                clearMarkers();
                markers = [];
            }  
      

            
            function mycode() 
            {
                deleteMarkers();
                getMarkers();
                tid = setTimeout(mycode, 10000); // repeat myself
            }       
        </script> 
    </head> 
    <body onload="init()"> 
        <div id="map_canvas"></div> 
        <div id="diag"></div>
    </body> 
</html>
