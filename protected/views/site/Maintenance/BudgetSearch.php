<script>
$(function() {
    $("#aMenuMaintenanceLinkBG").addClass("active");
    $("#aMenuMaintenanceLink").addClass("active");
    $("#aMenuMaintenanceLinkCaseForm").addClass("active");
});
</script>
<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
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

        <div class="row">
            <div class="col-md-3">
                Year
            </div>
            <div class="col-md-9">
                <select id="countYearSearchSel" name="countYearSearchSel" class="form-control" placeholder="">
                    <option value=""></option>
                    <?php foreach($this->viewbag['countYear'] as $countYear){ ?>
                    <option value=<?php echo $countYear['countYear']; ?>> <?php echo $countYear['countYear'] ?>
                    </option>

                    <?php } ?>
                </select>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-3">
                Service Type
            </div>
            <div class="col-md-9">
                <select id="serviceTypeSearchSel" name="serviceTypeSearchSel" type="text" class="form-control"
                    placeholder="">
                    <option value=""></option>
                    <?php $serviceTypeList = $this->viewbag['serviceTypeList']?>
                    <?php foreach ($serviceTypeList as $serviceType) {?>
                    <option value="<?php echo $serviceType["serviceTypeId"] ?>">
                        <?php echo $serviceType["serviceTypeName"] ?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-3">
                Party To Be Charged
            </div>
            <div class="col-md-9">
                <select id="partyToBeChargedSel" name="partyToBeChargedSel" type="text" class="form-control"
                    placeholder="">
                    <option value=""></option>
                    <?php $partyToBeChargedList = $this->viewbag['partyToBeChargedList']?>
                    <?php foreach ($partyToBeChargedList as $partyToBeCharged) {?>
                    <option value="<?php echo $partyToBeCharged["partyToBeChargedId"] ?>">
                        <?php echo $partyToBeCharged["partyToBeChargedName"] ?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-3">
                Active
            </div>
            <div class="col-md-9">
                <select id="activeSearchSel" name="activeSearchSel" class="form-control">
                    <option value=""> </option>
                    <option value="Y"> Yes </option>
                    <option value="N"> No </option>
                </select>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-12">
                <button id="searchBtn" type="button" class="btn btn-primary">Search</button>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-12">
                <button id="newBtn" name="newBtn" <?php echo $this->viewbag['disabled'] ?> type="button"
                    class="btn btn-primary">New</button>
            </div>
        </div>
        <br />
    </div>
    <div class="row justify-content-center">
        <div class="col-12">
            <table id="Table" width="100%" class="display no-wrap">
                <thead>
                    <tr>

                        <td width="10%">ID </td>
                        <td width="10%">Year </td>
                        <td width="10%">Service Type </td>
                        <td width="10%">Party to be charged</td>
                        <td width="10%">Unit Cost </td>
                        <td width="10%">Budget Number </td>
                        <td width="10%">Active</td>
                        <td width="10%"> </td>
                        <td width="20%">Created By</td>
                        <td width="20%">Created Date</td>
                        <td width="20%">Last Updated By</td>
                        <td width="20%">Last Updated Time</td>

                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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



        table = $("#Table").DataTable({
            "serverSide": true,
            "processing": true,
            "scrollX": true,
            "fixedHeader": true,
            deferRender: true,
            "scroller": true,
            "ajax": {
                "url": "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/AjaxGetBudgetTable",
                "type": "POST",
                "contentType": 'application/json; charset=utf-8',
                "data": function(data) {
                    return JSON.stringify(constructPostParam(data));
                }
            },

            "order": [
                [0, "desc"]
            ],
            "aLengthMenu": [
                [100, 200, 500, 1000, 9000000],
                [100, 200, 500, 1000, 'All'],
            ],
            "filter": false,
            "sPaginationType": "full_numbers",
            "columns": [

                {
                    "data": "budgetId",
                    "width": "10%"
                },
                {
                    "data": "countYear",
                    "width": "20%"
                },
                {
                    "data": "serviceTypeName",
                    "width": "20%"
                },
                {
                    "data": "partyToBeChargedName",
                    "width": "20%"
                },
                {
                    "data": "unitCost",
                    "width": "20%"
                },
                {
                    "data": "budgetNumber",
                    "width": "20%"
                },
                {
                    "data": "active",
                    "width": "10%"
                },
                {
                    "data": "budgetId",
                    render: function(data, type, row) {
                        var btnHtml = "<button id='modifyBtn-" + row.budgetId +
                            "' name='modifyBtn' <?php echo $this->viewbag['disabled'] ?> class='btn btn-primary'  countYear = '" +
                            row.countYear + "' budgetId='" + row.budgetId +
                            "' > Modify</button> ";
                        return btnHtml;
                    },
                    "width": "20%"
                },
                {
                    "data": "createdBy"
                },
                {
                    "data": "createdTime"
                },
                {
                    "data": "lastUpdatedBy"
                },
                {
                    "data": "lastUpdatedTime"
                }


            ],
            "drawCallback": function(settings) {
                // bind all button
                rebindAllBtn();
            },
            "columnDefs": [{
                "targets": 7,
                "orderable": false
            }]
        });

        $("#searchBtn").unbind().bind("click", function() {
            table.ajax.reload(null, false);
        });
    });

    function constructPostParam(d) {
        var searchParamStr = "{";
        if ($("#countYearSearchSel").val() != null && $("#countYearSearchSel").val() != "") {
            searchParamStr += "\"countYear\":" + "\"" + $("#countYearSearchSel").val() + "\"" + ",";
        }

        if ($("#serviceTypeSearchSel").val() != null && $("#serviceTypeSearchSel").val() != "") {
            searchParamStr += "\"serviceTypeId\":" + "\"" + $("#serviceTypeSearchSel").val() + "\"" + ",";
        }
        if ($("#partyToBeChargedSel").val() != null && $("#partyToBeChargedSel").val() != "") {
            searchParamStr += "\"partyToBeChargedId\":" + "\"" + $("#partyToBeChargedSel").val() + "\"" + ",";
        }
        if ($("#activeSearchSel").val() != null && $("#activeSearchSel").val() != "") {
            searchParamStr += "\"active\":" + "\"" + $("#activeSearchSel").val() + "\"" + ",";
        }

        if (searchParamStr != "{") {
            searchParamStr = searchParamStr.substr(0, searchParamStr.length - 1);
        }

        searchParamStr += "}";

        d.searchParam = searchParamStr;

        return d;
    }

    function rebindAllBtn() {


        /* $("button[name='newBtn']").unbind().bind("click", function () {
             $("#divLoadingModal").modal("show");
             $("#caseFormBody").html("");
             $.ajax({

                 url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxGetCaseFormForNew",
                 type: "POST",
                 cache: false,
                 data: { loginId: $("#txLoginId").val(), password: $("#txPassword").val()}
             }).done(function( data ) {

                 console.log(data);
                 var retJson = JSON.parse(data);

                 console.log(retJson);

                 if (retJson.status == "OK")
                 {
                     window.location.href = "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/Landing";
                 }
                 else
                     $("#msgFont").html(retJson.retMessage);
             }).fail(function (xhr, textStatus, errorThrown) {
                 console.log(xhr);
                 $("body").html(xhr.responseText);
             });
             */
        $("button[name='newBtn']").unbind().bind("click", function() {
            $("#divLoadingModal").modal("show");
            $("#modalBody").html("");

            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/GetBudgetForNew",
                type: "GET",
                contentType: 'application/json; charset=utf-8',
                cache: false,
                success: function(data) {
                    $("#modalBody").html(data);
                    $("#modifyModal").modal("show");
                }
            }).fail(function(event, jqXHR, settings, thrownError) {
                if (event.status != 440) {
                    alert("error in opening Modal")
                }

            }).always(function(data) {
                $("#divLoadingModal").modal("hide");
            });
        });
        $("button[name='modifyBtn']").unbind().bind("click", function() {
            $("#divLoadingModal").modal("show");
            $("#modalBody").html("");

            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/GetBudgetForUpdate&budgetId=" +
                    $(this).attr("budgetId") + "&countYear=" + $(this).attr("countYear"),
                type: "GET",
                contentType: 'application/json; charset=utf-8',
                cache: false,
                success: function(data) {
                    $("#modalBody").html(data);
                    $("#modifyModal").modal("show");
                }
            }).fail(function(event, jqXHR, settings, thrownError) {
                if (event.status != 440) {
                    alert("error in opening Modal")
                    alert(event.responseText);
                }

            }).always(function(data) {
                $("#divLoadingModal").modal("hide");
            });
        });

    }
    </script>