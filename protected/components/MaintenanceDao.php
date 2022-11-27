<?php
require_once('Encoding.php');
use \ForceUTF8\Encoding;
/**
 * CommonUtil.php
 * All common method will be in this common util. This util will act as component and init in the main.php
 */
class MaintenanceDao extends CApplicationComponent
{
    private $generatedId = "";
#region requestedbyTable
    public function GetRequestedBySearchResultCount($searchParam)
    {

        try {
            $sql = 'SELECT count(1) FROM "TblRequestedBy" WHERE 1=1 ';

            $requestedById = isset($searchParam['requestedById']) ? $searchParam['requestedById'] : '';
            $requestedByName = isset($searchParam['requestedByName']) ? $searchParam['requestedByName'] : '';
            $requestedByDept = isset($searchParam['requestedByDept']) ? $searchParam['requestedByDept'] : '';
            $active = isset($searchParam['active']) ? $searchParam['active'] : '';

            if ($requestedById != '') {
                $sql = $sql . 'AND "requestedById"::text LIKE :requestedById ';
            }
            if ($requestedByName != '') {
                $sql = $sql . 'AND "requestedByName" LIKE :requestedByName ';
            }
            if ($requestedByDept != '') {
                $sql = $sql . 'AND "requestedByDept" LIKE :requestedByDept ';
            }
            if ($active != '') {
                $sql = $sql . ' AND "active" LIKE :active ';
            }

            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            if ($requestedById != '') {
                $requestedById = "%" . $requestedById . "%";
                $sth->bindParam(':requestedById', $requestedById);
            }
            if ($requestedByName != '') {
                $requestedByName = "%" . $requestedByName . "%";
                $sth->bindParam(':requestedByName', $requestedByName);
            }
            if ($requestedByDept != '') {
                $requestedByDept = "%" . $requestedByDept . "%";
                $sth->bindParam(':requestedByDept', $requestedByDept);
            }
            if ($active != '') {
                $active = "%" . $active . "%";
                $sth->bindParam(':active', $active);
            }

            /*
            $result= $sth->execute();
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
    public function GetRequestedByRecordCount()
    {

        try {
            $sql = 'SELECT count(1) FROM "TblRequestedBy"';
            /*
            $result = $database->query($sql);
            $count  = $result->fetchColumn();
            */
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryRow();
            $count = $result['count'];
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $count;
    }

    public function GetRequestedBySearchByPage($searchParam, $start, $length, $orderByStr)
    {

        //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

        //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' requestedById ';

        $sqlMid = 'SELECT * ';

        $sqlBase = 'SELECT "requestedById" ';

        $sql1 = 'FROM "TblRequestedBy" WHERE 1=1 ';

        $sql2 = 'FROM "TblRequestedBy" WHERE 1=1 ';

        $requestedById = isset($searchParam['requestedById']) ? $searchParam['requestedById'] : '';
        $requestedByName = isset($searchParam['requestedByName']) ? $searchParam['requestedByName'] : '';
        $requestedByDept = isset($searchParam['requestedByDept']) ? $searchParam['requestedByDept'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';

        if ($requestedById != '') {
            $sql1 = $sql1 . 'AND "requestedById"::text LIKE :requestedById1 ';
            $sql2 = $sql2 . 'AND "requestedById"::text LIKE :requestedById2 ';
        }
        if ($requestedByName != '') {
            $sql1 = $sql1 . 'AND "requestedByName" LIKE :requestedByName1 ';
            $sql2 = $sql2 . 'AND "requestedByName" LIKE :requestedByName2 ';
        }
        if ($requestedByDept != '') {
            $sql1 = $sql1 . 'AND "requestedByDept" LIKE :requestedByDept1 ';
            $sql2 = $sql2 . 'AND "requestedByDept" LIKE :requestedByDept2 ';
        }
        if ($active != '') {
            $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
            $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
        }

        if ($orderByStr != '') {

            $sql1 = $sql1 . ' ORDER BY ' . $orderByStr . ' ';
            $sql2 = $sql2 . ' ORDER BY ' . $orderByStr . ' ';
        }
        if ($start != 0) {
            $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "requestedById" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
        } else {
            $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
        }

        try
        {
            //$sth = $database->prepare($sqlFinal);
            $sth = Yii::app()->db->createCommand($sqlFinal);
            if ($requestedById != '') {
                $requestedById = "%" . $requestedById . "%";
                $sth->bindParam(':requestedById1', $requestedById);
                if ($start != 0) {
                    $sth->bindParam(':requestedById2', $requestedById);
                }

            }
            if ($requestedByName != '') {
                $requestedByName = "%" . $requestedByName . "%";
                $sth->bindParam(':requestedByName1', $requestedByName);
                if ($start != 0) {
                    $sth->bindParam(':requestedByName2', $requestedByName);
                }

            }
            if ($requestedByDept != '') {
                $requestedByDept = "%" . $requestedByDept . "%";
                $sth->bindParam(':requestedByDept1', $requestedByDept);
                if ($start != 0) {
                    $sth->bindParam(':requestedByDept2', $requestedByDept);
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

            $array = array();
            $List = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['requestedById'] = $row['requestedById'];
                $array['requestedByName'] = Encoding::escapleAllCharacter($row['requestedByName']);  
                $array['requestedByDept'] = Encoding::escapleAllCharacter($row['requestedByDept']);  ;
                $array['active'] = $row['active'];
                $array['createdBy'] = $row['createdBy'];
                $array['createdTime'] = $row['createdTime'];
                $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
                $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
                array_push($List, $array);

            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $List;
    }

    public function getRequestedByById($id)
    {

        try {
            $sql = 'SELECT * FROM "TblRequestedBy" WHERE "requestedById" =' . $id . ' ';
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $requestedBy['requestedById'] = $row['requestedById'];
                $requestedBy['requestedByName'] = Encoding::escapleAllCharacter($row['requestedByName']);  
                $requestedBy['requestedByDept'] = Encoding::escapleAllCharacter($row['requestedByDept']);  ;
                $requestedBy['active'] = $row['active'];

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $requestedBy;
    }

    public function getFormRequestedByActiveById($id)
    {

        try {
            $sql = "SELECT * FROM \"TblRequestedBy\" WHERE \"requestedById\" =" . $id . " AND \"active\" ='Y' ";
            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $requestedBy['requestedById'] = $row['requestedById'];
                $requestedBy['requestedByName'] = Encoding::escapleAllCharacter($row['requestedByName']);  
                $requestedBy['requestedByDept'] = Encoding::escapleAllCharacter($row['requestedByDept']);  ;
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $requestedBy;
    }
#endregion requestedbyTable

#region HolidayTable
    public function GetHolidaySearchResultCount($searchParam)
    {

        try {

            $sql = "SELECT count(1) FROM \"TblHoliday\" WHERE 1=1 ";

            $holidayDate = isset($searchParam['holidayDate']) ? $searchParam['holidayDate'] : '';
            $holidayName = isset($searchParam['holidayName']) ? $searchParam['holidayName'] : '';
            $holidayDescription = isset($searchParam['holidayDescription']) ? $searchParam['holidayDescription'] : '';
            $active = isset($searchParam['active']) ? $searchParam['active'] : '';

            if ($holidayDate != '') {
                $sql = $sql . "AND \"holidayDate\" LIKE :holidayDate ";
            }
            if ($holidayName != '') {
                $sql = $sql . "AND \"holidayName\" LIKE :holidayName ";
            }
            if ($holidayDescription != '') {
                $sql = $sql . "AND \"holidayDescription\" LIKE :holidayDescription ";
            }
            if ($active != '') {
                $sql = $sql . " AND \"active\" LIKE :active ";
            }

            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            if ($holidayDate != '') {
                $holidayDate = "%" . $holidayDate . "%";
                $sth->bindParam(':holidayDate', $holidayDate);
            }
            if ($holidayName != '') {
                $holidayName = "%" . $holidayName . "%";
                $sth->bindParam(':holidayName', $holidayName);
            }
            if ($holidayDescription != '') {
                $holidayDescription = "%" . $holidayDescription . "%";
                $sth->bindParam(':holidayDescription', $holidayDescription);
            }
            if ($active != '') {
                $active = "%" . $active . "%";
                $sth->bindParam(':active', $active);
            }

            /*
            $result= $sth->execute();
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
    public function GetHolidayRecordCount()
    {

        try {
            $sql = "SELECT count(1) FROM \"TblHoliday\"";
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

    public function GetHolidaySearchByPage($searchParam, $start, $length, $orderByStr)
    {

        //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

        //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' holidayId ';

        $sqlMid = 'SELECT * ';
        $sqlBase = 'SELECT "holidayId" ';

        $sql1 = 'FROM "TblHoliday" WHERE 1=1 ';

        $sql2 = 'FROM "TblHoliday" WHERE 1=1 ';

        $holidayDate = isset($searchParam['holidayDate']) ? $searchParam['holidayDate'] : '';
        $holidayName = isset($searchParam['holidayName']) ? $searchParam['holidayName'] : '';
        $holidayDescription = isset($searchParam['holidayDescription']) ? $searchParam['holidayDescription'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';

        if ($holidayDate != '') {
            $sql1 = $sql1 . "AND \"holidayDate\" LIKE :holidayDate1 ";
            $sql2 = $sql2 . "AND \"holidayDate\" LIKE :holidayDate2 ";
        }
        if ($holidayName != '') {
            $sql1 = $sql1 . "AND \"holidayName\" LIKE :holidayName1 ";
            $sql2 = $sql2 . "AND \"holidayName\" LIKE :holidayName2 ";
        }
        if ($holidayDescription != '') {
            $sql1 = $sql1 . "AND \"holidayDescription\" LIKE :holidayDescription1 ";
            $sql2 = $sql2 . "AND \"holidayDescription \"LIKE :holidayDescription2 ";
        }
        if ($active != '') {
            $sql1 = $sql1 . " AND \"active\" LIKE :active1 ";
            $sql2 = $sql2 . " AND \"active\" LIKE :active2 ";
        }

        if ($orderByStr != '') {

            $sql1 = $sql1 . " ORDER BY " . $orderByStr . ' ';
            $sql2 = $sql2 . " ORDER BY " . $orderByStr . ' ';
        }
        if ($start != 0) {
            $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "holidayId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
        } else {
            $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
        }

        try
        {

            //$sth = $database->prepare($sqlFinal);
            $sth = Yii::app()->db->createCommand($sqlFinal);
            
            if ($holidayDate != '') {
                $holidayDate = "%" . $holidayDate . "%";
                $sth->bindParam(':holidayDate1', $holidayDate);
                if ($start != 0) {
                    $sth->bindParam(':holidayDate2', $holidayDate);
                }

            }
            if ($holidayName != '') {
                $holidayName = "%" . $holidayName . "%";
                $sth->bindParam(':holidayName1', $holidayName);
                if ($start != 0) {
                    $sth->bindParam(':holidayName2', $holidayName);
                }

            }
            if ($holidayDescription != '') {
                $holidayDescription = "%" . $holidayDescription . "%";
                $sth->bindParam(':holidayDescription1', $holidayDescription);
                if ($start != 0) {
                    $sth->bindParam(':holidayDescription2', $holidayDescription);
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


            $array = array();
            $List = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['holidayId'] = $row['holidayId'];
                $array['holidayDate'] = isset($row['holidayDate']) ? date('Y-m-d', strtotime($row['holidayDate'])) : '';
                $array['holidayName'] = Encoding::escapleAllCharacter($row['holidayName']);  
                $array['holidayDescription'] =Encoding::escapleAllCharacter($row['holidayDescription']);  
                $array['active'] = $row['active'];
                $array['createdBy'] = $row['createdBy'];
                $array['createdTime'] = $row['createdTime'];
                $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
                $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
                array_push($List, $array);

            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        } catch (Exception $e) {
            echo "Exception " . $e->getMessage();
        }
        return $List;
    }

    public function getHolidayById($id)
    {

        try {

            $sql = "SELECT * FROM \"TblHoliday\" WHERE \"holidayId\" =" . $id . " ";

            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();

            $List = array();

            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $holiday['holidayId'] = $row['holidayId'];
                $holiday['holidayDate'] = isset($row['holidayDate']) ? date('Y-m-d', strtotime($row['holidayDate'])) : '';
                $holiday['holidayName'] = Encoding::escapleAllCharacter($row['holidayName']);  
                $holiday['holidayDescription'] = Encoding::escapleAllCharacter($row['holidayDescription']);  
                $holiday['active'] = $row['active'];

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $holiday;
    }
#endregion HolidayTable

#region config
public function getConfigByConfigId($configId)
{

    try {

        $sql = "SELECT * FROM \"TblConfig\" WHERE \"configId\" = ". $configId ;

        //$result = $database->query($sql);

        $command = Yii::app()->db->createCommand($sql);
        $row = $command->queryRow();

        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $array['configId'] = $row['configId'];
            $array['configName'] = $row['configName'];
            $array['configValue'] = $row['configValue'];
            $array['configDescription'] = $row['configDescription'];
            
        //}
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $array;
}
public function getConfigAll()
{

    try {
        $List = array();
        $sql = "SELECT * FROM \"TblConfig\" WHERE 1=1" ;

        //$result = $database->query($sql);
        $command = Yii::app()->db->createCommand($sql);
        $result = $command->queryAll();

        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['configId'] = $row['configId'];
            $array['configName'] = $row['configName'];
            $array['configValue'] = $row['configValue'];
            $array['configDescription'] = $row['configDescription'];
            array_push($List, $array);
        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $List;
}
#endregion config
#region user
public function getUserByUserId($userId)
{

    try {

        $sql = "SELECT * FROM \"TblUser\" WHERE \"userId\" = ". $userId ;
        //$result = $database->query($sql);
        $command = Yii::app()->db->createCommand($sql);
        $row = $command->queryRow();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $array['userId'] = $row['userId'];
            $array['loginId'] = $row['loginId'];
            $array['password'] = $row['password'];
            $array['active'] = $row['active'];
            $array['roleId'] = $row['roleId'];
            
        //}
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $array;
}
public function getUserAll()
{

    try {

        $List = array();
        $sql = "SELECT * FROM \"TblUser\" WHERE 1=1" ;
        //$result = $database->query($sql);
        $command = Yii::app()->db->createCommand($sql);
        $result = $command->queryAll();

        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['userId'] = $row['userId'];
            $array['loginId'] = $row['loginId'];
            $array['password'] = $row['password'];
            $array['active'] = $row['active'];
            $array['roleId'] = $row['roleId'];
            array_push($List, $array);
        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $List;
}
#endregion user
#region costType
public function GetCostTypeCountYear(){
    try {
        $sql = "SELECT DISTINCT \"countYear\" FROM \"TblCostType\" WHERE 1=1 ";
        //$sth = $database->prepare($sql);
        $command = Yii::app()->db->createCommand($sql);
        $result = $command->queryAll();

        /*
        $result= $sth->execute();
        if(!$result){
            throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
            
        }
        */
        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['countYear']=$row['countYear'];
            array_push($List,$array);
        }
    } 
    catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}
public function GetCostTypeSearchResultCount($searchParam)
    {

        try {
            $sql = 'SELECT count(1) FROM "TblCostType" WHERE 1=1 ';

            $countYear = isset($searchParam['countYear']) ? $searchParam['countYear'] : '';
            $serviceTypeId = isset($searchParam['serviceTypeId']) ? $searchParam['serviceTypeId'] : '';
            $active = isset($searchParam['active']) ? $searchParam['active'] : '';

            if ($countYear != '') {
                $sql = $sql . 'AND "countYear" LIKE :countYear ';
            }
            if ($serviceTypeId != '') {
                $sql = $sql . 'AND "serviceTypeId" = :serviceTypeId ';
            }
            if ($active != '') {
                $sql = $sql . ' AND "active" LIKE :active ';
            }

            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            if ($countYear != '') {
                $countYear = "%" . $countYear . "%";
                $sth->bindParam(':countYear', $countYear);
            }
            if ($serviceTypeId != '') {
                $sth->bindParam(':serviceTypeId', $serviceTypeId);
            }
            if ($active != '') {
                $active = "%" . $active . "%";
                $sth->bindParam(':active', $active);
            }

            /*
            $result= $sth->execute();
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
    public function GetCostTypeRecordCount()
    {

        try {
            $sql = 'SELECT count(1) FROM "TblCostType"';
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

    public function GetCostTypeSearchByPage($searchParam, $start, $length, $orderByStr)
    {

        //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' ct.*, st.serviceTypeName as serviceTypeName ';

        //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' costTypeId ';
        $sqlMid = 'SELECT ct.*, st."serviceTypeName" ';

        $sqlBase = 'SELECT "costTypeId" ';

        $sql1 = 'FROM "TblCostType" ct LEFT JOIN "TblServiceType" st on ct."serviceTypeId" = st."serviceTypeId" WHERE 1=1 ';

        $sql2 = 'FROM "TblCostType" WHERE 1=1 ';

        $countYear = isset($searchParam['countYear']) ? $searchParam['countYear'] : '';
        $serviceTypeId = isset($searchParam['serviceTypeId']) ? $searchParam['serviceTypeId'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';

        if ($countYear != '') {
            $sql1 = $sql1 . 'AND "countYear" LIKE :countYear1 ';
            $sql2 = $sql2 . 'AND "countYear" LIKE :countYear2 ';
        }
        if ($serviceTypeId != '') {
            $sql1 = $sql1 . 'AND ct."serviceTypeId" = :serviceTypeId1 ';
            $sql2 = $sql2 . 'AND "serviceTypeId" = :serviceTypeId2 ';
        }

        if ($active != '') {
            $sql1 = $sql1 . 'AND ct."active" LIKE :active1 ';
            $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
        }

        if ($orderByStr != '') {
            if($orderByStr !='"unitCost" asc' && $orderByStr !='"unitCost" desc' && $orderByStr !='"countYear" asc' && $orderByStr !='"countYear" desc' && $orderByStr !='"costTypeId" asc' && $orderByStr !='"costTypeId" desc' ){
            $sql1 = $sql1 . ' ORDER BY st.' . $orderByStr . ' ';  
            $sql2 = $sql2 . ' ORDER BY st.' . $orderByStr . ' ';  
            }
        else{
            $sql1 = $sql1 . ' ORDER BY ' . $orderByStr . ' ';
            $sql2 = $sql2 . ' ORDER BY ' . $orderByStr . ' ';
        }
    }

        if ($start != 0) {
            $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "costTypeId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
        } else {
            $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
        }

        try
        {
            //$sth = $database->prepare($sqlFinal);
            $sth = Yii::app()->db->createCommand($sqlFinal);
            if ($countYear != '') {
                $countYear = "%" . $countYear . "%";
                $sth->bindParam(':countYear1', $countYear);
                if ($start != 0) {
                    $sth->bindParam(':countYear2', $countYear);
                }

            }
            if ($serviceTypeId != '') {
                $sth->bindParam(':serviceTypeId1', $serviceTypeId);
                if ($start != 0) {
                    $sth->bindParam(':serviceTypeId2', $serviceTypeId);
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
            $array = array();
            $List = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['costTypeId'] = $row['costTypeId'];
                $array['countYear'] = $row['countYear'];
                $array['serviceTypeId'] =$row['serviceTypeId'];
                $array['serviceTypeName'] =Encoding::escapleAllCharacter($row['serviceTypeName']);  
                $array['unitCost'] =$row['unitCost'];
                $array['active'] = $row['active'];
                $array['createdBy'] = $row['createdBy'];
                $array['createdTime'] = $row['createdTime'];
                $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
                $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
                array_push($List, $array);

            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $List;
    }

    public function getCostTypeByYear($countYear)
    {

        try {
            $sql = "SELECT * FROM \"TblCostType\" WHERE \"countYear\" ='" . $countYear . "' ";

            $sth = Yii::app()->db->createCommand($sql);
            //$result = $database->query($sql);
            $result = $sth->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['costTypeId'] = $row['costTypeId'];
                $array['countYear'] = $row['countYear'];
                $array['serviceTypeId'] =$row['serviceTypeId'];
                $array['unitCost'] =$row['unitCost'];
                $array['active'] = $row['active'];
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
#endregion costType
#region Budget
public function GetBudgetSearchResultCount($searchParam)
    {

        try {
            $sql = 'SELECT count(1) FROM ("TblBudget" bg LEFT JOIN "TblCostType" ct on bg."costTypeId" = ct."costTypeId") LEFT JOIN "TblPartyToBeCharged" pt on bg."partyToBeChargedId" = pt."partyToBeChargedId" WHERE 1=1 ';

            $countYear = isset($searchParam['countYear']) ? $searchParam['countYear'] : '';
            $serviceTypeId = isset($searchParam['serviceTypeId']) ? $searchParam['serviceTypeId'] : '';
            $partyToBeChargedId = isset($searchParam['partyToBeChargedId']) ? $searchParam['partyToBeChargedId'] : '';
            $active = isset($searchParam['active']) ? $searchParam['active'] : '';

            if ($countYear != '') {
                $sql = $sql . 'AND ct."countYear" LIKE :countYear ';
            }
            if ($serviceTypeId != '') {
                $sql = $sql . 'AND ct."serviceTypeId" = :serviceTypeId ';
            }
            if ($partyToBeChargedId != '') {
                $sql = $sql . 'AND bg."partyToBeChargedId" = :partyToBeChargedId ';
            }
            if ($active != '') {
                $sql = $sql . 'AND bg."active" LIKE :active ';
            }

            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            if ($countYear != '') {
                $countYear = "%" . $countYear . "%";
                $sth->bindParam(':countYear', $countYear);
            }
            if ($serviceTypeId != '') {
                $sth->bindParam(':serviceTypeId', $serviceTypeId);
            }
            if ($partyToBeChargedId != '') {
                $sth->bindParam(':partyToBeChargedId', $partyToBeChargedId);
            }
            if ($active != '') {
                $active = "%" . $active . "%";
                $sth->bindParam(':active', $active);
            }

            /*
            $result= $sth->execute();
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
    public function GetBudgetRecordCount()
    {

        try {
            $sql = 'SELECT count(1) FROM "TblBudget"';
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

    public function GetBudgetSearchByPage($searchParam, $start, $length, $orderByStr)
    {

        //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' bg.*, ct.countYear as countYear ,ct.unitCost as unitCost ,ct.serviceTypeId as serviceTypeId , st.serviceTypeName as serviceTypeName ,pt.partyToBeChargedName as partyToBeChargedName ';

        //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' budgetId ';

        $sqlMid = 'SELECT bg.*, ct."countYear", ct."unitCost", ct."serviceTypeId", st."serviceTypeName" ,pt."partyToBeChargedName" ';

        $sqlBase = 'SELECT "budgetId" ';

        $sql1 = 'FROM (("TblBudget" bg LEFT JOIN "TblCostType" ct  on bg."costTypeId" = ct."costTypeId") LEFT JOIN "TblServiceType" st on ct."serviceTypeId" = st."serviceTypeId" ) LEFT JOIN "TblPartyToBeCharged" pt on bg."partyToBeChargedId" = pt."partyToBeChargedId" WHERE 1=1 ';

        $sql2 = 'FROM (("TblBudget" bg LEFT JOIN "TblCostType" ct  on bg."costTypeId" = ct."costTypeId") LEFT JOIN "TblServiceType" st on ct."serviceTypeId" = st."serviceTypeId" ) LEFT JOIN "TblPartyToBeCharged" pt on bg."partyToBeChargedId" = pt."partyToBeChargedId" WHERE 1=1 ';

        $countYear = isset($searchParam['countYear']) ? $searchParam['countYear'] : '';
        $serviceTypeId = isset($searchParam['serviceTypeId']) ? $searchParam['serviceTypeId'] : '';
        $partyToBeChargedId = isset($searchParam['partyToBeChargedId']) ? $searchParam['partyToBeChargedId'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';

        if ($countYear != '') {
            $sql1 = $sql1 . "AND  \"countYear\" LIKE :countYear1 ";
            $sql2 = $sql2 . "AND  \"countYear\" LIKE :countYear2 ";
        }
        if ($serviceTypeId != '') {
            $sql1 = $sql1 . "AND ct.\"serviceTypeId\" = :serviceTypeId1 ";
            $sql2 = $sql2 . "AND ct.\"serviceTypeId\" = :serviceTypeId2 ";
        }
        if ($partyToBeChargedId != '') {
            $sql1 = $sql1 . "AND bg.\"partyToBeChargedId\" = :partyToBeChargedId1 ";
            $sql2 = $sql2 . "AND bg.\"partyToBeChargedId\" = :partyToBeChargedId2 ";
        }
        if ($active != '') {
            $sql1 = $sql1 . "AND bg.\"active\" LIKE :active1 ";
            $sql2 = $sql2 . "AND bg.\"active\" LIKE :active2 ";
        }

        if ($orderByStr != '') {
            if($orderByStr =="\"unitCost\" asc" || $orderByStr =="\"unitCost\" desc" || $orderByStr =="\"countYear\" asc" || $orderByStr =="\"countYear\" desc" ){
            $sql1 = $sql1 . " ORDER BY ct." . $orderByStr . ' ';  
            $sql2 = $sql2 . " ORDER BY ct." . $orderByStr . ' '; 
            }
            else if($orderByStr =="\"partyToBeChargedName\" asc" || $orderByStr =="\"partyToBeChargedName\" desc"){
            $sql1 = $sql1 . " ORDER BY pt." . $orderByStr . ' ';
            $sql2 = $sql2 . " ORDER BY pt." . $orderByStr . ' '; 
            }
            else if($orderByStr =="\"serviceTypeName\" asc" || $orderByStr =="\"serviceTypeName\" desc"){
                $sql1 = $sql1 . " ORDER BY st." . $orderByStr . ' ';
                $sql2 = $sql2 . " ORDER BY st." . $orderByStr . ' '; 
            }
            else {
                $sql1 = $sql1 . " ORDER BY bg." . $orderByStr . ' '; 
                $sql2 = $sql2 . " ORDER BY bg." . $orderByStr . ' '; 
            }
        }

        if ($start != 0) {
            $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ') AS A WHERE "budgetId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
        } else {
            $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
        }

        try
        {
            //$sth = $database->prepare($sqlFinal);
            $sth = Yii::app()->db->createCommand($sqlFinal);

            if ($countYear != '') {
                $countYear = "%" . $countYear . "%";
                $sth->bindParam(':countYear1', $countYear);
                if ($start != 0) {
                    $sth->bindParam(':countYear2', $countYear);
                }

            }
            if ($serviceTypeId != '') {
                $sth->bindParam(':serviceTypeId1', $serviceTypeId);
                if ($start != 0) {
                    $sth->bindParam(':serviceTypeId2', $serviceTypeId);
                }

            }
            if ($partyToBeChargedId != '') {
                $sth->bindParam(':partyToBeChargedId1', $partyToBeChargedId);
                if ($start != 0) {
                    $sth->bindParam(':partyToBeChargedId2', $partyToBeChargedId);
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
            $result = $sth->queryAll();

            /*
            if(!$result){
				throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
				
			}
            */

            $array = array();
            $List = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['budgetId'] = $row['budgetId'];
                $array['countYear'] = $row['countYear'];
                $array['serviceTypeId'] =$row['serviceTypeId'];
                $array['serviceTypeName'] =Encoding::escapleAllCharacter($row['serviceTypeName']);  
                $array['partyToBeChargedId'] =$row['partyToBeChargedId'];
                $array['partyToBeChargedName'] =Encoding::escapleAllCharacter($row['partyToBeChargedName']);  
                $array['unitCost'] =$row['unitCost'];
                $array['budgetNumber'] =$row['budgetNumber'];
                $array['active'] = $row['active'];
                $array['createdBy'] = $row['createdBy'];
                $array['createdTime'] = $row['createdTime'];
                $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
                $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
                array_push($List, $array);

            }

        } catch (Exception $e) {
            echo "Exception " . $e->getMessage();
        }
        return $List;
    }
    public function getBudgetByYear($countYear)
    {

        try {
            $sql = "SELECT bg.\"partyToBeChargedId\",
            bg.\"costTypeId\", bg.\"budgetNumber\",
            ct.\"countYear\", ct.\"serviceTypeId\" ,ct.\"unitCost\",
            st.\"showOrder\" as serviceTypeShowOrder, pt.\"showOrder\" as partyToBeChargedShowOrder
            FROM (((\"TblBudget\" bg 
            LEFT JOIN \"TblCostType\" ct on bg.\"costTypeId\" = ct.\"costTypeId\"  )
            LEFT JOIN \"TblServiceType\" st on ct.\"serviceTypeId\" = st.\"serviceTypeId\"  )
            LEFT JOIN \"TblPartyToBeCharged\" pt on bg.\"partyToBeChargedId\" = pt.\"partyToBeChargedId\") WHERE ct.\"countYear\" ='" . $countYear . "'  
            ORDER BY st.\"showOrder\"::NUMERIC, pt.\"showOrder\"::NUMERIC
            ";

            //$result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();

            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['costTypeId'] = $row['costTypeId'];
                $array['countYear'] = $row['countYear'];
                $array['serviceTypeId'] =$row['serviceTypeId'];
                $array['partyToBeChargedId'] =$row['partyToBeChargedId'];
                $array['unitCost'] =$row['unitCost'];
                $array['budgetNumber'] =$row['budgetNumber'];
                array_push($List, $array);
            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $List;
    }
    public function GetBudgetNewCountYear(){
        try {
            $sql = 'SELECT DISTINCT "countYear" FROM "TblCostType" WHERE "countYear" NOT IN ( SELECT ct."countYear" from "TblBudget" bt LEFT JOIN "TblCostType" ct on bt."costTypeId" = ct."costTypeId") ';
            
            /*
            $sth = $database->prepare($sql);
            $result= $sth->execute();
            if(!$result){
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
                
            }
            */
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();

            $array = array();
            $List = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) {
            $array['countYear']=$row['countYear'];
            array_push($List,$array);
            }
        } 
        catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $List;
    }
#endregion Budget
#region actionBy
    public function GetActionBySearchResultCount($searchParam)
    {

        try {
            $sql = "SELECT count(1) FROM \"TblActionBy\" WHERE 1=1 ";

            $actionByName = isset($searchParam['actionByName']) ? $searchParam['actionByName'] : '';
            $active = isset($searchParam['active']) ? $searchParam['active'] : '';
            $actionById = isset($searchParam['actionById']) ? $searchParam['actionById'] : '';
            
            if ($actionById != '') {
                $sql = $sql . "AND \"actionById\"::text LIKE :actionById ";
            }

            if ($actionByName != '') {
                $sql = $sql . "AND \"actionByName\" LIKE :actionByName ";
            }

            if ($active != '') {
                $sql = $sql . " AND \"active\" LIKE :active ";
            }

            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            if ($actionById != '') {
                $actionById = "%" . $actionById . "%";
                $sth->bindParam(':actionById', $actionById);

            }

            if ($actionByName != '') {
                $actionByName = "%" . $actionByName . "%";
                $sth->bindParam(':actionByName', $actionByName);
            }

            if ($active != '') {
                $active = "%" . $active . "%";
                $sth->bindParam(':active', $active);
            }

            /*
            $result= $sth->execute();
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
    public function GetActionByRecordCount()
    {

        try {
            $sql = "SELECT count(1) FROM \"TblActionBy\"";

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

    public function GetActionBySearchByPage($searchParam, $start, $length, $orderByStr)
    {

        //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

        //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' actionById ';

        $sqlMid = 'SELECT * ';

        $sqlBase = 'SELECT "actionById" ';

        $sql1 = 'FROM "TblActionBy" WHERE 1=1 ';

        $sql2 = 'FROM "TblActionBy" WHERE 1=1 ';

        $actionById = isset($searchParam['actionById']) ? $searchParam['actionById'] : '';
        $actionByName = isset($searchParam['actionByName']) ? $searchParam['actionByName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';

        
        if ($actionById != '') {
            $sql1 = $sql1 . "AND \"actionById\"::text LIKE :actionById1 ";
            $sql2 = $sql2 . "AND \"actionById\"::text LIKE :actionById2 ";
        }
        if ($actionByName != '') {
            $sql1 = $sql1 . "AND \"actionByName\" LIKE :actionByName1 ";
            $sql2 = $sql2 . "AND \"actionByName \"LIKE :actionByName2 ";
        }

        if ($active != '') {
            $sql1 = $sql1 . " AND \"active\" LIKE :active1 ";
            $sql2 = $sql2 . " AND \"active\" LIKE :active2 ";
        }

        if ($orderByStr != '') {

            $sql1 = $sql1 . " ORDER BY " . $orderByStr . ' ';
            $sql2 = $sql2 . " ORDER BY " . $orderByStr . ' ';
        }
        if ($start != 0) {
            $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ') AS A WHERE "actionById" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' .  (int) ($start) .') ';
        } else {
            $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
        }

        try
        {

            //$sth = $database->prepare($sqlFinal);
            $sth = Yii::app()->db->createCommand($sqlFinal);

            if ($actionById != '') {
                $actionById = "%" . $actionById . "%";
                $sth->bindParam(':actionById1', $actionById);
                if ($start != 0) {
                    $sth->bindParam(':actionById2', $actionById);
                }

            }
            if ($actionByName != '') {
                $actionByName = "%" . $actionByName . "%";
                $sth->bindParam(':actionByName1', $actionByName);
                if ($start != 0) {
                    $sth->bindParam(':actionByName2', $actionByName);
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
            $result = $sth->queryAll();
            /*
            if(!$result){
				throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
				
			}
            */
            $array = array();
            $List = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['actionById'] = $row['actionById'];
                $array['actionByName'] = Encoding::escapleAllCharacter($row['actionByName']);  
                $array['active'] = $row['active'];
                $array['createdBy'] = $row['createdBy'];
                $array['createdTime'] = $row['createdTime'];
                $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
                $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
                array_push($List, $array);

            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $List;
    }

    public function getActionByById($id)
    {

        try {

            $sql = "SELECT * FROM \"TblActionBy\" WHERE \"actionById\" =" . $id . " ";
            //$result = $database->query($sql);
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $List = array();
            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $actionBy['actionById'] = $row['actionById'];
                $actionBy['actionByName'] = Encoding::escapleAllCharacter($row['actionByName']);  
                $actionBy['active'] = $row['active'];

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $actionBy;
    }
#endregion actionBy
#region problemType
public function GetProblemTypeSearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblProblemType" WHERE 1=1 ';

        $problemTypeName = isset($searchParam['problemTypeName']) ? $searchParam['problemTypeName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $problemTypeId = isset($searchParam['problemTypeId']) ? $searchParam['problemTypeId'] : '';

        if ($problemTypeId != '') {
            $sql = $sql . 'AND "problemTypeId"::text LIKE :problemTypeId ';
        }

        if ($problemTypeName != '') {
            $sql = $sql . 'AND "problemTypeName" LIKE :problemTypeName ';
        }

        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($problemTypeId != '') {
            $problemTypeId = "%" . $problemTypeId . "%";
            $sth->bindParam(':problemTypeId', $problemTypeId);

        }

        if ($problemTypeName != '') {
            $problemTypeName = "%" . $problemTypeName . "%";
            $sth->bindParam(':problemTypeName', $problemTypeName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetProblemTypeRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblProblemType"';
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

public function GetProblemTypeSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' problemTypeId ';
    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "problemTypeId" ';

    $sql1 = 'FROM "TblProblemType" WHERE 1=1 ';

    $sql2 = 'FROM "TblProblemType" WHERE 1=1 ';

    $problemTypeId = isset($searchParam['problemTypeId']) ? $searchParam['problemTypeId'] : '';
    $problemTypeName = isset($searchParam['problemTypeName']) ? $searchParam['problemTypeName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($problemTypeId != '') {
        $sql1 = $sql1 . 'AND "problemTypeId"::text LIKE :problemTypeId1 ';
        $sql2 = $sql2 . 'AND "problemTypeId"::text LIKE :problemTypeId2 ';
    }
    if ($problemTypeName != '') {
        $sql1 = $sql1 . 'AND "problemTypeName" LIKE :problemTypeName1 ';
        $sql2 = $sql2 . 'AND "problemTypeName" LIKE :problemTypeName2 ';
    }

    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . " ORDER BY " . $orderByStr . ' ';
        $sql2 = $sql2 . " ORDER BY " . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "problemTypeId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($problemTypeId != '') {
            $problemTypeId = "%" . $problemTypeId . "%";
            $sth->bindParam(':problemTypeId1', $problemTypeId);
            if ($start != 0) {
                $sth->bindParam(':problemTypeId2', $problemTypeId);
            }

        }
        if ($problemTypeName != '') {
            $problemTypeName = "%" . $problemTypeName . "%";
            $sth->bindParam(':problemTypeName1', $problemTypeName);
            if ($start != 0) {
                $sth->bindParam(':problemTypeName2', $problemTypeName);
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
        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['problemTypeId'] = $row['problemTypeId'];
            $array['problemTypeName'] = Encoding::escapleAllCharacter($row['problemTypeName']);  
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getProblemTypeById($id)
{

    try {
        $sql = 'SELECT * FROM "TblProblemType" WHERE "problemTypeId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $problemType['problemTypeId'] = $row['problemTypeId'];
            $problemType['problemTypeName'] = Encoding::escapleAllCharacter($row['problemTypeName']);  
            $problemType['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $problemType;
}
#endregion problemType
#region businessType
public function GetBusinessTypeSearchResultCount($searchParam)
{

    try {

        $sql = 'SELECT count(1) FROM "TblBusinessType" WHERE 1=1 ';

        $businessTypeName = isset($searchParam['businessTypeName']) ? $searchParam['businessTypeName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $businessTypeId = isset($searchParam['businessTypeId']) ? $searchParam['businessTypeId'] : '';

        if ($businessTypeId != '') {
            $sql = $sql . "AND \"businessTypeId\"::text LIKE :businessTypeId ";
        }

        if ($businessTypeName != '') {
            $sql = $sql . "AND \"businessTypeName\" LIKE :businessTypeName ";
        }

        if ($active != '') {
            $sql = $sql . " AND \"active\" LIKE :active ";
        }


        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($businessTypeId != '') {
            $businessTypeId = "%" . $businessTypeId . "%";
            $sth->bindParam(':businessTypeId', $businessTypeId);

        }

        if ($businessTypeName != '') {
            $businessTypeName = "%" . $businessTypeName . "%";
            $sth->bindParam(':businessTypeName', $businessTypeName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetBusinessTypeRecordCount()
{

    try {

        $sql = 'SELECT count(1) FROM "TblBusinessType"';

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

public function GetBusinessTypeSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' businessTypeId ';

    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "businessTypeId" ';

    $sql1 = 'FROM "TblBusinessType" WHERE 1=1 ';

    $sql2 = 'FROM "TblBusinessType" WHERE 1=1 ';

    $businessTypeId = isset($searchParam['businessTypeId']) ? $searchParam['businessTypeId'] : '';
    $businessTypeName = isset($searchParam['businessTypeName']) ? $searchParam['businessTypeName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($businessTypeId != '') {
        $sql1 = $sql1 . "AND \"businessTypeId\"::text LIKE :businessTypeId1 ";
        $sql2 = $sql2 . "AND \"businessTypeId\"::text LIKE :businessTypeId2";
    }
    if ($businessTypeName != '') {
        $sql1 = $sql1 . "AND \"businessTypeName\" LIKE :businessTypeName1 ";
        $sql2 = $sql2 . "AND \"businessTypeName\" LIKE :businessTypeName2 ";
    }

    if ($active != '') {
        $sql1 = $sql1 . " AND \"active\" LIKE :active1 ";
        $sql2 = $sql2 . " AND \"active\" LIKE :active2 ";
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . " ORDER BY " . $orderByStr . ' ';
        $sql2 = $sql2 . " ORDER BY " . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE businessTypeId NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {

        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($businessTypeId != '') {
            $businessTypeId = "%" . $businessTypeId . "%";
            $sth->bindParam(':businessTypeId1', $businessTypeId);
            if ($start != 0) {
                $sth->bindParam(':businessTypeId2', $businessTypeId);
            }

        }
        if ($businessTypeName != '') {
            $businessTypeName = "%" . $businessTypeName . "%";
            $sth->bindParam(':businessTypeName1', $businessTypeName);
            if ($start != 0) {
                $sth->bindParam(':businessTypeName2', $businessTypeName);
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
        $result = $sth->queryAll();
        /*
        if(!$result){
            throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

        }
        */
        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) {
            $array['businessTypeId'] = $row['businessTypeId'];
            $array['businessTypeName'] = Encoding::escapleAllCharacter($row['businessTypeName']);  
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getBusinessTypeById($id)
{

    try {

        $sql = "SELECT * FROM \"TblBusinessType\" WHERE \"businessTypeId\" =" . $id . " ";
        //$result = $database->query($sql);
        $command = Yii::app()->db->createCommand($sql);
        $result = $command->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $businessType['businessTypeId'] = $row['businessTypeId'];
            $businessType['businessTypeName'] = Encoding::escapleAllCharacter($row['businessTypeName']);  
            $businessType['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $businessType;
}
#endregion businessType
#region clpPersonDepartment
public function GetClpPersonDepartmentSearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblClpPersonDepartment" WHERE 1=1 ';

        $clpPersonDepartmentName = isset($searchParam['clpPersonDepartmentName']) ? $searchParam['clpPersonDepartmentName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $clpPersonDepartmentId = isset($searchParam['clpPersonDepartmentId']) ? $searchParam['clpPersonDepartmentId'] : '';

        if ($clpPersonDepartmentId != '') {
            $sql = $sql . 'AND "clpPersonDepartmentId"::text LIKE :clpPersonDepartmentId ';
        }

        if ($clpPersonDepartmentName != '') {
            $sql = $sql . 'AND "clpPersonDepartmentName" LIKE :clpPersonDepartmentName ';
        }

        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($clpPersonDepartmentId != '') {
            $clpPersonDepartmentId = "%" . $clpPersonDepartmentId . "%";
            $sth->bindParam(':clpPersonDepartmentId', $clpPersonDepartmentId);

        }

        if ($clpPersonDepartmentName != '') {
            $clpPersonDepartmentName = "%" . $clpPersonDepartmentName . "%";
            $sth->bindParam(':clpPersonDepartmentName', $clpPersonDepartmentName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetClpPersonDepartmentRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblClpPersonDepartment"';
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

public function GetClpPersonDepartmentSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' clpPersonDepartmentId ';

    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "clpPersonDepartmentId" ';

    $sql1 = 'FROM "TblClpPersonDepartment" WHERE 1=1 ';

    $sql2 = 'FROM "TblClpPersonDepartment" WHERE 1=1 ';

    $clpPersonDepartmentId = isset($searchParam['clpPersonDepartmentId']) ? $searchParam['clpPersonDepartmentId'] : '';
    $clpPersonDepartmentName = isset($searchParam['clpPersonDepartmentName']) ? $searchParam['clpPersonDepartmentName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($clpPersonDepartmentId != '') {
        $sql1 = $sql1 . 'AND "clpPersonDepartmentId"::text LIKE :clpPersonDepartmentId1 ';
        $sql2 = $sql2 . 'AND "clpPersonDepartmentId"::text LIKE :clpPersonDepartmentId2 ';
    }
    if ($clpPersonDepartmentName != '') {
        $sql1 = $sql1 . 'AND "clpPersonDepartmentName" LIKE :clpPersonDepartmentName1 ';
        $sql2 = $sql2 . 'AND "clpPersonDepartmentName" LIKE :clpPersonDepartmentName2 ';
    }

    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . " ORDER BY " . $orderByStr . ' ';
        $sql2 = $sql2 . " ORDER BY " . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE  "clpPersonDepartmentId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($clpPersonDepartmentId != '') {
            $clpPersonDepartmentId = "%" . $clpPersonDepartmentId . "%";
            $sth->bindParam(':clpPersonDepartmentId1', $clpPersonDepartmentId);
            if ($start != 0) {
                $sth->bindParam(':clpPersonDepartmentId2', $clpPersonDepartmentId);
            }

        }
        if ($clpPersonDepartmentName != '') {
            $clpPersonDepartmentName = "%" . $clpPersonDepartmentName . "%";
            $sth->bindParam(':clpPersonDepartmentName1', $clpPersonDepartmentName);
            if ($start != 0) {
                $sth->bindParam(':clpPersonDepartmentName2', $clpPersonDepartmentName);
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
        $result = $sth->queryAll();

        /*
        if(!$result){
            throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

        }
        */

        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['clpPersonDepartmentId'] = $row['clpPersonDepartmentId'];
            $array['clpPersonDepartmentName'] = Encoding::escapleAllCharacter($row['clpPersonDepartmentName']);  
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getClpPersonDepartmentById($id)
{

    try {
        $sql = 'SELECT * FROM "TblClpPersonDepartment" WHERE "clpPersonDepartmentId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();

        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $clpPersonDepartment['clpPersonDepartmentId'] = $row['clpPersonDepartmentId'];
            $clpPersonDepartment['clpPersonDepartmentName'] = Encoding::escapleAllCharacter($row['clpPersonDepartmentName']);  
            $clpPersonDepartment['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $clpPersonDepartment;
}
#endregion clpPersonDepartment
#region clpReferredBy
public function GetClpReferredBySearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblClpReferredBy" WHERE 1=1 ';

        $clpReferredByName = isset($searchParam['clpReferredByName']) ? $searchParam['clpReferredByName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $clpReferredById = isset($searchParam['clpReferredById']) ? $searchParam['clpReferredById'] : '';

        if ($clpReferredById != '') {
            $sql = $sql . 'AND "clpReferredById"::text LIKE :clpReferredById ';
        }

        if ($clpReferredByName != '') {
            $sql = $sql . 'AND "clpReferredByName" LIKE :clpReferredByName ';
        }

        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($clpReferredById != '') {
            $clpReferredById = "%" . $clpReferredById . "%";
            $sth->bindParam(':clpReferredById', $clpReferredById);

        }

        if ($clpReferredByName != '') {
            $clpReferredByName = "%" . $clpReferredByName . "%";
            $sth->bindParam(':clpReferredByName', $clpReferredByName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetClpReferredByRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblClpReferredBy"';
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

public function GetClpReferredBySearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' clpReferredById ';

    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "clpReferredById" ';

    $sql1 = 'FROM "TblClpReferredBy" WHERE 1=1 ';

    $sql2 = 'FROM "TblClpReferredBy" WHERE 1=1 ';

    $clpReferredById = isset($searchParam['clpReferredById']) ? $searchParam['clpReferredById'] : '';
    $clpReferredByName = isset($searchParam['clpReferredByName']) ? $searchParam['clpReferredByName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($clpReferredById != '') {
        $sql1 = $sql1 . 'AND "clpReferredById"::text LIKE :clpReferredById1 ';
        $sql2 = $sql2 . 'AND "clpReferredById"::text LIKE :clpReferredById2 ';
    }
    if ($clpReferredByName != '') {
        $sql1 = $sql1 . 'AND "clpReferredByName" LIKE :clpReferredByName1 ';
        $sql2 = $sql2 . 'AND "clpReferredByName" LIKE :clpReferredByName2 ';
    }

    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . " ORDER BY " . $orderByStr . ' ';
        $sql2 = $sql2 . " ORDER BY " . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "clpReferredById" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($clpReferredById != '') {
            $clpReferredById = "%" . $clpReferredById . "%";
            $sth->bindParam(':clpReferredById1', $clpReferredById);
            if ($start != 0) {
                $sth->bindParam(':clpReferredById2', $clpReferredById);
            }

        }
        if ($clpReferredByName != '') {
            $clpReferredByName = "%" . $clpReferredByName . "%";
            $sth->bindParam(':clpReferredByName1', $clpReferredByName);
            if ($start != 0) {
                $sth->bindParam(':clpReferredByName2', $clpReferredByName);
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

        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['clpReferredById'] = $row['clpReferredById'];
            $array['clpReferredByName'] = Encoding::escapleAllCharacter($row['clpReferredByName']);  
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getClpReferredByById($id)
{

    try {
        $sql = 'SELECT * FROM "TblClpReferredBy" WHERE "clpReferredById" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $clpReferredBy['clpReferredById'] = $row['clpReferredById'];
            $clpReferredBy['clpReferredByName'] = Encoding::escapleAllCharacter($row['clpReferredByName']);  
            $clpReferredBy['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $clpReferredBy;
}
#endregion clpReferredBy
#region eic
public function GetEicSearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblEic" WHERE 1=1 ';

        $eicName = isset($searchParam['eicName']) ? $searchParam['eicName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $eicId = isset($searchParam['eicId']) ? $searchParam['eicId'] : '';

        if ($eicId != '') {
            $sql = $sql . 'AND "eicId"::text LIKE :eicId ';
        }

        if ($eicName != '') {
            $sql = $sql . 'AND "eicName" LIKE :eicName ';
        }

        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($eicId != '') {
            $eicId = "%" . $eicId . "%";
            $sth->bindParam(':eicId', $eicId);

        }

        if ($eicName != '') {
            $eicName = "%" . $eicName . "%";
            $sth->bindParam(':eicName', $eicName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetEicRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblEic"';
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

public function GetEicSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' eicId ';

    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "eicId" ';

    $sql1 = 'FROM "TblEic" WHERE 1=1 ';

    $sql2 = 'FROM "TblEic" WHERE 1=1 ';

    $eicId = isset($searchParam['eicId']) ? $searchParam['eicId'] : '';
    $eicName = isset($searchParam['eicName']) ? $searchParam['eicName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($eicId != '') {
        $sql1 = $sql1 . 'AND "eicId"::text LIKE :eicId1 ';
        $sql2 = $sql2 . 'AND "eicId"::text LIKE :eicId2 ';
    }
    if ($eicName != '') {
        $sql1 = $sql1 . 'AND "eicName" LIKE :eicName1 ';
        $sql2 = $sql2 . 'AND "eicName" LIKE :eicName2 ';
    }

    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . ' ORDER BY ' . $orderByStr . ' ';
        $sql2 = $sql2 . ' ORDER BY ' . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "eicId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($eicId != '') {
            $eicId = "%" . $eicId . "%";
            $sth->bindParam(':eicId1', $eicId);
            if ($start != 0) {
                $sth->bindParam(':eicId2', $eicId);
            }

        }
        if ($eicName != '') {
            $eicName = "%" . $eicName . "%";
            $sth->bindParam(':eicName1', $eicName);
            if ($start != 0) {
                $sth->bindParam(':eicName2', $eicName);
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

        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['eicId'] = $row['eicId'];
            $array['eicName'] = Encoding::escapleAllCharacter($row['eicName']);  
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getEicById($id)
{

    try {
        $sql = 'SELECT * FROM "TblEic" WHERE "eicId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $eic['eicId'] = $row['eicId'];
            $eic['eicName'] = Encoding::escapleAllCharacter($row['eicName']);  
            $eic['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $eic;
}
#endregion eic
#region majorAffectedElement
public function GetMajorAffectedElementSearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblMajorAffectedElement" WHERE 1=1 ';

        $majorAffectedElementName = isset($searchParam['majorAffectedElementName']) ? $searchParam['majorAffectedElementName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $majorAffectedElementId = isset($searchParam['majorAffectedElementId']) ? $searchParam['majorAffectedElementId'] : '';

        if ($majorAffectedElementId != '') {
            $sql = $sql . 'AND "majorAffectedElementId"::text LIKE :majorAffectedElementId ';
        }

        if ($majorAffectedElementName != '') {
            $sql = $sql . 'AND "majorAffectedElementName" LIKE :majorAffectedElementName ';
        }

        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($majorAffectedElementId != '') {
            $majorAffectedElementId = "%" . $majorAffectedElementId . "%";
            $sth->bindParam(':majorAffectedElementId', $majorAffectedElementId);

        }

        if ($majorAffectedElementName != '') {
            $majorAffectedElementName = "%" . $majorAffectedElementName . "%";
            $sth->bindParam(':majorAffectedElementName', $majorAffectedElementName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetMajorAffectedElementRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblMajorAffectedElement"';
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

public function GetMajorAffectedElementSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' majorAffectedElementId ';
    
    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "majorAffectedElementId" ';

    $sql1 = 'FROM "TblMajorAffectedElement" WHERE 1=1 ';

    $sql2 = 'FROM "TblMajorAffectedElement" WHERE 1=1 ';

    $majorAffectedElementId = isset($searchParam['majorAffectedElementId']) ? $searchParam['majorAffectedElementId'] : '';
    $majorAffectedElementName = isset($searchParam['majorAffectedElementName']) ? $searchParam['majorAffectedElementName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($majorAffectedElementId != '') {
        $sql1 = $sql1 . 'AND "majorAffectedElementId"::text LIKE :majorAffectedElementId1 ';
        $sql2 = $sql2 . 'AND "majorAffectedElementId":text LIKE :majorAffectedElementId2 ';
    }
    if ($majorAffectedElementName != '') {
        $sql1 = $sql1 . 'AND "majorAffectedElementName" LIKE :majorAffectedElementName1 ';
        $sql2 = $sql2 . 'AND "majorAffectedElementName" LIKE :majorAffectedElementName2 ';
    }

    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . ' ORDER BY ' . $orderByStr . ' ';
        $sql2 = $sql2 . ' ORDER BY ' . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "majorAffectedElementId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($majorAffectedElementId != '') {
            $majorAffectedElementId = "%" . $majorAffectedElementId . "%";
            $sth->bindParam(':majorAffectedElementId1', $majorAffectedElementId);
            if ($start != 0) {
                $sth->bindParam(':majorAffectedElementId2', $majorAffectedElementId);
            }

        }
        if ($majorAffectedElementName != '') {
            $majorAffectedElementName = "%" . $majorAffectedElementName . "%";
            $sth->bindParam(':majorAffectedElementName1', $majorAffectedElementName);
            if ($start != 0) {
                $sth->bindParam(':majorAffectedElementName2', $majorAffectedElementName);
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

        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['majorAffectedElementId'] = $row['majorAffectedElementId'];
            $array['majorAffectedElementName'] = Encoding::escapleAllCharacter($row['majorAffectedElementName']);  
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getMajorAffectedElementById($id)
{

    try {
        $sql = 'SELECT * FROM "TblMajorAffectedElement" WHERE "majorAffectedElementId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $majorAffectedElement['majorAffectedElementId'] = $row['majorAffectedElementId'];
            $majorAffectedElement['majorAffectedElementName'] = Encoding::escapleAllCharacter($row['majorAffectedElementName']);  
            $majorAffectedElement['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $majorAffectedElement;
}
#endregion majorAffectedElement
#region contactPerson
public function GetContactPersonSearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblContactPerson" WHERE 1=1 ';

        $contactPersonName = isset($searchParam['contactPersonName']) ? $searchParam['contactPersonName'] : '';
        $contactPersonTitle = isset($searchParam['contactPersonTitle']) ? $searchParam['contactPersonTitle'] : '';
        $contactPersonNo = isset($searchParam['contactPersonNo']) ? $searchParam['contactPersonNo'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $contactPersonId = isset($searchParam['contactPersonId']) ? $searchParam['contactPersonId'] : '';

        if ($contactPersonId != '') {
            $sql = $sql . 'AND "contactPersonId"::text LIKE :contactPersonId ';
        }

        if ($contactPersonName != '') {
            $sql = $sql . 'AND "contactPersonName" LIKE :contactPersonName ';
        }
        if ($contactPersonTitle != '') {
            $sql = $sql . 'AND "contactPersonTitle" LIKE :contactPersonTitle ';
        }
        if ($contactPersonNo != '') {
            $sql = $sql . 'AND "contactPersonNo" LIKE :contactPersonNo ';
        }
        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($contactPersonId != '') {
            $contactPersonId = "%" . $contactPersonId . "%";
            $sth->bindParam(':contactPersonId', $contactPersonId);

        }

        if ($contactPersonName != '') {
            $contactPersonName = "%" . $contactPersonName . "%";
            $sth->bindParam(':contactPersonName', $contactPersonName);
        }
        if ($contactPersonTitle != '') {
            $contactPersonTitle = "%" . $contactPersonTitle . "%";
            $sth->bindParam(':contactPersonTitle', $contactPersonTitle);
        }
        if ($contactPersonNo != '') {
            $contactPersonNo = "%" . $contactPersonNo . "%";
            $sth->bindParam(':contactPersonNo', $contactPersonNo);
        }
        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetContactPersonRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblContactPerson"';
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

public function GetContactPersonSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' contactPersonId ';

    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "contactPersonId" ';

    $sql1 = 'FROM "TblContactPerson" WHERE 1=1 ';

    $sql2 = 'FROM "TblContactPerson" WHERE 1=1 ';

    $contactPersonId = isset($searchParam['contactPersonId']) ? $searchParam['contactPersonId'] : '';
    $contactPersonName = isset($searchParam['contactPersonName']) ? $searchParam['contactPersonName'] : '';
    $contactPersonTitle = isset($searchParam['contactPersonTitle']) ? $searchParam['contactPersonTitle'] : '';
    $contactPersonNo = isset($searchParam['contactPersonNo']) ? $searchParam['contactPersonNo'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($contactPersonId != '') {
        $sql1 = $sql1 . 'AND "contactPersonId"::text LIKE :contactPersonId1 ';
        $sql2 = $sql2 . 'AND "contactPersonId"::text LIKE :contactPersonId2 ';
    }
    if ($contactPersonName != '') {
        $sql1 = $sql1 . 'AND "contactPersonName" LIKE :contactPersonName1 ';
        $sql2 = $sql2 . 'AND "contactPersonName" LIKE :contactPersonName2 ';
    }
    if ($contactPersonTitle != '') {
        $sql1 = $sql1 . 'AND "contactPersonTitle" LIKE :contactPersonTitle1 ';
        $sql2 = $sql2 . 'AND "contactPersonTitle" LIKE :contactPersonTitle2 ';
    }
    if ($contactPersonNo != '') {
        $sql1 = $sql1 . 'AND "contactPersonNo" LIKE :contactPersonNo1 ';
        $sql2 = $sql2 . 'AND "contactPersonNo" LIKE :contactPersonNo2 ';
    }
    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . " ORDER BY " . $orderByStr . ' ';
        $sql2 = $sql2 . " ORDER BY " . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "contactPersonId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($contactPersonId != '') {
            $contactPersonId = "%" . $contactPersonId . "%";
            $sth->bindParam(':contactPersonId1', $contactPersonId);
            if ($start != 0) {
                $sth->bindParam(':contactPersonId2', $contactPersonId);
            }

        }
        if ($contactPersonName != '') {
            $contactPersonName = "%" . $contactPersonName . "%";
            $sth->bindParam(':contactPersonName1', $contactPersonName);
            if ($start != 0) {
                $sth->bindParam(':contactPersonName2', $contactPersonName);
            }

        }
        if ($contactPersonTitle != '') {
            $contactPersonTitle = "%" . $contactPersonTitle . "%";
            $sth->bindParam(':contactPersonTitle1', $contactPersonTitle);
            if ($start != 0) {
                $sth->bindParam(':contactPersonTitle2', $contactPersonTitle);
            }

        }
        if ($contactPersonNo != '') {
            $contactPersonNo = "%" . $contactPersonNo . "%";
            $sth->bindParam(':contactPersonNo1', $contactPersonNo);
            if ($start != 0) {
                $sth->bindParam(':contactPersonNo2', $contactPersonNo);
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

        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['contactPersonId'] = $row['contactPersonId'];
            $array['contactPersonName'] = Encoding::escapleAllCharacter($row['contactPersonName']);  
            $array['contactPersonTitle'] = Encoding::escapleAllCharacter($row['contactPersonTitle']);  
            $array['contactPersonNo'] = $row['contactPersonNo'];
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getContactPersonById($id)
{

    try {
        $sql = 'SELECT * FROM "TblContactPerson" WHERE "contactPersonId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $contactPerson['contactPersonId'] = $row['contactPersonId'];
            $contactPerson['contactPersonName'] = Encoding::escapleAllCharacter($row['contactPersonName']);  
            $contactPerson['contactPersonTitle'] = Encoding::escapleAllCharacter($row['contactPersonTitle']);  
            $contactPerson['contactPersonNo'] = $row['contactPersonNo'];
            $contactPerson['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $contactPerson;
}
#endregion contactPerson
#region customer
public function GetCustomerSearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblCustomer" WHERE 1=1 ';

        $customerName = isset($searchParam['customerName']) ? $searchParam['customerName'] : '';
        $customerGroup = isset($searchParam['customerGroup']) ? $searchParam['customerGroup'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $customerId = isset($searchParam['customerId']) ? $searchParam['customerId'] : '';

        if ($customerId != '') {
            $sql = $sql . 'AND "customerId"::text LIKE :customerId ';
        }

        if ($customerName != '') {
            $sql = $sql . 'AND "customerName" LIKE :customerName ';
        }
        if ($customerGroup != '') {
            $sql = $sql . 'AND "customerGroup" LIKE :customerGroup ';
        }
        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($customerId != '') {
            $customerId = "%" . $customerId . "%";
            $sth->bindParam(':customerId', $customerId);

        }

        if ($customerName != '') {
            $customerName = "%" . $customerName . "%";
            $sth->bindParam(':customerName', $customerName);
        }
        if ($customerGroup != '') {
            $customerGroup = "%" . $customerGroup . "%";
            $sth->bindParam(':customerGroup', $customerGroup);
        }
        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetCustomerRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblCustomer"';
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

public function GetCustomerSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' customerId ';

    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "customerId" ';

    $sql1 = 'FROM "TblCustomer" WHERE 1=1 ';

    $sql2 = 'FROM "TblCustomer" WHERE 1=1 ';

    $customerId = isset($searchParam['customerId']) ? $searchParam['customerId'] : '';
    $customerName = isset($searchParam['customerName']) ? $searchParam['customerName'] : '';
    $customerGroup = isset($searchParam['customerGroup']) ? $searchParam['customerGroup'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($customerId != '') {
        $sql1 = $sql1 . 'AND "customerId"::text LIKE :customerId1 ';
        $sql2 = $sql2 . 'AND "customerId"::text LIKE :customerId2 ';
    }
    if ($customerName != '') {
        $sql1 = $sql1 . 'AND "customerName" LIKE :customerName1 ';
        $sql2 = $sql2 . 'AND "customerName" LIKE :customerName2 ';
    }
    if ($customerGroup != '') {
        $sql1 = $sql1 . 'AND "customerGroup" LIKE :customerGroup1 ';
        $sql2 = $sql2 . 'AND "customerGroup" LIKE :customerGroup2 ';
    }
    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . " ORDER BY " . $orderByStr . ' ';
        $sql2 = $sql2 . " ORDER BY " . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "customerId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($customerId != '') {
            $customerId = "%" . $customerId . "%";
            $sth->bindParam(':customerId1', $customerId);
            if ($start != 0) {
                $sth->bindParam(':customerId2', $customerId);
            }

        }
        if ($customerName != '') {
            $customerName = "%" . $customerName . "%";
            $sth->bindParam(':customerName1', $customerName);
            if ($start != 0) {
                $sth->bindParam(':customerName2', $customerName);
            }

        }
        if ($customerGroup != '') {
            $customerGroup = "%" . $customerGroup . "%";
            $sth->bindParam(':customerGroup1', $customerGroup);
            if ($start != 0) {
                $sth->bindParam(':customerGroup2', $customerGroup);
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

        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) {
            $array['customerId'] = $row['customerId'];
            $array['customerName'] = Encoding::escapleAllCharacter($row['customerName']); 
            $array['customerGroup'] = Encoding::escapleAllCharacter($row['customerGroup']);  
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getCustomerById($id)
{

    try {
        $sql = 'SELECT * FROM "TblCustomer" WHERE "customerId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $customer['customerId'] = $row['customerId'];
            $customer['customerName'] = Encoding::escapleAllCharacter($row['customerName']); 
            $customer['customerGroup'] = Encoding::escapleAllCharacter($row['customerGroup']);  
            $customer['businessTypeId'] = $row['businessTypeId'];
            $customer['clpNetwork'] = $row['clpNetwork'];
            $customer['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $customer;
}
#endregion customer
#region partyToBeCharged
public function GetPartyToBeChargedSearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblPartyToBeCharged" WHERE 1=1 ';

        $partyToBeChargedName = isset($searchParam['partyToBeChargedName']) ? $searchParam['partyToBeChargedName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $partyToBeChargedId = isset($searchParam['partyToBeChargedId']) ? $searchParam['partyToBeChargedId'] : '';

        if ($partyToBeChargedId != '') {
            $sql = $sql . 'AND "partyToBeChargedId"::text LIKE :partyToBeChargedId ';
        }

        if ($partyToBeChargedName != '') {
            $sql = $sql . 'AND "partyToBeChargedName" LIKE :partyToBeChargedName ';
        }

        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($partyToBeChargedId != '') {
            $partyToBeChargedId = "%" . $partyToBeChargedId . "%";
            $sth->bindParam(':partyToBeChargedId', $partyToBeChargedId);

        }

        if ($partyToBeChargedName != '') {
            $partyToBeChargedName = "%" . $partyToBeChargedName . "%";
            $sth->bindParam(':partyToBeChargedName', $partyToBeChargedName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetPartyToBeChargedRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblPartyToBeCharged"';
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

public function GetPartyToBeChargedSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' partyToBeChargedId ';
    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "partyToBeChargedId" ';

    $sql1 = 'FROM "TblPartyToBeCharged" WHERE 1=1 ';

    $sql2 = 'FROM "TblPartyToBeCharged" WHERE 1=1 ';

    $partyToBeChargedId = isset($searchParam['partyToBeChargedId']) ? $searchParam['partyToBeChargedId'] : '';
    $partyToBeChargedName = isset($searchParam['partyToBeChargedName']) ? $searchParam['partyToBeChargedName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($partyToBeChargedId != '') {
        $sql1 = $sql1 . 'AND "partyToBeChargedId"::text LIKE :partyToBeChargedId1 ';
        $sql2 = $sql2 . 'AND "partyToBeChargedId"::text LIKE :partyToBeChargedId2 ';
    }
    if ($partyToBeChargedName != '') {
        $sql1 = $sql1 . 'AND "partyToBeChargedName" LIKE :partyToBeChargedName1 ';
        $sql2 = $sql2 . 'AND "partyToBeChargedName" LIKE :partyToBeChargedName2 ';
    }

    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . ' ORDER BY ' . $orderByStr . ' ';
        $sql2 = $sql2 . ' ORDER BY ' . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "partyToBeChargedId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($partyToBeChargedId != '') {
            $partyToBeChargedId = "%" . $partyToBeChargedId . "%";
            $sth->bindParam(':partyToBeChargedId1', $partyToBeChargedId);
            if ($start != 0) {
                $sth->bindParam(':partyToBeChargedId2', $partyToBeChargedId);
            }

        }
        if ($partyToBeChargedName != '') {
            $partyToBeChargedName = "%" . $partyToBeChargedName . "%";
            $sth->bindParam(':partyToBeChargedName1', $partyToBeChargedName);
            if ($start != 0) {
                $sth->bindParam(':partyToBeChargedName2', $partyToBeChargedName);
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

        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['partyToBeChargedId'] = $row['partyToBeChargedId'];
            $array['partyToBeChargedName'] = Encoding::escapleAllCharacter($row['partyToBeChargedName']);  
            $array['showOrder'] = $row['showOrder'];
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getPartyToBeChargedById($id)
{

    try {
        $sql = 'SELECT * FROM "TblPartyToBeCharged" WHERE "partyToBeChargedId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $partyToBeCharged['partyToBeChargedId'] = $row['partyToBeChargedId'];
            $partyToBeCharged['partyToBeChargedName'] = Encoding::escapleAllCharacter($row['partyToBeChargedName']);  
            $partyToBeCharged['showOrder'] = $row['showOrder'];
            $partyToBeCharged['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $partyToBeCharged;
}
#endregion partyToBeCharged
#region plantType
public function GetPlantTypeSearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblPlantType" WHERE 1=1 ';

        $plantTypeName = isset($searchParam['plantTypeName']) ? $searchParam['plantTypeName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $plantTypeId = isset($searchParam['plantTypeId']) ? $searchParam['plantTypeId'] : '';

        if ($plantTypeId != '') {
            $sql = $sql . 'AND "plantTypeId"::text LIKE :plantTypeId ';
        }

        if ($plantTypeName != '') {
            $sql = $sql . 'AND "plantTypeName" LIKE :plantTypeName ';
        }

        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($plantTypeId != '') {
            $plantTypeId = "%" . $plantTypeId . "%";
            $sth->bindParam(':plantTypeId', $plantTypeId);

        }

        if ($plantTypeName != '') {
            $plantTypeName = "%" . $plantTypeName . "%";
            $sth->bindParam(':plantTypeName', $plantTypeName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetPlantTypeRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblPlantType"';
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

public function GetPlantTypeSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' plantTypeId ';

    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "plantTypeId" ';

    $sql1 = 'FROM "TblPlantType" WHERE 1=1 ';

    $sql2 = 'FROM "TblPlantType" WHERE 1=1 ';

    $plantTypeId = isset($searchParam['plantTypeId']) ? $searchParam['plantTypeId'] : '';
    $plantTypeName = isset($searchParam['plantTypeName']) ? $searchParam['plantTypeName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($plantTypeId != '') {
        $sql1 = $sql1 . 'AND "plantTypeId"::text LIKE :plantTypeId1 ';
        $sql2 = $sql2 . 'AND "plantTypeId"::text LIKE :plantTypeId2 ';
    }
    if ($plantTypeName != '') {
        $sql1 = $sql1 . 'AND "plantTypeName" LIKE :plantTypeName1 ';
        $sql2 = $sql2 . 'AND "plantTypeName" LIKE :plantTypeName2 ';
    }

    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . ' ORDER BY ' . $orderByStr . ' ';
        $sql2 = $sql2 . ' ORDER BY ' . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "plantTypeId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($plantTypeId != '') {
            $plantTypeId = "%" . $plantTypeId . "%";
            $sth->bindParam(':plantTypeId1', $plantTypeId);
            if ($start != 0) {
                $sth->bindParam(':plantTypeId2', $plantTypeId);
            }

        }
        if ($plantTypeName != '') {
            $plantTypeName = "%" . $plantTypeName . "%";
            $sth->bindParam(':plantTypeName1', $plantTypeName);
            if ($start != 0) {
                $sth->bindParam(':plantTypeName2', $plantTypeName);
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
        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['plantTypeId'] = $row['plantTypeId'];
            $array['plantTypeName'] = Encoding::escapleAllCharacter($row['plantTypeName']);  
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getPlantTypeById($id)
{

    try {
        $sql = 'SELECT * FROM "TblPlantType" WHERE "plantTypeId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $plantType['plantTypeId'] = $row['plantTypeId'];
            $plantType['plantTypeName'] = Encoding::escapleAllCharacter($row['plantTypeName']);  
            $plantType['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $plantType;
}
#endregion plantType
#region serviceStatus
public function GetServiceStatusSearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblServiceStatus" WHERE 1=1 ';

        $serviceStatusName = isset($searchParam['serviceStatusName']) ? $searchParam['serviceStatusName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $serviceStatusId = isset($searchParam['serviceStatusId']) ? $searchParam['serviceStatusId'] : '';

        if ($serviceStatusId != '') {
            $sql = $sql . 'AND "serviceStatusId"::text LIKE :serviceStatusId ';
        }

        if ($serviceStatusName != '') {
            $sql = $sql . 'AND "serviceStatusName" LIKE :serviceStatusName ';
        }

        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($serviceStatusId != '') {
            $serviceStatusId = "%" . $serviceStatusId . "%";
            $sth->bindParam(':serviceStatusId', $serviceStatusId);

        }

        if ($serviceStatusName != '') {
            $serviceStatusName = "%" . $serviceStatusName . "%";
            $sth->bindParam(':serviceStatusName', $serviceStatusName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetServiceStatusRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblServiceStatus"';
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

public function GetServiceStatusSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' serviceStatusId ';
    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "serviceStatusId" ';

    $sql1 = 'FROM "TblServiceStatus" WHERE 1=1 ';

    $sql2 = 'FROM "TblServiceStatus" WHERE 1=1 ';

    $serviceStatusId = isset($searchParam['serviceStatusId']) ? $searchParam['serviceStatusId'] : '';
    $serviceStatusName = isset($searchParam['serviceStatusName']) ? $searchParam['serviceStatusName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($serviceStatusId != '') {
        $sql1 = $sql1 . 'AND "serviceStatusId"::text LIKE :serviceStatusId1 ';
        $sql2 = $sql2 . 'AND "serviceStatusId"::text LIKE :serviceStatusId2 ';
    }
    if ($serviceStatusName != '') {
        $sql1 = $sql1 . 'AND "serviceStatusName" LIKE :serviceStatusName1 ';
        $sql2 = $sql2 . 'AND "serviceStatusName" LIKE :serviceStatusName2 ';
    }

    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . ' ORDER BY ' . $orderByStr . ' ';
        $sql2 = $sql2 . ' ORDER BY ' . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "serviceStatusId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($serviceStatusId != '') {
            $serviceStatusId = "%" . $serviceStatusId . "%";
            $sth->bindParam(':serviceStatusId1', $serviceStatusId);
            if ($start != 0) {
                $sth->bindParam(':serviceStatusId2', $serviceStatusId);
            }

        }
        if ($serviceStatusName != '') {
            $serviceStatusName = "%" . $serviceStatusName . "%";
            $sth->bindParam(':serviceStatusName1', $serviceStatusName);
            if ($start != 0) {
                $sth->bindParam(':serviceStatusName2', $serviceStatusName);
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
        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['serviceStatusId'] = $row['serviceStatusId'];
            $array['serviceStatusName'] = Encoding::escapleAllCharacter($row['serviceStatusName']);  
            $array['showOrder'] = $row['showOrder'];
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getServiceStatusById($id)
{

    try {
        $sql = 'SELECT * FROM "TblServiceStatus" WHERE "serviceStatusId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $serviceStatus['serviceStatusId'] = $row['serviceStatusId'];
            $serviceStatus['serviceStatusName'] = Encoding::escapleAllCharacter($row['serviceStatusName']);  
            $serviceStatus['showOrder'] = $row['showOrder'];
            $serviceStatus['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $serviceStatus;
}
#endregion serviceStatus
#region serviceType
public function GetServiceTypeSearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblServiceType" WHERE 1=1 ';

        $serviceTypeName = isset($searchParam['serviceTypeName']) ? $searchParam['serviceTypeName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $serviceTypeId = isset($searchParam['serviceTypeId']) ? $searchParam['serviceTypeId'] : '';

        if ($serviceTypeId != '') {
            $sql = $sql . 'AND "serviceTypeId"::text LIKE :serviceTypeId ';
        }

        if ($serviceTypeName != '') {
            $sql = $sql . 'AND "serviceTypeName" LIKE :serviceTypeName ';
        }

        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($serviceTypeId != '') {
            $serviceTypeId = "%" . $serviceTypeId . "%";
            $sth->bindParam(':serviceTypeId', $serviceTypeId);

        }

        if ($serviceTypeName != '') {
            $serviceTypeName = "%" . $serviceTypeName . "%";
            $sth->bindParam(':serviceTypeName', $serviceTypeName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetServiceTypeRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblServiceType"';
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

public function GetServiceTypeSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' serviceTypeId ';
    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "serviceTypeId" ';

    $sql1 = 'FROM "TblServiceType" WHERE 1=1 ';

    $sql2 = 'FROM "TblServiceType" WHERE 1=1 ';

    $serviceTypeId = isset($searchParam['serviceTypeId']) ? $searchParam['serviceTypeId'] : '';
    $serviceTypeName = isset($searchParam['serviceTypeName']) ? $searchParam['serviceTypeName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($serviceTypeId != '') {
        $sql1 = $sql1 . 'AND "serviceTypeId"::text LIKE :serviceTypeId1 ';
        $sql2 = $sql2 . 'AND "serviceTypeId"::text LIKE :serviceTypeId2 ';
    }
    if ($serviceTypeName != '') {
        $sql1 = $sql1 . 'AND "serviceTypeName" LIKE :serviceTypeName1 ';
        $sql2 = $sql2 . 'AND "serviceTypeName" LIKE :serviceTypeName2 ';
    }

    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . ' ORDER BY ' . $orderByStr . ' ';
        $sql2 = $sql2 . ' ORDER BY ' . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "serviceTypeId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($serviceTypeId != '') {
            $serviceTypeId = "%" . $serviceTypeId . "%";
            $sth->bindParam(':serviceTypeId1', $serviceTypeId);
            if ($start != 0) {
                $sth->bindParam(':serviceTypeId2', $serviceTypeId);
            }

        }
        if ($serviceTypeName != '') {
            $serviceTypeName = "%" . $serviceTypeName . "%";
            $sth->bindParam(':serviceTypeName1', $serviceTypeName);
            if ($start != 0) {
                $sth->bindParam(':serviceTypeName2', $serviceTypeName);
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
        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['serviceTypeId'] = $row['serviceTypeId'];
            $array['serviceTypeName'] = Encoding::escapleAllCharacter($row['serviceTypeName']);  
            $array['showOrder'] = $row['showOrder'];
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getServiceTypeById($id)
{

    try {
        $sql = 'SELECT * FROM "TblServiceType" WHERE "serviceTypeId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $serviceType['serviceTypeId'] = $row['serviceTypeId'];
            $serviceType['serviceTypeName'] = Encoding::escapleAllCharacter($row['serviceTypeName']);  
            $serviceType['showOrder'] = $row['showOrder'];
            $serviceType['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $serviceType;
}
#endregion serviceType
#region projectType
public function GetProjectTypeSearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblProjectType" WHERE 1=1 ';

        $projectTypeName = isset($searchParam['projectTypeName']) ? $searchParam['projectTypeName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $projectTypeId = isset($searchParam['projectTypeId']) ? $searchParam['projectTypeId'] : '';

        if ($projectTypeId != '') {
            $sql = $sql . 'AND "projectTypeId"::text LIKE :projectTypeId ';
        }

        if ($projectTypeName != '') {
            $sql = $sql . 'AND "projectTypeName" LIKE :projectTypeName ';
        }

        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($projectTypeId != '') {
            $projectTypeId = "%" . $projectTypeId . "%";
            $sth->bindParam(':projectTypeId', $projectTypeId);

        }

        if ($projectTypeName != '') {
            $projectTypeName = "%" . $projectTypeName . "%";
            $sth->bindParam(':projectTypeName', $projectTypeName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetProjectTypeRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblProjectType"';
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

public function GetProjectTypeSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' projectTypeId ';

    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "projectTypeId" ';

    $sql1 = 'FROM "TblProjectType" WHERE 1=1 ';

    $sql2 = 'FROM "TblProjectType" WHERE 1=1 ';

    $projectTypeId = isset($searchParam['projectTypeId']) ? $searchParam['projectTypeId'] : '';
    $projectTypeName = isset($searchParam['projectTypeName']) ? $searchParam['projectTypeName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($projectTypeId != '') {
        $sql1 = $sql1 . 'AND "projectTypeId"::text LIKE :projectTypeId1 ';
        $sql2 = $sql2 . 'AND "projectTypeId"::text LIKE :projectTypeId2 ';
    }
    if ($projectTypeName != '') {
        $sql1 = $sql1 . 'AND "projectTypeName" LIKE :projectTypeName1 ';
        $sql2 = $sql2 . 'AND "projectTypeName" LIKE :projectTypeName2 ';
    }

    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . ' ORDER BY ' . $orderByStr . ' ';
        $sql2 = $sql2 . ' ORDER BY ' . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "projectTypeId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($projectTypeId != '') {
            $projectTypeId = "%" . $projectTypeId . "%";
            $sth->bindParam(':projectTypeId1', $projectTypeId);
            if ($start != 0) {
                $sth->bindParam(':projectTypeId2', $projectTypeId);
            }

        }
        if ($projectTypeName != '') {
            $projectTypeName = "%" . $projectTypeName . "%";
            $sth->bindParam(':projectTypeName1', $projectTypeName);
            if ($start != 0) {
                $sth->bindParam(':projectTypeName2', $projectTypeName);
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
        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['projectTypeId'] = $row['projectTypeId'];
            $array['projectTypeName'] = Encoding::escapleAllCharacter($row['projectTypeName']);  
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getProjectTypeById($id)
{

    try {
        $sql = 'SELECT * FROM "TblProjectType" WHERE "projectTypeId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $projectType['projectTypeId'] = $row['projectTypeId'];
            $projectType['projectTypeName'] = Encoding::escapleAllCharacter($row['projectTypeName']);  
            $projectType['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $projectType;
}
#endregion projectType
#region buildingType
public function GetBuildingTypeSearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblBuildingType" WHERE 1=1 ';

        $buildingTypeName = isset($searchParam['buildingTypeName']) ? $searchParam['buildingTypeName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $buildingTypeId = isset($searchParam['buildingTypeId']) ? $searchParam['buildingTypeId'] : '';

        if ($buildingTypeId != '') {
            $sql = $sql . 'AND "buildingTypeId"::text LIKE :buildingTypeId ';
        }

        if ($buildingTypeName != '') {
            $sql = $sql . 'AND "buildingTypeName" LIKE :buildingTypeName ';
        }

        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($buildingTypeId != '') {
            $buildingTypeId = "%" . $buildingTypeId . "%";
            $sth->bindParam(':buildingTypeId', $buildingTypeId);

        }

        if ($buildingTypeName != '') {
            $buildingTypeName = "%" . $buildingTypeName . "%";
            $sth->bindParam(':buildingTypeName', $buildingTypeName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetBuildingTypeRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblBuildingType"';
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

public function GetBuildingTypeSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' buildingTypeId ';
    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "buildingTypeId" ';

    $sql1 = 'FROM "TblBuildingType" WHERE 1=1 ';

    $sql2 = 'FROM "TblBuildingType" WHERE 1=1 ';

    $buildingTypeId = isset($searchParam['buildingTypeId']) ? $searchParam['buildingTypeId'] : '';
    $buildingTypeName = isset($searchParam['buildingTypeName']) ? $searchParam['buildingTypeName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($buildingTypeId != '') {
        $sql1 = $sql1 . 'AND "buildingTypeId"::text LIKE :buildingTypeId1 ';
        $sql2 = $sql2 . 'AND "buildingTypeId"::text LIKE :buildingTypeId2 ';
    }
    if ($buildingTypeName != '') {
        $sql1 = $sql1 . 'AND "buildingTypeName" LIKE :buildingTypeName1 ';
        $sql2 = $sql2 . 'AND "buildingTypeName" LIKE :buildingTypeName2 ';
    }

    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . " ORDER BY " . $orderByStr . ' ';
        $sql2 = $sql2 . " ORDER BY " . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "buildingTypeId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1;
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($buildingTypeId != '') {
            $buildingTypeId = "%" . $buildingTypeId . "%";
            $sth->bindParam(':buildingTypeId1', $buildingTypeId);
            if ($start != 0) {
                $sth->bindParam(':buildingTypeId2', $buildingTypeId);
            }

        }
        if ($buildingTypeName != '') {
            $buildingTypeName = "%" . $buildingTypeName . "%";
            $sth->bindParam(':buildingTypeName1', $buildingTypeName);
            if ($start != 0) {
                $sth->bindParam(':buildingTypeName2', $buildingTypeName);
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
        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['buildingTypeId'] = $row['buildingTypeId'];
            $array['buildingTypeName'] = Encoding::escapleAllCharacter($row['buildingTypeName']);  
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getBuildingTypeById($id)
{

    try {
        $sql = 'SELECT * FROM "TblBuildingType" WHERE "buildingTypeId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $buildingType['buildingTypeId'] = $row['buildingTypeId'];
            $buildingType['buildingTypeName'] = Encoding::escapleAllCharacter($row['buildingTypeName']);  
            $buildingType['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $buildingType;
}
#endregion buildingType
#region projectRegion
public function GetProjectRegionSearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblProjectRegion" WHERE 1=1 ';

        $projectRegionEngName = isset($searchParam['projectRegionEngName']) ? $searchParam['projectRegionEngName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $projectRegionId = isset($searchParam['projectRegionId']) ? $searchParam['projectRegionId'] : '';

        if ($projectRegionId != '') {
            $sql = $sql . 'AND "projectRegionId"::text LIKE :projectRegionId ';
        }

        if ($projectRegionEngName != '') {
            $sql = $sql . 'AND "projectRegionEngName" LIKE :projectRegionEngName ';
        }

        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);
        if ($projectRegionId != '') {
            $projectRegionId = "%" . $projectRegionId . "%";
            $sth->bindParam(':projectRegionId', $projectRegionId);

        }

        if ($projectRegionEngName != '') {
            $projectRegionEngName = "%" . $projectRegionEngName . "%";
            $sth->bindParam(':projectRegionEngName', $projectRegionEngName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetProjectRegionRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblProjectRegion"';
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

public function GetProjectRegionSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' projectRegionId ';

    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "projectRegionId" ';

    $sql1 = 'FROM "TblProjectRegion" WHERE 1=1 ';

    $sql2 = 'FROM "TblProjectRegion" WHERE 1=1 ';

    $projectRegionId = isset($searchParam['projectRegionId']) ? $searchParam['projectRegionId'] : '';
    $projectRegionEngName = isset($searchParam['projectRegionEngName']) ? $searchParam['projectRegionEngName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($projectRegionId != '') {
        $sql1 = $sql1 . 'AND "projectRegionId"::text LIKE :projectRegionId1 ';
        $sql2 = $sql2 . 'AND "projectRegionId"::text LIKE :projectRegionId2 ';
    }
    if ($projectRegionEngName != '') {
        $sql1 = $sql1 . 'AND "projectRegionEngName" LIKE :projectRegionEngName1 ';
        $sql2 = $sql2 . 'AND "projectRegionEngName" LIKE :projectRegionEngName2 ';
    }

    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . " ORDER BY " . $orderByStr . ' ';
        $sql2 = $sql2 . " ORDER BY " . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "projectRegionId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($projectRegionId != '') {
            $projectRegionId = "%" . $projectRegionId . "%";
            $sth->bindParam(':projectRegionId1', $projectRegionId);
            if ($start != 0) {
                $sth->bindParam(':projectRegionId2', $projectRegionId);
            }

        }
        if ($projectRegionEngName != '') {
            $projectRegionEngName = "%" . $projectRegionEngName . "%";
            $sth->bindParam(':projectRegionEngName1', $projectRegionEngName);
            if ($start != 0) {
                $sth->bindParam(':projectRegionEngName2', $projectRegionEngName);
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
        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['projectRegionId'] = $row['projectRegionId'];
            $array['projectRegionEngName'] = Encoding::escapleAllCharacter($row['projectRegionEngName']);  
            $array['projectRegionChiName'] = Encoding::escapleAllCharacter($row['projectRegionChiName']);  
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getProjectRegionById($id)
{

    try {
        $sql = 'SELECT * FROM "TblProjectRegion" WHERE "projectRegionId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $projectRegion['projectRegionId'] = $row['projectRegionId'];
            $projectRegion['projectRegionEngName'] = Encoding::escapleAllCharacter($row['projectRegionEngName']);  
            $projectRegion['projectRegionChiName'] = Encoding::escapleAllCharacter($row['projectRegionChiName']);  
            $projectRegion['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $projectRegion;
}
#endregion projectRegion
#region consultantCompany
public function GetConsultantCompanySearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblConsultantCompany" WHERE 1=1 ';

        $consultantCompanyName = isset($searchParam['consultantCompanyName']) ? $searchParam['consultantCompanyName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $consultantCompanyId = isset($searchParam['consultantCompanyId']) ? $searchParam['consultantCompanyId'] : '';

        if ($consultantCompanyId != '') {
            $sql = $sql . 'AND "consultantCompanyId"::text LIKE :consultantCompanyId ';
        }

        if ($consultantCompanyName != '') {
            $sql = $sql . 'AND "consultantCompanyName" LIKE :consultantCompanyName ';
        }

        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($consultantCompanyId != '') {
            $consultantCompanyId = "%" . $consultantCompanyId . "%";
            $sth->bindParam(':consultantCompanyId', $consultantCompanyId);

        }

        if ($consultantCompanyName != '') {
            $consultantCompanyName = "%" . $consultantCompanyName . "%";
            $sth->bindParam(':consultantCompanyName', $consultantCompanyName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetConsultantCompanyRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblConsultantCompany"';
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

public function GetConsultantCompanySearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' consultantCompanyId ';

    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "consultantCompanyId" ';

    $sql1 = 'FROM "TblConsultantCompany" WHERE 1=1 ';

    $sql2 = 'FROM "TblConsultantCompany" WHERE 1=1 ';

    $consultantCompanyId = isset($searchParam['consultantCompanyId']) ? $searchParam['consultantCompanyId'] : '';
    $consultantCompanyName = isset($searchParam['consultantCompanyName']) ? $searchParam['consultantCompanyName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($consultantCompanyId != '') {
        $sql1 = $sql1 . 'AND "consultantCompanyId"::text LIKE :consultantCompanyId1 ';
        $sql2 = $sql2 . 'AND "consultantCompanyId"::text LIKE :consultantCompanyId2 ';
    }
    if ($consultantCompanyName != '') {
        $sql1 = $sql1 . 'AND "consultantCompanyName" LIKE :consultantCompanyName1 ';
        $sql2 = $sql2 . 'AND "consultantCompanyName" LIKE :consultantCompanyName2 ';
    }

    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . ' ORDER BY ' . $orderByStr . ' ';
        $sql2 = $sql2 . ' ORDER BY ' . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "consultantCompanyId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($consultantCompanyId != '') {
            $consultantCompanyId = "%" . $consultantCompanyId . "%";
            $sth->bindParam(':consultantCompanyId1', $consultantCompanyId);
            if ($start != 0) {
                $sth->bindParam(':consultantCompanyId2', $consultantCompanyId);
            }

        }
        if ($consultantCompanyName != '') {
            $consultantCompanyName = "%" . $consultantCompanyName . "%";
            $sth->bindParam(':consultantCompanyName1', $consultantCompanyName);
            if ($start != 0) {
                $sth->bindParam(':consultantCompanyName2', $consultantCompanyName);
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
        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['consultantCompanyId'] = $row['consultantCompanyId'];
            $array['consultantCompanyName'] = Encoding::escapleAllCharacter($row['consultantCompanyName']);
            $array['addressLine1'] = Encoding::escapleAllCharacter($row['addressLine1']);
            $array['addressLine2'] = Encoding::escapleAllCharacter($row['addressLine2']);
            $array['addressLine3'] = Encoding::escapleAllCharacter($row['addressLine3']);
            $array['addressLine4'] = Encoding::escapleAllCharacter($row['addressLine4']);
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getConsultantCompanyById($id)
{

    try {
        $sql = 'SELECT * FROM "TblConsultantCompany" WHERE "consultantCompanyId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $consultantCompany['consultantCompanyId'] = $row['consultantCompanyId'];
            $consultantCompany['consultantCompanyName'] = Encoding::escapleAllCharacter($row['consultantCompanyName']);
            $consultantCompany['addressLine1'] = Encoding::escapleAllCharacter($row['addressLine1']);
            $consultantCompany['addressLine2'] = Encoding::escapleAllCharacter($row['addressLine2']);
            $consultantCompany['addressLine3'] = Encoding::escapleAllCharacter($row['addressLine3']);
            $consultantCompany['addressLine4'] = Encoding::escapleAllCharacter($row['addressLine4']);
            $consultantCompany['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $consultantCompany;
}
#endregion consultantCompany
#region pqSensitiveLoad
public function GetPqSensitiveLoadSearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblPqSensitiveLoad" WHERE 1=1 ';

        $pqSensitiveLoadName = isset($searchParam['pqSensitiveLoadName']) ? $searchParam['pqSensitiveLoadName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $pqSensitiveLoadId = isset($searchParam['pqSensitiveLoadId']) ? $searchParam['pqSensitiveLoadId'] : '';

        if ($pqSensitiveLoadId != '') {
            $sql = $sql . 'AND "pqSensitiveLoadId"::text LIKE :pqSensitiveLoadId ';
        }

        if ($pqSensitiveLoadName != '') {
            $sql = $sql . 'AND "pqSensitiveLoadName" LIKE :pqSensitiveLoadName ';
        }

        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($pqSensitiveLoadId != '') {
            $pqSensitiveLoadId = "%" . $pqSensitiveLoadId . "%";
            $sth->bindParam(':pqSensitiveLoadId', $pqSensitiveLoadId);

        }

        if ($pqSensitiveLoadName != '') {
            $pqSensitiveLoadName = "%" . $pqSensitiveLoadName . "%";
            $sth->bindParam(':pqSensitiveLoadName', $pqSensitiveLoadName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetPqSensitiveLoadRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblPqSensitiveLoad"';
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

public function GetPqSensitiveLoadSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' pqSensitiveLoadId ';

    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "pqSensitiveLoadId" ';

    $sql1 = 'FROM "TblPqSensitiveLoad" WHERE 1=1 ';

    $sql2 = 'FROM "TblPqSensitiveLoad" WHERE 1=1 ';

    $pqSensitiveLoadId = isset($searchParam['pqSensitiveLoadId']) ? $searchParam['pqSensitiveLoadId'] : '';
    $pqSensitiveLoadName = isset($searchParam['pqSensitiveLoadName']) ? $searchParam['pqSensitiveLoadName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($pqSensitiveLoadId != '') {
        $sql1 = $sql1 . 'AND "pqSensitiveLoadId"::text LIKE :pqSensitiveLoadId1 ';
        $sql2 = $sql2 . 'AND "pqSensitiveLoadId"::text LIKE :pqSensitiveLoadId2 ';
    }
    if ($pqSensitiveLoadName != '') {
        $sql1 = $sql1 . 'AND "pqSensitiveLoadName" LIKE :pqSensitiveLoadName1 ';
        $sql2 = $sql2 . 'AND "pqSensitiveLoadName" LIKE :pqSensitiveLoadName2 ';
    }

    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . " ORDER BY " . $orderByStr . ' ';
        $sql2 = $sql2 . " ORDER BY " . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "pqSensitiveLoadId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($pqSensitiveLoadId != '') {
            $pqSensitiveLoadId = "%" . $pqSensitiveLoadId . "%";
            $sth->bindParam(':pqSensitiveLoadId1', $pqSensitiveLoadId);
            if ($start != 0) {
                $sth->bindParam(':pqSensitiveLoadId2', $pqSensitiveLoadId);
            }

        }
        if ($pqSensitiveLoadName != '') {
            $pqSensitiveLoadName = "%" . $pqSensitiveLoadName . "%";
            $sth->bindParam(':pqSensitiveLoadName1', $pqSensitiveLoadName);
            if ($start != 0) {
                $sth->bindParam(':pqSensitiveLoadName2', $pqSensitiveLoadName);
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
        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['pqSensitiveLoadId'] = $row['pqSensitiveLoadId'];
            $array['pqSensitiveLoadName'] = Encoding::escapleAllCharacter($row['pqSensitiveLoadName']);  
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getPqSensitiveLoadById($id)
{

    try {
        $sql = 'SELECT * FROM "TblPqSensitiveLoad" WHERE "pqSensitiveLoadId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $pqSensitiveLoad['pqSensitiveLoadId'] = $row['pqSensitiveLoadId'];
            $pqSensitiveLoad['pqSensitiveLoadName'] = Encoding::escapleAllCharacter($row['pqSensitiveLoadName']);  
            $pqSensitiveLoad['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $pqSensitiveLoad;
}
#endregion pqSensitiveLoad
#region consultant
public function GetConsultantSearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblConsultant" c LEFT JOIN "TblConsultantCompany" cc on c."consultantCompanyId" = cc."consultantCompanyId" WHERE 1=1 ';

        $consultantName = isset($searchParam['consultantName']) ? $searchParam['consultantName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $consultantId = isset($searchParam['consultantId']) ? $searchParam['consultantId'] : '';

        if ($consultantId != '') {
            $sql = $sql . 'AND "consultantId"::text LIKE :consultantId ';
        }

        if ($consultantName != '') {
            $sql = $sql . 'AND "consultantName" LIKE :consultantName ';
        }

        if ($active != '') {
            $sql = $sql . 'AND c."active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($consultantId != '') {
            $consultantId = "%" . $consultantId . "%";
            $sth->bindParam(':consultantId', $consultantId);

        }

        if ($consultantName != '') {
            $consultantName = "%" . $consultantName . "%";
            $sth->bindParam(':consultantName', $consultantName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetConsultantRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblConsultant"';
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

public function GetConsultantSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' c.*, cc.consultantCompanyName as consultantCompanyName ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' consultantId ';

    $sqlMid = 'SELECT c.*, cc."consultantCompanyName" ';

    $sqlBase = 'SELECT "consultantId" ';


    $sql1 = 'FROM "TblConsultant" c LEFT JOIN "TblConsultantCompany" cc on c."consultantCompanyId" = cc."consultantCompanyId" WHERE 1=1  ';

    $sql2 = 'FROM "TblConsultant" c LEFT JOIN "TblConsultantCompany" cc on c."consultantCompanyId" = cc."consultantCompanyId" WHERE 1=1 ';

    $consultantId = isset($searchParam['consultantId']) ? $searchParam['consultantId'] : '';
    $consultantName = isset($searchParam['consultantName']) ? $searchParam['consultantName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($consultantId != '') {
        $sql1 = $sql1 . 'AND "consultantId"::text LIKE :consultantId1 ';
        $sql2 = $sql2 . 'AND "consultantId"::text LIKE :consultantId2 ';
    }
    if ($consultantName != '') {
        $sql1 = $sql1 . 'AND "consultantName" LIKE :consultantName1 ';
        $sql2 = $sql2 . 'AND "consultantName" LIKE :consultantName2 ';
    }

    if ($active != '') {
        $sql1 = $sql1 . 'AND c."active" LIKE :active1 ';
        $sql2 = $sql2 . 'AND c."active" LIKE :active2 ';
    }

    if ($orderByStr != '"active" asc' && $orderByStr != '"active" desc') {

        $sql1 = $sql1 . " ORDER BY " . $orderByStr . ' ';
        $sql2 = $sql2 . " ORDER BY " . $orderByStr . ' ';
    }
    else{
        $sql1 = $sql1 . " ORDER BY c." . $orderByStr . ' ';
        $sql2 = $sql2 . " ORDER BY c." . $orderByStr . ' ';
    }

    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE "consultantId" NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($consultantId != '') {
            $consultantId = "%" . $consultantId . "%";
            $sth->bindParam(':consultantId1', $consultantId);
            if ($start != 0) {
                $sth->bindParam(':consultantId2', $consultantId);
            }

        }
        if ($consultantName != '') {
            $consultantName = "%" . $consultantName . "%";
            $sth->bindParam(':consultantName1', $consultantName);
            if ($start != 0) {
                $sth->bindParam(':consultantName2', $consultantName);
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
        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['consultantId'] = $row['consultantId'];
            $array['consultantName'] = Encoding::escapleAllCharacter($row['consultantName']);  
            $array['consultantCompanyId'] = $row['consultantCompanyId'];
            $array['consultantCompanyName'] = Encoding::escapleAllCharacter($row['consultantCompanyName']);  
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getConsultantById($id)
{

    try {
        $sql = 'SELECT * FROM "TblConsultant" WHERE "consultantId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $consultant['consultantId'] = $row['consultantId'];
            $consultant['consultantName'] = Encoding::escapleAllCharacter($row['consultantName']);  
            $consultant['consultantCompanyId'] = $row['consultantCompanyId'];
            $consultant['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $consultant;
}
#endregion consultant
#region regionPlanner
public function GetRegionPlannerSearchResultCount($searchParam)
{

    try {
        $sql = 'SELECT count(1) FROM "TblRegionPlanner" WHERE 1=1 ';

        $regionPlannerName = isset($searchParam['regionPlannerName']) ? $searchParam['regionPlannerName'] : '';
        $active = isset($searchParam['active']) ? $searchParam['active'] : '';
        $regionPlannerId = isset($searchParam['regionPlannerId']) ? $searchParam['regionPlannerId'] : '';

        if ($regionPlannerId != '') {
            $sql = $sql . 'AND "regionPlannerId"::text LIKE :regionPlannerId ';
        }

        if ($regionPlannerName != '') {
            $sql = $sql . 'AND "regionPlannerName" LIKE :regionPlannerName ';
        }

        if ($active != '') {
            $sql = $sql . ' AND "active" LIKE :active ';
        }

        //$sth = $database->prepare($sql);
        $sth = Yii::app()->db->createCommand($sql);

        if ($regionPlannerId != '') {
            $regionPlannerId = "%" . $regionPlannerId . "%";
            $sth->bindParam(':regionPlannerId', $regionPlannerId);

        }

        if ($regionPlannerName != '') {
            $regionPlannerName = "%" . $regionPlannerName . "%";
            $sth->bindParam(':regionPlannerName', $regionPlannerName);
        }

        if ($active != '') {
            $active = "%" . $active . "%";
            $sth->bindParam(':active', $active);
        }

        /*
        $result= $sth->execute();
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
public function GetRegionPlannerRecordCount()
{

    try {
        $sql = 'SELECT count(1) FROM "TblRegionPlanner"';
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

public function GetRegionPlannerSearchByPage($searchParam, $start, $length, $orderByStr)
{

    //$sqlMid = 'SELECT TOP ' . (int) ($length + $start) . ' * ';

    //$sqlBase = 'SELECT TOP ' . (int) ($start) . ' regionPlannerId ';

    $sqlMid = 'SELECT * ';

    $sqlBase = 'SELECT "regionPlannerId" ';

    $sql1 = 'FROM "TblRegionPlanner" WHERE 1=1 ';

    $sql2 = 'FROM "TblRegionPlanner" WHERE 1=1 ';

    $regionPlannerId = isset($searchParam['regionPlannerId']) ? $searchParam['regionPlannerId'] : '';
    $regionPlannerName = isset($searchParam['regionPlannerName']) ? $searchParam['regionPlannerName'] : '';
    $active = isset($searchParam['active']) ? $searchParam['active'] : '';


    if ($regionPlannerId != '') {
        $sql1 = $sql1 . 'AND "regionPlannerId"::text LIKE :regionPlannerId1 ';
        $sql2 = $sql2 . 'AND "regionPlannerId"::text LIKE :regionPlannerId2 ';
    }
    if ($regionPlannerName != '') {
        $sql1 = $sql1 . 'AND "regionPlannerName" LIKE :regionPlannerName1 ';
        $sql2 = $sql2 . 'AND "regionPlannerName" LIKE :regionPlannerName2 ';
    }

    if ($active != '') {
        $sql1 = $sql1 . ' AND "active" LIKE :active1 ';
        $sql2 = $sql2 . ' AND "active" LIKE :active2 ';
    }

    if ($orderByStr != '') {

        $sql1 = $sql1 . " ORDER BY " . $orderByStr . ' ';
        $sql2 = $sql2 . " ORDER BY " . $orderByStr . ' ';
    }
    if ($start != 0) {
        $sqlFinal = 'SELECT * FROM (' . $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start) . ' ) AS A WHERE regionPlannerId NOT IN ( ' . $sqlBase . $sql2 . ' LIMIT ' . (int) ($start) . ') ';
    } else {
        $sqlFinal = $sqlMid . $sql1 . ' LIMIT ' . (int) ($length + $start);
    }

    try
    {
        //$sth = $database->prepare($sqlFinal);
        $sth = Yii::app()->db->createCommand($sqlFinal);

        if ($regionPlannerId != '') {
            $regionPlannerId = "%" . $regionPlannerId . "%";
            $sth->bindParam(':regionPlannerId1', $regionPlannerId);
            if ($start != 0) {
                $sth->bindParam(':regionPlannerId2', $regionPlannerId);
            }

        }
        if ($regionPlannerName != '') {
            $regionPlannerName = "%" . $regionPlannerName . "%";
            $sth->bindParam(':regionPlannerName1', $regionPlannerName);
            if ($start != 0) {
                $sth->bindParam(':regionPlannerName2', $regionPlannerName);
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
        $array = array();
        $List = array();
        //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $array['regionPlannerId'] = $row['regionPlannerId'];
            $array['regionPlannerName'] = Encoding::escapleAllCharacter($row['regionPlannerName']);  
            $array['region'] = $row['region'];
            $array['active'] = $row['active'];
            $array['createdBy'] = $row['createdBy'];
            $array['createdTime'] = $row['createdTime'];
            $array['lastUpdatedBy'] = $row['lastUpdatedBy'];
            $array['lastUpdatedTime'] = $row['lastUpdatedTime'];
            array_push($List, $array);

        }

    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }
    return $List;
}

public function getRegionPlannerById($id)
{

    try {
        $sql = 'SELECT * FROM "TblRegionPlanner" WHERE "regionPlannerId" =' . $id . ' ';
        //$result = $database->query($sql);
        $sth = Yii::app()->db->createCommand($sql);
        $result = $sth->queryAll();
        $List = array();
        //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        foreach($result as $row) { 
            $regionPlanner['regionPlannerId'] = $row['regionPlannerId'];
            $regionPlanner['regionPlannerName'] = Encoding::escapleAllCharacter($row['regionPlannerName']);  
            $regionPlanner['region'] = $row['region'];
            $regionPlanner['active'] = $row['active'];

        }
    } catch (PDOException $e) {
        echo "Exception " . $e->getMessage();
    }

    return $regionPlanner;
}
#endregion regionPlanner
}

