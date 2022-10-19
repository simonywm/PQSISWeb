﻿<script>
$(function() {
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

    .overflow-x-hidden {
        /*   overflow-x: hidden; */
        border: 1px solid blue;
    }

    .is-hidden {
        opacity: 0;
        transition: transform 0.4s, opacity 0.2s;
    }

    .navbar-hide {
        pointer-events: none;
        opacity: 0;
    }

    .ui-autocomplete {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1030;
        float: left;
        display: none;
        min-width: 160px;
        padding: 4px 0;
        margin: 0 0 10px 25px;
        list-style: none;
        background-color: #ffffff;
        border-color: #ccc;
        border-color: rgba(0, 0, 0, 0.2);
        border-style: solid;
        border-width: 1px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        *border-right-width: 2px;
        *border-bottom-width: 2px;
    }

    .ui-menu-item>a.ui-corner-all {
        display: block;
        padding: 3px 15px;
        clear: both;
        font-weight: normal;
        line-height: 18px;
        color: #555555;
        white-space: nowrap;
        text-decoration: none;
    }

    .ui-state-hover,
    .ui-state-active {
        color: #ffffff;
        text-decoration: none;
        background-color: #0088cc;
        border-radius: 0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        background-image: none;
    }

    .invalid {
        background-color: #2774ad69;
    }


    .required {
        border-color: #800000;
        border-width: 3px;
    }

    .special-input input[type=number],
    input[type=datetime] {
        font-size: 17px;
        border: 1px solid grey;
        width: 20%;
        float: left;
        background: #f1f1f1;
    }

    /* Style the submit button */
    .special-input button {
        float: left;
        width: 20%;
        background: transparent;
        color: black;
        font-size: 17px;
        border: 1px solid grey;
        border-left: none;
        /* Prevent double borders */
        cursor: pointer;
    }

    .special-input button:hover {
        background: #0b7dda;
    }

    /* Clear floats */
    .special-input::after {
        content: "";
        clear: both;
        display: table;
    }
    </style>
</head>


<div class="card border border-secondary" style="background: #dee2e6;">
    <form id="Form" onsubmit=>
        <div class="card-header">
            <div class="row">
                <div class="col-lg-9">
                    <h3>Case Form</h3>
                </div>
                <div class="col-lg-3" style="text-align:right">

                    <button id="btnFormUpdate" name="btnFormUpdate" type="button"
                        class="btn btn-primary btnFormUpdate">Update</button>
                    <button id="btnFormCancel" name="btnFormCancel" type="button" class="btn btn-danger"
                        onclick="window.location.href = '<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch'">Cancel</button>
                </div>
            </div>
        </div>
        <nav id="topBar" class="sticky-top pl-4 py-1 d-flex flex-column " style="background-color:#6c757d;padding:0rem">
            <div class="row">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-5"><label>CaseNo <span class="text-danger">* </label></div>
                        <div class="col-lg-7">
                            <input id="txCaseNo" name="txCaseNo" type="number" class="" placeholder="" min="0"
                                max="99999" value="<?php echo $this->viewbag['serviceCaseForm']['serviceCaseId'] ?>"
                                readonly />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5"><label>Service Type <span class="text-danger">*</span></label></div>
                        <div class="col-lg-7">
                            <select class="" id="txServiceType" name="txServiceType" style="height:30px;width: 150px">
                                <option value="" disable> --- </option>

                                <?php $serviceTypeList = $this->viewbag['serviceTypeList']?>
                                <?php foreach ($serviceTypeList as $serviceType) {
    if ($serviceType['serviceTypeId'] == $this->viewbag['serviceCaseForm']['serviceTypeId']) {$selected = 'selected';} else { $selected = '';}?>
                                <option <?php echo $selected ?> value="<?php echo $serviceType["serviceTypeId"] ?>">
                                    <?php echo $serviceType["serviceTypeName"] ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-lg-3"><label>Problem Type<span class="text-danger">*</span></label></div>
                        <div class="col-lg-9">
                            <select class="" id="txProblemType" name="txProblemType" style="height:30px;width:200px">
                                <option value="">---</option>
                                <?php $problemTypeList = $this->viewbag['problemTypeList']?>
                                <?php foreach ($problemTypeList as $problemType) {
    if ($problemType['problemTypeId'] == $this->viewbag['serviceCaseForm']['problemTypeId']) {$selected = 'selected';} else { $selected = '';}?>
                                <option <?php echo $selected ?> value="<?php echo $problemType["problemTypeId"] ?>">
                                    <?php echo $problemType["problemTypeName"] ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row ">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-5"><label for="txIdrOrderId">IDR Order Id </label></div>
                        <div class="col-lg-7">
                            <input id="txIdrOrderId" name="txIdrOrderId" type="number" `0class="" placeholder="" min="0"
                                max="99999" value="<?php echo $this->viewbag['serviceCaseForm']['idrOrderId'] ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5"><label>IncidentDate/Time </label></div>
                        <div class="col-lg-7">
                            <input id="txIncidentDate" name="txIncidentDate" type="date" class="" placeholder=""
                                value="<?php echo $this->viewbag['serviceCaseForm']['incidentDate'] ?>">
                            <input id="txIncidentTime" name="txIncidentTime" type="time" class="" placeholder=""
                                value="<?php echo $this->viewbag['serviceCaseForm']['incidentDateTime'] ?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-5"><label>Request Date <span class="text-danger">*</span></label></div>
                        <div class="col-lg-7">
                            <input id="txRequestDate" name="txRequestDate" type="date" class="" placeholder=""
                                value="<?php echo $this->viewbag['serviceCaseForm']['requestDate'] ?>">
                            <input id="txRequestTime" name="txRequestTime" type="time" class="" placeholder=""
                                value="<?php echo $this->viewbag['serviceCaseForm']['requestDateTime'] ?>">
                        </div>
                    </div>
                </div>

            </div>
            <div class="row ">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-5"><label>Requested By <span class="text-danger">*</span></label></div>
                        <div class="col-lg-7">
                            <input id="txRequestedBy" name="txRequestedBy" type="text" class="" placeholder=""
                                value="<?php echo $this->viewbag['serviceCaseForm']['requestedBy'] ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5"><label>CLP Person Department <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-lg-7">
                            <select class="" id="txClpPersonDepartment" name="txClpPersonDepartment"
                                style="height:30px;width: 150px">
                                <option value="">---</option>
                                <?php $requestedByDepartment = $this->viewbag['requestedByDept']?>
                                <?php foreach ($requestedByDepartment as $requestedBy) {
    if ($requestedBy == $this->viewbag['serviceCaseForm']['clpPersonDepartment']) {$selected = 'selected';} else { $selected = '';}?>
                                <option <?php echo $selected ?> value="<?php echo $requestedBy ?>">
                                    <?php echo $requestedBy ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-lg-3"><label>CLP Referred By</label></div>
                        <div class="col-lg-9">
                            <select class="" id="txClpReferredBy" name="txClpReferredBy"
                                style="height:30px;width:200px">
                                <option value="">---</option>
                                <?php $clpReferredByList = $this->viewbag['clpReferredByList']?>
                                <?php foreach ($clpReferredByList as $clpReferredBy) {
    if ($clpReferredBy['clpReferredById'] == $this->viewbag['serviceCaseForm']['clpReferredById']) {$selected = 'selected';} else { $selected = '';}?>
                                <option <?php echo $selected ?> value="<?php echo $clpReferredBy['clpReferredById'] ?>">
                                    <?php echo $clpReferredBy['clpReferredByName'] ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>

            </div>


        </nav>
        <div class="card-body">



            <div class="title" style="color:#2e64c7db"><label><b>Customer Information</b></label></div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5"><label>Customer Name <span class="text-danger">*</span></label></div>
                        <div class="col-lg-7">
                            <input id="txCustomerName" name="txCustomerName" type="text" class="" placeholder=""
                                style="width:80%"
                                value="<?php echo $this->viewbag['serviceCaseForm']['customerName'] ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                </div>
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-lg-3"><label>Customer Group<span class="text-danger">*</span></label></div>
                        <div class="col-lg-9">
                            <input id="txCustomerGroup" name="txCustomerGroup" type="text" class="" placeholder=""
                                style="width:100%"
                                value="<?php echo $this->viewbag['serviceCaseForm']['customerGroup'] ?>" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5"><label>Business Type</label></div>
                        <div class="col-lg-7">
                            <select class="" id="txBusinessType" name="txBusinessType" style="height:30px;width:100%">
                                <option value="">---</option>
                                <?php $businessTypeList = $this->viewbag['businessTypeList']?>
                                <?php foreach ($businessTypeList as $businessType) {
    if ($businessType['businessTypeId'] == $this->viewbag['serviceCaseForm']['businessTypeId']) {$selected = 'selected';} else { $selected = '';}?>
                                <option <?php echo $selected ?> value="<?php echo $businessType['businessTypeId'] ?>">
                                    <?php echo $businessType['businessTypeName'] ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                </div>
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-lg-3"><label>CLP Network</label></div>
                        <div class="col-lg-9">
                            <input id="txClpNetwork" name="txClpNetwork" type="text" class="" placeholder=""
                                style="width:100%"
                                value="<?php echo $this->viewbag['serviceCaseForm']['clpNetwork'] ?>" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5"><label>Contact Person <span class="text-danger">*</span></label></div>
                        <div class="col-lg-7">
                            <input id="txContactPerson" name="txContactPerson" type="text" class="" placeholder=""
                                style="width:100%"
                                value="<?php echo $this->viewbag['serviceCaseForm']['contactPersonName'] ?>" />
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-3"><label>Title <span class="text-danger">*</span></label></div>
                        <div class="col-lg-9">
                            <input id="txTitle" type="text" name="txTitle" class="" placeholder="" style="width:100%"
                                value="<?php echo $this->viewbag['serviceCaseForm']['contactPersonTitle'] ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-lg-3"><label>Contant No. *</label></div>
                        <div class="col-lg-9">
                            <input id="txContactNo" name="txContactNo" type="tel" class="" placeholder=""
                                style="width:200px"
                                value="<?php echo $this->viewbag['serviceCaseForm']['contactPersonNumber'] ?>" />
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="title" style="color:#2e64c7db"><label><b>Schedule</b></label></div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5"><label>Action By <span class="text-danger">*</span></label></div>
                        <div class="col-lg-7">
                            <select class="" id="txActionBy" name="txActionBy" style="height:30px;width:80%">
                                <option value="Service1">
                                    Service1
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5" style="padding-right:0px"><label>Customer Contacted Date <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-lg-7">
                            <input id="txCustomerContactedDate" name="txCustomerContactedDate" type="date" class=""
                                placeholder="" style="width:80%"
                                value="<?php echo $this->viewbag['serviceCaseForm']['customerContactedDate'] ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5"><label>Case Referred to CLPE <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-lg-7">
                            <select id="txCaseReferredToClpe" name="txCaseReferredToClpe" style="width:80%;height:30px">
                                <option value=""> --- </option>
                                <?php if ($this->viewbag['serviceCaseForm']['caseReferredToClpe'] == 'Y') {?>
                                <option selected value="Y"> Yes </option>
                                <option value="N"> No </option>
                                <?php } else {?>
                                <option value="Y"> Yes </option>
                                <option selected value="N"> No </option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5"><label>Service Status <span class="text-danger">*</span></label></div>
                        <div class="col-lg-7">
                            <select id="txServiceStatus" name="txServiceStatus" style="height:30px;width:100%">

                                <option value="">---</option>
                                <?php $serviceStatusList = $this->viewbag['serviceStatusList']?>
                                <?php foreach ($serviceStatusList as $serviceStatus) {
    if ($serviceStatus['serviceStatusId'] == $this->viewbag['serviceCaseForm']['serviceStatusId']) {$selected = 'selected';} else { $selected = '';}?>
                                <option <?php echo $selected ?> value="<?php echo $serviceStatus['serviceStatusId'] ?>">
                                    <?php echo $serviceStatus['serviceStatusName'] ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <div class="row" id="">

                <div class="col-lg-4" id="divRequestedVisitDate" hidden="true">
                    <div class="row">
                        <div class="col-lg-5"><label>Requested Visit Date</label></div>
                        <div class="col-lg-7">
                            <input id="txRequestedVisitDate" name="txRequestedVisitDate" type="date" class=""
                                placeholder="" style="width:80%"
                                value="<?php echo $this->viewbag['serviceCaseForm']['requestedVisitDate'] ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" id="divActualVisitDate" hidden="true">
                    <div class="row">
                        <div class="col-lg-5"><label>Actual Visit Date</label></div>
                        <div class="col-lg-7">
                            <input id="txActualVisitDate" name="txActualVisitDate" type="date" class="" placeholder=""
                                style="width:80%"
                                value="<?php echo $this->viewbag['serviceCaseForm']['actualVisitDate'] ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                </div>
            </div>
            <br />
            <div id="">
                <div class="row">
                    <div class="col-lg-4" id="divServiceStartDate" hidden="true">
                        <div class="row">
                            <div class="col-lg-5"><label>Service Start Date</label></div>
                            <div class="col-lg-7">
                                <input id="txServiceStartDate" name="txServiceStartDate" type="date" class=""
                                    placeholder="" style="width:80%"
                                    value="<?php echo $this->viewbag['serviceCaseForm']['serviceStartDate'] ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" id="divServiceCompletionDate" hidden="true">
                        <div class="row">
                            <div class="col-lg-5"><label>Service Completion Date</label></div>
                            <div class="col-lg-7">
                                <input id="txServiceCompletionDate" name="txServiceCompletionDate" type="date" class=""
                                    placeholder="" style="width:80%"
                                    value="<?php echo $this->viewbag['serviceCaseForm']['serviceCompletionDate'] ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4" id="divPlannedReportIssueDate" hidden="true">
                        <div class="row">
                            <div class="col-lg-5" style="padding-right:0px"><label>Planned Report Issue Date</label>
                                <button type="button" id="plannedReportIssueDateRecalculator" style="width:15%"><i
                                        class="fa fa-calculator" aria-hidden="true"></i></button>
                            </div>
                            <div class="col-lg-7">
                                <input id="txPlannedReportIssueDate" name="txPlannedReportIssueDate" type="date"
                                    class="" placeholder="" style="width:80%"
                                    value="<?php echo $this->viewbag['serviceCaseForm']['plannedReportIssueDate'] ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" id="divActualReportIssueDate" hidden="true">
                        <div class="row">
                            <div class="col-lg-5"><label>Actual Report Issue Date</label></div>
                            <div class="col-lg-7">
                                <input id="txActualReportIssueDate" name="txActualReportIssueDate" type="date" class=""
                                    placeholder="" style="width:80%"
                                    value="<?php echo $this->viewbag['serviceCaseForm']['actualReportIssueDate'] ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" id="divActualReportWorkingDay" hidden="true">
                        <div class="row">
                            <div class="col-lg-6"><label>Actual Report Working Days</label></div>
                            <div class="col-lg-6">
                                <input id="txActualReportWorkingDay" name="txActualReportWorkingDay" type="number"
                                    class="" placeholder="" style="width:60px"
                                    value="<?php echo $this->viewbag['serviceCaseForm']['actualReportWorkingDay'] ?>" />
                                <button type="button" id="actualReportWorkingDayRecalculator" style="width:15%"><i
                                        class="fa fa-calculator" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row" id="">
                <div class="col-lg-4">
                </div>

                <div class="col-lg-4" id="divActualWorkingDay" hidden="true">
                    <div class="row">
                        <div class="col-lg-5"><label>Actual Working Day(s) <span class="text-danger"></span></label>
                        </div>
                        <div class="col-lg-7">
                            <input id="txActualWorkingDay" name="txActualWorkingDay" type="number" class=""
                                placeholder="" style="width:80%"
                                value="<?php echo $this->viewbag['serviceCaseForm']['actualWorkingDay'] ?>" />
                            <button type="button" id="actualWorkingDayRecalculator" style="width:15%"><i
                                    class="fa fa-calculator" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" id="divActualResponseDay" hidden="true">
                    <div class="row">
                        <div class="col-lg-6"><label>Actual Response Day(s) <span class="text-danger"></span></label>
                        </div>
                        <div class="col-lg-6">
                            <input id="txActualResponseDay" name="txActualResponseDay" type="number" class=""
                                placeholder="" style="width:60px"
                                value="<?php echo $this->viewbag['serviceCaseForm']['actualResponseDay'] ?>" />
                        </div>
                    </div>
                </div>
            </div>





            <hr />
            <div class="title" style="color:#2e64c7db"><label><b>AECS Charge</b></label></div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Manpower(mandays) </label>

                        </div>
                        <!--                        <div class="col-lg-8" style="padding:0px 0px 0px 0px">-->
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>MP &nbsp;</label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="number" min="1" step="1" id="txManPowerMP" name="txManPowerMP"
                                        style="width:80px"
                                        value="<?php echo $this->viewbag['serviceCaseForm']['mp'] ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="row">
                        <div class="col-lg-3"> G </div>
                        <div class="col-lg-9">
                            <input type="number" min="1" id="txManPowerG" name="txManPowerG" style="width:80px"
                                value="<?php echo $this->viewbag['serviceCaseForm']['g'] ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="row">
                        <div class="col-lg-3"> T </div>
                        <div class="col-lg-9">
                            <input type="number" min="1" id="txManPowerT" name="txManPowerT" style="width:80px"
                                value="<?php echo $this->viewbag['serviceCaseForm']['t'] ?>" />
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5" style="padding-right:0px"><label>Reported by EIC <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-lg-7">
                            <select id="txReportedByEic" name="txReportedByEic" style="height:30px;width:100%">
                                <option value="">---</option>
                                <?php $eicList = $this->viewbag['eicList']?>
                                <?php foreach ($eicList as $eic) {
    if ($eic['eicId'] == $this->viewbag['serviceCaseForm']['eicId']) {$selected = 'selected';} else { $selected = '';}?>
                                <option <?php echo $selected ?> value="<?php echo $eic['eicId'] ?>">
                                    <?php echo $eic['eicName'] ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5">
                            <label>Unit Rate(HK$) <span class="text-danger">*</span></label>

                        </div>
                        <div class="col-lg-7">
                            <select id="txUnitRate" name="txUnitRate" style="height:30px;width:100%">
                                <option value="">---</option>
                                <?php $costTypeList = $this->viewbag['costTypeList']?>
                                <?php foreach ($costTypeList as $costType) {
    if ($costType['costTypeId'] == $this->viewbag['serviceCaseForm']['costTypeId']) {$selected = 'selected';} else { $selected = '';}?>
                                <option <?php echo $selected ?> value="<?php echo $costType['costTypeId'] ?>"
                                    serviceTypeId="<?php echo $costType['serviceTypeId'] ?>">
                                    <?php echo $costType['unitCost'] ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="row">
                        <div class="col-lg-3"> <label> Unit <span class="text-danger">*</span></label> </div>
                        <div class="col-lg-9">
                            <input type="number" id="txUnit" name="txUnit" min="0" style="width:80px"
                                value="<?php echo $this->viewbag['serviceCaseForm']['costUnit'] ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="row">
                        <div class="col-lg-3"> <label>Total </label> <span class="text-danger">*</span></div>
                        <div class="col-lg-9 special-input">
                            <input type="number" id="txTotal" name="txTotal" style="width:80%"
                                value="<?php echo $this->viewbag['serviceCaseForm']['costTotal'] ?>" />
                            <button type="button" id="totalRecalculator" style="width:20%"> <i class="fa fa-calculator"
                                    aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5" style="padding-right:0px"><label>Party to be Charged <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-lg-7">
                            <select id="txPartyToBeCharged" name="txPartyToBeCharged" style="height:30px;width:100%">
                                <option value="">---</option>
                                <?php $partyToBeChargedList = $this->viewbag['partyToBeChargedList']?>
                                <?php foreach ($partyToBeChargedList as $partyToBeCharged) {
    if ($partyToBeCharged['partyToBeChargedId'] == $this->viewbag['serviceCaseForm']['partyToBeChargedId']) {$selected = 'selected';} else { $selected = '';}?>
                                <option <?php echo $selected ?>
                                    value="<?php echo $partyToBeCharged['partyToBeChargedId'] ?>">
                                    <?php echo $partyToBeCharged['partyToBeChargedName'] ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="title" style="color:#2e64c7db"><label><b>Background</b></label></div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-3" style="padding-right:0px"><label>Plant Type </label></div>
                        <div class="col-lg-7" style="padding-left:5px">
                            <select id="txPlantType" name="txPlantType" style="height:30px;width:100%">
                                <option value="">---</option>
                                <?php $plantTypeList = $this->viewbag['plantTypeList']?>
                                <?php foreach ($plantTypeList as $plantType) {
    if ($plantType['plantTypeId'] == $this->viewbag['serviceCaseForm']['plantTypeId']) {$selected = 'selected';} else { $selected = '';}?>
                                <option <?php echo $selected ?> value="<?php echo $plantType['plantTypeId'] ?>">
                                    <?php echo $plantType['plantTypeName'] ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-lg-5" style="padding-right:0px"><label>Manufactuer Brand</label></div>
                        <div class="col-lg-7">
                            <input type="text" id="txManufacturerBrand" name="txManufacturerBrand"
                                value="<?php echo $this->viewbag['serviceCaseForm']['manufacturerBrand'] ?>" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-3" style="padding-right:0px"><label>Major Affected Element </label></div>
                        <div class="col-lg-7" style="padding-left:5px">
                            <select id="txMajorAffectedElement" name="txMajorAffectedElement"
                                style="height:30px;width:100%">
                                <option value="">---</option>
                                <?php $majorAffectedElementList = $this->viewbag['majorAffectedElementList']?>

                                <?php foreach ($majorAffectedElementList as $majorAffectedElement) {
    if ($majorAffectedElement['majorAffectedElementId'] == $this->viewbag['serviceCaseForm']['majorAffectedElementId']) {$selected = 'selected';} else { $selected = '';}?>
                                <option <?php echo $selected ?>
                                    value="<?php echo $majorAffectedElement['majorAffectedElementId'] ?>">
                                    <?php echo $majorAffectedElement['majorAffectedElementName'] ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-lg-5" style="padding-right:0px"><label>Plant Rating</label></div>
                        <div class="col-lg-7">
                            <input type="text" id="txPlantRating" name="txPlantRating"
                                value="<?php echo $this->viewbag['serviceCaseForm']['plantRating'] ?>" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-3" style="">
                            <label>Customer's Problems <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-lg-9" style="padding-left:5px">
                            <textarea id="txCustomerProblems" name="txCustomerProblems" rows="5" style="width:100%"
                                itemscope=""><?php echo $this->viewbag['serviceCaseForm']['customerProblem'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="title" style="color:#2e64c7db"><label><b>Findings</b></label></div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-3" style="">
                            <label>Actions and Finding</label>
                        </div>
                        <div class="col-lg-9" style="padding-left:5px">
                            <textarea id="txActionsAndFinding" name="txActionsAndFinding" rows="5" style="width:100%"
                                itemscope=""><?php echo $this->viewbag['serviceCaseForm']['actionAndFinding'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-3" style="">
                            <label>Recommendation</label>
                        </div>
                        <div class="col-lg-9" style="padding-left:5px">
                            <textarea id="txRecommendation" name="txRecommendation" rows="5" style="width:100%"
                                itemscope=""><?php echo $this->viewbag['serviceCaseForm']['recommendation'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-3" style="">
                            <label>Remark</label>
                        </div>
                        <div class="col-lg-9" style="padding-left:5px">
                            <textarea id="txRemark" name="txRemark" rows="5" style="width:100%"
                                itemscope=""><?php echo $this->viewbag['serviceCaseForm']['remark'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-2">
                    <label>Required Follow-up <span class="text-danger">*</span></label>
                </div>
                <div class="col-lg-2">
                    <?php if ($this->viewbag['serviceCaseForm']['requiredFollowUp']) {?>
                    <input checked type="checkbox" id="txRequiredFollowUp" name="txRequiredFollowUp" />
                    <?php } else {?>
                    <input type="checkbox" id="txRequiredFollowUp" name="txRequiredFollowUp" />
                    <?php }?>

                </div>
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-3"><label>Implemented Solution</label></div>
                        <div class="col-lg-9">

                            <input type="text" id="txImplementedSolution" name="txImplementedSolution" style="width:80%"
                                value="<?php echo $this->viewbag['serviceCaseForm']['implementedSolution'] ?>" />
                        </div>
                    </div>
                </div>
                <br />
                <br />

            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-3" style="padding-right:0px"><label>Active? </label></div>
                        <div class="col-lg-7" style="padding-left:5px">
                            <select id="txActive" name="txActive" style="height:30px;width:100%">
                                <?php if ($this->viewbag['serviceCaseForm']['active'] == 'Y') {?>
                                <option selected value="Y"> Yes </option>
                                <option value="N"> No </option>
                                <?php } else {?>
                                <option value="Y"> Yes </option>
                                <option selected value="N"> No </option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>


            </div>
            <div class="card-footer">
                <div class="row">
                </div>
                <div class="col-lg-12" style="text-align:left">
                    <button id="btnFormUpdate" name="btnFormUpdate" type="button" class="btn btn-primary btnFormUpdate"
                        style="width:100%">Update</button>
                    <button id="btnFormCancel" name="btnFormCancel" type="button" class="btn btn-danger"
                        style="width:100%"
                        onclick="window.location.href = '<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch'">Cancel</button>

                </div>
            </div>
        </div>

</div>
</form>
</div>


</body>

</html>
<script>
$(document).ready(function() {

    var availableTags = [
        <?php foreach ($this->viewbag['requestedByAutoCompleteList'] as $requestedBy) {?> "<?php echo $requestedBy ?>",
        <?php }?>
    ];

    $("#txRequestedBy").autocomplete({

        source: function(request, response) {
            var results = $.ui.autocomplete.filter(availableTags, request.term);
            response(results.slice(0, 10));
        }
    });
    $("#txRequestedBy").change(function() {
        value = $(this).val().trim();
        switch (value) {
            <?php foreach ($this->viewbag['requestedByList'] as $requestedBy) {?>
            case "<?php echo $requestedBy['requestedByName'] ?>":
                $("#txClpPersonDepartment option[value='<?php echo $requestedBy['requestedByDept'] ?>']")
                    .attr("selected", "true");
                $("#txClpPersonDepartment").val("<?php echo $requestedBy['requestedByDept'] ?>");
                break;
                <?php }?>
        }
    });
    $("#totalRecalculator").unbind().bind("click", function() {
        value = $("#txUnitRate").find("option:selected").text().trim() * $("#txUnit").val();
        $("#txTotal").val(value);
        $("#txTotal").focus();
    });

    $("#txServiceCompletionDate").change(function() {

        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxGetPlannedReportIssueWorkingDate&numberOfWorkingDay=10", //10workingDay
            type: "POST",
            cache: false,
            data: $("#Form").serializeArray(),
            success: function(data) {
                console.log(data);
                var retJson = JSON.parse(data);

                if (retJson.status == "OK") {
                    // display message
                    $("#txPlannedReportIssueDate").val(retJson.Date);

                } else {
                    // error message
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", retJson
                        .retMessage);
                }
            }
        }).fail(function(event, jqXHR, settings, thrownError) {
            if (event.status != 440) {
                showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event.retMessage);
            }
        }).always(function(data) {

        });
    });

    $("#plannedReportIssueDateRecalculator").unbind().bind("click", function() {
        $("#loading-modal").modal("show");
        $(this).attr("disabled", true);
        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxGetPlannedReportIssueWorkingDate&numberOfWorkingDay=10", //10workingDay
            type: "POST",
            cache: false,
            data: $("#Form").serializeArray(),
            success: function(data) {
                console.log(data);
                var retJson = JSON.parse(data);

                if (retJson.status == "OK") {
                    // display message
                    $("#txPlannedReportIssueDate").val(retJson.Date);

                } else {
                    // error message
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", retJson
                        .retMessage);
                }
            }
        }).fail(function(event, jqXHR, settings, thrownError) {
            if (event.status != 440) {
                showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event.retMessage);
            }
        }).always(function(data) {
            $("#loading-modal").modal("hide");
            $("#plannedReportIssueDateRecalculator").attr("disabled", false);
        });
    });

    $("#actualReportWorkingDayRecalculator").unbind().bind("click", function() {
        $("#loading-modal").modal("show");
        $(this).attr("disabled", true);
        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxGetActualReportWorkingDay", //10workingDay
            type: "POST",
            cache: false,
            data: $("#Form").serializeArray(),
            success: function(data) {
                console.log(data);
                var retJson = JSON.parse(data);

                if (retJson.status == "OK") {
                    // display message
                    $("#txActualReportWorkingDay").val(retJson.numberOfWorkingDay);

                } else {
                    // error message
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", retJson
                        .retMessage);
                }
            }
        }).fail(function(event, jqXHR, settings, thrownError) {
            if (event.status != 440) {
                showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event.retMessage);
            }
        }).always(function(data) {
            $("#loading-modal").modal("hide");
            $("#actualReportWorkingDayRecalculator").attr("disabled", false);
        });
    });
    $("#actualWorkingDayRecalculator").unbind().bind("click", function() {
        $("#loading-modal").modal("show");
        $(this).attr("disabled", true);
        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxGetActualWorkingDay", //10workingDay
            type: "POST",
            cache: false,
            data: $("#Form").serializeArray(),
            success: function(data) {
                console.log(data);
                var retJson = JSON.parse(data);

                if (retJson.status == "OK") {
                    // display message
                    $("#txActualWorkingDay").val(retJson.numberOfWorkingDay);

                } else {
                    // error message
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", retJson
                        .retMessage);
                }
            }
        }).fail(function(event, jqXHR, settings, thrownError) {
            if (event.status != 440) {
                showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event.retMessage);
            }
        }).always(function(data) {
            $("#loading-modal").modal("hide");
            $("#actualWorkingDayRecalculator").attr("disabled", false);
        });
    });
    $("#txUnitRate").change(function() {
        value = $("#txUnitRate").find("option:selected").text().trim() * $("#txUnit").val();
        $("#txTotal").val(value);
    });
    $("#txUnit").change(function() {
        value = $("#txUnitRate").find("option:selected").text().trim() * $("#txUnit").val();
        $("#txTotal").val(value);
    });
    $("#txServiceType").change(function(e) {
        value = $(this).find("option:selected").val();
        switch (value) {
            case 1: //Enquiry
                $("#divRequestedVisitDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualVisitDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divServiceStartDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divServiceCompletionDate").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divPlannedReportIssueDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualReportIssueDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualReportWorkingDay").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualResponseDay").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divActualWorkingDay").attr({
                    "hidden": false,
                    "disable": false
                });
                break;
            case 2: //Site Visit
                $("#divRequestedVisitDate").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divActualVisitDate").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divServiceStartDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divServiceCompletionDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divPlannedReportIssueDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualReportIssueDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualReportWorkingDay").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualResponseDay").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divActualWorkingDay").attr({
                    "hidden": false,
                    "disable": false
                });
                break;
            case 3: //Investigation (L)
                $("#divRequestedVisitDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualVisitDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divServiceStartDate").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divServiceCompletionDate").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divPlannedReportIssueDate").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divActualReportIssueDate").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divActualReportWorkingDay").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divActualResponseDay").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualWorkingDay").attr({
                    "hidden": true,
                    "disable": true
                });
                break;
            case 4: //Investigation (S)
                $("#divRequestedVisitDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualVisitDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divServiceStartDate").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divServiceCompletionDate").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divPlannedReportIssueDate").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divActualReportIssueDate").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divActualReportWorkingDay").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divActualResponseDay").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualWorkingDay").attr({
                    "hidden": true,
                    "disable": true
                });
                break;
            case 5: //Reach Out
                $("#divRequestedVisitDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualVisitDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divServiceStartDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divServiceCompletionDate").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divPlannedReportIssueDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualReportIssueDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualReportWorkingDay").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualResponseDay").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divActualWorkingDay").attr({
                    "hidden": false,
                    "disable": false
                });
                break;
            case 6: //"PQ workshop visit":
                break;
            case " --- ":
                $("#divRequestedVisitDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualVisitDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divServiceStartDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divServiceCompletionDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divPlannedReportIssueDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualReportIssueDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualReportWorkingDay").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualResponseDay").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualWorkingDay").attr({
                    "hidden": true,
                    "disable": true
                });
                break;
            default:
                $("#divRequestedVisitDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualVisitDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divServiceStartDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divServiceCompletionDate").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divPlannedReportIssueDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualReportIssueDate").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualReportWorkingDay").attr({
                    "hidden": true,
                    "disable": true
                });
                $("#divActualResponseDay").attr({
                    "hidden": false,
                    "disable": false
                });
                $("#divActualWorkingDay").attr({
                    "hidden": false,
                    "disable": false
                });
                break;
        }
        var serviceTypeId = $(this).find("option:selected").val();
        var found = 0;
        $("#txUnitRate option").each(function(index) {
            if ($(this).attr("serviceTypeId") == serviceTypeId) {
                $(this).attr("selected", true);
                $("#txUnitRate").val($(this).val());
                $(this).attr("disabled", false);
                found = 1;
            } else if ($(this).val() != "") {
                $(this).attr("disabled", true);
            }
            if (found == 0) {
                $("#txUnitRate option[value='']").attr("selected", true);
                $("#txUnitRate").val("");
            }
        });
    });


    $(".btnFormUpdate").unbind().bind("click", function() {
        if (!validateInput()) {
            return;
        }
        $("#loading-modal").modal("show");
        $(this).attr("disabled", true);


        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxUpdateCaseForm",
            type: "POST",
            cache: false,
            data: $("#Form").serializeArray(),
            success: function(data) {
                console.log(data);
                var retJson = JSON.parse(data);

                if (retJson.status == "OK") {
                    // display message
                    showMsg("<i class=\"fas fa-check-circle\"></i> ", "Info",
                        "Case Form updated.", "",
                        function() {

                            //            table.ajax.reload(null, false);

                        });

                } else {
                    // error message
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", retJson
                        .retMessage);
                }
            }
        }).fail(function(event, jqXHR, settings, thrownError) {
            if (event.status != 440) {
                showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event.retMessage);
            }
        }).always(function(data) {
            $("#loading-modal").modal("hide");
            $(".btnFormUpdate").attr("disabled", false);
        });
    });

    function validateInput() {
        //  if ($("#txCaseNo").val() == "") {
        //  showError("<i class=\"fas fa-times-circle\"></i> ", "Error", "Case No can not be blank");
        //      return false;
        //  }
        $("#Form input ").each(function(index, value) {
            $(this).removeClass("invalid");
        });
        $("#Form select ").each(function(index, value) {
            $(this).removeClass("invalid");
        });
        var errorMessage = "";
        var i = 1;
        if ($("#txServiceType").val() == "") {

            if (errorMessage == "")
                $("#txServiceType").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Services Type Name can not be blank <br/>";

            i = i + 1;
            $("#txServiceType").addClass("invalid");
        }
        if ($("#txProblemType").val() == "") {

            if (errorMessage == "")
                $("#txProblemType").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Problem Type Name can not be blank <br/>";

            i = i + 1;
            $("#txServiceType").addClass("invalid");
        }
        if ($("#txRequestDate").val() == "") {
            if (errorMessage == "")
                $("#txRequestDate").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Request Date can not be blank <br/>";
            i = i + 1;
            $("#txRequestDate").addClass("invalid");
        }
        if ($("#txRequestTime").val() == "") {
            if (errorMessage == "")
                $("#txRequestTime").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Request Date Time can not be blank <br/>";
            i = i + 1;
            $("#txRequestTime").addClass("invalid");
        }
        if ($("#txRequestedBy").val() == "") {
            if (errorMessage == "")
                $("#txRequestedBy").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Requested By can not be blank <br/>";
            i = i + 1;
            $("#txRequestedBy").addClass("invalid");
        }
        if ($("#txClpPersonDepartment").val() == "") {
            if (errorMessage == "")
                $("#txClpPersonDepartment").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "CLP Person Department can not be blank <br/>";
            i = i + 1;
            $("#txClpPersonDepartment").addClass("invalid");
        }
        if ($("#txCustomerName").val() == "") {
            if (errorMessage == "")
                $("#txCustomerName").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Customer Name can not be blank <br/>";
            i = i + 1;
            $("#txCustomerName").addClass("invalid");
        }
        if ($("#txCustomerGroup").val() == "") {
            if (errorMessage == "")
                $("#txCustomerGroup").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Customer Group Name can not be blank <br/>";
            i = i + 1;
            $("#txCustomerGroup").addClass("invalid");
        }
        if ($("#txContactPerson").val() == "") {
            if (errorMessage == "")
                $("#txContactPerson").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Contact Person can not be blank <br/>";
            i = i + 1;
            $("#txContactPerson").addClass("invalid");
        }
        if ($("#txTitle").val() == "") {
            if (errorMessage == "")
                $("#txTitle").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Title can not be blank <br/>";
            i = i + 1;
            $("#txTitle").addClass("invalid");
        }
        if ($("#txActionBy").val() == "") {
            if (errorMessage == "")
                $("#txActionBy").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Action By can not be blank <br/>";
            i = i + 1;
            $("#txActionBy").addClass("invalid");
        }
        if ($("#txCustomerContactedDate").val() == "") {
            if (errorMessage == "")
                $("#txCustomerContactedDate").focus();
            errorMessage = errorMessage + "Error " + i + ": " +
                "Customer Contacted Date By can not be blank <br/>";
            i = i + 1;
            $("#txCustomerContactedDate").addClass("invalid");
        }
        /*
        if ($("#txActualResponseDay").val() == "") {
            if(errorMessage =="")
            $("#txActualResponseDay").focus();
            errorMessage = errorMessage + "Error " + i +": " + "Actual Response Days can not be blank <br/>";
            i =i+1;
            $("#txActualResponseDay").addClass("invalid");
        }
        if ($("#txActualWorkingDay").val() == "") {
            if(errorMessage =="")
            $("#txActualWorkingDay").focus();
            errorMessage = errorMessage + "Error " + i +": " + "Actual Working Days can not be blank <br/>";
            i =i+1;
            $("#txActualWorkingDay").addClass("invalid");
        }
        */
        if ($("#txCaseReferredToClep").val() == "") {
            if (errorMessage == "")
                $("#txCaseReferredToClep").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Case Referred To CLPE can not be blank <br/>";
            i = i + 1;
            $("#txCaseReferredToClep").addClass("invalid");
        }
        if ($("#txServiceStatus").val() == "") {
            if (errorMessage == "")
                $("#txServiceStatus").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Service Status To CLPE can not be blank <br/>";
            i = i + 1;
            $("#txServiceStatus").addClass("invalid");
        }
        if ($("#txReportedByEic").val() == "") {
            if (errorMessage == "")
                $("#txReportedByEic").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Report By EIC To CLPE can not be blank <br/>";
            i = i + 1;
            $("#txReportedByEic").addClass("invalid");
        }
        if ($("#txUnitRate").val() == "") {
            if (errorMessage == "")
                $("#txUnitRate").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Unit Rate can not be blank <br/>";
            i = i + 1;
            $("#txUnitRate").addClass("invalid");
        }
        if ($("#txUnit").val() == "") {
            if (errorMessage == "")
                $("#txUnit").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Unit can not be blank <br/>";
            i = i + 1;
            $("#txUnit").addClass("invalid");
        }
        if ($("#txTotal").val() == "") {
            if (errorMessage == "")
                $("#txTotal").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Total can not be blank <br/>";
            i = i + 1;
            $("#txTotal").addClass("invalid");
        }
        if ($("#txPartyToBeCharge").val() == "") {
            if (errorMessage == "")
                $("#txPartyToBeCharge").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Party To Be Charged can not be blank <br/>";
            i = i + 1;
            $("#txPartyToBeCharge").addClass("invalid");
        }
        if ($("#txCustomerProblems").val() == "") {
            if (errorMessage == "")
                $("#txCustomerProblems").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Customer Problems can not be blank <br/>";
            i = i + 1;
            $("#txCustomerProblems").addClass("invalid");
        }
        if (errorMessage == "") {
            return true;
        } else {
            showError("<i class=\"fas fa-times-circle\"></i> ", "Error", errorMessage);
            return false;
        }
    }



    var previousScroll = 0;
    $(window).scroll(function() {
        if ($(window).width() > 1000) {
            $("#topBar").addClass("sticky-top");
            var currentScroll = $(this).scrollTop();
            if (currentScroll < 700) {
                showNav();
            } else if (currentScroll > 0 && currentScroll < $(document).height() - $(window).height()) {
                if (currentScroll > previousScroll) {
                    hideNav();
                } else {}
                previousScroll = currentScroll;
            }
        } else {
            $("#topBar").removeClass("sticky-top");
        };
    });

    function hideNav() {
        $("#topBar").removeClass("is-visible").addClass("is-hidden");
    }

    function showNav() {
        $("#topBar").removeClass("is-hidden").addClass("is-visible").addClass("scrolling");
    }



});
</script>