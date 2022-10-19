<?php

class FirstFormController extends Controller
{
    public function filters()
    {
        return array(
            array(
                'application.filters.AccessControlFilter',

            ),
            array(
                'application.filters.EditControlFilter + GetCaseFormForNew , GetCaseFormForUpdate , GetPlanningAheadForNew,GetPlanningAheadForUpdate',
            ),
        );
    }
    public function actionAjaxGetUnitRateByCountYearAndServiceTypeId()
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        parse_str(parse_url($url, PHP_URL_QUERY), $param);
        $serviceTypeId = $param['serviceTypeId'];
        $countYear = $param['countYear'];
        $retJson['status'] = 'OK';
        $costType = Yii::app()->formDao->GetCostTypeByCountYearAndServiceTypeId($countYear, $serviceTypeId);
        if(empty($costType)){
            $retJson['status'] = 'NOTOK';
            $retJson['retMessage'] = "required Unit Rate doesn't exist in Data Base";
        }
        else{
            $retJson['costTypeId'] = $costType['costTypeId'];
            $retJson['countYear'] = $costType['countYear'];
            $retJson['serviceTypeId'] = $costType['serviceTypeId'];
            $retJson['unitCost'] = $costType['unitCost'];
        }

        echo json_encode($retJson);
    }
    
    public function actionAjaxGetPlannedReportIssueWorkingDate()
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        parse_str(parse_url($url, PHP_URL_QUERY), $param);
        $numberOfWorkingDay = $param['numberOfWorkingDay'];
        $retJson['status'] = 'OK';
        if ($_POST['txServiceCompletionDate'] == '') {
            $Date = null;
        } else {
            $Date = trim($_POST['txServiceCompletionDate']);
        }
        $endDate = Yii::app()->commonUtil->GetDateAfterParaWorkingDay($Date, $numberOfWorkingDay);
        $retJson['Date'] = $endDate;
        echo json_encode($retJson);
    }
    public function actionAjaxGetActualReportWorkingDay()
    {
        $retJson['status'] = 'OK';
        if ($_POST['txActualReportIssueDate'] == '') {
            $endDate = null;
        } else {
            $endDate = trim($_POST['txActualReportIssueDate']);
        }
        if ($_POST['txServiceCompletionDate'] == '') {
            $startDate = null;
        } else {
            $startDate = trim($_POST['txServiceCompletionDate']);
        }
        $numberOfWorkingDay = Yii::app()->commonUtil->GetWorkingDayByStartDateAndEndDate($startDate, $endDate);
        $retJson['numberOfWorkingDay'] = $numberOfWorkingDay;
        echo json_encode($retJson);
    }
    public function actionAjaxGetActualWorkingDay()
    {
        $retJson['status'] = 'OK';
        if ($_POST['txCustomerContactedDate'] == '') {
            $startDate = null;
        } else {
            $startDate = trim($_POST['txCustomerContactedDate']);
        }
        if ($_POST['txServiceCompletionDate'] == '') {
            $endDate = null;
        } else {
            $endDate = trim($_POST['txServiceCompletionDate']);
        }
        $numberOfWorkingDay = Yii::app()->commonUtil->GetWorkingDayByStartDateAndEndDate($startDate, $endDate);
        $retJson['numberOfWorkingDay'] = $numberOfWorkingDay;
        echo json_encode($retJson);
    }
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $this->render("//site/pages/firstPage");
    }

    public function actionLanding()
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);
        if(isset($param['mode'])){
        $this->viewbag['mode'] = $param['mode'];
        }
        else{
            $this->viewbag['mode']= '';
        }
        $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();
        $this->viewbag['serviceTypeList'] = Yii::app()->formDao->getFormServiceTypeAll();
        $this->viewbag['partyToBeChargedList'] = Yii::app()->formDao->getFormPartyToBeChargedAll();
        $this->viewbag['requestedByList'] = Yii::app()->formDao->getFormRequestedByAll();
        $this->viewbag['customerList'] = Yii::app()->formDao->getFormCustomerAll();
        $this->render("//site/form/caseFormSearch");
    }
    public function actionPlanningAheadSearch()
    {
        $this->viewbag['mode'] = 'normal';
        $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();
        $this->viewbag['projectRegionList'] = Yii::app()->formDao->getPlanningAheadProjectRegionAll();
        $this->render("//site/form/planningAheadSearch");
    }
    public function actionPlanningAheadSearchForCaseForm()
    {   
        $this->viewbag['mode'] = 'planningAheadSearchForCaseForm';
        $this->viewbag['iframe'] = 'caseForm';   
        $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();
        $this->viewbag['projectRegionList'] = Yii::app()->formDao->getPlanningAheadProjectRegionAll();
        $this->render("//site/form/planningAheadSearch");
    }
    public function actionGetPlanningAheadForNewForCaseForm()
    {
        $this->viewbag['mode'] = 'new';    
        $this->viewbag['iframe'] = 'caseForm';    
        $this->viewbag['projectRegionList'] = Yii::app()->formDao->getPlanningAheadProjectRegionActive();     
        $this->viewbag['projectTypeList'] = Yii::app()->formDao->getPlanningAheadProjectTypeActive();
        $this->viewbag['buildingTypeList'] = Yii::app()->formDao->getPlanningAheadBuildingTypeActive();
        $this->viewbag['planningAheadStatusList'] = Yii::app()->formDao->getPlanningAheadPlanningAheadStatusActive();
        $this->viewbag['replySlipReturnGradeList'] = Yii::app()->formDao->getPlanningAheadReplySlipReturnGradeActive();
        $this->viewbag['consultantCompanyList'] = Yii::app()->formDao->getPlanningAheadConsultantCompanyActive();
        $this->viewbag['consultantList'] = Yii::app()->formDao->getPlanningAheadConsultantActive();
        $this->viewbag['regionPlannerList'] = Yii::app()->formDao->getPlanningAheadRegionPlannerActive();
        $this->viewbag['pqSensitiveLoadList'] = Yii::app()->formDao->getPlanningAheadPqSensitiveLoadActive();
        
        $this->render("//site/form/planningAhead");
    }
    public function actionGetPlanningAheadForUpdateForCaseForm()
    {
        $this->viewbag['mode'] = "update";
        $this->viewbag['iframe'] = 'caseForm';   
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        parse_str(parse_url($url, PHP_URL_QUERY), $param);
        $planningAheadId = $param['planningAheadId'];
        $planning= $this->viewbag['planningAhead'] = Yii::app()->formDao->getPlanningAheadByPlanningAheadId($planningAheadId);

        $this->viewbag['projectRegionList'] = Yii::app()->formDao->getPlanningAheadProjectRegionActive();
        $this->viewbag['projectTypeList'] = Yii::app()->formDao->getPlanningAheadProjectTypeActive();
        $this->viewbag['buildingTypeList'] = Yii::app()->formDao->getPlanningAheadBuildingTypeActive();
        $this->viewbag['planningAheadStatusList'] = Yii::app()->formDao->getPlanningAheadPlanningAheadStatusActive();
        $this->viewbag['replySlipReturnGradeList'] = Yii::app()->formDao->getPlanningAheadReplySlipReturnGradeActive();
        $this->viewbag['consultantCompanyList'] = Yii::app()->formDao->getPlanningAheadConsultantCompanyActive();
        $this->viewbag['consultantList'] = Yii::app()->formDao->getPlanningAheadConsultantActive();
        $this->viewbag['regionPlannerList'] = Yii::app()->formDao->getPlanningAheadRegionPlannerActive();
        $this->viewbag['pqSensitiveLoadList'] = Yii::app()->formDao->getPlanningAheadPqSensitiveLoadActive();

        $this->render("//site/form/planningAhead");
    }
    public function actionGetPlanningAheadForReadForCaseForm()
    {
        
        $this->viewbag['mode'] = "read";
        $this->viewbag['iframe'] = 'caseForm';   
        $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        parse_str(parse_url($url, PHP_URL_QUERY), $param);
        $planningAheadId = $param['planningAheadId'];
        $this->viewbag['planningAhead'] = Yii::app()->formDao->getPlanningAheadByPlanningAheadId($planningAheadId);

        $this->viewbag['projectRegionList'] = Yii::app()->formDao->getPlanningAheadProjectRegionAll();
        $this->viewbag['projectTypeList'] = Yii::app()->formDao->getPlanningAheadProjectTypeAll();
        $this->viewbag['buildingTypeList'] = Yii::app()->formDao->getPlanningAheadBuildingTypeAll();
        $this->viewbag['planningAheadStatusList'] = Yii::app()->formDao->getPlanningAheadPlanningAheadStatusAll();
        $this->viewbag['replySlipReturnGradeList'] = Yii::app()->formDao->getPlanningAheadReplySlipReturnGradeAll();
        $this->viewbag['consultantCompanyList'] = Yii::app()->formDao->getPlanningAheadConsultantCompanyAll();
        $this->viewbag['consultantList'] = Yii::app()->formDao->getPlanningAheadConsultantAll();
        $this->viewbag['regionPlannerList'] = Yii::app()->formDao->getPlanningAheadRegionPlannerAll();
        $this->viewbag['pqSensitiveLoadList'] = Yii::app()->formDao->getPlanningAheadPqSensitiveLoadAll();

        $this->render("//site/form/planningAhead");
    }
    public function actionGetPlanningAheadForNew()
    {
        $this->viewbag['mode'] = 'new';
        $this->viewbag['iframe'] = '';   
        $this->viewbag['projectRegionList'] = Yii::app()->formDao->getPlanningAheadProjectRegionActive();     
        $this->viewbag['projectTypeList'] = Yii::app()->formDao->getPlanningAheadProjectTypeActive();
        $this->viewbag['buildingTypeList'] = Yii::app()->formDao->getPlanningAheadBuildingTypeActive();
        $this->viewbag['planningAheadStatusList'] = Yii::app()->formDao->getPlanningAheadPlanningAheadStatusActive();
        $this->viewbag['replySlipReturnGradeList'] = Yii::app()->formDao->getPlanningAheadReplySlipReturnGradeActive();
        $this->viewbag['consultantCompanyList'] = Yii::app()->formDao->getPlanningAheadConsultantCompanyActive();
        $this->viewbag['consultantList'] = Yii::app()->formDao->getPlanningAheadConsultantActive();
        $this->viewbag['regionPlannerList'] = Yii::app()->formDao->getPlanningAheadRegionPlannerActive();
        $this->viewbag['pqSensitiveLoadList'] = Yii::app()->formDao->getPlanningAheadPqSensitiveLoadActive();
        
        $this->render("//site/form/planningAhead");
    }


    public function actionGetPlanningAheadForUpdate()
    {
        $this->viewbag['mode'] = "update";
        $this->viewbag['iframe'] = '';   
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        parse_str(parse_url($url, PHP_URL_QUERY), $param);
        $planningAheadId = $param['planningAheadId'];
        $planning= $this->viewbag['planningAhead'] = Yii::app()->formDao->getPlanningAheadByPlanningAheadId($planningAheadId);

        $this->viewbag['projectRegionList'] = Yii::app()->formDao->getPlanningAheadProjectRegionActive();
        $this->viewbag['projectTypeList'] = Yii::app()->formDao->getPlanningAheadProjectTypeActive();
        $this->viewbag['buildingTypeList'] = Yii::app()->formDao->getPlanningAheadBuildingTypeActive();
        $this->viewbag['planningAheadStatusList'] = Yii::app()->formDao->getPlanningAheadPlanningAheadStatusActive();
        $this->viewbag['replySlipReturnGradeList'] = Yii::app()->formDao->getPlanningAheadReplySlipReturnGradeActive();
        $this->viewbag['consultantCompanyList'] = Yii::app()->formDao->getPlanningAheadConsultantCompanyActive();
        $this->viewbag['consultantList'] = Yii::app()->formDao->getPlanningAheadConsultantActive();
        $this->viewbag['regionPlannerList'] = Yii::app()->formDao->getPlanningAheadRegionPlannerActive();
        $this->viewbag['pqSensitiveLoadList'] = Yii::app()->formDao->getPlanningAheadPqSensitiveLoadActive();

        $this->render("//site/form/planningAhead");
    }
    public function actionGetPlanningAheadForRead()
    {
        
        $this->viewbag['mode'] = "read";
        $this->viewbag['iframe'] = '';   
        $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        parse_str(parse_url($url, PHP_URL_QUERY), $param);
        $planningAheadId = $param['planningAheadId'];
        $this->viewbag['planningAhead'] = Yii::app()->formDao->getPlanningAheadByPlanningAheadId($planningAheadId);

        $this->viewbag['projectRegionList'] = Yii::app()->formDao->getPlanningAheadProjectRegionAll();
        $this->viewbag['projectTypeList'] = Yii::app()->formDao->getPlanningAheadProjectTypeAll();
        $this->viewbag['buildingTypeList'] = Yii::app()->formDao->getPlanningAheadBuildingTypeAll();
        $this->viewbag['planningAheadStatusList'] = Yii::app()->formDao->getPlanningAheadPlanningAheadStatusAll();
        $this->viewbag['replySlipReturnGradeList'] = Yii::app()->formDao->getPlanningAheadReplySlipReturnGradeAll();
        $this->viewbag['consultantCompanyList'] = Yii::app()->formDao->getPlanningAheadConsultantCompanyAll();
        $this->viewbag['consultantList'] = Yii::app()->formDao->getPlanningAheadConsultantAll();
        $this->viewbag['regionPlannerList'] = Yii::app()->formDao->getPlanningAheadRegionPlannerAll();
        $this->viewbag['pqSensitiveLoadList'] = Yii::app()->formDao->getPlanningAheadPqSensitiveLoadAll();

        $this->render("//site/form/planningAhead");
    }
    public function actiontestSearch()
    {
        $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();
        $this->viewbag['serviceTypeList'] = Yii::app()->formDao->getFormServiceTypeAll();
        $this->viewbag['partyToBeChargedList'] = Yii::app()->formDao->getFormPartyToBeChargedAll();
        $this->viewbag['requestedByList'] = Yii::app()->formDao->getFormRequestedByAll();
        $this->viewbag['customerList'] = Yii::app()->formDao->getFormCustomerAll();
        $this->render("//site/form/testSearch");
    }
    public function actionCaseFormSearch()
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);
        if(isset($param['mode'])){
        $this->viewbag['mode'] = $param['mode'];
        }
        else{
            $this->viewbag['mode']= '';
        }
        $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();
        $this->viewbag['serviceTypeList'] = Yii::app()->formDao->getFormServiceTypeAll();
        $this->viewbag['partyToBeChargedList'] = Yii::app()->formDao->getFormPartyToBeChargedAll();
        $this->viewbag['requestedByList'] = Yii::app()->formDao->getFormRequestedByAll();
        $this->viewbag['customerList'] = Yii::app()->formDao->getFormCustomerAll();
        $this->render("//site/form/caseFormSearch");
    }
    public function actionGetCaseFormForNew()
    {
        $this->viewbag['mode'] = 'new';
        $this->viewbag['caseFormPlannedToActualReportIssueWorkingDay'] = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormPlannedToActualReportIssueWorkingDay');
        $caseFormCompletionDateToleranceDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormCompletionDateToleranceDay');
        $caseFormReporEndDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormReporEndDay');
        $this->viewbag['deadLine'] = date("Y-m-d", strtotime(date("Y") . "-" . date("m") . "-" . $caseFormReporEndDay["configValue"] . "+" . $caseFormCompletionDateToleranceDay["configValue"] . " days"));
        
        $this->viewbag['CaseNoMax'] = Yii::app()->formDao->getFormCaseNoMax();
        $this->viewbag['serviceTypeList'] = Yii::app()->formDao->getFormServiceTypeActive();
        $this->viewbag['partyToBeChargedList'] = Yii::app()->formDao->getFormPartyToBeChargedActive();
        $this->viewbag['problemTypeList'] = Yii::app()->formDao->getFormProblemTypeActive();
        $this->viewbag['clpReferredByList'] = Yii::app()->formDao->getFormClpReferredByActive();
        $this->viewbag['requestedByList'] = Yii::app()->formDao->getFormRequestedByActive();
        $this->viewbag['requestedByAutoCompleteList'] = Yii::app()->formDao->getFormRequestedByAutoCompleteActive();
        $this->viewbag['serviceStatusList'] = Yii::app()->formDao->getFormServiceStatusActive();
        $this->viewbag['requestedByDept'] = Yii::app()->formDao->getFormRequestedByDeptActive();
        $this->viewbag['businessTypeList'] = Yii::app()->formDao->getFormBusinessTypeActive();
        $this->viewbag['eicList'] = Yii::app()->formDao->getFormEicActive();
        $this->viewbag['countYear'] = Yii::app()->maintenanceDao->GetCostTypeCountYear();
        //$this->viewbag['costTypeList'] = Yii::app()->formDao->getFormCostTypeActive();
        $this->viewbag['plantTypeList'] = Yii::app()->formDao->getFormPlantTypeActive();
        $this->viewbag['majorAffectedElementList'] = Yii::app()->formDao->getFormMajorAffectedElementActive();
        $this->viewbag['contactPersonList'] = Yii::app()->formDao->getFormContactPersonActive();
        $this->viewbag['customerList'] = Yii::app()->formDao->getFormCustomerActive();
        $this->viewbag['actionByList'] = Yii::app()->formDao->getFormActionByActive();
        $this->viewbag['incidentList'] = Yii::app()->formDao->getFormIncidentAll();
        $this->render("//site/Form/CaseForm");

    }
    public function actionGetCaseFormForUpdate()
    {
        $this->viewbag['mode'] = 'update';
        $this->viewbag['caseFormPlannedToActualReportIssueWorkingDay'] = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormPlannedToActualReportIssueWorkingDay');
        $caseFormCompletionDateToleranceDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormCompletionDateToleranceDay');
        $caseFormReporEndDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormReporEndDay');
        $this->viewbag['deadLine'] = date("Y-m-d", strtotime(date("Y") . "-" . date("m") . "-" . $caseFormReporEndDay["configValue"] . "+" . $caseFormCompletionDateToleranceDay["configValue"] . " days"));

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);
        $this->viewbag['serviceCaseId'] = $serviceCaseId = $param['serviceCaseId'];
        $this->viewbag['serviceCaseForm'] = Yii::app()->formDao->getCaseFormByServiceCaseId($serviceCaseId);
        $this->viewbag['serviceTypeList'] = Yii::app()->formDao->getFormServiceTypeActive();
        $this->viewbag['partyToBeChargedList'] = Yii::app()->formDao->getFormPartyToBeChargedActive();
        $this->viewbag['problemTypeList'] = Yii::app()->formDao->getFormProblemTypeActive();
        $this->viewbag['clpReferredByList'] = Yii::app()->formDao->getFormClpReferredByActive();
        $this->viewbag['requestedByList'] = Yii::app()->formDao->getFormRequestedByActive();
        $this->viewbag['requestedByAutoCompleteList'] = Yii::app()->formDao->getFormRequestedByAutoCompleteActive();
        $this->viewbag['serviceStatusList'] = Yii::app()->formDao->getFormServiceStatusActive();
        $this->viewbag['requestedByDept'] = Yii::app()->formDao->getFormRequestedByDeptActive();
        $this->viewbag['businessTypeList'] = Yii::app()->formDao->getFormBusinessTypeActive();
        $this->viewbag['eicList'] = Yii::app()->formDao->getFormEicActive();
        $this->viewbag['countYear'] = Yii::app()->maintenanceDao->GetCostTypeCountYear();
        $this->viewbag['costType'] = Yii::app()->formDao->getFormCostTypeByCostTypeId($this->viewbag['serviceCaseForm']['costTypeId']);
        //$this->viewbag['costTypeList'] = Yii::app()->formDao->getFormCostTypeActive();
        $this->viewbag['plantTypeList'] = Yii::app()->formDao->getFormPlantTypeActive();
        $this->viewbag['majorAffectedElementList'] = Yii::app()->formDao->getFormmajorAffectedElementActive();
        $this->viewbag['contactPersonList'] = Yii::app()->formDao->getFormContactPersonActive();
        $this->viewbag['customerList'] = Yii::app()->formDao->getFormCustomerActive();
        $this->viewbag['actionByList'] = Yii::app()->formDao->getFormActionByActive();
        $this->viewbag['incidentList'] = Yii::app()->formDao->getFormIncidentAll();
        $this->render("//site/Form/CaseForm");

    }
    public function actionGetCaseFormForCopy()
    {
        $this->viewbag['mode'] = 'copy';
        $this->viewbag['caseFormPlannedToActualReportIssueWorkingDay'] = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormPlannedToActualReportIssueWorkingDay');
        $caseFormCompletionDateToleranceDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormCompletionDateToleranceDay');
        $caseFormReporEndDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormReporEndDay');
        $this->viewbag['deadLine'] = date("Y-m-d", strtotime(date("Y") . "-" . date("m") . "-" . $caseFormReporEndDay["configValue"] . "+" . $caseFormCompletionDateToleranceDay["configValue"] . " days"));

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);
        $serviceCaseId = $param['serviceCaseId'];
        $this->viewbag['serviceCaseForm'] = Yii::app()->formDao->getCaseFormByServiceCaseId($serviceCaseId);
        $maxCaseVersion = Yii::app()->formDao->getCaseFormByParentCaseNoAndCaseVersionOrderByVersion($this->viewbag['serviceCaseForm']['parentCaseNo'],$this->viewbag['serviceCaseForm']['caseVersion']);
        $this->viewbag['maxCaseVersion'] = $maxCaseVersion['caseVersion'] +1;
        $this->viewbag['serviceTypeList'] = Yii::app()->formDao->getFormServiceTypeActive();
        $this->viewbag['partyToBeChargedList'] = Yii::app()->formDao->getFormPartyToBeChargedActive();
        $this->viewbag['problemTypeList'] = Yii::app()->formDao->getFormProblemTypeActive();
        $this->viewbag['clpReferredByList'] = Yii::app()->formDao->getFormClpReferredByActive();
        $this->viewbag['requestedByList'] = Yii::app()->formDao->getFormRequestedByActive();
        $this->viewbag['requestedByAutoCompleteList'] = Yii::app()->formDao->getFormRequestedByAutoCompleteActive();
        $this->viewbag['serviceStatusList'] = Yii::app()->formDao->getFormServiceStatusActive();
        $this->viewbag['requestedByDept'] = Yii::app()->formDao->getFormRequestedByDeptActive();
        $this->viewbag['businessTypeList'] = Yii::app()->formDao->getFormBusinessTypeActive();
        $this->viewbag['eicList'] = Yii::app()->formDao->getFormEicActive();
        $this->viewbag['countYear'] = Yii::app()->maintenanceDao->GetCostTypeCountYear();
        $this->viewbag['costType'] = Yii::app()->formDao->getFormCostTypeByCostTypeId($this->viewbag['serviceCaseForm']['costTypeId']);
        //$this->viewbag['costTypeList'] = Yii::app()->formDao->getFormCostTypeActive();
        $this->viewbag['plantTypeList'] = Yii::app()->formDao->getFormPlantTypeActive();
        $this->viewbag['majorAffectedElementList'] = Yii::app()->formDao->getFormmajorAffectedElementActive();
        $this->viewbag['contactPersonList'] = Yii::app()->formDao->getFormContactPersonActive();
        $this->viewbag['customerList'] = Yii::app()->formDao->getFormCustomerActive();
        $this->viewbag['actionByList'] = Yii::app()->formDao->getFormActionByActive();
        $this->viewbag['incidentList'] = Yii::app()->formDao->getFormIncidentAll();
        $this->render("//site/Form/CaseForm");

    }
    public function actionGetCaseFormForRead()
    {
        $this->viewbag['mode'] = 'read';
        $this->viewbag['disabled'] = Yii::app()->commonUtil->getEditBtnRight();
        
        $this->viewbag['caseFormPlannedToActualReportIssueWorkingDay'] = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormPlannedToActualReportIssueWorkingDay');
        $caseFormCompletionDateToleranceDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormCompletionDateToleranceDay');
        $caseFormReporEndDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormReporEndDay');
        $this->viewbag['deadLine'] = date("Y-m-d", strtotime(date("Y") . "-" . date("m") . "-" . $caseFormReporEndDay["configValue"] . "+" . $caseFormCompletionDateToleranceDay["configValue"] . " days"));

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);
        $this->viewbag['serviceCaseId'] = $serviceCaseId = $param['serviceCaseId'];
        $this->viewbag['serviceCaseForm'] = Yii::app()->formDao->getCaseFormByServiceCaseId($serviceCaseId);
        $this->viewbag['serviceTypeList'] = Yii::app()->formDao->getFormServiceTypeAll();
        $this->viewbag['partyToBeChargedList'] = Yii::app()->formDao->getFormPartyToBeChargedAll();
        $this->viewbag['problemTypeList'] = Yii::app()->formDao->getFormProblemTypeAll();
        $this->viewbag['clpReferredByList'] = Yii::app()->formDao->getFormClpReferredByAll();
        $this->viewbag['requestedByList'] = Yii::app()->formDao->getFormRequestedByAll();
        $this->viewbag['requestedByAutoCompleteList'] = Yii::app()->formDao->getFormRequestedByAutoCompleteAll();
        $this->viewbag['serviceStatusList'] = Yii::app()->formDao->getFormServiceStatusAll();
        $this->viewbag['requestedByDept'] = Yii::app()->formDao->getFormRequestedByDeptAll();
        $this->viewbag['businessTypeList'] = Yii::app()->formDao->getFormBusinessTypeAll();
        $this->viewbag['eicList'] = Yii::app()->formDao->getFormEicAll();
        $this->viewbag['countYear'] = Yii::app()->maintenanceDao->GetCostTypeCountYear();
        $this->viewbag['costType'] = Yii::app()->formDao->getFormCostTypeByCostTypeId($this->viewbag['serviceCaseForm']['costTypeId']);
        //$this->viewbag['costTypeList'] = Yii::app()->formDao->getFormCostTypeActive();
        $this->viewbag['plantTypeList'] = Yii::app()->formDao->getFormPlantTypeAll();
        $this->viewbag['majorAffectedElementList'] = Yii::app()->formDao->getFormmajorAffectedElementAll();
        $this->viewbag['contactPersonList'] = Yii::app()->formDao->getFormContactPersonAll();
        $this->viewbag['customerList'] = Yii::app()->formDao->getFormCustomerAll();
        $this->viewbag['actionByList'] = Yii::app()->formDao->getFormActionByAll();
        $this->viewbag['incidentList'] = Yii::app()->formDao->getFormIncidentAll();
        $this->render("//site/Form/CaseForm");

    }

    // Load the upload form for allowing user to upload Condition Letter
    public function actionGetUploadConditionLetterForm() {

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        $this->render("//site/Form/PlanningAheadUploadConditionLetter");
    }

    // process the uploaded condition letter and save it to condition letter path in server
    public function actionPostUploadConditionLetter() {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {
            $fileName = basename($_FILES["file"]["name"]);
            $planningAheadConditionLetterPath = Yii::app()->commonUtil->getConfigValueByConfigName('planningAheadConditionLetterPath');
            $targetFilePath = $planningAheadConditionLetterPath["configValue"] . $fileName;
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

            //allow certain file formats
            $allowTypes = array('pdf');
            if (in_array($fileType, $allowTypes)){
                //upload file to server
                if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                    $this->viewbag['resultMsg'] = "The file [". $fileName . "] has been uploaded.";
                    $this->viewbag['IsUploadSuccess'] = true;
                }else{
                    $this->viewbag['resultMsg']  = "Sorry, there was an error uploading your file!";
                    $this->viewbag['IsUploadSuccess'] = false;
                }
            } else {
                $this->viewbag['resultMsg'] = 'Please select the condition letter in PDF format!';
                $this->viewbag['IsUploadSuccess'] = false;
            }

        } else {
            $this->viewbag['IsUploadSuccess'] = false;
            $this->viewbag['resultMsg'] = 'Please select the condition letter to upload!';
        }

        $this->render("//site/Form/PlanningAheadUploadConditionLetter");
    }

    // Load the form for Planning Ahead Project
    public function actionGetPlanningAheadProjectDetailForm() {

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        if (isset($param['SchemeNo'])) {
            $schemeNo = $param['SchemeNo'];
            $this->viewbag['schemeNo'] = $schemeNo;

            $recordList = Yii::app()->formDao->getPlanningAheadDetails($schemeNo);
            $this->viewbag['planningAheadId'] = $recordList['planningAheadId'];
            $this->viewbag['projectTitle'] = $recordList['projectTitle'];
            $this->viewbag['regionId'] = $recordList['regionId'];
            $this->viewbag['regionShortName'] = $recordList['regionShortName'];
            $this->viewbag['conditionLetterFilename'] = $recordList['conditionLetterFilename'];
            $this->viewbag['projectTypeId'] = $recordList['projectTypeId'];
            $this->viewbag['commissionDate'] = $recordList['commissionDate'];
            $this->viewbag['keyInfra'] = $recordList['keyInfra'];
            $this->viewbag['tempProject'] = $recordList['tempProject'];
            $this->viewbag['firstRegionStaffName'] = $recordList['firstRegionStaffName'];
            $this->viewbag['firstRegionStaffPhone'] = $recordList['firstRegionStaffPhone'];
            $this->viewbag['firstRegionStaffEmail'] = $recordList['firstRegionStaffEmail'];
            $this->viewbag['secondRegionStaffName'] = $recordList['secondRegionStaffName'];
            $this->viewbag['secondRegionStaffPhone'] = $recordList['secondRegionStaffPhone'];
            $this->viewbag['secondRegionStaffEmail'] = $recordList['secondRegionStaffEmail'];
            $this->viewbag['thirdRegionStaffName'] = $recordList['thirdRegionStaffName'];
            $this->viewbag['thirdRegionStaffPhone'] = $recordList['thirdRegionStaffPhone'];
            $this->viewbag['thirdRegionStaffEmail'] = $recordList['thirdRegionStaffEmail'];
            $this->viewbag['firstConsultantTitle'] = $recordList['firstConsultantTitle'];
            $this->viewbag['firstConsultantSurname'] = $recordList['firstConsultantSurname'];
            $this->viewbag['firstConsultantOtherName'] = $recordList['firstConsultantOtherName'];
            $this->viewbag['firstConsultantCompanyId'] = $recordList['firstConsultantCompanyId'];
            $this->viewbag['firstConsultantCompanyName'] = $recordList['firstConsultantCompanyName'];
            $this->viewbag['firstConsultantPhone'] = $recordList['firstConsultantPhone'];
            $this->viewbag['firstConsultantEmail'] = $recordList['firstConsultantEmail'];
            $this->viewbag['secondConsultantTitle'] = $recordList['secondConsultantTitle'];
            $this->viewbag['secondConsultantSurname'] = $recordList['secondConsultantSurname'];
            $this->viewbag['secondConsultantOtherName'] = $recordList['secondConsultantOtherName'];
            $this->viewbag['secondConsultantCompany'] = $recordList['secondConsultantCompany'];
            $this->viewbag['secondConsultantPhone'] = $recordList['secondConsultantPhone'];
            $this->viewbag['secondConsultantEmail'] = $recordList['secondConsultantEmail'];
            $this->viewbag['thirdConsultantTitle'] = $recordList['thirdConsultantTitle'];
            $this->viewbag['thirdConsultantSurname'] = $recordList['thirdConsultantSurname'];
            $this->viewbag['thirdConsultantOtherName'] = $recordList['thirdConsultantOtherName'];
            $this->viewbag['thirdConsultantCompany'] = $recordList['thirdConsultantCompany'];
            $this->viewbag['thirdConsultantPhone'] = $recordList['thirdConsultantPhone'];
            $this->viewbag['thirdConsultantEmail'] = $recordList['thirdConsultantEmail'];
            $this->viewbag['projectOwnerTitle'] = $recordList['projectOwnerTitle'];
            $this->viewbag['projectOwnerSurname'] = $recordList['projectOwnerSurname'];
            $this->viewbag['projectOwnerOtherName'] = $recordList['projectOwnerOtherName'];
            $this->viewbag['projectOwnerCompany'] = $recordList['projectOwnerCompany'];
            $this->viewbag['projectOwnerPhone'] = $recordList['projectOwnerPhone'];
            $this->viewbag['projectOwnerEmail'] = $recordList['projectOwnerEmail'];
            $this->viewbag['standLetterIssueDate'] = $recordList['standLetterIssueDate'];
            $this->viewbag['standLetterFaxRefNo'] = $recordList['standLetterFaxRefNo'];
            $this->viewbag['standLetterEdmsLink'] = $recordList['standLetterEdmsLink'];
            $this->viewbag['standLetterLetterLoc'] = $recordList['standLetterLetterLoc'];
            $this->viewbag['meetingFirstPreferMeetingDate'] = $recordList['meetingFirstPreferMeetingDate'];
            $this->viewbag['meetingSecondPreferMeetingDate'] = $recordList['meetingSecondPreferMeetingDate'];
            $this->viewbag['meetingActualMeetingDate'] = $recordList['meetingActualMeetingDate'];
            $this->viewbag['meetingRejReason'] = $recordList['meetingRejReason'];
            $this->viewbag['meetingConsentConsultant'] = $recordList['meetingConsentConsultant'];
            $this->viewbag['meetingConsentOwner'] = $recordList['meetingConsentOwner'];
            $this->viewbag['meetingReplySlipId'] = $recordList['meetingReplySlipId'];
            $this->viewbag['firstInvitationLetterIssueDate'] = $recordList['firstInvitationLetterIssueDate'];
            $this->viewbag['firstInvitationLetterFaxRefNo'] = $recordList['firstInvitationLetterFaxRefNo'];
            $this->viewbag['firstInvitationLetterEdmsLink'] = $recordList['firstInvitationLetterEdmsLink'];
            $this->viewbag['firstInvitationLetterAccept'] = $recordList['firstInvitationLetterAccept'];
            $this->viewbag['firstInvitationLetterWalkDate'] = $recordList['firstInvitationLetterWalkDate'];
            $this->viewbag['secondInvitationLetterIssueDate'] = $recordList['secondInvitationLetterIssueDate'];
            $this->viewbag['secondInvitationLetterFaxRefNo'] = $recordList['secondInvitationLetterFaxRefNo'];
            $this->viewbag['secondInvitationLetterEdmsLink'] = $recordList['secondInvitationLetterEdmsLink'];
            $this->viewbag['secondInvitationLetterAccept'] = $recordList['secondInvitationLetterAccept'];
            $this->viewbag['secondInvitationLetterWalkDate'] = $recordList['secondInvitationLetterWalkDate'];
            $this->viewbag['thirdInvitationLetterIssueDate'] = $recordList['thirdInvitationLetterIssueDate'];
            $this->viewbag['thirdInvitationLetterFaxRefNo'] = $recordList['thirdInvitationLetterFaxRefNo'];
            $this->viewbag['thirdInvitationLetterEdmsLink'] = $recordList['thirdInvitationLetterEdmsLink'];
            $this->viewbag['thirdInvitationLetterAccept'] = $recordList['thirdInvitationLetterAccept'];
            $this->viewbag['thirdInvitationLetterWalkDate'] = $recordList['thirdInvitationLetterWalkDate'];
            $this->viewbag['forthInvitationLetterIssueDate'] = $recordList['forthInvitationLetterIssueDate'];
            $this->viewbag['forthInvitationLetterFaxRefNo'] = $recordList['forthInvitationLetterFaxRefNo'];
            $this->viewbag['forthInvitationLetterEdmsLink'] = $recordList['forthInvitationLetterEdmsLink'];
            $this->viewbag['forthInvitationLetterAccept'] = $recordList['forthInvitationLetterAccept'];
            $this->viewbag['forthInvitationLetterWalkDate'] = $recordList['forthInvitationLetterWalkDate'];
            $this->viewbag['evaReportId'] = $recordList['evaReportId'];
            $this->viewbag['state'] = $recordList['state'];
            $this->viewbag['active'] = $recordList['active'];
            $this->viewbag['createdBy'] = $recordList['createdBy'];
            $this->viewbag['createdTime'] = $recordList['createdTime'];
            $this->viewbag['lastUpdatedBy'] = $recordList['lastUpdatedBy'];
            $this->viewbag['lastUpdatedTime'] = $recordList['lastUpdatedTime'];
            $this->viewbag['projectTypeList'] = Yii::app()->formDao->getPlanningAheadProjectTypeList();
            $this->viewbag['consultantCompanyList'] = Yii::app()->formDao->getPlanningAheadConsultantCompanyAllActive();
            $this->viewbag['regionList'] = Yii::app()->formDao->getPlanningAheadRegionAllActive();
            $this->viewbag['isError'] = false;
        } else {
            $this->viewbag['isError'] = true;
            $this->viewbag['errorMsg'] = 'Please provide Scheme No.!';
        }

        $this->render("//site/Form/PlanningAheadDetail");
    }

    public function actionAjaxGetCaseFormTable()
    {
        $param = json_decode(file_get_contents('php://input'), true);

        $searchParam = json_decode($param['searchParam'], true);
        $start = $param['start'];
        $length = $param['length'];
        $orderColumn = $param['order'][0]['column'];
        $orderDir = $param['order'][0]['dir'];
        //$order = $param['columns'][$orderColumn]['data'] . ' ' . $orderDir;
        $order = '"'. $param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

        $caseFormList = Yii::app()->formDao->GetCaseFormSearchByPage($searchParam, $start, $length, $order);

        $recordFiltered = Yii::app()->formDao->GetCaseFormSearchResultCount($searchParam);

        $totalCount = Yii::app()->formDao->GetCaseFormRecordCount();

        $result = array('draw' => $param['draw'],
            'data' => $caseFormList,
            'recordsFiltered' => $recordFiltered,
            'recordsTotal' => $totalCount);

        echo json_encode($result);

    }

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }

        }
    }
    public function actionAjaxInsertCaseForm()
    {
        $caseFormReporStartDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormReporStartDay');
        $caseFormReporEndDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormReporEndDay');
        $caseFormContactedDateToCompletionDateWorkingDayForEnquiry = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormContactedDateToCompletionDateWorkingDayForEnquiry');
        $caseFormContactedDateToCompletionDateWorkingDayForEnquiryResponseToCustomer = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormContactedDateToCompletionDateWorkingDayForEnquiryResponseToCustomer');
        $caseFormPlannedToActualReportIssueWorkingDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormPlannedToActualReportIssueWorkingDay');
        //$caseNo = isset($_POST['txCaseNo']) ? $_POST['txCaseNo'] : '';
        if ($_POST['txCaseVersion'] == '') {
            $caseVersion = null;
        } else {
            $caseVersion = trim($_POST['txCaseVersion']);
        }
        if ($_POST['txParentCaseNo'] == '') {
            $parentCaseNo = null;
        } else {
            $parentCaseNo = trim($_POST['txParentCaseNo']);
            $checkCaseExistFlag = Yii::app()->formDao->getCaseFormByParentCaseNoAndCaseVersion($parentCaseNo,$caseVersion);
            if($checkCaseExistFlag['serviceCaseId']!= null){
                $retJson['status'] = 'NOTOK';
                $retJson['retMessage'] = 'Case No and Version Already Exist ';
                echo json_encode($retJson);
                return;
            }
        }
        if ($_POST['txServiceType'] == '') {
            $serviceType = null;
        } else {
            $serviceType = trim($_POST['txServiceType']);
        }
        if ($_POST['txProblemType'] == '') {
            $problemType = null;
        } else {
            $problemType = trim($_POST['txProblemType']);
        }
        if ($_POST['txIdrOrderId'] == '') {
            $idrOrderId = null;
        } else {
            $idrOrderId = trim($_POST['txIdrOrderId']);
        }
        if ($_POST['txIncidentId'] == '') {
            $incidentId = null;
        } else {
            $incidentId = trim($_POST['txIncidentId']);
        }
        if ($_POST['txIncidentDate'] == '') {
            $incidentDate = null;
        } else {
            $incidentDate = trim($_POST['txIncidentDate']);
        }
        if ($_POST['txIncidentTime'] == '') {
            $incidentTime = null;
        } else {
            $incidentTime = trim($_POST['txIncidentTime']);
        }
        if ($incidentDate == null) {
            $incidentDateTime = null;
        } else {
            $incidentDateTime = $incidentDate . ' ' . $incidentTime;
        }

        if ($_POST['txRequestDate'] == '') {
            $requestDate = null;
        } else {
            $requestDate = trim($_POST['txRequestDate']);
        }
        if ($_POST['txRequestTime'] == '') {
            $requestTime = null;
        } else {
            $requestTime = trim($_POST['txRequestTime']);
        }
        if ($requestDate == null) {
            $requestDateTime = null;
        } else {
            $requestDateTime = $requestDate . ' ' . $requestTime;
        }
        $clpPersonDepartment = isset($_POST['txClpPersonDepartment']) ? trim($_POST['txClpPersonDepartment']) : '';
        $requestedBy = isset($_POST['txRequestedBy']) ? trim($_POST['txRequestedBy']) : '';
        if ($_POST['txClpReferredBy'] == '') {
            $clpReferredBy = null;
        } else {
            $clpReferredBy = trim($_POST['txClpReferredBy']);
        }
        $customerName = isset($_POST['txCustomerName']) ? trim($_POST['txCustomerName']) : '';
        $customerGroup = isset($_POST['txCustomerGroup']) ? trim($_POST['txCustomerGroup']) : '';
        if ($_POST['txBusinessType'] == '') {
            $businessType = null;
        } else {
            $businessType = trim($_POST['txBusinessType']);
        }
        $clpNetwork = isset($_POST['txClpNetwork']) ? trim($_POST['txClpNetwork']) : '';

        $contactPerson = isset($_POST['txContactPerson']) ? trim($_POST['txContactPerson']) : '';
        $title = isset($_POST['txTitle']) ? trim($_POST['txTitle']) : '';
        if ($_POST['txContactNo'] == '') {
            $contactNo = null;
        } else {
            $contactNo = trim($_POST['txContactNo']);
        }
        $actionBy = isset($_POST['txActionBy']) ? trim($_POST['txActionBy']) : '';
        if ($_POST['txCustomerContactedDate'] == '') {
            $customerContactedDate = null;
        } else {
            $customerContactedDate = trim($_POST['txCustomerContactedDate']);
        }
        $caseReferredToClpe = isset($_POST['txCaseReferredToClpe']) ? trim($_POST['txCaseReferredToClpe']) : '';

        if ($_POST['txServiceStatus'] == '') {
            $serviceStatus = null;
        } else {
            $serviceStatus = trim($_POST['txServiceStatus']);
        }
        if ($_POST['txRequestedVisitDate'] == '') {
            $requestedVisitDate = null;
        } else {
            $requestedVisitDate = trim($_POST['txRequestedVisitDate']);
        }

        if ($_POST['txActualVisitDate'] == '') {
            $actualVisitDate = null;
        } else {
            $actualVisitDate = trim($_POST['txActualVisitDate']);
        }

        if ($_POST['txServiceStartDate'] == '') {
            $serviceStartDate = null;
        } else {
            $serviceStartDate = trim($_POST['txServiceStartDate']);
        }
        if ($_POST['txServiceCompletionDate'] == '') {
            $serviceCompletionDate = null;
        } else {
            $serviceCompletionDate = trim($_POST['txServiceCompletionDate']);
        }
        if ($_POST['txPlannedReportIssueDate'] == '') {
            $plannedReportIssueDate = null;
        } else {
            $plannedReportIssueDate = trim($_POST['txPlannedReportIssueDate']);
        }
        if ($_POST['txActualReportIssueDate'] == '') {
            $actualReportIssueDate = null;
        } else {
            $actualReportIssueDate = trim($_POST['txActualReportIssueDate']);
        }
        if ($_POST['txActualReportWorkingDay'] == '') {
            $actualReportWorkingDay = null;
        } else {
            $actualReportWorkingDay = trim($_POST['txActualReportWorkingDay']);
        }
        if ($_POST['txActualResponseDay'] == '') {
            $actualResponseDay = null;
        } else {
            $actualResponseDay = trim($_POST['txActualResponseDay']);
        }
        if ($_POST['txActualWorkingDay'] == '') {
            $actualWorkingDay = null;
        } else {
            $actualWorkingDay = trim($_POST['txActualWorkingDay']);
        }
        if ($_POST['txManPowerMP'] == '') {
            $manPowerMP = null;
        } else {
            $manPowerMP = trim($_POST['txManPowerMP']);
        }
        if ($_POST['txManPowerG'] == '') {
            $manPowerG = null;
        } else {
            $manPowerG = trim($_POST['txManPowerG']);
        }
        if ($_POST['txManPowerT'] == '') {
            $manPowerT = null;
        } else {
            $manPowerT = trim($_POST['txManPowerT']);
        }
        if ($_POST['txReportedByEic'] == '') {
            $reportedByEic = null;
        } else {
            $reportedByEic = trim($_POST['txReportedByEic']);
        }

        if ($_POST['txUnitRate'] == '') {
            $unitRate = null;
        } else {
            $unitRate = trim($_POST['txUnitRate']);
        }
        if ($_POST['txUnit'] == '') {
            $unit = null;
        } else {
            $unit = trim($_POST['txUnit']);
        }
        if ($_POST['txTotal'] == '') {
            $total = null;
        } else {
            $total = trim($_POST['txTotal']);
        }
        if ($_POST['txPartyToBeCharged'] == '') {
            $partyToBeCharged = null;
        } else {
            $partyToBeCharged = trim($_POST['txPartyToBeCharged']);
        }

        if ($_POST['txPlantType'] == '') {
            $plantType = null;
        } else {
            $plantType = trim($_POST['txPlantType']);
        }
        $manufacturerBrand = isset($_POST['txManufacturerBrand']) ? trim($_POST['txManufacturerBrand']) : '';
        if ($_POST['txMajorAffectedElement'] == '') {
            $majorAffectedElement = null;
        } else {
            $majorAffectedElement = trim($_POST['txMajorAffectedElement']);
        }
        $plantRating = isset($_POST['txPlantRating']) ? trim($_POST['txPlantRating']) : '';
        $customerProblems = isset($_POST['txCustomerProblems']) ? trim($_POST['txCustomerProblems']) : '';
        $actionsAndFinding = isset($_POST['txActionsAndFinding']) ? trim($_POST['txActionsAndFinding']) : '';
        $recommendation = isset($_POST['txRecommendation']) ? trim($_POST['txRecommendation']) : '';
        $remark = isset($_POST['txRemark']) ? trim($_POST['txRemark']) : '';
        $requiredFollowUp = isset($_POST['txRequiredFollowUp']) ? 1 : 0;
        $implementedSolution = isset($_POST['txImplementedSolution']) ? trim($_POST['txImplementedSolution']) : '';
        $proposedSolution = isset($_POST['txProposedSolution']) ? trim($_POST['txProposedSolution']) : '';
        $projectRegion = isset($_POST['txProjectRegion']) ? trim($_POST['txProjectRegion']) : '';
        $projectAddress = isset($_POST['txProjectAddress']) ? trim($_POST['txProjectAddress']) : '';
        $active = isset($_POST['txActive']) ? trim($_POST['txActive']) : '';
        $createdBy = Yii::app()->session['tblUserDo']['username'];
        $createdTime = date("Y-m-d H:i");
        $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
        $lastUpdatedTime = date("Y-m-d H:i");
        if ($_POST['txPlanningAheadId'] == '') {
            $planningAheadId = null;
        } else {
            $planningAheadId = trim($_POST['txPlanningAheadId']);
        }
        //start Month and start Year
        $startYear= null;
        $startMonth = null;
        if($customerContactedDate!=null){
            $caseStartYear = date('Y', strtotime($customerContactedDate));
            $caseStartMonth = date('m', strtotime($customerContactedDate));
            $caseStartDay = date('d', strtotime($customerContactedDate));
            $startYear = $caseStartYear;
            if($caseStartDay>$caseFormReporStartDay["configValue"]){
                if ($caseStartMonth == 12) {
                    $startMonth = 1;
                    $startYear = $caseStartYear+1;
                }
                else{
                    $startMonth = $caseStartMonth+1;
                }
            }
            else{
                $startMonth = $caseStartMonth;

            }
        }
        //count Month and Count Year
        $year = null;
        $month = null;
        if (($serviceType == 3 || $serviceType == 4) && ($actualReportIssueDate != null)) {
            $reportEndDate = date('d/m/Y', strtotime($actualReportIssueDate));
            $reportEndYear = date('Y', strtotime($actualReportIssueDate));
            $reportEndMonth = date('m', strtotime($actualReportIssueDate));
            $reportEndDay = date('d', strtotime($actualReportIssueDate));
            $DeadLine = date('d/m/Y', strtotime($caseFormReporEndDay["configValue"] . '/' . $reportEndMonth . '/' . $reportEndYear));
            $year = $reportEndYear;
            if ($reportEndDay > $caseFormReporEndDay["configValue"]) {
                if ($reportEndMonth == 12) {
                    $month = 1;
                    $year = $reportEndYear + 1;
                } else {
                    $month = $reportEndMonth + 1;
                }
            } 
            else {
                $month = $reportEndMonth;
            }

            if ($actualReportWorkingDay != null) {
                if($actualReportWorkingDay> $caseFormPlannedToActualReportIssueWorkingDay['configValue']) {
                    $completedBeforeTargetDate = 'N';
                } else {
                    $completedBeforeTargetDate = 'Y';
                }
            }
            else{
                $completedBeforeTargetDate ='';
            }

        } elseif (($serviceType != 3 && $serviceType != 4) && ($serviceCompletionDate != null)) {
            $reportEndDate = date('d/m/Y', strtotime($serviceCompletionDate));
            $reportEndYear = date('Y', strtotime($serviceCompletionDate));
            $reportEndMonth = date('m', strtotime($serviceCompletionDate));
            $reportEndDay = date('d', strtotime($serviceCompletionDate));
            $DeadLine = date('d/m/Y', strtotime($caseFormReporEndDay["configValue"] . '/' . $reportEndMonth . '/' . $reportEndYear));
            $year = $reportEndYear;
            if ($reportEndDay > $caseFormReporEndDay["configValue"]) {
                if ($reportEndMonth == 12) {
                    $month = 1;
                    $year = $reportEndYear + 1;
                } else {
                    $month = $reportEndMonth + 1;
                }
            } else {
                $month = $reportEndMonth;
            }

            if ($actualWorkingDay != null) {
                if($serviceType !=16){
                    if ($actualWorkingDay > $caseFormContactedDateToCompletionDateWorkingDayForEnquiry['configValue']) {
                    $completedBeforeTargetDate = 'N';
                    } else {
                    $completedBeforeTargetDate = 'Y';
                    }
                }
                else{
                    if ($actualWorkingDay > $caseFormContactedDateToCompletionDateWorkingDayForEnquiryResponseToCustomer['configValue']) {
                        $completedBeforeTargetDate = 'N';
                        } else {
                        $completedBeforeTargetDate = 'Y';
                        }
                }
                
            }
            else{
                $completedBeforeTargetDate ='';
            }
        }
        else{
            $year = '';
            $month ='';
            $completedBeforeTargetDate ='';
        }

        $retJson['status'] = 'OK';

        try {

            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();

            //Query 1: Attempt to insert the payment record into our database.
            $sql = 'INSERT INTO "TblServiceCase" ("parentCaseNo","caseVersion","serviceTypeId","problemTypeId","idrOrderId","incidentDate","requestDate","requestedBy","clpPersonDepartment","clpReferredById","customerName","customerGroup"';
            $sql = $sql . ',"businessTypeId","clpNetwork","contactPersonName","contactPersonTitle","contactPersonNumber","actionBy","customerContactedDate","requestedVisitDate","actualVisitDate","serviceStartDate"';
            $sql = $sql . ',"serviceCompletionDate","plannedReportIssueDate","actualReportIssueDate","actualReportWorkingDay","actualResponseDay","actualWorkingDay","caseReferredToClpe","serviceStatusId","mp","g"';
            $sql = $sql . ',"t","eicId","costTypeId","costUnit","costTotal","partyToBeChargedId","plantTypeId","manufacturerBrand","majorAffectedElementId","plantRating"';
            $sql = $sql . ',"customerProblem","actionAndFinding","recommendation","remark","requiredFollowUp","implementedSolution","proposedSolution","projectRegion","projectAddress","active","createdBy","createdTime","lastUpdatedBy"';
            $sql = $sql . ',"lastUpdatedTime","countYear","countMonth","completedBeforeTargetDate","startYear","startMonth","incidentId","planningAheadId")';
            $sql = $sql . ' VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
            //$stmt = $pdo->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array(
               $parentCaseNo,$caseVersion, $serviceType, $problemType, $idrOrderId, $incidentDateTime, $requestDateTime, $requestedBy, $clpPersonDepartment, $clpReferredBy, $customerName, $customerGroup
                , $businessType, $clpNetwork, $contactPerson, $title, $contactNo, $actionBy, $customerContactedDate, $requestedVisitDate, $actualVisitDate, $serviceStartDate
                , $serviceCompletionDate, $plannedReportIssueDate, $actualReportIssueDate, $actualReportWorkingDay, $actualResponseDay, $actualWorkingDay, $caseReferredToClpe, $serviceStatus, $manPowerMP, $manPowerG
                , $manPowerT, $reportedByEic, $unitRate, $unit, $total, $partyToBeCharged, $plantType, $manufacturerBrand, $majorAffectedElement, $plantRating
                , $customerProblems, $actionsAndFinding, $recommendation, $remark, $requiredFollowUp, $implementedSolution,$proposedSolution,$projectRegion,$projectAddress,$active, $createdBy, $createdTime, $lastUpdatedBy
                , $lastUpdatedTime, $year, $month,$completedBeforeTargetDate,$startYear,$startMonth,$incidentId,$planningAheadId));
            
            /*
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            */
            $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
            //$stmt = $pdo->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);
            $stmt->execute(array(
                $lastUpdatedTime,
            )
            );

            //Query 2: Attempt to update the user's profile.
            /*    $sql = "UPDATE users SET credit = credit + ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
            $paymentAmount,
            $userId
            )
            ); */

            //We've got this far without an exception, so commit the changes.
            //$pdo->commit();
            $transaction->commit();
        }
        //Our catch block will handle any exceptions that are thrown.
         catch (PDOException $e) {

            //An exception has occured, which means that one of our database queries
            //failed.
            //Print out the error message.
            $retJson['status'] = 'NOTOK';
            $retJson['retMessage'] = $e->getMessage();
            //Rollback the transaction.
            //$pdo->rollBack();
            $transaction->rollBack();
        }

        echo json_encode($retJson);
    }
    public function actionAjaxUpdateCaseForm()
    {
        $caseFormReporStartDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormReporStartDay');
        $caseFormReporEndDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormReporEndDay');
        $caseFormContactedDateToCompletionDateWorkingDayForEnquiry = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormContactedDateToCompletionDateWorkingDayForEnquiry');
        $caseFormContactedDateToCompletionDateWorkingDayForEnquiryResponseToCustomer = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormContactedDateToCompletionDateWorkingDayForEnquiryResponseToCustomer');
        $caseFormPlannedToActualReportIssueWorkingDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormPlannedToActualReportIssueWorkingDay');
        $caseNo = isset($_POST['txCaseNo']) ? $_POST['txCaseNo'] : '';

        
        if ($_POST['txCaseVersion'] == '') {
            $caseVersion = null;
        } else {
            $caseVersion = trim($_POST['txCaseVersion']);
        }
        if ($_POST['txParentCaseNo'] == '') {
            $parentCaseNo = null;
        } else {
            $parentCaseNo = trim($_POST['txParentCaseNo']);
            $checkCaseExistFlag = Yii::app()->formDao->getCaseFormByParentCaseNoAndCaseVersion($parentCaseNo,$caseVersion);
            if($checkCaseExistFlag['serviceCaseId']!= null && $checkCaseExistFlag['serviceCaseId'] != $caseNo){
                $retJson['status'] = 'NOTOK';
                $retJson['retMessage'] = 'Case No and Version Already Exist ';
                echo json_encode($retJson);
                return;
            }
        }

        if ($_POST['txServiceType'] == '') {
            $serviceType = null;
        } else {
            $serviceType = trim($_POST['txServiceType']);
        }
        if ($_POST['txProblemType'] == '') {
            $problemType = null;
        } else {
            $problemType = trim($_POST['txProblemType']);
        }
        if ($_POST['txIdrOrderId'] == '') {
            $idrOrderId = null;
        } else {
            $idrOrderId = trim($_POST['txIdrOrderId']);
        }
        if ($_POST['txIncidentId'] == '') {
            $incidentId = null;
        } else {
            $incidentId = trim($_POST['txIncidentId']);
        }
        if ($_POST['txIncidentDate'] == '') {
            $incidentDate = null;
        } else {
            $incidentDate = trim($_POST['txIncidentDate']);
        }
        if ($_POST['txIncidentTime'] == '') {
            $incidentTime = null;
        } else {
            $incidentTime = trim($_POST['txIncidentTime']);
        }
        if ($incidentDate == null) {
            $incidentDateTime = null;
        } else {
            $incidentDateTime = $incidentDate . ' ' . $incidentTime;
        }

        if ($_POST['txRequestDate'] == '') {
            $requestDate = null;
        } else {
            $requestDate = trim($_POST['txRequestDate']);
        }
        if ($_POST['txRequestTime'] == '') {
            $requestTime = null;
        } else {
            $requestTime = trim($_POST['txRequestTime']);
        }
        if ($requestDate == null) {
            $requestDateTime = null;
        } else {
            $requestDateTime = $requestDate . ' ' . $requestTime;
        }
        $clpPersonDepartment = isset($_POST['txClpPersonDepartment']) ? trim($_POST['txClpPersonDepartment']) : '';
        $requestedBy = isset($_POST['txRequestedBy']) ? trim($_POST['txRequestedBy']) : '';
        if ($_POST['txClpReferredBy'] == '') {
            $clpReferredBy = null;
        } else {
            $clpReferredBy = trim($_POST['txClpReferredBy']);
        }
        $customerName = isset($_POST['txCustomerName']) ? trim($_POST['txCustomerName']) : '';
        $customerGroup = isset($_POST['txCustomerGroup']) ? trim($_POST['txCustomerGroup']) : '';
        if ($_POST['txBusinessType'] == '') {
            $businessType = null;
        } else {
            $businessType = trim($_POST['txBusinessType']);
        }
        $clpNetwork = isset($_POST['txClpNetwork']) ? trim($_POST['txClpNetwork']) : '';

        $contactPerson = isset($_POST['txContactPerson']) ? trim($_POST['txContactPerson']) : '';
        $title = isset($_POST['txTitle']) ? trim($_POST['txTitle']) : '';
        if ($_POST['txContactNo'] == '') {
            $contactNo = null;
        } else {
            $contactNo = trim($_POST['txContactNo']);
        }
        $actionBy = isset($_POST['txActionBy']) ? trim($_POST['txActionBy']) : '';
        if ($_POST['txCustomerContactedDate'] == '') {
            $customerContactedDate = null;
        } else {
            $customerContactedDate = trim($_POST['txCustomerContactedDate']);
        }
        $caseReferredToClpe = isset($_POST['txCaseReferredToClpe']) ? trim($_POST['txCaseReferredToClpe']) : '';

        if ($_POST['txServiceStatus'] == '') {
            $serviceStatus = null;
        } else {
            $serviceStatus = trim($_POST['txServiceStatus']);
        }
        if ($_POST['txRequestedVisitDate'] == '') {
            $requestedVisitDate = null;
        } else {
            $requestedVisitDate = trim($_POST['txRequestedVisitDate']);
        }

        if ($_POST['txActualVisitDate'] == '') {
            $actualVisitDate = null;
        } else {
            $actualVisitDate = trim($_POST['txActualVisitDate']);
        }

        if ($_POST['txServiceStartDate'] == '') {
            $serviceStartDate = null;
        } else {
            $serviceStartDate = trim($_POST['txServiceStartDate']);
        }
        if ($_POST['txServiceCompletionDate'] == '') {
            $serviceCompletionDate = null;
        } else {
            $serviceCompletionDate = trim($_POST['txServiceCompletionDate']);
        }
        if ($_POST['txPlannedReportIssueDate'] == '') {
            $plannedReportIssueDate = null;
        } else {
            $plannedReportIssueDate = trim($_POST['txPlannedReportIssueDate']);
        }
        if ($_POST['txActualReportIssueDate'] == '') {
            $actualReportIssueDate = null;
        } else {
            $actualReportIssueDate = trim($_POST['txActualReportIssueDate']);
        }
        if ($_POST['txActualReportWorkingDay'] == '') {
            $actualReportWorkingDay = null;
        } else {
            $actualReportWorkingDay = trim($_POST['txActualReportWorkingDay']);
        }
        if ($_POST['txActualResponseDay'] == '') {
            $actualResponseDay = null;
        } else {
            $actualResponseDay = trim($_POST['txActualResponseDay']);
        }
        if ($_POST['txActualWorkingDay'] == '') {
            $actualWorkingDay = null;
        } else {
            $actualWorkingDay = trim($_POST['txActualWorkingDay']);
        }
        if ($_POST['txManPowerMP'] == '') {
            $manPowerMP = null;
        } else {
            $manPowerMP = trim($_POST['txManPowerMP']);
        }
        if ($_POST['txManPowerG'] == '') {
            $manPowerG = null;
        } else {
            $manPowerG = trim($_POST['txManPowerG']);
        }
        if ($_POST['txManPowerT'] == '') {
            $manPowerT = null;
        } else {
            $manPowerT = trim($_POST['txManPowerT']);
        }
        if ($_POST['txReportedByEic'] == '') {
            $reportedByEic = null;
        } else {
            $reportedByEic = trim($_POST['txReportedByEic']);
        }

        if ($_POST['txUnitRate'] == '') {
            $unitRate = null;
        } else {
            $unitRate = trim($_POST['txUnitRate']);
        }
        if ($_POST['txUnit'] == '') {
            $unit = null;
        } else {
            $unit = trim($_POST['txUnit']);
        }
        if ($_POST['txTotal'] == '') {
            $total = null;
        } else {
            $total = trim($_POST['txTotal']);
        }
        if ($_POST['txPartyToBeCharged'] == '') {
            $partyToBeCharged = null;
        } else {
            $partyToBeCharged = trim($_POST['txPartyToBeCharged']);
        }

        if ($_POST['txPlantType'] == '') {
            $plantType = null;
        } else {
            $plantType = trim($_POST['txPlantType']);
        }
        $manufacturerBrand = isset($_POST['txManufacturerBrand']) ? trim($_POST['txManufacturerBrand']) : '';
        if ($_POST['txMajorAffectedElement'] == '') {
            $majorAffectedElement = null;
        } else {
            $majorAffectedElement = trim($_POST['txMajorAffectedElement']);
        }
        $plantRating = isset($_POST['txPlantRating']) ? trim($_POST['txPlantRating']) : '';
        $customerProblems = isset($_POST['txCustomerProblems']) ? trim($_POST['txCustomerProblems']) : '';
        $actionsAndFinding = isset($_POST['txActionsAndFinding']) ? trim($_POST['txActionsAndFinding']) : '';
        $recommendation = isset($_POST['txRecommendation']) ? trim($_POST['txRecommendation']) : '';
        $remark = isset($_POST['txRemark']) ? trim($_POST['txRemark']) : '';
        $requiredFollowUp = isset($_POST['txRequiredFollowUp']) ? 1 : 0;
        $implementedSolution = isset($_POST['txImplementedSolution']) ? trim($_POST['txImplementedSolution']) : '';
        $proposedSolution = isset($_POST['txProposedSolution']) ? trim($_POST['txProposedSolution']) : '';
        $projectRegion = isset($_POST['txProjectRegion']) ? trim($_POST['txProjectRegion']) : '';
        $projectAddress = isset($_POST['txProjectAddress']) ? trim($_POST['txProjectAddress']) : '';
        $active = isset($_POST['txActive']) ? trim($_POST['txActive']) : '';
        $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
        $lastUpdatedTime = date("Y-m-d H:i");
        if ($_POST['txPlanningAheadId'] == '') {
            $planningAheadId = null;
        } else {
            $planningAheadId = trim($_POST['txPlanningAheadId']);
        }
        //start Month and start Year
        $startYear= null;
        $startMonth = null;
        if($customerContactedDate!=null){
            $caseStartYear = date('Y', strtotime($customerContactedDate));
            $caseStartMonth = date('m', strtotime($customerContactedDate));
            $caseStartDay = date('d', strtotime($customerContactedDate));
            $startYear = $caseStartYear;
            if($caseStartDay>$caseFormReporStartDay["configValue"]){
                if ($caseStartMonth == 12) {
                    $startMonth = 1;
                    $startYear = $caseStartYear+1;
                }
                else{
                    $startMonth = $caseStartMonth+1;
                }
            }
            else{
                $startMonth = $caseStartMonth;
            }
        }
        //count Month and Count Year
        $year = null;
        $month = null;
        $completedBeforeTargetDate = null;
        if (($serviceType == 3 || $serviceType == 4) && ($actualReportIssueDate != null)) {
            $reportEndDate = date('d/m/Y', strtotime($actualReportIssueDate));
            $reportEndYear = date('Y', strtotime($actualReportIssueDate));
            $reportEndMonth = date('m', strtotime($actualReportIssueDate));
            $reportEndDay = date('d', strtotime($actualReportIssueDate));
            $DeadLine = date('d/m/Y', strtotime($caseFormReporEndDay["configValue"] . '/' . $reportEndMonth . '/' . $reportEndYear));
            $year = $reportEndYear;
            if ($reportEndDay > $caseFormReporEndDay["configValue"]) {
                if ($reportEndMonth == 12) {
                    $month = 1;
                    $year = $reportEndYear + 1;
                } else {
                    $month = $reportEndMonth + 1;
                }
            } else {
                $month = $reportEndMonth;
            }
            if ($actualReportWorkingDay != null) {
                if($actualReportWorkingDay> $caseFormPlannedToActualReportIssueWorkingDay['configValue']) {
                    $completedBeforeTargetDate = 'N';
                } else {
                    $completedBeforeTargetDate = 'Y';
                }
            }
            else{
                $completedBeforeTargetDate ='';
            }
        } elseif (($serviceType != 3 && $serviceType != 4) && ($serviceCompletionDate != null)) {
            $reportEndDate = date('d/m/Y', strtotime($serviceCompletionDate));
            $reportEndYear = date('Y', strtotime($serviceCompletionDate));
            $reportEndMonth = date('m', strtotime($serviceCompletionDate));
            $reportEndDay = date('d', strtotime($serviceCompletionDate));
            $DeadLine = date('d/m/Y', strtotime($caseFormReporEndDay["configValue"] . '/' . $reportEndMonth . '/' . $reportEndYear));
            $year = $reportEndYear;
            if ($reportEndDay > $caseFormReporEndDay["configValue"]) {
                if ($reportEndMonth == 12) {
                    $month = 1;
                    $year = $reportEndYear + 1;
                } else {
                    $month = $reportEndMonth + 1;
                }
            } else {
                $month = $reportEndMonth;
            }

            if ($actualWorkingDay != null) {
                if($serviceType !=16){
                    if ($actualWorkingDay > $caseFormContactedDateToCompletionDateWorkingDayForEnquiry['configValue']) {
                    $completedBeforeTargetDate = 'N';
                    } else {
                    $completedBeforeTargetDate = 'Y';
                    }
                }
                else{
                    if ($actualWorkingDay > $caseFormContactedDateToCompletionDateWorkingDayForEnquiryResponseToCustomer['configValue']) {
                        $completedBeforeTargetDate = 'N';
                        } else {
                        $completedBeforeTargetDate = 'Y';
                        }
                }
                
            }
            else{
                $completedBeforeTargetDate ='';
            }
        }
        else{
            $year = '';
            $month ='';
            $completedBeforeTargetDate ='';
        }

        $retJson['status'] = 'OK';

        try {

            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();

            //Query 1: Attempt to insert the payment record into our database.
            $sql = 'UPDATE "TblServiceCase" SET "parentCaseNo" =? ,"caseVersion" =? ,"serviceTypeId" =? ,"problemTypeId" =? ,"idrOrderId" =? ,"incidentDate" =? ,"requestDate" =? ,"requestedBy" =? ,"clpPersonDepartment" =? ,"clpReferredById" =? ,"customerName" =? ,"customerGroup" =? ';
            $sql = $sql . ',"businessTypeId" =? ,"clpNetwork" =? ,"contactPersonName" =? ,"contactPersonTitle" =? ,"contactPersonNumber" =? ,"actionBy" =? ,"customerContactedDate" =? ,"requestedVisitDate" =? ,"actualVisitDate" =? ,"serviceStartDate" =? ';
            $sql = $sql . ',"serviceCompletionDate" =? ,"plannedReportIssueDate" =? ,"actualReportIssueDate" =? ,"actualReportWorkingDay" =? ,"actualResponseDay" =? ,"actualWorkingDay" =? ,"caseReferredToClpe"=?,"serviceStatusId" =? ,"mp" =? ,"g" =? ';
            $sql = $sql . ',"t" =? ,"eicId" =? ,"costTypeId" =? ,"costUnit" =?,"costTotal"=?,"partyToBeChargedId" =? ,"plantTypeId" =? ,"manufacturerBrand" =? ,"majorAffectedElementId" =? ,"plantRating" =? ';
            $sql = $sql . ',"customerProblem" =? ,"actionAndFinding" =? ,"recommendation" =? ,"remark" =? ,"requiredFollowUp" =? ,"implementedSolution" =?, "proposedSolution"=?,"projectRegion"=?,"projectAddress"=? ,"active" =?,"lastUpdatedBy"=?,"lastUpdatedTime"=?,"countYear" =?,"countMonth"=?,"completedBeforeTargetDate"=?,"startYear"=?,"startMonth"=?,"incidentId"=?,"planningAheadId"=?';
            $sql = $sql . ' WHERE "serviceCaseId" = ?';
            //$stmt = $pdo->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array(
                $parentCaseNo,$caseVersion,$serviceType, $problemType, $idrOrderId, $incidentDateTime, $requestDateTime, $requestedBy, $clpPersonDepartment, $clpReferredBy, $customerName, $customerGroup
                , $businessType, $clpNetwork, $contactPerson, $title, $contactNo, $actionBy, $customerContactedDate, $requestedVisitDate, $actualVisitDate, $serviceStartDate
                , $serviceCompletionDate, $plannedReportIssueDate, $actualReportIssueDate, $actualReportWorkingDay, $actualResponseDay, $actualWorkingDay, $caseReferredToClpe, $serviceStatus, $manPowerMP, $manPowerG
                , $manPowerT, $reportedByEic, $unitRate, $unit, $total, $partyToBeCharged, $plantType, $manufacturerBrand, $majorAffectedElement, $plantRating
                , $customerProblems, $actionsAndFinding, $recommendation, $remark, $requiredFollowUp, $implementedSolution, $proposedSolution, $projectRegion, $projectAddress, $active, $lastUpdatedBy, $lastUpdatedTime, $year, $month, $completedBeforeTargetDate,$startYear,$startMonth,$incidentId,$planningAheadId
                , $caseNo));
            /*
            if (!$result) {
                throw new Exception($stmt->errorInfo()[2], $stmt->errorInfo()[1]);

            }
            */
            $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
            //$stmt = $pdo->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);
            $stmt->execute(array(
                $lastUpdatedTime,
            )
            );
            //Query 2: Attempt to update the user's profile.
            /*    $sql = "UPDATE users SET credit = credit + ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
            $paymentAmount,
            $userId
            )
            ); */

            //We've got this far without an exception, so commit the changes.
            //$pdo->commit();
            $transaction->commit();
        }
        //Our catch block will handle any exceptions that are thrown.
         catch (PDOException $e) {

            //An exception has occured, which means that one of our database queries
            //failed.
            //Print out the error message.
            $retJson['status'] = 'NOTOK';
            $retJson['retMessage'] = $e->getMessage();
            //Rollback the transaction.
            //$pdo->rollBack();
            $transaction->rollBack();
        }

        echo json_encode($retJson);
    }

    public function actionAjaxMigrateCaseForm()
    {
        $caseFormReporStartDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormReporStartDay');
        $caseFormReporEndDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormReporEndDay');
        $caseFormContactedDateToCompletionDateWorkingDayForEnquiry = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormContactedDateToCompletionDateWorkingDayForEnquiry');
        $caseFormContactedDateToCompletionDateWorkingDayForEnquiryResponseToCustomer = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormContactedDateToCompletionDateWorkingDayForEnquiryResponseToCustomer');
        $caseFormPlannedToActualReportIssueWorkingDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormPlannedToActualReportIssueWorkingDay');
        $retJson['status'] = 'OK';
        try {
            $sql = " SELECT 
            sct.\"serviceCaseId\",
            sct.\"parentCaseNo\",
            sct.\"CaseVersion\",
            CASE WHEN sct.\"serviceTypeId\" = 'Checkup' THEN 11 WHEN sct.\"serviceTypeId\" = 'Enquiry' THEN 1 WHEN sct.\"serviceTypeId\" = 'Investigation' THEN 3 WHEN sct.\"serviceTypeId\" = 'Others' THEN 12 WHEN sct.\"serviceTypeId\" = 'Reachout' THEN 5 WHEN sct.\"serviceTypeId\" = 'Site Visit' THEN 2 END as \"serviceTypeId\",
            pt.\"problemTypeId\",
            sct.\"idrOrderId\",
            sct.\"incidentDate\",
            sct.\"requestDate\",
            sct.\"requestedBy\",
            sct.\"clpPersonDepartment\",
            crb.\"clpReferredById\",
            sct.\"customerName\",
            sct.\"customerGroup\",
            bt.\"businessTypeId\",
            sct.\"clpNetwork\",
            sct.\"contactPersonName\",
            sct.\"contactPersonTitle\",
            sct.\"contactPersonNumber\",
            ab.\"actionById\",
            sct.\"customerContactedDate\",
            sct.\"requestedVisitDate\",
            sct.\"caseReferredToClpe\",
            ss.\"serviceStatusId\",
            sct.\"actualVisitDate\",
            sct.\"serviceStartDate\",
            sct.\"serviceCompletionDate\",
            sct.\"plannedReportIssueDate\",
            sct.\"actualReportIssueDate\",
            sct.\"actualReportWorkingDay\",
            sct.\"actualResponseDay\",
            sct.\"actualWorkingDay\",
            sct.\"mp\",
            sct.\"g\",
            sct.\"t\",
            e.\"eicId\",
            sct.\"costTypeId\",
            sct.\"costUnit\",
            sct.\"costTotal\",
            ptc.\"partyToBeChargedId\",
            ptt.\"plantTypeId\",
            sct.\"manufacturerBrand\",
            mae.\"majorAffectedElementId\",
            sct.\"plantRating\",
            sct.\"customerProblem\",
            sct.\"actionAndFinding\",
            sct.\"recommendation\",
            sct.\"remark\",
            sct.\"requiredFollowUp\",
            sct.\"implementedSolution\",
            sct.\"createdBy\",
            sct.\"createdTime\",
            sct.\"lastUpdatedBy\",
            sct.\"lastUpdatedtime\",
            sct.\"active\"
            From (((((((((\"serviceCaseTemp\" sct LEFT JOIN \"TblProblemType\" pt ON sct.\"problemTypeId\" = pt.\"problemTypeName\" ) LEFT JOIN \"TblClpReferredBy\" crb ON sct.\"clpReferredById\" = crb.\"clpReferredByName\" ) LEFT JOIN \"TblBusinessType\" bt ON sct.\"businessTypeId\" = bt.\"businessTypeName\") LEFT JOIN \"TblActionBy\" ab ON sct.\"actionBy\" = ab.\"actionByName\") LEFT JOIN \"TblServiceStatus\" ss ON sct.\"serviceStatusId\" = ss.\"serviceStatusName\") LEFT JOIN \"TblEic\" e ON sct.\"eicId\" = e.\"eicName\") LEFT JOIN \"TblPartyToBeCharged\" ptc ON sct.\"partyToBeChargedId\" = ptc.\"partyToBeChargedName\" )  LEFT JOIN \"TblPlantType\" ptT on sct.\"plantTypeId\" = ptt.\"plantTypeName\" ) LEFT JOIN \"TblMajorAffectedElement\" mae ON sct.\"majorAffectedElementId\" = mae.\"majorAffectedElementName\")
             ";
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

           // $sth->bindParam(':serviceCaseId', $serviceCaseId);
           /*
            $result= $sth->execute();
            if(!$result){
				throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
				
            }
            */
            $result = $sth->queryAll();
            $caseFormList = array();
            //while($row = $sth->fetch(PDO::FETCH_ASSOC)){
            foreach($result as $row) {     
            $caseForm['serviceCaseId'] = $row['serviceCaseId'];
            $caseForm['parentCaseNo'] = $row['parentCaseNo'];
            $caseForm['caseVersion'] = $row['caseVersion'];
            $caseForm['serviceTypeId'] = $row['serviceTypeId'];
            $caseForm['problemTypeId'] = $row['problemTypeId'];
            $caseForm['idrOrderId'] = $row['idrOrderId'];
            $caseForm['incidentDate'] = isset($row['incidentDate']) ? date('Y-m-d', strtotime($row['incidentDate'])) : null;
            $caseForm['incidentDateTime'] = isset($row['incidentDate']) ? date('H:i', strtotime($row['incidentDate'])) : null;
            $caseForm['requestDate'] = isset($row['requestDate']) ? date('Y-m-d', strtotime($row['requestDate'])) : null;
            $caseForm['requestDateTime'] = isset($row['requestDate']) ? date('H:i', strtotime($row['requestDate'])) : null;
            $caseForm['requestedBy'] = Encoding::escapleAllCharacter($row['requestedBy']);  
            $caseForm['clpPersonDepartment'] = Encoding::escapleAllCharacter($row['clpPersonDepartment']);  
            $caseForm['clpReferredById'] = $row['clpReferredById'];
            $caseForm['customerName'] = Encoding::escapleAllCharacter($row['customerName']); 
            $caseForm['customerGroup'] = Encoding::escapleAllCharacter($row['customerGroup']);  
            $caseForm['businessTypeId'] = $row['businessTypeId'];
            $caseForm['clpNetwork'] = $row['clpNetwork'];
            $caseForm['contactPersonName'] = Encoding::escapleAllCharacter($row['contactPersonName']);  
            $caseForm['contactPersonTitle'] = Encoding::escapleAllCharacter($row['contactPersonTitle']);  
            $caseForm['contactPersonNumber'] = $row['contactPersonNumber'];
            $caseForm['actionBy'] = $row['actionById'];
            $caseForm['customerContactedDate'] = isset($row['customerContactedDate']) ? date('Y-m-d', strtotime($row['customerContactedDate'])) : null;
            $caseForm['requestedVisitDate'] = isset($row['requestedVisitDate']) ? date('Y-m-d', strtotime($row['requestedVisitDate'])) : null;
            $caseForm['actualVisitDate'] = isset($row['actualVisitDate']) ? date('Y-m-d', strtotime($row['actualVisitDate'])) : null;
            $caseForm['serviceStartDate'] = isset($row['serviceStartDate']) ? date('Y-m-d', strtotime($row['serviceStartDate'])) : null;
            $caseForm['serviceCompletionDate'] = isset($row['serviceCompletionDate']) ? date('Y-m-d', strtotime($row['serviceCompletionDate'])) : null;
            $caseForm['plannedReportIssueDate'] = isset($row['plannedReportIssueDate']) ? date('Y-m-d', strtotime($row['plannedReportIssueDate'])) : null;
            $caseForm['actualReportIssueDate'] = isset($row['actualReportIssueDate']) ? date('Y-m-d', strtotime($row['actualReportIssueDate'])) : null;
            $caseForm['actualReportWorkingDay'] = $row['actualReportWorkingDay'];
            $caseForm['actualResponseDay'] = $row['actualResponseDay'];
            $caseForm['actualWorkingDay'] = $row['actualWorkingDay'];
            $caseForm['caseReferredToClpe'] = $row['caseReferredToClpe'];
            $caseForm['serviceStatusId'] = $row['serviceStatusId'];
            $caseForm['mp'] = $row['mp'];
            $caseForm['g'] = $row['g'];
            $caseForm['t'] = $row['t'];
            $caseForm['eicId'] = $row['eicId'];
            $caseForm['costTypeId'] = $row['costTypeId'];
            $caseForm['costUnit'] = $row['costUnit'];
            $caseForm['costTotal'] = $row['costTotal'];
            $caseForm['partyToBeChargedId'] = $row['partyToBeChargedId'];
            $caseForm['plantTypeId'] = $row['plantTypeId'];
            $caseForm['active'] = $row['active'];
            $caseForm['manufacturerBrand'] = $row['manufacturerBrand'];
            $caseForm['majorAffectedElementId'] = $row['majorAffectedElementId'];
            $caseForm['plantRating'] = $row['plantRating'];
            $caseForm['customerProblem'] = Encoding::escapleAllCharacter($row['customerProblem']);  
            $caseForm['actionAndFinding'] = Encoding::escapleAllCharacter($row['actionAndFinding']);  
            $caseForm['recommendation'] = Encoding::escapleAllCharacter($row['recommendation']);  
            $caseForm['remark'] = Encoding::escapleAllCharacter($row['remark']);  
            $caseForm['requiredFollowUp'] = $row['requiredFollowUp'];
            $caseForm['implementedSolution'] = Encoding::escapleAllCharacter($row['implementedSolution']);  
            array_push($caseFormList, $caseForm);
            }
        
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        
        

        $retJson['status'] = 'OK';

        try {
            
            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();
            foreach($caseFormList as $row){
            $serviceCaseId = $row['serviceCaseId']!='NULL'? $row['serviceCaseId']: null;
            $parentCaseNo = $row['parentCaseNo']!='NULL'? $row['parentCaseNo']: null;
            $caseVersion = $row['caseVersion']!='NULL'? $row['caseVersion']: null;
            $serviceType = $row['serviceTypeId']!='NULL'? $row['serviceTypeId']: null;
            $problemType = $row['problemTypeId']!='NULL'? $row['problemTypeId']: null;
            $idrOrderId = $row['idrOrderId']!='NULL'? $row['idrOrderId']: null;
            $incidentDateTime = $row['incidentDate'];
            $requestDateTime = $row['requestDate'];
            $requestedBy = Encoding::escapleAllCharacter($row['requestedBy']);  
            $clpPersonDepartment = Encoding::escapleAllCharacter($row['clpPersonDepartment']);  
            $clpReferredBy = $row['clpReferredById'];
            $customerName = Encoding::escapleAllCharacter($row['customerName']); 
            $customerGroup = Encoding::escapleAllCharacter($row['customerGroup']);  
            $businessTypeId = $row['businessTypeId'];
            $clpNetwork = $row['clpNetwork'];
            $contactPersonName = Encoding::escapleAllCharacter($row['contactPersonName']);  
            $contactPersonTitle = Encoding::escapleAllCharacter($row['contactPersonTitle']);  
            $contactPersonNumber = $row['contactPersonNumber'];
            $actionBy = $row['actionBy']!='NULL'? $row['actionBy']: null;
            $customerContactedDate = $row['customerContactedDate'];
            $requestedVisitDate = $row['requestedVisitDate'];
            $actualVisitDate = $row['actualVisitDate'];
            $serviceStartDate = $row['serviceStartDate'];
            $serviceCompletionDate = $row['serviceCompletionDate'];
            $plannedReportIssueDate = $row['plannedReportIssueDate'];
            $actualReportIssueDate = $row['actualReportIssueDate'];
            $actualReportWorkingDay = ($row['actualReportWorkingDay']!='NULL')? $row['actualReportWorkingDay']: null ;
            $actualResponseDay = ($row['actualResponseDay']!='NULL')? $row['actualResponseDay']: null ;
            $actualWorkingDay = ($row['actualWorkingDay']!='NULL')? $row['actualWorkingDay']: null;
            $caseReferredToClpe = $row['caseReferredToClpe']!='NULL'? $row['caseReferredToClpe']: null;
            $serviceStatusId = $row['serviceStatusId']!='NULL'? $row['serviceStatusId']: null;
            $mp = $row['mp']!='NULL'? $row['mp']: null;
            $g =  $row['g']!='NULL'? $row['g']: null;
            $t =  $row['t']!='NULL'? $row['t']: null;
            $eicId = $row['eicId']!='NULL'? $row['eicId']: null;
            $costTypeId = $row['costTypeId']!='NULL'? $row['costTypeId']: null;
            $costUnit = $row['costUnit']!='NULL'? $row['costUnit']: null;
            $costTotal = $row['costTotal']!='NULL'? $row['costTotal']: null;
            $partyToBeChargedId = $row['partyToBeChargedId']!='NULL'? $row['partyToBeChargedId']: null;
            $plantTypeId = $row['plantTypeId']!='NULL'? $row['plantTypeId']: null;
            $active = $row['active'];
            $manufacturerBrand = $row['manufacturerBrand'];
            $majorAffectedElementId = $row['majorAffectedElementId']!='NULL'? $row['majorAffectedElementId']: null;
            $plantRating = $row['plantRating'];
            $customerProblem = Encoding::escapleAllCharacter($row['customerProblem']);  
            $actionAndFinding = Encoding::escapleAllCharacter($row['actionAndFinding']);  
            $recommendation = Encoding::escapleAllCharacter($row['recommendation']);  
            $remark = Encoding::escapleAllCharacter($row['remark']);  
            $requiredFollowUp = $row['requiredFollowUp'];
            $implementedSolution = Encoding::escapleAllCharacter($row['implementedSolution']);  
            $createdBy = Yii::app()->session['tblUserDo']['username'];
            $createdTime = date("Y-m-d H:i");
            $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
            $lastUpdatedTime = date("Y-m-d H:i");

            //start Month and start Year
        $startYear= null;
        $startMonth = null;
        if($customerContactedDate!=null){
            $caseStartYear = date('Y', strtotime($customerContactedDate));
            $caseStartMonth = date('m', strtotime($customerContactedDate));
            $caseStartDay = date('d', strtotime($customerContactedDate));
            $startYear = $caseStartYear;
            if($caseStartDay>$caseFormReporStartDay["configValue"]){
                if ($caseStartMonth == 12) {
                    $startMonth = 1;
                    $startYear = $caseStartYear+1;
                }
                else{
                    $startMonth = $caseStartMonth+1;
                }
            }
            else{
                $startMonth = $caseStartMonth;

            }
        }
        //count Month and Count Year
        $year = null;
        $month = null;
        if (($serviceType == 3 || $serviceType == 4) && ($actualReportIssueDate != null)) {
            $reportEndDate = date('d/m/Y', strtotime($actualReportIssueDate));
            $reportEndYear = date('Y', strtotime($actualReportIssueDate));
            $reportEndMonth = date('m', strtotime($actualReportIssueDate));
            $reportEndDay = date('d', strtotime($actualReportIssueDate));
            $DeadLine = date('d/m/Y', strtotime($caseFormReporEndDay["configValue"] . '/' . $reportEndMonth . '/' . $reportEndYear));
            $year = $reportEndYear;
            if ($reportEndDay > $caseFormReporEndDay["configValue"]) {
                if ($reportEndMonth == 12) {
                    $month = 1;
                    $year = $reportEndYear + 1;
                } else {
                    $month = $reportEndMonth + 1;
                }
            } 
            else {
                $month = $reportEndMonth;
            }

            if ($actualReportWorkingDay != null) {
                if($actualReportWorkingDay> $caseFormPlannedToActualReportIssueWorkingDay['configValue']) {
                    $completedBeforeTargetDate = 'N';
                } else {
                    $completedBeforeTargetDate = 'Y';
                }
            }
            else{
                $completedBeforeTargetDate ='';
            }

        } elseif (($serviceType != 3 && $serviceType != 4) && ($serviceCompletionDate != null)) {
            $reportEndDate = date('d/m/Y', strtotime($serviceCompletionDate));
            $reportEndYear = date('Y', strtotime($serviceCompletionDate));
            $reportEndMonth = date('m', strtotime($serviceCompletionDate));
            $reportEndDay = date('d', strtotime($serviceCompletionDate));
            $DeadLine = date('d/m/Y', strtotime($caseFormReporEndDay["configValue"] . '/' . $reportEndMonth . '/' . $reportEndYear));
            $year = $reportEndYear;
            if ($reportEndDay > $caseFormReporEndDay["configValue"]) {
                if ($reportEndMonth == 12) {
                    $month = 1;
                    $year = $reportEndYear + 1;
                } else {
                    $month = $reportEndMonth + 1;
                }
            } else {
                $month = $reportEndMonth;
            }

            if ($actualWorkingDay != null) {
                if($serviceType !=16){
                    if ($actualWorkingDay > $caseFormContactedDateToCompletionDateWorkingDayForEnquiry['configValue']) {
                    $completedBeforeTargetDate = 'N';
                    } else {
                    $completedBeforeTargetDate = 'Y';
                    }
                }
                else{
                    if ($actualWorkingDay > $caseFormContactedDateToCompletionDateWorkingDayForEnquiryResponseToCustomer['configValue']) {
                        $completedBeforeTargetDate = 'N';
                        } else {
                        $completedBeforeTargetDate = 'Y';
                        }
                }
                
            }
            else{
                $completedBeforeTargetDate ='';
            }
        }
        else{
            $year = '';
            $month ='';
            $completedBeforeTargetDate ='';
        }
            //Query 1: Attempt to insert the payment record into our database.
            $sql = 'INSERT INTO "TblServiceCase" ("parentCaseNo","caseVersion","serviceTypeId","problemTypeId","idrOrderId","incidentDate","requestDate","requestedBy","clpPersonDepartment","clpReferredById","customerName","customerGroup"';
            $sql = $sql . ',"businessTypeId","clpNetwork","contactPersonName","contactPersonTitle","contactPersonNumber","actionBy","customerContactedDate","requestedVisitDate","actualVisitDate","serviceStartDate"';
            $sql = $sql . ',"serviceCompletionDate","plannedReportIssueDate","actualReportIssueDate","actualReportWorkingDay","actualResponseDay","actualWorkingDay","caseReferredToClpe","serviceStatusId","mp","g"';
            $sql = $sql . ',"t","eicId","costTypeId","costUnit","costTotal","partyToBeChargedId","plantTypeId","manufacturerBrand","majorAffectedElementId","plantRating"';
            $sql = $sql . ',"customerProblem","actionAndFinding","recommendation","remark","requiredFollowUp","implementedSolution","active","createdBy","createdTime","lastUpdatedBy"';
            $sql = $sql . ',"lastUpdatedTime","countYear","countMonth","completedBeforeTargetDate","startYear","startMonth")';
            $sql = $sql . ' VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
            //$stmt = $pdo->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array(
                $parentCaseNo,$caseVersion, $serviceType, $problemType, $idrOrderId, $incidentDateTime, $requestDateTime, $requestedBy, $clpPersonDepartment, $clpReferredBy, $customerName, $customerGroup
                , $businessTypeId, $clpNetwork, $contactPersonName, $contactPersonTitle, $contactPersonNumber, $actionBy, $customerContactedDate, $requestedVisitDate, $actualVisitDate, $serviceStartDate
                , $serviceCompletionDate, $plannedReportIssueDate, $actualReportIssueDate, $actualReportWorkingDay, $actualResponseDay, $actualWorkingDay, $caseReferredToClpe, $serviceStatusId, $mp, $g
                , $t, $eicId, $costTypeId, $costUnit, $costTotal, $partyToBeChargedId, $plantTypeId, $manufacturerBrand, $majorAffectedElementId, $plantRating
                , $customerProblem, $actionAndFinding, $recommendation, $remark, $requiredFollowUp, $implementedSolution, $active, $createdBy, $createdTime, $lastUpdatedBy
                , $lastUpdatedTime, $year, $month,$completedBeforeTargetDate,$startYear,$startMonth));
            /*
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            */
            $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
            //$stmt = $pdo->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);
            $stmt->execute(array(
                $lastUpdatedTime,
            )
            );

            //Query 2: Attempt to update the user's profile.
            /*    $sql = "UPDATE users SET credit = credit + ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
            $paymentAmount,
            $userId
            )
            ); */

            //We've got this far without an exception, so commit the changes.
           
            }
            //$pdo->commit();
            $transaction->commit();
        }
        //Our catch block will handle any exceptions that are thrown.
         catch (Exception $e) {

            //An exception has occured, which means that one of our database queries
            //failed.
            //Print out the error message.
            $retJson['status'] = 'NOTOK';
            $retJson['retMessage'] = $e->getMessage();
            //Rollback the transaction.
            //$pdo->rollBack();
            $transaction->rollBack();
        }

        echo json_encode($retJson);
    }

    public function actionAjaxGetPlanningAheadTable()
    {
        $param = json_decode(file_get_contents('php://input'), true);

        $searchParam = json_decode($param['searchParam'], true);
        $start = $param['start'];
        $length = $param['length'];
        $orderColumn = $param['order'][0]['column'];
        $orderDir = $param['order'][0]['dir'];
        $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

        $planningAheadList = Yii::app()->formDao->GetPlanningAheadSearchByPage($searchParam, $start, $length, $order);

        $recordFiltered = Yii::app()->formDao->GetPlanningAheadSearchResultCount($searchParam);

        $totalCount = Yii::app()->formDao->GetPlanningAheadRecordCount();

        $result = array('draw' => $param['draw'],
            'data' => $planningAheadList,
            'recordsFiltered' => $recordFiltered,
            'recordsTotal' => $totalCount);

        echo json_encode($result);

    }
    public function actionAjaxInsertPlanningAhead()
    {

        //$caseNo = isset($_POST['txCaseNo']) ? $_POST['txCaseNo'] : '';
        //project
        if ($_POST['txProjectRef'] == '') {
            $txProjectRef = null;
        } else {
            $txProjectRef = trim($_POST['txProjectRef']);
        }
        if ($_POST['txProjectTitle'] == '') {
            $txProjectTitle = null;
        } else {
            $txProjectTitle = trim($_POST['txProjectTitle']);
        }
        if ($_POST['txSchemeNumber'] == '') {
            $txSchemeNumber = null;
        } else {
            $txSchemeNumber = trim($_POST['txSchemeNumber']);
        }
        if ($_POST['txProjectRegion'] == '') {
            $txProjectRegion = null;
        } else {
            $txProjectRegion = trim($_POST['txProjectRegion']);
        }
        if ($_POST['txProjectAddress'] == '') {
            $txProjectAddress = null;
        } else {
            $txProjectAddress = trim($_POST['txProjectAddress']);
        }
        if ($_POST['txProjectAddressParentCaseNo'] == '') {
            $txProjectAddressParentCaseNo = null;
        } else {
            $txProjectAddressParentCaseNo = trim($_POST['txProjectAddressParentCaseNo']);
        }
        if ($_POST['txProjectAddressCaseVersion'] == '') {
            $txProjectAddressCaseVersion = null;
        } else {
            $txProjectAddressCaseVersion = trim($_POST['txProjectAddressCaseVersion']);
        }
        if ($_POST['txInputDate'] == '') {
            $txInputDate = null;
        } else {
            $txInputDate = trim($_POST['txInputDate']);
        }
        if ($_POST['txRegionLetterIssueDate'] == '') {
            $txRegionLetterIssueDate = null;
        } else {
            $txRegionLetterIssueDate = trim($_POST['txRegionLetterIssueDate']);
        }
        if ($_POST['txReportedBy'] == '') {
            $txReportedBy = null;
        } else {
            $txReportedBy = trim($_POST['txReportedBy']);
        }

     /*   if ($_POST['txLastUpdatedBy'] == '') {
            $txLastUpdatedBy = null;
        } else {
            $txLastUpdatedBy = trim($_POST['txLastUpdatedBy']);
        }
    */
    if ($_POST['txRegionPlanner'] == '') {
        $txRegionPlanner = null;
    } else {
        $txRegionPlanner = trim($_POST['txRegionPlanner']);
    }
        //type
        if ($_POST['txBuildingType'] == '') {
            $txBuildingType = null;
        } else {
            $txBuildingType = trim($_POST['txBuildingType']);
        }
        if ($_POST['txProjectType'] == '') {
            $txProjectType = null;
        } else {
            $txProjectType = trim($_POST['txProjectType']);
        }
        $txKeyinfrastructure = isset($_POST['txKeyinfrastructure']) ? 'Y' : 'N';
        $txPotentialSuccessfulCase = isset($_POST['txPotentialSuccessfulCase']) ? 'Y' : 'N';
        $txCriticalProject = isset($_POST['txCriticalProject']) ? 'Y' : 'N';
        $txTempSupplyProject = isset($_POST['txTempSupplyProject']) ? 'Y' : 'N';
        //equipment
        $txBms = isset($_POST['txBms']) ? 1 : 0;
        $txChangeoverScheme = isset($_POST['txChangeoverScheme']) ? 1 : 0;
        $txChillerPlant = isset($_POST['txChillerPlant']) ? 1 : 0;
        $txEscalator = isset($_POST['txEscalator']) ? 1 : 0;
        $txHidLamp = isset($_POST['txHidLamp']) ? 1 : 0;
        $txLift = isset($_POST['txLift']) ? 1 : 0;
        $txSensitiveMachine = isset($_POST['txSensitiveMachine']) ? 1 : 0;
        $txTelcom = isset($_POST['txTelcom']) ? 1 : 0;
        $txAcbTripping = isset($_POST['txAcbTripping']) ? 1 : 0;
        $txBuildingWithHighPenetrationEquipment = isset($_POST['txBuildingWithHighPenetrationEquipment']) ? 1 : 0;
        $txRe = isset($_POST['txRe']) ? 1 : 0;
        $txEv = isset($_POST['txEv']) ? 1 : 0;
        if ($_POST['txEstimatedLoad'] == '') {
            $txEstimatedLoad = null;
        } else {
            $txEstimatedLoad = trim($_POST['txEstimatedLoad']);
        }
        if ($_POST['txPqisNumber'] == '') {
            $txPqisNumber = null;
        } else {
            $txPqisNumber = trim($_POST['txPqisNumber']);
        }
        //pqwalk
        if ($_POST['txPqSiteWalkProjectRegion'] == '') {
            $txPqSiteWalkProjectRegion = null;
        } else {
            $txPqSiteWalkProjectRegion = trim($_POST['txPqSiteWalkProjectRegion']);
        }
        if ($_POST['txPqSiteWalkProjectAddress'] == '') {
            $txPqSiteWalkProjectAddress = null;
        } else {
            $txPqSiteWalkProjectAddress = trim($_POST['txPqSiteWalkProjectAddress']);
        }
        if ($_POST['txSensitiveEquipment'] == '') {
            $txSensitiveEquipment = null;
        } else {
            $txSensitiveEquipment = trim($_POST['txSensitiveEquipment']);
        }
        //pqwalk first walk
        if ($_POST['txFirstPqSiteWalkDate'] == '') {
            $txFirstPqSiteWalkDate = null;
        } else {
            $txFirstPqSiteWalkDate = trim($_POST['txFirstPqSiteWalkDate']);
        }
        if ($_POST['txFirstPqSiteWalkStatus'] == '') {
            $txFirstPqSiteWalkStatus = null;
        } else {
            $txFirstPqSiteWalkStatus = trim($_POST['txFirstPqSiteWalkStatus']);
        }
        if ($_POST['txFirstPqSiteWalkInvitationLetterLink'] == '') {
            $txFirstPqSiteWalkInvitationLetterLink = null;
        } else {
            $txFirstPqSiteWalkInvitationLetterLink = trim($_POST['txFirstPqSiteWalkInvitationLetterLink']);
        }
        if ($_POST['txFirstPqSiteWalkRequestLetterDate'] == '') {
            $txFirstPqSiteWalkRequestLetterDate = null;
        } else {
            $txFirstPqSiteWalkRequestLetterDate = trim($_POST['txFirstPqSiteWalkRequestLetterDate']);
        }
        if ($_POST['txPqWalkAssessmentReportDate'] == '') {
            $txPqWalkAssessmentReportDate = null;
        } else {
            $txPqWalkAssessmentReportDate = trim($_POST['txPqWalkAssessmentReportDate']);
        }
        if ($_POST['txPqWalkAssessmentReportLink'] == '') {
            $txPqWalkAssessmentReportLink = null;
        } else {
            $txPqWalkAssessmentReportLink = trim($_POST['txPqWalkAssessmentReportLink']);
        }
        if ($_POST['txFirstPqSiteWalkParentCaseNo'] == '') {
            $txFirstPqSiteWalkParentCaseNo = null;
        } else {
            $txFirstPqSiteWalkParentCaseNo = trim($_POST['txFirstPqSiteWalkParentCaseNo']);
        }
        if ($_POST['txFirstPqSiteWalkCaseVersion'] == '') {
            $txFirstPqSiteWalkCaseVersion = null;
        } else {
            $txFirstPqSiteWalkCaseVersion = trim($_POST['txFirstPqSiteWalkCaseVersion']);
        }
        if ($_POST['txFirstPqSiteWalkCustomerResponse'] == '') {
            $txFirstPqSiteWalkCustomerResponse = null;
        } else {
            $txFirstPqSiteWalkCustomerResponse = trim($_POST['txFirstPqSiteWalkCustomerResponse']);
        }
        if ($_POST['txFirstPqSiteWalkInvestigationStatus'] == '') {
            $txFirstPqSiteWalkInvestigationStatus = null;
        } else {
            $txFirstPqSiteWalkInvestigationStatus = trim($_POST['txFirstPqSiteWalkInvestigationStatus']);
        }
        if ($_POST['txSecondPqSiteWalkDate'] == '') {
            $txSecondPqSiteWalkDate = null;
        } else {
            $txSecondPqSiteWalkDate = trim($_POST['txSecondPqSiteWalkDate']);
        }
        if ($_POST['txSecondPqSiteWalkInvitationLetterLink'] == '') {
            $txSecondPqSiteWalkInvitationLetterLink = null;
        } else {
            $txSecondPqSiteWalkInvitationLetterLink = trim($_POST['txSecondPqSiteWalkInvitationLetterLink']);
        }
        if ($_POST['txSecondPqSiteWalkRequestLetterDate'] == '') {
            $txSecondPqSiteWalkRequestLetterDate = null;
        } else {
            $txSecondPqSiteWalkRequestLetterDate = trim($_POST['txSecondPqSiteWalkRequestLetterDate']);
        }
        if ($_POST['txPqAssessmentFollowUpReportDate'] == '') {
            $txPqAssessmentFollowUpReportDate = null;
        } else {
            $txPqAssessmentFollowUpReportDate = trim($_POST['txPqAssessmentFollowUpReportDate']);
        }
        if ($_POST['txPqAssessmentFollowupReportLink'] == '') {
            $txPqAssessmentFollowupReportLink = null;
        } else {
            $txPqAssessmentFollowupReportLink = trim($_POST['txPqAssessmentFollowupReportLink']);
        }
        if ($_POST['txSecondPqSiteWalkParentCaseNo'] == '') {
            $txSecondPqSiteWalkParentCaseNo = null;
        } else {
            $txSecondPqSiteWalkParentCaseNo = trim($_POST['txSecondPqSiteWalkParentCaseNo']);
        }
        if ($_POST['txSecondPqSiteWalkCaseVersion'] == '') {
            $txSecondPqSiteWalkCaseVersion = null;
        } else {
            $txSecondPqSiteWalkCaseVersion = trim($_POST['txSecondPqSiteWalkCaseVersion']);
        }
        if ($_POST['txSecondPqSiteWalkCustomerResponse'] == '') {
            $txSecondPqSiteWalkCustomerResponse = null;
        } else {
            $txSecondPqSiteWalkCustomerResponse = trim($_POST['txSecondPqSiteWalkCustomerResponse']);
        }
        if ($_POST['txSecondPqSiteWalkInvestigationStatus'] == '') {
            $txSecondPqSiteWalkInvestigationStatus = null;
        } else {
            $txSecondPqSiteWalkInvestigationStatus = trim($_POST['txSecondPqSiteWalkInvestigationStatus']);
        }
        //consultant information
        if ($_POST['txConsultantCompanyName'] == '') {
            $txConsultantCompanyName = null;
        } else {
            $txConsultantCompanyName = trim($_POST['txConsultantCompanyName']);
        }
        if ($_POST['txConsultantName'] == '') {
            $txConsultantName = null;
        } else {
            $txConsultantName = trim($_POST['txConsultantName']);
        }

        if ($_POST['txPhoneNumber1'] == '') {
            $txPhoneNumber1 = null;
        } else {
            $txPhoneNumber1 = trim($_POST['txPhoneNumber1']);
        }
        if ($_POST['txPhoneNumber2'] == '') {
            $txPhoneNumber2 = null;
        } else {
            $txPhoneNumber2 = trim($_POST['txPhoneNumber2']);
        }
        if ($_POST['txPhoneNumber3'] == '') {
            $txPhoneNumber3 = null;
        } else {
            $txPhoneNumber3 = trim($_POST['txPhoneNumber3']);
        }
        if ($_POST['txEmail1'] == '') {
            $txEmail1 = null;
        } else {
            $txEmail1 = trim($_POST['txEmail1']);
        }
        if ($_POST['txEmail2'] == '') {
            $txEmail2 = null;
        } else {
            $txEmail2 = trim($_POST['txEmail2']);
        }
        if ($_POST['txEmail3'] == '') {
            $txEmail3 = null;
        } else {
            $txEmail3 = trim($_POST['txEmail3']);
        }
        if ($_POST['txConsultantInformationRemark'] == '') {
            $txConsultantInformationRemark = null;
        } else {
            $txConsultantInformationRemark = trim($_POST['txConsultantInformationRemark']);
        }
        //consultant information status
        if ($_POST['txEstimatedCommisioningDateByCustomer'] == '') {
            $txEstimatedCommisioningDateByCustomer = null;
        } else {
            $txEstimatedCommisioningDateByCustomer = trim($_POST['txEstimatedCommisioningDateByCustomer']);
        }
        if ($_POST['txEstimatedCommisioningDateByRegion'] == '') {
            $txEstimatedCommisioningDateByRegion = null;
        } else {
            $txEstimatedCommisioningDateByRegion = trim($_POST['txEstimatedCommisioningDateByRegion']);
        }
        if ($_POST['txPlanningAheadStatus'] == '') {
            $txPlanningAheadStatus = null;
        } else {
            $txPlanningAheadStatus = trim($_POST['txPlanningAheadStatus']);
        }
        //replySlip
        if ($_POST['txInvitationToPaMeetingDate'] == '') {
            $txInvitationToPaMeetingDate = null;
        } else {
            $txInvitationToPaMeetingDate = trim($_POST['txInvitationToPaMeetingDate']);
        }
        if ($_POST['txReplySlipParentCaseNo'] == '') {
            $txReplySlipParentCaseNo = null;
        } else {
            $txReplySlipParentCaseNo = trim($_POST['txReplySlipParentCaseNo']);
        }
        if ($_POST['txReplySlipCaseVersion'] == '') {
            $txReplySlipCaseVersion = null;
        } else {
            $txReplySlipCaseVersion = trim($_POST['txReplySlipCaseVersion']);
        }
        if ($_POST['txReplySlipSentDate'] == '') {
            $txReplySlipSentDate = null;
        } else {
            $txReplySlipSentDate = trim($_POST['txReplySlipSentDate']);
        }
        if ($_POST['txFinish'] == '') {
            $txFinish = null;
        } else {
            $txFinish = trim($_POST['txFinish']);
        }
        if ($_POST['txActualReplySlipReturnDate'] == '') {
            $txActualReplySlipReturnDate = null;
        } else {
            $txActualReplySlipReturnDate = trim($_POST['txActualReplySlipReturnDate']);
        }
        if ($_POST['txFindingsFromReplySlip'] == '') {
            $txFindingsFromReplySlip = null;
        } else {
            $txFindingsFromReplySlip = trim($_POST['txFindingsFromReplySlip']);
        }
        $txFollowUpActionBool = isset($_POST['txFollowUpActionBool']) ? 'Y' : 'N';
        if ($_POST['txReplySlipFollowUpAction'] == '') {
            $txReplySlipFollowUpAction = null;
        } else {
            $txReplySlipFollowUpAction = trim($_POST['txReplySlipFollowUpAction']);
        }
        if ($_POST['txReplySlipRemark'] == '') {
            $txReplySlipRemark = null;
        } else {
            $txReplySlipRemark = trim($_POST['txReplySlipRemark']);
        }
        if ($_POST['txReplySlipSendPath'] == '') {
            $txReplySlipSendPath = null;
        } else {
            $txReplySlipSendPath = trim($_POST['txReplySlipSendPath']);
        }
        if ($_POST['txReplySlipReturnPath'] == '') {
            $txReplySlipReturnPath = null;
        } else {
            $txReplySlipReturnPath = trim($_POST['txReplySlipReturnPath']);
        }
        if ($_POST['txReplySlipReturnGrade'] == '') {
            $txReplySlipReturnGrade = null;
        } else {
            $txReplySlipReturnGrade = trim($_POST['txReplySlipReturnGrade']);
        }
        if ($_POST['txDateOfRequestedForReturnReplySlip'] == '') {
            $txDateOfRequestedForReturnReplySlip = null;
        } else {
            $txDateOfRequestedForReturnReplySlip = trim($_POST['txDateOfRequestedForReturnReplySlip']);
        }
        //addtiontal
        if ($_POST['txComplaint'] == '') {
            $txComplaint = null;
        } else {
            $txComplaint = trim($_POST['txComplaint']);
        }
        if ($_POST['txComplaintFollowUpAction'] == '') {
            $txComplaintFollowUpAction = null;
        } else {
            $txComplaintFollowUpAction = trim($_POST['txComplaintFollowUpAction']);
        }
        if ($_POST['txComplaintRemark'] == '') {
            $txComplaintRemark = null;
        } else {
            $txComplaintRemark = trim($_POST['txComplaintRemark']);
        }
        if ($_POST['txActive'] == '') {
            $txActive = null;
        } else {
            $txActive = trim($_POST['txActive']);
        }
        /*$active = isset($_POST['txActive']) ? trim($_POST['txActive']) : '';
        $createdBy = Yii::app()->session['tblUserDo']['username'];
        $createdTime = date("Y-m-d H:i"); */
        $lastUpdatedBy = Yii::app()->session['tblUserDo']['username']; 
        $lastUpdatedTime = date("Y-m-d H:i");
        $retJson['status'] = 'OK';

        try {

            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();

            //Query 1: Attempt to insert the payment record into our database.
            $sql = 'INSERT INTO "TblPlanningAhead" ("projectTitle","schemeNumber","projectRegion","projectAddress","projectAddressParentCaseNo","projectAddressCaseVersion","inputDate","regionLetterIssueDate","reportedBy","lastUpdatedBy"';
            $sql = $sql . ',"lastUpdatedTime","regionPlannerId","buildingTypeId","projectTypeId","keyInfrastructure","potentialSuccessfulCase","criticalProject","tempSupplyProject","bms","changeoverScheme"';
            $sql = $sql . ',"chillerPlant","escalator","hidLamp","lift","sensitiveMachine","telcom","acbTripping","buildingWithHighPenetrationEquipment","re","ev"';
            $sql = $sql . ',"estimatedLoad","pqisNumber","pqSiteWalkProjectRegion","pqSiteWalkProjectAddress","sensitiveEquipment","firstPqSiteWalkDate","firstPqSiteWalkStatus","firstPqSiteWalkInvitationLetterLink","firstPqSiteWalkRequestLetterDate","pqWalkAssessmentReportDate"';
            $sql = $sql . ',"pqWalkAssessmentReportLink","firstPqSiteWalkParentCaseNo","firstPqSiteWalkCaseVersion","firstPqSiteWalkCustomerResponse","firstPqSiteWalkInvestigationStatus","secondPqSiteWalkDate","secondPqSiteWalkInvitationLetterLink","secondPqSiteWalkRequestLetterDate","pqAssessmentFollowUpReportDate","pqAssessmentFollowUpReportLink"';
            $sql = $sql . ',"secondPqSiteWalkParentCaseNo","secondPqSiteWalkCaseVersion","secondPqSiteWalkCustomerResponse","secondPqSiteWalkInvestigationStatus","consultantCompanyNameId","consultantNameId","phoneNumber1","phoneNumber2","phoneNumber3","email1"';
            $sql = $sql . ',"email2","email3","consultantInformationRemark","estimatedCommisioningDateByCustomer","estimatedCommisioningDateByRegion","planningAheadStatus","invitationToPaMeetingDate","replySlipParentCaseNo","replySlipCaseVersion","replySlipSentDate"';
            $sql = $sql . ',"finish","actualReplySlipReturnDate","findingsFromReplySlip","replySlipfollowUpActionFlag","replySlipfollowUpAction","replySlipRemark","replySlipSendLink","replySlipReturnLink","replySlipGradeId","dateOfRequestedForReturnReplySlip"';
            $sql = $sql . ',"receiveComplaint","followUpAction","remark","active")';
            $sql = $sql . ' VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
            //$stmt = $pdo->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array(
                $txProjectTitle, $txSchemeNumber, $txProjectRegion, $txProjectAddress,$txProjectAddressParentCaseNo,$txProjectAddressCaseVersion, $txInputDate, $txRegionLetterIssueDate, $txReportedBy, $lastUpdatedBy
                ,$lastUpdatedTime,$txRegionPlanner,$txBuildingType, $txProjectType, $txKeyinfrastructure, $txPotentialSuccessfulCase, $txCriticalProject,$txTempSupplyProject,$txBms,$txChangeoverScheme
                ,$txChillerPlant, $txEscalator,$txHidLamp, $txLift,$txSensitiveMachine,$txTelcom,$txAcbTripping,$txBuildingWithHighPenetrationEquipment,$txRe,$txEv
                ,$txEstimatedLoad, $txPqisNumber, $txPqSiteWalkProjectRegion,$txPqSiteWalkProjectAddress,$txSensitiveEquipment,$txFirstPqSiteWalkDate,$txFirstPqSiteWalkStatus,$txFirstPqSiteWalkInvitationLetterLink,$txFirstPqSiteWalkRequestLetterDate,$txPqWalkAssessmentReportDate
                ,$txPqWalkAssessmentReportLink,$txFirstPqSiteWalkParentCaseNo,$txFirstPqSiteWalkCaseVersion,$txFirstPqSiteWalkCustomerResponse,$txFirstPqSiteWalkInvestigationStatus,$txSecondPqSiteWalkDate,$txSecondPqSiteWalkInvitationLetterLink,$txSecondPqSiteWalkRequestLetterDate,$txPqAssessmentFollowUpReportDate,$txPqAssessmentFollowupReportLink
                ,$txSecondPqSiteWalkParentCaseNo,$txSecondPqSiteWalkCaseVersion,$txSecondPqSiteWalkCustomerResponse,$txSecondPqSiteWalkInvestigationStatus,$txConsultantCompanyName,$txConsultantName,$txPhoneNumber1,$txPhoneNumber2,$txPhoneNumber3,$txEmail1
                ,$txEmail2,$txEmail3,$txConsultantInformationRemark,$txEstimatedCommisioningDateByCustomer,$txEstimatedCommisioningDateByRegion,$txPlanningAheadStatus,$txInvitationToPaMeetingDate,$txReplySlipParentCaseNo,$txReplySlipCaseVersion,$txReplySlipSentDate
                ,$txFinish,$txActualReplySlipReturnDate,$txFindingsFromReplySlip,$txFollowUpActionBool,$txReplySlipFollowUpAction,$txReplySlipRemark,$txReplySlipSendPath,$txReplySlipReturnPath,$txReplySlipReturnGrade,$txDateOfRequestedForReturnReplySlip
                ,$txComplaint, $txComplaintFollowUpAction, $txComplaintRemark, $txActive));
            
            /*
            if (!$result) {
                throw new Exception($stmt->errorInfo()[2], $stmt->errorInfo()[1]);

            }
            */

            $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
            //$stmt = $pdo->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);
            $stmt->execute(array(
                $lastUpdatedTime,
            )
            );

            //Query 2: Attempt to update the user's profile.
            /*    $sql = "UPDATE users SET credit = credit + ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
            $paymentAmount,
            $userId
            )
            ); */

            //We've got this far without an exception, so commit the changes.
            //$pdo->commit();
            $transaction->commit();
        }
        //Our catch block will handle any exceptions that are thrown.
         catch (PDOException $e) {

            //An exception has occured, which means that one of our database queries
            //failed.
            //Print out the error message.
            $retJson['status'] = 'NOTOK';
            $retJson['retMessage'] = $e->getMessage();
            //Rollback the transaction.
            //pdo->rollBack();
            $transaction->rollBack();
        }

        echo json_encode($retJson);
    }
    public function actionAjaxUpdatePlanningAhead()
    {

        if ($_POST['txProjectRef'] == '') {
            $txProjectRef = null;
        } else {
            $txProjectRef = trim($_POST['txProjectRef']);
        }
        if ($_POST['txProjectTitle'] == '') {
            $txProjectTitle = null;
        } else {
            $txProjectTitle = trim($_POST['txProjectTitle']);
        }
        if ($_POST['txSchemeNumber'] == '') {
            $txSchemeNumber = null;
        } else {
            $txSchemeNumber = trim($_POST['txSchemeNumber']);
        }
        if ($_POST['txProjectRegion'] == '') {
            $txProjectRegion = null;
        } else {
            $txProjectRegion = trim($_POST['txProjectRegion']);
        }
        if ($_POST['txProjectAddress'] == '') {
            $txProjectAddress = null;
        } else {
            $txProjectAddress = trim($_POST['txProjectAddress']);
        }
        if ($_POST['txProjectAddressParentCaseNo'] == '') {
            $txProjectAddressParentCaseNo = null;
        } else {
            $txProjectAddressParentCaseNo = trim($_POST['txProjectAddressParentCaseNo']);
        }
        if ($_POST['txProjectAddressCaseVersion'] == '') {
            $txProjectAddressCaseVersion = null;
        } else {
            $txProjectAddressCaseVersion = trim($_POST['txProjectAddressCaseVersion']);
        }
        if ($_POST['txInputDate'] == '') {
            $txInputDate = null;
        } else {
            $txInputDate = trim($_POST['txInputDate']);
        }
        if ($_POST['txRegionLetterIssueDate'] == '') {
            $txRegionLetterIssueDate = null;
        } else {
            $txRegionLetterIssueDate = trim($_POST['txRegionLetterIssueDate']);
        }
        if ($_POST['txReportedBy'] == '') {
            $txReportedBy = null;
        } else {
            $txReportedBy = trim($_POST['txReportedBy']);
        }

     /*   if ($_POST['txLastUpdatedBy'] == '') {
            $txLastUpdatedBy = null;
        } else {
            $txLastUpdatedBy = trim($_POST['txLastUpdatedBy']);
        }
    */
    if ($_POST['txRegionPlanner'] == '') {
        $txRegionPlanner = null;
    } else {
        $txRegionPlanner = trim($_POST['txRegionPlanner']);
    }
        //type
        if ($_POST['txBuildingType'] == '') {
            $txBuildingType = null;
        } else {
            $txBuildingType = trim($_POST['txBuildingType']);
        }
        if ($_POST['txProjectType'] == '') {
            $txProjectType = null;
        } else {
            $txProjectType = trim($_POST['txProjectType']);
        }
        $txKeyinfrastructure = isset($_POST['txKeyinfrastructure']) ? 'Y' : 'N';
        $txPotentialSuccessfulCase = isset($_POST['txPotentialSuccessfulCase']) ? 'Y' : 'N';
        $txCriticalProject = isset($_POST['txCriticalProject']) ? 'Y' : 'N';
        $txTempSupplyProject = isset($_POST['txTempSupplyProject']) ? 'Y' : 'N';
        //equipment
        $txBms = isset($_POST['txBms']) ? 1 : 0;
        $txChangeoverScheme = isset($_POST['txChangeoverScheme']) ? 1 : 0;
        $txChillerPlant = isset($_POST['txChillerPlant']) ? 1 : 0;
        $txEscalator = isset($_POST['txEscalator']) ? 1 : 0;
        $txHidLamp = isset($_POST['txHidLamp']) ? 1 : 0;
        $txLift = isset($_POST['txLift']) ? 1 : 0;
        $txSensitiveMachine = isset($_POST['txSensitiveMachine']) ? 1 : 0;
        $txTelcom = isset($_POST['txTelcom']) ? 1 : 0;
        $txAcbTripping = isset($_POST['txAcbTripping']) ? 1 : 0;
        $txBuildingWithHighPenetrationEquipment = isset($_POST['txBuildingWithHighPenetrationEquipment']) ? 1 : 0;
        $txRe = isset($_POST['txRe']) ? 1 : 0;
        $txEv = isset($_POST['txEv']) ? 1 : 0;
        if ($_POST['txEstimatedLoad'] == '') {
            $txEstimatedLoad = null;
        } else {
            $txEstimatedLoad = trim($_POST['txEstimatedLoad']);
        }
        if ($_POST['txPqisNumber'] == '') {
            $txPqisNumber = null;
        } else {
            $txPqisNumber = trim($_POST['txPqisNumber']);
        }
        //pqwalk
        if ($_POST['txPqSiteWalkProjectRegion'] == '') {
            $txPqSiteWalkProjectRegion = null;
        } else {
            $txPqSiteWalkProjectRegion = trim($_POST['txPqSiteWalkProjectRegion']);
        }
        if ($_POST['txPqSiteWalkProjectAddress'] == '') {
            $txPqSiteWalkProjectAddress = null;
        } else {
            $txPqSiteWalkProjectAddress = trim($_POST['txPqSiteWalkProjectAddress']);
        }
        if ($_POST['txSensitiveEquipment'] == '') {
            $txSensitiveEquipment = null;
        } else {
            $txSensitiveEquipment = trim($_POST['txSensitiveEquipment']);
        }
        //pqwalk first walk
        if ($_POST['txFirstPqSiteWalkDate'] == '') {
            $txFirstPqSiteWalkDate = null;
        } else {
            $txFirstPqSiteWalkDate = trim($_POST['txFirstPqSiteWalkDate']);
        }
        if ($_POST['txFirstPqSiteWalkStatus'] == '') {
            $txFirstPqSiteWalkStatus = null;
        } else {
            $txFirstPqSiteWalkStatus = trim($_POST['txFirstPqSiteWalkStatus']);
        }
        if ($_POST['txFirstPqSiteWalkInvitationLetterLink'] == '') {
            $txFirstPqSiteWalkInvitationLetterLink = null;
        } else {
            $txFirstPqSiteWalkInvitationLetterLink = trim($_POST['txFirstPqSiteWalkInvitationLetterLink']);
        }
        if ($_POST['txFirstPqSiteWalkRequestLetterDate'] == '') {
            $txFirstPqSiteWalkRequestLetterDate = null;
        } else {
            $txFirstPqSiteWalkRequestLetterDate = trim($_POST['txFirstPqSiteWalkRequestLetterDate']);
        }
        if ($_POST['txPqWalkAssessmentReportDate'] == '') {
            $txPqWalkAssessmentReportDate = null;
        } else {
            $txPqWalkAssessmentReportDate = trim($_POST['txPqWalkAssessmentReportDate']);
        }
        if ($_POST['txPqWalkAssessmentReportLink'] == '') {
            $txPqWalkAssessmentReportLink = null;
        } else {
            $txPqWalkAssessmentReportLink = trim($_POST['txPqWalkAssessmentReportLink']);
        }
        if ($_POST['txFirstPqSiteWalkParentCaseNo'] == '') {
            $txFirstPqSiteWalkParentCaseNo = null;
        } else {
            $txFirstPqSiteWalkParentCaseNo = trim($_POST['txFirstPqSiteWalkParentCaseNo']);
        }
        if ($_POST['txFirstPqSiteWalkCaseVersion'] == '') {
            $txFirstPqSiteWalkCaseVersion = null;
        } else {
            $txFirstPqSiteWalkCaseVersion = trim($_POST['txFirstPqSiteWalkCaseVersion']);
        }
        if ($_POST['txFirstPqSiteWalkCustomerResponse'] == '') {
            $txFirstPqSiteWalkCustomerResponse = null;
        } else {
            $txFirstPqSiteWalkCustomerResponse = trim($_POST['txFirstPqSiteWalkCustomerResponse']);
        }
        if ($_POST['txFirstPqSiteWalkInvestigationStatus'] == '') {
            $txFirstPqSiteWalkInvestigationStatus = null;
        } else {
            $txFirstPqSiteWalkInvestigationStatus = trim($_POST['txFirstPqSiteWalkInvestigationStatus']);
        }
        if ($_POST['txSecondPqSiteWalkDate'] == '') {
            $txSecondPqSiteWalkDate = null;
        } else {
            $txSecondPqSiteWalkDate = trim($_POST['txSecondPqSiteWalkDate']);
        }
        if ($_POST['txSecondPqSiteWalkInvitationLetterLink'] == '') {
            $txSecondPqSiteWalkInvitationLetterLink = null;
        } else {
            $txSecondPqSiteWalkInvitationLetterLink = trim($_POST['txSecondPqSiteWalkInvitationLetterLink']);
        }
        if ($_POST['txSecondPqSiteWalkRequestLetterDate'] == '') {
            $txSecondPqSiteWalkRequestLetterDate = null;
        } else {
            $txSecondPqSiteWalkRequestLetterDate = trim($_POST['txSecondPqSiteWalkRequestLetterDate']);
        }
        if ($_POST['txPqAssessmentFollowUpReportDate'] == '') {
            $txPqAssessmentFollowUpReportDate = null;
        } else {
            $txPqAssessmentFollowUpReportDate = trim($_POST['txPqAssessmentFollowUpReportDate']);
        }
        if ($_POST['txPqAssessmentFollowupReportLink'] == '') {
            $txPqAssessmentFollowupReportLink = null;
        } else {
            $txPqAssessmentFollowupReportLink = trim($_POST['txPqAssessmentFollowupReportLink']);
        }
        if ($_POST['txSecondPqSiteWalkParentCaseNo'] == '') {
            $txSecondPqSiteWalkParentCaseNo = null;
        } else {
            $txSecondPqSiteWalkParentCaseNo = trim($_POST['txSecondPqSiteWalkParentCaseNo']);
        }
        if ($_POST['txSecondPqSiteWalkCaseVersion'] == '') {
            $txSecondPqSiteWalkCaseVersion = null;
        } else {
            $txSecondPqSiteWalkCaseVersion = trim($_POST['txSecondPqSiteWalkCaseVersion']);
        }
        if ($_POST['txSecondPqSiteWalkCustomerResponse'] == '') {
            $txSecondPqSiteWalkCustomerResponse = null;
        } else {
            $txSecondPqSiteWalkCustomerResponse = trim($_POST['txSecondPqSiteWalkCustomerResponse']);
        }
        if ($_POST['txSecondPqSiteWalkInvestigationStatus'] == '') {
            $txSecondPqSiteWalkInvestigationStatus = null;
        } else {
            $txSecondPqSiteWalkInvestigationStatus = trim($_POST['txSecondPqSiteWalkInvestigationStatus']);
        }
        //consultant information
        if ($_POST['txConsultantCompanyName'] == '') {
            $txConsultantCompanyName = null;
        } else {
            $txConsultantCompanyName = trim($_POST['txConsultantCompanyName']);
        }
        if ($_POST['txConsultantName'] == '') {
            $txConsultantName = null;
        } else {
            $txConsultantName = trim($_POST['txConsultantName']);
        }

        if ($_POST['txPhoneNumber1'] == '') {
            $txPhoneNumber1 = null;
        } else {
            $txPhoneNumber1 = trim($_POST['txPhoneNumber1']);
        }
        if ($_POST['txPhoneNumber2'] == '') {
            $txPhoneNumber2 = null;
        } else {
            $txPhoneNumber2 = trim($_POST['txPhoneNumber2']);
        }
        if ($_POST['txPhoneNumber3'] == '') {
            $txPhoneNumber3 = null;
        } else {
            $txPhoneNumber3 = trim($_POST['txPhoneNumber3']);
        }
        if ($_POST['txEmail1'] == '') {
            $txEmail1 = null;
        } else {
            $txEmail1 = trim($_POST['txEmail1']);
        }
        if ($_POST['txEmail2'] == '') {
            $txEmail2 = null;
        } else {
            $txEmail2 = trim($_POST['txEmail2']);
        }
        if ($_POST['txEmail3'] == '') {
            $txEmail3 = null;
        } else {
            $txEmail3 = trim($_POST['txEmail3']);
        }
        if ($_POST['txConsultantInformationRemark'] == '') {
            $txConsultantInformationRemark = null;
        } else {
            $txConsultantInformationRemark = trim($_POST['txConsultantInformationRemark']);
        }
        //consultant information status
        if ($_POST['txEstimatedCommisioningDateByCustomer'] == '') {
            $txEstimatedCommisioningDateByCustomer = null;
        } else {
            $txEstimatedCommisioningDateByCustomer = trim($_POST['txEstimatedCommisioningDateByCustomer']);
        }
        if ($_POST['txEstimatedCommisioningDateByRegion'] == '') {
            $txEstimatedCommisioningDateByRegion = null;
        } else {
            $txEstimatedCommisioningDateByRegion = trim($_POST['txEstimatedCommisioningDateByRegion']);
        }
        if ($_POST['txPlanningAheadStatus'] == '') {
            $txPlanningAheadStatus = null;
        } else {
            $txPlanningAheadStatus = trim($_POST['txPlanningAheadStatus']);
        }
        //replySlip
        if ($_POST['txInvitationToPaMeetingDate'] == '') {
            $txInvitationToPaMeetingDate = null;
        } else {
            $txInvitationToPaMeetingDate = trim($_POST['txInvitationToPaMeetingDate']);
        }
        if ($_POST['txReplySlipParentCaseNo'] == '') {
            $txReplySlipParentCaseNo = null;
        } else {
            $txReplySlipParentCaseNo = trim($_POST['txReplySlipParentCaseNo']);
        }
        if ($_POST['txReplySlipCaseVersion'] == '') {
            $txReplySlipCaseVersion = null;
        } else {
            $txReplySlipCaseVersion = trim($_POST['txReplySlipCaseVersion']);
        }
        if ($_POST['txReplySlipSentDate'] == '') {
            $txReplySlipSentDate = null;
        } else {
            $txReplySlipSentDate = trim($_POST['txReplySlipSentDate']);
        }
        if ($_POST['txFinish'] == '') {
            $txFinish = null;
        } else {
            $txFinish = trim($_POST['txFinish']);
        }
        if ($_POST['txActualReplySlipReturnDate'] == '') {
            $txActualReplySlipReturnDate = null;
        } else {
            $txActualReplySlipReturnDate = trim($_POST['txActualReplySlipReturnDate']);
        }
        if ($_POST['txFindingsFromReplySlip'] == '') {
            $txFindingsFromReplySlip = null;
        } else {
            $txFindingsFromReplySlip = trim($_POST['txFindingsFromReplySlip']);
        }
        $txFollowUpActionBool = isset($_POST['txFollowUpActionBool']) ? 'Y' : 'N';
        if ($_POST['txReplySlipFollowUpAction'] == '') {
            $txReplySlipFollowUpAction = null;
        } else {
            $txReplySlipFollowUpAction = trim($_POST['txReplySlipFollowUpAction']);
        }
        if ($_POST['txReplySlipRemark'] == '') {
            $txReplySlipRemark = null;
        } else {
            $txReplySlipRemark = trim($_POST['txReplySlipRemark']);
        }
        if ($_POST['txReplySlipSendPath'] == '') {
            $txReplySlipSendPath = null;
        } else {
            $txReplySlipSendPath = trim($_POST['txReplySlipSendPath']);
        }
        if ($_POST['txReplySlipReturnPath'] == '') {
            $txReplySlipReturnPath = null;
        } else {
            $txReplySlipReturnPath = trim($_POST['txReplySlipReturnPath']);
        }
        if ($_POST['txReplySlipReturnGrade'] == '') {
            $txReplySlipReturnGrade = null;
        } else {
            $txReplySlipReturnGrade = trim($_POST['txReplySlipReturnGrade']);
        }
        if ($_POST['txDateOfRequestedForReturnReplySlip'] == '') {
            $txDateOfRequestedForReturnReplySlip = null;
        } else {
            $txDateOfRequestedForReturnReplySlip = trim($_POST['txDateOfRequestedForReturnReplySlip']);
        }
        //addtiontal
        if ($_POST['txComplaint'] == '') {
            $txComplaint = null;
        } else {
            $txComplaint = trim($_POST['txComplaint']);
        }
        if ($_POST['txComplaintFollowUpAction'] == '') {
            $txComplaintFollowUpAction = null;
        } else {
            $txComplaintFollowUpAction = trim($_POST['txComplaintFollowUpAction']);
        }
        if ($_POST['txComplaintRemark'] == '') {
            $txComplaintRemark = null;
        } else {
            $txComplaintRemark = trim($_POST['txComplaintRemark']);
        }
        if ($_POST['txActive'] == '') {
            $txActive = null;
        } else {
            $txActive = trim($_POST['txActive']);
        }
        /*$active = isset($_POST['txActive']) ? trim($_POST['txActive']) : '';
        $createdBy = Yii::app()->session['tblUserDo']['username'];
        $createdTime = date("Y-m-d H:i"); */
        $lastUpdatedBy = Yii::app()->session['tblUserDo']['username']; 
        $lastUpdatedTime = date("Y-m-d H:i");
        $retJson['status'] = 'OK';

        try {

            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();

            //Query 1: Attempt to insert the payment record into our database.
            $sql = 'UPDATE "TblPlanningAhead" SET "projectTitle"=?,"schemeNumber"=?,"projectRegion"=?,"projectAddress"=?,"projectAddressParentCaseNo"=?,"projectAddressCaseVersion"=?,"inputDate"=?,"regionLetterIssueDate"=?,"reportedBy"=?,"lastUpdatedBy"';
            $sql = $sql . '=?,"lastUpdatedTime"=?,"regionPlannerId"=?,"buildingTypeId"=?,"projectTypeId"=?,"keyInfrastructure"=?,"potentialSuccessfulCase"=?,"criticalProject"=?,"tempSupplyProject"=?,"bms"=?,"changeoverScheme"';
            $sql = $sql . '=?,"chillerPlant"=?,"escalator"=?,"hidLamp"=?,"lift"=?,"sensitiveMachine"=?,"telcom"=?,"acbTripping"=?,"buildingWithHighPenetrationEquipment"=?,"re"=?,"ev"';
            $sql = $sql . '=?,"estimatedLoad"=?,"pqisNumber"=?,"pqSiteWalkProjectRegion"=?,"pqSiteWalkProjectAddress"=?,"sensitiveEquipment"=?,"firstPqSiteWalkDate"=?,"firstPqSiteWalkStatus"=?,"firstPqSiteWalkInvitationLetterLink"=?,"firstPqSiteWalkRequestLetterDate"=?,"pqWalkAssessmentReportDate"';
            $sql = $sql . '=?,"pqWalkAssessmentReportLink"=?,"firstPqSiteWalkParentCaseNo"=?,"firstPqSiteWalkCaseVersion"=?,"firstPqSiteWalkCustomerResponse"=?,"firstPqSiteWalkInvestigationStatus"=?,"secondPqSiteWalkDate"=?,"secondPqSiteWalkInvitationLetterLink"=?,"secondPqSiteWalkRequestLetterDate"=?,"pqAssessmentFollowUpReportDate"=?,"pqAssessmentFollowUpReportLink"';
            $sql = $sql . '=?,"secondPqSiteWalkParentCaseNo"=?,"secondPqSiteWalkCaseVersion"=?,"secondPqSiteWalkCustomerResponse"=?,"secondPqSiteWalkInvestigationStatus"=?,"consultantCompanyNameId"=?,"consultantNameId"=?,"phoneNumber1"=?,"phoneNumber2"=?,"phoneNumber3"=?,"email1"';
            $sql = $sql . '=?,"email2"=?,"email3"=?,"consultantInformationRemark"=?,"estimatedCommisioningDateByCustomer"=?,"estimatedCommisioningDateByRegion"=?,"planningAheadStatus"=?,"invitationToPaMeetingDate"=?,"replySlipParentCaseNo"=?,"replySlipCaseVersion"=?,"replySlipSentDate"';
            $sql = $sql . '=?,"finish"=?,"actualReplySlipReturnDate"=?,"findingsFromReplySlip"=?,"replySlipfollowUpActionFlag"=?,"replySlipfollowUpAction"=?,"replySlipRemark"=?,"replySlipSendLink"=?,"replySlipReturnLink"=?,"replySlipGradeId"=?,"dateOfRequestedForReturnReplySlip"';
            $sql = $sql . '=?,"receiveComplaint"=?,"followUpAction"=?,"remark"=?,"active"=?';
            $sql = $sql . ' WHERE "planningAheadId" = ?';
            //$stmt = $pdo->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array(
                $txProjectTitle, $txSchemeNumber, $txProjectRegion, $txProjectAddress,$txProjectAddressParentCaseNo,$txProjectAddressCaseVersion, $txInputDate, $txRegionLetterIssueDate, $txReportedBy, $lastUpdatedBy
                ,$lastUpdatedTime,$txRegionPlanner,$txBuildingType, $txProjectType, $txKeyinfrastructure, $txPotentialSuccessfulCase, $txCriticalProject,$txTempSupplyProject,$txBms,$txChangeoverScheme
                ,$txChillerPlant, $txEscalator,$txHidLamp, $txLift,$txSensitiveMachine,$txTelcom,$txAcbTripping,$txBuildingWithHighPenetrationEquipment,$txRe,$txEv
                ,$txEstimatedLoad, $txPqisNumber, $txPqSiteWalkProjectRegion,$txPqSiteWalkProjectAddress,$txSensitiveEquipment,$txFirstPqSiteWalkDate,$txFirstPqSiteWalkStatus,$txFirstPqSiteWalkInvitationLetterLink,$txFirstPqSiteWalkRequestLetterDate,$txPqWalkAssessmentReportDate
                ,$txPqWalkAssessmentReportLink,$txFirstPqSiteWalkParentCaseNo,$txFirstPqSiteWalkCaseVersion,$txFirstPqSiteWalkCustomerResponse,$txFirstPqSiteWalkInvestigationStatus,$txSecondPqSiteWalkDate,$txSecondPqSiteWalkInvitationLetterLink,$txSecondPqSiteWalkRequestLetterDate,$txPqAssessmentFollowUpReportDate,$txPqAssessmentFollowupReportLink
                ,$txSecondPqSiteWalkParentCaseNo,$txSecondPqSiteWalkCaseVersion,$txSecondPqSiteWalkCustomerResponse,$txSecondPqSiteWalkInvestigationStatus,$txConsultantCompanyName,$txConsultantName,$txPhoneNumber1,$txPhoneNumber2,$txPhoneNumber3,$txEmail1
                ,$txEmail2,$txEmail3,$txConsultantInformationRemark,$txEstimatedCommisioningDateByCustomer,$txEstimatedCommisioningDateByRegion,$txPlanningAheadStatus,$txInvitationToPaMeetingDate,$txReplySlipParentCaseNo,$txReplySlipCaseVersion,$txReplySlipSentDate
                ,$txFinish,$txActualReplySlipReturnDate,$txFindingsFromReplySlip,$txFollowUpActionBool,$txReplySlipFollowUpAction,$txReplySlipRemark,$txReplySlipSendPath,$txReplySlipReturnPath,$txReplySlipReturnGrade,$txDateOfRequestedForReturnReplySlip
                ,$txComplaint, $txComplaintFollowUpAction, $txComplaintRemark, $txActive,$txProjectRef));
            /*
            if (!$result) {
                throw new Exception($stmt->errorInfo()[2], $stmt->errorInfo()[1]);

            }
            */
            $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
            //$stmt = $pdo->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);
            $stmt->execute(array(
                $lastUpdatedTime,
            )
            );

            //Query 2: Attempt to update the user's profile.
            /*    $sql = "UPDATE users SET credit = credit + ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
            $paymentAmount,
            $userId
            )
            ); */

            //We've got this far without an exception, so commit the changes.
            //$pdo->commit();
            $transaction->commit();
        }
        //Our catch block will handle any exceptions that are thrown.
         catch (PDOException $e) {

            //An exception has occured, which means that one of our database queries
            //failed.
            //Print out the error message.
            $retJson['status'] = 'NOTOK';
            $retJson['retMessage'] = $e->getMessage();
            //Rollback the transaction.
            //$pdo->rollBack();
            $transaction->rollBack();
        }

        echo json_encode($retJson);
    }

    public function actionAjaxPostPlanningAheadProjectDetailDraftUpdate() {

        $retJson = array();
        $success = true;

        if ($success && (!isset($_POST['planningAheadId']) || ($_POST['planningAheadId'] == ""))) {
            $retJson['retMessage'] = "Planning Ahead Id is required!";
            $success = false;
        } else {
            $txnPlanningAheadId = trim($_POST['planningAheadId']);
        }

        if ($success && (!isset($_POST['roleId']) || ($_POST['roleId'] == ""))) {
            $retJson['retMessage'] = "Role Id is required!";
            $success = false;
        } else {
            $txnRoleId = trim($_POST['roleId']);
        }

        if ($success && (!isset($_POST['state']) || ($_POST['state'] == ""))) {
            $retJson['retMessage'] = "State is required!";
            $success = false;
        } else {
            $txnState = trim($_POST['state']);
        }

        if ($success && (!isset($_POST['schemeNo']) || ($_POST['schemeNo'] == ""))) {
            $retJson['retMessage'] = "Scheme No. is required!";
            $success = false;
        } else {
            $txnSchemeNo = trim($_POST['schemeNo']);
        }

        if ($success && (!isset($_POST['projectTitle']) || ($_POST['projectTitle'] == ""))) {
            $retJson['retMessage'] = "Project Title is required!";
            $success = false;
        } else {
            $txnProjectTitle = trim($_POST['projectTitle']);
        }

        if ($success && (!isset($_POST['region']) || ($_POST['region'] == ""))) {
            $retJson['retMessage'] = "Region is required!";
            $success = false;
        } else {
            $txnRegion = trim($_POST['region']);
        }

        if ($success && isset($_POST['typeOfProject']) && ($_POST['typeOfProject'] != "")) {
            $txnTypeOfProject = trim($_POST['typeOfProject']);
        } else {
            $txnTypeOfProject = null;
        }

        if ($success && isset($_POST['commissionDate']) && ($_POST['commissionDate'] != "")) {
            $txnCommissionDate = trim($_POST['commissionDate']);
        } else {
            $txnCommissionDate = null;
        }

        if ($success && isset($_POST['infraOpt']) && ($_POST['infraOpt'] != "")) {
            $txnKeyInfra = trim($_POST['infraOpt']);
        } else {
            $txnKeyInfra = null;
        }

        if ($success && isset($_POST['tempProjOpt']) && ($_POST['tempProjOpt'] != "")) {
            $txnTempProj = trim($_POST['tempProjOpt']);
        } else {
            $txnTempProj = null;
        }

        if ($success && isset($_POST['firstRegionStaffName']) && ($_POST['firstRegionStaffName'] != "")) {
            $txnFirstRegionStaffName = trim($_POST['firstRegionStaffName']);
        } else {
            $txnFirstRegionStaffName = null;
        }

        if ($success && isset($_POST['firstRegionStaffPhone']) && ($_POST['firstRegionStaffPhone'] != "")) {
            $txnFirstRegionStaffPhone = trim($_POST['firstRegionStaffPhone']);
        } else {
            $txnFirstRegionStaffPhone = null;
        }

        if ($success && isset($_POST['firstRegionStaffEmail']) && ($_POST['firstRegionStaffEmail'] != "")) {
            $txnFirstRegionStaffEmail = trim($_POST['firstRegionStaffEmail']);
        } else {
            $txnFirstRegionStaffEmail = null;
        }

        if ($success && isset($_POST['secondRegionStaffName']) && ($_POST['secondRegionStaffName'] != "")) {
            $txnSecondRegionStaffName = trim($_POST['secondRegionStaffName']);
        } else {
            $txnSecondRegionStaffName = null;
        }

        if ($success && isset($_POST['secondRegionStaffPhone']) && ($_POST['secondRegionStaffPhone'] != "")) {
            $txnSecondRegionStaffPhone = trim($_POST['secondRegionStaffPhone']);
        } else {
            $txnSecondRegionStaffPhone = null;
        }

        if ($success && isset($_POST['secondRegionStaffEmail']) && ($_POST['secondRegionStaffEmail'] != "")) {
            $txnSecondRegionStaffEmail = trim($_POST['secondRegionStaffEmail']);
        } else {
            $txnSecondRegionStaffEmail = null;
        }

        if ($success && isset($_POST['thirdRegionStaffName']) && ($_POST['thirdRegionStaffName'] != "")) {
            $txnThirdRegionStaffName = trim($_POST['thirdRegionStaffName']);
        } else {
            $txnThirdRegionStaffName = null;
        }

        if ($success && isset($_POST['thirdRegionStaffPhone']) && ($_POST['thirdRegionStaffPhone'] != "")) {
            $txnThirdRegionStaffPhone = trim($_POST['thirdRegionStaffPhone']);
        } else {
            $txnThirdRegionStaffPhone = null;
        }

        if ($success && isset($_POST['thirdRegionStaffEmail']) && ($_POST['thirdRegionStaffEmail'] != "")) {
            $txnThirdRegionStaffEmail = trim($_POST['thirdRegionStaffEmail']);
        } else {
            $txnThirdRegionStaffEmail = null;
        }

        if ($success && isset($_POST['firstConsultantTitle']) && ($_POST['firstConsultantTitle'] != "")) {
            $txnFirstConsultantTitle = trim($_POST['firstConsultantTitle']);
        } else {
            $txnFirstConsultantTitle = null;
        }

        if ($success && isset($_POST['firstConsultantSurname']) && ($_POST['firstConsultantSurname'] != "")) {
            $txnFirstConsultantSurname = trim($_POST['firstConsultantSurname']);
        } else {
            $txnFirstConsultantSurname = null;
        }

        if ($success && isset($_POST['firstConsultantOtherName']) && ($_POST['firstConsultantOtherName'] != "")) {
            $txnFirstConsultantOtherName = trim($_POST['firstConsultantOtherName']);
        } else {
            $txnFirstConsultantOtherName = null;
        }

        if ($success && isset($_POST['firstConsultantCompany']) && ($_POST['firstConsultantCompany'] != "")) {
            $txnFirstConsultantCompany = trim($_POST['firstConsultantCompany']);
        } else {
            $txnFirstConsultantCompany = null;
        }

        if ($success && isset($_POST['firstConsultantPhone']) && ($_POST['firstConsultantPhone'] != "")) {
            $txnFirstConsultantPhone = trim($_POST['firstConsultantPhone']);
        } else {
            $txnFirstConsultantPhone = null;
        }

        if ($success && isset($_POST['firstConsultantEmail']) && ($_POST['firstConsultantEmail'] != "")) {
            $txnFirstConsultantEmail = trim($_POST['firstConsultantEmail']);
        } else {
            $txnFirstConsultantEmail = null;
        }

        if ($success && isset($_POST['projectOwnerTitle']) && ($_POST['projectOwnerTitle'] != "")) {
            $txnProjectOwnerTitle = trim($_POST['projectOwnerTitle']);
        } else {
            $txnProjectOwnerTitle = null;
        }

        if ($success && isset($_POST['projectOwnerSurname']) && ($_POST['projectOwnerSurname'] != "")) {
            $txnProjectOwnerSurname = trim($_POST['projectOwnerSurname']);
        } else {
            $txnProjectOwnerSurname = null;
        }

        if ($success && isset($_POST['projectOwnerOtherName']) && ($_POST['projectOwnerOtherName'] != "")) {
            $txnProjectOwnerOtherName = trim($_POST['projectOwnerOtherName']);
        } else {
            $txnProjectOwnerOtherName = null;
        }

        if ($success && isset($_POST['projectOwnerCompany']) && ($_POST['projectOwnerCompany'] != "")) {
            $txnProjectOwnerCompany = trim($_POST['projectOwnerCompany']);
        } else {
            $txnProjectOwnerCompany = null;
        }

        if ($success && isset($_POST['projectOwnerPhone']) && ($_POST['projectOwnerPhone'] != "")) {
            $txnProjectOwnerPhone = trim($_POST['projectOwnerPhone']);
        } else {
            $txnProjectOwnerPhone = null;
        }

        if ($success && isset($_POST['projectOwnerEmail']) && ($_POST['projectOwnerEmail'] != "")) {
            $txnProjectOwnerEmail = trim($_POST['projectOwnerEmail']);
        } else {
            $txnProjectOwnerEmail = null;
        }

        if ($success) {
            $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
            $lastUpdatedTime = date("Y-m-d H:i");

            $sql = 'UPDATE "tbl_planning_ahead" SET "project_title"=?, "scheme_no"=?, "region_id"=?, ';
            $sql = $sql . '"project_type_id"=?, "commission_date"=?, "key_infra"=?, "temp_project"=?, ';
            $sql = $sql . '"first_region_staff_name"=?, "first_region_staff_phone"=?, "first_region_staff_email"=?, ';
            $sql = $sql . '"second_region_staff_name"=?, "second_region_staff_phone"=?, "second_region_staff_email"=?, ';
            $sql = $sql . '"third_region_staff_name"=?, "third_region_staff_phone"=?, "third_region_staff_email"=?, ';
            $sql = $sql . '"first_consultant_title"=?, "first_consultant_surname"=?, "first_consultant_other_name"=?, ';
            $sql = $sql . '"first_consultant_company"=?, "first_consultant_phone"=?, "first_consultant_email"=?, ';
            $sql = $sql . '"project_owner_title"=?, "project_owner_surname"=?, "project_owner_other_name"=?, ';
            $sql = $sql . '"project_owner_company"=?, "project_owner_phone"=?, "project_owner_email"=?, ';
            $sql = $sql . '"last_updated_by"=?, "last_updated_time"=? ';
            $sql = $sql . 'WHERE "planning_ahead_id"=?';

            try {
                //We start our transaction.
                //$pdo->beginTransaction();
                $transaction = Yii::app()->db->beginTransaction();

                $stmt = Yii::app()->db->createCommand($sql);

                $result = $stmt->execute(array(
                    $txnProjectTitle,$txnSchemeNo,$txnRegion,
                    $txnTypeOfProject,$txnCommissionDate,$txnKeyInfra,$txnTempProj,
                    $txnFirstRegionStaffName,$txnFirstRegionStaffPhone,$txnFirstRegionStaffEmail,
                    $txnSecondRegionStaffName,$txnSecondRegionStaffPhone,$txnSecondRegionStaffEmail,
                    $txnThirdRegionStaffName,$txnThirdRegionStaffPhone,$txnThirdRegionStaffEmail,
                    $txnFirstConsultantTitle,$txnFirstConsultantSurname,$txnFirstConsultantOtherName,
                    $txnFirstConsultantCompany,$txnFirstConsultantPhone,$txnFirstConsultantEmail,
                    $txnProjectOwnerTitle,$txnProjectOwnerSurname,$txnProjectOwnerOtherName,
                    $txnProjectOwnerCompany,$txnProjectOwnerPhone,$txnProjectOwnerEmail,
                    $lastUpdatedBy,$lastUpdatedTime,
                    $txnPlanningAheadId));

                $transaction->commit();

                $retJson['status'] = 'OK';

            } catch (PDOException $e) {

                //An exception has occured, which means that one of our database queries failed.
                //Print out the error message.
                $retJson['status'] = 'NOTOK';
                $retJson['retMessage'] = $e->getMessage();
                //Rollback the transaction.
                //$pdo->rollBack();
                $transaction->rollBack();
            }
        } else {
            $retJson['status'] = 'NOTOK';
        }

        echo json_encode($retJson);
    }

    public function actionAjaxPostPlanningAheadProjectDetailProcessUpdate() {

        $retJson = array();
        $success = true;

        if ($success && (!isset($_POST['planningAheadId']) || ($_POST['planningAheadId'] == ""))) {
            $retJson['retMessage'] = "Planning Ahead Id is required!";
            $success = false;
        } else {
            $txnPlanningAheadId = trim($_POST['planningAheadId']);
        }

        if ($success && (!isset($_POST['roleId']) || ($_POST['roleId'] == ""))) {
            $retJson['retMessage'] = "Role Id is required!";
            $success = false;
        } else {
            $txnRoleId = trim($_POST['roleId']);
        }

        if ($success && (!isset($_POST['state']) || ($_POST['state'] == ""))) {
            $retJson['retMessage'] = "State is required!";
            $success = false;
        } else {
            $txnState = trim($_POST['state']);
        }

        if ($success && (!isset($_POST['schemeNo']) || ($_POST['schemeNo'] == ""))) {
            $retJson['retMessage'] = "Scheme No. is required!";
            $success = false;
        } else {
            $txnSchemeNo = trim($_POST['schemeNo']);
        }

        if ($success && (!isset($_POST['projectTitle']) || ($_POST['projectTitle'] == ""))) {
            $retJson['retMessage'] = "Project Title is required!";
            $success = false;
        } else {
            $txnProjectTitle = trim($_POST['projectTitle']);
        }

        if ($success && (!isset($_POST['region']) || ($_POST['region'] == ""))) {
            $retJson['retMessage'] = "Region is required!";
            $success = false;
        } else {
            $txnRegion = trim($_POST['region']);
        }

        if ($success && isset($_POST['typeOfProject']) && ($_POST['typeOfProject'] != "")) {
            $txnTypeOfProject = trim($_POST['typeOfProject']);
        } else {
            $txnTypeOfProject = null;
        }

        if ($success && isset($_POST['commissionDate']) && ($_POST['commissionDate'] != "")) {
            $txnCommissionDate = trim($_POST['commissionDate']);
        } else {
            $txnCommissionDate = null;
        }

        if ($success && isset($_POST['infraOpt']) && ($_POST['infraOpt'] != "")) {
            $txnKeyInfra = trim($_POST['infraOpt']);
        } else {
            $txnKeyInfra = null;
        }

        if ($success && isset($_POST['tempProjOpt']) && ($_POST['tempProjOpt'] != "")) {
            $txnTempProj = trim($_POST['tempProjOpt']);
        } else {
            $txnTempProj = null;
        }

        if ($success && isset($_POST['firstRegionStaffName']) && ($_POST['firstRegionStaffName'] != "")) {
            $txnFirstRegionStaffName = trim($_POST['firstRegionStaffName']);
        } else {
            $txnFirstRegionStaffName = null;
        }

        if ($success && isset($_POST['firstRegionStaffPhone']) && ($_POST['firstRegionStaffPhone'] != "")) {
            $txnFirstRegionStaffPhone = trim($_POST['firstRegionStaffPhone']);
        } else {
            $txnFirstRegionStaffPhone = null;
        }

        if ($success && isset($_POST['firstRegionStaffEmail']) && ($_POST['firstRegionStaffEmail'] != "")) {
            $txnFirstRegionStaffEmail = trim($_POST['firstRegionStaffEmail']);
        } else {
            $txnFirstRegionStaffEmail = null;
        }

        if ($success && isset($_POST['secondRegionStaffName']) && ($_POST['secondRegionStaffName'] != "")) {
            $txnSecondRegionStaffName = trim($_POST['secondRegionStaffName']);
        } else {
            $txnSecondRegionStaffName = null;
        }

        if ($success && isset($_POST['secondRegionStaffPhone']) && ($_POST['secondRegionStaffPhone'] != "")) {
            $txnSecondRegionStaffPhone = trim($_POST['secondRegionStaffPhone']);
        } else {
            $txnSecondRegionStaffPhone = null;
        }

        if ($success && isset($_POST['secondRegionStaffEmail']) && ($_POST['secondRegionStaffEmail'] != "")) {
            $txnSecondRegionStaffEmail = trim($_POST['secondRegionStaffEmail']);
        } else {
            $txnSecondRegionStaffEmail = null;
        }

        if ($success && isset($_POST['thirdRegionStaffName']) && ($_POST['thirdRegionStaffName'] != "")) {
            $txnThirdRegionStaffName = trim($_POST['thirdRegionStaffName']);
        } else {
            $txnThirdRegionStaffName = null;
        }

        if ($success && isset($_POST['thirdRegionStaffPhone']) && ($_POST['thirdRegionStaffPhone'] != "")) {
            $txnThirdRegionStaffPhone = trim($_POST['thirdRegionStaffPhone']);
        } else {
            $txnThirdRegionStaffPhone = null;
        }

        if ($success && isset($_POST['thirdRegionStaffEmail']) && ($_POST['thirdRegionStaffEmail'] != "")) {
            $txnThirdRegionStaffEmail = trim($_POST['thirdRegionStaffEmail']);
        } else {
            $txnThirdRegionStaffEmail = null;
        }

        if ($success && isset($_POST['firstConsultantTitle']) && ($_POST['firstConsultantTitle'] != "")) {
            $txnFirstConsultantTitle = trim($_POST['firstConsultantTitle']);
        } else {
            $txnFirstConsultantTitle = null;
        }

        if ($success && isset($_POST['firstConsultantSurname']) && ($_POST['firstConsultantSurname'] != "")) {
            $txnFirstConsultantSurname = trim($_POST['firstConsultantSurname']);
        } else {
            $txnFirstConsultantSurname = null;
        }

        if ($success && isset($_POST['firstConsultantOtherName']) && ($_POST['firstConsultantOtherName'] != "")) {
            $txnFirstConsultantOtherName = trim($_POST['firstConsultantOtherName']);
        } else {
            $txnFirstConsultantOtherName = null;
        }

        if ($success && isset($_POST['firstConsultantCompany']) && ($_POST['firstConsultantCompany'] != "")) {
            $txnFirstConsultantCompany = trim($_POST['firstConsultantCompany']);
        } else {
            $txnFirstConsultantCompany = null;
        }

        if ($success && isset($_POST['firstConsultantPhone']) && ($_POST['firstConsultantPhone'] != "")) {
            $txnFirstConsultantPhone = trim($_POST['firstConsultantPhone']);
        } else {
            $txnFirstConsultantPhone = null;
        }

        if ($success && isset($_POST['firstConsultantEmail']) && ($_POST['firstConsultantEmail'] != "")) {
            $txnFirstConsultantEmail = trim($_POST['firstConsultantEmail']);
        } else {
            $txnFirstConsultantEmail = null;
        }

        if ($success && isset($_POST['projectOwnerTitle']) && ($_POST['projectOwnerTitle'] != "")) {
            $txnProjectOwnerTitle = trim($_POST['projectOwnerTitle']);
        } else {
            $txnProjectOwnerTitle = null;
        }

        if ($success && isset($_POST['projectOwnerSurname']) && ($_POST['projectOwnerSurname'] != "")) {
            $txnProjectOwnerSurname = trim($_POST['projectOwnerSurname']);
        } else {
            $txnProjectOwnerSurname = null;
        }

        if ($success && isset($_POST['projectOwnerOtherName']) && ($_POST['projectOwnerOtherName'] != "")) {
            $txnProjectOwnerOtherName = trim($_POST['projectOwnerOtherName']);
        } else {
            $txnProjectOwnerOtherName = null;
        }

        if ($success && isset($_POST['projectOwnerCompany']) && ($_POST['projectOwnerCompany'] != "")) {
            $txnProjectOwnerCompany = trim($_POST['projectOwnerCompany']);
        } else {
            $txnProjectOwnerCompany = null;
        }

        if ($success && isset($_POST['projectOwnerPhone']) && ($_POST['projectOwnerPhone'] != "")) {
            $txnProjectOwnerPhone = trim($_POST['projectOwnerPhone']);
        } else {
            $txnProjectOwnerPhone = null;
        }

        if ($success && isset($_POST['projectOwnerEmail']) && ($_POST['projectOwnerEmail'] != "")) {
            $txnProjectOwnerEmail = trim($_POST['projectOwnerEmail']);
        } else {
            $txnProjectOwnerEmail = null;
        }

        if ($success) {
            $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
            $lastUpdatedTime = date("Y-m-d H:i");

            $sql = 'UPDATE "tbl_planning_ahead" SET "project_title"=?, "scheme_no"=?, "region_id"=?, ';
            $sql = $sql . '"project_type_id"=?, "commission_date"=?, "key_infra"=?, "temp_project"=?, ';
            $sql = $sql . '"first_region_staff_name"=?, "first_region_staff_phone"=?, "first_region_staff_email"=?, ';
            $sql = $sql . '"second_region_staff_name"=?, "second_region_staff_phone"=?, "second_region_staff_email"=?, ';
            $sql = $sql . '"third_region_staff_name"=?, "third_region_staff_phone"=?, "third_region_staff_email"=?, ';
            $sql = $sql . '"first_consultant_title"=?, "first_consultant_surname"=?, "first_consultant_other_name"=?, ';
            $sql = $sql . '"first_consultant_company"=?, "first_consultant_phone"=?, "first_consultant_email"=?, ';
            $sql = $sql . '"project_owner_title"=?, "project_owner_surname"=?, "project_owner_other_name"=?, ';
            $sql = $sql . '"project_owner_company"=?, "project_owner_phone"=?, "project_owner_email"=?, "state"=?, ';
            $sql = $sql . '"last_updated_by"=?, "last_updated_time"=? ';
            $sql = $sql . 'WHERE "planning_ahead_id"=?';

            try {



                $currState = Yii::app()->formDao->getPlanningAheadDetails($txnSchemeNo);
                $txnNewState = $currState['state'];

                if (($currState['state']=="WAITING_INITIAL_INFO") && ($txnRoleId == "2")){
                    $txnNewState = "WAITING_INITIAL_INFO_BY_REGION_STAFF";
                } else if (($currState['state']=="WAITING_INITIAL_INFO") && ($txnRoleId == "3")){
                    $txnNewState = "WAITING_INITIAL_INFO_BY_PQ";
                } else if (($currState['state']=="WAITING_INITIAL_INFO_BY_REGION_STAFF") && ($txnRoleId == "3")){
                    $txnNewState = "COMPLETED_INITIAL_INFO";
                } else if (($currState['state']=="WAITING_INITIAL_INFO_BY_PQ") && ($txnRoleId == "2")){
                    $txnNewState = "COMPLETED_INITIAL_INFO";
                }

                //We start our transaction.
                //$pdo->beginTransaction();
                $transaction = Yii::app()->db->beginTransaction();

                $stmt = Yii::app()->db->createCommand($sql);

                $result = $stmt->execute(array(
                    $txnProjectTitle,$txnSchemeNo,$txnRegion,
                    $txnTypeOfProject,$txnCommissionDate,$txnKeyInfra,$txnTempProj,
                    $txnFirstRegionStaffName,$txnFirstRegionStaffPhone,$txnFirstRegionStaffEmail,
                    $txnSecondRegionStaffName,$txnSecondRegionStaffPhone,$txnSecondRegionStaffEmail,
                    $txnThirdRegionStaffName,$txnThirdRegionStaffPhone,$txnThirdRegionStaffEmail,
                    $txnFirstConsultantTitle,$txnFirstConsultantSurname,$txnFirstConsultantOtherName,
                    $txnFirstConsultantCompany,$txnFirstConsultantPhone,$txnFirstConsultantEmail,
                    $txnProjectOwnerTitle,$txnProjectOwnerSurname,$txnProjectOwnerOtherName,
                    $txnProjectOwnerCompany,$txnProjectOwnerPhone,$txnProjectOwnerEmail,$txnNewState,
                    $lastUpdatedBy,$lastUpdatedTime,
                    $txnPlanningAheadId));

                $transaction->commit();

                $retJson['status'] = 'OK';

            } catch (PDOException $e) {

                //An exception has occured, which means that one of our database queries failed.
                //Print out the error message.
                $retJson['status'] = 'NOTOK';
                $retJson['retMessage'] = $e->getMessage();
                //Rollback the transaction.
                //$pdo->rollBack();
                $transaction->rollBack();
            }
        } else {
            $retJson['status'] = 'NOTOK';
        }

        echo json_encode($retJson);
    }
}
