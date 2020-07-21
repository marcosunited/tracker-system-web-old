<?
    /*
        Users Controller
        Cody Joyce
    */
    
    $users = new users();
    
    class users
    {
        function index()
        {
            $myauth = sess('auth_level');
            $data = array(
              "result" => query("select * from users where auth_level <= $myauth")
            );			
            view_core("users-table",$data);
        }
        function form()
        {
            $data = array(
              "result" => query("select * from users"),
              "values" => _getValues("users","user_id")
            );			
            view_core("users-form",$data); 
        }
        function action()
        {
            //if the passwords match, leave the password var intact so it can be changed. they don't match by default
            if(req("frm_password") != req("frm_password1")) 
            req("frm_password","");

            if(req("frm_password"))
            req("frm_password",md5(req("frm_password")));
            
            req("frm_password1",""); // we always unset this one as it does not exist in the table
            
            $alert = _submitForm("users","user_id");
           
            if(req("frm_user_id") != ''){ 					//if an id was specified, we must have done an update. go back to the item we just updated
                redirect(app('url')."/exec/users/form/?alert=$alert&frm_user_id=".req("frm_user_id"));
            }else{ 	//no field id? then it must be a new record, lets go back to create another new record.
                redirect(app('url')."/exec/users/?alert=$alert");
            }
        }
        function delete()
        {
            $user_id=req("frm_user_id");
            $query = "delete from users where user_id = $user_id";
            query($query);
            redirect(app('url')."/exec/users/?alert=User Deleted");
        }
    }
?>
