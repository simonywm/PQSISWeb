<?php
require_once('Encoding.php');
use \ForceUTF8\Encoding;

/**
 * CommonUtil.php
 * All common method will be in this common util. This util will act as component and init in the main.php
 */
class FormDao extends CApplicationComponent
{
    private $generatedId = "";

    public function getGeneratedId()
    {
        $this->generatedId = date('ymdHis') . rand(100, 999);

        return $this->generatedId;
    }

    public function getId()
    {
        if ($this->generateId == "" || $this->generateId == null) {
            $this->generatedId();
        }

        return $this->generatedId();
    }

    public function getSystemDate()
    {
        $systemDate = "sysdate()";

        return $systemDate;
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    public function getUser($user_name)
    {
        $elementList = array();
        
        try {
            $sql = "SELECT  * FROM \"TblUser\" WHERE \"loginId\" = :loginId and active ='Y' ";
            //$stmt = $database->prepare($sql);
            //$result= $stmt->execute(array($user_name));

            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(':loginId',$user_name, PDO::PARAM_STR);
            //$model = $command->queryRow();
            $result = $command->queryAll();

            /*
            if(!$result){
				throw new Exception($stmt->errorInfo()[2], $stmt->errorInfo()[1]);
				
			}
            */
            //while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $elementList['userId'] = $row['userId'];
                $elementList['loginId'] = $row['loginId'];
                $elementList['password'] = $row['password'];
                $elementList['roleId'] = $row['roleId'];
                $elementList['status'] = 'Success';
            }
            //}

        } catch (PDOException $e) {

            $elementList['status'] = $e->getMessage();

        }

        return $elementList;

    }

    public function getEditRight()
    {
        $elementList = array();
        $model = array();

        try {
            //$sql = "SELECT TOP 1 * FROM TblEditRight";
            $sql = "SELECT * FROM \"TblEditRight\" LIMIT 1";

            //$result = $database->query($sql);

            $command = Yii::app()->db->createCommand($sql);
            $model = $command->queryRow();

            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $elementList['editRightUserId'] = $model['editRightUserId'];
                $elementList['editRightOnUse'] = $model['editRightOnUse'];
                $elementList['editRightLastEditTime'] = $model['editRightLastEditTime'];
                $elementList['status'] = 'Success';
            //}
        } catch (PDOException $e) {

            $elementList['status'] = $e->getMessage();

        }

        return $elementList;

    }
    public function updateEditRight($userId, $boolean)
    {
        try {
            if ($boolean) {
                $sql = "UPDATE \"TblEditRight\" SET \"editRightUserId\" = ?,\"editRightOnUse\"=True, \"editRightLastEditTime\" = ? WHERE \"editRightId\" = (SELECT \"editRightId\" FROM \"TblEditRight\" ORDER BY \"editRightId\" asc LIMIT 1)";
            } else {
                $sql = "UPDATE \"TblEditRight\" SET \"editRightUserId\" = ?,\"editRightOnUse\"=False, \"editRightLastEditTime\" = ? WHERE \"editRightId\" = (SELECT \"editRightId\" FROM \"TblEditRight\" ORDER BY \"editRightId\" asc LIMIT 1)";
            }

            //$stmt = $database->prepare($sql);
            //$stmt->execute(array($userId, date('d/m/Y H:i:s')));

            $date=date('Y-m-d H:i:s');
            $command = Yii::app()->db->createCommand($sql);
            $command->execute(array($userId, $date));

            $status = 'Success';
        } catch (PDOException $e) {

            $status = 'Fail';
        }

        return $status;

    }
    public function getFormCaseNoMax()
    {

        try {
            $sql = "SELECT Max(\"parentCaseNo\") as \"parentCaseNoMax\" FROM \"TblServiceCase\"";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $value = $row['parentCaseNoMax'];

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $value;
    }

    public function getFormServiceTypeAll()
    {

        try {
            //$sql = "SELECT * FROM TblServiceType ORDER BY Cint(showOrder) ASC ";
            $sql = "SELECT * FROM \"TblServiceType\" ORDER BY \"showOrder\"::NUMERIC  ASC ";
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();            
            $serviceTypeList = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $serviceType['serviceTypeId'] = $row['serviceTypeId'];
                $serviceType['serviceTypeName'] = Encoding::escapleAllCharacter($row['serviceTypeName']);  
                array_push($serviceTypeList, $serviceType);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $serviceTypeList;
    }
    public function getFormServiceTypeActive()
    {

        try {

            //$sql = "SELECT * FROM TblServiceType WHERE active ='Y' ORDER BY Cint(showOrder) ASC ";
            $sql = "SELECT * FROM \"TblServiceType\" WHERE \"active\" ='Y' ORDER BY \"showOrder\"::NUMERIC ASC ";

            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $serviceTypeList = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $serviceType['serviceTypeId'] = $row['serviceTypeId'];
                $serviceType['serviceTypeName'] = Encoding::escapleAllCharacter($row['serviceTypeName']);  
                array_push($serviceTypeList, $serviceType);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $serviceTypeList;
    }

    public function getFormProblemTypeAll()
    {

        try {
 
            $sql = "SELECT * FROM \"TblProblemType\"";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $problemTypeList = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) {    
                $problemType['problemTypeId'] = $row['problemTypeId'];
                $problemType['problemTypeName'] = Encoding::escapleAllCharacter($row['problemTypeName']);  
                array_push($problemTypeList, $problemType);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $problemTypeList;
    }
    public function getFormProblemTypeActive()
    {

        try {
            $sql = "SELECT * FROM \"TblProblemType\" WHERE active ='Y' ";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $problemTypeList = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $problemType['problemTypeId'] = $row['problemTypeId'];
                $problemType['problemTypeName'] = Encoding::escapleAllCharacter($row['problemTypeName']);  
                array_push($problemTypeList, $problemType);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $problemTypeList;
    }

    public function getFormClpReferredByAll()
    {

        try {

            $sql = "SELECT * FROM \"TblClpReferredBy\" ORDER BY \"clpReferredByName\" asc ";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $clpReferredBy['clpReferredById'] = $row['clpReferredById'];
                $clpReferredBy['clpReferredByName'] = Encoding::escapleAllCharacter($row['clpReferredByName']);  
                array_push($List, $clpReferredBy);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormClpReferredByActive()
    {

        try {
            $sql = "SELECT * FROM \"TblClpReferredBy\" WHERE \"active\" ='Y' ORDER BY \"clpReferredByName\" asc ";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $clpReferredBy['clpReferredById'] = $row['clpReferredById'];
                $clpReferredBy['clpReferredByName'] = Encoding::escapleAllCharacter($row['clpReferredByName']);  
                array_push($List, $clpReferredBy);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormServiceStatusAll()
    {

        try {

            $sql = "SELECT * FROM \"TblServiceStatus\" ORDER BY  \"showOrder\"";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $serviceStatus['serviceStatusId'] = $row['serviceStatusId'];
                $serviceStatus['showOrder'] = $row['showOrder'];
                $serviceStatus['serviceStatusName'] = $row['serviceStatusName'];
                array_push($List, $serviceStatus);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormServiceStatusActive()
    {

        try {
            $sql = "SELECT * FROM \"TblServiceStatus\" WHERE \"active\" ='Y' ORDER BY \"showOrder\"";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $serviceStatus['serviceStatusId'] = $row['serviceStatusId'];
                $serviceStatus['showOrder'] = $row['showOrder'];
                $serviceStatus['serviceStatusName'] = $row['serviceStatusName'];
                array_push($List, $serviceStatus);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormEicAll()
    {

        try {
            $sql = "SELECT * FROM \"TblEic\" ORDER BY \"eicName\" asc ";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) {
                $eic['eicId'] = $row['eicId'];
                $eic['eicName'] = Encoding::escapleAllCharacter($row['eicName']);  
                array_push($List, $eic);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormEicActive()
    {

        try {
             $sql = "SELECT * FROM \"TblEic\" WHERE \"active\"='Y' ORDER BY \"eicName\"asc ";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();            
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $eic['eicId'] = $row['eicId'];
                $eic['eicName'] = Encoding::escapleAllCharacter($row['eicName']);  
                array_push($List, $eic);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
 
    public function GetCostTypeByCountYearAndServiceTypeId($countYear,$serviceTypeId){
        try {
            $sql = "SELECT * FROM \"TblCostType\" WHERE \"countYear\" = :countYear AND \"serviceTypeId\" = :serviceTypeId ";
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $sth->bindParam(':countYear', $countYear);
            $sth->bindParam(':serviceTypeId', $serviceTypeId);
            /*
            $result= $sth->execute();
            if(!$result){
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
                
            }
            */
            $result = $sth->queryAll();


            $array = array();
            $List = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
            $array['costTypeId']=$row['costTypeId'];
            $array['countYear']=$row['countYear'];
            $array['serviceTypeId']=$row['serviceTypeId'];
            $array['unitCost']=$row['unitCost'];
            }
        } 
        catch (Exception $e) {
            echo "Exception " . $e->getMessage();
        }
        return $array;
    }

    public function getFormCostTypeByCostTypeId($costTypeId)
    {

        try {
            $sql = "SELECT ct.*, st.\"serviceTypeName\" FROM \"TblCostType\" ct LEFT JOIN \"TblServiceType\" st ON st.\"serviceTypeId\" = ct.\"serviceTypeId\" WHERE ct.\"costTypeId\" =".$costTypeId ." " ;

            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();

            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) {    
                $costType['costTypeId'] = $row['costTypeId'];
                $costType['countYear'] = $row['countYear'];
                $costType['serviceTypeId'] = $row['serviceTypeId'];
                $costType['serviceTypeName'] = Encoding::escapleAllCharacter($row['serviceTypeName']);  
                $costType['unitCost'] = $row['unitCost'];

            }
        } catch (Exception $e) {
            echo "Exception " . $e->getMessage();
        }

        return $costType;
    }
    public function getFormBusinessTypeAll()
    {

        try {
            $sql = "SELECT * FROM \"TblBusinessType\"";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) {    
                $businessType['businessTypeId'] = $row['businessTypeId'];
                $businessType['businessTypeName'] = Encoding::escapleAllCharacter($row['businessTypeName']);  
                array_push($List, $businessType);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $List;
    }
    public function getFormBusinessTypeActive()
    {

        try {
            $sql = "SELECT * FROM \"TblBusinessType\" WHERE \"active\"='Y'";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $businessType['businessTypeId'] = $row['businessTypeId'];
                $businessType['businessTypeName'] = Encoding::escapleAllCharacter($row['businessTypeName']);  
                array_push($List, $businessType);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $List;
    }
    public function getFormPlantTypeAll()
    {

        try {
            $sql = "SELECT * FROM \"TblPlantType\" ORDER BY \"plantTypeName\" asc";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) {     
                $plantType['plantTypeId'] = $row['plantTypeId'];
                $plantType['plantTypeName'] = $row['plantTypeName'];
                array_push($List, $plantType);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormPlantTypeActive()
    {

        try {
            $sql = "SELECT * FROM \"TblPlantType\" WHERE \"active\" ='Y' ORDER BY \"plantTypeName\" asc ";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $plantType['plantTypeId'] = $row['plantTypeId'];
                $plantType['plantTypeName'] = $row['plantTypeName'];
                array_push($List, $plantType);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormCustomerAll()
    {
        try {

            $sql = "SELECT c.* , bt.\"businessTypeName\" FROM \"TblCustomer\" c LEFT JOIN \"TblBusinessType\" bt on c.\"businessTypeId\" = bt.\"businessTypeId\"  ORDER BY \"customerName\" asc ";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row)
            {
                $array['customerId'] = $row['customerId'];
                $array['customerName'] = Encoding::escapleAllCharacter($row['customerName']); 
                $array['customerGroup'] = Encoding::escapleAllCharacter($row['customerGroup']);  
                $array['businessTypeId'] = $row['businessTypeId'];
                $array['businessTypeName'] = Encoding::escapleAllCharacter($row['businessTypeName']);  
                $array['clpNetwork'] = $row['clpNetwork'];
                array_push($List, $array);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormCustomerActive()
    {

        try {
            $sql = "SELECT c.* , bt.\"businessTypeName\" FROM \"TblCustomer\" c LEFT JOIN \"TblBusinessType\" bt on c.\"businessTypeId\" = bt.\"businessTypeId\" WHERE c.\"active\"='Y' ORDER BY \"customerName\" asc  ";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['customerId'] = $row['customerId'];
                $array['customerName'] = Encoding::escapleAllCharacter($row['customerName']); 
                $array['customerGroup'] = Encoding::escapleAllCharacter($row['customerGroup']);  
                $array['businessTypeId'] = $row['businessTypeId'];
                $array['businessTypeName'] = Encoding::escapleAllCharacter($row['businessTypeName']);  
                $array['clpNetwork'] = $row['clpNetwork'];
                array_push($List, $array);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }

    public function getFormContactPersonAll()
    {

        try {
            $sql = "SELECT * FROM \"TblContactPerson\"  ORDER BY \"contactPersonName\" asc ";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['contactPersonId'] = $row['contactPersonId'];
                $array['contactPersonName'] = Encoding::escapleAllCharacter($row['contactPersonName']);  
                $array['contactPersonTitle'] = Encoding::escapleAllCharacter($row['contactPersonTitle']);  
                $array['contactPersonNo'] = $row['contactPersonNo'];
                array_push($List, $array);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormContactPersonActive()
    {

        try {
             $sql = "SELECT * FROM \"TblContactPerson\" WHERE \"active\"='Y' ORDER BY \"contactPersonName\" asc ";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['contactPersonId'] = $row['contactPersonId'];
                $array['contactPersonName'] = Encoding::escapleAllCharacter($row['contactPersonName']);  
                $array['contactPersonTitle'] = Encoding::escapleAllCharacter($row['contactPersonTitle']);  
                $array['contactPersonNo'] = $row['contactPersonNo'];
                array_push($List, $array);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }

    public function getFormMajorAffectedElementAll()
    {

        try {
            $sql = "SELECT * FROM \"TblMajorAffectedElement\"";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) {     
                $majorAffectedElement['majorAffectedElementId'] = $row['majorAffectedElementId'];
                $majorAffectedElement['majorAffectedElementName'] = Encoding::escapleAllCharacter($row['majorAffectedElementName']);  
                array_push($List, $majorAffectedElement);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormMajorAffectedElementActive()
    {

        try {
            $sql = "SELECT * FROM \"TblMajorAffectedElement\" WHERE \"active\" ='Y'";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $majorAffectedElement['majorAffectedElementId'] = $row['majorAffectedElementId'];
                $majorAffectedElement['majorAffectedElementName'] = Encoding::escapleAllCharacter($row['majorAffectedElementName']);  
                array_push($List, $majorAffectedElement);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }

    public function getFormPartyToBeChargedAll()
    {

        try {

            //$sql = "SELECT * FROM TblPartyToBeCharged ORDER BY Cint(showOrder) ASC";
            $sql = "SELECT * FROM \"TblPartyToBeCharged\" ORDER BY \"showOrder\"::NUMERIC ASC";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $PartyToBeCharged['partyToBeChargedId'] = $row['partyToBeChargedId'];
                $PartyToBeCharged['partyToBeChargedName'] = Encoding::escapleAllCharacter($row['partyToBeChargedName']);  
                array_push($List, $PartyToBeCharged);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormPartyToBeChargedActive()
    {

        try {
            //$sql = "SELECT * FROM TblPartyToBeCharged WHERE active ='Y' ORDER BY Cint(showOrder) ASC";
            $sql = "SELECT * FROM \"TblPartyToBeCharged\" WHERE \"active\" ='Y' ORDER BY \"showOrder\"::NUMERIC ASC";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $PartyToBeCharged['partyToBeChargedId'] = $row['partyToBeChargedId'];
                $PartyToBeCharged['partyToBeChargedName'] = Encoding::escapleAllCharacter($row['partyToBeChargedName']);  
                array_push($List, $PartyToBeCharged);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormRequestedByAll()
    {

        try {
            $sql = "SELECT * FROM \"TblRequestedBy\" ";
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $requestedBy['requestedById'] = $row['requestedById'];
                $requestedBy['requestedByName'] = Encoding::escapleAllCharacter($row['requestedByName']);  
                $requestedBy['requestedByDept'] = Encoding::escapleAllCharacter($row['requestedByDept']);  ;
                array_push($List, $requestedBy);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormRequestedByActive()
    {

        try {
            $sql = "SELECT * FROM \"TblRequestedBy\" WHERE \"active\" ='Y' ";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $requestedBy['requestedById'] = $row['requestedById'];
                $requestedBy['requestedByName'] = Encoding::escapleAllCharacter($row['requestedByName']);  
                $requestedBy['requestedByDept'] = Encoding::escapleAllCharacter($row['requestedByDept']);  ;

                array_push($List, $requestedBy);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormRequestedByDeptAll()
    {

        try {

            $sql = "SELECT DISTINCT \"requestedByDept\" FROM \"TblRequestedBy\"";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $List[] = Encoding::escapleAllCharacter($row['requestedByDept']);  ;
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormRequestedByDeptActive()
    {

        try {
            $sql = "SELECT DISTINCT \"requestedByDept\" FROM \"TblRequestedBy\" WHERE \"active\"='Y' ";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $List[] = Encoding::escapleAllCharacter($row['requestedByDept']);  ;
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormActionByAll()
    {

        try {
            $sql = "SELECT * FROM \"TblActionBy\"";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) {
                $array['actionById'] = $row['actionById'];
                $array['actionByName'] = Encoding::escapleAllCharacter($row['actionByName']);  
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormActionByActive()
    {

        try {
            $sql = "SELECT * FROM \"TblActionBy\" WHERE \"active\"='Y' ";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['actionById'] = $row['actionById'];
                $array['actionByName'] = Encoding::escapleAllCharacter($row['actionByName']);  
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormIncidentAll()
    {

        try {
            $sql = "SELECT * FROM \"TblVoltageReport\"";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) {  
                $array['incidentId'] = $row['Id'];
                $array['idrNo'] = $row['idrNo'];
                $array['incidentDateTime'] = $row['incidentDate'];
                $array['incidentDate'] = date("Y-m-d", strtotime($row['incidentDate']));
                $array['incidentTime'] = date("H:m", strtotime($row['incidentDate']));
                $array['voltage'] = $row['voltage'];
                $array['circuit'] = $row['circuit'];
                $array['durations'] = $row['durations'];
                $array['vL1'] = $row['vL1'];
                $array['vL2'] = $row['vL2'];
                $array['vL3'] = $row['vL3'];
                $array['ourRef'] = $row['ourRef'];
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormRequestedByAutoCompleteAll()
    {

        try {
 
            $sql = "SELECT * FROM \"TblRequestedBy\"";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) {     
                $List[] = Encoding::escapleAllCharacter($row['requestedByName']);  

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getFormRequestedByAutoCompleteActive()
    {

        try {
            $sql = "SELECT * FROM \"TblRequestedBy\" WHERE \"active\" ='Y' ";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $List[] = Encoding::escapleAllCharacter($row['requestedByName']);  

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }


    public function GetCaseFormSearchResultCount($searchParam)
    {

        try {

            $sql = "SELECT count(1) FROM \"TblServiceCase\" WHERE 1=1 ";

            $parentCaseNo = isset($searchParam['parentCaseNo']) ? $searchParam['parentCaseNo'] : '';
            $caseVersion = isset($searchParam['caseVersion']) ? $searchParam['caseVersion'] : '';
            $requestedBy = isset($searchParam['requestedBy']) ? $searchParam['requestedBy'] : '';
            $customerName = isset($searchParam['customerName']) ? $searchParam['customerName'] : '';
            $partyToBeChargedId = isset($searchParam['partyToBeChargedId']) ? $searchParam['partyToBeChargedId'] : '';
            $serviceTypeId = isset($searchParam['serviceTypeId']) ? $searchParam['serviceTypeId'] : '';
            $startDateStartRange = isset($searchParam['startDateStartRange']) ? $searchParam['startDateStartRange'] : '';
            $startDateEndRange = isset($searchParam['startDateEndRange']) ? $searchParam['startDateEndRange'] : '';
            $endDateStartRange = isset($searchParam['endDateStartRange']) ? $searchParam['endDateStartRange'] : '';
            $endDateEndRange = isset($searchParam['endDateEndRange']) ? $searchParam['endDateEndRange'] : '';
            $active = isset($searchParam['active']) ? $searchParam['active'] : '';

            if ($parentCaseNo != '') {
                $sql = $sql . "AND \"parentCaseNo\"::text LIKE :parentCaseNo ";
            }
            if ($caseVersion != '') {
                $sql = $sql . "AND \"caseVersion\"::text LIKE :caseVersion ";
            }
            if ($requestedBy != '') {
                $sql = $sql . "AND \"requestedBy\" LIKE :requestedBy ";
            }
            if ($customerName != '') {
                $sql = $sql . "AND \"customerName\" LIKE :customerName ";
            }
            if ($partyToBeChargedId != '') {
                $sql = $sql . "AND \"partyToBeChargedId\" = :partyToBeChargedId ";
            }
            if ($serviceTypeId != '') {
                $sql = $sql . "AND \"serviceTypeId\" = :serviceTypeId ";
            }

            if($startDateStartRange !='' && $startDateEndRange !=''){
              /*  
                $sql = $sql ." AND (
                  ((serviceTypeId = 3 OR serviceTypeId = 4) AND serviceStartDate >= :startDateStartRange1 AND serviceStartDate <= :startDateEndRange1) 
                OR ((serviceTypeId <>3 AND serviceTypeId <>4) AND customerContactedDate >= :startDateStartRange2 AND customerContactedDate <= :startDateEndRange2)
                OR ((serviceTypeId =2 OR serviceTypeId =6) AND requestedVisitDate >= :startDateStartRange3 AND requestedVisitDate <= :startDateEndRange3)
                )"; 
                */
                $sql = $sql ." AND (
                    ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"requestDate\" >= :startDateStartRange1 AND \"requestDate\" <= :startDateEndRange1) 
                  OR ((\"serviceTypeId\" <>3 AND \"serviceTypeId\" <>4) AND \"requestDate\" >= :startDateStartRange2 AND \"requestDate\" <= :startDateEndRange2)
                  OR ((\"serviceTypeId\" =2 OR \"serviceTypeId\" =6) AND \"requestDate\" >= :startDateStartRange3 AND \"requestDate\" <= :startDateEndRange3)
                  )";
                
            }else if($startDateStartRange !=''){
              /*  
                $sql = $sql ." AND (
                    ((serviceTypeId = 3 OR serviceTypeId = 4) AND serviceStartDate >= :startDateStartRange1 ) 
                  OR ((serviceTypeId <>3 AND serviceTypeId <>4) AND customerContactedDate >= :startDateStartRange2 )
                  OR ((serviceTypeId =2 OR serviceTypeId =6) AND requestedVisitDate >= :startDateStartRange3 )
                )"; 
                */
                $sql = $sql ." AND (
                    ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"requestDate\" >= :startDateStartRange1 ) 
                  OR ((\"serviceTypeId\" <>3 AND \"serviceTypeId\" <>4) AND \"requestDate\" >= :startDateStartRange2 )
                  OR ((\"serviceTypeId\" =2 OR \"serviceTypeId\" =6) AND \"requestDate\" >= :startDateStartRange3 )
                )";
               
            }else if($startDateEndRange !=''){
               /* 
                $sql = $sql ." AND (
                 ((serviceTypeId = 3 OR serviceTypeId = 4)  AND serviceStartDate <= :startDateEndRange1) 
                OR ((serviceTypeId <>3 AND serviceTypeId <>4) AND customerContactedDate <= :startDateEndRange2)
                OR ((serviceTypeId =2 OR serviceTypeId =6) AND requestedVisitDate <= :startDateEndRange3 )
                )"; 
                */
                $sql = $sql ." AND (
                    ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4)  AND \"requestDate\" <= :startDateEndRange1) 
                   OR ((\"serviceTypeId\" <>3 AND \"serviceTypeId\" <>4) AND \"requestDate\" <= :startDateEndRange2)
                   OR ((\"serviceTypeId\" =2 OR \"serviceTypeId\" =6) AND \"requestDate\" <= :startDateEndRange3 )
                   )";
            }
            if($endDateStartRange !='' && $endDateEndRange !=''){
                $sql = $sql ." AND (
                ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"actualReportIssueDate\" >= :endDateStartRange1 AND \"actualReportIssueDate\" <= :endDateEndRange1) 
                OR ((\"serviceTypeId\" <>3 AND \"serviceTypeId\" <>4) AND \"serviceCompletionDate\" >= :endDateStartRange2 AND \"serviceCompletionDate\" <=:endDateEndRange2)
                OR ((\"serviceTypeId\" =2 OR \"serviceTypeId\" =6) AND \"actualVisitDate\" >= :endDateStartRange3 AND \"actualVisitDate\" <= :endDateEndRange3)
                )";
            }else if($endDateStartRange !=''){
                $sql = $sql ." AND (
                    ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"actualReportIssueDate\" >= :endDateStartRange1 ) 
                    OR ((\"serviceTypeId\" <>3 AND \"serviceTypeId\" <>4) AND \"serviceCompletionDate\" >= :endDateStartRange2 )
                    OR ((\"serviceTypeId\" =2 OR \"serviceTypeId\" =6) AND \"actualVisitDate\" >= :endDateStartRange3 )
                    )";
            }else if($endDateEndRange !=''){
                $sql = $sql ." AND (
                    ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"actualReportIssueDate\" <= :endDateEndRange1) 
                    OR ((\"serviceTypeId\" <>3 AND \"serviceTypeId\" <>4) AND \"serviceCompletionDate\" <=:endDateEndRange2)
                    OR ((\"serviceTypeId\" =2 OR \"serviceTypeId\" =6) AND  \"actualVisitDate\" <= :endDateEndRange3)
                    )";
            
            }
            if ($active != '') {
                $sql = $sql . "  AND \"active\" LIKE :active ";
            }

            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            if ($parentCaseNo != '') {
                $parentCaseNo = "%" . $parentCaseNo . "%";
                $sth->bindParam(':parentCaseNo', $parentCaseNo);
            }
            if ($caseVersion != '') {
                $caseVersion = "%" . $caseVersion . "%";
                $sth->bindParam(':caseVersion', $caseVersion);
            }
            if ($requestedBy != '') {
                $requestedBy = "%" . $requestedBy . "%";
                $sth->bindParam(':requestedBy', $requestedBy);
            }
            if ($customerName != '') {
                $customerName = "%" . $customerName . "%";
                $sth->bindParam(':customerName', $customerName);
            }
            if ($partyToBeChargedId != '') {
                $sth->bindParam(':partyToBeChargedId', $partyToBeChargedId);
            }
            if ($serviceTypeId != '') {
                $sth->bindParam(':serviceTypeId', $serviceTypeId);
            }
            if($startDateStartRange !='' && $startDateEndRange !=''){
                $sth->bindParam(':startDateStartRange1', $startDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateStartRange2', $startDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateStartRange3', $startDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateEndRange1', $startDateEndRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateEndRange2', $startDateEndRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateEndRange3', $startDateEndRange,PDO::PARAM_STR);

            }else if($startDateStartRange !=''){
                $sth->bindParam(':startDateStartRange1', $startDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateStartRange2', $startDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateStartRange3', $startDateStartRange,PDO::PARAM_STR);

            }else if($startDateEndRange !=''){
                $sth->bindParam(':startDateEndRange1', $startDateEndRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateEndRange2', $startDateEndRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateEndRange3', $startDateEndRange,PDO::PARAM_STR);
            }
            if($endDateStartRange !='' && $endDateEndRange !=''){
                $sth->bindParam(':endDateStartRange1', $endDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateStartRange2', $endDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateStartRange3', $endDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateEndRange1', $endDateEndRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateEndRange2', $endDateEndRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateEndRange3', $endDateEndRange,PDO::PARAM_STR);

            }else if($endDateStartRange !=''){
                $sth->bindParam(':endDateStartRange1', $endDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateStartRange2', $endDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateStartRange3', $endDateStartRange,PDO::PARAM_STR);

            }else if($endDateEndRange !=''){

                $sth->bindParam(':endDateEndRange1', $endDateEndRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateEndRange2', $endDateEndRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateEndRange3', $endDateEndRange,PDO::PARAM_STR);

            }
            if ($active != '') {
                $active = "%" . $active . "%";
                $sth->bindParam(':active', $active);
            }

           //$result = $sth->execute();
           $result = $sth->queryRow();

            //$count = $sth->fetchColumn();
            $count = $result['count'];


        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        } catch (Exception $e) {
            echo "Exception " . $e->getMessage();
        }

        return $count;
    }
    public function GetCaseFormRecordCount()
    {

        try {
            $sql = "SELECT count(1) FROM \"TblServiceCase\"";

            //$result = $database->query($sql);
            //$count = $result->fetchColumn();

            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryRow();
            $count = $result['count'];


        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $count;
    }

    public function GetCaseFormSearchByPage($searchParam, $start, $length, $orderByStr)
    {

        //$sqlMid = 'SELECT TOP ' .  ($length + $start) . ' sc.* , st.serviceTypeName as serviceTypeName, e.eicName as eicName, ct.unitCost as unitCost,pt.problemTypeName as problemTypeName, crb.clpReferredByName as clpReferredByName , bt.businessTypeName as businessTypeName, ss.serviceStatusName as serviceStatusName, ptbc.partyToBeChargedName as partyToBeChargedName, plant.plantTypeName as plantTypeName, mae.majorAffectedElementName as majorAffectedElementName, ab.actionByName as actionByName ';
        
        //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' sc.serviceCaseId ';

        $sqlMid = 'SELECT  sc.* , st."serviceTypeName", e."eicName", ct."unitCost", pt."problemTypeName", crb."clpReferredByName", bt."businessTypeName", ss."serviceStatusName", ptbc."partyToBeChargedName", plant."plantTypeName", mae."majorAffectedElementName", ab."actionByName" ';
        
        $sqlBase = 'SELECT sc."serviceCaseId" ';


        $sql1 = 'FROM ((((((((((("TblServiceCase" sc LEFT JOIN "TblServiceType" st ON sc."serviceTypeId" = st."serviceTypeId")
            LEFT JOIN "TblEic" e  ON sc."eicId" =  e."eicId" ) 
            LEFT JOIN "TblCostType" ct on sc."costTypeId" = ct."costTypeId") 
            LEFT JOIN "TblProblemType" pt on sc."problemTypeId"= pt."problemTypeId") 
            LEFT JOIN "TblClpReferredBy" crb on sc."clpReferredById"= crb."clpReferredById") 
            LEFT JOIN "TblBusinessType" bt on sc."businessTypeId" = bt."businessTypeId") 
            LEFT JOIN "TblServiceStatus" ss on sc."serviceStatusId" = ss."serviceStatusId" ) 
            LEFT JOIN "TblPartyToBeCharged" ptbc on sc."partyToBeChargedId" = ptbc."partyToBeChargedId") 
            LEFT JOIN "TblPlantType" plant on sc."plantTypeId" = plant."plantTypeId" ) 
            LEFT JOIN "TblMajorAffectedElement" mae on sc."majorAffectedElementId" = mae."majorAffectedElementId" )  
            LEFT JOIN "TblActionBy" ab on sc."actionBy" = ab."actionById" ) WHERE 1=1 
            ';
            
        $sql2 = 'FROM ("TblServiceCase" sc LEFT JOIN "TblServiceType" st ON sc."serviceTypeId" = st."serviceTypeId") 
			LEFT JOIN "TblEic" e  ON sc."eicId" =  e."eicId"  WHERE 1=1 ';

        $parentCaseNo = isset($searchParam['parentCaseNo']) ? $searchParam['parentCaseNo'] : '';
        $caseVersion = isset($searchParam['caseVersion']) ? $searchParam['caseVersion'] : '';
        $requestedBy = isset($searchParam['requestedBy']) ? $searchParam['requestedBy'] : '';
        $customerName = isset($searchParam['customerName']) ? $searchParam['customerName'] : '';
        $partyToBeChargedId = isset($searchParam['partyToBeChargedId']) ? $searchParam['partyToBeChargedId'] : '';
        $serviceTypeId = isset($searchParam['serviceTypeId']) ? $searchParam['serviceTypeId'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $startDateStartRange = isset($searchParam['startDateStartRange']) ? $searchParam['startDateStartRange'] : '';
        $startDateEndRange = isset($searchParam['startDateEndRange']) ? $searchParam['startDateEndRange'] : '';
        $endDateStartRange = isset($searchParam['endDateStartRange']) ? $searchParam['endDateStartRange'] : '';
        $endDateEndRange = isset($searchParam['endDateEndRange']) ? $searchParam['endDateEndRange'] : '';
        if ($parentCaseNo != '') {
            $sql1 = $sql1 . "AND \"parentCaseNo\"::text LIKE :parentCaseNo1 ";
            $sql2 = $sql2 . "AND \"parentCaseNo\"::text LIKE :parentCaseNo2 ";
        }
        if ($caseVersion != '') {
            $sql1 = $sql1 . "AND \"caseVersion\"::text LIKE :caseVersion1 ";
            $sql2 = $sql2 . "AND \"caseVersion\"::text LIKE :caseVersion2 ";
        }
        if ($requestedBy != '') {
            $sql1 = $sql1 . "AND \"requestedBy\" LIKE :requestedBy1 ";
            $sql2 = $sql2 . "AND \"requestedBy\" LIKE :requestedBy2 ";
        }
        if ($customerName != '') {
            $sql1 = $sql1 . "AND \"customerName\" LIKE :customerName1 ";
            $sql2 = $sql2 . "AND \"customerName\" LIKE :customerName2 ";
        }
        if ($partyToBeChargedId != '') {
            $sql1 = $sql1 . "AND sc.\"partyToBeChargedId\" = :partyToBeChargedId1 ";
            $sql2 = $sql2 . "AND sc.\"partyToBeChargedId\" = :partyToBeChargedId2 ";
        }
        if ($serviceTypeId != '') {
            $sql1 = $sql1 . "AND sc.\"serviceTypeId\" = :serviceTypeId1 ";
            $sql2 = $sql2 . "AND sc.\"serviceTypeId\" = :serviceTypeId2 ";
        }
        if($startDateStartRange !='' && $startDateEndRange !=''){
            $sql1 = $sql1 ." AND (
              ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4) AND \"requestDate\" >= :startDateStartRange1 AND \"requestDate\" <= :startDateEndRange1) 
            OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4) AND \"requestDate\" >= :startDateStartRange2 AND \"requestDate\" <= :startDateEndRange2)
            OR ((sc.\"serviceTypeId\" =2 OR sc.\"serviceTypeId\" =6) AND \"requestDate\" >= :startDateStartRange3 AND \"requestDate\" <= :startDateEndRange3)
            ) ";
            /*
             $sql1 = $sql1 ." AND (
              ((sc.serviceTypeId = 3 OR sc.serviceTypeId = 4) AND serviceStartDate >= :startDateStartRange1 AND serviceStartDate <= :startDateEndRange1) 
            OR ((sc.serviceTypeId <>3 AND sc.serviceTypeId <>4) AND customerContactedDate >= :startDateStartRange2 AND customerContactedDate <= :startDateEndRange2)
            OR ((sc.serviceTypeId =2 OR sc.serviceTypeId =6) AND requestedVisitDate >= :startDateStartRange3 AND requestedVisitDate <= :startDateEndRange3)
            ) ";
            */
            $sql2 = $sql2 ." AND (
            ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4) AND \"requestDate\" >= :startDateStartRange4 AND \"requestDate\" <= :startDateEndRange4) 
            OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4) AND \"requestDate\" >= :startDateStartRange5 AND \"requestDate\" <= :startDateEndRange5)
            OR ((sc.\"serviceTypeId\" =2 OR sc.\"serviceTypeId\" =6) AND \"requestDate\" >= :startDateStartRange6 AND \"requestDate\" <= :startDateEndRange6)
            ) ";
            /*
            $sql2 = $sql2 ." AND (
            ((sc.serviceTypeId = 3 OR sc.serviceTypeId = 4) AND serviceStartDate >= :startDateStartRange4 AND serviceStartDate <= :startDateEndRange4) 
            OR ((sc.serviceTypeId <>3 AND sc.serviceTypeId <>4) AND customerContactedDate >= :startDateStartRange5 AND customerContactedDate <= :startDateEndRange5)
            OR ((sc.serviceTypeId =2 OR sc.serviceTypeId =6) AND requestedVisitDate >= :startDateStartRange6 AND requestedVisitDate <= :startDateEndRange6)
            ) ";
            */
        }else if($startDateStartRange !=''){
            $sql1 = $sql1 ." AND (
                ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4) AND \"requestDate\" >= :startDateStartRange1 ) 
              OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4) AND \"requestDate\" >= :startDateStartRange2 )
              OR ((sc.\"serviceTypeId\" =2 OR sc.\"serviceTypeId\" =6) AND \"requestDate\" >= :startDateStartRange3 )
              ) ";
            $sql2 = $sql2 ." AND (
                ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4) AND \"requestDate\" >= :startDateStartRange4 ) 
            OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4) AND \"requestDate\" >= :startDateStartRange5 )
            OR ((sc.\"serviceTypeId\" =2 OR sc.\"serviceTypeId\" =6) AND \"requestDate\" >= :startDateStartRange6 )
            ) ";
            /*
                        $sql1 = $sql1 ." AND (
                ((sc.serviceTypeId = 3 OR sc.serviceTypeId = 4) AND serviceStartDate >= :startDateStartRange1 ) 
              OR ((sc.serviceTypeId <>3 AND sc.serviceTypeId <>4) AND customerContactedDate >= :startDateStartRange2 )
              OR ((sc.serviceTypeId =2 OR sc.serviceTypeId =6) AND requestedVisitDate >= :startDateStartRange3 )
              ) ";
            $sql2 = $sql2 ." AND (
                ((sc.serviceTypeId = 3 OR sc.serviceTypeId = 4) AND serviceStartDate >= :startDateStartRange4 ) 
            OR ((sc.serviceTypeId <>3 AND sc.serviceTypeId <>4) AND customerContactedDate >= :startDateStartRange5 )
            OR ((sc.serviceTypeId =2 OR sc.serviceTypeId =6) AND requestedVisitDate >= :startDateStartRange6 )
            ) ";
            */
        }else if($startDateEndRange !=''){
            $sql1 = $sql1 ." AND (
             ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4)  AND \"requestDate\" <= :startDateEndRange1) 
            OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4) AND \"requestDate\" <= :startDateEndRange2)
            OR ((sc.\"serviceTypeId\" =2 OR sc.\"serviceTypeId\" =6) AND  \"requestDate\" <= :startDateEndRange3)
            )";
            $sql2 = $sql2 ." AND (
                 ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4)  AND \"requestDate\" <= :startDateEndRange4) 
                OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4) AND \"requestDate\" <= :startDateEndRange5)
                OR ((sc.\"serviceTypeId\" =2 OR sc.\"serviceTypeId\" =6) AND  \"requestDate\" <= :startDateEndRange6)
                ) ";
            /*
            $sql1 = $sql1 ." AND (
             ((sc.serviceTypeId = 3 OR sc.serviceTypeId = 4)  AND serviceStartDate <= :startDateEndRange1) 
            OR ((sc.serviceTypeId <>3 AND sc.serviceTypeId <>4) AND customerContactedDate <= :startDateEndRange2)
            OR ((sc.serviceTypeId =2 OR sc.serviceTypeId =6) AND  requestedVisitDate <= :startDateEndRange3)
            )";
            $sql2 = $sql2 ." AND (
                 ((sc.serviceTypeId = 3 OR sc.serviceTypeId = 4)  AND serviceStartDate <= :startDateEndRange4) 
                OR ((sc.serviceTypeId <>3 AND sc.serviceTypeId <>4) AND customerContactedDate <= :startDateEndRange5)
                OR ((sc.serviceTypeId =2 OR sc.serviceTypeId =6) AND  requestedVisitDate <= :startDateEndRange6)
                ) ";
            */
        }
        if($endDateStartRange !='' && $endDateEndRange !=''){
            $sql1 = $sql1 ." AND ( 
            ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4) AND \"actualReportIssueDate\" >= :endDateStartRange1 AND \"actualReportIssueDate\" <= :endDateEndRange1) 
            OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4) AND \"serviceCompletionDate\" >= :endDateStartRange2 AND \"serviceCompletionDate\" <=:endDateEndRange2)
            OR ((sc.\"serviceTypeId\" =2 OR sc.\"serviceTypeId\" =6) AND \"actualVisitDate\" >= :endDateStartRange3 AND \"actualVisitDate\" <=:endDateEndRange3)
            ) ";
           $sql2 = $sql2 ." AND (
            ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4) AND \"actualReportIssueDate\" >= :endDateStartRange4 AND \"actualReportIssueDate\" <= :endDateEndRange4) 
            OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4) AND \"serviceCompletionDate\" >= :endDateStartRange5 AND \"serviceCompletionDate\" <=:endDateEndRange5)
            OR ((sc.\"serviceTypeId\" =2 OR sc.\"serviceTypeId\" =6) AND \"actualVisitDate\" >= :endDateStartRange6 AND \"actualVisitDate\" <=:endDateEndRange6)
            ) ";
        }else if($endDateStartRange !=''){
            $sql1 = $sql1 ." AND (
                ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4) AND \"actualReportIssueDate\" >= :endDateStartRange1 ) 
                OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4) AND \"serviceCompletionDate\" >= :endDateStartRange2 )
                OR ((sc.\"serviceTypeId\" =2 OR sc.\"serviceTypeId\" =6) AND \"actualVisitDate\" >= :endDateStartRange3 )
                ) ";
               $sql2 = $sql2 ." AND (
                ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4) AND \"actualReportIssueDate\" >= :endDateStartRange4 ) 
                OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4) AND \"serviceCompletionDate\" >= :endDateStartRange5 )
                OR ((sc.\"serviceTypeId\" =2 OR sc.\"serviceTypeId\" =6) AND \"actualVisitDate\" >= :endDateStartRange6 )
                ) ";
        }else if($endDateEndRange !=''){
            $sql1 = $sql1 ." AND (
                ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4) AND \"actualReportIssueDate\" <= :endDateEndRange1) 
                OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4) AND \"serviceCompletionDate\" <=:endDateEndRange2)
                OR ((sc.\"serviceTypeId\" =2 OR sc.\"serviceTypeId\" =6) AND \"actualVisitDate\" <=:endDateEndRange3)
                ) ";
               $sql2 = $sql2 ." AND (
                ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4)  AND \"actualReportIssueDate\" <= :endDateEndRange4) 
                OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4) AND \"serviceCompletionDate\" <=:endDateEndRange5)
                OR ((sc.\"serviceTypeId\" =2 OR sc.\"serviceTypeId\" =6) AND  \"actualVisitDate\" <=:endDateEndRange6)
                ) ";
        }
        if ($active != '') {

            $sql1 = $sql1 . " AND sc.\"active\" LIKE :active1 ";
            $sql2 = $sql2 . " AND sc.\"active\" LIKE :active2 ";
        }

        if ($orderByStr != '') {
            if ($orderByStr != '\"active\" desc' && $orderByStr != '\"active\" asc' && $orderByStr != '\"createdBy\" desc' && $orderByStr != '\"createdBy\" asc' && $orderByStr != '\"createdTime\" desc' && $orderByStr != '\"createdTime\" asc' && $orderByStr != '\"lastUpdatedBy\" desc' && $orderByStr != '\"lastUpdatedBy\" asc' && $orderByStr != '\"lastUpdatedTime\" desc' && $orderByStr != '\"lastUpdatedTime\" asc') {
                $sql1 = $sql1 . " ORDER BY " . $orderByStr . ' ';
                $sql2 = $sql2 . " ORDER BY " . $orderByStr . ' ';
            } else {
                $sql1 = $sql1 . " ORDER BY sc." . $orderByStr . ' ';
                $sql2 = $sql2 . " ORDER BY sc." . $orderByStr . ' ';
            }
        }
        if ($start != 0) {
            $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT '. ($length + $start) .') WHERE sc."serviceCaseId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT '. (int) ($start) . ') ';
        } else {
            $sqlFinal = $sqlMid . $sql1 . ' LIMIT '. ($length + $start);
        }

        try
        {
            $sth = Yii::app()->db->createCommand($sqlFinal);


            if ($parentCaseNo != '') {
                $parentCaseNo = "%" . $parentCaseNo . "%";
                $sth->bindParam(':parentCaseNo1', $parentCaseNo);
                if ($start != 0) {
                    $sth->bindParam(':parentCaseNo2', $parentCaseNo);
                }

            }
            if ($caseVersion != '') {
                $caseVersion = "%" . $caseVersion . "%";
                $sth->bindParam(':caseVersion1', $caseVersion);
                if ($start != 0) {
                    $sth->bindParam(':caseVersion2', $caseVersion);
                }

            }
            if ($requestedBy != '') {
                $requestedBy = "%" . $requestedBy . "%";
                $sth->bindParam(':requestedBy1', $requestedBy);
                if ($start != 0) {
                    $sth->bindParam(':requestedBy2', $requestedBy);
                }

            }
            if ($customerName != '') {
                $customerName = "%" . $customerName . "%";
                $sth->bindParam(':customerName1', $customerName);
                if ($start != 0) {
                    $sth->bindParam(':customerName2', $customerName);
                }

            }
            if ($partyToBeChargedId != '') {
                $sth->bindParam(':partyToBeChargedId1', $partyToBeChargedId);
                if ($start != 0) {
                    $sth->bindParam(':partyToBeChargedId2', $partyToBeChargedId);
                }

            }
            if ($serviceTypeId != '') {
                $sth->bindParam(':serviceTypeId1', $serviceTypeId);
                if ($start != 0) {
                    $sth->bindParam(':serviceTypeId2', $serviceTypeId);
                }

            }
            if($startDateStartRange !='' && $startDateEndRange !=''){
                $sth->bindParam(':startDateStartRange1', $startDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateStartRange2', $startDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateStartRange3', $startDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateEndRange1', $startDateEndRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateEndRange2', $startDateEndRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateEndRange3', $startDateEndRange,PDO::PARAM_STR);
                if ($start != 0) {
                    $sth->bindParam(':startDateStartRange4', $startDateStartRange,PDO::PARAM_STR);
                    $sth->bindParam(':startDateStartRange5', $startDateStartRange,PDO::PARAM_STR);
                    $sth->bindParam(':startDateStartRange6', $startDateStartRange,PDO::PARAM_STR);
                    $sth->bindParam(':startDateEndRange4', $startDateEndRange,PDO::PARAM_STR);
                    $sth->bindParam(':startDateEndRange5', $startDateEndRange,PDO::PARAM_STR);
                    $sth->bindParam(':startDateEndRange6', $startDateEndRange,PDO::PARAM_STR);
                }
            }else if($startDateStartRange !=''){
                $sth->bindParam(':startDateStartRange1', $startDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateStartRange2', $startDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateStartRange3', $startDateStartRange,PDO::PARAM_STR);
                if ($start != 0) {
                    $sth->bindParam(':startDateStartRange4', $startDateStartRange,PDO::PARAM_STR);
                    $sth->bindParam(':startDateStartRange5', $startDateStartRange,PDO::PARAM_STR);
                    $sth->bindParam(':startDateStartRange6', $startDateStartRange,PDO::PARAM_STR);
                }
            }else if($startDateEndRange !=''){
                $sth->bindParam(':startDateEndRange1', $startDateEndRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateEndRange2', $startDateEndRange,PDO::PARAM_STR);
                $sth->bindParam(':startDateEndRange3', $startDateEndRange,PDO::PARAM_STR);
                if ($start != 0) {
                    $sth->bindParam(':startDateEndRange4', $startDateEndRange,PDO::PARAM_STR);
                    $sth->bindParam(':startDateEndRange5', $startDateEndRange,PDO::PARAM_STR);
                    $sth->bindParam(':startDateEndRange6', $startDateEndRange,PDO::PARAM_STR);
                }
            }
            if($endDateStartRange !='' && $endDateEndRange !=''){
                $sth->bindParam(':endDateStartRange1', $endDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateStartRange2', $endDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateStartRange3', $endDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateEndRange1', $endDateEndRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateEndRange2', $endDateEndRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateEndRange3', $endDateEndRange,PDO::PARAM_STR);
                if ($start != 0) {
                    $sth->bindParam(':endDateStartRange4', $endDateStartRange,PDO::PARAM_STR);
                    $sth->bindParam(':endDateStartRange5', $endDateStartRange,PDO::PARAM_STR);
                    $sth->bindParam(':endDateStartRange6', $endDateStartRange,PDO::PARAM_STR);
                    $sth->bindParam(':endDateEndRange4', $endDateEndRange,PDO::PARAM_STR);
                    $sth->bindParam(':endDateEndRange5', $endDateEndRange,PDO::PARAM_STR);
                    $sth->bindParam(':endDateEndRange6', $endDateEndRange,PDO::PARAM_STR);
                }
            }else if($endDateStartRange !=''){
                $sth->bindParam(':endDateStartRange1', $endDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateStartRange2', $endDateStartRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateStartRange3', $endDateStartRange,PDO::PARAM_STR);
                if ($start != 0) {
                    $sth->bindParam(':endDateStartRange4', $endDateStartRange,PDO::PARAM_STR);
                    $sth->bindParam(':endDateStartRange5', $endDateStartRange,PDO::PARAM_STR);
                    $sth->bindParam(':endDateStartRange6', $endDateStartRange,PDO::PARAM_STR);

                }
            }else if($endDateEndRange !=''){

                $sth->bindParam(':endDateEndRange1', $endDateEndRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateEndRange2', $endDateEndRange,PDO::PARAM_STR);
                $sth->bindParam(':endDateEndRange3', $endDateEndRange,PDO::PARAM_STR);
                if ($start != 0) {
                    $sth->bindParam(':endDateEndRange4', $endDateEndRange,PDO::PARAM_STR);
                    $sth->bindParam(':endDateEndRange5', $endDateEndRange,PDO::PARAM_STR);
                    $sth->bindParam(':endDateEndRange6', $endDateEndRange,PDO::PARAM_STR);
                }

            }
            if ($active != '') {
                $active = "%" . $active . "%";
                $sth->bindParam(':active1', $active);
                if ($start != 0) {
                    $sth->bindParam(':active2', $active);
                }

            }

            //$result= $sth->execute();
            $result= $sth->queryAll();
            /*
            if(!$result){
				throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
				
			}
            */
            $caseForm = array();
            $caseFormList = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row)
            {
                /*$List['serviceCaseId'] = $row['serviceCaseId'];
                $List['parentCaseNo'] = $row['parentCaseNo'];
                $List['caseVersion'] = $row['caseVersion'];
                $List['requestedBy'] = Encoding::escapleAllCharacter($row['requestedBy']);  
                $List['requestDate'] = $row['requestDate'];
                $List['serviceTypeName'] = Encoding::escapleAllCharacter($row['serviceTypeName']);  
                $List['customerName'] = Encoding::escapleAllCharacter($row['customerName']); 
                $List['contactPersonName'] = Encoding::escapleAllCharacter($row['contactPersonName']);  
                $List['contactPersonNumber'] = $row['contactPersonNumber'];
                $List['eicName'] = Encoding::escapleAllCharacter($row['eicName']);  
                $List['clpPersonDepartment'] = Encoding::escapleAllCharacter($row['clpPersonDepartment']);  
                $List['active'] = $row['active'];
                $List['createdBy'] = $row['createdBy'];
                $List['createdTime'] = $row['createdTime'];
                $List['lastUpdatedBy'] = $row['lastUpdatedBy'];
                $List['lastUpdatedTime'] = $row['lastUpdatedTime'];*/

                $caseForm['serviceCaseId'] = $row['serviceCaseId'];
                $caseForm['parentCaseNo'] = $row['parentCaseNo'];
                $caseForm['caseVersion'] = $row['caseVersion'];
                $caseForm['eicName'] = Encoding::escapleAllCharacter($row['eicName']);  
                $caseForm['actionByName'] = Encoding::escapleAllCharacter($row['actionByName']);  
                $caseForm['active'] = $row['active'];
                $caseForm['createdBy'] = $row['createdBy'];
                $caseForm['createdTime'] = $row['createdTime'];
                $caseForm['lastUpdatedBy'] = $row['lastUpdatedBy'];
                $caseForm['lastUpdatedTime'] = $row['lastUpdatedTime'];
                $caseForm['serviceTypeId'] = $row['serviceTypeId'];
                $caseForm['serviceTypeName'] = Encoding::escapleAllCharacter($row['serviceTypeName']);  
                $caseForm['problemTypeId'] = $row['problemTypeId'];
                $caseForm['problemTypeName'] = Encoding::escapleAllCharacter($row['problemTypeName']);  
                $caseForm['idrOrderId'] = $row['idrOrderId'];
                $caseForm['incidentDate'] = isset($row['incidentDate']) ? date('Y-m-d', strtotime($row['incidentDate'])) : '';
                $caseForm['incidentDateTime'] = isset($row['incidentDate']) ? date('H:i', strtotime($row['incidentDate'])) : '';
                $caseForm['requestDate'] = isset($row['requestDate']) ? date('Y-m-d', strtotime($row['requestDate'])) : '';
                $caseForm['requestDateTime'] = isset($row['requestDate']) ? date('H:i', strtotime($row['requestDate'])) : '';
                $caseForm['requestedBy'] = Encoding::escapleAllCharacter($row['requestedBy']);  
                $caseForm['clpPersonDepartment'] = Encoding::escapleAllCharacter($row['clpPersonDepartment']);  
                $caseForm['clpReferredById'] = $row['clpReferredById'];
                $caseForm['clpReferredByName'] = Encoding::escapleAllCharacter($row['clpReferredByName']); 
                $caseForm['customerName'] = Encoding::escapleAllCharacter($row['customerName']); 
                $caseForm['customerGroup'] = Encoding::escapleAllCharacter($row['customerGroup']);  
                $caseForm['businessTypeId'] = $row['businessTypeId'];
                $caseForm['businessTypeName'] = Encoding::escapleAllCharacter($row['businessTypeName']);  
                $caseForm['clpNetwork'] = $row['clpNetwork'];
                $caseForm['contactPersonName'] =Encoding::escapleAllCharacter($row['contactPersonName']);   
                $caseForm['contactPersonTitle'] = Encoding::escapleAllCharacter($row['contactPersonTitle']);  
                $caseForm['contactPersonNumber'] = $row['contactPersonNumber'];
                $caseForm['actionBy'] = $row['actionBy'];
                $caseForm['customerContactedDate'] = isset($row['customerContactedDate']) ? date('Y-m-d', strtotime($row['customerContactedDate'])) : '';
                $caseForm['requestedVisitDate'] = isset($row['requestedVisitDate']) ? date('Y-m-d', strtotime($row['requestedVisitDate'])) : '';
                $caseForm['actualVisitDate'] = isset($row['actualVisitDate']) ? date('Y-m-d', strtotime($row['actualVisitDate'])) : '';
                $caseForm['serviceStartDate'] = isset($row['serviceStartDate']) ? date('Y-m-d', strtotime($row['serviceStartDate'])) : '';
                $caseForm['serviceCompletionDate'] = isset($row['serviceCompletionDate']) ? date('Y-m-d', strtotime($row['serviceCompletionDate'])) : '';
                $caseForm['plannedReportIssueDate'] = isset($row['plannedReportIssueDate']) ? date('Y-m-d', strtotime($row['plannedReportIssueDate'])) : '';
                $caseForm['actualReportIssueDate'] = isset($row['actualReportIssueDate']) ? date('Y-m-d', strtotime($row['actualReportIssueDate'])) : '';
                $caseForm['actualReportWorkingDay'] = $row['actualReportWorkingDay'];
                $caseForm['actualResponseDay'] = $row['actualResponseDay'];
                $caseForm['actualWorkingDay'] = $row['actualWorkingDay'];
                $caseForm['caseReferredToClpe'] = $row['caseReferredToClpe'];
                $caseForm['serviceStatusId'] = $row['serviceStatusId'];
                $caseForm['serviceStatusName'] = $row['serviceStatusName'];
                $caseForm['mp'] = $row['mp'];
                $caseForm['g'] = $row['g'];
                $caseForm['t'] = $row['t'];
                $caseForm['eicId'] = $row['eicId'];
                $caseForm['costTypeId'] = $row['costTypeId'];
                $caseForm['unitCost'] = $row['unitCost'];
                $caseForm['costUnit'] = $row['costUnit'];
                $caseForm['costTotal'] = $row['costTotal'];
                $caseForm['partyToBeChargedId'] = $row['partyToBeChargedId'];
                $caseForm['partyToBeChargedName'] = Encoding::escapleAllCharacter($row['partyToBeChargedName']);  
                $caseForm['plantTypeId'] = $row['plantTypeId'];
                $caseForm['plantTypeName'] = Encoding::escapleAllCharacter($row['plantTypeName']); 
                $caseForm['manufacturerBrand'] =  Encoding::escapleAllCharacter($row['manufacturerBrand']); 
                $caseForm['majorAffectedElementId'] = $row['majorAffectedElementId'];
                $caseForm['majorAffectedElementName'] = Encoding::escapleAllCharacter($row['majorAffectedElementName']);
                $caseForm['plantRating'] = $row['plantRating'];
                $caseForm['planningAheadId'] = $row['planningAheadId'];
                /*$caseForm['customerProblem'] = trim($row['customerProblem']);
                $caseForm['actionAndFinding'] = Encoding::escapleAllCharacter($row['actionAndFinding']);  
                $caseForm['recommendation'] = Encoding::escapleAllCharacter($row['recommendation']);  
                $caseForm['remark'] = Encoding::escapleAllCharacter($row['remark']);  
                $caseForm['requiredFollowUp'] = $row['requiredFollowUp'];
                $caseForm['implementedSolution'] =  Encoding::escapleAllCharacter($row['implementedSolution']);  */

                $caseForm['customerProblem'] = Encoding::escapleAllCharacter($row['customerProblem']);
                $caseForm['actionAndFinding'] = Encoding::escapleAllCharacter($row['actionAndFinding']);
                $caseForm['recommendation'] = Encoding::escapleAllCharacter($row['recommendation']);
                $caseForm['remark'] = Encoding::escapleAllCharacter($row['remark']);
                $caseForm['requiredFollowUp'] = ($row['requiredFollowUp'] ? "true" : "false"); //Encoding::escapleAllCharacter($row['requiredFollowUp']);
                $caseForm['implementedSolution'] =  Encoding::escapleAllCharacter($row['implementedSolution']);
                $caseForm['proposedSolution'] =  Encoding::escapleAllCharacter($row['proposedSolution']);
/*
                $caseForm['customerProblem'] = iconv("big5", "UTF-8",trim($row['customerProblem']));
                $caseForm['actionAndFinding'] = iconv("big5", "UTF-8",$row['actionAndFinding']);
                $caseForm['recommendation'] = iconv("big5", "UTF-8",$row['recommendation']);
                $caseForm['remark'] = iconv("big5", "UTF-8",$row['remark']);
                $caseForm['requiredFollowUp'] = iconv("big5", "UTF-8",$row['requiredFollowUp']);
                $caseForm['implementedSolution'] = iconv("big5", "UTF-8",$row['implementedSolution']); 
*/
                array_push($caseFormList, $caseForm);

            }
            //$CaseFormList['totalCount'] = count($CaseFormList);

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        } catch (Exception $e) {
            echo "Exception " . $e->getMessage();
        }
        return $caseFormList;
    }
    public function getCaseFormByServiceCaseId($serviceCaseId)
    {

        try {

            //$sql = " SELECT sc.* , st.serviceTypeName as serviceTypeName, e.eicName as eicName ,vr.incidentDate as voltageIncidentDate, vr.voltage as voltage ,vr.circuit as circuit ,vr.durations as durations ,vr.vL1 as vL1,vr.vL2 as vL2,vr.vL3 as vL3, vr.ourRef as ourRef FROM ((TblServiceCase sc LEFT JOIN TblServiceType st ON sc.serviceTypeId = st.serviceTypeId)
			//LEFT JOIN TblEic e  ON sc.eicId =  e.eicId) LEFT JOIN TblVoltageReport vr ON sc.incidentId = vr.Id  WHERE serviceCaseId = :serviceCaseId ";
            $sql = " SELECT sc.* , st.\"serviceTypeName\", e.\"eicName\", vr.\"incidentDate\" as \"voltageIncidentDate\", vr.\"voltage\", vr.\"circuit\", vr.\"durations\", vr.\"vL1\", vr.\"vL2\", vr.\"vL3\", vr.\"ourRef\" FROM ((\"TblServiceCase\" sc LEFT JOIN \"TblServiceType\" st ON sc.\"serviceTypeId\" = st.\"serviceTypeId\")
			LEFT JOIN \"TblEic\" e  ON sc.\"eicId\" =  e.\"eicId\") LEFT JOIN \"TblVoltageReport\" vr ON sc.\"incidentId\" = vr.\"Id\"  WHERE \"serviceCaseId\" = :serviceCaseId ";
                        
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            $sth->bindParam(':serviceCaseId', $serviceCaseId);
            //$result= $sth->execute();
            $row = $sth->queryRow();
            /*
            if(!$result){
				throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
				
			}
            */
            $List = array();
            //$row = $sth->fetch(PDO::FETCH_ASSOC);
            $caseForm['serviceCaseId'] = $row['serviceCaseId'];
            $caseForm['parentCaseNo'] = $row['parentCaseNo'];
            $caseForm['caseVersion'] = $row['caseVersion'];
            $caseForm['serviceTypeId'] = $row['serviceTypeId'];
            $caseForm['problemTypeId'] = $row['problemTypeId'];
            $caseForm['idrOrderId'] = $row['idrOrderId'];
            $caseForm['incidentDate'] = isset($row['incidentDate']) ? date('Y-m-d', strtotime($row['incidentDate'])) : '';
            $caseForm['incidentDateTime'] = isset($row['incidentDate']) ? date('H:i', strtotime($row['incidentDate'])) : '';
            $caseForm['requestDate'] = isset($row['requestDate']) ? date('Y-m-d', strtotime($row['requestDate'])) : '';
            $caseForm['requestDateTime'] = isset($row['requestDate']) ? date('H:i', strtotime($row['requestDate'])) : '';
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
            $caseForm['actionBy'] = $row['actionBy'];
            $caseForm['customerContactedDate'] = isset($row['customerContactedDate']) ? date('Y-m-d', strtotime($row['customerContactedDate'])) : '';
            $caseForm['requestedVisitDate'] = isset($row['requestedVisitDate']) ? date('Y-m-d', strtotime($row['requestedVisitDate'])) : '';
            $caseForm['actualVisitDate'] = isset($row['actualVisitDate']) ? date('Y-m-d', strtotime($row['actualVisitDate'])) : '';
            $caseForm['serviceStartDate'] = isset($row['serviceStartDate']) ? date('Y-m-d', strtotime($row['serviceStartDate'])) : '';
            $caseForm['serviceCompletionDate'] = isset($row['serviceCompletionDate']) ? date('Y-m-d', strtotime($row['serviceCompletionDate'])) : '';
            $caseForm['plannedReportIssueDate'] = isset($row['plannedReportIssueDate']) ? date('Y-m-d', strtotime($row['plannedReportIssueDate'])) : '';
            $caseForm['actualReportIssueDate'] = isset($row['actualReportIssueDate']) ? date('Y-m-d', strtotime($row['actualReportIssueDate'])) : '';
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
            $caseForm['actionAndFinding'] =  Encoding::escapleAllCharacter($row['actionAndFinding']);
            $caseForm['recommendation'] = Encoding::escapleAllCharacter($row['recommendation']);
            $caseForm['remark'] = Encoding::escapleAllCharacter($row['remark']);
            $caseForm['requiredFollowUp'] = ($row['requiredFollowUp'] ? "true" : "false"); //Encoding::escapleAllCharacter($row['requiredFollowUp']);
            $caseForm['implementedSolution'] = Encoding::escapleAllCharacter($row['implementedSolution']);
            $caseForm['proposedSolution'] = Encoding::escapleAllCharacter($row['proposedSolution']);
            $caseForm['projectRegion'] = Encoding::escapleAllCharacter($row['projectRegion']);
            $caseForm['projectAddress'] = Encoding::escapleAllCharacter($row['projectAddress']);
            $caseForm['incidentId'] = $row['incidentId'];
            $caseForm['voltageIncidentDate'] =  isset($row['voltageIncidentDate']) ? date('Y-m-d', strtotime($row['voltageIncidentDate'])) : '';
            $caseForm['voltageIncidentTime'] =  isset($row['voltageIncidentDate']) ? date('H:i', strtotime($row['voltageIncidentDate'])) : '';
            $caseForm['voltage'] = $row['voltage'];
            $caseForm['circuit'] = $row['circuit'];
            $caseForm['durations'] = $row['durations'];
            $caseForm['vL1'] = $row['vL1'];
            $caseForm['vL2'] = $row['vL2'];
            $caseForm['vL3'] = $row['vL3'];
            $caseForm['ourRef'] = $row['ourRef'];
            $caseForm['planningAheadId'] = $row['planningAheadId'];
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $caseForm;
    }
    public function getCaseFormByParentCaseNoAndCaseVersion($parentCaseNo,$caseVersion)
    {

        try {
            $sql = " SELECT sc.* , st.\"serviceTypeName\", e.\"eicName\",vr.\"incidentDate\" as \"voltageIncidentDate\", vr.\"voltage\",vr.\"circuit\",vr.\"durations\",vr.\"vL1\",vr.\"vL2\",vr.\"vL3\",vr.\"ourRef\" FROM ((\"TblServiceCase\" sc LEFT JOIN \"TblServiceType\" st ON sc.\"serviceTypeId\" = st.\"serviceTypeId\")
            LEFT JOIN \"TblEic\" e  ON sc.\"eicId\" =  e.\"eicId\") LEFT JOIN \"TblVoltageReport\" vr ON sc.\"incidentId\" = vr.\"Id\"  WHERE \"parentCaseNo\" = $parentCaseNo ";
            if($caseVersion != null){
                $sql.= "AND \"caseVersion\" = $caseVersion "; 
            }

            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            /*
            $result= $sth->execute();
            if(!$result){
				throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
				
            }
            */
            $row = $sth->queryRow();

            $List = array();
            //$row = $sth->fetch(PDO::FETCH_ASSOC);
            $caseForm['serviceCaseId'] = $row['serviceCaseId']??null;
            $caseForm['parentCaseNo'] = $row['parentCaseNo']??null;
            $caseForm['caseVersion'] = $row['caseVersion']??null;
            $caseForm['serviceTypeId'] = $row['serviceTypeId']??null;
            $caseForm['problemTypeId'] = $row['problemTypeId']??null;
            $caseForm['idrOrderId'] = $row['idrOrderId']??null;
            $caseForm['incidentDate'] = isset($row['incidentDate']) ? date('Y-m-d', strtotime($row['incidentDate'])) : '';
            $caseForm['incidentDateTime'] = isset($row['incidentDate']) ? date('H:i', strtotime($row['incidentDate'])) : '';
            $caseForm['requestDate'] = isset($row['requestDate']) ? date('Y-m-d', strtotime($row['requestDate'])) : '';
            $caseForm['requestDateTime'] = isset($row['requestDate']) ? date('H:i', strtotime($row['requestDate'])) : '';
            $caseForm['requestedBy'] = isset($row['requestedBy']) ? Encoding::escapleAllCharacter($row['requestedBy']) : null;
            $caseForm['clpPersonDepartment'] = isset($row['clpPersonDepartment']) ? Encoding::escapleAllCharacter($row['clpPersonDepartment']) : null;
            $caseForm['clpReferredById'] = $row['clpReferredById']??null;
            $caseForm['customerName'] = isset($row['customerName']) ? Encoding::escapleAllCharacter($row['customerName']) : null;
            $caseForm['customerGroup'] = isset($row['customerGroup']) ? Encoding::escapleAllCharacter($row['customerGroup']) : null;
            $caseForm['businessTypeId'] = $row['businessTypeId']??null;
            $caseForm['clpNetwork'] = $row['clpNetwork']??null;
            $caseForm['contactPersonName'] = isset($row['contactPersonName']) ? Encoding::escapleAllCharacter($row['contactPersonName']) : null;
            $caseForm['contactPersonTitle'] = isset($row['contactPersonTitle']) ? Encoding::escapleAllCharacter($row['contactPersonTitle']) : null;
            $caseForm['contactPersonNumber'] = $row['contactPersonNumber']??null;
            $caseForm['actionBy'] = $row['actionBy']??null;
            $caseForm['customerContactedDate'] = isset($row['customerContactedDate']) ? date('Y-m-d', strtotime($row['customerContactedDate'])) : '';
            $caseForm['requestedVisitDate'] = isset($row['requestedVisitDate']) ? date('Y-m-d', strtotime($row['requestedVisitDate'])) : '';
            $caseForm['actualVisitDate'] = isset($row['actualVisitDate']) ? date('Y-m-d', strtotime($row['actualVisitDate'])) : '';
            $caseForm['serviceStartDate'] = isset($row['serviceStartDate']) ? date('Y-m-d', strtotime($row['serviceStartDate'])) : '';
            $caseForm['serviceCompletionDate'] = isset($row['serviceCompletionDate']) ? date('Y-m-d', strtotime($row['serviceCompletionDate'])) : '';
            $caseForm['plannedReportIssueDate'] = isset($row['plannedReportIssueDate']) ? date('Y-m-d', strtotime($row['plannedReportIssueDate'])) : '';
            $caseForm['actualReportIssueDate'] = isset($row['actualReportIssueDate']) ? date('Y-m-d', strtotime($row['actualReportIssueDate'])) : '';
            $caseForm['actualReportWorkingDay'] = $row['actualReportWorkingDay']??null;
            $caseForm['actualResponseDay'] = $row['actualResponseDay']??null;
            $caseForm['actualWorkingDay'] = $row['actualWorkingDay']??null;
            $caseForm['caseReferredToClpe'] = $row['caseReferredToClpe']??null;
            $caseForm['serviceStatusId'] = $row['serviceStatusId']??null;
            $caseForm['mp'] = $row['mp']??null;
            $caseForm['g'] = $row['g']??null;
            $caseForm['t'] = $row['t']??null;
            $caseForm['eicId'] = $row['eicId']??null;
            $caseForm['costTypeId'] = $row['costTypeId']??null;
            $caseForm['costUnit'] = $row['costUnit']??null;
            $caseForm['costTotal'] = $row['costTotal']??null;
            $caseForm['partyToBeChargedId'] = $row['partyToBeChargedId']??null;
            $caseForm['plantTypeId'] = $row['plantTypeId']??null;
            $caseForm['active'] = $row['active']??null;
            $caseForm['manufacturerBrand'] = $row['manufacturerBrand']??null;
            $caseForm['majorAffectedElementId'] = $row['majorAffectedElementId']??null;
            $caseForm['plantRating'] = $row['plantRating']??null;
            $caseForm['customerProblem'] = isset($row['customerProblem']) ? Encoding::escapleAllCharacter($row['customerProblem']) : '';
            $caseForm['actionAndFinding'] = isset($row['actionAndFinding']) ? Encoding::escapleAllCharacter($row['actionAndFinding']) : '';
            $caseForm['recommendation'] = isset($row['recommendation']) ? Encoding::escapleAllCharacter($row['recommendation']) : '';
            $caseForm['remark'] = isset($row['remark']) ? Encoding::escapleAllCharacter($row['remark']) : '';
            $caseForm['requiredFollowUp'] = isset($row['requiredFollowUp']) ? ($row['requiredFollowUp'] ? "true" : "false") : "false"; //Encoding::escapleAllCharacter($row['requiredFollowUp']);
            $caseForm['implementedSolution'] = isset($row['implementedSolution']) ? Encoding::escapleAllCharacter($row['implementedSolution']) : '';
            $caseForm['proposedSolution'] = isset($row['proposedSolution']) ? Encoding::escapleAllCharacter($row['proposedSolution']) : '';
            $caseForm['projectRegion'] = isset($row['projectRegion']) ? Encoding::escapleAllCharacter($row['projectRegion']) : '';
            $caseForm['projectAddress'] = isset($row['projectAddress']) ? Encoding::escapleAllCharacter($row['projectAddress']) : '';
            $caseForm['incidentId'] = $row['incidentId']??null;
            $caseForm['voltageIncidentDate'] =  isset($row['voltageIncidentDate']) ? date('Y-m-d', strtotime($row['voltageIncidentDate'])) : '';
            $caseForm['voltageIncidentTime'] =  isset($row['voltageIncidentDate']) ? date('H:i', strtotime($row['voltageIncidentDate'])) : '';
            $caseForm['voltage'] = $row['voltage']??null;
            $caseForm['circuit'] = $row['circuit']??null;
            $caseForm['durations'] = $row['durations']??null;
            $caseForm['vL1'] = $row['vL1']??null;
            $caseForm['vL2'] = $row['vL2']??null;
            $caseForm['vL3'] = $row['vL3']??null;
            $caseForm['ourRef'] = $row['ourRef']??null;
            $caseForm['planningAheadId'] = $row['planningAheadId']??null;
            
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $caseForm;
    }
    public function getCaseFormByParentCaseNoAndCaseVersionOrderByVersion($parentCaseNo,$caseVersion)
    {

        try {

            $sql = " SELECT sc.* , st.\"serviceTypeName\", e.\"eicName\", vr.\"incidentDate\" as \"voltageIncidentDate\", vr.\"voltage\", vr.\"circuit\", vr.\"durations\", vr.\"vL1\", vr.\"vL2\", vr.\"vL3\", vr.\"ourRef\" FROM ((\"TblServiceCase\" sc LEFT JOIN \"TblServiceType\" st ON sc.\"serviceTypeId\" = st.\"serviceTypeId\")
            LEFT JOIN \"TblEic\" e  ON sc.\"eicId\" =  e.\"eicId\") LEFT JOIN \"TblVoltageReport\" vr ON sc.\"incidentId\" = vr.\"Id\"  WHERE \"parentCaseNo\"= $parentCaseNo ";
            if($caseVersion != null){
                $sql.= "AND \"caseVersion\" = $caseVersion "; 
            }
            $sql.=" ORDER BY \"caseVersion\" DESC ";
            //$sth = $database->prepare($sql);
            $command = Yii::app()->db->createCommand($sql);
            $row = $command->queryRow();

            /*
            $result= $sth->execute();
            if(!$result){
				throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
				
			}
            */
            $List = array();
            //$row = $sth->fetch(PDO::FETCH_ASSOC);
            $caseForm['serviceCaseId'] = $row['serviceCaseId'];
            $caseForm['parentCaseNo'] = $row['parentCaseNo'];
            $caseForm['caseVersion'] = $row['caseVersion'];
            $caseForm['serviceTypeId'] = $row['serviceTypeId'];
            $caseForm['problemTypeId'] = $row['problemTypeId'];
            $caseForm['idrOrderId'] = $row['idrOrderId'];
            $caseForm['incidentDate'] = isset($row['incidentDate']) ? date('Y-m-d', strtotime($row['incidentDate'])) : '';
            $caseForm['incidentDateTime'] = isset($row['incidentDate']) ? date('H:i', strtotime($row['incidentDate'])) : '';
            $caseForm['requestDate'] = isset($row['requestDate']) ? date('Y-m-d', strtotime($row['requestDate'])) : '';
            $caseForm['requestDateTime'] = isset($row['requestDate']) ? date('H:i', strtotime($row['requestDate'])) : '';
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
            $caseForm['actionBy'] = $row['actionBy'];
            $caseForm['customerContactedDate'] = isset($row['customerContactedDate']) ? date('Y-m-d', strtotime($row['customerContactedDate'])) : '';
            $caseForm['requestedVisitDate'] = isset($row['requestedVisitDate']) ? date('Y-m-d', strtotime($row['requestedVisitDate'])) : '';
            $caseForm['actualVisitDate'] = isset($row['actualVisitDate']) ? date('Y-m-d', strtotime($row['actualVisitDate'])) : '';
            $caseForm['serviceStartDate'] = isset($row['serviceStartDate']) ? date('Y-m-d', strtotime($row['serviceStartDate'])) : '';
            $caseForm['serviceCompletionDate'] = isset($row['serviceCompletionDate']) ? date('Y-m-d', strtotime($row['serviceCompletionDate'])) : '';
            $caseForm['plannedReportIssueDate'] = isset($row['plannedReportIssueDate']) ? date('Y-m-d', strtotime($row['plannedReportIssueDate'])) : '';
            $caseForm['actualReportIssueDate'] = isset($row['actualReportIssueDate']) ? date('Y-m-d', strtotime($row['actualReportIssueDate'])) : '';
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
            $caseForm['requiredFollowUp'] = ($row['requiredFollowUp'] ? "true" : "false"); //Encoding::escapleAllCharacter($row['requiredFollowUp']);
            $caseForm['implementedSolution'] = Encoding::escapleAllCharacter($row['implementedSolution']);
            $caseForm['proposedSolution'] = Encoding::escapleAllCharacter($row['proposedSolution']);
            $caseForm['projectRegion'] = Encoding::escapleAllCharacter($row['projectRegion']);
            $caseForm['projectAddress'] = Encoding::escapleAllCharacter($row['projectAddress']);
            $caseForm['incidentId'] = $row['incidentId'];
            $caseForm['voltageIncidentDate'] =  isset($row['voltageIncidentDate']) ? date('Y-m-d', strtotime($row['voltageIncidentDate'])) : '';
            $caseForm['voltageIncidentTime'] =  isset($row['voltageIncidentDate']) ? date('H:i', strtotime($row['voltageIncidentDate'])) : '';
            $caseForm['voltage'] = $row['voltage'];
            $caseForm['circuit'] = $row['circuit'];
            $caseForm['durations'] = $row['durations'];
            $caseForm['vL1'] = $row['vL1'];
            $caseForm['vL2'] = $row['vL2'];
            $caseForm['vL3'] = $row['vL3'];
            $caseForm['ourRef'] = $row['ourRef'];
            $caseForm['planningAheadId'] = $row['planningAheadId'];
            
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $caseForm;
    }
#region report
    public function getCaseFormForServiceCaseReportByDateRange($startYear,$startMonth,$startDay,$endYear,$endMonth,$endDay)
    {   
        //$startDate = "#".$startDay."/".$startMonth."/".$startYear."#";
        //$endDate = "#".$endDay."/".$endMonth."/".$endYear."#";
        $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $startMonth, $startDay, $startYear));
        $endDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $endMonth, $endDay, $endYear)); 

        try {

            $sql = " SELECT sc.* , st.\"serviceTypeName\", e.\"eicName\", pt.\"plantTypeName\", pbc.\"partyToBeChargedName\", ss.\"serviceStatusName\",  
            CASE WHEN ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4) AND \"actualReportIssueDate\" >= :startDate AND \"actualReportIssueDate\" <= :endDate)  
            OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4 AND sc.\"serviceTypeId\" <> 2 AND sc.\"serviceTypeId\" <> 6) AND \"serviceCompletionDate\" >= :startDate AND \"serviceCompletionDate\" <=:endDate) 
            OR ((sc.\"serviceTypeId\" = 2 OR sc.\"serviceTypeId\"= 6) AND \"actualVisitDate\" >= :startDate AND \"actualVisitDate\" <=:endDate) THEN 'Yes' ELSE 'No' END as \"closedCase\" ,  
            CASE WHEN ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4) AND \"actualReportIssueDate\" is NULL AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)  
            OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4 AND sc.\"serviceTypeId\" <> 2 AND sc.\"serviceTypeId\" <> 6 ) AND \"serviceCompletionDate\" is NULL AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate) 
            OR ((sc.\"serviceTypeId\" = 2 OR sc.\"serviceTypeId\"= 6) AND \"actualVisitDate\" is NULL AND \"requestDate\" >= :startDate AND \"requestDate\" <=:endDate) THEN 'Yes' ELSE 'No' END as \"inProgressCase\" ,
            CASE WHEN ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4) AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)  
            OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4 AND sc.\"serviceTypeId\" <> 2 AND sc.\"serviceTypeId\" <> 6 ) AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate) 
            OR ((sc.\"serviceTypeId\" = 2 OR sc.\"serviceTypeId\"= 6) AND \"requestDate\" >= :startDate AND \"requestDate\" <=:endDate) THEN 'Yes' ELSE 'No' END as \"allCase\" 
            FROM ((((\"TblServiceCase\" sc LEFT JOIN \"TblServiceType\" st ON sc.\"serviceTypeId\" = st.\"serviceTypeId\") 
			LEFT JOIN \"TblEic\" e  ON sc.\"eicId\" =  e.\"eicId\") LEFT JOIN \"TblPlantType\" pt on sc.\"plantTypeId\" = pt.\"plantTypeId\") LEFT JOIN \"TblPartyToBeCharged\" pbc on sc.\"partyToBeChargedId\" = pbc.\"partyToBeChargedId\") LEFT JOIN \"TblServiceStatus\" ss on sc.\"serviceStatusId\" = ss.\"serviceStatusId\" 
            WHERE 
             ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4) AND \"actualReportIssueDate\" >= :startDate AND \"actualReportIssueDate\" <= :endDate)  
            OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4 AND sc.\"serviceTypeId\" <> 2 AND sc.\"serviceTypeId\" <> 6 ) AND \"serviceCompletionDate\" >= :startDate AND \"serviceCompletionDate\" <=:endDate) 
            OR ((sc.\"serviceTypeId\" = 2 OR sc.\"serviceTypeId\"= 6) AND \"actualVisitDate\" >= :startDate AND \"actualVisitDate\" <=:endDate) 
            OR ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4) AND \"actualReportIssueDate\" is NULL AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate) 
            OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4 AND sc.\"serviceTypeId\" <> 2 AND sc.\"serviceTypeId\" <> 6 ) AND \"serviceCompletionDate\" is NULL AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate) 
            OR ((sc.\"serviceTypeId\" = 2 OR sc.\"serviceTypeId\"= 6) AND \"actualVisitDate\" is NULL AND \"requestDate\" >= :startDate  AND \"requestDate\" <=:endDate) 
            OR ((sc.\"serviceTypeId\" = 3 OR sc.\"serviceTypeId\" = 4) AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate) 
            OR ((sc.\"serviceTypeId\" <>3 AND sc.\"serviceTypeId\" <>4 AND sc.\"serviceTypeId\" <> 2 AND sc.\"serviceTypeId\" <> 6 ) AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate) 
            OR ((sc.\"serviceTypeId\" = 2 OR sc.\"serviceTypeId\"= 6) AND \"requestDate\" >= :startDate AND \"requestDate\" <=:endDate)  
             " ;
            /*
                        $sql = " SELECT sc.* , st.serviceTypeName as serviceTypeName, e.eicName as eicName, pt.plantTypeName as plantTypeName, pbc.partyToBeChargedName as partyToBeChargedName ,ss.serviceStatusName as serviceStatusName , 
            IIF(((sc.serviceTypeId = 3 OR sc.serviceTypeId = 4) AND actualReportIssueDate >= $startDate AND actualReportIssueDate <= $endDate) 
            OR ((sc.serviceTypeId <>3 AND sc.serviceTypeId <>4) AND serviceCompletionDate >= $startDate AND serviceCompletionDate <=$endDate)
            OR ((sc.serviceTypeId = 2 OR sc.serviceTypeId= 6) AND actualVisitDate >=$startDate AND actualVisitDate <=$endDate) , 'Yes', 'No') as closedCase , 
            IIF(((sc.serviceTypeId = 3 OR sc.serviceTypeId = 4) AND actualReportIssueDate = NULL AND serviceStartDate <= $endDate) 
            OR ((sc.serviceTypeId <>3 AND sc.serviceTypeId <>4) AND serviceCompletionDate = NULL AND customerContactedDate <= $endDate)
            OR ((sc.serviceTypeId = 2 OR sc.serviceTypeId= 6) AND actualVisitDate =NULL AND requestedVisitDate <=$endDate) , 'Yes', 'No') as inProgressCase ,
            IIF(((sc.serviceTypeId = 3 OR sc.serviceTypeId = 4) AND serviceStartDate >= $startDate AND serviceStartDate <= $endDate) 
            OR ((sc.serviceTypeId <>3 AND sc.serviceTypeId <>4) AND customerContactedDate >= $startDate AND customerContactedDate <= $endDate)
            OR ((sc.serviceTypeId = 2 OR sc.serviceTypeId= 6) AND requestedVisitDate >=$startDate AND requestedVisitDate <=$endDate), 'Yes', 'No') as allCase
            FROM ((((TblServiceCase sc LEFT JOIN TblServiceType st ON sc.serviceTypeId = st.serviceTypeId)
			LEFT JOIN TblEic e  ON sc.eicId =  e.eicId) LEFT JOIN TblPlantType pt on sc.plantTypeId = pt.plantTypeId) LEFT JOIN TblPartyToBeCharged pbc on sc.partyToBeChargedId = pbc.partyToBeChargedId) LEFT JOIN TblServiceStatus ss on sc.serviceStatusId = ss.serviceStatusId 
            WHERE 
             ((sc.serviceTypeId = 3 OR sc.serviceTypeId = 4) AND actualReportIssueDate >= $startDate AND actualReportIssueDate <= $endDate) 
            OR ((sc.serviceTypeId <>3 AND sc.serviceTypeId <>4) AND serviceCompletionDate >= $startDate AND serviceCompletionDate <=$endDate)
            OR ((sc.serviceTypeId = 2 OR sc.serviceTypeId= 6) AND actualVisitDate >=$startDate AND actualVisitDate <=$endDate)
            OR ((sc.serviceTypeId = 3 OR sc.serviceTypeId = 4) AND actualReportIssueDate = NULL AND serviceStartDate <= $endDate) 
            OR ((sc.serviceTypeId <>3 AND sc.serviceTypeId <>4) AND serviceCompletionDate = NULL AND customerContactedDate <= $endDate) 
            OR ((sc.serviceTypeId = 2 OR sc.serviceTypeId= 6) AND actualVisitDate =NULL AND requestedVisitDate <=$endDate)
            OR ((sc.serviceTypeId = 3 OR sc.serviceTypeId = 4) AND serviceStartDate >= $startDate AND serviceStartDate <= $endDate) 
            OR ((sc.serviceTypeId <>3 AND sc.serviceTypeId <>4) AND customerContactedDate >= $startDate AND customerContactedDate <= $endDate)
            OR ((sc.serviceTypeId = 2 OR sc.serviceTypeId= 6) AND requestedVisitDate >=$startDate AND requestedVisitDate <=$endDate)  
             " ;
            */
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $sth->bindParam(':startDate',$startDate, PDO::PARAM_STR);
            $sth->bindParam(':endDate',$endDate, PDO::PARAM_STR);

            /*
            $result= $sth->execute();
            if(!$result){
				throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
				
			}
            */
            $result = $sth->queryAll();

            $caseFormList = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
            $caseForm['serviceCaseId'] = $row['serviceCaseId'];
            $caseForm['parentCaseNo'] = $row['parentCaseNo'];
            $caseForm['caseVersion'] = $row['caseVersion'];
            $caseForm['serviceTypeId'] = $row['serviceTypeId'];
            $caseForm['serviceTypeName'] = Encoding::escapleAllCharacter($row['serviceTypeName']);  
            $caseForm['problemTypeId'] = $row['problemTypeId'];
            $caseForm['idrOrderId'] = $row['idrOrderId'];
            $caseForm['incidentDate'] = isset($row['incidentDate']) ? date('Y-m-d', strtotime($row['incidentDate'])) : '';
            $caseForm['incidentDateTime'] = isset($row['incidentDate']) ? date('H:i', strtotime($row['incidentDate'])) : '';
            $caseForm['requestDate'] = isset($row['requestDate']) ? date('Y-m-d', strtotime($row['requestDate'])) : '';
            $caseForm['requestDateTime'] = isset($row['requestDate']) ? date('H:i', strtotime($row['requestDate'])) : '';
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
            $caseForm['actionBy'] = $row['actionBy'];
            $caseForm['customerContactedDate'] = isset($row['customerContactedDate']) ? date('Y-m-d', strtotime($row['customerContactedDate'])) : '';
            $caseForm['requestedVisitDate'] = isset($row['requestedVisitDate']) ? date('Y-m-d', strtotime($row['requestedVisitDate'])) : '';
            $caseForm['actualVisitDate'] = isset($row['actualVisitDate']) ? date('Y-m-d', strtotime($row['actualVisitDate'])) : '';
            $caseForm['serviceStartDate'] = isset($row['serviceStartDate']) ? date('Y-m-d', strtotime($row['serviceStartDate'])) : '';
            $caseForm['serviceCompletionDate'] = isset($row['serviceCompletionDate']) ? date('Y-m-d', strtotime($row['serviceCompletionDate'])) : '';
            $caseForm['plannedReportIssueDate'] = isset($row['plannedReportIssueDate']) ? date('Y-m-d', strtotime($row['plannedReportIssueDate'])) : '';
            $caseForm['actualReportIssueDate'] = isset($row['actualReportIssueDate']) ? date('Y-m-d', strtotime($row['actualReportIssueDate'])) : '';
            $caseForm['actualReportWorkingDay'] = $row['actualReportWorkingDay'];
            $caseForm['actualResponseDay'] = $row['actualResponseDay'];
            $caseForm['actualWorkingDay'] = $row['actualWorkingDay'];
            $caseForm['caseReferredToClpe'] = $row['caseReferredToClpe'];
            $caseForm['serviceStatusId'] = $row['serviceStatusId'];
            $caseForm['serviceStatusName'] = $row['serviceStatusName'];
            $caseForm['mp'] = $row['mp'];
            $caseForm['g'] = $row['g'];
            $caseForm['t'] = $row['t'];
            $caseForm['eicId'] = $row['eicId'];
            $caseForm['costTypeId'] = $row['costTypeId'];
            $caseForm['costUnit'] = $row['costUnit'];
            $caseForm['costTotal'] = $row['costTotal'];
            $caseForm['partyToBeChargedId'] = $row['partyToBeChargedId'];
            $caseForm['partyToBeChargedName'] = Encoding::escapleAllCharacter($row['partyToBeChargedName']);  
            $caseForm['plantTypeId'] = $row['plantTypeId'];
            $caseForm['plantTypeName'] = $row['plantTypeName'];
            $caseForm['active'] = $row['active'];
            $caseForm['manufacturerBrand'] = $row['manufacturerBrand'];
            $caseForm['majorAffectedElementId'] = $row['majorAffectedElementId'];
            $caseForm['plantRating'] = $row['plantRating'];
            $caseForm['customerProblem'] = Encoding::escapleAllCharacter($row['customerProblem']);
            $caseForm['actionAndFinding'] = Encoding::escapleAllCharacter($row['actionAndFinding']);
            $caseForm['recommendation'] = Encoding::escapleAllCharacter($row['recommendation']);
            $caseForm['remark'] = Encoding::escapleAllCharacter($row['remark']);
            $caseForm['requiredFollowUp'] = ($row['requiredFollowUp'] ? "true" : "false"); //Encoding::escapleAllCharacter($row['requiredFollowUp']);
            $caseForm['implementedSolution'] = Encoding::escapleAllCharacter($row['implementedSolution']);
            $caseForm['proposedSolution'] = Encoding::escapleAllCharacter($row['proposedSolution']);
            $caseForm['projectRegion'] = Encoding::escapleAllCharacter($row['projectRegion']);
            $caseForm['projectAddress'] = Encoding::escapleAllCharacter($row['projectAddress']);
            $caseForm['closedCase'] = $row['closedCase'];
            $caseForm['inProgressCase'] = $row['inProgressCase'];
            $caseForm['allCase'] = $row['allCase'];
            $caseForm['completedBeforeTargetDate'] = $row['completedBeforeTargetDate'];
            array_push($caseFormList, $caseForm);
            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $caseFormList;
    }

    public function getFormPartyToBeChargedActiveUnionForm($startYear,$startMonth,$startDay,$endYear,$endMonth,$endDay)
    {
        //$startDate = "#".$startDay."/".$startMonth."/".$startYear."#";
        //$endDate = "#".$endDay."/".$endMonth."/".$endYear."#";
        $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $startMonth, $startDay, $startYear));
        $endDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $endMonth, $endDay, $endYear)); 

        try {
            $sql = " SELECT \"partyToBeChargedId\"  , \"partyToBeChargedName\" ,\"showOrder\" 
            FROM \"TblPartyToBeCharged\" WHERE (\"partyToBeChargedId\") IN
            ( SELECT Distinct \"partyToBeChargedId\" 
            FROM \"TblServiceCase\" WHERE 
               ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"actualReportIssueDate\" >= :startDate AND \"actualReportIssueDate\" <= :endDate) 
            OR ((\"serviceTypeId\" <>3 AND \"serviceTypeId\" <>4 AND \"serviceTypeId\" <>2 AND \"serviceTypeId\" <> 6 ) AND \"serviceCompletionDate\" >= :startDate AND \"serviceCompletionDate\" <=:endDate)
            OR ((\"serviceTypeId\" = 2 OR \"serviceTypeId\"= 6) AND \"actualVisitDate\" >=:startDate AND \"actualVisitDate\" <=:endDate)
            OR ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"actualReportIssueDate\" is NULL AND \"requestDate\" >= :startDate  AND \"requestDate\" <= :endDate) 
            OR ((\"serviceTypeId\" <>3 AND \"serviceTypeId\" <>4 AND \"serviceTypeId\" <>2 AND \"serviceTypeId\" <> 6 ) AND \"serviceCompletionDate\" is NULL AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)
            OR ((\"serviceTypeId\" = 2 OR \"serviceTypeId\"= 6) AND \"actualVisitDate\" is NULL AND \"requestDate\" >= :startDate AND \"requestDate\" <=:endDate)
            OR ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate) 
            OR ((\"serviceTypeId\" <>3 AND \"serviceTypeId\" <>4 AND \"serviceTypeId\" <>2 AND \"serviceTypeId\" <> 6 ) AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)
            OR ((\"serviceTypeId\" = 2 OR \"serviceTypeId\"= 6) AND \"requestDate\" >=:startDate AND \"requestDate\" <=:endDate)
            ) OR \"active\" ='Y' ORDER BY  \"showOrder\"::NUMERIC ASC" ;
            /*
                        $sql = " SELECT partyToBeChargedId  , partyToBeChargedName ,showOrder 
            FROM TblPartyToBeCharged WHERE (partyToBeChargedId) IN
            ( SELECT Distinct partyToBeChargedId 
            FROM TblServiceCase WHERE 
               ((serviceTypeId = 3 OR serviceTypeId = 4) AND actualReportIssueDate >= $startDate AND actualReportIssueDate <= $endDate) 
            OR ((serviceTypeId <>3 AND serviceTypeId <>4) AND serviceCompletionDate >= $startDate AND serviceCompletionDate <=$endDate)
            OR ((serviceTypeId = 2 OR serviceTypeId= 6) AND actualVisitDate >=$startDate AND actualVisitDate <=$endDate)
            OR ((serviceTypeId = 3 OR serviceTypeId = 4) AND actualReportIssueDate = NULL AND serviceStartDate <= $endDate) 
            OR ((serviceTypeId <>3 AND serviceTypeId <>4) AND serviceCompletionDate = NULL AND customerContactedDate <= $endDate)
            OR ((serviceTypeId = 2 OR serviceTypeId= 6) AND actualVisitDate =NULL AND requestedVisitDate <=$endDate)
            OR ((serviceTypeId = 3 OR serviceTypeId = 4) AND serviceStartDate >= $startDate AND serviceStartDate <= $endDate) 
            OR ((serviceTypeId <>3 AND serviceTypeId <>4) AND customerContactedDate >= $startDate AND customerContactedDate <= $endDate)
            OR ((serviceTypeId = 2 OR serviceTypeId= 6) AND requestedVisitDate >=$startDate AND requestedVisitDate <=$endDate)
            ) OR active ='Y' ORDER BY Cint(showOrder) ASC" ;
            */
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $sth->bindParam(':startDate',$startDate, PDO::PARAM_STR);
            $sth->bindParam(':endDate',$endDate, PDO::PARAM_STR);

            /*
            $result= $sth->execute();
            if(!$result){
				throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
				
			}
            */
            $result = $sth->queryAll();

            $List = array();
            $outputList = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $List['partyToBeChargedId'] = $row['partyToBeChargedId'];
                $List['partyToBeChargedName'] = Encoding::escapleAllCharacter($row['partyToBeChargedName']);  
                array_push($outputList, $List);
            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $outputList;
    }
    public function getFormServiceTypeActiveUnionForm($startYear,$startMonth,$startDay,$endYear,$endMonth,$endDay)
    {
        //$startDate = "#".$startDay."/".$startMonth."/".$startYear."#";
        //$endDate = "#".$endDay."/".$endMonth."/".$endYear."#";
        $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $startMonth, $startDay, $startYear));
        $endDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $endMonth, $endDay, $endYear)); 

        try {
            $sql = " SELECT \"serviceTypeId\" , \"serviceTypeName\" ,\"showOrder\"
            FROM \"TblServiceType\" WHERE (\"serviceTypeId\") IN
            ( SELECT Distinct \"serviceTypeId\" 
            FROM \"TblServiceCase\" WHERE 
            ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"actualReportIssueDate\" >= :startDate AND \"actualReportIssueDate\" <= :endDate) 
            OR ((\"serviceTypeId\" <>3 AND \"serviceTypeId\" <>4 AND \"serviceTypeId\" <>2 AND \"serviceTypeId\" <> 6 ) AND \"serviceCompletionDate\" >= :startDate AND \"serviceCompletionDate\" <=:endDate)
            OR ((\"serviceTypeId\" = 2 OR \"serviceTypeId\"= 6) AND \"actualVisitDate\" >=:startDate AND \"actualVisitDate\" <=:endDate)
            OR ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"actualReportIssueDate\" is NULL AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate) 
            OR ((\"serviceTypeId\" <>3 AND \"serviceTypeId\" <>4 AND \"serviceTypeId\" <>2 AND \"serviceTypeId\" <> 6 ) AND \"serviceCompletionDate\" is NULL AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)
            OR ((\"serviceTypeId\" = 2 OR \"serviceTypeId\"= 6) AND \"actualVisitDate\" is NULL AND \"requestDate\" >= :startDate AND \"requestDate\" <=:endDate)
            OR ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate) 
            OR ((\"serviceTypeId\" <>3 AND \"serviceTypeId\" <>4 AND \"serviceTypeId\" <>2 AND \"serviceTypeId\" <> 6 ) AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)
            OR ((\"serviceTypeId\" = 2 OR \"serviceTypeId\"= 6) AND \"requestDate\" >=:startDate AND \"requestDate\" <=:endDate)
            ) OR \"active\" ='Y' ORDER BY  \"showOrder\"::NUMERIC ASC" ;
            /*
            $sql = " SELECT serviceTypeId , serviceTypeName ,showOrder
            FROM TblServiceType WHERE (serviceTypeId) IN
            ( SELECT Distinct serviceTypeId 
            FROM TblServiceCase WHERE 
            ((serviceTypeId = 3 OR serviceTypeId = 4) AND actualReportIssueDate >= $startDate AND actualReportIssueDate <= $endDate) 
            OR ((serviceTypeId <>3 AND serviceTypeId <>4) AND serviceCompletionDate >= $startDate AND serviceCompletionDate <=$endDate)
            OR ((serviceTypeId = 2 OR serviceTypeId= 6) AND actualVisitDate >=$startDate AND actualVisitDate <=$endDate)
            OR ((serviceTypeId = 3 OR serviceTypeId = 4) AND actualReportIssueDate = NULL AND serviceStartDate <= $endDate) 
            OR ((serviceTypeId <>3 AND serviceTypeId <>4) AND serviceCompletionDate = NULL AND customerContactedDate <= $endDate)
            OR ((serviceTypeId = 2 OR serviceTypeId= 6) AND actualVisitDate =NULL AND requestedVisitDate <=$endDate)
            OR ((serviceTypeId = 3 OR serviceTypeId = 4) AND serviceStartDate >= $startDate AND serviceStartDate <= $endDate) 
            OR ((serviceTypeId <>3 AND serviceTypeId <>4) AND customerContactedDate >= $startDate AND customerContactedDate <= $endDate)
            OR ((serviceTypeId = 2 OR serviceTypeId= 6) AND requestedVisitDate >=$startDate AND requestedVisitDate <=$endDate)
            ) OR active ='Y' ORDER BY Cint(showOrder) ASC" ;
            */
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $sth->bindParam(':startDate',$startDate, PDO::PARAM_STR);
            $sth->bindParam(':endDate',$endDate, PDO::PARAM_STR);
            
            /*
            $result= $sth->execute();
            if(!$result){
				throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
				
			}
            */
            $result = $sth->queryAll();

            $List = array();
            $outputList = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $List['serviceTypeId'] = $row['serviceTypeId'];
                $List['serviceTypeName'] = Encoding::escapleAllCharacter($row['serviceTypeName']);  
                array_push($outputList, $List);
            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $outputList;
    }
#endregion report
#region planningAhead
    public function GetPlanningAheadSearchResultCount($searchParam)
    {

        try {

        $sql = 'SELECT count(1) FROM "TblPlanningAhead" WHERE 1=1 ';

        $planningAheadId = isset($searchParam['planningAheadId']) ? $searchParam['planningAheadId'] : '';
        $projectTitle = isset($searchParam['projectTitle']) ? $searchParam['projectTitle'] : '';
        $reportedBy = isset($searchParam['reportedBy']) ? $searchParam['reportedBy'] : '';
        $projectRegion = isset($searchParam['projectRegion']) ? $searchParam['projectRegion'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';

        if ($planningAheadId != '') {
            $sql = $sql . 'AND "planningAheadId"::text LIKE :planningAheadId ';
        }
        if ($projectTitle != '') {
            $sql = $sql . 'AND "projectTitle" LIKE :projectTitle ';
        }
        if ($reportedBy != '') {
            $sql = $sql . 'AND "reportedBy" LIKE :reportedBy ';
        }
        if ($projectRegion != '') {
            $sql = $sql . 'AND "projectRegion" = :projectRegion ';
        }
        if ($active != '') {

            $sql = $sql . ' AND "active" LIKE :active ';
        }
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            if ($planningAheadId != '') {
                $planningAheadId = "%" . $planningAheadId . "%";
                $sth->bindParam(':planningAheadId', $planningAheadId);


            }
            if ($projectTitle != '') {
                $projectTitle = "%" . $projectTitle . "%";
                $sth->bindParam(':projectTitle', $projectTitle);


            }
            if ($reportedBy != '') {
                $reportedBy = "%" . $reportedBy . "%";
                $sth->bindParam(':reportedBy', $reportedBy);


            }
            if ($projectRegion != '') {
                $sth->bindParam(':projectRegion', $projectRegion);


            }
            if ($active != '') {
                $active = "%" . $active . "%";
                $sth->bindParam(':active', $active);

            }
            /*
           $result = $sth->execute();
           if(!$result){
            throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
            }
            
            $count = $sth->fetchColumn();
            */
            $result = $sth->queryRow();
            $count = $result['count'];

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $count;
    }
    public function GetPlanningAheadRecordCount()
    {

        try {
            $sql = 'SELECT count(1) FROM "TblPlanningAhead"';
            /*
            $result = $database->query($sql);
            $count = $result->fetchColumn();
            */
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryRow();
            $count = $result['count'];
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $count;
    }

    public function GetPlanningAheadSearchByPage($searchParam, $start, $length, $orderByStr)
    {

        //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' pa.*, bt.buildingTypeName as buildingTypeName, pt.projectTypeName as projectTypeName, cc.consultantCompanyName as consultantCompanyName, ct.consultantName as consultantName, rp.regionPlannerName as regionPlannerName, rsrg.replySlipReturnGradeName as replySlipReturnGradeName ';

        //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' planningAheadId ';

        $sqlMid = 'SELECT pa.*, bt."buildingTypeName", pt."projectTypeName", cc."consultantCompanyName", ct."consultantName", rp."regionPlannerName", rsrg."replySlipReturnGradeName" ';

        $sqlBase = 'SELECT "planningAheadId" ';

        $sql1 = 'FROM (((((("TblPlanningAhead" pa LEFT JOIN "TblBuildingType" bt on pa."buildingTypeId" = bt."buildingTypeId" ) LEFT JOIN "TblProjectType" pt on pa."projectTypeId" = pt."projectTypeId" ) LEFT JOIN "TblConsultantCompany" cc on pa."consultantCompanyNameId" = cc."consultantCompanyId" ) LEFT JOIN "TblConsultant" ct on pa."consultantNameId" = ct."consultantId" ) LEFT JOIN "TblRegionPlanner" rp on pa."regionPlannerId" = rp."regionPlannerId" ) LEFT JOIN "TblReplySlipReturnGrade" rsrg on pa."replySlipGradeId" = rsrg."replySlipReturnGradeId" ) WHERE 1=1 ';

        $sql2 = 'FROM "TblPlanningAhead"  WHERE 1=1 ';

        $planningAheadId = isset($searchParam['planningAheadId']) ? $searchParam['planningAheadId'] : '';
        $projectTitle = isset($searchParam['projectTitle']) ? $searchParam['projectTitle'] : '';
        $reportedBy = isset($searchParam['reportedBy']) ? $searchParam['reportedBy'] : '';
        $projectRegion = isset($searchParam['projectRegion']) ? $searchParam['projectRegion'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';

        if ($planningAheadId != '') {
            $sql1 = $sql1 . 'AND "planningAheadId"::text LIKE :planningAheadId1 ';
            $sql2 = $sql2 . 'AND "planningAheadId"::text LIKE :planningAheadId2 ';
        }
        if ($projectTitle != '') {
            $sql1 = $sql1 . 'AND "projectTitle" LIKE :projectTitle1 ';
            $sql2 = $sql2 . 'AND "projectTitle" LIKE :projectTitle2 ';
        }
        if ($reportedBy != '') {
            $sql1 = $sql1 . 'AND "reportedBy" LIKE :reportedBy1 ';
            $sql2 = $sql2 . 'AND "reportedBy" LIKE :reportedBy2 ';
        }
        if ($projectRegion != '') {
            $sql1 = $sql1 . 'AND "projectRegion" = :projectRegion1 ';
            $sql2 = $sql2 . 'AND "projectRegion" = :projectRegion2 ';
        }
        if ($active != '') {

            $sql1 = $sql1 . 'AND pa."active" LIKE :active1 ';
            $sql2 = $sql2 . 'AND pa."active" LIKE :active2 ';
        }

        if ($orderByStr != '') {
            if($orderByStr != '"active" asc' && $orderByStr !='"active" desc'){
                $sql1 = $sql1 . " ORDER BY " . $orderByStr . ' ';
                $sql2 = $sql2 . " ORDER BY " . $orderByStr . ' ';
            }
            else{
                $sql1 = $sql1 . " ORDER BY pa." . $orderByStr . ' ';
                $sql2 = $sql2 . " ORDER BY " . $orderByStr . ' ';
            }

        }
        if ($start != 0) {
            $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "planningAheadId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
        } else {
            $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
        }

        try
        {
            //$sth = $database->prepare($sqlFinal);
            $sth = Yii::app()->db->createCommand($sqlFinal);
            if ($planningAheadId != '') {
                $planningAheadId = "%" . $planningAheadId . "%";
                $sth->bindParam(':planningAheadId1', $planningAheadId);
                if ($start != 0) {
                    $sth->bindParam(':planningAheadId2', $planningAheadId);
                }

            }
            if ($projectTitle != '') {
                $projectTitle = "%" . $projectTitle . "%";
                $sth->bindParam(':projectTitle1', $projectTitle);
                if ($start != 0) {
                    $sth->bindParam(':projectTitle2', $projectTitle);
                }

            }
            if ($reportedBy != '') {
                $reportedBy = "%" . $reportedBy . "%";
                $sth->bindParam(':reportedBy1', $reportedBy);
                if ($start != 0) {
                    $sth->bindParam(':reportedBy2', $reportedBy);
                }

            }
            if ($projectRegion != '') {
                $sth->bindParam(':projectRegion1', $projectRegion);
                if ($start != 0) {
                    $sth->bindParam(':projectRegion2', $projectRegion);
                }

            }
            if ($active != '') {
                $active = "%" . $active . "%";
                $sth->bindParam(':active1', $active);
                if ($start != 0) {
                    $sth->bindParam(':active2', $active);
                }

            }

            /*
            $result= $sth->execute();
            if(!$result){
				throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
				
			}
            */
            $result = $sth->queryAll();
            $List = array();
            $PlanningAheadList = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
            //project
            $List['planningAheadId'] = $row['planningAheadId'];
            $List['projectTitle'] =  Encoding::escapleAllCharacter($row['projectTitle']);
            $List['schemeNumber'] = $row['schemeNumber'];
            $List['projectRegion'] =  Encoding::escapleAllCharacter($row['projectRegion']);
            $List['projectAddress'] =  Encoding::escapleAllCharacter($row['projectAddress']);
            $List['projectAddressParentCaseNo'] = $row['projectAddressParentCaseNo'];
            $List['projectAddressCaseVersion'] = $row['projectAddressCaseVersion'];
            $List['inputDate'] = $row['inputDate'];
            $List['regionLetterIssueDate'] = $row['regionLetterIssueDate'];
            $List['reportedBy'] = $row['reportedBy'];
            $List['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $List['lastUpdatedTime'] = $row['lastUpdatedTime'];
            $List['regionPlannerId'] = $row['regionPlannerId'];
            //type
            $List['buildingTypeId'] = $row['buildingTypeId'];
            $List['projectTypeId'] = $row['projectTypeId'];
            $List['keyInfrastructure'] = $row['keyInfrastructure'];
            $List['potentialSuccessfulCase'] = $row['potentialSuccessfulCase'];
            $List['criticalProject'] = $row['criticalProject'];
            $List['tempSupplyProject'] = $row['tempSupplyProject'];
            //equipment
            $List['bms'] = ($row['bms'] ? "true" : "false"); //$row['bms'];
            $List['changeoverScheme'] = ($row['changeoverScheme'] ? "true" : "false"); //$row['changeoverScheme'];
            $List['chillerPlant'] = ($row['chillerPlant'] ? "true" : "false"); //$row['chillerPlant'];
            $List['escalator'] = ($row['escalator'] ? "true" : "false"); //$row['escalator'];
            $List['hidLamp'] = ($row['hidLamp'] ? "true" : "false"); //$row['hidLamp'];
            $List['lift'] = ($row['lift'] ? "true" : "false"); //$row['lift'];
            $List['sensitiveMachine'] = ($row['sensitiveMachine'] ? "true" : "false"); //$row['sensitiveMachine'];
            $List['telcom'] = ($row['telcom'] ? "true" : "false"); //$row['telcom'];
            $List['acbTripping'] = ($row['acbTripping'] ? "true" : "false"); //$row['acbTripping'];
            $List['buildingWithHighPenetrationEquipment'] = ($row['buildingWithHighPenetrationEquipment'] ? "true" : "false"); //$row['buildingWithHighPenetrationEquipment'];
            $List['re'] = ($row['re'] ? "true" : "false"); //$row['re'];
            $List['ev'] = ($row['ev'] ? "true" : "false"); //$row['ev'];
        /*  $List['criticalEquipment1'] = $row['criticalEquipment1'];
            $List['criticalEquipment2'] = $row['criticalEquipment2'];
            $List['criticalEquipment3'] = $row['criticalEquipment3'];
            $List['criticalEquipment4'] = $row['criticalEquipment4'];
            $List['criticalEquipment5'] = $row['criticalEquipment5'];*/
            $List['estimatedLoad'] = $row['estimatedLoad'];
            $List['pqisNumber'] = $row['pqisNumber'];
            //pqwalk
            $List['pqSiteWalkProjectRegion'] =  Encoding::escapleAllCharacter($row['pqSiteWalkProjectRegion']);
            $List['pqSiteWalkProjectAddress'] =  Encoding::escapleAllCharacter($row['pqSiteWalkProjectAddress']);
            $List['sensitiveEquipment'] = Encoding::escapleAllCharacter( $row['sensitiveEquipment']);
            //pqwalk first walk
            $List['firstPqSiteWalkDate'] = isset($row['firstPqSiteWalkDate']) ? date('Y-m-d', strtotime($row['firstPqSiteWalkDate'])) : '';
            $List['firstPqSiteWalkStatus'] = $row['firstPqSiteWalkStatus'];
            $List['firstPqSiteWalkInvitationLetterLink'] = $row['firstPqSiteWalkInvitationLetterLink'];
            $List['firstPqSiteWalkRequestLetterDate'] = isset($row['firstPqSiteWalkRequestLetterDate']) ? date('Y-m-d', strtotime($row['firstPqSiteWalkRequestLetterDate'])) : '';
            $List['pqWalkAssessmentReportDate'] = isset($row['pqWalkAssessmentReportDate']) ? date('Y-m-d', strtotime($row['pqWalkAssessmentReportDate'])) : '';
            $List['pqWalkAssessmentReportLink'] = $row['pqWalkAssessmentReportLink'];
            $List['firstPqSiteWalkParentCaseNo'] = $row['firstPqSiteWalkParentCaseNo'];
            $List['firstPqSiteWalkCaseVersion'] = $row['firstPqSiteWalkCaseVersion'];
            $List['firstPqSiteWalkCustomerResponse'] = $row['firstPqSiteWalkCustomerResponse'];
            $List['firstPqSiteWalkInvestigationStatus'] = $row['firstPqSiteWalkInvestigationStatus'];
            //pqwalk second walk
            $List['secondPqSiteWalkDate'] = isset($row['secondPqSiteWalkDate']) ? date('Y-m-d', strtotime($row['secondPqSiteWalkDate'])) : '';
            $List['secondPqSiteWalkInvitationLetterLink'] = $row['secondPqSiteWalkInvitationLetterLink'];
            $List['secondPqSiteWalkRequestLetterDate'] = isset($row['secondPqSiteWalkRequestLetterDate']) ? date('Y-m-d', strtotime($row['secondPqSiteWalkRequestLetterDate'])) : '';
            $List['pqAssessmentFollowUpReportDate'] = isset($row['pqAssessmentFollowUpReportDate']) ? date('Y-m-d', strtotime($row['pqAssessmentFollowUpReportDate'])) : '';
            $List['pqAssessmentFollowUpReportLink'] = $row['pqAssessmentFollowUpReportLink'];
            $List['secondPqSiteWalkParentCaseNo'] = $row['secondPqSiteWalkParentCaseNo'];
            $List['secondPqSiteWalkCaseVersion'] = $row['secondPqSiteWalkCaseVersion'];
            $List['secondPqSiteWalkCustomerResponse'] = $row['secondPqSiteWalkCustomerResponse'];
            $List['secondPqSiteWalkInvestigationStatus'] = $row['secondPqSiteWalkInvestigationStatus'];
            //consultant information
            $List['consultantCompanyNameId'] = $row['consultantCompanyNameId'];
            $List['consultantNameId'] = $row['consultantNameId'];
            $List['phoneNumber1'] = $row['phoneNumber1'];
            $List['phoneNumber2'] = $row['phoneNumber2'];
            $List['phoneNumber3'] = $row['phoneNumber3'];
            $List['email1'] = $row['email1'];
            $List['email2'] = $row['email2'];
            $List['email3'] = $row['email3'];
            $List['consultantInformationRemark'] =  Encoding::escapleAllCharacter($row['consultantInformationRemark']);
            $List['estimatedCommisioningDateByCustomer'] = isset($row['estimatedCommisioningDateByCustomer']) ? date('Y-m-d', strtotime($row['estimatedCommisioningDateByCustomer'])) : '';
            $List['estimatedCommisioningDateByRegion'] = isset($row['estimatedCommisioningDateByRegion']) ? date('Y-m-d', strtotime($row['estimatedCommisioningDateByRegion'])) : '';
            $List['planningAheadStatus'] = $row['planningAheadStatus'];
            //reply sLip
            $List['invitationToPaMeetingDate'] = isset($row['invitationToPaMeetingDate']) ? date('Y-m-d', strtotime($row['invitationToPaMeetingDate'])) : '';
            $List['replySlipParentCaseNo'] = $row['replySlipParentCaseNo'];
            $List['replySlipCaseVersion'] = $row['replySlipCaseVersion'];
            $List['replySlipSentDate'] = isset($row['replySlipSentDate']) ? date('Y-m-d', strtotime($row['replySlipSentDate'])) : '';
            $List['finish'] = $row['finish'];
            $List['actualReplySlipReturnDate'] = isset($row['actualReplySlipReturnDate']) ? date('Y-m-d', strtotime($row['actualReplySlipReturnDate'])) : '';
            $List['findingsFromReplySlip'] =  Encoding::escapleAllCharacter($row['findingsFromReplySlip']);
            $List['replySlipfollowUpActionFlag'] = $row['replySlipfollowUpActionFlag'];
            $List['replySlipfollowUpAction'] =  Encoding::escapleAllCharacter($row['replySlipfollowUpAction']);
            $List['replySlipRemark'] =  Encoding::escapleAllCharacter($row['replySlipRemark']);
            //reply slip reply slip
            $List['replySlipSendLink'] = $row['replySlipSendLink'];
            $List['replySlipReturnLink'] = $row['replySlipReturnLink'];
            $List['replySlipGradeId'] = $row['replySlipGradeId'];
            $List['dateOfRequestedForReturnReplySlip'] = isset($row['dateOfRequestedForReturnReplySlip']) ? date('Y-m-d', strtotime($row['dateOfRequestedForReturnReplySlip'])) : '';
            //additional
            $List['receiveComplaint'] =  Encoding::escapleAllCharacter($row['receiveComplaint']);
            $List['followUpAction'] =  Encoding::escapleAllCharacter($row['followUpAction']);
            $List['remark'] =  Encoding::escapleAllCharacter($row['remark']);
            $List['active'] = $row['active'];
            
            $List['buildingTypeName'] = Encoding::escapleAllCharacter($row['buildingTypeName']);
            $List['projectTypeName'] = Encoding::escapleAllCharacter($row['projectTypeName']);
            $List['consultantCompanyName'] = Encoding::escapleAllCharacter($row['consultantCompanyName']);
            $List['consultantName'] = Encoding::escapleAllCharacter($row['consultantName']);
            $List['regionPlannerName'] = Encoding::escapleAllCharacter($row['regionPlannerName']);
            $List['replySlipGradeName'] = Encoding::escapleAllCharacter($row['replySlipReturnGradeName']);
            array_push($PlanningAheadList, $List);

            }
            //$PlanningAheadList['totalCount'] = count($PlanningAheadList);

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $PlanningAheadList;
    }
   

    public function getPlanningAheadByPlanningAheadId($planningAheadId)
    {

        try {
            $sql = ' SELECT *  FROM "TblPlanningAhead" WHERE "planningAheadId" = :planningAheadId ';
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);
            
            $sth->bindParam(':planningAheadId', $planningAheadId);
            /*
            $result= $sth->execute();
            if(!$result){
				throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
				
			}
            */
            $row = $sth->queryRow();
            $List = array();
            //$row = $sth->fetch(PDO::FETCH_ASSOC);
            //project
            $List['planningAheadId'] = $row['planningAheadId'];
            $List['projectTitle'] =  Encoding::escapleAllCharacter($row['projectTitle']);
            $List['schemeNumber'] = $row['schemeNumber'];
            $List['projectRegion'] =  Encoding::escapleAllCharacter($row['projectRegion']);
            $List['projectAddress'] =  Encoding::escapleAllCharacter($row['projectAddress']);
            $List['projectAddressParentCaseNo'] = $row['projectAddressParentCaseNo'];
            $List['projectAddressCaseVersion'] = $row['projectAddressCaseVersion'];
            $List['inputDate'] = $row['inputDate'];
            $List['regionLetterIssueDate'] = $row['regionLetterIssueDate'];
            $List['reportedBy'] = $row['reportedBy'];
            $List['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $List['lastUpdatedTime'] = $row['lastUpdatedTime'];
            $List['regionPlannerId'] = $row['regionPlannerId'];
            //type
            $List['buildingTypeId'] = $row['buildingTypeId'];
            $List['projectTypeId'] = $row['projectTypeId'];
            $List['keyInfrastructure'] = $row['keyInfrastructure'];
            $List['potentialSuccessfulCase'] = $row['potentialSuccessfulCase'];
            $List['criticalProject'] = $row['criticalProject'];
            $List['tempSupplyProject'] = $row['tempSupplyProject'];
            //equipment
            $List['bms'] = ($row['bms'] ? "true" : "false"); //$row['bms'];
            $List['changeoverScheme'] = ($row['changeoverScheme'] ? "true" : "false"); //$row['changeoverScheme'];
            $List['chillerPlant'] = ($row['chillerPlant'] ? "true" : "false"); //$row['chillerPlant'];
            $List['escalator'] = ($row['escalator'] ? "true" : "false"); //$row['escalator'];
            $List['hidLamp'] = ($row['hidLamp'] ? "true" : "false"); //$row['hidLamp'];
            $List['lift'] = ($row['lift'] ? "true" : "false"); //$row['lift'];
            $List['sensitiveMachine'] = ($row['sensitiveMachine'] ? "true" : "false"); //$row['sensitiveMachine'];
            $List['telcom'] = ($row['telcom'] ? "true" : "false"); //$row['telcom'];
            $List['acbTripping'] = ($row['acbTripping'] ? "true" : "false"); //$row['acbTripping'];
            $List['buildingWithHighPenetrationEquipment'] = ($row['buildingWithHighPenetrationEquipment'] ? "true" : "false"); //$row['buildingWithHighPenetrationEquipment'];
            $List['re'] = ($row['re'] ? "true" : "false"); //$row['re'];
            $List['ev'] = ($row['ev'] ? "true" : "false"); //$row['ev'];
        /*  $List['criticalEquipment1'] = $row['criticalEquipment1'];
            $List['criticalEquipment2'] = $row['criticalEquipment2'];
            $List['criticalEquipment3'] = $row['criticalEquipment3'];
            $List['criticalEquipment4'] = $row['criticalEquipment4'];
            $List['criticalEquipment5'] = $row['criticalEquipment5'];*/
            $List['estimatedLoad'] = $row['estimatedLoad'];
            $List['pqisNumber'] = $row['pqisNumber'];
            //pqwalk
            $List['pqSiteWalkProjectRegion'] =  Encoding::escapleAllCharacter($row['pqSiteWalkProjectRegion']);
            $List['pqSiteWalkProjectAddress'] =  Encoding::escapleAllCharacter($row['pqSiteWalkProjectAddress']);
            $List['sensitiveEquipment'] = Encoding::escapleAllCharacter( $row['sensitiveEquipment']);
            //pqwalk first walk
            $List['firstPqSiteWalkDate'] = isset($row['firstPqSiteWalkDate']) ? date('Y-m-d', strtotime($row['firstPqSiteWalkDate'])) : '';
            $List['firstPqSiteWalkStatus'] = $row['firstPqSiteWalkStatus'];
            $List['firstPqSiteWalkInvitationLetterLink'] = $row['firstPqSiteWalkInvitationLetterLink'];
            $List['firstPqSiteWalkRequestLetterDate'] = isset($row['firstPqSiteWalkRequestLetterDate']) ? date('Y-m-d', strtotime($row['firstPqSiteWalkRequestLetterDate'])) : '';
            $List['pqWalkAssessmentReportDate'] = isset($row['pqWalkAssessmentReportDate']) ? date('Y-m-d', strtotime($row['pqWalkAssessmentReportDate'])) : '';
            $List['pqWalkAssessmentReportLink'] = $row['pqWalkAssessmentReportLink'];
            $List['firstPqSiteWalkParentCaseNo'] = $row['firstPqSiteWalkParentCaseNo'];
            $List['firstPqSiteWalkCaseVersion'] = $row['firstPqSiteWalkCaseVersion'];
            $List['firstPqSiteWalkCustomerResponse'] = $row['firstPqSiteWalkCustomerResponse'];
            $List['firstPqSiteWalkInvestigationStatus'] = $row['firstPqSiteWalkInvestigationStatus'];
            //pqwalk second walk
            $List['secondPqSiteWalkDate'] = isset($row['secondPqSiteWalkDate']) ? date('Y-m-d', strtotime($row['secondPqSiteWalkDate'])) : '';
            $List['secondPqSiteWalkInvitationLetterLink'] = $row['secondPqSiteWalkInvitationLetterLink'];
            $List['secondPqSiteWalkRequestLetterDate'] = isset($row['secondPqSiteWalkRequestLetterDate']) ? date('Y-m-d', strtotime($row['secondPqSiteWalkRequestLetterDate'])) : '';
            $List['pqAssessmentFollowUpReportDate'] = isset($row['pqAssessmentFollowUpReportDate']) ? date('Y-m-d', strtotime($row['pqAssessmentFollowUpReportDate'])) : '';
            $List['pqAssessmentFollowUpReportLink'] = $row['pqAssessmentFollowUpReportLink'];
            $List['secondPqSiteWalkParentCaseNo'] = $row['secondPqSiteWalkParentCaseNo'];
            $List['secondPqSiteWalkCaseVersion'] = $row['secondPqSiteWalkCaseVersion'];
            $List['secondPqSiteWalkCustomerResponse'] = $row['secondPqSiteWalkCustomerResponse'];
            $List['secondPqSiteWalkInvestigationStatus'] = $row['secondPqSiteWalkInvestigationStatus'];
            //consultant information
            $List['consultantCompanyNameId'] = $row['consultantCompanyNameId'];
            $List['consultantNameId'] = $row['consultantNameId'];
            $List['phoneNumber1'] = $row['phoneNumber1'];
            $List['phoneNumber2'] = $row['phoneNumber2'];
            $List['phoneNumber3'] = $row['phoneNumber3'];
            $List['email1'] = $row['email1'];
            $List['email2'] = $row['email2'];
            $List['email3'] = $row['email3'];
            $List['consultantInformationRemark'] =  Encoding::escapleAllCharacter($row['consultantInformationRemark']);
            $List['estimatedCommisioningDateByCustomer'] = isset($row['estimatedCommisioningDateByCustomer']) ? date('Y-m-d', strtotime($row['estimatedCommisioningDateByCustomer'])) : '';
            $List['estimatedCommisioningDateByRegion'] = isset($row['estimatedCommisioningDateByRegion']) ? date('Y-m-d', strtotime($row['estimatedCommisioningDateByRegion'])) : '';
            $List['planningAheadStatus'] = $row['planningAheadStatus'];
            //reply sLip
            $List['invitationToPaMeetingDate'] = isset($row['invitationToPaMeetingDate']) ? date('Y-m-d', strtotime($row['invitationToPaMeetingDate'])) : '';
            $List['replySlipParentCaseNo'] = $row['replySlipParentCaseNo'];
            $List['replySlipCaseVersion'] = $row['replySlipCaseVersion'];
            $List['replySlipSentDate'] = isset($row['replySlipSentDate']) ? date('Y-m-d', strtotime($row['replySlipSentDate'])) : '';
            $List['finish'] = $row['finish'];
            $List['actualReplySlipReturnDate'] = isset($row['actualReplySlipReturnDate']) ? date('Y-m-d', strtotime($row['actualReplySlipReturnDate'])) : '';
            $List['findingsFromReplySlip'] =  Encoding::escapleAllCharacter($row['findingsFromReplySlip']);
            $List['replySlipfollowUpActionFlag'] = $row['replySlipfollowUpActionFlag'];
            $List['replySlipfollowUpAction'] =  Encoding::escapleAllCharacter($row['replySlipfollowUpAction']);
            $List['replySlipRemark'] =  Encoding::escapleAllCharacter($row['replySlipRemark']);
            //reply slip reply slip
            $List['replySlipSendLink'] = $row['replySlipSendLink'];
            $List['replySlipReturnLink'] = $row['replySlipReturnLink'];
            $List['replySlipGradeId'] = $row['replySlipGradeId'];
            $List['dateOfRequestedForReturnReplySlip'] = isset($row['dateOfRequestedForReturnReplySlip']) ? date('Y-m-d', strtotime($row['dateOfRequestedForReturnReplySlip'])) : '';
            //additional
            $List['receiveComplaint'] =  Encoding::escapleAllCharacter($row['receiveComplaint']);
            $List['followUpAction'] =  Encoding::escapleAllCharacter($row['followUpAction']);
            $List['remark'] =  Encoding::escapleAllCharacter($row['remark']);
            $List['active'] = $row['active'];
           
           
        


        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $List;
    }


    public function getPlanningAheadProjectRegionAll()
    {

        try {

            $sql = "SELECT * FROM \"TblProjectRegion\"";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['projectRegionId'] = $row['projectRegionId'];
                $array['projectRegionEngName'] = Encoding::escapleAllCharacter($row['projectRegionEngName']);
                //$array['projectRegionChiName'] = $row['projectRegionChiName'];
                $array['projectRegionChiName'] = Encoding::escapleAllCharacter($row['projectRegionChiName']);
                array_push($List, $array);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $List;
    }
    public function getPlanningAheadProjectRegionActive()
    {

        try {
            $sql = "SELECT * FROM \"TblProjectRegion\" WHERE \"active\"='Y'";
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['projectRegionId'] = $row['projectRegionId'];
                $array['projectRegionEngName'] = Encoding::escapleAllCharacter($row['projectRegionEngName']);
                //$array['projectRegionChiName'] = $row['projectRegionChiName'];
                $array['projectRegionChiName'] = Encoding::escapleAllCharacter($row['projectRegionChiName']);
                array_push($List, $array);

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $List;
    }


    public function getPlanningAheadProjectTypeAll()
    {

        try {
            $sql = 'SELECT * FROM "TblProjectType"';
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['projectTypeId'] = $row['projectTypeId'];
                $array['projectTypeName'] = Encoding::escapleAllCharacter($row['projectTypeName']);
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getPlanningAheadProjectTypeActive()
    {

        try {
            $sql = "SELECT * FROM \"TblProjectType\" WHERE \"active\"='Y' ";
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['projectTypeId'] = $row['projectTypeId'];
                $array['projectTypeName'] = Encoding::escapleAllCharacter($row['projectTypeName']);
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getPlanningAheadBuildingTypeAll()
    {

        try {
            $sql = 'SELECT * FROM "TblBuildingType"';
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['buildingTypeId'] = $row['buildingTypeId'];
                $array['buildingTypeName'] = Encoding::escapleAllCharacter($row['buildingTypeName']);
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getPlanningAheadBuildingTypeActive()
    {

        try {
            $sql = "SELECT * FROM \"TblBuildingType\" WHERE \"active\"='Y' ";
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) {
                $array['buildingTypeId'] = $row['buildingTypeId'];
                $array['buildingTypeName'] = Encoding::escapleAllCharacter($row['buildingTypeName']);
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getPlanningAheadRegionPlannerAll()
    {

        try {
            $sql = 'SELECT * FROM "TblRegionPlanner"';
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();            
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['regionPlannerId'] = $row['regionPlannerId'];
                $array['regionPlannerName'] = Encoding::escapleAllCharacter($row['regionPlannerName']);
                $array['region'] = Encoding::escapleAllCharacter($row['region']);
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getPlanningAheadRegionPlannerActive()
    {

        try {
            $sql = "SELECT * FROM \"TblRegionPlanner\" WHERE \"active\"='Y' ";
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['regionPlannerId'] = $row['regionPlannerId'];
                $array['regionPlannerName'] = Encoding::escapleAllCharacter($row['regionPlannerName']);
                $array['region'] = Encoding::escapleAllCharacter($row['region']);
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }

    public function getPlanningAheadRegionPlannerRegionActive()
    {

        try {
            $sql = "SELECT DISTINCT \"region\" FROM \"TblRegionPlanner\" WHERE active='Y' ";
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $List[] = Encoding::escapleAllCharacter($row['region']);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getPlanningAheadPlanningAheadStatusAll()
    {

        try {
            $sql = 'SELECT * FROM "TblPlanningAheadStatus"';
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['planningAheadStatusId'] = $row['planningAheadStatusId'];
                $array['planningAheadStatusName'] = Encoding::escapleAllCharacter($row['planningAheadStatusName']);
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getPlanningAheadPlanningAheadStatusActive()
    {

        try {
            $sql = "SELECT * FROM \"TblPlanningAheadStatus\" WHERE \"active\"='Y' ";
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['planningAheadStatusId'] = $row['planningAheadStatusId'];
                $array['planningAheadStatusName'] = Encoding::escapleAllCharacter($row['planningAheadStatusName']);
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }

    public function getPlanningAheadReplySlipReturnGradeAll()
    {

        try {
            $sql = 'SELECT * FROM "TblReplySlipReturnGrade"';
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['replySlipReturnGradeId'] = $row['replySlipReturnGradeId'];
                $array['replySlipReturnGradeName'] = Encoding::escapleAllCharacter($row['replySlipReturnGradeName']);
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getPlanningAheadReplySlipReturnGradeActive()
    {

        try {
            $sql = "SELECT * FROM \"TblReplySlipReturnGrade\" WHERE \"active\"='Y' ";
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['replySlipReturnGradeId'] = $row['replySlipReturnGradeId'];
                $array['replySlipReturnGradeName'] = Encoding::escapleAllCharacter($row['replySlipReturnGradeName']);
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }

    public function getPlanningAheadConsultantCompanyAll()
    {

        try {
            $sql = 'SELECT * FROM "TblConsultantCompany"';
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
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
    public function getPlanningAheadConsultantCompanyActive()
    {

        try {
            $sql = "SELECT * FROM \"TblConsultantCompany\" WHERE \"active\"='Y' ";
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
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

    public function getPlanningAheadPqSensitiveLoadAll()
    {

        try {
            $sql = 'SELECT * FROM "TblPqSensitiveLoad"';
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['pqSensitiveLoadId'] = $row['pqSensitiveLoadId'];
                $array['pqSensitiveLoadName'] = Encoding::escapleAllCharacter($row['pqSensitiveLoadName']);
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function getPlanningAheadPqSensitiveLoadActive()
    {

        try {
            $sql = "SELECT * FROM \"TblPqSensitiveLoad\" WHERE \"active\"='Y' ";
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['pqSensitiveLoadId'] = $row['pqSensitiveLoadId'];
                $array['pqSensitiveLoadName'] = Encoding::escapleAllCharacter($row['pqSensitiveLoadName']);
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }

    public function getPlanningAheadConsultantAll()
    {

        try {
            $sql = 'SELECT * FROM "TblConsultant" c LEFT JOIN "TblConsultantCompany" cc on c."consultantCompanyId" = cc."consultantCompanyId"';
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['consultantId'] = $row['consultantId'];
                $array['consultantName'] = Encoding::escapleAllCharacter($row['consultantName']);
                $array['consultantCompanyId'] = $row['consultantCompanyId'];
                $array['consultantCompanyName'] = Encoding::escapleAllCharacter($row['consultantCompanyName']);
                $array['contactTel1'] = $row['contactTel1'];
                $array['contactTel2'] = $row['contactTel2'];
                $array['faxNumber'] = $row['faxNumber'];
                $array['email'] = $row['email'];
                $array['pqMeeting'] = $row['pqMeeting'];
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }

    public function getPlanningAheadConsultantActive()
    {

        try {
            $sql = "SELECT * FROM \"TblConsultant\" c LEFT JOIN \"TblConsultantCompany\" cc on c.\"consultantCompanyId\" = cc.\"consultantCompanyId\" WHERE c.\"active\"='Y' ";
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['consultantId'] = $row['consultantId'];
                $array['consultantName'] = Encoding::escapleAllCharacter($row['consultantName']);
                $array['consultantCompanyId'] = $row['consultantCompanyId'];
                $array['consultantCompanyName'] = Encoding::escapleAllCharacter($row['consultantCompanyName']);
                $array['contactTel1'] = $row['contactTel1'];
                $array['contactTel2'] = $row['contactTel2'];
                $array['faxNumber'] = $row['faxNumber'];
                $array['email'] = $row['email'];
                $array['pqMeeting'] = $row['pqMeeting'];
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }

#endregion planningAhead

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

}
