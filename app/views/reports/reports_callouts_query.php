<?js_init()?>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/1.10.13/sorting/date-de.js"></script>

<div id="topbar">
    <a href="#" id="goBack">Go back</a>
</div>

<div id="printArea" contenteditable="true">
    <div id="logo">
        <img src="<?= app('app_url') ?>/images/logobig.png" align="center" width="400">
    </div>

    <table width="100%" border="0" align="center">
        <tr>
            <td class="postal">A.C.N 082 447 658</td>
            <td class="postal">ABN 81 082 447 658</td>
            <td class="postal">
                <div>
                    Postal Address:<br> P.O.Box 280<br> KEW VIC 3101<br> Telephone: 9687 9099<br> Facsimile: 9687 9094
                </div>
            </td>
        </tr>
    </table>

    <h1>Callout Report: <?= $job_name[0][0] ?></h1>
    <div style="text-align:center;margin:10px;">
        <h1>Callouts</h1>
    </div>
    <div style="text-align:center;margin:10px;">
        <b>Period Starting:</b>
        <?= req("start_date") ?> <b>Till</b>
        <?= req("end_date") ?>

        <input id="startDate" type="hidden" value="<?= req("start_date") ?>">
        <input id="endDate" type="hidden" value="<?= req("end_date") ?>">
    </div>

    <table width="95%" border="1" style="border-collapse:collapse" id="table-g" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Time of Call</th>
                <th>Arrived</th>
                <th>Finished</th>
                <th>Job No</th>
                <th>Site Name</th>
                <th>Lift Names</th>
                <th>Order Number</th>
                <th>Call Description</th>
                <th>Tech Fault</th>
                <th>Tech Description</th>
                <th>Technician</th>
                <th>Response Time Exceeded</th>
            </tr>
        </thead>
        <tbody>
            <?foreach($callouts as $callout){?>
            <tr>
                <td id="<?= $callout['callout_id'] ?>" class="classID">
                    <?= $callout["callout_id"] ?>
                </td>
                <td>
                    <?= toDate($callout["callout_time"]) ?>
                </td>
                <td>
                    <?= toTime($callout["callout_time"]) ?>
                </td>

                <td>
                    <?= toDateTime($callout["time_of_arrival"]) ?>
                </td>
                <td>
                    <?= toDateTime($callout["time_of_departure"]) ?>
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
                    <?= $callout["order_number"] ?>&nbsp;
                </td>
                <td>
                    <?= $callout["fault_name"] ?>&nbsp;
                </td>
                <td>
                    <?= $callout["technician_fault_name"] ?>&nbsp;
                </td>
                <td>
                    <?= $callout["tech_description"] ?>
                </td>
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

    <div style="text-align:center;padding-top:20px;">
        <b>Printed:</b>
        <?= toDateTime(time()) ?>
    </div>

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

        .classId,
        .classIdMaintenance {
            cursor: pointer;
            text-decoration: underline;
            color: blue;
        }
    </style>

</div>
<!--End Print Area!-->


<form id="printForm" action="<?= app('url') ?>/exec/reports/printReport/" method="post">
    <input type="hidden" name="frm_contents" id="frm_contents" value="">
    <input type="hidden" name="frm_filename" value="Group Report-<?= req(" frm_group_name ") . ".pdf" ?>">
    <input type="hidden" name="print" value="1">
</form>

<script>
    $(document).ready(function() {
        $("#printPdf").click(function() {
            $myVar = $("#printArea").html();
            $("#frm_contents").val($myVar);
            $("#printForm").submit();
        });

        $(".classID").on('click', function() {
            var id = $(this).attr('id');
            window.open("<?= app('url') ?>/exec/callouts/printPdf/?view_type=plain&frm_callout_id=" + id);
        });

        $("#goBack").click(function() {
            window.close();
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