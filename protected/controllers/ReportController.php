<?php
Yii::import('application.vendor.PHPExcel', true);
class ReportController extends Controller
{

    public function filters()
    {
        return array(
            array(
                'application.filters.AccessControlFilter',

            ),
        );
    }
#region planningAhead
    public function actionPlanningAheadReportSearch()
    {
        $this->render("//site/report/PlanningAheadReportSearch");
    }
    public function actionPlanningAheadReportDownload()
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);
        $mode = $param['mode'];
        $startYear = $param['startYear'];
        $startMonth = $param['startMonth'];
        $startDay = $param['startDay'];
        $endYear = $param['endYear'];
        $endMonth = $param['endMonth'];
        $endDay = $param['endDay'];
        $returnRateStartYear = $param['returnRateStartYear'];
        $returnRateEndYear = $param['returnRateEndYear'];
        if ($startMonth < 10) {
            $startDate = $startDay . "/0" . $startMonth . "/" . $startYear;

        } else {
            $startDate = $startDay . "/" . $startMonth . "/" . $startYear;
            $endDate = $endDay . "/" . $endMonth . "/" . $endYear;
        }
        if ($endMonth < 10) {
            $endDate = $endDay . "/0" . $endMonth . "/" . $endYear;
        } else {
            $endDate = $endDay . "/" . $endMonth . "/" . $endYear;
        }
        $planningAheadReplySlipList = Yii::app()->reportDao->getPlanningAheadByDateRangeForReplySlip($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay);
        $planningAheadSiteWalkList = Yii::app()->reportDao->getPlanningAheadByDateRangeForSiteWalk($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay);
        $planningAheadReplySlipReturnRateList = Yii::app()->reportDao->getPlanningAheadReplySlipReturnRateChartByDateRange($returnRateStartYear, $returnRateEndYear);
        $planningAheadSiteWalkReturnRateList = Yii::app()->reportDao->getPlanningAheadReplySlipReturnRateChartByDateRange($returnRateStartYear, $returnRateEndYear);
        $userModal = Yii::app()->session['tblUserDo'];
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator($userModal["username"])
            ->setLastModifiedBy($userModal["username"])
            ->setTitle("PlanningAheadStatusReport(" . $startDay . "-" . $startMonth . "-" . $startYear . ")")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        //special text
        $objRichTextMainDate = new PHPExcel_RichText();
        $objPayableMainDate = $objRichTextMainDate->createTextRun("Report Period: " . $startDate . " ~ " . $endDate);
        $objPayableMainDate->getFont()->setBold(true);
        $objPayableMainDate->getFont()->setItalic(true);
        $objPayableMainDate->getFont()->setSize(20);
        $objPayableMainDate->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));

        $objRichTextMainYear = new PHPExcel_RichText();
        $objRichTextMainYear = $objRichTextMainYear->createTextRun("Return Rate Period: " . $returnRateStartYear . " ~ " . $returnRateEndYear);
        $objRichTextMainYear->getFont()->setBold(true);
        $objRichTextMainYear->getFont()->setItalic(true);
        $objRichTextMainYear->getFont()->setSize(20);
        $objRichTextMainYear->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));
        //$objPHPExcel->getActiveSheet()->unmergeCells('A28:B28');    // Just to test...

#region Sheet1
        //SET Sheet Start Index
        $objPHPExcel->setActiveSheetIndex(0);
        //SET sheet name
        $objPHPExcel->getActiveSheet()->setTitle('Reply Slip');

        // Merge cells
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        //set Title
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $objRichTextMainDate);

        $objPHPExcel->getActiveSheet()
            ->setCellValue("A3", "Project Ref")
            ->setCellValue("B3", "Project Title")
            ->setCellValue("C3", "Project Region")
            ->setCellValue("D3", "Project Address")
            ->setCellValue("E3", "Active")
            ->setCellValue("F3", "Scheme Number/PBE")
            ->setCellValue("G3", "PQSIS Case No")
            ->setCellValue("H3", "Input Date")
            ->setCellValue("I3", "Region letter Issue Date")
            ->setCellValue("J3", "Reported By")
            ->setCellValue("K3", "Last Updated By")
            ->setCellValue("L3", "Last Updated Date ")
            ->setCellValue("M3", "Region Planner")
            ->setCellValue("N3", "Building Type")
            ->setCellValue("O3", "Project Type ")
            ->setCellValue("P3", "Key infrastructure ")
            ->setCellValue("Q3", "Potential Successful Case ")
            ->setCellValue("R3", "Critical Project ")
            ->setCellValue("S3", "Temp Supply Project ")
            ->setCellValue("T3", "BMS ")
            ->setCellValue("U3", "Change Over Scheme ")
            ->setCellValue("V3", "Chiller Plant ")
            ->setCellValue("W3", "Escalator ")
            ->setCellValue("X3", "Hid Lamp ")
            ->setCellValue("Y3", "Lift ")
            ->setCellValue("Z3", "Sensitive Machine ")
            ->setCellValue("AA3", "Telcom ")
            ->setCellValue("AB3", "acbTripping ")
            ->setCellValue("AC3", "Building With High Penetration Equipment ")
            ->setCellValue("AD3", "RE ")
            ->setCellValue("AE3", "EV ")
            ->setCellValue("AF3", "Estimated Load ")
            ->setCellValue("AG3", "PQIS Number ")
            ->setCellValue("AH3", "PQ site walk Project Region ")
            ->setCellValue("AI3", "PQ site walk Project Address ")
            ->setCellValue("AJ3", "Sensitive Equipment and Corresponding Mitigation Solutions Found During Site Walk ")
            ->setCellValue("AK3", "1st PQ site Walk Date ")
            ->setCellValue("AL3", "1st PQ site Walk Status ")
            ->setCellValue("AM3", "1st PQ site walk invitation letter’s link ")
            ->setCellValue("AN3", "Letter for request 1st PQ site walk date ")
            ->setCellValue("AO3", "PQ walk assessment report Date ")
            ->setCellValue("AP3", "PQ walk assessment report link/path ")
            ->setCellValue("AQ3", "1st PQ site Walk PQSIS Case No ")
            ->setCellValue("AR3", "1st Customer response for site walk ")
            ->setCellValue("AS3", "1st Investigation Status ")
            ->setCellValue("AT3", "2nd PQ site Walk Date ")
            ->setCellValue("AU3", "2nd PQ site walk invitation letter’s link ")
            ->setCellValue("AV3", "Letter for request 2nd PQ site walk date ")
            ->setCellValue("AW3", "PQ assessment follow up report Date  ")
            ->setCellValue("AX3", "PQ assessment follow up report link/path ")
            ->setCellValue("AY3", "2nd PQ site Walk PQSIS Case No ")
            ->setCellValue("AZ3", "2nd Customer response for site walk ")
            ->setCellValue("BA3", "2nd Investigation Status ")
            ->setCellValue("BB3", "Consultant Company Name ")
            ->setCellValue("BC3", "Consultant Name ")
            ->setCellValue("BD3", "Phone No.1 ")
            ->setCellValue("BE3", "Phone No.2 ")
            ->setCellValue("BF3", "Phone No.3 ")
            ->setCellValue("BG3", "email 1 ")
            ->setCellValue("BH3", "email 2 ")
            ->setCellValue("BI3", "email 3 ")
            ->setCellValue("BJ3", "consultant information remark ")
            ->setCellValue("BK3", "Estimated Commisioning Date(By Customer) ")
            ->setCellValue("BL3", "Estimated Commisioning Date(By Region) ")
            ->setCellValue("BM3", " Planning Ahead Status ")
            ->setCellValue("BN3", " Plan ahead meeting Date")
            ->setCellValue("BO3", " Reply Slip PQSIS Case No ")
            ->setCellValue("BP3", " Target Reply Slip return Date  ")
            ->setCellValue("BQ3", " Finish?")
            ->setCellValue("BR3", " Actual Reply Slip Return Date")
            ->setCellValue("BS3", " Findings from Reply Slip")
            ->setCellValue("BT3", " Follow Up Action?")
            ->setCellValue("BU3", " Follow Up Action")
            ->setCellValue("BV3", " Reply Slip Remark")
            ->setCellValue("BW3", " Plan ahead meeting Fax Link")
            ->setCellValue("BX3", " Reply Slip Fax Link")
            ->setCellValue("BY3", " Del reply Slip Grade")
            ->setCellValue("BZ3", " Date of requested for return reply slip")
            ->setCellValue("CA3", " Receive Complaint")
            ->setCellValue("CB3", " Follow-up Action")
            ->setCellValue("CC3", " Remark");

        for ($i = 1; $i <= 82; $i++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setAutoSize(true);
        }
        //0,1,3,4,5,7,8,9,10,2,11
        $planningAheadReplySlipEndRow = 3;
        foreach ($planningAheadReplySlipList as $planningAhead) {

            $planningAheadReplySlipEndRow = $planningAheadReplySlipEndRow + 1;
            if ($planningAhead["projectAddressParentCaseNo"] != null) {
                if ($planningAhead["projectAddressCaseVersion"] != null) {
                    $projectAddressParentCaseNo = $planningAhead["projectAddressParentCaseNo"]+"."+$planningAhead["projectAddressCaseVersion"];
                } else {
                    $projectAddressParentCaseNo = $planningAhead["projectAddressParentCaseNo"];
                }
            } else {
                $projectAddressParentCaseNo = "";
            }

            if ($planningAhead["firstPqSiteWalkParentCaseNo"] != null) {
                if ($planningAhead["firstPqSiteWalkCaseVersion"] != null) {
                    $firstPqSiteWalkParentCaseNo = $planningAhead["firstPqSiteWalkParentCaseNo"]+"."+$planningAhead["firstPqSiteWalkCaseVersion"];
                } else {
                    $firstPqSiteWalkParentCaseNo = $planningAhead["firstPqSiteWalkParentCaseNo"];
                }
            } else {
                $firstPqSiteWalkParentCaseNo = "";
            }

            if ($planningAhead["secondPqSiteWalkParentCaseNo"] != null) {
                if ($planningAhead["secondPqSiteWalkCaseVersion"] != null) {
                    $secondPqSiteWalkParentCaseNo = $planningAhead["secondPqSiteWalkParentCaseNo"]+"."+$planningAhead["secondPqSiteWalkCaseVersion"];
                } else {
                    $secondPqSiteWalkParentCaseNo = $planningAhead["secondPqSiteWalkParentCaseNo"];
                }
            } else {
                $secondPqSiteWalkParentCaseNo = "";
            }

            if ($planningAhead["replySlipParentCaseNo"] != null) {
                if ($planningAhead["replySlipCaseVersion"] != null) {
                    $replySlipParentCaseNo = $planningAhead["replySlipParentCaseNo"]+"."+$planningAhead["replySlipCaseVersion"];
                } else {
                    $replySlipParentCaseNo = $planningAhead["replySlipParentCaseNo"];
                }
            } else {
                $replySlipParentCaseNo = "";
            }
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A" . $planningAheadReplySlipEndRow, $planningAhead["planningAheadId"])
                ->setCellValue("B" . $planningAheadReplySlipEndRow, $planningAhead["projectTitle"])
                ->setCellValue("C" . $planningAheadReplySlipEndRow, $planningAhead["projectRegion"])
                ->setCellValue("D" . $planningAheadReplySlipEndRow, $planningAhead["projectAddress"])
                ->setCellValue("E" . $planningAheadReplySlipEndRow, $planningAhead["active"])
                ->setCellValue("F" . $planningAheadReplySlipEndRow, $planningAhead["schemeNumber"])
                ->setCellValue("G" . $planningAheadReplySlipEndRow, $projectAddressParentCaseNo)
                ->setCellValue("H" . $planningAheadReplySlipEndRow, $planningAhead["inputDate"])
                ->setCellValue("I" . $planningAheadReplySlipEndRow, $planningAhead["regionLetterIssueDate"])
                ->setCellValue("J" . $planningAheadReplySlipEndRow, $planningAhead["reportedBy"])
                ->setCellValue("K" . $planningAheadReplySlipEndRow, $planningAhead["lastUpdatedBy"])
                ->setCellValue("L" . $planningAheadReplySlipEndRow, $planningAhead["lastUpdatedTime"])
                ->setCellValue("M" . $planningAheadReplySlipEndRow, $planningAhead["regionPlannerName"])
                ->setCellValue("N" . $planningAheadReplySlipEndRow, $planningAhead["buildingTypeName"])
                ->setCellValue("O" . $planningAheadReplySlipEndRow, $planningAhead["projectTypeName"])
                ->setCellValue("P" . $planningAheadReplySlipEndRow, $planningAhead["keyInfrastructure"])
                ->setCellValue("Q" . $planningAheadReplySlipEndRow, $planningAhead["potentialSuccessfulCase"])
                ->setCellValue("R" . $planningAheadReplySlipEndRow, $planningAhead["criticalProject"])
                ->setCellValue("S" . $planningAheadReplySlipEndRow, $planningAhead["tempSupplyProject"])
                ->setCellValue("T" . $planningAheadReplySlipEndRow, $planningAhead["bms"])
                ->setCellValue("U" . $planningAheadReplySlipEndRow, $planningAhead["changeoverScheme"])
                ->setCellValue("V" . $planningAheadReplySlipEndRow, $planningAhead["chillerPlant"])
                ->setCellValue("W" . $planningAheadReplySlipEndRow, $planningAhead["escalator"])
                ->setCellValue("X" . $planningAheadReplySlipEndRow, $planningAhead["hidLamp"])
                ->setCellValue("Y" . $planningAheadReplySlipEndRow, $planningAhead["lift"])
                ->setCellValue("Z" . $planningAheadReplySlipEndRow, $planningAhead["sensitiveMachine"])
                ->setCellValue("AA" . $planningAheadReplySlipEndRow, $planningAhead["telcom"])
                ->setCellValue("AB" . $planningAheadReplySlipEndRow, $planningAhead["acbTripping"])
                ->setCellValue("AC" . $planningAheadReplySlipEndRow, $planningAhead["buildingWithHighPenetrationEquipment"])
                ->setCellValue("AD" . $planningAheadReplySlipEndRow, $planningAhead["re"])
                ->setCellValue("AE" . $planningAheadReplySlipEndRow, $planningAhead["ev"])
                ->setCellValue("AF" . $planningAheadReplySlipEndRow, $planningAhead["estimatedLoad"])
                ->setCellValue("AG" . $planningAheadReplySlipEndRow, $planningAhead["pqisNumber"])
                ->setCellValue("AH" . $planningAheadReplySlipEndRow, $planningAhead["pqSiteWalkProjectRegion"])
                ->setCellValue("AI" . $planningAheadReplySlipEndRow, $planningAhead["pqSiteWalkProjectAddress"])
                ->setCellValue("AJ" . $planningAheadReplySlipEndRow, $planningAhead["sensitiveEquipment"])
                ->setCellValue("AK" . $planningAheadReplySlipEndRow, $planningAhead["firstPqSiteWalkDate"])
                ->setCellValue("AL" . $planningAheadReplySlipEndRow, $planningAhead["firstPqSiteWalkStatus"])
                ->setCellValue("AM" . $planningAheadReplySlipEndRow, $planningAhead["firstPqSiteWalkInvitationLetterLink"])
                ->setCellValue("AN" . $planningAheadReplySlipEndRow, $planningAhead["firstPqSiteWalkRequestLetterDate"])
                ->setCellValue("AO" . $planningAheadReplySlipEndRow, $planningAhead["pqWalkAssessmentReportDate"])
                ->setCellValue("AP" . $planningAheadReplySlipEndRow, $planningAhead["pqWalkAssessmentReportLink"])
                ->setCellValue("AQ" . $planningAheadReplySlipEndRow, $firstPqSiteWalkParentCaseNo)
                ->setCellValue("AR" . $planningAheadReplySlipEndRow, $planningAhead["firstPqSiteWalkCustomerResponse"])
                ->setCellValue("AS" . $planningAheadReplySlipEndRow, $planningAhead["firstPqSiteWalkInvestigationStatus"])
                ->setCellValue("AT" . $planningAheadReplySlipEndRow, $planningAhead["secondPqSiteWalkDate"])
                ->setCellValue("AU" . $planningAheadReplySlipEndRow, $planningAhead["secondPqSiteWalkInvitationLetterLink"])
                ->setCellValue("AV" . $planningAheadReplySlipEndRow, $planningAhead["secondPqSiteWalkRequestLetterDate"])
                ->setCellValue("AW" . $planningAheadReplySlipEndRow, $planningAhead["pqAssessmentFollowUpReportDate"])
                ->setCellValue("AX" . $planningAheadReplySlipEndRow, $planningAhead["pqAssessmentFollowUpReportLink"])
                ->setCellValue("AY" . $planningAheadReplySlipEndRow, $secondPqSiteWalkParentCaseNo)
                ->setCellValue("AZ" . $planningAheadReplySlipEndRow, $planningAhead["secondPqSiteWalkCustomerResponse"])
                ->setCellValue("BA" . $planningAheadReplySlipEndRow, $planningAhead["secondPqSiteWalkInvestigationStatus"])
                ->setCellValue("BB" . $planningAheadReplySlipEndRow, $planningAhead["consultantCompanyName"])
                ->setCellValue("BC" . $planningAheadReplySlipEndRow, $planningAhead["consultantName"])
                ->setCellValue("BD" . $planningAheadReplySlipEndRow, $planningAhead["phoneNumber1"])
                ->setCellValue("BE" . $planningAheadReplySlipEndRow, $planningAhead["phoneNumber2"])
                ->setCellValue("BF" . $planningAheadReplySlipEndRow, $planningAhead["phoneNumber3"])
                ->setCellValue("BG" . $planningAheadReplySlipEndRow, $planningAhead["email1"])
                ->setCellValue("BH" . $planningAheadReplySlipEndRow, $planningAhead["email2"])
                ->setCellValue("BI" . $planningAheadReplySlipEndRow, $planningAhead["email3"])
                ->setCellValue("BJ" . $planningAheadReplySlipEndRow, $planningAhead["consultantInformationRemark"])
                ->setCellValue("BK" . $planningAheadReplySlipEndRow, $planningAhead["estimatedCommisioningDateByCustomer"])
                ->setCellValue("BL" . $planningAheadReplySlipEndRow, $planningAhead["estimatedCommisioningDateByRegion"])
                ->setCellValue("BM" . $planningAheadReplySlipEndRow, $planningAhead["planningAheadStatus"])
                ->setCellValue("BN" . $planningAheadReplySlipEndRow, $planningAhead["invitationToPaMeetingDate"])
                ->setCellValue("BO" . $planningAheadReplySlipEndRow, $replySlipParentCaseNo)
                ->setCellValue("BP" . $planningAheadReplySlipEndRow, $planningAhead["replySlipSentDate"])
                ->setCellValue("BQ" . $planningAheadReplySlipEndRow, $planningAhead["finish"])
                ->setCellValue("BR" . $planningAheadReplySlipEndRow, $planningAhead["actualReplySlipReturnDate"])
                ->setCellValue("BS" . $planningAheadReplySlipEndRow, $planningAhead["findingsFromReplySlip"])
                ->setCellValue("BT" . $planningAheadReplySlipEndRow, $planningAhead["replySlipfollowUpActionFlag"])
                ->setCellValue("BU" . $planningAheadReplySlipEndRow, $planningAhead["replySlipfollowUpAction"])
                ->setCellValue("BV" . $planningAheadReplySlipEndRow, $planningAhead["replySlipRemark"])
                ->setCellValue("BW" . $planningAheadReplySlipEndRow, $planningAhead["replySlipSendLink"])
                ->setCellValue("BX" . $planningAheadReplySlipEndRow, $planningAhead["replySlipReturnLink"])
                ->setCellValue("BY" . $planningAheadReplySlipEndRow, $planningAhead["replySlipGradeName"])
                ->setCellValue("BZ" . $planningAheadReplySlipEndRow, $planningAhead["dateOfRequestedForReturnReplySlip"])
                ->setCellValue("CA" . $planningAheadReplySlipEndRow, $planningAhead["receiveComplaint"])
                ->setCellValue("CB" . $planningAheadReplySlipEndRow, $planningAhead["followUpAction"])
                ->setCellValue("CC" . $planningAheadReplySlipEndRow, $planningAhead["remark"]);

        }

        $objPHPExcel->getActiveSheet()->getStyle('A3:CC3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
#endregion Sheet1
        #region Sheet2
        //Create New sheet
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        //SET Sheet Name
        $objPHPExcel->getActiveSheet()->setTitle('PQ Site Walk');

        // Merge cells
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        //set Title
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $objRichTextMainDate);

        $objPHPExcel->getActiveSheet()
            ->setCellValue("A3", "Project Ref")
            ->setCellValue("B3", "Project Title")
            ->setCellValue("C3", "Project Region")
            ->setCellValue("D3", "Project Address")
            ->setCellValue("E3", "Active")
            ->setCellValue("F3", "Scheme Number/PBE")
            ->setCellValue("G3", "PQSIS Case No")
            ->setCellValue("H3", "Input Date")
            ->setCellValue("I3", "Region letter Issue Date")
            ->setCellValue("J3", "Reported By")
            ->setCellValue("K3", "Last Updated By")
            ->setCellValue("L3", "Last Updated Date ")
            ->setCellValue("M3", "Region Planner")
            ->setCellValue("N3", "Building Type")
            ->setCellValue("O3", "Project Type ")
            ->setCellValue("P3", "Key infrastructure ")
            ->setCellValue("Q3", "Potential Successful Case ")
            ->setCellValue("R3", "Critical Project ")
            ->setCellValue("S3", "Temp Supply Project ")
            ->setCellValue("T3", "BMS ")
            ->setCellValue("U3", "Change Over Scheme ")
            ->setCellValue("V3", "Chiller Plant ")
            ->setCellValue("W3", "Escalator ")
            ->setCellValue("X3", "Hid Lamp ")
            ->setCellValue("Y3", "Lift ")
            ->setCellValue("Z3", "Sensitive Machine ")
            ->setCellValue("AA3", "Telcom ")
            ->setCellValue("AB3", "acbTripping ")
            ->setCellValue("AC3", "Building With High Penetration Equipment ")
            ->setCellValue("AD3", "RE ")
            ->setCellValue("AE3", "EV ")
            ->setCellValue("AF3", "Estimated Load ")
            ->setCellValue("AG3", "PQIS Number ")
            ->setCellValue("AH3", "PQ site walk Project Region ")
            ->setCellValue("AI3", "PQ site walk Project Address ")
            ->setCellValue("AJ3", "Sensitive Equipment and Corresponding Mitigation Solutions Found During Site Walk ")
            ->setCellValue("AK3", "1st PQ site Walk Date ")
            ->setCellValue("AL3", "1st PQ site Walk Status ")
            ->setCellValue("AM3", "1st PQ site walk invitation letter’s link ")
            ->setCellValue("AN3", "Letter for request 1st PQ site walk date ")
            ->setCellValue("AO3", "PQ walk assessment report Date ")
            ->setCellValue("AP3", "PQ walk assessment report link/path ")
            ->setCellValue("AQ3", "1st PQ site Walk PQSIS Case No ")
            ->setCellValue("AR3", "1st Customer response for site walk ")
            ->setCellValue("AS3", "1st Investigation Status ")
            ->setCellValue("AT3", "2nd PQ site Walk Date ")
            ->setCellValue("AU3", "2nd PQ site walk invitation letter’s link ")
            ->setCellValue("AV3", "Letter for request 2nd PQ site walk date ")
            ->setCellValue("AW3", "PQ assessment follow up report Date  ")
            ->setCellValue("AX3", "PQ assessment follow up report link/path ")
            ->setCellValue("AY3", "2nd PQ site Walk PQSIS Case No ")
            ->setCellValue("AZ3", "2nd Customer response for site walk ")
            ->setCellValue("BA3", "2nd Investigation Status ")
            ->setCellValue("BB3", "Consultant Company Name ")
            ->setCellValue("BC3", "Consultant Name ")
            ->setCellValue("BD3", "Phone No.1 ")
            ->setCellValue("BE3", "Phone No.2 ")
            ->setCellValue("BF3", "Phone No.3 ")
            ->setCellValue("BG3", "email 1 ")
            ->setCellValue("BH3", "email 2 ")
            ->setCellValue("BI3", "email 3 ")
            ->setCellValue("BJ3", "consultant information remark ")
            ->setCellValue("BK3", "Estimated Commisioning Date(By Customer) ")
            ->setCellValue("BL3", "Estimated Commisioning Date(By Region) ")
            ->setCellValue("BM3", " Planning Ahead Status ")
            ->setCellValue("BN3", " Plan ahead meeting Date")
            ->setCellValue("BO3", " Reply Slip PQSIS Case No ")
            ->setCellValue("BP3", " Target Reply Slip return Date  ")
            ->setCellValue("BQ3", " Finish?")
            ->setCellValue("BR3", " Actual Reply Slip Return Date")
            ->setCellValue("BS3", " Findings from Reply Slip")
            ->setCellValue("BT3", " Follow Up Action?")
            ->setCellValue("BU3", " Follow Up Action")
            ->setCellValue("BV3", " Reply Slip Remark")
            ->setCellValue("BW3", " Plan ahead meeting Fax Link")
            ->setCellValue("BX3", " Reply Slip Fax Link")
            ->setCellValue("BY3", " Del reply Slip Grade")
            ->setCellValue("BZ3", " Date of requested for return reply slip")
            ->setCellValue("CA3", " Receive Complaint")
            ->setCellValue("CB3", " Follow-up Action")
            ->setCellValue("CC3", " Remark");

        for ($i = 1; $i <= 82; $i++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setAutoSize(true);
        }
        //0,1,3,4,5,7,8,9,10,2,11
        $planningAheadReplySlipEndRow = 3;
        foreach ($planningAheadSiteWalkList as $planningAhead) {

            $planningAheadReplySlipEndRow = $planningAheadReplySlipEndRow + 1;
            if ($planningAhead["projectAddressParentCaseNo"] != null) {
                if ($planningAhead["projectAddressCaseVersion"] != null) {
                    $projectAddressParentCaseNo = $planningAhead["projectAddressParentCaseNo"]+"."+$planningAhead["projectAddressCaseVersion"];
                } else {
                    $projectAddressParentCaseNo = $planningAhead["projectAddressParentCaseNo"];
                }
            } else {
                $projectAddressParentCaseNo = "";
            }

            if ($planningAhead["firstPqSiteWalkParentCaseNo"] != null) {
                if ($planningAhead["firstPqSiteWalkCaseVersion"] != null) {
                    $firstPqSiteWalkParentCaseNo = $planningAhead["firstPqSiteWalkParentCaseNo"]+"."+$planningAhead["firstPqSiteWalkCaseVersion"];
                } else {
                    $firstPqSiteWalkParentCaseNo = $planningAhead["firstPqSiteWalkParentCaseNo"];
                }
            } else {
                $firstPqSiteWalkParentCaseNo = "";
            }

            if ($planningAhead["secondPqSiteWalkParentCaseNo"] != null) {
                if ($planningAhead["secondPqSiteWalkCaseVersion"] != null) {
                    $secondPqSiteWalkParentCaseNo = $planningAhead["secondPqSiteWalkParentCaseNo"]+"."+$planningAhead["secondPqSiteWalkCaseVersion"];
                } else {
                    $secondPqSiteWalkParentCaseNo = $planningAhead["secondPqSiteWalkParentCaseNo"];
                }
            } else {
                $secondPqSiteWalkParentCaseNo = "";
            }

            if ($planningAhead["replySlipParentCaseNo"] != null) {
                if ($planningAhead["replySlipCaseVersion"] != null) {
                    $replySlipParentCaseNo = $planningAhead["replySlipParentCaseNo"]+"."+$planningAhead["replySlipCaseVersion"];
                } else {
                    $replySlipParentCaseNo = $planningAhead["replySlipParentCaseNo"];
                }
            } else {
                $replySlipParentCaseNo = "";
            }
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A" . $planningAheadReplySlipEndRow, $planningAhead["planningAheadId"])
                ->setCellValue("B" . $planningAheadReplySlipEndRow, $planningAhead["projectTitle"])
                ->setCellValue("C" . $planningAheadReplySlipEndRow, $planningAhead["projectRegion"])
                ->setCellValue("D" . $planningAheadReplySlipEndRow, $planningAhead["projectAddress"])
                ->setCellValue("E" . $planningAheadReplySlipEndRow, $planningAhead["active"])
                ->setCellValue("F" . $planningAheadReplySlipEndRow, $planningAhead["schemeNumber"])
                ->setCellValue("G" . $planningAheadReplySlipEndRow, $projectAddressParentCaseNo)
                ->setCellValue("H" . $planningAheadReplySlipEndRow, $planningAhead["inputDate"])
                ->setCellValue("I" . $planningAheadReplySlipEndRow, $planningAhead["regionLetterIssueDate"])
                ->setCellValue("J" . $planningAheadReplySlipEndRow, $planningAhead["reportedBy"])
                ->setCellValue("K" . $planningAheadReplySlipEndRow, $planningAhead["lastUpdatedBy"])
                ->setCellValue("L" . $planningAheadReplySlipEndRow, $planningAhead["lastUpdatedTime"])
                ->setCellValue("M" . $planningAheadReplySlipEndRow, $planningAhead["regionPlannerName"])
                ->setCellValue("N" . $planningAheadReplySlipEndRow, $planningAhead["buildingTypeName"])
                ->setCellValue("O" . $planningAheadReplySlipEndRow, $planningAhead["projectTypeName"])
                ->setCellValue("P" . $planningAheadReplySlipEndRow, $planningAhead["keyInfrastructure"])
                ->setCellValue("Q" . $planningAheadReplySlipEndRow, $planningAhead["potentialSuccessfulCase"])
                ->setCellValue("R" . $planningAheadReplySlipEndRow, $planningAhead["criticalProject"])
                ->setCellValue("S" . $planningAheadReplySlipEndRow, $planningAhead["tempSupplyProject"])
                ->setCellValue("T" . $planningAheadReplySlipEndRow, $planningAhead["bms"])
                ->setCellValue("U" . $planningAheadReplySlipEndRow, $planningAhead["changeoverScheme"])
                ->setCellValue("V" . $planningAheadReplySlipEndRow, $planningAhead["chillerPlant"])
                ->setCellValue("W" . $planningAheadReplySlipEndRow, $planningAhead["escalator"])
                ->setCellValue("X" . $planningAheadReplySlipEndRow, $planningAhead["hidLamp"])
                ->setCellValue("Y" . $planningAheadReplySlipEndRow, $planningAhead["lift"])
                ->setCellValue("Z" . $planningAheadReplySlipEndRow, $planningAhead["sensitiveMachine"])
                ->setCellValue("AA" . $planningAheadReplySlipEndRow, $planningAhead["telcom"])
                ->setCellValue("AB" . $planningAheadReplySlipEndRow, $planningAhead["acbTripping"])
                ->setCellValue("AC" . $planningAheadReplySlipEndRow, $planningAhead["buildingWithHighPenetrationEquipment"])
                ->setCellValue("AD" . $planningAheadReplySlipEndRow, $planningAhead["re"])
                ->setCellValue("AE" . $planningAheadReplySlipEndRow, $planningAhead["ev"])
                ->setCellValue("AF" . $planningAheadReplySlipEndRow, $planningAhead["estimatedLoad"])
                ->setCellValue("AG" . $planningAheadReplySlipEndRow, $planningAhead["pqisNumber"])
                ->setCellValue("AH" . $planningAheadReplySlipEndRow, $planningAhead["pqSiteWalkProjectRegion"])
                ->setCellValue("AI" . $planningAheadReplySlipEndRow, $planningAhead["pqSiteWalkProjectAddress"])
                ->setCellValue("AJ" . $planningAheadReplySlipEndRow, $planningAhead["sensitiveEquipment"])
                ->setCellValue("AK" . $planningAheadReplySlipEndRow, $planningAhead["firstPqSiteWalkDate"])
                ->setCellValue("AL" . $planningAheadReplySlipEndRow, $planningAhead["firstPqSiteWalkStatus"])
                ->setCellValue("AM" . $planningAheadReplySlipEndRow, $planningAhead["firstPqSiteWalkInvitationLetterLink"])
                ->setCellValue("AN" . $planningAheadReplySlipEndRow, $planningAhead["firstPqSiteWalkRequestLetterDate"])
                ->setCellValue("AO" . $planningAheadReplySlipEndRow, $planningAhead["pqWalkAssessmentReportDate"])
                ->setCellValue("AP" . $planningAheadReplySlipEndRow, $planningAhead["pqWalkAssessmentReportLink"])
                ->setCellValue("AQ" . $planningAheadReplySlipEndRow, $firstPqSiteWalkParentCaseNo)
                ->setCellValue("AR" . $planningAheadReplySlipEndRow, $planningAhead["firstPqSiteWalkCustomerResponse"])
                ->setCellValue("AS" . $planningAheadReplySlipEndRow, $planningAhead["firstPqSiteWalkInvestigationStatus"])
                ->setCellValue("AT" . $planningAheadReplySlipEndRow, $planningAhead["secondPqSiteWalkDate"])
                ->setCellValue("AU" . $planningAheadReplySlipEndRow, $planningAhead["secondPqSiteWalkInvitationLetterLink"])
                ->setCellValue("AV" . $planningAheadReplySlipEndRow, $planningAhead["secondPqSiteWalkRequestLetterDate"])
                ->setCellValue("AW" . $planningAheadReplySlipEndRow, $planningAhead["pqAssessmentFollowUpReportDate"])
                ->setCellValue("AX" . $planningAheadReplySlipEndRow, $planningAhead["pqAssessmentFollowUpReportLink"])
                ->setCellValue("AY" . $planningAheadReplySlipEndRow, $secondPqSiteWalkParentCaseNo)
                ->setCellValue("AZ" . $planningAheadReplySlipEndRow, $planningAhead["secondPqSiteWalkCustomerResponse"])
                ->setCellValue("BA" . $planningAheadReplySlipEndRow, $planningAhead["secondPqSiteWalkInvestigationStatus"])
                ->setCellValue("BB" . $planningAheadReplySlipEndRow, $planningAhead["consultantCompanyName"])
                ->setCellValue("BC" . $planningAheadReplySlipEndRow, $planningAhead["consultantName"])
                ->setCellValue("BD" . $planningAheadReplySlipEndRow, $planningAhead["phoneNumber1"])
                ->setCellValue("BE" . $planningAheadReplySlipEndRow, $planningAhead["phoneNumber2"])
                ->setCellValue("BF" . $planningAheadReplySlipEndRow, $planningAhead["phoneNumber3"])
                ->setCellValue("BG" . $planningAheadReplySlipEndRow, $planningAhead["email1"])
                ->setCellValue("BH" . $planningAheadReplySlipEndRow, $planningAhead["email2"])
                ->setCellValue("BI" . $planningAheadReplySlipEndRow, $planningAhead["email3"])
                ->setCellValue("BJ" . $planningAheadReplySlipEndRow, $planningAhead["consultantInformationRemark"])
                ->setCellValue("BK" . $planningAheadReplySlipEndRow, $planningAhead["estimatedCommisioningDateByCustomer"])
                ->setCellValue("BL" . $planningAheadReplySlipEndRow, $planningAhead["estimatedCommisioningDateByRegion"])
                ->setCellValue("BM" . $planningAheadReplySlipEndRow, $planningAhead["planningAheadStatus"])
                ->setCellValue("BN" . $planningAheadReplySlipEndRow, $planningAhead["invitationToPaMeetingDate"])
                ->setCellValue("BO" . $planningAheadReplySlipEndRow, $replySlipParentCaseNo)
                ->setCellValue("BP" . $planningAheadReplySlipEndRow, $planningAhead["replySlipSentDate"])
                ->setCellValue("BQ" . $planningAheadReplySlipEndRow, $planningAhead["finish"])
                ->setCellValue("BR" . $planningAheadReplySlipEndRow, $planningAhead["actualReplySlipReturnDate"])
                ->setCellValue("BS" . $planningAheadReplySlipEndRow, $planningAhead["findingsFromReplySlip"])
                ->setCellValue("BT" . $planningAheadReplySlipEndRow, $planningAhead["replySlipfollowUpActionFlag"])
                ->setCellValue("BU" . $planningAheadReplySlipEndRow, $planningAhead["replySlipfollowUpAction"])
                ->setCellValue("BV" . $planningAheadReplySlipEndRow, $planningAhead["replySlipRemark"])
                ->setCellValue("BW" . $planningAheadReplySlipEndRow, $planningAhead["replySlipSendLink"])
                ->setCellValue("BX" . $planningAheadReplySlipEndRow, $planningAhead["replySlipReturnLink"])
                ->setCellValue("BY" . $planningAheadReplySlipEndRow, $planningAhead["replySlipGradeName"])
                ->setCellValue("BZ" . $planningAheadReplySlipEndRow, $planningAhead["dateOfRequestedForReturnReplySlip"])
                ->setCellValue("CA" . $planningAheadReplySlipEndRow, $planningAhead["receiveComplaint"])
                ->setCellValue("CB" . $planningAheadReplySlipEndRow, $planningAhead["followUpAction"])
                ->setCellValue("CC" . $planningAheadReplySlipEndRow, $planningAhead["remark"]);

        }

        $objPHPExcel->getActiveSheet()->getStyle('A3:CC3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
#endregion sheet2
        #region Sheet3 chart1
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);
        $objPHPExcel->getActiveSheet()->setTitle('replySlipReturnRate');

        $chart1StartColumn = 0;
        $chart1EndColumn = $chart1StartColumn + 2;
        $chart1StartRow = 1;
        $listLength = count($planningAheadReplySlipReturnRateList);
        $chart1EndRow = 1 + $listLength;

//Title
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart1StartColumn) . ($chart1StartRow), "");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart1StartColumn + 1) . ($chart1StartRow), "Rate");

//Value
        $i = ($chart1StartRow + 1);
        foreach ($planningAheadReplySlipReturnRateList as $List) {

            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart1StartColumn) . ($i), $List['year']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart1StartColumn + 1) . ($i), $List['returnRate']);
            $i++;

        }
//  Set the Labels for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataseriesLabels1 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'replySlipReturnRate!$B$1', null, 1), //  Rate
        );

//  Set the X-Axis Labels
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $xAxisTickValues = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'replySlipReturnRate!$A$2:$A$' . ($chart1EndRow), null, $listLength), //  year
        );
//  Set the Data values for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataSeriesValues1 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'replySlipReturnRate!$B$2:$B$' . ($chart1EndRow), null, $listLength),

        );

//  Build the dataseries
        $series1 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_BARCHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues1) - 1), // plotOrder
            $dataseriesLabels1, // plotLabel
            $xAxisTickValues, // plotCategory
            $dataSeriesValues1 // plotValues
        );

//  Set additional dataseries parameters
        //      Make it a vertical column rather than a horizontal bar graph
        $series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

        $layout = new PHPExcel_Chart_Layout();
        $layout->setShowVal(true);
//  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea($layout, array($series1));
//  Set the chart legend
        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);

        $title = new PHPExcel_Chart_Title('Reply slip return rate');

//  axis Label
        $axis = new PHPExcel_Chart_Axis();
        $axis->setAxisOptionsProperties("nextTo", null, null, null, null, null, 0, 1);

//  Create the chart
        $chart1 = new PHPExcel_Chart(
            'chart1', // name
            $title, // title
            $legend, // legend
            $plotarea, // plotArea
            true, // plotVisibleOnly
            0, // displayBlanksAs
            null, // xAxisLabel
            null, // yAxisLabel
            null,
            $axis

        );

//  Set the position where the chart should appear in the worksheet
        $chart1->setTopLeftPosition('A' . ($listLength + 2));
        $chart1->setBottomRightPosition('Q' . ($listLength + 17));
        $objPHPExcel->getActiveSheet()->addChart($chart1);
#endregion Sheet3 chart1

#region Sheet4 chart2
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(3);
        $objPHPExcel->getActiveSheet()->setTitle('SiteWalkReturnRate');

        $chart2StartColumn = 0;
        $chart2EndColumn = $chart2StartColumn + 2;
        $chart2StartRow = 1;
        $listLength = count($planningAheadSiteWalkReturnRateList);
        $chart2EndRow = 1 + $listLength;

//Title
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart2StartColumn) . ($chart2StartRow), "");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart2StartColumn + 1) . ($chart2StartRow), "Rate");

//Value
        $i = ($chart2StartRow + 1);
        foreach ($planningAheadSiteWalkReturnRateList as $List) {

            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart2StartColumn) . ($i), $List['year']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart2StartColumn + 1) . ($i), $List['returnRate']);
            $i++;

        }
//  Set the Labels for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataseriesLabels1 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'SiteWalkReturnRate!$B$1', null, 1), //  Rate
        );

//  Set the X-Axis Labels
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $xAxisTickValues = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'SiteWalkReturnRate!$A$2:$A$' . ($chart2EndRow), null, $listLength), //  year
        );
//  Set the Data values for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataSeriesValues1 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'SiteWalkReturnRate!$B$2:$B$' . ($chart2EndRow), null, $listLength),

        );

//  Build the dataseries
        $series1 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_BARCHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues1) - 1), // plotOrder
            $dataseriesLabels1, // plotLabel
            $xAxisTickValues, // plotCategory
            $dataSeriesValues1 // plotValues
        );

//  Set additional dataseries parameters
        //      Make it a vertical column rather than a horizontal bar graph
        $series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

        $layout = new PHPExcel_Chart_Layout();
        $layout->setShowVal(true);
//  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea($layout, array($series1));
//  Set the chart legend
        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);

        $title = new PHPExcel_Chart_Title('Site Walk return rate');

//  axis Label
        $axis = new PHPExcel_Chart_Axis();
        $axis->setAxisOptionsProperties("nextTo", null, null, null, null, null, 0, 1);

//  Create the chart
        $chart2 = new PHPExcel_Chart(
            'chart2', // name
            $title, // title
            $legend, // legend
            $plotarea, // plotArea
            true, // plotVisibleOnly
            0, // displayBlanksAs
            null, // xAxisLabel
            null, // yAxisLabel
            null,
            $axis

        );

//  Set the position where the chart should appear in the worksheet
        $chart2->setTopLeftPosition('A' . ($listLength + 2));
        $chart2->setBottomRightPosition('Q' . ($listLength + 17));
        $objPHPExcel->getActiveSheet()->addChart($chart2);
#endregion Sheet4 chart2

        //generate report now
        $this->layout = false;
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . "PlanningAheadStatusReport(" . $startDay . "-" . $startMonth . "-" . $startYear . ")" . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setPreCalculateFormulas(true);
        $objWriter->setIncludeCharts(true);
        $objWriter->save('php://output');
        return;

    }
#endregion planningAhead
    public function actionCaseReportSearch()
    {
        $this->viewbag['caseFormReporStartDay'] = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormReporStartDay');
        $this->viewbag['caseFormReporEndDay'] = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormReporEndDay');

        $this->render("//site/report/CaseReportSearch");
    }

    public function actionCaseReportDownload()
    {
        $caseFormReporStartDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormReporStartDay');
        $caseFormReporEndDay = Yii::app()->commonUtil->getConfigValueByConfigName('caseFormReporEndDay');

        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        parse_str(parse_url($url, PHP_URL_QUERY), $param);
        $mode = $param['mode'];
        $startYear = $param['startYear'];
        $startMonth = $param['startMonth'];
        $startDay = $param['startDay'];
        $endYear = $param['endYear'];
        $endMonth = $param['endMonth'];
        $endDay = $param['endDay'];
        if ($mode != "byDate") {

            if (($endYear - $startYear) > 0) {
                $countMonth = $endMonth;

            } else {
                $countMonth = ($endMonth - $startMonth);
            }
        } else {

            $countMonth = ($endMonth - $startMonth);
            if ($endMonth == $startMonth) {
                $countMonth = 1;
            }
        }
        if ($startMonth < 10) {
            $startDate = $startDay . "/0" . $startMonth . "/" . $startYear;

        } else {
            $startDate = $startDay . "/" . $startMonth . "/" . $startYear;
            $endDate = $endDay . "/" . $endMonth . "/" . $endYear;
        }
        if ($endMonth < 10) {
            $endDate = $endDay . "/0" . $endMonth . "/" . $endYear;
        } else {
            $endDate = $endDay . "/" . $endMonth . "/" . $endYear;
        }

        $caseFormList = Yii::app()->formDao->getCaseFormForServiceCaseReportByDateRange($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay);
        $caseFormChart1 = Yii::app()->reportDao->getCaseFormReportChart1($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay);
        $caseFormChart2 = Yii::app()->reportDao->getCaseFormReportChart2($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay);
        $caseFormChart3 = Yii::app()->reportDao->getCaseFormReportChart3($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay);
        $caseFormChart4 = Yii::app()->reportDao->getCaseFormReportChart4($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay);
        $caseFormChart5 = Yii::app()->reportDao->getCaseFormReportChart5($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay);
        $caseFormChart6 = Yii::app()->reportDao->getCaseFormReportChart6($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay);
        $caseFormChart7 = Yii::app()->reportDao->getCaseFormReportChart7($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay);
        // $caseFormChart1LastYearAverage = (Yii::app()->reportDao->getCaseFormReportChart1LastYearTotal($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay) )/12;
        $serviceTypeList = Yii::app()->formDao->getFormServiceTypeActiveUnionForm($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay);
        $serviceTypeCount = count($serviceTypeList);
        $partyToBeChargedList = Yii::app()->formDao->getFormPartyToBeChargedActiveUnionForm($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay);
        $partyToBeChargedCount = count($partyToBeChargedList);
        $budgetList = Yii::app()->reportDao->getBudgetActiveUnionForm($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay);
        $userModal = Yii::app()->session['tblUserDo'];
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator($userModal["username"])
            ->setLastModifiedBy($userModal["username"])
            ->setTitle("ServiceCaseReport(" . $startDay . "-" . $startMonth . "-" . $startYear . ")")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        // Merge cells
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        //special text
        $objRichTextMainDate = new PHPExcel_RichText();
        $objPayableMainDate = $objRichTextMainDate->createTextRun("Report Period: " . $startDate . " ~ " . $endDate);
        $objPayableMainDate->getFont()->setBold(true);
        $objPayableMainDate->getFont()->setItalic(true);
        $objPayableMainDate->getFont()->setSize(20);
        $objPayableMainDate->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $objRichTextMainDate);
        //$objPHPExcel->getActiveSheet()->unmergeCells('A28:B28');    // Just to test...

        //SET Sheet Start Index
        $objPHPExcel->setActiveSheetIndex(0);

        //SET title
        $objRichTextA = new PHPExcel_RichText();
        $objPayableA = $objRichTextA->createTextRun("Case No.");
        $objPayableA->getFont()->setBold(true);
        //$objPayableA->getFont()->setItalic(true);
        $objPayableA->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));

        $objRichTextB = new PHPExcel_RichText();
        $objPayableB = $objRichTextB->createTextRun("Customer Name");
        $objPayableB->getFont()->setBold(true);
        //$objPayableB->getFont()->setItalic(true);
        $objPayableB->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));

        $objRichTextC = new PHPExcel_RichText();
        $objPayableC = $objRichTextC->createTextRun("Plant Type");
        $objPayableC->getFont()->setBold(true);
        //$objPayableC->getFont()->setItalic(true);
        $objPayableC->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));

        $objRichTextD = new PHPExcel_RichText();
        $objPayableD = $objRichTextD->createTextRun("Customer Group");
        $objPayableD->getFont()->setBold(true);
        //$objPayableD->getFont()->setItalic(true);
        $objPayableD->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));

        $objRichTextE = new PHPExcel_RichText();
        $objPayableE = $objRichTextE->createTextRun("Request Date");
        $objPayableE->getFont()->setBold(true);
        //$objPayableE->getFont()->setItalic(true);
        $objPayableE->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));

        $objRichTextF = new PHPExcel_RichText();
        $objPayableF = $objRichTextF->createTextRun("Service Type");
        $objPayableF->getFont()->setBold(true);
        //$objPayableF->getFont()->setItalic(true);
        $objPayableF->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));

        $objRichTextG = new PHPExcel_RichText();
        $objPayableG = $objRichTextG->createTextRun("Service Charging(k)");
        $objPayableG->getFont()->setBold(true);
        //$objPayableG->getFont()->setItalic(true);
        $objPayableG->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));

        $objRichTextH = new PHPExcel_RichText();
        $objPayableH = $objRichTextH->createTextRun("Charged department");
        $objPayableH->getFont()->setBold(true);
        //$objPayableH->getFont()->setItalic(true);
        $objPayableH->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));

        $objRichTextI = new PHPExcel_RichText();
        $objPayableI = $objRichTextI->createTextRun("Service Completion Date");
        $objPayableI->getFont()->setBold(true);
        //$objPayableI->getFont()->setItalic(true);
        $objPayableI->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));

        $objRichTextJ = new PHPExcel_RichText();
        $objPayableJ = $objRichTextJ->createTextRun("Case Referred to CLPE");
        $objPayableJ->getFont()->setBold(true);
        //$objPayableJ->getFont()->setItalic(true);
        $objPayableJ->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));

        $objRichTextK = new PHPExcel_RichText();
        $objPayableK = $objRichTextK->createTextRun("All case");
        $objPayableK->getFont()->setBold(true);
        //$objPayableK->getFont()->setItalic(true);
        $objPayableK->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));

        $objRichTextL = new PHPExcel_RichText();
        $objPayableL = $objRichTextL->createTextRun("Closed case");
        $objPayableL->getFont()->setBold(true);
        //$objPayableL->getFont()->setItalic(true);
        $objPayableL->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));

        $objRichTextM = new PHPExcel_RichText();
        $objPayableM = $objRichTextM->createTextRun("in-progress case");
        $objPayableM->getFont()->setBold(true);
        //$objPayableM->getFont()->setItalic(true);
        $objPayableM->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));

        $objRichTextN = new PHPExcel_RichText();
        $objPayableN = $objRichTextN->createTextRun("Completed before target date");
        $objPayableN->getFont()->setBold(true);
        //$objPayableN->getFont()->setItalic(true);
        $objPayableN->getFont()->setColor(new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKBLUE));

        //Table1 Title
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $objRichTextA);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', $objRichTextB);
        $objPHPExcel->getActiveSheet()->setCellValue('C3', $objRichTextC);
        $objPHPExcel->getActiveSheet()->setCellValue('D3', $objRichTextD);
        $objPHPExcel->getActiveSheet()->setCellValue('E3', $objRichTextE);
        $objPHPExcel->getActiveSheet()->setCellValue('F3', $objRichTextF);
        $objPHPExcel->getActiveSheet()->setCellValue('G3', $objRichTextG);
        $objPHPExcel->getActiveSheet()->setCellValue('H3', $objRichTextH);
        $objPHPExcel->getActiveSheet()->setCellValue('I3', $objRichTextI);
        $objPHPExcel->getActiveSheet()->setCellValue('J3', $objRichTextJ);
        $objPHPExcel->getActiveSheet()->setCellValue('K3', $objRichTextK);
        $objPHPExcel->getActiveSheet()->setCellValue('L3', $objRichTextL);
        $objPHPExcel->getActiveSheet()->setCellValue('M3', $objRichTextM);
        $objPHPExcel->getActiveSheet()->setCellValue('N3', $objRichTextN);
        $objPHPExcel->getActiveSheet()->setTitle('Actual case');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //Table1 Data
        $serviceCaseEndRow = 3;

        foreach ($caseFormList as $caseForm) {
            $serviceCaseEndRow++;
            if ($caseForm['caseVersion'] != null) {
                $caseNo = $caseForm['parentCaseNo'] . "." . $caseForm['caseVersion'];
            } else {
                $caseNo = $caseForm['parentCaseNo'];
            }
            if ($caseForm['caseReferredToClpe'] == "Y") {
                $caseReferredToClpe = "Yes";
            } else {
                $caseReferredToClpe = "No";
            }

            if ($caseForm['requestDate'] != "") {
                $requestDate = date('d-m-Y', strtotime($caseForm['requestDate']));
                $requestDate = PHPExcel_Shared_Date::PHPToExcel($requestDate);

            } else {
                $requestDate = "";

            }
            //Get different serviceCompletionDate by serviceType
            if($caseForm['serviceTypeId'] == 3 || $caseForm['serviceTypeId'] == 4){
                $serviceCompletionDate = $caseForm['actualReportIssueDate'];
            }else if($caseForm['serviceTypeId'] == 2 || $caseForm['serviceTypeId'] == 6){
                $serviceCompletionDate = $caseForm['actualVisitDate'];
            }else {
                $serviceCompletionDate = $caseForm['serviceCompletionDate'];
            }
            if ($serviceCompletionDate != "") {
                $serviceCompletionDate = date('d-m-Y', strtotime($serviceCompletionDate));
                $serviceCompletionDate = PHPExcel_Shared_Date::PHPToExcel($serviceCompletionDate);
            } else {
                $serviceCompletionDate = "";
            }

            if ($caseForm['completedBeforeTargetDate'] == "Y") {
                $completedBeforeTargetDate = 'Yes';
            } elseif ($caseForm['completedBeforeTargetDate'] == "N") {
                $completedBeforeTargetDate = 'No';
            } else {
                $completedBeforeTargetDate = 'N/A';
            }

            $objPHPExcel->getActiveSheet()
                ->setCellValue("A" . $serviceCaseEndRow, $caseNo)
                ->setCellValue("B" . $serviceCaseEndRow, $caseForm['customerName'])
                ->setCellValue("C" . $serviceCaseEndRow, $caseForm['plantTypeName'])
                ->setCellValue("D" . $serviceCaseEndRow, $caseForm['customerGroup'])
                ->setCellValue("E" . $serviceCaseEndRow, $requestDate)
                ->setCellValue("F" . $serviceCaseEndRow, $caseForm['serviceTypeName'])
                ->setCellValue("G" . $serviceCaseEndRow, $caseForm['costTotal'])
                ->setCellValue("H" . $serviceCaseEndRow, $caseForm['partyToBeChargedName'])
                ->setCellValue("I" . $serviceCaseEndRow, $serviceCompletionDate)
                ->setCellValue("J" . $serviceCaseEndRow, $caseReferredToClpe)
                ->setCellValue("K" . $serviceCaseEndRow, $caseForm['allCase'])
                ->setCellValue("L" . $serviceCaseEndRow, $caseForm['closedCase'])
                ->setCellValue("M" . $serviceCaseEndRow, $caseForm['inProgressCase'])
                ->setCellValue("N" . $serviceCaseEndRow, $completedBeforeTargetDate);
            //->setCellValue("N" . $serviceCaseEndRow, )
        }
        //set Column Data Format
        $objPHPExcel->getActiveSheet()->getStyle("E2:E" . $serviceCaseEndRow)->getNumberFormat()->setFormatCode('dd-mmm-yyyy');
        $objPHPExcel->getActiveSheet()->getStyle("I2:I" . $serviceCaseEndRow)->getNumberFormat()->setFormatCode('dd-mmm-yyyy');
        $objPHPExcel->getActiveSheet()->getStyle("G2:G" . $serviceCaseEndRow)->getNumberFormat()->setFormatCode('0,');
        //Start of Table2
        $table2StartRow = $serviceCaseEndRow + 2;
        // Set thin black border outline around column
        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );
        $styleBgColorYellow = array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'FFF2CC',

            ),
        );
        // Merge cells and add border
        // PHPExcel_Cell::stringFromColumnIndex(5+$partyToBeChargedCount); get Column name Eg. A,B,AZ, A=0
        $fixedServiceTypeRow = 0;
        $verticalTitle1MergeCell = 3;
        $verticalTitle2MergeCell = $serviceTypeCount + $fixedServiceTypeRow;
        $verticalTitle3MergeCell = 6;
        $horizontalTitle1MergeCell = 3;
        $verticalTitle1MergeStartRow = $table2StartRow;
        $verticalTitle1MergeEndRow = ($table2StartRow + $verticalTitle1MergeCell);
        $verticalTitle2MergeStartRow = $verticalTitle1MergeEndRow + 1;
        $verticalTitle2MergeEndRow = $verticalTitle1MergeEndRow + $verticalTitle2MergeCell;
        $verticalTitle3MergeStartRow = $verticalTitle2MergeEndRow + 1;
        $verticalTitle3MergeEndRow = $verticalTitle2MergeEndRow + $verticalTitle3MergeCell;
        $caseTypeStartColumn = 2; //0=A;
        $caseTypeEndColumn = $caseTypeStartColumn + 2;
        $partyToBeChargedStartColumn = 1 + $horizontalTitle1MergeCell + 1;
        $partyToBeChargedEndColumn = $partyToBeChargedStartColumn + $partyToBeChargedCount;
        $table2EndColumn = 1 + $horizontalTitle1MergeCell + $partyToBeChargedCount + 1;
        $table2EndRow = ($table2StartRow + $verticalTitle1MergeCell + $verticalTitle2MergeCell + $verticalTitle3MergeCell + 3);

        //Whole Form border
        $objPHPExcel->getActiveSheet()->getStyle('A' . $table2StartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($table2EndColumn) . $table2EndRow)->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($partyToBeChargedStartColumn) . ($table2StartRow + 2) . ':' . PHPExcel_Cell::stringFromColumnIndex($table2EndColumn) . ($table2StartRow + 2))->getFill()->applyFromArray($styleBgColorYellow);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($partyToBeChargedStartColumn) . ($table2StartRow + 3) . ':' . PHPExcel_Cell::stringFromColumnIndex($table2EndColumn) . ($table2StartRow + 3))->getFill()->applyFromArray($styleBgColorYellow);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($partyToBeChargedStartColumn) . ($verticalTitle3MergeStartRow) . ':' . PHPExcel_Cell::stringFromColumnIndex($partyToBeChargedEndColumn) . ($verticalTitle3MergeStartRow))->getFill()->applyFromArray($styleBgColorYellow);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($partyToBeChargedStartColumn) . ($verticalTitle3MergeStartRow + 1) . ':' . PHPExcel_Cell::stringFromColumnIndex($partyToBeChargedEndColumn) . ($verticalTitle3MergeStartRow + 1))->getFill()->applyFromArray($styleBgColorYellow);
        //Vertical
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $verticalTitle1MergeStartRow . ':A' . $verticalTitle1MergeEndRow); //  Period
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $verticalTitle2MergeStartRow . ':A' . $verticalTitle2MergeEndRow); // Status
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $verticalTitle3MergeStartRow . ':A' . $verticalTitle3MergeEndRow); // Customer
        //Hoizontial
        $objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . $table2StartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($caseTypeEndColumn) . $table2StartRow); //CaseType
        $objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex($partyToBeChargedStartColumn) . $table2StartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($table2EndColumn) . $table2StartRow);
        //Add Table2 border
        for ($y = ($table2StartRow); $y <= $table2EndRow; $y++) {
            $column = 'A';
            for ($column = 'A'; $column <= PHPExcel_Cell::stringFromColumnIndex($table2EndColumn); $column++) {
                //  Do what you want with the cell
                $objPHPExcel->getActiveSheet()->getStyle($column . $y . ':' . $column . $y)->applyFromArray($styleThinBlackBorderOutline);
            }

        }
        //Add Table2 Title
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $table2StartRow, "Period");
        $objPHPExcel->getActiveSheet()->getStyle('A' . $table2StartRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $table2StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . $table2StartRow, "Case Type");
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . $table2StartRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . $table2StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($partyToBeChargedStartColumn) . $table2StartRow, "Charging department (for closed case only)");
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($partyToBeChargedStartColumn) . $table2StartRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($partyToBeChargedStartColumn) . $table2StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . ($table2StartRow + 1), "All case");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . ($table2StartRow + 1), "Closed case");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . ($table2StartRow + 1), "In-progress case");
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . ($table2StartRow + 1) . ":" . PHPExcel_Cell::stringFromColumnIndex($caseTypeEndColumn) . ($table2StartRow + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . ($table2StartRow + 1) . ":" . PHPExcel_Cell::stringFromColumnIndex($caseTypeEndColumn) . ($table2StartRow + 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $verticalTitle2MergeStartRow, "Status");
        $objPHPExcel->getActiveSheet()->getStyle('A' . $verticalTitle2MergeStartRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $verticalTitle2MergeStartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $verticalTitle3MergeStartRow, "Customer");
        $objPHPExcel->getActiveSheet()->getStyle('A' . $verticalTitle3MergeStartRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $verticalTitle3MergeStartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //hor subTtile

        $i = ($partyToBeChargedStartColumn - 1);
        foreach ($partyToBeChargedList as $partyToBeCharged) {
            $i++;
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($i) . ($table2StartRow + 1), $partyToBeCharged['partyToBeChargedName']);

        }
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($partyToBeChargedEndColumn) . ($table2StartRow + 1), "Sub-total");

        //vert subTitle

        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($table2StartRow + 2), "Planned budget :");
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($table2StartRow + 3), "Total records :");
        $serviceTypeEndRow = ($table2StartRow + 3);
        foreach ($serviceTypeList as $serviceType) {
            $serviceTypeEndRow++;
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $serviceTypeEndRow, $serviceType['serviceTypeName']);

        }
        //Fixed serviceType
        // $fixedServiceTypeRow
        /* $objPHPExcel->getActiveSheet()->setCellValue('B' . ($serviceTypeEndRow + 1), "Feasibility Study/ Consultancy");
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($serviceTypeEndRow + 2), "PQ Information and Reporting");*/
        // $objPHPExcel->getActiveSheet()->setCellValue('B' . ($serviceTypeEndRow + 3), "Plan ahead meeting");
        //CustomerTypeColumn
        //$verticalTitle3MergeCell
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($serviceTypeEndRow + 1), "Total (in term of cases)");
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($serviceTypeEndRow + 2), "Total (in term of customers)");
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($serviceTypeEndRow + 3), "LPT/BT (in term of cases)");
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($serviceTypeEndRow + 4), "LPT/BT (in term of customers)");
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($serviceTypeEndRow + 5), "Others (in term of cases)");
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($serviceTypeEndRow + 6), "Others (in term of customers)");

        $objPHPExcel->getActiveSheet()->getStyle('B' . ($table2StartRow + 2) . ":B" . ($serviceTypeEndRow + 6))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B' . ($table2StartRow + 2) . ":B" . ($serviceTypeEndRow + 6))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //set Fomula
        ///////3 Case Total
        $serviceTypeStartRow = $table2StartRow + 4;
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . ($serviceTypeStartRow - 1), '=SUM(' . '$' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . $serviceTypeStartRow . ':$' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . $serviceTypeEndRow . ')');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . ($serviceTypeStartRow - 1), '=SUM(' . '$' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . $serviceTypeStartRow . ':$' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . $serviceTypeEndRow . ')');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . ($serviceTypeStartRow - 1), '=SUM(' . '$' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . $serviceTypeStartRow . ':$' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . $serviceTypeEndRow . ')');
        /// 3 Case
        for ($y = $serviceTypeStartRow; $y <= $serviceTypeEndRow - 2; $y++) {
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . $y, '=COUNTIFS(' . '$F$4:$F$' . $serviceCaseEndRow . ',B' . $y . ',$K$4:$K$' . $serviceCaseEndRow . ',"Yes")');
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . $y, '=COUNTIFS(' . '$F$4:$F$' . $serviceCaseEndRow . ',B' . $y . ',$L$4:$L$' . $serviceCaseEndRow . ',"Yes")');
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . $y, '=COUNTIFS(' . '$F$4:$F$' . $serviceCaseEndRow . ',B' . $y . ',$M$4:$M$' . $serviceCaseEndRow . ',"Yes")');
        }
        ///3 Case for fixed ServiceTypeRow
        for ($y = ($serviceTypeEndRow - 1); $y <= ($serviceTypeEndRow + $fixedServiceTypeRow); $y++) {
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . $y, 'N/A');
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . $y, 'N/A');
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . $y, 'N/A');
        }
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . ($serviceTypeEndRow - 1) . ":" . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + $fixedServiceTypeRow) . ($serviceTypeEndRow + $fixedServiceTypeRow))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        ////Total
        //in terms of case
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . ($verticalTitle3MergeStartRow), '=SUM($' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . '$' . ($verticalTitle3MergeStartRow + 2) . ',$' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . '$' . ($verticalTitle3MergeStartRow + 4) . ')');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . ($verticalTitle3MergeStartRow), '=SUM($' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . '$' . ($verticalTitle3MergeStartRow + 2) . ',$' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . '$' . ($verticalTitle3MergeStartRow + 4) . ')');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . ($verticalTitle3MergeStartRow), '=SUM($' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . '$' . ($verticalTitle3MergeStartRow + 2) . ',$' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . '$' . ($verticalTitle3MergeStartRow + 4) . ')');
        //in terms of customer
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . ($verticalTitle3MergeStartRow + 1), '=SUM($' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . '$' . ($verticalTitle3MergeStartRow + 3) . ',$' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . '$' . ($verticalTitle3MergeStartRow + 5) . ')');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . ($verticalTitle3MergeStartRow + 1), '=SUM($' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . '$' . ($verticalTitle3MergeStartRow + 3) . ',$' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . '$' . ($verticalTitle3MergeStartRow + 5) . ')');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . ($verticalTitle3MergeStartRow + 1), '=SUM($' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . '$' . ($verticalTitle3MergeStartRow + 3) . ',$' . PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . '$' . ($verticalTitle3MergeStartRow + 54) . ')');
        ////LPT & BT
        //in terms of case
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . ($verticalTitle3MergeStartRow + 2), '=SUM(COUNTIFS(' . '$D$4:$D$' . $serviceCaseEndRow . ',{"*LPT*","*BT*"}' . ',$K$4:$K$' . $serviceCaseEndRow . ',"Yes"))');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . ($verticalTitle3MergeStartRow + 2), '=SUM(COUNTIFS(' . '$D$4:$D$' . $serviceCaseEndRow . ',{"*LPT*","*BT*"}' . ',$L$4:$L$' . $serviceCaseEndRow . ',"Yes"))');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . ($verticalTitle3MergeStartRow + 2), '=SUM(COUNTIFS(' . '$D$4:$D$' . $serviceCaseEndRow . ',{"*LPT*","*BT*"}' . ',$M$4:$M$' . $serviceCaseEndRow . ',"Yes"))');

        //in terms of customer
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . ($verticalTitle3MergeStartRow + 3), '=SUM(IF(ISNUMBER(SEARCH("*LPT*",$D$4:$D$' . $serviceCaseEndRow . ')), IF($K$4:$K$' . $serviceCaseEndRow . '="Yes",' . '(1/(COUNTIFS($D$4:$D$' . $serviceCaseEndRow . ',"*LPT*",$B$4:$B' . $serviceCaseEndRow . ',$B$4:$B$' . $serviceCaseEndRow . ',$K$4:$K$' . $serviceCaseEndRow . ',"Yes"))),0)' . ',0)) + SUM(IF(ISNUMBER(SEARCH("*BT*",$D$4:$D$' . $serviceCaseEndRow . ')), IF($K$4:$K$' . $serviceCaseEndRow . '="Yes",' . '(1/(COUNTIFS($D$4:$D$' . $serviceCaseEndRow . ',"*BT*",$B$4:$B' . $serviceCaseEndRow . ',$B$4:$B$' . $serviceCaseEndRow . ',$K$4:$K$' . $serviceCaseEndRow . ',"Yes"))),0)' . ',0))');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . ($verticalTitle3MergeStartRow + 3), '=SUM(IF(ISNUMBER(SEARCH("*LPT*",$D$4:$D$' . $serviceCaseEndRow . ')), IF($L$4:$L$' . $serviceCaseEndRow . '="Yes",' . '(1/(COUNTIFS($D$4:$D$' . $serviceCaseEndRow . ',"*LPT*",$B$4:$B' . $serviceCaseEndRow . ',$B$4:$B$' . $serviceCaseEndRow . ',$L$4:$L$' . $serviceCaseEndRow . ',"Yes"))),0)' . ',0)) + SUM(IF(ISNUMBER(SEARCH("*BT*",$D$4:$D$' . $serviceCaseEndRow . ')), IF($L$4:$L$' . $serviceCaseEndRow . '="Yes",' . '(1/(COUNTIFS($D$4:$D$' . $serviceCaseEndRow . ',"*BT*",$B$4:$B' . $serviceCaseEndRow . ',$B$4:$B$' . $serviceCaseEndRow . ',$L$4:$L$' . $serviceCaseEndRow . ',"Yes"))),0)' . ',0))');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . ($verticalTitle3MergeStartRow + 3), '=SUM(IF(ISNUMBER(SEARCH("*LPT*",$D$4:$D$' . $serviceCaseEndRow . ')), IF($M$4:$M$' . $serviceCaseEndRow . '="Yes",' . '(1/(COUNTIFS($D$4:$D$' . $serviceCaseEndRow . ',"*LPT*",$B$4:$B' . $serviceCaseEndRow . ',$B$4:$B$' . $serviceCaseEndRow . ',$M$4:$M$' . $serviceCaseEndRow . ',"Yes"))),0)' . ',0)) + SUM(IF(ISNUMBER(SEARCH("*BT*",$D$4:$D$' . $serviceCaseEndRow . ')), IF($M$4:$M$' . $serviceCaseEndRow . '="Yes",' . '(1/(COUNTIFS($D$4:$D$' . $serviceCaseEndRow . ',"*BT*",$B$4:$B' . $serviceCaseEndRow . ',$B$4:$B$' . $serviceCaseEndRow . ',$M$4:$M$' . $serviceCaseEndRow . ',"Yes"))),0)' . ',0))');
        $objPHPExcel->getActiveSheet()->getCell(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . ($verticalTitle3MergeStartRow + 3))->setFormulaAttributes(['t' => 'array']);
        $objPHPExcel->getActiveSheet()->getCell(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . ($verticalTitle3MergeStartRow + 3))->setFormulaAttributes(['t' => 'array']);
        $objPHPExcel->getActiveSheet()->getCell(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . ($verticalTitle3MergeStartRow + 3))->setFormulaAttributes(['t' => 'array']);

        ////Other
        //in terms of case
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . ($verticalTitle3MergeStartRow + 4), '=SUM(COUNTIFS(' . '$D$4:$D$' . $serviceCaseEndRow . ',"<>*LPT*",' . '$D$4:$D$' . $serviceCaseEndRow . ',"<>*BT*"' . ',$K$4:$K$' . $serviceCaseEndRow . ',"Yes"))');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . ($verticalTitle3MergeStartRow + 4), '=SUM(COUNTIFS(' . '$D$4:$D$' . $serviceCaseEndRow . ',"<>*LPT*",' . '$D$4:$D$' . $serviceCaseEndRow . ',"<>*BT*"' . ',$L$4:$L$' . $serviceCaseEndRow . ',"Yes"))');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . ($verticalTitle3MergeStartRow + 4), '=SUM(COUNTIFS(' . '$D$4:$D$' . $serviceCaseEndRow . ',"<>*LPT*",' . '$D$4:$D$' . $serviceCaseEndRow . ',"<>*BT*"' . ',$M$4:$M$' . $serviceCaseEndRow . ',"Yes"))');

        //in terms of customer
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . ($verticalTitle3MergeStartRow + 5), '=SUM(IF((ISNUMBER(SEARCH("*LPT*",$D$4:$D$' . $serviceCaseEndRow . '))+ISNUMBER(SEARCH("*BT*",$D$4:$D$' . $serviceCaseEndRow . ')))=0, IF($K$4:$K$' . $serviceCaseEndRow . '="Yes",' . '1/(COUNTIFS($D$4:$D$' . $serviceCaseEndRow . ',"<>*LPT*",$D$4:$D$' . $serviceCaseEndRow . ',"<>*BT*",$B$4:$B' . $serviceCaseEndRow . ',$B$4:$B$' . $serviceCaseEndRow . ',$K$4:$K$' . $serviceCaseEndRow . ',"Yes")),0)' . ',0))');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . ($verticalTitle3MergeStartRow + 5), '=SUM(IF((ISNUMBER(SEARCH("*LPT*",$D$4:$D$' . $serviceCaseEndRow . '))+ISNUMBER(SEARCH("*BT*",$D$4:$D$' . $serviceCaseEndRow . ')))=0, IF($L$4:$L$' . $serviceCaseEndRow . '="Yes",' . '1/(COUNTIFS($D$4:$D$' . $serviceCaseEndRow . ',"<>*LPT*",$D$4:$D$' . $serviceCaseEndRow . ',"<>*BT*",$B$4:$B' . $serviceCaseEndRow . ',$B$4:$B$' . $serviceCaseEndRow . ',$L$4:$L$' . $serviceCaseEndRow . ',"Yes")),0)' . ',0))');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . ($verticalTitle3MergeStartRow + 5), '=SUM(IF((ISNUMBER(SEARCH("*LPT*",$D$4:$D$' . $serviceCaseEndRow . '))+ISNUMBER(SEARCH("*BT*",$D$4:$D$' . $serviceCaseEndRow . ')))=0, IF($M$4:$M$' . $serviceCaseEndRow . '="Yes",' . '1/(COUNTIFS($D$4:$D$' . $serviceCaseEndRow . ',"<>*LPT*",$D$4:$D$' . $serviceCaseEndRow . ',"<>*BT*",$B$4:$B' . $serviceCaseEndRow . ',$B$4:$B$' . $serviceCaseEndRow . ',$M$4:$M$' . $serviceCaseEndRow . ',"Yes")),0)' . ',0))');
        $objPHPExcel->getActiveSheet()->getCell(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn) . ($verticalTitle3MergeStartRow + 5))->setFormulaAttributes(['t' => 'array']);
        $objPHPExcel->getActiveSheet()->getCell(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 1) . ($verticalTitle3MergeStartRow + 5))->setFormulaAttributes(['t' => 'array']);
        $objPHPExcel->getActiveSheet()->getCell(PHPExcel_Cell::stringFromColumnIndex($caseTypeStartColumn + 2) . ($verticalTitle3MergeStartRow + 5))->setFormulaAttributes(['t' => 'array']);

        /// department Cost Total

        for ($x = $partyToBeChargedStartColumn; $x <= $partyToBeChargedEndColumn; $x++) {
            //total
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($x) . ($serviceTypeStartRow - 1), '=SUM($' . PHPExcel_Cell::stringFromColumnIndex($x) . $serviceTypeStartRow . ':$' . PHPExcel_Cell::stringFromColumnIndex($x) . ($serviceTypeEndRow + $fixedServiceTypeRow) . ')');
            for ($s = $serviceTypeStartRow; $s <= ($serviceTypeEndRow + $fixedServiceTypeRow); $s++) {

                if ($x != $partyToBeChargedEndColumn) { //before last column

                    $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($x) . $s, '=SUMIFS($G4:$G' . $serviceCaseEndRow . ',$F4:$F' . $serviceCaseEndRow . ',$B' . $s . ',$L4:$L' . $serviceCaseEndRow . ',"Yes",$H4:$H' . $serviceCaseEndRow . ',$' . PHPExcel_Cell::stringFromColumnIndex($x) . ($table2StartRow + 1) . ')');
                } else {

                    $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($x) . $s, '=SUM($' . PHPExcel_Cell::stringFromColumnIndex($partyToBeChargedStartColumn) . $s . ':$' . PHPExcel_Cell::stringFromColumnIndex($partyToBeChargedEndColumn - 1) . $s . ')');

                }
            }

            for ($v = $verticalTitle3MergeStartRow; $v <= $verticalTitle3MergeEndRow; $v++) {

                if ($x != $partyToBeChargedEndColumn) { //before last column

                    //total Row
                    if ($v <= ($verticalTitle3MergeStartRow + 1)) {
                        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($x) . $v, '=SUM($' . PHPExcel_Cell::stringFromColumnIndex($x) . ($v + 2) . ',$' . PHPExcel_Cell::stringFromColumnIndex($x) . ($v + 4) . ')');
                    } else if ($v == ($verticalTitle3MergeStartRow + 2)) {
                        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($x) . $v, '=SUM(SUMIFS($G4:$G' . $serviceCaseEndRow . ',$D4:$D' . $serviceCaseEndRow . ',{"*LPT*","*BT*"},$L4:$L' . $serviceCaseEndRow . ',"Yes",$H4:$H' . $serviceCaseEndRow . ',$' . PHPExcel_Cell::stringFromColumnIndex($x) . ($table2StartRow + 1) . '))');
                    } else if ($v == ($verticalTitle3MergeStartRow + 4)) {
                        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($x) . $v, '=SUM(SUMIFS($G4:$G' . $serviceCaseEndRow . ',$D4:$D' . $serviceCaseEndRow . ',"<>*LPT*",$D4:$D' . $serviceCaseEndRow . ',"<>*BT*",$L4:$L' . $serviceCaseEndRow . ',"Yes",$H4:$H' . $serviceCaseEndRow . ',$' . PHPExcel_Cell::stringFromColumnIndex($x) . ($table2StartRow + 1) . '))');
                    }
                } else { //in last column
                    $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($x) . $v, '=SUM($' . PHPExcel_Cell::stringFromColumnIndex($partyToBeChargedStartColumn) . $v . ':$' . PHPExcel_Cell::stringFromColumnIndex($partyToBeChargedEndColumn - 1) . $v . ')');
                }
            }
        }

/*        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
foreach ($worksheet->getRowIterator() as $row) {
$cellIterator = $row->getCellIterator();
$cellIterator->setIterateOnlyExistingCells(true);
foreach ($cellIterator as $cell) {
if (preg_match( '/^=/', $cell->getValue())) {
$cellcoordinate = $cell->getCoordinate();
$worksheet->setCellValueExplicit($cellcoordinate,$worksheet->getCell($cellcoordinate));
}
}
}
}*/

        /*//Acutal Total & planned Total

        $objPHPExcel->getActiveSheet()->setCellValue($partyToBeChargedDepartmentEndColumn. ($table2StartRow-1),'Actual Total');
        $objPHPExcel->getActiveSheet()->setCellValue($partyToBeChargedDepartmentEndColumn. $table2EndRow,'Planned Total');
        $objPHPExcel->getActiveSheet()->setCellValue($partyToBeChargedEndColumnSubTotal. ($table2EndRow-1),'=SUM($'.$partyToBeChargedEndColumnSubTotal.$serviceTypeStartRow.':$'.$partyToBeChargedEndColumnSubTotal.($table2EndRow-2).')');
        $objPHPExcel->getActiveSheet()->setCellValue($partyToBeChargedEndColumnSubTotal. ($table2EndRow),'Test');
         */
        //Second Sheet Budget
        #region Budget
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet()->setTitle('Budget');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        //$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);

        //Budget1
        $budgetTable1StartRow = 1;
        $budgetTable1StartColumn = 0;
        $budgetHorizontialFixedTitleCell = 2;
        $budgetVerticalFixedTitleCell = 1;
        $fixedBudgetServiceTypeRow = 0;
        $budgetTable1EndRow = $budgetTable1StartRow + $budgetHorizontialFixedTitleCell + ($serviceTypeCount - 1) + $fixedBudgetServiceTypeRow + 1;
        $budgetTable1EndColumn = $budgetTable1StartColumn + $budgetVerticalFixedTitleCell + $partyToBeChargedCount + 1;
        $budgetTable1PartyToBeChargedStartColumn = $budgetTable1StartColumn + $budgetVerticalFixedTitleCell + 1;
        $budgetTable1PartyToBeChargedEndColumn = $budgetTable1PartyToBeChargedStartColumn + $partyToBeChargedCount - 1; //before Total
        $budgetTable1ServiceTypeStartColumn = $budgetTable1StartColumn;
        $budgetTable1ServiceTypeStartRow = $budgetTable1StartRow + $budgetHorizontialFixedTitleCell;
        $budgetTable1ServiceTypeEndRow = $budgetTable1ServiceTypeStartRow + $serviceTypeCount + $fixedBudgetServiceTypeRow - 1; //before Total

        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable1StartColumn) . $budgetTable1StartRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable1StartColumn) . $budgetTable1StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex($budgetTable1StartColumn) . $budgetTable1StartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable1StartColumn) . ($budgetTable1StartRow + 1)); //  Period
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($budgetTable1StartColumn) . $budgetTable1StartRow, 'Service(Annual unit)');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex(($budgetTable1StartColumn + 1)) . ($budgetTable1StartRow + 1), 'standard (std) unit rate');
        //border All
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable1StartColumn) . $budgetTable1StartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable1EndColumn) . $budgetTable1EndRow)->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable1StartColumn) . $budgetTable1EndRow . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable1EndColumn) . $budgetTable1EndRow)->getFill()->applyFromArray($styleBgColorYellow);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable1StartColumn) . $budgetTable1StartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable1EndColumn) . $budgetTable1EndRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        for ($i = $budgetTable1StartRow; $i <= $budgetTable1EndRow; $i++) {
            for ($y = $budgetTable1StartColumn; $y <= $budgetTable1EndColumn; $y++) {
                $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($y) . $i . ':' . PHPExcel_Cell::stringFromColumnIndex($y) . $i)->applyFromArray($styleThinBlackBorderOutline);
            }
        }
        //party Name
        $i = $budgetTable1PartyToBeChargedStartColumn;
        foreach ($partyToBeChargedList as $partyToBeCharged) {
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable1StartRow, $partyToBeCharged['partyToBeChargedName']);
            $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable1StartRow)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable1StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable1StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $i++;
        }
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable1StartRow, 'Total');
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable1StartRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable1StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable1StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Service Type Name
        $i = $budgetTable1ServiceTypeStartRow;
        foreach ($serviceTypeList as $serviceType) {
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($budgetTable1StartColumn) . $i, $serviceType['serviceTypeName']);
            $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable1StartColumn) . $i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $i++;

        }
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($budgetTable1StartColumn) . ($i + 2), 'Total');
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable1StartColumn) . $i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //Budget Number
        $i = $budgetTable1PartyToBeChargedStartColumn;
        $y = $budgetTable1ServiceTypeStartRow;
        foreach ($budgetList as $budget) {
            if ($i > $budgetTable1PartyToBeChargedEndColumn) {
                $i = $budgetTable1PartyToBeChargedStartColumn;
                $y++;
            }
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($i) . $y, $budget['budgetNumber']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex(($budgetTable1StartColumn + 1)) . $y, $budget['unitCost']);
            $i++;

        }

        //Budget2
        $budgetTable2StartRow = $budgetTable1EndRow + 2;
        $budgetTable2StartColumn = 0;
        $budgetHorizontialFixedTitleCell = 2;
        $budgetVerticalFixedTitleCell = 1;
        $fixedBudgetServiceTypeRow = 0;
        $budgetTable2EndRow = $budgetTable2StartRow + $budgetHorizontialFixedTitleCell + ($serviceTypeCount - 1) + $fixedBudgetServiceTypeRow + 1;
        $budgetTable2EndColumn = $budgetTable2StartColumn + $budgetVerticalFixedTitleCell + $partyToBeChargedCount + 1;
        $budgetTable2PartyToBeChargedStartColumn = $budgetTable2StartColumn + $budgetVerticalFixedTitleCell + 1;
        $budgetTable2PartyToBeChargedEndColumn = $budgetTable2PartyToBeChargedStartColumn + $partyToBeChargedCount - 1; //before Total
        $budgetTable2ServiceTypeStartColumn = $budgetTable2StartColumn;
        $budgetTable2ServiceTypeStartRow = $budgetTable2StartRow + $budgetHorizontialFixedTitleCell;
        $budgetTable2ServiceTypeEndRow = $budgetTable2ServiceTypeStartRow + $serviceTypeCount + $fixedBudgetServiceTypeRow - 1; //before Total

        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable2StartColumn) . $budgetTable2StartRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable2StartColumn) . $budgetTable2StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex($budgetTable2StartColumn) . $budgetTable2StartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable2StartColumn) . ($budgetTable2StartRow + 1)); //  Period
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($budgetTable2StartColumn) . $budgetTable2StartRow, 'Service(Monthly unit) Total: ' . $countMonth . ' Month');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex(($budgetTable2StartColumn + 1)) . ($budgetTable2StartRow + 1), 'standard (std) unit rate');
        //border All
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable2StartColumn) . $budgetTable2StartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable2EndColumn) . $budgetTable2EndRow)->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable2StartColumn) . $budgetTable2EndRow . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable2EndColumn) . $budgetTable2EndRow)->getFill()->applyFromArray($styleBgColorYellow);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable2StartColumn) . $budgetTable2StartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable2EndColumn) . $budgetTable2EndRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        for ($i = $budgetTable2StartRow; $i <= $budgetTable2EndRow; $i++) {
            for ($y = $budgetTable2StartColumn; $y <= $budgetTable2EndColumn; $y++) {
                $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($y) . $i . ':' . PHPExcel_Cell::stringFromColumnIndex($y) . $i)->applyFromArray($styleThinBlackBorderOutline);
            }
        }
        //party Name
        $i = $budgetTable2PartyToBeChargedStartColumn;
        foreach ($partyToBeChargedList as $partyToBeCharged) {
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable2StartRow, $partyToBeCharged['partyToBeChargedName']);
            $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable2StartRow)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable2StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable2StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $i++;
        }
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable2StartRow, 'Total');
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable2StartRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable2StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable2StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Service Type Name
        $i = $budgetTable2ServiceTypeStartRow;
        foreach ($serviceTypeList as $serviceType) {
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($budgetTable2StartColumn) . $i, $serviceType['serviceTypeName']);
            $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable2StartColumn) . $i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $i++;

        }
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($budgetTable2StartColumn) . ($i + 2), 'Total');
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable2StartColumn) . $i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //Budget Number
        $i = $budgetTable2PartyToBeChargedStartColumn;
        $y = $budgetTable2ServiceTypeStartRow;
        foreach ($budgetList as $budget) {
            if ($i > $budgetTable2PartyToBeChargedEndColumn) {
                $i = $budgetTable2PartyToBeChargedStartColumn;
                $y++;
            }
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($i) . $y, (($budget['budgetNumber'] / 12) * $countMonth));
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex(($budgetTable2StartColumn + 1)) . $y, $budget['unitCost']);
            $i++;

        }

        //Budget3
        $budgetTable3StartRow = $budgetTable2EndRow + 2;
        $budgetTable3StartColumn = 0;
        $budgetHorizontialFixedTitleCell = 2;
        $budgetVerticalFixedTitleCell = 1;
        $fixedBudgetServiceTypeRow = 0;
        $budgetTable3EndRow = $budgetTable3StartRow + $budgetHorizontialFixedTitleCell + ($serviceTypeCount - 1) + $fixedBudgetServiceTypeRow + 1;
        $budgetTable3EndColumn = $budgetTable3StartColumn + $budgetVerticalFixedTitleCell + $partyToBeChargedCount + 1;
        $budgetTable3PartyToBeChargedStartColumn = $budgetTable3StartColumn + $budgetVerticalFixedTitleCell + 1;
        $budgetTable3PartyToBeChargedEndColumn = $budgetTable3PartyToBeChargedStartColumn + $partyToBeChargedCount - 1; //before Total
        $budgetTable3ServiceTypeStartColumn = $budgetTable3StartColumn;
        $budgetTable3ServiceTypeStartRow = $budgetTable3StartRow + $budgetHorizontialFixedTitleCell;
        $budgetTable3ServiceTypeEndRow = $budgetTable3ServiceTypeStartRow + $fixedBudgetServiceTypeRow + $serviceTypeCount - 1; //before Total

        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable3StartColumn) . $budgetTable3StartRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable3StartColumn) . $budgetTable3StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex($budgetTable3StartColumn) . $budgetTable3StartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable3StartColumn) . ($budgetTable3StartRow + 1)); //  Period
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($budgetTable3StartColumn) . $budgetTable3StartRow, 'Service(Annually)');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex(($budgetTable3StartColumn + 1)) . ($budgetTable3StartRow + 1), 'standard (std) unit rate');
        //border All
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable3StartColumn) . $budgetTable3StartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable3EndColumn) . $budgetTable3EndRow)->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable3StartColumn) . $budgetTable3EndRow . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable3EndColumn) . $budgetTable3EndRow)->getFill()->applyFromArray($styleBgColorYellow);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable3StartColumn) . $budgetTable3StartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable3EndColumn) . $budgetTable3EndRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        for ($i = $budgetTable3StartRow; $i <= $budgetTable3EndRow; $i++) {
            for ($y = $budgetTable3StartColumn; $y <= $budgetTable3EndColumn; $y++) {
                $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($y) . $i . ':' . PHPExcel_Cell::stringFromColumnIndex($y) . $i)->applyFromArray($styleThinBlackBorderOutline);
            }
        }
        //party Name
        $i = $budgetTable3PartyToBeChargedStartColumn;
        foreach ($partyToBeChargedList as $partyToBeCharged) {
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable3StartRow, $partyToBeCharged['partyToBeChargedName']);
            $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable3StartRow)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable3StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable3StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $i++;
        }
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable3StartRow, 'Total');
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable3StartRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable3StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable3StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Service Type Name
        $i = $budgetTable3ServiceTypeStartRow;
        foreach ($serviceTypeList as $serviceType) {
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($budgetTable3StartColumn) . $i, $serviceType['serviceTypeName']);
            $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable3StartColumn) . $i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $i++;

        }
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($budgetTable3StartColumn) . ($i + 2), 'Total');
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable3StartColumn) . $i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //Budget Number
        $i = $budgetTable3PartyToBeChargedStartColumn;
        $y = $budgetTable3ServiceTypeStartRow;
        foreach ($budgetList as $budget) {
            if ($i > $budgetTable3PartyToBeChargedEndColumn) {
                $i = $budgetTable3PartyToBeChargedStartColumn;
                $y++;
            }
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($i) . $y, $budget['budgetNumber'] * $budget['unitCost']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex(($budgetTable3StartColumn + 1)) . $y, $budget['unitCost']);
            $i++;

        }
        for ($m = $budgetTable3PartyToBeChargedStartColumn; $m <= $budgetTable3PartyToBeChargedEndColumn; $m++) {
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($m) . ($budgetTable3ServiceTypeEndRow + 1), '=SUM(' . PHPExcel_Cell::stringFromColumnIndex($m) . $budgetTable3ServiceTypeStartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($m) . $budgetTable3ServiceTypeEndRow . ')');
        }
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex(($budgetTable3PartyToBeChargedEndColumn + 1)) . ($budgetTable3ServiceTypeEndRow + 1), '=SUM(' . PHPExcel_Cell::stringFromColumnIndex($budgetTable3PartyToBeChargedStartColumn) . ($budgetTable3ServiceTypeEndRow + 1) . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable3PartyToBeChargedEndColumn) . ($budgetTable3ServiceTypeEndRow + 1) . ')');

        //Budget4
        $budgetTable4StartRow = $budgetTable3EndRow + 2;
        $budgetTable4StartColumn = 0;
        $budgetHorizontialFixedTitleCell = 2;
        $budgetVerticalFixedTitleCell = 1;
        $fixedBudgetServiceTypeRow = 0;
        $budgetTable4EndRow = $budgetTable4StartRow + $budgetHorizontialFixedTitleCell + ($serviceTypeCount - 1) + $fixedBudgetServiceTypeRow + 1;
        $budgetTable4EndColumn = $budgetTable4StartColumn + $budgetVerticalFixedTitleCell + $partyToBeChargedCount + 1;
        $budgetTable4PartyToBeChargedStartColumn = $budgetTable4StartColumn + $budgetVerticalFixedTitleCell + 1;
        $budgetTable4PartyToBeChargedEndColumn = $budgetTable4PartyToBeChargedStartColumn + $partyToBeChargedCount - 1; //before Total
        $budgetTable4ServiceTypeStartColumn = $budgetTable4StartColumn;
        $budgetTable4ServiceTypeStartRow = $budgetTable4StartRow + $budgetHorizontialFixedTitleCell;
        $budgetTable4ServiceTypeEndRow = $budgetTable4ServiceTypeStartRow + $fixedBudgetServiceTypeRow + $serviceTypeCount - 1; //before Total

        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable4StartColumn) . $budgetTable4StartRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable4StartColumn) . $budgetTable4StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells(PHPExcel_Cell::stringFromColumnIndex($budgetTable4StartColumn) . $budgetTable4StartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable4StartColumn) . ($budgetTable4StartRow + 1)); //  Period
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($budgetTable4StartColumn) . $budgetTable4StartRow, 'Service(Monthly) Total:' . $countMonth . ' Month');
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex(($budgetTable4StartColumn + 1)) . ($budgetTable4StartRow + 1), 'standard (std) unit rate');
        //border All
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable4StartColumn) . $budgetTable4StartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable4EndColumn) . $budgetTable4EndRow)->applyFromArray($styleThinBlackBorderOutline);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable4StartColumn) . $budgetTable4EndRow . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable4EndColumn) . $budgetTable4EndRow)->getFill()->applyFromArray($styleBgColorYellow);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable4StartColumn) . $budgetTable4StartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable4EndColumn) . $budgetTable4EndRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        for ($i = $budgetTable4StartRow; $i <= $budgetTable4EndRow; $i++) {
            for ($y = $budgetTable4StartColumn; $y <= $budgetTable4EndColumn; $y++) {
                $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($y) . $i . ':' . PHPExcel_Cell::stringFromColumnIndex($y) . $i)->applyFromArray($styleThinBlackBorderOutline);
            }
        }
        //party Name
        $i = $budgetTable4PartyToBeChargedStartColumn;
        foreach ($partyToBeChargedList as $partyToBeCharged) {
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable4StartRow, $partyToBeCharged['partyToBeChargedName']);
            $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable4StartRow)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable4StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable4StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $i++;
        }
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable4StartRow, 'Total');
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable4StartRow)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable4StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($i) . $budgetTable4StartRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //Service Type Name
        $i = $budgetTable4ServiceTypeStartRow;
        foreach ($serviceTypeList as $serviceType) {
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($budgetTable4StartColumn) . $i, $serviceType['serviceTypeName']);
            $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable4StartColumn) . $i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $i++;

        }
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($budgetTable4StartColumn) . ($i + 2), 'Total');
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($budgetTable4StartColumn) . $i)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        //Budget Number
        $i = $budgetTable4PartyToBeChargedStartColumn;
        $y = $budgetTable4ServiceTypeStartRow;
        foreach ($budgetList as $budget) {
            if ($i > $budgetTable4PartyToBeChargedEndColumn) {
                $i = $budgetTable4PartyToBeChargedStartColumn;
                $y++;
            }
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($i) . $y, ((($budget['budgetNumber'] * $budget['unitCost']) / 12) * $countMonth));
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex(($budgetTable4StartColumn + 1)) . $y, $budget['unitCost']);
            $i++;

        }
        for ($m = $budgetTable4PartyToBeChargedStartColumn; $m <= $budgetTable4PartyToBeChargedEndColumn; $m++) {
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($m) . ($budgetTable4ServiceTypeEndRow + 1), '=SUM(' . PHPExcel_Cell::stringFromColumnIndex($m) . $budgetTable4ServiceTypeStartRow . ':' . PHPExcel_Cell::stringFromColumnIndex($m) . $budgetTable4ServiceTypeEndRow . ')');

        }
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex(($budgetTable4PartyToBeChargedEndColumn + 1)) . ($budgetTable4ServiceTypeEndRow + 1), '=SUM(' . PHPExcel_Cell::stringFromColumnIndex($budgetTable4PartyToBeChargedStartColumn) . ($budgetTable4ServiceTypeEndRow + 1) . ':' . PHPExcel_Cell::stringFromColumnIndex($budgetTable4PartyToBeChargedEndColumn) . ($budgetTable4ServiceTypeEndRow + 1) . ')');

        //Set Number Format
        $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex(($budgetTable1StartColumn + $budgetVerticalFixedTitleCell)) . $budgetTable1StartRow . ':' . PHPExcel_Cell::stringFromColumnIndex(($budgetTable1StartColumn + $budgetVerticalFixedTitleCell)) . $budgetTable4EndRow)
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        //Set Form1 Budget
        $objPHPExcel->setActiveSheetIndex(0);
        $diff = $partyToBeChargedStartColumn - $budgetTable4PartyToBeChargedStartColumn;
        for ($m = $budgetTable4PartyToBeChargedStartColumn; $m <= ($budgetTable4PartyToBeChargedEndColumn + 1); $m++) {
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex(($m + $diff)) . ($serviceTypeStartRow - 2), '=Budget!$' . PHPExcel_Cell::stringFromColumnIndex($m) . ($budgetTable4ServiceTypeEndRow + 1));

        }

        #endregion Budget
        #region Sheet2 chart1
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);
        $objPHPExcel->getActiveSheet()->setTitle('chart1');

        $chart1StartColumn = 0;
        $chart1EndColumn = $chart1StartColumn + 2;
        $chart1StartRow = 1;
        $chart1EndRow = 1 + count($caseFormChart1);
//Title
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart1StartColumn) . ($chart1StartRow), "");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart1StartColumn + 1) . ($chart1StartRow), "This Year");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart1StartColumn + 2) . ($chart1StartRow), "Last Year Average");
//Value
        $i = ($chart1StartRow + 1);
        foreach ($caseFormChart1 as $Chart1) {

            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart1StartColumn) . ($i), $Chart1['startMonth']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart1StartColumn + 1) . ($i), $Chart1['thisYearAmount']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart1StartColumn + 2) . ($i), $Chart1['lastYearAverageAmount']);
            $i++;
        }

//  Set the Labels for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataseriesLabels1 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart1!$B$1', null, 1), //  this Year
        );
        $dataseriesLabels2 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart1!$C$1', null, 1), //  Last Year Average
        );

//  Set the X-Axis Labels
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $xAxisTickValues = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart1!$A$2:$A$' . $chart1EndRow, null, 12), //  Jan to Dec
        );

//  Set the Data values for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataSeriesValues1 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart1!$B$2:$B$' . $chart1EndRow, null, 12),
        );
        $dataSeriesValues2 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart1!$C$2:$C$' . $chart1EndRow, null, 12),
        );
//  Build the dataseries
        $series1 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_BARCHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues1) - 1), // plotOrder
            $dataseriesLabels1, // plotLabel
            $xAxisTickValues, // plotCategory
            $dataSeriesValues1 // plotValues
        );
        $series2 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues2) - 1), // plotOrder
            $dataseriesLabels2, // plotLabel
            null, // plotCategory
            $dataSeriesValues2 // plotValues
        );
//  Set additional dataseries parameters
        //      Make it a vertical column rather than a horizontal bar graph
        $series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

//  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea(null, array($series1, $series2));
//  Set the chart legend
        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);

        $title = new PHPExcel_Chart_Title('No. of PQ Service Requested');

//  Create the chart
        $chart1 = new PHPExcel_Chart(
            'chart1', // name
            $title, // title
            $legend, // legend
            $plotarea, // plotArea
            true, // plotVisibleOnly
            0, // displayBlanksAs
            null, // xAxisLabel
            null// yAxisLabel
        );

//  Set the position where the chart should appear in the worksheet
        $chart1->setTopLeftPosition('B' . ($table2EndRow + 5));
        $chart1->setBottomRightPosition('D' . ($table2EndRow + 20));
#endregion Sheet 2 chart1
        #region Sheet3 chart2
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(3);
        $objPHPExcel->getActiveSheet()->setTitle('chart2');

        $chart2StartColumn = 0;
        $chart2EndColumn = $chart2StartColumn + 2;
        $chart2StartRow = 1;
        $chart2EndRow = 1 + count($caseFormChart2);
//Title
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart2StartColumn) . ($chart2StartRow), "");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart2StartColumn + 1) . ($chart2StartRow), "This Year");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart2StartColumn + 2) . ($chart2StartRow), "Last Year Average");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart2StartColumn + 3) . ($chart2StartRow), "YTD");

//Value
        $i = ($chart2StartRow + 1);
        foreach ($caseFormChart2 as $Chart2) {

            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart2StartColumn) . ($i), $Chart2['countMonth']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart2StartColumn + 1) . ($i), $Chart2['thisYearAmount']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart2StartColumn + 2) . ($i), $Chart2['lastYearAverageAmount']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart2StartColumn + 3) . ($i), '=SUM($' . PHPExcel_Cell::stringFromColumnIndex($chart2StartColumn + 1) . ($chart2StartRow + 1) . ':$' . PHPExcel_Cell::stringFromColumnIndex($chart2StartColumn + 1) . ($i) . ')');
            $i++;
        }

//  Set the Labels for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataseriesLabels1 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart2!$B$1', null, 1), //  this Year
        );
        $dataseriesLabels2 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart2!$C$1', null, 1), //  Last Year Average
            new PHPExcel_Chart_DataSeriesValues('String', 'chart2!$D$1', null, 1), // YTD
        );

//  Set the X-Axis Labels
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $xAxisTickValues = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart2!$A$2:$A$' . $chart2EndRow, null, 12), //  Jan to Dec
        );

//  Set the Data values for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataSeriesValues1 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart2!$B$2:$B$' . $chart2EndRow, null, 12),
        );

        $dataSeriesValues2 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart2!$C$2:$C$' . $chart2EndRow, null, 12),
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart2!$D$2:$D$' . $chart2EndRow, null, 12),
        );
//  Build the dataseries
        $series1 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_BARCHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues1) - 1), // plotOrder
            $dataseriesLabels1, // plotLabel
            $xAxisTickValues, // plotCategory
            $dataSeriesValues1 // plotValues
        );
        $series2 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues2) - 1), // plotOrder
            $dataseriesLabels2, // plotLabel
            null, // plotCategory
            $dataSeriesValues2 // plotValues
        );
//  Set additional dataseries parameters
        //      Make it a vertical column rather than a horizontal bar graph
        $series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

//  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea(null, array($series1, $series2));
//  Set the chart legend
        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);

        $title = new PHPExcel_Chart_Title('No. of Completed PQ Investigation Cases');

//  Create the chart
        $chart2 = new PHPExcel_Chart(
            'chart2', // name
            $title, // title
            $legend, // legend
            $plotarea, // plotArea
            true, // plotVisibleOnly
            0, // displayBlanksAs
            null, // xAxisLabel
            null// yAxisLabel
        );

//  Set the position where the chart should appear in the worksheet
        $chart2->setTopLeftPosition('B' . ($table2EndRow + 21));
        $chart2->setBottomRightPosition('D' . ($table2EndRow + 35));
#endregion Sheet3 chart2
        #region Sheet4 chart3
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(4);
        $objPHPExcel->getActiveSheet()->setTitle('chart3');

        $chart3StartColumn = 0;
        $chart3EndColumn = $chart3StartColumn + 2;
        $chart3StartRow = 1;
        $chart3EndRow = 1 + count($caseFormChart3);
//Title
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart3StartColumn) . ($chart3StartRow), "");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart3StartColumn + 1) . ($chart3StartRow), "This Year");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart3StartColumn + 2) . ($chart3StartRow), "Last Year Average");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart3StartColumn + 3) . ($chart3StartRow), "YTD");

//Value
        $i = ($chart3StartRow + 1);
        foreach ($caseFormChart3 as $Chart3) {

            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart3StartColumn) . ($i), $Chart3['countMonth']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart3StartColumn + 1) . ($i), $Chart3['thisYearAmount']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart3StartColumn + 2) . ($i), $Chart3['lastYearAverageAmount']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart3StartColumn + 3) . ($i), '=SUM($' . PHPExcel_Cell::stringFromColumnIndex($chart3StartColumn + 1) . ($chart3StartRow + 1) . ':$' . PHPExcel_Cell::stringFromColumnIndex($chart3StartColumn + 1) . ($i) . ')');
            $i++;
        }

//  Set the Labels for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataseriesLabels1 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart3!$B$1', null, 1), //  this Year
        );
        $dataseriesLabels2 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart3!$C$1', null, 1), //  Last Year Average
            new PHPExcel_Chart_DataSeriesValues('String', 'chart3!$D$1', null, 1), // YTD
        );

//  Set the X-Axis Labels
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $xAxisTickValues = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart3!$A$2:$A$' . $chart3EndRow, null, 12), //  Jan to Dec
        );

//  Set the Data values for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataSeriesValues1 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart3!$B$2:$B$' . $chart3EndRow, null, 12),
        );
        $dataSeriesValues2 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart3!$C$2:$C$' . $chart3EndRow, null, 12),
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart3!$D$2:$D$' . $chart3EndRow, null, 12),
        );
//  Build the dataseries
        $series1 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_BARCHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues1) - 1), // plotOrder
            $dataseriesLabels1, // plotLabel
            $xAxisTickValues, // plotCategory
            $dataSeriesValues1 // plotValues
        );
        $series2 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues2) - 1), // plotOrder
            $dataseriesLabels2, // plotLabel
            null, // plotCategory
            $dataSeriesValues2 // plotValues
        );
//  Set additional dataseries parameters
        //      Make it a vertical column rather than a horizontal bar graph
        $series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

//  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea(null, array($series1, $series2));
//  Set the chart legend
        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);

        $title = new PHPExcel_Chart_Title('No. of Completed PQ Visit & Reach-out Cases');

//  Create the chart
        $chart3 = new PHPExcel_Chart(
            'chart3', // name
            $title, // title
            $legend, // legend
            $plotarea, // plotArea
            true, // plotVisibleOnly
            0, // displayBlanksAs
            null, // xAxisLabel
            null// yAxisLabel
        );

//  Set the position where the chart should appear in the worksheet
        $chart3->setTopLeftPosition('B' . ($table2EndRow + 36));
        $chart3->setBottomRightPosition('D' . ($table2EndRow + 50));
#endregion Sheet4 chart3
        #region Sheet5 chart4
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(5);
        $objPHPExcel->getActiveSheet()->setTitle('chart4');

        $chart4StartColumn = 0;
        $chart4EndColumn = $chart4StartColumn + 2;
        $chart4StartRow = 1;
        $chart4EndRow = 1 + count($caseFormChart4);
//Title
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart4StartColumn) . ($chart4StartRow), "");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart4StartColumn + 1) . ($chart4StartRow), "This Year");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart4StartColumn + 2) . ($chart4StartRow), "Last Year Average");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart4StartColumn + 3) . ($chart4StartRow), "YTD");
//Value
        $i = ($chart4StartRow + 1);
        foreach ($caseFormChart4 as $Chart4) {

            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart4StartColumn) . ($i), $Chart4['countMonth']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart4StartColumn + 1) . ($i), $Chart4['thisYearAmount']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart4StartColumn + 2) . ($i), $Chart4['lastYearAverageAmount']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart4StartColumn + 3) . ($i), '=SUM($' . PHPExcel_Cell::stringFromColumnIndex($chart4StartColumn + 1) . ($chart4StartRow + 1) . ':$' . PHPExcel_Cell::stringFromColumnIndex($chart4StartColumn + 1) . ($i) . ')');
            $i++;
        }

//  Set the Labels for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataseriesLabels1 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart4!$B$1', null, 1), //  this Year
        );
        $dataseriesLabels2 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart4!$C$1', null, 1), //  Last Year Average
            new PHPExcel_Chart_DataSeriesValues('String', 'chart4!$D$1', null, 1),
        );

        $xAxisTickValues = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart4!$A$2:$A$' . $chart4EndRow, null, 12), //  Jan to Dec
        );

//  Set the Data values for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataSeriesValues1 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart4!$B$2:$B$' . $chart4EndRow, null, 12),
        );
        $dataSeriesValues2 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart4!$C$2:$C$' . $chart4EndRow, null, 12),
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart4!$D$2:$D$' . $chart4EndRow, null, 12),
        );
//  Build the dataseries
        $series1 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_BARCHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues1) - 1), // plotOrder
            $dataseriesLabels1, // plotLabel
            $xAxisTickValues, // plotCategory
            $dataSeriesValues1 // plotValues
        );
        $series2 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues2) - 1), // plotOrder
            $dataseriesLabels2, // plotLabel
            null, // plotCategory
            $dataSeriesValues2 // plotValues
        );
//  Set additional dataseries parameters
        //      Make it a vertical column rather than a horizontal bar graph
        $series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

//  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea(null, array($series1, $series2));
//  Set the chart legend
        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);

        $title = new PHPExcel_Chart_Title('No. of Completed PQ Enquiry Cases');

//  Create the chart
        $chart4 = new PHPExcel_Chart(
            'chart4', // name
            $title, // title
            $legend, // legend
            $plotarea, // plotArea
            true, // plotVisibleOnly
            0, // displayBlanksAs
            null, // xAxisLabel
            null// yAxisLabel
        );

//  Set the position where the chart should appear in the worksheet
        $chart4->setTopLeftPosition('B' . ($table2EndRow + 51));
        $chart4->setBottomRightPosition('D' . ($table2EndRow + 65));
#endregion Sheet5 chart4

#region Sheet6 chart5
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(6);
        $objPHPExcel->getActiveSheet()->setTitle('chart5');

        $chart5StartColumn = 0;
        $chart5EndColumn = $chart5StartColumn + 2;
        $chart5StartRow = 1;
        $chart5EndRow = 1 + count($caseFormChart5);
//Title
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart5StartColumn) . ($chart5StartRow), "");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart5StartColumn + 1) . ($chart5StartRow), "Monthly Performace");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart5StartColumn + 2) . ($chart5StartRow), "YTD Average");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart5StartColumn + 3) . ($chart5StartRow), "Target");

//Value
        $i = ($chart5StartRow + 1);
        foreach ($caseFormChart5 as $Chart5) {

            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart5StartColumn) . ($i), $Chart5['countMonth']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart5StartColumn + 1) . ($i), $Chart5['thisYearAmount']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart5StartColumn + 2) . ($i), $Chart5['lastYearAverage']);
            $i++;

        }
        $objPHPExcel->getActiveSheet()->setCellValue('D14', '=$B$14');
//  Set the Labels for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataseriesLabels1 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart5!$B$1', null, 1), //  this Year
            new PHPExcel_Chart_DataSeriesValues('String', 'chart5!$D$1', null, 1), //  Target
        );
        $dataseriesLabels2 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart5!$C$1', null, 1), //  Last Year Average
        );
//  Set the X-Axis Labels
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $xAxisTickValues = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart5!$A$2:$A$' . ($chart5EndRow), null, 13), //  Jan to Dec
        );
//  Set the Data values for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataSeriesValues1 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart5!$B$2:$B$' . ($chart5EndRow - 1), null, 12),
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart5!$D$2:$D$' . ($chart5EndRow), null, 13),

        );
        $dataSeriesValues2 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart5!$C$2:$C$' . $chart5EndRow, null, 12),
        );
//  Build the dataseries
        $series1 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_BARCHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues1) - 1), // plotOrder
            $dataseriesLabels1, // plotLabel
            $xAxisTickValues, // plotCategory
            $dataSeriesValues1 // plotValues
        );
        $series2 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues2) - 1), // plotOrder
            $dataseriesLabels2, // plotLabel
            null, // plotCategory
            $dataSeriesValues2 // plotValues
        );

//  Set additional dataseries parameters
        //      Make it a vertical column rather than a horizontal bar graph
        $series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

        $layout = new PHPExcel_Chart_Layout();
        $layout->setShowVal(true);
//  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea($layout, array($series1, $series2));
//  Set the chart legend
        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);

        $title = new PHPExcel_Chart_Title('Investigation of PQ Enquiry (Response to Customer)  Satisfactory Index ' . $endYear);

//  axis Label
        $axis = new PHPExcel_Chart_Axis();
        $axis->setAxisOptionsProperties("nextTo", null, null, null, null, null, 0, 1);

//  Create the chart
        $chart5 = new PHPExcel_Chart(
            'chart5', // name
            $title, // title
            $legend, // legend
            $plotarea, // plotArea
            true, // plotVisibleOnly
            0, // displayBlanksAs
            null, // xAxisLabel
            null, // yAxisLabel
            null,
            $axis

        );

//  Set the position where the chart should appear in the worksheet
        $chart5->setTopLeftPosition('F' . ($table2EndRow + 5));
        $chart5->setBottomRightPosition('L' . ($table2EndRow + 20));
#endregion Sheet6 chart5

#region Sheet7 chart6
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(7);
        $objPHPExcel->getActiveSheet()->setTitle('chart6');
        $chart6StartColumn = 0;
        $chart6EndColumn = $chart6StartColumn + 2;
        $chart6StartRow = 1;
        $chart6EndRow = 1 + count($caseFormChart6);
//Title
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart6StartColumn) . ($chart6StartRow), "");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart6StartColumn + 1) . ($chart6StartRow), "Monthly Performace");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart6StartColumn + 2) . ($chart6StartRow), "YTD Average");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart6StartColumn + 3) . ($chart6StartRow), "Target");
//Value
        $i = ($chart6StartRow + 1);
        foreach ($caseFormChart6 as $Chart6) {

            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart6StartColumn) . ($i), $Chart6['countMonth']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart6StartColumn + 1) . ($i), $Chart6['thisYearAmount']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart6StartColumn + 2) . ($i), $Chart6['lastYearAverage']);
            $i++;
        }
        $objPHPExcel->getActiveSheet()->setCellValue('D14', '=$B$14');

//  Set the Labels for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataseriesLabels1 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart6!$B$1', null, 1), //  this Year
            new PHPExcel_Chart_DataSeriesValues('String', 'chart6!$D$1', null, 1), //  Target
        );
        $dataseriesLabels2 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart6!$C$1', null, 1), //  Last Year Average
        );

//  Set the X-Axis Labels
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $xAxisTickValues = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart6!$A$2:$A$' . $chart6EndRow, null, 13), //  Jan to Dec
        );

//  Set the Data values for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataSeriesValues1 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart6!$B$2:$B$' . ($chart6EndRow - 1), null, 12),
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart6!$D$2:$D$' . ($chart6EndRow), null, 13),
        );
        $dataSeriesValues2 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart6!$C$2:$C$' . $chart6EndRow, null, 12),
        );
//  Build the dataseries
        $series1 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_BARCHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues1) - 1), // plotOrder
            $dataseriesLabels1, // plotLabel
            $xAxisTickValues, // plotCategory
            $dataSeriesValues1 // plotValues
        );
        $series2 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues2) - 1), // plotOrder
            $dataseriesLabels2, // plotLabel
            null, // plotCategory
            $dataSeriesValues2 // plotValues
        );

        $layout = new PHPExcel_Chart_Layout();
        $layout->setShowVal(true);
//  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea($layout, array($series1, $series2));
//  Set the chart legend
        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);

        $title = new PHPExcel_Chart_Title('Investigation of PQ Enquiry Satisfactory Index ' . $endYear);
//  axis Label
        $axis = new PHPExcel_Chart_Axis();
        $axis->setAxisOptionsProperties("nextTo", null, null, null, null, null, 0, 1);
//  Create the chart
        $chart6 = new PHPExcel_Chart(
            'chart6', // name
            $title, // title
            $legend, // legend
            $plotarea, // plotArea
            true, // plotVisibleOnly
            0, // displayBlanksAs
            null, // xAxisLabel
            null, // yAxisLabel
            null,
            $axis
        );

//  Set the position where the chart should appear in the worksheet
        $chart6->setTopLeftPosition('F' . ($table2EndRow + 21));
        $chart6->setBottomRightPosition('L' . ($table2EndRow + 35));
#endregion Sheet7 chart6

#region Sheet8 chart7
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(8);
        $objPHPExcel->getActiveSheet()->setTitle('chart7');

        $chart7StartColumn = 0;
        $chart7EndColumn = $chart7StartColumn + 2;
        $chart7StartRow = 1;
        $chart7EndRow = 1 + count($caseFormChart7);
        //Title
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart7StartColumn) . ($chart7StartRow), "");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart7StartColumn + 1) . ($chart7StartRow), "Monthly Performace");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart7StartColumn + 2) . ($chart7StartRow), "YTD Average");
        $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart7StartColumn + 3) . ($chart7StartRow), "Target");
        //Value
        $i = ($chart7StartRow + 1);
        foreach ($caseFormChart7 as $Chart7) {

            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart7StartColumn) . ($i), $Chart7['countMonth']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart7StartColumn + 1) . ($i), $Chart7['thisYearAmount']);
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($chart7StartColumn + 2) . ($i), $Chart7['lastYearAverage']);
            $i++;
        }
        $objPHPExcel->getActiveSheet()->setCellValue('D14', '=$B$14');

//  Set the Labels for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataseriesLabels1 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart7!$B$1', null, 1), //  this Year
            new PHPExcel_Chart_DataSeriesValues('String', 'chart7!$D$1', null, 1), //  Target
        );
        $dataseriesLabels2 = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart7!$C$1', null, 1), //  Last Year Average
        );

        //  Set the X-Axis Labels
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $xAxisTickValues = array(
            new PHPExcel_Chart_DataSeriesValues('String', 'chart7!$A$2:$A$' . $chart7EndRow, null, 13), //  Jan to Dec
        );

        //  Set the Data values for each data series we want to plot
        //      Datatype
        //      Cell reference for data
        //      Format Code
        //      Number of datapoints in series
        //      Data values
        //      Data Marker
        $dataSeriesValues1 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart7!$B$2:$B$' . ($chart7EndRow - 1), null, 12),
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart7!$D$2:$D$' . ($chart7EndRow), null, 13),
        );
        $dataSeriesValues2 = array(
            new PHPExcel_Chart_DataSeriesValues('Number', 'chart7!$C$2:$C$' . $chart7EndRow, null, 12),
        );

        //  Build the dataseries
        $series1 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_BARCHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues1) - 1), // plotOrder
            $dataseriesLabels1, // plotLabel
            $xAxisTickValues, // plotCategory
            $dataSeriesValues1 // plotValues
        );
        $series2 = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART, // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD, // plotGrouping
            range(0, count($dataSeriesValues2) - 1), // plotOrder
            $dataseriesLabels2, // plotLabel
            null, // plotCategory
            $dataSeriesValues2 // plotValues
        );
        //  Set additional dataseries parameters
        //      Make it a vertical column rather than a horizontal bar graph
        $series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

        $layout = new PHPExcel_Chart_Layout();
        $layout->setShowVal(true);
        //  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea($layout, array($series1, $series2));
        //  Set the chart legend
        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);

        $title = new PHPExcel_Chart_Title('Investigation of Investigation S/L Satisfactory Index ' . $endYear);
        //  axis Label
        $axis = new PHPExcel_Chart_Axis();
        $axis->setAxisOptionsProperties("nextTo", null, null, null, null, null, 0, 1);
        //  Create the chart
        $chart7 = new PHPExcel_Chart(
            'chart7', // name
            $title, // title
            $legend, // legend
            $plotarea, // plotArea
            true, // plotVisibleOnly
            0, // displayBlanksAs
            null, // xAxisLabel
            null, // yAxisLabel
            null,
            $axis
        );

        //  Set the position where the chart should appear in the worksheet
        $chart7->setTopLeftPosition('F' . ($table2EndRow + 36));
        $chart7->setBottomRightPosition('L' . ($table2EndRow + 50));
#endregion Sheet8 chart7

//  Add the chart to the worksheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->addChart($chart1);
        $objPHPExcel->getActiveSheet()->addChart($chart2);
        $objPHPExcel->getActiveSheet()->addChart($chart3);
        $objPHPExcel->getActiveSheet()->addChart($chart4);
        $objPHPExcel->getActiveSheet()->addChart($chart5);
        $objPHPExcel->getActiveSheet()->addChart($chart6);
        $objPHPExcel->getActiveSheet()->addChart($chart7);
        $objPHPExcel->getSheetByName('chart1')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        $objPHPExcel->getSheetByName('chart2')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        $objPHPExcel->getSheetByName('chart3')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        $objPHPExcel->getSheetByName('chart4')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        $objPHPExcel->getSheetByName('chart5')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        $objPHPExcel->getSheetByName('chart6')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        $objPHPExcel->getSheetByName('chart7')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);

        $this->layout = false;
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . "ServiceCaseReport(" . $startDay . "-" . $startMonth . "-" . $startYear . ")" . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setPreCalculateFormulas();
        $objWriter->setIncludeCharts(true);
        $objWriter->save('php://output');
        return;
// If you're serving to IE 9, then the following may be needed
        //$this->render("//site/report/CaseReportDownload");
    }

    public function actionTestExcel()
    {
        $file = "D:/Project/WebServer/xampp/htdocs/ExcelTestYii/protected/vendor/test.xlsx";
        $inputFileType = PHPExcel_IOFactory::identify($file);
        echo $inputFileType;

        $objReader = null;

        if ($inputFileType == "Excel2007") {
            $objReader = new PHPExcel_Reader_Excel2007;
        }

        $objPHPExcel = $objReader->load("D:/Project/WebServer/xampp/htdocs/ExcelTestYii/protected/vendor/test.xlsx");
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
        echo '<table>' . "\n";
        for ($row = 2; $row <= $highestRow; ++$row) {
            echo '<tr>' . "\n";
            for ($col = 0; $col <= $highestColumnIndex; ++$col) {
                echo '<td>' . $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() . '</td>' . "\n";
            }
            echo '</tr>' . "\n";
        }
        echo '</table>' . "\n";
    }

}
