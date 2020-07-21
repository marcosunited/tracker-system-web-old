<?
    include('config.php');
    
    if(sess('auth_level')>0){
        if(req('t'))
            $table=req('t');
        if(req('f'))
            $field=req('f');
        if(req('i'))
            $id_lookup=req('i');
            
        $row = mysqli_fetch_array(query("SHOW COLUMNS FROM $table"));
        $id_field = $row["Field"];
        

        $query = "select $field from $table where $id_field = $id_lookup";
        $row=mysqli_fetch_array(query($query));
        echo $row["$field"];
    }
?>