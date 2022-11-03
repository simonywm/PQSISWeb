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

                        if (!isset($excelSchemeNo)) {
                            continue;
                        }

                        $excelBmsYesNo = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
                        if (strtoupper($excelBmsYesNo) == 'YES') {
                            $excelBmsYesNo = 'Y';
                        } else {
                            $excelBmsYesNo = 'N';
                        }
                        $excelBmsServerCentralComputer = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(6, $row)->getValue());
                        $excelBmsDdc = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(7, $row)->getValue());
                        $excelChangeoverSchemeYesNo = $objWorksheet->getCellByColumnAndRow(8, $row)->getValue();
                        if (strtoupper($excelChangeoverSchemeYesNo) == 'YES') {
                            $excelChangeoverSchemeYesNo = 'Y';
                        } else {
                            $excelChangeoverSchemeYesNo = 'N';
                        }
                        $excelChangeoverSchemeControl = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(9, $row)->getValue());
                        $excelChangeoverSchemeUv = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(10, $row)->getValue());
                        $excelChillerPlantYesNo = $objWorksheet->getCellByColumnAndRow(11, $row)->getValue();
                        if (strtoupper($excelChillerPlantYesNo) == 'YES') {
                            $excelChillerPlantYesNo = 'Y';
                        } else {
                            $excelChillerPlantYesNo = 'N';
                        }
                        $excelChillerPlantAhuControl = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(12, $row)->getValue());
                        $excelChillerPlantAhuStartup = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(13, $row)->getValue());
                        $excelChillerPlantVsd = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(14, $row)->getValue());
                        $excelChillerPlantAhuChilledWater = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(15, $row)->getValue());
                        $excelChillerPlantStandbyAhu = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(16, $row)->getValue());
                        $excelChillerPlantChiller = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(17, $row)->getValue());
                        $excelEscalatorYesNo = $objWorksheet->getCellByColumnAndRow(18, $row)->getValue();
                        if (strtoupper($excelEscalatorYesNo) == 'YES') {
                            $excelEscalatorYesNo = 'Y';
                        } else {
                            $excelEscalatorYesNo = 'N';
                        }
                        $excelEscalatorMotorStartup = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(19, $row)->getValue());
                        $excelEscalatorVsdMitigation = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(20, $row)->getValue());
                        $excelEscalatorBrakingSystem = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(21, $row)->getValue());
                        $excelEscalatorControl = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(22, $row)->getValue());
                        $excelLiftYesNo = $objWorksheet->getCellByColumnAndRow(23, $row)->getValue();
                        if (strtoupper($excelLiftYesNo) == 'YES') {
                            $excelLiftYesNo = 'Y';
                        } else {
                            $excelLiftYesNo = 'N';
                        }
                        $excelLiftOperation = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(24, $row)->getValue());
                        $excelHidLampYesNo = $objWorksheet->getCellByColumnAndRow(25, $row)->getValue();
                        if (strtoupper($excelHidLampYesNo) == 'YES') {
                            $excelHidLampYesNo = 'Y';
                        } else {
                            $excelHidLampYesNo = 'N';
                        }
                        $excelHidLampMitigation = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(26, $row)->getValue());
                        $excelSensitiveMachineYesNo = $objWorksheet->getCellByColumnAndRow(27, $row)->getValue();
                        if (strtoupper($excelSensitiveMachineYesNo) == 'YES') {
                            $excelSensitiveMachineYesNo = 'Y';
                        } else {
                            $excelSensitiveMachineYesNo = 'N';
                        }
                        $excelSensitiveMachineMitigation = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(28, $row)->getValue());
                        $excelTelecomMachineYesNo = $objWorksheet->getCellByColumnAndRow(29, $row)->getValue();
                        if (strtoupper($excelTelecomMachineYesNo) == 'YES') {
                            $excelTelecomMachineYesNo = 'Y';
                        } else {
                            $excelTelecomMachineYesNo = 'N';
                        }
                        $excelTelecomMachineServerOrComputer = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(30, $row)->getValue());
                        $excelTelecomMachinePeripherals = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(31, $row)->getValue());
                        $excelTelecomMachineHarmonicEmission = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(32, $row)->getValue());
                        $excelAirConditionersYesNo = $objWorksheet->getCellByColumnAndRow(33, $row)->getValue();
                        if (strtoupper($excelAirConditionersYesNo) == 'YES') {
                            $excelAirConditionersYesNo = 'Y';
                        } else {
                            $excelAirConditionersYesNo = 'N';
                        }
                        $excelAirConditionersMicb = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(34, $row)->getValue());
                        $excelAirConditionersLoadForecasting = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(35, $row)->getValue());
                        $excelAirConditionersType = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(36, $row)->getValue());
                        $excelNonLinearLoadYesNo = $objWorksheet->getCellByColumnAndRow(37, $row)->getValue();
                        if (strtoupper($excelNonLinearLoadYesNo) == 'YES') {
                            $excelNonLinearLoadYesNo = 'Y';
                        } else {
                            $excelNonLinearLoadYesNo = 'N';
                        }
                        $excelNonLinearLoadHarmonicEmission = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(38, $row)->getValue());
                        $excelRenewableEnergyYesNo = $objWorksheet->getCellByColumnAndRow(39, $row)->getValue();
                        if (strtoupper($excelRenewableEnergyYesNo) == 'YES') {
                            $excelRenewableEnergyYesNo = 'Y';
                        } else {
                            $excelRenewableEnergyYesNo = 'N';
                        }
                        $excelRenewableEnergyInverterAndControls = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(40, $row)->getValue());
                        $excelRenewableEnergyHarmonicEmission = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(41, $row)->getValue());
                        $excelEvChargerSystemYesNo = $objWorksheet->getCellByColumnAndRow(42, $row)->getValue();
                        if (strtoupper($excelEvChargerSystemYesNo) == 'YES') {
                            $excelEvChargerSystemYesNo = 'Y';
                        } else {
                            $excelEvChargerSystemYesNo = 'N';
                        }
                        $excelEvControlYesNo = $objWorksheet->getCellByColumnAndRow(43, $row)->getValue();
                        if (strtoupper($excelEvControlYesNo) == 'YES') {
                            $excelEvControlYesNo = 'Y';
                        } else {
                            $excelEvControlYesNo = 'N';
                        }
                        $excelEvChargerSystemEvCharger = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(44, $row)->getValue());
                        $excelEvChargerSystemSmartYesNo = $objWorksheet->getCellByColumnAndRow(45, $row)->getValue();
                        if (strtoupper($excelEvChargerSystemSmartYesNo) == 'YES') {
                            $excelEvChargerSystemSmartYesNo = 'Y';
                        } else {
                            $excelEvChargerSystemSmartYesNo = 'N';
                        }
                        $excelEvChargerSystemSmartChargingSystem = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(46, $row)->getValue());
                        $excelEvChargerSystemHarmonicEmission = $this->replaceListToLines($objWorksheet->getCellByColumnAndRow(47, $row)->getValue());

                        $excelConsultantNameConfirmation = $objWorksheet->getCellByColumnAndRow(48, $row)->getValue();
                        $excelConsultantCompany = $objWorksheet->getCellByColumnAndRow(50, $row)->getValue();

                        $excelProjectOwnerNameConfirmation = $objWorksheet->getCellByColumnAndRow(51, $row)->getValue();
                        $excelProjectOwnerCompany = $objWorksheet->getCellByColumnAndRow(53, $row)->getValue();

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
                                    $createdBy,$createdTime,$lastUpdatedBy,$lastUpdatedTime);

                            } else {
                                $result = Yii::app()->planningAheadDao->updateReplySlip($projectDetail['meetingReplySlipId'],
                                    $targetFilePath, $excelBmsYesNo,$excelBmsServerCentralComputer,$excelBmsDdc,
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
                                    $createdBy,$createdTime,$lastUpdatedBy,$lastUpdatedTime);
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
            $this->viewbag['evaReportEvChargerSystemSmartChargingSystemYesNo'] = $recordList['evaReportEvChargerSystemSmartChargingSystemYesNo'];
            $this->viewbag['evaReportEvChargerSystemSmartChargingSystemFinding'] = $recordList['evaReportEvChargerSystemSmartChargingSystemFinding'];
            $this->viewbag['evaReportEvChargerSystemSmartChargingSystemRecommend'] = $recordList['evaReportEvChargerSystemSmartChargingSystemRecommend'];
            $this->viewbag['evaReportEvChargerSystemSmartChargingSystemPass'] = $recordList['evaReportEvChargerSystemSmartChargingSystemPass'];
            $this->viewbag['evaReportEvChargerSystemHarmonicEmissionYesNo'] = $recordList['evaReportEvChargerSystemHarmonicEmissionYesNo'];
            $this->viewbag['evaReportEvChargerSystemHarmonicEmissionFinding'] = $recordList['evaReportEvChargerSystemHarmonicEmissionFinding'];
            $this->viewbag['evaReportEvChargerSystemHarmonicEmissionRecommend'] = $recordList['evaReportEvChargerSystemHarmonicEmissionRecommend'];
            $this->viewbag['evaReportEvChargerSystemHarmonicEmissionPass'] = $recordList['evaReportEvChargerSystemHarmonicEmissionPass'];
            $this->viewbag['evaReportEvChargerSystemSupplementYesNo'] = $recordList['evaReportEvChargerSystemSupplementYesNo'];
            $this->viewbag['evaReportEvChargerSystemSupplement'] = $recordList['evaReportEvChargerSystemSupplement'];
            $this->viewbag['evaReportEvChargerSystemSupplementPass'] = $recordList['evaReportEvChargerSystemSupplementPass'];
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
        readfile($pathToSave);
        unlink($pathToSave); // deletes the temporary file

        die();

    }

    public function actionGetPlanningAheadProjectDetailReplySlipTemplate() {

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);

        $schemeNo = $param['schemeNo'];
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

        $pathToSave = $replySlipTemplatePath['configValue'] . 'temp\\(' . $schemeNo . ')' . $replySlipTemplateFileName['configValue'];
        $templateProcessor->saveAs($pathToSave);
        chmod($pathToSave, 0644);

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
        unlink($pathToSave); // deletes the temporary file

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

        if (isset($recordList['secondConsultantSurname'])) {
            $templateProcessor->setValue('secondConsultantCc', "c.c.");
            $templateProcessor->setValue('secondConsultantTitle', "(" . $recordList['secondConsultantTitle'] . ")");
            $templateProcessor->setValue('secondConsultantSurname', $recordList['secondConsultantSurname']);
            $templateProcessor->setValue('secondConsultantCompany', $this->formatToWordTemplate($recordList['secondConsultantCompany']));
            $templateProcessor->setValue('secondConsultantEmail', "(Email: " . $recordList['secondConsultantEmail'] . ")");
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

        if (isset($recordList['secondConsultantSurname'])) {
            $templateProcessor->setValue('secondConsultantCc', "c.c.");
            $templateProcessor->setValue('secondConsultantTitle', "(" . $recordList['secondConsultantTitle'] . ")");
            $templateProcessor->setValue('secondConsultantSurname', $recordList['secondConsultantSurname']);
            $templateProcessor->setValue('secondConsultantCompany', $this->formatToWordTemplate($recordList['secondConsultantCompany']));
            $templateProcessor->setValue('secondConsultantEmail', "(Email: " . $recordList['secondConsultantEmail'] . ")");
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

        $secondInvitationLetterTemplatePath = Yii::app()->commonUtil->
        getConfigValueByConfigName('planningAheadInvitationLetterTemplatePath');

        $secondInvitationLetterTemplateFileName = Yii::app()->commonUtil->
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

        $templateProcessor = new TemplateProcessor($secondInvitationLetterTemplatePath['configValue'] .
            $secondInvitationLetterTemplateFileName['configValue']);
        $templateProcessor->setValue('firstConsultantTitle', $recordList['firstConsultantTitle']);
        $templateProcessor->setValue('firstConsultantSurname', $recordList['firstConsultantSurname']);
        $templateProcessor->setValue('firstConsultantCompany', $this->formatToWordTemplate($recordList['firstConsultantCompany']));
        $templateProcessor->setValue('firstConsultantEmail', $recordList['firstConsultantEmail']);

        if (isset($recordList['secondConsultantSurname'])) {
            $templateProcessor->setValue('secondConsultantCc', "c.c.");
            $templateProcessor->setValue('secondConsultantTitle', "(" . $recordList['secondConsultantTitle'] . ")");
            $templateProcessor->setValue('secondConsultantSurname', $recordList['secondConsultantSurname']);
            $templateProcessor->setValue('secondConsultantCompany', $this->formatToWordTemplate($recordList['secondConsultantCompany']));
            $templateProcessor->setValue('secondConsultantEmail', "(Email: " . $recordList['secondConsultantEmail'] . ")");
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
                } else if ($currState['state']=="SENT_SECOND_INVITATION_LETTER") {
                    $txnNewState = "WAITING_PQ_SITE_WALK";
                } else if ($currState['state']=="SENT_THIRD_INVITATION_LETTER") {
                    $txnNewState = "WAITING_PQ_SITE_WALK";
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
            $value = htmlspecialchars($value);
            return str_replace("\\n", "<w:br />", $value);
        } else {
            return $value;
        }
    }





}
?>