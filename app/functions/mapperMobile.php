<?
    /*
        Google Map Function, Provides a map with marker, along with a text inforbox for that marker.
        Version: 14.2.24
        Cody Joyce
    */
    
    function mapperMobile($lat,$long,$string)
    {
?>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
        <script>
            function initialize()
            {
                //set the latitude and longitude
                var myLatlng = new google.maps.LatLng(<?=$lat?>,<?=$long?>);

                //set the information for the marker
                var mystring = "<?=$string?>";
                var infowindow = new google.maps.InfoWindow({
                content: mystring
                });
                  
                //general map options
                var mapOptions = {
                zoom: 16,
                center: myLatlng
                }

                //init the map within the map-canvas div element
                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

                //put the marker down
                var marker = new google.maps.Marker({
                position: myLatlng,
                map: map
                });

                //add click event for the marker to show the infowindow
                google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
                });
            }

            google.maps.event.addDomListener(window, 'load', initialize);
        </script>

        <div id="map-canvas"></div>
        <style>
            #map-canvas{
                width:325px;
                height:250px;
            }
        </style>
<?
    }
?>