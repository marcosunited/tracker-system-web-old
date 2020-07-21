<table width="100%" border="1">
    <tr>
        <td valign="bottom" colspan="2"><h1>United Lift Services Pty Ltd</h1></td>
    </tr>
    <tr>
        <td>A.C.N. 082 477 658</td><td>ABN 81 082 447 658</td>
    </tr>
    <tr>
        <td valign="bottom"><b>Postal Address</b></td><td valign="bottom"><h1>PURCHASE ORDER</h1></td>
    </tr>
    <tr>
        <td valign="bottom">
            P.O BOX 645<br>
            YARRAVILLE VIC 3013<br>
            Ph: 03 9687 9099 - Fx: 03 9687 9094
        </td>
        <td style="text-align:right">
            <table style="float:right" border="1">
                <tr>
                    <td>ORDER No.</td><td><?=null?></td>
                </tr>
                <tr>
                    <td>JOB No.</td><td><?=null?></td>
                </tr>
                <tr>
                    <td>Date</td><td><?=date("D-M-y",time())?></td>
                </tr>
            </table>
        </td>
    </tr>        
</table>

<table width="100%" border="1">
    <tr>
        <td>
            <u>ORDER FROM</u><br>
            <?=$order['supplier_name']?><br>
            <?=$order['supplier_address_1']?><br>
            <?=$order['supplier_address_2']?> <?=$order['suburb_name']?>, <?=$order['suburb_state']?> <?=$order['suburb_postcode']?>
            <p></p>
            Attention: <?=$order['supplier_attention']?>By Fax: <?=$order['supplier_fax']?>
        </td>
    </tr>
    <tr>
        <td>
           <b>DELIVER TO: </b> <br>
           3/260 Hyde Street<br>
                            Yarraville VIC 3013
        </td>
    </tr>    
</table>

<table width="100%" border="1">
    <tr>
        <td>Qty</td>
        <td>Description</td>
        <td>Unit</td>
        <td>Total</td>
    </tr>
    <?while($item = mysqli_fetch_array($items)){?>
        <tr>
        <td><?=$item['order_item_qty']?></td>
        <td><?=$item['inventory_item_name']?></td>
        <td>Unit</td>
        <td>Total</td>
        </tr>
    <?}?>
</table>


