<?php
/**
 * CommonUtil.php
 * All common method will be in this common util. This util will act as component and init in the main.php
 */
class CommonUtil extends CApplicationComponent
{
    public $viewBag = array();
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
    public function getEditBtnRight()
    {
        $editRight = Yii::app()->formDao->getEditRight();
        $userModel = Yii::app()->session['tblUserDo'];
        if (!($userModel['userId'] == $editRight['editRightUserId'] && $editRight['editRightOnUse'] = true)) {
            $disable = "disabled";
        } else {
            $disable = "";
        }
        return $disable;
    }
    public function getUser($userId)
    {
        $elementList = array();

        try {

            $sql = "SELECT  * FROM \"TblUser\" WHERE \"userId\" = :userId";
            //$stmt = $database->prepare($sql);
            //$result= $stmt->execute(array($userId));

            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(':userId',$userId, PDO::PARAM_STR);
            $row = $command->queryRow();

            /*
            if(!$result){
				throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
				
			}
            */
            //$result = $database->query($sql);
            //$row = $stmt->fetch(PDO::FETCH_ASSOC);
                $elementList['userId'] = $row['userId'];
                $elementList['loginId'] = $row['loginId'];
                $elementList['password'] = $row['password'];
                $elementList['roleId'] = $row['roleId'];
                $elementList['status'] = 'Success';
            

        } catch (PDOException $e) {

            $elementList['status'] = $e->getMessage();

        }

        return $elementList;

    }
    public function GetDateAfterParaWorkingDay($startDate, $numberOfWorkingDay)
    {

        try {
            $year = date("Y", strtotime($startDate));
            $month = date("m", strtotime($startDate));
            $day = date("d", strtotime($startDate));
            $sql = 'SELECT * FROM "TblHoliday" where "holidayDate" > :thisYear ';
            //$stmt = $database->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);
            //$thisYear = $month . '/' . $day . '/' . $year;
            $thisYear = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year));
            $stmt->bindValue(':thisYear', $thisYear, PDO::PARAM_STR);
            /*
            $result = $stmt->execute();
            if (!$result) {
                throw new Exception($stmt->errorInfo()[2], $stmt->errorInfo()[1]);

            }
            */
            $result = $stmt->queryAll();

            $holidayList = [];
            //$result = $database->query($sql);
            //while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $list['holidayName'] = Encoding::escapleAllCharacter($row['holidayName']);  
                $list['holidayDate'] = date('Y-m-d', strtotime($row['holidayDate']));
                $list['holidayDescription'] = Encoding::escapleAllCharacter($row['holidayDescription']);  
                array_push($holidayList, $list);
            }
            $i = 0;
            $y = 1;

            while ($i < $numberOfWorkingDay) {
                $holidayFlag = 0;
                $nextDate = date('Y-m-d', strtotime($startDate . ' +' . $y . ' day'));
                $dayOfWeek = date('N', strtotime($nextDate));
                if ($dayOfWeek != 6 && $dayOfWeek != 7) { // Saturday =6 ; Sunday = 7;
                    foreach ($holidayList as $holiday) {
                        if ($nextDate == $holiday['holidayDate']) {
                            $holidayFlag = 1;

                        }
                    }
                    if ($holidayFlag != 1) {
                        $i++;
                        $endDate = $nextDate;
                    }
                }
                $y++;
            }
            return $endDate;
        } catch (PDOException $e) {

            $status = $e->getMessage();
            return $status;

        }

    }
    public function GetWorkingDayByStartDateAndEndDate($startDate, $endDate)
    {

        try {
            $year = date("Y", strtotime($startDate));
            $month = date("m", strtotime($startDate));
            $day = date("d", strtotime($startDate));
            $endYear = date("Y", strtotime($endDate));
            $endMonth = date("m", strtotime($endDate));
            $endDay = date("d", strtotime($endDate));
            $sql = "SELECT * FROM \"TblHoliday\" where \"holidayDate\" > :thisYear AND \"holidayDate\" <= :nextYear";
            //$stmt = $database->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);
            //$thisYear = $month . '/' . $day . '/' . $year;
            //$nextYear = $endMonth . '/' . $endDay . '/' . $endYear;
            $thisYear = date("Y-m-d H:i:s", mktime(0, 0, 0, $month, $day, $year));
            $nextYear = date("Y-m-d H:i:s", mktime(0, 0, 0, $endMonth, $endDay, $endYear));
            $stmt->bindValue(':thisYear', $thisYear, PDO::PARAM_STR);
            $stmt->bindValue(':nextYear', $nextYear, PDO::PARAM_STR);
            /*
            $result = $stmt->execute(array($thisYear, $nextYear));
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            */
            $holidayList = [];
            //$result = $database->query($sql);
            $result = $stmt->queryAll();
            //while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $list['holidayName'] = Encoding::escapleAllCharacter($row['holidayName']);  
                $list['holidayDate'] = date('Y-m-d', strtotime($row['holidayDate']));
                $list['holidayDescription'] = Encoding::escapleAllCharacter($row['holidayDescription']);  
                array_push($holidayList, $list);
            }
            $i = $startDate;
            $y = 1;
            $numberOfWorkingDay = 0;
            while ($i < $endDate) {
                $holidayFlag = 0;
                $i = date('Y-m-d', strtotime($i . ' +1 day'));
                $dayOfWeek = date('N', strtotime($i));
                if ($dayOfWeek != 6 && $dayOfWeek != 7) { // Saturday =6 ; Sunday = 7;
                    foreach ($holidayList as $holiday) {
                        if ($i == $holiday['holidayDate']) {
                            $holidayFlag = 1;

                        }
                    }
                    if ($holidayFlag != 1) {
                        $numberOfWorkingDay++;

                    }
                }

            }
            if ($startDate == $endDate){
                $numberOfWorkingDay = 1;
            }
            return $numberOfWorkingDay;
        } catch (PDOException $e) {

            $status = $e->getMessage();
            return $status;

        }

    }

    public function getHolidayCountByYear($year)
    {

        try {
            //$sql = "SELECT count(1) FROM TblHoliday WHERE holidayDate LIKE '%" . $year . "%' ";
            $sql = "SELECT count(1) FROM \"TblHoliday\" WHERE to_char(\"holidayDate\", 'YYYY') LIKE '%" . $year . "%' ";
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
    public function getConfigValueByConfigName($configName)
    {

        try {
            $sql = "SELECT * FROM \"TblConfig\" WHERE \"configName\" LIKE '%" . $configName . "%'";

            // $result = $database->query($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $result = $sth->queryAll();

            //while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['configId'] = $row['configId'];
                $array['configName'] = $row['configName'];
                $array['configValue'] = $row['configValue'];
                $array['configDescription'] = $row['configDescription'];

            }
        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }

        return $array;
    }
}
