<?php

    /*
            GPS Tracker
            Version: 14.2.24
            Cody Joyce
    */
    
    $gps = new gps();
    class gps
    {
        //Viewer: Displays a google map on screen and places markers at their location
        function index()
        {
			
			$then = time() - 3600;
            
			$query = "select * from gps_tracker 
            inner join users on gps_tracker.user_id = users.user_id
			order by id DESC"; 
            $locations = query($query);
            $data = array(
                "locations" => $locations
            );     
            view_plain("gps/gps_viewer",$data);
        }
        
        //Tracker Component: receives username, lat, long from the node device, and updates the database
        function tracker() 
        {
            $user_id = req("user_id");
            $myTime = time();
            $latitude = req("lat");
            $longitude = req("long");
            query("INSERT INTO gps_tracker (`log_time`, `user_id`, `latitude`, `longitude`) VALUES ('$myTime', '$user_id', '$latitude', '$longitude')");
        }
        
        //Markers: Provides the marker location in lat / long for all users
        function markers()
        {
            $myTime = time()-9999999999999;
			$query = "select distinct user_id from gps_tracker order by log_time DESC";
            $result = query($query);
            
            while($row = mysqli_fetch_array($result)){
                $user_id = $row["user_id"];
                
                $query = "select * from gps_tracker 
                            inner join users on gps_tracker.user_id = users.user_id
                            where gps_tracker.user_id = $user_id order by log_time DESC";
                $marker = mysqli_fetch_array(query($query));
                
				$username = $marker["username"] ." ".toDateTime($marker["log_time"]);
                $lat = $marker["latitude"];
                $long = $marker["longitude"];
                $image = $marker["image"];
                echo "$username,$lat,$long,$image;";
            }
        }
        
        //The Node: This is a little html5 app which received the Lat / long from the tracker component
        function node()
        {
            view_plain("gps/gps_node",null);
        }
    }
?>
