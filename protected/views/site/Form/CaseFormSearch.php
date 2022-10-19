<script>
$(function() {

    $("#aMenuFormLink").addClass("active");
    if ("<?php echo $this->viewbag['mode'] ?>" == 'InvestigationS') {
        $("#aMenuFormLinkCFIS").addClass("active");
    } else if ("<?php echo $this->viewbag['mode'] ?>" == 'InvestigationL') {
        $("#aMenuFormLinkCFIL").addClass("active");
    } else if ("<?php echo $this->viewbag['mode'] ?>" == 'Enquiry') {
        $("#aMenuFormLinkCFE").addClass("active");
    } else if ("<?php echo $this->viewbag['mode'] ?>" == 'SiteVisit') {
        $("#aMenuFormLinkCFSV").addClass("active");
    } else if ("<?php echo $this->viewbag['mode'] ?>" == 'Seminar20') {
        $("#aMenuFormLinkCFSEM20").addClass("active");
    } else if ("<?php echo $this->viewbag['mode'] ?>" == 'Seminar20-50') {
        $("#aMenuFormLinkCFSEM20-50").addClass("active");
    } else if ("<?php echo $this->viewbag['mode'] ?>" == 'Seminar50') {
        $("#aMenuFormLinkCFSEM50").addClass("active");
    } else if ("<?php echo $this->viewbag['mode'] ?>" == 'PqWorkshopVisit') {
        $("#aMenuFormLinkPQWSV").addClass("active");
    } else {
        $("#aMenuFormLinkCF").addClass("active");
    }
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
        <div style="text-align:center;">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#searchDiv"
                aria-expanded="false" aria-controls="searchDiv">
                Open Search box
            </button>
        </div>
        <br />
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-9">
                        <h3 id="webTitle">PQSIS Case Search</h3>
                    </div>
                    <div class="col-lg-3" style="text-align:right">
                        <button id="searchCaseFormBtn" type="button" class="btn btn-success">Search</button>
                        <button id="newBtn" name="newBtn" <?php echo $this->viewbag['disabled'] ?> type="button"
                            class="btn btn-primary"
                            onclick="window.location.href='<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/GetCaseFormForNew'">New</button>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-3">
                        <!-- Service Start Date / <br/> Customer Contacted Date  / Requested Visit Date -->
                        Requested Date
                    </div>
                    <div class="col-md-9">
                        <b>From</b>
                        <input id="startDate1Txt" name="startDate1Txt" type="text" class="" placeholder="YYYY-mm-dd"
                            value="<?php echo date('Y-m-d', strtotime('-6 months') )?>" style="" />
                        <b>&nbsp;To &nbsp;</b>
                        <input id="startDate2Txt" name="startDate2Txt" type="text" class="" placeholder="YYYY-mm-dd"
                            value="<?php echo date("Y-m-d")?>" style="" />
                    </div>
                </div>
            </div>
            <div class="card-body collapse" id="searchDiv">

                <div class="row">
                    <div class="col-md-3">
                        Case No.
                    </div>
                    <div class="col-md-9">
                        <input id="caseNoSearchTxt" name="caseNoSearchTxt" type="number" class="" placeholder="Case No"
                            style="width:150px"> <b>.</b>
                        <input id="versionSearchTxt" name="versionSearchTxt" type="number" class=""
                            placeholder="Version" style="width:80px" />
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-3">
                        Requested By
                    </div>
                    <div class="col-md-9">
                        <input id="requestedBySearchTxt" name="requestedBySearchTxt" type="text" class=""
                            placeholder="Requested By" />
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-3">
                        Customer Name
                    </div>
                    <div class="col-md-9">
                        <input id="customerNameSearchTxt" name="customerNameSearchTxt" type="text" class=""
                            placeholder="Customer Name" />
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
                            <option value="<?php echo $partyToBeCharged['partyToBeChargedId'] ?>">
                                <?php echo $partyToBeCharged['partyToBeChargedName'] ?></option>
                            <?php }?>

                        </select>

                    </div>
                </div>
                <br />
                <div class="row" id="serviceTypeDiv">
                    <div class="col-md-3">
                        Service Type
                    </div>
                    <div class="col-md-9">
                        <select id="serviceTypeSearchSel" name="serviceTypeSearchSel" class="">
                            <option value="">---</option>
                            <?php $serviceTypeList = $this->viewbag['serviceTypeList']?>
                            <?php foreach ($serviceTypeList as $serviceType) {?>
                            <option value="<?php echo $serviceType['serviceTypeId'] ?>">
                                <?php echo $serviceType['serviceTypeName'] ?></option>
                            <?php }?>

                        </select>

                    </div>
                </div>
                <br />
                <br />
                <div class="row ">
                    <div class="col-md-3">
                        Actual Report Issue Date / <br /> Service Completion Date / <br /> Actual Visit Date
                    </div>
                    <div class="col-md-9">

                        <b>From</b>
                        <input id="endDate1Txt" name="endDate1Txt" type="text" class="" placeholder="YYYY-mm-dd"
                            value="" style="" />
                        <b>&nbsp;To &nbsp;</b>
                        <input id="endDate2Txt" name="endDate2Txt" type="text" class="" placeholder="YYYY-mm-dd"
                            value="" style="" />
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
        <br />
    </div>
    <br />
    <div class="row justify-content-center">
        <div class="col-12">
            <table id="caseFormTable" class="display" style="width:100%;white-space:nowrap;">
                <thead>
                    <tr>

                        <th width="">Case No. </th>
                        <th width="10%"> </th>
                        <th width="10%">Requested By </th>
                        <th width="10%">Requested Date </th>
                        <th width="10%">Service Type </th>
                        <th width="10%">Customer Name </th>
                        <th width="10%">Contact Person </th>
                        <th width="10%">Contact No.</th>
                        <th width="10%">Reported by EIC </th>
                        <th width="10%">CLP Person Department </th>
                        <th width="10%">Active</th>

                        <th width="20%">Created By</th>
                        <th width="20%">Created Date</th>
                        <th width="20%">Last Updated By</th>
                        <th width="20%">Last Updated Time</th>
                        <th width="10%">Problem Type </th>
                        <th width="10%">CLP Referred By</th>
                        <th width="10%">Action By</th>
                        <th width="10%">Incident Date & Time</th>
                        <th width="10%">Customer Group</th>
                        <th width="10%">Title</th>
                        <th width="10%">Customer Contacted Date</th>
                        <th width="10%">Service Start Date</th>
                        <th width="10%">Service Completion Date</th>
                        <th width="10%">Planned Report Issue Date</th>
                        <th width="10%">Actual Report Issue Date</th>
                        <th width="10%">Actual Response Day(s)</th>
                        <th width="10%">Actual Report Working Day(s)</th>
                        <th width="10%">Requested Visit Date</th>
                        <th width="10%">Actual Visit Date</th>
                        <th width="10%">Service Status</th>
                        <th width="10%">Case Referred to CLPE</th>
                        <th width="10%">Customer's Problems</th>
                        <th width="10%">Actions & Findings</th>
                        <th width="10%">Business Type</th>
                        <th width="10%">Plant Type</th>
                        <th width="10%">Manufacturer Brand</th>
                        <th width="10%">Plant Rating</th>
                        <th width="10%">Major Affected Element</th>
                        <th width="10%">Recommendation</th>
                        <th width="10%">Remarks</th>
                        <th width="10%">Implemented Solution</th>
                        <th width="10%">Followup Required</th>
                        <th width="10%">IDR Order ID</th>
                        <th width="10%">CLP Network</th>
                        <th width="10%">MP</th>
                        <th width="10%">G</th>
                        <th width="10%">T</th>
                        <th width="10%">Unit Rate</th>
                        <th width="10%">Unit</th>
                        <th width="10%">Total</th>
                        <th width="10%">Party to be Charged</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <script>
    $(function() {

        if ("<?php echo $this->viewbag['mode'] ?>" == 'InvestigationS') {
            $("#webTitle").html("Investigation(S) Search");
            $("#serviceTypeDiv").attr("hidden", true);
            $("#serviceTypeSearchSel").val("4");
        } else if ("<?php echo $this->viewbag['mode'] ?>" == 'InvestigationL') {
            $("#webTitle").html("Investigation(L) Search");
            $("#serviceTypeDiv").attr("hidden", true);
            $("#serviceTypeSearchSel").val("3");
        } else if ("<?php echo $this->viewbag['mode'] ?>" == 'Enquiry') {
            $("#webTitle").html("Enquiry Search");
            $("#serviceTypeDiv").attr("hidden", true);
            $("#serviceTypeSearchSel").val("1");
        } else if ("<?php echo $this->viewbag['mode'] ?>" == 'SiteVisit') {
            $("#webTitle").html("SiteVisit Search");
            $("#serviceTypeDiv").attr("hidden", true);
            $("#serviceTypeSearchSel").val("2");
        } else if ("<?php echo $this->viewbag['mode'] ?>" == 'Seminar20') {
            $("#webTitle").html("Seminar(<20ppl) Search");
            $("#serviceTypeDiv").attr("hidden", true);
            $("#serviceTypeSearchSel").val("10");
        } else if ("<?php echo $this->viewbag['mode'] ?>" == 'Seminar20-50') {
            $("#webTitle").html("Seminar(20-50ppl) Search");
            $("#serviceTypeDiv").attr("hidden", true);
            $("#serviceTypeSearchSel").val("9");
        } else if ("<?php echo $this->viewbag['mode'] ?>" == 'Seminar50') {
            $("#webTitle").html("Seminar(>50ppl) Search");
            $("#serviceTypeDiv").attr("hidden", true);
            $("#serviceTypeSearchSel").val("7");
        } else if ("<?php echo $this->viewbag['mode'] ?>" == 'PqWorkshopVisit') {
            $("#webTitle").html("PQ Workshop Visit Search");
            $("#serviceTypeDiv").attr("hidden", true);
            $("#serviceTypeSearchSel").val("6");
        } else {

        }

        $("#startDate1Txt").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });
        $("#startDate2Txt").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });
        $("#endDate1Txt").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });
        $("#endDate2Txt").datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            scrollInput: false
        });

        var availableTags = [<?php foreach ($this->viewbag['requestedByList'] as $requestedBy) {?> {
                value: "name:<?php echo $requestedBy['requestedByName'] ?>, dept: <?php echo $requestedBy['requestedByDept'] ?>",
                name: "<?php echo $requestedBy['requestedByName'] ?>",
                dept: "<?php echo $requestedBy['requestedByDept'] ?>"
            },
            <?php }?>
        ];
        var availableTagsForCustomer = [<?php foreach ($this->viewbag['customerList'] as $customer) {?> {
                value: "name:<?php echo $customer['customerName'] ?> , group : <?php echo $customer['customerGroup'] ?> , business type : <?php echo $customer['businessTypeName'] ?> , clp Network: <?php echo $customer['clpNetwork'] ?>",
                name: "<?php echo $customer['customerName'] ?>",
                group: "<?php echo $customer['customerGroup'] ?>",
                businessTypeId: "<?php echo $customer['businessTypeId'] ?>",
                clpNetwork: "<?php echo $customer['clpNetwork'] ?>"
            },
            <?php }?>
        ];
        $("#requestedBySearchTxt").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(availableTags, request.term);
                response(results.slice(0, 10));
            },
            focus: function(event, ui) {
                $("#requestedBySearchTxt").val(ui.item.name);
                return false;
            },
            select: function(event, ui) {
                $("#requestedBySearchTxt").val(ui.item.name);
                return false;
            }
        });
        $("#customerNameSearchTxt").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(availableTagsForCustomer, request.term);
                response(results.slice(0, 10));
            },
            focus: function(event, ui) {
                $("#customerNameSearchTxt").val(ui.item.name);
                return false;
            },
            select: function(event, ui) {
                $("#customerNameSearchTxt").val(ui.item.name);

                return false;
            }
        });


        table = $("#caseFormTable").DataTable({
            "serverSide": true,
            "autoWidth": false,
            "processing": true,
            "scrollX": true,
            "fixedHeader": false,
            "stateSave": false,
            "dom": 'Blipfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 3, 5, 4, 15, 2, 9, 16, 17, 18, 19, 6, 20, 7, 21, 22, 23, 24,
                            25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41,
                            42, 43, 44, 45, 46, 47, 14, 8, 48, 49, 50,51
                        ],
                        //columns:[0,2,4,3,16,1,7,17,18,19,4,20,5,21,6,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,15,7,49,50,51]
                        format: {
                            body: function(data, row, column, node) {
                                if (column != 0)
                                    return data;
                                return node.innerText;
                            }
                        },
                    },


                },
                //'copy', 'csv', 'excel'
            ],
            //
            "ajax": {
                "url": "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxGetCaseFormTable",
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
                [9000000, 100, 200, 500, 1000],
                ["All",100, 200, 500, 1000, ]
            ],
            "filter": false,
            "sPaginationType": "full_numbers",
            "columns": [

                {
                    "data": "parentCaseNo",
                    render: function(data, type, row) {
                        if (row.caseVersion != null) {
                            CaseNo = row.parentCaseNo + "." + row.caseVersion;
                        } else {
                            CaseNo = row.parentCaseNo;
                        }
                        var btnHtml =
                            "<a href='<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/GetCaseFormForRead&serviceCaseId=" +
                            row.serviceCaseId + "'>" + CaseNo + "</a>";
                        return btnHtml;
                    },
                    "width": "20%"
                },
                {
                    "data": "serviceCaseId",
                    render: function(data, type, row) {
                        var btnHtml = "<button id='copyBtn-" + row.serviceCaseId +
                            "' name='copyBtn' <?php echo $this->viewbag['disabled'] ?> class='btn btn-primary' serviceCaseId='" +
                            row.serviceCaseId +
                            "'  onclick=\"window.location.href=\'<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/GetCaseFormForCopy&serviceCaseId=" +
                            row.serviceCaseId + "\'\"> Copy</button> ";
                        return btnHtml;
                    },
                    "width": "10%"
                },
                {
                    "data": "requestedBy",
                    "width": "10%"
                },
                {
                    "data": "requestDate",
                    "width": "5%"
                },
                {
                    "data": "serviceTypeName",
                    "width": "10%"
                },
                {
                    "data": "customerName",
                    "width": "20%"
                },
                {
                    "data": "contactPersonName",
                    "width": "10%"
                },
                {
                    "data": "contactPersonNumber",
                    "width": "20%"
                },
                {
                    "data": "eicName",
                    "width": "20%"
                },
                {
                    "data": "clpPersonDepartment",
                    "width": "20%"
                },
                {
                    "data": "active",
                    "width": "10%"
                }, //10
                /*{
                    "data": "serviceCaseId", //10
                    render: function (data, type, row) {
                        var btnHtml = "<button id='modifyBtn-" + row.serviceCaseId + "' name='modifyBtn' <?php echo $this->viewbag['disabled'] ?> class='btn btn-primary' serviceCaseId='" + row.serviceCaseId + "'  onclick=\"window.location.href=\'<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/GetCaseFormForUpdate&serviceCaseId=" + row.serviceCaseId + "\'\"> Modify</button> ";
                        return btnHtml;
                    },
                    "width": "10%"
                }, */
                {
                    "data": "createdBy",
                    "width": "20%"
                },
                {
                    "data": "createdTime",
                    "width": "20%"
                },
                {
                    "data": "lastUpdatedBy",
                    "width": "20%"
                },
                {
                    "data": "lastUpdatedTime",
                    "width": "20%"
                },
                {
                    "data": "problemTypeName",
                    "width": "20%"
                },
                {
                    "data": "clpReferredByName",
                    "width": "20%"
                },
                {
                    "data": "actionByName",
                    "width": "20%"
                },
                {
                    "data": "incidentDate",
                    "width": "20%"
                },
                {
                    "data": "customerGroup",
                    "width": "20%"
                },
                {
                    "data": "contactPersonTitle",
                    "width": "20%"
                }, //20
                {
                    "data": "customerContactedDate",
                    "width": "20%"
                },
                {
                    "data": "serviceStartDate",
                    "width": "20%"
                },
                {
                    "data": "serviceCompletionDate",
                    "width": "20%"
                },
                {
                    "data": "plannedReportIssueDate",
                    "width": "20%"
                },
                {
                    "data": "actualReportIssueDate",
                    "width": "20%"
                },
                {
                    "data": "actualResponseDay",
                    "width": "20%"
                },
                {
                    "data": "actualReportWorkingDay",
                    "width": "20%"
                },
                {
                    "data": "requestedVisitDate",
                    "width": "20%"
                },
                {
                    "data": "actualVisitDate",
                    "width": "20%"
                },
                {
                    "data": "serviceStatusName",
                    "width": "20%"
                }, //30
                {
                    "data": "caseReferredToClpe",
                    "width": "20%"
                },
                {
                    "data": "customerProblem",
                    "width": "20%"
                },
                {
                    "data": "actionAndFinding",
                    "width": "20%"
                },
                {
                    "data": "businessTypeName",
                    "width": "20%"
                },
                {
                    "data": "plantTypeName",
                    "width": "20%"
                },
                {
                    "data": "manufacturerBrand",
                    "width": "20%"
                },
                {
                    "data": "plantRating",
                    "width": "20%"
                },
                {
                    "data": "majorAffectedElementName",
                    "width": "20%"
                },
                {
                    "data": "recommendation",
                    "width": "20%"
                },
                {
                    "data": "remark",
                    "width": "20%"
                }, //40
                {
                    "data": "implementedSolution",
                    "width": "20%"
                },
                {
                    "data": "requiredFollowUp",
                    "width": "20%"
                },
                {
                    "data": "idrOrderId",
                    "width": "20%"
                },
                {
                    "data": "clpNetwork",
                    "width": "20%"
                },
                {
                    "data": "mp",
                    "width": "20%"
                },
                {
                    "data": "g",
                    "width": "20%"
                },
                {
                    "data": "t",
                    "width": "20%"
                },
                {
                    "data": "unitCost",
                    "width": "20%"
                },
                {
                    "data": "costUnit",
                    "width": "20%"
                },
                {
                    "data": "costTotal",
                    "width": "20%"
                },
                {
                    "data": "partyToBeChargedName",
                    "width": "20%"
                } //51


            ],
            "drawCallback": function(settings) {
                // bind all button
                rebindAllBtn();
            },
            "columnDefs": [{
                    "orderable": false,
                    "width": "50px",
                    "targets": 2
                },
                {
                    "visible": false,
                    "targets": [15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31,
                        32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49,
                        50,51
                    ]
                }
            ]

        });

        $("#searchCaseFormBtn").unbind().bind("click", function() {
            table.ajax.reload(null, false);
        });
    });

    function constructPostParam(d) {
        var searchParamStr = "{";
        if ($("#caseNoSearchTxt").val() != null && $("#caseNoSearchTxt").val() != "") {
            searchParamStr += "\"parentCaseNo\":" + "\"" + $("#caseNoSearchTxt").val() + "\"" + ",";
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