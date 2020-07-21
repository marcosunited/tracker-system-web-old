<?ob_start();?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Docket</title>
  </head>
  <style>

a {
  color: #0087C3;
  text-decoration: none;
}

body {
  position: relative;
  margin: 0 auto;
  color: #555555;
  background: #FFFFFF;
  font-family: Arial, sans-serif;
  font-size: 12px;
  font-family: SourceSansPro;
  width: 21cm;
  height: 29.7cm;
}

header {
  padding: 10px 0;
  margin-bottom: 20px;
  border-bottom: 1px solid #AAAAAA;
}

#logo {
  float: left;
}

#logo img {
  margin-top: 8px;
  float: left;
}

#company {
  text-align: right;
  margin-right: 80px;
  margin-top: 8px;
}


#details {
  margin-bottom: 50px;
}

#client {
  padding-left: 6px;
  border-left: 6px solid #0087C3;
  float: left;
}

#client .to {
  color: #777777;
}

h2.name {
  font-size: 1.4em;
  font-weight: normal;
  margin: 0;
}

#invoice {
  padding-right: 6px;
  text-align: right;
  margin-right: 80px;
}

#invoice h1 {
  color: #0087C3;
  font-size: 2.4em;
  line-height: 1em;
  font-weight: normal;
  margin: 0 0 10px 0;
}

#invoice .date {
  font-size: 1.1em;
  color: #777777;
}

#line {
  height: 1px;
  width: 100%;
  background-color: #0087C3;
  margin-bottom: 10px;
  position: absolute;
  bottom: 10px
}

fotter {
  position: absolute;
  bottom: 19px;
}
</style>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="<?=app('url')?>/app/images/logo.png">
      </div>
      <div id="company">
        <div>Unit 3 / 260 Hyde St YARRAVILLE VIC 3013
        </div>
        <div>03 9687 9099</div>
        <div>
          <a href="mailto:company@example.com">info@unitedlifts.com.au</a>
        </div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">Service Address:</div>
          <h2 class="name">
            <?=$repair["job_name"]?>
          </h2>
          <div class="address">
            <?=$repair["job_address_number"]?>
              <?=$repair["job_address"]?>
                <?=$repair["job_suburb"]?>
          </div>
          <div class="email">
          Contract No: <?=$repair["job_number"]?>
            </a>
          </div>
        </div>
        <div id="invoice">
          <h1>Repair ID:
            <?=$repair["repair_id"]?>
          </h1>
          <h2>Quote No:
            <?=$repair["quote_no"]?>
          </h2>
          <div class="date">Notice Time:
            <?=date(toDate($repair["repair_time"]))?>
            <?=toTime($repair["repair_time"])?>
          </div>
          <div class="date">Time of Arrival:
		    <?=date(toDate($repair["time_of_arrival"]))?>
            <?=toTime($repair["time_of_arrival"])?>
          </div>
          <div class="date">Time of Departure:
            <?=date(toDate($repair["time_of_departure"]))?>
			<?=toTime($repair["time_of_departure"])?>
          </div>
        </div>
      </div>
      <table>
        <tr>
          <td colspan="2">
            <div style="border:0px solid black;height:300px;padding:10px;">
			
              <p>
                <b style="color:#0087C3">
                  <u>Repairs DETAILS</u>
                </b>
              </p>
                <b>For Lift(s): </b>
                <?=liftNames($repair["lift_ids"])?>
              </p>
			  
              <p>
                <b>Repairs Description:</b>
                <?=$repair["repair_description"]?>
              </p>
			   <p>
			   <b>Chargeable:</b>
                <?=$repair["chargeable_name"]?>
              </p>
			  
			   <b>Order Number:</b>
                <?=$repair["order_no"]?>

			
              <div style="height:1px;width:100%;background-color:#0087C3;margin-bottom:10px;"></div>
				
              <p>
                <b style="color:#0087C3">
                  <u>DESCRIPTION OF WORK</u>
                </b>
              </p>
              <p>
                <b>Part Required:</b>
                
                <?=$repair["parts_description"]?>
              </p>
              <p>
                <b>Work Description:</b>
                
                <?=$repair["repair_description"]?>
              </p>
            </div>
          </td>
        </tr>
      </table>
      <table style="margin-top:80px;">
      <tr>
        <td style="width:300px">
            <p><b>Service Technician</b></p>
            <?=$repair["technician_name"]?>       
        </td>
        <!-- <td style="width:300px">
            <p><b>Reported Customer</b></p>
              <?=$repair["reported_customer"]?> 
        </td>   -->
        </tr>
      </table>
    </main>
    <div id="line"></div>
    <fotter>
      Thanks for choosing  United Lifts Services! 24 Hour Service, Phone 1300161740
    </fotter>
  </body>

  </html>
  <?
	$contents = ob_get_contents();
	ob_end_clean();
    
	require_once(app('lib_path')."/functions/dompdf/dompdf_config.inc.php");
	$dompdf = new DOMPDF();
	$dompdf->load_html($contents);
	$dompdf->render();
	$dompdf->stream($repair["job_address"]."-".$repair["repair_id"].".pdf"); 
?>