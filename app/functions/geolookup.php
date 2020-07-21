<?php
    /*
        Google GeoLoocup Function, Supply a complete address as a test string and it will return 
        "Latitude Longitude" without quotes.
        Version 14.2.24
        Cody Joyce
    */
    
    function geolookup($string)
    {

        $string = str_replace (" ", "+", urlencode($string));
        $details_url ="https://maps.googleapis.com/maps/api/geocode/json?address=".$string."&key=AIzaSyApoWIL5n82jkYHO8lGc2SCPGhTNGUBhbU";
       

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch), true);

        // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
        if ($response['status'] != 'OK') {
        return "ERROR!";
        }

        //print_r($response);
        $geometry = $response['results'][0]['geometry'];

        $longitude = $geometry['location']['lat'];
        $latitude = $geometry['location']['lng'];

        $array = array(
            'latitude' => $geometry['location']['lng'],
            'longitude' => $geometry['location']['lat'],
            'location_type' => $geometry['location_type'],
        );

        return $latitude . " " . $longitude;
    } 
?>