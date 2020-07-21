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
    serviceTechnician {
      position: absolute;
      bottom: 35px;
    }
    fotter {
      position: absolute;
      bottom: 19px;
    } 
  </style>

  <body>
  <header class="clearfix">
      <div id="logo">
       <? $fileLogo = $_SERVER['DOCUMENT_ROOT']."/melbourne-tracker/app/images/logo.png";?>
        <img src= <?=$fileLogo?> >    
      </div>
      <div id="company">
        <div>Unit 3 / 260 Hyde St YARRAVILLE VIC 3013
        </div>
        <div>(03) 9687 9099</div>
        <div>
          <a href="mailto:company@example.com">info@unitedlifts.com.au</a>
        </div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
      <div id="client">
          <div class="to"><b style="color:#0087C3">CUSTOMER DETAILS:</b> </div>
          <h2 class="name">
          <?=$visit["job_name"]?>
          </h2>
          <div class="address">
          <?=$visit["job_address_number"]?> <?=$visit["job_address"]?> <?=$visit["job_suburb"]?>
          </div>
          <div class="email">
            
              Contract No: <?=$visit["job_number"]?>
            </a>
          </div>
        </div>
        <div id="invoice">
          <h1>Maintenance#:
            <?=$visit["maintenance_id"]?>
          </h1>
          <div class="date">Date of Call:
          <?=toDate($visit["maintenance_toa"])?></p>
          </div>
          <div class="date">Time of Arrival:
          <?=toTime($visit["maintenance_toa"])?></p>
          </div>
          <div class="date">Time of Departure:
          <?=toTime($visit["maintenance_tod"])?></p>
          </div>
        </div>
      </div>
      
      <div style="border:0px solid black;height:300px;padding:10px;">
              <p>
                <b style="color:#0087C3">
                  <u>Maintenance Details</u>
                </b>
              </p>

              <p style="font-size:11px">
                <b>Maintenance Description: </b>
                <?=$visit["maintenance_notes"]?>
              </p>

      <div style="height:1px;width:100%;background-color:#0087C3;margin-bottom:10px;position:center;"></div>
				
      <div style="height:100px; overflow: auto;">

      <? 
                $totalTaskCount =0 ; //maybe we can use it for printing purpose
                $lift_type ="L";

                $lifts =  explode("|" , $visit['lift_ids']); // get_query("select * from lifts where job_id = $job_id");

                foreach($lifts as $lift)
                {
                   if( $visit['lift_id'] < 0 || $lift == '|'  || $lift == '' ||  $lift == null ) 
                       continue; // signed ones no need tp print
                  else 
                  {
                    ?>
                    <table width="50%" border="1" style="border-collapse:collapse">
                      <tr>
                        <th>Lift Number </th>   
                        <?                            
                            $liftsDB = get_query("select * from lifts where lift_id =".$lift ); 
                            $liftName = $liftsDB[0]["lift_name"];
                                                                           
                        ?>               
                        <th> <?=$liftName ?></th>                    
                      </tr>
                      <?
                  //Manual entry here because my brain is not fucking working today. Needs to be done tho
                  $tasks = trim($visit['task_ids'],"|");
                  $tasks = explode("|",$tasks);
                  $totalTaskCount = $totalTaskCount + count($tasks);
                  
                  
                  foreach($tasks as $task){       
                          if( $task == "|" || $task == ""  ) continue;                              
                          if( $visit['lift_id'] == null || $visit['lift_id'] == ""  ) //for old records
                              $task_name = get_query("select * from _new_tasks where task_id =".$task);                      
                          else if( $lift_type == "L" )
                              $task_name = get_query("select * from _lift_tasks where task_id =".$task);
                          else if( $lift_type == "E" ) 
                              $task_name = get_query("select * from _escalator_tasks where task_id =".$task);                      
                          else 
                              $task_name ="lift task could not be get";                      
                          
                      $task_name = $task_name[0];
                  ?>
                      <tr>
                          <td>
                          <?=$task_name["task_name"]?>
                          </td>
                            <td>
                            <?if (strstr($visit["lift_ids"],$lift)){?>
                                  Y     
                              <?}?>
                                                         
                            </td>                          
                        </tr>  
                        <?}?>           
                    </table>
                    <br>  
                    <?}?>                                
              <?} ?>
      </div> 
              
      </main>
    <div id="line"></div>
    <fotter>
      Thank you for choosing  United Lift Services 24 Hour Service, Phone (03)9687 9099    <b> Service Technician: </b> <?=$visit["technician_name"]?> <b> Customer Email:</b> <?=$visit["job_email"]?>
    </fotter>
  </body>

  </html>
  <?
	$contents = ob_get_contents();
	ob_end_clean();
    
	require_once $_SERVER['DOCUMENT_ROOT'].'/melbourne-tracker/dompdf/lib/html5lib/Parser.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/melbourne-tracker/dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/melbourne-tracker/dompdf/lib/php-svg-lib/src/autoload.php';
  require_once $_SERVER['DOCUMENT_ROOT'].'/melbourne-tracker/dompdf/src/Autoloader.php';
  
  Dompdf\Autoloader::register();
  
  use Dompdf\Dompdf;
  
  $dompdf = new Dompdf();
  
  $dompdf->loadHtml($contents);
  
  // (Optional) Setup the paper size and orientation
  $dompdf->setPaper('A4', 'landscape');
  $dompdf->render();
  $file_location = $_SERVER['DOCUMENT_ROOT']."/melbourne-tracker/pdfReports/".$visit["job_address"]."-".$visit["maintenance_id"].".pdf";
  
  $dompdf->stream($file_location) ;
  //file_put_contents($file_location, $dompdf->output());
  
  
?>
