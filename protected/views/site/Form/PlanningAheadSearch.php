<script>
$(function() {
    $("#aMenuFormLinkPH").addClass("active");
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
    <div class="container" style="">
        <div style="text-align:center;">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#searchDiv"
                aria-expanded="false" aria-controls="searchDiv">
                Open Search box
            </button>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-9">
                        <h3>Planning Ahead Search</h3>
                    </div>
                    <div class="col-lg-3" style="text-align:right">
                        <button id="searchBtn" type="button" class="btn btn-success">Search</button>

                        <button id="newBtn" name="newBtn" <?php echo $this->viewbag['disabled'] ?> type="button"
                            class="btn btn-primary"
                            onclick="window.location.href='<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/GetPlanningAheadForNew'">New</button>
                    </div>
                </div>

            </div>
            <div class="card-body collapse" id="searchDiv">
                <div class="row">
                    <div class="col-md-3">
                        Project Ref
                    </div>
                    <div class="col-md-9">
                        <input id="projectRefSearchTxt" name="projectRefSearchTxt" type="number" class="form-control" />
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-3">
                        Project Title
                    </div>
                    <div class="col-md-9">
                        <input id="projectTitleSearchTxt" name="projectTitleSearchTxt" type="text" class="form-control"
                            placeholder="" />
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-3">
                        Reported By
                    </div>
                    <div class="col-md-9">
                        <input id="reportedBySearchTxt" name="reportedBySearchTxt" type="text" class="form-control"
                            placeholder="" />
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-3">
                        Project Region
                    </div>
                    <div class="col-md-9">
                        <input id="projectRegionSearchSel" name="projectRegionSearchSel" type="text"
                            class="form-control">


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
            </div>
        </div>
    </div>
    <br />
    <div class="row justify-content-center">
        <div class="col-12">
            <table id="Table" width="100%" style="white-space:nowrap;" class="display">
                <thead>
                    <tr>
                        <td width="10"> Project Ref</td>
                        <td width="10%">Project Title </td>
                        <td width="10%">Reported By </td>
                        <td width="10%">Project Region </td>
                        <td width="10%">Project Address </td>
                        <td width="10%">Active </td>
                        <td width="10%"> </td>
                        <td width="10%">Scheme Number/PBE</td>
                        <td width="10%">PQSIS Case No </td>
                        <td width="10%">Input Date </td><!-- 10 -->
                        <td width="10%">Region letter Issue Date </td>
                        <td width="10%">Last Updated By </td>
                        <td width="10%">Last Updated Date </td>
                        <td width="10%">Region Planner</td>
                        <td width="10%">Building Type</td>
                        <td width="10%">Project Type </td>
                        <td width="10%">Key infrastructure </td>
                        <td width="10%">Potential Successful Case </td>
                        <td width="10%">Critical Project </td>
                        <td width="10%">Temp Supply Project </td><!-- 20 -->
                        <td width="10%">BMS </td>
                        <td width="10%">Change Over Scheme </td>
                        <td width="10%">Chiller Plant </td>
                        <td width="10%">Escalator </td>
                        <td width="10%">Hid Lamp </td>
                        <td width="10%">Lift </td>
                        <td width="10%">Sensitive Machine </td>
                        <td width="10%">Telcom </td>
                        <td width="10%">acbTripping </td>
                        <td width="10%">Building With High Penetration Equipment </td><!-- 30 -->
                        <td width="10%">RE </td>
                        <td width="10%">EV </td>
                        <td width="10%">Estimated Load </td>
                        <td width="10%">PQIS Number </td>
                        <td width="10%">PQ site walk Project Region </td>
                        <td width="10%">PQ site walk Project Address </td>
                        <td width="10%">Sensitive Equipment and Corresponding Mitigation Solutions Found During Site
                            Walk </td>
                        <td width="10%">1st PQ site Walk Date </td>
                        <td width="10%">1st PQ site Walk Status </td>
                        <td width="10%">1st PQ site walk invitation letter’s link </td><!-- 40 -->
                        <td width="10%">Letter for request 1st PQ site walk date </td>
                        <td width="10%">PQ walk assessment report Date </td>
                        <td width="10%">PQ walk assessment report link/path </td>
                        <td width="10%">1st PQ site Walk PQSIS Case No </td>
                        <td width="10%">1st Customer response for site walk </td>
                        <td width="10%">1st Investigation Status </td>
                        <td width="10%">2nd PQ site Walk Date </td>
                        <td width="10%">2nd PQ site walk invitation letter’s link </td>
                        <td width="10%">Letter for request 2nd PQ site walk date </td>
                        <td width="10%">PQ assessment follow up report Date </td><!-- 50 -->
                        <td width="10%">PQ assessment follow up report link/path </td>
                        <td width="10%">2nd PQ site Walk PQSIS Case No </td>
                        <td width="10%">2nd Customer response for site walk </td>
                        <td width="10%">2nd Investigation Status </td>
                        <td width="10%">Consultant Company Name </td>
                        <td width="10%">Consultant Name </td>
                        <td width="10%">Phone No.1 </td>
                        <td width="10%">Phone No.2 </td>
                        <td width="10%">Phone No.3 </td>
                        <td width="10%">email 1 </td><!-- 60 -->
                        <td width="10%">email 2 </td>
                        <td width="10%">email 3 </td>
                        <td width="10%">consultant information remark </td>
                        <td width="10%">Estimated Commisioning Date(By Customer) </td>
                        <td width="10%">Estimated Commisioning Date(By Region) </td>
                        <td width="10%"> Planning Ahead Status </td>
                        <td width="10%"> Plan ahead meeting Date</td>
                        <td width="10%"> Reply Slip PQSIS Case No </td>
                        <td width="10%"> Target Reply Slip return Date </td>
                        <td width="10%"> Finish?</td><!-- 70 -->
                        <td width="10%"> Actual Reply Slip Return Date</td>
                        <td width="10%"> Findings from Reply Slip</td>
                        <td width="10%"> Follow Up Action?</td>
                        <td width="10%"> Follow Up Action</td>
                        <td width="10%"> Reply Slip Remark</td>
                        <td width="10%"> Plan ahead meeting Fax Link</td>
                        <td width="10%"> Reply Slip Fax Link</td>
                        <td width="10%"> Del reply Slip Grade</td>
                        <td width="10%"> Date of requested for return reply slip</td>
                        <td width="10%"> Receive Complaint</td><!-- 80 -->
                        <td width="10%"> Follow-up Action</td>
                        <td width="10%"> Remark</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>


    <script>
    $(function() {

        <?php if (isset($this->viewbag['iframe'])) { ?>
        if ("<?php echo $this->viewbag['iframe']?>" == "caseForm") {
            $("#newBtn").attr("onclick",
                "window.location.href='<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/GetPlanningAheadForNewForCaseForm'"
                )
        }
        <?php }?>
        table = $("#Table").DataTable({
            "serverSide": true,
            "autoWidth": true,
            "processing": true,
            "scrollX": true,
            "fixedHeader": true,
            "stateSave": false,
            "dom": 'Blipfrtip',
            buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 3, 4, 5, 7, 8, 9, 10, 2, 11, 12, 13, 14, 15, 16, 17, 18, 19,
                        20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36,
                        37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53,
                        54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70,
                        71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81
                    ],
                    //columns:[0,2,4,3,16,1,7,17,18,19,4,20,5,21,6,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,15,7,49,50,51]
                    format: {
                        body: function(data, row, column, node) {
                            if (column != 0)
                                return data;
                            return node.innerText;
                        }
                    }
                }

            }, ],
            "ajax": {
                "url": "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxGetPlanningAheadTable",
                "type": "POST",
                "contentType": 'application/json; charset=utf-8',
                "data": function(data) {
                    console.log(data);
                    return JSON.stringify(constructPostParam(data));
                }
            },
            //
            "order": [
                [0, "desc"]
            ],
            "aLengthMenu": [
                [100, 200, 500, 1000, 9000000],
                [100, 200, 500, 1000, "All"]
            ],
            "filter": false,
            "sPaginationType": "full_numbers",
            "columns": [
                {
                    "data": "planningAheadId",
                    render: function(data, type, row) {
                        var btnHtml =
                            "<a href='<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/GetPlanningAheadForRead&planningAheadId=" +
                            row.planningAheadId + "'>" + data + "</a>";
                        <?php if (isset($this->viewbag['iframe'])) { ?>
                        if ("<?php echo $this->viewbag['iframe']?>" == "caseForm") {
                            var btnHtml =
                                "<a href='<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/GetPlanningAheadForReadForCaseForm&planningAheadId=" +
                                row.planningAheadId + "'>" + data + "</a>";
                        }
                        <?php }?>
                        return btnHtml;
                    },

                    "width": "10%"
                },
                {
                    "data": "projectTitle",
                    render: function(data, type, row) {
                        return data;
                    },
                    "width": "10%"
                },
                //{ "data": "projectTitle", "width": "10%" },
                {
                    "data": "reportedBy",
                    "width": "5%"
                },
                {
                    "data": "projectRegion",
                    "width": "10%"
                },
                {
                    "data": "projectAddress",
                    "width": "20%"
                },
                {
                    "data": "active",
                    "width": "10%"
                },
                {
                    "data": "planningAheadId",
                    render: function(data, type, row) {

                        var btnHtml = "<button id='updateBtn-" + row.planningAheadId +
                            "' name='updateBtn' <?php echo $this->viewbag['disabled'] ?> class='btn btn-primary'  planningAheadId='" +
                            row.planningAheadId +
                            "'  onclick=\"window.location.href=\'<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/GetPlanningAheadForUpdate&planningAheadId=" +
                            row.planningAheadId + "\'\"> Modify </button> ";
                        <?php if (isset($this->viewbag['iframe'])) { ?>
                        if ("<?php echo $this->viewbag['iframe']?>" == "caseForm") {
                            var btnHtml = "<button id='updateBtn-" + row.planningAheadId +
                                "' name='updateBtn' <?php echo $this->viewbag['disabled'] ?> class='btn btn-primary'  planningAheadId='" +
                                row.planningAheadId +
                                "'  onclick=\"window.location.href=\'<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/GetPlanningAheadForUpdateForCaseForm&planningAheadId=" +
                                row.planningAheadId + "\'\"> Modify </button> ";
                        }
                        <?php }?>

                        return btnHtml;
                    },
                    "width": "10%"
                },
                {
                    "data": "schemeNumber",
                    "width": "20%"
                },
                {
                    "data": "projectAddressParentCaseNo",
                    render: function(data, type, row) {
                        if (row.projectAddressParentCaseNo != null) {
                            if (row.projectAddressCaseVersion != null) {
                                CaseNo = row.projectAddressParentCaseNo + "." + row
                                    .projectAddressCaseVersion;
                            } else {
                                CaseNo = row.projectAddressParentCaseNo;
                            }
                        } else {
                            CaseNo = "";
                        }
                        return CaseNo;
                    },
                    "width": "20%"
                },
                {
                    "data": "inputDate",
                    "width": "20%"
                }, //10
                {
                    "data": "regionLetterIssueDate",
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
                    "data": "regionPlannerName",
                    "width": "20%"
                },
                {
                    "data": "buildingTypeName",
                    "width": "20%"
                },
                {
                    "data": "projectTypeName",
                    "width": "20%"
                },
                {
                    "data": "keyInfrastructure",
                    "width": "20%"
                },
                {
                    "data": "potentialSuccessfulCase",
                    "width": "20%"
                },
                {
                    "data": "criticalProject",
                    "width": "20%"
                },
                {
                    "data": "tempSupplyProject",
                    "width": "20%"
                }, //20
                {
                    "data": "bms",
                    "width": "20%"
                },
                {
                    "data": "changeoverScheme",
                    "width": "20%"
                },
                {
                    "data": "chillerPlant",
                    "width": "20%"
                },
                {
                    "data": "escalator",
                    "width": "20%"
                },
                {
                    "data": "hidLamp",
                    "width": "20%"
                },
                {
                    "data": "lift",
                    "width": "20%"
                },
                {
                    "data": "sensitiveMachine",
                    "width": "20%"
                },
                {
                    "data": "telcom",
                    "width": "20%"
                },
                {
                    "data": "acbTripping",
                    "width": "20%"
                },
                {
                    "data": "buildingWithHighPenetrationEquipment",
                    "width": "20%"
                }, //30
                {
                    "data": "re",
                    "width": "20%"
                },
                {
                    "data": "ev",
                    "width": "20%"
                },
                {
                    "data": "estimatedLoad",
                    "width": "20%"
                },
                {
                    "data": "pqisNumber",
                    "width": "20%"
                },
                {
                    "data": "pqSiteWalkProjectRegion",
                    "width": "20%"
                },
                {
                    "data": "pqSiteWalkProjectAddress",
                    "width": "20%"
                },
                {
                    "data": "sensitiveEquipment",
                    "width": "20%"
                },
                {
                    "data": "firstPqSiteWalkDate",
                    "width": "20%"
                },
                {
                    "data": "firstPqSiteWalkStatus",
                    "width": "20%"
                },
                {
                    "data": "firstPqSiteWalkInvitationLetterLink",
                    "width": "20%"
                }, //40
                {
                    "data": "firstPqSiteWalkRequestLetterDate",
                    "width": "20%"
                },
                {
                    "data": "pqWalkAssessmentReportDate",
                    "width": "20%"
                },
                {
                    "data": "pqWalkAssessmentReportLink",
                    "width": "20%"
                },
                {
                    "data": "firstPqSiteWalkParentCaseNo",
                    render: function(data, type, row) {
                        if (row.firstPqSiteWalkParentCaseNo != null) {
                            if (row.firstPqSiteWalkCaseVersion != null) {
                                CaseNo = row.firstPqSiteWalkParentCaseNo + "." + row
                                    .firstPqSiteWalkCaseVersion;
                            } else {
                                CaseNo = row.firstPqSiteWalkParentCaseNo;
                            }

                        } else {
                            CaseNo = "";
                        }

                        return CaseNo;
                    },
                    "width": "20%"
                },
                {
                    "data": "firstPqSiteWalkCustomerResponse",
                    "width": "20%"
                },
                {
                    "data": "firstPqSiteWalkInvestigationStatus",
                    "width": "20%"
                },
                {
                    "data": "secondPqSiteWalkDate",
                    "width": "20%"
                },
                {
                    "data": "secondPqSiteWalkInvitationLetterLink",
                    "width": "20%"
                },
                {
                    "data": "secondPqSiteWalkRequestLetterDate",
                    "width": "20%"
                },
                {
                    "data": "pqAssessmentFollowUpReportDate",
                    "width": "20%"
                }, //50
                {
                    "data": "pqAssessmentFollowUpReportLink",
                    "width": "20%"
                },
                {
                    "data": "secondPqSiteWalkParentCaseNo",
                    render: function(data, type, row) {

                        if (row.secondPqSiteWalkParentCaseNo != null) {
                            if (row.secondPqSiteWalkCaseVersion != null) {
                                CaseNo = row.secondPqSiteWalkParentCaseNo + "." + row
                                    .secondPqSiteWalkCaseVersion;
                            } else {
                                CaseNo = row.secondPqSiteWalkParentCaseNo;
                            }

                        } else {
                            CaseNo = "";
                        }
                        return CaseNo;
                    },
                    "width": "20%"
                },
                {
                    "data": "secondPqSiteWalkCustomerResponse",
                    "width": "20%"
                },
                {
                    "data": "secondPqSiteWalkInvestigationStatus",
                    "width": "20%"
                },
                {
                    "data": "consultantCompanyName",
                    "width": "20%"
                },
                {
                    "data": "consultantName",
                    "width": "20%"
                },
                {
                    "data": "phoneNumber1",
                    "width": "20%"
                },
                {
                    "data": "phoneNumber2",
                    "width": "20%"
                },
                {
                    "data": "phoneNumber3",
                    "width": "20%"
                },
                {
                    "data": "email1",
                    "width": "20%"
                }, //60
                {
                    "data": "email2",
                    "width": "20%"
                },
                {
                    "data": "email3",
                    "width": "20%"
                },
                {
                    "data": "consultantInformationRemark",
                    "width": "20%"
                },
                {
                    "data": "estimatedCommisioningDateByCustomer",
                    "width": "20%"
                },
                {
                    "data": "estimatedCommisioningDateByRegion",
                    "width": "20%"
                },
                {
                    "data": "planningAheadStatus",
                    "width": "20%"
                },
                {
                    "data": "invitationToPaMeetingDate",
                    "width": "20%"
                },
                {
                    "data": "replySlipParentCaseNo",
                    render: function(data, type, row) {
                        if (row.replySlipParentCaseNo != null) {
                            if (row.replySlipCaseVersion != null) {
                                CaseNo = row.replySlipParentCaseNo + "." + row
                                    .replySlipCaseVersion;
                            } else {
                                CaseNo = row.replySlipParentCaseNo;
                            }
                        } else {
                            CaseNo = "";
                        }
                        return CaseNo;
                    },
                    "width": "20%"
                },
                {
                    "data": "replySlipSentDate",
                    "width": "20%"
                },
                {
                    "data": "finish",
                    "width": "20%"
                }, //70
                {
                    "data": "actualReplySlipReturnDate",
                    "width": "20%"
                },
                {
                    "data": "findingsFromReplySlip",
                    "width": "20%"
                },
                {
                    "data": "replySlipfollowUpActionFlag",
                    "width": "20%"
                },
                {
                    "data": "replySlipfollowUpAction",
                    "width": "20%"
                },
                {
                    "data": "replySlipRemark",
                    "width": "20%"
                },
                {
                    "data": "replySlipSendLink",
                    "width": "20%"
                },
                {
                    "data": "replySlipReturnLink",
                    "width": "20%"
                },
                {
                    "data": "replySlipGradeName",
                    "width": "20%"
                },
                {
                    "data": "dateOfRequestedForReturnReplySlip",
                    "width": "20%"
                },
                {
                    "data": "receiveComplaint",
                    "width": "20%"
                }, //80
                {
                    "data": "followUpAction",
                    "width": "20%"
                },
                {
                    "data": "remark",
                    "width": "20%"
                }
            ],
            "drawCallback": function(settings) {
                // bind all button
                rebindAllBtn();
            },
            "columnDefs": [{
                    "targets": 5,
                    "orderable": false
                },
                {
                    "visible": false,
                    "targets": [15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31,
                        32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49,
                        50
                    ]
                }
            ]
        });

        $("#searchBtn").unbind().bind("click", function() {
            table.ajax.reload(null, false);
        });
    });

    function constructPostParam(d) {
        var searchParamStr = "{";
        if ($("#projectRefSearchTxt").val() != null && $("#projectRefSearchTxt").val() != "") {
            searchParamStr += "\"planningAheadId\":" + "\"" + $("#projectRefSearchTxt").val() + "\"" + ",";
        }
        if ($("#projectTitleSearchTxt").val() != null && $("#projectTitleSearchTxt").val() != "") {
            searchParamStr += "\"projectTitle\":" + "\"" + $("#projectTitleSearchTxt").val() + "\"" + ",";
        }
        if ($("#reportedBySearchTxt").val() != null && $("#reportedBySearchTxt").val() != "") {
            searchParamStr += "\"reportedBy\":" + "\"" + $("#reportedBySearchTxt").val() + "\"" + ",";
        }
        if ($("#projectRegionSearchSel").val() != null && $("#projectRegionSearchSel").val() != "") {
            searchParamStr += "\"projectRegion\":" + "\"" + $("#projectRegionSearchSel").val() + "\"" + ",";
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



    }
    </script>