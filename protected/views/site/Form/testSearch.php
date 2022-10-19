
<script>
    $(function () {
        $("#aMenuFormLinkCF").addClass("active");
        $("#aMenuFormLink").addClass("active");
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
    <div class="container-md" style="">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-9">
                        <h3>PQSIS Case Search</h3>
                    </div>
                    <div class="col-lg-3" style="text-align:right">
                        <button id="searchCaseFormBtn" type="button" class="btn btn-success">Search</button>
                        <button id="newBtn" name="newBtn" <?php echo $this->viewbag['disabled'] ?> type="button"  class="btn btn-primary" onclick="window.location.href='<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/GetCaseFormForNew'">New</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        Case No.
                    </div>
                    <div class="col-md-9">
                                <input id="caseNoSearchTxt" name="caseNoSearchTxt" type="number" class="" placeholder="Case No"  style="width:150px"> <b>.</b>
                                <input id="versionSearchTxt" name="versionSearchTxt" type="number" class="" placeholder="Version" style="width:80px"/>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-3">
                        Requested By
                    </div>
                    <div class="col-md-9">
                        <input id="requestedBySearchTxt" name="requestedBySearchTxt" type="text" class="" placeholder="Requested By" />
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-3">
                        Customer Name
                    </div>
                    <div class="col-md-9">
                        <input id="customerNameSearchTxt" name="customerNameSearchTxt" type="text" class="" placeholder="Customer Name" />
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-3">
                        Department To Be Charge
                    </div>
                    <div class="col-md-9">
                        <select id="partyToBeChargedSearchSel" name="partyToBeChargedSearchSel" class="">
                            <option value="">---</option>
                            <?php $partyToBeChargedList = $this->viewbag['partyToBeChargedList']?>
                            <?php foreach ($partyToBeChargedList as $partyToBeCharged) {?>
                            <option value="<?php echo $partyToBeCharged['partyToBeChargedId'] ?>"><?php echo $partyToBeCharged['partyToBeChargedName'] ?></option>
                            <?php }?>

                        </select>

                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-3">
                        Service Type
                    </div>
                    <div class="col-md-9">
                        <select id="serviceTypeSearchSel" name="serviceTypeSearchSel" class="">
                            <option value="">---</option>
                            <?php $serviceTypeList = $this->viewbag['serviceTypeList']?>
                            <?php foreach ($serviceTypeList as $serviceType) {?>
                            <option value="<?php echo $serviceType['serviceTypeId'] ?>"><?php echo $serviceType['serviceTypeName'] ?></option>
                            <?php }?>

                        </select>

                    </div>
                </div>
                <br/>
                <div class="row ">
                    <div class="col-md-3">
                        Service Start Date / <br/> Customer Contacted Date 
                    </div>
                    <div class="col-md-9">
                        <b>From</b>
                        <input id="startDate1Txt" name="startDate1Txt" type="text" class="" placeholder="YYYY-mm-dd" value="<?php echo date('Y-m-d', strtotime('-6 months') )?>" style="" />
                        <b>&nbsp;To &nbsp;</b>
                        <input id="startDate2Txt" name="startDate2Txt" type="text" class="" placeholder="YYYY-mm-dd" value="<?php echo date("Y-m-d")?>"style="" />
                    </div>            
                </div>
                <br />
                <div class="row ">
                    <div class="col-md-3">
                        Actual Report Issue Date / <br/> Service Completion Date
                    </div>
                    <div class="col-md-9">
                            
                        <b>From</b>
                        <input id="endDate1Txt" name="endDate1Txt" type="text" class="" placeholder="YYYY-mm-dd" value="<?php echo date('Y-m-d', strtotime('-6 months') )?>" style="" />
                        <b>&nbsp;To &nbsp;</b>
                        <input id="endDate2Txt" name="endDate2Txt" type="text" class="" placeholder="YYYY-mm-dd" value="<?php echo date("Y-m-d")?>" style="" />
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-3">
                        Active
                    </div>
                    <div class="col-md-9">
                        <select id="activeSearchSel" name="activeSearchSel" class="">
                            <option value=""> </option>
                            <option value="Y"> Yes </option>
                            <option value="N"> No </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <br/>
    </div>
    <br/>
    <div class="row justify-content-center">
            <div class="col-12">
            <table id="Table" class="display DataTable order-column table-striped table-bordered stripe" style="width:100%">
    <thead>
    <tr>
        <th></th>
        <th>Info</th>
        <th>Seminar Name</th>
        <th>Start Date</th>
        <th>Friend Number</th>
        <th>Last Update Time</th>
        <th>Referee</th>
        <th>   </th>
        <th>   </th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
            </div>
        </div>

    <script>
        $(function () {

        $("#startDate1Txt").datetimepicker({ timepicker: false, format: 'Y-m-d', scrollInput: false });
        $("#startDate2Txt").datetimepicker({ timepicker: false, format: 'Y-m-d', scrollInput: false });
        $("#endDate1Txt").datetimepicker({ timepicker: false, format: 'Y-m-d', scrollInput: false });
        $("#endDate2Txt").datetimepicker({ timepicker: false, format: 'Y-m-d', scrollInput: false });


    table = $("#Table").DataTable({
                "scrollX": true,
                "serverSide": true,
                "processing": true,
                "ajax": {
                    "url": "https://localhost:44334/Course/AjaxSearchSeminarReg",
                    "type": "POST",
                    "contentType": 'application/json; charset=utf-8',
                    "data": function (data) {
                        return JSON.stringify(constructPostParam(data));
                    }
                },
              // 
                "iDisplayLength": 50,
                "order": [[5, "desc"]],
                "aLengthMenu": [
                    [100, 200, 500, 1000, 9000000],
                    [100, 200, 500, 1000, 'All'],
                ],
                "filter": false,
                "fixedHeader": true,
                //"fixedColumns": true,
                "sPaginationType": "full_numbers",
                "columns": [
                    {
                        "data": null,
                        render: function (data, type, row, meta) {
                            var info = table.page.info();
                            var html = info.page * info.length + (meta.row +1);
                            return html;
                        },
                        "width": "3%"
                    },
                    {
                        "data": "ATTENDANT_NAME",
                        render: function (data, type, row) {
                            var html = row.ATTENDANT_NAME + "<br />"
                                + "<a href='https://wa.me/852" + row.ATTENDANT_PHONE + "?text=%E4%B8%8A%E5%A0%82%E5%9C%B0%E9%BB%9E%E6%98%AFxxx' target='_blank'>" + row.ATTENDANT_PHONE + "</a>" + "<br />"
                                    + "<a href='mailto:" + row.ATTENDANT_EMAIL + "'>" + row.ATTENDANT_EMAIL + "</a>";

                            return html;
                        },
                        "width": "10%"
                    },
                    { "data": "SEMINAR_NAME", "width": "10%" },
                    { "data": "START_DATETIME", "width": "10%" },
                    { "data": "FRIEND_NO", "width": "10%" },
                    { "data": "LAST_UPD_DT", "width": "10%" },
                    { "data": "USER_ID","width": "10%"},
                    {
                    "data": "openBtn",
                        render: function (data, type, row) {

                        if (!row.ATTEND) {
                            var btnHtml = "<button id='attendBtn-" + row.SYS_SEM_REG_ID + "' name='attendBtn' class='btn btn-primary' style='width: 100px;' semRegId='" + row.SYS_SEM_REG_ID + "'>Attend</button> ";
                        }

                        if (row.ATTEND) {
                            var btnHtml = "<button id='unattendBtn-" + row.SYS_SEM_REG_ID + "' name='unattendBtn' class='btn btn-outline-danger' style='width: 100px;' semRegId='" + row.SYS_SEM_REG_ID + "'>Unattend</button> ";
                        }

                        return btnHtml;
                    },
                        "width": "5%"
                    },
                    {
                        "data": "deleteBtn",
                        render: function (data, type, row) {

                            var btnHtml = "<button id='deleteBtn-" + row.SYS_SEM_REG_ID + "' name='deleteBtn' class='btn btn-primary' style='width: 100px;' semRegId='" + row.SYS_SEM_REG_ID + "'>Delete</button> ";

                            return btnHtml;
                        },
                        "width": "5%"
                    }
                ],
                "drawCallback": function (settings) {
                    // bind all button
                    rebindAllBtn();
                },
                "columnDefs": [
                    { "targets": 0, "orderable": false },
                    { "targets": 7, "orderable": false },
                    { "targets": 8, "orderable": false }
                ]
            });

        $("#searchCaseFormBtn").unbind().bind("click", function () {
            table.ajax.reload(null, false);
        });
    });

        function constructPostParam(d) {
            var searchParamStr = "{";
            if ($("#caseNoSearchTxt").val() != null && $("#caseNoSearchTxt").val() != "") {
                searchParamStr += "\"serviceCaseId\":" + "\"" + $("#caseNoSearchTxt").val() + "\"" + ",";
            }
            if ($("#versionSearchTxt").val() != null && $("#versionSearchTxt").val() != "") {
                searchParamStr += "\"caseVersion\":" + "\"" + $("#versionSearchTxt").val() + "\"" + ",";
            }
            if ($("#requestedBySearchTxt").val() != null && $("#requestedBySearchTxt").val() != "") {
                searchParamStr += "\"requestedBy\":" + "\"" + $("#requestedBySearchTxt").val() + "\"" + ",";
            }
            if ($("#customerNameSearchTxt").val() != null && $("#customerNameSearchTxt").val() != "") {
                searchParamStr += "\"customerName\":" + "\"" + $("#customerNameSearchTxt").val() + "\"" + ",";
            }
            if ($("#partyToBeChargedSearchSel").val() != null && $("#partyToBeChargedSearchSel").val() != "") {
                searchParamStr += "\"partyToBeChargedId\":" + "\"" + $("#partyToBeChargedSearchSel").val() + "\"" + ",";
            }
            if ($("#serviceTypeSearchSel").val() != null && $("#serviceTypeSearchSel").val() != "") {
                searchParamStr += "\"serviceTypeId\":" + "\"" + $("#serviceTypeSearchSel").val() + "\"" + ",";
            }
            if ($("#startDate1Txt").val() != null && $("#startDate1Txt").val() != "") {
                searchParamStr += "\"startDateStartRange\":" + "\"" + $("#startDate1Txt").val() + "\"" + ",";
            }
            if ($("#startDate2Txt").val() != null && $("#startDate2Txt").val() != "") {
                searchParamStr += "\"startDateEndRange\":" + "\"" + $("#startDate2Txt").val() + "\"" + ",";
            }
            if ($("#endDate1Txt").val() != null && $("#endDate1Txt").val() != "") {
                searchParamStr += "\"endDateStartRange\":" + "\"" + $("#endDate1Txt").val() + "\"" + ",";
            }
            if ($("#endDate2Txt").val() != null && $("#endDate2Txt").val() != "") {
                searchParamStr += "\"endDateEndRange\":" + "\"" + $("#endDate2Txt").val() + "\"" + ",";
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
                 $.ajax(
                     {
                         url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxGetCaseFormForNew",
                         type: "GET",
                         contentType: 'application/json; charset=utf-8',
                         cache: false,
                         success: function (data) {
                             $("#caseFormBody").html(data);
                             $("#modifyCaseFormModal").modal("show");
                         }
                     }
                 ).fail(function (event, jqXHR, settings, thrownError) {
                     if (event.status != 440) {
                         alert("error in opening CaseForm")
                     }

                 }).always(function (data) {
                     $("#divLoadingModal").modal("hide");
                 });
             });
          */
        }
    </script>
