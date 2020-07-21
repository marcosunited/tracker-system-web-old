<?	
    /*
        Redirect functions: Redirect to another URL. jredirect uses Javascript incase of prior headers being in the way. Not often used
        14.2.22
        Cody Joyce
    */
    function redirect($url){
		header('Location:'.$url);
	}
	
	function jredirect($url){
		echo "<script>";
		echo "window.location = '$url'";
		echo "</script>";
	}
?>