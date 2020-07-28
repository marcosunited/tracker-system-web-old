<?js_init()?>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/1.10.13/sorting/date-dd-MMM-yyyy.js"></script>

<div id="topbar">
    <a href="#" id="printPdf">Print As PDF</a>
</div>

<div id="printArea" contenteditable="true">
    <div style="text-align:center;"><img src="<?= app('app_url') ?>/images/logobig.png" width="400"></div>

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

    <h1>Callout Report</h1>

    <div style="text-align:center;margin:10px;">
        <b>Period Starting:</b>
        <?= req("frm_start_date") ?> <b>Till</b>
        <?= req("frm_end_date") ?>
    </div>


    <p></p>
    <?grapher($callCountTotal,$faults)?>
    <table id="table" border="1">
        <thead>
            <tr>
                <th>Job No</th>
                <th>Job Name
                    <div style="width:720px;"></div>
                </th>
                <th>Lifts</th>
                <th>Callouts</th>
                <th>Round</th>
            </tr>
        </thead>
        <tbody>
            <?while($row = mysqli_fetch_array($results)){?>
            <tr>
                <td id="<?= $row['job_id'] ?>" class="classID"><?= $row['job_number'] ?></td>
                <td style="text-align:left;">&nbsp;
                    <?= $row["job_name"] ?> -
                    <?= $row["job_address_number"] ?>
                    <?= $row["job_address"] ?>
                    <?= $row["job_suburb"] ?>
                </td>
                <td>
                    <?= $row["lift_count"] ?>
                </td>
                <td>
                    <?= $row["call_count"] ?>
                </td>
                <td>
                    <?= $row["round_name"] ?>
                </td>
            </tr>
            <?}?>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <div style="text-align:center"><b>Printed</b>:
        <?= toDateTime(time()) ?>
    </div>
    <style>
        body {
            margin: 0px;
            font-size: 12px;
        }

        #table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            font-size: 12px;
            text-align: center;
        }

        th {
            font-weight: bold;
            font-size: 12px;
            padding: 5px;
            text-align: center;
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

        h1 {
            text-align: center;
            font-size: 28px;
        }

        a {
            color: #000;
            text-decoration: none
        }
    </style>
</div>

<form id="printForm" action="<?= app('url') ?>/exec/reports/printReport/" method="post">
    <input type="hidden" name="frm_contents" id="frm_contents" value="">
    <input type="hidden" name="frm_filename" value="Callout Report-<?= date(" d-m-y ") . ".pdf " ?>">
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
    $(document).ready(function() {
        $('#table').DataTable({
            "order": [
                [0, "asc"]
            ],
            paging: false,
            searching: false,


        });
    });
</script>

<script>
    $(".classID").on('click', function() {
        var id = $(this).attr('id');
        window.open("<?= app('url') ?>/exec/jobs/form/?frm_job_id=" + id);
    });
</script>