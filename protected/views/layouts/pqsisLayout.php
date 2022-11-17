<?php header('Content-Type: text/html; charset=utf-8');//@session_start(); Yii::app()->setLanguage(isset($_SESSION['lang'])?Yii::app()->setLanguage($_SESSION['lang']):Yii::app()->setLanguage('zh_hk')); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery/jquery-ui.min.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/DataTables-1.10.21/jquery.dataTables.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/common_util.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap/bootstrap.bundle.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/selectize/selectize.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/numeric/jquery.numeric.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap/bootstrap-select.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/fontawesome_all.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/common_util.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/core/selectize.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/DateTimePicker/jquery.datetimepicker.full.min.js"></script>
    <!-- dataTable excel / pdf / print button-->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/DataTables-1.10.21/dataTables.buttons.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/DataTables-1.10.21/buttons.flash.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/DataTables-1.10.21/jszip.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/DataTables-1.10.21/pdfmake.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/DataTables-1.10.21/vfs_fonts.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/DataTables-1.10.21/buttons.html5.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/DataTables-1.10.21/buttons.print.min.js"></script>


    <!-- Bootstrap core CSS -->
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/bootstrap-grid.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/bootstrap-reboot.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/bootstrap-select.css" />
    <!--selectize CSS -->
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/Selectize/selectize.legacy.css" />

    <!-- datatable CSS -->
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/DataTables-1.10.21/jquery.dataTables.min.css" />
    <!--fontawesome_all -->
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/all.min.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap/sticky-footer.css" />
    <!--loadingGifCSS -->
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin.css" />
    <!--JqeryUi CSS -->
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery/jquery-ui.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery/jquery.ui.autocomplete.css" />
    <!--DateTimePicker -->
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/DateTimePicker/jquery.datetimepicker.css" />
    <title><?php echo Yii::t('globalmessage', Yii::app()->name) ?></title>
    <style>
    @media (min-width: 992px){
	    .dropdown-menu .dropdown-toggle:after{
		    border-top: .3em solid transparent;
	        border-right: 0;
	        border-bottom: .3em solid transparent;
	        border-left: .3em solid;
	    }
	    .dropdown-menu .dropdown-menu{
		    margin-left:0; margin-right: 0;
	    }
	    .dropdown-menu li{
		    position: relative;
	    }
	    .nav-item .submenu{
		    display: none;
		    position: absolute;
		    left:100%; top:-7px;
	    }
	    .nav-item .submenu-left{
		    right:100%; left:auto;
	    }
	    .dropdown-menu > li:hover{ background-color: #f1f1f1 }
	    .dropdown-menu > li:hover > .submenu{
		    display: block;
	    }
    }
    </style>
</head>

<body style="font-family:sans-serif;">
    <!--  user bootstrap 4 nav bar -->
    <nav id="navbar" class="navbar navbar-expand-md navbar-dark bg-dark bg-primary justify-content-between" style="z-index:5000;">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#main_nav" aria-controls="navbarNavDropdown" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/Landing">
            <i class="fas fa-home" style="color: #FFDF00"></i>
            <span class="menu-collapsed">PQSIS</span>
        </a>
        <div class="collapse navbar-collapse" id="main_nav">

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a id="aMenuFormLink" class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">Form</a>
                    <ul class="dropdown-menu" aria-labelledby="aMenuFormLink">
                        <li><a id="aMenuFormLinkCF" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch">All PQSIS Case</a></li>
                        <li><a id="aMenuFormLinkPHOld" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/PlanningAheadSearch">Planning Ahead (Old)</a></li>
                        <?php if (Yii::app()->session['tblUserDo']['roleId']==2) { ?>
                        <li>
                            <a id="aMenuFormLinkPH" class="dropdown-item" href="#">Planning Ahead &raquo </a>
                            <ul class="submenu dropdown-menu">
                                <a id="aMenuFormLinkPHConditionLetter" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetPlanningAheadInfoSearch">Planning Ahead Information</a>
                                <a id="aMenuFormLinkPHConditionLetter" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetUploadConditionLetterForm">Upload Condition Letter</a>
                                <a id="aMenuFormLinkPHConditionLetter" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=PlanningAhead/GetUploadReplySlipForm">Upload Reply Slip File</a>
                            </ul>
                        </li>
                        <?php } ?>
                        <li><a id="aMenuFormLinkCFIS" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch&mode=InvestigationS">Investigation(S) </a></li>
                        <li><a id="aMenuFormLinkCFIL" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch&mode=InvestigationL">Investigation(L) </a></li>
                        <li><a id="aMenuFormLinkCFE" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch&mode=Enquiry">Enquiry </a></li>
                        <li><a id="aMenuFormLinkCFSV" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch&mode=SiteVisit">Site Visit </a></li>
                        <li><a id="aMenuFormLinkCFSEM20" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch&mode=Seminar20">Seminar(&lt;20ppl) </a></li>
                        <li><a id="aMenuFormLinkCFSEM20-50" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch&mode=Seminar20-50">Seminar(20-50ppl) </a></li>
                        <li><a id="aMenuFormLinkCFSEM50" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch&mode=Seminar50">Seminar(&gt;50ppl) </a></li>
                        <li><a id="aMenuFormLinkPQWSV" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=FirstForm/CaseFormSearch&mode=PqWorkshopVisit">PQ Workshop Visit </a></li>

                    </ul>
                </li>
    <?php if(isset(Yii::app()->session['tblUserDo']['roleId'])) {
                if(Yii::app()->session['tblUserDo']['roleId']==1){ ?>
                    
                <li class="nav-item dropdown">
                    <a id="aMenuMaintenanceLink" class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Maintenance</a>
                    <ul class="dropdown-menu" aria-labelledby="aMenuMaintenanceLink">
                        <li>
                            <a class="dropdown-item" id="aMenuMaintenanceLinkCaseForm" href="#"> PQSIS Case &raquo </a>
                            <ul class="submenu dropdown-menu">
                                <a id="aMenuMaintenanceLinkAB" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/ActionBySearch">Action By</a>
                                <a id="aMenuMaintenanceLinkBG" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/BudgetSearch">Budget</a>
                                <a id="aMenuMaintenanceLinkBT" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/BusinessTypeSearch">Business Type</a>
                                <a id="aMenuMaintenanceLinkCPD" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/ClpPersonDepartmentSearch">CLP Person Department</a>
                                <a id="aMenuMaintenanceLinkCRB" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/ClpReferredBySearch">Referred By</a>
                                <a id="aMenuMaintenanceLinkCP" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/ContactPersonSearch">Contact Person</a>
                                <a id="aMenuMaintenanceLinkC" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/customerSearch">Customer</a>
                                <a id="aMenuMaintenanceLinkE" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/eicSearch">EIC</a>
                                <a id="aMenuMaintenanceLinkMAE" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/majorAffectedElementSearch">Major Affected Element</a>
                                <a id="aMenuMaintenanceLinkPTBC" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/PartyToBeChargedSearch">Party To Be Charged</a>
                                <a id="aMenuMaintenanceLinkPLT" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/PlantTypeSearch">Plant Type</a>
                                <a id="aMenuMaintenanceLinkPT" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/ProblemTypeSearch">Problem Type</a>
                                <a id="aMenuMaintenanceLinkRQ" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/RequestedBySearch">Requested By</a>
                                <a id="aMenuMaintenanceLinkSS" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/ServiceStatusSearch">Service Status</a>
                                <a id="aMenuMaintenanceLinkST" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/ServiceTypeSearch">Service Type</a>
                                <a id="aMenuMaintenanceLinkCT" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/CostTypeSearch">Unit Rate</a>

                                    <!--<li>
                                        <a class="dropdown-item" href=""> Third level 3 &raquo </a>
                                        <ul class="submenu dropdown-menu">
                                            <li><a class="dropdown-item" href=""> Fourth level 1</a></li>
                                            <li><a class="dropdown-item" href=""> Fourth level 2</a></li>
                                        </ul>
                                    </li> -->
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-item" id="aMenuMaintenanceLinkPlanningAhead" href="#"> Planning Ahead &raquo </a>
                            <ul class="submenu dropdown-menu">
                            <!-- <li><a id="bMenuMaintenanceLinkPR" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/ProjectRegionSearch">Project Region</a></li> -->
                                <li><a id="bMenuMaintenanceLinkPT" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/ProjectTypeSearch">Project Type</a></li>
                              <!--  <li><a id="bMenuMaintenanceLinkBT" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/BuildingTypeSearch">Building Type</a></li> -->
                              <!--  <li><a class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/PlanningAheadStatusSearch">Planning Ahead Status</a></li>
                                <li><a class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/ReplySlipReturnGradeSearch">Reply Slip Return Grade</a></li> -->
                                <li><a id="bMenuMaintenanceLinkCC" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/ConsultantCompanySearch">Consultant Company</a></li>
                                <li><a id="bMenuMaintenanceLinkC" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/ConsultantSearch">Consultant</a></li>
                                <li><a id="bMenuMaintenanceLinkRP" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/RegionPlannerSearch">Region Planner</a></li>
                                <li><a id="bMenuMaintenanceLinkPSL" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/PqSensitiveLoadSearch">PQ Sensitve Load</a></li>
                                <!--<li>
                                    <a class="dropdown-item" href=""> Third level 3 &raquo </a>
                                    <ul class="submenu dropdown-menu">
                                        <li><a class="dropdown-item" href=""> Fourth level 1</a></li>
                                        <li><a class="dropdown-item" href=""> Fourth level 2</a></li>
                                    </ul>
                                </li> -->
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown-item" id="aMenuMaintenanceLinkCommon"  href="#"> Common &raquo</a>
                            <ul class="submenu dropdown-menu">

                                <li><a id="aMenuMaintenanceLinkHD" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/HolidaySearch">Holiday</a></li>
                                <li><a id="aMenuMaintenanceLinkCF" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/ConfigSearch">Config</a></li>
                                <li><a id="aMenuMaintenanceLinkUser" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Maintenance/UserSearch">User Maintenance</a></li>
                               <!-- <li>
                                    <a class="dropdown-item" href=""> Third level 3 &raquo </a>
                                    <ul class="submenu dropdown-menu">
                                        <li><a class="dropdown-item" href=""> Fourth level 1</a></li>
                                        <li><a class="dropdown-item" href=""> Fourth level 2</a></li>
                                    </ul>
                                </li> -->
                            </ul>
                        </li>
                    </ul>
                </li>
        <?php } } ?>
                <li class="nav-item dropdown">
                    <a id="aMenuReportLink" class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">Report</a>
                    <div class="dropdown-menu" aria-labelledby="aMenuReportLink">
                        <a id="aMenuReportLinkCR" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Report/CaseReportSearch">PQSIS Case Report</a>
                        <a id="aMenuReportLinkPAR" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Report/PlanningAheadReportSearch">Planning Ahead Status Report</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a id="aMenuFunctionLink" class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">Function</a>
                    <div class="dropdown-menu" aria-labelledby="aMenuFunctionLink">
                        <a id="aMenuFunctionLinkIR" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Function/IncidentReportSearch">Incident Report Upload</a>
                        <a id="aMenuFunctionLinkIRPM" class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Function/IncidentReportPdfSearch">Incident Report PDF Match</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=Site/Logout">Logout</a>
                </li>

            </ul>

        </div> <!-- navbar-collapse.// -->
        <span class="text-info" style="text-align:right;">
            ID: <?php echo Yii::app()->session['tblUserDo']['username']; ?><br>
            Editable: <?php echo isset(Yii::app()->session['tblUserDo']['editRight'])?(Yii::app()->session['tblUserDo']['editRight']=='1'?'True':'False'):''?>
        </span>


    </nav>

    <div aria-live="polite" aria-atomic="true" style="position: relative;">
        <!-- Position it -->
        <div style="position: absolute; top: 0; right: 0;z-index:1000">

            <!-- Then put toasts within -->
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000" <?php echo Yii::app()->session['HolidayFlag']['thisYearHolidayFlag'] ?>>
      <div class="toast-header">
      <i class="fas fa-user-clock" style="color: #FFDF00"> </i>
        <strong class="mr-auto"><?php echo Yii::app()->session['HolidayFlag']['thisYear'] ?></strong>
        <small class="text-muted">remind</small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body">
        You have not inserted Holiday of this year yet.
      </div>
    </div>

            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000" <?php echo Yii::app()->session['HolidayFlag']['nextYearHolidayFlag'] ?> >
      <div class="toast-header">
      <i class="fa fa-user-clock" style="color: #FFDF00"> </i>
        <strong class="mr-auto"><?php echo Yii::app()->session['HolidayFlag']['nextYear'] ?></strong>
        <small class="text-muted">remind</small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body">
      You have not inserted Holiday of next year yet.
      </div>
    </div>
        </div>
    </div>
    <!-- action result -->
    <div class="modal fade" id="divActionResultModal" style="z-index:5001">
        <!-- the default modal z-index is 1050 -->
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="max-height: 90vh; overflow:auto;">
                <div id="divActionResultHeader" class="modal-header">
                    <h5 id="hActionResultTitle" class="modal-title"></h5>
                    <button id="btnTopRightClose" type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div id="divActionResultBody" class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation -->
    <div class="modal fade" id="divConfirmationModal" style="z-index:5002">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="max-height: 90vh; overflow:auto;">
                <div id="divConfirmationHeader" class="modal-header">
                    <h5 id="hConfirmationTitle" class="modal-title"></h5>
                    <button id="btnTopRightClose" type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div id="divConfirmationBody" class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="btnModalConfirmation" type="submit" class="btn btn-primary" data-dismiss="modal">Confirm</button>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid" id="page_content">
        <?php echo $content; ?>
    </div>

    <div class="loading-modal"></div>
    <br />
    <br />
    <br />
    <!-- FOOTER -->
    <div class="footer">
        <div class="container" id="page_footer">
            <div class="row" style="text-align:center;">
                <div class="col-12" style="text-align:center;">
                    <?php echo Yii::t('globalmessage', 'Powered by JKTech-Ltd'); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script>
        $(document).on('click', '.dropdown-menu', function (e) {
            e.stopPropagation();
        });

        // make it as accordion for smaller screens
        if ($(window).width() < 992) {
            $('.dropdown-menu a').click(function (e) {
                e.preventDefault();
                if ($(this).next('.submenu').length) {
                    $(this).next('.submenu').toggle();
                }
                $('.dropdown').on('hide.bs.dropdown', function () {
                    $(this).find('.submenu').hide();
                })
            });
        }

        function showMsg(icon, title, msg, fnShown, fnHidden) {
            $("#hActionResultTitle").html(icon + title);
            $("#divActionResultBody").html(msg);
            $("#divActionResultHeader").removeClass("alert-warning").removeClass("alert-danger").addClass("alert-primary");
            if (fnShown !== undefined && fnShown != null)
                $('#divActionResultModal').unbind("shown.bs.modal").on("shown.bs.modal", fnShown);
            else
                $('#divActionResultModal').unbind("shown.bs.modal");
            if (fnHidden !== undefined && fnHidden != null)
                $('#divActionResultModal').unbind("hidden.bs.modal").on("hidden.bs.modal", fnHidden);
            else
                $('#divActionResultModal').unbind("hidden.bs.modal");
            $("#divActionResultModal").modal("show");
        }

        function showWarning(icon, title, warn, fnShown, fnHidden) {
            $("#hActionResultTitle").html(icon + title);
            $("#divActionResultBody").html(warn);
            $("#divActionResultHeader").removeClass("alert-primary").removeClass("alert-danger").addClass("alert-warning");
            if (fnShown !== undefined && fnShown != null)
                $('#divActionResultModal').unbind("shown.bs.modal").on("shown.bs.modal", fnShown);
            else
                $('#divActionResultModal').unbind("shown.bs.modal");
            if (fnHidden !== undefined && fnHidden != null)
                $('#divActionResultModal').unbind("hidden.bs.modal").on("hidden.bs.modal", fnHidden);
            else
                $('#divActionResultModal').unbind("hidden.bs.modal");
            $("#divActionResultModal").modal("show");
        }

        function showError(icon, title, err, fnShown, fnHidden) {
            $("#hActionResultTitle").html(icon + title);
            $("#divActionResultBody").html(err);
            $("#divActionResultHeader").removeClass("alert-primary").removeClass("alert-warning").addClass("alert-danger");
            if (fnShown !== undefined && fnShown != null)
                $('#divActionResultModal').unbind("shown.bs.modal").on("shown.bs.modal", fnShown);
            else
                $('#divActionResultModal').unbind("shown.bs.modal");
            if (fnHidden !== undefined && fnHidden != null)
                $('#divActionResultModal').unbind("hidden.bs.modal").on("hidden.bs.modal", fnHidden);
            else
                $('#divActionResultModal').unbind("hidden.bs.modal");
            $("#divActionResultModal").modal("show");
        }

        function showConfirmation(icon, title, msg, fnConfirm, fnShown, fnHidden) {
            $("#hConfirmationTitle").html(icon + title);
            $("#divConfirmationBody").html(msg);

            // Bring black drop z-index upper
            var prevZIndex = $(".modal-backdrop").css("z-index"); // 1040
            $(".modal-backdrop").css("z-index", $("#divConfirmationModal").css("z-index") - 1);
            // Reset black drop z-index
            $('#divConfirmationModal').unbind("hide.bs.modal").on("hide.bs.modal", function () {
                $(".modal-backdrop").css("z-index", prevZIndex);
            });

            // Shown callback
            if (fnShown !== undefined && fnShown != null)
                $('#divConfirmationModal').unbind("shown.bs.modal").on("shown.bs.modal", fnShown);
            else
                $('#divConfirmationModal').unbind("shown.bs.modal");

            // hidden callback
            if (fnHidden !== undefined && fnHidden != null)
                $('#divConfirmationModal').unbind("hidden.bs.modal").on("hidden.bs.modal", fnHidden);
            else
                $('#divConfirmationModal').unbind("hidden.bs.modal");

            // Confirm action
            $("#btnModalConfirmation").unbind("click").on("click", fnConfirm);

            $("#divConfirmationModal").modal("show");
        }
        $('.toast').toast('show');


        <?php if (isset($this->viewbag['iframe'])) { ?>
                $("#navbar").attr("hidden",true);        
        <?php } ?>
    </script>
</body>
</html>
