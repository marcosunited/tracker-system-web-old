<? js_init();?>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/1.10.13/sorting/date-dd-MMM-yyyy.js"></script>
<div id="topbar">
    <a href="#" id="printPdf">Print As PDF</a>
</div>
<button id="hide" class="noprint">Hide Maintenance</button>
<button id="show" class="noprint">Show Maintenance</button>
<div id="printArea" contenteditable="true">
    <div id="logo">
        <img src="<?= app('app_url') ?>/images/logobig.png" align="center" width="400">
    </div>

    <table width="100%" border="0">
        <tr>
            <td class="postal">A.C.N 082 447 658</td>
            <td class="postal">ABN 81 082 447 658</td>
            <td class="postal">
                <div style="">
                    Postal Address:<br> P.O.Box 280<br> KEW VIC 3101<br> Telephone: 9687 9099<br> Facsimile: 9687 9094
                </div>
            </td>
        </tr>
    </table>

    <h1>Site Report: <?= $job["job_name"] ?></h1>

    <table width="100%" border="1" style="border-collapse:collapse">
        <tr>
            <td><strong>TO:</strong></td>
            <td>
                <?= $agent["agent_name"] ?>
            </td>
            <td><strong>Fax No.:</strong></td>
            <td>
                <?= $agent["agent_fax"] ?>
            </td>
        </tr>
        <tr>
            <td><strong>Attention:</strong></td>
            <td>
                <?= $agent["agent_phone"] ?>
            </td>
            <td><strong>No. Of pages:</strong></td>
            <td>One</td>
        </tr>
        <tr>
            <td><strong>C.c.:</strong></td>
            <td></td>
            <td><strong>Date:</strong></td>
            <td>
                <?= date("d/m/Y", time()) ?>
            </td>
        </tr>
        <tr>
            <td><strong>From:</strong></td>
            <td>Barry Denner</td>
            <td><strong>Our Ref:</strong></td>
            <td></td>
        </tr>
        <tr>
            <td><strong>Subject:</strong></td>
            <td>Monthly Reports</td>
            <td><strong>Premises:</strong></td>
            <td>
                <?= $job["job_address"] ?>
            </td>
        </tr>
    </table>

    <div id="disclaimer">
        This document is confidential. It is intended exclusively for the use of the addressee. Any form of disclosure is unauthorised. Please advise the sender if you recieve this in error. Your reasonable cost in advising us of the error will be reimbursed.
    </div>

    <div id="dear">
        Dear
        <?= $job["job_contact_details"] ?>,
        <p>Please find detailed below a list of the calls and routine maintenance we attended between <b><?= date("d/M/Y", $start_date) ?></b> and <b><?= date("d/M/Y", $end_date) ?></b>.</p>
    </div>

    <div style="text-align:center;margin:10px;">
        <h1>Callouts</h1>
    </div>
    <div style="text-align:center;margin:10px;">
        <b>Period Starting:</b>
        <?= req("frm_start_date") ?> <b>Till</b>
        <?= req("frm_end_date") ?>
    </div>

    <?grapher(count($callouts),$faults)?>

    <table width="95%" border="1" style="border-collapse:collapse" id="table-g" cellspacing="0">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time of Call</th>
                <th>Arrived</th>
                <th>Finished</th>
                <th>Job No</th>
                <th>Site Name</th>
                <th>Lift Names</th>
                <th>Order Number</th>
                <th>Docket No</th>
                <th>Call Description</th>
                <th>Tech Fault</th>

                <?if(req('advanced')){?>
                <th>Tech Description</th>
                <?}?>

                <th>Technician</th>
                <th>Response Time Exceeded</th>
            </tr>
        </thead>
        <tbody>
            <?foreach($callouts as $callout){?>
            <tr>
                <td>
                    <?= toDate($callout["callout_time"]) ?>
                </td>
                <td>
                    <?= toTime($callout["callout_time"]) ?>
                </td>

                <td>
                    <?= toTime($callout["time_of_arrival"]) ?>
                </td>
                <td>
                    <?= toTime($callout["time_of_departure"]) ?>
                </td>
                <td>
                    <?= $callout["job_number"] ?>
                </td>
                <td>
                    <?= $callout["job_name"] ?>
                </td>
                <td>
                    <?= liftNames($callout["lift_ids"]) ?>
                </td>
                <td>
                    <?= $callout["order_number"] ?>&nbsp;</td>
                <td>
                    <?= $callout["docket_number"] ?>
                </td>
                <td>
                    <?= $callout["fault_name"] ?>&nbsp;</td>

                <td>

                    <?= $callout["technician_fault_name"] ?>&nbsp;
                </td>
                <?if(req('advanced')){?>
                <td>
                    <?= $callout["tech_description"] ?>
                </td>
                <?}?>

                <td>
                    <?= $callout["technician_name"] ?>
                </td>
                <td>
                    <?timeExceeded($callout["fault_name"],$callout["callout_time"],$callout["time_of_arrival"])?>
                </td>
            </tr>
            <?}?>
        </tbody>
    </table>

    <h1 id="maintenance">Maintenance</h1>
    <table width="95%" border="1" style="border-collapse:collapse" id="maintable2">
        <thead>
            <tr>
                <th>Date</th>

                <th>Job No</th>
                <th>Job Address</th>
                <th>Lifts</th>
                <th>Technician</th>
                <th>Tech Notes</th>
                <th>Area Serviced</th>
                <th>Service Type</th>

            </tr>
        </thead>
        <tbody>
            <?foreach ($maintenances as $row){?>
            <tr>
                <td>
                    <?= toDate($row["maintenance_date"]) ?>
                </td>
                <td>
                    <?= $row["job_number"] ?>
                </td>

                <td>
                    <?= $row["job_name"] ?>
                </td>
                <td>
                    <?= liftNames($row["lift_ids"]) ?>
                </td>
                <td>
                    <?= $row["technician_name"] ?>
                </td>
                <td>
                    <?= $row["maintenance_notes"] ?>
                </td>
                <td>
                    General
                </td>
                <td>
                    General
                </td>


            </tr>
            <? }?>
        </tbody>
    </table>
    <h1 id="maintenance">Repair</h1>
    <table width="95%" border="1" style="border-collapse:collapse" cellspacing="0" id="maintable3">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time of Repair</th>
                <th>Arrived</th>
                <th>Finished</th>
                <th>Job No</th>
                <th>Site Name</th>
                <th>Lift Names</th>
                <th>Quote Number</th>
                <th>Order Number</th>

            </tr>
        </thead>
        <tbody>
            <?foreach($repairs as $repair){?>
            <tr>
                <td>
                    <?= toDate($repair["repair_time"]) ?>
                </td>
                <td>
                    <?= toTime($repair["repair_time"]) ?>
                </td>

                <td>
                    <?= toTime($repair["time_of_arrival"]) ?>
                </td>
                <td>
                    <?= toTime($repair["time_of_departure"]) ?>
                </td>
                <td>
                    <?= $repair["job_number"] ?>
                </td>
                <td>
                    <?= $repair["job_name"] ?>
                </td>
                <td>
                    <?= liftNames($repair["lift_ids"]) ?>
                </td>
                <td>
                    <?= $repair["quote_no"] ?>&nbsp;</td>
                <td>
                    <?= $repair["order_no"] ?>
                </td>

            </tr>
            <?}?>
        </tbody>
    </table>
    <style>
        body {
            margin: 0px;
            font-size: 12px;
        }

        td {
            font-size: 12px;
            text-align: center;
        }

        th {
            font-weight: bold;
            font-size: 12px;
        }

        * {
            font-family: sans-serif;
        }

        #topbar,
        #topbar a {
            background-color: blue;
            color: #fff;
            padding: 5px;
            background: #7abcff;
            /* Old browsers */
            background: -moz-linear-gradient(top, #7abcff 0%, #60abf8 44%, #4096ee 100%);
            /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #7abcff), color-stop(44%, #60abf8), color-stop(100%, #4096ee));
            /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top, #7abcff 0%, #60abf8 44%, #4096ee 100%);
            /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top, #7abcff 0%, #60abf8 44%, #4096ee 100%);
            /* Opera 11.10+ */
            background: -ms-linear-gradient(top, #7abcff 0%, #60abf8 44%, #4096ee 100%);
            /* IE10+ */
            background: linear-gradient(to bottom, #7abcff 0%, #60abf8 44%, #4096ee 100%);
            /* W3C */
            filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#7abcff', endColorstr='#4096ee', GradientType=0);
            /* IE6-9 */
        }

        #logo {
            text-align: center;
            padding: 10px;
        }

        #disclaimer {
            padding-top: 10px;
        }

        #dear {
            padding-bottom: 10px;
        }

        .postal {
            font-weight: bold;
            text-align: center;
            vertical-align: top;
        }

        .address {
            width: 200px;
            text-align: left;
        }

        h1 {
            text-align: center;
            font-size: 28px;
        }

        #disclaimer {
            margin: 10px 0px 10px 0px;
        }

        a {
            color: #000;
            text-decoration: none
        }
    </style>

</div>
<!--End Print Area!-->


<form id="printForm" action="<?= app('url') ?>/exec/reports/printReport/" method="post">
    <input type="hidden" name="frm_contents" id="frm_contents" value="">
    <input type="hidden" name="frm_filename" value="Group Report-<?= req(" frm_group_name ") . ".pdf " ?>">
    <input type="hidden" name="print" value="1">
</form>

<script>
    $(document).ready(function() {
        $("#printPdf").click(function() {
            $myVar = $("#printArea").html();
            $("#frm_contents").val($myVar);
            $("#printForm").submit();
        });
    });
</script>

<script>
    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "date-uk-pre": function(a) {
            if (a == null || a == "") {
                return 0;
            }
            var ukDatea = a.split('-');
            return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
        },

        "date-uk-asc": function(a, b) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "date-uk-desc": function(a, b) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#table-g').DataTable({
            "order": [
                [0, "asc"]
            ],
            paging: false,
            searching: false,
            info: false,
            columnDefs: [{
                type: 'date-uk',
                targets: 0
            }]

        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#maintable2').DataTable({
            "order": [
                [0, "asc"]
            ],
            paging: false,
            searching: false,
            info: false,
            columnDefs: [{
                type: 'date-uk',
                targets: 0
            }]

        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#maintable3').DataTable({
            "order": [
                [0, "asc"]
            ],
            paging: false,
            searching: false,
            info: false,
            columnDefs: [{
                type: 'date-uk',
                targets: 0
            }]

        });
    });
</script>


<script>
    $("#hide").click(function() {
        $("#maintable2,#maintenance,#hide,#show").hide("slow", function() {});
    });
</script>
<script>
    $("#show").click(function() {
        $("#maintable2,#maintenance").show("slow", function() {});
    });
</script>