<?
    function grapher($count,$dataArray) {
        echo "<table border='0' align='center'>";
        $colors = array(1 => 'black', 2 => '#145da1');
        $i=1;
        $x=1;
        foreach($dataArray as $postvar=>$value){
            $percent = round($value/$count*100);
            $height = 20 + $percent;
            
            echo "<td  height='30px' valign='bottom' align='center'>";
            echo "<div style='width:30px;height:{$height}px;background-color:$colors[$i];color:#ffffff;text-align:center;min-height:20px;'>$value</div> $x ";	
            echo "</td>";
            $i++;
            $x++;
            if($i==3)
                $i=1;
        }
        echo "<td width='50px'></td><td>";
        $x=1;
        foreach($dataArray as $postvar=>$value){
            echo "$x = $postvar <br>";
            $x++;
        }
        echo "</td>";
        echo "</tr>";
        echo "</table>";
    }
?>
