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

            if (isset($result) && count($result)>0) {
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
                $record['firstConsultantCompany'] = Encoding::escapleAllCharacter($result[0]['first_consultant_company']);

                if (isset($record['firstConsultantCompany']) && trim($record['firstConsultantCompany']) != "") {
                    $consultantCompany = $this->getConsultantCompanyAddressInfo($record['firstConsultantCompany']);
                    if (isset($consultantCompany) && count($consultantCompany)>0) {
                        $record['firstConsultantCompanyAdd1'] = $consultantCompany[0]['addressLine1'];
                        $record['firstConsultantCompanyAdd2'] = $consultantCompany[0]['addressLine2'];
                        $record['firstConsultantCompanyAdd3'] = $consultantCompany[0]['addressLine3'];
                        $record['firstConsultantCompanyAdd4'] = $consultantCompany[0]['addressLine4'];
                    } else {
                        $record['firstConsultantCompanyAdd1'] = "";
                        $record['firstConsultantCompanyAdd2'] = "";
                        $record['firstConsultantCompanyAdd3'] = "";
                        $record['firstConsultantCompanyAdd4'] = "";
                    }
                }

                $record['firstConsultantPhone'] = Encoding::escapleAllCharacter($result[0]['first_consultant_phone']);
                $record['firstConsultantEmail'] = Encoding::escapleAllCharacter($result[0]['first_consultant_email']);
                $record['secondConsultantTitle'] = Encoding::escapleAllCharacter($result[0]['second_consultant_title']);
                $record['secondConsultantSurname'] = Encoding::escapleAllCharacter($result[0]['second_consultant_surname']);
                $record['secondConsultantOtherName'] = Encoding::escapleAllCharacter($result[0]['second_consultant_other_name']);
                $record['secondConsultantCompany'] = Encoding::escapleAllCharacter($result[0]['second_consultant_company']);
                $record['secondConsultantCompanyName'] = Encoding::escapleAllCharacter($result[0]['second_consultant_company']);
                $record['secondConsultantPhone'] = Encoding::escapleAllCharacter($result[0]['second_consultant_phone']);
                $record['secondConsultantEmail'] = Encoding::escapleAllCharacter($result[0]['second_consultant_email']);
                $record['thirdConsultantTitle'] = Encoding::escapleAllCharacter($result[0]['third_consultant_title']);
                $record['thirdConsultantSurname'] = Encoding::escapleAllCharacter($result[0]['third_consultant_surname']);
                $record['thirdConsultantOtherName'] = Encoding::escapleAllCharacter($result[0]['third_consultant_other_name']);
                $record['thirdConsultantCompany'] = Encoding::escapleAllCharacter($result[0]['third_consultant_company']);
                $record['thirdConsultantPhone'] = Encoding::escapleAllCharacter($result[0]['third_consultant_phone']);
                $record['thirdConsultantEmail'] = Encoding::escapleAllCharacter($result[0]['third_consultant_email']);
                $record['firstProjectOwnerTitle'] = Encoding::escapleAllCharacter($result[0]['first_project_owner_title']);
                $record['firstProjectOwnerSurname'] = Encoding::escapleAllCharacter($result[0]['first_project_owner_surname']);
                $record['firstProjectOwnerOtherName'] = Encoding::escapleAllCharacter($result[0]['first_project_owner_other_name']);
                $record['firstProjectOwnerCompany'] = Encoding::escapleAllCharacter($result[0]['first_project_owner_company']);
                $record['firstProjectOwnerPhone'] = Encoding::escapleAllCharacter($result[0]['first_project_owner_phone']);
                $record['firstProjectOwnerEmail'] = Encoding::escapleAllCharacter($result[0]['first_project_owner_email']);
                $record['secondProjectOwnerTitle'] = Encoding::escapleAllCharacter($result[0]['second_project_owner_title']);
                $record['secondProjectOwnerSurname'] = Encoding::escapleAllCharacter($result[0]['second_project_owner_surname']);
                $record['secondProjectOwnerOtherName'] = Encoding::escapleAllCharacter($result[0]['second_project_owner_other_name']);
                $record['secondProjectOwnerCompany'] = Encoding::escapleAllCharacter($result[0]['second_project_owner_company']);
                $record['secondProjectOwnerPhone'] = Encoding::escapleAllCharacter($result[0]['second_project_owner_phone']);
                $record['secondProjectOwnerEmail'] = Encoding::escapleAllCharacter($result[0]['second_project_owner_email']);
                $record['thirdProjectOwnerTitle'] = Encoding::escapleAllCharacter($result[0]['third_project_owner_title']);
                $record['thirdProjectOwnerSurname'] = Encoding::escapleAllCharacter($result[0]['third_project_owner_surname']);
                $record['thirdProjectOwnerOtherName'] = Encoding::escapleAllCharacter($result[0]['third_project_owner_other_name']);
                $record['thirdProjectOwnerCompany'] = Encoding::escapleAllCharacter($result[0]['third_project_owner_company']);
                $record['thirdProjectOwnerPhone'] = Encoding::escapleAllCharacter($result[0]['third_project_owner_phone']);
                $record['thirdProjectOwnerEmail'] = Encoding::escapleAllCharacter($result[0]['third_project_owner_email']);
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
                $record['meetingRemark'] = $result[0]['meeting_remark'];
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
                    $record['replySlipChillerPlantAhuControl'] = Encoding::escapleAllCharacter($item['replySlipChillerPlantAhuControl']);
                    $record['replySlipChillerPlantAhuStartup'] = Encoding::escapleAllCharacter($item['replySlipChillerPlantAhuStartup']);
                    $record['replySlipChillerPlantVsd'] = Encoding::escapleAllCharacter($item['replySlipChillerPlantVsd']);
                    $record['replySlipChillerPlantAhuChilledWater'] = Encoding::escapleAllCharacter($item['replySlipChillerPlantAhuChilledWater']);
                    $record['replySlipChillerPlantStandbyAhu'] = Encoding::escapleAllCharacter($item['replySlipChillerPlantStandbyAhu']);
                    $record['replySlipChillerPlantChiller'] = Encoding::escapleAllCharacter($item['replySlipChillerPlantChiller']);
                    $record['replySlipEscalatorYesNo'] = Encoding::escapleAllCharacter($item['replySlipEscalatorYesNo']);
                    $record['replySlipEscalatorMotorStartup'] = Encoding::escapleAllCharacter($item['replySlipEscalatorMotorStartup']);
                    $record['replySlipEscalatorVsdMitigation'] = Encoding::escapleAllCharacter($item['replySlipEscalatorVsdMitigation']);
                    $record['replySlipEscalatorBrakingSystem'] = Encoding::escapleAllCharacter($item['replySlipEscalatorBrakingSystem']);
                    $record['replySlipEscalatorControl'] = Encoding::escapleAllCharacter($item['replySlipEscalatorControl']);
                    $record['replySlipHidLampYesNo'] = Encoding::escapleAllCharacter($item['replySlipHidLampYesNo']);
                    $record['replySlipHidLampMitigation'] = Encoding::escapleAllCharacter($item['replySlipHidLampMitigation']);
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
                    $record['replySlipEvControlYesNo'] = Encoding::escapleAllCharacter($item['replySlipEvControlYesNo']);
                    $record['replySlipEvChargerSystemEvCharger'] = Encoding::escapleAllCharacter($item['replySlipEvChargerSystemEvCharger']);
                    $record['replySlipEvChargerSystemSmartYesNo'] = Encoding::escapleAllCharacter($item['replySlipEvChargerSystemSmartYesNo']);
                    $record['replySlipEvChargerSystemSmartChargingSystem'] = Encoding::escapleAllCharacter($item['replySlipEvChargerSystemSmartChargingSystem']);
                    $record['replySlipEvChargerSystemHarmonicEmission'] = Encoding::escapleAllCharacter($item['replySlipEvChargerSystemHarmonicEmission']);
                    $record['replySlipConsultantNameConfirmation'] = Encoding::escapleAllCharacter($item['replySlipConsultantNameConfirmation']);
                    $record['replySlipConsultantCompany'] = Encoding::escapleAllCharacter($item['replySlipConsultantCompany']);
                    $record['replySlipProjectOwnerNameConfirmation'] = Encoding::escapleAllCharacter($item['replySlipProjectOwnerNameConfirmation']);
                    $record['replySlipProjectOwnerCompany'] = Encoding::escapleAllCharacter($item['replySlipProjectOwnerCompany']);
                    $record['replySlipLastUploadTime'] = Encoding::escapleAllCharacter($item['replySlipLastUploadTime']);
                } else {
                    $record['replySlipBmsYesNo'] = "";
                    $record['replySlipBmsServerCentralComputer'] = "";
                    $record['replySlipBmsDdc'] = "";
                    $record['replySlipChangeoverSchemeYesNo'] = "";
                    $record['replySlipChangeoverSchemeControl'] = "";
                    $record['replySlipChangeoverSchemeUv'] = "";
                    $record['replySlipChillerPlantYesNo'] = "";
                    $record['replySlipChillerPlantAhuControl'] = "";
                    $record['replySlipChillerPlantAhuStartup'] = "";
                    $record['replySlipChillerPlantVsd'] = "";
                    $record['replySlipChillerPlantAhuChilledWater'] = "";
                    $record['replySlipChillerPlantStandbyAhu'] = "";
                    $record['replySlipChillerPlantChiller'] = "";
                    $record['replySlipEscalatorYesNo'] = "";
                    $record['replySlipEscalatorMotorStartup'] = "";
                    $record['replySlipEscalatorVsdMitigation'] = "";
                    $record['replySlipEscalatorBrakingSystem'] = "";
                    $record['replySlipEscalatorControl'] = "";
                    $record['replySlipHidLampYesNo'] = "";
                    $record['replySlipHidLampMitigation'] = "";
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
                    $record['replySlipEvControlYesNo'] = "";
                    $record['replySlipEvChargerSystemEvCharger'] = "";
                    $record['replySlipEvChargerSystemSmartYesNo'] = "";
                    $record['replySlipEvChargerSystemSmartChargingSystem'] = "";
                    $record['replySlipEvChargerSystemHarmonicEmission'] = "";
                    $record['replySlipConsultantNameConfirmation'] = "";
                    $record['replySlipConsultantCompany'] = "";
                    $record['replySlipProjectOwnerNameConfirmation'] = "";
                    $record['replySlipProjectOwnerCompany'] = "";
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

                if (isset($record['evaReportId']) && ($record['evaReportId'] > 0)) {

                    $sql = 'SELECT * FROM "tbl_evaluation_report" 
                        WHERE "evaluation_report_id" = :evaluationReportId';
                    $sth = Yii::app()->db->createCommand($sql);
                    $sth->bindParam(':evaluationReportId', $record['evaReportId']);
                    $evaRecord = $sth->queryAll();

                    $record['evaReportRemark'] = Encoding::escapleAllCharacter($evaRecord[0]['evaluation_report_remark']);
                    $record['evaReportEdmsLink'] = Encoding::escapleAllCharacter($evaRecord[0]['evaluation_report_edms_link']);

                    if (isset($evaRecord[0]['evaluation_report_issue_date'])) {
                        $evaReportIssueDateYear = date("Y", strtotime($evaRecord[0]['evaluation_report_issue_date']));
                        $evaReportIssueDateMonth = date("m", strtotime($evaRecord[0]['evaluation_report_issue_date']));
                        $evaReportIssueDateDay = date("d", strtotime($evaRecord[0]['evaluation_report_issue_date']));
                        $record['evaReportIssueDate'] = $evaReportIssueDateYear . "-" . $evaReportIssueDateMonth . "-" . $evaReportIssueDateDay;
                    } else {
                        $record['evaReportIssueDate'] = "";
                    }
                    $record['evaReportFaxRefNo'] = Encoding::escapleAllCharacter($evaRecord[0]['evaluation_report_fax_ref_no']);
                    $record['evaReportScore'] = $evaRecord[0]['evaluation_report_score'];
                    $record['evaReportBmsYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_yes_no']);
                    $record['evaReportBmsServerCentralComputerYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_server_central_computer_yes_no']);
                    $record['evaReportBmsServerCentralComputerFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_server_central_computer_finding']);
                    $record['evaReportBmsServerCentralComputerRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_server_central_computer_recommend']);
                    $record['evaReportBmsServerCentralComputerPass'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_server_central_computer_pass']);
                    $record['evaReportBmsDdcYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_ddc_yes_no']);
                    $record['evaReportBmsDdcFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_ddc_finding']);
                    $record['evaReportBmsDdcRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_ddc_recommend']);
                    $record['evaReportBmsDdcPass'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_ddc_pass']);
                    $record['evaReportBmsSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_supplement_yes_no']);
                    $record['evaReportBmsSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_supplement']);
                    $record['evaReportBmsSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_supplement_pass']);
                    $record['evaReportChangeoverSchemeYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_yes_no']);
                    $record['evaReportChangeoverSchemeControlYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_control_yes_no']);
                    $record['evaReportChangeoverSchemeControlFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_control_finding']);
                    $record['evaReportChangeoverSchemeControlRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_control_recommend']);
                    $record['evaReportChangeoverSchemeControlPass'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_control_pass']);
                    $record['evaReportChangeoverSchemeUvYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_uv_yes_no']);
                    $record['evaReportChangeoverSchemeUvFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_uv_finding']);
                    $record['evaReportChangeoverSchemeUvRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_uv_recommend']);
                    $record['evaReportChangeoverSchemeUvPass'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_uv_pass']);
                    $record['evaReportChangeoverSchemeSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_supplement_yes_no']);
                    $record['evaReportChangeoverSchemeSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_supplement']);
                    $record['evaReportChangeoverSchemeSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_supplement_pass']);
                    $record['evaReportChillerPlantYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_yes_no']);
                    $record['evaReportChillerPlantAhuChilledWaterYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_ahu_chilled_water_yes_no']);
                    $record['evaReportChillerPlantAhuChilledWaterFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_ahu_chilled_water_finding']);
                    $record['evaReportChillerPlantAhuChilledWaterRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_ahu_chilled_water_recommend']);
                    $record['evaReportChillerPlantAhuChilledWaterPass'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_ahu_chilled_water_pass']);
                    $record['evaReportChillerPlantChillerYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_chiller_yes_no']);
                    $record['evaReportChillerPlantChillerFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_chiller_finding']);
                    $record['evaReportChillerPlantChillerRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_chiller_recommend']);
                    $record['evaReportChillerPlantChillerPass'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_chiller_pass']);
                    $record['evaReportChillerPlantSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_supplement_yes_no']);
                    $record['evaReportChillerPlantSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_supplement']);
                    $record['evaReportChillerPlantSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_supplement_pass']);
                    $record['evaReportEscalatorYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_yes_no']);
                    $record['evaReportEscalatorBrakingSystemYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_braking_system_yes_no']);
                    $record['evaReportEscalatorBrakingSystemFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_braking_system_finding']);
                    $record['evaReportEscalatorBrakingSystemRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_braking_system_recommend']);
                    $record['evaReportEscalatorBrakingSystemPass'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_braking_system_pass']);
                    $record['evaReportEscalatorControlYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_control_yes_no']);
                    $record['evaReportEscalatorControlFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_control_finding']);
                    $record['evaReportEscalatorControlRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_control_recommend']);
                    $record['evaReportEscalatorControlPass'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_control_pass']);
                    $record['evaReportEscalatorSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_supplement_yes_no']);
                    $record['evaReportEscalatorSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_supplement']);
                    $record['evaReportEscalatorSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_supplement_pass']);
                    $record['evaReportLiftYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_yes_no']);
                    $record['evaReportLiftOperationYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_operation_yes_no']);
                    $record['evaReportLiftOperationFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_operation_finding']);
                    $record['evaReportLiftOperationRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_operation_recommend']);
                    $record['evaReportLiftOperationPass'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_operation_pass']);
                    $record['evaReportLiftMainSupplyYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_main_supply_yes_no']);
                    $record['evaReportLiftMainSupplyFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_main_supply_finding']);
                    $record['evaReportLiftMainSupplyRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_main_supply_recommend']);
                    $record['evaReportLiftMainSupplyPass'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_main_supply_pass']);
                    $record['evaReportLiftSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_supplement_yes_no']);
                    $record['evaReportLiftSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_supplement']);
                    $record['evaReportLiftSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_supplement_pass']);
                    $record['evaReportHidLampYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_yes_no']);
                    $record['evaReportHidLampBallastYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_ballast_yes_no']);
                    $record['evaReportHidLampBallastFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_ballast_finding']);
                    $record['evaReportHidLampBallastRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_ballast_recommend']);
                    $record['evaReportHidLampBallastPass'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_ballast_pass']);
                    $record['evaReportHidLampAddonProtectYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_addon_protect_yes_no']);
                    $record['evaReportHidLampAddonProtectFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_addon_protect_finding']);
                    $record['evaReportHidLampAddonProtectRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_addon_protect_recommend']);
                    $record['evaReportHidLampAddonProtectPass'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_addon_protect_pass']);
                    $record['evaReportHidLampSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_supplement_yes_no']);
                    $record['evaReportHidLampSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_supplement']);
                    $record['evaReportHidLampSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_supplement_pass']);
                    $record['evaReportSensitiveMachineYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['sensitive_machine_yes_no']);
                    $record['evaReportSensitiveMachineMedicalYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['sensitive_machine_medical_yes_no']);
                    $record['evaReportSensitiveMachineMedicalFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['sensitive_machine_medical_finding']);
                    $record['evaReportSensitiveMachineMedicalRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['sensitive_machine_medical_recommend']);
                    $record['evaReportSensitiveMachineMedicalPass'] = Encoding::escapleAllCharacter($evaRecord[0]['sensitive_machine_medical_pass']);
                    $record['evaReportSensitiveMachineSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['sensitive_machine_supplement_yes_no']);
                    $record['evaReportSensitiveMachineSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['sensitive_machine_supplement']);
                    $record['evaReportSensitiveMachineSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['sensitive_machine_supplement_pass']);
                    $record['evaReportTelecomMachineYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_yes_no']);
                    $record['evaReportTelecomMachineServerOrComputerYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_server_or_computer_yes_no']);
                    $record['evaReportTelecomMachineServerOrComputerFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_server_or_computer_finding']);
                    $record['evaReportTelecomMachineServerOrComputerRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_server_or_computer_recommend']);
                    $record['evaReportTelecomMachineServerOrComputerPass'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_server_or_computer_pass']);
                    $record['evaReportTelecomMachinePeripheralsYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_peripherals_yes_no']);
                    $record['evaReportTelecomMachinePeripheralsFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_peripherals_finding']);
                    $record['evaReportTelecomMachinePeripheralsRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_peripherals_recommend']);
                    $record['evaReportTelecomMachinePeripheralsPass'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_peripherals_pass']);
                    $record['evaReportTelecomMachineHarmonicEmissionYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_harmonic_emission_yes_no']);
                    $record['evaReportTelecomMachineHarmonicEmissionFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_harmonic_emission_finding']);
                    $record['evaReportTelecomMachineHarmonicEmissionRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_harmonic_emission_recommend']);
                    $record['evaReportTelecomMachineHarmonicEmissionPass'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_harmonic_emission_pass']);
                    $record['evaReportTelecomMachineSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_supplement_yes_no']);
                    $record['evaReportTelecomMachineSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_supplement']);
                    $record['evaReportTelecomMachineSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_supplement_pass']);
                    $record['evaReportAirConditionersYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_yes_no']);
                    $record['evaReportAirConditionersMicbYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_micb_yes_no']);
                    $record['evaReportAirConditionersMicbFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_micb_finding']);
                    $record['evaReportAirConditionersMicbRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_micb_recommend']);
                    $record['evaReportAirConditionersMicbPass'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_micb_pass']);
                    $record['evaReportAirConditionersLoadForecastingYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_load_forecasting_yes_no']);
                    $record['evaReportAirConditionersLoadForecastingFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_load_forecasting_finding']);
                    $record['evaReportAirConditionersLoadForecastingRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_load_forecasting_recommend']);
                    $record['evaReportAirConditionersLoadForecastingPass'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_load_forecasting_pass']);
                    $record['evaReportAirConditionersTypeYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_type_yes_no']);
                    $record['evaReportAirConditionersTypeFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_type_finding']);
                    $record['evaReportAirConditionersTypeRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_type_recommend']);
                    $record['evaReportAirConditionersTypePass'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_type_pass']);
                    $record['evaReportAirConditionersSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_supplement_yes_no']);
                    $record['evaReportAirConditionersSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_supplement']);
                    $record['evaReportAirConditionersSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_supplement_pass']);
                    $record['evaReportNonLinearLoadYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['non_linear_load_yes_no']);
                    $record['evaReportNonLinearLoadHarmonicEmissionYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['non_linear_load_harmonic_emission_yes_no']);
                    $record['evaReportNonLinearLoadHarmonicEmissionFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['non_linear_load_harmonic_emission_finding']);
                    $record['evaReportNonLinearLoadHarmonicEmissionRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['non_linear_load_harmonic_emission_recommend']);
                    $record['evaReportNonLinearLoadHarmonicEmissionPass'] = Encoding::escapleAllCharacter($evaRecord[0]['non_linear_load_harmonic_emission_pass']);
                    $record['evaReportNonLinearLoadSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['non_linear_load_supplement_yes_no']);
                    $record['evaReportNonLinearLoadSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['non_linear_load_supplement']);
                    $record['evaReportNonLinearLoadSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['non_linear_load_supplement_pass']);
                    $record['evaReportRenewableEnergyYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_yes_no']);
                    $record['evaReportRenewableEnergyInverterAndControlsYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_inverter_and_controls_yes_no']);
                    $record['evaReportRenewableEnergyInverterAndControlsFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_inverter_and_controls_finding']);
                    $record['evaReportRenewableEnergyInverterAndControlsRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_inverter_and_controls_recommend']);
                    $record['evaReportRenewableEnergyInverterAndControlsPass'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_inverter_and_controls_pass']);
                    $record['evaReportRenewableEnergyHarmonicEmissionYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_harmonic_emission_yes_no']);
                    $record['evaReportRenewableEnergyHarmonicEmissionFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_harmonic_emission_finding']);
                    $record['evaReportRenewableEnergyHarmonicEmissionRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_harmonic_emission_recommend']);
                    $record['evaReportRenewableEnergyHarmonicEmissionPass'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_harmonic_emission_pass']);
                    $record['evaReportRenewableEnergySupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_supplement_yes_no']);
                    $record['evaReportRenewableEnergySupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_supplement']);
                    $record['evaReportRenewableEnergySupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_supplement_pass']);
                    $record['evaReportEvChargerSystemYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_yes_no']);
                    $record['evaReportEvChargerSystemEvChargerYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_ev_charger_yes_no']);
                    $record['evaReportEvChargerSystemEvChargerFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_ev_charger_finding']);
                    $record['evaReportEvChargerSystemEvChargerRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_ev_charger_recommend']);
                    $record['evaReportEvChargerSystemEvChargerPass'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_ev_charger_pass']);
                    $record['evaReportEvChargerSystemHarmonicEmissionYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_harmonic_emission_yes_no']);
                    $record['evaReportEvChargerSystemHarmonicEmissionFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_harmonic_emission_finding']);
                    $record['evaReportEvChargerSystemHarmonicEmissionRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_harmonic_emission_recommend']);
                    $record['evaReportEvChargerSystemHarmonicEmissionPass'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_harmonic_emission_pass']);
                    $record['evaReportEvChargerSystemSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_supplement_yes_no']);
                    $record['evaReportEvChargerSystemSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_supplement']);
                    $record['evaReportEvChargerSystemSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_supplement_pass']);
                } else {
                    $record['evaReportRemark'] = "";
                    $record['evaReportEdmsLink'] = "";
                    $record['evaReportIssueDate'] = "";
                    $record['evaReportFaxRefNo'] = "";
                    $record['evaReportScore'] = "";
                    $record['evaReportBmsYesNo'] = "";
                    $record['evaReportBmsServerCentralComputerYesNo'] = "";
                    $record['evaReportBmsServerCentralComputerFinding'] = "";
                    $record['evaReportBmsServerCentralComputerRecommend'] = "";
                    $record['evaReportBmsServerCentralComputerPass'] = "";
                    $record['evaReportBmsDdcYesNo'] = "";
                    $record['evaReportBmsDdcFinding'] = "";
                    $record['evaReportBmsDdcRecommend'] = "";
                    $record['evaReportBmsDdcPass'] = "";
                    $record['evaReportBmsSupplementYesNo'] = "";
                    $record['evaReportBmsSupplement'] = "";
                    $record['evaReportBmsSupplementPass'] = "";
                    $record['evaReportChangeoverSchemeYesNo'] = "";
                    $record['evaReportChangeoverSchemeControlYesNo'] = "";
                    $record['evaReportChangeoverSchemeControlFinding'] = "";
                    $record['evaReportChangeoverSchemeControlRecommend'] = "";
                    $record['evaReportChangeoverSchemeControlPass'] = "";
                    $record['evaReportChangeoverSchemeUvYesNo'] = "";
                    $record['evaReportChangeoverSchemeUvFinding'] = "";
                    $record['evaReportChangeoverSchemeUvRecommend'] = "";
                    $record['evaReportChangeoverSchemeUvPass'] = "";
                    $record['evaReportChangeoverSchemeSupplementYesNo'] = "";
                    $record['evaReportChangeoverSchemeSupplement'] = "";
                    $record['evaReportChangeoverSchemeSupplementPass'] = "";
                    $record['evaReportChillerPlantYesNo'] = "";
                    $record['evaReportChillerPlantAhuChilledWaterYesNo'] = "";
                    $record['evaReportChillerPlantAhuChilledWaterFinding'] = "";
                    $record['evaReportChillerPlantAhuChilledWaterRecommend'] = "";
                    $record['evaReportChillerPlantAhuChilledWaterPass'] = "";
                    $record['evaReportChillerPlantChillerYesNo'] = "";
                    $record['evaReportChillerPlantChillerFinding'] = "";
                    $record['evaReportChillerPlantChillerRecommend'] = "";
                    $record['evaReportChillerPlantChillerPass'] = "";
                    $record['evaReportChillerPlantSupplementYesNo'] = "";
                    $record['evaReportChillerPlantSupplement'] = "";
                    $record['evaReportChillerPlantSupplementPass'] = "";
                    $record['evaReportEscalatorYesNo'] = "";
                    $record['evaReportEscalatorBrakingSystemYesNo'] = "";
                    $record['evaReportEscalatorBrakingSystemFinding'] = "";
                    $record['evaReportEscalatorBrakingSystemRecommend'] = "";
                    $record['evaReportEscalatorBrakingSystemPass'] = "";
                    $record['evaReportEscalatorControlYesNo'] = "";
                    $record['evaReportEscalatorControlFinding'] = "";
                    $record['evaReportEscalatorControlRecommend'] = "";
                    $record['evaReportEscalatorControlPass'] = "";
                    $record['evaReportEscalatorSupplementYesNo'] = "";
                    $record['evaReportEscalatorSupplement'] = "";
                    $record['evaReportEscalatorSupplementPass'] = "";
                    $record['evaReportLiftYesNo'] = "";
                    $record['evaReportLiftOperationYesNo'] = "";
                    $record['evaReportLiftOperationFinding'] = "";
                    $record['evaReportLiftOperationRecommend'] = "";
                    $record['evaReportLiftOperationPass'] = "";
                    $record['evaReportLiftMainSupplyYesNo'] = "";
                    $record['evaReportLiftMainSupplyFinding'] = "";
                    $record['evaReportLiftMainSupplyRecommend'] = "";
                    $record['evaReportLiftMainSupplyPass'] = "";
                    $record['evaReportLiftSupplementYesNo'] = "";
                    $record['evaReportLiftSupplement'] = "";
                    $record['evaReportLiftSupplementPass'] = "";
                    $record['evaReportHidLampYesNo'] = "";
                    $record['evaReportHidLampBallastYesNo'] = "";
                    $record['evaReportHidLampBallastFinding'] = "";
                    $record['evaReportHidLampBallastRecommend'] = "";
                    $record['evaReportHidLampBallastPass'] = "";
                    $record['evaReportHidLampAddonProtectYesNo'] = "";
                    $record['evaReportHidLampAddonProtectFinding'] = "";
                    $record['evaReportHidLampAddonProtectRecommend'] = "";
                    $record['evaReportHidLampAddonProtectPass'] = "";
                    $record['evaReportHidLampSupplementYesNo'] = "";
                    $record['evaReportHidLampSupplement'] = "";
                    $record['evaReportHidLampSupplementPass'] = "";
                    $record['evaReportSensitiveMachineYesNo'] = "";
                    $record['evaReportSensitiveMachineMedicalYesNo'] = "";
                    $record['evaReportSensitiveMachineMedicalFinding'] = "";
                    $record['evaReportSensitiveMachineMedicalRecommend'] = "";
                    $record['evaReportSensitiveMachineMedicalPass'] = "";
                    $record['evaReportSensitiveMachineSupplementYesNo'] = "";
                    $record['evaReportSensitiveMachineSupplement'] = "";
                    $record['evaReportSensitiveMachineSupplementPass'] = "";
                    $record['evaReportTelecomMachineYesNo'] = "";
                    $record['evaReportTelecomMachineServerOrComputerYesNo'] = "";
                    $record['evaReportTelecomMachineServerOrComputerFinding'] = "";
                    $record['evaReportTelecomMachineServerOrComputerRecommend'] = "";
                    $record['evaReportTelecomMachineServerOrComputerPass'] = "";
                    $record['evaReportTelecomMachinePeripheralsYesNo'] = "";
                    $record['evaReportTelecomMachinePeripheralsFinding'] = "";
                    $record['evaReportTelecomMachinePeripheralsRecommend'] = "";
                    $record['evaReportTelecomMachinePeripheralsPass'] = "";
                    $record['evaReportTelecomMachineHarmonicEmissionYesNo'] = "";
                    $record['evaReportTelecomMachineHarmonicEmissionFinding'] = "";
                    $record['evaReportTelecomMachineHarmonicEmissionRecommend'] = "";
                    $record['evaReportTelecomMachineHarmonicEmissionPass'] = "";
                    $record['evaReportTelecomMachineSupplementYesNo'] = "";
                    $record['evaReportTelecomMachineSupplement'] = "";
                    $record['evaReportTelecomMachineSupplementPass'] = "";
                    $record['evaReportAirConditionersYesNo'] = "";
                    $record['evaReportAirConditionersMicbYesNo'] = "";
                    $record['evaReportAirConditionersMicbFinding'] = "";
                    $record['evaReportAirConditionersMicbRecommend'] = "";
                    $record['evaReportAirConditionersMicbPass'] = "";
                    $record['evaReportAirConditionersLoadForecastingYesNo'] = "";
                    $record['evaReportAirConditionersLoadForecastingFinding'] = "";
                    $record['evaReportAirConditionersLoadForecastingRecommend'] = "";
                    $record['evaReportAirConditionersLoadForecastingPass'] = "";
                    $record['evaReportAirConditionersTypeYesNo'] = "";
                    $record['evaReportAirConditionersTypeFinding'] = "";
                    $record['evaReportAirConditionersTypeRecommend'] = "";
                    $record['evaReportAirConditionersTypePass'] = "";
                    $record['evaReportAirConditionersSupplementYesNo'] = "";
                    $record['evaReportAirConditionersSupplement'] = "";
                    $record['evaReportAirConditionersSupplementPass'] = "";
                    $record['evaReportNonLinearLoadYesNo'] = "";
                    $record['evaReportNonLinearLoadHarmonicEmissionYesNo'] = "";
                    $record['evaReportNonLinearLoadHarmonicEmissionFinding'] = "";
                    $record['evaReportNonLinearLoadHarmonicEmissionRecommend'] = "";
                    $record['evaReportNonLinearLoadHarmonicEmissionPass'] = "";
                    $record['evaReportNonLinearLoadSupplementYesNo'] = "";
                    $record['evaReportNonLinearLoadSupplement'] = "";
                    $record['evaReportNonLinearLoadSupplementPass'] = "";
                    $record['evaReportRenewableEnergyYesNo'] = "";
                    $record['evaReportRenewableEnergyInverterAndControlsYesNo'] = "";
                    $record['evaReportRenewableEnergyInverterAndControlsFinding'] = "";
                    $record['evaReportRenewableEnergyInverterAndControlsRecommend'] = "";
                    $record['evaReportRenewableEnergyInverterAndControlsPass'] = "";
                    $record['evaReportRenewableEnergyHarmonicEmissionYesNo'] = "";
                    $record['evaReportRenewableEnergyHarmonicEmissionFinding'] = "";
                    $record['evaReportRenewableEnergyHarmonicEmissionRecommend'] = "";
                    $record['evaReportRenewableEnergyHarmonicEmissionPass'] = "";
                    $record['evaReportRenewableEnergySupplementYesNo'] = "";
                    $record['evaReportRenewableEnergySupplement'] = "";
                    $record['evaReportRenewableEnergySupplementPass'] = "";
                    $record['evaReportEvChargerSystemYesNo'] = "";
                    $record['evaReportEvChargerSystemEvChargerYesNo'] = "";
                    $record['evaReportEvChargerSystemEvChargerFinding'] = "";
                    $record['evaReportEvChargerSystemEvChargerRecommend'] = "";
                    $record['evaReportEvChargerSystemEvChargerPass'] = "";
                    $record['evaReportEvChargerSystemHarmonicEmissionYesNo'] = "";
                    $record['evaReportEvChargerSystemHarmonicEmissionFinding'] = "";
                    $record['evaReportEvChargerSystemHarmonicEmissionRecommend'] = "";
                    $record['evaReportEvChargerSystemHarmonicEmissionPass'] = "";
                    $record['evaReportEvChargerSystemSupplementYesNo'] = "";
                    $record['evaReportEvChargerSystemSupplement'] = "";
                    $record['evaReportEvChargerSystemSupplementPass'] = "";
                }

                $record['reEvaReportId'] = $result[0]['re_eva_report_id'];

                if (isset($record['reEvaReportId']) && ($record['reEvaReportId'] > 0)) {

                    $sql = 'SELECT * FROM "tbl_evaluation_report" 
                        WHERE "evaluation_report_id" = :evaluationReportId';
                    $sth = Yii::app()->db->createCommand($sql);
                    $sth->bindParam(':evaluationReportId', $record['reEvaReportId']);
                    $evaRecord = $sth->queryAll();

                    $record['reEvaReportRemark'] = Encoding::escapleAllCharacter($evaRecord[0]['evaluation_report_remark']);
                    $record['reEvaReportEdmsLink'] = Encoding::escapleAllCharacter($evaRecord[0]['evaluation_report_edms_link']);

                    if (isset($evaRecord[0]['evaluation_report_issue_date'])) {
                        $reEvaReportIssueDateYear = date("Y", strtotime($evaRecord[0]['evaluation_report_issue_date']));
                        $reEvaReportIssueDateMonth = date("m", strtotime($evaRecord[0]['evaluation_report_issue_date']));
                        $reEvaReportIssueDateDay = date("d", strtotime($evaRecord[0]['evaluation_report_issue_date']));
                        $record['reEvaReportIssueDate'] = $reEvaReportIssueDateYear . "-" . $reEvaReportIssueDateMonth . "-" . $reEvaReportIssueDateDay;
                    } else {
                        $record['reEvaReportIssueDate'] = "";
                    }
                    $record['reEvaReportFaxRefNo'] = Encoding::escapleAllCharacter($evaRecord[0]['evaluation_report_fax_ref_no']);
                    $record['reEvaReportScore'] = $evaRecord[0]['evaluation_report_score'];
                    $record['reEvaReportBmsYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_yes_no']);
                    $record['reEvaReportBmsServerCentralComputerYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_server_central_computer_yes_no']);
                    $record['reEvaReportBmsServerCentralComputerFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_server_central_computer_finding']);
                    $record['reEvaReportBmsServerCentralComputerRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_server_central_computer_recommend']);
                    $record['reEvaReportBmsServerCentralComputerPass'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_server_central_computer_pass']);
                    $record['reEvaReportBmsDdcYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_ddc_yes_no']);
                    $record['reEvaReportBmsDdcFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_ddc_finding']);
                    $record['reEvaReportBmsDdcRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_ddc_recommend']);
                    $record['reEvaReportBmsDdcPass'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_ddc_pass']);
                    $record['reEvaReportBmsSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_supplement_yes_no']);
                    $record['reEvaReportBmsSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_supplement']);
                    $record['reEvaReportBmsSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['bms_supplement_pass']);
                    $record['reEvaReportChangeoverSchemeYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_yes_no']);
                    $record['reEvaReportChangeoverSchemeControlYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_control_yes_no']);
                    $record['reEvaReportChangeoverSchemeControlFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_control_finding']);
                    $record['reEvaReportChangeoverSchemeControlRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_control_recommend']);
                    $record['reEvaReportChangeoverSchemeControlPass'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_control_pass']);
                    $record['reEvaReportChangeoverSchemeUvYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_uv_yes_no']);
                    $record['reEvaReportChangeoverSchemeUvFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_uv_finding']);
                    $record['reEvaReportChangeoverSchemeUvRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_uv_recommend']);
                    $record['reEvaReportChangeoverSchemeUvPass'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_uv_pass']);
                    $record['reEvaReportChangeoverSchemeSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_supplement_yes_no']);
                    $record['reEvaReportChangeoverSchemeSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_supplement']);
                    $record['reEvaReportChangeoverSchemeSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['changeover_scheme_supplement_pass']);
                    $record['reEvaReportChillerPlantYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_yes_no']);
                    $record['reEvaReportChillerPlantAhuChilledWaterYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_ahu_chilled_water_yes_no']);
                    $record['reEvaReportChillerPlantAhuChilledWaterFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_ahu_chilled_water_finding']);
                    $record['reEvaReportChillerPlantAhuChilledWaterRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_ahu_chilled_water_recommend']);
                    $record['reEvaReportChillerPlantAhuChilledWaterPass'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_ahu_chilled_water_pass']);
                    $record['reEvaReportChillerPlantChillerYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_chiller_yes_no']);
                    $record['reEvaReportChillerPlantChillerFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_chiller_finding']);
                    $record['reEvaReportChillerPlantChillerRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_chiller_recommend']);
                    $record['reEvaReportChillerPlantChillerPass'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_chiller_pass']);
                    $record['reEvaReportChillerPlantSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_supplement_yes_no']);
                    $record['reEvaReportChillerPlantSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_supplement']);
                    $record['reEvaReportChillerPlantSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['chiller_plant_supplement_pass']);
                    $record['reEvaReportEscalatorYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_yes_no']);
                    $record['reEvaReportEscalatorBrakingSystemYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_braking_system_yes_no']);
                    $record['reEvaReportEscalatorBrakingSystemFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_braking_system_finding']);
                    $record['reEvaReportEscalatorBrakingSystemRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_braking_system_recommend']);
                    $record['reEvaReportEscalatorBrakingSystemPass'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_braking_system_pass']);
                    $record['reEvaReportEscalatorControlYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_control_yes_no']);
                    $record['reEvaReportEscalatorControlFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_control_finding']);
                    $record['reEvaReportEscalatorControlRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_control_recommend']);
                    $record['reEvaReportEscalatorControlPass'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_control_pass']);
                    $record['reEvaReportEscalatorSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_supplement_yes_no']);
                    $record['reEvaReportEscalatorSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_supplement']);
                    $record['reEvaReportEscalatorSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['escalator_supplement_pass']);
                    $record['reEvaReportLiftYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_yes_no']);
                    $record['reEvaReportLiftOperationYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_operation_yes_no']);
                    $record['reEvaReportLiftOperationFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_operation_finding']);
                    $record['reEvaReportLiftOperationRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_operation_recommend']);
                    $record['reEvaReportLiftOperationPass'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_operation_pass']);
                    $record['reEvaReportLiftMainSupplyYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_main_supply_yes_no']);
                    $record['reEvaReportLiftMainSupplyFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_main_supply_finding']);
                    $record['reEvaReportLiftMainSupplyRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_main_supply_recommend']);
                    $record['reEvaReportLiftMainSupplyPass'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_main_supply_pass']);
                    $record['reEvaReportLiftSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_supplement_yes_no']);
                    $record['reEvaReportLiftSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_supplement']);
                    $record['reEvaReportLiftSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['lift_supplement_pass']);
                    $record['reEvaReportHidLampYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_yes_no']);
                    $record['reEvaReportHidLampBallastYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_ballast_yes_no']);
                    $record['reEvaReportHidLampBallastFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_ballast_finding']);
                    $record['reEvaReportHidLampBallastRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_ballast_recommend']);
                    $record['reEvaReportHidLampBallastPass'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_ballast_pass']);
                    $record['reEvaReportHidLampAddonProtectYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_addon_protect_yes_no']);
                    $record['reEvaReportHidLampAddonProtectFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_addon_protect_finding']);
                    $record['reEvaReportHidLampAddonProtectRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_addon_protect_recommend']);
                    $record['reEvaReportHidLampAddonProtectPass'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_addon_protect_pass']);
                    $record['reEvaReportHidLampSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_supplement_yes_no']);
                    $record['reEvaReportHidLampSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_supplement']);
                    $record['reEvaReportHidLampSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['hid_lamp_supplement_pass']);
                    $record['reEvaReportSensitiveMachineYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['sensitive_machine_yes_no']);
                    $record['reEvaReportSensitiveMachineMedicalYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['sensitive_machine_medical_yes_no']);
                    $record['reEvaReportSensitiveMachineMedicalFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['sensitive_machine_medical_finding']);
                    $record['reEvaReportSensitiveMachineMedicalRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['sensitive_machine_medical_recommend']);
                    $record['reEvaReportSensitiveMachineMedicalPass'] = Encoding::escapleAllCharacter($evaRecord[0]['sensitive_machine_medical_pass']);
                    $record['reEvaReportSensitiveMachineSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['sensitive_machine_supplement_yes_no']);
                    $record['reEvaReportSensitiveMachineSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['sensitive_machine_supplement']);
                    $record['reEvaReportSensitiveMachineSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['sensitive_machine_supplement_pass']);
                    $record['reEvaReportTelecomMachineYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_yes_no']);
                    $record['reEvaReportTelecomMachineServerOrComputerYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_server_or_computer_yes_no']);
                    $record['reEvaReportTelecomMachineServerOrComputerFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_server_or_computer_finding']);
                    $record['reEvaReportTelecomMachineServerOrComputerRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_server_or_computer_recommend']);
                    $record['reEvaReportTelecomMachineServerOrComputerPass'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_server_or_computer_pass']);
                    $record['reEvaReportTelecomMachinePeripheralsYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_peripherals_yes_no']);
                    $record['reEvaReportTelecomMachinePeripheralsFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_peripherals_finding']);
                    $record['reEvaReportTelecomMachinePeripheralsRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_peripherals_recommend']);
                    $record['reEvaReportTelecomMachinePeripheralsPass'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_peripherals_pass']);
                    $record['reEvaReportTelecomMachineHarmonicEmissionYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_harmonic_emission_yes_no']);
                    $record['reEvaReportTelecomMachineHarmonicEmissionFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_harmonic_emission_finding']);
                    $record['reEvaReportTelecomMachineHarmonicEmissionRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_harmonic_emission_recommend']);
                    $record['reEvaReportTelecomMachineHarmonicEmissionPass'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_harmonic_emission_pass']);
                    $record['reEvaReportTelecomMachineSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_supplement_yes_no']);
                    $record['reEvaReportTelecomMachineSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_supplement']);
                    $record['reEvaReportTelecomMachineSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['telecom_machine_supplement_pass']);
                    $record['reEvaReportAirConditionersYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_yes_no']);
                    $record['reEvaReportAirConditionersMicbYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_micb_yes_no']);
                    $record['reEvaReportAirConditionersMicbFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_micb_finding']);
                    $record['reEvaReportAirConditionersMicbRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_micb_recommend']);
                    $record['reEvaReportAirConditionersMicbPass'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_micb_pass']);
                    $record['reEvaReportAirConditionersLoadForecastingYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_load_forecasting_yes_no']);
                    $record['reEvaReportAirConditionersLoadForecastingFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_load_forecasting_finding']);
                    $record['reEvaReportAirConditionersLoadForecastingRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_load_forecasting_recommend']);
                    $record['reEvaReportAirConditionersLoadForecastingPass'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_load_forecasting_pass']);
                    $record['reEvaReportAirConditionersTypeYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_type_yes_no']);
                    $record['reEvaReportAirConditionersTypeFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_type_finding']);
                    $record['reEvaReportAirConditionersTypeRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_type_recommend']);
                    $record['reEvaReportAirConditionersTypePass'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_type_pass']);
                    $record['reEvaReportAirConditionersSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_supplement_yes_no']);
                    $record['reEvaReportAirConditionersSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_supplement']);
                    $record['reEvaReportAirConditionersSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['air_conditioners_supplement_pass']);
                    $record['reEvaReportNonLinearLoadYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['non_linear_load_yes_no']);
                    $record['reEvaReportNonLinearLoadHarmonicEmissionYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['non_linear_load_harmonic_emission_yes_no']);
                    $record['reEvaReportNonLinearLoadHarmonicEmissionFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['non_linear_load_harmonic_emission_finding']);
                    $record['reEvaReportNonLinearLoadHarmonicEmissionRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['non_linear_load_harmonic_emission_recommend']);
                    $record['reEvaReportNonLinearLoadHarmonicEmissionPass'] = Encoding::escapleAllCharacter($evaRecord[0]['non_linear_load_harmonic_emission_pass']);
                    $record['reEvaReportNonLinearLoadSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['non_linear_load_supplement_yes_no']);
                    $record['reEvaReportNonLinearLoadSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['non_linear_load_supplement']);
                    $record['reEvaReportNonLinearLoadSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['non_linear_load_supplement_pass']);
                    $record['reEvaReportRenewableEnergyYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_yes_no']);
                    $record['reEvaReportRenewableEnergyInverterAndControlsYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_inverter_and_controls_yes_no']);
                    $record['reEvaReportRenewableEnergyInverterAndControlsFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_inverter_and_controls_finding']);
                    $record['reEvaReportRenewableEnergyInverterAndControlsRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_inverter_and_controls_recommend']);
                    $record['reEvaReportRenewableEnergyInverterAndControlsPass'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_inverter_and_controls_pass']);
                    $record['reEvaReportRenewableEnergyHarmonicEmissionYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_harmonic_emission_yes_no']);
                    $record['reEvaReportRenewableEnergyHarmonicEmissionFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_harmonic_emission_finding']);
                    $record['reEvaReportRenewableEnergyHarmonicEmissionRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_harmonic_emission_recommend']);
                    $record['reEvaReportRenewableEnergyHarmonicEmissionPass'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_harmonic_emission_pass']);
                    $record['reEvaReportRenewableEnergySupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_supplement_yes_no']);
                    $record['reEvaReportRenewableEnergySupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_supplement']);
                    $record['reEvaReportRenewableEnergySupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['renewable_energy_supplement_pass']);
                    $record['reEvaReportEvChargerSystemYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_yes_no']);
                    $record['reEvaReportEvChargerSystemEvChargerYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_ev_charger_yes_no']);
                    $record['reEvaReportEvChargerSystemEvChargerFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_ev_charger_finding']);
                    $record['reEvaReportEvChargerSystemEvChargerRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_ev_charger_recommend']);
                    $record['reEvaReportEvChargerSystemEvChargerPass'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_ev_charger_pass']);
                    $record['reEvaReportEvChargerSystemHarmonicEmissionYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_harmonic_emission_yes_no']);
                    $record['reEvaReportEvChargerSystemHarmonicEmissionFinding'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_harmonic_emission_finding']);
                    $record['reEvaReportEvChargerSystemHarmonicEmissionRecommend'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_harmonic_emission_recommend']);
                    $record['reEvaReportEvChargerSystemHarmonicEmissionPass'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_harmonic_emission_pass']);
                    $record['reEvaReportEvChargerSystemSupplementYesNo'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_supplement_yes_no']);
                    $record['reEvaReportEvChargerSystemSupplement'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_supplement']);
                    $record['reEvaReportEvChargerSystemSupplementPass'] = Encoding::escapleAllCharacter($evaRecord[0]['ev_charger_system_supplement_pass']);
                } else {
                    $record['reEvaReportRemark'] = "";
                    $record['reEvaReportEdmsLink'] = "";
                    $record['reEvaReportIssueDate'] = "";
                    $record['reEvaReportFaxRefNo'] = "";
                    $record['reEvaReportScore'] = "";
                    $record['reEvaReportBmsYesNo'] = "";
                    $record['reEvaReportBmsServerCentralComputerYesNo'] = "";
                    $record['reEvaReportBmsServerCentralComputerFinding'] = "";
                    $record['reEvaReportBmsServerCentralComputerRecommend'] = "";
                    $record['reEvaReportBmsServerCentralComputerPass'] = "";
                    $record['reEvaReportBmsDdcYesNo'] = "";
                    $record['reEvaReportBmsDdcFinding'] = "";
                    $record['reEvaReportBmsDdcRecommend'] = "";
                    $record['reEvaReportBmsDdcPass'] = "";
                    $record['reEvaReportBmsSupplementYesNo'] = "";
                    $record['reEvaReportBmsSupplement'] = "";
                    $record['reEvaReportBmsSupplementPass'] = "";
                    $record['reEvaReportChangeoverSchemeYesNo'] = "";
                    $record['reEvaReportChangeoverSchemeControlYesNo'] = "";
                    $record['reEvaReportChangeoverSchemeControlFinding'] = "";
                    $record['reEvaReportChangeoverSchemeControlRecommend'] = "";
                    $record['reEvaReportChangeoverSchemeControlPass'] = "";
                    $record['reEvaReportChangeoverSchemeUvYesNo'] = "";
                    $record['reEvaReportChangeoverSchemeUvFinding'] = "";
                    $record['reEvaReportChangeoverSchemeUvRecommend'] = "";
                    $record['reEvaReportChangeoverSchemeUvPass'] = "";
                    $record['reEvaReportChangeoverSchemeSupplementYesNo'] = "";
                    $record['reEvaReportChangeoverSchemeSupplement'] = "";
                    $record['reEvaReportChangeoverSchemeSupplementPass'] = "";
                    $record['reEvaReportChillerPlantYesNo'] = "";
                    $record['reEvaReportChillerPlantAhuChilledWaterYesNo'] = "";
                    $record['reEvaReportChillerPlantAhuChilledWaterFinding'] = "";
                    $record['reEvaReportChillerPlantAhuChilledWaterRecommend'] = "";
                    $record['reEvaReportChillerPlantAhuChilledWaterPass'] = "";
                    $record['reEvaReportChillerPlantChillerYesNo'] = "";
                    $record['reEvaReportChillerPlantChillerFinding'] = "";
                    $record['reEvaReportChillerPlantChillerRecommend'] = "";
                    $record['reEvaReportChillerPlantChillerPass'] = "";
                    $record['reEvaReportChillerPlantSupplementYesNo'] = "";
                    $record['reEvaReportChillerPlantSupplement'] = "";
                    $record['reEvaReportChillerPlantSupplementPass'] = "";
                    $record['reEvaReportEscalatorYesNo'] = "";
                    $record['reEvaReportEscalatorBrakingSystemYesNo'] = "";
                    $record['reEvaReportEscalatorBrakingSystemFinding'] = "";
                    $record['reEvaReportEscalatorBrakingSystemRecommend'] = "";
                    $record['reEvaReportEscalatorBrakingSystemPass'] = "";
                    $record['reEvaReportEscalatorControlYesNo'] = "";
                    $record['reEvaReportEscalatorControlFinding'] = "";
                    $record['reEvaReportEscalatorControlRecommend'] = "";
                    $record['reEvaReportEscalatorControlPass'] = "";
                    $record['reEvaReportEscalatorSupplementYesNo'] = "";
                    $record['reEvaReportEscalatorSupplement'] = "";
                    $record['reEvaReportEscalatorSupplementPass'] = "";
                    $record['reEvaReportLiftYesNo'] = "";
                    $record['reEvaReportLiftOperationYesNo'] = "";
                    $record['reEvaReportLiftOperationFinding'] = "";
                    $record['reEvaReportLiftOperationRecommend'] = "";
                    $record['reEvaReportLiftOperationPass'] = "";
                    $record['reEvaReportLiftMainSupplyYesNo'] = "";
                    $record['reEvaReportLiftMainSupplyFinding'] = "";
                    $record['reEvaReportLiftMainSupplyRecommend'] = "";
                    $record['reEvaReportLiftMainSupplyPass'] = "";
                    $record['reEvaReportLiftSupplementYesNo'] = "";
                    $record['reEvaReportLiftSupplement'] = "";
                    $record['reEvaReportLiftSupplementPass'] = "";
                    $record['reEvaReportHidLampYesNo'] = "";
                    $record['reEvaReportHidLampBallastYesNo'] = "";
                    $record['reEvaReportHidLampBallastFinding'] = "";
                    $record['reEvaReportHidLampBallastRecommend'] = "";
                    $record['reEvaReportHidLampBallastPass'] = "";
                    $record['reEvaReportHidLampAddonProtectYesNo'] = "";
                    $record['reEvaReportHidLampAddonProtectFinding'] = "";
                    $record['reEvaReportHidLampAddonProtectRecommend'] = "";
                    $record['reEvaReportHidLampAddonProtectPass'] = "";
                    $record['reEvaReportHidLampSupplementYesNo'] = "";
                    $record['reEvaReportHidLampSupplement'] = "";
                    $record['reEvaReportHidLampSupplementPass'] = "";
                    $record['reEvaReportSensitiveMachineYesNo'] = "";
                    $record['reEvaReportSensitiveMachineMedicalYesNo'] = "";
                    $record['reEvaReportSensitiveMachineMedicalFinding'] = "";
                    $record['reEvaReportSensitiveMachineMedicalRecommend'] = "";
                    $record['reEvaReportSensitiveMachineMedicalPass'] = "";
                    $record['reEvaReportSensitiveMachineSupplementYesNo'] = "";
                    $record['reEvaReportSensitiveMachineSupplement'] = "";
                    $record['reEvaReportSensitiveMachineSupplementPass'] = "";
                    $record['reEvaReportTelecomMachineYesNo'] = "";
                    $record['reEvaReportTelecomMachineServerOrComputerYesNo'] = "";
                    $record['reEvaReportTelecomMachineServerOrComputerFinding'] = "";
                    $record['reEvaReportTelecomMachineServerOrComputerRecommend'] = "";
                    $record['reEvaReportTelecomMachineServerOrComputerPass'] = "";
                    $record['reEvaReportTelecomMachinePeripheralsYesNo'] = "";
                    $record['reEvaReportTelecomMachinePeripheralsFinding'] = "";
                    $record['reEvaReportTelecomMachinePeripheralsRecommend'] = "";
                    $record['reEvaReportTelecomMachinePeripheralsPass'] = "";
                    $record['reEvaReportTelecomMachineHarmonicEmissionYesNo'] = "";
                    $record['reEvaReportTelecomMachineHarmonicEmissionFinding'] = "";
                    $record['reEvaReportTelecomMachineHarmonicEmissionRecommend'] = "";
                    $record['reEvaReportTelecomMachineHarmonicEmissionPass'] = "";
                    $record['reEvaReportTelecomMachineSupplementYesNo'] = "";
                    $record['reEvaReportTelecomMachineSupplement'] = "";
                    $record['reEvaReportTelecomMachineSupplementPass'] = "";
                    $record['reEvaReportAirConditionersYesNo'] = "";
                    $record['reEvaReportAirConditionersMicbYesNo'] = "";
                    $record['reEvaReportAirConditionersMicbFinding'] = "";
                    $record['reEvaReportAirConditionersMicbRecommend'] = "";
                    $record['reEvaReportAirConditionersMicbPass'] = "";
                    $record['reEvaReportAirConditionersLoadForecastingYesNo'] = "";
                    $record['reEvaReportAirConditionersLoadForecastingFinding'] = "";
                    $record['reEvaReportAirConditionersLoadForecastingRecommend'] = "";
                    $record['reEvaReportAirConditionersLoadForecastingPass'] = "";
                    $record['reEvaReportAirConditionersTypeYesNo'] = "";
                    $record['reEvaReportAirConditionersTypeFinding'] = "";
                    $record['reEvaReportAirConditionersTypeRecommend'] = "";
                    $record['reEvaReportAirConditionersTypePass'] = "";
                    $record['reEvaReportAirConditionersSupplementYesNo'] = "";
                    $record['reEvaReportAirConditionersSupplement'] = "";
                    $record['reEvaReportAirConditionersSupplementPass'] = "";
                    $record['reEvaReportNonLinearLoadYesNo'] = "";
                    $record['reEvaReportNonLinearLoadHarmonicEmissionYesNo'] = "";
                    $record['reEvaReportNonLinearLoadHarmonicEmissionFinding'] = "";
                    $record['reEvaReportNonLinearLoadHarmonicEmissionRecommend'] = "";
                    $record['reEvaReportNonLinearLoadHarmonicEmissionPass'] = "";
                    $record['reEvaReportNonLinearLoadSupplementYesNo'] = "";
                    $record['reEvaReportNonLinearLoadSupplement'] = "";
                    $record['reEvaReportNonLinearLoadSupplementPass'] = "";
                    $record['reEvaReportRenewableEnergyYesNo'] = "";
                    $record['reEvaReportRenewableEnergyInverterAndControlsYesNo'] = "";
                    $record['reEvaReportRenewableEnergyInverterAndControlsFinding'] = "";
                    $record['reEvaReportRenewableEnergyInverterAndControlsRecommend'] = "";
                    $record['reEvaReportRenewableEnergyInverterAndControlsPass'] = "";
                    $record['reEvaReportRenewableEnergyHarmonicEmissionYesNo'] = "";
                    $record['reEvaReportRenewableEnergyHarmonicEmissionFinding'] = "";
                    $record['reEvaReportRenewableEnergyHarmonicEmissionRecommend'] = "";
                    $record['reEvaReportRenewableEnergyHarmonicEmissionPass'] = "";
                    $record['reEvaReportRenewableEnergySupplementYesNo'] = "";
                    $record['reEvaReportRenewableEnergySupplement'] = "";
                    $record['reEvaReportRenewableEnergySupplementPass'] = "";
                    $record['reEvaReportEvChargerSystemYesNo'] = "";
                    $record['reEvaReportEvChargerSystemEvChargerYesNo'] = "";
                    $record['reEvaReportEvChargerSystemEvChargerFinding'] = "";
                    $record['reEvaReportEvChargerSystemEvChargerRecommend'] = "";
                    $record['reEvaReportEvChargerSystemEvChargerPass'] = "";
                    $record['reEvaReportEvChargerSystemHarmonicEmissionYesNo'] = "";
                    $record['reEvaReportEvChargerSystemHarmonicEmissionFinding'] = "";
                    $record['reEvaReportEvChargerSystemHarmonicEmissionRecommend'] = "";
                    $record['reEvaReportEvChargerSystemHarmonicEmissionPass'] = "";
                    $record['reEvaReportEvChargerSystemSupplementYesNo'] = "";
                    $record['reEvaReportEvChargerSystemSupplement'] = "";
                    $record['reEvaReportEvChargerSystemSupplementPass'] = "";
                }

                $record['state'] = Encoding::escapleAllCharacter($result[0]['state']);
                $record['active'] = Encoding::escapleAllCharacter($result[0]['active']);
                $record['createdBy'] = Encoding::escapleAllCharacter($result[0]['created_by']);
                $record['createdTime'] = $result[0]['created_time'];
                $record['lastUpdatedBy'] = Encoding::escapleAllCharacter($result[0]['last_updated_by']);
                $record['lastUpdatedTime'] = $result[0]['last_updated_time'];
            } else {
                return null;
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
                $item['replySlipChillerPlantAhuControl'] = $row['chiller_plant_ahu_control'];
                $item['replySlipChillerPlantAhuStartup'] = $row['chiller_plant_ahu_startup'];
                $item['replySlipChillerPlantVsd'] = $row['chiller_plant_vsd'];
                $item['replySlipChillerPlantAhuChilledWater'] = $row['chiller_plant_ahu_chilled_water'];
                $item['replySlipChillerPlantStandbyAhu'] = $row['chiller_plant_standby_ahu'];
                $item['replySlipChillerPlantChiller'] = $row['chiller_plant_chiller'];
                $item['replySlipEscalatorYesNo'] = $row['escalator_yes_no'];
                $item['replySlipEscalatorMotorStartup'] = $row['escalator_motor_startup'];
                $item['replySlipEscalatorVsdMitigation'] = $row['escalator_vsd_mitigation'];
                $item['replySlipEscalatorBrakingSystem'] = $row['escalator_braking_system'];
                $item['replySlipEscalatorControl'] = $row['escalator_control'];
                $item['replySlipHidLampYesNo'] = $row['hid_lamp_yes_no'];
                $item['replySlipHidLampMitigation'] = $row['hid_lamp_mitigation'];
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
                $item['replySlipEvControlYesNo'] = $row['ev_control_yes_no'];
                $item['replySlipEvChargerSystemEvCharger'] = $row['ev_charger_system_ev_charger'];
                $item['replySlipEvChargerSystemSmartYesNo'] = $row['ev_charger_system_smart_yes_no'];
                $item['replySlipEvChargerSystemSmartChargingSystem'] = $row['ev_charger_system_smart_charging_system'];
                $item['replySlipEvChargerSystemHarmonicEmission'] = $row['ev_charger_system_harmonic_emission'];
                $item['replySlipConsultantNameConfirmation'] = $row['consultant_name_confirmation'];
                $item['replySlipConsultantCompany'] = $row['consultant_company'];
                $item['replySlipProjectOwnerNameConfirmation'] = $row['project_owner_name_confirmation'];
                $item['replySlipProjectOwnerCompany'] = $row['project_owner_company'];

                if (isset($row['last_updated_time'])) {
                    $replySlipLastUpdateTimeYear = date("Y", strtotime($row['last_updated_time']));
                    $replySlipLastUpdateTimeMonth = date("m", strtotime($row['last_updated_time']));
                    $replySlipLastUpdateTimeDay = date("d", strtotime($row['last_updated_time']));
                    $item['replySlipLastUpdateTime'] = $replySlipLastUpdateTimeYear . "-" .
                        $replySlipLastUpdateTimeMonth . "-" . $replySlipLastUpdateTimeDay;
                } else {
                    $item['replySlipLastUpdateTime'] = null;
                }

                if (isset($row['last_upload_time'])) {
                    $replySlipLastUploadTimeYear = date("Y", strtotime($row['last_upload_time']));
                    $replySlipLastUploadTimeMonth = date("m", strtotime($row['last_upload_time']));
                    $replySlipLastUploadTimeDay = date("d", strtotime($row['last_upload_time']));
                    $item['replySlipLastUploadTime'] = $replySlipLastUploadTimeYear . "-" .
                        $replySlipLastUploadTimeMonth . "-" . $replySlipLastUploadTimeDay;
                } else {
                    $item['replySlipLastUploadTime'] = null;
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
                $array['consultantCompanyName'] = Encoding::escapleAllCharacter($row['consultantCompanyName']);
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }

    public function getPlanningAheadProjectOwnerCompanyAllActive()
    {
        $List = array();
        try {
            $sql = "SELECT * FROM \"tbl_project_owner_company\" WHERE active ='Y' AND \"project_owner_company_name\" IS NOT NULL ORDER BY \"project_owner_company_name\"";
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) {
                $array['projectOwnerCompanyName'] = Encoding::escapleAllCharacter($row['project_owner_company_name']);
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }

    public function getConsultantCompanyAddressInfo($companyName) {
        $List = array();
        try {
            $sql = "SELECT * FROM \"TblConsultantCompany\" WHERE \"consultantCompanyName\"=:companyName";
            $sth = Yii::app()->db->createCommand($sql);
            $sth->bindParam(':companyName', $companyName);
            $result = $sth->queryAll();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) {
                $array['addressLine1'] = Encoding::escapleAllCharacter($row['addressLine1']);
                $array['addressLine2'] = Encoding::escapleAllCharacter($row['addressLine2']);
                $array['addressLine3'] = Encoding::escapleAllCharacter($row['addressLine3']);
                $array['addressLine4'] = Encoding::escapleAllCharacter($row['addressLine4']);
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
                                                   $txnMeetingConsentOwner,$txnMeetingReplySlipId,$txnReplySlipBmsYesNo,$txnReplySlipBmsServerCentralComputer,
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
                                                   $txnState,$lastUpdatedBy,$lastUpdatedTime,$txnPlanningAheadId) {

        if (($txnState == 'NOTIFIED_PQ_SITE_WALK') || ($txnState == 'COMPLETED_PQ_SITE_WALK_PASS') || ($txnState == 'COMPLETED_PQ_SITE_WALK_FAIL') ||
            ($txnState == 'NOTIFIED_RE_PQ_SITE_WALK') || ($txnState == 'COMPLETED_RE_PQ_SITE_WALK_PASS') || ($txnState == 'COMPLETED_RE_PQ_SITE_WALK_FAIL')) {
            if ($txnEvaReportId == 0) {
                $sql = "INSERT INTO public.tbl_evaluation_report(evaluation_report_remark, scheme_no, evaluation_report_edms_link, 
                                         evaluation_report_issue_date, evaluation_report_fax_ref_no, evaluation_report_score, 
                                         bms_yes_no, bms_server_central_computer_yes_no, bms_server_central_computer_finding, 
                                         bms_server_central_computer_recommend, bms_server_central_computer_pass, bms_ddc_yes_no, 
                                         bms_ddc_finding, bms_ddc_recommend, bms_ddc_pass, bms_supplement_yes_no, bms_supplement, 
                                         bms_supplement_pass, changeover_scheme_yes_no, changeover_scheme_control_yes_no, 
                                         changeover_scheme_control_finding, changeover_scheme_control_recommend, changeover_scheme_control_pass, 
                                         changeover_scheme_uv_yes_no, changeover_scheme_uv_finding, changeover_scheme_uv_recommend, changeover_scheme_uv_pass, 
                                         changeover_scheme_supplement_yes_no, changeover_scheme_supplement, changeover_scheme_supplement_pass, chiller_plant_yes_no, 
                                         chiller_plant_ahu_chilled_water_yes_no, chiller_plant_ahu_chilled_water_finding, chiller_plant_ahu_chilled_water_recommend, 
                                         chiller_plant_ahu_chilled_water_pass, chiller_plant_chiller_yes_no, chiller_plant_chiller_finding, 
                                         chiller_plant_chiller_recommend, chiller_plant_chiller_pass, chiller_plant_supplement_yes_no, chiller_plant_supplement, 
                                         chiller_plant_supplement_pass, escalator_yes_no, escalator_braking_system_yes_no, escalator_braking_system_finding, 
                                         escalator_braking_system_recommend, escalator_braking_system_pass, escalator_control_yes_no, escalator_control_finding, 
                                         escalator_control_recommend, escalator_control_pass, escalator_supplement_yes_no, escalator_supplement, 
                                         escalator_supplement_pass, hid_lamp_yes_no, hid_lamp_ballast_yes_no, hid_lamp_ballast_finding, hid_lamp_ballast_recommend, 
                                         hid_lamp_ballast_pass, hid_lamp_addon_protect_yes_no, hid_lamp_addon_protect_finding, hid_lamp_addon_protect_recommend, 
                                         hid_lamp_addon_protect_pass, hid_lamp_supplement_yes_no, hid_lamp_supplement, hid_lamp_supplement_pass, lift_yes_no, 
                                         lift_operation_yes_no, lift_operation_finding, lift_operation_recommend, lift_operation_pass, lift_main_supply_yes_no, 
                                         lift_main_supply_finding, lift_main_supply_recommend, lift_main_supply_pass, lift_supplement_yes_no, lift_supplement, 
                                         lift_supplement_pass, sensitive_machine_yes_no, sensitive_machine_medical_yes_no, sensitive_machine_medical_finding, 
                                         sensitive_machine_medical_recommend, sensitive_machine_medical_pass, sensitive_machine_supplement_yes_no, 
                                         sensitive_machine_supplement, sensitive_machine_supplement_pass, telecom_machine_yes_no, 
                                         telecom_machine_server_or_computer_yes_no, telecom_machine_server_or_computer_finding, 
                                         telecom_machine_server_or_computer_recommend, telecom_machine_server_or_computer_pass, telecom_machine_peripherals_yes_no, 
                                         telecom_machine_peripherals_finding, telecom_machine_peripherals_recommend, telecom_machine_peripherals_pass, 
                                         telecom_machine_harmonic_emission_yes_no, telecom_machine_harmonic_emission_finding, telecom_machine_harmonic_emission_recommend, 
                                         telecom_machine_harmonic_emission_pass, telecom_machine_supplement_yes_no, telecom_machine_supplement, 
                                         telecom_machine_supplement_pass, air_conditioners_yes_no, air_conditioners_micb_yes_no, air_conditioners_micb_finding, 
                                         air_conditioners_micb_recommend, air_conditioners_micb_pass, air_conditioners_load_forecasting_yes_no, 
                                         air_conditioners_load_forecasting_finding, air_conditioners_load_forecasting_recommend, air_conditioners_load_forecasting_pass, 
                                         air_conditioners_type_yes_no, air_conditioners_type_finding, air_conditioners_type_recommend, air_conditioners_type_pass, 
                                         air_conditioners_supplement_yes_no, air_conditioners_supplement, air_conditioners_supplement_pass, non_linear_load_yes_no, 
                                         non_linear_load_harmonic_emission_yes_no, non_linear_load_harmonic_emission_finding, non_linear_load_harmonic_emission_recommend, 
                                         non_linear_load_harmonic_emission_pass, non_linear_load_supplement_yes_no, non_linear_load_supplement, non_linear_load_supplement_pass, 
                                         renewable_energy_yes_no, renewable_energy_inverter_and_controls_yes_no, renewable_energy_inverter_and_controls_finding, 
                                         renewable_energy_inverter_and_controls_recommend, renewable_energy_inverter_and_controls_pass, renewable_energy_harmonic_emission_yes_no, 
                                         renewable_energy_harmonic_emission_finding, renewable_energy_harmonic_emission_recommend, renewable_energy_harmonic_emission_pass, 
                                         renewable_energy_supplement_yes_no, renewable_energy_supplement, renewable_energy_supplement_pass, ev_charger_system_yes_no, 
                                         ev_charger_system_ev_charger_yes_no, ev_charger_system_ev_charger_finding, ev_charger_system_ev_charger_recommend, 
                                         ev_charger_system_ev_charger_pass, ev_charger_system_harmonic_emission_yes_no, ev_charger_system_harmonic_emission_finding, 
                                         ev_charger_system_harmonic_emission_recommend, ev_charger_system_harmonic_emission_pass, ev_charger_system_supplement_yes_no, 
                                         ev_charger_system_supplement, ev_charger_system_supplement_pass, active, created_by, created_time, last_updated_by, last_updated_time)
	VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
	        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
	        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

                $stmt = Yii::app()->db->createCommand($sql);
                $result = $stmt->execute(array($txnEvaReportRemark,$txnSchemeNo,$txnEvaReportEdmsLink,$txnEvaReportIssueDate,
                    $txnEvaReportFaxRefNo,$txnEvaReportScore,$txnEvaReportBmsYesNo,$txnEvaReportBmsServerCentralComputerYesNo,
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
                    $txnEvaReportEscalatorSupplement,$txnEvaReportEscalatorSupplementPass,$txnEvaReportHidLampYesNo,
                    $txnEvaReportHidLampBallastYesNo,$txnEvaReportHidLampBallastFinding,$txnEvaReportHidLampBallastRecommend,
                    $txnEvaReportHidLampBallastPass,$txnEvaReportHidLampAddonProtectYesNo,$txnEvaReportHidLampAddonProtectFinding,
                    $txnEvaReportHidLampAddonProtectRecommend,$txnEvaReportHidLampAddonProtectPass,
                    $txnEvaReportHidLampSupplementYesNo,$txnEvaReportHidLampSupplement,$txnEvaReportHidLampSupplementPass,
                    $txnEvaReportLiftYesNo,$txnEvaReportLiftOperationYesNo,$txnEvaReportLiftOperationFinding,
                    $txnEvaReportLiftOperationRecommend,$txnEvaReportLiftOperationPass,$txnEvaReportLiftMainSupplyYesNo,
                    $txnEvaReportLiftMainSupplyFinding,$txnEvaReportLiftMainSupplyRecommend,$txnEvaReportLiftMainSupplyPass,
                    $txnEvaReportLiftSupplementYesNo, $txnEvaReportLiftSupplement,$txnEvaReportLiftSupplementPass,
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
                    $txnEvaReportEvChargerSystemSupplement,$txnEvaReportEvChargerSystemSupplementPass,'Y',
                    $lastUpdatedBy,$lastUpdatedTime,$lastUpdatedBy,$lastUpdatedTime));

                $sql = "SELECT * FROM \"tbl_evaluation_report\" WHERE \"active\"='Y' AND \"scheme_no\"=:scheme_no";
                $sth = Yii::app()->db->createCommand($sql);
                $sth->bindParam(':scheme_no', $txnSchemeNo);
                $result = $sth->queryAll();

                foreach($result as $row) {
                    $txnEvaReportId = $row['evaluation_report_id'];
                }
            } else {

                $sql = 'UPDATE public.tbl_evaluation_report
	                        SET evaluation_report_remark=?, 
	                            evaluation_report_edms_link=?, evaluation_report_issue_date=?, evaluation_report_fax_ref_no=?, 
	                            evaluation_report_score=?, bms_yes_no=?, bms_server_central_computer_yes_no=?, 
	                            bms_server_central_computer_finding=?, bms_server_central_computer_recommend=?, 
	                            bms_server_central_computer_pass=?, bms_ddc_yes_no=?, bms_ddc_finding=?, bms_ddc_recommend=?, 
	                            bms_ddc_pass=?, bms_supplement_yes_no=?, bms_supplement=?, bms_supplement_pass=?, 
	                            changeover_scheme_yes_no=?, changeover_scheme_control_yes_no=?, 
	                            changeover_scheme_control_finding=?, changeover_scheme_control_recommend=?, 
	                            changeover_scheme_control_pass=?, changeover_scheme_uv_yes_no=?, changeover_scheme_uv_finding=?,
	                            changeover_scheme_uv_recommend=?, changeover_scheme_uv_pass=?, changeover_scheme_supplement_yes_no=?, 
	                            changeover_scheme_supplement=?, changeover_scheme_supplement_pass=?, chiller_plant_yes_no=?, 
	                            chiller_plant_ahu_chilled_water_yes_no=?, chiller_plant_ahu_chilled_water_finding=?, 
	                            chiller_plant_ahu_chilled_water_recommend=?, chiller_plant_ahu_chilled_water_pass=?, 
	                            chiller_plant_chiller_yes_no=?, chiller_plant_chiller_finding=?, chiller_plant_chiller_recommend=?, 
	                            chiller_plant_chiller_pass=?, chiller_plant_supplement_yes_no=?, chiller_plant_supplement=?, 
	                            chiller_plant_supplement_pass=?, escalator_yes_no=?, escalator_braking_system_yes_no=?, 
	                            escalator_braking_system_finding=?, escalator_braking_system_recommend=?, 
	                            escalator_braking_system_pass=?, escalator_control_yes_no=?, escalator_control_finding=?, 
	                            escalator_control_recommend=?, escalator_control_pass=?, escalator_supplement_yes_no=?, 
	                            escalator_supplement=?, escalator_supplement_pass=?, hid_lamp_yes_no=?, hid_lamp_ballast_yes_no=?, 
	                            hid_lamp_ballast_finding=?, hid_lamp_ballast_recommend=?, hid_lamp_ballast_pass=?, 
	                            hid_lamp_addon_protect_yes_no=?, hid_lamp_addon_protect_finding=?, hid_lamp_addon_protect_recommend=?, 
	                            hid_lamp_addon_protect_pass=?, hid_lamp_supplement_yes_no=?, hid_lamp_supplement=?, 
	                            hid_lamp_supplement_pass=?, lift_yes_no=?, lift_operation_yes_no=?, lift_operation_finding=?, 
	                            lift_operation_recommend=?, lift_operation_pass=?, lift_main_supply_yes_no=?, 
	                            lift_main_supply_finding=?, lift_main_supply_recommend=?, lift_main_supply_pass=?, 
	                            lift_supplement_yes_no=?, lift_supplement=?, lift_supplement_pass=?, sensitive_machine_yes_no=?, 
	                            sensitive_machine_medical_yes_no=?, sensitive_machine_medical_finding=?, sensitive_machine_medical_recommend=?, 
	                            sensitive_machine_medical_pass=?, sensitive_machine_supplement_yes_no=?, sensitive_machine_supplement=?, 
	                            sensitive_machine_supplement_pass=?, telecom_machine_yes_no=?, telecom_machine_server_or_computer_yes_no=?, 
	                            telecom_machine_server_or_computer_finding=?, telecom_machine_server_or_computer_recommend=?, 
	                            telecom_machine_server_or_computer_pass=?, telecom_machine_peripherals_yes_no=?, telecom_machine_peripherals_finding=?,
	                            telecom_machine_peripherals_recommend=?, telecom_machine_peripherals_pass=?, telecom_machine_harmonic_emission_yes_no=?,
	                            telecom_machine_harmonic_emission_finding=?, telecom_machine_harmonic_emission_recommend=?, telecom_machine_harmonic_emission_pass=?, 
	                            telecom_machine_supplement_yes_no=?, telecom_machine_supplement=?, telecom_machine_supplement_pass=?, 
	                            air_conditioners_yes_no=?, air_conditioners_micb_yes_no=?, air_conditioners_micb_finding=?, 
	                            air_conditioners_micb_recommend=?, air_conditioners_micb_pass=?, air_conditioners_load_forecasting_yes_no=?, 
	                            air_conditioners_load_forecasting_finding=?, air_conditioners_load_forecasting_recommend=?, 
	                            air_conditioners_load_forecasting_pass=?, air_conditioners_type_yes_no=?, air_conditioners_type_finding=?, 
	                            air_conditioners_type_recommend=?, air_conditioners_type_pass=?, air_conditioners_supplement_yes_no=?, 
	                            air_conditioners_supplement=?, air_conditioners_supplement_pass=?, non_linear_load_yes_no=?, 
	                            non_linear_load_harmonic_emission_yes_no=?, non_linear_load_harmonic_emission_finding=?, 
	                            non_linear_load_harmonic_emission_recommend=?, non_linear_load_harmonic_emission_pass=?, 
	                            non_linear_load_supplement_yes_no=?, non_linear_load_supplement=?, non_linear_load_supplement_pass=?, 
	                            renewable_energy_yes_no=?, renewable_energy_inverter_and_controls_yes_no=?, renewable_energy_inverter_and_controls_finding=?, 
	                            renewable_energy_inverter_and_controls_recommend=?, renewable_energy_inverter_and_controls_pass=?, 
	                            renewable_energy_harmonic_emission_yes_no=?, renewable_energy_harmonic_emission_finding=?, 
	                            renewable_energy_harmonic_emission_recommend=?, renewable_energy_harmonic_emission_pass=?, 
	                            renewable_energy_supplement_yes_no=?, renewable_energy_supplement=?, renewable_energy_supplement_pass=?, 
	                            ev_charger_system_yes_no=?, ev_charger_system_ev_charger_yes_no=?, ev_charger_system_ev_charger_finding=?, 
	                            ev_charger_system_ev_charger_recommend=?, ev_charger_system_ev_charger_pass=?, ev_charger_system_harmonic_emission_yes_no=?, 
	                            ev_charger_system_harmonic_emission_finding=?, ev_charger_system_harmonic_emission_recommend=?, 
	                            ev_charger_system_harmonic_emission_pass=?, ev_charger_system_supplement_yes_no=?, 
	                            ev_charger_system_supplement=?, ev_charger_system_supplement_pass=?, 
	                            last_updated_by=?, last_updated_time=?
	                    WHERE evaluation_report_id=?';

                $stmt = Yii::app()->db->createCommand($sql);
                $result = $stmt->execute(array($txnEvaReportRemark,$txnEvaReportEdmsLink,$txnEvaReportIssueDate,
                    $txnEvaReportFaxRefNo,$txnEvaReportScore,$txnEvaReportBmsYesNo,$txnEvaReportBmsServerCentralComputerYesNo,
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
                    $txnEvaReportEscalatorSupplement,$txnEvaReportEscalatorSupplementPass,$txnEvaReportHidLampYesNo,
                    $txnEvaReportHidLampBallastYesNo,$txnEvaReportHidLampBallastFinding,$txnEvaReportHidLampBallastRecommend,
                    $txnEvaReportHidLampBallastPass,$txnEvaReportHidLampAddonProtectYesNo,$txnEvaReportHidLampAddonProtectFinding,
                    $txnEvaReportHidLampAddonProtectRecommend,$txnEvaReportHidLampAddonProtectPass,
                    $txnEvaReportHidLampSupplementYesNo,$txnEvaReportHidLampSupplement,$txnEvaReportHidLampSupplementPass,
                    $txnEvaReportLiftYesNo,$txnEvaReportLiftOperationYesNo,$txnEvaReportLiftOperationFinding,
                    $txnEvaReportLiftOperationRecommend,$txnEvaReportLiftOperationPass,$txnEvaReportLiftMainSupplyYesNo,
                    $txnEvaReportLiftMainSupplyFinding, $txnEvaReportLiftMainSupplyRecommend,$txnEvaReportLiftMainSupplyPass,
                    $txnEvaReportLiftSupplementYesNo, $txnEvaReportLiftSupplement,$txnEvaReportLiftSupplementPass,
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
                    $lastUpdatedBy,$lastUpdatedTime,$txnEvaReportId));
            }
        }

        if (($txnState == 'NOTIFIED_RE_PQ_SITE_WALK') || ($txnState == 'COMPLETED_RE_PQ_SITE_WALK_PASS') || ($txnState == 'COMPLETED_RE_PQ_SITE_WALK_FAIL')) {
            if ($txnReEvaReportId == 0) {
                $sql = "INSERT INTO public.tbl_evaluation_report(evaluation_report_remark, scheme_no, evaluation_report_edms_link, 
                                         evaluation_report_issue_date, evaluation_report_fax_ref_no, evaluation_report_score, 
                                         bms_yes_no, bms_server_central_computer_yes_no, bms_server_central_computer_finding, 
                                         bms_server_central_computer_recommend, bms_server_central_computer_pass, bms_ddc_yes_no, 
                                         bms_ddc_finding, bms_ddc_recommend, bms_ddc_pass, bms_supplement_yes_no, bms_supplement, 
                                         bms_supplement_pass, changeover_scheme_yes_no, changeover_scheme_control_yes_no, 
                                         changeover_scheme_control_finding, changeover_scheme_control_recommend, changeover_scheme_control_pass, 
                                         changeover_scheme_uv_yes_no, changeover_scheme_uv_finding, changeover_scheme_uv_recommend, changeover_scheme_uv_pass, 
                                         changeover_scheme_supplement_yes_no, changeover_scheme_supplement, changeover_scheme_supplement_pass, chiller_plant_yes_no, 
                                         chiller_plant_ahu_chilled_water_yes_no, chiller_plant_ahu_chilled_water_finding, chiller_plant_ahu_chilled_water_recommend, 
                                         chiller_plant_ahu_chilled_water_pass, chiller_plant_chiller_yes_no, chiller_plant_chiller_finding, 
                                         chiller_plant_chiller_recommend, chiller_plant_chiller_pass, chiller_plant_supplement_yes_no, chiller_plant_supplement, 
                                         chiller_plant_supplement_pass, escalator_yes_no, escalator_braking_system_yes_no, escalator_braking_system_finding, 
                                         escalator_braking_system_recommend, escalator_braking_system_pass, escalator_control_yes_no, escalator_control_finding, 
                                         escalator_control_recommend, escalator_control_pass, escalator_supplement_yes_no, escalator_supplement, 
                                         escalator_supplement_pass, hid_lamp_yes_no, hid_lamp_ballast_yes_no, hid_lamp_ballast_finding, hid_lamp_ballast_recommend, 
                                         hid_lamp_ballast_pass, hid_lamp_addon_protect_yes_no, hid_lamp_addon_protect_finding, hid_lamp_addon_protect_recommend, 
                                         hid_lamp_addon_protect_pass, hid_lamp_supplement_yes_no, hid_lamp_supplement, hid_lamp_supplement_pass, lift_yes_no, 
                                         lift_operation_yes_no, lift_operation_finding, lift_operation_recommend, lift_operation_pass, lift_main_supply_yes_no, 
                                         lift_main_supply_finding, lift_main_supply_recommend, lift_main_supply_pass, lift_supplement_yes_no, lift_supplement, 
                                         lift_supplement_pass, sensitive_machine_yes_no, sensitive_machine_medical_yes_no, sensitive_machine_medical_finding, 
                                         sensitive_machine_medical_recommend, sensitive_machine_medical_pass, sensitive_machine_supplement_yes_no, 
                                         sensitive_machine_supplement, sensitive_machine_supplement_pass, telecom_machine_yes_no, 
                                         telecom_machine_server_or_computer_yes_no, telecom_machine_server_or_computer_finding, 
                                         telecom_machine_server_or_computer_recommend, telecom_machine_server_or_computer_pass, telecom_machine_peripherals_yes_no, 
                                         telecom_machine_peripherals_finding, telecom_machine_peripherals_recommend, telecom_machine_peripherals_pass, 
                                         telecom_machine_harmonic_emission_yes_no, telecom_machine_harmonic_emission_finding, telecom_machine_harmonic_emission_recommend, 
                                         telecom_machine_harmonic_emission_pass, telecom_machine_supplement_yes_no, telecom_machine_supplement, 
                                         telecom_machine_supplement_pass, air_conditioners_yes_no, air_conditioners_micb_yes_no, air_conditioners_micb_finding, 
                                         air_conditioners_micb_recommend, air_conditioners_micb_pass, air_conditioners_load_forecasting_yes_no, 
                                         air_conditioners_load_forecasting_finding, air_conditioners_load_forecasting_recommend, air_conditioners_load_forecasting_pass, 
                                         air_conditioners_type_yes_no, air_conditioners_type_finding, air_conditioners_type_recommend, air_conditioners_type_pass, 
                                         air_conditioners_supplement_yes_no, air_conditioners_supplement, air_conditioners_supplement_pass, non_linear_load_yes_no, 
                                         non_linear_load_harmonic_emission_yes_no, non_linear_load_harmonic_emission_finding, non_linear_load_harmonic_emission_recommend, 
                                         non_linear_load_harmonic_emission_pass, non_linear_load_supplement_yes_no, non_linear_load_supplement, non_linear_load_supplement_pass, 
                                         renewable_energy_yes_no, renewable_energy_inverter_and_controls_yes_no, renewable_energy_inverter_and_controls_finding, 
                                         renewable_energy_inverter_and_controls_recommend, renewable_energy_inverter_and_controls_pass, renewable_energy_harmonic_emission_yes_no, 
                                         renewable_energy_harmonic_emission_finding, renewable_energy_harmonic_emission_recommend, renewable_energy_harmonic_emission_pass, 
                                         renewable_energy_supplement_yes_no, renewable_energy_supplement, renewable_energy_supplement_pass, ev_charger_system_yes_no, 
                                         ev_charger_system_ev_charger_yes_no, ev_charger_system_ev_charger_finding, ev_charger_system_ev_charger_recommend, 
                                         ev_charger_system_ev_charger_pass, ev_charger_system_harmonic_emission_yes_no, ev_charger_system_harmonic_emission_finding, 
                                         ev_charger_system_harmonic_emission_recommend, ev_charger_system_harmonic_emission_pass, ev_charger_system_supplement_yes_no, 
                                         ev_charger_system_supplement, ev_charger_system_supplement_pass, active, created_by, created_time, last_updated_by, last_updated_time)
	VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
	        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
	        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

                $stmt = Yii::app()->db->createCommand($sql);
                $result = $stmt->execute(array($txnReEvaReportRemark,$txnSchemeNo,$txnReEvaReportEdmsLink,$txnReEvaReportIssueDate,
                    $txnReEvaReportFaxRefNo,$txnReEvaReportScore,$txnReEvaReportBmsYesNo,$txnReEvaReportBmsServerCentralComputerYesNo,
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
                    $txnReEvaReportEscalatorSupplement,$txnReEvaReportEscalatorSupplementPass,$txnReEvaReportHidLampYesNo,
                    $txnReEvaReportHidLampBallastYesNo,$txnReEvaReportHidLampBallastFinding,$txnReEvaReportHidLampBallastRecommend,
                    $txnReEvaReportHidLampBallastPass,$txnReEvaReportHidLampAddonProtectYesNo,$txnReEvaReportHidLampAddonProtectFinding,
                    $txnReEvaReportHidLampAddonProtectRecommend,$txnReEvaReportHidLampAddonProtectPass,
                    $txnReEvaReportHidLampSupplementYesNo,$txnReEvaReportHidLampSupplement,$txnReEvaReportHidLampSupplementPass,
                    $txnReEvaReportLiftYesNo,$txnReEvaReportLiftOperationYesNo,$txnReEvaReportLiftOperationFinding,
                    $txnReEvaReportLiftOperationRecommend,$txnReEvaReportLiftOperationPass,$txnReEvaReportLiftMainSupplyYesNo,
                    $txnReEvaReportLiftMainSupplyFinding,$txnReEvaReportLiftMainSupplyRecommend,$txnReEvaReportLiftMainSupplyPass,
                    $txnReEvaReportLiftSupplementYesNo, $txnReEvaReportLiftSupplement,$txnReEvaReportLiftSupplementPass,
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
                    $txnReEvaReportEvChargerSystemSupplement,$txnReEvaReportEvChargerSystemSupplementPass,'Y',
                    $lastUpdatedBy,$lastUpdatedTime,$lastUpdatedBy,$lastUpdatedTime));

                $sql = "SELECT * FROM \"tbl_evaluation_report\" WHERE \"active\"='Y' AND \"scheme_no\"=:scheme_no ORDER BY evaluation_report_id";
                $sth = Yii::app()->db->createCommand($sql);
                $sth->bindParam(':scheme_no', $txnSchemeNo);
                $result = $sth->queryAll();

                foreach($result as $row) {
                    $txnReEvaReportId = $row['evaluation_report_id'];
                }
            } else {

                $sql = 'UPDATE public.tbl_evaluation_report
	                        SET evaluation_report_remark=?, 
	                            evaluation_report_edms_link=?, evaluation_report_issue_date=?, evaluation_report_fax_ref_no=?, 
	                            evaluation_report_score=?, bms_yes_no=?, bms_server_central_computer_yes_no=?, 
	                            bms_server_central_computer_finding=?, bms_server_central_computer_recommend=?, 
	                            bms_server_central_computer_pass=?, bms_ddc_yes_no=?, bms_ddc_finding=?, bms_ddc_recommend=?, 
	                            bms_ddc_pass=?, bms_supplement_yes_no=?, bms_supplement=?, bms_supplement_pass=?, 
	                            changeover_scheme_yes_no=?, changeover_scheme_control_yes_no=?, 
	                            changeover_scheme_control_finding=?, changeover_scheme_control_recommend=?, 
	                            changeover_scheme_control_pass=?, changeover_scheme_uv_yes_no=?, changeover_scheme_uv_finding=?,
	                            changeover_scheme_uv_recommend=?, changeover_scheme_uv_pass=?, changeover_scheme_supplement_yes_no=?, 
	                            changeover_scheme_supplement=?, changeover_scheme_supplement_pass=?, chiller_plant_yes_no=?, 
	                            chiller_plant_ahu_chilled_water_yes_no=?, chiller_plant_ahu_chilled_water_finding=?, 
	                            chiller_plant_ahu_chilled_water_recommend=?, chiller_plant_ahu_chilled_water_pass=?, 
	                            chiller_plant_chiller_yes_no=?, chiller_plant_chiller_finding=?, chiller_plant_chiller_recommend=?, 
	                            chiller_plant_chiller_pass=?, chiller_plant_supplement_yes_no=?, chiller_plant_supplement=?, 
	                            chiller_plant_supplement_pass=?, escalator_yes_no=?, escalator_braking_system_yes_no=?, 
	                            escalator_braking_system_finding=?, escalator_braking_system_recommend=?, 
	                            escalator_braking_system_pass=?, escalator_control_yes_no=?, escalator_control_finding=?, 
	                            escalator_control_recommend=?, escalator_control_pass=?, escalator_supplement_yes_no=?, 
	                            escalator_supplement=?, escalator_supplement_pass=?, hid_lamp_yes_no=?, hid_lamp_ballast_yes_no=?, 
	                            hid_lamp_ballast_finding=?, hid_lamp_ballast_recommend=?, hid_lamp_ballast_pass=?, 
	                            hid_lamp_addon_protect_yes_no=?, hid_lamp_addon_protect_finding=?, hid_lamp_addon_protect_recommend=?, 
	                            hid_lamp_addon_protect_pass=?, hid_lamp_supplement_yes_no=?, hid_lamp_supplement=?, 
	                            hid_lamp_supplement_pass=?, lift_yes_no=?, lift_operation_yes_no=?, lift_operation_finding=?, 
	                            lift_operation_recommend=?, lift_operation_pass=?, lift_main_supply_yes_no=?, 
	                            lift_main_supply_finding=?, lift_main_supply_recommend=?, lift_main_supply_pass=?, 
	                            lift_supplement_yes_no=?, lift_supplement=?, lift_supplement_pass=?, sensitive_machine_yes_no=?, 
	                            sensitive_machine_medical_yes_no=?, sensitive_machine_medical_finding=?, sensitive_machine_medical_recommend=?, 
	                            sensitive_machine_medical_pass=?, sensitive_machine_supplement_yes_no=?, sensitive_machine_supplement=?, 
	                            sensitive_machine_supplement_pass=?, telecom_machine_yes_no=?, telecom_machine_server_or_computer_yes_no=?, 
	                            telecom_machine_server_or_computer_finding=?, telecom_machine_server_or_computer_recommend=?, 
	                            telecom_machine_server_or_computer_pass=?, telecom_machine_peripherals_yes_no=?, telecom_machine_peripherals_finding=?,
	                            telecom_machine_peripherals_recommend=?, telecom_machine_peripherals_pass=?, telecom_machine_harmonic_emission_yes_no=?,
	                            telecom_machine_harmonic_emission_finding=?, telecom_machine_harmonic_emission_recommend=?, telecom_machine_harmonic_emission_pass=?, 
	                            telecom_machine_supplement_yes_no=?, telecom_machine_supplement=?, telecom_machine_supplement_pass=?, 
	                            air_conditioners_yes_no=?, air_conditioners_micb_yes_no=?, air_conditioners_micb_finding=?, 
	                            air_conditioners_micb_recommend=?, air_conditioners_micb_pass=?, air_conditioners_load_forecasting_yes_no=?, 
	                            air_conditioners_load_forecasting_finding=?, air_conditioners_load_forecasting_recommend=?, 
	                            air_conditioners_load_forecasting_pass=?, air_conditioners_type_yes_no=?, air_conditioners_type_finding=?, 
	                            air_conditioners_type_recommend=?, air_conditioners_type_pass=?, air_conditioners_supplement_yes_no=?, 
	                            air_conditioners_supplement=?, air_conditioners_supplement_pass=?, non_linear_load_yes_no=?, 
	                            non_linear_load_harmonic_emission_yes_no=?, non_linear_load_harmonic_emission_finding=?, 
	                            non_linear_load_harmonic_emission_recommend=?, non_linear_load_harmonic_emission_pass=?, 
	                            non_linear_load_supplement_yes_no=?, non_linear_load_supplement=?, non_linear_load_supplement_pass=?, 
	                            renewable_energy_yes_no=?, renewable_energy_inverter_and_controls_yes_no=?, renewable_energy_inverter_and_controls_finding=?, 
	                            renewable_energy_inverter_and_controls_recommend=?, renewable_energy_inverter_and_controls_pass=?, 
	                            renewable_energy_harmonic_emission_yes_no=?, renewable_energy_harmonic_emission_finding=?, 
	                            renewable_energy_harmonic_emission_recommend=?, renewable_energy_harmonic_emission_pass=?, 
	                            renewable_energy_supplement_yes_no=?, renewable_energy_supplement=?, renewable_energy_supplement_pass=?, 
	                            ev_charger_system_yes_no=?, ev_charger_system_ev_charger_yes_no=?, ev_charger_system_ev_charger_finding=?, 
	                            ev_charger_system_ev_charger_recommend=?, ev_charger_system_ev_charger_pass=?, ev_charger_system_harmonic_emission_yes_no=?, 
	                            ev_charger_system_harmonic_emission_finding=?, ev_charger_system_harmonic_emission_recommend=?, 
	                            ev_charger_system_harmonic_emission_pass=?, ev_charger_system_supplement_yes_no=?, 
	                            ev_charger_system_supplement=?, ev_charger_system_supplement_pass=?, 
	                            last_updated_by=?, last_updated_time=?
	                    WHERE evaluation_report_id=?';

                $stmt = Yii::app()->db->createCommand($sql);
                $result = $stmt->execute(array($txnReEvaReportRemark,$txnReEvaReportEdmsLink,$txnReEvaReportIssueDate,
                    $txnReEvaReportFaxRefNo,$txnReEvaReportScore,$txnReEvaReportBmsYesNo,$txnReEvaReportBmsServerCentralComputerYesNo,
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
                    $txnReEvaReportEscalatorSupplement,$txnReEvaReportEscalatorSupplementPass,$txnReEvaReportHidLampYesNo,
                    $txnReEvaReportHidLampBallastYesNo,$txnReEvaReportHidLampBallastFinding,$txnReEvaReportHidLampBallastRecommend,
                    $txnReEvaReportHidLampBallastPass,$txnReEvaReportHidLampAddonProtectYesNo,$txnReEvaReportHidLampAddonProtectFinding,
                    $txnReEvaReportHidLampAddonProtectRecommend,$txnReEvaReportHidLampAddonProtectPass,
                    $txnReEvaReportHidLampSupplementYesNo,$txnReEvaReportHidLampSupplement,$txnReEvaReportHidLampSupplementPass,
                    $txnReEvaReportLiftYesNo,$txnReEvaReportLiftOperationYesNo,$txnReEvaReportLiftOperationFinding,
                    $txnReEvaReportLiftOperationRecommend,$txnReEvaReportLiftOperationPass,$txnReEvaReportLiftMainSupplyYesNo,
                    $txnReEvaReportLiftMainSupplyFinding, $txnReEvaReportLiftMainSupplyRecommend,$txnReEvaReportLiftMainSupplyPass,
                    $txnReEvaReportLiftSupplementYesNo, $txnReEvaReportLiftSupplement,$txnReEvaReportLiftSupplementPass,
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
                    $lastUpdatedBy,$lastUpdatedTime,$txnEvaReportId));
            }
        }

        $sql = 'UPDATE "tbl_planning_ahead" SET "project_title"=?, "scheme_no"=?, "region_id"=?, ';
        $sql = $sql . '"project_type_id"=?, "commission_date"=?, "key_infra"=?, "temp_project"=?, ';
        $sql = $sql . '"first_region_staff_name"=?, "first_region_staff_phone"=?, "first_region_staff_email"=?, ';
        $sql = $sql . '"second_region_staff_name"=?, "second_region_staff_phone"=?, "second_region_staff_email"=?, ';
        $sql = $sql . '"third_region_staff_name"=?, "third_region_staff_phone"=?, "third_region_staff_email"=?, ';
        $sql = $sql . '"first_consultant_title"=?, "first_consultant_surname"=?, "first_consultant_other_name"=?, ';
        $sql = $sql . '"first_consultant_company"=?, "first_consultant_phone"=?, "first_consultant_email"=?, ';
        $sql = $sql . '"second_consultant_title"=?, "second_consultant_surname"=?, "second_consultant_other_name"=?, ';
        $sql = $sql . '"second_consultant_company"=?, "second_consultant_phone"=?, "second_consultant_email"=?, ';
        $sql = $sql . '"third_consultant_title"=?, "third_consultant_surname"=?, "third_consultant_other_name"=?, ';
        $sql = $sql . '"third_consultant_company"=?, "third_consultant_phone"=?, "third_consultant_email"=?, ';
        $sql = $sql . '"first_project_owner_title"=?, "first_project_owner_surname"=?, "first_project_owner_other_name"=?, ';
        $sql = $sql . '"first_project_owner_company"=?, "first_project_owner_phone"=?, "first_project_owner_email"=?, ';
        $sql = $sql . '"second_project_owner_title"=?, "second_project_owner_surname"=?, "second_project_owner_other_name"=?, ';
        $sql = $sql . '"second_project_owner_company"=?, "second_project_owner_phone"=?, "second_project_owner_email"=?, ';
        $sql = $sql . '"third_project_owner_title"=?, "third_project_owner_surname"=?, "third_project_owner_other_name"=?, ';
        $sql = $sql . '"third_project_owner_company"=?, "third_project_owner_phone"=?, "third_project_owner_email"=?, ';
        $sql = $sql . '"stand_letter_issue_date"=?, "stand_letter_fax_ref_no"=?, "stand_letter_edms_link"=?, ';
        $sql = $sql . '"stand_letter_letter_loc"=?, ';
        $sql = $sql . '"meeting_first_prefer_meeting_date"=?, "meeting_second_prefer_meeting_date"=?, ';
        $sql = $sql . '"meeting_actual_meeting_date"=?, "meeting_rej_reason"=?, ';
        $sql = $sql . '"meeting_consent_consultant"=?, "meeting_consent_owner"=?, "meeting_remark"=?, ';
        $sql = $sql . '"first_invitation_letter_issue_date"=?, "first_invitation_letter_fax_ref_no"=?, ';
        $sql = $sql . '"first_invitation_letter_edms_link"=?, "first_invitation_letter_accept"=?, ';
        $sql = $sql . '"first_invitation_letter_walk_date"=?, ';
        $sql = $sql . '"second_invitation_letter_issue_date"=?, "second_invitation_letter_fax_ref_no"=?, ';
        $sql = $sql . '"second_invitation_letter_edms_link"=?, "second_invitation_letter_accept"=?, ';
        $sql = $sql . '"second_invitation_letter_walk_date"=?, ';
        $sql = $sql . '"third_invitation_letter_issue_date"=?, "third_invitation_letter_fax_ref_no"=?, ';
        $sql = $sql . '"third_invitation_letter_edms_link"=?, "third_invitation_letter_accept"=?, ';
        $sql = $sql . '"third_invitation_letter_walk_date"=?, ';
        $sql = $sql . '"forth_invitation_letter_issue_date"=?, "forth_invitation_letter_fax_ref_no"=?, ';
        $sql = $sql . '"forth_invitation_letter_edms_link"=?, "forth_invitation_letter_accept"=?, ';
        $sql = $sql . '"forth_invitation_letter_walk_date"=?, ';
        $sql = $sql . '"eva_report_id"=?, "re_eva_report_id"=?, "last_updated_by"=?, "last_updated_time"=? ';
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
                $txnThirdConsultantTitle, $txnThirdConsultantSurname, $txnThirdConsultantOtherName,
                $txnThirdConsultantCompany, $txnThirdConsultantPhone, $txnThirdConsultantEmail,
                $txnFirstProjectOwnerTitle, $txnFirstProjectOwnerSurname, $txnFirstProjectOwnerOtherName,
                $txnFirstProjectOwnerCompany, $txnFirstProjectOwnerPhone, $txnFirstProjectOwnerEmail,
                $txnSecondProjectOwnerTitle, $txnSecondProjectOwnerSurname, $txnSecondProjectOwnerOtherName,
                $txnSecondProjectOwnerCompany, $txnSecondProjectOwnerPhone, $txnSecondProjectOwnerEmail,
                $txnThirdProjectOwnerTitle, $txnThirdProjectOwnerSurname, $txnThirdProjectOwnerOtherName,
                $txnThirdProjectOwnerCompany, $txnThirdProjectOwnerPhone, $txnThirdProjectOwnerEmail,
                $txnStandLetterIssueDate, $txnStandLetterFaxRefNo, $txnStandLetterEdmsLink,
                $txnStandLetterLetterLoc,
                $txnMeetingFirstPreferMeetingDate, $txnMeetingSecondPreferMeetingDate,
                $txnMeetingActualMeetingDate, $txnMeetingRejReason, $txnMeetingConsentConsultant,
                $txnMeetingConsentOwner, $txnMeetingRemark,
                $txnFirstInvitationLetterIssueDate,$txnFirstInvitationLetterFaxRefNo,
                $txnFirstInvitationLetterEdmsLink,$txnFirstInvitationLetterAccept,$txnFirstInvitationLetterWalkDate,
                $txnSecondInvitationLetterIssueDate,$txnSecondInvitationLetterFaxRefNo,
                $txnSecondInvitationLetterEdmsLink,$txnSecondInvitationLetterAccept,$txnSecondInvitationLetterWalkDate,
                $txnThirdInvitationLetterIssueDate,$txnThirdInvitationLetterFaxRefNo,
                $txnThirdInvitationLetterEdmsLink,$txnThirdInvitationLetterAccept,$txnThirdInvitationLetterWalkDate,
                $txnForthInvitationLetterIssueDate,$txnForthInvitationLetterFaxRefNo,
                $txnForthInvitationLetterEdmsLink,$txnForthInvitationLetterAccept,$txnForthInvitationLetterWalkDate,
                $txnEvaReportId,$txnReEvaReportId,$lastUpdatedBy,$lastUpdatedTime,$txnPlanningAheadId));

            if (isset($txnFirstProjectOwnerCompany) && (trim($txnFirstProjectOwnerCompany) != "")) {
                $this->updateProjectOwnerCompanyByName($txnFirstProjectOwnerCompany,$lastUpdatedBy,$lastUpdatedTime);
            }

            if (isset($txnSecondProjectOwnerCompany) && (trim($txnSecondProjectOwnerCompany) != "")) {
                $this->updateProjectOwnerCompanyByName($txnSecondProjectOwnerCompany,$lastUpdatedBy,$lastUpdatedTime);
            }

            if (isset($txnThirdProjectOwnerCompany) && (trim($txnThirdProjectOwnerCompany) != "")) {
                $this->updateProjectOwnerCompanyByName($txnThirdProjectOwnerCompany,$lastUpdatedBy,$lastUpdatedTime);
            }

            if ($txnMeetingReplySlipId>0) {
                $sql = 'UPDATE "tbl_slip_reply" SET "bms_yes_no"=?, "bms_server_central_computer"=?,
                            "bms_ddc"=?, "changeover_scheme_yes_no"=?, "changeover_scheme_control"=?, 
                            "changeover_scheme_uv"=?, "chiller_plant_yes_no"=?, "chiller_plant_ahu_control"=?,
                            "chiller_plant_ahu_startup"=?, "chiller_plant_vsd"=?, "chiller_plant_ahu_chilled_water"=?,
                            "chiller_plant_standby_ahu"=?, "chiller_plant_chiller"=?, "escalator_yes_no"=?, 
                            "escalator_motor_startup"=?, "escalator_vsd_mitigation"=?, "escalator_braking_system"=?, 
                            "escalator_control"=?, "hid_lamp_yes_no"=?, "hid_lamp_mitigation"=?, 
                            "lift_yes_no"=?, "lift_operation"=?, "sensitive_machine_yes_no"=?,
                            "sensitive_machine_mitigation"=?, "telecom_machine_yes_no"=?, 
                            "telecom_machine_server_or_computer"=?, "telecom_machine_peripherals"=?, 
                            "telecom_machine_harmonic_emission"=?, "air_conditioners_yes_no"=?, 
                            "air_conditioners_micb"=?, "air_conditioners_load_forecasting"=?, 
                            "air_conditioners_type"=?, "non_linear_load_yes_no"=?, "non_linear_load_harmonic_emission"=?, 
                            "renewable_energy_yes_no"=?, "renewable_energy_inverter_and_controls"=?, 
                            "renewable_energy_harmonic_emission"=?, "ev_charger_system_yes_no"=?, "ev_control_yes_no"=?, 
                            "ev_charger_system_ev_charger"=?, "ev_charger_system_smart_yes_no"=?, 
                            "ev_charger_system_smart_charging_system"=?, "ev_charger_system_harmonic_emission"=?, 
                            "consultant_name_confirmation"=?, "consultant_company"=?, 
                            "project_owner_name_confirmation"=?, "project_owner_company"=?, 
                            "last_updated_by"=?, "last_updated_time"=? 
                            WHERE "reply_slip_id"=?';

                $stmt = Yii::app()->db->createCommand($sql);
                $result = $stmt->execute(array($txnReplySlipBmsYesNo,$txnReplySlipBmsServerCentralComputer,
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
                                                     $txnMeetingConsentOwner,$txnMeetingReplySlipId,$txnReplySlipBmsYesNo,$txnReplySlipBmsServerCentralComputer,
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
                                                     $txnState,$txnNewState, $lastUpdatedBy,$lastUpdatedTime,
                                                     $txnPlanningAheadId)
    {
        if (($txnState == 'NOTIFIED_PQ_SITE_WALK') || ($txnState == 'COMPLETED_PQ_SITE_WALK_PASS') || ($txnState == 'COMPLETED_PQ_SITE_WALK_FAIL')) {
            if ($txnEvaReportId == 0) {
                $sql = "INSERT INTO public.tbl_evaluation_report(evaluation_report_remark, scheme_no, evaluation_report_edms_link, 
                                         evaluation_report_issue_date, evaluation_report_fax_ref_no, evaluation_report_score, 
                                         bms_yes_no, bms_server_central_computer_yes_no, bms_server_central_computer_finding, 
                                         bms_server_central_computer_recommend, bms_server_central_computer_pass, bms_ddc_yes_no, 
                                         bms_ddc_finding, bms_ddc_recommend, bms_ddc_pass, bms_supplement_yes_no, bms_supplement, 
                                         bms_supplement_pass, changeover_scheme_yes_no, changeover_scheme_control_yes_no, 
                                         changeover_scheme_control_finding, changeover_scheme_control_recommend, changeover_scheme_control_pass, 
                                         changeover_scheme_uv_yes_no, changeover_scheme_uv_finding, changeover_scheme_uv_recommend, changeover_scheme_uv_pass, 
                                         changeover_scheme_supplement_yes_no, changeover_scheme_supplement, changeover_scheme_supplement_pass, chiller_plant_yes_no, 
                                         chiller_plant_ahu_chilled_water_yes_no, chiller_plant_ahu_chilled_water_finding, chiller_plant_ahu_chilled_water_recommend, 
                                         chiller_plant_ahu_chilled_water_pass, chiller_plant_chiller_yes_no, chiller_plant_chiller_finding, 
                                         chiller_plant_chiller_recommend, chiller_plant_chiller_pass, chiller_plant_supplement_yes_no, chiller_plant_supplement, 
                                         chiller_plant_supplement_pass, escalator_yes_no, escalator_braking_system_yes_no, escalator_braking_system_finding, 
                                         escalator_braking_system_recommend, escalator_braking_system_pass, escalator_control_yes_no, escalator_control_finding, 
                                         escalator_control_recommend, escalator_control_pass, escalator_supplement_yes_no, escalator_supplement, 
                                         escalator_supplement_pass, hid_lamp_yes_no, hid_lamp_ballast_yes_no, hid_lamp_ballast_finding, hid_lamp_ballast_recommend, 
                                         hid_lamp_ballast_pass, hid_lamp_addon_protect_yes_no, hid_lamp_addon_protect_finding, hid_lamp_addon_protect_recommend, 
                                         hid_lamp_addon_protect_pass, hid_lamp_supplement_yes_no, hid_lamp_supplement, hid_lamp_supplement_pass, lift_yes_no, 
                                         lift_operation_yes_no, lift_operation_finding, lift_operation_recommend, lift_operation_pass, lift_main_supply_yes_no, 
                                         lift_main_supply_finding, lift_main_supply_recommend, lift_main_supply_pass, lift_supplement_yes_no, lift_supplement, 
                                         lift_supplement_pass, sensitive_machine_yes_no, sensitive_machine_medical_yes_no, sensitive_machine_medical_finding, 
                                         sensitive_machine_medical_recommend, sensitive_machine_medical_pass, sensitive_machine_supplement_yes_no, 
                                         sensitive_machine_supplement, sensitive_machine_supplement_pass, telecom_machine_yes_no, 
                                         telecom_machine_server_or_computer_yes_no, telecom_machine_server_or_computer_finding, 
                                         telecom_machine_server_or_computer_recommend, telecom_machine_server_or_computer_pass, telecom_machine_peripherals_yes_no, 
                                         telecom_machine_peripherals_finding, telecom_machine_peripherals_recommend, telecom_machine_peripherals_pass, 
                                         telecom_machine_harmonic_emission_yes_no, telecom_machine_harmonic_emission_finding, telecom_machine_harmonic_emission_recommend, 
                                         telecom_machine_harmonic_emission_pass, telecom_machine_supplement_yes_no, telecom_machine_supplement, 
                                         telecom_machine_supplement_pass, air_conditioners_yes_no, air_conditioners_micb_yes_no, air_conditioners_micb_finding, 
                                         air_conditioners_micb_recommend, air_conditioners_micb_pass, air_conditioners_load_forecasting_yes_no, 
                                         air_conditioners_load_forecasting_finding, air_conditioners_load_forecasting_recommend, air_conditioners_load_forecasting_pass, 
                                         air_conditioners_type_yes_no, air_conditioners_type_finding, air_conditioners_type_recommend, air_conditioners_type_pass, 
                                         air_conditioners_supplement_yes_no, air_conditioners_supplement, air_conditioners_supplement_pass, non_linear_load_yes_no, 
                                         non_linear_load_harmonic_emission_yes_no, non_linear_load_harmonic_emission_finding, non_linear_load_harmonic_emission_recommend, 
                                         non_linear_load_harmonic_emission_pass, non_linear_load_supplement_yes_no, non_linear_load_supplement, non_linear_load_supplement_pass, 
                                         renewable_energy_yes_no, renewable_energy_inverter_and_controls_yes_no, renewable_energy_inverter_and_controls_finding, 
                                         renewable_energy_inverter_and_controls_recommend, renewable_energy_inverter_and_controls_pass, renewable_energy_harmonic_emission_yes_no, 
                                         renewable_energy_harmonic_emission_finding, renewable_energy_harmonic_emission_recommend, renewable_energy_harmonic_emission_pass, 
                                         renewable_energy_supplement_yes_no, renewable_energy_supplement, renewable_energy_supplement_pass, ev_charger_system_yes_no, 
                                         ev_charger_system_ev_charger_yes_no, ev_charger_system_ev_charger_finding, ev_charger_system_ev_charger_recommend, 
                                         ev_charger_system_ev_charger_pass, ev_charger_system_harmonic_emission_yes_no, ev_charger_system_harmonic_emission_finding, 
                                         ev_charger_system_harmonic_emission_recommend, ev_charger_system_harmonic_emission_pass, ev_charger_system_supplement_yes_no, 
                                         ev_charger_system_supplement, ev_charger_system_supplement_pass, active, created_by, created_time, last_updated_by, last_updated_time)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

                $stmt = Yii::app()->db->createCommand($sql);
                $result = $stmt->execute(array($txnEvaReportRemark,$txnSchemeNo,$txnEvaReportEdmsLink,$txnEvaReportIssueDate,
                    $txnEvaReportFaxRefNo,$txnEvaReportScore,$txnEvaReportBmsYesNo,$txnEvaReportBmsServerCentralComputerYesNo,
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
                    $txnEvaReportEscalatorSupplement,$txnEvaReportEscalatorSupplementPass,$txnEvaReportHidLampYesNo,
                    $txnEvaReportHidLampBallastYesNo,$txnEvaReportHidLampBallastFinding,$txnEvaReportHidLampBallastRecommend,
                    $txnEvaReportHidLampBallastPass,$txnEvaReportHidLampAddonProtectYesNo,$txnEvaReportHidLampAddonProtectFinding,
                    $txnEvaReportHidLampAddonProtectRecommend,$txnEvaReportHidLampAddonProtectPass,
                    $txnEvaReportHidLampSupplementYesNo,$txnEvaReportHidLampSupplement,$txnEvaReportHidLampSupplementPass,
                    $txnEvaReportLiftYesNo,$txnEvaReportLiftOperationYesNo,$txnEvaReportLiftOperationFinding,
                    $txnEvaReportLiftOperationRecommend,$txnEvaReportLiftOperationPass,$txnEvaReportLiftMainSupplyYesNo,
                    $txnEvaReportLiftMainSupplyFinding,$txnEvaReportLiftMainSupplyRecommend,$txnEvaReportLiftMainSupplyPass,
                    $txnEvaReportLiftSupplementYesNo, $txnEvaReportLiftSupplement,$txnEvaReportLiftSupplementPass,
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
                    $txnEvaReportEvChargerSystemSupplement,$txnEvaReportEvChargerSystemSupplementPass,'Y',
                    $lastUpdatedBy,$lastUpdatedTime,$lastUpdatedBy,$lastUpdatedTime));

                $sql = "SELECT * FROM \"tbl_evaluation_report\" WHERE \"active\"='Y' AND \"scheme_no\"=:scheme_no";
                $sth = Yii::app()->db->createCommand($sql);
                $sth->bindParam(':scheme_no', $txnSchemeNo);
                $result = $sth->queryAll();

                foreach($result as $row) {
                    $txnEvaReportId = $row['evaluation_report_id'];
                }
            } else {

                $sql = 'UPDATE public.tbl_evaluation_report
	                        SET evaluation_report_remark=?, 
	                            evaluation_report_edms_link=?, evaluation_report_issue_date=?, evaluation_report_fax_ref_no=?, 
	                            evaluation_report_score=?, bms_yes_no=?, bms_server_central_computer_yes_no=?, 
	                            bms_server_central_computer_finding=?, bms_server_central_computer_recommend=?, 
	                            bms_server_central_computer_pass=?, bms_ddc_yes_no=?, bms_ddc_finding=?, bms_ddc_recommend=?, 
	                            bms_ddc_pass=?, bms_supplement_yes_no=?, bms_supplement=?, bms_supplement_pass=?, 
	                            changeover_scheme_yes_no=?, changeover_scheme_control_yes_no=?, 
	                            changeover_scheme_control_finding=?, changeover_scheme_control_recommend=?, 
	                            changeover_scheme_control_pass=?, changeover_scheme_uv_yes_no=?, changeover_scheme_uv_finding=?,
	                            changeover_scheme_uv_recommend=?, changeover_scheme_uv_pass=?, changeover_scheme_supplement_yes_no=?, 
	                            changeover_scheme_supplement=?, changeover_scheme_supplement_pass=?, chiller_plant_yes_no=?, 
	                            chiller_plant_ahu_chilled_water_yes_no=?, chiller_plant_ahu_chilled_water_finding=?, 
	                            chiller_plant_ahu_chilled_water_recommend=?, chiller_plant_ahu_chilled_water_pass=?, 
	                            chiller_plant_chiller_yes_no=?, chiller_plant_chiller_finding=?, chiller_plant_chiller_recommend=?, 
	                            chiller_plant_chiller_pass=?, chiller_plant_supplement_yes_no=?, chiller_plant_supplement=?, 
	                            chiller_plant_supplement_pass=?, escalator_yes_no=?, escalator_braking_system_yes_no=?, 
	                            escalator_braking_system_finding=?, escalator_braking_system_recommend=?, 
	                            escalator_braking_system_pass=?, escalator_control_yes_no=?, escalator_control_finding=?, 
	                            escalator_control_recommend=?, escalator_control_pass=?, escalator_supplement_yes_no=?, 
	                            escalator_supplement=?, escalator_supplement_pass=?, hid_lamp_yes_no=?, hid_lamp_ballast_yes_no=?, 
	                            hid_lamp_ballast_finding=?, hid_lamp_ballast_recommend=?, hid_lamp_ballast_pass=?, 
	                            hid_lamp_addon_protect_yes_no=?, hid_lamp_addon_protect_finding=?, hid_lamp_addon_protect_recommend=?, 
	                            hid_lamp_addon_protect_pass=?, hid_lamp_supplement_yes_no=?, hid_lamp_supplement=?, 
	                            hid_lamp_supplement_pass=?, lift_yes_no=?, lift_operation_yes_no=?, lift_operation_finding=?, 
	                            lift_operation_recommend=?, lift_operation_pass=?, lift_main_supply_yes_no=?, 
	                            lift_main_supply_finding=?, lift_main_supply_recommend=?, lift_main_supply_pass=?, 
	                            lift_supplement_yes_no=?, lift_supplement=?, lift_supplement_pass=?, sensitive_machine_yes_no=?, 
	                            sensitive_machine_medical_yes_no=?, sensitive_machine_medical_finding=?, sensitive_machine_medical_recommend=?, 
	                            sensitive_machine_medical_pass=?, sensitive_machine_supplement_yes_no=?, sensitive_machine_supplement=?, 
	                            sensitive_machine_supplement_pass=?, telecom_machine_yes_no=?, telecom_machine_server_or_computer_yes_no=?, 
	                            telecom_machine_server_or_computer_finding=?, telecom_machine_server_or_computer_recommend=?, 
	                            telecom_machine_server_or_computer_pass=?, telecom_machine_peripherals_yes_no=?, telecom_machine_peripherals_finding=?,
	                            telecom_machine_peripherals_recommend=?, telecom_machine_peripherals_pass=?, telecom_machine_harmonic_emission_yes_no=?,
	                            telecom_machine_harmonic_emission_finding=?, telecom_machine_harmonic_emission_recommend=?, telecom_machine_harmonic_emission_pass=?, 
	                            telecom_machine_supplement_yes_no=?, telecom_machine_supplement=?, telecom_machine_supplement_pass=?, 
	                            air_conditioners_yes_no=?, air_conditioners_micb_yes_no=?, air_conditioners_micb_finding=?, 
	                            air_conditioners_micb_recommend=?, air_conditioners_micb_pass=?, air_conditioners_load_forecasting_yes_no=?, 
	                            air_conditioners_load_forecasting_finding=?, air_conditioners_load_forecasting_recommend=?, 
	                            air_conditioners_load_forecasting_pass=?, air_conditioners_type_yes_no=?, air_conditioners_type_finding=?, 
	                            air_conditioners_type_recommend=?, air_conditioners_type_pass=?, air_conditioners_supplement_yes_no=?, 
	                            air_conditioners_supplement=?, air_conditioners_supplement_pass=?, non_linear_load_yes_no=?, 
	                            non_linear_load_harmonic_emission_yes_no=?, non_linear_load_harmonic_emission_finding=?, 
	                            non_linear_load_harmonic_emission_recommend=?, non_linear_load_harmonic_emission_pass=?, 
	                            non_linear_load_supplement_yes_no=?, non_linear_load_supplement=?, non_linear_load_supplement_pass=?, 
	                            renewable_energy_yes_no=?, renewable_energy_inverter_and_controls_yes_no=?, renewable_energy_inverter_and_controls_finding=?, 
	                            renewable_energy_inverter_and_controls_recommend=?, renewable_energy_inverter_and_controls_pass=?, 
	                            renewable_energy_harmonic_emission_yes_no=?, renewable_energy_harmonic_emission_finding=?, 
	                            renewable_energy_harmonic_emission_recommend=?, renewable_energy_harmonic_emission_pass=?, 
	                            renewable_energy_supplement_yes_no=?, renewable_energy_supplement=?, renewable_energy_supplement_pass=?, 
	                            ev_charger_system_yes_no=?, ev_charger_system_ev_charger_yes_no=?, ev_charger_system_ev_charger_finding=?, 
	                            ev_charger_system_ev_charger_recommend=?, ev_charger_system_ev_charger_pass=?, ev_charger_system_harmonic_emission_yes_no=?, 
	                            ev_charger_system_harmonic_emission_finding=?, ev_charger_system_harmonic_emission_recommend=?, 
	                            ev_charger_system_harmonic_emission_pass=?, ev_charger_system_supplement_yes_no=?, 
	                            ev_charger_system_supplement=?, ev_charger_system_supplement_pass=?, 
	                            last_updated_by=?, last_updated_time=?
	                    WHERE evaluation_report_id=?';

                $stmt = Yii::app()->db->createCommand($sql);
                $result = $stmt->execute(array($txnEvaReportRemark,$txnEvaReportEdmsLink,$txnEvaReportIssueDate,
                    $txnEvaReportFaxRefNo,$txnEvaReportScore,$txnEvaReportBmsYesNo,$txnEvaReportBmsServerCentralComputerYesNo,
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
                    $txnEvaReportEscalatorSupplement,$txnEvaReportEscalatorSupplementPass,$txnEvaReportHidLampYesNo,
                    $txnEvaReportHidLampBallastYesNo,$txnEvaReportHidLampBallastFinding,$txnEvaReportHidLampBallastRecommend,
                    $txnEvaReportHidLampBallastPass,$txnEvaReportHidLampAddonProtectYesNo,$txnEvaReportHidLampAddonProtectFinding,
                    $txnEvaReportHidLampAddonProtectRecommend,$txnEvaReportHidLampAddonProtectPass,
                    $txnEvaReportHidLampSupplementYesNo,$txnEvaReportHidLampSupplement,$txnEvaReportHidLampSupplementPass,
                    $txnEvaReportLiftYesNo,$txnEvaReportLiftOperationYesNo,$txnEvaReportLiftOperationFinding,
                    $txnEvaReportLiftOperationRecommend,$txnEvaReportLiftOperationPass,$txnEvaReportLiftMainSupplyYesNo,
                    $txnEvaReportLiftMainSupplyFinding, $txnEvaReportLiftMainSupplyRecommend,$txnEvaReportLiftMainSupplyPass,
                    $txnEvaReportLiftSupplementYesNo, $txnEvaReportLiftSupplement,$txnEvaReportLiftSupplementPass,
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
                    $lastUpdatedBy,$lastUpdatedTime,$txnEvaReportId));
            }
        }

        $sql = 'UPDATE "tbl_planning_ahead" SET "project_title"=?, "scheme_no"=?, "region_id"=?, ';
        $sql = $sql . '"project_type_id"=?, "commission_date"=?, "key_infra"=?, "temp_project"=?, ';
        $sql = $sql . '"first_region_staff_name"=?, "first_region_staff_phone"=?, "first_region_staff_email"=?, ';
        $sql = $sql . '"second_region_staff_name"=?, "second_region_staff_phone"=?, "second_region_staff_email"=?, ';
        $sql = $sql . '"third_region_staff_name"=?, "third_region_staff_phone"=?, "third_region_staff_email"=?, ';
        $sql = $sql . '"first_consultant_title"=?, "first_consultant_surname"=?, "first_consultant_other_name"=?, ';
        $sql = $sql . '"first_consultant_company"=?, "first_consultant_phone"=?, "first_consultant_email"=?, ';
        $sql = $sql . '"second_consultant_title"=?, "second_consultant_surname"=?, "second_consultant_other_name"=?, ';
        $sql = $sql . '"second_consultant_company"=?, "second_consultant_phone"=?, "second_consultant_email"=?, ';
        $sql = $sql . '"third_consultant_title"=?, "third_consultant_surname"=?, "third_consultant_other_name"=?, ';
        $sql = $sql . '"third_consultant_company"=?, "third_consultant_phone"=?, "third_consultant_email"=?, ';
        $sql = $sql . '"first_project_owner_title"=?, "first_project_owner_surname"=?, "first_project_owner_other_name"=?, ';
        $sql = $sql . '"first_project_owner_company"=?, "first_project_owner_phone"=?, "first_project_owner_email"=?, ';
        $sql = $sql . '"second_project_owner_title"=?, "second_project_owner_surname"=?, "second_project_owner_other_name"=?, ';
        $sql = $sql . '"second_project_owner_company"=?, "second_project_owner_phone"=?, "second_project_owner_email"=?, ';
        $sql = $sql . '"third_project_owner_title"=?, "third_project_owner_surname"=?, "third_project_owner_other_name"=?, ';
        $sql = $sql . '"third_project_owner_company"=?, "third_project_owner_phone"=?, "third_project_owner_email"=?, ';
        $sql = $sql . '"stand_letter_issue_date"=?, "stand_letter_fax_ref_no"=?, "stand_letter_edms_link"=?, ';
        $sql = $sql . '"stand_letter_letter_loc"=?, ';
        $sql = $sql . '"meeting_first_prefer_meeting_date"=?, "meeting_second_prefer_meeting_date"=?, ';
        $sql = $sql . '"meeting_actual_meeting_date"=?, "meeting_rej_reason"=?, ';
        $sql = $sql . '"meeting_consent_consultant"=?, "meeting_consent_owner"=?, "meeting_remark"=?, ';
        $sql = $sql . '"first_invitation_letter_issue_date"=?, "first_invitation_letter_fax_ref_no"=?, ';
        $sql = $sql . '"first_invitation_letter_edms_link"=?, "first_invitation_letter_accept"=?, ';
        $sql = $sql . '"first_invitation_letter_walk_date"=?, ';
        $sql = $sql . '"second_invitation_letter_issue_date"=?, "second_invitation_letter_fax_ref_no"=?, ';
        $sql = $sql . '"second_invitation_letter_edms_link"=?, "second_invitation_letter_accept"=?, ';
        $sql = $sql . '"second_invitation_letter_walk_date"=?, ';
        $sql = $sql . '"third_invitation_letter_issue_date"=?, "third_invitation_letter_fax_ref_no"=?, ';
        $sql = $sql . '"third_invitation_letter_edms_link"=?, "third_invitation_letter_accept"=?, ';
        $sql = $sql . '"third_invitation_letter_walk_date"=?, ';
        $sql = $sql . '"forth_invitation_letter_issue_date"=?, "forth_invitation_letter_fax_ref_no"=?, ';
        $sql = $sql . '"forth_invitation_letter_edms_link"=?, "forth_invitation_letter_accept"=?, ';
        $sql = $sql . '"forth_invitation_letter_walk_date"=?, ';
        $sql = $sql . '"eva_report_id"=?, "state"=?, "last_updated_by"=?, "last_updated_time"=? ';
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
                $txnThirdConsultantTitle,$txnThirdConsultantSurname,$txnThirdConsultantOtherName,
                $txnThirdConsultantCompany,$txnThirdConsultantPhone,$txnThirdConsultantEmail,
                $txnFirstProjectOwnerTitle, $txnFirstProjectOwnerSurname, $txnFirstProjectOwnerOtherName,
                $txnFirstProjectOwnerCompany, $txnFirstProjectOwnerPhone, $txnFirstProjectOwnerEmail,
                $txnSecondProjectOwnerTitle, $txnSecondProjectOwnerSurname, $txnSecondProjectOwnerOtherName,
                $txnSecondProjectOwnerCompany, $txnSecondProjectOwnerPhone, $txnSecondProjectOwnerEmail,
                $txnThirdProjectOwnerTitle, $txnThirdProjectOwnerSurname, $txnThirdProjectOwnerOtherName,
                $txnThirdProjectOwnerCompany, $txnThirdProjectOwnerPhone, $txnThirdProjectOwnerEmail,
                $txnStandLetterIssueDate,$txnStandLetterFaxRefNo,$txnStandLetterEdmsLink,
                $txnStandLetterLetterLoc,$txnMeetingFirstPreferMeetingDate,$txnMeetingSecondPreferMeetingDate,
                $txnMeetingActualMeetingDate,$txnMeetingRejReason,$txnMeetingConsentConsultant,$txnMeetingConsentOwner,
                $txnMeetingRemark,
                $txnFirstInvitationLetterIssueDate,$txnFirstInvitationLetterFaxRefNo,
                $txnFirstInvitationLetterEdmsLink, $txnFirstInvitationLetterAccept,$txnFirstInvitationLetterWalkDate,
                $txnSecondInvitationLetterIssueDate,$txnSecondInvitationLetterFaxRefNo,
                $txnSecondInvitationLetterEdmsLink, $txnSecondInvitationLetterAccept,$txnSecondInvitationLetterWalkDate,
                $txnThirdInvitationLetterIssueDate,$txnThirdInvitationLetterFaxRefNo,
                $txnThirdInvitationLetterEdmsLink, $txnThirdInvitationLetterAccept,$txnThirdInvitationLetterWalkDate,
                $txnForthInvitationLetterIssueDate,$txnForthInvitationLetterFaxRefNo,
                $txnForthInvitationLetterEdmsLink, $txnForthInvitationLetterAccept,$txnForthInvitationLetterWalkDate,
                $txnEvaReportId,
                $txnNewState, $lastUpdatedBy, $lastUpdatedTime,
                $txnPlanningAheadId));

            if (isset($txnFirstProjectOwnerCompany) && (trim($txnFirstProjectOwnerCompany) != "")) {
                $this->updateProjectOwnerCompanyByName($txnFirstProjectOwnerCompany,$lastUpdatedBy,$lastUpdatedTime);
            }

            if (isset($txnSecondProjectOwnerCompany) && (trim($txnSecondProjectOwnerCompany) != "")) {
                $this->updateProjectOwnerCompanyByName($txnSecondProjectOwnerCompany,$lastUpdatedBy,$lastUpdatedTime);
            }

            if (isset($txnThirdProjectOwnerCompany) && (trim($txnThirdProjectOwnerCompany) != "")) {
                $this->updateProjectOwnerCompanyByName($txnThirdProjectOwnerCompany,$lastUpdatedBy,$lastUpdatedTime);
            }

            if ($txnMeetingReplySlipId>0) {
                $sql = 'UPDATE "tbl_slip_reply" SET "bms_yes_no"=?, "bms_server_central_computer"=?,
                            "bms_ddc"=?, "changeover_scheme_yes_no"=?, "changeover_scheme_control"=?, 
                            "changeover_scheme_uv"=?, "chiller_plant_yes_no"=?, "chiller_plant_ahu_control"=?,
                            "chiller_plant_ahu_startup"=?, "chiller_plant_vsd"=?, "chiller_plant_ahu_chilled_water"=?,
                            "chiller_plant_standby_ahu"=?, "chiller_plant_chiller"=?, "escalator_yes_no"=?, 
                            "escalator_motor_startup"=?, "escalator_vsd_mitigation"=?, "escalator_braking_system"=?, 
                            "escalator_control"=?, "hid_lamp_yes_no"=?, "hid_lamp_mitigation"=?, 
                            "lift_yes_no"=?, "lift_operation"=?, "sensitive_machine_yes_no"=?,
                            "sensitive_machine_mitigation"=?, "telecom_machine_yes_no"=?, 
                            "telecom_machine_server_or_computer"=?, "telecom_machine_peripherals"=?, 
                            "telecom_machine_harmonic_emission"=?, "air_conditioners_yes_no"=?, 
                            "air_conditioners_micb"=?, "air_conditioners_load_forecasting"=?, 
                            "air_conditioners_type"=?, "non_linear_load_yes_no"=?, "non_linear_load_harmonic_emission"=?, 
                            "renewable_energy_yes_no"=?, "renewable_energy_inverter_and_controls"=?, 
                            "renewable_energy_harmonic_emission"=?, "ev_charger_system_yes_no"=?, "ev_control_yes_no"=?, 
                            "ev_charger_system_ev_charger"=?, "ev_charger_system_smart_yes_no"=?, 
                            "ev_charger_system_smart_charging_system"=?, "ev_charger_system_harmonic_emission"=?, 
                            "consultant_name_confirmation"=?, "consultant_company"=?, 
                            "project_owner_name_confirmation"=?, "project_owner_company"=?, 
                            "last_updated_by"=?, "last_updated_time"=? 
                            WHERE "reply_slip_id"=?';

                $stmt = Yii::app()->db->createCommand($sql);
                $result = $stmt->execute(array($txnReplySlipBmsYesNo,$txnReplySlipBmsServerCentralComputer,
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

    public function updateProjectOwnerCompanyByName($name,$lastUpdatedBy,$lastUpdatedTime) {

        $sql = "SELECT * FROM \"tbl_project_owner_company\" WHERE upper(\"project_owner_company_name\") = upper(trim(:project_owner_company_name))";
        $sth = Yii::app()->db->createCommand($sql);
        $sth->bindParam(':project_owner_company_name', $name);
        $result = $sth->queryAll();

        if (!(count($result) > 0)) {
            $sql = 'INSERT INTO "tbl_project_owner_company"("project_owner_company_name", "active", "created_by", 
                                    "created_time", "last_updated_by", "last_updated_time") VALUES (?,?,?,?,?,?)';
            $stmt = Yii::app()->db->createCommand($sql);
            $result = $stmt->execute(array($name,"Y",$lastUpdatedBy,$lastUpdatedTime,$lastUpdatedBy,$lastUpdatedTime));
            $retJson['status'] = 'OK';
        }

    }

    public function updateStandardLetter($txnPlanningAheadId, $standLetterIssueDate, $standLetterFaxRefNo,
                                         $lastUpdatedBy,$lastUpdatedTime) {

        $sql = 'UPDATE "tbl_planning_ahead" SET "stand_letter_issue_date"=?, "stand_letter_fax_ref_no"=?, ';
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

    public function updateThirdInvitationLetter($txnPlanningAheadId,$firstInvitationLetterIssueDate,$firstInvitationLetterFaxRefNo,
                                                $secondInvitationLetterIssueDate,$secondInvitationLetterFaxRefNo,
                                                $thirdInvitationLetterIssueDate,$thirdInvitationLetterFaxRefNo,
                                                $lastUpdatedBy,$lastUpdatedTime) {

        $sql = 'UPDATE "tbl_planning_ahead" SET 
                                "first_invitation_letter_issue_date"=?, "first_invitation_letter_fax_ref_no"=?, 
                                "second_invitation_letter_issue_date"=?, "second_invitation_letter_fax_ref_no"=?, 
                                "third_invitation_letter_issue_date"=?, "third_invitation_letter_fax_ref_no"=?, 
                                "last_updated_by"=?, "last_updated_time"=? 
                                WHERE "planning_ahead_id"=?';

        try {
            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array($firstInvitationLetterIssueDate,$firstInvitationLetterFaxRefNo,
                $secondInvitationLetterIssueDate,$secondInvitationLetterFaxRefNo,
                $thirdInvitationLetterIssueDate,$thirdInvitationLetterFaxRefNo,
                $lastUpdatedBy,$lastUpdatedTime,$txnPlanningAheadId));
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

    public function updateForthInvitationLetter($txnPlanningAheadId, $forthInvitationLetterIssueDate,
                                                $forthInvitationLetterFaxRefNo, $lastUpdatedBy,$lastUpdatedTime) {

        $sql = 'UPDATE "tbl_planning_ahead" SET "forth_invitation_letter_issue_date"=?, "forth_invitation_letter_fax_ref_no"=?, ';
        $sql = $sql . '"last_updated_by"=?, "last_updated_time"=? ';
        $sql = $sql . 'WHERE "planning_ahead_id"=?';

        try {
            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array($forthInvitationLetterIssueDate,$forthInvitationLetterFaxRefNo,
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

    public function addReplySlip($schemeNo,$state,$replySlipLoc,$meetingRejReason,$meetingFirstPreferMeetingDate,
                                 $meetingSecondPreferMeetingDate,$meetingConsentConsultant,$meetingConsentOwner,
                                 $bmsYesNo,$bmsServerCentralComputer,$bmsDdc,
                                 $changeoverSchemeYesNo,$changeoverSchemeControl,$changeoverSchemeUv,
                                 $chillerPlantYesNo,$chillerPlantAhuControl,$chillerPlantAhuStartup,
                                 $chillerPlantVsd,$chillerPlantAhuChilledWater,$chillerPlantStandbyAhu,
                                 $chillerPlantChiller,$escalatorYesNo,$escalatorMotorStartup,
                                 $escalatorVsdMitigation,$escalatorBrakingSystem,$escalatorControl,
                                 $liftYesNo,$liftOperation,$hidLampYesNo,$hidLampMitigation,
                                 $sensitiveMachineYesNo,$sensitiveMachineMitigation,
                                 $telecomMachineYesNo,$telecomMachineServerOrComputer,$telecomMachinePeripherals,
                                 $telecomMachineHarmonicEmission,$airConditionersYesNo,$airConditionersMicb,
                                 $airConditionersLoadForecasting,$airConditionersType,$nonLinearLoadYesNo,
                                 $nonLinearLoadHarmonicEmission,$renewableEnergyYesNo,$renewableEnergyInverterAndControls,
                                 $renewableEnergyHarmonicEmission,$evChargerSystemYesNo,$evControlYesNo,
                                 $evChargerSystemEvCharger,$evChargerSystemSmartYesNo,
                                 $evChargerSystemSmartChargingSystem,$evChargerSystemHarmonicEmission,
                                 $consultantNameConfirmation,$consultantCompany,
                                 $projectOwnerNameConfirmation,$projectOwnerCompany,
                                 $createdBy,$createdTime,$lastUpdatedBy,$lastUpdatedTime,$lastUploadTime) {

        $sql = 'INSERT INTO "tbl_slip_reply" ("reply_slip_loc","scheme_no", "bms_yes_no","bms_server_central_computer",
                              "bms_ddc","changeover_scheme_yes_no","changeover_scheme_control","changeover_scheme_uv",
                              "chiller_plant_yes_no","chiller_plant_ahu_control","chiller_plant_ahu_startup",
                              "chiller_plant_vsd","chiller_plant_ahu_chilled_water","chiller_plant_standby_ahu",
                              "chiller_plant_chiller","escalator_yes_no","escalator_motor_startup","escalator_vsd_mitigation",
                              "escalator_braking_system","escalator_control","lift_yes_no","lift_operation",
                              "hid_lamp_yes_no","hid_lamp_mitigation","sensitive_machine_yes_no",
                              "sensitive_machine_mitigation","telecom_machine_yes_no","telecom_machine_server_or_computer",
                              "telecom_machine_peripherals","telecom_machine_harmonic_emission","air_conditioners_yes_no",
                              "air_conditioners_micb","air_conditioners_load_forecasting","air_conditioners_type",
                              "non_linear_load_yes_no","non_linear_load_harmonic_emission","renewable_energy_yes_no",
                              "renewable_energy_inverter_and_controls","renewable_energy_harmonic_emission",
                              "ev_charger_system_yes_no","ev_control_yes_no","ev_charger_system_ev_charger",
                              "ev_charger_system_smart_yes_no","ev_charger_system_smart_charging_system",
                              "ev_charger_system_harmonic_emission",
                              "consultant_name_confirmation","consultant_company",
                              "project_owner_name_confirmation","project_owner_company",
                              "created_by","created_time",
                              "last_updated_by","last_updated_time","last_upload_time") 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ';

        try {
            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array($replySlipLoc,$schemeNo,$bmsYesNo,$bmsServerCentralComputer,$bmsDdc,
                $changeoverSchemeYesNo,$changeoverSchemeControl,$changeoverSchemeUv,
                $chillerPlantYesNo,$chillerPlantAhuControl,$chillerPlantAhuStartup,
                $chillerPlantVsd,$chillerPlantAhuChilledWater,$chillerPlantStandbyAhu,
                $chillerPlantChiller,$escalatorYesNo,$escalatorMotorStartup,
                $escalatorVsdMitigation,$escalatorBrakingSystem,$escalatorControl,
                $liftYesNo,$liftOperation,$hidLampYesNo,$hidLampMitigation,
                $sensitiveMachineYesNo,$sensitiveMachineMitigation,
                $telecomMachineYesNo,$telecomMachineServerOrComputer,$telecomMachinePeripherals,
                $telecomMachineHarmonicEmission,$airConditionersYesNo,$airConditionersMicb,
                $airConditionersLoadForecasting,$airConditionersType,$nonLinearLoadYesNo,
                $nonLinearLoadHarmonicEmission,$renewableEnergyYesNo,$renewableEnergyInverterAndControls,
                $renewableEnergyHarmonicEmission,$evChargerSystemYesNo,$evControlYesNo,
                $evChargerSystemEvCharger,$evChargerSystemSmartYesNo,
                $evChargerSystemSmartChargingSystem,$evChargerSystemHarmonicEmission,
                $consultantNameConfirmation,$consultantCompany,
                $projectOwnerNameConfirmation,$projectOwnerCompany,
                $createdBy,$createdTime,$lastUpdatedBy,$lastUpdatedTime,$lastUploadTime));

            if ($result) {
                $sql = "SELECT \"reply_slip_id\" FROM \"tbl_slip_reply\" WHERE \"scheme_no\"=:scheme_no";

                $sth = Yii::app()->db->createCommand($sql);
                $sth->bindParam(':scheme_no', $schemeNo);
                $result = $sth->queryAll();

                foreach($result as $row) {
                    $replySlipId = $row['reply_slip_id'];
                }

                if (isset($replySlipId)) {

                    if (isset($state) && $state == 'WAITING_CONSULTANT_MEETING_INFO') {
                        $newState = "COMPLETED_CONSULTANT_MEETING_INFO";
                    } else {
                        $newState = $state;
                    }

                    $sql = 'UPDATE "tbl_planning_ahead" SET "meeting_reply_slip_id"=?,  
                                "meeting_first_prefer_meeting_date"=?, "meeting_second_prefer_meeting_date"=?,
                                "meeting_rej_reason"=?, "meeting_consent_consultant"=?,
                                "meeting_consent_owner"=?, "state"=?, "last_updated_by"=?, "last_updated_time"=?
                                WHERE "scheme_no"=?';
                    $stmt = Yii::app()->db->createCommand($sql);
                    $result = $stmt->execute(array($replySlipId,$meetingFirstPreferMeetingDate,$meetingSecondPreferMeetingDate,
                        $meetingRejReason,$meetingConsentConsultant,$meetingConsentOwner,$newState,$lastUpdatedBy,
                        $lastUpdatedTime,$schemeNo));
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

    public function updateReplySlip($schemeNo,$state,$replySlipId,$replySlipLoc,$meetingRejReason,$meetingFirstPreferMeetingDate,
                                    $meetingSecondPreferMeetingDate,$meetingConsentConsultant,$meetingConsentOwner,
                                    $bmsYesNo,$bmsServerCentralComputer,$bmsDdc,
                                    $changeoverSchemeYesNo,$changeoverSchemeControl,$changeoverSchemeUv,
                                    $chillerPlantYesNo,$chillerPlantAhuControl,$chillerPlantAhuStartup,
                                    $chillerPlantVsd,$chillerPlantAhuChilledWater,$chillerPlantStandbyAhu,
                                    $chillerPlantChiller,$escalatorYesNo,$escalatorMotorStartup,
                                    $escalatorVsdMitigation,$escalatorBrakingSystem,$escalatorControl,
                                    $liftYesNo,$liftOperation,$hidLampYesNo,$hidLampMitigation,
                                    $sensitiveMachineYesNo,$sensitiveMachineMitigation,
                                    $telecomMachineYesNo,$telecomMachineServerOrComputer,$telecomMachinePeripherals,
                                    $telecomMachineHarmonicEmission,$airConditionersYesNo,$airConditionersMicb,
                                    $airConditionersLoadForecasting,$airConditionersType,$nonLinearLoadYesNo,
                                    $nonLinearLoadHarmonicEmission,$renewableEnergyYesNo,$renewableEnergyInverterAndControls,
                                    $renewableEnergyHarmonicEmission,$evChargerSystemYesNo,$evControlYesNo,
                                    $evChargerSystemEvCharger,$evChargerSystemSmartYesNo,
                                    $evChargerSystemSmartChargingSystem,$evChargerSystemHarmonicEmission,
                                    $consultantNameConfirmation,$consultantCompany,
                                    $projectOwnerNameConfirmation,$projectOwnerCompany,
                                    $lastUpdatedBy,$lastUpdatedTime,$lastUploadTime) {
        $sql = 'UPDATE "tbl_slip_reply" SET "reply_slip_loc"=?, "bms_yes_no"=?, "bms_server_central_computer"=?,
                            "bms_ddc"=?, "changeover_scheme_yes_no"=?, "changeover_scheme_control"=?, 
                            "changeover_scheme_uv"=?, "chiller_plant_yes_no"=?, "chiller_plant_ahu_control"=?,
                            "chiller_plant_ahu_startup"=?, "chiller_plant_vsd"=?, "chiller_plant_ahu_chilled_water"=?,
                            "chiller_plant_standby_ahu"=?, "chiller_plant_chiller"=?, "escalator_yes_no"=?, 
                            "escalator_motor_startup"=?, "escalator_vsd_mitigation"=?, "escalator_braking_system"=?, 
                            "escalator_control"=?, "hid_lamp_yes_no"=?, "hid_lamp_mitigation"=?, 
                            "lift_yes_no"=?, "lift_operation"=?, "sensitive_machine_yes_no"=?,
                            "sensitive_machine_mitigation"=?, "telecom_machine_yes_no"=?, 
                            "telecom_machine_server_or_computer"=?, "telecom_machine_peripherals"=?, 
                            "telecom_machine_harmonic_emission"=?, "air_conditioners_yes_no"=?, 
                            "air_conditioners_micb"=?, "air_conditioners_load_forecasting"=?, 
                            "air_conditioners_type"=?, "non_linear_load_yes_no"=?, "non_linear_load_harmonic_emission"=?, 
                            "renewable_energy_yes_no"=?, "renewable_energy_inverter_and_controls"=?, 
                            "renewable_energy_harmonic_emission"=?, "ev_charger_system_yes_no"=?, "ev_control_yes_no"=?, 
                            "ev_charger_system_ev_charger"=?, "ev_charger_system_smart_yes_no"=?, 
                            "ev_charger_system_smart_charging_system"=?, "ev_charger_system_harmonic_emission"=?, 
                            "consultant_name_confirmation"=?, "consultant_company"=?,
                            "project_owner_name_confirmation"=?, "project_owner_company"=?,
                            "last_updated_by"=?, "last_updated_time"=?, "last_upload_time"=? WHERE "reply_slip_id"=?';

        try {
            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();
            $stmt = Yii::app()->db->createCommand($sql);

            $result = $stmt->execute(array($replySlipLoc,$bmsYesNo,$bmsServerCentralComputer,$bmsDdc,
                $changeoverSchemeYesNo,$changeoverSchemeControl,$changeoverSchemeUv,
                $chillerPlantYesNo,$chillerPlantAhuControl,$chillerPlantAhuStartup,
                $chillerPlantVsd,$chillerPlantAhuChilledWater,$chillerPlantStandbyAhu,
                $chillerPlantChiller,$escalatorYesNo,$escalatorMotorStartup,
                $escalatorVsdMitigation,$escalatorBrakingSystem,$escalatorControl,
                $hidLampYesNo,$hidLampMitigation,$liftYesNo,$liftOperation,
                $sensitiveMachineYesNo,$sensitiveMachineMitigation,
                $telecomMachineYesNo,$telecomMachineServerOrComputer,$telecomMachinePeripherals,
                $telecomMachineHarmonicEmission,$airConditionersYesNo,$airConditionersMicb,
                $airConditionersLoadForecasting,$airConditionersType,$nonLinearLoadYesNo,
                $nonLinearLoadHarmonicEmission,$renewableEnergyYesNo,$renewableEnergyInverterAndControls,
                $renewableEnergyHarmonicEmission,$evChargerSystemYesNo,$evControlYesNo,
                $evChargerSystemEvCharger,$evChargerSystemSmartYesNo,
                $evChargerSystemSmartChargingSystem,$evChargerSystemHarmonicEmission,
                $consultantNameConfirmation,$consultantCompany,
                $projectOwnerNameConfirmation,$projectOwnerCompany,
                $lastUpdatedBy,$lastUpdatedTime,$lastUploadTime,$replySlipId));


            if (isset($state) && $state == 'WAITING_CONSULTANT_MEETING_INFO') {
                $newState = "COMPLETED_CONSULTANT_MEETING_INFO";
            } else {
                $newState = $state;
            }
            $sql = 'UPDATE "tbl_planning_ahead" SET "meeting_reply_slip_id"=?,  
                                "meeting_first_prefer_meeting_date"=?, "meeting_second_prefer_meeting_date"=?,
                                "meeting_rej_reason"=?, "meeting_consent_consultant"=?, "meeting_consent_owner"=?,  
                                "state"=?, "last_updated_by"=?, "last_updated_time"=?
                                WHERE "scheme_no"=?';

            $stmt = Yii::app()->db->createCommand($sql);
            $result = $stmt->execute(array($replySlipId,$meetingFirstPreferMeetingDate,$meetingSecondPreferMeetingDate,
                $meetingRejReason,$meetingConsentConsultant,$meetingConsentOwner,$newState,$lastUpdatedBy,
                $lastUpdatedTime,$schemeNo));

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

    public function updateReplySlipGeneratedLocation($replySlipId, $fileLocation, $lastUpdateBy, $lastUpdateTime) {
        $sql = 'UPDATE "tbl_slip_reply" SET "reply_slip_loc"=?,  
                                "last_updated_by"=?, "last_updated_time"=?
                                WHERE "reply_slip_id"=?';

        try {
            $transaction = Yii::app()->db->beginTransaction();
            $stmt = Yii::app()->db->createCommand($sql);
            $result = $stmt->execute(array($fileLocation, $lastUpdateBy, $lastUpdateTime, $replySlipId));

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

