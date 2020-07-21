<?
    /*
        Element Framework
        SHow the main menu, generate a menu from the database. Alows us to add edit menus from the app itself.
        Version: 14.2.22
    */
        function menu($id=null,$count=0)
		{
			if($count == 0){
				echo "<ul id=\"testie\">\n";
			}else{
				echo "<ul>\n";
			}
			
			if($id==null){
				$query = "select * from menu where menu_parent is null OR menu_parent = 0 order by menu_order DESC";
			}else{
				$query = "select * from menu where menu_parent = $id";
			}
			
			$dashes = "";
			for($i=0;$i<$count;$i++){
					$dashes = $dashes . "-";
			}
			
			$results = query($query);
			if(sess('auth_level') == 0)
            echo "<li><a href='#' class='ui-btn-active ui-state-persist'>Login</a></li>";
            
			while($row = mysqli_fetch_array($results)){
				
				if($row["auth_level"] <= sess("auth_level") && $row["level_only"] == null)
				{
					$active = "";
                    $murl = "/exec/".$row["class_name"];
					
                    if (strstr($_SERVER['REQUEST_URI'],$murl)){
						$active =  " class='active' ";
                        if(is_mobile()){
                            $active =  " class='ui-btn-active ui-state-persist' ";
                        }
					}
                    
					echo "<li><a href=\"". app('url')."/exec/".$row["class_name"]."\" $active target=\"".$row["menu_target"]."\">" . $row["menu_name"]."</a>";
					
					//check to see if this has any kids
					$query = "select * from menu where menu_parent = " . $row["menu_id"];
					$kids = query($query);
					
					if(mysqli_num_rows($kids)>0)
					{
						$count = $count + 1;

						menu($row["menu_id"],$count);

					}
					
					echo "</li>\n";
				}
                if($row["level_only"] != null && sess("auth_level") == $row["level_only"] ){
					$active = "";
                    $murl = "/exec/".$row["class_name"];
					
                    if (strstr($_SERVER['REQUEST_URI'],$murl)){
						$active =  " class='active' ";
                        if(is_mobile()){
                            $active =  " class='ui-btn-active ui-state-persist' ";
                        }
					}
                    echo "<li><a href=\"". app('url')."/exec/".$row["class_name"]."\" $active target=\"".$row["menu_target"]."\">" . $row["menu_name"]."</a>";
                }
			}
			
			echo "</ul>";
        }    
?>