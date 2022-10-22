<?php

use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\PhpWord;

Yii::import('application.vendor.autoload', true);

class PlanningAheadController extends Controller {

    public function filters()
    {
        return array(
            array(
                'application.filters.AccessControlFilter',

            ),
        );
    }

    // *************************************
    // ***** Web application function ******
    // *************************************

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

            $recordList = Yii::app()->planningAheadDao->getPlanningAheadDetails($schemeNo);
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
            $this->viewbag['projectTypeList'] = Yii::app()->planningAheadDao->getPlanningAheadProjectTypeList();
            $this->viewbag['consultantCompanyList'] = Yii::app()->planningAheadDao->getPlanningAheadConsultantCompanyAllActive();
            $this->viewbag['regionList'] = Yii::app()->planningAheadDao->getPlanningAheadRegionAllActive();
            $this->viewbag['isError'] = false;
        } else {
            $this->viewbag['isError'] = true;
            $this->viewbag['errorMsg'] = 'Please provide Scheme No.!';
        }

        $this->render("//site/Form/PlanningAheadDetail");
    }

    public function actionGetPlanningAheadProjectDetailStandardLetterTemplate() {

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        $standLetterIssueDate = $param['standLetterIssueDate'];
        $standLetterFaxRefNo = $param['standLetterFaxRefNo'];
        $schemeNo = $param['schemeNo'];

        $recordList = Yii::app()->planningAheadDao->getPlanningAheadDetails($schemeNo);

        // Update the issue date and fax ref no. to database first
        Yii::app()->planningAheadDao->updateStandardLetter($recordList['planningAheadId'], $standLetterIssueDate, $standLetterFaxRefNo);

        $projectType = Yii::app()->planningAheadDao->getPlanningAheadProjectTypeById($recordList['projectTypeId']);
        $standardLetterTemplatePath = Yii::app()->commonUtil->getConfigValueByConfigName('planningAheadStandardLetterTemplatePath');

        $templateProcessor = new TemplateProcessor($standardLetterTemplatePath['configValue'] . $projectType[0]['projectTypeTemplateFileName']);
        $templateProcessor->setValue('consultantTitle', $recordList['firstConsultantTitle']);
        $templateProcessor->setValue('consultantSurname', $recordList['firstConsultantSurname']);
        $templateProcessor->setValue('consultantCompanyName', $recordList['firstConsultantCompanyName']);
        $templateProcessor->setValue('consultantEmail', $recordList['firstConsultantEmail']);
        $templateProcessor->setValue('faxRefNo', $standLetterFaxRefNo);
        $templateProcessor->setValue('issueDate', $standLetterIssueDate);
        $templateProcessor->setValue('projectTitle', $recordList['projectTitle']);

        $pathToSave = $standardLetterTemplatePath['configValue'] . 'temp\\(' . $schemeNo . ')' . $projectType[0]['projectTypeTemplateFileName'];
        $templateProcessor->saveAs($pathToSave);

        header("Content-Description: File Transfer");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header('Content-Disposition: attachment; filename='. basename($pathToSave));
        header('Content-Length: ' . filesize($pathToSave));
        header('Pragma: public');

        //Clear system output buffer
        flush();

        //Read the size of the file
        readfile($pathToSave,true);

        die();

    }


    // *************************************
    // ***** Ajax function ******
    // *************************************

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

        if ($success && isset($_POST['standLetterIssueDate']) && ($_POST['standLetterIssueDate'] != "")) {
            $txnStandLetterIssueDate = trim($_POST['standLetterIssueDate']);
        } else {
            $txnStandLetterIssueDate = null;
        }

        if ($success && isset($_POST['standLetterFaxRefNo']) && ($_POST['standLetterFaxRefNo'] != "")) {
            $txnStandLetterFaxRefNo = trim($_POST['standLetterFaxRefNo']);
        } else {
            $txnStandLetterFaxRefNo = null;
        }

        if ($success && isset($_POST['standLetterEdmsLink']) && ($_POST['standLetterEdmsLink'] != "")) {
            $txnStandLetterEdmsLink = trim($_POST['standLetterEdmsLink']);
        } else {
            $txnStandLetterEdmsLink = null;
        }

        $txnStandLetterLetterLoc = null;

        if ($success && !empty($_FILES["standSignedLetter"]["name"])) {
            $fileName = basename($_FILES["standSignedLetter"]["name"]);
            $planningAheadStandardSignedLetterPath = Yii::app()->commonUtil->getConfigValueByConfigName('planningAheadStandardLetterPath');
            $targetFilePath = $planningAheadStandardSignedLetterPath["configValue"] . $txnSchemeNo . '_' . $fileName;
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            $txnStandLetterLetterLoc = $targetFilePath;

            //upload file to server
            if (!move_uploaded_file($_FILES["standSignedLetter"]["tmp_name"], $targetFilePath)){
                $retJson['status'] = 'NOTOK';
                $retJson['retMessage'] = "Upload signed standard letter failed!";
                $success = false;
            }
        }

        if ($success) {
            $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
            $lastUpdatedTime = date("Y-m-d H:i");

            $retJson = Yii::app()->planningAheadDao->updatePlanningAheadDetailDraft($txnProjectTitle,$txnSchemeNo,$txnRegion,
                $txnTypeOfProject,$txnCommissionDate,$txnKeyInfra,$txnTempProj,
                $txnFirstRegionStaffName,$txnFirstRegionStaffPhone,$txnFirstRegionStaffEmail,
                $txnSecondRegionStaffName,$txnSecondRegionStaffPhone,$txnSecondRegionStaffEmail,
                $txnThirdRegionStaffName,$txnThirdRegionStaffPhone,$txnThirdRegionStaffEmail,
                $txnFirstConsultantTitle,$txnFirstConsultantSurname,$txnFirstConsultantOtherName,
                $txnFirstConsultantCompany,$txnFirstConsultantPhone,$txnFirstConsultantEmail,
                $txnProjectOwnerTitle,$txnProjectOwnerSurname,$txnProjectOwnerOtherName,
                $txnProjectOwnerCompany,$txnProjectOwnerPhone,$txnProjectOwnerEmail,
                $txnStandLetterIssueDate,$txnStandLetterFaxRefNo,$txnStandLetterEdmsLink,
                $txnStandLetterLetterLoc,
                $lastUpdatedBy,$lastUpdatedTime,
                $txnPlanningAheadId);

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

        if ($success && isset($_POST['standLetterIssueDate']) && ($_POST['standLetterIssueDate'] != "")) {
            $txnStandLetterIssueDate = trim($_POST['standLetterIssueDate']);
        } else {
            $txnStandLetterIssueDate = null;
        }

        if ($success && isset($_POST['standLetterFaxRefNo']) && ($_POST['standLetterFaxRefNo'] != "")) {
            $txnStandLetterFaxRefNo = trim($_POST['standLetterFaxRefNo']);
        } else {
            $txnStandLetterFaxRefNo = null;
        }

        if ($success && isset($_POST['standLetterEdmsLink']) && ($_POST['standLetterEdmsLink'] != "")) {
            $txnStandLetterEdmsLink = trim($_POST['standLetterEdmsLink']);
        } else {
            $txnStandLetterEdmsLink = null;
        }

        if ($success && isset($_POST['standLetterLetterLoc']) && ($_POST['standLetterLetterLoc'] != "")) {
            $txnStandLetterLetterLoc = trim($_POST['standLetterLetterLoc']);
        } else {
            $txnStandLetterLetterLoc = null;
        }

        if ($success && !empty($_FILES["standSignedLetter"]["name"])) {
            $fileName = basename($_FILES["standSignedLetter"]["name"]);
            $planningAheadStandardSignedLetterPath = Yii::app()->commonUtil->getConfigValueByConfigName('planningAheadStandardLetterPath');
            $targetFilePath = $planningAheadStandardSignedLetterPath["configValue"] . $txnSchemeNo . '_' . $fileName;
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            $txnStandLetterLetterLoc = $targetFilePath;

            //upload file to server
            if (!move_uploaded_file($_FILES["standSignedLetter"]["tmp_name"], $targetFilePath)){
                $retJson['status'] = 'NOTOK';
                $retJson['retMessage'] = "Upload signed standard letter failed!";
                $success = false;
            }
        }

        if ($success) {
            $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
            $lastUpdatedTime = date("Y-m-d H:i");

            try {

                $currState = Yii::app()->planningAheadDao->getPlanningAheadDetails($txnSchemeNo);
                $txnNewState = $currState['state'];

                if (($currState['state']=="WAITING_INITIAL_INFO") && ($txnRoleId == "2")){
                    $txnNewState = "WAITING_INITIAL_INFO_BY_REGION_STAFF";
                } else if (($currState['state']=="WAITING_INITIAL_INFO") && ($txnRoleId == "3")){
                    $txnNewState = "WAITING_INITIAL_INFO_BY_PQ";
                } else if (($currState['state']=="WAITING_INITIAL_INFO_BY_REGION_STAFF") && ($txnRoleId == "3")){
                    $txnNewState = "COMPLETED_INITIAL_INFO";
                } else if (($currState['state']=="WAITING_INITIAL_INFO_BY_PQ") && ($txnRoleId == "2")){
                    $txnNewState = "COMPLETED_INITIAL_INFO";
                } else if ($currState['state']=="WAITING_STANDARD_LETTER"){
                    $txnNewState = "COMPLETED_STANDARD_LETTER";
                }

                $retJson = Yii::app()->planningAheadDao->updatePlanningAheadDetailProcess($txnProjectTitle,$txnSchemeNo,$txnRegion,
                    $txnTypeOfProject,$txnCommissionDate,$txnKeyInfra,$txnTempProj,
                    $txnFirstRegionStaffName,$txnFirstRegionStaffPhone,$txnFirstRegionStaffEmail,
                    $txnSecondRegionStaffName,$txnSecondRegionStaffPhone,$txnSecondRegionStaffEmail,
                    $txnThirdRegionStaffName,$txnThirdRegionStaffPhone,$txnThirdRegionStaffEmail,
                    $txnFirstConsultantTitle,$txnFirstConsultantSurname,$txnFirstConsultantOtherName,
                    $txnFirstConsultantCompany,$txnFirstConsultantPhone,$txnFirstConsultantEmail,
                    $txnProjectOwnerTitle,$txnProjectOwnerSurname,$txnProjectOwnerOtherName,
                    $txnProjectOwnerCompany,$txnProjectOwnerPhone,$txnProjectOwnerEmail,
                    $txnStandLetterIssueDate,$txnStandLetterFaxRefNo,$txnStandLetterEdmsLink,
                    $txnStandLetterLetterLoc,
                    $txnNewState, $lastUpdatedBy,$lastUpdatedTime,
                    $txnPlanningAheadId);

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
?>