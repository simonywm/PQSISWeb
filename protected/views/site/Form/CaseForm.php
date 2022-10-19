<script>
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

    .invalidSelectize .selectize-control.single .selectize-input {
        border: 5px ridge #2774ad69;
        border-color: #2774ad69;
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

    select[readonly] {
        pointer-events: none;
        background-color: #e9ecef;
    }

    .selectize-input.items.full.has-options.has-items.locked {
        background-color: #e9ecef;
    }
    </style>
</head>


<div class="card border border-secondary" style="background: #dee2e6;">
    <form id="Form" onsubmit=>
        <div class="card-header">
            <div class="row">
                <div class="col-lg-9">
                    <h3 id="title">Case Form</h3>
                </div>
                <div class="col-lg-3" style="text-align:right">

                    <button id="btnFormApply" name="btnFormApply" type="button"
                        class="btn btn-primary btnFormApply">Apply</button>
                    <button id="btnFormCancel" name="btnFormCancel" type="button"
                        class="btn btn-danger btnFormCancel">Cancel</button>
                    <button id="btnForMigrate" name="btnForMigrate" type="button" class="btn btn-primary btnForMigrate"
                        hidden>Migrate</button>

                </div>
            </div>
        </div>
        <nav id="topBar" class="sticky-top pl-4 py-1 d-flex flex-column " style="background-color:#6c757d;padding:0rem">



            <div class="row" id="divCaseNo" hidden="true">
                <div class="col-lg-5"><label>CaseNo * </label></div>
                <div class="col-lg-7">
                    <input id="txCaseNo" name="txCaseNo" type="number" class="" placeholder="" min="0" max="99999"
                        readonly />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="row" id="">
                        <div class="col-lg-5"><label>Case No * </label></div>
                        <div class="col-lg-7">
                            <input id="txParentCaseNo" name="txParentCaseNo" type="number" class=""
                                placeholder="Case No" min="0" max="99999" /> <b>.</b>
                            <input id="txCaseVersion" name="txCaseVersion" type="number" class="" step="1"
                                placeholder="" min="0" max="99999" style="width:50px" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5"><label>Service Type <span class="text-danger">*</span></label></div>
                        <div class="col-lg-7" id="divServiceType">
                            <select class="" id="txServiceType" name="txServiceType" style="height:30px;width: 150px">
                                <option value="" disable> ------ </option>

                                <?php $serviceTypeList = $this->viewbag['serviceTypeList']?>
                                <?php foreach ($serviceTypeList as $serviceType) {
    if ($serviceType['serviceTypeId'] != 19 && $serviceType['serviceTypeId'] != 20) { //disabled fixed serviceType
        ?>
                                <option value="<?php echo $serviceType["serviceTypeId"] ?>">
                                    <?php echo $serviceType["serviceTypeName"] ?></option>
                                <?php }}?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-lg-3"><label>Problem Type<span class="text-danger">*</span></label></div>
                        <div class="col-lg-9" id="divProblemType">
                            <select class="" id="txProblemType" name="txProblemType" style="height:30px;width:200px">
                                <option value="">------</option>
                                <?php $problemTypeList = $this->viewbag['problemTypeList']?>
                                <?php foreach ($problemTypeList as $problemType) {?>
                                <option value="<?php echo $problemType["problemTypeId"] ?>">
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
                        <div class="col-lg-5"><label for="txIdrOrderId">IDR Order Id </label>
                        </div>
                        <div class="col-lg-7" id="idrOrderIdDiv">
                            <input id="txIdrOrderId" name="txIdrOrderId" type="text" class="" placeholder="" />
                            <input id="txIncidentId" name="txIncidentId" type="text" class="" placeholder="" hidden />
                        </div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5"><label>Incident Date/Time </label></div>
                        <div class="col-lg-7">
                            <input id="txIncidentDate" name="txIncidentDate" style="width:60%" type="text" class=""
                                placeholder="YYYY-MM-DD" value="">
                            <input id="txIncidentTime" name="txIncidentTime" style="width:30%" type="text" class=""
                                placeholder="HH:mm" value="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-auto" style="min-width:31.2%"><label>Request Date <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-lg-7" id="divRequestDate">
                            <input id="txRequestDate" name="txRequestDate" style="width:60%" type="text" class=""
                                placeholder="YYYY-MM-DD" value="">
                            <input id="txRequestTime" name="txRequestTime" style="width:30%" type="text" class=""
                                placeholder="HH:mm" value="00:00" hidden>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row ">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-5"><label>Requested By <span class="text-danger">*</span></label></div>
                        <div class="col-lg-7" id="divRequestedBy">
                            <input id="txRequestedBy" name="txRequestedBy" type="text" class="" placeholder="" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5"><label>CLP Person Department <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-lg-7" id="divClpPersonDepartment">
                            <select class="" id="txClpPersonDepartment" name="txClpPersonDepartment"
                                style="height:30px;width: 150px">
                                <option value="">------</option>
                                <?php $requestedByDepartment = $this->viewbag['requestedByDept']?>
                                <?php foreach ($requestedByDepartment as $requestedBy) {?>
                                <option value="<?php echo $requestedBy ?>"><?php echo $requestedBy ?></option>
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
                                <option value="">------</option>
                                <?php $clpReferredByList = $this->viewbag['clpReferredByList']?>
                                <?php foreach ($clpReferredByList as $clpReferredBy) {?>
                                <option value="<?php echo $clpReferredBy['clpReferredById'] ?>">
                                    <?php echo $clpReferredBy['clpReferredByName'] ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="card-body">
            <div id="incidentDiv" class="collapse">
                <div class="title" style="color:#2e64c7db"><label><b>Incident Information</b></label></div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-5"><label>IDR No </span></label></div>
                            <div class="col-lg-7">
                                <input id="idrNo" name="" type="text" class="" placeholder="" style="width:80%"
                                    readonly />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-5"><label>Incident Date</span></label></div>
                            <div class="col-lg-7">
                                <input id="incidentDate" name="" type="datetime" class="" placeholder=""
                                    style="width:80%" readonly />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" id="">
                        <div class="row">
                            <div class="col-lg-5"><label> Voltage </label></div>
                            <div class="col-lg-7">
                                <input id="voltage" name="" type="text" class="" placeholder="" style="width:80%"
                                    readonly />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-5"><label> Circuit </label></div>
                            <div class="col-lg-7">
                                <input id="circuit" name="" type="text" class="" placeholder="" style="width:80%"
                                    readonly />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-5"><label>Durations <span class="text-danger"></span></label></div>
                            <div class="col-lg-7">
                                <input id="durations" name="" type="text" class="" placeholder="" style="width:80%"
                                    readonly />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-5"><label>Our Ref </label></div>
                            <div class="col-lg-7">
                                <input id="ourRef" name="" type="text" class="" placeholder="" style="width:80%"
                                    readonly />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-5"><label>VL1<span class="text-danger"></span></label></div>
                            <div class="col-lg-7">
                                <input id="vL1" type="text" name="" class="" placeholder="" style="width:80%"
                                    readonly />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-5"><label>VL2<span class="text-danger"></span></label></div>
                            <div class="col-lg-7">
                                <input id="vL2" type="text" name="" class="" placeholder="" style="width:80%"
                                    readonly />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-5"><label>VL3 </label></div>
                            <div class="col-lg-7">
                                <input id="vL3" name="" type="text" class="" placeholder="" style="width:80%"
                                    readonly />
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <hr>

            <div class="title" style="color:#2e64c7db"><label><b>Customer Information</b></label></div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5"><label>Customer Name/<br />Company Name <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-lg-7">
                            <input id="txCustomerName" name="txCustomerName" type="text" class="" placeholder=""
                                style="width:80%" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-3" id="divCustomerGroup">
                    <div class="row">
                        <div class="col-lg-3"><label>Customer Group<span class="text-danger">*</span></label></div>
                        <div class="col-lg-9">
                            <select class="" id="txCustomerGroup" name="txCustomerGroup" type="text" placeholder=""
                                style="width:100%">
                                <option value=""> ----- </option>
                                <?php $customerList = $this->viewbag['customerList']?>
                                <?php foreach ($customerList as $customer) {?>
                                <option value="<?php echo $customer['customerGroup'] ?>">
                                    <?php echo $customer['customerGroup'] ?> </option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-lg-3"><label>Project Region <span class="text-danger"></span></label></div>
                        <div class="col-lg-7">
                            <input id="txProjectRegion" name="txProjectRegion" type="text" class="" placeholder=""
                                style="width:100%" />
                        </div>
                        <div class="col-lg-3"><label>Project Address <span class="text-danger"></span></label></div>
                        <div class="col-lg-7">
                            <input id="txProjectAddress" name="txProjectAddress" type="text" class="" placeholder=""
                                style="width:100%" />
                        </div>
                    </div>
                </div>
            </div>
            </br>
            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5"><label>Business Type</label></div>
                        <div class="col-lg-7">
                            <select class="" id="txBusinessType" name="txBusinessType" style="height:30px;width:100%">
                                <option value="">------</option>
                                <?php $businessTypeList = $this->viewbag['businessTypeList']?>
                                <?php foreach ($businessTypeList as $businessType) {?>
                                <option value="<?php echo $businessType['businessTypeId'] ?>">
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
                                style="width:100%" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5"><label>Contact Person <span class="text-danger"></span></label></div>
                        <div class="col-lg-7">
                            <input id="txContactPerson" name="txContactPerson" type="text" class="" placeholder=""
                                style="width:100%" />
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-3"><label>Title <span class="text-danger"></span></label></div>
                        <div class="col-lg-9">
                            <input id="txTitle" type="text" name="txTitle" class="" placeholder="" style="width:100%" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-lg-3"><label>Contact No. </label></div>
                        <div class="col-lg-9">
                            <input id="txContactNo" name="txContactNo" type="tel" class="" placeholder=""
                                style="width:200px" />
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="title" style="color:#2e64c7db"><label><b>Schedule</b></label></div>
            <div class="row">
                <div class="col-lg-4" id="divActionBy">
                    <div class="row">
                        <div class="col-lg-5"><label>Action By <span class="text-danger">*</span></label></div>
                        <div class="col-lg-7">
                            <select class="" id="txActionBy" name="txActionBy" style="height:30px;width:80%">
                                <option value="">------</option>
                                <?php $actionByList = $this->viewbag['actionByList'];?>
                                <?php foreach ($actionByList as $actionBy) {$selected = '';
    if ($actionBy['actionByName'] == 'TSD/SEB') {
        $selected = 'selected';
    }
    ?>
                                <option value="<?php echo $actionBy['actionById'] ?>" <?php echo $selected ?>>
                                    <?php echo $actionBy['actionByName'] ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" id="divCustomerContactedDate">
                    <div class="row">
                        <div class="col-lg-5" style="padding-right:0px"><label>Customer Contacted Date <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-lg-7">
                            <input id="txCustomerContactedDate" name="txCustomerContactedDate" type="text" class=""
                                placeholder="YYYY-MM-DD" style="width:80%" />
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
                        <div class="col-lg-7" id="divCaseReferredToClpe">
                            <select id="txCaseReferredToClpe" name="txCaseReferredToClpe" style="width:80%;height:30px">
                                <option value="N" selected> No </option>
                                <option value="Y"> Yes </option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5"><label>Service Status <span class="text-danger">*</span></label></div>
                        <div class="col-lg-7" id="divServiceStatus">
                            <select id="txServiceStatus" name="txServiceStatus" style="height:30px;width:100%">
                                <?php $serviceStatusList = $this->viewbag['serviceStatusList']?>
                                <?php foreach ($serviceStatusList as $serviceStatus) {?>
                                <option value="<?php echo $serviceStatus['serviceStatusId'] ?>">
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
                            <input id="txRequestedVisitDate" name="txRequestedVisitDate" type="text" class=""
                                placeholder="YYYY-MM-DD" style="width:80%" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" id="divActualVisitDate" hidden="true">
                    <div class="row">
                        <div class="col-lg-5"><label>Actual Visit Date</label></div>
                        <div class="col-lg-7">
                            <input id="txActualVisitDate" name="txActualVisitDate" type="text" class=""
                                placeholder="YYYY-MM-DD" style="width:80%" />
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
                                <input id="txServiceStartDate" name="txServiceStartDate" type="text" class=""
                                    placeholder="YYYY-MM-DD" style="width:80%" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" id="divServiceCompletionDate" hidden="true">
                        <div class="row">
                            <div class="col-lg-5"><label>Service Completion Date</label></div>
                            <div class="col-lg-7">
                                <input id="txServiceCompletionDate" name="txServiceCompletionDate" type="text" class=""
                                    placeholder="YYYY-MM-DD" style="width:80%" />
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
                                <input id="txPlannedReportIssueDate" name="txPlannedReportIssueDate" type="text"
                                    class="" placeholder="YYYY-MM-DD" style="width:80%" />


                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" id="divActualReportIssueDate" hidden="true">
                        <div class="row">
                            <div class="col-lg-5"><label>Actual Report Issue Date</label></div>
                            <div class="col-lg-7">
                                <input id="txActualReportIssueDate" name="txActualReportIssueDate" type="text" class=""
                                    placeholder="YYYY-MM-DD" style="width:80%" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" id="divActualReportWorkingDay" hidden="true">
                        <div class="row">
                            <div class="col-lg-6"><label>Actual Report Working Days</label></div>

                            <div class="col-lg-6">
                                <input id="txActualReportWorkingDay" name="txActualReportWorkingDay" type="number"
                                    class="" placeholder="" style="width:60px" />
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
                                placeholder="" style="width:80%" />
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
                                placeholder="" style="width:60px" />
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
                                    <input type="number" step="1" min="1" id="txManPowerMP" name="txManPowerMP"
                                        style="width:80px" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="row">
                        <div class="col-lg-3"> G </div>
                        <div class="col-lg-9">
                            <input type="number" min="1" id="txManPowerG" name="txManPowerG" style="width:80px" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="row">
                        <div class="col-lg-3"> T </div>
                        <div class="col-lg-9">
                            <input type="number" min="1" id="txManPowerT" name="txManPowerT" style="width:80px" />
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5" style="padding-right:0px"><label>Reported by EIC <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-lg-7" id="divReportedByEic">
                            <select id="txReportedByEic" name="txReportedByEic" style="height:30px;width:100%">
                                <option value="">------</option>
                                <?php $eicList = $this->viewbag['eicList']?>
                                <?php foreach ($eicList as $eic) {?>
                                <option value="<?php echo $eic['eicId'] ?>"><?php echo $eic['eicName'] ?></option>
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
                            <label>Unit Rate Year <span class="text-danger">*</span></label>
                            <select id="unitRateCountYear">
                                <?php foreach ($this->viewbag['countYear'] as $countYear) {?>
                                <option value="<?php echo $countYear['countYear'] ?>">
                                    <?php echo $countYear['countYear'] ?> </option>

                                <?php }?>
                            </select>

                        </div>
                        <div class="col-lg-7">

                            <label>Unit Rate(HK$) <span class="text-danger">*</span></label>
                            <select id="txUnitRate" name="txUnitRate" style="height:30px;width:45%">
                                <option value="">------</option>
                                <!-- <?php /* $costTypeList = $this->viewbag['costTypeList']?>
<?php foreach ($costTypeList as $costType) {?>
<option value="<?php echo $costType['costTypeId'] ?>" serviceTypeId="<?php echo $costType['serviceTypeId'] ?>"><?php echo $costType['unitCost'] ?></option>
<?php }*/?> -->
                            </select>

                        </div>
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="row">
                        <div class="col-lg-3"><label> Unit <span class="text-danger">*</span></label></div>
                        <div class="col-lg-9">
                            <input type="number" id="txUnit" name="txUnit" min="1" style="width:80px" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="row">

                        <div class="col-lg-3"> <label>Total </label><span class="text-danger">*</span></div>
                        <div class="col-lg-9 special-input">

                            <input type="number" id="txTotal" name="txTotal" style="width:80%" />
                            <button type="button" id="totalRecalculator" style="width:20%"><i class="fa fa-calculator"
                                    aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-5" style="padding-right:0px"><label>Party to be Charged <span
                                    class="text-danger">*</span></label></div>
                        <div class="col-lg-7" id="divPartyToBeCharged">
                            <select id="txPartyToBeCharged" name="txPartyToBeCharged" style="height:30px;width:100%">
                                <option value="">------</option>
                                <?php $partyToBeChargedList = $this->viewbag['partyToBeChargedList']?>
                                <?php foreach ($partyToBeChargedList as $partyToBeCharged) {?>
                                <option value="<?php echo $partyToBeCharged['partyToBeChargedId'] ?>">
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
                                <option value="">------</option>
                                <?php $plantTypeList = $this->viewbag['plantTypeList']?>
                                <?php foreach ($plantTypeList as $plantType) {?>
                                <option value="<?php echo $plantType['plantTypeId'] ?>">
                                    <?php echo $plantType['plantTypeName'] ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-lg-5" style="padding-right:0px"><label>Manufacturer Brand</label></div>
                        <div class="col-lg-7">
                            <input type="text" id="txManufacturerBrand" name="txManufacturerBrand" />
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
                                <option value="">------</option>
                                <?php $majorAffectedElementList = $this->viewbag['majorAffectedElementList']?>
                                <?php foreach ($majorAffectedElementList as $majorAffectedElement) {?>
                                <option value="<?php echo $majorAffectedElement['majorAffectedElementId'] ?>">
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
                            <input type="text" id="txPlantRating" name="txPlantRating" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-auto" style="min-width:14%">
                            <label>Customer's Problems <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-lg-10" style="">
                            <textarea id="txCustomerProblems" name="txCustomerProblems" rows="7" style="width:100%"
                                itemscope=""></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="title" style="color:#2e64c7db"><label><b>Findings</b></label></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-auto" style="min-width:14%">
                            <label>Actions and Finding</label>
                        </div>
                        <div class="col-lg-10" style="">
                            <textarea id="txActionsAndFinding" name="txActionsAndFinding" rows="7" style="width:100%"
                                itemscope=""></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-auto" style="min-width:14%">
                            <label>Recommendation</label>
                        </div>
                        <div class="col-lg-10" style="">
                            <textarea id="txRecommendation" name="txRecommendation" rows="7" style="width:100%"
                                itemscope=""></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-auto" style="min-width:14%">
                            <label>Remark</label>
                        </div>
                        <div class="col-lg-10" style="">
                            <textarea id="txRemark" name="txRemark" rows="7" style="width:100%" itemscope=""></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-auto">
                    <div class="row">
                        <div class="col-lg-auto">
                            <label>Required Follow-up <span class="text-danger"></span></label>
                        </div>
                        <div class="col-lg-auto">
                            <input type="checkbox" id="txRequiredFollowUp" name="txRequiredFollowUp" />
                        </div>
                    </div>
                </div>
                <div class="col-10">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-3"><label>Implemented Solution</label></div>
                                <div class="col-lg-9">
                                    <input type="text" id="txImplementedSolution" name="txImplementedSolution"
                                        style="width:100%" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-3"><label>proposed Solution</label></div>
                                <div class="col-lg-9">
                                    <input type="text" id="txProposedSolution" name="txProposedSolution"
                                        style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br />





            <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-3" style="padding-right:0px"><label>Active? </label></div>
                        <div class="col-lg-7" style="padding-left:5px">
                            <select id="txActive" name="txActive" style="height:30px;width:100%">
                                <option value="Y"> Yes </option>
                                <option value="N"> No </option>
                            </select>
                        </div>
                    </div>
                </div>


            </div>

            <div class="card-footer">
                <div id="planningAheadDiv" hidden>
                    <div class="row">
                        <div class="col-lg-3"><label>Planning Ahead Id</label></div>
                        <div class="col-lg-9" style="text-align:left">
                            <input type="number" id="txPlanningAheadId" name="txPlanningAheadId" min="0">
                        </div>
                    </div>
                    <iframe id="planningAheadIframe" name="planningAheadIframe" width="100%" height="800px" allow-forms
                        allow-modals allow-scripts allow-top-navigation-by-user-activation>
                        你的瀏覽器不支援 iframe
                    </iframe>
                </div>
                <div class="col-lg-12" style="text-align:left">
                    <button id="btnFormApply" name="btnFormApply" type="button" class="btn btn-primary btnFormApply"
                        style="width:100%">Apply</button>
                    <button id="btnFormCancel" name="btnFormCancel" type="button" class="btn btn-danger btnFormCancel"
                        style="width:100%">Cancel</button>

                </div>
            </div>
        </div>


</div>
</form>
</div>


</html>
<script>
function addPlanningAheadId(planningAheadId) {
    $("#txPlanningAheadId").val(planningAheadId);
}

$(document).ready(function() {


    $("#planningAheadIframe").attr("src",
        "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/PlanningAheadSearchForCaseForm");
    $("#myDropdown option:contains(TSD/SEB)").attr('selected', 'selected');

    $("#txProblemType").change(function() {
        if ($("#txProblemType").val() == 4) {
            $("#planningAheadDiv").attr("hidden", false);

        } else {
            $("#planningAheadDiv").attr("hidden", true);
        }
        $("#txPlanningAheadId").val("");
    });
    //Migratation
    $("button[name='btnForMigrate']").unbind().bind("click", function() {
        $("#loading-modal").modal("show");
        $(this).attr("disabled", true);


        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxMigrateCaseForm",
            type: "POST",
            cache: false,
            data: $("#Form").serializeArray(),
            success: function(data) {
                console.log(data);
                var retJson = JSON.parse(data);

                if (retJson.status == "OK") {
                    // display message
                    showMsg("<i class=\"fas fa-check-circle\"></i> ", "Info",
                        "Case Form inserted.", "",
                        function() {
                            window.location.href =
                                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch"
                            table.ajax.reload(null, false);

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
            $(".btnForMigrate").attr("disabled", false);
        });
    });
    $("#txIncidentDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txIncidentTime").datetimepicker({
        datepicker: false,
        format: 'H:i',
        scrollInput: false
    });
    $("#txRequestDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txRequestTime").datetimepicker({
        datepicker: false,
        format: 'H:i',
        scrollInput: false
    });
    $("#txCustomerContactedDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txRequestedVisitDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txActualVisitDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txServiceStartDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txServiceCompletionDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txPlannedReportIssueDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txActualReportIssueDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    var $txServiceType = $("#txServiceType").selectize({});
    var $selectizeServiceType = $txServiceType[0].selectize;
    var $txProblemType = $("#txProblemType").selectize({});
    var $selectizeProblemType = $txProblemType[0].selectize;
    var $txClpPersonDepartment = $("#txClpPersonDepartment").selectize({});
    var $selectizeClpPersonDepartment = $txClpPersonDepartment[0].selectize;
    var $txClpReferredBy = $("#txClpReferredBy").selectize({});
    var $selectizeClpReferredBy = $txClpReferredBy[0].selectize;
    var $txBusinessType = $("#txBusinessType").selectize({});
    var $selectizeBusinessType = $txBusinessType[0].selectize;
    var $txActionBy = $("#txActionBy").selectize({});
    var $selectizeActionBy = $txActionBy[0].selectize;
    var $txCaseReferredToClpe = $("#txCaseReferredToClpe").selectize({});
    var $selectizeCaseReferredToClpe = $txCaseReferredToClpe[0].selectize;
    var $txServiceStatus = $("#txServiceStatus").selectize({});
    var $selectizeServiceStatus = $txServiceStatus[0].selectize;
    var $txReportedByEic = $("#txReportedByEic").selectize({});
    var $selectizeReportedByEic = $txReportedByEic[0].selectize;
    // var $txUnitRate=$("#txUnitRate").selectize({});
    // var $selectizeUnitRate = $txUnitRate[0].selectize;
    var $txPartyToBeCharged = $("#txPartyToBeCharged").selectize({});
    var $selectizePartyToBeCharged = $txPartyToBeCharged[0].selectize;
    var $txPlantType = $("#txPlantType").selectize({});
    var $selectizePlantType = $txPlantType[0].selectize;
    var $txMajorAffectedElement = $("#txMajorAffectedElement").selectize({});
    var $selectizeMajorAffectedElement = $txMajorAffectedElement[0].selectize;
    var $txActive = $("#txActive").selectize({});
    var $selectizeActive = $txActive[0].selectize;
    var $txCustomerGroup = $("#txCustomerGroup").selectize({});
    var $selectizeCustomerGroup = $txCustomerGroup[0].selectize;

    $("button[name='btnFormCancel']").unbind().bind("click", function() {
        showConfirmation("<i class=\"fas fa-exclamation-circle\"></i> ", "Confirmation",
            "Are you sure to Cancel?",
            function() {
                window.location.href =
                    "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch"
            },
            function() {
                $("#btnModalConfirmation").focus();
            });
    });

    <?php if ($this->viewbag['mode'] == 'update') {?> //if mode = update
    $("#title").html("Case Form ( Update )");
    $("button[name='btnFormApply']").unbind().bind("click", function() {
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
                            window.location.href =
                                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch"
                            table.ajax.reload(null, false);

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
            $(".btnFormApply").attr("disabled", false);
        });
    });


    //$("#divCaseNo").attr("hidden",false);
    $("#txCaseNo").val("<?php echo $this->viewbag['serviceCaseForm']['serviceCaseId'] ?>");
    $("#txParentCaseNo").val("<?php echo $this->viewbag['serviceCaseForm']['parentCaseNo'] ?>");
    $("#txCaseVersion").val("<?php echo $this->viewbag['serviceCaseForm']['caseVersion'] ?>");
    $selectizeServiceType.setValue("<?php echo $this->viewbag['serviceCaseForm']['serviceTypeId'] ?>");
    //$("#txServiceType").val("<?php echo $this->viewbag['serviceCaseForm']['serviceTypeId'] ?>");
    $selectizeProblemType.setValue("<?php echo $this->viewbag['serviceCaseForm']['problemTypeId'] ?>");
    //$("#txProblemType").val("<?php echo $this->viewbag['serviceCaseForm']['problemTypeId'] ?>");
    $("#txIdrOrderId").val("<?php echo $this->viewbag['serviceCaseForm']['idrOrderId'] ?>");
    $("#txIncidentId").val("<?php echo $this->viewbag['serviceCaseForm']['incidentId'] ?>");
    if ("<?php echo $this->viewbag['serviceCaseForm']['incidentId'] ?>" != '') {
        $("#txIncidentDate").val("<?php echo $this->viewbag['serviceCaseForm']['voltageIncidentDate'] ?>");
        $("#txIncidentTime").val("<?php echo $this->viewbag['serviceCaseForm']['voltageIncidentTime'] ?>");
        $("#idrNo").val("<?php echo $this->viewbag['serviceCaseForm']['incidentId'] ?>");
        $("#idrNo").val("<?php echo $this->viewbag['serviceCaseForm']['idrOrderId'] ?>");
        $("#incidentDate").val(
            "<?php echo ($this->viewbag['serviceCaseForm']['voltageIncidentDate'] . ' ' . $this->viewbag['serviceCaseForm']['voltageIncidentDate']) ?>"
            );
        $("#voltage").val("<?php echo $this->viewbag['serviceCaseForm']['voltage'] ?>");
        $("#circuit").val("<?php echo $this->viewbag['serviceCaseForm']['circuit'] ?>");
        $("#durations").val("<?php echo $this->viewbag['serviceCaseForm']['durations'] ?>");
        $("#vL1").val("<?php echo $this->viewbag['serviceCaseForm']['vL1'] ?>");
        $("#vL2").val("<?php echo $this->viewbag['serviceCaseForm']['vL2'] ?>");
        $("#vL3").val("<?php echo $this->viewbag['serviceCaseForm']['vL3'] ?>");
        $("#ourRef").val("<?php echo $this->viewbag['serviceCaseForm']['ourRef'] ?>");
        $("#incidentDiv").collapse('show');
    } else {
        $("#txIncidentDate").val("<?php echo $this->viewbag['serviceCaseForm']['incidentDate'] ?>");
        $("#txIncidentTime").val("<?php echo $this->viewbag['serviceCaseForm']['incidentDateTime'] ?>");
    }

    $("#txRequestDate").val("<?php echo $this->viewbag['serviceCaseForm']['requestDate'] ?>");
    $("#txRequestTime").val("<?php echo $this->viewbag['serviceCaseForm']['requestDateTime'] ?>");
    $("#txRequestedBy").val("<?php echo $this->viewbag['serviceCaseForm']['requestedBy'] ?>");
    $selectizeClpPersonDepartment.setValue(
        "<?php echo $this->viewbag['serviceCaseForm']['clpPersonDepartment'] ?>");
    //$("#txClpPersonDepartment").val("<?php echo $this->viewbag['serviceCaseForm']['clpPersonDepartment'] ?>");
    $selectizeClpReferredBy.setValue("<?php echo $this->viewbag['serviceCaseForm']['clpReferredById'] ?>");
    //$("#txClpReferredBy").val("<?php echo $this->viewbag['serviceCaseForm']['clpReferredById'] ?>");
    $("#txCustomerName").val("<?php echo $this->viewbag['serviceCaseForm']['customerName'] ?>");
    $selectizeCustomerGroup.setValue("<?php echo $this->viewbag['serviceCaseForm']['customerGroup'] ?>");
    $selectizeBusinessType.setValue("<?php echo $this->viewbag['serviceCaseForm']['businessTypeId'] ?>");
    //$("#txBusinessType").val("<?php echo $this->viewbag['serviceCaseForm']['businessTypeId'] ?>");
    $("#txClpNetwork").val("<?php echo $this->viewbag['serviceCaseForm']['clpNetwork'] ?>");
    $("#txContactPerson").val("<?php echo $this->viewbag['serviceCaseForm']['contactPersonName'] ?>");
    $("#txTitle").val("<?php echo $this->viewbag['serviceCaseForm']['contactPersonTitle'] ?>");
    $("#txContactNo").val("<?php echo $this->viewbag['serviceCaseForm']['contactPersonNumber'] ?>");
    $selectizeActionBy.setValue("<?php echo $this->viewbag['serviceCaseForm']['actionBy'] ?>");
    //$("#txActionBy").val("<?php echo $this->viewbag['serviceCaseForm']['actionBy'] ?>");
    $("#txCustomerContactedDate").val(
        "<?php echo $this->viewbag['serviceCaseForm']['customerContactedDate'] ?>");
    $selectizeCaseReferredToClpe.setValue(
        "<?php echo $this->viewbag['serviceCaseForm']['caseReferredToClpe'] ?>");
    //$("#txCaseReferredToClpe").val("<?php echo $this->viewbag['serviceCaseForm']['caseReferredToClpe'] ?>");
    $selectizeServiceStatus.setValue("<?php echo $this->viewbag['serviceCaseForm']['serviceStatusId'] ?>");
    //$("#txServiceStatus").val("<?php echo $this->viewbag['serviceCaseForm']['serviceStatusId'] ?>");
    $("#txRequestedVisitDate").val("<?php echo $this->viewbag['serviceCaseForm']['requestedVisitDate'] ?>");
    $("#txActualVisitDate").val("<?php echo $this->viewbag['serviceCaseForm']['actualVisitDate'] ?>");
    $("#txServiceStartDate").val("<?php echo $this->viewbag['serviceCaseForm']['serviceStartDate'] ?>");
    $("#txServiceCompletionDate").val(
        "<?php echo $this->viewbag['serviceCaseForm']['serviceCompletionDate'] ?>");
    $("#txPlannedReportIssueDate").val(
        "<?php echo $this->viewbag['serviceCaseForm']['plannedReportIssueDate'] ?>");
    $("#txActualReportIssueDate").val(
        "<?php echo $this->viewbag['serviceCaseForm']['actualReportIssueDate'] ?>");
    $("#txActualReportWorkingDay").val(
        "<?php echo $this->viewbag['serviceCaseForm']['actualReportWorkingDay'] ?>");
    $("#txActualWorkingDay").val("<?php echo $this->viewbag['serviceCaseForm']['actualWorkingDay'] ?>");
    $("#txActualResponseDay").val("<?php echo $this->viewbag['serviceCaseForm']['actualResponseDay'] ?>");
    $("#txManPowerMP").val("<?php echo $this->viewbag['serviceCaseForm']['mp'] ?>");
    $("#txManPowerG").val("<?php echo $this->viewbag['serviceCaseForm']['g'] ?>");
    $("#txManPowerT").val("<?php echo $this->viewbag['serviceCaseForm']['t'] ?>");
    $selectizeReportedByEic.setValue("<?php echo $this->viewbag['serviceCaseForm']['eicId'] ?>");
    //$("#txReportedByEic").val("<?php echo $this->viewbag['serviceCaseForm']['eicId'] ?>");
    //$selectizeUnitRate.setValue("<?php echo $this->viewbag['serviceCaseForm']['costTypeId'] ?>");
    $("#unitRateCountYear").val("<?php echo $this->viewbag['costType']['countYear'] ?>");
    $('#txUnitRate').find('option').remove().end().append(
        '<option value="<?php echo $this->viewbag['costType']['costTypeId'] ?>"> <?php echo $this->viewbag['costType']['unitCost'] ?></option>'
        );
    $("#txUnitRate").val("<?php echo $this->viewbag['serviceCaseForm']['costTypeId'] ?>");
    $("#txUnit").val("<?php echo $this->viewbag['serviceCaseForm']['costUnit'] ?>");
    $("#txTotal").val("<?php echo $this->viewbag['serviceCaseForm']['costTotal'] ?>");
    $selectizePartyToBeCharged.setValue(
    "<?php echo $this->viewbag['serviceCaseForm']['partyToBeChargedId'] ?>");
    //$("#txPartyToBeCharged").val("<?php echo $this->viewbag['serviceCaseForm']['partyToBeChargedId'] ?>");
    $selectizePlantType.setValue("<?php echo $this->viewbag['serviceCaseForm']['plantTypeId'] ?>");
    //$("#txPlantType").val("<?php echo $this->viewbag['serviceCaseForm']['plantTypeId'] ?>");
    $("#txManufacturerBrand").val("<?php echo $this->viewbag['serviceCaseForm']['manufacturerBrand'] ?>");
    $selectizeMajorAffectedElement.setValue(
        "<?php echo $this->viewbag['serviceCaseForm']['majorAffectedElementId'] ?>");
    //$("#txMajorAffectedElement").val("<?php echo $this->viewbag['serviceCaseForm']['majorAffectedElementId'] ?>");
    $("#txPlantRating").val("<?php echo $this->viewbag['serviceCaseForm']['plantRating'] ?>");
    $("#txCustomerProblems").val("<?php echo $this->viewbag['serviceCaseForm']['customerProblem'] ?>");
    $("#txActionsAndFinding").val(
        "<?php echo preg_replace('/(\r\n|\n|\r)/', '\n', trim($this->viewbag['serviceCaseForm']['actionAndFinding'])) ?>"
        );
    $("#txRecommendation").val("<?php echo $this->viewbag['serviceCaseForm']['recommendation'] ?>");
    $("#txRemark").val("<?php echo $this->viewbag['serviceCaseForm']['remark'] ?>");
    if (<?php echo $this->viewbag['serviceCaseForm']['requiredFollowUp'] ?>) {
        $("#txRequiredFollowUp").prop("checked", true);
    }
    $("#txImplementedSolution").val("<?php echo $this->viewbag['serviceCaseForm']['implementedSolution'] ?>");
    $("#txProposedSolution").val("<?php echo $this->viewbag['serviceCaseForm']['proposedSolution'] ?>");
    $("#txProjectRegion").val("<?php echo $this->viewbag['serviceCaseForm']['projectRegion'] ?>");
    $("#txprojectAddress").val("<?php echo $this->viewbag['serviceCaseForm']['projectAddress'] ?>");
    $selectizeActive.setValue("<?php echo $this->viewbag['serviceCaseForm']['active'] ?>");
    $("#txPlanningAheadId").val("<?php echo $this->viewbag['serviceCaseForm']['planningAheadId'] ?>");
    //$("#txActive").val("<?php echo $this->viewbag['serviceCaseForm']['active'] ?>");
    switch ($("#txServiceType").val()) {
        case "1": //Enquiry
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
        case "2": //Site Visit
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
        case "3": //Investigation (L)
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
        case "4": //Investigation (S)
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
        case "5": //Reach Out
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
        case "6": //"PQ workshop visit":
            break;
        case "":
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
    <?php } else if ($this->viewbag['mode'] == 'copy') {?> //if mode = copy
    $("#title").html("Case Form ( Copy )");
    $("button[name='btnFormApply']").unbind().bind("click", function() {
        if (!validateInput()) {
            return;
        }
        $("#loading-modal").modal("show");
        $(this).attr("disabled", true);


        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxInsertCaseForm",
            type: "POST",
            cache: false,
            data: $("#Form").serializeArray(),
            success: function(data) {
                console.log(data);
                var retJson = JSON.parse(data);

                if (retJson.status == "OK") {
                    // display message
                    showMsg("<i class=\"fas fa-check-circle\"></i> ", "Info",
                        "Case Form inserted.", "",
                        function() {
                            window.location.href =
                                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch"
                            table.ajax.reload(null, false);

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
            $(".btnFormApply").attr("disabled", false);
        });
    });


    $("#divCaseNo").attr("hidden", true);
    $("#txParentCaseNo").val("<?php echo $this->viewbag['serviceCaseForm']['parentCaseNo'] ?>");
    $("#txCaseVersion").val("<?php echo $this->viewbag['maxCaseVersion'] ?>");
    $selectizeServiceType.setValue("<?php echo $this->viewbag['serviceCaseForm']['serviceTypeId'] ?>");
    //$("#txServiceType").val("<?php echo $this->viewbag['serviceCaseForm']['serviceTypeId'] ?>");
    $selectizeProblemType.setValue("<?php echo $this->viewbag['serviceCaseForm']['problemTypeId'] ?>");
    //$("#txProblemType").val("<?php echo $this->viewbag['serviceCaseForm']['problemTypeId'] ?>");
    $("#txIdrOrderId").val("<?php echo $this->viewbag['serviceCaseForm']['idrOrderId'] ?>");
    $("#txIncidentId").val("<?php echo $this->viewbag['serviceCaseForm']['incidentId'] ?>");
    if ("<?php echo $this->viewbag['serviceCaseForm']['incidentId'] ?>" != '') {
        $("#txIncidentDate").val("<?php echo $this->viewbag['serviceCaseForm']['voltageIncidentDate'] ?>");
        $("#txIncidentTime").val("<?php echo $this->viewbag['serviceCaseForm']['voltageIncidentTime'] ?>");
        $("#idrNo").val("<?php echo $this->viewbag['serviceCaseForm']['incidentId'] ?>");
        $("#idrNo").val("<?php echo $this->viewbag['serviceCaseForm']['idrOrderId'] ?>");
        $("#incidentDate").val(
            "<?php echo ($this->viewbag['serviceCaseForm']['voltageIncidentDate'] . ' ' . $this->viewbag['serviceCaseForm']['voltageIncidentDate']) ?>"
            );
        $("#voltage").val("<?php echo $this->viewbag['serviceCaseForm']['voltage'] ?>");
        $("#circuit").val("<?php echo $this->viewbag['serviceCaseForm']['circuit'] ?>");
        $("#durations").val("<?php echo $this->viewbag['serviceCaseForm']['durations'] ?>");
        $("#vL1").val("<?php echo $this->viewbag['serviceCaseForm']['vL1'] ?>");
        $("#vL2").val("<?php echo $this->viewbag['serviceCaseForm']['vL2'] ?>");
        $("#vL3").val("<?php echo $this->viewbag['serviceCaseForm']['vL3'] ?>");
        $("#ourRef").val("<?php echo $this->viewbag['serviceCaseForm']['ourRef'] ?>");
        $("#incidentDiv").collapse('show');
    } else {
        $("#txIncidentDate").val("<?php echo $this->viewbag['serviceCaseForm']['incidentDate'] ?>");
        $("#txIncidentTime").val("<?php echo $this->viewbag['serviceCaseForm']['incidentDateTime'] ?>");
    }
    $("#txRequestDate").val("<?php echo $this->viewbag['serviceCaseForm']['requestDate'] ?>");
    $("#txRequestTime").val("<?php echo $this->viewbag['serviceCaseForm']['requestDateTime'] ?>");
    $("#txRequestedBy").val("<?php echo $this->viewbag['serviceCaseForm']['requestedBy'] ?>");
    $selectizeClpPersonDepartment.setValue(
        "<?php echo $this->viewbag['serviceCaseForm']['clpPersonDepartment'] ?>");
    //$("#txClpPersonDepartment").val("<?php echo $this->viewbag['serviceCaseForm']['clpPersonDepartment'] ?>");
    $selectizeClpReferredBy.setValue("<?php echo $this->viewbag['serviceCaseForm']['clpReferredById'] ?>");
    //$("#txClpReferredBy").val("<?php echo $this->viewbag['serviceCaseForm']['clpReferredById'] ?>");
    $("#txCustomerName").val("<?php echo $this->viewbag['serviceCaseForm']['customerName'] ?>");
    $selectizeCustomerGroup.setValue("<?php echo $this->viewbag['serviceCaseForm']['customerGroup'] ?>");
    $selectizeBusinessType.setValue("<?php echo $this->viewbag['serviceCaseForm']['businessTypeId'] ?>");
    //$("#txBusinessType").val("<?php echo $this->viewbag['serviceCaseForm']['businessTypeId'] ?>");
    $("#txClpNetwork").val("<?php echo $this->viewbag['serviceCaseForm']['clpNetwork'] ?>");
    $("#txContactPerson").val("<?php echo $this->viewbag['serviceCaseForm']['contactPersonName'] ?>");
    $("#txTitle").val("<?php echo $this->viewbag['serviceCaseForm']['contactPersonTitle'] ?>");
    $("#txContactNo").val("<?php echo $this->viewbag['serviceCaseForm']['contactPersonNumber'] ?>");
    $selectizeActionBy.setValue("<?php echo $this->viewbag['serviceCaseForm']['actionBy'] ?>");
    //$("#txActionBy").val("<?php echo $this->viewbag['serviceCaseForm']['actionBy'] ?>");
    $("#txCustomerContactedDate").val(
        "<?php echo $this->viewbag['serviceCaseForm']['customerContactedDate'] ?>");
    $selectizeCaseReferredToClpe.setValue(
        "<?php echo $this->viewbag['serviceCaseForm']['caseReferredToClpe'] ?>");
    //$("#txCaseReferredToClpe").val("<?php echo $this->viewbag['serviceCaseForm']['caseReferredToClpe'] ?>");
    $selectizeServiceStatus.setValue("<?php echo $this->viewbag['serviceCaseForm']['serviceStatusId'] ?>");
    //$("#txServiceStatus").val("<?php echo $this->viewbag['serviceCaseForm']['serviceStatusId'] ?>");
    $("#txRequestedVisitDate").val("<?php echo $this->viewbag['serviceCaseForm']['requestedVisitDate'] ?>");
    $("#txActualVisitDate").val("<?php echo $this->viewbag['serviceCaseForm']['actualVisitDate'] ?>");
    $("#txServiceStartDate").val("<?php echo $this->viewbag['serviceCaseForm']['serviceStartDate'] ?>");
    $("#txServiceCompletionDate").val(
        "<?php echo $this->viewbag['serviceCaseForm']['serviceCompletionDate'] ?>");
    $("#txPlannedReportIssueDate").val(
        "<?php echo $this->viewbag['serviceCaseForm']['plannedReportIssueDate'] ?>");
    $("#txActualReportIssueDate").val(
        "<?php echo $this->viewbag['serviceCaseForm']['actualReportIssueDate'] ?>");
    $("#txActualReportWorkingDay").val(
        "<?php echo $this->viewbag['serviceCaseForm']['actualReportWorkingDay'] ?>");
    $("#txActualWorkingDay").val("<?php echo $this->viewbag['serviceCaseForm']['actualWorkingDay'] ?>");
    $("#txActualResponseDay").val("<?php echo $this->viewbag['serviceCaseForm']['actualResponseDay'] ?>");
    $("#txManPowerMP").val("<?php echo $this->viewbag['serviceCaseForm']['mp'] ?>");
    $("#txManPowerG").val("<?php echo $this->viewbag['serviceCaseForm']['g'] ?>");
    $("#txManPowerT").val("<?php echo $this->viewbag['serviceCaseForm']['t'] ?>");
    $selectizeReportedByEic.setValue("<?php echo $this->viewbag['serviceCaseForm']['eicId'] ?>");
    //$("#txReportedByEic").val("<?php echo $this->viewbag['serviceCaseForm']['eicId'] ?>");
    //$selectizeUnitRate.setValue("<?php echo $this->viewbag['serviceCaseForm']['costTypeId'] ?>");
    $("#unitRateCountYear").val("<?php echo $this->viewbag['costType']['countYear'] ?>");
    $('#txUnitRate').find('option').remove().end().append(
        '<option value="<?php echo $this->viewbag['costType']['costTypeId'] ?>"> <?php echo $this->viewbag['costType']['unitCost'] ?></option>'
        );
    $("#txUnitRate").val("<?php echo $this->viewbag['serviceCaseForm']['costTypeId'] ?>");
    $("#txUnit").val("<?php echo $this->viewbag['serviceCaseForm']['costUnit'] ?>");
    $("#txTotal").val("<?php echo $this->viewbag['serviceCaseForm']['costTotal'] ?>");
    $selectizePartyToBeCharged.setValue(
    "<?php echo $this->viewbag['serviceCaseForm']['partyToBeChargedId'] ?>");
    //$("#txPartyToBeCharged").val("<?php echo $this->viewbag['serviceCaseForm']['partyToBeChargedId'] ?>");
    $selectizePlantType.setValue("<?php echo $this->viewbag['serviceCaseForm']['plantTypeId'] ?>");
    //$("#txPlantType").val("<?php echo $this->viewbag['serviceCaseForm']['plantTypeId'] ?>");
    $("#txManufacturerBrand").val("<?php echo $this->viewbag['serviceCaseForm']['manufacturerBrand'] ?>");
    $selectizeMajorAffectedElement.setValue(
        "<?php echo $this->viewbag['serviceCaseForm']['majorAffectedElementId'] ?>");
    //$("#txMajorAffectedElement").val("<?php echo $this->viewbag['serviceCaseForm']['majorAffectedElementId'] ?>");
    $("#txPlantRating").val("<?php echo $this->viewbag['serviceCaseForm']['plantRating'] ?>");
    $("#txCustomerProblems").val("<?php echo $this->viewbag['serviceCaseForm']['customerProblem'] ?>");
    $("#txActionsAndFinding").val(
        "<?php echo preg_replace('/(\r\n|\n|\r)/', '\n', trim($this->viewbag['serviceCaseForm']['actionAndFinding'])) ?>"
        );
    $("#txRecommendation").val("<?php echo $this->viewbag['serviceCaseForm']['recommendation'] ?>");
    $("#txRemark").val("<?php echo $this->viewbag['serviceCaseForm']['remark'] ?>");
    if (<?php echo $this->viewbag['serviceCaseForm']['requiredFollowUp'] ?>) {
        $("#txRequiredFollowUp").prop("checked", true);
    }
    $("#txImplementedSolution").val("<?php echo $this->viewbag['serviceCaseForm']['implementedSolution'] ?>");
    $("#txProposedSolution").val("<?php echo $this->viewbag['serviceCaseForm']['proposedSolution'] ?>");
    $("#txProjectRegion").val("<?php echo $this->viewbag['serviceCaseForm']['projectRegion'] ?>");
    $("#txprojectAddress").val("<?php echo $this->viewbag['serviceCaseForm']['projectAddress'] ?>");
    $selectizeActive.setValue("<?php echo $this->viewbag['serviceCaseForm']['active'] ?>");
    $("#txPlanningAheadId").val("<?php echo $this->viewbag['serviceCaseForm']['planningAheadId'] ?>");
    //$("#txActive").val("<?php echo $this->viewbag['serviceCaseForm']['active'] ?>");
    switch ($("#txServiceType").val()) {
        case "1": //Enquiry
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
        case "2": //Site Visit
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
        case "3": //Investigation (L)
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
        case "4": //Investigation (S)
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
        case "5": //Reach Out
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
        case "6": //"PQ workshop visit":
            break;
        case "":
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
    <?php } else if ($this->viewbag['mode'] == 'read') {?> //if mode = read
    $("#title").html("Case Form ( Read Only )");
    $("button[name='btnFormApply']").html('Modify');

    $("button[name='btnFormApply']").unbind().bind("click", function() {
        window.location.href =
            "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/GetCaseFormForUpdate&serviceCaseId=<?php echo $this->viewbag['serviceCaseForm']['serviceCaseId'] ?>";
    });
    $("button[name='btnFormCancel']").html("Back");
    $("button[name='btnFormCancel']").unbind().bind("click", function() {

        window.location.href =
            "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch"

    });



    //$("#divCaseNo").attr("hidden",false);
    $("#txCaseNo").val("<?php echo $this->viewbag['serviceCaseForm']['serviceCaseId'] ?>");
    $("#txParentCaseNo").val("<?php echo $this->viewbag['serviceCaseForm']['parentCaseNo'] ?>");
    $("#txCaseVersion").val("<?php echo $this->viewbag['serviceCaseForm']['caseVersion'] ?>");
    $selectizeServiceType.setValue("<?php echo $this->viewbag['serviceCaseForm']['serviceTypeId'] ?>");
    //$("#txServiceType").val("<?php echo $this->viewbag['serviceCaseForm']['serviceTypeId'] ?>");
    $selectizeProblemType.setValue("<?php echo $this->viewbag['serviceCaseForm']['problemTypeId'] ?>");
    //$("#txProblemType").val("<?php echo $this->viewbag['serviceCaseForm']['problemTypeId'] ?>");
    $("#txIdrOrderId").val("<?php echo $this->viewbag['serviceCaseForm']['idrOrderId'] ?>");
    $("#txIncidentId").val("<?php echo $this->viewbag['serviceCaseForm']['incidentId'] ?>");
    if ("<?php echo $this->viewbag['serviceCaseForm']['incidentId'] ?>" != '') {
        $("#txIncidentDate").val("<?php echo $this->viewbag['serviceCaseForm']['voltageIncidentDate'] ?>");
        $("#txIncidentTime").val("<?php echo $this->viewbag['serviceCaseForm']['voltageIncidentTime'] ?>");
        $("#idrNo").val("<?php echo $this->viewbag['serviceCaseForm']['incidentId'] ?>");
        $("#idrNo").val("<?php echo $this->viewbag['serviceCaseForm']['idrOrderId'] ?>");
        $("#incidentDate").val(
            "<?php echo ($this->viewbag['serviceCaseForm']['voltageIncidentDate'] . ' ' . $this->viewbag['serviceCaseForm']['voltageIncidentDate']) ?>"
            );
        $("#voltage").val("<?php echo $this->viewbag['serviceCaseForm']['voltage'] ?>");
        $("#circuit").val("<?php echo $this->viewbag['serviceCaseForm']['circuit'] ?>");
        $("#durations").val("<?php echo $this->viewbag['serviceCaseForm']['durations'] ?>");
        $("#vL1").val("<?php echo $this->viewbag['serviceCaseForm']['vL1'] ?>");
        $("#vL2").val("<?php echo $this->viewbag['serviceCaseForm']['vL2'] ?>");
        $("#vL3").val("<?php echo $this->viewbag['serviceCaseForm']['vL3'] ?>");
        $("#ourRef").val("<?php echo $this->viewbag['serviceCaseForm']['ourRef'] ?>");
        $("#incidentDiv").collapse('show');
    } else {
        $("#txIncidentDate").val("<?php echo $this->viewbag['serviceCaseForm']['incidentDate'] ?>");
        $("#txIncidentTime").val("<?php echo $this->viewbag['serviceCaseForm']['incidentDateTime'] ?>");
    }
    $("#txRequestDate").val("<?php echo $this->viewbag['serviceCaseForm']['requestDate'] ?>");
    $("#txRequestTime").val("<?php echo $this->viewbag['serviceCaseForm']['requestDateTime'] ?>");
    $("#txRequestedBy").val("<?php echo $this->viewbag['serviceCaseForm']['requestedBy'] ?>");
    $selectizeClpPersonDepartment.setValue(
        "<?php echo $this->viewbag['serviceCaseForm']['clpPersonDepartment'] ?>");
    //$("#txClpPersonDepartment").val("<?php echo $this->viewbag['serviceCaseForm']['clpPersonDepartment'] ?>");
    $selectizeClpReferredBy.setValue("<?php echo $this->viewbag['serviceCaseForm']['clpReferredById'] ?>");
    //$("#txClpReferredBy").val("<?php echo $this->viewbag['serviceCaseForm']['clpReferredById'] ?>");
    $("#txCustomerName").val("<?php echo $this->viewbag['serviceCaseForm']['customerName'] ?>");
    $selectizeCustomerGroup.setValue("<?php echo $this->viewbag['serviceCaseForm']['customerGroup'] ?>");
    $selectizeBusinessType.setValue("<?php echo $this->viewbag['serviceCaseForm']['businessTypeId'] ?>");
    //$("#txBusinessType").val("<?php echo $this->viewbag['serviceCaseForm']['businessTypeId'] ?>");
    $("#txClpNetwork").val("<?php echo $this->viewbag['serviceCaseForm']['clpNetwork'] ?>");
    $("#txContactPerson").val("<?php echo $this->viewbag['serviceCaseForm']['contactPersonName'] ?>");
    $("#txTitle").val("<?php echo $this->viewbag['serviceCaseForm']['contactPersonTitle'] ?>");
    $("#txContactNo").val("<?php echo $this->viewbag['serviceCaseForm']['contactPersonNumber'] ?>");
    $selectizeActionBy.setValue("<?php echo $this->viewbag['serviceCaseForm']['actionBy'] ?>");
    //$("#txActionBy").val("<?php echo $this->viewbag['serviceCaseForm']['actionBy'] ?>");
    $("#txCustomerContactedDate").val(
        "<?php echo $this->viewbag['serviceCaseForm']['customerContactedDate'] ?>");
    $selectizeCaseReferredToClpe.setValue(
        "<?php echo $this->viewbag['serviceCaseForm']['caseReferredToClpe'] ?>");
    //$("#txCaseReferredToClpe").val("<?php echo $this->viewbag['serviceCaseForm']['caseReferredToClpe'] ?>");
    $selectizeServiceStatus.setValue("<?php echo $this->viewbag['serviceCaseForm']['serviceStatusId'] ?>");
    //$("#txServiceStatus").val("<?php echo $this->viewbag['serviceCaseForm']['serviceStatusId'] ?>");
    $("#txRequestedVisitDate").val("<?php echo $this->viewbag['serviceCaseForm']['requestedVisitDate'] ?>");
    $("#txActualVisitDate").val("<?php echo $this->viewbag['serviceCaseForm']['actualVisitDate'] ?>");
    $("#txServiceStartDate").val("<?php echo $this->viewbag['serviceCaseForm']['serviceStartDate'] ?>");
    $("#txServiceCompletionDate").val(
        "<?php echo $this->viewbag['serviceCaseForm']['serviceCompletionDate'] ?>");
    $("#txPlannedReportIssueDate").val(
        "<?php echo $this->viewbag['serviceCaseForm']['plannedReportIssueDate'] ?>");
    $("#txActualReportIssueDate").val(
        "<?php echo $this->viewbag['serviceCaseForm']['actualReportIssueDate'] ?>");
    $("#txActualReportWorkingDay").val(
        "<?php echo $this->viewbag['serviceCaseForm']['actualReportWorkingDay'] ?>");
    $("#txActualWorkingDay").val("<?php echo $this->viewbag['serviceCaseForm']['actualWorkingDay'] ?>");
    $("#txActualResponseDay").val("<?php echo $this->viewbag['serviceCaseForm']['actualResponseDay'] ?>");
    $("#txManPowerMP").val("<?php echo $this->viewbag['serviceCaseForm']['mp'] ?>");
    $("#txManPowerG").val("<?php echo $this->viewbag['serviceCaseForm']['g'] ?>");
    $("#txManPowerT").val("<?php echo $this->viewbag['serviceCaseForm']['t'] ?>");
    $selectizeReportedByEic.setValue("<?php echo $this->viewbag['serviceCaseForm']['eicId'] ?>");
    //$("#txReportedByEic").val("<?php echo $this->viewbag['serviceCaseForm']['eicId'] ?>");
    //$selectizeUnitRate.setValue("<?php echo $this->viewbag['serviceCaseForm']['costTypeId'] ?>");
    $("#unitRateCountYear").val("<?php echo $this->viewbag['costType']['countYear'] ?>");
    $('#txUnitRate').find('option').remove().end().append(
        '<option value="<?php echo $this->viewbag['costType']['costTypeId'] ?>"> <?php echo $this->viewbag['costType']['unitCost'] ?></option>'
        );
    $("#txUnitRate").val("<?php echo $this->viewbag['serviceCaseForm']['costTypeId'] ?>");
    $("#txUnit").val("<?php echo $this->viewbag['serviceCaseForm']['costUnit'] ?>");
    $("#txTotal").val("<?php echo $this->viewbag['serviceCaseForm']['costTotal'] ?>");
    $selectizePartyToBeCharged.setValue(
    "<?php echo $this->viewbag['serviceCaseForm']['partyToBeChargedId'] ?>");
    //$("#txPartyToBeCharged").val("<?php echo $this->viewbag['serviceCaseForm']['partyToBeChargedId'] ?>");
    $selectizePlantType.setValue("<?php echo $this->viewbag['serviceCaseForm']['plantTypeId'] ?>");
    //$("#txPlantType").val("<?php echo $this->viewbag['serviceCaseForm']['plantTypeId'] ?>");
    $("#txManufacturerBrand").val("<?php echo $this->viewbag['serviceCaseForm']['manufacturerBrand'] ?>");
    $selectizeMajorAffectedElement.setValue(
        "<?php echo $this->viewbag['serviceCaseForm']['majorAffectedElementId'] ?>");
    //$("#txMajorAffectedElement").val("<?php echo $this->viewbag['serviceCaseForm']['majorAffectedElementId'] ?>");
    $("#txPlantRating").val("<?php echo $this->viewbag['serviceCaseForm']['plantRating'] ?>");
    $("#txCustomerProblems").val("<?php echo $this->viewbag['serviceCaseForm']['customerProblem'] ?>");
    $("#txActionsAndFinding").val(
        "<?php echo preg_replace('/(\r\n|\n|\r)/', '\n', trim($this->viewbag['serviceCaseForm']['actionAndFinding'])) ?>"
        );
    $("#txRecommendation").val("<?php echo $this->viewbag['serviceCaseForm']['recommendation'] ?>");
    $("#txRemark").val("<?php echo $this->viewbag['serviceCaseForm']['remark'] ?>");
    if (<?php echo $this->viewbag['serviceCaseForm']['requiredFollowUp'] ?>) {
        $("#txRequiredFollowUp").prop("checked", true);
    }
    $("#txImplementedSolution").val("<?php echo $this->viewbag['serviceCaseForm']['implementedSolution'] ?>");
    $("#txProposedSolution").val("<?php echo $this->viewbag['serviceCaseForm']['proposedSolution'] ?>");
    $("#txProjectRegion").val("<?php echo $this->viewbag['serviceCaseForm']['projectRegion'] ?>");
    $("#txprojectAddress").val("<?php echo $this->viewbag['serviceCaseForm']['projectAddress'] ?>");
    $selectizeActive.setValue("<?php echo $this->viewbag['serviceCaseForm']['active'] ?>");
    $("#txPlanningAheadId").val("<?php echo $this->viewbag['serviceCaseForm']['planningAheadId'] ?>");
    //$("#txActive").val("<?php echo $this->viewbag['serviceCaseForm']['active'] ?>");
    switch ($("#txServiceType").val()) {
        case "1": //Enquiry
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
        case "2": //Site Visit
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
        case "3": //Investigation (L)
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
        case "4": //Investigation (S)
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
        case "5": //Reach Out
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
        case "6": //"PQ workshop visit":
            break;
        case "":
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
    $("#Form input ").each(function(index, value) {
        $(this).attr("readonly", true);
        $(this).attr("disabled", true);
    });
    $("#Form select ").each(function(index, value) {
        $(this).attr("readonly", true);
        $(this).attr("disabled", true);
        $(this).selectize({
            create: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            }
        });
        if ($(this).is('[readonly]')) {
            $(this)[0].selectize.lock();
        }

    });
    $("#Form textarea ").each(function(index, value) {
        $(this).attr("readonly", true);
        $(this).attr("disabled", true);
    });
    <?php } else {?>
    $("#title").html("Case Form ( New )");
    $("#unitRateCountYear option[value='<?php echo date('Y') ?>']").attr("selected", true);
    $("#txParentCaseNo").val("<?php echo ($this->viewbag['CaseNoMax'] + 1) ?>")
    $(".btnFormApply").unbind().bind("click", function() {
        if (!validateInput()) {
            return;
        }
        $("#loading-modal").modal("show");
        $(this).attr("disabled", true);


        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxInsertCaseForm",
            type: "POST",
            cache: false,
            data: $("#Form").serializeArray(),
            success: function(data) {
                console.log(data);
                var retJson = JSON.parse(data);

                if (retJson.status == "OK") {
                    // display message
                    showMsg("<i class=\"fas fa-check-circle\"></i> ", "Info",
                        "Case Form created.", "",
                        function() {
                            window.location.href =
                                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch"
                            // table.ajax.reload(null, false);

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
            $(".btnFormApply").attr("disabled", false);
        });
    });
    <?php }?>


    var availableTags = [<?php foreach ($this->viewbag['requestedByList'] as $requestedBy) {?> {
            value: "name:<?php echo $requestedBy['requestedByName'] ?>, dept: <?php echo $requestedBy['requestedByDept'] ?>",
            name: "<?php echo $requestedBy['requestedByName'] ?>",
            dept: "<?php echo $requestedBy['requestedByDept'] ?>"
        },
        <?php }?>
    ];
    var availableTagsForCustomer = [<?php foreach ($this->viewbag['customerList'] as $customer) {?> {
            value: "name:<?php echo preg_replace("/\r|\n/", "", $customer['customerName']); ?> , group : <?php echo $customer['customerGroup'] ?> , business type : <?php echo $customer['businessTypeName'] ?> , clp Network: <?php echo $customer['clpNetwork'] ?>",
            name: "<?php echo $customer['customerName'] ?>",
            group: "<?php echo $customer['customerGroup'] ?>",
            businessTypeId: "<?php echo $customer['businessTypeId'] ?>",
            clpNetwork: "<?php echo $customer['clpNetwork'] ?>"
        },
        <?php }?>
    ];
    var availableTagsForContactPerson = [
        <?php foreach ($this->viewbag['contactPersonList'] as $contactPerson) {?> {
            value: "name:<?php echo $contactPerson['contactPersonName'] ?>,title:<?php echo $contactPerson['contactPersonTitle'] ?>",
            name: "<?php echo $contactPerson['contactPersonName'] ?>",
            title: "<?php echo $contactPerson['contactPersonTitle'] ?>",
            contactNo: "<?php echo $contactPerson['contactPersonNo'] ?>"
        },
        <?php }?>
    ];

    var availableTagsForIncident = [<?php foreach ($this->viewbag['incidentList'] as $incident) {?> {
            value: "Id:<?php echo $incident['idrNo'] ?>,Date:<?php echo $incident['incidentDate'] ?>,Voltage:<?php echo $incident['voltage'] ?>",
            incidentId: "<?php echo $incident['incidentId'] ?>",
            idrNo: "<?php echo $incident['idrNo'] ?>",
            incidentDate: "<?php echo $incident['incidentDate'] ?>",
            incidentTime: "<?php echo $incident['incidentTime'] ?>",
            voltage: "<?php echo $incident['voltage'] ?>",
            circuit: "<?php echo $incident['circuit'] ?>",
            durations: "<?php echo $incident['durations'] ?>",
            vL1: "<?php echo $incident['vL1'] ?>",
            vL2: "<?php echo $incident['vL2'] ?>",
            vL3: "<?php echo $incident['vL3'] ?>",
            ourRef: "<?php echo $incident['ourRef'] ?>"
        },
        <?php }?>
    ];
    $("#txRequestedBy").autocomplete({
        source: function(request, response) {
            var results = $.ui.autocomplete.filter(availableTags, request.term);
            response(results.slice(0, 10));
        },
        focus: function(event, ui) {
            $("#txRequestedBy").val(ui.item.name);
            return false;
        },
        select: function(event, ui) {
            $("#txRequestedBy").val(ui.item.name);
            $selectizeClpPersonDepartment.setValue(ui.item.dept);
            return false;
        }
    }).keydown(function(event) {
        if (event.keyCode == 8) {
            $selectizeClpPersonDepartment.setValue('');
        }
    });

    $("#txCustomerName").autocomplete({
        source: function(request, response) {
            var results = $.ui.autocomplete.filter(availableTagsForCustomer, request.term);
            response(results.slice(0, 10));
        },
        focus: function(event, ui) {
            $("#txCustomerName").val(ui.item.name);
            return false;
        },
        select: function(event, ui) {
            $("#txCustomerName").val(ui.item.name);
            $selectizeCustomerGroup.setValue(ui.item.group);
            $selectizeBusinessType.setValue(ui.item.businessTypeId);
            $("#txClpNetwork").val(ui.item.clpNetwork);
            return false;
        }
    }).keydown(function(event) {
        if (event.keyCode == 8) {
            $selectizeCustomerGroup.setValue('');
            $selectizeBusinessType.setValue('');
            $("#txClpNetwork").val('');
        }
    });
    $("#txContactPerson").autocomplete({
        source: function(request, response) {
            var results = $.ui.autocomplete.filter(availableTagsForContactPerson, request.term);
            response(results.slice(0, 10));
        },
        focus: function(event, ui) {
            $("#txContactPerson").val(ui.item.name);
            return false;
        },
        select: function(event, ui) {
            $("#txContactPerson").val(ui.item.name);
            $("#txTitle").val(ui.item.title);
            $("#txContactNo").val(ui.item.contactNo);
            return false;
        }
    }).keydown(function(event) {
        if (event.keyCode == 8) {
            $("#txTitle").val('');
            $("#txContactNo").val('');
        }
    });
    $("#txIdrOrderId").autocomplete({
        source: function(request, response) {
            var results = $.ui.autocomplete.filter(availableTagsForIncident, request.term);
            response(results.slice(0, 10));
        },
        focus: function(event, ui) {
            $("#txIdrOrderId").val(ui.item.idrNo);
            return false;
        },
        select: function(event, ui) {
            $("#txIdrOrderId").val(ui.item.idrNo);
            $("#txIncidentDate").val(ui.item.incidentDate);
            $("#txIncidentTime").val(ui.item.incidentTime);
            $("#idrNo").val(ui.item.idrNo);
            $("#incidentDate").val(ui.item.incidentDate + ' ' + ui.item.incidentTime);
            $("#voltage").val(ui.item.voltage);
            $("#circuit").val(ui.item.circuit);
            $("#durations").val(ui.item.durations);
            $("#vL1").val(ui.item.vL1);
            $("#vL2").val(ui.item.vL2);
            $("#vL3").val(ui.item.vL3);
            $("#ourRef").val(ui.item.ourRef);
            $("#txIncidentId").val(ui.item.incidentId);
            $("#txIncidentDate").attr('readonly', true);
            $("#txIncidentTime").attr('readonly', true);
            $("#txIncidentDate").attr('hidden', true);
            $("#txIncidentTime").attr('hidden', true);
            $("#incidentDiv").collapse('show');
            return false;
        },
    }).keydown(function(event) {
        if (event.keyCode == 8) {
            $("#txIncidentDate").val('');
            $("#txIncidentTime").val('');
            $("#idrNo").val('');
            $("#incidentDate").val('');
            $("#voltage").val('');
            $("#circuit").val('');
            $("#durations").val('');
            $("#vL1").val('');
            $("#vL2").val('');
            $("#vL3").val('');
            $("#ourRef").val('');
            $("#txIncidentId").val('');
            $("#incidentDiv").collapse('hide');
            $("#txIncidentDate").attr('readonly', false);
            $("#txIncidentTime").attr('readonly', false);
            $("#txIncidentDate").attr('hidden', false);
            $("#txIncidentTime").attr('hidden', false);
        }
    });
    /*var projects = [ { id: "12",value: "Don Davis" }, { id: "17", value:"Stan Smith" } ]

        $( "#txCustomerName" ).autocomplete({
            minLength: 0,
            source: projects,
            focus: function( event, ui ) {
                $( "#txCustomerName" ).val( ui.item.id);
                return false;
            },
            select: function( event, ui ) {
                $( "#txCustomerName" ).val( ui.item.id);
                $( "#txTitle" ).val( ui.item.id);

                return false;
            },
            search: function(event, ui) { console.log(event); console.log(ui) }
        })
     */

    $("#totalRecalculator").unbind().bind("click", function() {
        //value=  $selectizeUnitRate.options[$selectizeUnitRate.items].text.trim() *  $("#txUnit").val();
        value = $("#txUnitRate").find("option:selected").text().trim() * $("#txUnit").val();
        $("#txTotal").val(value);
        $("#txTotal").focus();
    });

    $("#txServiceCompletionDate").change(function() {
        if ($("#txServiceType").val() == 3 || $("#txServiceType").val() == 4) {
            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxGetPlannedReportIssueWorkingDate&numberOfWorkingDay=<?php echo $this->viewbag['caseFormPlannedToActualReportIssueWorkingDay']["configValue"] ?>", //10workingDay
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
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event
                        .retMessage);
                }
            }).always(function(data) {

            });
        } else {
            $.ajax({
                url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxGetActualWorkingDay",
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
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event
                        .retMessage);
                }
            }).always(function(data) {
                $("#loading-modal").modal("hide");
                $("#actualWorkingDayRecalculator").attr("disabled", false);
            });
        }
    });

    $("#plannedReportIssueDateRecalculator").unbind().bind("click", function() {
        $("#loading-modal").modal("show");
        $(this).attr("disabled", true);
        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxGetPlannedReportIssueWorkingDate&numberOfWorkingDay=<?php echo $this->viewbag['caseFormPlannedToActualReportIssueWorkingDay']["configValue"] ?>", //10workingDay
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
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxGetActualReportWorkingDay",
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
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxGetActualWorkingDay",
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
        //value=  $selectizeUnitRate.options[$selectizeUnitRate.items].text.trim() *  $("#txUnit").val();
        value = $("#txUnitRate").find("option:selected").text().trim() * $("#txUnit").val();
        $("#txTotal").val(value);
    });
    $("#txUnit").change(function() {
        // value=  $selectizeUnitRate.options[$selectizeUnitRate.items].text.trim() *  $("#txUnit").val();
        value = $("#txUnitRate").find("option:selected").text().trim() * $("#txUnit").val();
        $("#txTotal").val(value);
    });
    $("#txServiceType").change(function(e) {
        value = $(this).find("option:selected").val();
        switch (value) {
            case "1": //Enquiry
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
            case "2": //Site Visit
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
            case "3": //Investigation (L)
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
            case "4": //Investigation (S)
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
            case "5": //Reach Out
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
            case "6": //"PQ workshop visit":
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
            case "":
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
        checkUnitCost();

    });
    $("#unitRateCountYear").change(function(e) {
        checkUnitCost();
    });

    function checkUnitCost() {
        var serviceTypeId = $("#txServiceType").find("option:selected").val();
        var unitRateYear = $("#unitRateCountYear option:selected").val();
        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxGetUnitRateByCountYearAndServiceTypeId&serviceTypeId=" +
                serviceTypeId + "&countYear=" + unitRateYear,
            type: "POST",
            cache: false,
            data: $("#Form").serializeArray(),
            success: function(data) {
                console.log(data);
                var retJson = JSON.parse(data);

                if (retJson.status == "OK") {
                    // display message
                    $('#txUnitRate').find('option').remove().end().append('<option value="' +
                        retJson.costTypeId + '">' + retJson.unitCost + '</option>');
                    $("#txUnitRate option[value='" + retJson.costTypeId + "'").attr("selected",
                        true);

                } else {
                    // error message
                    showError("<i class=\"fas fa-times-circle\"></i> ", "Error", retJson
                    .retMessage);
                    $('#txUnitRate').find('option').remove().end();
                }
            }
        }).fail(function(event, jqXHR, settings, thrownError) {
            if (event.status != 440) {
                showError("<i class=\"fas fa-times-circle\"></i> ", "Error", event.retMessage);
            }
        }).always(function(data) {
            $("#loading-modal").modal("hide");
        });
    }

    function validateInput() {
        //  if ($("#txCaseNo").val() == "") {
        //  showError("<i class=\"fas fa-times-circle\"></i> ", "Error", "Case No can not be blank");
        //      return false;
        //  }
        $(".invalidSelectize").each(function(index, value) {
            $(this).removeClass("invalidSelectize");
        });
        $("#Form input ").each(function(index, value) {
            $(this).removeClass("invalid");
        });
        $("#Form select ").each(function(index, value) {
            $(this).removeClass("invalid");

        });

        var errorMessage = "";
        var i = 1;
        if ($("#txParentCaseNo").val() == "") {

            if (errorMessage == "")
                $("#txParentCaseNo").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Case No can not be blank <br/>";

            i = i + 1;
            $("#txParentCaseNo").addClass("invalid");
        }
        if ($("#txServiceType").val() == "") {

            if (errorMessage == "")
                $("#txServiceType").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Services Type Name can not be blank <br/>";

            i = i + 1;
            $("#divServiceType").addClass("invalidSelectize");
        }
        if ($("#txProblemType").val() == "") {

            if (errorMessage == "")
                $("#txProblemType").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Problem Type Name can not be blank <br/>";

            i = i + 1;
            $("#divProblemType").addClass("invalidSelectize");
        }
        if ($("#txRequestDate").val() == "") {
            if (errorMessage == "")
                $("#txRequestDate").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Request Date can not be blank <br/>";
            i = i + 1;
            $("#txRequestDate").addClass("invalid");
        }
        /*   if ($("#txRequestTime").val() == "") {
               if(errorMessage =="")
               $("#txRequestTime").focus();
               errorMessage = errorMessage + "Error " + i +": " + "Request Date Time can not be blank <br/>";
               i =i+1;
               $("#txRequestTime").addClass("invalid");
           } */
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
            $("#divClpPersonDepartment").addClass("invalidSelectize");
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
            $("#divCustomerGroup").addClass("invalidSelectize");
        }
        /*if ($("#txContactPerson").val() == "") {
            if(errorMessage =="")
            $("#txContactPerson").focus();
            errorMessage = errorMessage + "Error " + i +": " + "Contact Person can not be blank <br/>";
            i =i+1;
            $("#txContactPerson").addClass("invalid");
        }
        if ($("#txTitle").val() == "") {
            if(errorMessage =="")
            $("#txTitle").focus();
            errorMessage = errorMessage + "Error " + i +": " + "Title can not be blank <br/>";
            i =i+1;
            $("#txTitle").addClass("invalid");
        }*/
        if ($("#txActionBy").val() == "") {
            if (errorMessage == "")
                $("#txActionBy").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Action By can not be blank <br/>";
            i = i + 1;
            $("#divActionBy").addClass("invalidSelectize");
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
        }*/
        if ($("#txCaseReferredToClep").val() == "") {
            if (errorMessage == "")
                $("#txCaseReferredToClep").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Case Referred To CLPE can not be blank <br/>";
            i = i + 1;
            $("#divCaseReferredToClep").addClass("invalidSelectize");
        }
        if ($("#txServiceStatus").val() == "") {
            if (errorMessage == "")
                $("#txServiceStatus").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Service Status To CLPE can not be blank <br/>";
            i = i + 1;
            $("#divServiceStatus").addClass("invalidSelectize");
        }
        if ($("#txReportedByEic").val() == "") {
            if (errorMessage == "")
                $("#txReportedByEic").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Report By EIC To CLPE can not be blank <br/>";
            i = i + 1;
            $("#divReportedByEic").addClass("invalidSelectize");
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
        if ($("#txPartyToBeCharged").val() == "") {
            if (errorMessage == "")
                $("#txPartyToBeCharged").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Party To Be Charged can not be blank <br/>";
            i = i + 1;
            $("#divPartyToBeCharged").addClass("invalidSelectize");
        }
        if ($("#txCustomerProblems").val() == "") {
            if (errorMessage == "")
                $("#txCustomerProblems").focus();
            errorMessage = errorMessage + "Error " + i + ": " + "Customer Problems can not be blank <br/>";
            i = i + 1;
            $("#txCustomerProblems").addClass("invalid");
        }

        /*if($("#txServiceType").val()=="3" || $("#txServiceType").val()=="4"){
            if($("#txActualReportIssueDate").val()!="" ){
                if($("#txActualReportIssueDate").val()<"<?php echo $this->viewbag['deadLine'] ?>") {
                if(errorMessage =="")
                $("#txActualReportIssueDate").focus();
                errorMessage = errorMessage + "Error " + i +": " + "Actual Report Issue Date Can not Input a date before report Deadline :<?php echo $this->viewbag['deadLine'] ?> <br/>";
                i =i+1;
                $("#txActualReportIssueDate").addClass("invalid");
                }
            }
        }else{
            if($("#txServiceCompletionDate").val()!="") {
                if($("#txServiceCompletionDate").val()< "<?php echo $this->viewbag['deadLine'] ?>") {
                if(errorMessage =="")
                $("#txServiceCompletionDate").focus();
                errorMessage = errorMessage + "Error " + i +": " + "Service Completion Date Can not Input a date before report Deadline :<?php echo $this->viewbag['deadLine'] ?> <br/>";
                i =i+1;
                $("#txServiceCompletionDate").addClass("invalid");
                }
            }

        }*/

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