<?php
require_once('Encoding.php');
use \ForceUTF8\Encoding;

class PlanningAheadDao extends CApplicationComponent {

    public function getPlanningAheadDetails($schemeNo) {

        $record = array();
        try {
            $sql = 'SELECT * FROM "tbl_planning_ahead" a 
                        LEFT JOIN "tbl_region" b on a."region_id" = b."region_id"  
                        WHERE "scheme_no"::text = :schemeNo';
            $sth = Yii::app()->db->createCommand($sql);
            $sth->bindParam(':schemeNo', $schemeNo);
            $result = $sth->queryAll();


            if (isset($result)) {
                $record['planningAheadId'] = $result[0]['planning_ahead_id'];
                $record['projectTitle'] = Encoding::escapleAllCharacter($result[0]['project_title']);
                $record['schemeNo'] = Encoding::escapleAllCharacter($result[0]['scheme_no']);
                $record['regionId'] = Encoding::escapleAllCharacter($result[0]['region_id']);
                $record['regionShortName'] = Encoding::escapleAllCharacter($result[0]['region_short_name']);
                $record['conditionLetterFilename'] = Encoding::escapleAllCharacter($result[0]['condition_letter_filename']);
                $record['projectTypeId'] = $result[0]['project_type_id'];
                if (isset($result[0]['commission_date'])) {
                    $commissionDateYear = date("Y", strtotime($result[0]['commission_date']));
                    $commissionDateMonth = date("m", strtotime($result[0]['commission_date']));
                    $commissionDateDay = date("d", strtotime($result[0]['commission_date']));
                    $record['commissionDate'] = $commissionDateYear . "-" . $commissionDateMonth . "-" . $commissionDateDay;
                } else {
                    $record['commissionDate'] = null;
                }
                $record['keyInfra'] = $result[0]['key_infra'];
                $record['tempProject'] = $result[0]['temp_project'];
                $record['firstRegionStaffName'] = Encoding::escapleAllCharacter($result[0]['first_region_staff_name']);
                $record['firstRegionStaffPhone'] = Encoding::escapleAllCharacter($result[0]['first_region_staff_phone']);
                $record['firstRegionStaffEmail'] = Encoding::escapleAllCharacter($result[0]['first_region_staff_email']);
                $record['secondRegionStaffName'] = Encoding::escapleAllCharacter($result[0]['second_region_staff_name']);
                $record['secondRegionStaffPhone'] = Encoding::escapleAllCharacter($result[0]['second_region_staff_phone']);
                $record['secondRegionStaffEmail'] = Encoding::escapleAllCharacter($result[0]['second_region_staff_email']);
                $record['thirdRegionStaffName'] = Encoding::escapleAllCharacter($result[0]['third_region_staff_name']);
                $record['thirdRegionStaffPhone'] = Encoding::escapleAllCharacter($result[0]['third_region_staff_phone']);
                $record['thirdRegionStaffEmail'] = Encoding::escapleAllCharacter($result[0]['third_region_staff_email']);
                $record['firstConsultantTitle'] = Encoding::escapleAllCharacter($result[0]['first_consultant_title']);
                $record['firstConsultantSurname'] = Encoding::escapleAllCharacter($result[0]['first_consultant_surname']);
                $record['firstConsultantOtherName'] = Encoding::escapleAllCharacter($result[0]['first_consultant_other_name']);
                $record['firstConsultantCompanyId'] = Encoding::escapleAllCharacter($result[0]['first_consultant_company']);

                if (isset($record['firstConsultantCompanyId']) && ($record['firstConsultantCompanyId'] != 0)) {
                    $sql = 'SELECT * FROM "TblConsultantCompany"   
                        WHERE "consultantCompanyId" = :consultantCompanyId';
                    $sth = Yii::app()->db->createCommand($sql);
                    $sth->bindParam(':consultantCompanyId', $record['firstConsultantCompanyId']);
                    $firstConsultantCompany = $sth->queryAll();

                    if (isset($firstConsultantCompany)) {
                        $record['firstConsultantCompanyName'] = Encoding::escapleAllCharacter($firstConsultantCompany[0]['consultantCompanyName']);
                    } else {
                        $record['firstConsultantCompanyName'] = "UNKNOWN";
                    }
                } else {
                    $record['firstConsultantCompanyName'] = null;
                }

                $record['firstConsultantPhone'] = Encoding::escapleAllCharacter($result[0]['first_consultant_phone']);
                $record['firstConsultantEmail'] = Encoding::escapleAllCharacter($result[0]['first_consultant_email']);
                $record['secondConsultantTitle'] = Encoding::escapleAllCharacter($result[0]['second_consultant_title']);
                $record['secondConsultantSurname'] = Encoding::escapleAllCharacter($result[0]['second_consultant_surname']);
                $record['secondConsultantOtherName'] = Encoding::escapleAllCharacter($result[0]['second_consultant_other_name']);
                $record['secondConsultantCompanyId'] = Encoding::escapleAllCharacter($result[0]['second_consultant_company']);

                if (isset($record['secondConsultantCompanyId']) && ($record['secondConsultantCompanyId'] != 0)) {
                    $sql = 'SELECT * FROM "TblConsultantCompany"   
                        WHERE "consultantCompanyId" = :consultantCompanyId';
                    $sth = Yii::app()->db->createCommand($sql);
                    $sth->bindParam(':consultantCompanyId', $record['secondConsultantCompanyId']);
                    $secondConsultantCompany = $sth->queryAll();

                    if (isset($secondConsultantCompany)) {
                        $record['secondConsultantCompanyName'] = Encoding::escapleAllCharacter($secondConsultantCompany[0]['consultantCompanyName']);
                    } else {
                        $record['secondConsultantCompanyName'] = "UNKNOWN";
                    }
                } else {
                    $record['secondConsultantCompanyName'] = null;
                }

                $record['secondConsultantCompanyName'] = Encoding::escapleAllCharacter($result[0]['second_consultant_company']);
                $record['secondConsultantPhone'] = Encoding::escapleAllCharacter($result[0]['second_consultant_phone']);
                $record['secondConsultantEmail'] = Encoding::escapleAllCharacter($result[0]['second_consultant_email']);
                $record['thirdConsultantTitle'] = Encoding::escapleAllCharacter($result[0]['third_consultant_title']);
                $record['thirdConsultantSurname'] = Encoding::escapleAllCharacter($result[0]['third_consultant_surname']);
                $record['thirdConsultantOtherName'] = Encoding::escapleAllCharacter($result[0]['third_consultant_other_name']);
                $record['thirdConsultantCompany'] = Encoding::escapleAllCharacter($result[0]['third_consultant_company']);
                $record['thirdConsultantPhone'] = Encoding::escapleAllCharacter($result[0]['third_consultant_phone']);
                $record['thirdConsultantEmail'] = Encoding::escapleAllCharacter($result[0]['third_consultant_email']);
                $record['projectOwnerTitle'] = Encoding::escapleAllCharacter($result[0]['project_owner_title']);
                $record['projectOwnerSurname'] = Encoding::escapleAllCharacter($result[0]['project_owner_surname']);
                $record['projectOwnerOtherName'] = Encoding::escapleAllCharacter($result[0]['project_owner_other_name']);
                $record['projectOwnerCompany'] = Encoding::escapleAllCharacter($result[0]['project_owner_company']);
                $record['projectOwnerPhone'] = Encoding::escapleAllCharacter($result[0]['project_owner_phone']);
                $record['projectOwnerEmail'] = Encoding::escapleAllCharacter($result[0]['project_owner_email']);
                if (isset($result[0]['stand_letter_issue_date'])) {
                    $standLetterIssueDateYear = date("Y", strtotime($result[0]['stand_letter_issue_date']));
                    $standLetterIssueDateMonth = date("m", strtotime($result[0]['stand_letter_issue_date']));
                    $standLetterIssueDateDay = date("d", strtotime($result[0]['stand_letter_issue_date']));
                    $record['standLetterIssueDate'] = $standLetterIssueDateYear . "-" . $standLetterIssueDateMonth . "-" . $standLetterIssueDateDay;
                } else {
                    $record['standLetterIssueDate'] = null;
                }
                $record['standLetterFaxRefNo'] = Encoding::escapleAllCharacter($result[0]['stand_letter_fax_ref_no']);
                $record['standLetterEdmsLink'] = Encoding::escapleAllCharacter($result[0]['stand_letter_edms_link']);
                $record['standLetterLetterLoc'] = Encoding::escapleAllCharacter($result[0]['stand_letter_letter_loc']);
                if (isset($result[0]['meeting_first_prefer_meeting_date'])) {
                    $meetingFirstPreferMeetingDateYear = date("Y", strtotime($result[0]['meeting_first_prefer_meeting_date']));
                    $meetingFirstPreferMeetingDateMonth = date("m", strtotime($result[0]['meeting_first_prefer_meeting_date']));
                    $meetingFirstPreferMeetingDateDay = date("d", strtotime($result[0]['meeting_first_prefer_meeting_date']));
                    $meetingFirstPreferMeetingDateHour = date("H", strtotime($result[0]['meeting_first_prefer_meeting_date']));
                    $meetingFirstPreferMeetingDateMin = date("i", strtotime($result[0]['meeting_first_prefer_meeting_date']));
                    $record['meetingFirstPreferMeetingDate'] = $meetingFirstPreferMeetingDateYear . "-" .
                        $meetingFirstPreferMeetingDateMonth . "-" . $meetingFirstPreferMeetingDateDay. " " .
                        $meetingFirstPreferMeetingDateHour . ":" . $meetingFirstPreferMeetingDateMin;
                } else {
                    $record['meetingFirstPreferMeetingDate'] = null;
                }

                if (isset($result[0]['meeting_second_prefer_meeting_date'])) {
                    $meetingSecondPreferMeetingDateYear = date("Y", strtotime($result[0]['meeting_second_prefer_meeting_date']));
                    $meetingSecondPreferMeetingDateMonth = date("m", strtotime($result[0]['meeting_second_prefer_meeting_date']));
                    $meetingSecondPreferMeetingDateDay = date("d", strtotime($result[0]['meeting_second_prefer_meeting_date']));
                    $meetingSecondPreferMeetingDateHour = date("H", strtotime($result[0]['meeting_second_prefer_meeting_date']));
                    $meetingSecondPreferMeetingDateMin = date("i", strtotime($result[0]['meeting_second_prefer_meeting_date']));
                    $record['meetingSecondPreferMeetingDate'] = $meetingSecondPreferMeetingDateYear . "-" .
                        $meetingSecondPreferMeetingDateMonth . "-" . $meetingSecondPreferMeetingDateDay. " " .
                        $meetingSecondPreferMeetingDateHour . ":" . $meetingSecondPreferMeetingDateMin;
                } else {
                    $record['meetingSecondPreferMeetingDate'] = null;
                }
                $record['meetingActualMeetingDate'] = $result[0]['meeting_actual_meeting_date'];

                if (isset($result[0]['meeting_actual_meeting_date'])) {
                    $meetingActualMeetingDateYear = date("Y", strtotime($result[0]['meeting_actual_meeting_date']));
                    $meetingActualMeetingDateMonth = date("m", strtotime($result[0]['meeting_actual_meeting_date']));
                    $meetingActualMeetingDateDay = date("d", strtotime($result[0]['meeting_actual_meeting_date']));
                    $meetingActualMeetingDateHour = date("H", strtotime($result[0]['meeting_actual_meeting_date']));
                    $meetingActualMeetingDateMin = date("i", strtotime($result[0]['meeting_actual_meeting_date']));
                    $record['meetingActualMeetingDate'] = $meetingActualMeetingDateYear . "-" .
                        $meetingActualMeetingDateMonth . "-" . $meetingActualMeetingDateDay. " " .
                        $meetingActualMeetingDateHour . ":" . $meetingActualMeetingDateMin;
                } else {
                    $record['meetingActualMeetingDate'] = null;
                }

                $record['meetingRejReason'] = Encoding::escapleAllCharacter($result[0]['meeting_rej_reason']);
                $record['meetingConsentConsultant'] = $result[0]['meeting_consent_consultant'];
                $record['meetingConsentOwner'] = $result[0]['meeting_consent_owner'];
                $record['meetingReplySlipId'] = $result[0]['meeting_reply_slip_id'];

                if ($record['meetingReplySlipId'] > 0) {
                    $item = $this->getReplySlip($record['meetingReplySlipId']);
                    $record['replySlipBmsYesNo'] = Encoding::escapleAllCharacter($item['replySlipBmsYesNo']);
                    $record['replySlipBmsServerCentralComputer'] = Encoding::escapleAllCharacter($item['replySlipBmsServerCentralComputer']);
                    $record['replySlipBmsDdc'] = Encoding::escapleAllCharacter($item['replySlipBmsDdc']);
                    $record['replySlipChangeoverSchemeYesNo'] = Encoding::escapleAllCharacter($item['replySlipChangeoverSchemeYesNo']);
                    $record['replySlipChangeoverSchemeControl'] = Encoding::escapleAllCharacter($item['replySlipChangeoverSchemeControl']);
                    $record['replySlipChangeoverSchemeUv'] = Encoding::escapleAllCharacter($item['replySlipChangeoverSchemeUv']);
                    $record['replySlipChillerPlantYesNo'] = Encoding::escapleAllCharacter($item['replySlipChillerPlantYesNo']);
                    $record['replySlipChillerPlantAhu'] = Encoding::escapleAllCharacter($item['replySlipChillerPlantAhu']);
                    $record['replySlipChillerPlantChiller'] = Encoding::escapleAllCharacter($item['replySlipChillerPlantChiller']);
                    $record['replySlipEscalatorYesNo'] = Encoding::escapleAllCharacter($item['replySlipEscalatorYesNo']);
                    $record['replySlipEscalatorBrakingSystem'] = Encoding::escapleAllCharacter($item['replySlipEscalatorBrakingSystem']);
                    $record['replySlipEscalatorControl'] = Encoding::escapleAllCharacter($item['replySlipEscalatorControl']);
                    $record['replySlipHidLampYesNo'] = Encoding::escapleAllCharacter($item['replySlipHidLampYesNo']);
                    $record['replySlipHidLampBallast'] = Encoding::escapleAllCharacter($item['replySlipHidLampBallast']);
                    $record['replySlipHidLampAddOnProtection'] = Encoding::escapleAllCharacter($item['replySlipHidLampAddOnProtection']);
                    $record['replySlipLiftYesNo'] = Encoding::escapleAllCharacter($item['replySlipLiftYesNo']);
                    $record['replySlipLiftOperation'] = Encoding::escapleAllCharacter($item['replySlipLiftOperation']);
                    $record['replySlipSensitiveMachineYesNo'] = Encoding::escapleAllCharacter($item['replySlipSensitiveMachineYesNo']);
                    $record['replySlipSensitiveMachineMitigation'] = Encoding::escapleAllCharacter($item['replySlipSensitiveMachineMitigation']);
                    $record['replySlipTelecomMachineYesNo'] = Encoding::escapleAllCharacter($item['replySlipTelecomMachineYesNo']);
                    $record['replySlipTelecomMachineServerOrComputer'] = Encoding::escapleAllCharacter($item['replySlipTelecomMachineServerOrComputer']);
                    $record['replySlipTelecomMachinePeripherals'] = Encoding::escapleAllCharacter($item['replySlipTelecomMachinePeripherals']);
                    $record['replySlipTelecomMachineHarmonicEmission'] = Encoding::escapleAllCharacter($item['replySlipTelecomMachineHarmonicEmission']);
                    $record['replySlipAirConditionersYesNo'] = Encoding::escapleAllCharacter($item['replySlipAirConditionersYesNo']);
                    $record['replySlipAirConditionersMicb'] = Encoding::escapleAllCharacter($item['replySlipAirConditionersMicb']);
                    $record['replySlipAirConditionersLoadForecasting'] = Encoding::escapleAllCharacter($item['replySlipAirConditionersLoadForecasting']);
                    $record['replySlipAirConditionersType'] = Encoding::escapleAllCharacter($item['replySlipAirConditionersType']);
                    $record['replySlipNonLinearLoadYesNo'] = Encoding::escapleAllCharacter($item['replySlipNonLinearLoadYesNo']);
                    $record['replySlipNonLinearLoadHarmonicEmission'] = Encoding::escapleAllCharacter($item['replySlipNonLinearLoadHarmonicEmission']);
                    $record['replySlipRenewableEnergyYesNo'] = Encoding::escapleAllCharacter($item['replySlipRenewableEnergyYesNo']);
                    $record['replySlipRenewableEnergyInverterAndControls'] = Encoding::escapleAllCharacter($item['replySlipRenewableEnergyInverterAndControls']);
                    $record['replySlipRenewableEnergyHarmonicEmission'] = Encoding::escapleAllCharacter($item['replySlipRenewableEnergyHarmonicEmission']);
                    $record['replySlipEvChargerSystemYesNo'] = Encoding::escapleAllCharacter($item['replySlipEvChargerSystemYesNo']);
                    $record['replySlipEvChargerSystemEvCharger'] = Encoding::escapleAllCharacter($item['replySlipEvChargerSystemEvCharger']);
                    $record['replySlipEvChargerSystemSmartChargingSystem'] = Encoding::escapleAllCharacter($item['replySlipEvChargerSystemSmartChargingSystem']);
                    $record['replySlipEvChargerSystemHarmonicEmission'] = Encoding::escapleAllCharacter($item['replySlipEvChargerSystemHarmonicEmission']);
                } else {
                    $record['replySlipBmsYesNo'] = "";
                    $record['replySlipBmsServerCentralComputer'] = "";
                    $record['replySlipBmsDdc'] = "";
                    $record['replySlipChangeoverSchemeYesNo'] = "";
                    $record['replySlipChangeoverSchemeControl'] = "";
                    $record['replySlipChangeoverSchemeUv'] = "";
                    $record['replySlipChillerPlantYesNo'] = "";
                    $record['replySlipChillerPlantAhu'] = "";
                    $record['replySlipChillerPlantChiller'] = "";
                    $record['replySlipEscalatorYesNo'] = "";
                    $record['replySlipEscalatorBrakingSystem'] = "";
                    $record['replySlipEscalatorControl'] = "";
                    $record['replySlipHidLampYesNo'] = "";
                    $record['replySlipHidLampBallast'] = "";
                    $record['replySlipHidLampAddOnProtection'] = "";
                    $record['replySlipLiftYesNo'] = "";
                    $record['replySlipLiftOperation'] = "";
                    $record['replySlipSensitiveMachineYesNo'] = "";
                    $record['replySlipSensitiveMachineMitigation'] = "";
                    $record['replySlipTelecomMachineYesNo'] = "";
                    $record['replySlipTelecomMachineServerOrComputer'] = "";
                    $record['replySlipTelecomMachinePeripherals'] = "";
                    $record['replySlipTelecomMachineHarmonicEmission'] = "";
                    $record['replySlipAirConditionersYesNo'] = "";
                    $record['replySlipAirConditionersMicb'] = "";
                    $record['replySlipAirConditionersLoadForecasting'] = "";
                    $record['replySlipAirConditionersType'] = "";
                    $record['replySlipNonLinearLoadYesNo'] = "";
                    $record['replySlipNonLinearLoadHarmonicEmission'] = "";
                    $record['replySlipRenewableEnergyYesNo'] = "";
                    $record['replySlipRenewableEnergyInverterAndControls'] = "";
                    $record['replySlipRenewableEnergyHarmonicEmission'] = "";
                    $record['replySlipEvChargerSystemYesNo'] = "";
                    $record['replySlipEvChargerSystemEvCharger'] = "";
                    $record['replySlipEvChargerSystemSmartChargingSystem'] = "";
                    $record['replySlipEvChargerSystemHarmonicEmission'] = "";
                }
                if (isset($result[0]['first_invitation_letter_issue_date'])) {
                    $firstInvitationLetterIssueDateYear = date("Y", strtotime($result[0]['first_invitation_letter_issue_date']));
                    $firstInvitationLetterIssueDateMonth = date("m", strtotime($result[0]['first_invitation_letter_issue_date']));
                    $firstInvitationLetterIssueDateDay = date("d", strtotime($result[0]['first_invitation_letter_issue_date']));
                    $record['firstInvitationLetterIssueDate'] = $firstInvitationLetterIssueDateYear . "-" .
                        $firstInvitationLetterIssueDateMonth . "-" . $firstInvitationLetterIssueDateDay;
                } else {
                    $record['firstInvitationLetterIssueDate'] = null;
                }

                $record['firstInvitationLetterFaxRefNo'] = Encoding::escapleAllCharacter($result[0]['first_invitation_letter_fax_ref_no']);
                $record['firstInvitationLetterEdmsLink'] = Encoding::escapleAllCharacter($result[0]['first_invitation_letter_edms_link']);
                $record['firstInvitationLetterAccept'] = $result[0]['first_invitation_letter_accept'];

                if (isset($result[0]['first_invitation_letter_walk_date'])) {
                    $firstInvitationLetterWalkDateYear = date("Y", strtotime($result[0]['first_invitation_letter_walk_date']));
                    $firstInvitationLetterWalkDateMonth = date("m", strtotime($result[0]['first_invitation_letter_walk_date']));
                    $firstInvitationLetterWalkDateDay = date("d", strtotime($result[0]['first_invitation_letter_walk_date']));
                    $record['firstInvitationLetterWalkDate'] = $firstInvitationLetterWalkDateYear . "-" .
                        $firstInvitationLetterWalkDateMonth . "-" . $firstInvitationLetterWalkDateDay;
                } else {
                    $record['firstInvitationLetterWalkDate'] = null;
                }

                if (isset($result[0]['second_invitation_letter_issue_date'])) {
                    $secondInvitationLetterIssueDateYear = date("Y", strtotime($result[0]['second_invitation_letter_issue_date']));
                    $secondInvitationLetterIssueDateMonth = date("m", strtotime($result[0]['second_invitation_letter_issue_date']));
                    $secondInvitationLetterIssueDateDay = date("d", strtotime($result[0]['second_invitation_letter_issue_date']));
                    $record['secondInvitationLetterIssueDate'] = $secondInvitationLetterIssueDateYear . "-" .
                        $secondInvitationLetterIssueDateMonth . "-" . $secondInvitationLetterIssueDateDay;
                } else {
                    $record['secondInvitationLetterIssueDate'] = null;
                }

                $record['secondInvitationLetterFaxRefNo'] = Encoding::escapleAllCharacter($result[0]['second_invitation_letter_fax_ref_no']);
                $record['secondInvitationLetterEdmsLink'] = Encoding::escapleAllCharacter($result[0]['second_invitation_letter_edms_link']);
                $record['secondInvitationLetterAccept'] = $result[0]['second_invitation_letter_accept'];

                if (isset($result[0]['second_invitation_letter_walk_date'])) {
                    $secondInvitationLetterWalkDateYear = date("Y", strtotime($result[0]['second_invitation_letter_walk_date']));
                    $secondInvitationLetterWalkDateMonth = date("m", strtotime($result[0]['second_invitation_letter_walk_date']));
                    $secondInvitationLetterWalkDateDay = date("d", strtotime($result[0]['second_invitation_letter_walk_date']));
                    $record['secondInvitationLetterWalkDate'] = $secondInvitationLetterWalkDateYear . "-" .
                        $secondInvitationLetterWalkDateMonth . "-" . $secondInvitationLetterWalkDateDay;
                } else {
                    $record['secondInvitationLetterWalkDate'] = null;
                }

                if (isset($result[0]['third_invitation_letter_issue_date'])) {
                    $thirdInvitationLetterIssueDateYear = date("Y", strtotime($result[0]['third_invitation_letter_issue_date']));
                    $thirdInvitationLetterIssueDateMonth = date("m", strtotime($result[0]['third_invitation_letter_issue_date']));
                    $thirdInvitationLetterIssueDateDay = date("d", strtotime($result[0]['third_invitation_letter_issue_date']));
                    $record['thirdInvitationLetterIssueDate'] = $thirdInvitationLetterIssueDateYear . "-" .
                        $thirdInvitationLetterIssueDateMonth . "-" . $thirdInvitationLetterIssueDateDay;
                } else {
                    $record['thirdInvitationLetterIssueDate'] = null;
                }

                $record['thirdInvitationLetterFaxRefNo'] = Encoding::escapleAllCharacter($result[0]['third_invitation_letter_fax_ref_no']);
                $record['thirdInvitationLetterEdmsLink'] = Encoding::escapleAllCharacter($result[0]['third_invitation_letter_edms_link']);
                $record['thirdInvitationLetterAccept'] = $result[0]['third_invitation_letter_accept'];

                if (isset($result[0]['third_invitation_letter_walk_date'])) {
                    $thirdInvitationLetterWalkDateYear = date("Y", strtotime($result[0]['third_invitation_letter_walk_date']));
                    $thirdInvitationLetterWalkDateMonth = date("m", strtotime($result[0]['third_invitation_letter_walk_date']));
                    $thirdInvitationLetterWalkDateDay = date("d", strtotime($result[0]['third_invitation_letter_walk_date']));
                    $record['thirdInvitationLetterWalkDate'] = $thirdInvitationLetterWalkDateYear . "-" .
                        $thirdInvitationLetterWalkDateMonth . "-" . $thirdInvitationLetterWalkDateDay;
                } else {
                    $record['thirdInvitationLetterWalkDate'] = null;
                }

                if (isset($result[0]['forth_invitation_letter_issue_date'])) {
                    $forthInvitationLetterIssueDateYear = date("Y", strtotime($result[0]['forth_invitation_letter_issue_date']));
                    $forthInvitationLetterIssueDateMonth = date("m", strtotime($result[0]['forth_invitation_letter_issue_date']));
                    $forthInvitationLetterIssueDateDay = date("d", strtotime($result[0]['forth_invitation_letter_issue_date']));
                    $record['forthInvitationLetterIssueDate'] = $forthInvitationLetterIssueDateYear . "-" .
                        $forthInvitationLetterIssueDateMonth . "-" . $forthInvitationLetterIssueDateDay;
                } else {
                    $record['forthInvitationLetterIssueDate'] = null;
                }

                $record['forthInvitationLetterFaxRefNo'] = Encoding::escapleAllCharacter($result[0]['forth_invitation_letter_fax_ref_no']);
                $record['forthInvitationLetterEdmsLink'] = Encoding::escapleAllCharacter($result[0]['forth_invitation_letter_edms_link']);
                $record['forthInvitationLetterAccept'] = $result[0]['forth_invitation_letter_accept'];

                if (isset($result[0]['forth_invitation_letter_walk_date'])) {
                    $forthInvitationLetterWalkDateYear = date("Y", strtotime($result[0]['forth_invitation_letter_walk_date']));
                    $forthInvitationLetterWalkDateMonth = date("m", strtotime($result[0]['forth_invitation_letter_walk_date']));
                    $forthInvitationLetterWalkDateDay = date("d", strtotime($result[0]['forth_invitation_letter_walk_date']));
                    $record['forthInvitationLetterWalkDate'] = $forthInvitationLetterWalkDateYear . "-" .
                        $forthInvitationLetterWalkDateMonth . "-" . $forthInvitationLetterWalkDateDay;
                } else {
                    $record['forthInvitationLetterWalkDate'] = null;
                }

                $record['evaReportId'] = $result[0]['eva_report_id'];
                $record['state'] = Encoding::escapleAllCharacter($result[0]['state']);
                $record['active'] = Encoding::escapleAllCharacter($result[0]['active']);
                $record['createdBy'] = Encoding::escapleAllCharacter($result[0]['created_by']);
                $record['createdTime'] = $result[0]['created_time'];
                $record['lastUpdatedBy'] = Encoding::escapleAllCharacter($result[0]['last_updated_by']);
                $record['lastUpdatedTime'] = $result[0]['last_updated_time'];
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $record;
    }

    public function getReplySlip($replySlipId) {

        $item = array();

        try {
            $sql = "SELECT * FROM \"tbl_slip_reply\" WHERE \"reply_slip_id\"=:replySlipId";
            $sth = Yii::app()->db->createCommand($sql);
            $sth->bindParam(':replySlipId', $replySlipId);
            $result = $sth->queryAll();

            foreach($result as $row) {
                $item['replySlipBmsYesNo'] = $row['bms_yes_no'];
                $item['replySlipBmsServerCentralComputer'] = $row['bms_server_central_computer'];
                $item['replySlipBmsDdc'] = $row['bms_ddc'];
                $item['replySlipChangeoverSchemeYesNo'] = $row['changeover_scheme_yes_no'];
                $item['replySlipChangeoverSchemeControl'] = $row['changeover_scheme_control'];
                $item['replySlipChangeoverSchemeUv'] = $row['changeover_scheme_uv'];
                $item['replySlipChillerPlantYesNo'] = $row['chiller_plant_yes_no'];
                $item['replySlipChillerPlantAhu'] = $row['chiller_plant_ahu'];
                $item['replySlipChillerPlantChiller'] = $row['chiller_plant_chiller'];
                $item['replySlipEscalatorYesNo'] = $row['escalator_yes_no'];
                $item['replySlipEscalatorBrakingSystem'] = $row['escalator_braking_system'];
                $item['replySlipEscalatorControl'] = $row['escalator_control'];
                $item['replySlipHidLampYesNo'] = $row['hid_lamp_yes_no'];
                $item['replySlipHidLampBallast'] = $row['hid_lamp_ballast'];
                $item['replySlipHidLampAddOnProtection'] = $row['hid_lamp_add_on_protection'];
                $item['replySlipLiftYesNo'] = $row['lift_yes_no'];
                $item['replySlipLiftOperation'] = $row['lift_operation'];
                $item['replySlipSensitiveMachineYesNo'] = $row['sensitive_machine_yes_no'];
                $item['replySlipSensitiveMachineMitigation'] = $row['sensitive_machine_mitigation'];
                $item['replySlipTelecomMachineYesNo'] = $row['telecom_machine_yes_no'];
                $item['replySlipTelecomMachineServerOrComputer'] = $row['telecom_machine_server_or_computer'];
                $item['replySlipTelecomMachinePeripherals'] = $row['telecom_machine_peripherals'];
                $item['replySlipTelecomMachineHarmonicEmission'] = $row['telecom_machine_harmonic_emission'];
                $item['replySlipAirConditionersYesNo'] = $row['air_conditioners_yes_no'];
                $item['replySlipAirConditionersMicb'] = $row['air_conditioners_micb'];
                $item['replySlipAirConditionersLoadForecasting'] = $row['air_conditioners_load_forecasting'];
                $item['replySlipAirConditionersType'] = $row['air_conditioners_type'];
                $item['replySlipNonLinearLoadYesNo'] = $row['non_linear_load_yes_no'];
                $item['replySlipNonLinearLoadHarmonicEmission'] = $row['non_linear_load_harmonic_emission'];
                $item['replySlipRenewableEnergyYesNo'] = $row['renewable_energy_yes_no'];
                $item['replySlipRenewableEnergyInverterAndControls'] = $row['renewable_energy_inverter_and_controls'];
                $item['replySlipRenewableEnergyHarmonicEmission'] = $row['renewable_energy_harmonic_emission'];
                $item['replySlipEvChargerSystemYesNo'] = $row['ev_charger_system_yes_no'];
                $item['replySlipEvChargerSystemEvCharger'] = $row['ev_charger_system_ev_charger'];
                $item['replySlipEvChargerSystemSmartChargingSystem'] = $row['ev_charger_system_smart_charging_system'];
                $item['replySlipEvChargerSystemHarmonicEmission'] = $row['ev_charger_system_harmonic_emission'];

                if (isset($row['last_updated_time'])) {
                    $replySlipLastUpdateTimeYear = date("Y", strtotime($row['last_updated_time']));
                    $replySlipLastUpdateTimeMonth = date("m", strtotime($row['last_updated_time']));
                    $replySlipLastUpdateTimeDay = date("d", strtotime($row['last_updated_time']));
                    $item['replySlipLastUpdateTime'] = $replySlipLastUpdateTimeYear . "-" .
                        $replySlipLastUpdateTimeMonth . "-" . $replySlipLastUpdateTimeDay;
                } else {
                    $item['replySlipLastUpdateTime'] = null;
                }
            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $item;

    }

    public function getPlanningAheadProjectTypeList() {

        $record = array();
        $item = array();

        try {
            $sql = "SELECT * FROM \"tbl_project_type\" WHERE \"active\"='Y'";
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();

            foreach($result as $row) {
                $item['projectTypeId'] = $row['project_type_id'];
                $item['projectTypeName'] = $row['project_type_name'];
                $record[] = $item;
            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $record;
    }

    public function getPlanningAheadProjectTypeById($projectTypeId) {

        $record = array();
        $item = array();

        try {
            $sql = "SELECT * FROM \"tbl_project_type\" WHERE \"active\"='Y' AND \"project_type_id\"=:project_type_id";
            $sth = Yii::app()->db->createCommand($sql);
            $sth->bindParam(':project_type_id', $projectTypeId);
            $result = $sth->queryAll();

            foreach($result as $row) {
                $item['projectTypeId'] = $row['project_type_id'];
                $item['projectTypeName'] = $row['project_type_name'];
                $item['projectTypeTemplateFileName'] = $row['project_type_template_file_name'];
                $record[] = $item;
            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $record;
    }

    public function getPlanningAheadConsultantCompanyAllActive()
    {
        $List = array();
        try {
            $sql = "SELECT * FROM \"TblConsultantCompany\" WHERE active ='Y' AND \"consultantCompanyName\" IS NOT NULL ORDER BY \"consultantCompanyName\"";
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) {
                $array['consultantCompanyId'] = $row['consultantCompanyId'];
                $array['consultantCompanyName'] = Encoding::escapleAllCharacter($row['consultantCompanyName']);
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }

    public function getPlanningAheadRegionAllActive() {
        $List = array();
        try {
            $sql = "SELECT * FROM \"tbl_region\" WHERE active ='Y' ORDER BY \"region_short_name\"";
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) {
                $array['regionId'] = $row['region_id'];
                $array['regionShortName'] = Encoding::escapleAllCharacter($row['region_short_name']);
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }



    public function updatePlanningAheadDetailDraft($txnProjectTitle,$txnSchemeNo,$txnRegion,
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
                                                   $txnMeetingActualMeetingDate,$txnMeetingRejReason,$txnMeetingConsentConsultant,
                                                   $txnMeetingConsentOwner,$txnMeetingReplySlipId,$txnReplySlipBmsYesNo,$txnReplySlipBmsServerCentralComputer,
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
                                                   $txnReplySlipEvChargerSystemHarmonicEmission,$txnFirstInvitationLetterIssueDate,
                                                   $txnFirstInvitationLetterFaxRefNo,$txnFirstInvitationLetterEdmsLink,
                                                   $txnFirstInvitationLetterAccept,$txnFirstInvitationLetterWalkDate,
                                                   $lastUpdatedBy,$lastUpdatedTime,
                                                   $txnPlanningAheadId) {

        $sql = 'UPDATE "tbl_planning_ahead" SET "project_title"=?, "scheme_no"=?, "region_id"=?, ';
        $sql = $sql . '"project_type_id"=?, "commission_date"=?, "key_infra"=?, "temp_project"=?, ';
        $sql = $sql . '"first_region_staff_name"=?, "first_region_staff_phone"=?, "first_region_staff_email"=?, ';
        $sql = $sql . '"second_region_staff_name"=?, "second_region_staff_phone"=?, "second_region_staff_email"=?, ';
        $sql = $sql . '"third_region_staff_name"=?, "third_region_staff_phone"=?, "third_region_staff_email"=?, ';
        $sql = $sql . '"first_consultant_title"=?, "first_consultant_surname"=?, "first_consultant_other_name"=?, ';
        $sql = $sql . '"first_consultant_company"=?, "first_consultant_phone"=?, "first_consultant_email"=?, ';
        $sql = $sql . '"second_consultant_title"=?, "second_consultant_surname"=?, "second_consultant_other_name"=?, ';
        $sql = $sql . '"second_consultant_company"=?, "second_consultant_phone"=?, "second_consultant_email"=?, ';
        $sql = $sql . '"project_owner_title"=?, "project_owner_surname"=?, "project_owner_other_name"=?, ';
        $sql = $sql . '"project_owner_company"=?, "project_owner_phone"=?, "project_owner_email"=?, ';
        $sql = $sql . '"stand_letter_issue_date"=?, "stand_letter_fax_ref_no"=?, "stand_letter_edms_link"=?, ';
        $sql = $sql . '"stand_letter_letter_loc"=?, ';
        $sql = $sql . '"meeting_first_prefer_meeting_date"=?, "meeting_second_prefer_meeting_date"=?, ';
        $sql = $sql . '"meeting_actual_meeting_date"=?, "meeting_rej_reason"=?, ';
        $sql = $sql . '"meeting_consent_consultant"=?, "meeting_consent_owner"=?, ';
        $sql = $sql . '"first_invitation_letter_issue_date"=?, "first_invitation_letter_fax_ref_no"=?, ';
        $sql = $sql . '"first_invitation_letter_edms_link"=?, "first_invitation_letter_accept"=?, ';
        $sql = $sql . '"first_invitation_letter_walk_date"=?, ';
        $sql = $sql . '"last_updated_by"=?, "last_updated_time"=? ';
        $sql = $sql . 'WHERE "planning_ahead_id"=?';

        try {
            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array(
                $txnProjectTitle, $txnSchemeNo, $txnRegion,
                $txnTypeOfProject, $txnCommissionDate, $txnKeyInfra, $txnTempProj,
                $txnFirstRegionStaffName, $txnFirstRegionStaffPhone, $txnFirstRegionStaffEmail,
                $txnSecondRegionStaffName, $txnSecondRegionStaffPhone, $txnSecondRegionStaffEmail,
                $txnThirdRegionStaffName, $txnThirdRegionStaffPhone, $txnThirdRegionStaffEmail,
                $txnFirstConsultantTitle, $txnFirstConsultantSurname, $txnFirstConsultantOtherName,
                $txnFirstConsultantCompany, $txnFirstConsultantPhone, $txnFirstConsultantEmail,
                $txnSecondConsultantTitle, $txnSecondConsultantSurname, $txnSecondConsultantOtherName,
                $txnSecondConsultantCompany, $txnSecondConsultantPhone, $txnSecondConsultantEmail,
                $txnProjectOwnerTitle, $txnProjectOwnerSurname, $txnProjectOwnerOtherName,
                $txnProjectOwnerCompany, $txnProjectOwnerPhone, $txnProjectOwnerEmail,
                $txnStandLetterIssueDate, $txnStandLetterFaxRefNo, $txnStandLetterEdmsLink,
                $txnStandLetterLetterLoc, $txnMeetingFirstPreferMeetingDate, $txnMeetingSecondPreferMeetingDate,
                $txnMeetingActualMeetingDate, $txnMeetingRejReason, $txnMeetingConsentConsultant,
                $txnMeetingConsentOwner,$txnFirstInvitationLetterIssueDate,$txnFirstInvitationLetterFaxRefNo,
                $txnFirstInvitationLetterEdmsLink,$txnFirstInvitationLetterAccept,$txnFirstInvitationLetterWalkDate,
                $lastUpdatedBy, $lastUpdatedTime, $txnPlanningAheadId));

            if ($txnMeetingReplySlipId>0) {
                $sql = 'UPDATE "tbl_slip_reply" SET "bms_yes_no"=?, "bms_server_central_computer"=?,
                            "bms_ddc"=?, "changeover_scheme_yes_no"=?, "changeover_scheme_control"=?, 
                            "changeover_scheme_uv"=?, "chiller_plant_yes_no"=?, "chiller_plant_ahu"=?, 
                            "chiller_plant_chiller"=?, "escalator_yes_no"=?, "escalator_braking_system"=?, 
                            "escalator_control"=?, "hid_lamp_yes_no"=?, "hid_lamp_ballast"=?, "hid_lamp_add_on_protection"=?,
                            "lift_yes_no"=?, "lift_operation"=?, "sensitive_machine_yes_no"=?,
                            "sensitive_machine_mitigation"=?, "telecom_machine_yes_no"=?, 
                            "telecom_machine_server_or_computer"=?, "telecom_machine_peripherals"=?, 
                            "telecom_machine_harmonic_emission"=?, "air_conditioners_yes_no"=?, 
                            "air_conditioners_micb"=?, "air_conditioners_load_forecasting"=?, 
                            "air_conditioners_type"=?, "non_linear_load_yes_no"=?, "non_linear_load_harmonic_emission"=?, 
                            "renewable_energy_yes_no"=?, "renewable_energy_inverter_and_controls"=?, 
                            "renewable_energy_harmonic_emission"=?, "ev_charger_system_yes_no"=?,
                            "ev_charger_system_ev_charger"=?, "ev_charger_system_smart_charging_system"=?, 
                            "ev_charger_system_harmonic_emission"=?, 
                            "last_updated_by"=?, "last_updated_time"=? 
                            WHERE "reply_slip_id"=?';

                $stmt = Yii::app()->db->createCommand($sql);
                $result = $stmt->execute(array($txnReplySlipBmsYesNo,$txnReplySlipBmsServerCentralComputer,
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
                    $lastUpdatedBy,$lastUpdatedTime,$txnMeetingReplySlipId));
            }

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

        return $retJson;
    }

    public function updatePlanningAheadDetailProcess($txnProjectTitle,$txnSchemeNo,$txnRegion,
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
                                                     $txnMeetingActualMeetingDate,$txnMeetingRejReason,$txnMeetingConsentConsultant,
                                                     $txnMeetingConsentOwner,$txnMeetingReplySlipId,$txnReplySlipBmsYesNo,$txnReplySlipBmsServerCentralComputer,
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
                                                     $txnPlanningAheadId)
    {

        $sql = 'UPDATE "tbl_planning_ahead" SET "project_title"=?, "scheme_no"=?, "region_id"=?, ';
        $sql = $sql . '"project_type_id"=?, "commission_date"=?, "key_infra"=?, "temp_project"=?, ';
        $sql = $sql . '"first_region_staff_name"=?, "first_region_staff_phone"=?, "first_region_staff_email"=?, ';
        $sql = $sql . '"second_region_staff_name"=?, "second_region_staff_phone"=?, "second_region_staff_email"=?, ';
        $sql = $sql . '"third_region_staff_name"=?, "third_region_staff_phone"=?, "third_region_staff_email"=?, ';
        $sql = $sql . '"first_consultant_title"=?, "first_consultant_surname"=?, "first_consultant_other_name"=?, ';
        $sql = $sql . '"first_consultant_company"=?, "first_consultant_phone"=?, "first_consultant_email"=?, ';
        $sql = $sql . '"second_consultant_title"=?, "second_consultant_surname"=?, "second_consultant_other_name"=?, ';
        $sql = $sql . '"second_consultant_company"=?, "second_consultant_phone"=?, "second_consultant_email"=?, ';
        $sql = $sql . '"project_owner_title"=?, "project_owner_surname"=?, "project_owner_other_name"=?, ';
        $sql = $sql . '"project_owner_company"=?, "project_owner_phone"=?, "project_owner_email"=?, ';
        $sql = $sql . '"stand_letter_issue_date"=?, "stand_letter_fax_ref_no"=?, "stand_letter_edms_link"=?, ';
        $sql = $sql . '"stand_letter_letter_loc"=?, ';
        $sql = $sql . '"meeting_first_prefer_meeting_date"=?, "meeting_second_prefer_meeting_date"=?, ';
        $sql = $sql . '"meeting_actual_meeting_date"=?, "meeting_rej_reason"=?, ';
        $sql = $sql . '"meeting_consent_consultant"=?, "meeting_consent_owner"=?, ';
        $sql = $sql . '"first_invitation_letter_issue_date"=?, "first_invitation_letter_fax_ref_no"=?, ';
        $sql = $sql . '"first_invitation_letter_edms_link"=?, "first_invitation_letter_accept"=?, ';
        $sql = $sql . '"first_invitation_letter_walk_date"=?, ';
        $sql = $sql . '"state"=?, "last_updated_by"=?, "last_updated_time"=? ';
        $sql = $sql . 'WHERE "planning_ahead_id"=?';

        try {
            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array(
                $txnProjectTitle, $txnSchemeNo, $txnRegion,
                $txnTypeOfProject, $txnCommissionDate, $txnKeyInfra, $txnTempProj,
                $txnFirstRegionStaffName, $txnFirstRegionStaffPhone, $txnFirstRegionStaffEmail,
                $txnSecondRegionStaffName, $txnSecondRegionStaffPhone, $txnSecondRegionStaffEmail,
                $txnThirdRegionStaffName, $txnThirdRegionStaffPhone, $txnThirdRegionStaffEmail,
                $txnFirstConsultantTitle, $txnFirstConsultantSurname, $txnFirstConsultantOtherName,
                $txnFirstConsultantCompany, $txnFirstConsultantPhone, $txnFirstConsultantEmail,
                $txnSecondConsultantTitle,$txnSecondConsultantSurname,$txnSecondConsultantOtherName,
                $txnSecondConsultantCompany,$txnSecondConsultantPhone,$txnSecondConsultantEmail,
                $txnProjectOwnerTitle, $txnProjectOwnerSurname, $txnProjectOwnerOtherName,
                $txnProjectOwnerCompany, $txnProjectOwnerPhone, $txnProjectOwnerEmail,
                $txnStandLetterIssueDate,$txnStandLetterFaxRefNo,$txnStandLetterEdmsLink,
                $txnStandLetterLetterLoc,$txnMeetingFirstPreferMeetingDate,$txnMeetingSecondPreferMeetingDate,
                $txnMeetingActualMeetingDate,$txnMeetingRejReason,$txnMeetingConsentConsultant,
                $txnMeetingConsentOwner, $txnFirstInvitationLetterIssueDate,$txnFirstInvitationLetterFaxRefNo,
                $txnFirstInvitationLetterEdmsLink, $txnFirstInvitationLetterAccept,$txnFirstInvitationLetterWalkDate,
                $txnNewState, $lastUpdatedBy, $lastUpdatedTime,
                $txnPlanningAheadId));

            if ($txnMeetingReplySlipId>0) {
                $sql = 'UPDATE "tbl_slip_reply" SET "bms_yes_no"=?, "bms_server_central_computer"=?,
                            "bms_ddc"=?, "changeover_scheme_yes_no"=?, "changeover_scheme_control"=?, 
                            "changeover_scheme_uv"=?, "chiller_plant_yes_no"=?, "chiller_plant_ahu"=?, 
                            "chiller_plant_chiller"=?, "escalator_yes_no"=?, "escalator_braking_system"=?, 
                            "escalator_control"=?, "hid_lamp_yes_no"=?, "hid_lamp_ballast"=?, "hid_lamp_add_on_protection"=?,
                            "lift_yes_no"=?, "lift_operation"=?, "sensitive_machine_yes_no"=?,
                            "sensitive_machine_mitigation"=?, "telecom_machine_yes_no"=?, 
                            "telecom_machine_server_or_computer"=?, "telecom_machine_peripherals"=?, 
                            "telecom_machine_harmonic_emission"=?, "air_conditioners_yes_no"=?, 
                            "air_conditioners_micb"=?, "air_conditioners_load_forecasting"=?, 
                            "air_conditioners_type"=?, "non_linear_load_yes_no"=?, "non_linear_load_harmonic_emission"=?, 
                            "renewable_energy_yes_no"=?, "renewable_energy_inverter_and_controls"=?, 
                            "renewable_energy_harmonic_emission"=?, "ev_charger_system_yes_no"=?,
                            "ev_charger_system_ev_charger"=?, "ev_charger_system_smart_charging_system"=?, 
                            "ev_charger_system_harmonic_emission"=?, 
                            "last_updated_by"=?, "last_updated_time"=? 
                            WHERE "reply_slip_id"=?';

                $stmt = Yii::app()->db->createCommand($sql);
                $result = $stmt->execute(array($txnReplySlipBmsYesNo,$txnReplySlipBmsServerCentralComputer,
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
                    $lastUpdatedBy,$lastUpdatedTime,$txnMeetingReplySlipId));
            }

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

        return $retJson;
    }

    public function updateStandardLetter($txnPlanningAheadId, $standLetterIssueDate, $standLetterFaxRefNo,
                                         $lastUpdatedBy,$lastUpdatedTime) {

        $sql = 'UPDATE "tbl_planning_ahead" SET "stand_letter_issue_date"=?, "stand_letter_fax_ref_no"=?';
        $sql = $sql . '"last_updated_by"=?, "last_updated_time"=? ';
        $sql = $sql . 'WHERE "planning_ahead_id"=?';

        try {
            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array($standLetterIssueDate,$standLetterFaxRefNo,$lastUpdatedBy,$lastUpdatedTime,
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

        return $retJson;

    }

    public function updateFirstInvitationLetter($txnPlanningAheadId, $firstInvitationLetterIssueDate,
                                                $firstInvitationLetterFaxRefNo, $lastUpdatedBy,$lastUpdatedTime) {

        $sql = 'UPDATE "tbl_planning_ahead" SET "first_invitation_letter_issue_date"=?, "first_invitation_letter_fax_ref_no"=?, ';
        $sql = $sql . '"last_updated_by"=?, "last_updated_time"=? ';
        $sql = $sql . 'WHERE "planning_ahead_id"=?';

        try {
            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array($firstInvitationLetterIssueDate,$firstInvitationLetterFaxRefNo,
                $lastUpdatedBy,$lastUpdatedTime, $txnPlanningAheadId));
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

        return $retJson;

    }

    public function updateSecondInvitationLetter($txnPlanningAheadId,$firstInvitationLetterIssueDate,
                                                 $firstInvitationLetterFaxRefNo,$secondInvitationLetterIssueDate,
                                                 $secondInvitationLetterFaxRefNo,$lastUpdatedBy,$lastUpdatedTime) {

        $sql = 'UPDATE "tbl_planning_ahead" SET "first_invitation_letter_issue_date"=?, 
                                "first_invitation_letter_fax_ref_no"=?, "second_invitation_letter_issue_date"=?, 
                                "second_invitation_letter_fax_ref_no"=?, "last_updated_by"=?, "last_updated_time"=? 
                                WHERE "planning_ahead_id"=?';

        try {
            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array($firstInvitationLetterIssueDate,$firstInvitationLetterFaxRefNo,
                $secondInvitationLetterIssueDate,$secondInvitationLetterFaxRefNo,$lastUpdatedBy,
                $lastUpdatedTime,$txnPlanningAheadId));
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

        return $retJson;

    }


    public function updateConsultantMeetingInfo($schemeNo,$firstPreferredMeetingDate,$secondPreferredMeetingDate,
                                                $rejectReason,$consentedByConsultant,$consentedByProjectOwner,
                                                $lastUpdatedBy,$lastUpdatedTime) {

        $sql = 'UPDATE "tbl_planning_ahead" SET "meeting_first_prefer_meeting_date"=?, "meeting_second_prefer_meeting_date"=?, ';
        $sql = $sql . '"meeting_rej_reason"=?, "meeting_consent_consultant"=?, "meeting_consent_owner"=?, ';
        $sql = $sql . '"last_updated_by"=?, "last_updated_time"=?, ';
        $sql = $sql . '"state"=\'COMPLETED_CONSULTANT_MEETING_INFO\' ';
        $sql = $sql . 'WHERE "scheme_no"=?';

        try {
            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array($firstPreferredMeetingDate,$secondPreferredMeetingDate,$rejectReason,
                $consentedByConsultant,$consentedByProjectOwner,$lastUpdatedBy,$lastUpdatedTime,$schemeNo));
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

        return $retJson;
    }

    public function addReplySlip($schemeNo,$replySlipLoc,$bmsYesNo,$bmsServerCentralComputer,$bmsDdc,
                                    $changeoverSchemeYesNo,$changeoverSchemeControl,$changeoverSchemeUv,
                                    $chillerPlantYesNo,$chillerPlantAhu,$chillerPlantChiller,
                                    $escalatorYesNo,$escalatorBrakingSystem,$escalatorControl,
                                    $liftYesNo,$liftOperation,$hidLampYesNo,$hidLampBallast,
                                    $hidLampAddOnProtection,$sensitiveMachineYesNo,$sensitiveMachineMitigation,
                                    $telecomMachineYesNo,$telecomMachineServerOrComputer,$telecomMachinePeripherals,
                                    $telecomMachineHarmonicEmission,$airConditionersYesNo,$airConditionersMicb,
                                    $airConditionersLoadForecasting,$airConditionersType,$nonLinearLoadYesNo,
                                    $nonLinearLoadHarmonicEmission,$renewableEnergyYesNo,$renewableEnergyInverterAndControls,
                                    $renewableEnergyHarmonicEmission,$evChargerSystemYesNo,$evChargerSystemEvCharger,
                                    $evChargerSystemSmartChargingSystem,$evChargerSystemHarmonicEmission,
                                    $createdBy,$createdTime,$lastUpdatedBy,$lastUpdatedTime) {

        $sql = 'INSERT INTO "tbl_slip_reply" ("reply_slip_loc","scheme_no", "bms_yes_no","bms_server_central_computer",
                              "bms_ddc","changeover_scheme_yes_no","changeover_scheme_control","changeover_scheme_uv",
                              "chiller_plant_yes_no","chiller_plant_ahu","chiller_plant_chiller","escalator_yes_no",
                              "escalator_braking_system","escalator_control","lift_yes_no","lift_operation",
                              "hid_lamp_yes_no","hid_lamp_ballast","hid_lamp_add_on_protection","sensitive_machine_yes_no",
                              "sensitive_machine_mitigation","telecom_machine_yes_no","telecom_machine_server_or_computer",
                              "telecom_machine_peripherals","telecom_machine_harmonic_emission","air_conditioners_yes_no",
                              "air_conditioners_micb","air_conditioners_load_forecasting","air_conditioners_type",
                              "non_linear_load_yes_no","non_linear_load_harmonic_emission","renewable_energy_yes_no",
                              "renewable_energy_inverter_and_controls","renewable_energy_harmonic_emission",
                              "ev_charger_system_yes_no","ev_charger_system_ev_charger","ev_charger_system_smart_charging_system",
                              "ev_charger_system_harmonic_emission","created_by","created_time","last_updated_by","last_updated_time") 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ';

        try {
            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array($replySlipLoc,$schemeNo,$bmsYesNo,$bmsServerCentralComputer,$bmsDdc,
                $changeoverSchemeYesNo,$changeoverSchemeControl,$changeoverSchemeUv,
                $chillerPlantYesNo,$chillerPlantAhu,$chillerPlantChiller,
                $escalatorYesNo,$escalatorBrakingSystem,$escalatorControl,
                $liftYesNo,$liftOperation,$hidLampYesNo,$hidLampBallast,
                $hidLampAddOnProtection,$sensitiveMachineYesNo,$sensitiveMachineMitigation,
                $telecomMachineYesNo,$telecomMachineServerOrComputer,$telecomMachinePeripherals,
                $telecomMachineHarmonicEmission,$airConditionersYesNo,$airConditionersMicb,
                $airConditionersLoadForecasting,$airConditionersType,$nonLinearLoadYesNo,
                $nonLinearLoadHarmonicEmission,$renewableEnergyYesNo,$renewableEnergyInverterAndControls,
                $renewableEnergyHarmonicEmission,$evChargerSystemYesNo,$evChargerSystemEvCharger,
                $evChargerSystemSmartChargingSystem,$evChargerSystemHarmonicEmission,
                $createdBy,$createdTime,$lastUpdatedBy,$lastUpdatedTime));

            if ($result) {
                $sql = "SELECT \"reply_slip_id\" FROM \"tbl_slip_reply\" WHERE \"scheme_no\"=:scheme_no";

                $sth = Yii::app()->db->createCommand($sql);
                $sth->bindParam(':scheme_no', $schemeNo);
                $result = $sth->queryAll();

                foreach($result as $row) {
                    $replySlipId = $row['reply_slip_id'];
                }

                if (isset($replySlipId)) {
                    $sql = 'UPDATE "tbl_planning_ahead" SET "meeting_reply_slip_id"=?,  
                                "last_updated_by"=?, "last_updated_time"=?
                                WHERE "scheme_no"=?';
                    $stmt = Yii::app()->db->createCommand($sql);
                    $result = $stmt->execute(array($replySlipId,$lastUpdatedBy,$lastUpdatedTime,$schemeNo));

                } else {
                    $retJson['status'] = 'NOTOK';
                    $retJson['retMessage'] = 'Error in processing Scheme No [' . $schemeNo . ']';
                }
            }

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

        return $retJson;
    }

    public function updateReplySlip($replySlipId,$replySlipLoc,$bmsYesNo,$bmsServerCentralComputer,$bmsDdc,
                                 $changeoverSchemeYesNo,$changeoverSchemeControl,$changeoverSchemeUv,
                                 $chillerPlantYesNo,$chillerPlantAhu,$chillerPlantChiller,
                                 $escalatorYesNo,$escalatorBrakingSystem,$escalatorControl,
                                 $liftYesNo,$liftOperation,$hidLampYesNo,$hidLampBallast,
                                 $hidLampAddOnProtection,$sensitiveMachineYesNo,$sensitiveMachineMitigation,
                                 $telecomMachineYesNo,$telecomMachineServerOrComputer,$telecomMachinePeripherals,
                                 $telecomMachineHarmonicEmission,$airConditionersYesNo,$airConditionersMicb,
                                 $airConditionersLoadForecasting,$airConditionersType,$nonLinearLoadYesNo,
                                 $nonLinearLoadHarmonicEmission,$renewableEnergyYesNo,$renewableEnergyInverterAndControls,
                                 $renewableEnergyHarmonicEmission,$evChargerSystemYesNo,$evChargerSystemEvCharger,
                                 $evChargerSystemSmartChargingSystem,$evChargerSystemHarmonicEmission,
                                 $lastUpdatedBy,$lastUpdatedTime) {
        $sql = 'UPDATE "tbl_slip_reply" SET "reply_slip_loc"=?, "bms_yes_no"=?, "bms_server_central_computer"=?, 
                           "bms_ddc"=?, "changeover_scheme_yes_no"=?, "changeover_scheme_control"=?, 
                           "changeover_scheme_uv"=?, "chiller_plant_yes_no"=?, "chiller_plant_ahu"=?, 
                           "chiller_plant_chiller"=?, "escalator_yes_no"=?, "escalator_braking_system"=?, 
                           "escalator_control"=?, "lift_yes_no"=?, "lift_operation"=?, "hid_lamp_yes_no"=?,
                           "hid_lamp_ballast"=?, "hid_lamp_add_on_protection"=?, "sensitive_machine_yes_no"=?,
                           "sensitive_machine_mitigation"=?, "telecom_machine_yes_no"=?, "telecom_machine_server_or_computer"=?,
                           "telecom_machine_peripherals"=?, "telecom_machine_harmonic_emission"=?, "air_conditioners_yes_no"=?,
                           "air_conditioners_micb"=?, "air_conditioners_load_forecasting"=?, "air_conditioners_type"=?,
                           "non_linear_load_yes_no"=?, "non_linear_load_harmonic_emission"=?, "renewable_energy_yes_no"=?,
                           "renewable_energy_inverter_and_controls"=?, "renewable_energy_harmonic_emission"=?,
                           "ev_charger_system_yes_no"=?, "ev_charger_system_ev_charger"=?, 
                           "ev_charger_system_smart_charging_system"=?, "ev_charger_system_harmonic_emission"=?,
                           "last_updated_by"=?, "last_updated_time"=? WHERE "reply_slip_id"=?';

        try {
            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array($replySlipLoc,$bmsYesNo,$bmsServerCentralComputer,$bmsDdc,
                $changeoverSchemeYesNo,$changeoverSchemeControl,$changeoverSchemeUv,
                $chillerPlantYesNo,$chillerPlantAhu,$chillerPlantChiller,
                $escalatorYesNo,$escalatorBrakingSystem,$escalatorControl,
                $liftYesNo,$liftOperation,$hidLampYesNo,$hidLampBallast,
                $hidLampAddOnProtection,$sensitiveMachineYesNo,$sensitiveMachineMitigation,
                $telecomMachineYesNo,$telecomMachineServerOrComputer,$telecomMachinePeripherals,
                $telecomMachineHarmonicEmission,$airConditionersYesNo,$airConditionersMicb,
                $airConditionersLoadForecasting,$airConditionersType,$nonLinearLoadYesNo,
                $nonLinearLoadHarmonicEmission,$renewableEnergyYesNo,$renewableEnergyInverterAndControls,
                $renewableEnergyHarmonicEmission,$evChargerSystemYesNo,$evChargerSystemEvCharger,
                $evChargerSystemSmartChargingSystem,$evChargerSystemHarmonicEmission,
                $lastUpdatedBy,$lastUpdatedTime,$replySlipId));

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

        return $retJson;
    }

}

