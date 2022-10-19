<script>
$(function() {
    $("#aMenuReportLinkCR").addClass("active");
    $("#aMenuReportLink").addClass("active");
});
</script>
<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>
<!doctype html>
<html lang="en">

<head>
    <style>
    body {
        overflow-x: hidden;
    }
    </style>
</head>

<body class="" style="">
    <div class="container" style="margin-top:56px;">

        <div class="row border border-secondary p-4">
            <div class="col-md-3">
                By Month Range
            </div>
            <div class="col-md-7">
                <b>From</b>
                <input id="reportMonth1Txt" name="reportMonth1Txt" type="text" class="form-control"
                    value="<?php echo date('Y-m-' . $this->viewbag['caseFormReporStartDay']["configValue"], strtotime('-1 month')) ?>"
                    style="" />
                <b>To</b>
                <input id="reportMonth2Txt" name="reportMonth2Txt" type="text" class="form-control"
                    value="<?php echo date('Y-m-' . $this->viewbag['caseFormReporEndDay']["configValue"]) ?>"
                    style="" />
            </div>
            <div class="col-md-2">
                <br />
                <button id="downloadBtnByMonth" name="downloadBtnByMonth" type="button"
                    class="btn btn-primary">Download</button>
            </div>
        </div>
        <br />
        <div class="row border border-secondary p-4">
            <div class="col-md-3">
                By Quarter
            </div>
            <div class="col-md-7">
                <b>Year</b>
                <input id="reportYear1Txt" name="reportYear1Txt" type="number" class="form-control"
                    value="<?php echo date('Y') ?>" style="" min="1" max="9999" />
                <b>Quarter</b>
                <select id="reportQuraterTxt" name="reportQuraterTxt" class="form-control">
                    <option value="1"> Q1(Jan-Mar) </option>
                    <option value="2"> Q2(Apr-Jun) </option>
                    <option value="3"> Q3(Jul-Sep) </option>
                    <option value="4"> Q4(Oct-Dec) </option>
                </select>
            </div>
            <div class="col-md-2">
                <br />
                <button id="downloadBtnByQuarter" name="downloadBtnByQuarter" type="button"
                    class="btn btn-primary">Download</button>
            </div>
        </div>
        <br />
        <div class="row border border-secondary p-4">
            <div class="col-md-3">
                By Year
            </div>
            <div class="col-md-7">
                <b>Year</b>
                <input id="reportYear2Txt" name="reportYear2Txt" type="number" class="form-control"
                    value="<?php echo date('Y') ?>" style="" min="1" max="9999" />
            </div>
            <div class="col-md-2">
                <br />
                <button id="downloadBtnByYear" name="downloadBtnByYear" type="button"
                    class="btn btn-primary">Download</button>
            </div>
        </div>
        <br />
        <div class="row border border-secondary p-4">
            <div class="col-md-3">
                By Day Range
            </div>
            <div class="col-md-7">
                <b>From</b>
                <input id="reportDate1Txt" name="reportDate1Txt" type="text" class="form-control"
                    value="<?php echo Date('Y-m-d', strtotime('-1 month')) ?>" style="" />
                <b>To</b>
                <input id="reportDate2Txt" name="reportDate2Txt" type="text" class="form-control"
                    value="<?php echo date('Y-m-d') ?>" style="" />
            </div>
            <div class="col-md-2">
                <br />
                <button id="downloadBtnByDate" name="downloadBtnByDate" type="button"
                    class="btn btn-primary">Download</button>
            </div>
        </div>

    </div>

    <div id="modifyModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content" style="width:100%;height:auto;">
                <div id="modalBody" class="modal-body">
                </div>

            </div>
        </div>
    </div>

    <script>
    $(function() {
        $("#reportMonth1Txt").datetimepicker({
            timepicker: false,
            closeOnDateSelect: true,
            format: 'Y-m-<?php echo $this->viewbag['caseFormReporStartDay']["configValue"] ?>',
            scrollInput: false
        });
        $("#reportMonth2Txt").datetimepicker({
            timepicker: false,
            format: 'Y-m-<?php echo $this->viewbag['caseFormReporEndDay']["configValue"] ?>',
            scrollInput: false
        });
        $("#reportYear1Txt").datetimepicker({
            timepicker: false,
            format: 'Y',
            scrollInput: false
        });
        $("#reportYear2Txt").datetimepicker({
            timepicker: false,
            format: 'Y',
            scrollInput: false
        });
        $("#reportDate1Txt").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });
        $("#reportDate2Txt").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });






        $("#downloadBtnByMonth").unbind().bind("click", function() {
            $(this).attr("disabled", true);
            $date1 = $("#reportMonth1Txt").val();
            $date2 = $("#reportMonth2Txt").val();
            if ($date1 == "" || $date2 == "") {
                alert("please Choose a date");
                $(this).attr("disabled", false);
                return;
            } else {
                $startYear = new Date($("#reportMonth1Txt").val()).getFullYear();
                $startMonth = new Date($("#reportMonth1Txt").val()).getMonth() + 1;
                $endYear = new Date($("#reportMonth2Txt").val()).getFullYear();
                $endMonth = new Date($("#reportMonth2Txt").val()).getMonth() + 1;
                $startDay =
                <?php echo $this->viewbag['caseFormReporStartDay']["configValue"] ?>; //Default
                $endDay = <?php echo $this->viewbag['caseFormReporEndDay']["configValue"] ?>; //Default
                if (($endYear - $startYear) == 1 && $startMonth != 12) {
                    alert("Please Choose The same Year");
                    $(this).attr("disabled", false);
                    return;
                }
                if (($endYear - $startYear) > 1) {
                    alert("Please only choose one Year");
                    $(this).attr("disabled", false);
                    return;
                }
                if (($endYear - $startYear) < 0) {
                    alert("End Year should not be less than Start Year");
                    $(this).attr("disabled", false);
                    return;
                }
            }
            window.location.href =
                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Report/CaseReportDownload&mode=byMonth&startYear=" +
                $startYear + "&startMonth=" + $startMonth + "&startDay=" + $startDay + "&endYear=" +
                $endYear + "&endMonth=" + $endMonth + "&endDay=" + $endDay;
            $(this).attr("disabled", false);
        });

        $("#downloadBtnByQuarter").unbind().bind("click", function() {
            $(this).attr("disabled", true);
            $year = $("#reportYear1Txt").val();
            $quarter = $("#reportQuraterTxt").val();
            if ($year == "" || $quarter == "") {
                alert("please Choose a date");
                $(this).attr("disabled", false);
                return;
            } else {
                switch ($quarter) {
                    case "1":
                        $startYear = ($year - 1);
                        $startMonth = 12;
                        $endYear = $year;
                        $endMonth = 3;
                        break;
                    case "2":
                        $startYear = $year;
                        $startMonth = 3;
                        $endYear = $year;
                        $endMonth = 6;
                        break;
                    case "3":
                        $startYear = $year;
                        $startMonth = 6;
                        $endYear = $year;
                        $endMonth = 9;
                        break;
                    case "4":
                        $startYear = $year;
                        $startMonth = 9;
                        $endYear = $year;
                        $endMonth = 12;
                        break;
                }
                $startDay =
                <?php echo $this->viewbag['caseFormReporStartDay']["configValue"] ?>; //Default
                $endDay = <?php echo $this->viewbag['caseFormReporEndDay']["configValue"] ?>; //Default
            }
            window.location.href =
                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Report/CaseReportDownload&mode=byQuarter&startYear=" +
                $startYear + "&startMonth=" + $startMonth + "&startDay=" + $startDay + "&endYear=" +
                $endYear + "&endMonth=" + $endMonth + "&endDay=" + $endDay;
            $(this).attr("disabled", false);
        });

        $("#downloadBtnByYear").unbind().bind("click", function() {
            $(this).attr("disabled", true);
            $year = $("#reportYear2Txt").val();
            if ($year == "") {
                alert("please Choose a date");
                $(this).attr("disabled", false);
                return;
            } else {
                $startYear = ($year - 1);
                $startMonth = 12;
                $endYear = $year;
                $endMonth = 12;
                $startDay =
                <?php echo $this->viewbag['caseFormReporStartDay']["configValue"] ?>; //Default
                $endDay = <?php echo $this->viewbag['caseFormReporEndDay']["configValue"] ?>; //Default
            }
            window.location.href =
                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Report/CaseReportDownload&mode=byYear&startYear=" +
                $startYear + "&startMonth=" + $startMonth + "&startDay=" + $startDay + "&endYear=" +
                $endYear + "&endMonth=" + $endMonth + "&endDay=" + $endDay;
            $(this).attr("disabled", false);
        });

        $("#downloadBtnByDate").unbind().bind("click", function() {
            $(this).attr("disabled", true);
            $date1 = $("#reportDate1Txt").val();
            $date2 = $("#reportDate2Txt").val();
            if ($date1 == "" || $date2 == "") {
                alert("please Choose a date");
                $(this).attr("disabled", false);
                return;
            } else {
                $startYear = new Date($date1).getFullYear();
                $startMonth = new Date($date1).getMonth() + 1;
                $startDay = new Date($date1).getDate();
                $endYear = new Date($date2).getFullYear();
                $endMonth = new Date($date2).getMonth() + 1;
                $endDay = new Date($date2).getDate();
            }
            window.location.href =
                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Report/CaseReportDownload&mode=byDate&startYear=" +
                $startYear + "&startMonth=" + $startMonth + "&startDay=" + $startDay + "&endYear=" +
                $endYear + "&endMonth=" + $endMonth + "&endDay=" + $endDay;
            $(this).attr("disabled", false);
        });
    });
    </script>