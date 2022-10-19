<script>
$(function() {
    $("#aMenuReportLinkPAR").addClass("active");
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
                By Day Range
            </div>
            <div class="col-md-7">
                <b>From</b>
                <input id="reportDate1Txt" name="reportDate1Txt" type="text" class="form-control"
                    value="<?php echo Date('Y-m-d', strtotime('-1 month'))?>" style="" />
                <b>To</b>
                <input id="reportDate2Txt" name="reportDate2Txt" type="text" class="form-control"
                    value="<?php echo date('Y-m-d')?>" style="" />
            </div>
            <div class="col-md-2">
                <br />
                <button id="downloadBtnByDate" name="downloadBtnByDate" type="button"
                    class="btn btn-primary">Download</button>
            </div>
            <div class="col-md-3">
                Year of Return Rate
            </div>
            <div class="col-md-7">
                <b>From</b>
                <input id="reportYear1Txt" name="reportYear1Txt" type="number" class="form-control"
                    value="<?php echo Date('Y', strtotime('-1 year'))?>" style="" />
                <b>To</b>
                <input id="reportYear2Txt" name="reportYear2Txt" type="number" class="form-control"
                    value="<?php echo date('Y')?>" style="" />
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
            $returnRateStartYear = $("#reportYear1Txt").val();
            $returnRateEndYear = $("#reportYear2Txt").val();
            if ($startYear > $endYear) {
                alert("The start year should be less than end year");
                $(this).attr("disabled", false);
                return;
            }
            if ($returnRateStartYear > $returnRateEndYear) {
                alert("The start year should be less than end year");
                $(this).attr("disabled", false);
                return;
            }
            window.location.href =
                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Report/PlanningAheadReportDownload&mode=byDate&startYear=" +
                $startYear + "&startMonth=" + $startMonth + "&startDay=" + $startDay + "&endYear=" +
                $endYear + "&endMonth=" + $endMonth + "&endDay=" + $endDay + "&returnRateStartYear=" +
                $returnRateStartYear + "&returnRateEndYear=" + $returnRateEndYear;
            $(this).attr("disabled", false);
        });
    });
    </script>