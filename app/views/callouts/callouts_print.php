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
            <?=$callout["job_name"]?>
          </h2>
          <div class="address">
            <?=$callout["job_address_number"]?>
              <?=$callout["job_address"]?>
                <?=$callout["job_suburb"]?>
          </div>
          <div class="email">
          Contract No: <?=$callout["job_number"]?>
            </a>
          </div>
        </div>
        <div id="invoice">
          <h1>Callout:
            <?=$callout["callout_id"]?>
          </h1>
          <div class="date">Date of Call:
            <?=date(toDate($callout["callout_time"]))?>
            <?=toTime($callout["callout_time"])?>
          </div>
          <div class="date">Time of Arrival:
		    <?=date(toDate($callout["time_of_arrival"]))?>
            <?=toTime($callout["time_of_arrival"])?>
          </div>
		    <div class="date">Rectification Time:
		    <?=date(toDate($callout["rectification_time"]))?>
            <?=toTime($callout["rectification_time"])?>
          </div>
          <div class="date">Time of Departure:
            <?=date(toDate($callout["time_of_departure"]))?>
			<?=toTime($callout["time_of_departure"])?>
          </div>
        </div>
      </div>
      <table>
        <tr>
          <td colspan="2">
            <div style="border:0px solid black;height:300px;padding:10px;">
			
              <p>
                <b style="color:#0087C3">
                  <u>CALLOUTS DETAILS</u>
                </b>
              </p>

              <p>
                <b>Reported Fault (COMPLAINT): </b>
                <?=$callout["fault_name"]?>
              </p>
              <p>
                <b>For Lift(s): </b>
                <?=liftNames($callout["lift_ids"])?>
              </p>
			  
			  <b>For Floor(s):</b>
                <?=$callout["floor_no"]?>
              </p>


              <p>
                <b>Call Description:</b>
                <?=$callout["callout_description"]?>
              </p>
			   <p>
			   <b>Chargeable:</b>
                <?=$callout["chargeable_name"]?>
              </p>
			  
			   <b>Order Number:</b>
                <?=$callout["order_number"]?>

			
              <div style="height:1px;width:100%;background-color:#0087C3;margin-bottom:10px;"></div>
				
              <p>
                <b style="color:#0087C3">
                  <u>DESCRIPTION OF WORK</u>
                </b>
              </p>
              <p>
                <b>Fault Found (CAUSE):</b>
                <?=$callout["technician_fault_name"]?>
              </p>
              <p>
                <b>Work Action (CORRECTION):</b>
                <?=$callout["correction_name"]?>
              </p>
             
                <b>Work Description:</b>
                
                <?=$callout["tech_description"]?>
              </p>
              <p>
                <b>Part Required:</b>
                
                <?=$callout["part_description"]?>
              </p>
            </div>
          </td>
        </tr>
      </table>
      <table style="margin-top:80px;">
      <tr>
        <td style="width:300px">
            <p><b>Service Technician</b></p>
            <?=$callout["technician_name"]?>       
        </td>
        <td style="width:300px">
            <p><b>Reported Customer</b></p>
              <?=$callout["reported_customer"]?> 
        </td>  
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
	$dompdf->stream($callout["job_address"]."-".$callout["callout_id"].".pdf"); 
?>