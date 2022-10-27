<?php

use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\PhpWord;

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

    // Load the upload form for allowing user to upload Consultant Meeting Information File
    public function actionGetUploadConsultantMeetingInfoForm() {

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        $this->render("//site/Form/PlanningAheadUploadConsultantMeetingInfo");
    }

    // process the uploaded consultant meeting information file and save its information to DB
    public function actionPostUploadConsultantMeetingInfo() {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

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

    // Load the upload form for allowing user to upload Reply Slip File
    public function actionGetUploadReplySlipForm() {

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        $this->render("//site/Form/PlanningAheadUploadReplySlip");
    }

    // process the uploaded consultant meeting information file and save its information to DB
    public function actionPostUploadReplySlip() {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

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
                        $excelBmsYesNo = $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
                        if (strtoupper($excelBmsYesNo) == 'YES') {
                            $excelBmsYesNo = 'Y';
                        } else {
                            $excelBmsYesNo = 'N';
                        }
                        $excelBmsServerCentralComputer = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $excelBmsDdc = $objWorksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $excelChangeoverSchemeYesNo = $objWorksheet->getCellByColumnAndRow(7, $row)->getValue();
                        if (strtoupper($excelChangeoverSchemeYesNo) == 'YES') {
                            $excelChangeoverSchemeYesNo = 'Y';
                        } else {
                            $excelChangeoverSchemeYesNo = 'N';
                        }
                        $excelChangeoverSchemeControl = $objWorksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $excelChangeoverSchemeUv = $objWorksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $excelChillerPlantYesNo = $objWorksheet->getCellByColumnAndRow(10, $row)->getValue();
                        if (strtoupper($excelChillerPlantYesNo) == 'YES') {
                            $excelChillerPlantYesNo = 'Y';
                        } else {
                            $excelChillerPlantYesNo = 'N';
                        }
                        $excelChillerPlantAhu = $objWorksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $excelChillerPlantChiller = $objWorksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $excelEscalatorYesNo = $objWorksheet->getCellByColumnAndRow(13, $row)->getValue();
                        if (strtoupper($excelEscalatorYesNo) == 'YES') {
                            $excelEscalatorYesNo = 'Y';
                        } else {
                            $excelEscalatorYesNo = 'N';
                        }
                        $excelEscalatorBrakingSystem = $objWorksheet->getCellByColumnAndRow(14, $row)->getValue();
                        $excelEscalatorControl = $objWorksheet->getCellByColumnAndRow(15, $row)->getValue();
                        $excelLiftYesNo = $objWorksheet->getCellByColumnAndRow(16, $row)->getValue();
                        if (strtoupper($excelLiftYesNo) == 'YES') {
                            $excelLiftYesNo = 'Y';
                        } else {
                            $excelLiftYesNo = 'N';
                        }
                        $excelLiftOperation = $objWorksheet->getCellByColumnAndRow(17, $row)->getValue();
                        $excelHidLampYesNo = $objWorksheet->getCellByColumnAndRow(18, $row)->getValue();
                        if (strtoupper($excelHidLampYesNo) == 'YES') {
                            $excelHidLampYesNo = 'Y';
                        } else {
                            $excelHidLampYesNo = 'N';
                        }
                        $excelHidLampBallast = $objWorksheet->getCellByColumnAndRow(19, $row)->getValue();
                        $excelHidLampAddOnProtection = $objWorksheet->getCellByColumnAndRow(20, $row)->getValue();
                        $excelSensitiveMachineYesNo = $objWorksheet->getCellByColumnAndRow(21, $row)->getValue();
                        if (strtoupper($excelSensitiveMachineYesNo) == 'YES') {
                            $excelSensitiveMachineYesNo = 'Y';
                        } else {
                            $excelSensitiveMachineYesNo = 'N';
                        }
                        $excelSensitiveMachineMitigation = $objWorksheet->getCellByColumnAndRow(22, $row)->getValue();
                        $excelTelecomMachineYesNo = $objWorksheet->getCellByColumnAndRow(23, $row)->getValue();
                        if (strtoupper($excelTelecomMachineYesNo) == 'YES') {
                            $excelTelecomMachineYesNo = 'Y';
                        } else {
                            $excelTelecomMachineYesNo = 'N';
                        }
                        $excelTelecomMachineServerOrComputer = $objWorksheet->getCellByColumnAndRow(24, $row)->getValue();
                        $excelTelecomMachinePeripherals = $objWorksheet->getCellByColumnAndRow(25, $row)->getValue();
                        $excelTelecomMachineHarmonicEmission = $objWorksheet->getCellByColumnAndRow(26, $row)->getValue();
                        $excelAirConditionersYesNo = $objWorksheet->getCellByColumnAndRow(27, $row)->getValue();
                        if (strtoupper($excelAirConditionersYesNo) == 'YES') {
                            $excelAirConditionersYesNo = 'Y';
                        } else {
                            $excelAirConditionersYesNo = 'N';
                        }
                        $excelAirConditionersMicb = $objWorksheet->getCellByColumnAndRow(28, $row)->getValue();
                        $excelAirConditionersLoadForecasting = $objWorksheet->getCellByColumnAndRow(29, $row)->getValue();
                        $excelAirConditionersType = $objWorksheet->getCellByColumnAndRow(30, $row)->getValue();
                        $excelNonLinearLoadYesNo = $objWorksheet->getCellByColumnAndRow(31, $row)->getValue();
                        if (strtoupper($excelNonLinearLoadYesNo) == 'YES') {
                            $excelNonLinearLoadYesNo = 'Y';
                        } else {
                            $excelNonLinearLoadYesNo = 'N';
                        }
                        $excelNonLinearLoadHarmonicEmission = $objWorksheet->getCellByColumnAndRow(32, $row)->getValue();
                        $excelRenewableEnergyYesNo = $objWorksheet->getCellByColumnAndRow(33, $row)->getValue();
                        if (strtoupper($excelRenewableEnergyYesNo) == 'YES') {
                            $excelRenewableEnergyYesNo = 'Y';
                        } else {
                            $excelRenewableEnergyYesNo = 'N';
                        }
                        $excelRenewableEnergyInverterAndControls = $objWorksheet->getCellByColumnAndRow(34, $row)->getValue();
                        $excelRenewableEnergyHarmonicEmission = $objWorksheet->getCellByColumnAndRow(35, $row)->getValue();
                        $excelEvChargerSystemYesNo = $objWorksheet->getCellByColumnAndRow(36, $row)->getValue();
                        if (strtoupper($excelEvChargerSystemYesNo) == 'YES') {
                            $excelEvChargerSystemYesNo = 'Y';
                        } else {
                            $excelEvChargerSystemYesNo = 'N';
                        }
                        $excelEvChargerSystemEvCharger = $objWorksheet->getCellByColumnAndRow(37, $row)->getValue();
                        $excelEvChargerSystemSmartChargingSystem = $objWorksheet->getCellByColumnAndRow(38, $row)->getValue();
                        $excelEvChargerSystemHarmonicEmission = $objWorksheet->getCellByColumnAndRow(39, $row)->getValue();
                        $createdBy = Yii::app()->session['tblUserDo']['username'];
                        $createdTime = date("Y-m-d H:i");
                        $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
                        $lastUpdatedTime = date("Y-m-d H:i");

                        $projectDetail = Yii::app()->planningAheadDao->getPlanningAheadDetails($excelSchemeNo);
                        if (isset($projectDetail)) {

                            if ($projectDetail['meetingReplySlipId'] == 0) {
                                $result = Yii::app()->planningAheadDao->addReplySlip($excelSchemeNo,$targetFilePath,
                                    $excelBmsYesNo,$excelBmsServerCentralComputer,$excelBmsDdc,
                                    $excelChangeoverSchemeYesNo,$excelChangeoverSchemeControl,$excelChangeoverSchemeUv,
                                    $excelChillerPlantYesNo,$excelChillerPlantAhu,$excelChillerPlantChiller,
                                    $excelEscalatorYesNo,$excelEscalatorBrakingSystem,$excelEscalatorControl,
                                    $excelLiftYesNo,$excelLiftOperation,$excelHidLampYesNo,$excelHidLampBallast,
                                    $excelHidLampAddOnProtection,$excelSensitiveMachineYesNo,$excelSensitiveMachineMitigation,
                                    $excelTelecomMachineYesNo,$excelTelecomMachineServerOrComputer,$excelTelecomMachinePeripherals,
                                    $excelTelecomMachineHarmonicEmission,$excelAirConditionersYesNo,$excelAirConditionersMicb,
                                    $excelAirConditionersLoadForecasting,$excelAirConditionersType,$excelNonLinearLoadYesNo,
                                    $excelNonLinearLoadHarmonicEmission,$excelRenewableEnergyYesNo,$excelRenewableEnergyInverterAndControls,
                                    $excelRenewableEnergyHarmonicEmission,$excelEvChargerSystemYesNo,$excelEvChargerSystemEvCharger,
                                    $excelEvChargerSystemSmartChargingSystem,$excelEvChargerSystemHarmonicEmission,
                                    $createdBy,$createdTime,$lastUpdatedBy,$lastUpdatedTime);

                            } else {
                                $result = Yii::app()->planningAheadDao->updateReplySlip($projectDetail['meetingReplySlipId'],
                                    $targetFilePath, $excelBmsYesNo,$excelBmsServerCentralComputer,$excelBmsDdc,
                                    $excelChangeoverSchemeYesNo,$excelChangeoverSchemeControl,$excelChangeoverSchemeUv,
                                    $excelChillerPlantYesNo,$excelChillerPlantAhu,$excelChillerPlantChiller,
                                    $excelEscalatorYesNo,$excelEscalatorBrakingSystem,$excelEscalatorControl,
                                    $excelLiftYesNo,$excelLiftOperation,$excelHidLampYesNo,$excelHidLampBallast,
                                    $excelHidLampAddOnProtection,$excelSensitiveMachineYesNo,$excelSensitiveMachineMitigation,
                                    $excelTelecomMachineYesNo,$excelTelecomMachineServerOrComputer,$excelTelecomMachinePeripherals,
                                    $excelTelecomMachineHarmonicEmission,$excelAirConditionersYesNo,$excelAirConditionersMicb,
                                    $excelAirConditionersLoadForecasting,$excelAirConditionersType,$excelNonLinearLoadYesNo,
                                    $excelNonLinearLoadHarmonicEmission,$excelRenewableEnergyYesNo,$excelRenewableEnergyInverterAndControls,
                                    $excelRenewableEnergyHarmonicEmission,$excelEvChargerSystemYesNo,$excelEvChargerSystemEvCharger,
                                    $excelEvChargerSystemSmartChargingSystem,$excelEvChargerSystemHarmonicEmission,
                                    $lastUpdatedBy,$lastUpdatedTime);
                            }

                            if ($result['status'] == 'OK') {
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
                $this->viewbag['resultMsg'] = 'Please select the condition letter in PDF format!';
                $this->viewbag['IsUploadSuccess'] = false;
            }
        } else {
            $this->viewbag['IsUploadSuccess'] = false;
            $this->viewbag['resultMsg'] = 'Please select the consultant meeting information file to upload!';
        }

        $this->render("//site/Form/PlanningAheadUploadReplySlip");
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
            $this->viewbag['secondConsultantCompanyId'] = $recordList['secondConsultantCompanyId'];
            $this->viewbag['secondConsultantCompanyName'] = $recordList['secondConsultantCompanyName'];
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
            $this->viewbag['replySlipBmsYesNo'] = $recordList['replySlipBmsYesNo'];
            $this->viewbag['replySlipBmsServerCentralComputer'] = $recordList['replySlipBmsServerCentralComputer'];
            $this->viewbag['replySlipBmsDdc'] = $recordList['replySlipBmsDdc'];
            $this->viewbag['replySlipChangeoverSchemeYesNo'] = $recordList['replySlipChangeoverSchemeYesNo'];
            $this->viewbag['replySlipChangeoverSchemeControl'] = $recordList['replySlipChangeoverSchemeControl'];
            $this->viewbag['replySlipChangeoverSchemeUv'] = $recordList['replySlipChangeoverSchemeUv'];
            $this->viewbag['replySlipChillerPlantYesNo'] = $recordList['replySlipChillerPlantYesNo'];
            $this->viewbag['replySlipChillerPlantAhu'] = $recordList['replySlipChillerPlantAhu'];
            $this->viewbag['replySlipChillerPlantChiller'] = $recordList['replySlipChillerPlantChiller'];
            $this->viewbag['replySlipEscalatorYesNo'] = $recordList['replySlipEscalatorYesNo'];
            $this->viewbag['replySlipEscalatorBrakingSystem'] = $recordList['replySlipEscalatorBrakingSystem'];
            $this->viewbag['replySlipEscalatorControl'] = $recordList['replySlipEscalatorControl'];
            $this->viewbag['replySlipHidLampYesNo'] = $recordList['replySlipHidLampYesNo'];
            $this->viewbag['replySlipHidLampBallast'] = $recordList['replySlipHidLampBallast'];
            $this->viewbag['replySlipHidLampAddOnProtection'] = $recordList['replySlipHidLampAddOnProtection'];
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
            $this->viewbag['replySlipEvChargerSystemEvCharger'] = $recordList['replySlipEvChargerSystemEvCharger'];
            $this->viewbag['replySlipEvChargerSystemSmartChargingSystem'] = $recordList['replySlipEvChargerSystemSmartChargingSystem'];
            $this->viewbag['replySlipEvChargerSystemHarmonicEmission'] = $recordList['replySlipEvChargerSystemHarmonicEmission'];
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
        $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
        $lastUpdatedTime = date("Y-m-d H:i");

        $recordList = Yii::app()->planningAheadDao->getPlanningAheadDetails($schemeNo);

        // Update the issue date and fax ref no. to database first
        Yii::app()->planningAheadDao->updateStandardLetter($recordList['planningAheadId'], $standLetterIssueDate,
            $standLetterFaxRefNo,$lastUpdatedBy,$lastUpdatedTime);

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

        $templateProcessor = new TemplateProcessor($firstInvitationLetterTemplatePath['configValue'] .
            $firstInvitationLetterTemplateFileName['configValue']);
        $templateProcessor->setValue('firstConsultantTitle', $recordList['firstConsultantTitle']);
        $templateProcessor->setValue('firstConsultantSurname', $recordList['firstConsultantSurname']);
        $templateProcessor->setValue('firstConsultantCompanyName', $recordList['firstConsultantCompanyName']);
        $templateProcessor->setValue('firstConsultantEmail', $recordList['firstConsultantEmail']);
        $templateProcessor->setValue('secondConsultantTitle', $recordList['secondConsultantTitle']);
        $templateProcessor->setValue('secondConsultantSurname', $recordList['secondConsultantSurname']);
        $templateProcessor->setValue('secondConsultantCompanyName', $recordList['secondConsultantCompanyName']);
        $templateProcessor->setValue('secondConsultantEmail', $recordList['secondConsultantEmail']);
        $templateProcessor->setValue('faxRefNo', $firstInvitationLetterFaxRefNo);
        $templateProcessor->setValue('issueDate', $firstInvitationLetterIssueDate);
        $templateProcessor->setValue('projectTitle', $recordList['projectTitle']);
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
        readfile($pathToSave,true);

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

        $templateProcessor = new TemplateProcessor($secondInvitationLetterTemplatePath['configValue'] .
            $secondInvitationLetterTemplateFileName['configValue']);
        $templateProcessor->setValue('firstConsultantTitle', $recordList['firstConsultantTitle']);
        $templateProcessor->setValue('firstConsultantSurname', $recordList['firstConsultantSurname']);
        $templateProcessor->setValue('firstConsultantCompanyName', $recordList['firstConsultantCompanyName']);
        $templateProcessor->setValue('firstConsultantEmail', $recordList['firstConsultantEmail']);
        $templateProcessor->setValue('secondConsultantTitle', $recordList['secondConsultantTitle']);
        $templateProcessor->setValue('secondConsultantSurname', $recordList['secondConsultantSurname']);
        $templateProcessor->setValue('secondConsultantCompanyName', $recordList['secondConsultantCompanyName']);
        $templateProcessor->setValue('secondConsultantEmail', $recordList['secondConsultantEmail']);
        $templateProcessor->setValue('faxRefNo', $secondInvitationLetterFaxRefNo);
        $templateProcessor->setValue('issueDate', $secondInvitationLetterIssueDate);
        $templateProcessor->setValue('projectTitle', $recordList['projectTitle']);
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

        if ($success && isset($_POST['secondConsultantTitle']) && ($_POST['secondConsultantTitle'] != "")) {
            $txnSecondConsultantTitle = trim($_POST['secondConsultantTitle']);
        } else {
            $txnSecondConsultantTitle = null;
        }

        if ($success && isset($_POST['secondConsultantSurname']) && ($_POST['secondConsultantSurname'] != "")) {
            $txnSecondConsultantSurname = trim($_POST['secondConsultantSurname']);
        } else {
            $txnSecondConsultantSurname = null;
        }

        if ($success && isset($_POST['secondConsultantOtherName']) && ($_POST['secondConsultantOtherName'] != "")) {
            $txnSecondConsultantOtherName = trim($_POST['secondConsultantOtherName']);
        } else {
            $txnSecondConsultantOtherName = null;
        }

        if ($success && isset($_POST['secondConsultantCompany']) && ($_POST['secondConsultantCompany'] != "")) {
            $txnSecondConsultantCompany = trim($_POST['secondConsultantCompany']);
        } else {
            $txnSecondConsultantCompany = null;
        }

        if ($success && isset($_POST['secondConsultantPhone']) && ($_POST['secondConsultantPhone'] != "")) {
            $txnSecondConsultantPhone = trim($_POST['secondConsultantPhone']);
        } else {
            $txnSecondConsultantPhone = null;
        }

        if ($success && isset($_POST['secondConsultantEmail']) && ($_POST['secondConsultantEmail'] != "")) {
            $txnSecondConsultantEmail = trim($_POST['secondConsultantEmail']);
        } else {
            $txnSecondConsultantEmail = null;
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

        if ($success && isset($_POST['meetingFirstPreferMeetingDate']) && ($_POST['meetingFirstPreferMeetingDate'] != "")) {
            $txnMeetingFirstPreferMeetingDate = trim($_POST['meetingFirstPreferMeetingDate']);
        } else {
            $txnMeetingFirstPreferMeetingDate = null;
        }

        if ($success && isset($_POST['meetingSecondPreferMeetingDate']) && ($_POST['meetingSecondPreferMeetingDate'] != "")) {
            $txnMeetingSecondPreferMeetingDate = trim($_POST['meetingSecondPreferMeetingDate']);
        } else {
            $txnMeetingSecondPreferMeetingDate = null;
        }

        if ($success && isset($_POST['meetingActualMeetingDate']) && ($_POST['meetingActualMeetingDate'] != "")) {
            $txnMeetingActualMeetingDate = trim($_POST['meetingActualMeetingDate']);
        } else {
            $txnMeetingActualMeetingDate = null;
        }

        if ($success && isset($_POST['meetingRejReason']) && ($_POST['meetingRejReason'] != "")) {
            $txnMeetingRejReason = trim($_POST['meetingRejReason']);
        } else {
            $txnMeetingRejReason = null;
        }

        if ($success && isset($_POST['meetingConsentConsultant']) && ($_POST['meetingConsentConsultant'] != "")) {
            $txnMeetingConsentConsultant = trim($_POST['meetingConsentConsultant']);
        } else {
            $txnMeetingConsentConsultant = 'N';
        }

        if ($success && isset($_POST['meetingConsentOwner']) && ($_POST['meetingConsentOwner'] != "")) {
            $txnMeetingConsentOwner = trim($_POST['meetingConsentOwner']);
        } else {
            $txnMeetingConsentOwner = 'N';
        }

        if ($success && isset($_POST['meetingReplySlipId']) && ($_POST['meetingReplySlipId'] != "")) {
            $txnMeetingReplySlipId = trim($_POST['meetingReplySlipId']);
        } else {
            $txnMeetingReplySlipId = null;
        }

        if ($success && isset($_POST['replySlipBmsYesNo']) && ($_POST['replySlipBmsYesNo'] != "")) {
            $txnReplySlipBmsYesNo = trim($_POST['replySlipBmsYesNo']);
        } else {
            $txnReplySlipBmsYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipBmsServerCentralComputer']) && ($_POST['replySlipBmsServerCentralComputer'] != "")) {
            $txnReplySlipBmsServerCentralComputer = trim($_POST['replySlipBmsServerCentralComputer']);
        } else {
            $txnReplySlipBmsServerCentralComputer = null;
        }

        if ($success && isset($_POST['replySlipBmsDdc']) && ($_POST['replySlipBmsDdc'] != "")) {
            $txnReplySlipBmsDdc = trim($_POST['replySlipBmsDdc']);
        } else {
            $txnReplySlipBmsDdc = null;
        }

        if ($success && isset($_POST['replySlipChangeoverSchemeYesNo']) && ($_POST['replySlipChangeoverSchemeYesNo'] != "")) {
            $txnReplySlipChangeoverSchemeYesNo = trim($_POST['replySlipChangeoverSchemeYesNo']);
        } else {
            $txnReplySlipChangeoverSchemeYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipChangeoverSchemeControl']) && ($_POST['replySlipChangeoverSchemeControl'] != "")) {
            $txnReplySlipChangeoverSchemeControl = trim($_POST['replySlipChangeoverSchemeControl']);
        } else {
            $txnReplySlipChangeoverSchemeControl = null;
        }

        if ($success && isset($_POST['replySlipChangeoverSchemeUv']) && ($_POST['replySlipChangeoverSchemeUv'] != "")) {
            $txnReplySlipChangeoverSchemeUv = trim($_POST['replySlipChangeoverSchemeUv']);
        } else {
            $txnReplySlipChangeoverSchemeUv = null;
        }

        if ($success && isset($_POST['replySlipChillerPlantYesNo']) && ($_POST['replySlipChillerPlantYesNo'] != "")) {
            $txnReplySlipChillerPlantYesNo = trim($_POST['replySlipChillerPlantYesNo']);
        } else {
            $txnReplySlipChillerPlantYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipChillerPlantAhu']) && ($_POST['replySlipChillerPlantAhu'] != "")) {
            $txnReplySlipChillerPlantAhu = trim($_POST['replySlipChillerPlantAhu']);
        } else {
            $txnReplySlipChillerPlantAhu = null;
        }

        if ($success && isset($_POST['replySlipChillerPlantChiller']) && ($_POST['replySlipChillerPlantChiller'] != "")) {
            $txnReplySlipChillerPlantChiller = trim($_POST['replySlipChillerPlantChiller']);
        } else {
            $txnReplySlipChillerPlantChiller = null;
        }

        if ($success && isset($_POST['replySlipEscalatorYesNo']) && ($_POST['replySlipEscalatorYesNo'] != "")) {
            $txnReplySlipEscalatorYesNo = trim($_POST['replySlipEscalatorYesNo']);
        } else {
            $txnReplySlipEscalatorYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipEscalatorBrakingSystem']) && ($_POST['replySlipEscalatorBrakingSystem'] != "")) {
            $txnReplySlipEscalatorBrakingSystem = trim($_POST['replySlipEscalatorBrakingSystem']);
        } else {
            $txnReplySlipEscalatorBrakingSystem = null;
        }

        if ($success && isset($_POST['replySlipEscalatorControl']) && ($_POST['replySlipEscalatorControl'] != "")) {
            $txnReplySlipEscalatorControl = trim($_POST['replySlipEscalatorControl']);
        } else {
            $txnReplySlipEscalatorControl = null;
        }

        if ($success && isset($_POST['replyHidLampYesNo']) && ($_POST['replyHidLampYesNo'] != "")) {
            $txnReplySlipHidLampYesNo = trim($_POST['replyHidLampYesNo']);
        } else {
            $txnReplySlipHidLampYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipHidLampBallast']) && ($_POST['replySlipHidLampBallast'] != "")) {
            $txnReplySlipHidLampBallast = trim($_POST['replySlipHidLampBallast']);
        } else {
            $txnReplySlipHidLampBallast = null;
        }

        if ($success && isset($_POST['replySlipHidLampAddOnProtection']) && ($_POST['replySlipHidLampAddOnProtection'] != "")) {
            $txnReplySlipHidLampAddOnProtection = trim($_POST['replySlipHidLampAddOnProtection']);
        } else {
            $txnReplySlipHidLampAddOnProtection = null;
        }

        if ($success && isset($_POST['replyLiftYesNo']) && ($_POST['replyLiftYesNo'] != "")) {
            $txnReplySlipLiftYesNo = trim($_POST['replyLiftYesNo']);
        } else {
            $txnReplySlipLiftYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipLiftOperation']) && ($_POST['replySlipLiftOperation'] != "")) {
            $txnReplySlipLiftOperation = trim($_POST['replySlipLiftOperation']);
        } else {
            $txnReplySlipLiftOperation = null;
        }

        if ($success && isset($_POST['replySlipSensitiveMachineYesNo']) && ($_POST['replySlipSensitiveMachineYesNo'] != "")) {
            $txnReplySlipSensitiveMachineYesNo = trim($_POST['replySlipSensitiveMachineYesNo']);
        } else {
            $txnReplySlipSensitiveMachineYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipSensitiveMachineMitigation']) && ($_POST['replySlipSensitiveMachineMitigation'] != "")) {
            $txnReplySlipSensitiveMachineMitigation = trim($_POST['replySlipSensitiveMachineMitigation']);
        } else {
            $txnReplySlipSensitiveMachineMitigation = null;
        }

        if ($success && isset($_POST['replySlipTelecomMachineYesNo']) && ($_POST['replySlipTelecomMachineYesNo'] != "")) {
            $txnReplySlipTelecomMachineYesNo = trim($_POST['replySlipTelecomMachineYesNo']);
        } else {
            $txnReplySlipTelecomMachineYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipTelecomMachineServerOrComputer']) && ($_POST['replySlipTelecomMachineServerOrComputer'] != "")) {
            $txnReplySlipTelecomMachineServerOrComputer = trim($_POST['replySlipTelecomMachineServerOrComputer']);
        } else {
            $txnReplySlipTelecomMachineServerOrComputer = null;
        }

        if ($success && isset($_POST['replySlipTelecomMachinePeripherals']) && ($_POST['replySlipTelecomMachinePeripherals'] != "")) {
            $txnReplySlipTelecomMachinePeripherals = trim($_POST['replySlipTelecomMachinePeripherals']);
        } else {
            $txnReplySlipTelecomMachinePeripherals = null;
        }

        if ($success && isset($_POST['replySlipTelecomMachineHarmonicEmission']) && ($_POST['replySlipTelecomMachineHarmonicEmission'] != "")) {
            $txnReplySlipTelecomMachineHarmonicEmission = trim($_POST['replySlipTelecomMachineHarmonicEmission']);
        } else {
            $txnReplySlipTelecomMachineHarmonicEmission = null;
        }

        if ($success && isset($_POST['replySlipAirConditionersYesNo']) && ($_POST['replySlipAirConditionersYesNo'] != "")) {
            $txnReplySlipAirConditionersYesNo = trim($_POST['replySlipAirConditionersYesNo']);
        } else {
            $txnReplySlipAirConditionersYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipAirConditionersMicb']) && ($_POST['replySlipAirConditionersMicb'] != "")) {
            $txnReplySlipAirConditionersMicb = trim($_POST['replySlipAirConditionersMicb']);
        } else {
            $txnReplySlipAirConditionersMicb = null;
        }

        if ($success && isset($_POST['replySlipAirConditionersLoadForecasting']) && ($_POST['replySlipAirConditionersLoadForecasting'] != "")) {
            $txnReplySlipAirConditionersLoadForecasting = trim($_POST['replySlipAirConditionersLoadForecasting']);
        } else {
            $txnReplySlipAirConditionersLoadForecasting = null;
        }

        if ($success && isset($_POST['replySlipAirConditionersType']) && ($_POST['replySlipAirConditionersType'] != "")) {
            $txnReplySlipAirConditionersType = trim($_POST['replySlipAirConditionersType']);
        } else {
            $txnReplySlipAirConditionersType = null;
        }

        if ($success && isset($_POST['replySlipNonLinearLoadYesNo']) && ($_POST['replySlipNonLinearLoadYesNo'] != "")) {
            $txnReplySlipNonLinearLoadYesNo = trim($_POST['replySlipNonLinearLoadYesNo']);
        } else {
            $txnReplySlipNonLinearLoadYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipNonLinearLoadHarmonicEmission']) && ($_POST['replySlipNonLinearLoadHarmonicEmission'] != "")) {
            $txnReplySlipNonLinearLoadHarmonicEmission = trim($_POST['replySlipNonLinearLoadHarmonicEmission']);
        } else {
            $txnReplySlipNonLinearLoadHarmonicEmission = null;
        }

        if ($success && isset($_POST['replySlipRenewableEnergyYesNo']) && ($_POST['replySlipRenewableEnergyYesNo'] != "")) {
            $txnReplySlipRenewableEnergyYesNo = trim($_POST['replySlipRenewableEnergyYesNo']);
        } else {
            $txnReplySlipRenewableEnergyYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipRenewableEnergyInverterAndControls']) && ($_POST['replySlipRenewableEnergyInverterAndControls'] != "")) {
            $txnReplySlipRenewableEnergyInverterAndControls = trim($_POST['replySlipRenewableEnergyInverterAndControls']);
        } else {
            $txnReplySlipRenewableEnergyInverterAndControls = null;
        }

        if ($success && isset($_POST['replySlipRenewableEnergyHarmonicEmission']) && ($_POST['replySlipRenewableEnergyHarmonicEmission'] != "")) {
            $txnReplySlipRenewableEnergyHarmonicEmission = trim($_POST['replySlipRenewableEnergyHarmonicEmission']);
        } else {
            $txnReplySlipRenewableEnergyHarmonicEmission = null;
        }

        if ($success && isset($_POST['replySlipEvChargerSystemYesNo']) && ($_POST['replySlipEvChargerSystemYesNo'] != "")) {
            $txnReplySlipEvChargerSystemYesNo = trim($_POST['replySlipEvChargerSystemYesNo']);
        } else {
            $txnReplySlipEvChargerSystemYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipEvChargerSystemEvCharger']) && ($_POST['replySlipEvChargerSystemEvCharger'] != "")) {
            $txnReplySlipEvChargerSystemEvCharger = trim($_POST['replySlipEvChargerSystemEvCharger']);
        } else {
            $txnReplySlipEvChargerSystemEvCharger = null;
        }

        if ($success && isset($_POST['replySlipEvChargerSystemSmartChargingSystem']) && ($_POST['replySlipEvChargerSystemSmartChargingSystem'] != "")) {
            $txnReplySlipEvChargerSystemSmartChargingSystem = trim($_POST['replySlipEvChargerSystemSmartChargingSystem']);
        } else {
            $txnReplySlipEvChargerSystemSmartChargingSystem = null;
        }

        if ($success && isset($_POST['replySlipEvChargerSystemHarmonicEmission']) && ($_POST['replySlipEvChargerSystemHarmonicEmission'] != "")) {
            $txnReplySlipEvChargerSystemHarmonicEmission = trim($_POST['replySlipEvChargerSystemHarmonicEmission']);
        } else {
            $txnReplySlipEvChargerSystemHarmonicEmission = null;
        }

        if ($success && isset($_POST['firstInvitationLetterIssueDate']) && ($_POST['firstInvitationLetterIssueDate'] != "")) {
            $txnFirstInvitationLetterIssueDate = trim($_POST['firstInvitationLetterIssueDate']);
        } else {
            $txnFirstInvitationLetterIssueDate = null;
        }

        if ($success && isset($_POST['firstInvitationLetterFaxRefNo']) && ($_POST['firstInvitationLetterFaxRefNo'] != "")) {
            $txnFirstInvitationLetterFaxRefNo = trim($_POST['firstInvitationLetterFaxRefNo']);
        } else {
            $txnFirstInvitationLetterFaxRefNo = null;
        }

        if ($success && isset($_POST['firstInvitationLetterEdmsLink']) && ($_POST['firstInvitationLetterEdmsLink'] != "")) {
            $txnFirstInvitationLetterEdmsLink = trim($_POST['firstInvitationLetterEdmsLink']);
        } else {
            $txnFirstInvitationLetterEdmsLink = null;
        }

        if ($success && isset($_POST['firstInvitationLetterAccept']) && ($_POST['firstInvitationLetterAccept'] != "")) {
            $txnFirstInvitationLetterAccept = trim($_POST['firstInvitationLetterAccept']);
        } else {
            $txnFirstInvitationLetterAccept = null;
        }

        if ($success && isset($_POST['firstInvitationLetterWalkDate']) && ($_POST['firstInvitationLetterWalkDate'] != "")) {
            $txnFirstInvitationLetterWalkDate = trim($_POST['firstInvitationLetterWalkDate']);
        } else {
            $txnFirstInvitationLetterWalkDate = null;
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
                $txnSecondConsultantTitle,$txnSecondConsultantSurname,$txnSecondConsultantOtherName,
                $txnSecondConsultantCompany,$txnSecondConsultantPhone,$txnSecondConsultantEmail,
                $txnProjectOwnerTitle,$txnProjectOwnerSurname,$txnProjectOwnerOtherName,
                $txnProjectOwnerCompany,$txnProjectOwnerPhone,$txnProjectOwnerEmail,
                $txnStandLetterIssueDate,$txnStandLetterFaxRefNo,$txnStandLetterEdmsLink,
                $txnStandLetterLetterLoc,$txnMeetingFirstPreferMeetingDate,$txnMeetingSecondPreferMeetingDate,
                $txnMeetingActualMeetingDate,$txnMeetingRejReason,$txnMeetingConsentConsultant,$txnMeetingConsentOwner,
                $txnMeetingReplySlipId,$txnReplySlipBmsYesNo,$txnReplySlipBmsServerCentralComputer,
                $txnReplySlipBmsDdc,$txnReplySlipChangeoverSchemeYesNo,$txnReplySlipChangeoverSchemeControl,
                $txnReplySlipChangeoverSchemeUv,$txnReplySlipChillerPlantYesNo,$txnReplySlipChillerPlantAhu,
                $txnReplySlipChillerPlantChiller,$txnReplySlipEscalatorYesNo,$txnReplySlipEscalatorBrakingSystem,
                $txnReplySlipEscalatorControl,$txnReplySlipHidLampYesNo,$txnReplySlipHidLampBallast,
                $txnReplySlipHidLampAddOnProtection,$txnReplySlipLiftYesNo,$txnReplySlipLiftOperation,
                $txnReplySlipSensitiveMachineYesNo,$txnReplySlipSensitiveMachineMitigation,
                $txnReplySlipTelecomMachineYesNo,$txnReplySlipTelecomMachineServerOrComputer,
                $txnReplySlipTelecomMachinePeripherals,$txnReplySlipTelecomMachineHarmonicEmission,
                $txnReplySlipAirConditionersYesNo,$txnReplySlipAirConditionersMicb,
                $txnReplySlipAirConditionersLoadForecasting,$txnReplySlipAirConditionersType,
                $txnReplySlipNonLinearLoadYesNo,$txnReplySlipNonLinearLoadHarmonicEmission,
                $txnReplySlipRenewableEnergyYesNo,$txnReplySlipRenewableEnergyInverterAndControls,
                $txnReplySlipRenewableEnergyHarmonicEmission,$txnReplySlipEvChargerSystemYesNo,
                $txnReplySlipEvChargerSystemEvCharger,$txnReplySlipEvChargerSystemSmartChargingSystem,
                $txnReplySlipEvChargerSystemHarmonicEmission,
                $txnFirstInvitationLetterIssueDate,$txnFirstInvitationLetterFaxRefNo,$txnFirstInvitationLetterEdmsLink,
                $txnFirstInvitationLetterAccept,$txnFirstInvitationLetterWalkDate,
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

        if ($success && isset($_POST['secondConsultantTitle']) && ($_POST['secondConsultantTitle'] != "")) {
            $txnSecondConsultantTitle = trim($_POST['secondConsultantTitle']);
        } else {
            $txnSecondConsultantTitle = null;
        }

        if ($success && isset($_POST['secondConsultantSurname']) && ($_POST['secondConsultantSurname'] != "")) {
            $txnSecondConsultantSurname = trim($_POST['secondConsultantSurname']);
        } else {
            $txnSecondConsultantSurname = null;
        }

        if ($success && isset($_POST['secondConsultantOtherName']) && ($_POST['secondConsultantOtherName'] != "")) {
            $txnSecondConsultantOtherName = trim($_POST['secondConsultantOtherName']);
        } else {
            $txnSecondConsultantOtherName = null;
        }

        if ($success && isset($_POST['secondConsultantCompany']) && ($_POST['secondConsultantCompany'] != "")) {
            $txnSecondConsultantCompany = trim($_POST['secondConsultantCompany']);
        } else {
            $txnSecondConsultantCompany = null;
        }

        if ($success && isset($_POST['secondConsultantPhone']) && ($_POST['secondConsultantPhone'] != "")) {
            $txnSecondConsultantPhone = trim($_POST['secondConsultantPhone']);
        } else {
            $txnSecondConsultantPhone = null;
        }

        if ($success && isset($_POST['secondConsultantEmail']) && ($_POST['secondConsultantEmail'] != "")) {
            $txnSecondConsultantEmail = trim($_POST['secondConsultantEmail']);
        } else {
            $txnSecondConsultantEmail = null;
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

        if ($success && isset($_POST['meetingFirstPreferMeetingDate']) && ($_POST['meetingFirstPreferMeetingDate'] != "")) {
            $txnMeetingFirstPreferMeetingDate = trim($_POST['meetingFirstPreferMeetingDate']);
        } else {
            $txnMeetingFirstPreferMeetingDate = null;
        }

        if ($success && isset($_POST['meetingSecondPreferMeetingDate']) && ($_POST['meetingSecondPreferMeetingDate'] != "")) {
            $txnMeetingSecondPreferMeetingDate = trim($_POST['meetingSecondPreferMeetingDate']);
        } else {
            $txnMeetingSecondPreferMeetingDate = null;
        }

        if ($success && isset($_POST['meetingActualMeetingDate']) && ($_POST['meetingActualMeetingDate'] != "")) {
            $txnMeetingActualMeetingDate = trim($_POST['meetingActualMeetingDate']);
        } else {
            $txnMeetingActualMeetingDate = null;
        }

        if ($success && isset($_POST['meetingRejReason']) && ($_POST['meetingRejReason'] != "")) {
            $txnMeetingRejReason = trim($_POST['meetingRejReason']);
        } else {
            $txnMeetingRejReason = null;
        }

        if ($success && isset($_POST['meetingConsentConsultant']) && ($_POST['meetingConsentConsultant'] != "")) {
            $txnMeetingConsentConsultant = trim($_POST['meetingConsentConsultant']);
        } else {
            $txnMeetingConsentConsultant = 'N';
        }

        if ($success && isset($_POST['meetingConsentOwner']) && ($_POST['meetingConsentOwner'] != "")) {
            $txnMeetingConsentOwner = trim($_POST['meetingConsentOwner']);
        } else {
            $txnMeetingConsentOwner = 'N';
        }

        if ($success && isset($_POST['meetingReplySlipId']) && ($_POST['meetingReplySlipId'] != "")) {
            $txnMeetingReplySlipId = trim($_POST['meetingReplySlipId']);
        } else {
            $txnMeetingReplySlipId = null;
        }

        if ($success && isset($_POST['replySlipBmsYesNo']) && ($_POST['replySlipBmsYesNo'] != "")) {
            $txnReplySlipBmsYesNo = trim($_POST['replySlipBmsYesNo']);
        } else {
            $txnReplySlipBmsYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipBmsServerCentralComputer']) && ($_POST['replySlipBmsServerCentralComputer'] != "")) {
            $txnReplySlipBmsServerCentralComputer = trim($_POST['replySlipBmsServerCentralComputer']);
        } else {
            $txnReplySlipBmsServerCentralComputer = null;
        }

        if ($success && isset($_POST['replySlipBmsDdc']) && ($_POST['replySlipBmsDdc'] != "")) {
            $txnReplySlipBmsDdc = trim($_POST['replySlipBmsDdc']);
        } else {
            $txnReplySlipBmsDdc = null;
        }

        if ($success && isset($_POST['replySlipChangeoverSchemeYesNo']) && ($_POST['replySlipChangeoverSchemeYesNo'] != "")) {
            $txnReplySlipChangeoverSchemeYesNo = trim($_POST['replySlipChangeoverSchemeYesNo']);
        } else {
            $txnReplySlipChangeoverSchemeYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipChangeoverSchemeControl']) && ($_POST['replySlipChangeoverSchemeControl'] != "")) {
            $txnReplySlipChangeoverSchemeControl = trim($_POST['replySlipChangeoverSchemeControl']);
        } else {
            $txnReplySlipChangeoverSchemeControl = null;
        }

        if ($success && isset($_POST['replySlipChangeoverSchemeUv']) && ($_POST['replySlipChangeoverSchemeUv'] != "")) {
            $txnReplySlipChangeoverSchemeUv = trim($_POST['replySlipChangeoverSchemeUv']);
        } else {
            $txnReplySlipChangeoverSchemeUv = null;
        }

        if ($success && isset($_POST['replySlipChillerPlantYesNo']) && ($_POST['replySlipChillerPlantYesNo'] != "")) {
            $txnReplySlipChillerPlantYesNo = trim($_POST['replySlipChillerPlantYesNo']);
        } else {
            $txnReplySlipChillerPlantYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipChillerPlantAhu']) && ($_POST['replySlipChillerPlantAhu'] != "")) {
            $txnReplySlipChillerPlantAhu = trim($_POST['replySlipChillerPlantAhu']);
        } else {
            $txnReplySlipChillerPlantAhu = null;
        }

        if ($success && isset($_POST['replySlipChillerPlantChiller']) && ($_POST['replySlipChillerPlantChiller'] != "")) {
            $txnReplySlipChillerPlantChiller = trim($_POST['replySlipChillerPlantChiller']);
        } else {
            $txnReplySlipChillerPlantChiller = null;
        }

        if ($success && isset($_POST['replySlipEscalatorYesNo']) && ($_POST['replySlipEscalatorYesNo'] != "")) {
            $txnReplySlipEscalatorYesNo = trim($_POST['replySlipEscalatorYesNo']);
        } else {
            $txnReplySlipEscalatorYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipEscalatorBrakingSystem']) && ($_POST['replySlipEscalatorBrakingSystem'] != "")) {
            $txnReplySlipEscalatorBrakingSystem = trim($_POST['replySlipEscalatorBrakingSystem']);
        } else {
            $txnReplySlipEscalatorBrakingSystem = null;
        }

        if ($success && isset($_POST['replySlipEscalatorControl']) && ($_POST['replySlipEscalatorControl'] != "")) {
            $txnReplySlipEscalatorControl = trim($_POST['replySlipEscalatorControl']);
        } else {
            $txnReplySlipEscalatorControl = null;
        }

        if ($success && isset($_POST['replyHidLampYesNo']) && ($_POST['replyHidLampYesNo'] != "")) {
            $txnReplySlipHidLampYesNo = trim($_POST['replyHidLampYesNo']);
        } else {
            $txnReplySlipHidLampYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipHidLampBallast']) && ($_POST['replySlipHidLampBallast'] != "")) {
            $txnReplySlipHidLampBallast = trim($_POST['replySlipHidLampBallast']);
        } else {
            $txnReplySlipHidLampBallast = null;
        }

        if ($success && isset($_POST['replySlipHidLampAddOnProtection']) && ($_POST['replySlipHidLampAddOnProtection'] != "")) {
            $txnReplySlipHidLampAddOnProtection = trim($_POST['replySlipHidLampAddOnProtection']);
        } else {
            $txnReplySlipHidLampAddOnProtection = null;
        }

        if ($success && isset($_POST['replyLiftYesNo']) && ($_POST['replyLiftYesNo'] != "")) {
            $txnReplySlipLiftYesNo = trim($_POST['replyLiftYesNo']);
        } else {
            $txnReplySlipLiftYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipLiftOperation']) && ($_POST['replySlipLiftOperation'] != "")) {
            $txnReplySlipLiftOperation = trim($_POST['replySlipLiftOperation']);
        } else {
            $txnReplySlipLiftOperation = null;
        }

        if ($success && isset($_POST['replySlipSensitiveMachineYesNo']) && ($_POST['replySlipSensitiveMachineYesNo'] != "")) {
            $txnReplySlipSensitiveMachineYesNo = trim($_POST['replySlipSensitiveMachineYesNo']);
        } else {
            $txnReplySlipSensitiveMachineYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipSensitiveMachineMitigation']) && ($_POST['replySlipSensitiveMachineMitigation'] != "")) {
            $txnReplySlipSensitiveMachineMitigation = trim($_POST['replySlipSensitiveMachineMitigation']);
        } else {
            $txnReplySlipSensitiveMachineMitigation = null;
        }

        if ($success && isset($_POST['replySlipTelecomMachineYesNo']) && ($_POST['replySlipTelecomMachineYesNo'] != "")) {
            $txnReplySlipTelecomMachineYesNo = trim($_POST['replySlipTelecomMachineYesNo']);
        } else {
            $txnReplySlipTelecomMachineYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipTelecomMachineServerOrComputer']) && ($_POST['replySlipTelecomMachineServerOrComputer'] != "")) {
            $txnReplySlipTelecomMachineServerOrComputer = trim($_POST['replySlipTelecomMachineServerOrComputer']);
        } else {
            $txnReplySlipTelecomMachineServerOrComputer = null;
        }

        if ($success && isset($_POST['replySlipTelecomMachinePeripherals']) && ($_POST['replySlipTelecomMachinePeripherals'] != "")) {
            $txnReplySlipTelecomMachinePeripherals = trim($_POST['replySlipTelecomMachinePeripherals']);
        } else {
            $txnReplySlipTelecomMachinePeripherals = null;
        }

        if ($success && isset($_POST['replySlipTelecomMachineHarmonicEmission']) && ($_POST['replySlipTelecomMachineHarmonicEmission'] != "")) {
            $txnReplySlipTelecomMachineHarmonicEmission = trim($_POST['replySlipTelecomMachineHarmonicEmission']);
        } else {
            $txnReplySlipTelecomMachineHarmonicEmission = null;
        }

        if ($success && isset($_POST['replySlipAirConditionersYesNo']) && ($_POST['replySlipAirConditionersYesNo'] != "")) {
            $txnReplySlipAirConditionersYesNo = trim($_POST['replySlipAirConditionersYesNo']);
        } else {
            $txnReplySlipAirConditionersYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipAirConditionersMicb']) && ($_POST['replySlipAirConditionersMicb'] != "")) {
            $txnReplySlipAirConditionersMicb = trim($_POST['replySlipAirConditionersMicb']);
        } else {
            $txnReplySlipAirConditionersMicb = null;
        }

        if ($success && isset($_POST['replySlipAirConditionersLoadForecasting']) && ($_POST['replySlipAirConditionersLoadForecasting'] != "")) {
            $txnReplySlipAirConditionersLoadForecasting = trim($_POST['replySlipAirConditionersLoadForecasting']);
        } else {
            $txnReplySlipAirConditionersLoadForecasting = null;
        }

        if ($success && isset($_POST['replySlipAirConditionersType']) && ($_POST['replySlipAirConditionersType'] != "")) {
            $txnReplySlipAirConditionersType = trim($_POST['replySlipAirConditionersType']);
        } else {
            $txnReplySlipAirConditionersType = null;
        }

        if ($success && isset($_POST['replySlipNonLinearLoadYesNo']) && ($_POST['replySlipNonLinearLoadYesNo'] != "")) {
            $txnReplySlipNonLinearLoadYesNo = trim($_POST['replySlipNonLinearLoadYesNo']);
        } else {
            $txnReplySlipNonLinearLoadYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipNonLinearLoadHarmonicEmission']) && ($_POST['replySlipNonLinearLoadHarmonicEmission'] != "")) {
            $txnReplySlipNonLinearLoadHarmonicEmission = trim($_POST['replySlipNonLinearLoadHarmonicEmission']);
        } else {
            $txnReplySlipNonLinearLoadHarmonicEmission = null;
        }

        if ($success && isset($_POST['replySlipRenewableEnergyYesNo']) && ($_POST['replySlipRenewableEnergyYesNo'] != "")) {
            $txnReplySlipRenewableEnergyYesNo = trim($_POST['replySlipRenewableEnergyYesNo']);
        } else {
            $txnReplySlipRenewableEnergyYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipRenewableEnergyInverterAndControls']) && ($_POST['replySlipRenewableEnergyInverterAndControls'] != "")) {
            $txnReplySlipRenewableEnergyInverterAndControls = trim($_POST['replySlipRenewableEnergyInverterAndControls']);
        } else {
            $txnReplySlipRenewableEnergyInverterAndControls = null;
        }

        if ($success && isset($_POST['replySlipRenewableEnergyHarmonicEmission']) && ($_POST['replySlipRenewableEnergyHarmonicEmission'] != "")) {
            $txnReplySlipRenewableEnergyHarmonicEmission = trim($_POST['replySlipRenewableEnergyHarmonicEmission']);
        } else {
            $txnReplySlipRenewableEnergyHarmonicEmission = null;
        }

        if ($success && isset($_POST['replySlipEvChargerSystemYesNo']) && ($_POST['replySlipEvChargerSystemYesNo'] != "")) {
            $txnReplySlipEvChargerSystemYesNo = trim($_POST['replySlipEvChargerSystemYesNo']);
        } else {
            $txnReplySlipEvChargerSystemYesNo = 'N';
        }

        if ($success && isset($_POST['replySlipEvChargerSystemEvCharger']) && ($_POST['replySlipEvChargerSystemEvCharger'] != "")) {
            $txnReplySlipEvChargerSystemEvCharger = trim($_POST['replySlipEvChargerSystemEvCharger']);
        } else {
            $txnReplySlipEvChargerSystemEvCharger = null;
        }

        if ($success && isset($_POST['replySlipEvChargerSystemSmartChargingSystem']) && ($_POST['replySlipEvChargerSystemSmartChargingSystem'] != "")) {
            $txnReplySlipEvChargerSystemSmartChargingSystem = trim($_POST['replySlipEvChargerSystemSmartChargingSystem']);
        } else {
            $txnReplySlipEvChargerSystemSmartChargingSystem = null;
        }

        if ($success && isset($_POST['replySlipEvChargerSystemHarmonicEmission']) && ($_POST['replySlipEvChargerSystemHarmonicEmission'] != "")) {
            $txnReplySlipEvChargerSystemHarmonicEmission = trim($_POST['replySlipEvChargerSystemHarmonicEmission']);
        } else {
            $txnReplySlipEvChargerSystemHarmonicEmission = null;
        }

        if ($success && isset($_POST['firstInvitationLetterIssueDate']) && ($_POST['firstInvitationLetterIssueDate'] != "")) {
            $txnFirstInvitationLetterIssueDate = trim($_POST['firstInvitationLetterIssueDate']);
        } else {
            $txnFirstInvitationLetterIssueDate = null;
        }

        if ($success && isset($_POST['firstInvitationLetterFaxRefNo']) && ($_POST['firstInvitationLetterFaxRefNo'] != "")) {
            $txnFirstInvitationLetterFaxRefNo = trim($_POST['firstInvitationLetterFaxRefNo']);
        } else {
            $txnFirstInvitationLetterFaxRefNo = null;
        }

        if ($success && isset($_POST['firstInvitationLetterEdmsLink']) && ($_POST['firstInvitationLetterEdmsLink'] != "")) {
            $txnFirstInvitationLetterEdmsLink = trim($_POST['firstInvitationLetterEdmsLink']);
        } else {
            $txnFirstInvitationLetterEdmsLink = null;
        }

        if ($success && isset($_POST['firstInvitationLetterAccept']) && ($_POST['firstInvitationLetterAccept'] != "")) {
            $txnFirstInvitationLetterAccept = trim($_POST['firstInvitationLetterAccept']);
        } else {
            $txnFirstInvitationLetterAccept = null;
        }

        if ($success && isset($_POST['firstInvitationLetterWalkDate']) && ($_POST['firstInvitationLetterWalkDate'] != "")) {
            $txnFirstInvitationLetterWalkDate = trim($_POST['firstInvitationLetterWalkDate']);
        } else {
            $txnFirstInvitationLetterWalkDate = null;
        }

        if ($success) {
            $lastUpdatedBy = Yii::app()->session['tblUserDo']['username'];
            $lastUpdatedTime = date("Y-m-d H:i");

            try {

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
                }

                $retJson = Yii::app()->planningAheadDao->updatePlanningAheadDetailProcess($txnProjectTitle,$txnSchemeNo,$txnRegion,
                    $txnTypeOfProject,$txnCommissionDate,$txnKeyInfra,$txnTempProj,
                    $txnFirstRegionStaffName,$txnFirstRegionStaffPhone,$txnFirstRegionStaffEmail,
                    $txnSecondRegionStaffName,$txnSecondRegionStaffPhone,$txnSecondRegionStaffEmail,
                    $txnThirdRegionStaffName,$txnThirdRegionStaffPhone,$txnThirdRegionStaffEmail,
                    $txnFirstConsultantTitle,$txnFirstConsultantSurname,$txnFirstConsultantOtherName,
                    $txnFirstConsultantCompany,$txnFirstConsultantPhone,$txnFirstConsultantEmail,
                    $txnSecondConsultantTitle,$txnSecondConsultantSurname,$txnSecondConsultantOtherName,
                    $txnSecondConsultantCompany,$txnSecondConsultantPhone,$txnSecondConsultantEmail,
                    $txnProjectOwnerTitle,$txnProjectOwnerSurname,$txnProjectOwnerOtherName,
                    $txnProjectOwnerCompany,$txnProjectOwnerPhone,$txnProjectOwnerEmail,
                    $txnStandLetterIssueDate,$txnStandLetterFaxRefNo,$txnStandLetterEdmsLink,
                    $txnStandLetterLetterLoc,$txnMeetingFirstPreferMeetingDate,$txnMeetingSecondPreferMeetingDate,
                    $txnMeetingActualMeetingDate,$txnMeetingRejReason,$txnMeetingConsentConsultant,$txnMeetingConsentOwner,
                    $txnMeetingReplySlipId,$txnReplySlipBmsYesNo,$txnReplySlipBmsServerCentralComputer,
                    $txnReplySlipBmsDdc,$txnReplySlipChangeoverSchemeYesNo,$txnReplySlipChangeoverSchemeControl,
                    $txnReplySlipChangeoverSchemeUv,$txnReplySlipChillerPlantYesNo,$txnReplySlipChillerPlantAhu,
                    $txnReplySlipChillerPlantChiller,$txnReplySlipEscalatorYesNo,$txnReplySlipEscalatorBrakingSystem,
                    $txnReplySlipEscalatorControl,$txnReplySlipHidLampYesNo,$txnReplySlipHidLampBallast,
                    $txnReplySlipHidLampAddOnProtection,$txnReplySlipLiftYesNo,$txnReplySlipLiftOperation,
                    $txnReplySlipSensitiveMachineYesNo,$txnReplySlipSensitiveMachineMitigation,
                    $txnReplySlipTelecomMachineYesNo,$txnReplySlipTelecomMachineServerOrComputer,
                    $txnReplySlipTelecomMachinePeripherals,$txnReplySlipTelecomMachineHarmonicEmission,
                    $txnReplySlipAirConditionersYesNo,$txnReplySlipAirConditionersMicb,
                    $txnReplySlipAirConditionersLoadForecasting,$txnReplySlipAirConditionersType,
                    $txnReplySlipNonLinearLoadYesNo,$txnReplySlipNonLinearLoadHarmonicEmission,
                    $txnReplySlipRenewableEnergyYesNo,$txnReplySlipRenewableEnergyInverterAndControls,
                    $txnReplySlipRenewableEnergyHarmonicEmission,$txnReplySlipEvChargerSystemYesNo,
                    $txnReplySlipEvChargerSystemEvCharger,$txnReplySlipEvChargerSystemSmartChargingSystem,
                    $txnReplySlipEvChargerSystemHarmonicEmission,
                    $txnFirstInvitationLetterIssueDate,$txnFirstInvitationLetterFaxRefNo,$txnFirstInvitationLetterEdmsLink,
                    $txnFirstInvitationLetterAccept,$txnFirstInvitationLetterWalkDate,
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