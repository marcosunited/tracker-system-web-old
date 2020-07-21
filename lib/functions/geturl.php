<?
    /*
        This will provide the URL of the current page we are on.
        14.2.22
        Cody Joyce
    */
    function geturl() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		return $pageURL;
	}
?>
