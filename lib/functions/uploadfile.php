<?
	/*
        Upload a file, just provide the as 'file' and run this function. Just provide the path to upload the file to.z
        14.2.22
    */
    function uploadFile($uploaddir){
		$uploadfile = $uploaddir . "/".basename($_FILES['file']['name']);
		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
			return basename($_FILES['file']['name']);
		} else {
			return null;
		}
    }
?>