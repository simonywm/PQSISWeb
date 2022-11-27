<?php

use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\PhpWord\Element\ListItem;

Yii::import('application.vendor.PHPExcel', true);
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

    // *********************************************************************
    // Load the information page for the Planning Ahead
    // *********************************************************************
    public function actionGetPlanningAheadInfoSearch() {
        // Only allow PG Admin for this function
        if (Yii::app()->session['tblUserDo']['roleId']!=2) {
            $this->viewbag['isError'] = true;
            $this->viewbag['errorMsg'] = 'You do not have the privilege to upload condition letter.';
            $this->render("//site/Form/PlanningAheadDetailError");
        } else {
            $this->viewbag['projectTypeList'] = Yii::app()->planningAheadDao->getPlanningAheadProjectTypeList();
            $this->viewbag['searchProjectTypeId'] = "";
            $this->viewbag['isError'] = false;
            $this->render("//site/Form/PlanningAheadInfoSearch");
        }
    }

    // *********************************************************************
    // Load the upload form for allowing PG staff to upload Condition Letter
    // *********************************************************************
    public function actionGetUploadConditionLetterForm() {

        // Only allow PG Admin for this function
        if (Yii::app()->session['tblUserDo']['roleId']!=2) {
            $this->viewbag['isError'] = true;
            $this->viewbag['errorMsg'] = 'You do not have the privilege to upload condition letter.';
            $this->render("//site/Form/PlanningAheadDetailError");
        } else {
            $this->render("//site/Form/PlanningAheadUploadConditionLetter");
        }
    }

    // *********************************************************************
    // Save the uploaded condition letter to pre-defined condition letter
    // path in server.
    // *********************************************************************
    public function actionPostUploadConditionLetter() {

        // Only allow PG Admin for this function
        if (Yii::app()->session['tblUserDo']['roleId']!=2) {
            $this->viewbag['isError'] = true;
            $this->viewbag['errorMsg'] = 'You do not have the privilege to upload condition letter.';
            $this->render("//site/Form/PlanningAheadDetailError");
        } else {
            if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {
                $fileName = basename($_FILES["file"]["name"]);
                $planningAheadConditionLetterPath = Yii::app()->commonUtil->getConfigValueByConfigName('planningAheadConditionLetterPath');
                $targetFilePath = $planningAheadConditionLetterPath["configValue"] . $fileName;
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

                // Only allow PDF file format for the condition letter
                $allowTypes = array('pdf');
                if (in_array($fileType, $allowTypes)){
                    // Upload the file to server
                    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                        $this->viewbag['resultMsg'] = "The file <strong>[" . $fileName . "]</strong> has been uploaded.";
                        $this->viewbag['IsUploadSuccess'] = true;
                    }else{
                        $this->viewbag['resultMsg']  = "Sorry, there was an error when uploading your file!";
                        $this->viewbag['IsUploadSuccess'] = false;
                    }
                } else {
                    $this->viewbag['resultMsg'] = "The file <strong>[" . $fileName . "]</strong> is not in <Strong>PDF format</strong>!";
                    $this->viewbag['IsUploadSuccess'] = false;
                }
            } else {
                $this->viewbag['IsUploadSuccess'] = false;
                $this->viewbag['resultMsg'] = 'Please select the condition letter to upload!';
            }

            $this->render("//site/Form/PlanningAheadUploadConditionLetter");
        }
    }

    // process the uploaded consultant meeting information file and save its information to DB
    public function actionPostUploadConsultantMeetingInfo() {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        if (Yii::app()->session['tblUserDo']['roleId']!=2) {
            $this->viewbag['isError'] = true;
            $this->viewbag['errorMsg'] = 'You do not have the privilege to upload consultant meeting information file.';
            $this->render("//site/Form/PlanningAheadDetailError");
        } else {
            if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {

                $fileName = basename($_FILES["file"]["name"]);
                $planningAheadConsultantMeetingPath = Yii::app()->commonUtil->getConfigValueByConfigName('planningAheadConsultantMeetingFilePath');
                $targetFilePath = $planningAheadConsultantMeetingPath["configValue"] . date("Y_m_d_H_i_s_") . $fileName;
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

                //allow certain file formats
                $allowTypes = array('xlsx');
                if (in_array($fileType, $allowTypes)){
                    //upload file to server
                    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){

                        $objPHPExcel = new PHPExcel();
                        $inputFileType = PHPExcel_IOFactory::identify($targetFilePath);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objReader->setReadDataOnly(true);

                        $objPHPExcel = $objReader->load($targetFilePath);
                        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
                        $highestRow = $objWorksheet->getHighestRow();

                        $successCount = 0;
                        $failCount = 0;
                        $failSchemeNo = "";

                        for ($row = 2; $row <= $highestRow; ++$row) {

                            $excelSchemeNo = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();

                            if (!isset($excelSchemeNo)) {
                                continue;
                            }

                            $excel1stPreferredMeetingDate = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
                            $excel2ndPreferredMeetingDate = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
                            $excelRejectReason = $objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
                            $excelConsentedByConsultant = $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
                            $excelConsentedByProjectOwner = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
                            $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
                            $lastUpdatedTime = date("Y-m-d H:i");

                            $result = Yii::app()->planningAheadDao->updateConsultantMeetingInfo($excelSchemeNo,$excel1stPreferredMeetingDate,
                                $excel2ndPreferredMeetingDate,$excelRejectReason,$excelConsentedByConsultant,$excelConsentedByProjectOwner,
                                $lastUpdatedBy,$lastUpdatedTime);
                            if ($result['status'] == 'OK') {
                                $successCount++;
                            } else {
                                $failSchemeNo = $failSchemeNo . $excelSchemeNo . ",";
                                $failCount++;
                            }
                        }

                        if ($failCount > 0) {
                            $this->viewbag['resultMsg'] = "The file [". $fileName . "] has been uploaded. Total [" .
                                ($successCount + $failCount) . '], Success [' . $successCount . '], Failed [' . $failCount . ':' .
                                substr($failSchemeNo,0,(strlen($failSchemeNo)-1)) . ']';
                        } else {
                            $this->viewbag['resultMsg'] = "The file [". $fileName . "] has been uploaded. Total [" .
                                ($successCount + $failCount) . '], Success [' . $successCount . '], Failed [' . $failCount . ']' ;
                        }

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
                $this->viewbag['resultMsg'] = 'Please select the consultant meeting information file to upload!';
            }

            $this->render("//site/Form/PlanningAheadUploadConsultantMeetingInfo");
        }
    }

    // *********************************************************************
    // Load the upload form for allowing user to upload Reply Slip File
    // *********************************************************************
    public function actionGetUploadReplySlipForm() {

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        if (Yii::app()->session['tblUserDo']['roleId']!=2) {
            $this->viewbag['isError'] = true;
            $this->viewbag['errorMsg'] = 'You do not have the privilege to upload reply slip file.';
            $this->render("//site/Form/PlanningAheadDetailError");
        } else {
            $this->render("//site/Form/PlanningAheadUploadReplySlip");
        }
    }

    // *********************************************************************
    // process the uploaded consultant meeting information file and save
    // its information to DB
    // *********************************************************************
    public function actionPostUploadReplySlip() {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        if (Yii::app()->session['tblUserDo']['roleId']!=2) {
            $this->viewbag['isError'] = true;
            $this->viewbag['errorMsg'] = 'You do not have the privilege to upload reply slip file.';
            $this->render("//site/Form/PlanningAheadDetailError");
        } else {
            if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {

                $fileName = basename($_FILES["file"]["name"]);
                $planningAheadReplySlipPath = Yii::app()->commonUtil->getConfigValueByConfigName('planningAheadReplySlipFilePath');
                $targetFilePath = $planningAheadReplySlipPath["configValue"] . date("Y_m_d_H_i_s_") . $fileName;
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

                //allow certain file formats
                $allowTypes = array('xlsx');
                if (in_array($fileType, $allowTypes)){
                    //upload file to server
                    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){

                        $objPHPExcel = new PHPExcel();
                        $inputFileType = PHPExcel_IOFactory::identify($targetFilePath);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objReader->setReadDataOnly(true);

                        $objPHPExcel = $objReader->load($targetFilePath);
                        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
                        $highestRow = $objWorksheet->getHighestRow();

                        $successCount = 0;
                        $failCount = 0;
                        $failSchemeNo = "";

                        for ($row = 2; $row <= $highestRow; ++$row) {

                            $excelSchemeNo = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();

                            if (!isset($excelSchemeNo)) {
                                continue;
                            }

                            $excelMeetingRejReason = $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();

                            $excelMeetingFirstPreferMeetingDate = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
                            if (isset($excelMeetingFirstPreferMeetingDate) && ($excelMeetingFirstPreferMeetingDate != "")) {
                                $excelMeetingFirstPreferMeetingDate = date($format = "Y-m-d H:i", PHPExcel_Shared_Date::ExcelToPHP($excelMeetingFirstPreferMeetingDate));
                            }

                            $excelMeetingSecondPreferMeetingDate = $objWorksheet->getCellByColumnAndRow(6, $row)->getValue();
                            if (isset($excelMeetingSecondPreferMeetingDate) && ($excelMeetingSecondPreferMeetingDate != "")) {
                                $excelMeetingSecondPreferMeetingDate = date($format = "Y-m-d H:i", PHPExcel_Shared_Date::ExcelToPHP($excelMeetingSecondPreferMeetingDate));
                            }

                            $excelBmsYesNo = $objWorksheet->getCellByColumnAndRow(7, $row)->getValue();
                            if (strtoupper($excelBmsYesNo) == 'YES') {
                                $excelBmsYesNo = 'Y';
                            } else {
                                $excelBmsYesNo = 'N';
                            }
                            $excelBmsServerCentralComputer = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(8, $row)->getValue());
                            $excelBmsDdc = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(9, $row)->getValue());
                            $excelChangeoverSchemeYesNo = $objWorksheet->getCellByColumnAndRow(10, $row)->getValue();
                            if (strtoupper($excelChangeoverSchemeYesNo) == 'YES') {
                                $excelChangeoverSchemeYesNo = 'Y';
                            } else {
                                $excelChangeoverSchemeYesNo = 'N';
                            }
                            $excelChangeoverSchemeControl = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(11, $row)->getValue());
                            $excelChangeoverSchemeUv = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(12, $row)->getValue());
                            $excelChillerPlantYesNo = $objWorksheet->getCellByColumnAndRow(13, $row)->getValue();
                            if (strtoupper($excelChillerPlantYesNo) == 'YES') {
                                $excelChillerPlantYesNo = 'Y';
                            } else {
                                $excelChillerPlantYesNo = 'N';
                            }
                            $excelChillerPlantAhuControl = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(14, $row)->getValue());
                            $excelChillerPlantAhuStartup = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(15, $row)->getValue());
                            $excelChillerPlantVsd = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(16, $row)->getValue());
                            $excelChillerPlantAhuChilledWater = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(17, $row)->getValue());
                            $excelChillerPlantStandbyAhu = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(18, $row)->getValue());
                            $excelChillerPlantChiller = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(19, $row)->getValue());
                            $excelEscalatorYesNo = $objWorksheet->getCellByColumnAndRow(20, $row)->getValue();
                            if (strtoupper($excelEscalatorYesNo) == 'YES') {
                                $excelEscalatorYesNo = 'Y';
                            } else {
                                $excelEscalatorYesNo = 'N';
                            }
                            $excelEscalatorMotorStartup = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(21, $row)->getValue());
                            $excelEscalatorVsdMitigation = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(22, $row)->getValue());
                            $excelEscalatorBrakingSystem = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(23, $row)->getValue());
                            $excelEscalatorControl = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(24, $row)->getValue());
                            $excelLiftYesNo = $objWorksheet->getCellByColumnAndRow(25, $row)->getValue();
                            if (strtoupper($excelLiftYesNo) == 'YES') {
                                $excelLiftYesNo = 'Y';
                            } else {
                                $excelLiftYesNo = 'N';
                            }
                            $excelLiftOperation = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(26, $row)->getValue());
                            $excelHidLampYesNo = $objWorksheet->getCellByColumnAndRow(27, $row)->getValue();
                            if (strtoupper($excelHidLampYesNo) == 'YES') {
                                $excelHidLampYesNo = 'Y';
                            } else {
                                $excelHidLampYesNo = 'N';
                            }
                            $excelHidLampMitigation = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(28, $row)->getValue());
                            $excelSensitiveMachineYesNo = $objWorksheet->getCellByColumnAndRow(29, $row)->getValue();
                            if (strtoupper($excelSensitiveMachineYesNo) == 'YES') {
                                $excelSensitiveMachineYesNo = 'Y';
                            } else {
                                $excelSensitiveMachineYesNo = 'N';
                            }
                            $excelSensitiveMachineMitigation = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(30, $row)->getValue());
                            $excelTelecomMachineYesNo = $objWorksheet->getCellByColumnAndRow(31, $row)->getValue();
                            if (strtoupper($excelTelecomMachineYesNo) == 'YES') {
                                $excelTelecomMachineYesNo = 'Y';
                            } else {
                                $excelTelecomMachineYesNo = 'N';
                            }
                            $excelTelecomMachineServerOrComputer = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(32, $row)->getValue());
                            $excelTelecomMachinePeripherals = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(33, $row)->getValue());
                            $excelTelecomMachineHarmonicEmission = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(34, $row)->getValue());
                            $excelAirConditionersYesNo = $objWorksheet->getCellByColumnAndRow(35, $row)->getValue();
                            if (strtoupper($excelAirConditionersYesNo) == 'YES') {
                                $excelAirConditionersYesNo = 'Y';
                            } else {
                                $excelAirConditionersYesNo = 'N';
                            }
                            $excelAirConditionersMicb = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(36, $row)->getValue());
                            $excelAirConditionersLoadForecasting = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(37, $row)->getValue());
                            $excelAirConditionersType = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(38, $row)->getValue());
                            $excelNonLinearLoadYesNo = $objWorksheet->getCellByColumnAndRow(39, $row)->getValue();
                            if (strtoupper($excelNonLinearLoadYesNo) == 'YES') {
                                $excelNonLinearLoadYesNo = 'Y';
                            } else {
                                $excelNonLinearLoadYesNo = 'N';
                            }
                            $excelNonLinearLoadHarmonicEmission = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(40, $row)->getValue());
                            $excelRenewableEnergyYesNo = $objWorksheet->getCellByColumnAndRow(41, $row)->getValue();
                            if (strtoupper($excelRenewableEnergyYesNo) == 'YES') {
                                $excelRenewableEnergyYesNo = 'Y';
                            } else {
                                $excelRenewableEnergyYesNo = 'N';
                            }
                            $excelRenewableEnergyInverterAndControls = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(42, $row)->getValue());
                            $excelRenewableEnergyHarmonicEmission = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(43, $row)->getValue());
                            $excelEvChargerSystemYesNo = $objWorksheet->getCellByColumnAndRow(44, $row)->getValue();
                            if (strtoupper($excelEvChargerSystemYesNo) == 'YES') {
                                $excelEvChargerSystemYesNo = 'Y';
                            } else {
                                $excelEvChargerSystemYesNo = 'N';
                            }
                            $excelEvControlYesNo = $objWorksheet->getCellByColumnAndRow(45, $row)->getValue();
                            if (strtoupper($excelEvControlYesNo) == 'YES') {
                                $excelEvControlYesNo = 'Y';
                            } else {
                                $excelEvControlYesNo = 'N';
                            }
                            $excelEvChargerSystemEvCharger = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(46, $row)->getValue());
                            $excelEvChargerSystemSmartYesNo = $objWorksheet->getCellByColumnAndRow(47, $row)->getValue();
                            if (strtoupper($excelEvChargerSystemSmartYesNo) == 'YES') {
                                $excelEvChargerSystemSmartYesNo = 'Y';
                            } else {
                                $excelEvChargerSystemSmartYesNo = 'N';
                            }
                            $excelEvChargerSystemSmartChargingSystem = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(48, $row)->getValue());
                            $excelEvChargerSystemHarmonicEmission = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(49, $row)->getValue());

                            $excelConsultantNameConfirmation = $objWorksheet->getCellByColumnAndRow(50, $row)->getValue();
                            $excelConsultantCompany = $objWorksheet->getCellByColumnAndRow(52, $row)->getValue();

                            $excelProjectOwnerNameConfirmation = $objWorksheet->getCellByColumnAndRow(53, $row)->getValue();
                            $excelProjectOwnerCompany = $objWorksheet->getCellByColumnAndRow(55, $row)->getValue();

                            $createdBy = Yii::app()->session['tblUserDo']['username'];
                            $createdTime = date("Y-m-d H:i");
                            $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
                            $lastUpdatedTime = date("Y-m-d H:i");
                            $lastUploadTime = null;
                            $consetFromConsultant = "N";
                            $consetFromProjectOwner = "N";

                            $projectDetail = Yii::app()->planningAheadDao->getPlanningAheadDetails($excelSchemeNo);
                            if (isset($projectDetail)) {

                                if ($projectDetail['meetingReplySlipId'] == 0) {

                                    if (isset($excelConsultantNameConfirmation) && (trim($excelConsultantNameConfirmation))!="") {
                                        $consetFromConsultant = 'Y';
                                    }

                                    if ((isset($excelProjectOwnerNameConfirmation) && (trim($excelProjectOwnerNameConfirmation))!="") ||
                                        (isset($excelProjectOwnerCompany) && (trim($excelProjectOwnerCompany))!="")){
                                        $consetFromProjectOwner = 'Y';
                                    }

                                    if (($consetFromConsultant=='Y') && ($consetFromProjectOwner=='Y')) {
                                        $lastUploadTime = date("Y-m-d H:i");
                                    }

                                    $result = Yii::app()->planningAheadDao->addReplySlip($excelSchemeNo,$projectDetail['state'],$targetFilePath,
                                        $excelMeetingRejReason,$excelMeetingFirstPreferMeetingDate,$excelMeetingSecondPreferMeetingDate,
                                        $consetFromConsultant,$consetFromProjectOwner,
                                        $excelBmsYesNo,$excelBmsServerCentralComputer,$excelBmsDdc,
                                        $excelChangeoverSchemeYesNo,$excelChangeoverSchemeControl,$excelChangeoverSchemeUv,
                                        $excelChillerPlantYesNo,$excelChillerPlantAhuControl,$excelChillerPlantAhuStartup,$excelChillerPlantVsd,
                                        $excelChillerPlantAhuChilledWater,$excelChillerPlantStandbyAhu,$excelChillerPlantChiller,
                                        $excelEscalatorYesNo,$excelEscalatorMotorStartup,$excelEscalatorVsdMitigation,
                                        $excelEscalatorBrakingSystem,$excelEscalatorControl,
                                        $excelLiftYesNo,$excelLiftOperation,$excelHidLampYesNo,$excelHidLampMitigation,
                                        $excelSensitiveMachineYesNo,$excelSensitiveMachineMitigation,
                                        $excelTelecomMachineYesNo,$excelTelecomMachineServerOrComputer,$excelTelecomMachinePeripherals,
                                        $excelTelecomMachineHarmonicEmission,$excelAirConditionersYesNo,$excelAirConditionersMicb,
                                        $excelAirConditionersLoadForecasting,$excelAirConditionersType,$excelNonLinearLoadYesNo,
                                        $excelNonLinearLoadHarmonicEmission,$excelRenewableEnergyYesNo,$excelRenewableEnergyInverterAndControls,
                                        $excelRenewableEnergyHarmonicEmission,$excelEvChargerSystemYesNo,$excelEvControlYesNo,
                                        $excelEvChargerSystemEvCharger,$excelEvChargerSystemSmartYesNo,
                                        $excelEvChargerSystemSmartChargingSystem,$excelEvChargerSystemHarmonicEmission,
                                        $excelConsultantNameConfirmation,$excelConsultantCompany,
                                        $excelProjectOwnerNameConfirmation,$excelProjectOwnerCompany,
                                        $createdBy,$createdTime,$lastUpdatedBy,$lastUpdatedTime,$lastUploadTime);

                                } else {
                                    if (isset($excelConsultantNameConfirmation) && (trim($excelConsultantNameConfirmation))!="") {
                                        $consetFromConsultant = 'Y';
                                    }

                                    if ((isset($excelProjectOwnerNameConfirmation) && (trim($excelProjectOwnerNameConfirmation))!="") ||
                                        (isset($excelProjectOwnerCompany) && (trim($excelProjectOwnerCompany))!="")){
                                        $consetFromProjectOwner = 'Y';
                                    }

                                    if (($consetFromConsultant=='Y') && ($consetFromProjectOwner=='Y')) {
                                        $lastUploadTime = date("Y-m-d H:i");
                                    }

                                    $result = Yii::app()->planningAheadDao->updateReplySlip($excelSchemeNo,$projectDetail['state'],
                                        $projectDetail['meetingReplySlipId'],
                                        $targetFilePath,$excelMeetingRejReason,$excelMeetingFirstPreferMeetingDate,$excelMeetingSecondPreferMeetingDate,
                                        $consetFromConsultant,$consetFromProjectOwner,
                                        $excelBmsYesNo,$excelBmsServerCentralComputer,$excelBmsDdc,
                                        $excelChangeoverSchemeYesNo,$excelChangeoverSchemeControl,$excelChangeoverSchemeUv,
                                        $excelChillerPlantYesNo,$excelChillerPlantAhuControl,$excelChillerPlantAhuStartup,$excelChillerPlantVsd,
                                        $excelChillerPlantAhuChilledWater,$excelChillerPlantStandbyAhu,$excelChillerPlantChiller,
                                        $excelEscalatorYesNo,$excelEscalatorMotorStartup,$excelEscalatorVsdMitigation,
                                        $excelEscalatorBrakingSystem,$excelEscalatorControl,
                                        $excelLiftYesNo,$excelLiftOperation,$excelHidLampYesNo,$excelHidLampMitigation,
                                        $excelSensitiveMachineYesNo,$excelSensitiveMachineMitigation,
                                        $excelTelecomMachineYesNo,$excelTelecomMachineServerOrComputer,$excelTelecomMachinePeripherals,
                                        $excelTelecomMachineHarmonicEmission,$excelAirConditionersYesNo,$excelAirConditionersMicb,
                                        $excelAirConditionersLoadForecasting,$excelAirConditionersType,$excelNonLinearLoadYesNo,
                                        $excelNonLinearLoadHarmonicEmission,$excelRenewableEnergyYesNo,$excelRenewableEnergyInverterAndControls,
                                        $excelRenewableEnergyHarmonicEmission,$excelEvChargerSystemYesNo,$excelEvControlYesNo,
                                        $excelEvChargerSystemEvCharger,$excelEvChargerSystemSmartYesNo,
                                        $excelEvChargerSystemSmartChargingSystem,$excelEvChargerSystemHarmonicEmission,
                                        $excelConsultantNameConfirmation,$excelConsultantCompany,
                                        $excelProjectOwnerNameConfirmation,$excelProjectOwnerCompany,
                                        $lastUpdatedBy,$lastUpdatedTime,$lastUploadTime);
                                }

                                if ($result['status'] == 'OK') {
                                    $this->generateReplySlipTemplate($excelSchemeNo);
                                    $successCount++;
                                } else {
                                    $failSchemeNo = $failSchemeNo . $excelSchemeNo . ",";
                                    $failCount++;
                                }
                            } else {
                                $failSchemeNo = $failSchemeNo . $excelSchemeNo . ",";
                                $failCount++;
                            }
                        }

                        if ($failCount > 0) {
                            $this->viewbag['resultMsg'] = "The file [". $fileName . "] has been uploaded. Total [" .
                                ($successCount + $failCount) . '], Success [' . $successCount . '], Failed [' . $failCount . ':' .
                                substr($failSchemeNo,0,(strlen($failSchemeNo)-1)) . ']';
                        } else {
                            $this->viewbag['resultMsg'] = "The file [". $fileName . "] has been uploaded. Total [" .
                                ($successCount + $failCount) . '], Success [' . $successCount . '], Failed [' . $failCount . ']' ;
                        }

                        $this->viewbag['IsUploadSuccess'] = true;
                    }else{
                        $this->viewbag['resultMsg']  = "Sorry, there was an error uploading your file!";
                        $this->viewbag['IsUploadSuccess'] = false;
                    }
                } else {
                    $this->viewbag['resultMsg'] = 'Please select the reply slip in Excel format!';
                    $this->viewbag['IsUploadSuccess'] = false;
                }
            } else {
                $this->viewbag['IsUploadSuccess'] = false;
                $this->viewbag['resultMsg'] = 'Please select the consultant meeting information file to upload!';
            }

            $this->render("//site/Form/PlanningAheadUploadReplySlip");
        }
    }

    // *********************************************************************
    // Load the Planning Ahead Project Information
    // *********************************************************************
    public function actionGetPlanningAheadProjectDetailForm() {

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        if (isset($param['SchemeNo']) && (trim($param['SchemeNo']) != "")) {
            $schemeNo = $param['SchemeNo'];
            $this->viewbag['schemeNo'] = $schemeNo;

            $recordList = Yii::app()->planningAheadDao->getPlanningAheadDetails($schemeNo);

            // Only allow PG Admin & Region Staffs to access this function
            if (!isset($recordList) || $recordList == null) {
                $this->viewbag['isError'] = true;
                $this->viewbag['errorMsg'] = 'Unable to find the Scheme No. <strong>[' . $schemeNo . "]</strong> from our database.";
                $this->render("//site/Form/PlanningAheadDetailError");
            } else if (($recordList['state'] != "WAITING_INITIAL_INFO") &&
                ($recordList['state'] != "WAITING_INITIAL_INFO_BY_REGION_STAFF") &&
                ($recordList['state'] != "WAITING_INITIAL_INFO_BY_PQ") &&
                (Yii::app()->session['tblUserDo']['roleId']!=2)) {
                $this->viewbag['isError'] = true;
                $this->viewbag['errorMsg'] = 'You do not have the privilege to view Scheme No. <strong>[' . $schemeNo . "]</strong>.";
                $this->render("//site/Form/PlanningAheadDetailError");
            } else {
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
                $this->viewbag['firstConsultantCompany'] = $recordList['firstConsultantCompany'];
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
                $this->viewbag['firstProjectOwnerTitle'] = $recordList['firstProjectOwnerTitle'];
                $this->viewbag['firstProjectOwnerSurname'] = $recordList['firstProjectOwnerSurname'];
                $this->viewbag['firstProjectOwnerOtherName'] = $recordList['firstProjectOwnerOtherName'];
                $this->viewbag['firstProjectOwnerCompany'] = $recordList['firstProjectOwnerCompany'];
                $this->viewbag['firstProjectOwnerPhone'] = $recordList['firstProjectOwnerPhone'];
                $this->viewbag['firstProjectOwnerEmail'] = $recordList['firstProjectOwnerEmail'];
                $this->viewbag['secondProjectOwnerTitle'] = $recordList['secondProjectOwnerTitle'];
                $this->viewbag['secondProjectOwnerSurname'] = $recordList['secondProjectOwnerSurname'];
                $this->viewbag['secondProjectOwnerOtherName'] = $recordList['secondProjectOwnerOtherName'];
                $this->viewbag['secondProjectOwnerCompany'] = $recordList['secondProjectOwnerCompany'];
                $this->viewbag['secondProjectOwnerPhone'] = $recordList['secondProjectOwnerPhone'];
                $this->viewbag['secondProjectOwnerEmail'] = $recordList['secondProjectOwnerEmail'];
                $this->viewbag['thirdProjectOwnerTitle'] = $recordList['thirdProjectOwnerTitle'];
                $this->viewbag['thirdProjectOwnerSurname'] = $recordList['thirdProjectOwnerSurname'];
                $this->viewbag['thirdProjectOwnerOtherName'] = $recordList['thirdProjectOwnerOtherName'];
                $this->viewbag['thirdProjectOwnerCompany'] = $recordList['thirdProjectOwnerCompany'];
                $this->viewbag['thirdProjectOwnerPhone'] = $recordList['thirdProjectOwnerPhone'];
                $this->viewbag['thirdProjectOwnerEmail'] = $recordList['thirdProjectOwnerEmail'];
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
                $this->viewbag['meetingRemark'] = $recordList['meetingRemark'];
                $this->viewbag['meetingReplySlipId'] = $recordList['meetingReplySlipId'];
                $this->viewbag['replySlipBmsYesNo'] = $recordList['replySlipBmsYesNo'];
                $this->viewbag['replySlipBmsServerCentralComputer'] = $recordList['replySlipBmsServerCentralComputer'];
                $this->viewbag['replySlipBmsDdc'] = $recordList['replySlipBmsDdc'];
                $this->viewbag['replySlipChangeoverSchemeYesNo'] = $recordList['replySlipChangeoverSchemeYesNo'];
                $this->viewbag['replySlipChangeoverSchemeControl'] = $recordList['replySlipChangeoverSchemeControl'];
                $this->viewbag['replySlipChangeoverSchemeUv'] = $recordList['replySlipChangeoverSchemeUv'];
                $this->viewbag['replySlipChillerPlantYesNo'] = $recordList['replySlipChillerPlantYesNo'];
                $this->viewbag['replySlipChillerPlantAhuControl'] = $recordList['replySlipChillerPlantAhuControl'];
                $this->viewbag['replySlipChillerPlantAhuStartup'] = $recordList['replySlipChillerPlantAhuStartup'];
                $this->viewbag['replySlipChillerPlantVsd'] = $recordList['replySlipChillerPlantVsd'];
                $this->viewbag['replySlipChillerPlantAhuChilledWater'] = $recordList['replySlipChillerPlantAhuChilledWater'];
                $this->viewbag['replySlipChillerPlantStandbyAhu'] = $recordList['replySlipChillerPlantStandbyAhu'];
                $this->viewbag['replySlipChillerPlantChiller'] = $recordList['replySlipChillerPlantChiller'];
                $this->viewbag['replySlipEscalatorYesNo'] = $recordList['replySlipEscalatorYesNo'];
                $this->viewbag['replySlipEscalatorMotorStartup'] = $recordList['replySlipEscalatorMotorStartup'];
                $this->viewbag['replySlipEscalatorVsdMitigation'] = $recordList['replySlipEscalatorVsdMitigation'];
                $this->viewbag['replySlipEscalatorBrakingSystem'] = $recordList['replySlipEscalatorBrakingSystem'];
                $this->viewbag['replySlipEscalatorControl'] = $recordList['replySlipEscalatorControl'];
                $this->viewbag['replySlipHidLampYesNo'] = $recordList['replySlipHidLampYesNo'];
                $this->viewbag['replySlipHidLampMitigation'] = $recordList['replySlipHidLampMitigation'];
                $this->viewbag['replySlipLiftYesNo'] = $recordList['replySlipLiftYesNo'];
                $this->viewbag['replySlipLiftOperation'] = $recordList['replySlipLiftOperation'];
                $this->viewbag['replySlipSensitiveMachineYesNo'] = $recordList['replySlipSensitiveMachineYesNo'];
                $this->viewbag['replySlipSensitiveMachineMitigation'] = $recordList['replySlipSensitiveMachineMitigation'];
                $this->viewbag['replySlipTelecomMachineYesNo'] = $recordList['replySlipTelecomMachineYesNo'];
                $this->viewbag['replySlipTelecomMachineServerOrComputer'] = $recordList['replySlipTelecomMachineServerOrComputer'];
                $this->viewbag['replySlipTelecomMachinePeripherals'] = $recordList['replySlipTelecomMachinePeripherals'];
                $this->viewbag['replySlipTelecomMachineHarmonicEmission'] = $recordList['replySlipTelecomMachineHarmonicEmission'];
                $this->viewbag['replySlipAirConditionersYesNo'] = $recordList['replySlipAirConditionersYesNo'];
                $this->viewbag['replySlipAirConditionersMicb'] = $recordList['replySlipAirConditionersMicb'];
                $this->viewbag['replySlipAirConditionersLoadForecasting'] = $recordList['replySlipAirConditionersLoadForecasting'];
                $this->viewbag['replySlipAirConditionersType'] = $recordList['replySlipAirConditionersType'];
                $this->viewbag['replySlipNonLinearLoadYesNo'] = $recordList['replySlipNonLinearLoadYesNo'];
                $this->viewbag['replySlipNonLinearLoadHarmonicEmission'] = $recordList['replySlipNonLinearLoadHarmonicEmission'];
                $this->viewbag['replySlipRenewableEnergyYesNo'] = $recordList['replySlipRenewableEnergyYesNo'];
                $this->viewbag['replySlipRenewableEnergyInverterAndControls'] = $recordList['replySlipRenewableEnergyInverterAndControls'];
                $this->viewbag['replySlipRenewableEnergyHarmonicEmission'] = $recordList['replySlipRenewableEnergyHarmonicEmission'];
                $this->viewbag['replySlipEvChargerSystemYesNo'] = $recordList['replySlipEvChargerSystemYesNo'];
                $this->viewbag['replySlipEvControlYesNo'] = $recordList['replySlipEvControlYesNo'];
                $this->viewbag['replySlipEvChargerSystemEvCharger'] = $recordList['replySlipEvChargerSystemEvCharger'];
                $this->viewbag['replySlipEvChargerSystemSmartYesNo'] = $recordList['replySlipEvChargerSystemSmartYesNo'];
                $this->viewbag['replySlipEvChargerSystemSmartChargingSystem'] = $recordList['replySlipEvChargerSystemSmartChargingSystem'];
                $this->viewbag['replySlipEvChargerSystemHarmonicEmission'] = $recordList['replySlipEvChargerSystemHarmonicEmission'];
                $this->viewbag['replySlipConsultantNameConfirmation'] = $recordList['replySlipConsultantNameConfirmation'];
                $this->viewbag['replySlipConsultantCompany'] = $recordList['replySlipConsultantCompany'];
                $this->viewbag['replySlipProjectOwnerNameConfirmation'] = $recordList['replySlipProjectOwnerNameConfirmation'];
                $this->viewbag['replySlipProjectOwnerCompany'] = $recordList['replySlipProjectOwnerCompany'];
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
                $this->viewbag['evaReportRemark'] = $recordList['evaReportRemark'];
                $this->viewbag['evaReportEdmsLink'] = $recordList['evaReportEdmsLink'];
                $this->viewbag['evaReportIssueDate'] = $recordList['evaReportIssueDate'];
                $this->viewbag['evaReportFaxRefNo'] = $recordList['evaReportFaxRefNo'];
                $this->viewbag['evaReportScore'] = $recordList['evaReportScore'];
                $this->viewbag['evaReportBmsYesNo'] = $recordList['evaReportBmsYesNo'];
                $this->viewbag['evaReportBmsServerCentralComputerYesNo'] = $recordList['evaReportBmsServerCentralComputerYesNo'];
                $this->viewbag['evaReportBmsServerCentralComputerFinding'] = $recordList['evaReportBmsServerCentralComputerFinding'];
                $this->viewbag['evaReportBmsServerCentralComputerRecommend'] = $recordList['evaReportBmsServerCentralComputerRecommend'];
                $this->viewbag['evaReportBmsServerCentralComputerPass'] = $recordList['evaReportBmsServerCentralComputerPass'];
                $this->viewbag['evaReportBmsDdcYesNo'] = $recordList['evaReportBmsDdcYesNo'];
                $this->viewbag['evaReportBmsDdcFinding'] = $recordList['evaReportBmsDdcFinding'];
                $this->viewbag['evaReportBmsDdcRecommend'] = $recordList['evaReportBmsDdcRecommend'];
                $this->viewbag['evaReportBmsDdcPass'] = $recordList['evaReportBmsDdcPass'];
                $this->viewbag['evaReportBmsSupplementYesNo'] = $recordList['evaReportBmsSupplementYesNo'];
                $this->viewbag['evaReportBmsSupplement'] = $recordList['evaReportBmsSupplement'];
                $this->viewbag['evaReportBmsSupplementPass'] = $recordList['evaReportBmsSupplementPass'];
                $this->viewbag['evaReportChangeoverSchemeYesNo'] = $recordList['evaReportChangeoverSchemeYesNo'];
                $this->viewbag['evaReportChangeoverSchemeControlYesNo'] = $recordList['evaReportChangeoverSchemeControlYesNo'];
                $this->viewbag['evaReportChangeoverSchemeControlFinding'] = $recordList['evaReportChangeoverSchemeControlFinding'];
                $this->viewbag['evaReportChangeoverSchemeControlRecommend'] = $recordList['evaReportChangeoverSchemeControlRecommend'];
                $this->viewbag['evaReportChangeoverSchemeControlPass'] = $recordList['evaReportChangeoverSchemeControlPass'];
                $this->viewbag['evaReportChangeoverSchemeUvYesNo'] = $recordList['evaReportChangeoverSchemeUvYesNo'];
                $this->viewbag['evaReportChangeoverSchemeUvFinding'] = $recordList['evaReportChangeoverSchemeUvFinding'];
                $this->viewbag['evaReportChangeoverSchemeUvRecommend'] = $recordList['evaReportChangeoverSchemeUvRecommend'];
                $this->viewbag['evaReportChangeoverSchemeUvPass'] = $recordList['evaReportChangeoverSchemeUvPass'];
                $this->viewbag['evaReportChangeoverSchemeSupplementYesNo'] = $recordList['evaReportChangeoverSchemeSupplementYesNo'];
                $this->viewbag['evaReportChangeoverSchemeSupplement'] = $recordList['evaReportChangeoverSchemeSupplement'];
                $this->viewbag['evaReportChangeoverSchemeSupplementPass'] = $recordList['evaReportChangeoverSchemeSupplementPass'];
                $this->viewbag['evaReportChillerPlantYesNo'] = $recordList['evaReportChillerPlantYesNo'];
                $this->viewbag['evaReportChillerPlantAhuChilledWaterYesNo'] = $recordList['evaReportChillerPlantAhuChilledWaterYesNo'];
                $this->viewbag['evaReportChillerPlantAhuChilledWaterFinding'] = $recordList['evaReportChillerPlantAhuChilledWaterFinding'];
                $this->viewbag['evaReportChillerPlantAhuChilledWaterRecommend'] = $recordList['evaReportChillerPlantAhuChilledWaterRecommend'];
                $this->viewbag['evaReportChillerPlantAhuChilledWaterPass'] = $recordList['evaReportChillerPlantAhuChilledWaterPass'];
                $this->viewbag['evaReportChillerPlantChillerYesNo'] = $recordList['evaReportChillerPlantChillerYesNo'];
                $this->viewbag['evaReportChillerPlantChillerFinding'] = $recordList['evaReportChillerPlantChillerFinding'];
                $this->viewbag['evaReportChillerPlantChillerRecommend'] = $recordList['evaReportChillerPlantChillerRecommend'];
                $this->viewbag['evaReportChillerPlantChillerPass'] = $recordList['evaReportChillerPlantChillerPass'];
                $this->viewbag['evaReportChillerPlantSupplementYesNo'] = $recordList['evaReportChillerPlantSupplementYesNo'];
                $this->viewbag['evaReportChillerPlantSupplement'] = $recordList['evaReportChillerPlantSupplement'];
                $this->viewbag['evaReportChillerPlantSupplementPass'] = $recordList['evaReportChillerPlantSupplementPass'];
                $this->viewbag['evaReportEscalatorYesNo'] = $recordList['evaReportEscalatorYesNo'];
                $this->viewbag['evaReportEscalatorBrakingSystemYesNo'] = $recordList['evaReportEscalatorBrakingSystemYesNo'];
                $this->viewbag['evaReportEscalatorBrakingSystemFinding'] = $recordList['evaReportEscalatorBrakingSystemFinding'];
                $this->viewbag['evaReportEscalatorBrakingSystemRecommend'] = $recordList['evaReportEscalatorBrakingSystemRecommend'];
                $this->viewbag['evaReportEscalatorBrakingSystemPass'] = $recordList['evaReportEscalatorBrakingSystemPass'];
                $this->viewbag['evaReportEscalatorControlYesNo'] = $recordList['evaReportEscalatorControlYesNo'];
                $this->viewbag['evaReportEscalatorControlFinding'] = $recordList['evaReportEscalatorControlFinding'];
                $this->viewbag['evaReportEscalatorControlRecommend'] = $recordList['evaReportEscalatorControlRecommend'];
                $this->viewbag['evaReportEscalatorControlPass'] = $recordList['evaReportEscalatorControlPass'];
                $this->viewbag['evaReportEscalatorSupplementYesNo'] = $recordList['evaReportEscalatorSupplementYesNo'];
                $this->viewbag['evaReportEscalatorSupplement'] = $recordList['evaReportEscalatorSupplement'];
                $this->viewbag['evaReportEscalatorSupplementPass'] = $recordList['evaReportEscalatorSupplementPass'];
                $this->viewbag['evaReportLiftYesNo'] = $recordList['evaReportLiftYesNo'];
                $this->viewbag['evaReportLiftOperationYesNo'] = $recordList['evaReportLiftOperationYesNo'];
                $this->viewbag['evaReportLiftOperationFinding'] = $recordList['evaReportLiftOperationFinding'];
                $this->viewbag['evaReportLiftOperationRecommend'] = $recordList['evaReportLiftOperationRecommend'];
                $this->viewbag['evaReportLiftOperationPass'] = $recordList['evaReportLiftOperationPass'];
                $this->viewbag['evaReportLiftMainSupplyYesNo'] = $recordList['evaReportLiftMainSupplyYesNo'];
                $this->viewbag['evaReportLiftMainSupplyFinding'] = $recordList['evaReportLiftMainSupplyFinding'];
                $this->viewbag['evaReportLiftMainSupplyRecommend'] = $recordList['evaReportLiftMainSupplyRecommend'];
                $this->viewbag['evaReportLiftMainSupplyPass'] = $recordList['evaReportLiftMainSupplyPass'];
                $this->viewbag['evaReportLiftSupplementYesNo'] = $recordList['evaReportLiftSupplementYesNo'];
                $this->viewbag['evaReportLiftSupplement'] = $recordList['evaReportLiftSupplement'];
                $this->viewbag['evaReportLiftSupplementPass'] = $recordList['evaReportLiftSupplementPass'];
                $this->viewbag['evaReportHidLampYesNo'] = $recordList['evaReportHidLampYesNo'];
                $this->viewbag['evaReportHidLampBallastYesNo'] = $recordList['evaReportHidLampBallastYesNo'];
                $this->viewbag['evaReportHidLampBallastFinding'] = $recordList['evaReportHidLampBallastFinding'];
                $this->viewbag['evaReportHidLampBallastRecommend'] = $recordList['evaReportHidLampBallastRecommend'];
                $this->viewbag['evaReportHidLampBallastPass'] = $recordList['evaReportHidLampBallastPass'];
                $this->viewbag['evaReportHidLampAddonProtectYesNo'] = $recordList['evaReportHidLampAddonProtectYesNo'];
                $this->viewbag['evaReportHidLampAddonProtectFinding'] = $recordList['evaReportHidLampAddonProtectFinding'];
                $this->viewbag['evaReportHidLampAddonProtectRecommend'] = $recordList['evaReportHidLampAddonProtectRecommend'];
                $this->viewbag['evaReportHidLampAddonProtectPass'] = $recordList['evaReportHidLampAddonProtectPass'];
                $this->viewbag['evaReportHidLampSupplementYesNo'] = $recordList['evaReportHidLampSupplementYesNo'];
                $this->viewbag['evaReportHidLampSupplement'] = $recordList['evaReportHidLampSupplement'];
                $this->viewbag['evaReportHidLampSupplementPass'] = $recordList['evaReportHidLampSupplementPass'];
                $this->viewbag['evaReportSensitiveMachineYesNo'] = $recordList['evaReportSensitiveMachineYesNo'];
                $this->viewbag['evaReportSensitiveMachineMedicalYesNo'] = $recordList['evaReportSensitiveMachineMedicalYesNo'];
                $this->viewbag['evaReportSensitiveMachineMedicalFinding'] = $recordList['evaReportSensitiveMachineMedicalFinding'];
                $this->viewbag['evaReportSensitiveMachineMedicalRecommend'] = $recordList['evaReportSensitiveMachineMedicalRecommend'];
                $this->viewbag['evaReportSensitiveMachineMedicalPass'] = $recordList['evaReportSensitiveMachineMedicalPass'];
                $this->viewbag['evaReportSensitiveMachineSupplementYesNo'] = $recordList['evaReportSensitiveMachineSupplementYesNo'];
                $this->viewbag['evaReportSensitiveMachineSupplement'] = $recordList['evaReportSensitiveMachineSupplement'];
                $this->viewbag['evaReportSensitiveMachineSupplementPass'] = $recordList['evaReportSensitiveMachineSupplementPass'];
                $this->viewbag['evaReportTelecomMachineYesNo'] = $recordList['evaReportTelecomMachineYesNo'];
                $this->viewbag['evaReportTelecomMachineServerOrComputerYesNo'] = $recordList['evaReportTelecomMachineServerOrComputerYesNo'];
                $this->viewbag['evaReportTelecomMachineServerOrComputerFinding'] = $recordList['evaReportTelecomMachineServerOrComputerFinding'];
                $this->viewbag['evaReportTelecomMachineServerOrComputerRecommend'] = $recordList['evaReportTelecomMachineServerOrComputerRecommend'];
                $this->viewbag['evaReportTelecomMachineServerOrComputerPass'] = $recordList['evaReportTelecomMachineServerOrComputerPass'];
                $this->viewbag['evaReportTelecomMachinePeripheralsYesNo'] = $recordList['evaReportTelecomMachinePeripheralsYesNo'];
                $this->viewbag['evaReportTelecomMachinePeripheralsFinding'] = $recordList['evaReportTelecomMachinePeripheralsFinding'];
                $this->viewbag['evaReportTelecomMachinePeripheralsRecommend'] = $recordList['evaReportTelecomMachinePeripheralsRecommend'];
                $this->viewbag['evaReportTelecomMachinePeripheralsPass'] = $recordList['evaReportTelecomMachinePeripheralsPass'];
                $this->viewbag['evaReportTelecomMachineHarmonicEmissionYesNo'] = $recordList['evaReportTelecomMachineHarmonicEmissionYesNo'];
                $this->viewbag['evaReportTelecomMachineHarmonicEmissionFinding'] = $recordList['evaReportTelecomMachineHarmonicEmissionFinding'];
                $this->viewbag['evaReportTelecomMachineHarmonicEmissionRecommend'] = $recordList['evaReportTelecomMachineHarmonicEmissionRecommend'];
                $this->viewbag['evaReportTelecomMachineHarmonicEmissionPass'] = $recordList['evaReportTelecomMachineHarmonicEmissionPass'];
                $this->viewbag['evaReportTelecomMachineSupplementYesNo'] = $recordList['evaReportTelecomMachineSupplementYesNo'];
                $this->viewbag['evaReportTelecomMachineSupplement'] = $recordList['evaReportTelecomMachineSupplement'];
                $this->viewbag['evaReportTelecomMachineSupplementPass'] = $recordList['evaReportTelecomMachineSupplementPass'];
                $this->viewbag['evaReportAirConditionersYesNo'] = $recordList['evaReportAirConditionersYesNo'];
                $this->viewbag['evaReportAirConditionersMicbYesNo'] = $recordList['evaReportAirConditionersMicbYesNo'];
                $this->viewbag['evaReportAirConditionersMicbFinding'] = $recordList['evaReportAirConditionersMicbFinding'];
                $this->viewbag['evaReportAirConditionersMicbRecommend'] = $recordList['evaReportAirConditionersMicbRecommend'];
                $this->viewbag['evaReportAirConditionersMicbPass'] = $recordList['evaReportAirConditionersMicbPass'];
                $this->viewbag['evaReportAirConditionersLoadForecastingYesNo'] = $recordList['evaReportAirConditionersLoadForecastingYesNo'];
                $this->viewbag['evaReportAirConditionersLoadForecastingFinding'] = $recordList['evaReportAirConditionersLoadForecastingFinding'];
                $this->viewbag['evaReportAirConditionersLoadForecastingRecommend'] = $recordList['evaReportAirConditionersLoadForecastingRecommend'];
                $this->viewbag['evaReportAirConditionersLoadForecastingPass'] = $recordList['evaReportAirConditionersLoadForecastingPass'];
                $this->viewbag['evaReportAirConditionersTypeYesNo'] = $recordList['evaReportAirConditionersTypeYesNo'];
                $this->viewbag['evaReportAirConditionersTypeFinding'] = $recordList['evaReportAirConditionersTypeFinding'];
                $this->viewbag['evaReportAirConditionersTypeRecommend'] = $recordList['evaReportAirConditionersTypeRecommend'];
                $this->viewbag['evaReportAirConditionersTypePass'] = $recordList['evaReportAirConditionersTypePass'];
                $this->viewbag['evaReportAirConditionersSupplementYesNo'] = $recordList['evaReportAirConditionersSupplementYesNo'];
                $this->viewbag['evaReportAirConditionersSupplement'] = $recordList['evaReportAirConditionersSupplement'];
                $this->viewbag['evaReportAirConditionersSupplementPass'] = $recordList['evaReportAirConditionersSupplementPass'];
                $this->viewbag['evaReportNonLinearLoadYesNo'] = $recordList['evaReportNonLinearLoadYesNo'];
                $this->viewbag['evaReportNonLinearLoadHarmonicEmissionYesNo'] = $recordList['evaReportNonLinearLoadHarmonicEmissionYesNo'];
                $this->viewbag['evaReportNonLinearLoadHarmonicEmissionFinding'] = $recordList['evaReportNonLinearLoadHarmonicEmissionFinding'];
                $this->viewbag['evaReportNonLinearLoadHarmonicEmissionRecommend'] = $recordList['evaReportNonLinearLoadHarmonicEmissionRecommend'];
                $this->viewbag['evaReportNonLinearLoadHarmonicEmissionPass'] = $recordList['evaReportNonLinearLoadHarmonicEmissionPass'];
                $this->viewbag['evaReportNonLinearLoadSupplementYesNo'] = $recordList['evaReportNonLinearLoadSupplementYesNo'];
                $this->viewbag['evaReportNonLinearLoadSupplement'] = $recordList['evaReportNonLinearLoadSupplement'];
                $this->viewbag['evaReportNonLinearLoadSupplementPass'] = $recordList['evaReportNonLinearLoadSupplementPass'];
                $this->viewbag['evaReportRenewableEnergyYesNo'] = $recordList['evaReportRenewableEnergyYesNo'];
                $this->viewbag['evaReportRenewableEnergyInverterAndControlsYesNo'] = $recordList['evaReportRenewableEnergyInverterAndControlsYesNo'];
                $this->viewbag['evaReportRenewableEnergyInverterAndControlsFinding'] = $recordList['evaReportRenewableEnergyInverterAndControlsFinding'];
                $this->viewbag['evaReportRenewableEnergyInverterAndControlsRecommend'] = $recordList['evaReportRenewableEnergyInverterAndControlsRecommend'];
                $this->viewbag['evaReportRenewableEnergyInverterAndControlsPass'] = $recordList['evaReportRenewableEnergyInverterAndControlsPass'];
                $this->viewbag['evaReportRenewableEnergyHarmonicEmissionYesNo'] = $recordList['evaReportRenewableEnergyHarmonicEmissionYesNo'];
                $this->viewbag['evaReportRenewableEnergyHarmonicEmissionFinding'] = $recordList['evaReportRenewableEnergyHarmonicEmissionFinding'];
                $this->viewbag['evaReportRenewableEnergyHarmonicEmissionRecommend'] = $recordList['evaReportRenewableEnergyHarmonicEmissionRecommend'];
                $this->viewbag['evaReportRenewableEnergyHarmonicEmissionPass'] = $recordList['evaReportRenewableEnergyHarmonicEmissionPass'];
                $this->viewbag['evaReportRenewableEnergySupplementYesNo'] = $recordList['evaReportRenewableEnergySupplementYesNo'];
                $this->viewbag['evaReportRenewableEnergySupplement'] = $recordList['evaReportRenewableEnergySupplement'];
                $this->viewbag['evaReportRenewableEnergySupplementPass'] = $recordList['evaReportRenewableEnergySupplementPass'];
                $this->viewbag['evaReportEvChargerSystemYesNo'] = $recordList['evaReportEvChargerSystemYesNo'];
                $this->viewbag['evaReportEvChargerSystemEvChargerYesNo'] = $recordList['evaReportEvChargerSystemEvChargerYesNo'];
                $this->viewbag['evaReportEvChargerSystemEvChargerFinding'] = $recordList['evaReportEvChargerSystemEvChargerFinding'];
                $this->viewbag['evaReportEvChargerSystemEvChargerRecommend'] = $recordList['evaReportEvChargerSystemEvChargerRecommend'];
                $this->viewbag['evaReportEvChargerSystemEvChargerPass'] = $recordList['evaReportEvChargerSystemEvChargerPass'];
                $this->viewbag['evaReportEvChargerSystemHarmonicEmissionYesNo'] = $recordList['evaReportEvChargerSystemHarmonicEmissionYesNo'];
                $this->viewbag['evaReportEvChargerSystemHarmonicEmissionFinding'] = $recordList['evaReportEvChargerSystemHarmonicEmissionFinding'];
                $this->viewbag['evaReportEvChargerSystemHarmonicEmissionRecommend'] = $recordList['evaReportEvChargerSystemHarmonicEmissionRecommend'];
                $this->viewbag['evaReportEvChargerSystemHarmonicEmissionPass'] = $recordList['evaReportEvChargerSystemHarmonicEmissionPass'];
                $this->viewbag['evaReportEvChargerSystemSupplementYesNo'] = $recordList['evaReportEvChargerSystemSupplementYesNo'];
                $this->viewbag['evaReportEvChargerSystemSupplement'] = $recordList['evaReportEvChargerSystemSupplement'];
                $this->viewbag['evaReportEvChargerSystemSupplementPass'] = $recordList['evaReportEvChargerSystemSupplementPass'];
                $this->viewbag['reEvaReportId'] = $recordList['reEvaReportId'];
                $this->viewbag['reEvaReportRemark'] = $recordList['reEvaReportRemark'];
                $this->viewbag['reEvaReportEdmsLink'] = $recordList['reEvaReportEdmsLink'];
                $this->viewbag['reEvaReportIssueDate'] = $recordList['reEvaReportIssueDate'];
                $this->viewbag['reEvaReportFaxRefNo'] = $recordList['reEvaReportFaxRefNo'];
                $this->viewbag['reEvaReportScore'] = $recordList['reEvaReportScore'];
                $this->viewbag['reEvaReportBmsYesNo'] = $recordList['reEvaReportBmsYesNo'];
                $this->viewbag['reEvaReportBmsServerCentralComputerYesNo'] = $recordList['reEvaReportBmsServerCentralComputerYesNo'];
                $this->viewbag['reEvaReportBmsServerCentralComputerFinding'] = $recordList['reEvaReportBmsServerCentralComputerFinding'];
                $this->viewbag['reEvaReportBmsServerCentralComputerRecommend'] = $recordList['reEvaReportBmsServerCentralComputerRecommend'];
                $this->viewbag['reEvaReportBmsServerCentralComputerPass'] = $recordList['reEvaReportBmsServerCentralComputerPass'];
                $this->viewbag['reEvaReportBmsDdcYesNo'] = $recordList['reEvaReportBmsDdcYesNo'];
                $this->viewbag['reEvaReportBmsDdcFinding'] = $recordList['reEvaReportBmsDdcFinding'];
                $this->viewbag['reEvaReportBmsDdcRecommend'] = $recordList['reEvaReportBmsDdcRecommend'];
                $this->viewbag['reEvaReportBmsDdcPass'] = $recordList['reEvaReportBmsDdcPass'];
                $this->viewbag['reEvaReportBmsSupplementYesNo'] = $recordList['reEvaReportBmsSupplementYesNo'];
                $this->viewbag['reEvaReportBmsSupplement'] = $recordList['reEvaReportBmsSupplement'];
                $this->viewbag['reEvaReportBmsSupplementPass'] = $recordList['reEvaReportBmsSupplementPass'];
                $this->viewbag['reEvaReportChangeoverSchemeYesNo'] = $recordList['reEvaReportChangeoverSchemeYesNo'];
                $this->viewbag['reEvaReportChangeoverSchemeControlYesNo'] = $recordList['reEvaReportChangeoverSchemeControlYesNo'];
                $this->viewbag['reEvaReportChangeoverSchemeControlFinding'] = $recordList['reEvaReportChangeoverSchemeControlFinding'];
                $this->viewbag['reEvaReportChangeoverSchemeControlRecommend'] = $recordList['reEvaReportChangeoverSchemeControlRecommend'];
                $this->viewbag['reEvaReportChangeoverSchemeControlPass'] = $recordList['reEvaReportChangeoverSchemeControlPass'];
                $this->viewbag['reEvaReportChangeoverSchemeUvYesNo'] = $recordList['reEvaReportChangeoverSchemeUvYesNo'];
                $this->viewbag['reEvaReportChangeoverSchemeUvFinding'] = $recordList['reEvaReportChangeoverSchemeUvFinding'];
                $this->viewbag['reEvaReportChangeoverSchemeUvRecommend'] = $recordList['reEvaReportChangeoverSchemeUvRecommend'];
                $this->viewbag['reEvaReportChangeoverSchemeUvPass'] = $recordList['reEvaReportChangeoverSchemeUvPass'];
                $this->viewbag['reEvaReportChangeoverSchemeSupplementYesNo'] = $recordList['reEvaReportChangeoverSchemeSupplementYesNo'];
                $this->viewbag['reEvaReportChangeoverSchemeSupplement'] = $recordList['reEvaReportChangeoverSchemeSupplement'];
                $this->viewbag['reEvaReportChangeoverSchemeSupplementPass'] = $recordList['reEvaReportChangeoverSchemeSupplementPass'];
                $this->viewbag['reEvaReportChillerPlantYesNo'] = $recordList['reEvaReportChillerPlantYesNo'];
                $this->viewbag['reEvaReportChillerPlantAhuChilledWaterYesNo'] = $recordList['reEvaReportChillerPlantAhuChilledWaterYesNo'];
                $this->viewbag['reEvaReportChillerPlantAhuChilledWaterFinding'] = $recordList['reEvaReportChillerPlantAhuChilledWaterFinding'];
                $this->viewbag['reEvaReportChillerPlantAhuChilledWaterRecommend'] = $recordList['reEvaReportChillerPlantAhuChilledWaterRecommend'];
                $this->viewbag['reEvaReportChillerPlantAhuChilledWaterPass'] = $recordList['reEvaReportChillerPlantAhuChilledWaterPass'];
                $this->viewbag['reEvaReportChillerPlantChillerYesNo'] = $recordList['reEvaReportChillerPlantChillerYesNo'];
                $this->viewbag['reEvaReportChillerPlantChillerFinding'] = $recordList['reEvaReportChillerPlantChillerFinding'];
                $this->viewbag['reEvaReportChillerPlantChillerRecommend'] = $recordList['reEvaReportChillerPlantChillerRecommend'];
                $this->viewbag['reEvaReportChillerPlantChillerPass'] = $recordList['reEvaReportChillerPlantChillerPass'];
                $this->viewbag['reEvaReportChillerPlantSupplementYesNo'] = $recordList['reEvaReportChillerPlantSupplementYesNo'];
                $this->viewbag['reEvaReportChillerPlantSupplement'] = $recordList['reEvaReportChillerPlantSupplement'];
                $this->viewbag['reEvaReportChillerPlantSupplementPass'] = $recordList['reEvaReportChillerPlantSupplementPass'];
                $this->viewbag['reEvaReportEscalatorYesNo'] = $recordList['reEvaReportEscalatorYesNo'];
                $this->viewbag['reEvaReportEscalatorBrakingSystemYesNo'] = $recordList['reEvaReportEscalatorBrakingSystemYesNo'];
                $this->viewbag['reEvaReportEscalatorBrakingSystemFinding'] = $recordList['reEvaReportEscalatorBrakingSystemFinding'];
                $this->viewbag['reEvaReportEscalatorBrakingSystemRecommend'] = $recordList['reEvaReportEscalatorBrakingSystemRecommend'];
                $this->viewbag['reEvaReportEscalatorBrakingSystemPass'] = $recordList['reEvaReportEscalatorBrakingSystemPass'];
                $this->viewbag['reEvaReportEscalatorControlYesNo'] = $recordList['reEvaReportEscalatorControlYesNo'];
                $this->viewbag['reEvaReportEscalatorControlFinding'] = $recordList['reEvaReportEscalatorControlFinding'];
                $this->viewbag['reEvaReportEscalatorControlRecommend'] = $recordList['reEvaReportEscalatorControlRecommend'];
                $this->viewbag['reEvaReportEscalatorControlPass'] = $recordList['reEvaReportEscalatorControlPass'];
                $this->viewbag['reEvaReportEscalatorSupplementYesNo'] = $recordList['reEvaReportEscalatorSupplementYesNo'];
                $this->viewbag['reEvaReportEscalatorSupplement'] = $recordList['reEvaReportEscalatorSupplement'];
                $this->viewbag['reEvaReportEscalatorSupplementPass'] = $recordList['reEvaReportEscalatorSupplementPass'];
                $this->viewbag['reEvaReportLiftYesNo'] = $recordList['reEvaReportLiftYesNo'];
                $this->viewbag['reEvaReportLiftOperationYesNo'] = $recordList['reEvaReportLiftOperationYesNo'];
                $this->viewbag['reEvaReportLiftOperationFinding'] = $recordList['reEvaReportLiftOperationFinding'];
                $this->viewbag['reEvaReportLiftOperationRecommend'] = $recordList['reEvaReportLiftOperationRecommend'];
                $this->viewbag['reEvaReportLiftOperationPass'] = $recordList['reEvaReportLiftOperationPass'];
                $this->viewbag['reEvaReportLiftMainSupplyYesNo'] = $recordList['reEvaReportLiftMainSupplyYesNo'];
                $this->viewbag['reEvaReportLiftMainSupplyFinding'] = $recordList['reEvaReportLiftMainSupplyFinding'];
                $this->viewbag['reEvaReportLiftMainSupplyRecommend'] = $recordList['reEvaReportLiftMainSupplyRecommend'];
                $this->viewbag['reEvaReportLiftMainSupplyPass'] = $recordList['reEvaReportLiftMainSupplyPass'];
                $this->viewbag['reEvaReportLiftSupplementYesNo'] = $recordList['reEvaReportLiftSupplementYesNo'];
                $this->viewbag['reEvaReportLiftSupplement'] = $recordList['reEvaReportLiftSupplement'];
                $this->viewbag['reEvaReportLiftSupplementPass'] = $recordList['reEvaReportLiftSupplementPass'];
                $this->viewbag['reEvaReportHidLampYesNo'] = $recordList['reEvaReportHidLampYesNo'];
                $this->viewbag['reEvaReportHidLampBallastYesNo'] = $recordList['reEvaReportHidLampBallastYesNo'];
                $this->viewbag['reEvaReportHidLampBallastFinding'] = $recordList['reEvaReportHidLampBallastFinding'];
                $this->viewbag['reEvaReportHidLampBallastRecommend'] = $recordList['reEvaReportHidLampBallastRecommend'];
                $this->viewbag['reEvaReportHidLampBallastPass'] = $recordList['reEvaReportHidLampBallastPass'];
                $this->viewbag['reEvaReportHidLampAddonProtectYesNo'] = $recordList['reEvaReportHidLampAddonProtectYesNo'];
                $this->viewbag['reEvaReportHidLampAddonProtectFinding'] = $recordList['reEvaReportHidLampAddonProtectFinding'];
                $this->viewbag['reEvaReportHidLampAddonProtectRecommend'] = $recordList['reEvaReportHidLampAddonProtectRecommend'];
                $this->viewbag['reEvaReportHidLampAddonProtectPass'] = $recordList['reEvaReportHidLampAddonProtectPass'];
                $this->viewbag['reEvaReportHidLampSupplementYesNo'] = $recordList['reEvaReportHidLampSupplementYesNo'];
                $this->viewbag['reEvaReportHidLampSupplement'] = $recordList['reEvaReportHidLampSupplement'];
                $this->viewbag['reEvaReportHidLampSupplementPass'] = $recordList['reEvaReportHidLampSupplementPass'];
                $this->viewbag['reEvaReportSensitiveMachineYesNo'] = $recordList['reEvaReportSensitiveMachineYesNo'];
                $this->viewbag['reEvaReportSensitiveMachineMedicalYesNo'] = $recordList['reEvaReportSensitiveMachineMedicalYesNo'];
                $this->viewbag['reEvaReportSensitiveMachineMedicalFinding'] = $recordList['reEvaReportSensitiveMachineMedicalFinding'];
                $this->viewbag['reEvaReportSensitiveMachineMedicalRecommend'] = $recordList['reEvaReportSensitiveMachineMedicalRecommend'];
                $this->viewbag['reEvaReportSensitiveMachineMedicalPass'] = $recordList['reEvaReportSensitiveMachineMedicalPass'];
                $this->viewbag['reEvaReportSensitiveMachineSupplementYesNo'] = $recordList['reEvaReportSensitiveMachineSupplementYesNo'];
                $this->viewbag['reEvaReportSensitiveMachineSupplement'] = $recordList['reEvaReportSensitiveMachineSupplement'];
                $this->viewbag['reEvaReportSensitiveMachineSupplementPass'] = $recordList['reEvaReportSensitiveMachineSupplementPass'];
                $this->viewbag['reEvaReportTelecomMachineYesNo'] = $recordList['reEvaReportTelecomMachineYesNo'];
                $this->viewbag['reEvaReportTelecomMachineServerOrComputerYesNo'] = $recordList['reEvaReportTelecomMachineServerOrComputerYesNo'];
                $this->viewbag['reEvaReportTelecomMachineServerOrComputerFinding'] = $recordList['reEvaReportTelecomMachineServerOrComputerFinding'];
                $this->viewbag['reEvaReportTelecomMachineServerOrComputerRecommend'] = $recordList['reEvaReportTelecomMachineServerOrComputerRecommend'];
                $this->viewbag['reEvaReportTelecomMachineServerOrComputerPass'] = $recordList['reEvaReportTelecomMachineServerOrComputerPass'];
                $this->viewbag['reEvaReportTelecomMachinePeripheralsYesNo'] = $recordList['reEvaReportTelecomMachinePeripheralsYesNo'];
                $this->viewbag['reEvaReportTelecomMachinePeripheralsFinding'] = $recordList['reEvaReportTelecomMachinePeripheralsFinding'];
                $this->viewbag['reEvaReportTelecomMachinePeripheralsRecommend'] = $recordList['reEvaReportTelecomMachinePeripheralsRecommend'];
                $this->viewbag['reEvaReportTelecomMachinePeripheralsPass'] = $recordList['reEvaReportTelecomMachinePeripheralsPass'];
                $this->viewbag['reEvaReportTelecomMachineHarmonicEmissionYesNo'] = $recordList['reEvaReportTelecomMachineHarmonicEmissionYesNo'];
                $this->viewbag['reEvaReportTelecomMachineHarmonicEmissionFinding'] = $recordList['reEvaReportTelecomMachineHarmonicEmissionFinding'];
                $this->viewbag['reEvaReportTelecomMachineHarmonicEmissionRecommend'] = $recordList['reEvaReportTelecomMachineHarmonicEmissionRecommend'];
                $this->viewbag['reEvaReportTelecomMachineHarmonicEmissionPass'] = $recordList['reEvaReportTelecomMachineHarmonicEmissionPass'];
                $this->viewbag['reEvaReportTelecomMachineSupplementYesNo'] = $recordList['reEvaReportTelecomMachineSupplementYesNo'];
                $this->viewbag['reEvaReportTelecomMachineSupplement'] = $recordList['reEvaReportTelecomMachineSupplement'];
                $this->viewbag['reEvaReportTelecomMachineSupplementPass'] = $recordList['reEvaReportTelecomMachineSupplementPass'];
                $this->viewbag['reEvaReportAirConditionersYesNo'] = $recordList['reEvaReportAirConditionersYesNo'];
                $this->viewbag['reEvaReportAirConditionersMicbYesNo'] = $recordList['reEvaReportAirConditionersMicbYesNo'];
                $this->viewbag['reEvaReportAirConditionersMicbFinding'] = $recordList['reEvaReportAirConditionersMicbFinding'];
                $this->viewbag['reEvaReportAirConditionersMicbRecommend'] = $recordList['reEvaReportAirConditionersMicbRecommend'];
                $this->viewbag['reEvaReportAirConditionersMicbPass'] = $recordList['reEvaReportAirConditionersMicbPass'];
                $this->viewbag['reEvaReportAirConditionersLoadForecastingYesNo'] = $recordList['reEvaReportAirConditionersLoadForecastingYesNo'];
                $this->viewbag['reEvaReportAirConditionersLoadForecastingFinding'] = $recordList['reEvaReportAirConditionersLoadForecastingFinding'];
                $this->viewbag['reEvaReportAirConditionersLoadForecastingRecommend'] = $recordList['reEvaReportAirConditionersLoadForecastingRecommend'];
                $this->viewbag['reEvaReportAirConditionersLoadForecastingPass'] = $recordList['reEvaReportAirConditionersLoadForecastingPass'];
                $this->viewbag['reEvaReportAirConditionersTypeYesNo'] = $recordList['reEvaReportAirConditionersTypeYesNo'];
                $this->viewbag['reEvaReportAirConditionersTypeFinding'] = $recordList['reEvaReportAirConditionersTypeFinding'];
                $this->viewbag['reEvaReportAirConditionersTypeRecommend'] = $recordList['reEvaReportAirConditionersTypeRecommend'];
                $this->viewbag['reEvaReportAirConditionersTypePass'] = $recordList['reEvaReportAirConditionersTypePass'];
                $this->viewbag['reEvaReportAirConditionersSupplementYesNo'] = $recordList['reEvaReportAirConditionersSupplementYesNo'];
                $this->viewbag['reEvaReportAirConditionersSupplement'] = $recordList['reEvaReportAirConditionersSupplement'];
                $this->viewbag['reEvaReportAirConditionersSupplementPass'] = $recordList['reEvaReportAirConditionersSupplementPass'];
                $this->viewbag['reEvaReportNonLinearLoadYesNo'] = $recordList['reEvaReportNonLinearLoadYesNo'];
                $this->viewbag['reEvaReportNonLinearLoadHarmonicEmissionYesNo'] = $recordList['reEvaReportNonLinearLoadHarmonicEmissionYesNo'];
                $this->viewbag['reEvaReportNonLinearLoadHarmonicEmissionFinding'] = $recordList['reEvaReportNonLinearLoadHarmonicEmissionFinding'];
                $this->viewbag['reEvaReportNonLinearLoadHarmonicEmissionRecommend'] = $recordList['reEvaReportNonLinearLoadHarmonicEmissionRecommend'];
                $this->viewbag['reEvaReportNonLinearLoadHarmonicEmissionPass'] = $recordList['reEvaReportNonLinearLoadHarmonicEmissionPass'];
                $this->viewbag['reEvaReportNonLinearLoadSupplementYesNo'] = $recordList['reEvaReportNonLinearLoadSupplementYesNo'];
                $this->viewbag['reEvaReportNonLinearLoadSupplement'] = $recordList['reEvaReportNonLinearLoadSupplement'];
                $this->viewbag['reEvaReportNonLinearLoadSupplementPass'] = $recordList['reEvaReportNonLinearLoadSupplementPass'];
                $this->viewbag['reEvaReportRenewableEnergyYesNo'] = $recordList['reEvaReportRenewableEnergyYesNo'];
                $this->viewbag['reEvaReportRenewableEnergyInverterAndControlsYesNo'] = $recordList['reEvaReportRenewableEnergyInverterAndControlsYesNo'];
                $this->viewbag['reEvaReportRenewableEnergyInverterAndControlsFinding'] = $recordList['reEvaReportRenewableEnergyInverterAndControlsFinding'];
                $this->viewbag['reEvaReportRenewableEnergyInverterAndControlsRecommend'] = $recordList['reEvaReportRenewableEnergyInverterAndControlsRecommend'];
                $this->viewbag['reEvaReportRenewableEnergyInverterAndControlsPass'] = $recordList['reEvaReportRenewableEnergyInverterAndControlsPass'];
                $this->viewbag['reEvaReportRenewableEnergyHarmonicEmissionYesNo'] = $recordList['reEvaReportRenewableEnergyHarmonicEmissionYesNo'];
                $this->viewbag['reEvaReportRenewableEnergyHarmonicEmissionFinding'] = $recordList['reEvaReportRenewableEnergyHarmonicEmissionFinding'];
                $this->viewbag['reEvaReportRenewableEnergyHarmonicEmissionRecommend'] = $recordList['reEvaReportRenewableEnergyHarmonicEmissionRecommend'];
                $this->viewbag['reEvaReportRenewableEnergyHarmonicEmissionPass'] = $recordList['reEvaReportRenewableEnergyHarmonicEmissionPass'];
                $this->viewbag['reEvaReportRenewableEnergySupplementYesNo'] = $recordList['reEvaReportRenewableEnergySupplementYesNo'];
                $this->viewbag['reEvaReportRenewableEnergySupplement'] = $recordList['reEvaReportRenewableEnergySupplement'];
                $this->viewbag['reEvaReportRenewableEnergySupplementPass'] = $recordList['reEvaReportRenewableEnergySupplementPass'];
                $this->viewbag['reEvaReportEvChargerSystemYesNo'] = $recordList['reEvaReportEvChargerSystemYesNo'];
                $this->viewbag['reEvaReportEvChargerSystemEvChargerYesNo'] = $recordList['reEvaReportEvChargerSystemEvChargerYesNo'];
                $this->viewbag['reEvaReportEvChargerSystemEvChargerFinding'] = $recordList['reEvaReportEvChargerSystemEvChargerFinding'];
                $this->viewbag['reEvaReportEvChargerSystemEvChargerRecommend'] = $recordList['reEvaReportEvChargerSystemEvChargerRecommend'];
                $this->viewbag['reEvaReportEvChargerSystemEvChargerPass'] = $recordList['reEvaReportEvChargerSystemEvChargerPass'];
                $this->viewbag['reEvaReportEvChargerSystemHarmonicEmissionYesNo'] = $recordList['reEvaReportEvChargerSystemHarmonicEmissionYesNo'];
                $this->viewbag['reEvaReportEvChargerSystemHarmonicEmissionFinding'] = $recordList['reEvaReportEvChargerSystemHarmonicEmissionFinding'];
                $this->viewbag['reEvaReportEvChargerSystemHarmonicEmissionRecommend'] = $recordList['reEvaReportEvChargerSystemHarmonicEmissionRecommend'];
                $this->viewbag['reEvaReportEvChargerSystemHarmonicEmissionPass'] = $recordList['reEvaReportEvChargerSystemHarmonicEmissionPass'];
                $this->viewbag['reEvaReportEvChargerSystemSupplementYesNo'] = $recordList['reEvaReportEvChargerSystemSupplementYesNo'];
                $this->viewbag['reEvaReportEvChargerSystemSupplement'] = $recordList['reEvaReportEvChargerSystemSupplement'];
                $this->viewbag['reEvaReportEvChargerSystemSupplementPass'] = $recordList['reEvaReportEvChargerSystemSupplementPass'];
                $this->viewbag['state'] = $recordList['state'];
                $this->viewbag['active'] = $recordList['active'];
                $this->viewbag['createdBy'] = $recordList['createdBy'];
                $this->viewbag['createdTime'] = $recordList['createdTime'];
                $this->viewbag['lastUpdatedBy'] = $recordList['lastUpdatedBy'];
                $this->viewbag['lastUpdatedTime'] = $recordList['lastUpdatedTime'];
                $this->viewbag['projectTypeList'] = Yii::app()->planningAheadDao->getPlanningAheadProjectTypeList();
                $this->viewbag['consultantCompanyList'] = Yii::app()->planningAheadDao->getPlanningAheadConsultantCompanyAllActive();
                $this->viewbag['regionList'] = Yii::app()->planningAheadDao->getPlanningAheadRegionAllActive();
                $this->viewbag['projectOwnerCompanyList'] = Yii::app()->planningAheadDao->getPlanningAheadProjectOwnerCompanyAllActive();

                $this->viewbag['isError'] = false;
                $this->render("//site/Form/PlanningAheadDetail");
            }
        } else {
            $this->viewbag['isError'] = true;
            $this->viewbag['errorMsg'] = 'Please provide Scheme No.!';
            $this->render("//site/Form/PlanningAheadDetailError");
        }

    }

    // *********************************************************************
    // Generate Standard letter template to PG team
    // *********************************************************************
    public function actionGetPlanningAheadProjectDetailStandardLetterTemplate() {

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        if (Yii::app()->session['tblUserDo']['roleId']!=2) {
            $this->viewbag['isError'] = true;
            $this->viewbag['errorMsg'] = 'You do not have the privilege to generate standard letter template.';
            $this->render("//site/Form/PlanningAheadDetailError");
        } else {
            $standLetterIssueDate = $param['standLetterIssueDate'];
            $standLetterFaxRefNo = $param['standLetterFaxRefNo'];
            $schemeNo = $param['schemeNo'];
            $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
            $lastUpdatedTime = date("Y-m-d H:i");

            $recordList = Yii::app()->planningAheadDao->getPlanningAheadDetails($schemeNo);

            // Update the issue date and fax ref no. to database first
            Yii::app()->planningAheadDao->updateStandardLetter($recordList['planningAheadId'], $standLetterIssueDate,
                $standLetterFaxRefNo,$lastUpdatedBy,$lastUpdatedTime);

            $projectType = Yii::app()->planningAheadDao->getPlanningAheadProjectTypeById($recordList['projectTypeId']);
            $standardLetterTemplatePath = Yii::app()->commonUtil->getConfigValueByConfigName('planningAheadStandardLetterTemplatePath');

            $standLetterFaxYear = date("y", strtotime($standLetterIssueDate));
            $standLetterFaxMonth = date("m", strtotime($standLetterIssueDate));
            $standLetterIssueDay = date("j", strtotime($standLetterIssueDate));
            $standLetterIssueMonth = date("M", strtotime($standLetterIssueDate));
            $standLetterIssueYear = date("Y", strtotime($standLetterIssueDate));

            $templateProcessor = new TemplateProcessor($standardLetterTemplatePath['configValue'] . $projectType[0]['projectTypeTemplateFileName']);
            $templateProcessor->setValue('consultantTitle', $recordList['firstConsultantTitle']);
            $templateProcessor->setValue('consultantSurname', $this->formatToWordTemplate($recordList['firstConsultantSurname']));
            $templateProcessor->setValue('consultantCompanyName', $this->formatToWordTemplate($recordList['firstConsultantCompany']));
            $templateProcessor->setValue('consultantEmail', $this->formatToWordTemplate($recordList['firstConsultantEmail']));
            $templateProcessor->setValue('faxRefNo', $standLetterFaxRefNo);
            $templateProcessor->setValue('faxDate', $standLetterFaxYear . "-" . $standLetterFaxMonth);
            $templateProcessor->setValue('issueDate', $standLetterIssueDay . " " . $standLetterIssueMonth . " " . $standLetterIssueYear);
            $templateProcessor->setValue('projectTitle', $this->formatToWordTemplate($recordList['projectTitle']));

            $pathToSave = $standardLetterTemplatePath['configValue'] . 'temp\\(' . $schemeNo . ') ' . $projectType[0]['projectTypeTemplateFileName'];
            $templateProcessor->saveAs($pathToSave);

            header("Content-Description: File Transfer");
            header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
            header('Content-Disposition: attachment; filename='. basename($pathToSave));
            header('Content-Length: ' . filesize($pathToSave));
            header('Pragma: public');

            //Clear system output buffer
            flush();

            //Read the size of the file
            readfile($pathToSave);
            unlink($pathToSave); // deletes the temporary file

            die();
        }
    }

    // *********************************************************************
    // Generate Reply Slip template to PG team
    // *********************************************************************
    public function actionGetPlanningAheadProjectDetailReplySlipTemplate() {

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        $pathToSave = $this->generateReplySlipTemplate($param['schemeNo']);

        header("Content-Description: File Transfer");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header('Content-Disposition: attachment; filename='. basename($pathToSave));
        header('Content-Length: ' . filesize($pathToSave));
        header('Content-Transfer-Encoding: binary');
        header('Pragma: public');

        //Clear system output buffer
        flush();

        //Read the size of the file
        readfile($pathToSave);

        die();
    }

    public function actionGetPlanningAheadProjectDetailFirstInvitationLetterTemplate() {

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        $firstInvitationLetterIssueDate = $param['firstInvitationLetterIssueDate'];
        $firstInvitationLetterFaxRefNo = $param['firstInvitationLetterFaxRefNo'];
        $schemeNo = $param['schemeNo'];
        $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
        $lastUpdatedTime = date("Y-m-d H:i");

        $recordList = Yii::app()->planningAheadDao->getPlanningAheadDetails($schemeNo);
        $replySlip = Yii::app()->planningAheadDao->getReplySlip($recordList['meetingReplySlipId']);

        // Update the issue date and fax ref no. to database first
        Yii::app()->planningAheadDao->updateFirstInvitationLetter($recordList['planningAheadId'],
            $firstInvitationLetterIssueDate,$firstInvitationLetterFaxRefNo,$lastUpdatedBy,$lastUpdatedTime);

        $firstInvitationLetterTemplatePath = Yii::app()->commonUtil->
        getConfigValueByConfigName('planningAheadInvitationLetterTemplatePath');

        $firstInvitationLetterTemplateFileName = Yii::app()->commonUtil->
        getConfigValueByConfigName('planningAheadFirstInvitationLetterTemplateFileName');

        $firstInvitationLetterFaxYear = date("y", strtotime($firstInvitationLetterIssueDate));
        $firstInvitationLetterFaxMonth = date("m", strtotime($firstInvitationLetterIssueDate));
        $firstInvitationLetterIssueDateDay = date("j", strtotime($firstInvitationLetterIssueDate));
        $firstInvitationLetterIssueDateMonth = date("M", strtotime($firstInvitationLetterIssueDate));
        $firstInvitationLetterIssueDateYear = date("Y", strtotime($firstInvitationLetterIssueDate));

        $templateProcessor = new TemplateProcessor($firstInvitationLetterTemplatePath['configValue'] .
            $firstInvitationLetterTemplateFileName['configValue']);
        $templateProcessor->setValue('firstConsultantTitle', $recordList['firstConsultantTitle']);
        $templateProcessor->setValue('firstConsultantSurname', $recordList['firstConsultantSurname']);
        $templateProcessor->setValue('firstConsultantCompany', $this->formatToWordTemplate($recordList['firstConsultantCompany']));
        $templateProcessor->setValue('firstConsultantEmail', $recordList['firstConsultantEmail']);

        if (isset($recordList['secondConsultantSurname']) && (trim($recordList['secondConsultantSurname']) != "")) {
            $templateProcessor->setValue('secondConsultantCc', "c.c.");
            $templateProcessor->setValue('secondConsultantTitle', "(" . $recordList['secondConsultantTitle'] . ")");
            $templateProcessor->setValue('secondConsultantSurname', $recordList['secondConsultantSurname']);
            $templateProcessor->setValue('secondConsultantCompany', $this->formatToWordTemplate($recordList['secondConsultantCompany']));
            $templateProcessor->setValue('secondConsultantEmail', "(Email: " . $recordList['secondConsultantEmail'] . ")");
        } else {
            $templateProcessor->setValue('secondConsultantCc', "");
            $templateProcessor->setValue('secondConsultantTitle', "");
            $templateProcessor->setValue('secondConsultantSurname', "");
            $templateProcessor->setValue('secondConsultantCompany', "");
            $templateProcessor->setValue('secondConsultantEmail', "");
        }

        $templateProcessor->setValue('faxRefNo', $firstInvitationLetterFaxRefNo);
        $templateProcessor->setValue('faxDate', $firstInvitationLetterFaxYear . "-" . $firstInvitationLetterFaxMonth);
        $templateProcessor->setValue('issueDate', $firstInvitationLetterIssueDateDay . " " .
            $firstInvitationLetterIssueDateMonth . " " .
            $firstInvitationLetterIssueDateYear);
        $templateProcessor->setValue('projectTitle', $this->formatToWordTemplate($recordList['projectTitle']));
        $templateProcessor->setValue('replySlipReturnDate', $replySlip['replySlipLastUpdateTime']);

        $pathToSave = $firstInvitationLetterTemplatePath['configValue'] . 'temp\\(' . $schemeNo . ')' .
            $firstInvitationLetterTemplateFileName['configValue'];
        $templateProcessor->saveAs($pathToSave);

        header("Content-Description: File Transfer");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header('Content-Disposition: attachment; filename='. basename($pathToSave));
        header('Content-Length: ' . filesize($pathToSave));
        header('Pragma: public');

        //Clear system output buffer
        flush();

        //Read the size of the file
        readfile($pathToSave);
        unlink($pathToSave); // deletes the temporary file

        die();

    }

    public function actionGetPlanningAheadProjectDetailSecondInvitationLetterTemplate() {

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        $firstInvitationLetterIssueDate = $param['firstInvitationLetterIssueDate'];
        $firstInvitationLetterFaxRefNo = $param['firstInvitationLetterFaxRefNo'];
        $secondInvitationLetterIssueDate = $param['secondInvitationLetterIssueDate'];
        $secondInvitationLetterFaxRefNo = $param['secondInvitationLetterFaxRefNo'];

        $schemeNo = $param['schemeNo'];
        $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
        $lastUpdatedTime = date("Y-m-d H:i");

        $recordList = Yii::app()->planningAheadDao->getPlanningAheadDetails($schemeNo);
        $replySlip = Yii::app()->planningAheadDao->getReplySlip($recordList['meetingReplySlipId']);

        // Update the issue date and fax ref no. to database first
        Yii::app()->planningAheadDao->updateSecondInvitationLetter($recordList['planningAheadId'],
            $firstInvitationLetterIssueDate,$firstInvitationLetterFaxRefNo,
            $secondInvitationLetterIssueDate,$secondInvitationLetterFaxRefNo,
            $lastUpdatedBy,$lastUpdatedTime);

        $secondInvitationLetterTemplatePath = Yii::app()->commonUtil->
        getConfigValueByConfigName('planningAheadInvitationLetterTemplatePath');

        $secondInvitationLetterTemplateFileName = Yii::app()->commonUtil->
        getConfigValueByConfigName('planningAheadSecondInvitationLetterTemplateFileName');

        $secondInvitationLetterFaxYear = date("y", strtotime($secondInvitationLetterIssueDate));
        $secondInvitationLetterFaxMonth = date("m", strtotime($secondInvitationLetterIssueDate));
        $secondInvitationLetterIssueDateDay = date("j", strtotime($secondInvitationLetterIssueDate));
        $secondInvitationLetterIssueDateMonth = date("M", strtotime($secondInvitationLetterIssueDate));
        $secondInvitationLetterIssueDateYear = date("Y", strtotime($secondInvitationLetterIssueDate));

        $templateProcessor = new TemplateProcessor($secondInvitationLetterTemplatePath['configValue'] .
            $secondInvitationLetterTemplateFileName['configValue']);
        $templateProcessor->setValue('firstConsultantTitle', $recordList['firstConsultantTitle']);
        $templateProcessor->setValue('firstConsultantSurname', $recordList['firstConsultantSurname']);
        $templateProcessor->setValue('firstConsultantCompany', $this->formatToWordTemplate($recordList['firstConsultantCompany']));
        $templateProcessor->setValue('firstConsultantEmail', $recordList['firstConsultantEmail']);

        if (isset($recordList['secondConsultantSurname']) && (trim($recordList['secondConsultantSurname']) != "")) {
            $templateProcessor->setValue('secondConsultantCc', "c.c.");
            $templateProcessor->setValue('secondConsultantTitle', "(" . $recordList['secondConsultantTitle'] . ")");
            $templateProcessor->setValue('secondConsultantSurname', $recordList['secondConsultantSurname']);
            $templateProcessor->setValue('secondConsultantCompany', $this->formatToWordTemplate($recordList['secondConsultantCompany']));
            $templateProcessor->setValue('secondConsultantEmail', "(Email: " . $recordList['secondConsultantEmail'] . ")");
        } else {
            $templateProcessor->setValue('secondConsultantCc', "");
            $templateProcessor->setValue('secondConsultantTitle', "");
            $templateProcessor->setValue('secondConsultantSurname', "");
            $templateProcessor->setValue('secondConsultantCompany', "");
            $templateProcessor->setValue('secondConsultantEmail', "");
        }

        $templateProcessor->setValue('faxRefNo', $secondInvitationLetterFaxRefNo);
        $templateProcessor->setValue('faxDate', $secondInvitationLetterFaxYear . "-" . $secondInvitationLetterFaxMonth);
        $templateProcessor->setValue('issueDate', $secondInvitationLetterIssueDateDay . " " .
            $secondInvitationLetterIssueDateMonth . " " .
            $secondInvitationLetterIssueDateYear);
        $templateProcessor->setValue('projectTitle', $this->formatToWordTemplate($recordList['projectTitle']));
        $templateProcessor->setValue('firstLetterSendDate', $firstInvitationLetterIssueDate);

        $pathToSave = $secondInvitationLetterTemplatePath['configValue'] . 'temp\\(' . $schemeNo . ')' .
            $secondInvitationLetterTemplateFileName['configValue'];

        $templateProcessor->saveAs($pathToSave);

        header("Content-Description: File Transfer");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header('Content-Disposition: attachment; filename='. basename($pathToSave));
        header('Content-Length: ' . filesize($pathToSave));
        header('Pragma: public');

        //Clear system output buffer
        flush();

        //Read the size of the file
        readfile($pathToSave);
        unlink($pathToSave); // deletes the temporary file

        die();

    }

    public function actionGetPlanningAheadProjectDetailThirdInvitationLetterTemplate() {

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        $firstInvitationLetterIssueDate = $param['firstInvitationLetterIssueDate'];
        $firstInvitationLetterFaxRefNo = $param['firstInvitationLetterFaxRefNo'];
        $secondInvitationLetterIssueDate = $param['secondInvitationLetterIssueDate'];
        $secondInvitationLetterFaxRefNo = $param['secondInvitationLetterFaxRefNo'];
        $thirdInvitationLetterIssueDate = $param['thirdInvitationLetterIssueDate'];
        $thirdInvitationLetterFaxRefNo = $param['thirdInvitationLetterFaxRefNo'];

        $schemeNo = $param['schemeNo'];
        $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
        $lastUpdatedTime = date("Y-m-d H:i");

        $recordList = Yii::app()->planningAheadDao->getPlanningAheadDetails($schemeNo);
        $replySlip = Yii::app()->planningAheadDao->getReplySlip($recordList['meetingReplySlipId']);

        // Update the issue date and fax ref no. to database first
        Yii::app()->planningAheadDao->updateThirdInvitationLetter($recordList['planningAheadId'],
            $firstInvitationLetterIssueDate,$firstInvitationLetterFaxRefNo,
            $secondInvitationLetterIssueDate,$secondInvitationLetterFaxRefNo,
            $thirdInvitationLetterIssueDate,$thirdInvitationLetterFaxRefNo,
            $lastUpdatedBy,$lastUpdatedTime);

        $thirdInvitationLetterTemplatePath = Yii::app()->commonUtil->
        getConfigValueByConfigName('planningAheadInvitationLetterTemplatePath');

        $thirdInvitationLetterTemplateFileName = Yii::app()->commonUtil->
        getConfigValueByConfigName('planningAheadThirdInvitationLetterTemplateFileName');

        $firstInvitationLetterFaxYear = date("y", strtotime($firstInvitationLetterIssueDate));
        $firstInvitationLetterFaxMonth = date("m", strtotime($firstInvitationLetterIssueDate));
        $secondInvitationLetterFaxYear = date("y", strtotime($secondInvitationLetterIssueDate));
        $secondInvitationLetterFaxMonth = date("m", strtotime($secondInvitationLetterIssueDate));
        $thirdInvitationLetterFaxYear = date("y", strtotime($thirdInvitationLetterIssueDate));
        $thirdInvitationLetterFaxMonth = date("m", strtotime($thirdInvitationLetterIssueDate));
        $thirdInvitationLetterIssueDateDay = date("j", strtotime($thirdInvitationLetterIssueDate));
        $thirdInvitationLetterIssueDateMonth = date("M", strtotime($thirdInvitationLetterIssueDate));
        $thirdInvitationLetterIssueDateYear = date("Y", strtotime($thirdInvitationLetterIssueDate));

        $templateProcessor = new TemplateProcessor($thirdInvitationLetterTemplatePath['configValue'] .
            $thirdInvitationLetterTemplateFileName['configValue']);
        $templateProcessor->setValue('firstConsultantTitle', $recordList['firstConsultantTitle']);
        $templateProcessor->setValue('firstConsultantSurname', $recordList['firstConsultantSurname']);
        $templateProcessor->setValue('firstConsultantCompany', $this->formatToWordTemplate($recordList['firstConsultantCompany']));
        $templateProcessor->setValue('firstConsultantEmail', $recordList['firstConsultantEmail']);

        if (isset($recordList['secondConsultantSurname']) && (trim($recordList['secondConsultantSurname']) != "")) {
            $templateProcessor->setValue('secondConsultantCc', "c.c.");
            $templateProcessor->setValue('secondConsultantTitle', "(" . $recordList['secondConsultantTitle'] . ")");
            $templateProcessor->setValue('secondConsultantSurname', $recordList['secondConsultantSurname']);
            $templateProcessor->setValue('secondConsultantCompany', $this->formatToWordTemplate($recordList['secondConsultantCompany']));
            $templateProcessor->setValue('secondConsultantEmail', "(Email: " . $recordList['secondConsultantEmail'] . ")");
        } else {
            $templateProcessor->setValue('secondConsultantCc', "");
            $templateProcessor->setValue('secondConsultantTitle', "");
            $templateProcessor->setValue('secondConsultantSurname', "");
            $templateProcessor->setValue('secondConsultantCompany', "");
            $templateProcessor->setValue('secondConsultantEmail', "");
        }

        $templateProcessor->setValue('faxRefNo', $thirdInvitationLetterFaxRefNo);
        $templateProcessor->setValue('faxDate', $thirdInvitationLetterFaxYear . "-" . $thirdInvitationLetterFaxMonth);
        $templateProcessor->setValue('issueDate', $thirdInvitationLetterIssueDateDay . " " .
            $thirdInvitationLetterIssueDateMonth . " " .
            $thirdInvitationLetterIssueDateYear);
        $templateProcessor->setValue('projectTitle', $this->formatToWordTemplate($recordList['projectTitle']));
        $templateProcessor->setValue('firstLetterIssueDate', $firstInvitationLetterIssueDate);
        $templateProcessor->setValue('firstLetterFaxRefNo', $firstInvitationLetterFaxRefNo);
        $templateProcessor->setValue('firstFaxDate', $firstInvitationLetterFaxYear . "-" . $firstInvitationLetterFaxMonth);
        $templateProcessor->setValue('secondLetterIssueDate', $secondInvitationLetterIssueDate);
        $templateProcessor->setValue('secondLetterFaxRefNo', $secondInvitationLetterFaxRefNo);
        $templateProcessor->setValue('secondFaxDate', $secondInvitationLetterFaxYear . "-" . $secondInvitationLetterFaxMonth);

        $pathToSave = $thirdInvitationLetterTemplatePath['configValue'] . 'temp\\(' . $schemeNo . ')' .
            $thirdInvitationLetterTemplateFileName['configValue'];
        $templateProcessor->saveAs($pathToSave);

        header("Content-Description: File Transfer");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header('Content-Disposition: attachment; filename='. basename($pathToSave));
        header('Content-Length: ' . filesize($pathToSave));
        header('Pragma: public');

        //Clear system output buffer
        flush();

        //Read the size of the file
        readfile($pathToSave);
        unlink($pathToSave); // deletes the temporary file

        die();

    }

    public function actionGetPlanningAheadProjectDetailForthInvitationLetterTemplate() {

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        $forthInvitationLetterIssueDate = $param['forthInvitationLetterIssueDate'];
        $forthInvitationLetterFaxRefNo = $param['forthInvitationLetterFaxRefNo'];
        $schemeNo = $param['schemeNo'];
        $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
        $lastUpdatedTime = date("Y-m-d H:i");

        $recordList = Yii::app()->planningAheadDao->getPlanningAheadDetails($schemeNo);


        // Update the issue date and fax ref no. to database first
        Yii::app()->planningAheadDao->updateForthInvitationLetter($recordList['planningAheadId'],
            $forthInvitationLetterIssueDate,$forthInvitationLetterFaxRefNo,$lastUpdatedBy,$lastUpdatedTime);

        $forthInvitationLetterTemplatePath = Yii::app()->commonUtil->
        getConfigValueByConfigName('planningAheadInvitationLetterTemplatePath');

        $forthInvitationLetterTemplateFileName = Yii::app()->commonUtil->
        getConfigValueByConfigName('planningAheadForthInvitationLetterTemplateFileName');

        $forthInvitationLetterFaxYear = date("y", strtotime($forthInvitationLetterIssueDate));
        $forthInvitationLetterFaxMonth = date("m", strtotime($forthInvitationLetterIssueDate));
        $forthInvitationLetterIssueDateDay = date("j", strtotime($forthInvitationLetterIssueDate));
        $forthInvitationLetterIssueDateMonth = date("M", strtotime($forthInvitationLetterIssueDate));
        $forthInvitationLetterIssueDateYear = date("Y", strtotime($forthInvitationLetterIssueDate));

        $templateProcessor = new TemplateProcessor($forthInvitationLetterTemplatePath['configValue'] .
            $forthInvitationLetterTemplateFileName['configValue']);
        $templateProcessor->setValue('firstProjectOwnerTitle', $recordList['firstProjectOwnerTitle']);
        $templateProcessor->setValue('firstProjectOwnerSurname', $recordList['firstProjectOwnerSurname']);
        $templateProcessor->setValue('firstProjectOwnerCompany', $this->formatToWordTemplate($recordList['firstProjectOwnerCompany']));
        $templateProcessor->setValue('firstProjectOwnerEmail', $recordList['firstProjectOwnerEmail']);

        if (isset($recordList['secondProjectOwnerSurname']) && (trim($recordList['secondProjectOwnerSurname']) != "")) {
            $templateProcessor->setValue('secondProjectOwnerCc', "c.c.");
            $templateProcessor->setValue('secondProjectOwnerTitle', "(" . $recordList['secondProjectOwnerTitle'] . ")");
            $templateProcessor->setValue('secondProjectOwnerSurname', $recordList['secondProjectOwnerSurname']);
            $templateProcessor->setValue('secondProjectOwnerCompany', $this->formatToWordTemplate($recordList['secondProjectOwnerCompany']));
            $templateProcessor->setValue('secondProjectOwnerEmail', "(Email: " . $recordList['secondProjectOwnerEmail'] . ")");
        } else {
            $templateProcessor->setValue('secondProjectOwnerCc', "");
            $templateProcessor->setValue('secondProjectOwnerTitle', "");
            $templateProcessor->setValue('secondProjectOwnerSurname', "");
            $templateProcessor->setValue('secondProjectOwnerCompany', "");
            $templateProcessor->setValue('secondProjectOwnerEmail', "");
        }

        $templateProcessor->setValue('faxRefNo', $forthInvitationLetterFaxRefNo);
        $templateProcessor->setValue('faxDate', $forthInvitationLetterFaxYear . "-" . $forthInvitationLetterFaxMonth);
        $templateProcessor->setValue('issueDate', $forthInvitationLetterIssueDateDay . " " .
            $forthInvitationLetterIssueDateMonth . " " .
            $forthInvitationLetterIssueDateYear);
        $templateProcessor->setValue('projectTitle', $this->formatToWordTemplate($recordList['projectTitle']));
        $templateProcessor->setValue('firstConsultantCompany', $this->formatToWordTemplate($recordList['firstConsultantCompany']));

        if (isset($recordList['firstInvitationLetterWalkDate'])) {
            $templateProcessor->setValue('pqSiteWalkDate', $this->formatToWordTemplate($recordList['firstInvitationLetterWalkDate']));
        } else if (isset($recordList['secondInvitationLetterWalkDate'])) {
            $templateProcessor->setValue('pqSiteWalkDate', $this->formatToWordTemplate($recordList['secondInvitationLetterWalkDate']));
        } else if (isset($recordList['thirdInvitationLetterWalkDate'])) {
            $templateProcessor->setValue('pqSiteWalkDate', $this->formatToWordTemplate($recordList['thirdInvitationLetterWalkDate']));
        }
        $templateProcessor->setValue('evaReportIssueDate', $this->formatToWordTemplate($recordList['evaReportIssueDate']));
        $templateProcessor->setValue('evaReportFaxRefNo', $this->formatToWordTemplate($recordList['evaReportFaxRefNo']));
        $evaReportFaxYear = date("y", strtotime($recordList['evaReportIssueDate']));
        $evaReportFaxMonth = date("m", strtotime($recordList['evaReportIssueDate']));
        $templateProcessor->setValue('evaReportFaxDate', $evaReportFaxYear . "-" . $evaReportFaxMonth);

        $pathToSave = $forthInvitationLetterTemplatePath['configValue'] . 'temp\\(' . $schemeNo . ')' .
            $forthInvitationLetterTemplateFileName['configValue'];
        $templateProcessor->saveAs($pathToSave);

        header("Content-Description: File Transfer");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header('Content-Disposition: attachment; filename='. basename($pathToSave));
        header('Content-Length: ' . filesize($pathToSave));
        header('Pragma: public');

        //Clear system output buffer
        flush();

        //Read the size of the file
        readfile($pathToSave);
        unlink($pathToSave); // deletes the temporary file

        die();

    }

    public function actionGetPlanningAheadProjectDetailEvaReportTemplate()
    {

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        $schemeNo = $param['schemeNo'];
        $recordList = Yii::app()->planningAheadDao->getPlanningAheadDetails($schemeNo);
        $checkedBox = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
        $unCheckedBox = '<w:sym w:font="Wingdings" w:char="F0A8"/>';

        $evaReportTemplatePath = Yii::app()->commonUtil->getConfigValueByConfigName('planningAheadEvaReportTemplatePath');
        $evaReportTemplateFileName = Yii::app()->commonUtil->getConfigValueByConfigName('planningAheadEvaReportTemplateFileName');

        $evaReportIssueDateDay = date("j", strtotime($recordList['evaReportIssueDate']));
        $evaReportIssueDateMonth = date("M", strtotime($recordList['evaReportIssueDate']));
        $evaReportIssueDateYear = date("Y", strtotime($recordList['evaReportIssueDate']));
        $evaReportFaxDateMonth = date("m", strtotime($recordList['evaReportIssueDate']));
        $evaReportFaxDateYear = date("y", strtotime($recordList['evaReportIssueDate']));
        $commissionDateMonth = date("M", strtotime($recordList['commissionDate']));
        $commissionDateYear = date("Y", strtotime($recordList['commissionDate']));
        $replySlipReturnDateMonth = date("M", strtotime($recordList['replySlipLastUploadTime']));
        $replySlipReturnDateYear = date("Y", strtotime($recordList['replySlipLastUploadTime']));

        $templateProcessor = new TemplateProcessor($evaReportTemplatePath['configValue'] . $evaReportTemplateFileName['configValue']);

        $templateProcessor->setValue('projectTitle', $this->formatToWordTemplate($recordList['projectTitle']));
        $templateProcessor->setValue('issueDate', $evaReportIssueDateDay . " " . $evaReportIssueDateMonth . " " . $evaReportIssueDateYear);
        $templateProcessor->setValue('commissionDate', $commissionDateMonth . " " . $commissionDateYear);
        $templateProcessor->setValue('replySlipReturnDate', $replySlipReturnDateMonth . " " . $replySlipReturnDateYear);
        $templateProcessor->setValue('firstConsultantEmail', $recordList['firstConsultantEmail']);
        $templateProcessor->setValue('firstConsultantTitle', $recordList['firstConsultantTitle']);
        $templateProcessor->setValue('firstConsultantSurname', $recordList['firstConsultantSurname']);
        $templateProcessor->setValue('firstConsultantCompany', $this->formatToWordTemplate($recordList['firstConsultantCompany']));
        $templateProcessor->setValue('faxRefNo', $this->formatToWordTemplate($recordList['evaReportFaxRefNo']));
        $templateProcessor->setValue('faxDate', $evaReportFaxDateYear . "-" . $evaReportFaxDateMonth);
        $templateProcessor->setValue('firstConsultantCompanyAdd1', $this->formatToWordTemplate($recordList['firstConsultantCompanyAdd1']));
        $templateProcessor->setValue('firstConsultantCompanyAdd2', $this->formatToWordTemplate($recordList['firstConsultantCompanyAdd2']));
        $templateProcessor->setValue('firstConsultantCompanyAdd3', $this->formatToWordTemplate($recordList['firstConsultantCompanyAdd3']));
        $templateProcessor->setValue('firstConsultantCompanyAdd4', $this->formatToWordTemplate($recordList['firstConsultantCompanyAdd4']));
        if (isset($recordList['secondConsultantSurname']) && (trim($recordList['secondConsultantSurname']) != "")) {
            $templateProcessor->setValue('secondConsultantCc', "c.c.");
            $templateProcessor->setValue('secondConsultantCompany', "(" . $this->formatToWordTemplate($recordList['secondConsultantCompany']) . ")");
            $templateProcessor->setValue('secondConsultantTitle', $recordList['secondConsultantTitle']);
            $templateProcessor->setValue('secondConsultantSurname', $recordList['secondConsultantSurname']);
            $templateProcessor->setValue('secondConsultantEmail', "(Email: " . $recordList['secondConsultantEmail'] . ")");
        } else {
            $templateProcessor->setValue('secondConsultantCc', "");
            $templateProcessor->setValue('secondConsultantCompany', "");
            $templateProcessor->setValue('secondConsultantTitle', "");
            $templateProcessor->setValue('secondConsultantSurname', "");
            $templateProcessor->setValue('secondConsultantEmail', "");
        }
        if (isset($recordList['firstInvitationLetterWalkDate'])) {
            $siteVisitDateDay = date("j", strtotime($recordList['firstInvitationLetterWalkDate']));
            $siteVisitDateMonth = date("M", strtotime($recordList['firstInvitationLetterWalkDate']));
            $siteVisitDateYear = date("Y", strtotime($recordList['firstInvitationLetterWalkDate']));
            $templateProcessor->setValue('siteVisitDate', $siteVisitDateDay . " " . $siteVisitDateMonth . " " . $siteVisitDateYear);
        } else if (isset($recordList['secondInvitationLetterWalkDate'])) {
            $siteVisitDateDay = date("j", strtotime($recordList['secondInvitationLetterWalkDate']));
            $siteVisitDateMonth = date("M", strtotime($recordList['secondInvitationLetterWalkDate']));
            $siteVisitDateYear = date("Y", strtotime($recordList['secondInvitationLetterWalkDate']));
            $templateProcessor->setValue('siteVisitDate', $siteVisitDateDay . " " . $siteVisitDateMonth . " " . $siteVisitDateYear);
        } else if (isset($recordList['thirdInvitationLetterWalkDate'])) {
            $siteVisitDateDay = date("j", strtotime($recordList['thirdInvitationLetterWalkDate']));
            $siteVisitDateMonth = date("M", strtotime($recordList['thirdInvitationLetterWalkDate']));
            $siteVisitDateYear = date("Y", strtotime($recordList['thirdInvitationLetterWalkDate']));
            $templateProcessor->setValue('siteVisitDate', $siteVisitDateDay . " " . $siteVisitDateMonth . " " . $siteVisitDateYear);
        }

        $contentCount=1;

        // check if BMS contains information
        if ($recordList['evaReportBmsYesNo'] == 'Y') {
            $templateProcessor->setValue('bmsYN', $checkedBox);
        } else {
            $templateProcessor->setValue('bmsYN', $unCheckedBox);
        }
        if ($recordList['evaReportBmsServerCentralComputerYesNo'] == 'Y') {
            $templateProcessor->setValue('bmsSCCYesNo', $checkedBox);
        } else {
            $templateProcessor->setValue('bmsSCCYesNo', $unCheckedBox);
        }
        if ($recordList['evaReportBmsDdcYesNo'] == 'Y') {
            $templateProcessor->setValue('bmsDdcYN', $checkedBox);
        } else {
            $templateProcessor->setValue('bmsDdcYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipBmsServerCentralComputer']) && ($recordList['replySlipBmsServerCentralComputer'] != "")) {
            $templateProcessor->setValue('bmsSCC', $this->formatToWordTemplate($recordList['replySlipBmsServerCentralComputer']));
        } else {
            $templateProcessor->setValue('bmsSCC',"Nil");
        }
        if (isset($recordList['evaReportBmsServerCentralComputerFinding']) && ($recordList['evaReportBmsServerCentralComputerFinding']!="")) {
            $content = $recordList['evaReportBmsServerCentralComputerFinding'];
            $templateProcessor->setValue('bmsSCCFind', $this->formatToWordTemplate($recordList['evaReportBmsServerCentralComputerFinding']));
            if (isset($recordList['evaReportBmsServerCentralComputerRecommend']) && (trim($recordList['evaReportBmsServerCentralComputerRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportBmsServerCentralComputerRecommend'];
                $templateProcessor->setValue('bmsSCCRec', $this->formatToWordTemplate($recordList['evaReportBmsServerCentralComputerRecommend']));
            } else {
                $content = $content . " hence, their operations for controlling building facilities would be sustained under voltage dip incidents.";
                $templateProcessor->setValue('bmsSCCRec', 'Nil');
            }
        } else {
            $templateProcessor->setValue('bmsSCCFind', 'Nil');
            $templateProcessor->setValue('bmsSCCRec', 'Nil');
        }
        if (isset($recordList['replySlipBmsDdc']) && ($recordList['replySlipBmsDdc'] != "")) {
            $templateProcessor->setValue('bmsDdc', $this->formatToWordTemplate($recordList['replySlipBmsDdc']));
        } else {
            $templateProcessor->setValue('bmsDdc',"Nil");
        }
        if (isset($recordList['evaReportBmsDdcFinding']) && ($recordList['evaReportBmsDdcFinding']!="")) {
            $content = $content . " " . $recordList['evaReportBmsDdcFinding'];
            $templateProcessor->setValue('bmsDdcFind', $this->formatToWordTemplate($recordList['evaReportBmsDdcFinding']));
            if (isset($recordList['evaReportBmsDdcRecommend']) && (trim($recordList['evaReportBmsDdcRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportBmsDdcRecommend'];
                $templateProcessor->setValue('bmsDdcRec', $this->formatToWordTemplate($recordList['evaReportBmsDdcRecommend']));
            } else {
                $templateProcessor->setValue('bmsDdcRec', 'Nil');
            }
        } else {
            $templateProcessor->setValue('bmsDdcFind', 'Nil');
            $templateProcessor->setValue('bmsDdcRec', 'Nil');
        }
        if (isset($content) && (trim($content) != "")) {
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun($content));
            $contentCount++;
        }
        if (isset($recordList['evaReportBmsSupplement']) && ($recordList['evaReportBmsSupplement']!="")) {
            $content = $recordList['evaReportBmsSupplement'];
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun($content));
            $templateProcessor->setValue('bmsSupplement', $this->formatToWordTemplate($recordList['evaReportBmsSupplement']));
            $contentCount++;
        } else {
            $templateProcessor->setValue('bmsSupplement', "Nil");
        }

        // check if changeover contains information
        $changeoverFindingCount=1; $changeoverFindingMaxCount=2;
        $changeoverRecommendCount=1; $changeoverRecommendMaxCount=2;
        if ($recordList['evaReportChangeoverSchemeYesNo'] == 'Y') {
            $templateProcessor->setValue('chgSchYN', $checkedBox);
        } else {
            $templateProcessor->setValue('chgSchYN', $unCheckedBox);
        }
        if ($recordList['evaReportChangeoverSchemeControlYesNo'] == 'Y') {
            $templateProcessor->setValue('chgSchCtlYN', $checkedBox);
        } else {
            $templateProcessor->setValue('chgSchCtlYN', $unCheckedBox);
        }
        if ($recordList['evaReportChangeoverSchemeYesNo'] == 'Y') {
            $templateProcessor->setValue('chgSchUvYN', $checkedBox);
        } else {
            $templateProcessor->setValue('chgSchUvYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipChangeoverSchemeControl']) && ($recordList['replySlipChangeoverSchemeControl'] != "")) {
            $templateProcessor->setValue('chgSchCtl', $this->formatToWordTemplate($recordList['replySlipChangeoverSchemeControl']));
        } else {
            $templateProcessor->setValue('chgSchCtl',"Nil");
        }
        if (isset($recordList['evaReportChangeoverSchemeControlFinding']) && ($recordList['evaReportChangeoverSchemeControlFinding']!="")) {
            $content = $recordList['evaReportChangeoverSchemeControlFinding'];
            $templateProcessor->setComplexBlock('changeoverSchemeFinding' . $changeoverFindingCount, $this->getTableListItemRun($recordList['evaReportChangeoverSchemeControlFinding']));
            $changeoverFindingCount++;
            if (isset($recordList['evaReportChangeoverSchemeControlRecommend']) && (trim($recordList['evaReportChangeoverSchemeControlRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportChangeoverSchemeControlRecommend'];
                $templateProcessor->setComplexBlock('changeoverSchemeRecommend' . $changeoverRecommendCount, $this->getTableListItemRun($recordList['evaReportChangeoverSchemeControlRecommend']));
                $changeoverRecommendCount++;
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun($content));
            $contentCount++;
        }
        if (isset($recordList['replySlipChangeoverSchemeUv']) && ($recordList['replySlipChangeoverSchemeUv'] != "")) {
            $templateProcessor->setValue('chgSchUv', $this->formatToWordTemplate($recordList['replySlipChangeoverSchemeUv']));
        } else {
            $templateProcessor->setValue('chgSchUv',"Nil");
        }
        if (isset($recordList['evaReportChangeoverSchemeUvFinding']) && ($recordList['evaReportChangeoverSchemeUvFinding']!="")) {
            $content = $recordList['evaReportChangeoverSchemeUvFinding'];
            $templateProcessor->setComplexBlock('changeoverSchemeFinding' . $changeoverFindingCount, $this->getTableListItemRun($recordList['evaReportChangeoverSchemeUvFinding']));
            $changeoverFindingCount++;
            if (isset($recordList['evaReportChangeoverSchemeUvRecommend']) && (trim($recordList['evaReportChangeoverSchemeUvRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportChangeoverSchemeUvRecommend'];
                $templateProcessor->setComplexBlock('changeoverSchemeRecommend' . $changeoverRecommendCount, $this->getTableListItemRun($recordList['evaReportChangeoverSchemeUvRecommend']));
                $changeoverRecommendCount++;
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun($content));
            $contentCount++;
        }

        if ($changeoverFindingCount==1) {
            $templateProcessor->setValue('changeoverSchemeFinding1', "Nil");
            $templateProcessor->setValue('changeoverSchemeFinding2', "");
        } else {
            for ($x=$changeoverFindingCount; $x<=$changeoverFindingMaxCount; $x++) {
                $templateProcessor->setValue('changeoverSchemeFinding' . $x, "");
            }
        }
        if ($changeoverRecommendCount==1) {
            $templateProcessor->setValue('changeoverSchemeRecommend1', "Nil");
            $templateProcessor->setValue('changeoverSchemeRecommend2', "");
        } else {
            for ($x=$changeoverRecommendCount; $x<=$changeoverRecommendMaxCount; $x++) {
                $templateProcessor->setValue('changeoverSchemeRecommend' . $x, "");
            }
        }
        if (isset($recordList['evaReportChangeoverSchemeSupplement']) && ($recordList['evaReportChangeoverSchemeSupplement']!="")) {
            $content = $recordList['evaReportChangeoverSchemeSupplement'];
            $templateProcessor->setValue('changeoverSchemeSupplement', $this->formatToWordTemplate($recordList['evaReportChangeoverSchemeSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun($content));
            $contentCount++;
        } else {
            $templateProcessor->setValue('changeoverSchemeSupplement', "Nil");
        }

        // check if Chiller Plant contains information
        if ($recordList['evaReportChillerPlantYesNo'] == 'Y') {
            $templateProcessor->setValue('chilPltYN', $checkedBox);
        } else {
            $templateProcessor->setValue('chilPltYN', $unCheckedBox);
        }
        if ($recordList['evaReportChillerPlantAhuChilledWaterYesNo'] == 'Y') {
            $templateProcessor->setValue('chilPltAhuYN', $checkedBox);
        } else {
            $templateProcessor->setValue('chilPltAhuYN', $unCheckedBox);
        }
        if ($recordList['evaReportChillerPlantChillerYesNo'] == 'Y') {
            $templateProcessor->setValue('chilPltChilYN', $checkedBox);
        } else {
            $templateProcessor->setValue('chilPltChilYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipChillerPlantAhuChilledWater']) && ($recordList['replySlipChillerPlantAhuChilledWater'] != "")) {
            $templateProcessor->setValue('chilPltAhu', $this->formatToWordTemplate($recordList['replySlipChillerPlantAhuChilledWater']));
        } else {
            $templateProcessor->setValue('chilPltAhu',"Nil");
        }
        if (isset($recordList['evaReportChillerPlantAhuChilledWaterFinding']) && ($recordList['evaReportChillerPlantAhuChilledWaterFinding']!="")) {
            $content = $recordList['evaReportChillerPlantAhuChilledWaterFinding'];
            $templateProcessor->setValue('chilPltAhuFind', $this->formatToWordTemplate($recordList['evaReportChillerPlantAhuChilledWaterFinding']));
            if (isset($recordList['evaReportChillerPlantAhuChilledWaterRecommend']) && (trim($recordList['evaReportChillerPlantAhuChilledWaterRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportChillerPlantAhuChilledWaterRecommend'];
                $templateProcessor->setValue('chilPltAhuRec', $this->formatToWordTemplate($recordList['evaReportChillerPlantAhuChilledWaterFinding']));
            } else {
                $templateProcessor->setValue('chilPltAhuRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun($content));
            $contentCount++;
        } else {
            $templateProcessor->setValue('chilPltAhuFind', "Nil");
            $templateProcessor->setValue('chilPltAhuRec', "Nil");
        }
        if (isset($recordList['replySlipChillerPlantChiller']) && ($recordList['replySlipChillerPlantChiller'] != "")) {
            $templateProcessor->setValue('chilPltChil', $this->formatToWordTemplate($recordList['replySlipChillerPlantChiller']));
        } else {
            $templateProcessor->setValue('chilPltChil',"Nil");
        }
        if (isset($recordList['evaReportChillerPlantChillerFinding']) && ($recordList['evaReportChillerPlantChillerFinding']!="")) {
            $content = $recordList['evaReportChillerPlantChillerFinding'];
            $templateProcessor->setValue('chilPltChilFind', $this->formatToWordTemplate($recordList['evaReportChillerPlantChillerFinding']));
            if (isset($recordList['evaReportChillerPlantChillerRecommend']) && (trim($recordList['evaReportChillerPlantChillerRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportChillerPlantChillerRecommend'];
                $templateProcessor->setValue('chilPltChilRec', $this->formatToWordTemplate($recordList['evaReportChillerPlantChillerRecommend']));
            } else {
                $templateProcessor->setValue('chilPltChilRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun($content));
            $contentCount++;
        } else {
            $templateProcessor->setValue('chilPltChilFind', "Nil");
            $templateProcessor->setValue('chilPltChilRec', "Nil");
        }
        if (isset($recordList['evaReportChillerPlantSupplement']) && ($recordList['evaReportChillerPlantSupplement']!="")) {
            $content = $recordList['evaReportChillerPlantSupplement'];
            $templateProcessor->setValue('chillerPlantSupplement', $this->formatToWordTemplate($recordList['evaReportChillerPlantSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun($content));
            $contentCount++;
        } else {
            $templateProcessor->setValue('chillerPlantSupplement', "Nil");
        }

        // check if escalator contains information
        if ($recordList['evaReportEscalatorYesNo'] == 'Y') {
            $templateProcessor->setValue('escYN', $checkedBox);
        } else {
            $templateProcessor->setValue('escYN', $unCheckedBox);
        }
        if ($recordList['evaReportEscalatorBrakingSystemYesNo'] == 'Y') {
            $templateProcessor->setValue('escBraSysYN', $checkedBox);
        } else {
            $templateProcessor->setValue('escBraSysYN', $unCheckedBox);
        }
        if ($recordList['evaReportEscalatorControlYesNo'] == 'Y') {
            $templateProcessor->setValue('escCtlYN', $checkedBox);
        } else {
            $templateProcessor->setValue('escCtlYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipEscalatorBrakingSystem']) && ($recordList['replySlipEscalatorBrakingSystem'] != "")) {
            $templateProcessor->setValue('escBraSys', $this->formatToWordTemplate($recordList['replySlipEscalatorBrakingSystem']));
        } else {
            $templateProcessor->setValue('escBraSys',"Nil");
        }
        if (isset($recordList['evaReportEscalatorBrakingSystemFinding']) && ($recordList['evaReportEscalatorBrakingSystemFinding']!="")) {
            $content = $recordList['evaReportEscalatorBrakingSystemFinding'];
            $templateProcessor->setValue('escBraSysFind', $this->formatToWordTemplate($recordList['evaReportEscalatorBrakingSystemFinding']));
            if (isset($recordList['evaReportEscalatorBrakingSystemRecommend']) && (trim($recordList['evaReportEscalatorBrakingSystemRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportEscalatorBrakingSystemRecommend'];
                $templateProcessor->setValue('escBraSysRec', $this->formatToWordTemplate($recordList['evaReportEscalatorBrakingSystemRecommend']));
            } else {
                $templateProcessor->setValue('escBraSysRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('escBraSysFind', "Nil");
            $templateProcessor->setValue('escBraSysRec', "Nil");
        }
        if (isset($recordList['replySlipEscalatorControl']) && ($recordList['replySlipEscalatorControl'] != "")) {
            $templateProcessor->setValue('escCtl', $this->formatToWordTemplate($recordList['replySlipEscalatorControl']));
        } else {
            $templateProcessor->setValue('escCtl',"Nil");
        }
        if (isset($recordList['evaReportEscalatorControlFinding']) && ($recordList['evaReportEscalatorControlFinding']!="")) {
            $content = $recordList['evaReportEscalatorControlFinding'];
            $templateProcessor->setValue('escCtlFind', $this->formatToWordTemplate($recordList['evaReportEscalatorControlFinding']));
            if (isset($recordList['evaReportEscalatorControlRecommend']) && (trim($recordList['evaReportEscalatorControlRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportEscalatorControlRecommend'];
                $templateProcessor->setValue('escCtlRec', $this->formatToWordTemplate($recordList['evaReportEscalatorControlRecommend']));
            } else {
                $templateProcessor->setValue('escCtlRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('escCtlFind', "Nil");
            $templateProcessor->setValue('escCtlRec', "Nil");
        }
        if (isset($recordList['evaReportEscalatorSupplement']) && ($recordList['evaReportEscalatorSupplement']!="")) {
            $content = $recordList['evaReportEscalatorSupplement'];
            $templateProcessor->setValue('escalatorSupplement', $this->formatToWordTemplate($recordList['evaReportEscalatorSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('escalatorSupplement', "Nil");
        }

        // check if LED Lighting contains information
        if ($recordList['evaReportHidLampYesNo'] == 'Y') {
            $templateProcessor->setValue('hidYN', $checkedBox);
        } else {
            $templateProcessor->setValue('hidYN', $unCheckedBox);
        }
        if ($recordList['evaReportHidLampBallastYesNo'] == 'Y') {
            $templateProcessor->setValue('hidBallYN', $checkedBox);
        } else {
            $templateProcessor->setValue('hidBallYN', $unCheckedBox);
        }
        if ($recordList['evaReportHidLampAddonProtectYesNo'] == 'Y') {
            $templateProcessor->setValue('hidAddonYN', $checkedBox);
        } else {
            $templateProcessor->setValue('hidAddonYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipHidLampMitigation']) && ($recordList['replySlipHidLampMitigation'] != "")) {
            $templateProcessor->setValue('hidMit', $this->formatToWordTemplate($recordList['replySlipHidLampMitigation']));
        } else {
            $templateProcessor->setValue('hidMit',"Nil");
        }
        if (isset($recordList['evaReportHidLampBallastFinding']) && ($recordList['evaReportHidLampBallastFinding']!="")) {
            $content = $recordList['evaReportHidLampBallastFinding'];
            $templateProcessor->setValue('hidBallFind', $this->formatToWordTemplate($recordList['evaReportHidLampBallastFinding']));
            if (isset($recordList['evaReportHidLampBallastRecommend']) && (trim($recordList['evaReportHidLampBallastRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportHidLampBallastRecommend'];
                $templateProcessor->setValue('hidBallRec', $this->formatToWordTemplate($recordList['evaReportHidLampBallastRecommend']));
            } else {
                $templateProcessor->setValue('hidBallRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('hidBallFind', "Nil");
            $templateProcessor->setValue('hidBallRec', "Nil");
        }
        if (isset($recordList['evaReportHidLampAddonProtectFinding']) && ($recordList['evaReportHidLampAddonProtectFinding']!="")) {
            $content = $recordList['evaReportHidLampAddonProtectFinding'];
            $templateProcessor->setValue('hidAddonFind', $this->formatToWordTemplate($recordList['evaReportHidLampAddonProtectFinding']));
            if (isset($recordList['evaReportHidLampAddonProtectRecommend']) && (trim($recordList['evaReportHidLampAddonProtectRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportHidLampAddonProtectRecommend'];
                $templateProcessor->setValue('hidAddonRec', $this->formatToWordTemplate($recordList['evaReportHidLampAddonProtectRecommend']));
            } else {
                $templateProcessor->setValue('hidAddonRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('hidAddonFind', "Nil");
            $templateProcessor->setValue('hidAddonRec', "Nil");
        }
        if (isset($recordList['evaReportHidLampSupplement']) && ($recordList['evaReportHidLampSupplement']!="")) {
            $content = $recordList['evaReportHidLampSupplement'];
            $templateProcessor->setValue('hidLampSupplement', $this->formatToWordTemplate($recordList['evaReportHidLampSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('hidLampSupplement', "Nil");
        }

        // check if Lift contains information
        if ($recordList['evaReportLiftYesNo'] == 'Y') {
            $templateProcessor->setValue('liftYN', $checkedBox);
        } else {
            $templateProcessor->setValue('liftYN', $unCheckedBox);
        }
        if ($recordList['evaReportLiftOperationYesNo'] == 'Y') {
            $templateProcessor->setValue('liftOptYN', $checkedBox);
        } else {
            $templateProcessor->setValue('liftOptYN', $unCheckedBox);
        }
        if ($recordList['evaReportLiftMainSupplyYesNo'] == 'Y') {
            $templateProcessor->setValue('liftMainYN', $checkedBox);
        } else {
            $templateProcessor->setValue('liftMainYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipLiftOperation']) && ($recordList['replySlipLiftOperation'] != "")) {
            $templateProcessor->setValue('liftOpt', $this->formatToWordTemplate($recordList['replySlipLiftOperation']));
        } else {
            $templateProcessor->setValue('liftOpt',"Nil");
        }
        if (isset($recordList['evaReportLiftOperationFinding']) && ($recordList['evaReportLiftOperationFinding']!="")) {
            $content = $recordList['evaReportLiftOperationFinding'];
            $templateProcessor->setValue('liftOptFind', $this->formatToWordTemplate($recordList['evaReportLiftOperationFinding']));
            if (isset($recordList['evaReportLiftOperationRecommend']) && (trim($recordList['evaReportLiftOperationRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportLiftOperationRecommend'];
                $templateProcessor->setValue('liftOptRec', $this->formatToWordTemplate($recordList['evaReportLiftOperationRecommend']));
            } else {
                $templateProcessor->setValue('liftOptRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('liftOptFind', "Nil");
            $templateProcessor->setValue('liftOptRec', "Nil");
        }
        if (isset($recordList['evaReportLiftMainSupplyFinding']) && ($recordList['evaReportLiftMainSupplyFinding']!="")) {
            $content = $recordList['evaReportLiftMainSupplyFinding'];
            $templateProcessor->setValue('liftMainFind', $this->formatToWordTemplate($recordList['evaReportLiftMainSupplyFinding']));
            if (isset($recordList['evaReportLiftMainSupplyRecommend']) && (trim($recordList['evaReportLiftMainSupplyRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportLiftMainSupplyRecommend'];
                $templateProcessor->setValue('liftMainRec', $this->formatToWordTemplate($recordList['evaReportLiftMainSupplyRecommend']));
            } else {
                $templateProcessor->setValue('liftMainRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('liftMainFind', "Nil");
            $templateProcessor->setValue('liftMainRec', "Nil");
        }
        if (isset($recordList['evaReportLiftSupplement']) && ($recordList['evaReportLiftSupplement']!="")) {
            $content = $recordList['evaReportLiftSupplement'];
            $templateProcessor->setValue('liftSupplement', $this->formatToWordTemplate($recordList['evaReportLiftSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('liftSupplement', "Nil");
        }

        // check if Sensitive Machine contains information
        if ($recordList['evaReportSensitiveMachineYesNo'] == 'Y') {
            $templateProcessor->setValue('senYN', $checkedBox);
        } else {
            $templateProcessor->setValue('senYN', $unCheckedBox);
        }
        if ($recordList['evaReportSensitiveMachineMedicalYesNo'] == 'Y') {
            $templateProcessor->setValue('senMedYN', $checkedBox);
        } else {
            $templateProcessor->setValue('senMedYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipSensitiveMachineMitigation']) && ($recordList['replySlipSensitiveMachineMitigation'] != "")) {
            $templateProcessor->setValue('senMedMit', $this->formatToWordTemplate($recordList['replySlipSensitiveMachineMitigation']));
        } else {
            $templateProcessor->setValue('senMedMit',"Nil");
        }
        if (isset($recordList['evaReportSensitiveMachineMedicalFinding']) && ($recordList['evaReportSensitiveMachineMedicalFinding']!="")) {
            $content = $recordList['evaReportSensitiveMachineMedicalFinding'];
            $templateProcessor->setValue('senMedMitFind', $this->formatToWordTemplate($recordList['evaReportSensitiveMachineMedicalFinding']));
            if (isset($recordList['evaReportSensitiveMachineMedicalRecommend']) && (trim($recordList['evaReportSensitiveMachineMedicalRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportSensitiveMachineMedicalRecommend'];
                $templateProcessor->setValue('senMedMitRec', $this->formatToWordTemplate($recordList['evaReportSensitiveMachineMedicalRecommend']));
            } else {
                $templateProcessor->setValue('senMedMitRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('senMedMitFind', "Nil");
            $templateProcessor->setValue('senMedMitRec', "Nil");
        }
        if (isset($recordList['evaReportSensitiveMachineSupplement']) && ($recordList['evaReportSensitiveMachineSupplement']!="")) {
            $content = $recordList['evaReportSensitiveMachineSupplement'];
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $templateProcessor->setValue('sensitiveMachineSupplement', $this->formatToWordTemplate($recordList['evaReportSensitiveMachineSupplement']));
            $contentCount++;
        } else {
            $templateProcessor->setValue('sensitiveMachineSupplement', "Nil");
        }

        // check if Telecom contains information
        if ($recordList['evaReportTelecomMachineYesNo'] == 'Y') {
            $templateProcessor->setValue('telYN', $checkedBox);
        } else {
            $templateProcessor->setValue('telYN', $unCheckedBox);
        }
        if ($recordList['evaReportTelecomMachineServerOrComputerYesNo'] == 'Y') {
            $templateProcessor->setValue('telSCYN', $checkedBox);
        } else {
            $templateProcessor->setValue('telSCYN', $unCheckedBox);
        }
        if ($recordList['evaReportTelecomMachinePeripheralsYesNo'] == 'Y') {
            $templateProcessor->setValue('telPerYN', $checkedBox);
        } else {
            $templateProcessor->setValue('telPerYN', $unCheckedBox);
        }
        if ($recordList['evaReportTelecomMachineHarmonicEmissionYesNo'] == 'Y') {
            $templateProcessor->setValue('telHarYN', $checkedBox);
        } else {
            $templateProcessor->setValue('telHarYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipTelecomMachineServerOrComputer']) && ($recordList['replySlipTelecomMachineServerOrComputer'] != "")) {
            $templateProcessor->setValue('telSC', $this->formatToWordTemplate($recordList['replySlipTelecomMachineServerOrComputer']));
        } else {
            $templateProcessor->setValue('telSC',"Nil");
        }
        if (isset($recordList['evaReportTelecomMachineServerOrComputerFinding']) && ($recordList['evaReportTelecomMachineServerOrComputerFinding']!="")) {
            $content = $recordList['evaReportTelecomMachineServerOrComputerFinding'];
            $templateProcessor->setValue('telSCFind', $this->formatToWordTemplate($recordList['evaReportTelecomMachineServerOrComputerFinding']));
            if (isset($recordList['evaReportTelecomMachineServerOrComputerRecommend']) && (trim($recordList['evaReportTelecomMachineServerOrComputerRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportTelecomMachineServerOrComputerRecommend'];
                $templateProcessor->setValue('telSCRec', $this->formatToWordTemplate($recordList['evaReportTelecomMachineServerOrComputerRecommend']));
            } else {
                $templateProcessor->setValue('telSCRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('telSCFind', "Nil");
            $templateProcessor->setValue('telSCRec', "Nil");
        }
        if (isset($recordList['replySlipTelecomMachinePeripherals']) && ($recordList['replySlipTelecomMachinePeripherals'] != "")) {
            $templateProcessor->setValue('telPer', $this->formatToWordTemplate($recordList['replySlipTelecomMachinePeripherals']));
        } else {
            $templateProcessor->setValue('telPer',"Nil");
        }
        if (isset($recordList['evaReportTelecomMachinePeripheralsFinding']) && ($recordList['evaReportTelecomMachinePeripheralsFinding']!="")) {
            $content = $recordList['evaReportTelecomMachinePeripheralsFinding'];
            $templateProcessor->setValue('telPerFind', $this->formatToWordTemplate($recordList['evaReportTelecomMachinePeripheralsFinding']));
            if (isset($recordList['evaReportTelecomMachinePeripheralsRecommend']) && (trim($recordList['evaReportTelecomMachinePeripheralsRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportTelecomMachinePeripheralsRecommend'];
                $templateProcessor->setValue('telPerRec', $this->formatToWordTemplate($recordList['evaReportTelecomMachinePeripheralsRecommend']));
            } else {
                $templateProcessor->setValue('telPerRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('telPerFind', "Nil");
            $templateProcessor->setValue('telPerRec', "Nil");
        }
        if (isset($recordList['replySlipTelecomMachineHarmonicEmission']) && ($recordList['replySlipTelecomMachineHarmonicEmission'] != "")) {
            $templateProcessor->setValue('telHar', $this->formatToWordTemplate($recordList['replySlipTelecomMachineHarmonicEmission']));
        } else {
            $templateProcessor->setValue('telHar',"Nil");
        }
        if (isset($recordList['evaReportTelecomMachineHarmonicEmissionFinding']) && ($recordList['evaReportTelecomMachineHarmonicEmissionFinding']!="")) {
            $content = $recordList['evaReportTelecomMachineHarmonicEmissionFinding'];
            $templateProcessor->setValue('telHarFind', $this->formatToWordTemplate($recordList['evaReportTelecomMachineHarmonicEmissionFinding']));
            if (isset($recordList['evaReportTelecomMachineHarmonicEmissionRecommend']) && (trim($recordList['evaReportTelecomMachineHarmonicEmissionRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportTelecomMachineHarmonicEmissionRecommend'];
                $templateProcessor->setValue('telHarRec', $this->formatToWordTemplate($recordList['evaReportTelecomMachineHarmonicEmissionRecommend']));
            } else {
                $templateProcessor->setValue('telHarRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('telHarFind', "Nil");
            $templateProcessor->setValue('telHarRec', "Nil");
        }
        if (isset($recordList['evaReportTelecomMachineSupplement']) && ($recordList['evaReportTelecomMachineSupplement']!="")) {
            $content = $recordList['evaReportTelecomMachineSupplement'];
            $templateProcessor->setValue('telecomMachineSupplement', $this->formatToWordTemplate($recordList['evaReportTelecomMachineSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('telecomMachineSupplement', "Nil");
        }

        // check if Air Conditioners contains information
        if ($recordList['evaReportAirConditionersYesNo'] == 'Y') {
            $templateProcessor->setValue('airConYN', $checkedBox);
        } else {
            $templateProcessor->setValue('airConYN', $unCheckedBox);
        }
        if ($recordList['evaReportAirConditionersMicbYesNo'] == 'Y') {
            $templateProcessor->setValue('airConMicbYN', $checkedBox);
        } else {
            $templateProcessor->setValue('airConMicbYN', $unCheckedBox);
        }
        if ($recordList['evaReportAirConditionersLoadForecastingYesNo'] == 'Y') {
            $templateProcessor->setValue('airConForYN', $checkedBox);
        } else {
            $templateProcessor->setValue('airConForYN', $unCheckedBox);
        }
        if ($recordList['evaReportAirConditionersTypeYesNo'] == 'Y') {
            $templateProcessor->setValue('airConTypYN', $checkedBox);
        } else {
            $templateProcessor->setValue('airConTypYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipAirConditionersMicb']) && ($recordList['replySlipAirConditionersMicb'] != "")) {
            $templateProcessor->setValue('airConMicb', $this->formatToWordTemplate($recordList['replySlipAirConditionersMicb']));
        } else {
            $templateProcessor->setValue('airConMicb',"Nil");
        }
        if (isset($recordList['evaReportAirConditionersMicbFinding']) && ($recordList['evaReportAirConditionersMicbFinding']!="")) {
            $content = $recordList['evaReportAirConditionersMicbFinding'];
            $templateProcessor->setValue('airConMicbFind', $this->formatToWordTemplate($recordList['evaReportAirConditionersMicbFinding']));
            if (isset($recordList['evaReportAirConditionersMicbRecommend']) && (trim($recordList['evaReportAirConditionersMicbRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportAirConditionersMicbRecommend'];
                $templateProcessor->setValue('airConMicbRec', $this->formatToWordTemplate($recordList['evaReportAirConditionersMicbRecommend']));
            } else {
                $templateProcessor->setValue('airConMicbRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('airConMicbFind', "Nil");
            $templateProcessor->setValue('airConMicbRec', "Nil");
        }
        if (isset($recordList['replySlipAirConditionersLoadForecasting']) && ($recordList['replySlipAirConditionersLoadForecasting'] != "")) {
            $templateProcessor->setValue('airConFor', $this->formatToWordTemplate($recordList['replySlipAirConditionersLoadForecasting']));
        } else {
            $templateProcessor->setValue('airConFor',"Nil");
        }
        if (isset($recordList['evaReportAirConditionersLoadForecastingFinding']) && ($recordList['evaReportAirConditionersLoadForecastingFinding']!="")) {
            $content = $recordList['evaReportAirConditionersLoadForecastingFinding'];
            $templateProcessor->setValue('airConForFind', $this->formatToWordTemplate($recordList['evaReportAirConditionersLoadForecastingFinding']));
            if (isset($recordList['evaReportAirConditionersLoadForecastingRecommend']) && (trim($recordList['evaReportAirConditionersLoadForecastingRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportAirConditionersLoadForecastingRecommend'];
                $templateProcessor->setValue('airConForRec', $this->formatToWordTemplate($recordList['evaReportAirConditionersLoadForecastingRecommend']));
            } else {
                $templateProcessor->setValue('airConForRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('airConForFind', "Nil");
            $templateProcessor->setValue('airConForRec', "Nil");
        }
        if (isset($recordList['replySlipAirConditionersType']) && ($recordList['replySlipAirConditionersType'] != "")) {
            $templateProcessor->setValue('airConTyp', $this->formatToWordTemplate($recordList['replySlipAirConditionersType']));
        } else {
            $templateProcessor->setValue('airConTyp',"Nil");
        }
        if (isset($recordList['evaReportAirConditionersTypeFinding']) && ($recordList['evaReportAirConditionersTypeFinding']!="")) {
            $content = $recordList['evaReportAirConditionersTypeFinding'];
            $templateProcessor->setValue('airConTypFind', $this->formatToWordTemplate($recordList['evaReportAirConditionersTypeFinding']));
            if (isset($recordList['evaReportAirConditionersTypeRecommend']) && (trim($recordList['evaReportAirConditionersTypeRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportAirConditionersTypeRecommend'];
                $templateProcessor->setValue('airConTypRec', $this->formatToWordTemplate($recordList['evaReportAirConditionersTypeRecommend']));
            } else {
                $templateProcessor->setValue('airConTypRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('airConTypFind', "Nil");
            $templateProcessor->setValue('airConTypRec', "Nil");
        }
        if (isset($recordList['evaReportAirConditionersSupplement']) && ($recordList['evaReportAirConditionersSupplement']!="")) {
            $content = $recordList['evaReportAirConditionersSupplement'];
            $templateProcessor->setValue('airConditionersSupplement', $this->formatToWordTemplate($recordList['evaReportAirConditionersSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('airConditionersSupplement', "Nil");
        }

        // check if Non-linear contains information
        if ($recordList['evaReportNonLinearLoadYesNo'] == 'Y') {
            $templateProcessor->setValue('nonYN', $checkedBox);
        } else {
            $templateProcessor->setValue('nonYN', $unCheckedBox);
        }
        if ($recordList['evaReportNonLinearLoadHarmonicEmissionYesNo'] == 'Y') {
            $templateProcessor->setValue('nonHarYN', $checkedBox);
        } else {
            $templateProcessor->setValue('nonHarYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipNonLinearLoadHarmonicEmission']) && ($recordList['replySlipNonLinearLoadHarmonicEmission'] != "")) {
            $templateProcessor->setValue('nonHar', $this->formatToWordTemplate($recordList['replySlipNonLinearLoadHarmonicEmission']));
        } else {
            $templateProcessor->setValue('nonHar',"Nil");
        }
        if (isset($recordList['evaReportNonLinearLoadHarmonicEmissionFinding']) && ($recordList['evaReportNonLinearLoadHarmonicEmissionFinding']!="")) {
            $content = $content . $recordList['evaReportNonLinearLoadHarmonicEmissionFinding'];
            $templateProcessor->setValue('nonHarFind', $this->formatToWordTemplate($recordList['evaReportNonLinearLoadHarmonicEmissionFinding']));
            if (isset($recordList['evaReportNonLinearLoadHarmonicEmissionRecommend']) && (trim($recordList['evaReportNonLinearLoadHarmonicEmissionRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportNonLinearLoadHarmonicEmissionRecommend'];
                $templateProcessor->setValue('nonHarRec', $this->formatToWordTemplate($recordList['evaReportNonLinearLoadHarmonicEmissionRecommend']));
            } else {
                $templateProcessor->setValue('nonHarRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('nonHarFind', "Nil");
            $templateProcessor->setValue('nonHarRec', "Nil");
        }
        if (isset($recordList['evaReportNonLinearLoadSupplement']) && ($recordList['evaReportNonLinearLoadSupplement']!="")) {
            $content = $recordList['evaReportNonLinearLoadSupplement'];
            $templateProcessor->setValue('nonLinearLoadSupplement', $this->formatToWordTemplate($recordList['evaReportNonLinearLoadSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('nonLinearLoadSupplement', "Nil");
        }

        // check if renewable energy contains information
        if ($recordList['evaReportRenewableEnergyYesNo'] == 'Y') {
            $templateProcessor->setValue('renewYN', $checkedBox);
        } else {
            $templateProcessor->setValue('renewYN', $unCheckedBox);
        }
        if ($recordList['evaReportRenewableEnergyInverterAndControlsYesNo'] == 'Y') {
            $templateProcessor->setValue('renewCtlYN', $checkedBox);
        } else {
            $templateProcessor->setValue('renewCtlYN', $unCheckedBox);
        }
        if ($recordList['evaReportRenewableEnergyHarmonicEmissionYesNo'] == 'Y') {
            $templateProcessor->setValue('renewHarYN', $checkedBox);
        } else {
            $templateProcessor->setValue('renewHarYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipRenewableEnergyInverterAndControls']) && ($recordList['replySlipRenewableEnergyInverterAndControls'] != "")) {
            $templateProcessor->setValue('renewCtl', $this->formatToWordTemplate($recordList['replySlipRenewableEnergyInverterAndControls']));
        } else {
            $templateProcessor->setValue('renewCtl',"Nil");
        }
        if (isset($recordList['evaReportRenewableEnergyInverterAndControlsFinding']) && ($recordList['evaReportRenewableEnergyInverterAndControlsFinding']!="")) {
            $content = $recordList['evaReportRenewableEnergyInverterAndControlsFinding'];
            $templateProcessor->setValue('renewCtlFind', $this->formatToWordTemplate($recordList['evaReportRenewableEnergyInverterAndControlsFinding']));
            if (isset($recordList['evaReportRenewableEnergyInverterAndControlsRecommend']) && (trim($recordList['evaReportRenewableEnergyInverterAndControlsRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportRenewableEnergyInverterAndControlsRecommend'];
                $templateProcessor->setValue('renewCtlRec', $this->formatToWordTemplate($recordList['evaReportRenewableEnergyInverterAndControlsRecommend']));
            } else {
                $templateProcessor->setValue('renewCtlRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('renewCtlFind', "Nil");
            $templateProcessor->setValue('renewCtlRec', "Nil");
        }
        if (isset($recordList['replySlipRenewableEnergyHarmonicEmission']) && ($recordList['replySlipRenewableEnergyHarmonicEmission'] != "")) {
            $templateProcessor->setValue('renewHar', $this->formatToWordTemplate($recordList['replySlipRenewableEnergyHarmonicEmission']));
        } else {
            $templateProcessor->setValue('renewHar',"Nil");
        }
        if (isset($recordList['evaReportRenewableEnergyHarmonicEmissionFinding']) && ($recordList['evaReportRenewableEnergyHarmonicEmissionFinding']!="")) {
            $content = $recordList['evaReportRenewableEnergyHarmonicEmissionFinding'];
            $templateProcessor->setValue('renewHarFind', $this->formatToWordTemplate($recordList['evaReportRenewableEnergyHarmonicEmissionFinding']));
            if (isset($recordList['evaReportRenewableEnergyHarmonicEmissionRecommend']) && (trim($recordList['evaReportRenewableEnergyHarmonicEmissionRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportRenewableEnergyHarmonicEmissionRecommend'];
                $templateProcessor->setValue('renewHarRec', $this->formatToWordTemplate($recordList['evaReportRenewableEnergyHarmonicEmissionRecommend']));
            } else {
                $templateProcessor->setValue('renewHarRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('renewHarFind', "Nil");
            $templateProcessor->setValue('renewHarRec', "Nil");
        }
        if (isset($recordList['evaReportRenewableEnergySupplement']) && ($recordList['evaReportRenewableEnergySupplement']!="")) {
            $content = $recordList['evaReportRenewableEnergySupplement'];
            $templateProcessor->setValue('renewableEnergySupplement', $this->formatToWordTemplate($recordList['evaReportRenewableEnergySupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('renewableEnergySupplement', "Nil");
        }

        // check if EV charge contains information
        if ($recordList['evaReportEvChargerSystemYesNo'] == 'Y') {
            $templateProcessor->setValue('evYN', $checkedBox);
        } else {
            $templateProcessor->setValue('evYN', $unCheckedBox);
        }
        if ($recordList['evaReportEvChargerSystemEvChargerYesNo'] == 'Y') {
            $templateProcessor->setValue('evChgYN', $checkedBox);
        } else {
            $templateProcessor->setValue('evChgYN', $unCheckedBox);
        }
        if ($recordList['evaReportEvChargerSystemHarmonicEmissionYesNo'] == 'Y') {
            $templateProcessor->setValue('evHarYN', $checkedBox);
        } else {
            $templateProcessor->setValue('evHarYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipEvChargerSystemEvCharger']) && ($recordList['replySlipEvChargerSystemEvCharger'] != "")) {
            $templateProcessor->setValue('evChg', $this->formatToWordTemplate($recordList['replySlipEvChargerSystemEvCharger']));
        } else {
            $templateProcessor->setValue('evChg',"Nil");
        }
        if (isset($recordList['evaReportEvChargerSystemEvChargerFinding']) && ($recordList['evaReportEvChargerSystemEvChargerFinding']!="")) {
            $content = $recordList['evaReportEvChargerSystemEvChargerFinding'];
            $templateProcessor->setValue('evChgFind', $this->formatToWordTemplate($recordList['evaReportEvChargerSystemEvChargerFinding']));
            if (isset($recordList['evaReportEvChargerSystemEvChargerRecommend']) && (trim($recordList['evaReportEvChargerSystemEvChargerRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportEvChargerSystemEvChargerRecommend'];
                $templateProcessor->setValue('evChgRec', $this->formatToWordTemplate($recordList['evaReportEvChargerSystemEvChargerRecommend']));
            } else {
                $templateProcessor->setValue('evChgRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('evChgFind', "Nil");
            $templateProcessor->setValue('evChgRec', "Nil");
        }
        if (isset($recordList['replySlipEvChargerSystemHarmonicEmission']) && ($recordList['replySlipEvChargerSystemHarmonicEmission'] != "")) {
            $templateProcessor->setValue('evHar', $this->formatToWordTemplate($recordList['replySlipEvChargerSystemHarmonicEmission']));
        } else {
            $templateProcessor->setValue('evHar',"Nil");
        }
        if (isset($recordList['evaReportEvChargerSystemHarmonicEmissionFinding']) && ($recordList['evaReportEvChargerSystemHarmonicEmissionFinding']!="")) {
            $content = $content . $recordList['evaReportEvChargerSystemHarmonicEmissionFinding'];
            $templateProcessor->setValue('evHarFind', $this->formatToWordTemplate($recordList['evaReportEvChargerSystemHarmonicEmissionFinding']));
            if (isset($recordList['evaReportEvChargerSystemHarmonicEmissionRecommend']) && (trim($recordList['evaReportEvChargerSystemHarmonicEmissionRecommend']) != "")) {
                $content = $content . " " . $recordList['evaReportEvChargerSystemHarmonicEmissionRecommend'];
                $templateProcessor->setValue('evHarRec', $this->formatToWordTemplate($recordList['evaReportEvChargerSystemHarmonicEmissionRecommend']));
            } else {
                $templateProcessor->setValue('evHarRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('evHarFind', "Nil");
            $templateProcessor->setValue('evHarRec', "Nil");
        }
        if (isset($recordList['evaReportEvChargerSystemSupplement']) && ($recordList['evaReportEvChargerSystemSupplement']!="")) {
            $content = $recordList['evaReportEvChargerSystemSupplement'];
            $templateProcessor->setValue('evChargerSystemSupplement', $this->formatToWordTemplate($recordList['evaReportEvChargerSystemSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('evChargerSystemSupplement', "Nil");
        }

        // Display the footer messages
        $footerTextRun = new \PhpOffice\PhpWord\Element\TextRun(array('align'=>'both'));
        $footerTextRun->addText("We are committed in assisting our customers to resolve the potential PQ issues and it is our pleasure to have this chance to have a PQ site walk with you to share the mitigation solutions to alleviate the impacts on your critical equipment caused by PQ issues. We would be grateful to conduct further study with your team by carrying out voltage dip simulation tests or PQ measurement on the concerned equipment and devising possible cost-effective mitigation solutions to improve the performances of the concerned equipment caused by PQ issues.");
        $footerTextRun->addTextBreak(2);
        $footerTextRun->addText("Should you have any query, please feel free to contact our Mr. K.Y. Poon at 2678 6047 or Mr. K.W. Chan at 2678 7518 for assistance.");
        $footerTextRun->addTextBreak(2);
        $footerTextRun->addText("Yours sincerely,");
        $footerTextRun->addTextBreak(1);
        $footerTextRun->addText("CLP Power Hong Kong Limited");
        $footerTextRun->addTextBreak(5);
        $footerTextRun->addText("Edmond Chan");
        $footerTextRun->addTextBreak(1);
        $footerTextRun->addText("Principal Manager – Systems Engineering");
        $footerTextRun->addTextBreak(1);
        $footerTextRun->addText("4817", array('size'=>8));
        $templateProcessor->setComplexBlock('content' . $contentCount, $footerTextRun);
        $contentCount++;

        $contentMaxCount = 36;
        for ($x=$contentCount; $x<=$contentMaxCount; $x++) {
            $templateProcessor->setValue('content' . $x, "");
        }

        $pathToSave = $evaReportTemplatePath['configValue'] . 'temp\\(' . $schemeNo . ')' .
            $evaReportTemplateFileName['configValue'];
        $templateProcessor->saveAs($pathToSave);

        header("Content-Description: File Transfer");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header('Content-Disposition: attachment; filename='. basename($pathToSave));
        header('Content-Length: ' . filesize($pathToSave));
        header('Pragma: public');

        //Clear system output buffer
        flush();

        //Read the size of the file
        readfile($pathToSave);
        unlink($pathToSave); // deletes the temporary file

        die();

    }


    public function actionGetPlanningAheadProjectDetailReEvaReportTemplate()
    {

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        $schemeNo = $param['schemeNo'];
        $recordList = Yii::app()->planningAheadDao->getPlanningAheadDetails($schemeNo);
        $checkedBox = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
        $unCheckedBox = '<w:sym w:font="Wingdings" w:char="F0A8"/>';

        $evaReportTemplatePath = Yii::app()->commonUtil->getConfigValueByConfigName('planningAheadEvaReportTemplatePath');
        $evaReportTemplateFileName = Yii::app()->commonUtil->getConfigValueByConfigName('planningAheadEvaReportTemplateFileName');

        $evaReportIssueDateDay = date("j", strtotime($recordList['reEvaReportIssueDate']));
        $evaReportIssueDateMonth = date("M", strtotime($recordList['reEvaReportIssueDate']));
        $evaReportIssueDateYear = date("Y", strtotime($recordList['reEvaReportIssueDate']));
        $evaReportFaxDateMonth = date("m", strtotime($recordList['reEvaReportIssueDate']));
        $evaReportFaxDateYear = date("y", strtotime($recordList['reEvaReportIssueDate']));
        $commissionDateMonth = date("M", strtotime($recordList['commissionDate']));
        $commissionDateYear = date("Y", strtotime($recordList['commissionDate']));
        $replySlipReturnDateMonth = date("M", strtotime($recordList['replySlipLastUploadTime']));
        $replySlipReturnDateYear = date("Y", strtotime($recordList['replySlipLastUploadTime']));

        $templateProcessor = new TemplateProcessor($evaReportTemplatePath['configValue'] . $evaReportTemplateFileName['configValue']);

        $templateProcessor->setValue('projectTitle', $this->formatToWordTemplate($recordList['projectTitle']));
        $templateProcessor->setValue('issueDate', $evaReportIssueDateDay . " " . $evaReportIssueDateMonth . " " . $evaReportIssueDateYear);
        $templateProcessor->setValue('commissionDate', $commissionDateMonth . " " . $commissionDateYear);
        $templateProcessor->setValue('replySlipReturnDate', $replySlipReturnDateMonth . " " . $replySlipReturnDateYear);
        $templateProcessor->setValue('firstConsultantEmail', $recordList['firstProjectOwnerEmail']);
        $templateProcessor->setValue('firstConsultantTitle', $recordList['firstProjectOwnerTitle']);
        $templateProcessor->setValue('firstConsultantSurname', $recordList['firstProjectOwnerSurname']);
        $templateProcessor->setValue('firstConsultantCompany', $this->formatToWordTemplate($recordList['firstProjectOwnerCompany']));
        $templateProcessor->setValue('faxRefNo', $this->formatToWordTemplate($recordList['reEvaReportFaxRefNo']));
        $templateProcessor->setValue('faxDate', $evaReportFaxDateYear . "-" . $evaReportFaxDateMonth);
        $templateProcessor->setValue('firstConsultantCompanyAdd1', $this->formatToWordTemplate($recordList['firstProjectOwnerCompany']));
        $templateProcessor->setValue('firstConsultantCompanyAdd2', "");
        $templateProcessor->setValue('firstConsultantCompanyAdd3', "");
        $templateProcessor->setValue('firstConsultantCompanyAdd4', "");
        if (isset($recordList['secondConsultantSurname']) && (trim($recordList['secondConsultantSurname']) != "")) {
            $templateProcessor->setValue('secondConsultantCc', "c.c.");
            $templateProcessor->setValue('secondConsultantCompany', "(" . $this->formatToWordTemplate($recordList['secondConsultantCompany']) . ")");
            $templateProcessor->setValue('secondConsultantTitle', $recordList['secondConsultantTitle']);
            $templateProcessor->setValue('secondConsultantSurname', $recordList['secondConsultantSurname']);
            $templateProcessor->setValue('secondConsultantEmail', "(Email: " . $recordList['secondConsultantEmail'] . ")");
        } else {
            $templateProcessor->setValue('secondConsultantCc', "");
            $templateProcessor->setValue('secondConsultantCompany', "");
            $templateProcessor->setValue('secondConsultantTitle', "");
            $templateProcessor->setValue('secondConsultantSurname', "");
            $templateProcessor->setValue('secondConsultantEmail', "");
        }
        if (isset($recordList['forthInvitationLetterWalkDate'])) {
            $siteVisitDateDay = date("j", strtotime($recordList['forthInvitationLetterWalkDate']));
            $siteVisitDateMonth = date("M", strtotime($recordList['forthInvitationLetterWalkDate']));
            $siteVisitDateYear = date("Y", strtotime($recordList['forthInvitationLetterWalkDate']));
            $templateProcessor->setValue('siteVisitDate', $siteVisitDateDay . " " . $siteVisitDateMonth . " " . $siteVisitDateYear);
        }

        $contentCount=1;

        // check if BMS contains information
        if ($recordList['reEvaReportBmsYesNo'] == 'Y') {
            $templateProcessor->setValue('bmsYN', $checkedBox);
        } else {
            $templateProcessor->setValue('bmsYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportBmsServerCentralComputerYesNo'] == 'Y') {
            $templateProcessor->setValue('bmsSCCYesNo', $checkedBox);
        } else {
            $templateProcessor->setValue('bmsSCCYesNo', $unCheckedBox);
        }
        if ($recordList['reEvaReportBmsDdcYesNo'] == 'Y') {
            $templateProcessor->setValue('bmsDdcYN', $checkedBox);
        } else {
            $templateProcessor->setValue('bmsDdcYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipBmsServerCentralComputer']) && ($recordList['replySlipBmsServerCentralComputer'] != "")) {
            $templateProcessor->setValue('bmsSCC', $this->formatToWordTemplate($recordList['replySlipBmsServerCentralComputer']));
        } else {
            $templateProcessor->setValue('bmsSCC',"Nil");
        }
        if (isset($recordList['reEvaReportBmsServerCentralComputerFinding']) && ($recordList['reEvaReportBmsServerCentralComputerFinding']!="")) {
            $content = $recordList['reEvaReportBmsServerCentralComputerFinding'];
            $templateProcessor->setValue('bmsSCCFind', $this->formatToWordTemplate($recordList['reEvaReportBmsServerCentralComputerFinding']));
            if (isset($recordList['reEvaReportBmsServerCentralComputerRecommend']) && (trim($recordList['reEvaReportBmsServerCentralComputerRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportBmsServerCentralComputerRecommend'];
                $templateProcessor->setValue('bmsSCCRec', $this->formatToWordTemplate($recordList['reEvaReportBmsServerCentralComputerRecommend']));
            } else {
                $content = $content . " hence, their operations for controlling building facilities would be sustained under voltage dip incidents.";
                $templateProcessor->setValue('bmsSCCRec', 'Nil');
            }
        } else {
            $templateProcessor->setValue('bmsSCCFind', 'Nil');
            $templateProcessor->setValue('bmsSCCRec', 'Nil');
        }
        if (isset($recordList['replySlipBmsDdc']) && ($recordList['replySlipBmsDdc'] != "")) {
            $templateProcessor->setValue('bmsDdc', $this->formatToWordTemplate($recordList['replySlipBmsDdc']));
        } else {
            $templateProcessor->setValue('bmsDdc',"Nil");
        }
        if (isset($recordList['reEvaReportBmsDdcFinding']) && ($recordList['reEvaReportBmsDdcFinding']!="")) {
            $content = $content . " " . $recordList['reEvaReportBmsDdcFinding'];
            $templateProcessor->setValue('bmsDdcFind', $this->formatToWordTemplate($recordList['reEvaReportBmsDdcFinding']));
            if (isset($recordList['reEvaReportBmsDdcRecommend']) && (trim($recordList['reEvaReportBmsDdcRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportBmsDdcRecommend'];
                $templateProcessor->setValue('bmsDdcRec', $this->formatToWordTemplate($recordList['reEvaReportBmsDdcRecommend']));
            } else {
                $templateProcessor->setValue('bmsDdcRec', 'Nil');
            }
        } else {
            $templateProcessor->setValue('bmsDdcFind', 'Nil');
            $templateProcessor->setValue('bmsDdcRec', 'Nil');
        }
        if (isset($content) && (trim($content) != "")) {
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun($content));
            $contentCount++;
        }
        if (isset($recordList['reEvaReportBmsSupplement']) && ($recordList['reEvaReportBmsSupplement']!="")) {
            $content = $recordList['reEvaReportBmsSupplement'];
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun($content));
            $templateProcessor->setValue('bmsSupplement', $this->formatToWordTemplate($recordList['reEvaReportBmsSupplement']));
            $contentCount++;
        } else {
            $templateProcessor->setValue('bmsSupplement', "Nil");
        }

        // check if changeover contains information
        $changeoverFindingCount=1; $changeoverFindingMaxCount=2;
        $changeoverRecommendCount=1; $changeoverRecommendMaxCount=2;
        if ($recordList['reEvaReportChangeoverSchemeYesNo'] == 'Y') {
            $templateProcessor->setValue('chgSchYN', $checkedBox);
        } else {
            $templateProcessor->setValue('chgSchYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportChangeoverSchemeControlYesNo'] == 'Y') {
            $templateProcessor->setValue('chgSchCtlYN', $checkedBox);
        } else {
            $templateProcessor->setValue('chgSchCtlYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportChangeoverSchemeYesNo'] == 'Y') {
            $templateProcessor->setValue('chgSchUvYN', $checkedBox);
        } else {
            $templateProcessor->setValue('chgSchUvYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipChangeoverSchemeControl']) && ($recordList['replySlipChangeoverSchemeControl'] != "")) {
            $templateProcessor->setValue('chgSchCtl', $this->formatToWordTemplate($recordList['replySlipChangeoverSchemeControl']));
        } else {
            $templateProcessor->setValue('chgSchCtl',"Nil");
        }
        if (isset($recordList['reEvaReportChangeoverSchemeControlFinding']) && ($recordList['reEvaReportChangeoverSchemeControlFinding']!="")) {
            $content = $recordList['reEvaReportChangeoverSchemeControlFinding'];
            $templateProcessor->setComplexBlock('changeoverSchemeFinding' . $changeoverFindingCount, $this->getTableListItemRun($recordList['reEvaReportChangeoverSchemeControlFinding']));
            $changeoverFindingCount++;
            if (isset($recordList['reEvaReportChangeoverSchemeControlRecommend']) && (trim($recordList['reEvaReportChangeoverSchemeControlRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportChangeoverSchemeControlRecommend'];
                $templateProcessor->setComplexBlock('changeoverSchemeRecommend' . $changeoverRecommendCount, $this->getTableListItemRun($recordList['reEvaReportChangeoverSchemeControlRecommend']));
                $changeoverRecommendCount++;
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun($content));
            $contentCount++;
        }
        if (isset($recordList['replySlipChangeoverSchemeUv']) && ($recordList['replySlipChangeoverSchemeUv'] != "")) {
            $templateProcessor->setValue('chgSchUv', $this->formatToWordTemplate($recordList['replySlipChangeoverSchemeUv']));
        } else {
            $templateProcessor->setValue('chgSchUv',"Nil");
        }
        if (isset($recordList['reEvaReportChangeoverSchemeUvFinding']) && ($recordList['reEvaReportChangeoverSchemeUvFinding']!="")) {
            $content = $recordList['reEvaReportChangeoverSchemeUvFinding'];
            $templateProcessor->setComplexBlock('changeoverSchemeFinding' . $changeoverFindingCount, $this->getTableListItemRun($recordList['reEvaReportChangeoverSchemeUvFinding']));
            $changeoverFindingCount++;
            if (isset($recordList['reEvaReportChangeoverSchemeUvRecommend']) && (trim($recordList['reEvaReportChangeoverSchemeUvRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportChangeoverSchemeUvRecommend'];
                $templateProcessor->setComplexBlock('changeoverSchemeRecommend' . $changeoverRecommendCount, $this->getTableListItemRun($recordList['reEvaReportChangeoverSchemeUvRecommend']));
                $changeoverRecommendCount++;
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun($content));
            $contentCount++;
        }
        if ($changeoverFindingCount==1) {
            $templateProcessor->setValue('changeoverSchemeFinding1', "Nil");
            $templateProcessor->setValue('changeoverSchemeFinding2', "");
        } else {
            for ($x=$changeoverFindingCount; $x<=$changeoverFindingMaxCount; $x++) {
                $templateProcessor->setValue('changeoverSchemeFinding' . $x, "");
            }
        }

        if ($changeoverRecommendCount==1) {
            $templateProcessor->setValue('changeoverSchemeRecommend1', "Nil");
            $templateProcessor->setValue('changeoverSchemeRecommend2', "");
        } else {
            for ($x=$changeoverRecommendCount; $x<=$changeoverRecommendMaxCount; $x++) {
                $templateProcessor->setValue('changeoverSchemeRecommend' . $x, "");
            }
        }


        if (isset($recordList['reEvaReportChangeoverSchemeSupplement']) && ($recordList['reEvaReportChangeoverSchemeSupplement']!="")) {
            $content = $recordList['reEvaReportChangeoverSchemeSupplement'];
            $templateProcessor->setValue('changeoverSchemeSupplement', $this->formatToWordTemplate($recordList['reEvaReportChangeoverSchemeSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun($content));
            $contentCount++;
        } else {
            $templateProcessor->setValue('changeoverSchemeSupplement', "Nil");
        }

        // check if Chiller Plant contains information
        if ($recordList['reEvaReportChillerPlantYesNo'] == 'Y') {
            $templateProcessor->setValue('chilPltYN', $checkedBox);
        } else {
            $templateProcessor->setValue('chilPltYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportChillerPlantAhuChilledWaterYesNo'] == 'Y') {
            $templateProcessor->setValue('chilPltAhuYN', $checkedBox);
        } else {
            $templateProcessor->setValue('chilPltAhuYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportChillerPlantChillerYesNo'] == 'Y') {
            $templateProcessor->setValue('chilPltChilYN', $checkedBox);
        } else {
            $templateProcessor->setValue('chilPltChilYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipChillerPlantAhuChilledWater']) && ($recordList['replySlipChillerPlantAhuChilledWater'] != "")) {
            $templateProcessor->setValue('chilPltAhu', $this->formatToWordTemplate($recordList['replySlipChillerPlantAhuChilledWater']));
        } else {
            $templateProcessor->setValue('chilPltAhu',"Nil");
        }
        if (isset($recordList['reEvaReportChillerPlantAhuChilledWaterFinding']) && ($recordList['reEvaReportChillerPlantAhuChilledWaterFinding']!="")) {
            $content = $recordList['reEvaReportChillerPlantAhuChilledWaterFinding'];
            $templateProcessor->setValue('chilPltAhuFind', $this->formatToWordTemplate($recordList['reEvaReportChillerPlantAhuChilledWaterFinding']));
            if (isset($recordList['reEvaReportChillerPlantAhuChilledWaterRecommend']) && (trim($recordList['reEvaReportChillerPlantAhuChilledWaterRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportChillerPlantAhuChilledWaterRecommend'];
                $templateProcessor->setValue('chilPltAhuRec', $this->formatToWordTemplate($recordList['reEvaReportChillerPlantAhuChilledWaterFinding']));
            } else {
                $templateProcessor->setValue('chilPltAhuRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun($content));
            $contentCount++;
        } else {
            $templateProcessor->setValue('chilPltAhuFind', "Nil");
            $templateProcessor->setValue('chilPltAhuRec', "Nil");
        }
        if (isset($recordList['replySlipChillerPlantChiller']) && ($recordList['replySlipChillerPlantChiller'] != "")) {
            $templateProcessor->setValue('chilPltChil', $this->formatToWordTemplate($recordList['replySlipChillerPlantChiller']));
        } else {
            $templateProcessor->setValue('chilPltChil',"Nil");
        }
        if (isset($recordList['reEvaReportChillerPlantChillerFinding']) && ($recordList['reEvaReportChillerPlantChillerFinding']!="")) {
            $content = $recordList['reEvaReportChillerPlantChillerFinding'];
            $templateProcessor->setValue('chilPltChilFind', $this->formatToWordTemplate($recordList['reEvaReportChillerPlantChillerFinding']));
            if (isset($recordList['reEvaReportChillerPlantChillerRecommend']) && (trim($recordList['reEvaReportChillerPlantChillerRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportChillerPlantChillerRecommend'];
                $templateProcessor->setValue('chilPltChilRec', $this->formatToWordTemplate($recordList['reEvaReportChillerPlantChillerRecommend']));
            } else {
                $templateProcessor->setValue('chilPltChilRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun($content));
            $contentCount++;
        } else {
            $templateProcessor->setValue('chilPltChilFind', "Nil");
            $templateProcessor->setValue('chilPltChilRec', "Nil");
        }
        if (isset($recordList['reEvaReportChillerPlantSupplement']) && ($recordList['reEvaReportChillerPlantSupplement']!="")) {
            $content = $recordList['reEvaReportChillerPlantSupplement'];
            $templateProcessor->setValue('chillerPlantSupplement', $this->formatToWordTemplate($recordList['reEvaReportChillerPlantSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun($content));
            $contentCount++;
        } else {
            $templateProcessor->setValue('chillerPlantSupplement', "Nil");
        }

        // check if escalator contains information
        if ($recordList['reEvaReportEscalatorYesNo'] == 'Y') {
            $templateProcessor->setValue('escYN', $checkedBox);
        } else {
            $templateProcessor->setValue('escYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportEscalatorBrakingSystemYesNo'] == 'Y') {
            $templateProcessor->setValue('escBraSysYN', $checkedBox);
        } else {
            $templateProcessor->setValue('escBraSysYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportEscalatorControlYesNo'] == 'Y') {
            $templateProcessor->setValue('escCtlYN', $checkedBox);
        } else {
            $templateProcessor->setValue('escCtlYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipEscalatorBrakingSystem']) && ($recordList['replySlipEscalatorBrakingSystem'] != "")) {
            $templateProcessor->setValue('escBraSys', $this->formatToWordTemplate($recordList['replySlipEscalatorBrakingSystem']));
        } else {
            $templateProcessor->setValue('escBraSys',"Nil");
        }
        if (isset($recordList['reEvaReportEscalatorBrakingSystemFinding']) && ($recordList['reEvaReportEscalatorBrakingSystemFinding']!="")) {
            $content = $recordList['reEvaReportEscalatorBrakingSystemFinding'];
            $templateProcessor->setValue('escBraSysFind', $this->formatToWordTemplate($recordList['reEvaReportEscalatorBrakingSystemFinding']));
            if (isset($recordList['reEvaReportEscalatorBrakingSystemRecommend']) && (trim($recordList['reEvaReportEscalatorBrakingSystemRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportEscalatorBrakingSystemRecommend'];
                $templateProcessor->setValue('escBraSysRec', $this->formatToWordTemplate($recordList['reEvaReportEscalatorBrakingSystemRecommend']));
            } else {
                $templateProcessor->setValue('escBraSysRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('escBraSysFind', "Nil");
            $templateProcessor->setValue('escBraSysRec', "Nil");
        }
        if (isset($recordList['replySlipEscalatorControl']) && ($recordList['replySlipEscalatorControl'] != "")) {
            $templateProcessor->setValue('escCtl', $this->formatToWordTemplate($recordList['replySlipEscalatorControl']));
        } else {
            $templateProcessor->setValue('escCtl',"Nil");
        }
        if (isset($recordList['reEvaReportEscalatorControlFinding']) && ($recordList['reEvaReportEscalatorControlFinding']!="")) {
            $content = $recordList['reEvaReportEscalatorControlFinding'];
            $templateProcessor->setValue('escCtlFind', $this->formatToWordTemplate($recordList['reEvaReportEscalatorControlFinding']));
            if (isset($recordList['reEvaReportEscalatorControlRecommend']) && (trim($recordList['reEvaReportEscalatorControlRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportEscalatorControlRecommend'];
                $templateProcessor->setValue('escCtlRec', $this->formatToWordTemplate($recordList['reEvaReportEscalatorControlRecommend']));
            } else {
                $templateProcessor->setValue('escCtlRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('escCtlFind', "Nil");
            $templateProcessor->setValue('escCtlRec', "Nil");
        }
        if (isset($recordList['reEvaReportEscalatorSupplement']) && ($recordList['reEvaReportEscalatorSupplement']!="")) {
            $content = $recordList['reEvaReportEscalatorSupplement'];
            $templateProcessor->setValue('reEscalatorSupplement', $this->formatToWordTemplate($recordList['reEvaReportEscalatorSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('escalatorSupplement', "Nil");
        }

        // check if LED Lighting contains information
        if ($recordList['reEvaReportHidLampYesNo'] == 'Y') {
            $templateProcessor->setValue('hidYN', $checkedBox);
        } else {
            $templateProcessor->setValue('hidYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportHidLampBallastYesNo'] == 'Y') {
            $templateProcessor->setValue('hidBallYN', $checkedBox);
        } else {
            $templateProcessor->setValue('hidBallYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportHidLampAddonProtectYesNo'] == 'Y') {
            $templateProcessor->setValue('hidAddonYN', $checkedBox);
        } else {
            $templateProcessor->setValue('hidAddonYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipHidLampMitigation']) && ($recordList['replySlipHidLampMitigation'] != "")) {
            $templateProcessor->setValue('hidMit', $this->formatToWordTemplate($recordList['replySlipHidLampMitigation']));
        } else {
            $templateProcessor->setValue('hidMit',"Nil");
        }
        if (isset($recordList['reEvaReportHidLampBallastFinding']) && ($recordList['reEvaReportHidLampBallastFinding']!="")) {
            $content = $recordList['reEvaReportHidLampBallastFinding'];
            $templateProcessor->setValue('hidBallFind', $this->formatToWordTemplate($recordList['reEvaReportHidLampBallastFinding']));
            if (isset($recordList['reEvaReportHidLampBallastRecommend']) && (trim($recordList['reEvaReportHidLampBallastRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportHidLampBallastRecommend'];
                $templateProcessor->setValue('hidBallRec', $this->formatToWordTemplate($recordList['reEvaReportHidLampBallastRecommend']));
            } else {
                $templateProcessor->setValue('hidBallRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('hidBallFind', "Nil");
            $templateProcessor->setValue('hidBallRec', "Nil");
        }
        if (isset($recordList['reEvaReportHidLampAddonProtectFinding']) && ($recordList['reEvaReportHidLampAddonProtectFinding']!="")) {
            $content = $recordList['reEvaReportHidLampAddonProtectFinding'];
            $templateProcessor->setValue('hidAddonFind', $this->formatToWordTemplate($recordList['reEvaReportHidLampAddonProtectFinding']));
            if (isset($recordList['reEvaReportHidLampAddonProtectRecommend']) && (trim($recordList['reEvaReportHidLampAddonProtectRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportHidLampAddonProtectRecommend'];
                $templateProcessor->setValue('hidAddonRec', $this->formatToWordTemplate($recordList['reEvaReportHidLampAddonProtectRecommend']));
            } else {
                $templateProcessor->setValue('hidAddonRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('hidAddonFind', "Nil");
            $templateProcessor->setValue('hidAddonRec', "Nil");
        }
        if (isset($recordList['reEvaReportHidLampSupplement']) && ($recordList['reEvaReportHidLampSupplement']!="")) {
            $content = $recordList['reEvaReportHidLampSupplement'];
            $templateProcessor->setValue('hidLampSupplement', $this->formatToWordTemplate($recordList['reEvaReportHidLampSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('hidLampSupplement', "Nil");
        }

        // check if Lift contains information
        if ($recordList['reEvaReportLiftYesNo'] == 'Y') {
            $templateProcessor->setValue('liftYN', $checkedBox);
        } else {
            $templateProcessor->setValue('liftYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportLiftOperationYesNo'] == 'Y') {
            $templateProcessor->setValue('liftOptYN', $checkedBox);
        } else {
            $templateProcessor->setValue('liftOptYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportLiftMainSupplyYesNo'] == 'Y') {
            $templateProcessor->setValue('liftMainYN', $checkedBox);
        } else {
            $templateProcessor->setValue('liftMainYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipLiftOperation']) && ($recordList['replySlipLiftOperation'] != "")) {
            $templateProcessor->setValue('liftOpt', $this->formatToWordTemplate($recordList['replySlipLiftOperation']));
        } else {
            $templateProcessor->setValue('liftOpt',"Nil");
        }
        if (isset($recordList['reEvaReportLiftOperationFinding']) && ($recordList['reEvaReportLiftOperationFinding']!="")) {
            $content = $recordList['reEvaReportLiftOperationFinding'];
            $templateProcessor->setValue('liftOptFind', $this->formatToWordTemplate($recordList['reEvaReportLiftOperationFinding']));
            if (isset($recordList['reEvaReportLiftOperationRecommend']) && (trim($recordList['reEvaReportLiftOperationRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportLiftOperationRecommend'];
                $templateProcessor->setValue('liftOptRec', $this->formatToWordTemplate($recordList['reEvaReportLiftOperationRecommend']));
            } else {
                $templateProcessor->setValue('liftOptRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('liftOptFind', "Nil");
            $templateProcessor->setValue('liftOptRec', "Nil");
        }
        if (isset($recordList['reEvaReportLiftMainSupplyFinding']) && ($recordList['reEvaReportLiftMainSupplyFinding']!="")) {
            $content = $recordList['reEvaReportLiftMainSupplyFinding'];
            $templateProcessor->setValue('liftMainFind', $this->formatToWordTemplate($recordList['reEvaReportLiftMainSupplyFinding']));
            if (isset($recordList['reEvaReportLiftMainSupplyRecommend']) && (trim($recordList['reEvaReportLiftMainSupplyRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportLiftMainSupplyRecommend'];
                $templateProcessor->setValue('liftMainRec', $this->formatToWordTemplate($recordList['reEvaReportLiftMainSupplyRecommend']));
            } else {
                $templateProcessor->setValue('liftMainRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('liftMainFind', "Nil");
            $templateProcessor->setValue('liftMainRec', "Nil");
        }
        if (isset($recordList['reEvaReportLiftSupplement']) && ($recordList['reEvaReportLiftSupplement']!="")) {
            $content = $recordList['reEvaReportLiftSupplement'];
            $templateProcessor->setValue('liftSupplement', $this->formatToWordTemplate($recordList['reEvaReportLiftSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('liftSupplement', "Nil");
        }

        // check if Sensitive Machine contains information
        if ($recordList['reEvaReportSensitiveMachineYesNo'] == 'Y') {
            $templateProcessor->setValue('senYN', $checkedBox);
        } else {
            $templateProcessor->setValue('senYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportSensitiveMachineMedicalYesNo'] == 'Y') {
            $templateProcessor->setValue('senMedYN', $checkedBox);
        } else {
            $templateProcessor->setValue('senMedYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipSensitiveMachineMitigation']) && ($recordList['replySlipSensitiveMachineMitigation'] != "")) {
            $templateProcessor->setValue('senMedMit', $this->formatToWordTemplate($recordList['replySlipSensitiveMachineMitigation']));
        } else {
            $templateProcessor->setValue('senMedMit',"Nil");
        }
        if (isset($recordList['reEvaReportSensitiveMachineMedicalFinding']) && ($recordList['reEvaReportSensitiveMachineMedicalFinding']!="")) {
            $content = $recordList['reEvaReportSensitiveMachineMedicalFinding'];
            $templateProcessor->setValue('senMedMitFind', $this->formatToWordTemplate($recordList['reEvaReportSensitiveMachineMedicalFinding']));
            if (isset($recordList['reEvaReportSensitiveMachineMedicalRecommend']) && (trim($recordList['reEvaReportSensitiveMachineMedicalRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportSensitiveMachineMedicalRecommend'];
                $templateProcessor->setValue('senMedMitRec', $this->formatToWordTemplate($recordList['reEvaReportSensitiveMachineMedicalRecommend']));
            } else {
                $templateProcessor->setValue('senMedMitRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('senMedMitFind', "Nil");
            $templateProcessor->setValue('senMedMitRec', "Nil");
        }
        if (isset($recordList['reEvaReportSensitiveMachineSupplement']) && ($recordList['reEvaReportSensitiveMachineSupplement']!="")) {
            $content = $recordList['reEvaReportSensitiveMachineSupplement'];
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $templateProcessor->setValue('sensitiveMachineSupplement', $this->formatToWordTemplate($recordList['reEvaReportSensitiveMachineSupplement']));
            $contentCount++;
        } else {
            $templateProcessor->setValue('sensitiveMachineSupplement', "Nil");
        }

        // check if Telecom contains information
        if ($recordList['reEvaReportTelecomMachineYesNo'] == 'Y') {
            $templateProcessor->setValue('telYN', $checkedBox);
        } else {
            $templateProcessor->setValue('telYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportTelecomMachineServerOrComputerYesNo'] == 'Y') {
            $templateProcessor->setValue('telSCYN', $checkedBox);
        } else {
            $templateProcessor->setValue('telSCYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportTelecomMachinePeripheralsYesNo'] == 'Y') {
            $templateProcessor->setValue('telPerYN', $checkedBox);
        } else {
            $templateProcessor->setValue('telPerYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportTelecomMachineHarmonicEmissionYesNo'] == 'Y') {
            $templateProcessor->setValue('telHarYN', $checkedBox);
        } else {
            $templateProcessor->setValue('telHarYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipTelecomMachineServerOrComputer']) && ($recordList['replySlipTelecomMachineServerOrComputer'] != "")) {
            $templateProcessor->setValue('telSC', $this->formatToWordTemplate($recordList['replySlipTelecomMachineServerOrComputer']));
        } else {
            $templateProcessor->setValue('telSC',"Nil");
        }
        if (isset($recordList['reEvaReportTelecomMachineServerOrComputerFinding']) && ($recordList['reEvaReportTelecomMachineServerOrComputerFinding']!="")) {
            $content = $recordList['reEvaReportTelecomMachineServerOrComputerFinding'];
            $templateProcessor->setValue('telSCFind', $this->formatToWordTemplate($recordList['reEvaReportTelecomMachineServerOrComputerFinding']));
            if (isset($recordList['reEvaReportTelecomMachineServerOrComputerRecommend']) && (trim($recordList['reEvaReportTelecomMachineServerOrComputerRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportTelecomMachineServerOrComputerRecommend'];
                $templateProcessor->setValue('telSCRec', $this->formatToWordTemplate($recordList['reEvaReportTelecomMachineServerOrComputerRecommend']));
            } else {
                $templateProcessor->setValue('telSCRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('telSCFind', "Nil");
            $templateProcessor->setValue('telSCRec', "Nil");
        }
        if (isset($recordList['replySlipTelecomMachinePeripherals']) && ($recordList['replySlipTelecomMachinePeripherals'] != "")) {
            $templateProcessor->setValue('telPer', $this->formatToWordTemplate($recordList['replySlipTelecomMachinePeripherals']));
        } else {
            $templateProcessor->setValue('telPer',"Nil");
        }
        if (isset($recordList['reEvaReportTelecomMachinePeripheralsFinding']) && ($recordList['reEvaReportTelecomMachinePeripheralsFinding']!="")) {
            $content = $recordList['reEvaReportTelecomMachinePeripheralsFinding'];
            $templateProcessor->setValue('telPerFind', $this->formatToWordTemplate($recordList['reEvaReportTelecomMachinePeripheralsFinding']));
            if (isset($recordList['reEvaReportTelecomMachinePeripheralsRecommend']) && (trim($recordList['reEvaReportTelecomMachinePeripheralsRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportTelecomMachinePeripheralsRecommend'];
                $templateProcessor->setValue('telPerRec', $this->formatToWordTemplate($recordList['reEvaReportTelecomMachinePeripheralsRecommend']));
            } else {
                $templateProcessor->setValue('telPerRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('telPerFind', "Nil");
            $templateProcessor->setValue('telPerRec', "Nil");
        }
        if (isset($recordList['replySlipTelecomMachineHarmonicEmission']) && ($recordList['replySlipTelecomMachineHarmonicEmission'] != "")) {
            $templateProcessor->setValue('telHar', $this->formatToWordTemplate($recordList['replySlipTelecomMachineHarmonicEmission']));
        } else {
            $templateProcessor->setValue('telHar',"Nil");
        }
        if (isset($recordList['reEvaReportTelecomMachineHarmonicEmissionFinding']) && ($recordList['reEvaReportTelecomMachineHarmonicEmissionFinding']!="")) {
            $content = $recordList['reEvaReportTelecomMachineHarmonicEmissionFinding'];
            $templateProcessor->setValue('telHarFind', $this->formatToWordTemplate($recordList['reEvaReportTelecomMachineHarmonicEmissionFinding']));
            if (isset($recordList['reEvaReportTelecomMachineHarmonicEmissionRecommend']) && (trim($recordList['reEvaReportTelecomMachineHarmonicEmissionRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportTelecomMachineHarmonicEmissionRecommend'];
                $templateProcessor->setValue('telHarRec', $this->formatToWordTemplate($recordList['reEvaReportTelecomMachineHarmonicEmissionRecommend']));
            } else {
                $templateProcessor->setValue('telHarRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('telHarFind', "Nil");
            $templateProcessor->setValue('telHarRec', "Nil");
        }
        if (isset($recordList['reEvaReportTelecomMachineSupplement']) && ($recordList['reEvaReportTelecomMachineSupplement']!="")) {
            $content = $recordList['reEvaReportTelecomMachineSupplement'];
            $templateProcessor->setValue('telecomMachineSupplement', $this->formatToWordTemplate($recordList['reEvaReportTelecomMachineSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('telecomMachineSupplement', "Nil");
        }

        // check if Air Conditioners contains information
        if ($recordList['reEvaReportAirConditionersYesNo'] == 'Y') {
            $templateProcessor->setValue('airConYN', $checkedBox);
        } else {
            $templateProcessor->setValue('airConYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportAirConditionersMicbYesNo'] == 'Y') {
            $templateProcessor->setValue('airConMicbYN', $checkedBox);
        } else {
            $templateProcessor->setValue('airConMicbYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportAirConditionersLoadForecastingYesNo'] == 'Y') {
            $templateProcessor->setValue('airConForYN', $checkedBox);
        } else {
            $templateProcessor->setValue('airConForYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportAirConditionersTypeYesNo'] == 'Y') {
            $templateProcessor->setValue('airConTypYN', $checkedBox);
        } else {
            $templateProcessor->setValue('airConTypYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipAirConditionersMicb']) && ($recordList['replySlipAirConditionersMicb'] != "")) {
            $templateProcessor->setValue('airConMicb', $this->formatToWordTemplate($recordList['replySlipAirConditionersMicb']));
        } else {
            $templateProcessor->setValue('airConMicb',"Nil");
        }
        if (isset($recordList['reEvaReportAirConditionersMicbFinding']) && ($recordList['reEvaReportAirConditionersMicbFinding']!="")) {
            $content = $recordList['reEvaReportAirConditionersMicbFinding'];
            $templateProcessor->setValue('airConMicbFind', $this->formatToWordTemplate($recordList['reEvaReportAirConditionersMicbFinding']));
            if (isset($recordList['reEvaReportAirConditionersMicbRecommend']) && (trim($recordList['reEvaReportAirConditionersMicbRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportAirConditionersMicbRecommend'];
                $templateProcessor->setValue('airConMicbRec', $this->formatToWordTemplate($recordList['reEvaReportAirConditionersMicbRecommend']));
            } else {
                $templateProcessor->setValue('airConMicbRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('airConMicbFind', "Nil");
            $templateProcessor->setValue('airConMicbRec', "Nil");
        }
        if (isset($recordList['replySlipAirConditionersLoadForecasting']) && ($recordList['replySlipAirConditionersLoadForecasting'] != "")) {
            $templateProcessor->setValue('airConFor', $this->formatToWordTemplate($recordList['replySlipAirConditionersLoadForecasting']));
        } else {
            $templateProcessor->setValue('airConFor',"Nil");
        }
        if (isset($recordList['reEvaReportAirConditionersLoadForecastingFinding']) && ($recordList['reEvaReportAirConditionersLoadForecastingFinding']!="")) {
            $content = $recordList['reEvaReportAirConditionersLoadForecastingFinding'];
            $templateProcessor->setValue('airConForFind', $this->formatToWordTemplate($recordList['reEvaReportAirConditionersLoadForecastingFinding']));
            if (isset($recordList['reEvaReportAirConditionersLoadForecastingRecommend']) && (trim($recordList['reEvaReportAirConditionersLoadForecastingRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportAirConditionersLoadForecastingRecommend'];
                $templateProcessor->setValue('airConForRec', $this->formatToWordTemplate($recordList['reEvaReportAirConditionersLoadForecastingRecommend']));
            } else {
                $templateProcessor->setValue('airConForRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('airConForFind', "Nil");
            $templateProcessor->setValue('airConForRec', "Nil");
        }
        if (isset($recordList['replySlipAirConditionersType']) && ($recordList['replySlipAirConditionersType'] != "")) {
            $templateProcessor->setValue('airConTyp', $this->formatToWordTemplate($recordList['replySlipAirConditionersType']));
        } else {
            $templateProcessor->setValue('airConTyp',"Nil");
        }
        if (isset($recordList['reEvaReportAirConditionersTypeFinding']) && ($recordList['reEvaReportAirConditionersTypeFinding']!="")) {
            $content = $recordList['reEvaReportAirConditionersTypeFinding'];
            $templateProcessor->setValue('airConTypFind', $this->formatToWordTemplate($recordList['reEvaReportAirConditionersTypeFinding']));
            if (isset($recordList['reEvaReportAirConditionersTypeRecommend']) && (trim($recordList['reEvaReportAirConditionersTypeRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportAirConditionersTypeRecommend'];
                $templateProcessor->setValue('airConTypRec', $this->formatToWordTemplate($recordList['reEvaReportAirConditionersTypeRecommend']));
            } else {
                $templateProcessor->setValue('airConTypRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('airConTypFind', "Nil");
            $templateProcessor->setValue('airConTypRec', "Nil");
        }
        if (isset($recordList['reEvaReportAirConditionersSupplement']) && ($recordList['reEvaReportAirConditionersSupplement']!="")) {
            $content = $recordList['reEvaReportAirConditionersSupplement'];
            $templateProcessor->setValue('airConditionersSupplement', $this->formatToWordTemplate($recordList['reEvaReportAirConditionersSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('airConditionersSupplement', "Nil");
        }

        // check if Non-linear contains information
        if ($recordList['reEvaReportNonLinearLoadYesNo'] == 'Y') {
            $templateProcessor->setValue('nonYN', $checkedBox);
        } else {
            $templateProcessor->setValue('nonYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportNonLinearLoadHarmonicEmissionYesNo'] == 'Y') {
            $templateProcessor->setValue('nonHarYN', $checkedBox);
        } else {
            $templateProcessor->setValue('nonHarYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipNonLinearLoadHarmonicEmission']) && ($recordList['replySlipNonLinearLoadHarmonicEmission'] != "")) {
            $templateProcessor->setValue('nonHar', $this->formatToWordTemplate($recordList['replySlipNonLinearLoadHarmonicEmission']));
        } else {
            $templateProcessor->setValue('nonHar',"Nil");
        }
        if (isset($recordList['reEvaReportNonLinearLoadHarmonicEmissionFinding']) && ($recordList['reEvaReportNonLinearLoadHarmonicEmissionFinding']!="")) {
            $content = $content . $recordList['reEvaReportNonLinearLoadHarmonicEmissionFinding'];
            $templateProcessor->setValue('nonHarFind', $this->formatToWordTemplate($recordList['reEvaReportNonLinearLoadHarmonicEmissionFinding']));
            if (isset($recordList['reEvaReportNonLinearLoadHarmonicEmissionRecommend']) && (trim($recordList['reEvaReportNonLinearLoadHarmonicEmissionRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportNonLinearLoadHarmonicEmissionRecommend'];
                $templateProcessor->setValue('nonHarRec', $this->formatToWordTemplate($recordList['reEvaReportNonLinearLoadHarmonicEmissionRecommend']));
            } else {
                $templateProcessor->setValue('nonHarRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('nonHarFind', "Nil");
            $templateProcessor->setValue('nonHarRec', "Nil");
        }
        if (isset($recordList['reEvaReportNonLinearLoadSupplement']) && ($recordList['reEvaReportNonLinearLoadSupplement']!="")) {
            $content = $recordList['reEvaReportNonLinearLoadSupplement'];
            $templateProcessor->setValue('nonLinearLoadSupplement', $this->formatToWordTemplate($recordList['reEvaReportNonLinearLoadSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('nonLinearLoadSupplement', "Nil");
        }

        // check if renewable energy contains information
        if ($recordList['reEvaReportRenewableEnergyYesNo'] == 'Y') {
            $templateProcessor->setValue('renewYN', $checkedBox);
        } else {
            $templateProcessor->setValue('renewYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportRenewableEnergyInverterAndControlsYesNo'] == 'Y') {
            $templateProcessor->setValue('renewCtlYN', $checkedBox);
        } else {
            $templateProcessor->setValue('renewCtlYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportRenewableEnergyHarmonicEmissionYesNo'] == 'Y') {
            $templateProcessor->setValue('renewHarYN', $checkedBox);
        } else {
            $templateProcessor->setValue('renewHarYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipRenewableEnergyInverterAndControls']) && ($recordList['replySlipRenewableEnergyInverterAndControls'] != "")) {
            $templateProcessor->setValue('renewCtl', $this->formatToWordTemplate($recordList['replySlipRenewableEnergyInverterAndControls']));
        } else {
            $templateProcessor->setValue('renewCtl',"Nil");
        }
        if (isset($recordList['reEvaReportRenewableEnergyInverterAndControlsFinding']) && ($recordList['reEvaReportRenewableEnergyInverterAndControlsFinding']!="")) {
            $content = $recordList['reEvaReportRenewableEnergyInverterAndControlsFinding'];
            $templateProcessor->setValue('renewCtlFind', $this->formatToWordTemplate($recordList['reEvaReportRenewableEnergyInverterAndControlsFinding']));
            if (isset($recordList['reEvaReportRenewableEnergyInverterAndControlsRecommend']) && (trim($recordList['reEvaReportRenewableEnergyInverterAndControlsRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportRenewableEnergyInverterAndControlsRecommend'];
                $templateProcessor->setValue('renewCtlRec', $this->formatToWordTemplate($recordList['reEvaReportRenewableEnergyInverterAndControlsRecommend']));
            } else {
                $templateProcessor->setValue('renewCtlRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('renewCtlFind', "Nil");
            $templateProcessor->setValue('renewCtlRec', "Nil");
        }
        if (isset($recordList['replySlipRenewableEnergyHarmonicEmission']) && ($recordList['replySlipRenewableEnergyHarmonicEmission'] != "")) {
            $templateProcessor->setValue('renewHar', $this->formatToWordTemplate($recordList['replySlipRenewableEnergyHarmonicEmission']));
        } else {
            $templateProcessor->setValue('renewHar',"Nil");
        }
        if (isset($recordList['reEvaReportRenewableEnergyHarmonicEmissionFinding']) && ($recordList['reEvaReportRenewableEnergyHarmonicEmissionFinding']!="")) {
            $content = $recordList['reEvaReportRenewableEnergyHarmonicEmissionFinding'];
            $templateProcessor->setValue('renewHarFind', $this->formatToWordTemplate($recordList['reEvaReportRenewableEnergyHarmonicEmissionFinding']));
            if (isset($recordList['reEvaReportRenewableEnergyHarmonicEmissionRecommend']) && (trim($recordList['reEvaReportRenewableEnergyHarmonicEmissionRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportRenewableEnergyHarmonicEmissionRecommend'];
                $templateProcessor->setValue('renewHarRec', $this->formatToWordTemplate($recordList['reEvaReportRenewableEnergyHarmonicEmissionRecommend']));
            } else {
                $templateProcessor->setValue('renewHarRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('renewHarFind', "Nil");
            $templateProcessor->setValue('renewHarRec', "Nil");
        }
        if (isset($recordList['reEvaReportRenewableEnergySupplement']) && ($recordList['reEvaReportRenewableEnergySupplement']!="")) {
            $content = $recordList['reEvaReportRenewableEnergySupplement'];
            $templateProcessor->setValue('renewableEnergySupplement', $this->formatToWordTemplate($recordList['reEvaReportRenewableEnergySupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('renewableEnergySupplement', "Nil");
        }

        // check if EV charge contains information
        if ($recordList['reEvaReportEvChargerSystemYesNo'] == 'Y') {
            $templateProcessor->setValue('evYN', $checkedBox);
        } else {
            $templateProcessor->setValue('evYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportEvChargerSystemEvChargerYesNo'] == 'Y') {
            $templateProcessor->setValue('evChgYN', $checkedBox);
        } else {
            $templateProcessor->setValue('evChgYN', $unCheckedBox);
        }
        if ($recordList['reEvaReportEvChargerSystemHarmonicEmissionYesNo'] == 'Y') {
            $templateProcessor->setValue('evHarYN', $checkedBox);
        } else {
            $templateProcessor->setValue('evHarYN', $unCheckedBox);
        }
        if (isset($recordList['replySlipEvChargerSystemEvCharger']) && ($recordList['replySlipEvChargerSystemEvCharger'] != "")) {
            $templateProcessor->setValue('evChg', $this->formatToWordTemplate($recordList['replySlipEvChargerSystemEvCharger']));
        } else {
            $templateProcessor->setValue('evChg',"Nil");
        }
        if (isset($recordList['reEvaReportEvChargerSystemEvChargerFinding']) && ($recordList['reEvaReportEvChargerSystemEvChargerFinding']!="")) {
            $content = $recordList['reEvaReportEvChargerSystemEvChargerFinding'];
            $templateProcessor->setValue('evChgFind', $this->formatToWordTemplate($recordList['reEvaReportEvChargerSystemEvChargerFinding']));
            if (isset($recordList['reEvaReportEvChargerSystemEvChargerRecommend']) && (trim($recordList['reEvaReportEvChargerSystemEvChargerRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportEvChargerSystemEvChargerRecommend'];
                $templateProcessor->setValue('evChgRec', $this->formatToWordTemplate($recordList['reEvaReportEvChargerSystemEvChargerRecommend']));
            } else {
                $templateProcessor->setValue('evChgRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('evChgFind', "Nil");
            $templateProcessor->setValue('evChgRec', "Nil");
        }
        if (isset($recordList['replySlipEvChargerSystemHarmonicEmission']) && ($recordList['replySlipEvChargerSystemHarmonicEmission'] != "")) {
            $templateProcessor->setValue('evHar', $this->formatToWordTemplate($recordList['replySlipEvChargerSystemHarmonicEmission']));
        } else {
            $templateProcessor->setValue('evHar',"Nil");
        }
        if (isset($recordList['reEvaReportEvChargerSystemHarmonicEmissionFinding']) && ($recordList['reEvaReportEvChargerSystemHarmonicEmissionFinding']!="")) {
            $content = $content . $recordList['reEvaReportEvChargerSystemHarmonicEmissionFinding'];
            $templateProcessor->setValue('evHarFind', $this->formatToWordTemplate($recordList['reEvaReportEvChargerSystemHarmonicEmissionFinding']));
            if (isset($recordList['reEvaReportEvChargerSystemHarmonicEmissionRecommend']) && (trim($recordList['reEvaReportEvChargerSystemHarmonicEmissionRecommend']) != "")) {
                $content = $content . " " . $recordList['reEvaReportEvChargerSystemHarmonicEmissionRecommend'];
                $templateProcessor->setValue('evHarRec', $this->formatToWordTemplate($recordList['reEvaReportEvChargerSystemHarmonicEmissionRecommend']));
            } else {
                $templateProcessor->setValue('evHarRec', "Nil");
            }
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('evHarFind', "Nil");
            $templateProcessor->setValue('evHarRec', "Nil");
        }
        if (isset($recordList['reEvaReportEvChargerSystemSupplement']) && ($recordList['reEvaReportEvChargerSystemSupplement']!="")) {
            $content = $recordList['reEvaReportEvChargerSystemSupplement'];
            $templateProcessor->setValue('reEvChargerSystemSupplement', $this->formatToWordTemplate($recordList['reEvaReportEvChargerSystemSupplement']));
            $templateProcessor->setComplexBlock('content' . $contentCount, $this->getListItemRun(trim($content)));
            $contentCount++;
        } else {
            $templateProcessor->setValue('evChargerSystemSupplement', "Nil");
        }

        // Display the footer messages
        $footerTextRun = new \PhpOffice\PhpWord\Element\TextRun(array('align'=>'both'));
        $footerTextRun->addText("We are committed in assisting our customers to resolve the potential PQ issues and it is our pleasure to have this chance to have a PQ site walk with you to share the mitigation solutions to alleviate the impacts on your critical equipment caused by PQ issues. We would be grateful to conduct further study with your team by carrying out voltage dip simulation tests or PQ measurement on the concerned equipment and devising possible cost-effective mitigation solutions to improve the performances of the concerned equipment caused by PQ issues.");
        $footerTextRun->addTextBreak(2);
        $footerTextRun->addText("Should you have any query, please feel free to contact our Mr. K.Y. Poon at 2678 6047 or Mr. K.W. Chan at 2678 7518 for assistance.");
        $footerTextRun->addTextBreak(2);
        $footerTextRun->addText("Yours sincerely,");
        $footerTextRun->addTextBreak(1);
        $footerTextRun->addText("CLP Power Hong Kong Limited");
        $footerTextRun->addTextBreak(5);
        $footerTextRun->addText("Edmond Chan");
        $footerTextRun->addTextBreak(1);
        $footerTextRun->addText("Principal Manager – Systems Engineering");
        $footerTextRun->addTextBreak(1);
        $footerTextRun->addText("4817", array('size'=>8));
        $templateProcessor->setComplexBlock('content' . $contentCount, $footerTextRun);
        $contentCount++;

        $contentMaxCount = 36;
        for ($x=$contentCount; $x<=$contentMaxCount; $x++) {
            $templateProcessor->setValue('content' . $x, "");
        }

        $pathToSave = $evaReportTemplatePath['configValue'] . 'temp\\(' . $schemeNo . ')' .
            $evaReportTemplateFileName['configValue'];
        $templateProcessor->saveAs($pathToSave);

        header("Content-Description: File Transfer");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header('Content-Disposition: attachment; filename='. basename($pathToSave));
        header('Content-Length: ' . filesize($pathToSave));
        header('Pragma: public');

        //Clear system output buffer
        flush();

        //Read the size of the file
        readfile($pathToSave);
        unlink($pathToSave); // deletes the temporary file

        die();

    }


    private function getListItemRun($content) {
        $listItemRun = new \PhpOffice\PhpWord\Element\ListItemRun(0,array(),array('align'=>'both'));
        $listItemRun->addText($this->formatToWordTemplate(trim($content)));
        $listItemRun->addTextBreak(1);
        return $listItemRun;
    }

    private function getTableListItemRun($content) {
        $listItemRun = new \PhpOffice\PhpWord\Element\ListItemRun(0,array(),array('align'=>'both'));
        $listItemRun->addText($this->formatToWordTemplate(trim($content)),array('size'=> 8, 'name'=>'Arial'));
        $listItemRun->addTextBreak(1);
        return $listItemRun;
    }


    // *************************************
    // ***** Ajax function ******
    // *************************************

    public function actionAjaxGetPlanningAheadTable() {
        $param = json_decode(file_get_contents('php://input'), true);
        $searchParam = json_decode($param['searchParam'], true);

        $start = $param['start'];
        $length = $param['length'];
        $orderColumn = $param['order'][0]['column'];
        $orderDir = $param['order'][0]['dir'];
        $order = '"'.$param['columns'][$orderColumn]['data'] . '" ' . $orderDir;

        $planningAheadList = Yii::app()->planningAheadDao->GetPlanningAheadSearchByPage($searchParam, $start, $length, $order);
        $recordFiltered = Yii::app()->planningAheadDao->GetPlanningAheadSearchResultCount($searchParam);
        $totalCount = Yii::app()->planningAheadDao->GetPlanningAheadRecordCount();

        $result = array('draw' => $param['draw'],
            'data' => $planningAheadList,
            'recordsFiltered' => $recordFiltered,
            'recordsTotal' => $totalCount);

        echo json_encode($result);
    }

    // *********************************************************************
    // Draft update for the project detail
    // *********************************************************************
    public function actionAjaxPostPlanningAheadProjectDetailDraftUpdate() {

        $retJson = array();
        $success = true;

        if ($success && (!isset($_POST['planningAheadId']) || ($_POST['planningAheadId'] == ""))) {
            $retJson['retMessage'] = "Planning Ahead Id is required!";
            $success = false;
        } else {
            $txnPlanningAheadId = trim($_POST['planningAheadId']);
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

        if ($success) {
            $txnTypeOfProject = $this->getPostParamInteger('typeOfProject');
            $txnCommissionDate = $this->getPostParamString('commissionDate');
            $txnKeyInfra = $this->getPostParamString('infraOpt');
            $txnTempProj = $this->getPostParamString('tempProjOpt');
            $txnFirstRegionStaffName = $this->getPostParamString('firstRegionStaffName');
            $txnFirstRegionStaffPhone = $this->getPostParamString('firstRegionStaffPhone');
            $txnFirstRegionStaffEmail = $this->getPostParamString('firstRegionStaffEmail');
            $txnSecondRegionStaffName = $this->getPostParamString('secondRegionStaffName');
            $txnSecondRegionStaffPhone = $this->getPostParamString('secondRegionStaffPhone');
            $txnSecondRegionStaffEmail = $this->getPostParamString('secondRegionStaffEmail');
            $txnThirdRegionStaffName = $this->getPostParamString('thirdRegionStaffName');
            $txnThirdRegionStaffPhone = $this->getPostParamString('thirdRegionStaffPhone');
            $txnThirdRegionStaffEmail = $this->getPostParamString('thirdRegionStaffEmail');
            $txnFirstConsultantTitle = $this->getPostParamString('firstConsultantTitle');
            $txnFirstConsultantSurname = $this->getPostParamString('firstConsultantSurname');
            $txnFirstConsultantOtherName = $this->getPostParamString('firstConsultantOtherName');
            $txnFirstConsultantCompany = $this->getPostParamString('firstConsultantCompany');
            $txnFirstConsultantPhone = $this->getPostParamString('firstConsultantPhone');
            $txnFirstConsultantEmail = $this->getPostParamString('firstConsultantEmail');
            $txnSecondConsultantTitle = $this->getPostParamString('secondConsultantTitle');
            $txnSecondConsultantSurname = $this->getPostParamString('secondConsultantSurname');
            $txnSecondConsultantOtherName = $this->getPostParamString('secondConsultantOtherName');
            $txnSecondConsultantCompany = $this->getPostParamString('secondConsultantCompany');
            $txnSecondConsultantPhone = $this->getPostParamString('secondConsultantPhone');
            $txnSecondConsultantEmail = $this->getPostParamString('secondConsultantEmail');
            $txnThirdConsultantTitle = $this->getPostParamString('thirdConsultantTitle');
            $txnThirdConsultantSurname = $this->getPostParamString('thirdConsultantSurname');
            $txnThirdConsultantOtherName = $this->getPostParamString('thirdConsultantOtherName');
            $txnThirdConsultantCompany = $this->getPostParamString('thirdConsultantCompany');
            $txnThirdConsultantPhone = $this->getPostParamString('thirdConsultantPhone');
            $txnThirdConsultantEmail = $this->getPostParamString('thirdConsultantEmail');
            $txnFirstProjectOwnerTitle = $this->getPostParamString('firstProjectOwnerTitle');
            $txnFirstProjectOwnerSurname = $this->getPostParamString('firstProjectOwnerSurname');
            $txnFirstProjectOwnerOtherName = $this->getPostParamString('firstProjectOwnerOtherName');
            $txnFirstProjectOwnerCompany = $this->getPostParamString('firstProjectOwnerCompany');
            $txnFirstProjectOwnerPhone = $this->getPostParamString('firstProjectOwnerPhone');
            $txnFirstProjectOwnerEmail = $this->getPostParamString('firstProjectOwnerEmail');
            $txnSecondProjectOwnerTitle = $this->getPostParamString('secondProjectOwnerTitle');
            $txnSecondProjectOwnerSurname = $this->getPostParamString('secondProjectOwnerSurname');
            $txnSecondProjectOwnerOtherName = $this->getPostParamString('secondProjectOwnerOtherName');
            $txnSecondProjectOwnerCompany = $this->getPostParamString('secondProjectOwnerCompany');
            $txnSecondProjectOwnerPhone = $this->getPostParamString('secondProjectOwnerPhone');
            $txnSecondProjectOwnerEmail = $this->getPostParamString('secondProjectOwnerEmail');
            $txnThirdProjectOwnerTitle = $this->getPostParamString('thirdProjectOwnerTitle');
            $txnThirdProjectOwnerSurname = $this->getPostParamString('thirdProjectOwnerSurname');
            $txnThirdProjectOwnerOtherName = $this->getPostParamString('thirdProjectOwnerOtherName');
            $txnThirdProjectOwnerCompany = $this->getPostParamString('thirdProjectOwnerCompany');
            $txnThirdProjectOwnerPhone = $this->getPostParamString('thirdProjectOwnerPhone');
            $txnThirdProjectOwnerEmail = $this->getPostParamString('thirdProjectOwnerEmail');
            $txnStandLetterIssueDate = $this->getPostParamString('standLetterIssueDate');
            $txnStandLetterFaxRefNo = $this->getPostParamString('standLetterFaxRefNo');
            $txnStandLetterEdmsLink = $this->getPostParamString('standLetterEdmsLink');
            $txnStandLetterLetterLoc = $this->getPostParamString('standLetterLetterLoc');

            if (!empty($_FILES["standSignedLetter"]["name"])) {
                $fileName = basename($_FILES["standSignedLetter"]["name"]);
                $planningAheadStandardSignedLetterPath = Yii::app()->commonUtil->getConfigValueByConfigName('planningAheadStandardLetterPath');
                $targetFilePath = $planningAheadStandardSignedLetterPath["configValue"] . $txnSchemeNo . '_' . $fileName;
                $txnStandLetterLetterLoc = $targetFilePath;

                //upload file to server
                if (!move_uploaded_file($_FILES["standSignedLetter"]["tmp_name"], $targetFilePath)){
                    $retJson['status'] = 'NOTOK';
                    $retJson['retMessage'] = "Upload signed standard letter failed!";
                    $success = false;
                }
            }

            if ($success) {
                $txnMeetingFirstPreferMeetingDate = $this->getPostParamString('meetingFirstPreferMeetingDate');
                $txnMeetingSecondPreferMeetingDate = $this->getPostParamString('meetingSecondPreferMeetingDate');
                $txnMeetingActualMeetingDate = $this->getPostParamString('meetingActualMeetingDate');
                $txnMeetingRejReason = $this->getPostParamString('meetingRejReason');
                $txnMeetingConsentConsultant = $this->getPostParamBoolean('meetingConsentConsultant');
                $txnMeetingConsentOwner = $this->getPostParamBoolean('meetingConsentOwner');
                $txnMeetingRemark = $this->getPostParamString('meetingRemark');
                $txnMeetingReplySlipId = $this->getPostParamInteger('meetingReplySlipId');
                $txnReplySlipBmsYesNo = $this->getPostParamBoolean('replySlipBmsYesNo');
                $txnReplySlipBmsServerCentralComputer = $this->getPostParamString('replySlipBmsServerCentralComputer');
                $txnReplySlipBmsDdc = $this->getPostParamString('replySlipBmsDdc');
                $txnReplySlipChangeoverSchemeYesNo = $this->getPostParamBoolean('replySlipChangeoverSchemeYesNo');
                $txnReplySlipChangeoverSchemeControl = $this->getPostParamString('replySlipChangeoverSchemeControl');
                $txnReplySlipChangeoverSchemeUv = $this->getPostParamString('replySlipChangeoverSchemeUv');
                $txnReplySlipChillerPlantYesNo = $this->getPostParamBoolean('replySlipChillerPlantYesNo');
                $txnReplySlipChillerPlantAhuControl = $this->getPostParamString('replySlipChillerPlantAhuControl');
                $txnReplySlipChillerPlantAhuStartup = $this->getPostParamString('replySlipChillerPlantAhuStartup');
                $txnReplySlipChillerPlantVsd = $this->getPostParamString('replySlipChillerPlantVsd');
                $txnReplySlipChillerPlantAhuChilledWater = $this->getPostParamString('replySlipChillerPlantAhuChilledWater');
                $txnReplySlipChillerPlantStandbyAhu = $this->getPostParamString('replySlipChillerPlantStandbyAhu');
                $txnReplySlipChillerPlantChiller = $this->getPostParamString('replySlipChillerPlantChiller');
                $txnReplySlipEscalatorYesNo = $this->getPostParamBoolean('replySlipEscalatorYesNo');
                $txnReplySlipEscalatorMotorStartup = $this->getPostParamBoolean('replySlipEscalatorMotorStartup');
                $txnReplySlipEscalatorVsdMitigation = $this->getPostParamString('replySlipEscalatorVsdMitigation');
                $txnReplySlipEscalatorBrakingSystem = $this->getPostParamString('replySlipEscalatorBrakingSystem');
                $txnReplySlipEscalatorControl = $this->getPostParamString('replySlipEscalatorControl');
                $txnReplySlipHidLampYesNo = $this->getPostParamBoolean('replyHidLampYesNo');
                $txnReplySlipHidLampMitigation = $this->getPostParamString('replySlipHidLampMitigation');
                $txnReplySlipLiftYesNo = $this->getPostParamBoolean('replyLiftYesNo');
                $txnReplySlipLiftOperation = $this->getPostParamString('replySlipLiftOperation');
                $txnReplySlipSensitiveMachineYesNo = $this->getPostParamBoolean('replySlipSensitiveMachineYesNo');
                $txnReplySlipSensitiveMachineMitigation = $this->getPostParamString('replySlipSensitiveMachineMitigation');
                $txnReplySlipTelecomMachineYesNo = $this->getPostParamBoolean('replySlipTelecomMachineYesNo');
                $txnReplySlipTelecomMachineServerOrComputer = $this->getPostParamString('replySlipTelecomMachineServerOrComputer');
                $txnReplySlipTelecomMachinePeripherals = $this->getPostParamString('replySlipTelecomMachinePeripherals');
                $txnReplySlipTelecomMachineHarmonicEmission = $this->getPostParamString('replySlipTelecomMachineHarmonicEmission');
                $txnReplySlipAirConditionersYesNo = $this->getPostParamBoolean('replySlipAirConditionersYesNo');
                $txnReplySlipAirConditionersMicb = $this->getPostParamString('replySlipAirConditionersMicb');
                $txnReplySlipAirConditionersLoadForecasting = $this->getPostParamString('replySlipAirConditionersLoadForecasting');
                $txnReplySlipAirConditionersType = $this->getPostParamString('replySlipAirConditionersType');
                $txnReplySlipNonLinearLoadYesNo = $this->getPostParamBoolean('replySlipNonLinearLoadYesNo');
                $txnReplySlipNonLinearLoadHarmonicEmission = $this->getPostParamString('replySlipNonLinearLoadHarmonicEmission');
                $txnReplySlipRenewableEnergyYesNo = $this->getPostParamBoolean('replySlipRenewableEnergyYesNo');
                $txnReplySlipRenewableEnergyInverterAndControls = $this->getPostParamString('replySlipRenewableEnergyInverterAndControls');
                $txnReplySlipRenewableEnergyHarmonicEmission = $this->getPostParamString('replySlipRenewableEnergyHarmonicEmission');
                $txnReplySlipEvChargerSystemYesNo = $this->getPostParamBoolean('replySlipEvChargerSystemYesNo');
                $txnReplySlipEvControlYesNo = $this->getPostParamBoolean('replySlipEvControlYesNo');
                $txnReplySlipEvChargerSystemEvCharger = $this->getPostParamString('replySlipEvChargerSystemEvCharger');
                $txnReplySlipEvChargerSystemSmartYesNo = $this->getPostParamString('replySlipEvChargerSystemSmartYesNo');
                $txnReplySlipEvChargerSystemSmartChargingSystem = $this->getPostParamString('replySlipEvChargerSystemSmartChargingSystem');
                $txnReplySlipEvChargerSystemHarmonicEmission = $this->getPostParamString('replySlipEvChargerSystemHarmonicEmission');
                $txnReplySlipConsultantNameConfirmation = $this->getPostParamString('replySlipConsultantNameConfirmation');
                $txnReplySlipConsultantCompany = $this->getPostParamString('replySlipConsultantCompany');
                $txnReplySlipProjectOwnerNameConfirmation = $this->getPostParamString('replySlipProjectOwnerNameConfirmation');
                $txnReplySlipProjectOwnerCompany = $this->getPostParamString('replySlipProjectOwnerCompany');
                $txnFirstInvitationLetterIssueDate = $this->getPostParamString('firstInvitationLetterIssueDate');
                $txnFirstInvitationLetterFaxRefNo = $this->getPostParamString('firstInvitationLetterFaxRefNo');
                $txnFirstInvitationLetterEdmsLink = $this->getPostParamString('firstInvitationLetterEdmsLink');
                $txnFirstInvitationLetterAccept = $this->getPostParamString('firstInvitationLetterAccept');
                $txnFirstInvitationLetterWalkDate = $this->getPostParamString('firstInvitationLetterWalkDate');
                $txnSecondInvitationLetterIssueDate = $this->getPostParamString('secondInvitationLetterIssueDate');
                $txnSecondInvitationLetterFaxRefNo = $this->getPostParamString('secondInvitationLetterFaxRefNo');
                $txnSecondInvitationLetterEdmsLink = $this->getPostParamString('secondInvitationLetterEdmsLink');
                $txnSecondInvitationLetterAccept = $this->getPostParamString('secondInvitationLetterAccept');
                $txnSecondInvitationLetterWalkDate = $this->getPostParamString('secondInvitationLetterWalkDate');
                $txnThirdInvitationLetterIssueDate = $this->getPostParamString('thirdInvitationLetterIssueDate');
                $txnThirdInvitationLetterFaxRefNo = $this->getPostParamString('thirdInvitationLetterFaxRefNo');
                $txnThirdInvitationLetterEdmsLink = $this->getPostParamString('thirdInvitationLetterEdmsLink');
                $txnThirdInvitationLetterAccept = $this->getPostParamString('thirdInvitationLetterAccept');
                $txnThirdInvitationLetterWalkDate = $this->getPostParamString('thirdInvitationLetterWalkDate');
                $txnForthInvitationLetterIssueDate = $this->getPostParamString('forthInvitationLetterIssueDate');
                $txnForthInvitationLetterFaxRefNo = $this->getPostParamString('forthInvitationLetterFaxRefNo');
                $txnForthInvitationLetterEdmsLink = $this->getPostParamString('forthInvitationLetterEdmsLink');
                $txnForthInvitationLetterAccept = $this->getPostParamString('forthInvitationLetterAccept');
                $txnForthInvitationLetterWalkDate = $this->getPostParamString('forthInvitationLetterWalkDate');
                $txnEvaReportId = $this->getPostParamString('evaReportId');
                $txnEvaReportRemark = $this->getPostParamString('evaReportRemark');
                $txnEvaReportEdmsLink = $this->getPostParamString('evaReportEdmsLink');
                $txnEvaReportIssueDate = $this->getPostParamString('evaReportIssueDate');
                $txnEvaReportFaxRefNo = $this->getPostParamString('evaReportFaxRefNo');
                $txnEvaReportScore = $this->getPostParamString('evaReportScore');
                $txnEvaReportBmsYesNo = $this->getPostParamString('evaReportBmsYesNo');
                $txnEvaReportBmsServerCentralComputerYesNo = $this->getPostParamString('evaReportBmsServerCentralComputerYesNo');
                $txnEvaReportBmsServerCentralComputerFinding = $this->getPostParamString('evaReportBmsServerCentralComputerFinding');
                $txnEvaReportBmsServerCentralComputerRecommend = $this->getPostParamString('evaReportBmsServerCentralComputerRecommend');
                $txnEvaReportBmsServerCentralComputerPass = $this->getPostParamString('evaReportBmsServerCentralComputerPass');
                $txnEvaReportBmsDdcYesNo = $this->getPostParamString('evaReportBmsDdcYesNo');
                $txnEvaReportBmsDdcFinding = $this->getPostParamString('evaReportBmsDdcFinding');
                $txnEvaReportBmsDdcRecommend = $this->getPostParamString('evaReportBmsDdcRecommend');
                $txnEvaReportBmsDdcPass = $this->getPostParamString('evaReportBmsDdcPass');
                $txnEvaReportBmsSupplementYesNo = $this->getPostParamString('evaReportBmsSupplementYesNo');
                $txnEvaReportBmsSupplement = $this->getPostParamString('evaReportBmsSupplement');
                $txnEvaReportBmsSupplementPass = $this->getPostParamString('evaReportBmsSupplementPass');
                $txnEvaReportChangeoverSchemeYesNo = $this->getPostParamString('evaReportChangeoverSchemeYesNo');
                $txnEvaReportChangeoverSchemeControlYesNo = $this->getPostParamString('evaReportChangeoverSchemeControlYesNo');
                $txnEvaReportChangeoverSchemeControlFinding = $this->getPostParamString('evaReportChangeoverSchemeControlFinding');
                $txnEvaReportChangeoverSchemeControlRecommend = $this->getPostParamString('evaReportChangeoverSchemeControlRecommend');
                $txnEvaReportChangeoverSchemeControlPass = $this->getPostParamString('evaReportChangeoverSchemeControlPass');
                $txnEvaReportChangeoverSchemeUvYesNo = $this->getPostParamString('evaReportChangeoverSchemeUvYesNo');
                $txnEvaReportChangeoverSchemeUvFinding = $this->getPostParamString('evaReportChangeoverSchemeUvFinding');
                $txnEvaReportChangeoverSchemeUvRecommend = $this->getPostParamString('evaReportChangeoverSchemeUvRecommend');
                $txnEvaReportChangeoverSchemeUvPass = $this->getPostParamString('evaReportChangeoverSchemeUvPass');
                $txnEvaReportChangeoverSchemeSupplementYesNo = $this->getPostParamString('evaReportChangeoverSchemeSupplementYesNo');
                $txnEvaReportChangeoverSchemeSupplement = $this->getPostParamString('evaReportChangeoverSchemeSupplement');
                $txnEvaReportChangeoverSchemeSupplementPass = $this->getPostParamString('evaReportChangeoverSchemeSupplementPass');
                $txnEvaReportChillerPlantYesNo = $this->getPostParamString('evaReportChillerPlantYesNo');
                $txnEvaReportChillerPlantAhuChilledWaterYesNo = $this->getPostParamString('evaReportChillerPlantAhuChilledWaterYesNo');
                $txnEvaReportChillerPlantAhuChilledWaterFinding = $this->getPostParamString('evaReportChillerPlantAhuChilledWaterFinding');
                $txnEvaReportChillerPlantAhuChilledWaterRecommend = $this->getPostParamString('evaReportChillerPlantAhuChilledWaterRecommend');
                $txnEvaReportChillerPlantAhuChilledWaterPass = $this->getPostParamString('evaReportChillerPlantAhuChilledWaterPass');
                $txnEvaReportChillerPlantChillerYesNo = $this->getPostParamString('evaReportChillerPlantChillerYesNo');
                $txnEvaReportChillerPlantChillerFinding = $this->getPostParamString('evaReportChillerPlantChillerFinding');
                $txnEvaReportChillerPlantChillerRecommend = $this->getPostParamString('evaReportChillerPlantChillerRecommend');
                $txnEvaReportChillerPlantChillerPass = $this->getPostParamString('evaReportChillerPlantChillerPass');
                $txnEvaReportChillerPlantSupplementYesNo = $this->getPostParamString('evaReportChillerPlantSupplementYesNo');
                $txnEvaReportChillerPlantSupplement = $this->getPostParamString('evaReportChillerPlantSupplement');
                $txnEvaReportChillerPlantSupplementPass = $this->getPostParamString('evaReportChillerPlantSupplementPass');
                $txnEvaReportEscalatorYesNo = $this->getPostParamString('evaReportEscalatorYesNo');
                $txnEvaReportEscalatorBrakingSystemYesNo = $this->getPostParamString('evaReportEscalatorBrakingSystemYesNo');
                $txnEvaReportEscalatorBrakingSystemFinding = $this->getPostParamString('evaReportEscalatorBrakingSystemFinding');
                $txnEvaReportEscalatorBrakingSystemRecommend = $this->getPostParamString('evaReportEscalatorBrakingSystemRecommend');
                $txnEvaReportEscalatorBrakingSystemPass = $this->getPostParamString('evaReportEscalatorBrakingSystemPass');
                $txnEvaReportEscalatorControlYesNo = $this->getPostParamString('evaReportEscalatorControlYesNo');
                $txnEvaReportEscalatorControlFinding = $this->getPostParamString('evaReportEscalatorControlFinding');
                $txnEvaReportEscalatorControlRecommend = $this->getPostParamString('evaReportEscalatorControlRecommend');
                $txnEvaReportEscalatorControlPass = $this->getPostParamString('evaReportEscalatorControlPass');
                $txnEvaReportEscalatorSupplementYesNo = $this->getPostParamString('evaReportEscalatorSupplementYesNo');
                $txnEvaReportEscalatorSupplement = $this->getPostParamString('evaReportEscalatorSupplement');
                $txnEvaReportEscalatorSupplementPass = $this->getPostParamString('evaReportEscalatorSupplementPass');
                $txnEvaReportLiftYesNo = $this->getPostParamString('evaReportLiftYesNo');
                $txnEvaReportLiftOperationYesNo = $this->getPostParamString('evaReportLiftOperationYesNo');
                $txnEvaReportLiftOperationFinding = $this->getPostParamString('evaReportLiftOperationFinding');
                $txnEvaReportLiftOperationRecommend = $this->getPostParamString('evaReportLiftOperationRecommend');
                $txnEvaReportLiftOperationPass = $this->getPostParamString('evaReportLiftOperationPass');
                $txnEvaReportLiftMainSupplyYesNo = $this->getPostParamString('evaReportLiftMainSupplyYesNo');
                $txnEvaReportLiftMainSupplyFinding = $this->getPostParamString('evaReportLiftMainSupplyFinding');
                $txnEvaReportLiftMainSupplyRecommend = $this->getPostParamString('evaReportLiftMainSupplyRecommend');
                $txnEvaReportLiftMainSupplyPass = $this->getPostParamString('evaReportLiftMainSupplyPass');
                $txnEvaReportLiftSupplementYesNo = $this->getPostParamString('evaReportLiftSupplementYesNo');
                $txnEvaReportLiftSupplement = $this->getPostParamString('evaReportLiftSupplement');
                $txnEvaReportLiftSupplementPass = $this->getPostParamString('evaReportLiftSupplementPass');
                $txnEvaReportHidLampYesNo = $this->getPostParamString('evaReportHidLampYesNo');
                $txnEvaReportHidLampBallastYesNo = $this->getPostParamString('evaReportHidLampBallastYesNo');
                $txnEvaReportHidLampBallastFinding = $this->getPostParamString('evaReportHidLampBallastFinding');
                $txnEvaReportHidLampBallastRecommend = $this->getPostParamString('evaReportHidLampBallastRecommend');
                $txnEvaReportHidLampBallastPass = $this->getPostParamString('evaReportHidLampBallastPass');
                $txnEvaReportHidLampAddonProtectYesNo = $this->getPostParamString('evaReportHidLampAddonProtectYesNo');
                $txnEvaReportHidLampAddonProtectFinding = $this->getPostParamString('evaReportHidLampAddonProtectFinding');
                $txnEvaReportHidLampAddonProtectRecommend = $this->getPostParamString('evaReportHidLampAddonProtectRecommend');
                $txnEvaReportHidLampAddonProtectPass = $this->getPostParamString('evaReportHidLampAddonProtectPass');
                $txnEvaReportHidLampSupplementYesNo = $this->getPostParamString('evaReportHidLampSupplementYesNo');
                $txnEvaReportHidLampSupplement = $this->getPostParamString('evaReportHidLampSupplement');
                $txnEvaReportHidLampSupplementPass = $this->getPostParamString('evaReportHidLampSupplementPass');
                $txnEvaReportSensitiveMachineYesNo = $this->getPostParamString('evaReportSensitiveMachineYesNo');
                $txnEvaReportSensitiveMachineMedicalYesNo = $this->getPostParamString('evaReportSensitiveMachineMedicalYesNo');
                $txnEvaReportSensitiveMachineMedicalFinding = $this->getPostParamString('evaReportSensitiveMachineMedicalFinding');
                $txnEvaReportSensitiveMachineMedicalRecommend = $this->getPostParamString('evaReportSensitiveMachineMedicalRecommend');
                $txnEvaReportSensitiveMachineMedicalPass = $this->getPostParamString('evaReportSensitiveMachineMedicalPass');
                $txnEvaReportSensitiveMachineSupplementYesNo = $this->getPostParamString('evaReportSensitiveMachineSupplementYesNo');
                $txnEvaReportSensitiveMachineSupplement = $this->getPostParamString('evaReportSensitiveMachineSupplement');
                $txnEvaReportSensitiveMachineSupplementPass = $this->getPostParamString('evaReportSensitiveMachineSupplementPass');
                $txnEvaReportTelecomMachineYesNo = $this->getPostParamString('evaReportTelecomMachineYesNo');
                $txnEvaReportTelecomMachineServerOrComputerYesNo = $this->getPostParamString('evaReportTelecomMachineServerOrComputerYesNo');
                $txnEvaReportTelecomMachineServerOrComputerFinding = $this->getPostParamString('evaReportTelecomMachineServerOrComputerFinding');
                $txnEvaReportTelecomMachineServerOrComputerRecommend = $this->getPostParamString('evaReportTelecomMachineServerOrComputerRecommend');
                $txnEvaReportTelecomMachineServerOrComputerPass = $this->getPostParamString('evaReportTelecomMachineServerOrComputerPass');
                $txnEvaReportTelecomMachinePeripheralsYesNo = $this->getPostParamString('evaReportTelecomMachinePeripheralsYesNo');
                $txnEvaReportTelecomMachinePeripheralsFinding = $this->getPostParamString('evaReportTelecomMachinePeripheralsFinding');
                $txnEvaReportTelecomMachinePeripheralsRecommend = $this->getPostParamString('evaReportTelecomMachinePeripheralsRecommend');
                $txnEvaReportTelecomMachinePeripheralsPass = $this->getPostParamString('evaReportTelecomMachinePeripheralsPass');
                $txnEvaReportTelecomMachineHarmonicEmissionYesNo = $this->getPostParamString('evaReportTelecomMachineHarmonicEmissionYesNo');
                $txnEvaReportTelecomMachineHarmonicEmissionFinding = $this->getPostParamString('evaReportTelecomMachineHarmonicEmissionFinding');
                $txnEvaReportTelecomMachineHarmonicEmissionRecommend = $this->getPostParamString('evaReportTelecomMachineHarmonicEmissionRecommend');
                $txnEvaReportTelecomMachineHarmonicEmissionPass = $this->getPostParamString('evaReportTelecomMachineHarmonicEmissionPass');
                $txnEvaReportTelecomMachineSupplementYesNo = $this->getPostParamString('evaReportTelecomMachineSupplementYesNo');
                $txnEvaReportTelecomMachineSupplement = $this->getPostParamString('evaReportTelecomMachineSupplement');
                $txnEvaReportTelecomMachineSupplementPass = $this->getPostParamString('evaReportTelecomMachineSupplementPass');
                $txnEvaReportAirConditionersYesNo = $this->getPostParamString('evaReportAirConditionersYesNo');
                $txnEvaReportAirConditionersMicbYesNo = $this->getPostParamString('evaReportAirConditionersMicbYesNo');
                $txnEvaReportAirConditionersMicbFinding = $this->getPostParamString('evaReportAirConditionersMicbFinding');
                $txnEvaReportAirConditionersMicbRecommend = $this->getPostParamString('evaReportAirConditionersMicbRecommend');
                $txnEvaReportAirConditionersMicbPass = $this->getPostParamString('evaReportAirConditionersMicbPass');
                $txnEvaReportAirConditionersLoadForecastingYesNo = $this->getPostParamString('evaReportAirConditionersLoadForecastingYesNo');
                $txnEvaReportAirConditionersLoadForecastingFinding = $this->getPostParamString('evaReportAirConditionersLoadForecastingFinding');
                $txnEvaReportAirConditionersLoadForecastingRecommend = $this->getPostParamString('evaReportAirConditionersLoadForecastingRecommend');
                $txnEvaReportAirConditionersLoadForecastingPass = $this->getPostParamString('evaReportAirConditionersLoadForecastingPass');
                $txnEvaReportAirConditionersTypeYesNo = $this->getPostParamString('evaReportAirConditionersTypeYesNo');
                $txnEvaReportAirConditionersTypeFinding = $this->getPostParamString('evaReportAirConditionersTypeFinding');
                $txnEvaReportAirConditionersTypeRecommend = $this->getPostParamString('evaReportAirConditionersTypeRecommend');
                $txnEvaReportAirConditionersTypePass = $this->getPostParamString('evaReportAirConditionersTypePass');
                $txnEvaReportAirConditionersSupplementYesNo = $this->getPostParamString('evaReportAirConditionersSupplementYesNo');
                $txnEvaReportAirConditionersSupplement = $this->getPostParamString('evaReportAirConditionersSupplement');
                $txnEvaReportAirConditionersSupplementPass = $this->getPostParamString('evaReportAirConditionersSupplementPass');
                $txnEvaReportNonLinearLoadYesNo = $this->getPostParamString('evaReportNonLinearLoadYesNo');
                $txnEvaReportNonLinearLoadHarmonicEmissionYesNo = $this->getPostParamString('evaReportNonLinearLoadHarmonicEmissionYesNo');
                $txnEvaReportNonLinearLoadHarmonicEmissionFinding = $this->getPostParamString('evaReportNonLinearLoadHarmonicEmissionFinding');
                $txnEvaReportNonLinearLoadHarmonicEmissionRecommend = $this->getPostParamString('evaReportNonLinearLoadHarmonicEmissionRecommend');
                $txnEvaReportNonLinearLoadHarmonicEmissionPass = $this->getPostParamString('evaReportNonLinearLoadHarmonicEmissionPass');
                $txnEvaReportNonLinearLoadSupplementYesNo = $this->getPostParamString('evaReportNonLinearLoadSupplementYesNo');
                $txnEvaReportNonLinearLoadSupplement = $this->getPostParamString('evaReportNonLinearLoadSupplement');
                $txnEvaReportNonLinearLoadSupplementPass = $this->getPostParamString('evaReportNonLinearLoadSupplementPass');
                $txnEvaReportRenewableEnergyYesNo = $this->getPostParamString('evaReportRenewableEnergyYesNo');
                $txnEvaReportRenewableEnergyInverterAndControlsYesNo = $this->getPostParamString('evaReportRenewableEnergyInverterAndControlsYesNo');
                $txnEvaReportRenewableEnergyInverterAndControlsFinding = $this->getPostParamString('evaReportRenewableEnergyInverterAndControlsFinding');
                $txnEvaReportRenewableEnergyInverterAndControlsRecommend = $this->getPostParamString('evaReportRenewableEnergyInverterAndControlsRecommend');
                $txnEvaReportRenewableEnergyInverterAndControlsPass = $this->getPostParamString('evaReportRenewableEnergyInverterAndControlsPass');
                $txnEvaReportRenewableEnergyHarmonicEmissionYesNo = $this->getPostParamString('evaReportRenewableEnergyHarmonicEmissionYesNo');
                $txnEvaReportRenewableEnergyHarmonicEmissionFinding = $this->getPostParamString('evaReportRenewableEnergyHarmonicEmissionFinding');
                $txnEvaReportRenewableEnergyHarmonicEmissionRecommend = $this->getPostParamString('evaReportRenewableEnergyHarmonicEmissionRecommend');
                $txnEvaReportRenewableEnergyHarmonicEmissionPass = $this->getPostParamString('evaReportRenewableEnergyHarmonicEmissionPass');
                $txnEvaReportRenewableEnergySupplementYesNo = $this->getPostParamString('evaReportRenewableEnergySupplementYesNo');
                $txnEvaReportRenewableEnergySupplement = $this->getPostParamString('evaReportRenewableEnergySupplement');
                $txnEvaReportRenewableEnergySupplementPass = $this->getPostParamString('evaReportRenewableEnergySupplementPass');
                $txnEvaReportEvChargerSystemYesNo = $this->getPostParamString('evaReportEvChargerSystemYesNo');
                $txnEvaReportEvChargerSystemEvChargerYesNo = $this->getPostParamString('evaReportEvChargerSystemEvChargerYesNo');
                $txnEvaReportEvChargerSystemEvChargerFinding = $this->getPostParamString('evaReportEvChargerSystemEvChargerFinding');
                $txnEvaReportEvChargerSystemEvChargerRecommend = $this->getPostParamString('evaReportEvChargerSystemEvChargerRecommend');
                $txnEvaReportEvChargerSystemEvChargerPass = $this->getPostParamString('evaReportEvChargerSystemEvChargerPass');
                $txnEvaReportEvChargerSystemHarmonicEmissionYesNo = $this->getPostParamString('evaReportEvChargerSystemHarmonicEmissionYesNo');
                $txnEvaReportEvChargerSystemHarmonicEmissionFinding = $this->getPostParamString('evaReportEvChargerSystemHarmonicEmissionFinding');
                $txnEvaReportEvChargerSystemHarmonicEmissionRecommend = $this->getPostParamString('evaReportEvChargerSystemHarmonicEmissionRecommend');
                $txnEvaReportEvChargerSystemHarmonicEmissionPass = $this->getPostParamString('evaReportEvChargerSystemHarmonicEmissionPass');
                $txnEvaReportEvChargerSystemSupplementYesNo = $this->getPostParamString('evaReportEvChargerSystemSupplementYesNo');
                $txnEvaReportEvChargerSystemSupplement = $this->getPostParamString('evaReportEvChargerSystemSupplement');
                $txnEvaReportEvChargerSystemSupplementPass = $this->getPostParamString('evaReportEvChargerSystemSupplementPass');

                $txnReEvaReportId = $this->getPostParamString('reEvaReportId');
                $txnReEvaReportRemark = $this->getPostParamString('reEvaReportRemark');
                $txnReEvaReportEdmsLink = $this->getPostParamString('reEvaReportEdmsLink');
                $txnReEvaReportIssueDate = $this->getPostParamString('reEvaReportIssueDate');
                $txnReEvaReportFaxRefNo = $this->getPostParamString('reEvaReportFaxRefNo');
                $txnReEvaReportScore = $this->getPostParamString('reEvaReportScore');
                $txnReEvaReportBmsYesNo = $this->getPostParamString('reEvaReportBmsYesNo');
                $txnReEvaReportBmsServerCentralComputerYesNo = $this->getPostParamString('reEvaReportBmsServerCentralComputerYesNo');
                $txnReEvaReportBmsServerCentralComputerFinding = $this->getPostParamString('reEvaReportBmsServerCentralComputerFinding');
                $txnReEvaReportBmsServerCentralComputerRecommend = $this->getPostParamString('reEvaReportBmsServerCentralComputerRecommend');
                $txnReEvaReportBmsServerCentralComputerPass = $this->getPostParamString('reEvaReportBmsServerCentralComputerPass');
                $txnReEvaReportBmsDdcYesNo = $this->getPostParamString('reEvaReportBmsDdcYesNo');
                $txnReEvaReportBmsDdcFinding = $this->getPostParamString('reEvaReportBmsDdcFinding');
                $txnReEvaReportBmsDdcRecommend = $this->getPostParamString('reEvaReportBmsDdcRecommend');
                $txnReEvaReportBmsDdcPass = $this->getPostParamString('reEvaReportBmsDdcPass');
                $txnReEvaReportBmsSupplementYesNo = $this->getPostParamString('reEvaReportBmsSupplementYesNo');
                $txnReEvaReportBmsSupplement = $this->getPostParamString('reEvaReportBmsSupplement');
                $txnReEvaReportBmsSupplementPass = $this->getPostParamString('reEvaReportBmsSupplementPass');
                $txnReEvaReportChangeoverSchemeYesNo = $this->getPostParamString('reEvaReportChangeoverSchemeYesNo');
                $txnReEvaReportChangeoverSchemeControlYesNo = $this->getPostParamString('reEvaReportChangeoverSchemeControlYesNo');
                $txnReEvaReportChangeoverSchemeControlFinding = $this->getPostParamString('reEvaReportChangeoverSchemeControlFinding');
                $txnReEvaReportChangeoverSchemeControlRecommend = $this->getPostParamString('reEvaReportChangeoverSchemeControlRecommend');
                $txnReEvaReportChangeoverSchemeControlPass = $this->getPostParamString('reEvaReportChangeoverSchemeControlPass');
                $txnReEvaReportChangeoverSchemeUvYesNo = $this->getPostParamString('reEvaReportChangeoverSchemeUvYesNo');
                $txnReEvaReportChangeoverSchemeUvFinding = $this->getPostParamString('reEvaReportChangeoverSchemeUvFinding');
                $txnReEvaReportChangeoverSchemeUvRecommend = $this->getPostParamString('reEvaReportChangeoverSchemeUvRecommend');
                $txnReEvaReportChangeoverSchemeUvPass = $this->getPostParamString('reEvaReportChangeoverSchemeUvPass');
                $txnReEvaReportChangeoverSchemeSupplementYesNo = $this->getPostParamString('reEvaReportChangeoverSchemeSupplementYesNo');
                $txnReEvaReportChangeoverSchemeSupplement = $this->getPostParamString('reEvaReportChangeoverSchemeSupplement');
                $txnReEvaReportChangeoverSchemeSupplementPass = $this->getPostParamString('reEvaReportChangeoverSchemeSupplementPass');
                $txnReEvaReportChillerPlantYesNo = $this->getPostParamString('reEvaReportChillerPlantYesNo');
                $txnReEvaReportChillerPlantAhuChilledWaterYesNo = $this->getPostParamString('reEvaReportChillerPlantAhuChilledWaterYesNo');
                $txnReEvaReportChillerPlantAhuChilledWaterFinding = $this->getPostParamString('reEvaReportChillerPlantAhuChilledWaterFinding');
                $txnReEvaReportChillerPlantAhuChilledWaterRecommend = $this->getPostParamString('reEvaReportChillerPlantAhuChilledWaterRecommend');
                $txnReEvaReportChillerPlantAhuChilledWaterPass = $this->getPostParamString('reEvaReportChillerPlantAhuChilledWaterPass');
                $txnReEvaReportChillerPlantChillerYesNo = $this->getPostParamString('reEvaReportChillerPlantChillerYesNo');
                $txnReEvaReportChillerPlantChillerFinding = $this->getPostParamString('reEvaReportChillerPlantChillerFinding');
                $txnReEvaReportChillerPlantChillerRecommend = $this->getPostParamString('reEvaReportChillerPlantChillerRecommend');
                $txnReEvaReportChillerPlantChillerPass = $this->getPostParamString('reEvaReportChillerPlantChillerPass');
                $txnReEvaReportChillerPlantSupplementYesNo = $this->getPostParamString('reEvaReportChillerPlantSupplementYesNo');
                $txnReEvaReportChillerPlantSupplement = $this->getPostParamString('reEvaReportChillerPlantSupplement');
                $txnReEvaReportChillerPlantSupplementPass = $this->getPostParamString('reEvaReportChillerPlantSupplementPass');
                $txnReEvaReportEscalatorYesNo = $this->getPostParamString('reEvaReportEscalatorYesNo');
                $txnReEvaReportEscalatorBrakingSystemYesNo = $this->getPostParamString('reEvaReportEscalatorBrakingSystemYesNo');
                $txnReEvaReportEscalatorBrakingSystemFinding = $this->getPostParamString('reEvaReportEscalatorBrakingSystemFinding');
                $txnReEvaReportEscalatorBrakingSystemRecommend = $this->getPostParamString('reEvaReportEscalatorBrakingSystemRecommend');
                $txnReEvaReportEscalatorBrakingSystemPass = $this->getPostParamString('reEvaReportEscalatorBrakingSystemPass');
                $txnReEvaReportEscalatorControlYesNo = $this->getPostParamString('reEvaReportEscalatorControlYesNo');
                $txnReEvaReportEscalatorControlFinding = $this->getPostParamString('reEvaReportEscalatorControlFinding');
                $txnReEvaReportEscalatorControlRecommend = $this->getPostParamString('reEvaReportEscalatorControlRecommend');
                $txnReEvaReportEscalatorControlPass = $this->getPostParamString('reEvaReportEscalatorControlPass');
                $txnReEvaReportEscalatorSupplementYesNo = $this->getPostParamString('reEvaReportEscalatorSupplementYesNo');
                $txnReEvaReportEscalatorSupplement = $this->getPostParamString('reEvaReportEscalatorSupplement');
                $txnReEvaReportEscalatorSupplementPass = $this->getPostParamString('reEvaReportEscalatorSupplementPass');
                $txnReEvaReportLiftYesNo = $this->getPostParamString('reEvaReportLiftYesNo');
                $txnReEvaReportLiftOperationYesNo = $this->getPostParamString('reEvaReportLiftOperationYesNo');
                $txnReEvaReportLiftOperationFinding = $this->getPostParamString('reEvaReportLiftOperationFinding');
                $txnReEvaReportLiftOperationRecommend = $this->getPostParamString('reEvaReportLiftOperationRecommend');
                $txnReEvaReportLiftOperationPass = $this->getPostParamString('reEvaReportLiftOperationPass');
                $txnReEvaReportLiftMainSupplyYesNo = $this->getPostParamString('reEvaReportLiftMainSupplyYesNo');
                $txnReEvaReportLiftMainSupplyFinding = $this->getPostParamString('reEvaReportLiftMainSupplyFinding');
                $txnReEvaReportLiftMainSupplyRecommend = $this->getPostParamString('reEvaReportLiftMainSupplyRecommend');
                $txnReEvaReportLiftMainSupplyPass = $this->getPostParamString('reEvaReportLiftMainSupplyPass');
                $txnReEvaReportLiftSupplementYesNo = $this->getPostParamString('reEvaReportLiftSupplementYesNo');
                $txnReEvaReportLiftSupplement = $this->getPostParamString('reEvaReportLiftSupplement');
                $txnReEvaReportLiftSupplementPass = $this->getPostParamString('reEvaReportLiftSupplementPass');
                $txnReEvaReportHidLampYesNo = $this->getPostParamString('reEvaReportHidLampYesNo');
                $txnReEvaReportHidLampBallastYesNo = $this->getPostParamString('reEvaReportHidLampBallastYesNo');
                $txnReEvaReportHidLampBallastFinding = $this->getPostParamString('reEvaReportHidLampBallastFinding');
                $txnReEvaReportHidLampBallastRecommend = $this->getPostParamString('reEvaReportHidLampBallastRecommend');
                $txnReEvaReportHidLampBallastPass = $this->getPostParamString('reEvaReportHidLampBallastPass');
                $txnReEvaReportHidLampAddonProtectYesNo = $this->getPostParamString('reEvaReportHidLampAddonProtectYesNo');
                $txnReEvaReportHidLampAddonProtectFinding = $this->getPostParamString('reEvaReportHidLampAddonProtectFinding');
                $txnReEvaReportHidLampAddonProtectRecommend = $this->getPostParamString('reEvaReportHidLampAddonProtectRecommend');
                $txnReEvaReportHidLampAddonProtectPass = $this->getPostParamString('reEvaReportHidLampAddonProtectPass');
                $txnReEvaReportHidLampSupplementYesNo = $this->getPostParamString('reEvaReportHidLampSupplementYesNo');
                $txnReEvaReportHidLampSupplement = $this->getPostParamString('reEvaReportHidLampSupplement');
                $txnReEvaReportHidLampSupplementPass = $this->getPostParamString('reEvaReportHidLampSupplementPass');
                $txnReEvaReportSensitiveMachineYesNo = $this->getPostParamString('reEvaReportSensitiveMachineYesNo');
                $txnReEvaReportSensitiveMachineMedicalYesNo = $this->getPostParamString('reEvaReportSensitiveMachineMedicalYesNo');
                $txnReEvaReportSensitiveMachineMedicalFinding = $this->getPostParamString('reEvaReportSensitiveMachineMedicalFinding');
                $txnReEvaReportSensitiveMachineMedicalRecommend = $this->getPostParamString('reEvaReportSensitiveMachineMedicalRecommend');
                $txnReEvaReportSensitiveMachineMedicalPass = $this->getPostParamString('reEvaReportSensitiveMachineMedicalPass');
                $txnReEvaReportSensitiveMachineSupplementYesNo = $this->getPostParamString('reEvaReportSensitiveMachineSupplementYesNo');
                $txnReEvaReportSensitiveMachineSupplement = $this->getPostParamString('reEvaReportSensitiveMachineSupplement');
                $txnReEvaReportSensitiveMachineSupplementPass = $this->getPostParamString('reEvaReportSensitiveMachineSupplementPass');
                $txnReEvaReportTelecomMachineYesNo = $this->getPostParamString('reEvaReportTelecomMachineYesNo');
                $txnReEvaReportTelecomMachineServerOrComputerYesNo = $this->getPostParamString('reEvaReportTelecomMachineServerOrComputerYesNo');
                $txnReEvaReportTelecomMachineServerOrComputerFinding = $this->getPostParamString('reEvaReportTelecomMachineServerOrComputerFinding');
                $txnReEvaReportTelecomMachineServerOrComputerRecommend = $this->getPostParamString('reEvaReportTelecomMachineServerOrComputerRecommend');
                $txnReEvaReportTelecomMachineServerOrComputerPass = $this->getPostParamString('reEvaReportTelecomMachineServerOrComputerPass');
                $txnReEvaReportTelecomMachinePeripheralsYesNo = $this->getPostParamString('reEvaReportTelecomMachinePeripheralsYesNo');
                $txnReEvaReportTelecomMachinePeripheralsFinding = $this->getPostParamString('reEvaReportTelecomMachinePeripheralsFinding');
                $txnReEvaReportTelecomMachinePeripheralsRecommend = $this->getPostParamString('reEvaReportTelecomMachinePeripheralsRecommend');
                $txnReEvaReportTelecomMachinePeripheralsPass = $this->getPostParamString('reEvaReportTelecomMachinePeripheralsPass');
                $txnReEvaReportTelecomMachineHarmonicEmissionYesNo = $this->getPostParamString('reEvaReportTelecomMachineHarmonicEmissionYesNo');
                $txnReEvaReportTelecomMachineHarmonicEmissionFinding = $this->getPostParamString('reEvaReportTelecomMachineHarmonicEmissionFinding');
                $txnReEvaReportTelecomMachineHarmonicEmissionRecommend = $this->getPostParamString('reEvaReportTelecomMachineHarmonicEmissionRecommend');
                $txnReEvaReportTelecomMachineHarmonicEmissionPass = $this->getPostParamString('reEvaReportTelecomMachineHarmonicEmissionPass');
                $txnReEvaReportTelecomMachineSupplementYesNo = $this->getPostParamString('reEvaReportTelecomMachineSupplementYesNo');
                $txnReEvaReportTelecomMachineSupplement = $this->getPostParamString('reEvaReportTelecomMachineSupplement');
                $txnReEvaReportTelecomMachineSupplementPass = $this->getPostParamString('reEvaReportTelecomMachineSupplementPass');
                $txnReEvaReportAirConditionersYesNo = $this->getPostParamString('reEvaReportAirConditionersYesNo');
                $txnReEvaReportAirConditionersMicbYesNo = $this->getPostParamString('reEvaReportAirConditionersMicbYesNo');
                $txnReEvaReportAirConditionersMicbFinding = $this->getPostParamString('reEvaReportAirConditionersMicbFinding');
                $txnReEvaReportAirConditionersMicbRecommend = $this->getPostParamString('reEvaReportAirConditionersMicbRecommend');
                $txnReEvaReportAirConditionersMicbPass = $this->getPostParamString('reEvaReportAirConditionersMicbPass');
                $txnReEvaReportAirConditionersLoadForecastingYesNo = $this->getPostParamString('reEvaReportAirConditionersLoadForecastingYesNo');
                $txnReEvaReportAirConditionersLoadForecastingFinding = $this->getPostParamString('reEvaReportAirConditionersLoadForecastingFinding');
                $txnReEvaReportAirConditionersLoadForecastingRecommend = $this->getPostParamString('reEvaReportAirConditionersLoadForecastingRecommend');
                $txnReEvaReportAirConditionersLoadForecastingPass = $this->getPostParamString('reEvaReportAirConditionersLoadForecastingPass');
                $txnReEvaReportAirConditionersTypeYesNo = $this->getPostParamString('reEvaReportAirConditionersTypeYesNo');
                $txnReEvaReportAirConditionersTypeFinding = $this->getPostParamString('reEvaReportAirConditionersTypeFinding');
                $txnReEvaReportAirConditionersTypeRecommend = $this->getPostParamString('reEvaReportAirConditionersTypeRecommend');
                $txnReEvaReportAirConditionersTypePass = $this->getPostParamString('reEvaReportAirConditionersTypePass');
                $txnReEvaReportAirConditionersSupplementYesNo = $this->getPostParamString('reEvaReportAirConditionersSupplementYesNo');
                $txnReEvaReportAirConditionersSupplement = $this->getPostParamString('reEvaReportAirConditionersSupplement');
                $txnReEvaReportAirConditionersSupplementPass = $this->getPostParamString('reEvaReportAirConditionersSupplementPass');
                $txnReEvaReportNonLinearLoadYesNo = $this->getPostParamString('reEvaReportNonLinearLoadYesNo');
                $txnReEvaReportNonLinearLoadHarmonicEmissionYesNo = $this->getPostParamString('reEvaReportNonLinearLoadHarmonicEmissionYesNo');
                $txnReEvaReportNonLinearLoadHarmonicEmissionFinding = $this->getPostParamString('reEvaReportNonLinearLoadHarmonicEmissionFinding');
                $txnReEvaReportNonLinearLoadHarmonicEmissionRecommend = $this->getPostParamString('reEvaReportNonLinearLoadHarmonicEmissionRecommend');
                $txnReEvaReportNonLinearLoadHarmonicEmissionPass = $this->getPostParamString('reEvaReportNonLinearLoadHarmonicEmissionPass');
                $txnReEvaReportNonLinearLoadSupplementYesNo = $this->getPostParamString('reEvaReportNonLinearLoadSupplementYesNo');
                $txnReEvaReportNonLinearLoadSupplement = $this->getPostParamString('reEvaReportNonLinearLoadSupplement');
                $txnReEvaReportNonLinearLoadSupplementPass = $this->getPostParamString('reEvaReportNonLinearLoadSupplementPass');
                $txnReEvaReportRenewableEnergyYesNo = $this->getPostParamString('reEvaReportRenewableEnergyYesNo');
                $txnReEvaReportRenewableEnergyInverterAndControlsYesNo = $this->getPostParamString('reEvaReportRenewableEnergyInverterAndControlsYesNo');
                $txnReEvaReportRenewableEnergyInverterAndControlsFinding = $this->getPostParamString('reEvaReportRenewableEnergyInverterAndControlsFinding');
                $txnReEvaReportRenewableEnergyInverterAndControlsRecommend = $this->getPostParamString('reEvaReportRenewableEnergyInverterAndControlsRecommend');
                $txnReEvaReportRenewableEnergyInverterAndControlsPass = $this->getPostParamString('reEvaReportRenewableEnergyInverterAndControlsPass');
                $txnReEvaReportRenewableEnergyHarmonicEmissionYesNo = $this->getPostParamString('reEvaReportRenewableEnergyHarmonicEmissionYesNo');
                $txnReEvaReportRenewableEnergyHarmonicEmissionFinding = $this->getPostParamString('reEvaReportRenewableEnergyHarmonicEmissionFinding');
                $txnReEvaReportRenewableEnergyHarmonicEmissionRecommend = $this->getPostParamString('reEvaReportRenewableEnergyHarmonicEmissionRecommend');
                $txnReEvaReportRenewableEnergyHarmonicEmissionPass = $this->getPostParamString('reEvaReportRenewableEnergyHarmonicEmissionPass');
                $txnReEvaReportRenewableEnergySupplementYesNo = $this->getPostParamString('reEvaReportRenewableEnergySupplementYesNo');
                $txnReEvaReportRenewableEnergySupplement = $this->getPostParamString('reEvaReportRenewableEnergySupplement');
                $txnReEvaReportRenewableEnergySupplementPass = $this->getPostParamString('reEvaReportRenewableEnergySupplementPass');
                $txnReEvaReportEvChargerSystemYesNo = $this->getPostParamString('reEvaReportEvChargerSystemYesNo');
                $txnReEvaReportEvChargerSystemEvChargerYesNo = $this->getPostParamString('reEvaReportEvChargerSystemEvChargerYesNo');
                $txnReEvaReportEvChargerSystemEvChargerFinding = $this->getPostParamString('reEvaReportEvChargerSystemEvChargerFinding');
                $txnReEvaReportEvChargerSystemEvChargerRecommend = $this->getPostParamString('reEvaReportEvChargerSystemEvChargerRecommend');
                $txnReEvaReportEvChargerSystemEvChargerPass = $this->getPostParamString('reEvaReportEvChargerSystemEvChargerPass');
                $txnReEvaReportEvChargerSystemHarmonicEmissionYesNo = $this->getPostParamString('reEvaReportEvChargerSystemHarmonicEmissionYesNo');
                $txnReEvaReportEvChargerSystemHarmonicEmissionFinding = $this->getPostParamString('reEvaReportEvChargerSystemHarmonicEmissionFinding');
                $txnReEvaReportEvChargerSystemHarmonicEmissionRecommend = $this->getPostParamString('reEvaReportEvChargerSystemHarmonicEmissionRecommend');
                $txnReEvaReportEvChargerSystemHarmonicEmissionPass = $this->getPostParamString('reEvaReportEvChargerSystemHarmonicEmissionPass');
                $txnReEvaReportEvChargerSystemSupplementYesNo = $this->getPostParamString('reEvaReportEvChargerSystemSupplementYesNo');
                $txnReEvaReportEvChargerSystemSupplement = $this->getPostParamString('reEvaReportEvChargerSystemSupplement');
                $txnReEvaReportEvChargerSystemSupplementPass = $this->getPostParamString('reEvaReportEvChargerSystemSupplementPass');

                $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
                $lastUpdatedTime = date("Y-m-d H:i");

                $retJson = Yii::app()->planningAheadDao->updatePlanningAheadDetailDraft(
                    $txnProjectTitle,$txnSchemeNo,$txnRegion,
                    $txnTypeOfProject,$txnCommissionDate,$txnKeyInfra,$txnTempProj,
                    $txnFirstRegionStaffName,$txnFirstRegionStaffPhone,$txnFirstRegionStaffEmail,
                    $txnSecondRegionStaffName,$txnSecondRegionStaffPhone,$txnSecondRegionStaffEmail,
                    $txnThirdRegionStaffName,$txnThirdRegionStaffPhone,$txnThirdRegionStaffEmail,
                    $txnFirstConsultantTitle,$txnFirstConsultantSurname,$txnFirstConsultantOtherName,
                    $txnFirstConsultantCompany,$txnFirstConsultantPhone,$txnFirstConsultantEmail,
                    $txnSecondConsultantTitle,$txnSecondConsultantSurname,$txnSecondConsultantOtherName,
                    $txnSecondConsultantCompany,$txnSecondConsultantPhone,$txnSecondConsultantEmail,
                    $txnThirdConsultantTitle,$txnThirdConsultantSurname,$txnThirdConsultantOtherName,
                    $txnThirdConsultantCompany,$txnThirdConsultantPhone,$txnThirdConsultantEmail,
                    $txnFirstProjectOwnerTitle,$txnFirstProjectOwnerSurname,$txnFirstProjectOwnerOtherName,
                    $txnFirstProjectOwnerCompany,$txnFirstProjectOwnerPhone,$txnFirstProjectOwnerEmail,
                    $txnSecondProjectOwnerTitle,$txnSecondProjectOwnerSurname,$txnSecondProjectOwnerOtherName,
                    $txnSecondProjectOwnerCompany,$txnSecondProjectOwnerPhone,$txnSecondProjectOwnerEmail,
                    $txnThirdProjectOwnerTitle,$txnThirdProjectOwnerSurname,$txnThirdProjectOwnerOtherName,
                    $txnThirdProjectOwnerCompany,$txnThirdProjectOwnerPhone,$txnThirdProjectOwnerEmail,
                    $txnStandLetterIssueDate,$txnStandLetterFaxRefNo,$txnStandLetterEdmsLink,
                    $txnStandLetterLetterLoc,$txnMeetingFirstPreferMeetingDate,$txnMeetingSecondPreferMeetingDate,
                    $txnMeetingActualMeetingDate,$txnMeetingRejReason,$txnMeetingConsentConsultant,$txnMeetingRemark,
                    $txnMeetingConsentOwner,$txnMeetingReplySlipId,
                    $txnReplySlipBmsYesNo,$txnReplySlipBmsServerCentralComputer,
                    $txnReplySlipBmsDdc,$txnReplySlipChangeoverSchemeYesNo,$txnReplySlipChangeoverSchemeControl,
                    $txnReplySlipChangeoverSchemeUv,$txnReplySlipChillerPlantYesNo,$txnReplySlipChillerPlantAhuControl,
                    $txnReplySlipChillerPlantAhuStartup,$txnReplySlipChillerPlantVsd,$txnReplySlipChillerPlantAhuChilledWater,
                    $txnReplySlipChillerPlantStandbyAhu,$txnReplySlipChillerPlantChiller,$txnReplySlipEscalatorYesNo,
                    $txnReplySlipEscalatorMotorStartup,$txnReplySlipEscalatorVsdMitigation,$txnReplySlipEscalatorBrakingSystem,
                    $txnReplySlipEscalatorControl,$txnReplySlipHidLampYesNo,$txnReplySlipHidLampMitigation,
                    $txnReplySlipLiftYesNo,$txnReplySlipLiftOperation,
                    $txnReplySlipSensitiveMachineYesNo,$txnReplySlipSensitiveMachineMitigation,
                    $txnReplySlipTelecomMachineYesNo,$txnReplySlipTelecomMachineServerOrComputer,
                    $txnReplySlipTelecomMachinePeripherals,$txnReplySlipTelecomMachineHarmonicEmission,
                    $txnReplySlipAirConditionersYesNo,$txnReplySlipAirConditionersMicb,
                    $txnReplySlipAirConditionersLoadForecasting,$txnReplySlipAirConditionersType,
                    $txnReplySlipNonLinearLoadYesNo,$txnReplySlipNonLinearLoadHarmonicEmission,
                    $txnReplySlipRenewableEnergyYesNo,$txnReplySlipRenewableEnergyInverterAndControls,
                    $txnReplySlipRenewableEnergyHarmonicEmission,$txnReplySlipEvChargerSystemYesNo,$txnReplySlipEvControlYesNo,
                    $txnReplySlipEvChargerSystemEvCharger,$txnReplySlipEvChargerSystemSmartYesNo,
                    $txnReplySlipEvChargerSystemSmartChargingSystem,$txnReplySlipEvChargerSystemHarmonicEmission,
                    $txnReplySlipConsultantNameConfirmation,$txnReplySlipConsultantCompany,
                    $txnReplySlipProjectOwnerNameConfirmation,$txnReplySlipProjectOwnerCompany,
                    $txnFirstInvitationLetterIssueDate,
                    $txnFirstInvitationLetterFaxRefNo,$txnFirstInvitationLetterEdmsLink,
                    $txnFirstInvitationLetterAccept,$txnFirstInvitationLetterWalkDate,
                    $txnSecondInvitationLetterIssueDate,
                    $txnSecondInvitationLetterFaxRefNo,$txnSecondInvitationLetterEdmsLink,
                    $txnSecondInvitationLetterAccept,$txnSecondInvitationLetterWalkDate,
                    $txnThirdInvitationLetterIssueDate,
                    $txnThirdInvitationLetterFaxRefNo,$txnThirdInvitationLetterEdmsLink,
                    $txnThirdInvitationLetterAccept,$txnThirdInvitationLetterWalkDate,
                    $txnForthInvitationLetterIssueDate,
                    $txnForthInvitationLetterFaxRefNo,$txnForthInvitationLetterEdmsLink,
                    $txnForthInvitationLetterAccept,$txnForthInvitationLetterWalkDate,
                    $txnEvaReportId,$txnEvaReportRemark,$txnEvaReportEdmsLink,$txnEvaReportIssueDate,$txnEvaReportFaxRefNo,
                    $txnEvaReportScore,$txnEvaReportBmsYesNo,$txnEvaReportBmsServerCentralComputerYesNo,
                    $txnEvaReportBmsServerCentralComputerFinding,$txnEvaReportBmsServerCentralComputerRecommend,
                    $txnEvaReportBmsServerCentralComputerPass,$txnEvaReportBmsDdcYesNo,$txnEvaReportBmsDdcFinding,
                    $txnEvaReportBmsDdcRecommend,$txnEvaReportBmsDdcPass,$txnEvaReportBmsSupplementYesNo,
                    $txnEvaReportBmsSupplement,$txnEvaReportBmsSupplementPass,$txnEvaReportChangeoverSchemeYesNo,
                    $txnEvaReportChangeoverSchemeControlYesNo,$txnEvaReportChangeoverSchemeControlFinding,
                    $txnEvaReportChangeoverSchemeControlRecommend,$txnEvaReportChangeoverSchemeControlPass,
                    $txnEvaReportChangeoverSchemeUvYesNo,$txnEvaReportChangeoverSchemeUvFinding,
                    $txnEvaReportChangeoverSchemeUvRecommend,$txnEvaReportChangeoverSchemeUvPass,
                    $txnEvaReportChangeoverSchemeSupplementYesNo,$txnEvaReportChangeoverSchemeSupplement,
                    $txnEvaReportChangeoverSchemeSupplementPass,$txnEvaReportChillerPlantYesNo,
                    $txnEvaReportChillerPlantAhuChilledWaterYesNo,$txnEvaReportChillerPlantAhuChilledWaterFinding,
                    $txnEvaReportChillerPlantAhuChilledWaterRecommend,$txnEvaReportChillerPlantAhuChilledWaterPass,
                    $txnEvaReportChillerPlantChillerYesNo,$txnEvaReportChillerPlantChillerFinding,
                    $txnEvaReportChillerPlantChillerRecommend,$txnEvaReportChillerPlantChillerPass,
                    $txnEvaReportChillerPlantSupplementYesNo,$txnEvaReportChillerPlantSupplement,
                    $txnEvaReportChillerPlantSupplementPass,$txnEvaReportEscalatorYesNo,$txnEvaReportEscalatorBrakingSystemYesNo,
                    $txnEvaReportEscalatorBrakingSystemFinding,$txnEvaReportEscalatorBrakingSystemRecommend,
                    $txnEvaReportEscalatorBrakingSystemPass,$txnEvaReportEscalatorControlYesNo,$txnEvaReportEscalatorControlFinding,
                    $txnEvaReportEscalatorControlRecommend,$txnEvaReportEscalatorControlPass,$txnEvaReportEscalatorSupplementYesNo,
                    $txnEvaReportEscalatorSupplement,$txnEvaReportEscalatorSupplementPass,$txnEvaReportLiftYesNo,
                    $txnEvaReportLiftOperationYesNo,$txnEvaReportLiftOperationFinding,$txnEvaReportLiftOperationRecommend,
                    $txnEvaReportLiftOperationPass,$txnEvaReportLiftMainSupplyYesNo,$txnEvaReportLiftMainSupplyFinding,
                    $txnEvaReportLiftMainSupplyRecommend,$txnEvaReportLiftMainSupplyPass,$txnEvaReportLiftSupplementYesNo,
                    $txnEvaReportLiftSupplement,$txnEvaReportLiftSupplementPass,$txnEvaReportHidLampYesNo,
                    $txnEvaReportHidLampBallastYesNo,$txnEvaReportHidLampBallastFinding,$txnEvaReportHidLampBallastRecommend,
                    $txnEvaReportHidLampBallastPass,$txnEvaReportHidLampAddonProtectYesNo,$txnEvaReportHidLampAddonProtectFinding,
                    $txnEvaReportHidLampAddonProtectRecommend,$txnEvaReportHidLampAddonProtectPass,
                    $txnEvaReportHidLampSupplementYesNo,$txnEvaReportHidLampSupplement,$txnEvaReportHidLampSupplementPass,
                    $txnEvaReportSensitiveMachineYesNo,$txnEvaReportSensitiveMachineMedicalYesNo,
                    $txnEvaReportSensitiveMachineMedicalFinding,$txnEvaReportSensitiveMachineMedicalRecommend,
                    $txnEvaReportSensitiveMachineMedicalPass,$txnEvaReportSensitiveMachineSupplementYesNo,
                    $txnEvaReportSensitiveMachineSupplement,$txnEvaReportSensitiveMachineSupplementPass,$txnEvaReportTelecomMachineYesNo,
                    $txnEvaReportTelecomMachineServerOrComputerYesNo,$txnEvaReportTelecomMachineServerOrComputerFinding,
                    $txnEvaReportTelecomMachineServerOrComputerRecommend,$txnEvaReportTelecomMachineServerOrComputerPass,
                    $txnEvaReportTelecomMachinePeripheralsYesNo,$txnEvaReportTelecomMachinePeripheralsFinding,
                    $txnEvaReportTelecomMachinePeripheralsRecommend,$txnEvaReportTelecomMachinePeripheralsPass,
                    $txnEvaReportTelecomMachineHarmonicEmissionYesNo,$txnEvaReportTelecomMachineHarmonicEmissionFinding,
                    $txnEvaReportTelecomMachineHarmonicEmissionRecommend,$txnEvaReportTelecomMachineHarmonicEmissionPass,
                    $txnEvaReportTelecomMachineSupplementYesNo,$txnEvaReportTelecomMachineSupplement,
                    $txnEvaReportTelecomMachineSupplementPass,$txnEvaReportAirConditionersYesNo,$txnEvaReportAirConditionersMicbYesNo,
                    $txnEvaReportAirConditionersMicbFinding,$txnEvaReportAirConditionersMicbRecommend,$txnEvaReportAirConditionersMicbPass,
                    $txnEvaReportAirConditionersLoadForecastingYesNo,$txnEvaReportAirConditionersLoadForecastingFinding,
                    $txnEvaReportAirConditionersLoadForecastingRecommend,$txnEvaReportAirConditionersLoadForecastingPass,
                    $txnEvaReportAirConditionersTypeYesNo,$txnEvaReportAirConditionersTypeFinding,$txnEvaReportAirConditionersTypeRecommend,
                    $txnEvaReportAirConditionersTypePass,$txnEvaReportAirConditionersSupplementYesNo,$txnEvaReportAirConditionersSupplement,
                    $txnEvaReportAirConditionersSupplementPass,$txnEvaReportNonLinearLoadYesNo,$txnEvaReportNonLinearLoadHarmonicEmissionYesNo,
                    $txnEvaReportNonLinearLoadHarmonicEmissionFinding,$txnEvaReportNonLinearLoadHarmonicEmissionRecommend,
                    $txnEvaReportNonLinearLoadHarmonicEmissionPass,$txnEvaReportNonLinearLoadSupplementYesNo,
                    $txnEvaReportNonLinearLoadSupplement,$txnEvaReportNonLinearLoadSupplementPass,$txnEvaReportRenewableEnergyYesNo,
                    $txnEvaReportRenewableEnergyInverterAndControlsYesNo,$txnEvaReportRenewableEnergyInverterAndControlsFinding,
                    $txnEvaReportRenewableEnergyInverterAndControlsRecommend,$txnEvaReportRenewableEnergyInverterAndControlsPass,
                    $txnEvaReportRenewableEnergyHarmonicEmissionYesNo,$txnEvaReportRenewableEnergyHarmonicEmissionFinding,
                    $txnEvaReportRenewableEnergyHarmonicEmissionRecommend,$txnEvaReportRenewableEnergyHarmonicEmissionPass,
                    $txnEvaReportRenewableEnergySupplementYesNo,$txnEvaReportRenewableEnergySupplement,
                    $txnEvaReportRenewableEnergySupplementPass,$txnEvaReportEvChargerSystemYesNo,$txnEvaReportEvChargerSystemEvChargerYesNo,
                    $txnEvaReportEvChargerSystemEvChargerFinding,$txnEvaReportEvChargerSystemEvChargerRecommend,
                    $txnEvaReportEvChargerSystemEvChargerPass,$txnEvaReportEvChargerSystemHarmonicEmissionYesNo,
                    $txnEvaReportEvChargerSystemHarmonicEmissionFinding,$txnEvaReportEvChargerSystemHarmonicEmissionRecommend,
                    $txnEvaReportEvChargerSystemHarmonicEmissionPass,$txnEvaReportEvChargerSystemSupplementYesNo,
                    $txnEvaReportEvChargerSystemSupplement,$txnEvaReportEvChargerSystemSupplementPass,
                    $txnReEvaReportId,$txnReEvaReportRemark,$txnReEvaReportEdmsLink,$txnReEvaReportIssueDate,$txnReEvaReportFaxRefNo,
                    $txnReEvaReportScore,$txnReEvaReportBmsYesNo,$txnReEvaReportBmsServerCentralComputerYesNo,
                    $txnReEvaReportBmsServerCentralComputerFinding,$txnReEvaReportBmsServerCentralComputerRecommend,
                    $txnReEvaReportBmsServerCentralComputerPass,$txnReEvaReportBmsDdcYesNo,$txnReEvaReportBmsDdcFinding,
                    $txnReEvaReportBmsDdcRecommend,$txnReEvaReportBmsDdcPass,$txnReEvaReportBmsSupplementYesNo,
                    $txnReEvaReportBmsSupplement,$txnReEvaReportBmsSupplementPass,$txnReEvaReportChangeoverSchemeYesNo,
                    $txnReEvaReportChangeoverSchemeControlYesNo,$txnReEvaReportChangeoverSchemeControlFinding,
                    $txnReEvaReportChangeoverSchemeControlRecommend,$txnReEvaReportChangeoverSchemeControlPass,
                    $txnReEvaReportChangeoverSchemeUvYesNo,$txnReEvaReportChangeoverSchemeUvFinding,
                    $txnReEvaReportChangeoverSchemeUvRecommend,$txnReEvaReportChangeoverSchemeUvPass,
                    $txnReEvaReportChangeoverSchemeSupplementYesNo,$txnReEvaReportChangeoverSchemeSupplement,
                    $txnReEvaReportChangeoverSchemeSupplementPass,$txnReEvaReportChillerPlantYesNo,
                    $txnReEvaReportChillerPlantAhuChilledWaterYesNo,$txnReEvaReportChillerPlantAhuChilledWaterFinding,
                    $txnReEvaReportChillerPlantAhuChilledWaterRecommend,$txnReEvaReportChillerPlantAhuChilledWaterPass,
                    $txnReEvaReportChillerPlantChillerYesNo,$txnReEvaReportChillerPlantChillerFinding,
                    $txnReEvaReportChillerPlantChillerRecommend,$txnReEvaReportChillerPlantChillerPass,
                    $txnReEvaReportChillerPlantSupplementYesNo,$txnReEvaReportChillerPlantSupplement,
                    $txnReEvaReportChillerPlantSupplementPass,$txnReEvaReportEscalatorYesNo,$txnReEvaReportEscalatorBrakingSystemYesNo,
                    $txnReEvaReportEscalatorBrakingSystemFinding,$txnReEvaReportEscalatorBrakingSystemRecommend,
                    $txnReEvaReportEscalatorBrakingSystemPass,$txnReEvaReportEscalatorControlYesNo,$txnReEvaReportEscalatorControlFinding,
                    $txnReEvaReportEscalatorControlRecommend,$txnReEvaReportEscalatorControlPass,$txnReEvaReportEscalatorSupplementYesNo,
                    $txnReEvaReportEscalatorSupplement,$txnReEvaReportEscalatorSupplementPass,$txnReEvaReportLiftYesNo,
                    $txnReEvaReportLiftOperationYesNo,$txnReEvaReportLiftOperationFinding,$txnReEvaReportLiftOperationRecommend,
                    $txnReEvaReportLiftOperationPass,$txnReEvaReportLiftMainSupplyYesNo,$txnReEvaReportLiftMainSupplyFinding,
                    $txnReEvaReportLiftMainSupplyRecommend,$txnReEvaReportLiftMainSupplyPass,$txnReEvaReportLiftSupplementYesNo,
                    $txnReEvaReportLiftSupplement,$txnReEvaReportLiftSupplementPass,$txnReEvaReportHidLampYesNo,
                    $txnReEvaReportHidLampBallastYesNo,$txnReEvaReportHidLampBallastFinding,$txnReEvaReportHidLampBallastRecommend,
                    $txnReEvaReportHidLampBallastPass,$txnReEvaReportHidLampAddonProtectYesNo,$txnReEvaReportHidLampAddonProtectFinding,
                    $txnReEvaReportHidLampAddonProtectRecommend,$txnReEvaReportHidLampAddonProtectPass,
                    $txnReEvaReportHidLampSupplementYesNo,$txnReEvaReportHidLampSupplement,$txnReEvaReportHidLampSupplementPass,
                    $txnReEvaReportSensitiveMachineYesNo,$txnReEvaReportSensitiveMachineMedicalYesNo,
                    $txnReEvaReportSensitiveMachineMedicalFinding,$txnReEvaReportSensitiveMachineMedicalRecommend,
                    $txnReEvaReportSensitiveMachineMedicalPass,$txnReEvaReportSensitiveMachineSupplementYesNo,
                    $txnReEvaReportSensitiveMachineSupplement,$txnReEvaReportSensitiveMachineSupplementPass,$txnReEvaReportTelecomMachineYesNo,
                    $txnReEvaReportTelecomMachineServerOrComputerYesNo,$txnReEvaReportTelecomMachineServerOrComputerFinding,
                    $txnReEvaReportTelecomMachineServerOrComputerRecommend,$txnReEvaReportTelecomMachineServerOrComputerPass,
                    $txnReEvaReportTelecomMachinePeripheralsYesNo,$txnReEvaReportTelecomMachinePeripheralsFinding,
                    $txnReEvaReportTelecomMachinePeripheralsRecommend,$txnReEvaReportTelecomMachinePeripheralsPass,
                    $txnReEvaReportTelecomMachineHarmonicEmissionYesNo,$txnReEvaReportTelecomMachineHarmonicEmissionFinding,
                    $txnReEvaReportTelecomMachineHarmonicEmissionRecommend,$txnReEvaReportTelecomMachineHarmonicEmissionPass,
                    $txnReEvaReportTelecomMachineSupplementYesNo,$txnReEvaReportTelecomMachineSupplement,
                    $txnReEvaReportTelecomMachineSupplementPass,$txnReEvaReportAirConditionersYesNo,$txnReEvaReportAirConditionersMicbYesNo,
                    $txnReEvaReportAirConditionersMicbFinding,$txnReEvaReportAirConditionersMicbRecommend,$txnReEvaReportAirConditionersMicbPass,
                    $txnReEvaReportAirConditionersLoadForecastingYesNo,$txnReEvaReportAirConditionersLoadForecastingFinding,
                    $txnReEvaReportAirConditionersLoadForecastingRecommend,$txnReEvaReportAirConditionersLoadForecastingPass,
                    $txnReEvaReportAirConditionersTypeYesNo,$txnReEvaReportAirConditionersTypeFinding,$txnReEvaReportAirConditionersTypeRecommend,
                    $txnReEvaReportAirConditionersTypePass,$txnReEvaReportAirConditionersSupplementYesNo,$txnReEvaReportAirConditionersSupplement,
                    $txnReEvaReportAirConditionersSupplementPass,$txnReEvaReportNonLinearLoadYesNo,$txnReEvaReportNonLinearLoadHarmonicEmissionYesNo,
                    $txnReEvaReportNonLinearLoadHarmonicEmissionFinding,$txnReEvaReportNonLinearLoadHarmonicEmissionRecommend,
                    $txnReEvaReportNonLinearLoadHarmonicEmissionPass,$txnReEvaReportNonLinearLoadSupplementYesNo,
                    $txnReEvaReportNonLinearLoadSupplement,$txnReEvaReportNonLinearLoadSupplementPass,$txnReEvaReportRenewableEnergyYesNo,
                    $txnReEvaReportRenewableEnergyInverterAndControlsYesNo,$txnReEvaReportRenewableEnergyInverterAndControlsFinding,
                    $txnReEvaReportRenewableEnergyInverterAndControlsRecommend,$txnReEvaReportRenewableEnergyInverterAndControlsPass,
                    $txnReEvaReportRenewableEnergyHarmonicEmissionYesNo,$txnReEvaReportRenewableEnergyHarmonicEmissionFinding,
                    $txnReEvaReportRenewableEnergyHarmonicEmissionRecommend,$txnReEvaReportRenewableEnergyHarmonicEmissionPass,
                    $txnReEvaReportRenewableEnergySupplementYesNo,$txnReEvaReportRenewableEnergySupplement,
                    $txnReEvaReportRenewableEnergySupplementPass,$txnReEvaReportEvChargerSystemYesNo,$txnReEvaReportEvChargerSystemEvChargerYesNo,
                    $txnReEvaReportEvChargerSystemEvChargerFinding,$txnReEvaReportEvChargerSystemEvChargerRecommend,
                    $txnReEvaReportEvChargerSystemEvChargerPass,$txnReEvaReportEvChargerSystemHarmonicEmissionYesNo,
                    $txnReEvaReportEvChargerSystemHarmonicEmissionFinding,$txnReEvaReportEvChargerSystemHarmonicEmissionRecommend,
                    $txnReEvaReportEvChargerSystemHarmonicEmissionPass,$txnReEvaReportEvChargerSystemSupplementYesNo,
                    $txnReEvaReportEvChargerSystemSupplement,$txnReEvaReportEvChargerSystemSupplementPass,
                    $txnState,$lastUpdatedBy,$lastUpdatedTime,$txnPlanningAheadId);

                $retJson['status'] = 'OK';
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

        if ($success) {
            $txnTypeOfProject = $this->getPostParamInteger('typeOfProject');
            $txnCommissionDate = $this->getPostParamString('commissionDate');
            $txnKeyInfra = $this->getPostParamString('infraOpt');
            $txnTempProj = $this->getPostParamString('tempProjOpt');
            $txnFirstRegionStaffName = $this->getPostParamString('firstRegionStaffName');
            $txnFirstRegionStaffPhone = $this->getPostParamString('firstRegionStaffPhone');
            $txnFirstRegionStaffEmail = $this->getPostParamString('firstRegionStaffEmail');
            $txnSecondRegionStaffName = $this->getPostParamString('secondRegionStaffName');
            $txnSecondRegionStaffPhone = $this->getPostParamString('secondRegionStaffPhone');
            $txnSecondRegionStaffEmail = $this->getPostParamString('secondRegionStaffEmail');
            $txnThirdRegionStaffName = $this->getPostParamString('thirdRegionStaffName');
            $txnThirdRegionStaffPhone = $this->getPostParamString('thirdRegionStaffPhone');
            $txnThirdRegionStaffEmail = $this->getPostParamString('thirdRegionStaffEmail');
            $txnFirstConsultantTitle = $this->getPostParamString('firstConsultantTitle');
            $txnFirstConsultantSurname = $this->getPostParamString('firstConsultantSurname');
            $txnFirstConsultantOtherName = $this->getPostParamString('firstConsultantOtherName');
            $txnFirstConsultantCompany = $this->getPostParamString('firstConsultantCompany');
            $txnFirstConsultantPhone = $this->getPostParamString('firstConsultantPhone');
            $txnFirstConsultantEmail = $this->getPostParamString('firstConsultantEmail');
            $txnSecondConsultantTitle = $this->getPostParamString('secondConsultantTitle');
            $txnSecondConsultantSurname = $this->getPostParamString('secondConsultantSurname');
            $txnSecondConsultantOtherName = $this->getPostParamString('secondConsultantOtherName');
            $txnSecondConsultantCompany = $this->getPostParamString('secondConsultantCompany');
            $txnSecondConsultantPhone = $this->getPostParamString('secondConsultantPhone');
            $txnSecondConsultantEmail = $this->getPostParamString('secondConsultantEmail');
            $txnThirdConsultantTitle = $this->getPostParamString('thirdConsultantTitle');
            $txnThirdConsultantSurname = $this->getPostParamString('thirdConsultantSurname');
            $txnThirdConsultantOtherName = $this->getPostParamString('thirdConsultantOtherName');
            $txnThirdConsultantCompany = $this->getPostParamString('thirdConsultantCompany');
            $txnThirdConsultantPhone = $this->getPostParamString('thirdConsultantPhone');
            $txnThirdConsultantEmail = $this->getPostParamString('thirdConsultantEmail');
            $txnFirstProjectOwnerTitle = $this->getPostParamString('firstProjectOwnerTitle');
            $txnFirstProjectOwnerSurname = $this->getPostParamString('firstProjectOwnerSurname');
            $txnFirstProjectOwnerOtherName = $this->getPostParamString('firstProjectOwnerOtherName');
            $txnFirstProjectOwnerCompany = $this->getPostParamString('firstProjectOwnerCompany');
            $txnFirstProjectOwnerPhone = $this->getPostParamString('firstProjectOwnerPhone');
            $txnFirstProjectOwnerEmail = $this->getPostParamString('firstProjectOwnerEmail');
            $txnSecondProjectOwnerTitle = $this->getPostParamString('secondProjectOwnerTitle');
            $txnSecondProjectOwnerSurname = $this->getPostParamString('secondProjectOwnerSurname');
            $txnSecondProjectOwnerOtherName = $this->getPostParamString('secondProjectOwnerOtherName');
            $txnSecondProjectOwnerCompany = $this->getPostParamString('secondProjectOwnerCompany');
            $txnSecondProjectOwnerPhone = $this->getPostParamString('secondProjectOwnerPhone');
            $txnSecondProjectOwnerEmail = $this->getPostParamString('secondProjectOwnerEmail');
            $txnThirdProjectOwnerTitle = $this->getPostParamString('thirdProjectOwnerTitle');
            $txnThirdProjectOwnerSurname = $this->getPostParamString('thirdProjectOwnerSurname');
            $txnThirdProjectOwnerOtherName = $this->getPostParamString('thirdProjectOwnerOtherName');
            $txnThirdProjectOwnerCompany = $this->getPostParamString('thirdProjectOwnerCompany');
            $txnThirdProjectOwnerPhone = $this->getPostParamString('thirdProjectOwnerPhone');
            $txnThirdProjectOwnerEmail = $this->getPostParamString('thirdProjectOwnerEmail');
            $txnStandLetterIssueDate = $this->getPostParamString('standLetterIssueDate');
            $txnStandLetterFaxRefNo = $this->getPostParamString('standLetterFaxRefNo');
            $txnStandLetterEdmsLink = $this->getPostParamString('standLetterEdmsLink');
            $txnStandLetterLetterLoc = $this->getPostParamString('standLetterLetterLoc');

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

            $txnMeetingFirstPreferMeetingDate = $this->getPostParamString('meetingFirstPreferMeetingDate');
            $txnMeetingSecondPreferMeetingDate = $this->getPostParamString('meetingSecondPreferMeetingDate');
            $txnMeetingActualMeetingDate = $this->getPostParamString('meetingActualMeetingDate');
            $txnMeetingRejReason = $this->getPostParamString('meetingRejReason');
            $txnMeetingConsentConsultant = $this->getPostParamBoolean('meetingConsentConsultant');
            $txnMeetingConsentOwner = $this->getPostParamBoolean('meetingConsentOwner');
            $txnMeetingRemark = $this->getPostParamString('meetingRemark');
            $txnMeetingReplySlipId = $this->getPostParamInteger('meetingReplySlipId');
            $txnReplySlipBmsYesNo = $this->getPostParamBoolean('replySlipBmsYesNo');
            $txnReplySlipBmsServerCentralComputer = $this->getPostParamString('replySlipBmsServerCentralComputer');
            $txnReplySlipBmsDdc = $this->getPostParamString('replySlipBmsDdc');
            $txnReplySlipChangeoverSchemeYesNo = $this->getPostParamBoolean('replySlipChangeoverSchemeYesNo');
            $txnReplySlipChangeoverSchemeControl = $this->getPostParamString('replySlipChangeoverSchemeControl');
            $txnReplySlipChangeoverSchemeUv = $this->getPostParamString('replySlipChangeoverSchemeUv');
            $txnReplySlipChillerPlantYesNo = $this->getPostParamBoolean('replySlipChillerPlantYesNo');
            $txnReplySlipChillerPlantAhuControl = $this->getPostParamString('replySlipChillerPlantAhuControl');
            $txnReplySlipChillerPlantAhuStartup = $this->getPostParamString('replySlipChillerPlantAhuStartup');
            $txnReplySlipChillerPlantVsd = $this->getPostParamString('replySlipChillerPlantVsd');
            $txnReplySlipChillerPlantAhuChilledWater = $this->getPostParamString('replySlipChillerPlantAhuChilledWater');
            $txnReplySlipChillerPlantStandbyAhu = $this->getPostParamString('replySlipChillerPlantStandbyAhu');
            $txnReplySlipChillerPlantChiller = $this->getPostParamString('replySlipChillerPlantChiller');
            $txnReplySlipEscalatorYesNo = $this->getPostParamBoolean('replySlipEscalatorYesNo');
            $txnReplySlipEscalatorMotorStartup = $this->getPostParamBoolean('replySlipEscalatorMotorStartup');
            $txnReplySlipEscalatorVsdMitigation = $this->getPostParamString('replySlipEscalatorVsdMitigation');
            $txnReplySlipEscalatorBrakingSystem = $this->getPostParamString('replySlipEscalatorBrakingSystem');
            $txnReplySlipEscalatorControl = $this->getPostParamString('replySlipEscalatorControl');
            $txnReplySlipHidLampYesNo = $this->getPostParamBoolean('replyHidLampYesNo');
            $txnReplySlipHidLampMitigation = $this->getPostParamString('replySlipHidLampMitigation');
            $txnReplySlipLiftYesNo = $this->getPostParamBoolean('replyLiftYesNo');
            $txnReplySlipLiftOperation = $this->getPostParamString('replySlipLiftOperation');
            $txnReplySlipSensitiveMachineYesNo = $this->getPostParamBoolean('replySlipSensitiveMachineYesNo');
            $txnReplySlipSensitiveMachineMitigation = $this->getPostParamString('replySlipSensitiveMachineMitigation');
            $txnReplySlipTelecomMachineYesNo = $this->getPostParamBoolean('replySlipTelecomMachineYesNo');
            $txnReplySlipTelecomMachineServerOrComputer = $this->getPostParamString('replySlipTelecomMachineServerOrComputer');
            $txnReplySlipTelecomMachinePeripherals = $this->getPostParamString('replySlipTelecomMachinePeripherals');
            $txnReplySlipTelecomMachineHarmonicEmission = $this->getPostParamString('replySlipTelecomMachineHarmonicEmission');
            $txnReplySlipAirConditionersYesNo = $this->getPostParamBoolean('replySlipAirConditionersYesNo');
            $txnReplySlipAirConditionersMicb = $this->getPostParamString('replySlipAirConditionersMicb');
            $txnReplySlipAirConditionersLoadForecasting = $this->getPostParamString('replySlipAirConditionersLoadForecasting');
            $txnReplySlipAirConditionersType = $this->getPostParamString('replySlipAirConditionersType');
            $txnReplySlipNonLinearLoadYesNo = $this->getPostParamBoolean('replySlipNonLinearLoadYesNo');
            $txnReplySlipNonLinearLoadHarmonicEmission = $this->getPostParamString('replySlipNonLinearLoadHarmonicEmission');
            $txnReplySlipRenewableEnergyYesNo = $this->getPostParamBoolean('replySlipRenewableEnergyYesNo');
            $txnReplySlipRenewableEnergyInverterAndControls = $this->getPostParamString('replySlipRenewableEnergyInverterAndControls');
            $txnReplySlipRenewableEnergyHarmonicEmission = $this->getPostParamString('replySlipRenewableEnergyHarmonicEmission');
            $txnReplySlipEvChargerSystemYesNo = $this->getPostParamBoolean('replySlipEvChargerSystemYesNo');
            $txnReplySlipEvControlYesNo = $this->getPostParamBoolean('replySlipEvControlYesNo');
            $txnReplySlipEvChargerSystemEvCharger = $this->getPostParamString('replySlipEvChargerSystemEvCharger');
            $txnReplySlipEvChargerSystemSmartYesNo = $this->getPostParamString('replySlipEvChargerSystemSmartYesNo');
            $txnReplySlipEvChargerSystemSmartChargingSystem = $this->getPostParamString('replySlipEvChargerSystemSmartChargingSystem');
            $txnReplySlipEvChargerSystemHarmonicEmission = $this->getPostParamString('replySlipEvChargerSystemHarmonicEmission');
            $txnReplySlipConsultantNameConfirmation = $this->getPostParamString('replySlipConsultantNameConfirmation');
            $txnReplySlipConsultantCompany = $this->getPostParamString('replySlipConsultantCompany');
            $txnReplySlipProjectOwnerNameConfirmation = $this->getPostParamString('replySlipProjectOwnerNameConfirmation');
            $txnReplySlipProjectOwnerCompany = $this->getPostParamString('replySlipProjectOwnerCompany');
            $txnFirstInvitationLetterIssueDate = $this->getPostParamString('firstInvitationLetterIssueDate');
            $txnFirstInvitationLetterFaxRefNo = $this->getPostParamString('firstInvitationLetterFaxRefNo');
            $txnFirstInvitationLetterEdmsLink = $this->getPostParamString('firstInvitationLetterEdmsLink');
            $txnFirstInvitationLetterAccept = $this->getPostParamString('firstInvitationLetterAccept');
            $txnFirstInvitationLetterWalkDate = $this->getPostParamString('firstInvitationLetterWalkDate');
            $txnSecondInvitationLetterIssueDate = $this->getPostParamString('secondInvitationLetterIssueDate');
            $txnSecondInvitationLetterFaxRefNo = $this->getPostParamString('secondInvitationLetterFaxRefNo');
            $txnSecondInvitationLetterEdmsLink = $this->getPostParamString('secondInvitationLetterEdmsLink');
            $txnSecondInvitationLetterAccept = $this->getPostParamString('secondInvitationLetterAccept');
            $txnSecondInvitationLetterWalkDate = $this->getPostParamString('secondInvitationLetterWalkDate');
            $txnThirdInvitationLetterIssueDate = $this->getPostParamString('thirdInvitationLetterIssueDate');
            $txnThirdInvitationLetterFaxRefNo = $this->getPostParamString('thirdInvitationLetterFaxRefNo');
            $txnThirdInvitationLetterEdmsLink = $this->getPostParamString('thirdInvitationLetterEdmsLink');
            $txnThirdInvitationLetterAccept = $this->getPostParamString('thirdInvitationLetterAccept');
            $txnThirdInvitationLetterWalkDate = $this->getPostParamString('thirdInvitationLetterWalkDate');
            $txnForthInvitationLetterIssueDate = $this->getPostParamString('forthInvitationLetterIssueDate');
            $txnForthInvitationLetterFaxRefNo = $this->getPostParamString('forthInvitationLetterFaxRefNo');
            $txnForthInvitationLetterEdmsLink = $this->getPostParamString('forthInvitationLetterEdmsLink');
            $txnForthInvitationLetterAccept = $this->getPostParamString('forthInvitationLetterAccept');
            $txnForthInvitationLetterWalkDate = $this->getPostParamString('forthInvitationLetterWalkDate');
            $txnEvaReportId = $this->getPostParamString('evaReportId');
            $txnEvaReportRemark = $this->getPostParamString('evaReportRemark');
            $txnEvaReportEdmsLink = $this->getPostParamString('evaReportEdmsLink');
            $txnEvaReportIssueDate = $this->getPostParamString('evaReportIssueDate');
            $txnEvaReportFaxRefNo = $this->getPostParamString('evaReportFaxRefNo');
            $txnEvaReportScore = $this->getPostParamString('evaReportScore');
            $txnEvaReportBmsYesNo = $this->getPostParamString('evaReportBmsYesNo');
            $txnEvaReportBmsServerCentralComputerYesNo = $this->getPostParamString('evaReportBmsServerCentralComputerYesNo');
            $txnEvaReportBmsServerCentralComputerFinding = $this->getPostParamString('evaReportBmsServerCentralComputerFinding');
            $txnEvaReportBmsServerCentralComputerRecommend = $this->getPostParamString('evaReportBmsServerCentralComputerRecommend');
            $txnEvaReportBmsServerCentralComputerPass = $this->getPostParamString('evaReportBmsServerCentralComputerPass');
            $txnEvaReportBmsDdcYesNo = $this->getPostParamString('evaReportBmsDdcYesNo');
            $txnEvaReportBmsDdcFinding = $this->getPostParamString('evaReportBmsDdcFinding');
            $txnEvaReportBmsDdcRecommend = $this->getPostParamString('evaReportBmsDdcRecommend');
            $txnEvaReportBmsDdcPass = $this->getPostParamString('evaReportBmsDdcPass');
            $txnEvaReportBmsSupplementYesNo = $this->getPostParamString('evaReportBmsSupplementYesNo');
            $txnEvaReportBmsSupplement = $this->getPostParamString('evaReportBmsSupplement');
            $txnEvaReportBmsSupplementPass = $this->getPostParamString('evaReportBmsSupplementPass');
            $txnEvaReportChangeoverSchemeYesNo = $this->getPostParamString('evaReportChangeoverSchemeYesNo');
            $txnEvaReportChangeoverSchemeControlYesNo = $this->getPostParamString('evaReportChangeoverSchemeControlYesNo');
            $txnEvaReportChangeoverSchemeControlFinding = $this->getPostParamString('evaReportChangeoverSchemeControlFinding');
            $txnEvaReportChangeoverSchemeControlRecommend = $this->getPostParamString('evaReportChangeoverSchemeControlRecommend');
            $txnEvaReportChangeoverSchemeControlPass = $this->getPostParamString('evaReportChangeoverSchemeControlPass');
            $txnEvaReportChangeoverSchemeUvYesNo = $this->getPostParamString('evaReportChangeoverSchemeUvYesNo');
            $txnEvaReportChangeoverSchemeUvFinding = $this->getPostParamString('evaReportChangeoverSchemeUvFinding');
            $txnEvaReportChangeoverSchemeUvRecommend = $this->getPostParamString('evaReportChangeoverSchemeUvRecommend');
            $txnEvaReportChangeoverSchemeUvPass = $this->getPostParamString('evaReportChangeoverSchemeUvPass');
            $txnEvaReportChangeoverSchemeSupplementYesNo = $this->getPostParamString('evaReportChangeoverSchemeSupplementYesNo');
            $txnEvaReportChangeoverSchemeSupplement = $this->getPostParamString('evaReportChangeoverSchemeSupplement');
            $txnEvaReportChangeoverSchemeSupplementPass = $this->getPostParamString('evaReportChangeoverSchemeSupplementPass');
            $txnEvaReportChillerPlantYesNo = $this->getPostParamString('evaReportChillerPlantYesNo');
            $txnEvaReportChillerPlantAhuChilledWaterYesNo = $this->getPostParamString('evaReportChillerPlantAhuChilledWaterYesNo');
            $txnEvaReportChillerPlantAhuChilledWaterFinding = $this->getPostParamString('evaReportChillerPlantAhuChilledWaterFinding');
            $txnEvaReportChillerPlantAhuChilledWaterRecommend = $this->getPostParamString('evaReportChillerPlantAhuChilledWaterRecommend');
            $txnEvaReportChillerPlantAhuChilledWaterPass = $this->getPostParamString('evaReportChillerPlantAhuChilledWaterPass');
            $txnEvaReportChillerPlantChillerYesNo = $this->getPostParamString('evaReportChillerPlantChillerYesNo');
            $txnEvaReportChillerPlantChillerFinding = $this->getPostParamString('evaReportChillerPlantChillerFinding');
            $txnEvaReportChillerPlantChillerRecommend = $this->getPostParamString('evaReportChillerPlantChillerRecommend');
            $txnEvaReportChillerPlantChillerPass = $this->getPostParamString('evaReportChillerPlantChillerPass');
            $txnEvaReportChillerPlantSupplementYesNo = $this->getPostParamString('evaReportChillerPlantSupplementYesNo');
            $txnEvaReportChillerPlantSupplement = $this->getPostParamString('evaReportChillerPlantSupplement');
            $txnEvaReportChillerPlantSupplementPass = $this->getPostParamString('evaReportChillerPlantSupplementPass');
            $txnEvaReportEscalatorYesNo = $this->getPostParamString('evaReportEscalatorYesNo');
            $txnEvaReportEscalatorBrakingSystemYesNo = $this->getPostParamString('evaReportEscalatorBrakingSystemYesNo');
            $txnEvaReportEscalatorBrakingSystemFinding = $this->getPostParamString('evaReportEscalatorBrakingSystemFinding');
            $txnEvaReportEscalatorBrakingSystemRecommend = $this->getPostParamString('evaReportEscalatorBrakingSystemRecommend');
            $txnEvaReportEscalatorBrakingSystemPass = $this->getPostParamString('evaReportEscalatorBrakingSystemPass');
            $txnEvaReportEscalatorControlYesNo = $this->getPostParamString('evaReportEscalatorControlYesNo');
            $txnEvaReportEscalatorControlFinding = $this->getPostParamString('evaReportEscalatorControlFinding');
            $txnEvaReportEscalatorControlRecommend = $this->getPostParamString('evaReportEscalatorControlRecommend');
            $txnEvaReportEscalatorControlPass = $this->getPostParamString('evaReportEscalatorControlPass');
            $txnEvaReportEscalatorSupplementYesNo = $this->getPostParamString('evaReportEscalatorSupplementYesNo');
            $txnEvaReportEscalatorSupplement = $this->getPostParamString('evaReportEscalatorSupplement');
            $txnEvaReportEscalatorSupplementPass = $this->getPostParamString('evaReportEscalatorSupplementPass');
            $txnEvaReportLiftYesNo = $this->getPostParamString('evaReportLiftYesNo');
            $txnEvaReportLiftOperationYesNo = $this->getPostParamString('evaReportLiftOperationYesNo');
            $txnEvaReportLiftOperationFinding = $this->getPostParamString('evaReportLiftOperationFinding');
            $txnEvaReportLiftOperationRecommend = $this->getPostParamString('evaReportLiftOperationRecommend');
            $txnEvaReportLiftOperationPass = $this->getPostParamString('evaReportLiftOperationPass');
            $txnEvaReportLiftMainSupplyYesNo = $this->getPostParamString('evaReportLiftMainSupplyYesNo');
            $txnEvaReportLiftMainSupplyFinding = $this->getPostParamString('evaReportLiftMainSupplyFinding');
            $txnEvaReportLiftMainSupplyRecommend = $this->getPostParamString('evaReportLiftMainSupplyRecommend');
            $txnEvaReportLiftMainSupplyPass = $this->getPostParamString('evaReportLiftMainSupplyPass');
            $txnEvaReportLiftSupplementYesNo = $this->getPostParamString('evaReportLiftSupplementYesNo');
            $txnEvaReportLiftSupplement = $this->getPostParamString('evaReportLiftSupplement');
            $txnEvaReportLiftSupplementPass = $this->getPostParamString('evaReportLiftSupplementPass');
            $txnEvaReportHidLampYesNo = $this->getPostParamString('evaReportHidLampYesNo');
            $txnEvaReportHidLampBallastYesNo = $this->getPostParamString('evaReportHidLampBallastYesNo');
            $txnEvaReportHidLampBallastFinding = $this->getPostParamString('evaReportHidLampBallastFinding');
            $txnEvaReportHidLampBallastRecommend = $this->getPostParamString('evaReportHidLampBallastRecommend');
            $txnEvaReportHidLampBallastPass = $this->getPostParamString('evaReportHidLampBallastPass');
            $txnEvaReportHidLampAddonProtectYesNo = $this->getPostParamString('evaReportHidLampAddonProtectYesNo');
            $txnEvaReportHidLampAddonProtectFinding = $this->getPostParamString('evaReportHidLampAddonProtectFinding');
            $txnEvaReportHidLampAddonProtectRecommend = $this->getPostParamString('evaReportHidLampAddonProtectRecommend');
            $txnEvaReportHidLampAddonProtectPass = $this->getPostParamString('evaReportHidLampAddonProtectPass');
            $txnEvaReportHidLampSupplementYesNo = $this->getPostParamString('evaReportHidLampSupplementYesNo');
            $txnEvaReportHidLampSupplement = $this->getPostParamString('evaReportHidLampSupplement');
            $txnEvaReportHidLampSupplementPass = $this->getPostParamString('evaReportHidLampSupplementPass');
            $txnEvaReportSensitiveMachineYesNo = $this->getPostParamString('evaReportSensitiveMachineYesNo');
            $txnEvaReportSensitiveMachineMedicalYesNo = $this->getPostParamString('evaReportSensitiveMachineMedicalYesNo');
            $txnEvaReportSensitiveMachineMedicalFinding = $this->getPostParamString('evaReportSensitiveMachineMedicalFinding');
            $txnEvaReportSensitiveMachineMedicalRecommend = $this->getPostParamString('evaReportSensitiveMachineMedicalRecommend');
            $txnEvaReportSensitiveMachineMedicalPass = $this->getPostParamString('evaReportSensitiveMachineMedicalPass');
            $txnEvaReportSensitiveMachineSupplementYesNo = $this->getPostParamString('evaReportSensitiveMachineSupplementYesNo');
            $txnEvaReportSensitiveMachineSupplement = $this->getPostParamString('evaReportSensitiveMachineSupplement');
            $txnEvaReportSensitiveMachineSupplementPass = $this->getPostParamString('evaReportSensitiveMachineSupplementPass');
            $txnEvaReportTelecomMachineYesNo = $this->getPostParamString('evaReportTelecomMachineYesNo');
            $txnEvaReportTelecomMachineServerOrComputerYesNo = $this->getPostParamString('evaReportTelecomMachineServerOrComputerYesNo');
            $txnEvaReportTelecomMachineServerOrComputerFinding = $this->getPostParamString('evaReportTelecomMachineServerOrComputerFinding');
            $txnEvaReportTelecomMachineServerOrComputerRecommend = $this->getPostParamString('evaReportTelecomMachineServerOrComputerRecommend');
            $txnEvaReportTelecomMachineServerOrComputerPass = $this->getPostParamString('evaReportTelecomMachineServerOrComputerPass');
            $txnEvaReportTelecomMachinePeripheralsYesNo = $this->getPostParamString('evaReportTelecomMachinePeripheralsYesNo');
            $txnEvaReportTelecomMachinePeripheralsFinding = $this->getPostParamString('evaReportTelecomMachinePeripheralsFinding');
            $txnEvaReportTelecomMachinePeripheralsRecommend = $this->getPostParamString('evaReportTelecomMachinePeripheralsRecommend');
            $txnEvaReportTelecomMachinePeripheralsPass = $this->getPostParamString('evaReportTelecomMachinePeripheralsPass');
            $txnEvaReportTelecomMachineHarmonicEmissionYesNo = $this->getPostParamString('evaReportTelecomMachineHarmonicEmissionYesNo');
            $txnEvaReportTelecomMachineHarmonicEmissionFinding = $this->getPostParamString('evaReportTelecomMachineHarmonicEmissionFinding');
            $txnEvaReportTelecomMachineHarmonicEmissionRecommend = $this->getPostParamString('evaReportTelecomMachineHarmonicEmissionRecommend');
            $txnEvaReportTelecomMachineHarmonicEmissionPass = $this->getPostParamString('evaReportTelecomMachineHarmonicEmissionPass');
            $txnEvaReportTelecomMachineSupplementYesNo = $this->getPostParamString('evaReportTelecomMachineSupplementYesNo');
            $txnEvaReportTelecomMachineSupplement = $this->getPostParamString('evaReportTelecomMachineSupplement');
            $txnEvaReportTelecomMachineSupplementPass = $this->getPostParamString('evaReportTelecomMachineSupplementPass');
            $txnEvaReportAirConditionersYesNo = $this->getPostParamString('evaReportAirConditionersYesNo');
            $txnEvaReportAirConditionersMicbYesNo = $this->getPostParamString('evaReportAirConditionersMicbYesNo');
            $txnEvaReportAirConditionersMicbFinding = $this->getPostParamString('evaReportAirConditionersMicbFinding');
            $txnEvaReportAirConditionersMicbRecommend = $this->getPostParamString('evaReportAirConditionersMicbRecommend');
            $txnEvaReportAirConditionersMicbPass = $this->getPostParamString('evaReportAirConditionersMicbPass');
            $txnEvaReportAirConditionersLoadForecastingYesNo = $this->getPostParamString('evaReportAirConditionersLoadForecastingYesNo');
            $txnEvaReportAirConditionersLoadForecastingFinding = $this->getPostParamString('evaReportAirConditionersLoadForecastingFinding');
            $txnEvaReportAirConditionersLoadForecastingRecommend = $this->getPostParamString('evaReportAirConditionersLoadForecastingRecommend');
            $txnEvaReportAirConditionersLoadForecastingPass = $this->getPostParamString('evaReportAirConditionersLoadForecastingPass');
            $txnEvaReportAirConditionersTypeYesNo = $this->getPostParamString('evaReportAirConditionersTypeYesNo');
            $txnEvaReportAirConditionersTypeFinding = $this->getPostParamString('evaReportAirConditionersTypeFinding');
            $txnEvaReportAirConditionersTypeRecommend = $this->getPostParamString('evaReportAirConditionersTypeRecommend');
            $txnEvaReportAirConditionersTypePass = $this->getPostParamString('evaReportAirConditionersTypePass');
            $txnEvaReportAirConditionersSupplementYesNo = $this->getPostParamString('evaReportAirConditionersSupplementYesNo');
            $txnEvaReportAirConditionersSupplement = $this->getPostParamString('evaReportAirConditionersSupplement');
            $txnEvaReportAirConditionersSupplementPass = $this->getPostParamString('evaReportAirConditionersSupplementPass');
            $txnEvaReportNonLinearLoadYesNo = $this->getPostParamString('evaReportNonLinearLoadYesNo');
            $txnEvaReportNonLinearLoadHarmonicEmissionYesNo = $this->getPostParamString('evaReportNonLinearLoadHarmonicEmissionYesNo');
            $txnEvaReportNonLinearLoadHarmonicEmissionFinding = $this->getPostParamString('evaReportNonLinearLoadHarmonicEmissionFinding');
            $txnEvaReportNonLinearLoadHarmonicEmissionRecommend = $this->getPostParamString('evaReportNonLinearLoadHarmonicEmissionRecommend');
            $txnEvaReportNonLinearLoadHarmonicEmissionPass = $this->getPostParamString('evaReportNonLinearLoadHarmonicEmissionPass');
            $txnEvaReportNonLinearLoadSupplementYesNo = $this->getPostParamString('evaReportNonLinearLoadSupplementYesNo');
            $txnEvaReportNonLinearLoadSupplement = $this->getPostParamString('evaReportNonLinearLoadSupplement');
            $txnEvaReportNonLinearLoadSupplementPass = $this->getPostParamString('evaReportNonLinearLoadSupplementPass');
            $txnEvaReportRenewableEnergyYesNo = $this->getPostParamString('evaReportRenewableEnergyYesNo');
            $txnEvaReportRenewableEnergyInverterAndControlsYesNo = $this->getPostParamString('evaReportRenewableEnergyInverterAndControlsYesNo');
            $txnEvaReportRenewableEnergyInverterAndControlsFinding = $this->getPostParamString('evaReportRenewableEnergyInverterAndControlsFinding');
            $txnEvaReportRenewableEnergyInverterAndControlsRecommend = $this->getPostParamString('evaReportRenewableEnergyInverterAndControlsRecommend');
            $txnEvaReportRenewableEnergyInverterAndControlsPass = $this->getPostParamString('evaReportRenewableEnergyInverterAndControlsPass');
            $txnEvaReportRenewableEnergyHarmonicEmissionYesNo = $this->getPostParamString('evaReportRenewableEnergyHarmonicEmissionYesNo');
            $txnEvaReportRenewableEnergyHarmonicEmissionFinding = $this->getPostParamString('evaReportRenewableEnergyHarmonicEmissionFinding');
            $txnEvaReportRenewableEnergyHarmonicEmissionRecommend = $this->getPostParamString('evaReportRenewableEnergyHarmonicEmissionRecommend');
            $txnEvaReportRenewableEnergyHarmonicEmissionPass = $this->getPostParamString('evaReportRenewableEnergyHarmonicEmissionPass');
            $txnEvaReportRenewableEnergySupplementYesNo = $this->getPostParamString('evaReportRenewableEnergySupplementYesNo');
            $txnEvaReportRenewableEnergySupplement = $this->getPostParamString('evaReportRenewableEnergySupplement');
            $txnEvaReportRenewableEnergySupplementPass = $this->getPostParamString('evaReportRenewableEnergySupplementPass');
            $txnEvaReportEvChargerSystemYesNo = $this->getPostParamString('evaReportEvChargerSystemYesNo');
            $txnEvaReportEvChargerSystemEvChargerYesNo = $this->getPostParamString('evaReportEvChargerSystemEvChargerYesNo');
            $txnEvaReportEvChargerSystemEvChargerFinding = $this->getPostParamString('evaReportEvChargerSystemEvChargerFinding');
            $txnEvaReportEvChargerSystemEvChargerRecommend = $this->getPostParamString('evaReportEvChargerSystemEvChargerRecommend');
            $txnEvaReportEvChargerSystemEvChargerPass = $this->getPostParamString('evaReportEvChargerSystemEvChargerPass');
            $txnEvaReportEvChargerSystemHarmonicEmissionYesNo = $this->getPostParamString('evaReportEvChargerSystemHarmonicEmissionYesNo');
            $txnEvaReportEvChargerSystemHarmonicEmissionFinding = $this->getPostParamString('evaReportEvChargerSystemHarmonicEmissionFinding');
            $txnEvaReportEvChargerSystemHarmonicEmissionRecommend = $this->getPostParamString('evaReportEvChargerSystemHarmonicEmissionRecommend');
            $txnEvaReportEvChargerSystemHarmonicEmissionPass = $this->getPostParamString('evaReportEvChargerSystemHarmonicEmissionPass');
            $txnEvaReportEvChargerSystemSupplementYesNo = $this->getPostParamString('evaReportEvChargerSystemSupplementYesNo');
            $txnEvaReportEvChargerSystemSupplement = $this->getPostParamString('evaReportEvChargerSystemSupplement');
            $txnEvaReportEvChargerSystemSupplementPass = $this->getPostParamString('evaReportEvChargerSystemSupplementPass');
            $txnReEvaReportId = $this->getPostParamString('reEvaReportId');
            $txnReEvaReportRemark = $this->getPostParamString('reEvaReportRemark');
            $txnReEvaReportEdmsLink = $this->getPostParamString('reEvaReportEdmsLink');
            $txnReEvaReportIssueDate = $this->getPostParamString('reEvaReportIssueDate');
            $txnReEvaReportFaxRefNo = $this->getPostParamString('reEvaReportFaxRefNo');
            $txnReEvaReportScore = $this->getPostParamString('reEvaReportScore');
            $txnReEvaReportBmsYesNo = $this->getPostParamString('reEvaReportBmsYesNo');
            $txnReEvaReportBmsServerCentralComputerYesNo = $this->getPostParamString('reEvaReportBmsServerCentralComputerYesNo');
            $txnReEvaReportBmsServerCentralComputerFinding = $this->getPostParamString('reEvaReportBmsServerCentralComputerFinding');
            $txnReEvaReportBmsServerCentralComputerRecommend = $this->getPostParamString('reEvaReportBmsServerCentralComputerRecommend');
            $txnReEvaReportBmsServerCentralComputerPass = $this->getPostParamString('reEvaReportBmsServerCentralComputerPass');
            $txnReEvaReportBmsDdcYesNo = $this->getPostParamString('reEvaReportBmsDdcYesNo');
            $txnReEvaReportBmsDdcFinding = $this->getPostParamString('reEvaReportBmsDdcFinding');
            $txnReEvaReportBmsDdcRecommend = $this->getPostParamString('reEvaReportBmsDdcRecommend');
            $txnReEvaReportBmsDdcPass = $this->getPostParamString('reEvaReportBmsDdcPass');
            $txnReEvaReportBmsSupplementYesNo = $this->getPostParamString('reEvaReportBmsSupplementYesNo');
            $txnReEvaReportBmsSupplement = $this->getPostParamString('reEvaReportBmsSupplement');
            $txnReEvaReportBmsSupplementPass = $this->getPostParamString('reEvaReportBmsSupplementPass');
            $txnReEvaReportChangeoverSchemeYesNo = $this->getPostParamString('reEvaReportChangeoverSchemeYesNo');
            $txnReEvaReportChangeoverSchemeControlYesNo = $this->getPostParamString('reEvaReportChangeoverSchemeControlYesNo');
            $txnReEvaReportChangeoverSchemeControlFinding = $this->getPostParamString('reEvaReportChangeoverSchemeControlFinding');
            $txnReEvaReportChangeoverSchemeControlRecommend = $this->getPostParamString('reEvaReportChangeoverSchemeControlRecommend');
            $txnReEvaReportChangeoverSchemeControlPass = $this->getPostParamString('reEvaReportChangeoverSchemeControlPass');
            $txnReEvaReportChangeoverSchemeUvYesNo = $this->getPostParamString('reEvaReportChangeoverSchemeUvYesNo');
            $txnReEvaReportChangeoverSchemeUvFinding = $this->getPostParamString('reEvaReportChangeoverSchemeUvFinding');
            $txnReEvaReportChangeoverSchemeUvRecommend = $this->getPostParamString('reEvaReportChangeoverSchemeUvRecommend');
            $txnReEvaReportChangeoverSchemeUvPass = $this->getPostParamString('reEvaReportChangeoverSchemeUvPass');
            $txnReEvaReportChangeoverSchemeSupplementYesNo = $this->getPostParamString('reEvaReportChangeoverSchemeSupplementYesNo');
            $txnReEvaReportChangeoverSchemeSupplement = $this->getPostParamString('reEvaReportChangeoverSchemeSupplement');
            $txnReEvaReportChangeoverSchemeSupplementPass = $this->getPostParamString('reEvaReportChangeoverSchemeSupplementPass');
            $txnReEvaReportChillerPlantYesNo = $this->getPostParamString('reEvaReportChillerPlantYesNo');
            $txnReEvaReportChillerPlantAhuChilledWaterYesNo = $this->getPostParamString('reEvaReportChillerPlantAhuChilledWaterYesNo');
            $txnReEvaReportChillerPlantAhuChilledWaterFinding = $this->getPostParamString('reEvaReportChillerPlantAhuChilledWaterFinding');
            $txnReEvaReportChillerPlantAhuChilledWaterRecommend = $this->getPostParamString('reEvaReportChillerPlantAhuChilledWaterRecommend');
            $txnReEvaReportChillerPlantAhuChilledWaterPass = $this->getPostParamString('reEvaReportChillerPlantAhuChilledWaterPass');
            $txnReEvaReportChillerPlantChillerYesNo = $this->getPostParamString('reEvaReportChillerPlantChillerYesNo');
            $txnReEvaReportChillerPlantChillerFinding = $this->getPostParamString('reEvaReportChillerPlantChillerFinding');
            $txnReEvaReportChillerPlantChillerRecommend = $this->getPostParamString('reEvaReportChillerPlantChillerRecommend');
            $txnReEvaReportChillerPlantChillerPass = $this->getPostParamString('reEvaReportChillerPlantChillerPass');
            $txnReEvaReportChillerPlantSupplementYesNo = $this->getPostParamString('reEvaReportChillerPlantSupplementYesNo');
            $txnReEvaReportChillerPlantSupplement = $this->getPostParamString('reEvaReportChillerPlantSupplement');
            $txnReEvaReportChillerPlantSupplementPass = $this->getPostParamString('reEvaReportChillerPlantSupplementPass');
            $txnReEvaReportEscalatorYesNo = $this->getPostParamString('reEvaReportEscalatorYesNo');
            $txnReEvaReportEscalatorBrakingSystemYesNo = $this->getPostParamString('reEvaReportEscalatorBrakingSystemYesNo');
            $txnReEvaReportEscalatorBrakingSystemFinding = $this->getPostParamString('reEvaReportEscalatorBrakingSystemFinding');
            $txnReEvaReportEscalatorBrakingSystemRecommend = $this->getPostParamString('reEvaReportEscalatorBrakingSystemRecommend');
            $txnReEvaReportEscalatorBrakingSystemPass = $this->getPostParamString('reEvaReportEscalatorBrakingSystemPass');
            $txnReEvaReportEscalatorControlYesNo = $this->getPostParamString('reEvaReportEscalatorControlYesNo');
            $txnReEvaReportEscalatorControlFinding = $this->getPostParamString('reEvaReportEscalatorControlFinding');
            $txnReEvaReportEscalatorControlRecommend = $this->getPostParamString('reEvaReportEscalatorControlRecommend');
            $txnReEvaReportEscalatorControlPass = $this->getPostParamString('reEvaReportEscalatorControlPass');
            $txnReEvaReportEscalatorSupplementYesNo = $this->getPostParamString('reEvaReportEscalatorSupplementYesNo');
            $txnReEvaReportEscalatorSupplement = $this->getPostParamString('reEvaReportEscalatorSupplement');
            $txnReEvaReportEscalatorSupplementPass = $this->getPostParamString('reEvaReportEscalatorSupplementPass');
            $txnReEvaReportLiftYesNo = $this->getPostParamString('reEvaReportLiftYesNo');
            $txnReEvaReportLiftOperationYesNo = $this->getPostParamString('reEvaReportLiftOperationYesNo');
            $txnReEvaReportLiftOperationFinding = $this->getPostParamString('reEvaReportLiftOperationFinding');
            $txnReEvaReportLiftOperationRecommend = $this->getPostParamString('reEvaReportLiftOperationRecommend');
            $txnReEvaReportLiftOperationPass = $this->getPostParamString('reEvaReportLiftOperationPass');
            $txnReEvaReportLiftMainSupplyYesNo = $this->getPostParamString('reEvaReportLiftMainSupplyYesNo');
            $txnReEvaReportLiftMainSupplyFinding = $this->getPostParamString('reEvaReportLiftMainSupplyFinding');
            $txnReEvaReportLiftMainSupplyRecommend = $this->getPostParamString('reEvaReportLiftMainSupplyRecommend');
            $txnReEvaReportLiftMainSupplyPass = $this->getPostParamString('reEvaReportLiftMainSupplyPass');
            $txnReEvaReportLiftSupplementYesNo = $this->getPostParamString('reEvaReportLiftSupplementYesNo');
            $txnReEvaReportLiftSupplement = $this->getPostParamString('reEvaReportLiftSupplement');
            $txnReEvaReportLiftSupplementPass = $this->getPostParamString('reEvaReportLiftSupplementPass');
            $txnReEvaReportHidLampYesNo = $this->getPostParamString('reEvaReportHidLampYesNo');
            $txnReEvaReportHidLampBallastYesNo = $this->getPostParamString('reEvaReportHidLampBallastYesNo');
            $txnReEvaReportHidLampBallastFinding = $this->getPostParamString('reEvaReportHidLampBallastFinding');
            $txnReEvaReportHidLampBallastRecommend = $this->getPostParamString('reEvaReportHidLampBallastRecommend');
            $txnReEvaReportHidLampBallastPass = $this->getPostParamString('reEvaReportHidLampBallastPass');
            $txnReEvaReportHidLampAddonProtectYesNo = $this->getPostParamString('reEvaReportHidLampAddonProtectYesNo');
            $txnReEvaReportHidLampAddonProtectFinding = $this->getPostParamString('reEvaReportHidLampAddonProtectFinding');
            $txnReEvaReportHidLampAddonProtectRecommend = $this->getPostParamString('reEvaReportHidLampAddonProtectRecommend');
            $txnReEvaReportHidLampAddonProtectPass = $this->getPostParamString('reEvaReportHidLampAddonProtectPass');
            $txnReEvaReportHidLampSupplementYesNo = $this->getPostParamString('reEvaReportHidLampSupplementYesNo');
            $txnReEvaReportHidLampSupplement = $this->getPostParamString('reEvaReportHidLampSupplement');
            $txnReEvaReportHidLampSupplementPass = $this->getPostParamString('reEvaReportHidLampSupplementPass');
            $txnReEvaReportSensitiveMachineYesNo = $this->getPostParamString('reEvaReportSensitiveMachineYesNo');
            $txnReEvaReportSensitiveMachineMedicalYesNo = $this->getPostParamString('reEvaReportSensitiveMachineMedicalYesNo');
            $txnReEvaReportSensitiveMachineMedicalFinding = $this->getPostParamString('reEvaReportSensitiveMachineMedicalFinding');
            $txnReEvaReportSensitiveMachineMedicalRecommend = $this->getPostParamString('reEvaReportSensitiveMachineMedicalRecommend');
            $txnReEvaReportSensitiveMachineMedicalPass = $this->getPostParamString('reEvaReportSensitiveMachineMedicalPass');
            $txnReEvaReportSensitiveMachineSupplementYesNo = $this->getPostParamString('reEvaReportSensitiveMachineSupplementYesNo');
            $txnReEvaReportSensitiveMachineSupplement = $this->getPostParamString('reEvaReportSensitiveMachineSupplement');
            $txnReEvaReportSensitiveMachineSupplementPass = $this->getPostParamString('reEvaReportSensitiveMachineSupplementPass');
            $txnReEvaReportTelecomMachineYesNo = $this->getPostParamString('reEvaReportTelecomMachineYesNo');
            $txnReEvaReportTelecomMachineServerOrComputerYesNo = $this->getPostParamString('reEvaReportTelecomMachineServerOrComputerYesNo');
            $txnReEvaReportTelecomMachineServerOrComputerFinding = $this->getPostParamString('reEvaReportTelecomMachineServerOrComputerFinding');
            $txnReEvaReportTelecomMachineServerOrComputerRecommend = $this->getPostParamString('reEvaReportTelecomMachineServerOrComputerRecommend');
            $txnReEvaReportTelecomMachineServerOrComputerPass = $this->getPostParamString('reEvaReportTelecomMachineServerOrComputerPass');
            $txnReEvaReportTelecomMachinePeripheralsYesNo = $this->getPostParamString('reEvaReportTelecomMachinePeripheralsYesNo');
            $txnReEvaReportTelecomMachinePeripheralsFinding = $this->getPostParamString('reEvaReportTelecomMachinePeripheralsFinding');
            $txnReEvaReportTelecomMachinePeripheralsRecommend = $this->getPostParamString('reEvaReportTelecomMachinePeripheralsRecommend');
            $txnReEvaReportTelecomMachinePeripheralsPass = $this->getPostParamString('reEvaReportTelecomMachinePeripheralsPass');
            $txnReEvaReportTelecomMachineHarmonicEmissionYesNo = $this->getPostParamString('reEvaReportTelecomMachineHarmonicEmissionYesNo');
            $txnReEvaReportTelecomMachineHarmonicEmissionFinding = $this->getPostParamString('reEvaReportTelecomMachineHarmonicEmissionFinding');
            $txnReEvaReportTelecomMachineHarmonicEmissionRecommend = $this->getPostParamString('reEvaReportTelecomMachineHarmonicEmissionRecommend');
            $txnReEvaReportTelecomMachineHarmonicEmissionPass = $this->getPostParamString('reEvaReportTelecomMachineHarmonicEmissionPass');
            $txnReEvaReportTelecomMachineSupplementYesNo = $this->getPostParamString('reEvaReportTelecomMachineSupplementYesNo');
            $txnReEvaReportTelecomMachineSupplement = $this->getPostParamString('reEvaReportTelecomMachineSupplement');
            $txnReEvaReportTelecomMachineSupplementPass = $this->getPostParamString('reEvaReportTelecomMachineSupplementPass');
            $txnReEvaReportAirConditionersYesNo = $this->getPostParamString('reEvaReportAirConditionersYesNo');
            $txnReEvaReportAirConditionersMicbYesNo = $this->getPostParamString('reEvaReportAirConditionersMicbYesNo');
            $txnReEvaReportAirConditionersMicbFinding = $this->getPostParamString('reEvaReportAirConditionersMicbFinding');
            $txnReEvaReportAirConditionersMicbRecommend = $this->getPostParamString('reEvaReportAirConditionersMicbRecommend');
            $txnReEvaReportAirConditionersMicbPass = $this->getPostParamString('reEvaReportAirConditionersMicbPass');
            $txnReEvaReportAirConditionersLoadForecastingYesNo = $this->getPostParamString('reEvaReportAirConditionersLoadForecastingYesNo');
            $txnReEvaReportAirConditionersLoadForecastingFinding = $this->getPostParamString('reEvaReportAirConditionersLoadForecastingFinding');
            $txnReEvaReportAirConditionersLoadForecastingRecommend = $this->getPostParamString('reEvaReportAirConditionersLoadForecastingRecommend');
            $txnReEvaReportAirConditionersLoadForecastingPass = $this->getPostParamString('reEvaReportAirConditionersLoadForecastingPass');
            $txnReEvaReportAirConditionersTypeYesNo = $this->getPostParamString('reEvaReportAirConditionersTypeYesNo');
            $txnReEvaReportAirConditionersTypeFinding = $this->getPostParamString('reEvaReportAirConditionersTypeFinding');
            $txnReEvaReportAirConditionersTypeRecommend = $this->getPostParamString('reEvaReportAirConditionersTypeRecommend');
            $txnReEvaReportAirConditionersTypePass = $this->getPostParamString('reEvaReportAirConditionersTypePass');
            $txnReEvaReportAirConditionersSupplementYesNo = $this->getPostParamString('reEvaReportAirConditionersSupplementYesNo');
            $txnReEvaReportAirConditionersSupplement = $this->getPostParamString('reEvaReportAirConditionersSupplement');
            $txnReEvaReportAirConditionersSupplementPass = $this->getPostParamString('reEvaReportAirConditionersSupplementPass');
            $txnReEvaReportNonLinearLoadYesNo = $this->getPostParamString('reEvaReportNonLinearLoadYesNo');
            $txnReEvaReportNonLinearLoadHarmonicEmissionYesNo = $this->getPostParamString('reEvaReportNonLinearLoadHarmonicEmissionYesNo');
            $txnReEvaReportNonLinearLoadHarmonicEmissionFinding = $this->getPostParamString('reEvaReportNonLinearLoadHarmonicEmissionFinding');
            $txnReEvaReportNonLinearLoadHarmonicEmissionRecommend = $this->getPostParamString('reEvaReportNonLinearLoadHarmonicEmissionRecommend');
            $txnReEvaReportNonLinearLoadHarmonicEmissionPass = $this->getPostParamString('reEvaReportNonLinearLoadHarmonicEmissionPass');
            $txnReEvaReportNonLinearLoadSupplementYesNo = $this->getPostParamString('reEvaReportNonLinearLoadSupplementYesNo');
            $txnReEvaReportNonLinearLoadSupplement = $this->getPostParamString('reEvaReportNonLinearLoadSupplement');
            $txnReEvaReportNonLinearLoadSupplementPass = $this->getPostParamString('reEvaReportNonLinearLoadSupplementPass');
            $txnReEvaReportRenewableEnergyYesNo = $this->getPostParamString('reEvaReportRenewableEnergyYesNo');
            $txnReEvaReportRenewableEnergyInverterAndControlsYesNo = $this->getPostParamString('reEvaReportRenewableEnergyInverterAndControlsYesNo');
            $txnReEvaReportRenewableEnergyInverterAndControlsFinding = $this->getPostParamString('reEvaReportRenewableEnergyInverterAndControlsFinding');
            $txnReEvaReportRenewableEnergyInverterAndControlsRecommend = $this->getPostParamString('reEvaReportRenewableEnergyInverterAndControlsRecommend');
            $txnReEvaReportRenewableEnergyInverterAndControlsPass = $this->getPostParamString('reEvaReportRenewableEnergyInverterAndControlsPass');
            $txnReEvaReportRenewableEnergyHarmonicEmissionYesNo = $this->getPostParamString('reEvaReportRenewableEnergyHarmonicEmissionYesNo');
            $txnReEvaReportRenewableEnergyHarmonicEmissionFinding = $this->getPostParamString('reEvaReportRenewableEnergyHarmonicEmissionFinding');
            $txnReEvaReportRenewableEnergyHarmonicEmissionRecommend = $this->getPostParamString('reEvaReportRenewableEnergyHarmonicEmissionRecommend');
            $txnReEvaReportRenewableEnergyHarmonicEmissionPass = $this->getPostParamString('reEvaReportRenewableEnergyHarmonicEmissionPass');
            $txnReEvaReportRenewableEnergySupplementYesNo = $this->getPostParamString('reEvaReportRenewableEnergySupplementYesNo');
            $txnReEvaReportRenewableEnergySupplement = $this->getPostParamString('reEvaReportRenewableEnergySupplement');
            $txnReEvaReportRenewableEnergySupplementPass = $this->getPostParamString('reEvaReportRenewableEnergySupplementPass');
            $txnReEvaReportEvChargerSystemYesNo = $this->getPostParamString('reEvaReportEvChargerSystemYesNo');
            $txnReEvaReportEvChargerSystemEvChargerYesNo = $this->getPostParamString('reEvaReportEvChargerSystemEvChargerYesNo');
            $txnReEvaReportEvChargerSystemEvChargerFinding = $this->getPostParamString('reEvaReportEvChargerSystemEvChargerFinding');
            $txnReEvaReportEvChargerSystemEvChargerRecommend = $this->getPostParamString('reEvaReportEvChargerSystemEvChargerRecommend');
            $txnReEvaReportEvChargerSystemEvChargerPass = $this->getPostParamString('reEvaReportEvChargerSystemEvChargerPass');
            $txnReEvaReportEvChargerSystemHarmonicEmissionYesNo = $this->getPostParamString('reEvaReportEvChargerSystemHarmonicEmissionYesNo');
            $txnReEvaReportEvChargerSystemHarmonicEmissionFinding = $this->getPostParamString('reEvaReportEvChargerSystemHarmonicEmissionFinding');
            $txnReEvaReportEvChargerSystemHarmonicEmissionRecommend = $this->getPostParamString('reEvaReportEvChargerSystemHarmonicEmissionRecommend');
            $txnReEvaReportEvChargerSystemHarmonicEmissionPass = $this->getPostParamString('reEvaReportEvChargerSystemHarmonicEmissionPass');
            $txnReEvaReportEvChargerSystemSupplementYesNo = $this->getPostParamString('reEvaReportEvChargerSystemSupplementYesNo');
            $txnReEvaReportEvChargerSystemSupplement = $this->getPostParamString('reEvaReportEvChargerSystemSupplement');
            $txnReEvaReportEvChargerSystemSupplementPass = $this->getPostParamString('reEvaReportEvChargerSystemSupplementPass');

            $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
            $lastUpdatedTime = date("Y-m-d H:i");

            $currState = Yii::app()->planningAheadDao->getPlanningAheadDetails($txnSchemeNo);
            $txnNewState = $currState['state'];

            if (($currState['state']=="WAITING_INITIAL_INFO") && ($txnRoleId == "2")) {
                $txnNewState = "WAITING_INITIAL_INFO_BY_REGION_STAFF";
            } else if (($currState['state']=="WAITING_INITIAL_INFO") && ($txnRoleId == "3")) {
                $txnNewState = "WAITING_INITIAL_INFO_BY_PQ";
            } else if (($currState['state']=="WAITING_INITIAL_INFO_BY_REGION_STAFF") && ($txnRoleId == "3")) {
                $txnNewState = "COMPLETED_INITIAL_INFO";
            } else if (($currState['state']=="WAITING_INITIAL_INFO_BY_PQ") && ($txnRoleId == "2")) {
                $txnNewState = "COMPLETED_INITIAL_INFO";
            } else if ($currState['state']=="WAITING_STANDARD_LETTER") {
                $txnNewState = "COMPLETED_STANDARD_LETTER";
            } else if ($currState['state']=="COMPLETED_CONSULTANT_MEETING_INFO") {
                $txnNewState = "COMPLETED_ACTUAL_MEETING_DATE";
            } else if ($currState['state']=="SENT_FIRST_INVITATION_LETTER") {
                $txnNewState = "WAITING_PQ_SITE_WALK";
            } else if ($currState['state']=="SENT_SECOND_INVITATION_LETTER") {
                $txnNewState = "WAITING_PQ_SITE_WALK";
            } else if ($currState['state']=="SENT_THIRD_INVITATION_LETTER") {
                $txnNewState = "WAITING_PQ_SITE_WALK";
            } else if (($currState['state']=="NOTIFIED_PQ_SITE_WALK") ||
                    ($currState['state']=="COMPLETED_PQ_SITE_WALK_PASS") ||
                    ($currState['state']=="COMPLETED_PQ_SITE_WALK_FAIL")) {

                    if (floatval($txnEvaReportScore) >= 50.0) {
                        $txnNewState = "COMPLETED_PQ_SITE_WALK_PASS";
                    } else {
                        $txnNewState = "COMPLETED_PQ_SITE_WALK_FAIL";
                    }
            } else if ($currState['state']=="SENT_FORTH_INVITATION_LETTER") {
                $txnNewState = "WAITING_RE_PQ_SITE_WALK";
            } else if (($currState['state']=="NOTIFIED_RE_PQ_SITE_WALK") ||
                ($currState['state']=="COMPLETED_RE_PQ_SITE_WALK_PASS") ||
                ($currState['state']=="COMPLETED_RE_PQ_SITE_WALK_FAIL")) {

                if (floatval($txnReEvaReportScore) >= 50.0) {
                    $txnNewState = "COMPLETED_RE_PQ_SITE_WALK_PASS";
                } else {
                    $txnNewState = "COMPLETED_RE_PQ_SITE_WALK_FAIL";
                }
            }

            $retJson = Yii::app()->planningAheadDao->updatePlanningAheadDetailProcess($txnProjectTitle,
                $txnSchemeNo,$txnRegion,
                $txnTypeOfProject,$txnCommissionDate,$txnKeyInfra,$txnTempProj,
                $txnFirstRegionStaffName,$txnFirstRegionStaffPhone,$txnFirstRegionStaffEmail,
                $txnSecondRegionStaffName,$txnSecondRegionStaffPhone,$txnSecondRegionStaffEmail,
                $txnThirdRegionStaffName,$txnThirdRegionStaffPhone,$txnThirdRegionStaffEmail,
                $txnFirstConsultantTitle,$txnFirstConsultantSurname,$txnFirstConsultantOtherName,
                $txnFirstConsultantCompany,$txnFirstConsultantPhone,$txnFirstConsultantEmail,
                $txnSecondConsultantTitle,$txnSecondConsultantSurname,$txnSecondConsultantOtherName,
                $txnSecondConsultantCompany,$txnSecondConsultantPhone,$txnSecondConsultantEmail,
                $txnThirdConsultantTitle,$txnThirdConsultantSurname,$txnThirdConsultantOtherName,
                $txnThirdConsultantCompany,$txnThirdConsultantPhone,$txnThirdConsultantEmail,
                $txnFirstProjectOwnerTitle,$txnFirstProjectOwnerSurname,$txnFirstProjectOwnerOtherName,
                $txnFirstProjectOwnerCompany,$txnFirstProjectOwnerPhone,$txnFirstProjectOwnerEmail,
                $txnSecondProjectOwnerTitle,$txnSecondProjectOwnerSurname,$txnSecondProjectOwnerOtherName,
                $txnSecondProjectOwnerCompany,$txnSecondProjectOwnerPhone,$txnSecondProjectOwnerEmail,
                $txnThirdProjectOwnerTitle,$txnThirdProjectOwnerSurname,$txnThirdProjectOwnerOtherName,
                $txnThirdProjectOwnerCompany,$txnThirdProjectOwnerPhone,$txnThirdProjectOwnerEmail,
                $txnStandLetterIssueDate,$txnStandLetterFaxRefNo,$txnStandLetterEdmsLink,
                $txnStandLetterLetterLoc,$txnMeetingFirstPreferMeetingDate,$txnMeetingSecondPreferMeetingDate,
                $txnMeetingActualMeetingDate,$txnMeetingRejReason,$txnMeetingConsentConsultant,$txnMeetingRemark,
                $txnMeetingConsentOwner,$txnMeetingReplySlipId,
                $txnReplySlipBmsYesNo,$txnReplySlipBmsServerCentralComputer,
                $txnReplySlipBmsDdc,$txnReplySlipChangeoverSchemeYesNo,$txnReplySlipChangeoverSchemeControl,
                $txnReplySlipChangeoverSchemeUv,$txnReplySlipChillerPlantYesNo,$txnReplySlipChillerPlantAhuControl,
                $txnReplySlipChillerPlantAhuStartup,$txnReplySlipChillerPlantVsd,$txnReplySlipChillerPlantAhuChilledWater,
                $txnReplySlipChillerPlantStandbyAhu,$txnReplySlipChillerPlantChiller,$txnReplySlipEscalatorYesNo,
                $txnReplySlipEscalatorMotorStartup,$txnReplySlipEscalatorVsdMitigation,$txnReplySlipEscalatorBrakingSystem,
                $txnReplySlipEscalatorControl,$txnReplySlipHidLampYesNo,$txnReplySlipHidLampMitigation,
                $txnReplySlipLiftYesNo,$txnReplySlipLiftOperation,
                $txnReplySlipSensitiveMachineYesNo,$txnReplySlipSensitiveMachineMitigation,
                $txnReplySlipTelecomMachineYesNo,$txnReplySlipTelecomMachineServerOrComputer,
                $txnReplySlipTelecomMachinePeripherals,$txnReplySlipTelecomMachineHarmonicEmission,
                $txnReplySlipAirConditionersYesNo,$txnReplySlipAirConditionersMicb,
                $txnReplySlipAirConditionersLoadForecasting,$txnReplySlipAirConditionersType,
                $txnReplySlipNonLinearLoadYesNo,$txnReplySlipNonLinearLoadHarmonicEmission,
                $txnReplySlipRenewableEnergyYesNo,$txnReplySlipRenewableEnergyInverterAndControls,
                $txnReplySlipRenewableEnergyHarmonicEmission,$txnReplySlipEvChargerSystemYesNo,$txnReplySlipEvControlYesNo,
                $txnReplySlipEvChargerSystemEvCharger,$txnReplySlipEvChargerSystemSmartYesNo,
                $txnReplySlipEvChargerSystemSmartChargingSystem,$txnReplySlipEvChargerSystemHarmonicEmission,
                $txnReplySlipConsultantNameConfirmation,$txnReplySlipConsultantCompany,
                $txnReplySlipProjectOwnerNameConfirmation,$txnReplySlipProjectOwnerCompany,
                $txnFirstInvitationLetterIssueDate,$txnFirstInvitationLetterFaxRefNo,$txnFirstInvitationLetterEdmsLink,
                $txnFirstInvitationLetterAccept,$txnFirstInvitationLetterWalkDate,
                $txnSecondInvitationLetterIssueDate,$txnSecondInvitationLetterFaxRefNo,$txnSecondInvitationLetterEdmsLink,
                $txnSecondInvitationLetterAccept,$txnSecondInvitationLetterWalkDate,
                $txnThirdInvitationLetterIssueDate,$txnThirdInvitationLetterFaxRefNo,$txnThirdInvitationLetterEdmsLink,
                $txnThirdInvitationLetterAccept,$txnThirdInvitationLetterWalkDate,
                $txnForthInvitationLetterIssueDate,$txnForthInvitationLetterFaxRefNo,$txnForthInvitationLetterEdmsLink,
                $txnForthInvitationLetterAccept,$txnForthInvitationLetterWalkDate,
                $txnEvaReportId,$txnEvaReportRemark,$txnEvaReportEdmsLink,$txnEvaReportIssueDate,$txnEvaReportFaxRefNo,
                $txnEvaReportScore,$txnEvaReportBmsYesNo,$txnEvaReportBmsServerCentralComputerYesNo,
                $txnEvaReportBmsServerCentralComputerFinding,$txnEvaReportBmsServerCentralComputerRecommend,
                $txnEvaReportBmsServerCentralComputerPass,$txnEvaReportBmsDdcYesNo,$txnEvaReportBmsDdcFinding,
                $txnEvaReportBmsDdcRecommend,$txnEvaReportBmsDdcPass,$txnEvaReportBmsSupplementYesNo,
                $txnEvaReportBmsSupplement,$txnEvaReportBmsSupplementPass,$txnEvaReportChangeoverSchemeYesNo,
                $txnEvaReportChangeoverSchemeControlYesNo,$txnEvaReportChangeoverSchemeControlFinding,
                $txnEvaReportChangeoverSchemeControlRecommend,$txnEvaReportChangeoverSchemeControlPass,
                $txnEvaReportChangeoverSchemeUvYesNo,$txnEvaReportChangeoverSchemeUvFinding,
                $txnEvaReportChangeoverSchemeUvRecommend,$txnEvaReportChangeoverSchemeUvPass,
                $txnEvaReportChangeoverSchemeSupplementYesNo,$txnEvaReportChangeoverSchemeSupplement,
                $txnEvaReportChangeoverSchemeSupplementPass,$txnEvaReportChillerPlantYesNo,
                $txnEvaReportChillerPlantAhuChilledWaterYesNo,$txnEvaReportChillerPlantAhuChilledWaterFinding,
                $txnEvaReportChillerPlantAhuChilledWaterRecommend,$txnEvaReportChillerPlantAhuChilledWaterPass,
                $txnEvaReportChillerPlantChillerYesNo,$txnEvaReportChillerPlantChillerFinding,
                $txnEvaReportChillerPlantChillerRecommend,$txnEvaReportChillerPlantChillerPass,
                $txnEvaReportChillerPlantSupplementYesNo,$txnEvaReportChillerPlantSupplement,
                $txnEvaReportChillerPlantSupplementPass,$txnEvaReportEscalatorYesNo,$txnEvaReportEscalatorBrakingSystemYesNo,
                $txnEvaReportEscalatorBrakingSystemFinding,$txnEvaReportEscalatorBrakingSystemRecommend,
                $txnEvaReportEscalatorBrakingSystemPass,$txnEvaReportEscalatorControlYesNo,$txnEvaReportEscalatorControlFinding,
                $txnEvaReportEscalatorControlRecommend,$txnEvaReportEscalatorControlPass,$txnEvaReportEscalatorSupplementYesNo,
                $txnEvaReportEscalatorSupplement,$txnEvaReportEscalatorSupplementPass,$txnEvaReportLiftYesNo,
                $txnEvaReportLiftOperationYesNo,$txnEvaReportLiftOperationFinding,$txnEvaReportLiftOperationRecommend,
                $txnEvaReportLiftOperationPass,$txnEvaReportLiftMainSupplyYesNo,$txnEvaReportLiftMainSupplyFinding,
                $txnEvaReportLiftMainSupplyRecommend,$txnEvaReportLiftMainSupplyPass,$txnEvaReportLiftSupplementYesNo,
                $txnEvaReportLiftSupplement,$txnEvaReportLiftSupplementPass,$txnEvaReportHidLampYesNo,
                $txnEvaReportHidLampBallastYesNo,$txnEvaReportHidLampBallastFinding,$txnEvaReportHidLampBallastRecommend,
                $txnEvaReportHidLampBallastPass,$txnEvaReportHidLampAddonProtectYesNo,$txnEvaReportHidLampAddonProtectFinding,
                $txnEvaReportHidLampAddonProtectRecommend,$txnEvaReportHidLampAddonProtectPass,
                $txnEvaReportHidLampSupplementYesNo,$txnEvaReportHidLampSupplement,$txnEvaReportHidLampSupplementPass,
                $txnEvaReportSensitiveMachineYesNo,$txnEvaReportSensitiveMachineMedicalYesNo,
                $txnEvaReportSensitiveMachineMedicalFinding,$txnEvaReportSensitiveMachineMedicalRecommend,
                $txnEvaReportSensitiveMachineMedicalPass,$txnEvaReportSensitiveMachineSupplementYesNo,
                $txnEvaReportSensitiveMachineSupplement,$txnEvaReportSensitiveMachineSupplementPass,$txnEvaReportTelecomMachineYesNo,
                $txnEvaReportTelecomMachineServerOrComputerYesNo,$txnEvaReportTelecomMachineServerOrComputerFinding,
                $txnEvaReportTelecomMachineServerOrComputerRecommend,$txnEvaReportTelecomMachineServerOrComputerPass,
                $txnEvaReportTelecomMachinePeripheralsYesNo,$txnEvaReportTelecomMachinePeripheralsFinding,
                $txnEvaReportTelecomMachinePeripheralsRecommend,$txnEvaReportTelecomMachinePeripheralsPass,
                $txnEvaReportTelecomMachineHarmonicEmissionYesNo,$txnEvaReportTelecomMachineHarmonicEmissionFinding,
                $txnEvaReportTelecomMachineHarmonicEmissionRecommend,$txnEvaReportTelecomMachineHarmonicEmissionPass,
                $txnEvaReportTelecomMachineSupplementYesNo,$txnEvaReportTelecomMachineSupplement,
                $txnEvaReportTelecomMachineSupplementPass,$txnEvaReportAirConditionersYesNo,$txnEvaReportAirConditionersMicbYesNo,
                $txnEvaReportAirConditionersMicbFinding,$txnEvaReportAirConditionersMicbRecommend,$txnEvaReportAirConditionersMicbPass,
                $txnEvaReportAirConditionersLoadForecastingYesNo,$txnEvaReportAirConditionersLoadForecastingFinding,
                $txnEvaReportAirConditionersLoadForecastingRecommend,$txnEvaReportAirConditionersLoadForecastingPass,
                $txnEvaReportAirConditionersTypeYesNo,$txnEvaReportAirConditionersTypeFinding,$txnEvaReportAirConditionersTypeRecommend,
                $txnEvaReportAirConditionersTypePass,$txnEvaReportAirConditionersSupplementYesNo,$txnEvaReportAirConditionersSupplement,
                $txnEvaReportAirConditionersSupplementPass,$txnEvaReportNonLinearLoadYesNo,$txnEvaReportNonLinearLoadHarmonicEmissionYesNo,
                $txnEvaReportNonLinearLoadHarmonicEmissionFinding,$txnEvaReportNonLinearLoadHarmonicEmissionRecommend,
                $txnEvaReportNonLinearLoadHarmonicEmissionPass,$txnEvaReportNonLinearLoadSupplementYesNo,
                $txnEvaReportNonLinearLoadSupplement,$txnEvaReportNonLinearLoadSupplementPass,$txnEvaReportRenewableEnergyYesNo,
                $txnEvaReportRenewableEnergyInverterAndControlsYesNo,$txnEvaReportRenewableEnergyInverterAndControlsFinding,
                $txnEvaReportRenewableEnergyInverterAndControlsRecommend,$txnEvaReportRenewableEnergyInverterAndControlsPass,
                $txnEvaReportRenewableEnergyHarmonicEmissionYesNo,$txnEvaReportRenewableEnergyHarmonicEmissionFinding,
                $txnEvaReportRenewableEnergyHarmonicEmissionRecommend,$txnEvaReportRenewableEnergyHarmonicEmissionPass,
                $txnEvaReportRenewableEnergySupplementYesNo,$txnEvaReportRenewableEnergySupplement,
                $txnEvaReportRenewableEnergySupplementPass,$txnEvaReportEvChargerSystemYesNo,$txnEvaReportEvChargerSystemEvChargerYesNo,
                $txnEvaReportEvChargerSystemEvChargerFinding,$txnEvaReportEvChargerSystemEvChargerRecommend,
                $txnEvaReportEvChargerSystemEvChargerPass,$txnEvaReportEvChargerSystemHarmonicEmissionYesNo,
                $txnEvaReportEvChargerSystemHarmonicEmissionFinding,$txnEvaReportEvChargerSystemHarmonicEmissionRecommend,
                $txnEvaReportEvChargerSystemHarmonicEmissionPass,$txnEvaReportEvChargerSystemSupplementYesNo,
                $txnEvaReportEvChargerSystemSupplement,$txnEvaReportEvChargerSystemSupplementPass,
                $txnReEvaReportId,$txnReEvaReportRemark,$txnReEvaReportEdmsLink,$txnReEvaReportIssueDate,$txnReEvaReportFaxRefNo,
                $txnReEvaReportScore,$txnReEvaReportBmsYesNo,$txnReEvaReportBmsServerCentralComputerYesNo,
                $txnReEvaReportBmsServerCentralComputerFinding,$txnReEvaReportBmsServerCentralComputerRecommend,
                $txnReEvaReportBmsServerCentralComputerPass,$txnReEvaReportBmsDdcYesNo,$txnReEvaReportBmsDdcFinding,
                $txnReEvaReportBmsDdcRecommend,$txnReEvaReportBmsDdcPass,$txnReEvaReportBmsSupplementYesNo,
                $txnReEvaReportBmsSupplement,$txnReEvaReportBmsSupplementPass,$txnReEvaReportChangeoverSchemeYesNo,
                $txnReEvaReportChangeoverSchemeControlYesNo,$txnReEvaReportChangeoverSchemeControlFinding,
                $txnReEvaReportChangeoverSchemeControlRecommend,$txnReEvaReportChangeoverSchemeControlPass,
                $txnReEvaReportChangeoverSchemeUvYesNo,$txnReEvaReportChangeoverSchemeUvFinding,
                $txnReEvaReportChangeoverSchemeUvRecommend,$txnReEvaReportChangeoverSchemeUvPass,
                $txnReEvaReportChangeoverSchemeSupplementYesNo,$txnReEvaReportChangeoverSchemeSupplement,
                $txnReEvaReportChangeoverSchemeSupplementPass,$txnReEvaReportChillerPlantYesNo,
                $txnReEvaReportChillerPlantAhuChilledWaterYesNo,$txnReEvaReportChillerPlantAhuChilledWaterFinding,
                $txnReEvaReportChillerPlantAhuChilledWaterRecommend,$txnReEvaReportChillerPlantAhuChilledWaterPass,
                $txnReEvaReportChillerPlantChillerYesNo,$txnReEvaReportChillerPlantChillerFinding,
                $txnReEvaReportChillerPlantChillerRecommend,$txnReEvaReportChillerPlantChillerPass,
                $txnReEvaReportChillerPlantSupplementYesNo,$txnReEvaReportChillerPlantSupplement,
                $txnReEvaReportChillerPlantSupplementPass,$txnReEvaReportEscalatorYesNo,$txnReEvaReportEscalatorBrakingSystemYesNo,
                $txnReEvaReportEscalatorBrakingSystemFinding,$txnReEvaReportEscalatorBrakingSystemRecommend,
                $txnReEvaReportEscalatorBrakingSystemPass,$txnReEvaReportEscalatorControlYesNo,$txnReEvaReportEscalatorControlFinding,
                $txnReEvaReportEscalatorControlRecommend,$txnReEvaReportEscalatorControlPass,$txnReEvaReportEscalatorSupplementYesNo,
                $txnReEvaReportEscalatorSupplement,$txnReEvaReportEscalatorSupplementPass,$txnReEvaReportLiftYesNo,
                $txnReEvaReportLiftOperationYesNo,$txnReEvaReportLiftOperationFinding,$txnReEvaReportLiftOperationRecommend,
                $txnReEvaReportLiftOperationPass,$txnReEvaReportLiftMainSupplyYesNo,$txnReEvaReportLiftMainSupplyFinding,
                $txnReEvaReportLiftMainSupplyRecommend,$txnReEvaReportLiftMainSupplyPass,$txnReEvaReportLiftSupplementYesNo,
                $txnReEvaReportLiftSupplement,$txnReEvaReportLiftSupplementPass,$txnReEvaReportHidLampYesNo,
                $txnReEvaReportHidLampBallastYesNo,$txnReEvaReportHidLampBallastFinding,$txnReEvaReportHidLampBallastRecommend,
                $txnReEvaReportHidLampBallastPass,$txnReEvaReportHidLampAddonProtectYesNo,$txnReEvaReportHidLampAddonProtectFinding,
                $txnReEvaReportHidLampAddonProtectRecommend,$txnReEvaReportHidLampAddonProtectPass,
                $txnReEvaReportHidLampSupplementYesNo,$txnReEvaReportHidLampSupplement,$txnReEvaReportHidLampSupplementPass,
                $txnReEvaReportSensitiveMachineYesNo,$txnReEvaReportSensitiveMachineMedicalYesNo,
                $txnReEvaReportSensitiveMachineMedicalFinding,$txnReEvaReportSensitiveMachineMedicalRecommend,
                $txnReEvaReportSensitiveMachineMedicalPass,$txnReEvaReportSensitiveMachineSupplementYesNo,
                $txnReEvaReportSensitiveMachineSupplement,$txnReEvaReportSensitiveMachineSupplementPass,$txnReEvaReportTelecomMachineYesNo,
                $txnReEvaReportTelecomMachineServerOrComputerYesNo,$txnReEvaReportTelecomMachineServerOrComputerFinding,
                $txnReEvaReportTelecomMachineServerOrComputerRecommend,$txnReEvaReportTelecomMachineServerOrComputerPass,
                $txnReEvaReportTelecomMachinePeripheralsYesNo,$txnReEvaReportTelecomMachinePeripheralsFinding,
                $txnReEvaReportTelecomMachinePeripheralsRecommend,$txnReEvaReportTelecomMachinePeripheralsPass,
                $txnReEvaReportTelecomMachineHarmonicEmissionYesNo,$txnReEvaReportTelecomMachineHarmonicEmissionFinding,
                $txnReEvaReportTelecomMachineHarmonicEmissionRecommend,$txnReEvaReportTelecomMachineHarmonicEmissionPass,
                $txnReEvaReportTelecomMachineSupplementYesNo,$txnReEvaReportTelecomMachineSupplement,
                $txnReEvaReportTelecomMachineSupplementPass,$txnReEvaReportAirConditionersYesNo,$txnReEvaReportAirConditionersMicbYesNo,
                $txnReEvaReportAirConditionersMicbFinding,$txnReEvaReportAirConditionersMicbRecommend,$txnReEvaReportAirConditionersMicbPass,
                $txnReEvaReportAirConditionersLoadForecastingYesNo,$txnReEvaReportAirConditionersLoadForecastingFinding,
                $txnReEvaReportAirConditionersLoadForecastingRecommend,$txnReEvaReportAirConditionersLoadForecastingPass,
                $txnReEvaReportAirConditionersTypeYesNo,$txnReEvaReportAirConditionersTypeFinding,$txnReEvaReportAirConditionersTypeRecommend,
                $txnReEvaReportAirConditionersTypePass,$txnReEvaReportAirConditionersSupplementYesNo,$txnReEvaReportAirConditionersSupplement,
                $txnReEvaReportAirConditionersSupplementPass,$txnReEvaReportNonLinearLoadYesNo,$txnReEvaReportNonLinearLoadHarmonicEmissionYesNo,
                $txnReEvaReportNonLinearLoadHarmonicEmissionFinding,$txnReEvaReportNonLinearLoadHarmonicEmissionRecommend,
                $txnReEvaReportNonLinearLoadHarmonicEmissionPass,$txnReEvaReportNonLinearLoadSupplementYesNo,
                $txnReEvaReportNonLinearLoadSupplement,$txnReEvaReportNonLinearLoadSupplementPass,$txnReEvaReportRenewableEnergyYesNo,
                $txnReEvaReportRenewableEnergyInverterAndControlsYesNo,$txnReEvaReportRenewableEnergyInverterAndControlsFinding,
                $txnReEvaReportRenewableEnergyInverterAndControlsRecommend,$txnReEvaReportRenewableEnergyInverterAndControlsPass,
                $txnReEvaReportRenewableEnergyHarmonicEmissionYesNo,$txnReEvaReportRenewableEnergyHarmonicEmissionFinding,
                $txnReEvaReportRenewableEnergyHarmonicEmissionRecommend,$txnReEvaReportRenewableEnergyHarmonicEmissionPass,
                $txnReEvaReportRenewableEnergySupplementYesNo,$txnReEvaReportRenewableEnergySupplement,
                $txnReEvaReportRenewableEnergySupplementPass,$txnReEvaReportEvChargerSystemYesNo,$txnReEvaReportEvChargerSystemEvChargerYesNo,
                $txnReEvaReportEvChargerSystemEvChargerFinding,$txnReEvaReportEvChargerSystemEvChargerRecommend,
                $txnReEvaReportEvChargerSystemEvChargerPass,$txnReEvaReportEvChargerSystemHarmonicEmissionYesNo,
                $txnReEvaReportEvChargerSystemHarmonicEmissionFinding,$txnReEvaReportEvChargerSystemHarmonicEmissionRecommend,
                $txnReEvaReportEvChargerSystemHarmonicEmissionPass,$txnReEvaReportEvChargerSystemSupplementYesNo,
                $txnReEvaReportEvChargerSystemSupplement,$txnReEvaReportEvChargerSystemSupplementPass,
                $currState['state'],$txnNewState,$lastUpdatedBy,$lastUpdatedTime,
                $txnPlanningAheadId);

        } else {
            $retJson['status'] = 'NOTOK';
        }

        echo json_encode($retJson);
    }

    // *************************************
    // ***** Internal Utility function *****
    // *************************************

    // *******************************************
    // Generate reply slip template and save to
    // pre-defined path.
    // *******************************************
    private function generateReplySlipTemplate($schemeNo) {

        $recordList = Yii::app()->planningAheadDao->getPlanningAheadDetails($schemeNo);

        $checkedBox='<w:sym w:font="Wingdings" w:char="F0FE"/>';
        $unCheckedBox = '<w:sym w:font="Wingdings" w:char="F0A8"/>';

        $replySlipTemplatePath = Yii::app()->commonUtil->getConfigValueByConfigName('planningAheadReplySlipTemplatePath');
        $replySlipTemplateFileName = Yii::app()->commonUtil->getConfigValueByConfigName('planningAheadReplySlipTemplateFileName');

        $templateProcessor = new TemplateProcessor($replySlipTemplatePath['configValue'] . $replySlipTemplateFileName['configValue']);

        $templateProcessor->setValue('projectTitle', $this->formatToWordTemplate($recordList['projectTitle']));
        $templateProcessor->setValue('commissionDate', $recordList['commissionDate']);
        if ($recordList['replySlipBmsYesNo'] == 'Y') {
            $templateProcessor->setValue('BmsYesNo', $checkedBox);
        } else {
            $templateProcessor->setValue('BmsYesNo', $unCheckedBox);
        }
        $templateProcessor->setValue('BmsServerCentralComputer', $this->formatToWordTemplate($recordList['replySlipBmsServerCentralComputer']));
        $templateProcessor->setValue('BmsDdc', $this->formatToWordTemplate($recordList['replySlipBmsDdc']));
        if ($recordList['replySlipChangeoverSchemeYesNo'] == 'Y') {
            $templateProcessor->setValue('ChangeoverSchemeYesNo', $checkedBox);
        } else {
            $templateProcessor->setValue('ChangeoverSchemeYesNo', $unCheckedBox);
        }
        $templateProcessor->setValue('ChangeoverSchemeControl', $this->formatToWordTemplate($recordList['replySlipChangeoverSchemeControl']));
        $templateProcessor->setValue('ChangeoverSchemeUv', $this->formatToWordTemplate($recordList['replySlipChangeoverSchemeUv']));

        if ($recordList['replySlipChillerPlantYesNo'] == 'Y') {
            $templateProcessor->setValue('ChillerPlantYesNo', $checkedBox);
        } else {
            $templateProcessor->setValue('ChillerPlantYesNo', $unCheckedBox);
        }
        $templateProcessor->setValue('ChillerPlantAhuControl', $this->formatToWordTemplate($recordList['replySlipChillerPlantAhuControl']));
        $templateProcessor->setValue('ChillerPlantAhuStartup', $this->formatToWordTemplate($recordList['replySlipChillerPlantAhuStartup']));
        $templateProcessor->setValue('ChillerPlantVsd', $this->formatToWordTemplate($recordList['replySlipChillerPlantVsd']));
        $templateProcessor->setValue('ChillerPlantAhuChilledWater', $this->formatToWordTemplate($recordList['replySlipChillerPlantAhuChilledWater']));
        $templateProcessor->setValue('ChillerPlantStandbyAhu', $this->formatToWordTemplate($recordList['replySlipChillerPlantStandbyAhu']));
        $templateProcessor->setValue('ChillerPlantChiller', $this->formatToWordTemplate($recordList['replySlipChillerPlantChiller']));
        if ($recordList['replySlipEscalatorYesNo'] == 'Y') {
            $templateProcessor->setValue('EscalatorYesNo', $checkedBox);
        } else {
            $templateProcessor->setValue('EscalatorYesNo', $unCheckedBox);
        }
        $templateProcessor->setValue('EscalatorMotorStartup', $this->formatToWordTemplate($recordList['replySlipEscalatorMotorStartup']));
        $templateProcessor->setValue('EscalatorVsdMitigation', $this->formatToWordTemplate($recordList['replySlipEscalatorVsdMitigation']));
        $templateProcessor->setValue('EscalatorBrakingSystem', $this->formatToWordTemplate($recordList['replySlipEscalatorBrakingSystem']));
        $templateProcessor->setValue('EscalatorControl', $this->formatToWordTemplate($recordList['replySlipEscalatorControl']));
        if ($recordList['replySlipHidLampYesNo'] == 'Y') {
            $templateProcessor->setValue('HidLampYesNo', $checkedBox);
        } else {
            $templateProcessor->setValue('HidLampYesNo', $unCheckedBox);
        }
        $templateProcessor->setValue('HidLampMitigation', $this->formatToWordTemplate($recordList['replySlipHidLampMitigation']));
        if ($recordList['replySlipLiftYesNo'] == 'Y') {
            $templateProcessor->setValue('LiftYesNo', $checkedBox);
        } else {
            $templateProcessor->setValue('LiftYesNo', $unCheckedBox);
        }
        $templateProcessor->setValue('LiftOperation', $this->formatToWordTemplate($recordList['replySlipLiftOperation']));
        if ($recordList['replySlipSensitiveMachineYesNo'] == 'Y') {
            $templateProcessor->setValue('SensitiveMachineYesNo', $checkedBox);
        } else {
            $templateProcessor->setValue('SensitiveMachineYesNo', $unCheckedBox);
        }
        $templateProcessor->setValue('SensitiveMachineMitigation', $this->formatToWordTemplate($recordList['replySlipSensitiveMachineMitigation']));
        if ($recordList['replySlipTelecomMachineYesNo'] == 'Y') {
            $templateProcessor->setValue('TelecomMachineYesNo', $checkedBox);
        } else {
            $templateProcessor->setValue('TelecomMachineYesNo', $unCheckedBox);
        }
        $templateProcessor->setValue('TelecomMachineServerOrComputer', $this->formatToWordTemplate($recordList['replySlipTelecomMachineServerOrComputer']));
        $templateProcessor->setValue('TelecomMachinePeripherals', $this->formatToWordTemplate($recordList['replySlipTelecomMachinePeripherals']));
        $templateProcessor->setValue('TelecomMachineHarmonicEmission', $this->formatToWordTemplate($recordList['replySlipTelecomMachineHarmonicEmission']));
        if ($recordList['replySlipAirConditionersYesNo'] == 'Y') {
            $templateProcessor->setValue('AirConditionersYesNo', $checkedBox);
        } else {
            $templateProcessor->setValue('AirConditionersYesNo', $unCheckedBox);
        }
        $templateProcessor->setValue('AirConditionersMicb', $this->formatToWordTemplate($recordList['replySlipAirConditionersMicb']));
        $templateProcessor->setValue('AirConditionersLoadForecasting', $this->formatToWordTemplate($recordList['replySlipAirConditionersLoadForecasting']));
        $templateProcessor->setValue('AirConditionersType', $this->formatToWordTemplate($recordList['replySlipAirConditionersType']));
        if ($recordList['replySlipNonLinearLoadYesNo'] == 'Y') {
            $templateProcessor->setValue('NonLinearLoadYesNo', $checkedBox);
        } else {
            $templateProcessor->setValue('NonLinearLoadYesNo', $unCheckedBox);
        }
        $templateProcessor->setValue('NonLinearLoadHarmonicEmission', $this->formatToWordTemplate($recordList['replySlipNonLinearLoadHarmonicEmission']));
        if ($recordList['replySlipRenewableEnergyYesNo'] == 'Y') {
            $templateProcessor->setValue('RenewableEnergyYesNo', $checkedBox);
        } else {
            $templateProcessor->setValue('RenewableEnergyYesNo', $unCheckedBox);
        }
        $templateProcessor->setValue('RenewableEnergyInverterAndControls', $this->formatToWordTemplate($recordList['replySlipRenewableEnergyInverterAndControls']));
        $templateProcessor->setValue('RenewableEnergyHarmonicEmission', $this->formatToWordTemplate($recordList['replySlipRenewableEnergyHarmonicEmission']));
        if ($recordList['replySlipEvChargerSystemYesNo'] == 'Y') {
            $templateProcessor->setValue('EvChargerSystemYesNo', $checkedBox);
        } else {
            $templateProcessor->setValue('EvChargerSystemYesNo', $unCheckedBox);
        }
        if ($recordList['replySlipEvControlYesNo'] == 'Y') {
            $templateProcessor->setValue('EvControlYesNo', $checkedBox);
        } else {
            $templateProcessor->setValue('EvControlYesNo', $unCheckedBox);
        }
        $templateProcessor->setValue('EvChargerSystemEvCharger', $this->formatToWordTemplate($recordList['replySlipEvChargerSystemEvCharger']));
        if ($recordList['replySlipEvChargerSystemSmartYesNo'] == 'Y') {
            $templateProcessor->setValue('EvChargerSystemSmartYesNo', $checkedBox);
        } else {
            $templateProcessor->setValue('EvChargerSystemSmartYesNo', $unCheckedBox);
        }
        $templateProcessor->setValue('EvChargerSystemSmartChargingSystem', $this->formatToWordTemplate($recordList['replySlipEvChargerSystemSmartChargingSystem']));
        $templateProcessor->setValue('EvChargerSystemHarmonicEmission', $this->formatToWordTemplate($recordList['replySlipEvChargerSystemHarmonicEmission']));
        $templateProcessor->setValue('ConsultantNameConfirmation', $this->formatToWordTemplate($recordList['replySlipConsultantNameConfirmation']));
        $templateProcessor->setValue('ConsultantCompany', $this->formatToWordTemplate($recordList['replySlipConsultantCompany']));
        $templateProcessor->setValue('ProjectOwnerNameConfirmation', $this->formatToWordTemplate($recordList['replySlipProjectOwnerNameConfirmation']));
        $templateProcessor->setValue('ProjectOwnerCompany', $this->formatToWordTemplate($recordList['replySlipProjectOwnerCompany']));
        $templateProcessor->setValue('replySlipSignedDate', $this->formatToWordTemplate($recordList['replySlipLastUploadTime']));

        $pathToSave = $replySlipTemplatePath['configValue'] . 'temp\\(' . $schemeNo . ')' . $replySlipTemplateFileName['configValue'];
        $templateProcessor->saveAs($pathToSave);
        chmod($pathToSave, 0644);

        // save the generated file path to DB
        $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
        $lastUpdatedTime = date("Y-m-d H:i");
        Yii::app()->planningAheadDao->updateReplySlipGeneratedLocation($recordList['meetingReplySlipId'],$pathToSave,
            $lastUpdatedBy, $lastUpdatedTime);

        return $pathToSave;
    }


    private function getPostParamString($param) {
        if (isset($_POST[$param]) && ($_POST[$param] != "")) {
            return trim($_POST[$param]);
        } else {
            return null;
        }
    }

    private function getPostParamBoolean($param) {
        if (isset($_POST[$param]) && ($_POST[$param] != "")) {
            return trim($_POST[$param]);
        } else {
            return 'N';
        }
    }

    private function getPostParamInteger($param) {
        if (isset($_POST[$param]) && ($_POST[$param] != "")) {
            return trim($_POST[$param]);
        } else {
            return 0;
        }
    }

    private function replaceListToLines($value) {
        if (isset($value)) {
            $value = str_replace("[\"","",$value);
            $value = str_replace("\"]","",$value);

            return str_replace("\",\"","\n",$value);
        } else {
            return $value;
        }
    }

    private function formatToWordTemplate($value) {
        if (isset($value)) {
            $value = htmlspecialchars(trim($value));
            return str_replace("\\n", "<w:br />", $value);
        } else {
            return $value;
        }
    }

}
?>