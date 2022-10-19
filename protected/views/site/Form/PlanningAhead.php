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

    .special-input input {
        font-size: 17px;
        border: 1px solid grey;
        width: 20%;
        float: left;
        background: #f1f1f1;
    }

    /* Style the submit button */
    .special-input button {
        float: left;
        width: 15%;
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

    .row {
        padding-bottom: 4px;
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


<div class="card border border-secondary container-fluid" style="background-color: #dee2e6;">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-9">
                <h3 id="title">Planning Ahead</h3>
            </div>
            <div class="col-lg-3" style="text-align:right">
                <button id="btnFormChoose" name="btnFormChoose" type="button" class="btn btn-primary btnFormChoose"
                    hidden>Choose</button>
                <button id="btnFormApply" name="btnFormApply" type="button"
                    class="btn btn-primary btnFormApply">Apply</button>
                <button id="btnFormCancel" name="btnFormCancel" type="button"
                    class="btn btn-danger btnFormCancel">Cancel</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form id="Form">
            <div id="content" style="padding:0px 10px 0px 10px">
                <div class="row">
                    <!-- Project -->
                    <div class="col-lg-12 border border-secondary" style="padding: 1rem 1rem 1rem 1rem;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="title" style="color:#2e64c7db;"><label><b>Project</b></label></div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-5"><label style="white-space:nowrap">Project Ref </label></div>
                                    <div class="col-lg-7">
                                        <input id="txProjectRef" name="txProjectRef" type="text" class="" placeholder=""
                                            style="width:50%" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-2"><label>Project Title </label></div>
                                    <div class="col-lg-7 special-input">
                                        <input id="txProjectTitle" name="txProjectTitle" type="text" class=""
                                            placeholder="" style="width:85%" />
                                        <button type="button"><i id="txProjectTitleCheckingBtn" class="fa fa-check"
                                                aria-hidden="true"></i></button>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                            </div>

                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-5"><label>Scheme Number/PBE </label></div>
                                    <div class="col-lg-7">
                                        <input id="txSchemeNumber" name="txSchemeNumber" type="text" class=""
                                            placeholder="" style="width:50%" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                            </div>
                            <div class="col-lg-4">
                            </div>
                            <hr>
                            <div class="col-lg-4">
                                <small class="text-muted">Project Address </small>
                                <div class="row">
                                    <div class="col-lg-5"><label>Project Region </label></div>
                                    <div class="col-lg-7 special-input">
                                        <input id="txProjectRegion" name="txProjectRegion" type="text" class=""
                                            placeholder="" style="width:85%" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Project Address </label></div>
                                    <div class="col-lg-7 special-input">
                                        <input id="txProjectAddress" name="txProjectAddress" type="text" class=""
                                            placeholder="" style="width:85%" />
                                        <button type="button"><i id="txProjectAddressCheckingBtn" class="fa fa-check"
                                                aria-hidden="true"></i></button>
                                    </div>
                                </div>
                                <div class="row" id="">
                                    <div class="col-lg-5"><label>PQSIS Case No </label></div>
                                    <div class="col-lg-7">
                                        <input id="txProjectAddressParentCaseNo" name="txProjectAddressParentCaseNo"
                                            type="number" class="" placeholder="Case No" min="0" max="99999" /> <b>.</b>
                                        <input id="txProjectAddressCaseVersion" name="txProjectAddressCaseVersion"
                                            type="number" class="" step="1" placeholder="" min="0" max="99999"
                                            style="width:50px" />
                                    </div>
                                </div>
                                <small class="text-muted">Status </small>
                                <div class="row">
                                    <div class="col-lg-5"><label>Input Date</label></div>
                                    <div class="col-lg-7">
                                        <input id="txInputDate" name="txInputDate" type="text" class=""
                                            placeholder="YYYY-mm-dd" style="width:85%" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Region letter Issue Date</label></div>
                                    <div class="col-lg-7">
                                        <input id="txRegionLetterIssueDate" name="txRegionLetterIssueDate" type="text"
                                            class="" placeholder="YYYY-mm-dd" style="width:85%" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Reported By<span class="text-danger"></span></label>
                                    </div>
                                    <div class="col-lg-7">
                                        <input id="txReportedBy" name="txReportedBy" type="text" class="" placeholder=""
                                            style="width:85%" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Last Updated By<span
                                                class="text-danger"></span></label></div>
                                    <div class="col-lg-7">
                                        <input id="txLastUpdatedBy" name="txLastUpdatedBy" type="text" class=""
                                            placeholder="" style="width:85%" readonly />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Last Updated Date<span
                                                class="text-danger"></span></label></div>
                                    <div class="col-lg-7">
                                        <input id="txLastUpdatedTime" name="txLastUpdatedTime" type="text" class=""
                                            placeholder="" style="width:85%" readonly />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label> Region Planner </label></div>
                                    <div class="col-lg-7">
                                        <select class="" id="txRegionPlanner" name="txRegionPlanner"
                                            style="height:30px;width:85%">
                                            <option value="" selected>------</option>
                                            <?php foreach($this->viewbag['regionPlannerList'] as $regionPlanner){ ?>
                                            <option value="<?php echo $regionPlanner['regionPlannerId']?>">
                                                <?php echo $regionPlanner['regionPlannerName']?></option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <small class="text-muted"> Type </small>
                                <div class="row">
                                    <div class="col-lg-5"><label>Building Type </label></div>
                                    <div class="col-lg-7">
                                        <select class="" id="txBuildingType" name="txBuildingType"
                                            style="height:30px;width:85%">
                                            <option value="0" selected>------</option>
                                            <?php foreach($this->viewbag['buildingTypeList'] as $buildingType){ ?>
                                            <option value="<?php echo $buildingType['buildingTypeId']?>">
                                                <?php echo $buildingType['buildingTypeName']?></option>

                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Project Type </label></div>
                                    <div class="col-lg-7">
                                        <select class="" id="txProjectType" name="txProjectType"
                                            style="height:30px;width:85%">
                                            <option value="0" selected>------</option>
                                            <?php foreach($this->viewbag['projectTypeList'] as $projectType){ ?>
                                            <option value="<?php echo $projectType['projectTypeId']?>">
                                                <?php echo $projectType['projectTypeName']?></option>

                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Key infrastructure</label></div>
                                    <div class="col-lg-7">
                                        <input type="checkbox" id="txKeyinfrastructure" name="txKeyinfrastructure">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Potential Successful Case</label></div>
                                    <div class="col-lg-7">
                                        <input type="checkbox" id="txPotentialSuccessfulCase"
                                            name="txPotentialSuccessfulCase">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Critical Project</label></div>
                                    <div class="col-lg-7">
                                        <input type="checkbox" id="txCriticalProject" name="txCriticalProject">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Temp Supply Project</label></div>
                                    <div class="col-lg-7">
                                        <input type="checkbox" id="txTempSupplyProject" name="txTempSupplyProject">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <small class="text-muted">Equipment </small>
                                <div class="row">
                                    <div class="col-lg-5"><label>BMS</label></div>
                                    <div class="col-lg-7">
                                        <input type="checkbox" id="txBms" name="txBms">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Change Over Scheme</label></div>
                                    <div class="col-lg-7">
                                        <input type="checkbox" id="txChangeoverScheme" name="txChangeoverScheme">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Chiller Plant</label></div>
                                    <div class="col-lg-7">
                                        <input type="checkbox" id="txChillerPlant" name="txChillerPlant">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Escalator</label></div>
                                    <div class="col-lg-7">
                                        <input type="checkbox" id="txEscalator" name="txEscalator">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Hid Lamp</label></div>
                                    <div class="col-lg-7">
                                        <input type="checkbox" id="txHidLamp" name="txHidLamp">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Lift</label></div>
                                    <div class="col-lg-7">
                                        <input type="checkbox" id="txLift" name="txLift">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Sensitive Machine</label></div>
                                    <div class="col-lg-7">
                                        <input type="checkbox" id="txSensitiveMachine" name="txSensitiveMachine">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Telcom</label></div>
                                    <div class="col-lg-7">
                                        <input type="checkbox" id="txTelcom" name="txTelcom">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>acbTripping</label></div>
                                    <div class="col-lg-7">
                                        <input type="checkbox" id="txAcbTripping" name="txAcbTripping">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Building With High Penetration Equipment</label></div>
                                    <div class="col-lg-7">
                                        <input type="checkbox" id="txBuildingWithHighPenetrationEquipment"
                                            name="txBuildingWithHighPenetrationEquipment">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>RE</label></div>
                                    <div class="col-lg-7">
                                        <input type="checkbox" id="TxRe" name="TxRe">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>EV</label></div>
                                    <div class="col-lg-7">
                                        <input type="checkbox" id="TxEv" name="TxEv">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>Estimated Load<span class="text-danger"></span></label>
                                    </div>
                                    <div class="col-lg-7">
                                        <input id="txEstimatedLoad" name="txEstimatedLoad" type="text" class=""
                                            placeholder="" style="width:85%" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-5"><label>PQIS Number<span class="text-danger"></span></label>
                                    </div>
                                    <div class="col-lg-7">
                                        <input id="txPqisNumber" name="txPqisNumber" type="number" class=""
                                            placeholder="" style="width:85%" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end of Project -->
                    <!--PQ walk -->
                    <div class="col-lg-4 border border-secondary" style="padding: 1rem 1rem 1rem 1rem;">
                        <div class="title" style="color:#2e64c7db"><label><b>PQ Walk</b></label></div>
                        <div class="row">
                            <div class="col-lg-5"><label>Project Region </label></div>
                            <div class="col-lg-7 special-input">
                                <input id="txPqSiteWalkProjectRegion" name="txPqSiteWalkProjectRegion" type="text"
                                    class="" placeholder="" style="width:85%" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label>Project Address </label></div>
                            <div class="col-lg-7 special-input">
                                <input id="txPqSiteWalkProjectAddress" name="txPqSiteWalkProjectAddress" type="text"
                                    class="" placeholder="" style="width:85%" />
                                <button type="button"><i id="txPqSiteWalkProjectAddressCheckingBtn" class="fa fa-check"
                                        aria-hidden="true"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12"><label> Sensitive Equipment and Corresponding Mitigation Solutions
                                    Found During Site Walk </label></div>
                            <div class="col-lg-12">
                                <textarea id="txSensitiveEquipment" name="txSensitiveEquipment" placeholder=""
                                    style="width:100%"></textarea>
                            </div>
                        </div>
                        <small class="text-muted">First Walk</small>
                        <div class="row no-gutters">
                            <div class="col-lg-7"><label>1st PQ site Walk Date </label></div>
                            <div class="col-lg-5">
                                <input id="txFirstPqSiteWalkDate" name="txFirstPqSiteWalkDate" type="text" class=""
                                    placeholder="YYYY-mm-dd" style="width:85%" />
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-7"><label>1st PQ site Walk Status </label></div>
                            <div class="col-lg-5">
                                <select class="" id="txFirstPqSiteWalkStatus" name="txFirstPqSiteWalkStatus"
                                    style="height:30px;width:85%">
                                    <option value="" selected>------</option>
                                    <option value="Success">Success</option>
                                    <option value="Fail">Fail</option>
                                    <option value="Unsure">Unsure</option>
                                </select>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-7"><label>1st PQ site walk invitation letter’s link </label></div>
                            <div class="col-lg-5">
                                <input id="txFirstPqSiteWalkInvitationLetterLink"
                                    name="txFirstPqSiteWalkInvitationLetterLink" type="text" class="" placeholder=""
                                    style="width:85%" />
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-7"><label>Letter for request 1st PQ site walk date </label></div>
                            <div class="col-lg-5">
                                <input id="txFirstPqSiteWalkRequestLetterDate" name="txFirstPqSiteWalkRequestLetterDate"
                                    type="text" class="" placeholder="YYYY-mm-dd" style="width:85%" />
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-7"><label>PQ walk assessment report Date </label></div>
                            <div class="col-lg-5">
                                <input id="txPqWalkAssessmentReportDate" name="txPqWalkAssessmentReportDate" type="text"
                                    class="" placeholder="YYYY-mm-dd" style="width:85%" />
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-7"><label>PQ walk assessment report link/path <span
                                        class="text-danger"></span></label></div>
                            <div class="col-lg-5">
                                <input id="txPqWalkAssessmentReportLink" name="txPqWalkAssessmentReportLink" type="text"
                                    class="" placeholder="" style="width:85%" />
                            </div>
                        </div>
                        <div class="row no-gutters" id="">
                            <div class="col-lg-7"><label>PQSIS Case No </label></div>
                            <div class="col-lg-5">
                                <input id="txFirstPqSiteWalkParentCaseNo" name="txFirstPqSiteWalkParentCaseNo"
                                    type="number" class="" placeholder="Case No" min="0" max="99999" /> <b>.</b>
                                <input id="txFirstPqSiteWalkCaseVersion" name="txFirstPqSiteWalkCaseVersion"
                                    type="number" class="" step="1" placeholder="" min="0" max="99999"
                                    style="width:50px" />
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-7"><label>Customer response for site walk </label></div>
                            <div class="col-lg-5">
                                <select id="txFirstPqSiteWalkCustomerResponse" name="txFirstPqSiteWalkCustomerResponse"
                                    style="height:30px;width:85%">
                                    <option value=""> --- </option>
                                    <option value="accept"> Accept </option>
                                    <option value="pending"> Pending </option>
                                    <option value="reject"> Reject </option>
                                </select>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-7"><label>Investigation Status </label></div>
                            <div class="col-lg-5">
                                <select id="txFirstPqSiteWalkInvestigationStatus"
                                    name="txFirstPqSiteWalkInvestigationStatus" style="height:30px;width:85%">
                                    <option value=""> --- </option>
                                    <option value="pass"> Pass </option>
                                    <option value="fail"> Fail </option>
                                </select>
                            </div>
                        </div>
                        <small class="text-muted">Second Walk</small>
                        <div class="row no-gutters">
                            <div class="col-lg-7"><label>2nd PQ site Walk Date </label></div>
                            <div class="col-lg-5">
                                <input id="txSecondPqSiteWalkDate" name="txSecondPqSiteWalkDate" type="text" class=""
                                    placeholder="YYYY-mm-dd" style="width:85%" />
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-7"><label>2nd PQ site walk invitation letter’s link </label></div>
                            <div class="col-lg-5">
                                <input id="txSecondPqSiteWalkInvitationLetterLink"
                                    name="txSecondPqSiteWalkInvitationLetterLink" type="text" class="" placeholder=""
                                    style="width:85%" />
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-7"><label>Letter for request 2nd PQ site walk date </label></div>
                            <div class="col-lg-5">
                                <input id="txSecondPqSiteWalkRequestLetterDate"
                                    name="txSecondPqSiteWalkRequestLetterDate" type="text" class=""
                                    placeholder="YYYY-mm-dd" style="width:85%" />
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-7"><label>PQ assessment follow up report Date </label></div>
                            <div class="col-lg-5">
                                <input id="txPqAssessmentFollowUpReportDate" name="txPqAssessmentFollowUpReportDate"
                                    type="text" class="" placeholder="YYYY-mm-dd" style="width:85%" />
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-7"><label>PQ assessment follow up report link/path <span
                                        class="text-danger"></span></label></div>
                            <div class="col-lg-5">
                                <input id="txPqAssessmentFollowupReportLink" name="txPqAssessmentFollowupReportLink"
                                    type="text" class="" placeholder="" style="width:85%" />
                            </div>
                        </div>
                        <div class="row no-gutters" id="">
                            <div class="col-lg-7"><label>PQSIS Case No </label></div>
                            <div class="col-lg-5">
                                <input id="txSecondPqSiteWalkParentCaseNo" name="txSecondPqSiteWalkParentCaseNo"
                                    type="number" class="" placeholder="Case No" min="0" max="99999" /> <b>.</b>
                                <input id="txSecondPqSiteWalkCaseVersion" name="txSecondPqSiteWalkCaseVersion"
                                    type="number" class="" step="1" placeholder="" min="0" max="99999"
                                    style="width:50px" />
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-7"><label>Customer response for site walk </label></div>
                            <div class="col-lg-5">
                                <select id="txSecondPqSiteWalkCustomerResponse"
                                    name="txSecondPqSiteWalkCustomerResponse" style="height:30px;width:85%">
                                    <option value=""> --- </option>
                                    <option value="accept"> Accept </option>
                                    <option value="pending"> Pending </option>
                                    <option value="reject"> Reject </option>
                                </select>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-lg-7"><label>Investigation Status </label></div>
                            <div class="col-lg-5">
                                <select id="txSecondPqSiteWalkInvestigationStatus"
                                    name="txSecondPqSiteWalkInvestigationStatus" style="height:30px;width:85%">
                                    <option value=""> --- </option>
                                    <option value="pass"> Pass </option>
                                    <option value="fail"> Fail </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--End Of PQ walk -->
                    <!-- Consultant Information -->
                    <div class="col-lg-4 border border-secondary" style="padding: 1rem 1rem 1rem 1rem;">
                        <div class="title" style="color:#2e64c7db"><label><b>Consultant Information</b></label></div>
                        <div class="row">
                            <div class="col-lg-5"><label>Consultant Company Name </label></div>
                            <div class="col-lg-7">
                                <select class="" id="txConsultantCompanyName" name="txConsultantCompanyName"
                                    style="height:30px;width:85%">
                                    <option value="" selected>------</option>
                                    <?php foreach($this->viewbag['consultantCompanyList'] as $consultantCompany){ ?>
                                    <option value="<?php echo $consultantCompany['consultantCompanyId']?>">
                                        <?php echo $consultantCompany['consultantCompanyName']?></option>

                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Consultant Name </label></div>
                            <div class="col-lg-7">
                                <select class="" id="txConsultantName" name="txConsultantName"
                                    style="height:30px;width:85%">
                                    <option value="" selected>------</option>
                                    <?php foreach($this->viewbag['consultantList'] as $consultant){ ?>
                                    <option companyId="<?php echo $consultant['consultantCompanyId']?>"
                                        value="<?php echo $consultant['consultantId']?>">
                                        <?php echo $consultant['consultantName']?></option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Phone No.1 </label></div>
                            <div class="col-lg-7">
                                <input id="txPhoneNumber1" name="txPhoneNumber1" type="tel" class="" placeholder=""
                                    style="width:85%" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Phone No.2 </label></div>
                            <div class="col-lg-7">
                                <input id="txPhoneNumber2" name="txPhoneNumber2" type="tel" class="" placeholder=""
                                    style="width:85%" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Phone No.3 </label></div>
                            <div class="col-lg-7">
                                <input id="txPhoneNumber3" name="txPhoneNumber3" type="tel" class="" placeholder=""
                                    style="width:85%" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Email 1 </label></div>
                            <div class="col-lg-7">
                                <input id="txEmail1" name="txEmail1" type="text" class="" placeholder=""
                                    style="width:85%" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Email 2 </label></div>
                            <div class="col-lg-7">
                                <input id="txEmail2" name="txEmail2" type="text" class="" placeholder=""
                                    style="width:85%" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Email 3 </label></div>
                            <div class="col-lg-7">
                                <input id="txEmail3" name="txEmail3" type="text" class="" placeholder=""
                                    style="width:85%" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Remark </label></div>
                            <div class="col-lg-7">
                                <textarea id="txConsultantInformationRemark" name="txConsultantInformationRemark"
                                    placeholder="" style="width:85%"></textarea>
                            </div>
                        </div>
                        <br />
                        <small class="text-muted">Status </small>
                        <div class="row">
                            <div class="col-lg-5"><label> Estimated Commisioning Date(By Customer)</label></div>
                            <div class="col-lg-7">
                                <input id="txEstimatedCommisioningDateByCustomer"
                                    name="txEstimatedCommisioningDateByCustomer" type="text" class=""
                                    placeholder="YYYY-mm-dd" style="width:85%" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Estimated Commisioning Date(By Region) </label></div>
                            <div class="col-lg-7">
                                <input id="txEstimatedCommisioningDateByRegion"
                                    name="txEstimatedCommisioningDateByRegion" type="text" class=""
                                    placeholder="YYYY-mm-dd" style="width:85%" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Planning Ahead Status </label></div>
                            <div class="col-lg-7">
                                <input id="txPlanningAheadStatus" name="txPlanningAheadStatus" type="text" class=""
                                    placeholder="" style="width:85%" />
                            </div>
                        </div>
                    </div>
                    <!-- End Of Consultant Information -->
                    <!-- Reply SLIP -->
                    <div class="col-lg-4 border border-secondary" style="padding: 1rem 1rem 1rem 1rem;">
                        <div class="title" style="color:#2e64c7db"><label><b>Reply SLIP</b></label></div>
                        <div class="row">
                            <div class="col-lg-5"><label> Plan ahead meeting Date </label></div>
                            <div class="col-lg-7">
                                <input id="txInvitationToPaMeetingDate" name="txInvitationToPaMeetingDate" type="text"
                                    class="" placeholder="YYYY-mm-dd" style="width:85%" />

                            </div>
                        </div>
                        <div class="row " id="">
                            <div class="col-lg-5"><label>PQSIS Case No </label></div>
                            <div class="col-lg-7">
                                <input id="txReplySlipParentCaseNo" name="txReplySlipParentCaseNo" type="number"
                                    class="" placeholder="Case No" min="0" max="99999" /> <b>.</b>
                                <input id="txReplySlipCaseVersion" name="txReplySlipCaseVersion" type="number" class=""
                                    step="1" placeholder="" min="0" max="99999" style="width:50px" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Target Reply Slip return Date </label></div>
                            <div class="col-lg-7">
                                <input id="txReplySlipSentDate" name="txReplySlipSentDate" type="text" class=""
                                    placeholder="YYYY-mm-dd" style="width:85%" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Finish? </label></div>
                            <div class="col-lg-7">
                                <input id="txFinish" name="txFinish" type="text" class="" placeholder=""
                                    style="width:85%" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Actual Reply Slip Return Date </label></div>
                            <div class="col-lg-7">
                                <input id="txActualReplySlipReturnDate" name="txActualReplySlipReturnDate" type="text"
                                    class="" placeholder="YYYY-mm-dd" style="width:85%" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Findings from Reply Slip </label></div>
                            <div class="col-lg-7">
                                <textarea id="txFindingsFromReplySlip" name="txFindingsFromReplySlip" placeholder=""
                                    style="width:85%"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Follow Up Action? &nbsp;</label><input
                                    id="txFollowUpActionBool" name="txFollowUpActionBool" type="checkbox" /></div>
                            <div class="col-lg-7">
                                <textarea id="txReplySlipFollowUpAction" name="txReplySlipFollowUpAction" placeholder=""
                                    style="width:85%"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Remark </label></div>
                            <div class="col-lg-7">
                                <textarea id="txReplySlipRemark" name="txReplySlipRemark" placeholder=""
                                    style="width:85%"></textarea>
                            </div>
                        </div>
                        <small class="text-muted">Reply Slip</small>
                        <div class="row">
                            <div class="col-lg-5"><label> Plan ahead meeting Fax Link </label></div>
                            <div class="col-lg-7">
                                <input id="txReplySlipSendPath" name="txReplySlipSendPath" type="email" class=""
                                    placeholder="customer@gmail.com" style="width:85%" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Reply Slip Fax Link </label></div>
                            <div class="col-lg-7">
                                <input id="txReplySlipReturnPath" name="txReplySlipReturnPath" type="text" class=""
                                    placeholder="" style="width:85%" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Del reply Slip Grade </label></div>
                            <div class="col-lg-7">
                                <select class="" id="txReplySlipReturnGrade" name="txReplySlipReturnGrade"
                                    style="height:30px;width:85%">
                                    <option value="" selected>------</option>
                                    <?php foreach($this->viewbag['replySlipReturnGradeList'] as $replySlipReturnGrade){ ?>
                                    <option value="<?php echo $replySlipReturnGrade['replySlipReturnGradeId']?>">
                                        <?php echo $replySlipReturnGrade['replySlipReturnGradeName']?></option>

                                    <?php } ?>

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5"><label> Date of requested for return reply slip </label></div>
                            <div class="col-lg-7">
                                <input id="txDateOfRequestedForReturnReplySlip"
                                    name="txDateOfRequestedForReturnReplySlip" type="text" class=""
                                    placeholder="YYYY-mm-dd" style="width:85%" />

                            </div>
                        </div>
                    </div>
                    <!-- End Of Reply SLIP -->
                    <!--Additional -->
                    <div class="col-lg-12 border border-secondary" style="padding: 1rem 1rem 1rem 1rem;">
                        <div class="title" style="color:#2e64c7db"><label><b>Additional</b></label></div>
                        <div class="row">
                            <div class="col-lg-3"><label> Receive Complaint </label></div>
                            <div class="col-lg-9">
                                <textarea id="txComplaint" name="txComplaint" placeholder=""
                                    style="width:100%"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3"><label> Follow-up Action </label></div>
                            <div class="col-lg-9">
                                <textarea id="txComplaintFollowUpAction" name="txComplaintFollowUpAction" placeholder=""
                                    style="width:100%"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3"><label> Remark </label></div>
                            <div class="col-lg-9">
                                <textarea id="txComplaintRemark" name="txComplaintRemark" placeholder=""
                                    style="width:100%"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3"><label> Active </label></div>
                            <div class="col-lg-9">
                                <select class="" id="txActive" name="txActive" style="height:30px;width:85%">
                                    <option value="Y"> YES </option>
                                    <option value="N"> NO </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End Of Additional -->
                </div>
            </div>
            <div class="col-lg-12" style="text-align:center">
                <button id="btnFormApply" name="btnFormApply" type="button" class="btn btn-primary btnFormApply"
                    style="width:85%">Apply</button>
                <button id="btnFormCancel" name="btnFormCancel" type="button" class="btn btn-danger btnFormCancel"
                    style="width:85%">Cancel</button>
            </div>
    </div>
</div>

</div>
</div>
</form>
</div>


</html>
<script>
$(document).ready(function() {
    <?php if (isset($this->viewbag['iframe'])) { ?>
    if ("<?php echo $this->viewbag['iframe']?>" == "caseForm") {
        $("button[name='btnFormCancel']").unbind().bind("click", function() {
            showConfirmation("<i class=\"fas fa-exclamation-circle\"></i> ", "Confirmation",
                "Are you sure to Cancel?",
                function() {
                    window.location.href =
                        "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/PlanningAheadSearchForCaseForm";
                },
                function() {
                    $("#btnModalConfirmation").focus();
                });
        });

    }
    <?php } else{?>
    $("button[name='btnFormCancel']").unbind().bind("click", function() {
        showConfirmation("<i class=\"fas fa-exclamation-circle\"></i> ", "Confirmation",
            "Are you sure to Cancel?",
            function() {
                window.location.href =
                    "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/PlanningAheadSearch";
            },
            function() {
                $("#btnModalConfirmation").focus();
            });
    });

    <?php } ?>
    $("#txInputDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txRegionLetterIssueDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txFirstPqSiteWalkDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txPqWalkAssessmentReportDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txFirstPqSiteWalkDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txPqAssessmentFollowUpReportDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txEstimatedCommisioningDateByCustomer").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txEstimatedCommisioningDateByRegion").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txInvitationToPaMeetingDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txReplySlipSentDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txActualReplySlipReturnDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txDateOfRequestedForReturnReplySlip").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txFirstPqSiteWalkRequestLetterDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txSecondPqSiteWalkDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txPqAssessmentFollowUpReportDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });
    $("#txSecondPqSiteWalkRequestLetterDate").datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollInput: false
    });

    var availableTagsForPqSensitiveLoad = [
        <?php foreach($this->viewbag['pqSensitiveLoadList'] as $pqSensitiveLoad){ ?> "<?php echo $pqSensitiveLoad['pqSensitiveLoadName']?>",
        <?php } ?>
    ];

    function split(val) {
        return val.split(/,\s*/);
    }

    function extractLast(term) {
        return split(term).pop();
    }

    $("#txSensitiveEquipment")
        // 当选择一个条目时不离开文本域
        .bind("keydown", function(event) {
            if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).data("ui-autocomplete").menu.active) {
                event.preventDefault();
            }
        })
        .autocomplete({
            minLength: 0,
            source: function(request, response) {
                // 回到 autocomplete，但是提取最后的条目
                response($.ui.autocomplete.filter(
                    availableTagsForPqSensitiveLoad, extractLast(request.term)).slice(0, 15));
            },
            focus: function() {
                // 防止在获得焦点时插入值
                return false;
            },
            select: function(event, ui) {
                var terms = split(this.value);
                // 移除当前输入
                terms.pop();
                // 添加被选项
                terms.push(ui.item.value);
                // 添加占位符，在结尾添加逗号+空格
                terms.push("");
                this.value = terms.join(", ");
                return false;
            }
        });
    $("#txConsultantName").change(function() {
        $("#txConsultantCompanyName").val($("#txConsultantName option:selected").attr('companyId'));
    });
    $("button[name='btnFormChoose']").unbind().bind("click", function() {
        window.parent.$("#txPlanningAheadId").val($("#txProjectRef").val());
    });
    <?php if ($this->viewbag['mode'] == 'update') { ?> //if mode = update
    var updateLocation = "/index.php?r=FirstForm/PlanningAheadSearch";
    <?php if (isset($this->viewbag['iframe'])) { ?>
    if ("<?php echo $this->viewbag['iframe']?>" == "caseForm") {
        var updateLocation = "/index.php?r=FirstForm/PlanningAheadSearchForCaseForm";
    }
    <?php }?>
    $("#title").html("Planning Ahead ( Update )");
    $("button[name='btnFormApply']").unbind().bind("click", function() {
        if (!validateInput()) {
            return;
        }
        $("#loading-modal").modal("show");
        $(this).attr("disabled", true);


        $.ajax({
            url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxUpdatePlanningAhead",
            type: "POST",
            cache: false,
            data: $("#Form").serializeArray(),
            success: function(data) {
                console.log(data);
                var retJson = JSON.parse(data);

                if (retJson.status == "OK") {
                    // display message
                    showMsg("<i class=\"fas fa-check-circle\"></i> ", "Info",
                        "Planning Ahead updated.", "",
                        function() {
                            window.location.href =
                                "<?php echo Yii::app()->request->baseUrl; ?>" +
                                updateLocation

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
    //project
    $("#txProjectRef").val("<?php echo $this->viewbag['planningAhead']['planningAheadId']?>");
    $("#txProjectTitle").val("<?php echo $this->viewbag['planningAhead']['projectTitle']?>");
    $("#txSchemeNumber").val("<?php echo $this->viewbag['planningAhead']['schemeNumber']?>");
    $("#txProjectRegion").val("<?php echo $this->viewbag['planningAhead']['projectRegion']?>");
    $("#txProjectAddress").val("<?php echo $this->viewbag['planningAhead']['projectAddress']?>");
    $("#txProjectAddressParentCaseNo").val(
        "<?php echo $this->viewbag['planningAhead']['projectAddressParentCaseNo']?>");
    $("#txProjectAddressCaseVersion").val(
        "<?php echo $this->viewbag['planningAhead']['projectAddressCaseVersion']?>");
    $("#txInputDate").val("<?php echo $this->viewbag['planningAhead']['inputDate']?>");
    $("#txRegionLetterIssueDate").val("<?php echo $this->viewbag['planningAhead']['regionLetterIssueDate']?>");
    $("#txReportedBy").val("<?php echo $this->viewbag['planningAhead']['reportedBy']?>");
    $("#txLastUpdatedBy").val("<?php echo $this->viewbag['planningAhead']['lastUpdatedBy']?>");
    $("#txLastUpdatedTime").val("<?php echo $this->viewbag['planningAhead']['lastUpdatedTime']?>");
    $("#txRegionPlanner").val("<?php echo $this->viewbag['planningAhead']['regionPlannerId']?>");
    //type
    $("#txBuildingType").val("<?php echo $this->viewbag['planningAhead']['buildingTypeId']?>");
    $("#txProjectType").val("<?php echo $this->viewbag['planningAhead']['projectTypeId']?>");
    if ("<?php echo $this->viewbag['planningAhead']['keyInfrastructure']?>" == "Y") {
        $("#txKeyinfrastructure").prop("checked", true);
    }
    if ("<?php echo $this->viewbag['planningAhead']['potentialSuccessfulCase']?>" == "Y") {
        $("#txPotentialSuccessfulCase").prop("checked", true);
    }
    if ("<?php echo $this->viewbag['planningAhead']['criticalProject']?>" == "Y") {
        $("#txCriticalProject").prop("checked", true);
    }
    if ("<?php echo $this->viewbag['planningAhead']['tempSupplyProject']?>" == "Y") {
        $("#txTempSupplyProject").prop("checked", true);
    }
    //equipment
    if (<?php echo $this->viewbag['planningAhead']['bms']?>) {
        $("#txBms").prop("checked", true);
    }
    if (<?php echo $this->viewbag['planningAhead']['changeoverScheme']?>) {
        $("#txChangeoverScheme").prop("checked", true);
    }
    if (<?php echo $this->viewbag['planningAhead']['chillerPlant']?>) {
        $("#txChillerPlant").prop("checked", true);
    }
    if (<?php echo $this->viewbag['planningAhead']['escalator']?>) {
        $("#txEscalator").prop("checked", true);
    }
    if (<?php echo $this->viewbag['planningAhead']['hidLamp']?>) {
        $("#txHidLamp").prop("checked", true);
    }
    if (<?php echo $this->viewbag['planningAhead']['lift']?>) {
        $("#txLift").prop("checked", true);
    }
    if (<?php echo $this->viewbag['planningAhead']['sensitiveMachine']?>) {
        $("#txSensitiveMachine").prop("checked", true);
    }
    if (<?php echo $this->viewbag['planningAhead']['telcom']?>) {
        $("#txTelcom").prop("checked", true);
    }
    if (<?php echo $this->viewbag['planningAhead']['acbTripping']?>) {
        $("#txAcbTripping").prop("checked", true);
    }
    if (<?php echo $this->viewbag['planningAhead']['buildingWithHighPenetrationEquipment']?>) {
        $("#txBuildingWithHighPenetrationEquipment").prop("checked", true);
    }
    if (<?php echo $this->viewbag['planningAhead']['re']?>) {
        $("#TxRe").prop("checked", true);
    }
    if (<?php echo $this->viewbag['planningAhead']['ev']?>) {
        $("#TxEv").prop("checked", true);
    }
    $("#txEstimatedLoad").val("<?php echo $this->viewbag['planningAhead']['estimatedLoad']?>");
    $("#txPqisNumber").val("<?php echo $this->viewbag['planningAhead']['pqisNumber']?>");
    //pq walk
    $("#txSensitiveEquipment").val("<?php echo $this->viewbag['planningAhead']['sensitiveEquipment']?>");
    //pq walk first walk
    $("#txFirstPqSiteWalkDate").val("<?php echo $this->viewbag['planningAhead']['firstPqSiteWalkDate']?>");
    $("#txFirstPqSiteWalkStatus").val("<?php echo $this->viewbag['planningAhead']['firstPqSiteWalkStatus']?>");
    $("#txFirstPqSiteWalkInvitationLetterLink").val(
        "<?php echo $this->viewbag['planningAhead']['firstPqSiteWalkInvitationLetterLink']?>");
    $("#txFirstPqSiteWalkRequestLetterDate").val(
        "<?php echo $this->viewbag['planningAhead']['firstPqSiteWalkRequestLetterDate']?>");
    $("#txPqWalkAssessmentReportDate").val(
        "<?php echo $this->viewbag['planningAhead']['pqWalkAssessmentReportDate']?>");
    $("#txPqWalkAssessmentReportLink").val(
        "<?php echo $this->viewbag['planningAhead']['pqWalkAssessmentReportLink']?>");
    $("#txFirstPqSiteWalkParentCaseNo").val(
        "<?php echo $this->viewbag['planningAhead']['firstPqSiteWalkParentCaseNo']?>");
    $("#txFirstPqSiteWalkCaseVersion").val(
        "<?php echo $this->viewbag['planningAhead']['firstPqSiteWalkCaseVersion']?>");
    $("#txFirstPqSiteWalkCustomerResponse").val(
        "<?php echo $this->viewbag['planningAhead']['firstPqSiteWalkCustomerResponse']?>");
    $("#txFirstPqSiteWalkInvestigationStatus").val(
        "<?php echo $this->viewbag['planningAhead']['firstPqSiteWalkInvestigationStatus']?>");
    //pq walk second walk
    $("#txSecondPqSiteWalkDate").val("<?php echo $this->viewbag['planningAhead']['secondPqSiteWalkDate']?>");
    $("#txSecondPqSiteWalkInvitationLetterLink").val(
        "<?php echo $this->viewbag['planningAhead']['secondPqSiteWalkInvitationLetterLink']?>");
    $("#txSecondPqSiteWalkRequestLetterDate").val(
        "<?php echo $this->viewbag['planningAhead']['secondPqSiteWalkRequestLetterDate']?>");
    $("#txPqAssessmentFollowUpReportDate").val(
        "<?php echo $this->viewbag['planningAhead']['pqAssessmentFollowUpReportDate']?>");
    $("#txPqAssessmentFollowupReportLink").val(
        "<?php echo $this->viewbag['planningAhead']['pqAssessmentFollowUpReportLink']?>");
    $("#txSecondPqSiteWalkParentCaseNo").val(
        "<?php echo $this->viewbag['planningAhead']['secondPqSiteWalkParentCaseNo']?>");
    $("#txSecondPqSiteWalkCaseVersion").val(
        "<?php echo $this->viewbag['planningAhead']['secondPqSiteWalkCaseVersion']?>");
    $("#txSecondPqSiteWalkCustomerResponse").val(
        "<?php echo $this->viewbag['planningAhead']['secondPqSiteWalkCustomerResponse']?>");
    $("#txSecondPqSiteWalkInvestigationStatus").val(
        "<?php echo $this->viewbag['planningAhead']['secondPqSiteWalkInvestigationStatus']?>");
    //consultant information
    $("#txConsultantCompanyName").val(
    "<?php echo $this->viewbag['planningAhead']['consultantCompanyNameId']?>");
    $("#txConsultantName").val("<?php echo $this->viewbag['planningAhead']['consultantNameId']?>");
    $("#txPhoneNumber1").val("<?php echo $this->viewbag['planningAhead']['phoneNumber1']?>");
    $("#txPhoneNumber2").val("<?php echo $this->viewbag['planningAhead']['phoneNumber2']?>");
    $("#txPhoneNumber3").val("<?php echo $this->viewbag['planningAhead']['phoneNumber3']?>");
    $("#txEmail1").val("<?php echo $this->viewbag['planningAhead']['email1']?>");
    $("#txEmail2").val("<?php echo $this->viewbag['planningAhead']['email2']?>");
    $("#txEmail3").val("<?php echo $this->viewbag['planningAhead']['email3']?>");
    //consultant information status
    $("#txEstimatedCommisioningDateByCustomer").val(
        "<?php echo $this->viewbag['planningAhead']['estimatedCommisioningDateByCustomer']?>");
    $("#txEstimatedCommisioningDateByRegion").val(
        "<?php echo $this->viewbag['planningAhead']['estimatedCommisioningDateByRegion']?>");
    $("#txPlanningAheadStatus").val("<?php echo $this->viewbag['planningAhead']['planningAheadStatus']?>");

    //reply Slip
    $("#txInvitationToPaMeetingDate").val(
        "<?php echo $this->viewbag['planningAhead']['invitationToPaMeetingDate']?>");
    $("#txReplySlipParentCaseNo").val("<?php echo $this->viewbag['planningAhead']['replySlipParentCaseNo']?>");
    $("#txReplySlipCaseVersion").val("<?php echo $this->viewbag['planningAhead']['replySlipCaseVersion']?>");
    $("#txReplySlipSentDate").val("<?php echo $this->viewbag['planningAhead']['replySlipSentDate']?>");
    $("#txFinish").val("<?php echo $this->viewbag['planningAhead']['finish']?>");
    $("#txActualReplySlipReturnDate").val(
        "<?php echo $this->viewbag['planningAhead']['actualReplySlipReturnDate']?>");
    $("#txFindingsFromReplySlip").val("<?php echo $this->viewbag['planningAhead']['findingsFromReplySlip']?>");
    if ("<?php echo $this->viewbag['planningAhead']['replySlipfollowUpActionFlag']?>" == "Y") {
        $("#txFollowUpActionBool").prop("checked", true);
    }
    $("#txReplySlipFollowUpAction").val(
        "<?php echo $this->viewbag['planningAhead']['replySlipfollowUpAction']?>");
    $("#txReplySlipRemark").val("<?php echo $this->viewbag['planningAhead']['replySlipRemark']?>");

    $("#txReplySlipSendPath").val("<?php echo $this->viewbag['planningAhead']['replySlipSendLink']?>");
    $("#txReplySlipReturnPath").val("<?php echo $this->viewbag['planningAhead']['replySlipReturnLink']?>");
    $("#txReplySlipReturnGrade").val("<?php echo $this->viewbag['planningAhead']['replySlipGradeId']?>");
    $("#txDateOfRequestedForReturnReplySlip").val(
        "<?php echo $this->viewbag['planningAhead']['dateOfRequestedForReturnReplySlip']?>");


    //additional
    $("#txComplaint").val("<?php echo $this->viewbag['planningAhead']['receiveComplaint']?>");
    $("#txComplaintFollowUpAction").val("<?php echo $this->viewbag['planningAhead']['followUpAction']?>");
    $("#txComplaintRemark").val("<?php echo $this->viewbag['planningAhead']['remark']?>");
    $("#txActive").val("<?php echo $this->viewbag['planningAhead']['active']?>");



    <?php } else if ($this->viewbag['mode'] == 'read') { ?> // if mode = read

    $("#title").html("Planning Ahead ( Read Only )");
    $("button[name='btnFormApply']").html('Modify');
    $("button[name='btnFormCancel']").html("Back");
    $("button[name='btnFormChoose']").attr("hidden", false);
    <?php if (isset($this->viewbag['iframe'])) { ?>
    if ("<?php echo $this->viewbag['iframe']?>" == "caseForm") {
        $("button[name='btnFormApply']").unbind().bind("click", function() {
            window.location.href =
                "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/GetPlanningAheadForUpdateForCaseForm&planningAheadId=<?php echo $this->viewbag['planningAhead']['planningAheadId'] ?>";
        });
    }
    <?php }else{?>
    $("button[name='btnFormApply']").unbind().bind("click", function() {
        window.location.href =
            "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/GetPlanningAheadForUpdate&planningAheadId=<?php echo $this->viewbag['planningAhead']['planningAheadId'] ?>";
    });
});
<?php } ?>
//project
$("#txProjectRef").val("<?php echo $this->viewbag['planningAhead']['planningAheadId']?>");
$("#txProjectTitle").val("<?php echo $this->viewbag['planningAhead']['projectTitle']?>");
$("#txSchemeNumber").val("<?php echo $this->viewbag['planningAhead']['schemeNumber']?>");
$("#txProjectRegion").val("<?php echo $this->viewbag['planningAhead']['projectRegion']?>");
$("#txProjectAddress").val("<?php echo $this->viewbag['planningAhead']['projectAddress']?>");
$("#txProjectAddressParentCaseNo").val("<?php echo $this->viewbag['planningAhead']['projectAddressParentCaseNo']?>");
$("#txProjectAddressCaseVersion").val("<?php echo $this->viewbag['planningAhead']['projectAddressCaseVersion']?>");
$("#txInputDate").val("<?php echo $this->viewbag['planningAhead']['inputDate']?>");
$("#txRegionLetterIssueDate").val("<?php echo $this->viewbag['planningAhead']['regionLetterIssueDate']?>");
$("#txReportedBy").val("<?php echo $this->viewbag['planningAhead']['reportedBy']?>");
$("#txLastUpdatedBy").val("<?php echo $this->viewbag['planningAhead']['lastUpdatedBy']?>");
$("#txLastUpdatedTime").val("<?php echo $this->viewbag['planningAhead']['lastUpdatedTime']?>");
$("#txRegionPlanner").val("<?php echo $this->viewbag['planningAhead']['regionPlannerId']?>");
//type
$("#txBuildingType").val("<?php echo $this->viewbag['planningAhead']['buildingTypeId']?>");
$("#txProjectType").val("<?php echo $this->viewbag['planningAhead']['projectTypeId']?>");
if ("<?php echo $this->viewbag['planningAhead']['keyInfrastructure']?>" == "Y") {
    $("#txKeyinfrastructure").prop("checked", true);
}
if ("<?php echo $this->viewbag['planningAhead']['potentialSuccessfulCase']?>" == "Y") {
    $("#txPotentialSuccessfulCase").prop("checked", true);
}
if ("<?php echo $this->viewbag['planningAhead']['criticalProject']?>" == "Y") {
    $("#txCriticalProject").prop("checked", true);
}
if ("<?php echo $this->viewbag['planningAhead']['tempSupplyProject']?>" == "Y") {
    $("#txTempSupplyProject").prop("checked", true);
}
//equipment
if (<?php echo $this->viewbag['planningAhead']['bms']?>) {
    $("#txBms").prop("checked", true);
}
if (<?php echo $this->viewbag['planningAhead']['changeoverScheme']?>) {
    $("#txChangeoverScheme").prop("checked", true);
}
if (<?php echo $this->viewbag['planningAhead']['chillerPlant']?>) {
    $("#txChillerPlant").prop("checked", true);
}
if (<?php echo $this->viewbag['planningAhead']['escalator']?>) {
    $("#txEscalator").prop("checked", true);
}
if (<?php echo $this->viewbag['planningAhead']['hidLamp']?>) {
    $("#txHidLamp").prop("checked", true);
}
if (<?php echo $this->viewbag['planningAhead']['lift']?>) {
    $("#txLift").prop("checked", true);
}
if (<?php echo $this->viewbag['planningAhead']['sensitiveMachine']?>) {
    $("#txSensitiveMachine").prop("checked", true);
}
if (<?php echo $this->viewbag['planningAhead']['telcom']?>) {
    $("#txTelcom").prop("checked", true);
}
if (<?php echo $this->viewbag['planningAhead']['acbTripping']?>) {
    $("#txAcbTripping").prop("checked", true);
}
if (<?php echo $this->viewbag['planningAhead']['buildingWithHighPenetrationEquipment']?>) {
    $("#txBuildingWithHighPenetrationEquipment").prop("checked", true);
}
if (<?php echo $this->viewbag['planningAhead']['re']?>) {
    $("#TxRe").prop("checked", true);
}
if (<?php echo $this->viewbag['planningAhead']['ev']?>) {
    $("#TxEv").prop("checked", true);
}
$("#txEstimatedLoad").val("<?php echo $this->viewbag['planningAhead']['estimatedLoad']?>");
$("#txPqisNumber").val("<?php echo $this->viewbag['planningAhead']['pqisNumber']?>");
//pq walk
$("#txPqSiteWalkProjectRegion").val("<?php echo $this->viewbag['planningAhead']['pqSiteWalkProjectRegion']?>");
$("#txPqSiteWalkProjectAddress").val("<?php echo $this->viewbag['planningAhead']['pqSiteWalkProjectAddress']?>");
$("#txSensitiveEquipment").val("<?php echo $this->viewbag['planningAhead']['sensitiveEquipment']?>");
//pq walk first walk
$("#txFirstPqSiteWalkDate").val("<?php echo $this->viewbag['planningAhead']['firstPqSiteWalkDate']?>");
$("#txFirstPqSiteWalkStatus").val("<?php echo $this->viewbag['planningAhead']['firstPqSiteWalkStatus']?>");
$("#txFirstPqSiteWalkInvitationLetterLink").val(
    "<?php echo $this->viewbag['planningAhead']['firstPqSiteWalkInvitationLetterLink']?>");
$("#txFirstPqSiteWalkRequestLetterDate").val(
    "<?php echo $this->viewbag['planningAhead']['firstPqSiteWalkRequestLetterDate']?>");
$("#txPqWalkAssessmentReportDate").val("<?php echo $this->viewbag['planningAhead']['pqWalkAssessmentReportDate']?>");
$("#txPqWalkAssessmentReportLink").val("<?php echo $this->viewbag['planningAhead']['pqWalkAssessmentReportLink']?>");
$("#txFirstPqSiteWalkParentCaseNo").val("<?php echo $this->viewbag['planningAhead']['firstPqSiteWalkParentCaseNo']?>");
$("#txFirstPqSiteWalkCaseVersion").val("<?php echo $this->viewbag['planningAhead']['firstPqSiteWalkCaseVersion']?>");
$("#txFirstPqSiteWalkCustomerResponse").val(
    "<?php echo $this->viewbag['planningAhead']['firstPqSiteWalkCustomerResponse']?>");
$("#txFirstPqSiteWalkInvestigationStatus").val(
    "<?php echo $this->viewbag['planningAhead']['firstPqSiteWalkInvestigationStatus']?>");
//pq walk second walk
$("#txSecondPqSiteWalkDate").val("<?php echo $this->viewbag['planningAhead']['secondPqSiteWalkDate']?>");
$("#txSecondPqSiteWalkInvitationLetterLink").val(
    "<?php echo $this->viewbag['planningAhead']['secondPqSiteWalkInvitationLetterLink']?>");
$("#txSecondPqSiteWalkRequestLetterDate").val(
    "<?php echo $this->viewbag['planningAhead']['secondPqSiteWalkRequestLetterDate']?>");
$("#txPqAssessmentFollowUpReportDate").val(
    "<?php echo $this->viewbag['planningAhead']['pqAssessmentFollowUpReportDate']?>");
$("#txPqAssessmentFollowupReportLink").val(
    "<?php echo $this->viewbag['planningAhead']['pqAssessmentFollowUpReportLink']?>");
$("#txSecondPqSiteWalkParentCaseNo").val(
"<?php echo $this->viewbag['planningAhead']['secondPqSiteWalkParentCaseNo']?>");
$("#txSecondPqSiteWalkCaseVersion").val("<?php echo $this->viewbag['planningAhead']['secondPqSiteWalkCaseVersion']?>");
$("#txSecondPqSiteWalkCustomerResponse").val(
    "<?php echo $this->viewbag['planningAhead']['secondPqSiteWalkCustomerResponse']?>");
$("#txSecondPqSiteWalkInvestigationStatus").val(
    "<?php echo $this->viewbag['planningAhead']['secondPqSiteWalkInvestigationStatus']?>");
//consultant information
$("#txConsultantCompanyName").val("<?php echo $this->viewbag['planningAhead']['consultantCompanyNameId']?>");
$("#txConsultantName").val("<?php echo $this->viewbag['planningAhead']['consultantNameId']?>");
$("#txPhoneNumber1").val("<?php echo $this->viewbag['planningAhead']['phoneNumber1']?>");
$("#txPhoneNumber2").val("<?php echo $this->viewbag['planningAhead']['phoneNumber2']?>");
$("#txPhoneNumber3").val("<?php echo $this->viewbag['planningAhead']['phoneNumber3']?>");
$("#txEmail1").val("<?php echo $this->viewbag['planningAhead']['email1']?>");
$("#txEmail2").val("<?php echo $this->viewbag['planningAhead']['email2']?>");
$("#txEmail3").val("<?php echo $this->viewbag['planningAhead']['email3']?>");
$("#txConsultantInformationRemark").val("<?php echo $this->viewbag['planningAhead']['consultantInformationRemark']?>");
//consultant information status
$("#txEstimatedCommisioningDateByCustomer").val(
    "<?php echo $this->viewbag['planningAhead']['estimatedCommisioningDateByCustomer']?>");
$("#txEstimatedCommisioningDateByRegion").val(
    "<?php echo $this->viewbag['planningAhead']['estimatedCommisioningDateByRegion']?>");
$("#txPlanningAheadStatus").val("<?php echo $this->viewbag['planningAhead']['planningAheadStatus']?>");

//reply Slip
$("#txInvitationToPaMeetingDate").val("<?php echo $this->viewbag['planningAhead']['invitationToPaMeetingDate']?>");
$("#txReplySlipParentCaseNo").val("<?php echo $this->viewbag['planningAhead']['replySlipParentCaseNo']?>");
$("#txReplySlipCaseVersion").val("<?php echo $this->viewbag['planningAhead']['replySlipCaseVersion']?>");
$("#txReplySlipSentDate").val("<?php echo $this->viewbag['planningAhead']['replySlipSentDate']?>");
$("#txFinish").val("<?php echo $this->viewbag['planningAhead']['finish']?>");
$("#txActualReplySlipReturnDate").val("<?php echo $this->viewbag['planningAhead']['actualReplySlipReturnDate']?>");
$("#txFindingsFromReplySlip").val("<?php echo $this->viewbag['planningAhead']['findingsFromReplySlip']?>");
if ("<?php echo $this->viewbag['planningAhead']['replySlipfollowUpActionFlag']?>" == "Y") {
    $("#txFollowUpActionBool").prop("checked", true);
}
$("#txReplySlipFollowUpAction").val("<?php echo $this->viewbag['planningAhead']['replySlipfollowUpAction']?>");
$("#txReplySlipRemark").val("<?php echo $this->viewbag['planningAhead']['replySlipRemark']?>");

$("#txReplySlipSendPath").val("<?php echo $this->viewbag['planningAhead']['replySlipSendLink']?>");
$("#txReplySlipReturnPath").val("<?php echo $this->viewbag['planningAhead']['replySlipReturnLink']?>");
$("#txReplySlipReturnGrade").val("<?php echo $this->viewbag['planningAhead']['replySlipGradeId']?>");
$("#txDateOfRequestedForReturnReplySlip").val(
    "<?php echo $this->viewbag['planningAhead']['dateOfRequestedForReturnReplySlip']?>");


//additional
$("#txComplaint").val("<?php echo $this->viewbag['planningAhead']['receiveComplaint']?>");
$("#txComplaintFollowUpAction").val("<?php echo $this->viewbag['planningAhead']['followUpAction']?>");
$("#txComplaintRemark").val("<?php echo $this->viewbag['planningAhead']['remark']?>");
$("#txActive").val("<?php echo $this->viewbag['planningAhead']['active']?>");
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


<?php } else { ?> //else if mode =new
var newLocation = "/index.php?r=FirstForm/PlanningAheadSearch";
<?php if (isset($this->viewbag['iframe'])) { ?>
if ("<?php echo $this->viewbag['iframe']?>" == "caseForm") {
    var newLocation = "/index.php?r=FirstForm/PlanningAheadSearchForCaseForm";
}
<?php }?>
$("#title").html("Planning Ahead ( New )");
$("button[name='btnFormApply']").unbind().bind("click", function() {
    if (!validateInput()) {
        return;
    }
    $("#loading-modal").modal("show");
    $(this).attr("disabled", true);


    $.ajax({
        url: "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/AjaxInsertPlanningAhead",
        type: "POST",
        cache: false,
        data: $("#Form").serializeArray(),
        success: function(data) {
            console.log(data);
            var retJson = JSON.parse(data);

            if (retJson.status == "OK") {
                // display message
                showMsg("<i class=\"fas fa-check-circle\"></i> ", "Info", "Planning Ahead created.",
                    "",
                    function() {
                        window.location.href = "<?php echo Yii::app()->request->baseUrl; ?>" +
                            newLocation;

                    });

            } else {
                // error message
                showError("<i class=\"fas fa-times-circle\"></i> ", "Error", retJson.retMessage);
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
<?php } ?>



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
    /*if ($("#txServiceType").val() == "") {

        if (errorMessage == "")
            $("#txServiceType").focus();
        errorMessage = errorMessage + "Error " + i + ": " + "Services Type Name can not be blank <br/>";

        i = i + 1;
        $("#txServiceType").addClass("invalid");
    } */
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