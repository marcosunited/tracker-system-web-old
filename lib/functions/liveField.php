<?
    //The liveField function will provide live data to the screen. Say we want to show the status of a job. liveField will
    //continually update that field on the screen using AJAX and live data.
    
    function liveField($table,$field,$id_lookup)
    {
        $row = mysqli_fetch_array(query("SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'"));
        $id_field = $row["Column_name"];
        $row=mysqli_fetch_array(query("select $field from $table where $id_field = $id_lookup"));
        return $row["$field"];
    }
?>