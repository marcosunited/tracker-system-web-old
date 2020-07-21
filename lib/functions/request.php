<?
    /*
        Element Framework
        Request / Session Helper
        
        Easy, instead of having to type $_REQUEST['var_name'] we can just do req('var_name')
        saving on the finger acrobatics :)
        
        To assign a value to $_REQUEST['field_name'], just to req("field_name","value")
    */
    
    function req($myVar,$value=null)
    {
        if(isset($value))
        {
            if($value == ""){
                unset($_REQUEST[$myVar]);
            }else{
                $_REQUEST[$myVar] = $value;
            }
        }else
        {
            if(isset($_REQUEST[$myVar])){
                $string = mysqli_real_escape_string(db::$conn,$_REQUEST[$myVar]);
				$string = htmlspecialchars($string);
				return $string;
            }else{
                return null;
            }
        }
    }
    
    function sess($myVar,$value=null)
    {
        if(isset($value))
        {
            if($value == ""){
                unset($_SESSION[$myVar]);
            }else{
                $_SESSION[$myVar] = $value;
            }
        }else
        {
            if(isset($_SESSION[$myVar])){
                return $_SESSION[$myVar];
            }else{
                return null;
            }
        }
    }
?>
