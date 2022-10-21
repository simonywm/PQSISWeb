<?php
require_once('Encoding.php');
use \ForceUTF8\Encoding;

class PlanningAheadDao extends CApplicationComponent {

    public function getPlanningAheadDetails($schemeNo) {

        $record = array();
        try {
            $sql = 'SELECT * FROM "tbl_planning_ahead" a LEFT JOIN "tbl_region" b on a."region_id" = b."region_id" LEFT JOIN "TblConsultantCompany" c on a."first_consultant_company" = c."consultantCompanyId" WHERE "scheme_no"::text = :schemeNo';
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
                $record['firstConsultantCompanyId'] = $result[0]['consultantCompanyId'];
                $record['firstConsultantCompanyName'] = Encoding::escapleAllCharacter($result[0]['consultantCompanyName']);
                $record['firstConsultantPhone'] = Encoding::escapleAllCharacter($result[0]['first_consultant_phone']);
                $record['firstConsultantEmail'] = Encoding::escapleAllCharacter($result[0]['first_consultant_email']);
                $record['secondConsultantTitle'] = Encoding::escapleAllCharacter($result[0]['second_consultant_title']);
                $record['secondConsultantSurname'] = Encoding::escapleAllCharacter($result[0]['second_consultant_surname']);
                $record['secondConsultantOtherName'] = Encoding::escapleAllCharacter($result[0]['second_consultant_other_name']);
                $record['secondConsultantCompany'] = Encoding::escapleAllCharacter($result[0]['second_consultant_company']);
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
                $record['standLetterIssueDate'] = $result[0]['stand_letter_issue_date'];
                $record['standLetterFaxRefNo'] = Encoding::escapleAllCharacter($result[0]['stand_letter_fax_ref_no']);
                $record['standLetterEdmsLink'] = Encoding::escapleAllCharacter($result[0]['stand_letter_edms_link']);
                $record['standLetterLetterLoc'] = Encoding::escapleAllCharacter($result[0]['stand_letter_letter_loc']);
                $record['meetingFirstPreferMeetingDate'] = $result[0]['meeting_first_prefer_meeting_date'];
                $record['meetingSecondPreferMeetingDate'] = $result[0]['meeting_second_prefer_meeting_date'];
                $record['meetingActualMeetingDate'] = $result[0]['meeting_actual_meeting_date'];
                $record['meetingRejReason'] = Encoding::escapleAllCharacter($result[0]['meeting_rej_reason']);
                $record['meetingConsentConsultant'] = $result[0]['meeting_consent_consultant'];
                $record['meetingConsentOwner'] = $result[0]['meeting_consent_owner'];
                $record['meetingReplySlipId'] = $result[0]['meeting_reply_slip_id'];
                $record['firstInvitationLetterIssueDate'] = $result[0]['first_invitation_letter_issue_date'];
                $record['firstInvitationLetterFaxRefNo'] = Encoding::escapleAllCharacter($result[0]['first_invitation_letter_fax_ref_no']);
                $record['firstInvitationLetterEdmsLink'] = Encoding::escapleAllCharacter($result[0]['first_invitation_letter_edms_link']);
                $record['firstInvitationLetterAccept'] = $result[0]['first_invitation_letter_accept'];
                $record['firstInvitationLetterWalkDate'] = $result[0]['first_invitation_letter_walk_date'];
                $record['secondInvitationLetterIssueDate'] = $result[0]['second_invitation_letter_issue_date'];
                $record['secondInvitationLetterFaxRefNo'] = Encoding::escapleAllCharacter($result[0]['second_invitation_letter_fax_ref_no']);
                $record['secondInvitationLetterEdmsLink'] = Encoding::escapleAllCharacter($result[0]['second_invitation_letter_edms_link']);
                $record['secondInvitationLetterAccept'] = $result[0]['second_invitation_letter_accept'];
                $record['secondInvitationLetterWalkDate'] = $result[0]['second_invitation_letter_walk_date'];
                $record['thirdInvitationLetterIssueDate'] = $result[0]['third_invitation_letter_issue_date'];
                $record['thirdInvitationLetterFaxRefNo'] = Encoding::escapleAllCharacter($result[0]['third_invitation_letter_fax_ref_no']);
                $record['thirdInvitationLetterEdmsLink'] = Encoding::escapleAllCharacter($result[0]['third_invitation_letter_edms_link']);
                $record['thirdInvitationLetterAccept'] = $result[0]['third_invitation_letter_accept'];
                $record['thirdInvitationLetterWalkDate'] = $result[0]['third_invitation_letter_walk_date'];
                $record['forthInvitationLetterIssueDate'] = $result[0]['forth_invitation_letter_issue_date'];
                $record['forthInvitationLetterFaxRefNo'] = Encoding::escapleAllCharacter($result[0]['forth_invitation_letter_fax_ref_no']);
                $record['forthInvitationLetterEdmsLink'] = Encoding::escapleAllCharacter($result[0]['forth_invitation_letter_edms_link']);
                $record['forthInvitationLetterAccept'] = $result[0]['forth_invitation_letter_accept'];
                $record['forthInvitationLetterWalkDate'] = $result[0]['forth_invitation_letter_walk_date'];
                $record['evaReportId'] = $result[0]['eva_report_id'];
                $record['state'] = $result[0]['state'];
                $record['active'] = $result[0]['active'];
                $record['createdBy'] = $result[0]['created_by'];
                $record['createdTime'] = $result[0]['created_time'];
                $record['lastUpdatedBy'] = $result[0]['last_updated_by'];
                $record['lastUpdatedTime'] = $result[0]['last_updated_time'];
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $record;
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
                                                   $txnProjectOwnerTitle,$txnProjectOwnerSurname,$txnProjectOwnerOtherName,
                                                   $txnProjectOwnerCompany,$txnProjectOwnerPhone,$txnProjectOwnerEmail,
                                                   $txnStandLetterIssueDate,$txnStandLetterFaxRefNo,
                                                   $lastUpdatedBy,$lastUpdatedTime,
                                                   $txnPlanningAheadId) {

        $sql = 'UPDATE "tbl_planning_ahead" SET "project_title"=?, "scheme_no"=?, "region_id"=?, ';
        $sql = $sql . '"project_type_id"=?, "commission_date"=?, "key_infra"=?, "temp_project"=?, ';
        $sql = $sql . '"first_region_staff_name"=?, "first_region_staff_phone"=?, "first_region_staff_email"=?, ';
        $sql = $sql . '"second_region_staff_name"=?, "second_region_staff_phone"=?, "second_region_staff_email"=?, ';
        $sql = $sql . '"third_region_staff_name"=?, "third_region_staff_phone"=?, "third_region_staff_email"=?, ';
        $sql = $sql . '"first_consultant_title"=?, "first_consultant_surname"=?, "first_consultant_other_name"=?, ';
        $sql = $sql . '"first_consultant_company"=?, "first_consultant_phone"=?, "first_consultant_email"=?, ';
        $sql = $sql . '"project_owner_title"=?, "project_owner_surname"=?, "project_owner_other_name"=?, ';
        $sql = $sql . '"project_owner_company"=?, "project_owner_phone"=?, "project_owner_email"=?, ';
        $sql = $sql . '"stand_letter_issue_date"=?, "stand_letter_fax_ref_no"=?, ';
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
                $txnStandLetterIssueDate,$txnStandLetterFaxRefNo,
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

        return $retJson;

    }

    public function updatePlanningAheadDetailProcess($txnProjectTitle,$txnSchemeNo,$txnRegion,
                                                     $txnTypeOfProject,$txnCommissionDate,$txnKeyInfra,$txnTempProj,
                                                     $txnFirstRegionStaffName,$txnFirstRegionStaffPhone,$txnFirstRegionStaffEmail,
                                                     $txnSecondRegionStaffName,$txnSecondRegionStaffPhone,$txnSecondRegionStaffEmail,
                                                     $txnThirdRegionStaffName,$txnThirdRegionStaffPhone,$txnThirdRegionStaffEmail,
                                                     $txnFirstConsultantTitle,$txnFirstConsultantSurname,$txnFirstConsultantOtherName,
                                                     $txnFirstConsultantCompany,$txnFirstConsultantPhone,$txnFirstConsultantEmail,
                                                     $txnProjectOwnerTitle,$txnProjectOwnerSurname,$txnProjectOwnerOtherName,
                                                     $txnProjectOwnerCompany,$txnProjectOwnerPhone,$txnProjectOwnerEmail,$txnNewState,
                                                     $lastUpdatedBy,$lastUpdatedTime,
                                                     $txnPlanningAheadId)
    {

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
                $txnProjectOwnerTitle, $txnProjectOwnerSurname, $txnProjectOwnerOtherName,
                $txnProjectOwnerCompany, $txnProjectOwnerPhone, $txnProjectOwnerEmail, $txnNewState,
                $lastUpdatedBy, $lastUpdatedTime,
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
}

