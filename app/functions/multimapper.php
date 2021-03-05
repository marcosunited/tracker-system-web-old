<?
    /*
        Google Multimapper - Provides a full screen map with markers of all jobs provided in the array
        14.2.24
        Cody Joyce
    */
    
    function multimapper($jobs)
    {
?>
         <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApoWIL5n82jkYHO8lGc2SCPGhTNGUBhbU"
 type="text/javascript"></script>
		
        <div id="map-canvas" style="width: 100%; height: 100%;"></div>

        <script type="text/javascript">
            var locations = [
                <?while($job = mysqli_fetch_array($jobs)){?>
                    ["<?=$job["round_name"]?><br><?=$job["job_name"]?><br><?=$job["job_address"]?>", <?=$job["job_latitude"]?>, <?=$job["job_longitude"]?>,"<?=$job["round_colour"]?>"],
                <?}?>
            ];

            var map = new google.maps.Map(document.getElementById('map-canvas'), {
                zoom: 10,
                center: new google.maps.LatLng(-37.817416, 144.9588213),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow({maxWidth: 500,maxHeight:500});

            var marker, i;

            for (i = 0; i < locations.length; i++) {  
                
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    icon: "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2%7C"+locations[i][3],
                    shadow:"http://chart.apis.google.com/chart?chst=d_map_pin_shadow"

                });

                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
        </script>

<?
    }
?>