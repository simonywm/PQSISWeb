<?php
require_once 'Encoding.php';
use \ForceUTF8\Encoding;

/**
 * CommonUtil.php
 * All common method will be in this common util. This util will act as component and init in the main.php
 */
class ReportDao extends CApplicationComponent
{
    private $generatedId = "";
#region caseFormChart

    public function getCaseFormReportChart1($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay)
    {

        //$startDate = "#" . $startDay . "/" . $startMonth . "/" . $startYear . "#";
        //$endDate = "#" . $endDay . "/" . $endMonth . "/" . $endYear . "#";
        $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $startMonth, $startDay, $startYear));
        $endDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $endMonth, $endDay, $endYear)); 

        try {
            
            $sql1 = 'SELECT (count(1)/12::decimal) as "lastYearAverageAmount" FROM "TblServiceCase" WHERE "startYear" = :lastYear ';

            //$sth = $database->prepare($sql1);
            $sth = Yii::app()->db->createCommand($sql1);

            $lastYear = ($endYear - 1);
            $sth->bindParam(':lastYear', $lastYear, PDO::PARAM_STR);
            /*
            $result = $sth->execute();
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            */
            //$row = $sth->fetch(PDO::FETCH_ASSOC);

            $row = $sth->queryRow();
            $lastYearAverageAmount = round($row['lastYearAverageAmount'], 1);

            $sql = "SELECT * FROM ( SELECT * FROM ( SELECT count(1) as \"thisYearAmount\", 'Jan' as \"startMonthName\", 1 as \"startMonth\"  FROM \"TblServiceCase\" WHERE (\"customerContactedDate\" >= :startDate AND \"startYear\" = :endYear1 AND \"startMonth\" = '1' ) UNION ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Feb' as \"startMonthName\",2 as \"startMonth\"  FROM \"TblServiceCase\" WHERE (\"customerContactedDate\" >= :startDate AND \"startYear\" = :endYear2 AND \"startMonth\" = '2' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Mar' as \"startMonthName\",3 as \"startMonth\"  FROM \"TblServiceCase\" WHERE (\"customerContactedDate\" >= :startDate AND \"startYear\" = :endYear3 AND \"startMonth\" = '3' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Apr' as \"startMonthName\",4 as \"startMonth\"  FROM \"TblServiceCase\" WHERE (\"customerContactedDate\" >= :startDate AND \"startYear\" = :endYear4 AND \"startMonth\" = '4' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'May' as \"startMonthName\",5 as \"startMonth\"  FROM \"TblServiceCase\" WHERE (\"customerContactedDate\" >= :startDate AND \"startYear\" = :endYear5 AND \"startMonth\" = '5' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Jun' as \"startMonthName\",6 as \"startMonth\"  FROM \"TblServiceCase\" WHERE (\"customerContactedDate\" >= :startDate AND \"startYear\" = :endYear6 AND \"startMonth\" = '6' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Jul' as \"startMonthName\",7 as \"startMonth\"  FROM \"TblServiceCase\" WHERE (\"customerContactedDate\" >= :startDate AND \"startYear\" = :endYear7 AND \"startMonth\" = '7' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Aug' as \"startMonthName\",8 as \"startMonth\"  FROM \"TblServiceCase\" WHERE (\"customerContactedDate\" >= :startDate AND \"startYear\" = :endYear8 AND \"startMonth\" = '8' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Sep' as \"startMonthName\",9 as \"startMonth\"  FROM \"TblServiceCase\" WHERE (\"customerContactedDate\" >= :startDate AND \"startYear\" = :endYear9 AND \"startMonth\" = '9' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Oct' as \"startMonthName\",10 as \"startMonth\"  FROM \"TblServiceCase\" WHERE (\"customerContactedDate\" >= :startDate AND \"startYear\" = :endYear10 AND \"startMonth\" = '10' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Nov' as \"startMonthName\",11 as \"startMonth\"  FROM \"TblServiceCase\" WHERE (\"customerContactedDate\" >= :startDate AND \"startYear\" = :endYear11 AND \"startMonth\" = '11' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Dec' as \"startMonthName\",12 as \"startMonth\"  FROM \"TblServiceCase\" WHERE (\"customerContactedDate\" >= :startDate AND \"startYear\" = :endYear12 AND \"startMonth\" = '12' ) ) as a) as b ORDER BY \"startMonth\"::NUMERIC ASC ";
            /* $sql=   "SELECT count(1) as amount,month
            FROM
            ( SELECT  SWITCH(serviceTypeId =3,Month(actualReportIssueDate), serviceTypeId = 4, Month(actualReportIssueDate),True,Month(serviceCompletionDate)) As month
            FROM TblServiceCase WHERE ((serviceTypeId = 3 OR serviceTypeId = 4) AND actualReportIssueDate >= $startDate AND actualReportIssueDate <= $endDate) OR ((serviceTypeId <>3 OR serviceTypeId <>4) AND serviceCompletionDate >= $startDate AND serviceCompletionDate <=$endDate)
            ) group by month";*/
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            $sth->bindParam(':endYear1', $endYear);
            $sth->bindParam(':endYear2', $endYear);
            $sth->bindParam(':endYear3', $endYear);
            $sth->bindParam(':endYear4', $endYear);
            $sth->bindParam(':endYear5', $endYear);
            $sth->bindParam(':endYear6', $endYear);
            $sth->bindParam(':endYear7', $endYear);
            $sth->bindParam(':endYear8', $endYear);
            $sth->bindParam(':endYear9', $endYear);
            $sth->bindParam(':endYear10', $endYear);
            $sth->bindParam(':endYear11', $endYear);
            $sth->bindParam(':endYear12', $endYear);
            $sth->bindParam(':startDate',$startDate, PDO::PARAM_STR);

            /*
            $result = $sth->execute();
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            */
            $result = $sth->queryAll();

            $caseFormList = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $caseForm['startMonth'] = $row['startMonthName'];
                $caseForm['thisYearAmount'] = $row['thisYearAmount'];
                $caseForm['lastYearAverageAmount'] = $lastYearAverageAmount;
                array_push($caseFormList, $caseForm);
            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $caseFormList;
    }
    public function getCaseFormReportChart2($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay)
    {

        //$startDate = "#" . $startDay . "/" . $startMonth . "/" . $startYear . "#";
        //$endDate = "#" . $endDay . "/" . $endMonth . "/" . $endYear . "#";
        $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $startMonth, $startDay, $startYear));
        $endDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $endMonth, $endDay, $endYear)); 

        try {
            $sql1 = 'SELECT (count(1)/12::decimal) as "lastYearAverageAmount" FROM "TblServiceCase" WHERE "countYear" = :lastYear ';

            //$sth = $database->prepare($sql1);
            $sth = Yii::app()->db->createCommand($sql1);
            $lastYear = ($endYear - 1);
            $sth->bindParam(':lastYear', $lastYear, PDO::PARAM_STR);
            /*
            $result = $sth->execute();
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            $row = $sth->fetch(PDO::FETCH_ASSOC);
            */
            $row = $sth->queryRow();
            $lastYearAverageAmount = round($row['lastYearAverageAmount'], 1);

            $sql = "SELECT * FROM ( SELECT count(1) as \"thisYearAmount\", 'Jan' as \"countMonthName\",1 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 3 or \"serviceTypeId\" = 4) AND \"countYear\" = :endYear1 AND \"countMonth\" = '1' ) UNION ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Feb' as \"countMonthName\",2 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 3 or \"serviceTypeId\" = 4) AND \"countYear\" = :endYear2 AND \"countMonth\" = '2' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Mar' as \"countMonthName\",3 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 3 or \"serviceTypeId\" = 4) AND \"countYear\" = :endYear3 AND \"countMonth\" = '3' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Apr' as \"countMonthName\",4 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 3 or \"serviceTypeId\" = 4) AND \"countYear\" = :endYear4 AND \"countMonth\" = '4' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'May' as \"countMonthName\",5 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 3 or \"serviceTypeId\" = 4) AND \"countYear\" = :endYear5 AND \"countMonth\" = '5' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Jun' as \"countMonthName\",6 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 3 or \"serviceTypeId\" = 4) AND \"countYear\" = :endYear6 AND \"countMonth\" = '6' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Jul' as \"countMonthName\",7 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 3 or \"serviceTypeId\" = 4) AND \"countYear\" = :endYear7 AND \"countMonth\" = '7' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Aug' as \"countMonthName\",8 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 3 or \"serviceTypeId\" = 4) AND \"countYear\" = :endYear8 AND \"countMonth\" = '8' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Sep' as \"countMonthName\",9 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 3 or \"serviceTypeId\" = 4) AND \"countYear\" = :endYear9 AND \"countMonth\" = '9' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Oct' as \"countMonthName\",10 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 3 or \"serviceTypeId\" = 4) AND \"countYear\" = :endYear10 AND \"countMonth\" = '10' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Nov' as \"countMonthName\",11 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 3 or \"serviceTypeId\" = 4) AND \"countYear\" = :endYear11 AND \"countMonth\" = '11' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Dec' as \"countMonthName\",12 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 3 or \"serviceTypeId\" = 4) AND \"countYear\" = :endYear12 AND \"countMonth\" = '12' ) ) as a ORDER BY \"countMonth\"::NUMERIC ASC ";
            /* $sql=   "SELECT count(1) as amount,month
            FROM
            ( SELECT  SWITCH(serviceTypeId =3,Month(actualReportIssueDate), serviceTypeId = 4, Month(actualReportIssueDate),True,Month(serviceCompletionDate)) As month
            FROM TblServiceCase WHERE ((serviceTypeId = 3 OR serviceTypeId = 4) AND actualReportIssueDate >= $startDate AND actualReportIssueDate <= $endDate) OR ((serviceTypeId <>3 OR serviceTypeId <>4) AND serviceCompletionDate >= $startDate AND serviceCompletionDate <=$endDate)
            ) group by month";*/
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            $sth->bindParam(':endYear1', $endYear);
            $sth->bindParam(':endYear2', $endYear);
            $sth->bindParam(':endYear3', $endYear);
            $sth->bindParam(':endYear4', $endYear);
            $sth->bindParam(':endYear5', $endYear);
            $sth->bindParam(':endYear6', $endYear);
            $sth->bindParam(':endYear7', $endYear);
            $sth->bindParam(':endYear8', $endYear);
            $sth->bindParam(':endYear9', $endYear);
            $sth->bindParam(':endYear10', $endYear);
            $sth->bindParam(':endYear11', $endYear);
            $sth->bindParam(':endYear12', $endYear);

            /*
            $result = $sth->execute();
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            */
            $result = $sth->queryAll();

            $caseFormList = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $caseForm['countMonth'] = $row['countMonthName'];
                $caseForm['thisYearAmount'] = $row['thisYearAmount'];
                $caseForm['lastYearAverageAmount'] = $lastYearAverageAmount;
                array_push($caseFormList, $caseForm);
            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $caseFormList;
    }

    public function getCaseFormReportChart3($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay)
    {

        //$startDate = "#" . $startDay . "/" . $startMonth . "/" . $startYear . "#";
        //$endDate = "#" . $endDay . "/" . $endMonth . "/" . $endYear . "#";
        $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $startMonth, $startDay, $startYear));
        $endDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $endMonth, $endDay, $endYear)); 

        try {
            $sql1 = 'SELECT (count(1)/12::decimal) as "lastYearAverageAmount" FROM "TblServiceCase" WHERE "countYear" = :lastYear ';

            //$sth = $database->prepare($sql1);
            $sth = Yii::app()->db->createCommand($sql1);
            $lastYear = ($endYear - 1);
            $sth->bindParam(':lastYear', $lastYear, PDO::PARAM_STR);
            /*
            $result = $sth->execute();
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            $row = $sth->fetch(PDO::FETCH_ASSOC);
            */
            $row = $sth->queryRow();
            $lastYearAverageAmount = round($row['lastYearAverageAmount'], 1);

            $sql = "SELECT * FROM ( SELECT count(1) as \"thisYearAmount\", 'Jan' as \"countMonthName\",1 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 5 or \"serviceTypeId\" = 6) AND \"countYear\" = :endYear1 AND \"countMonth\" = '1' ) UNION ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Feb' as \"countMonthName\",2 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 5 or \"serviceTypeId\" = 6) AND \"countYear\" = :endYear2 AND \"countMonth\" = '2' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Mar' as \"countMonthName\",3 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 5 or \"serviceTypeId\" = 6) AND \"countYear\" = :endYear3 AND \"countMonth\" = '3' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Apr' as \"countMonthName\",4 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 5 or \"serviceTypeId\" = 6) AND \"countYear\" = :endYear4 AND \"countMonth\" = '4' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'May' as \"countMonthName\",5 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 5 or \"serviceTypeId\" = 6) AND \"countYear\" = :endYear5 AND \"countMonth\" = '5' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Jun' as \"countMonthName\",6 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 5 or \"serviceTypeId\" = 6) AND \"countYear\" = :endYear6 AND \"countMonth\" = '6' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Jul' as \"countMonthName\",7 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 5 or \"serviceTypeId\" = 6) AND \"countYear\" = :endYear7 AND \"countMonth\" = '7' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Aug' as \"countMonthName\",8 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 5 or \"serviceTypeId\" = 6) AND \"countYear\" = :endYear8 AND \"countMonth\" = '8' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Sep' as \"countMonthName\",9 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 5 or \"serviceTypeId\" = 6) AND \"countYear\" = :endYear9 AND \"countMonth\" = '9' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Oct' as \"countMonthName\",10 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 5 or \"serviceTypeId\" = 6) AND \"countYear\" = :endYear10 AND \"countMonth\" = '10' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Nov' as \"countMonthName\",11 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 5 or \"serviceTypeId\" = 6) AND \"countYear\" = :endYear11 AND \"countMonth\" = '11' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Dec' as \"countMonthName\",12 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( (\"serviceTypeId\" = 5 or \"serviceTypeId\" = 6) AND \"countYear\" = :endYear12 AND \"countMonth\" = '12' ) ) as a ORDER BY \"countMonth\"::NUMERIC ASC ";
            /* $sql=   "SELECT count(1) as amount,month
            FROM
            ( SELECT  SWITCH(serviceTypeId =3,Month(actualReportIssueDate), serviceTypeId = 4, Month(actualReportIssueDate),True,Month(serviceCompletionDate)) As month
            FROM TblServiceCase WHERE ((serviceTypeId = 3 OR serviceTypeId = 4) AND actualReportIssueDate >= $startDate AND actualReportIssueDate <= $endDate) OR ((serviceTypeId <>3 OR serviceTypeId <>4) AND serviceCompletionDate >= $startDate AND serviceCompletionDate <=$endDate)
            ) group by month";*/
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            $sth->bindParam(':endYear1', $endYear);
            $sth->bindParam(':endYear2', $endYear);
            $sth->bindParam(':endYear3', $endYear);
            $sth->bindParam(':endYear4', $endYear);
            $sth->bindParam(':endYear5', $endYear);
            $sth->bindParam(':endYear6', $endYear);
            $sth->bindParam(':endYear7', $endYear);
            $sth->bindParam(':endYear8', $endYear);
            $sth->bindParam(':endYear9', $endYear);
            $sth->bindParam(':endYear10', $endYear);
            $sth->bindParam(':endYear11', $endYear);
            $sth->bindParam(':endYear12', $endYear);

            /*
            $result = $sth->execute();
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            */
            $result = $sth->queryAll();

            $caseFormList = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $caseForm['countMonth'] = $row['countMonthName'];
                $caseForm['thisYearAmount'] = $row['thisYearAmount'];
                $caseForm['lastYearAverageAmount'] = $lastYearAverageAmount;
                array_push($caseFormList, $caseForm);
            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $caseFormList;
    }

    public function getCaseFormReportChart4($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay)
    {

        //$startDate = "#" . $startDay . "/" . $startMonth . "/" . $startYear . "#";
        //$endDate = "#" . $endDay . "/" . $endMonth . "/" . $endYear . "#";
        $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $startMonth, $startDay, $startYear));
        $endDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $endMonth, $endDay, $endYear)); 

        try {
            $sql1 = 'SELECT (count(1)/12::decimal) as "lastYearAverageAmount" FROM "TblServiceCase" WHERE "countYear" = :lastYear ';

            //$sth = $database->prepare($sql1);
            $sth = Yii::app()->db->createCommand($sql1);
            $lastYear = ($endYear - 1);
            $sth->bindParam(':lastYear', $lastYear, PDO::PARAM_STR);
            /*
            $result = $sth->execute();
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            $row = $sth->fetch(PDO::FETCH_ASSOC);
            */
            $row = $sth->queryRow();
            $lastYearAverageAmount = round($row['lastYearAverageAmount'], 1);

            $sql = "SELECT * FROM ( SELECT count(1) as \"thisYearAmount\", 'Jan' as \"countMonthName\",1 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( \"serviceTypeId\"=1 AND \"countYear\" = :endYear1 AND \"countMonth\" = '1' ) UNION ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Feb' as \"countMonthName\",2 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( \"serviceTypeId\"=1 AND \"countYear\" = :endYear2 AND \"countMonth\" = '2' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Mar' as \"countMonthName\",3 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( \"serviceTypeId\"=1 AND \"countYear\" = :endYear3 AND \"countMonth\" = '3' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Apr' as \"countMonthName\",4 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( \"serviceTypeId\"=1 AND \"countYear\" = :endYear4 AND \"countMonth\" = '4' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'May' as \"countMonthName\",5 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( \"serviceTypeId\"=1 AND \"countYear\" = :endYear5 AND \"countMonth\" = '5' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Jun' as \"countMonthName\",6 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( \"serviceTypeId\"=1 AND \"countYear\" = :endYear6 AND \"countMonth\" = '6' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Jul' as \"countMonthName\",7 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( \"serviceTypeId\"=1 AND \"countYear\" = :endYear7 AND \"countMonth\" = '7' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Aug' as \"countMonthName\",8 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( \"serviceTypeId\"=1 AND \"countYear\" = :endYear8 AND \"countMonth\" = '8' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Sep' as \"countMonthName\",9 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( \"serviceTypeId\"=1 AND \"countYear\" = :endYear9 AND \"countMonth\" = '9' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Oct' as \"countMonthName\",10 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( \"serviceTypeId\"=1 AND \"countYear\" = :endYear10 AND \"countMonth\" = '10' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Nov' as \"countMonthName\",11 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( \"serviceTypeId\"=1 AND \"countYear\" = :endYear11 AND \"countMonth\" = '11' ) UNION  ";
            $sql = $sql . "SELECT count(1) as \"thisYearAmount\", 'Dec' as \"countMonthName\",12 as \"countMonth\"  FROM \"TblServiceCase\" WHERE ( \"serviceTypeId\"=1 AND \"countYear\" = :endYear12 AND \"countMonth\" = '12' ) ) as a ORDER BY \"countMonth\"::NUMERIC ASC ";
            /* $sql=   "SELECT count(1) as amount,month
            FROM
            ( SELECT  SWITCH(serviceTypeId =3,Month(actualReportIssueDate), serviceTypeId = 4, Month(actualReportIssueDate),True,Month(serviceCompletionDate)) As month
            FROM TblServiceCase WHERE ((serviceTypeId = 3 OR serviceTypeId = 4) AND actualReportIssueDate >= $startDate AND actualReportIssueDate <= $endDate) OR ((serviceTypeId <>3 OR serviceTypeId <>4) AND serviceCompletionDate >= $startDate AND serviceCompletionDate <=$endDate)
            ) group by month";*/
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            $sth->bindParam(':endYear1', $endYear);
            $sth->bindParam(':endYear2', $endYear);
            $sth->bindParam(':endYear3', $endYear);
            $sth->bindParam(':endYear4', $endYear);
            $sth->bindParam(':endYear5', $endYear);
            $sth->bindParam(':endYear6', $endYear);
            $sth->bindParam(':endYear7', $endYear);
            $sth->bindParam(':endYear8', $endYear);
            $sth->bindParam(':endYear9', $endYear);
            $sth->bindParam(':endYear10', $endYear);
            $sth->bindParam(':endYear11', $endYear);
            $sth->bindParam(':endYear12', $endYear);

            /*
            $result = $sth->execute();
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            */
            $result = $sth->queryAll();

            $caseFormList = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $caseForm['countMonth'] = $row['countMonthName'];
                $caseForm['thisYearAmount'] = $row['thisYearAmount'];
                $caseForm['lastYearAverageAmount'] = $lastYearAverageAmount;
                array_push($caseFormList, $caseForm);
            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $caseFormList;
    }
    public function getCaseFormReportChart5($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay) //satisfactory Index

    {

        //$startDate = "#" . $startDay . "/" . $startMonth . "/" . $startYear . "#";
        //$endDate = "#" . $endDay . "/" . $endMonth . "/" . $endYear . "#";
        $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $startMonth, $startDay, $startYear));
        $endDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $endMonth, $endDay, $endYear)); 

        try {
            $sql = "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) as \"lastYearAverageAmount\" FROM \"TblServiceCase\" WHERE \"serviceTypeId\" = 16 AND \"countYear\" = :endYear";
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            $sth->bindParam(':endYear', $endYear, PDO::PARAM_STR);
            /*
            $result = $sth->execute();
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            $row = $sth->fetch(PDO::FETCH_ASSOC);
            */
            $row = $sth->queryRow();
            $lastYearAverageAmount = round($row['lastYearAverageAmount'], 1);

            $sql = " SELECT * FROM ( SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Jan' as \"countMonthName\",1 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 16 AND \"countYear\" = :endYear1 AND \"countMonth\" = '1' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Feb' as \"countMonthName\",2 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 16 AND \"countYear\" = :endYear2 AND \"countMonth\" = '2' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Mar' as \"countMonthName\",3 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 16 AND \"countYear\" = :endYear3 AND \"countMonth\" = '3' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Apr' as \"countMonthName\",4 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 16 AND \"countYear\" = :endYear4 AND \"countMonth\" = '4' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'May' as \"countMonthName\",5 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 16 AND \"countYear\" = :endYear5 AND \"countMonth\" = '5' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Jun' as \"countMonthName\",6 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 16 AND \"countYear\" = :endYear6 AND \"countMonth\" = '6' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Jul' as \"countMonthName\",7 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 16 AND \"countYear\" = :endYear7 AND \"countMonth\" = '7' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Aug' as \"countMonthName\",8 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 16 AND \"countYear\" = :endYear8 AND \"countMonth\" = '8' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Sep' as \"countMonthName\",9 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 16 AND \"countYear\" = :endYear9 AND \"countMonth\" = '9' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Oct' as \"countMonthName\",10 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 16 AND \"countYear\" = :endYear10 AND \"countMonth\" = '10' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Nov' as \"countMonthName\",11 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 16 AND \"countYear\" = :endYear11 AND \"countMonth\" = '11' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Dec' as \"countMonthName\",12 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 16 AND \"countYear\" = :endYear12 AND \"countMonth\" = '12'  ) as a ORDER BY \"countMonth\"::NUMERIC ASC";

            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            $sth->bindParam(':endYear1', $endYear);
            $sth->bindParam(':endYear2', $endYear);
            $sth->bindParam(':endYear3', $endYear);
            $sth->bindParam(':endYear4', $endYear);
            $sth->bindParam(':endYear5', $endYear);
            $sth->bindParam(':endYear6', $endYear);
            $sth->bindParam(':endYear7', $endYear);
            $sth->bindParam(':endYear8', $endYear);
            $sth->bindParam(':endYear9', $endYear);
            $sth->bindParam(':endYear10', $endYear);
            $sth->bindParam(':endYear11', $endYear);
            $sth->bindParam(':endYear12', $endYear);

            /*
            $result = $sth->execute();
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            */
            $result = $sth->queryAll();

            $caseFormList = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $caseForm['countMonth'] = $row['countMonthName'];
                $caseForm['thisYearAmount'] = $row['thisYearAmount'];
                $caseForm['lastYearAverage'] = $lastYearAverageAmount;
                array_push($caseFormList, $caseForm);
            }
            $caseForm['countMonth'] = 'Target';
            $caseForm['thisYearAmount'] = '0.95';
            $caseForm['lastYearAverage'] = $lastYearAverageAmount;
            array_push($caseFormList, $caseForm);

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $caseFormList;
    }
    public function getCaseFormReportChart6($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay) //satisfactory Index

    {

        //$startDate = "#" . $startDay . "/" . $startMonth . "/" . $startYear . "#";
        //$endDate = "#" . $endDay . "/" . $endMonth . "/" . $endYear . "#";
        $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $startMonth, $startDay, $startYear));
        $endDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $endMonth, $endDay, $endYear)); 

        try {
            $sql = "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) as \"lastYearAverageAmount\" FROM \"TblServiceCase\" WHERE \"serviceTypeId\" = 1 AND \"countYear\" = :endYear";
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            $sth->bindParam(':endYear', $endYear, PDO::PARAM_STR);
            /*
            $result = $sth->execute();
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            $row = $sth->fetch(PDO::FETCH_ASSOC);
            */
            $row = $sth->queryRow();
            $lastYearAverageAmount = round($row['lastYearAverageAmount'], 1);

            $sql = " SELECT * FROM ( SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Jan' as \"countMonthName\",1 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 1 AND \"countYear\" = :endYear1 AND \"countMonth\" = '1' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Feb' as \"countMonthName\",2 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 1 AND \"countYear\" = :endYear2 AND \"countMonth\" = '2' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Mar' as \"countMonthName\",3 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 1 AND \"countYear\" = :endYear3 AND \"countMonth\" = '3' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Apr' as \"countMonthName\",4 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 1 AND \"countYear\" = :endYear4 AND \"countMonth\" = '4' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'May' as \"countMonthName\",5 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 1 AND \"countYear\" = :endYear5 AND \"countMonth\" = '5' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Jun' as \"countMonthName\",6 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 1 AND \"countYear\" = :endYear6 AND \"countMonth\" = '6' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Jul' as \"countMonthName\",7 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 1 AND \"countYear\" = :endYear7 AND \"countMonth\" = '7' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Aug' as \"countMonthName\",8 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 1 AND \"countYear\" = :endYear8 AND \"countMonth\" = '8' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Sep' as \"countMonthName\",9 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 1 AND \"countYear\" = :endYear9 AND \"countMonth\" = '9' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Oct' as \"countMonthName\",10 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 1 AND \"countYear\" = :endYear10 AND \"countMonth\" = '10' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Nov' as \"countMonthName\",11 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 1 AND \"countYear\" = :endYear11 AND \"countMonth\" = '11' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Dec' as \"countMonthName\",12 as \"countMonth\"   From \"TblServiceCase\" WHERE \"serviceTypeId\" = 1 AND \"countYear\" = :endYear12 AND \"countMonth\" = '12'  ) as a ORDER BY \"countMonth\"::NUMERIC ASC";
            
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            $sth->bindParam(':endYear1', $endYear);
            $sth->bindParam(':endYear2', $endYear);
            $sth->bindParam(':endYear3', $endYear);
            $sth->bindParam(':endYear4', $endYear);
            $sth->bindParam(':endYear5', $endYear);
            $sth->bindParam(':endYear6', $endYear);
            $sth->bindParam(':endYear7', $endYear);
            $sth->bindParam(':endYear8', $endYear);
            $sth->bindParam(':endYear9', $endYear);
            $sth->bindParam(':endYear10', $endYear);
            $sth->bindParam(':endYear11', $endYear);
            $sth->bindParam(':endYear12', $endYear);

            /*
            $result = $sth->execute();
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            */
            $result = $sth->queryAll();

            $caseFormList = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $caseForm['countMonth'] = $row['countMonthName'];
                $caseForm['thisYearAmount'] = $row['thisYearAmount'];
                $caseForm['lastYearAverage'] = $lastYearAverageAmount;
                array_push($caseFormList, $caseForm);
            }
            $caseForm['countMonth'] = 'Target';
            $caseForm['thisYearAmount'] = '0.95';
            $caseForm['lastYearAverage'] = $lastYearAverageAmount;
            array_push($caseFormList, $caseForm);

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $caseFormList;
    }

    public function getCaseFormReportChart7($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay) //satisfactory Index

    {

        //$startDate = "#" . $startDay . "/" . $startMonth . "/" . $startYear . "#";
        //$endDate = "#" . $endDay . "/" . $endMonth . "/" . $endYear . "#";
        $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $startMonth, $startDay, $startYear));
        $endDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $endMonth, $endDay, $endYear)); 

        try {
            $sql = "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEn 1 ELSE 0 END))/(count(1)::decimal)) as \"lastYearAverageAmount\" FROM \"TblServiceCase\" WHERE ( \"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"countYear\" = :endYear";
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $sth->bindParam(':endYear', $endYear, PDO::PARAM_STR);
            /*
            $result = $sth->execute();
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            $row = $sth->fetch(PDO::FETCH_ASSOC);
            */
            $row = $sth->queryRow();
            $lastYearAverageAmount = round($row['lastYearAverageAmount'], 1);

            $sql = " SELECT * FROM ( SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Jan' as \"countMonthName\",1 as \"countMonth\"   From \"TblServiceCase\" WHERE (\"serviceTypeId\" = 3 OR \"serviceTypeId\" =4 ) AND \"countYear\" = :endYear1 AND \"countMonth\" = '1' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Feb' as \"countMonthName\",2 as \"countMonth\"   From \"TblServiceCase\" WHERE (\"serviceTypeId\" = 3 OR \"serviceTypeId\" =4 ) AND \"countYear\" = :endYear2 AND \"countMonth\" = '2' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Mar' as \"countMonthName\",3 as \"countMonth\"   From \"TblServiceCase\" WHERE (\"serviceTypeId\" = 3 OR \"serviceTypeId\" =4 ) AND \"countYear\" = :endYear3 AND \"countMonth\" = '3' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Apr' as \"countMonthName\",4 as \"countMonth\"   From \"TblServiceCase\" WHERE (\"serviceTypeId\" = 3 OR \"serviceTypeId\" =4 ) AND \"countYear\" = :endYear4 AND \"countMonth\" = '4' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'May' as \"countMonthName\",5 as \"countMonth\"   From \"TblServiceCase\" WHERE (\"serviceTypeId\" = 3 OR \"serviceTypeId\" =4 ) AND \"countYear\" = :endYear5 AND \"countMonth\" = '5' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Jun' as \"countMonthName\",6 as \"countMonth\"   From \"TblServiceCase\" WHERE (\"serviceTypeId\" = 3 OR \"serviceTypeId\" =4 ) AND \"countYear\" = :endYear6 AND \"countMonth\" = '6' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Jul' as \"countMonthName\",7 as \"countMonth\"   From \"TblServiceCase\" WHERE (\"serviceTypeId\" = 3 OR \"serviceTypeId\" =4 ) AND \"countYear\" = :endYear7 AND \"countMonth\" = '7' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Aug' as \"countMonthName\",8 as \"countMonth\"   From \"TblServiceCase\" WHERE (\"serviceTypeId\" = 3 OR \"serviceTypeId\" =4 ) AND \"countYear\" = :endYear8 AND \"countMonth\" = '8' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Sep' as \"countMonthName\",9 as \"countMonth\"   From \"TblServiceCase\" WHERE (\"serviceTypeId\" = 3 OR \"serviceTypeId\" =4 ) AND \"countYear\" = :endYear9 AND \"countMonth\" = '9' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Oct' as \"countMonthName\",10 as \"countMonth\"   From \"TblServiceCase\" WHERE (\"serviceTypeId\" = 3 OR \"serviceTypeId\" =4 ) AND \"countYear\" = :endYear10 AND \"countMonth\" = '10' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Nov' as \"countMonthName\",11 as \"countMonth\"   From \"TblServiceCase\" WHERE (\"serviceTypeId\" = 3 OR \"serviceTypeId\" =4 ) AND \"countYear\" = :endYear11 AND \"countMonth\" = '11' UNION ";
            $sql = $sql . "SELECT ((SUM(CASE WHEN \"completedBeforeTargetDate\" = 'Y' THEN 1 ELSE 0 END))/(count(1)::decimal)) As \"thisYearAmount\" , 'Dec' as \"countMonthName\",12 as \"countMonth\"   From \"TblServiceCase\" WHERE (\"serviceTypeId\" = 3 OR \"serviceTypeId\" =4 ) AND \"countYear\" = :endYear12 AND \"countMonth\" = '12'  ) as a ORDER BY \"countMonth\"::NUMERIC ASC";
            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            $sth->bindParam(':endYear1', $endYear);
            $sth->bindParam(':endYear2', $endYear);
            $sth->bindParam(':endYear3', $endYear);
            $sth->bindParam(':endYear4', $endYear);
            $sth->bindParam(':endYear5', $endYear);
            $sth->bindParam(':endYear6', $endYear);
            $sth->bindParam(':endYear7', $endYear);
            $sth->bindParam(':endYear8', $endYear);
            $sth->bindParam(':endYear9', $endYear);
            $sth->bindParam(':endYear10', $endYear);
            $sth->bindParam(':endYear11', $endYear);
            $sth->bindParam(':endYear12', $endYear);

            /*
            $result = $sth->execute();
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            */
            $result = $sth->queryAll();

            $caseFormList = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $caseForm['countMonth'] = $row['countMonthName'];
                $caseForm['thisYearAmount'] = $row['thisYearAmount'];
                $caseForm['lastYearAverage'] = $lastYearAverageAmount;
                array_push($caseFormList, $caseForm);
            }
            $caseForm['countMonth'] = 'Target';
            $caseForm['thisYearAmount'] = '0.95';
            $caseForm['lastYearAverage'] = $lastYearAverageAmount;
            array_push($caseFormList, $caseForm);

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $caseFormList;
    }
    public function getBudgetActiveUnionForm($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay)
    {
        //$startDate = "#" . $startDay . "/" . $startMonth . "/" . $startYear . "#";
        //$endDate = "#" . $endDay . "/" . $endMonth . "/" . $endYear . "#";
        $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $startMonth, $startDay, $startYear));
        $endDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $endMonth, $endDay, $endYear)); 

        try {
            $sql = "SELECT bg.\"budgetId\", bg.\"partyToBeChargedId\", bg.\"costTypeId\", bg.\"budgetNumber\"
              , ct.\"serviceTypeId\", ct.\"unitCost\", ct.\"countYear\",st.\"serviceTypeName\"
              , st.\"showOrder\" as \"serviceTypeShowOrder\", pt.\"partyToBeChargedName\", pt.\"showOrder\" as \"partyToBeChargedShowOrder\"
            From ((( \"TblServiceType\" st LEFT JOIN \"TblCostType\" ct on ct.\"serviceTypeId\" = st.\"serviceTypeId\" )
            LEFT JOIN \"TblBudget\" bg on ct.\"costTypeId\" = bg.\"costTypeId\" )
            LEFT JOIN \"TblPartyToBeCharged\" pt on bg.\"partyToBeChargedId\" = pt.\"partyToBeChargedId\" )
            Where ct.\"serviceTypeId\" <> NULL AND bg.\"partyToBeChargedId\" <> NULL AND bg.\"costTypeId\" <> NULL AND ct.\"countYear\" = :endYear
            OR (bg.\"partyToBeChargedId\") IN
            ( SELECT Distinct \"partyToBeChargedId\"
            FROM \"TblServiceCase\" WHERE
               ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"actualReportIssueDate\" >= :startDate AND \"actualReportIssueDate\" <= :endDate)
            OR ((\"serviceTypeId\" <>3 OR \"serviceTypeId\" <>4 AND \"serviceTypeId\" <>2 AND \"serviceTypeId\" <> 6 ) AND \"serviceCompletionDate\" >= :startDate AND \"serviceCompletionDate\" <=:endDate)
            OR ((\"serviceTypeId\" = 2 OR \"serviceTypeId\"= 6) AND \"actualVisitDate\" >=:startDate AND \"actualVisitDate\" <=:endDate)
            OR ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"actualReportIssueDate\" is NULL AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)
            OR ((\"serviceTypeId\" <>3 OR \"serviceTypeId\" <>4 AND \"serviceTypeId\" <>2 AND \"serviceTypeId\" <> 6 ) AND \"serviceCompletionDate\" is NULL AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)
            OR ((\"serviceTypeId\" = 2 OR \"serviceTypeId\"= 6) AND \"actualVisitDate\" is NULL AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)
            OR ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)
            OR ((\"serviceTypeId\" <>3 OR \"serviceTypeId\" <>4 AND \"serviceTypeId\" <>2 AND \"serviceTypeId\" <> 6 ) AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)
            OR ((\"serviceTypeId\" = 2 OR \"serviceTypeId\"= 6) AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)
            OR \"active\" ='Y')
            OR (bg.\"costTypeId\") IN
             ( SELECT Distinct \"serviceTypeId\"
            FROM \"TblServiceCase\" WHERE
               ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"actualReportIssueDate\" >= :startDate AND \"actualReportIssueDate\" <= :endDate)
            OR ((\"serviceTypeId\" <>3 AND \"serviceTypeId\" <>4 AND \"serviceTypeId\" <>2 AND \"serviceTypeId\" <> 6 ) AND \"serviceCompletionDate\" >= :startDate AND \"serviceCompletionDate\" <=:endDate)
            OR ((\"serviceTypeId\" = 2 OR \"serviceTypeId\"= 6) AND \"actualVisitDate\" >=:startDate AND \"actualVisitDate\" <=:endDate)
            OR ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"actualReportIssueDate\" is NULL AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)
            OR ((\"serviceTypeId\" <>3 AND \"serviceTypeId\" <>4 AND \"serviceTypeId\" <>2 AND \"serviceTypeId\" <> 6 ) AND \"serviceCompletionDate\" is NULL AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)
            OR ((\"serviceTypeId\" = 2 OR \"serviceTypeId\"= 6) AND \"actualVisitDate\" is NULL AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)
            OR ((\"serviceTypeId\" = 3 OR \"serviceTypeId\" = 4) AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)
            OR ((\"serviceTypeId\" <>3 AND \"serviceTypeId\" <>4 AND \"serviceTypeId\" <>2 AND \"serviceTypeId\" <> 6 ) AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)
            OR ((\"serviceTypeId\" = 2 OR \"serviceTypeId\"= 6) AND \"requestDate\" >= :startDate AND \"requestDate\" <= :endDate)
            OR \"active\"='Y')
            ORDER BY st.\"showOrder\"::NUMERIC ASC, pt.\"showOrder\"::NUMERIC ASC";

            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);
            $sth->bindParam(':endYear', $endYear, PDO::PARAM_STR);
            $sth->bindParam(':startDate',$startDate, PDO::PARAM_STR);
            $sth->bindParam(':endDate',$endDate, PDO::PARAM_STR);

            /*
            $result = $sth->execute();
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            */
            $result = $sth->queryAll();

            $List = array();
            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 
                $array['budgetId'] = $row['budgetId'];
                $array['serviceTypeId'] = $row['serviceTypeId'];
                $array['serviceTypeName'] = Encoding::escapleAllCharacter($row['serviceTypeName']);
                $array['partyToBeChargedId'] = $row['partyToBeChargedId'];
                $array['partyToBeChargedName'] = Encoding::escapleAllCharacter($row['partyToBeChargedName']);
                $array['unitCost'] = $row['unitCost'];
                $array['budgetNumber'] = $row['budgetNumber'];
                $array['countYear'] = $row['countYear'];
                $array['costTypeId'] = $row['costTypeId'];
                $array['serviceTypeShowOrder'] = $row['serviceTypeShowOrder'];
                $array['partyToBeChargedShowOrder'] = $row['partyToBeChargedShowOrder'];
                array_push($List, $array);
            }

        } catch (Exception $e) {
            echo "Exception " . $e->getMessage();
        }
        return $List;
    }
    #endregion CaseFormChart
    #region planningAhead
    public function getPlanningAheadByDateRangeForReplySlip($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay)
    {
        //$startDate = "#" . $startDay . "/" . $startMonth . "/" . $startYear . "#";
        //$endDate = "#" . $endDay . "/" . $endMonth . "/" . $endYear . "#";
        $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $startMonth, $startDay, $startYear));
        $endDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $endMonth, $endDay, $endYear)); 

        try {
         $sql = " SELECT  pa.*, bt.\"buildingTypeName\", pt.\"projectTypeName\", cc.\"consultantCompanyName\", ct.\"consultantName\", rp.\"regionPlannerName\", rsrg.\"replySlipReturnGradeName\"
         FROM \"TblPlanningAhead\" pa
         LEFT JOIN \"TblBuildingType\" bt on pa.\"buildingTypeId\" = bt.\"buildingTypeId\" 
         LEFT JOIN \"TblProjectType\" pt on pa.\"projectTypeId\" = pt.\"projectTypeId\" 
         LEFT JOIN \"TblConsultantCompany\" cc on pa.\"consultantCompanyNameId\" = cc.\"consultantCompanyId\" 
         LEFT JOIN \"TblConsultant\" ct on pa.\"consultantNameId\" = ct.\"consultantId\" 
         LEFT JOIN \"TblRegionPlanner\" rp on pa.\"regionPlannerId\" = rp.\"regionPlannerId\" 
         LEFT JOIN \"TblReplySlipReturnGrade\" rsrg on pa.\"replySlipGradeId\" = rsrg.\"replySlipReturnGradeId\" 
         WHERE  (( \"invitationToPaMeetingDate\" is not null and \"invitationToPaMeetingDate\" + interval '30 day' >= :startDate and \"invitationToPaMeetingDate\" + interval '30 day' <= :endDate )
         OR ( \"invitationToPaMeetingDate\" is null and \"inputDate\" is not null and \"inputDate\" + interval '30 day' >= :startDate and \"inputDate\" + interval '30 day' <= :endDate ))
         AND \"replySlipReturnLink\" is null
         ORDER BY \"planningAheadId\" desc ";
            /*pa.replySlipSentDate>= startDate1 and pa.replySlipSentDate <=endDate1  and pa.replySlipReturnLink */
            //$sth = $database->prepare($sql);

            $sth = Yii::app()->db->createCommand($sql);
            $sth->bindParam(':startDate',$startDate, PDO::PARAM_STR);
            $sth->bindParam(':endDate',$endDate, PDO::PARAM_STR);

            /*
            $result = $sth->execute();
            if (!$result) {
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
                $List['projectTitle'] = Encoding::escapleAllCharacter($row['projectTitle']);
                $List['schemeNumber'] = $row['schemeNumber'];
                $List['projectRegion'] = Encoding::escapleAllCharacter($row['projectRegion']);
                $List['projectAddress'] = Encoding::escapleAllCharacter($row['projectAddress']);
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
                $List['bms'] = $row['bms'];
                $List['changeoverScheme'] = $row['changeoverScheme'];
                $List['chillerPlant'] = $row['chillerPlant'];
                $List['escalator'] = $row['escalator'];
                $List['hidLamp'] = $row['hidLamp'];
                $List['lift'] = $row['lift'];
                $List['sensitiveMachine'] = $row['sensitiveMachine'];
                $List['telcom'] = $row['telcom'];
                $List['acbTripping'] = $row['acbTripping'];
                $List['buildingWithHighPenetrationEquipment'] = $row['buildingWithHighPenetrationEquipment'];
                $List['re'] = $row['re'];
                $List['ev'] = $row['ev'];
                /*  $List['criticalEquipment1'] = $row['criticalEquipment1'];
                $List['criticalEquipment2'] = $row['criticalEquipment2'];
                $List['criticalEquipment3'] = $row['criticalEquipment3'];
                $List['criticalEquipment4'] = $row['criticalEquipment4'];
                $List['criticalEquipment5'] = $row['criticalEquipment5'];*/
                $List['estimatedLoad'] = $row['estimatedLoad'];
                $List['pqisNumber'] = $row['pqisNumber'];
                //pqwalk
                $List['pqSiteWalkProjectRegion'] = Encoding::escapleAllCharacter($row['pqSiteWalkProjectRegion']);
                $List['pqSiteWalkProjectAddress'] = Encoding::escapleAllCharacter($row['pqSiteWalkProjectAddress']);
                $List['sensitiveEquipment'] = Encoding::escapleAllCharacter($row['sensitiveEquipment']);
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
                $List['consultantInformationRemark'] = Encoding::escapleAllCharacter($row['consultantInformationRemark']);
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
                $List['findingsFromReplySlip'] = Encoding::escapleAllCharacter($row['findingsFromReplySlip']);
                $List['replySlipfollowUpActionFlag'] = $row['replySlipfollowUpActionFlag'];
                $List['replySlipfollowUpAction'] = Encoding::escapleAllCharacter($row['replySlipfollowUpAction']);
                $List['replySlipRemark'] = Encoding::escapleAllCharacter($row['replySlipRemark']);
                //reply slip reply slip
                $List['replySlipSendLink'] = $row['replySlipSendLink'];
                $List['replySlipReturnLink'] = $row['replySlipReturnLink'];
                $List['replySlipGradeId'] = $row['replySlipGradeId'];
                $List['dateOfRequestedForReturnReplySlip'] = isset($row['dateOfRequestedForReturnReplySlip']) ? date('Y-m-d', strtotime($row['dateOfRequestedForReturnReplySlip'])) : '';
                //additional
                $List['receiveComplaint'] = Encoding::escapleAllCharacter($row['receiveComplaint']);
                $List['followUpAction'] = Encoding::escapleAllCharacter($row['followUpAction']);
                $List['remark'] = Encoding::escapleAllCharacter($row['remark']);
                $List['active'] = $row['active'];

                $List['buildingTypeName'] = Encoding::escapleAllCharacter($row['buildingTypeName']);
                $List['projectTypeName'] = Encoding::escapleAllCharacter($row['projectTypeName']);
                $List['consultantCompanyName'] = Encoding::escapleAllCharacter($row['consultantCompanyName']);
                $List['consultantName'] = Encoding::escapleAllCharacter($row['consultantName']);
                $List['regionPlannerName'] = Encoding::escapleAllCharacter($row['regionPlannerName']);
                $List['replySlipGradeName'] = Encoding::escapleAllCharacter($row['replySlipReturnGradeName']);

                array_push($PlanningAheadList, $List);
            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $PlanningAheadList;
    }
    public function getPlanningAheadByDateRangeForSiteWalk($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay)
    {
        //$startDate = "#" . $startDay . "/" . $startMonth . "/" . $startYear . "#";
        //$endDate = "#" . $endDay . "/" . $endMonth . "/" . $endYear . "#";
        $startDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $startMonth, $startDay, $startYear));
        $endDate = date("Y-m-d H:i:s", mktime(0, 0, 0, $endMonth, $endDay, $endYear)); 

        try {
         $sql = " SELECT  pa.*, bt.\"buildingTypeName\", pt.\"projectTypeName\", cc.\"consultantCompanyName\", ct.\"consultantName\", rp.\"regionPlannerName\", rsrg.\"replySlipReturnGradeName\"
         FROM \"TblPlanningAhead\" pa
         LEFT JOIN \"TblBuildingType\" bt on pa.\"buildingTypeId\" = bt.\"buildingTypeId\" 
         LEFT JOIN \"TblProjectType\" pt on pa.\"projectTypeId\" = pt.\"projectTypeId\" 
         LEFT JOIN \"TblConsultantCompany\" cc on pa.\"consultantCompanyNameId\" = cc.\"consultantCompanyId\" 
         LEFT JOIN \"TblConsultant\" ct on pa.\"consultantNameId\" = ct.\"consultantId\" 
         LEFT JOIN \"TblRegionPlanner\" rp on pa.\"regionPlannerId\" = rp.\"regionPlannerId\" 
         LEFT JOIN \"TblReplySlipReturnGrade\" rsrg on pa.\"replySlipGradeId\" = rsrg.\"replySlipReturnGradeId\" 
         WHERE  (( \"invitationToPaMeetingDate\" is not null and \"invitationToPaMeetingDate\" + interval '660 day' >=:startDate and \"invitationToPaMeetingDate\" + interval '660 day' <= :endDate )
         or ( \"invitationToPaMeetingDate\" is null and \"inputDate\" is not null and \"inputDate\" + interval '660 day' >=:startDate and \"inputDate\" + interval '660 day' <= :endDate ))
         OR (( \"estimatedCommisioningDateByCustomer\" is not null and \"estimatedCommisioningDateByCustomer\" - interval '60 day' >=:startDate and \"estimatedCommisioningDateByCustomer\" - interval '60 day' <= :endDate )
         or ( \"estimatedCommisioningDateByCustomer\" is null and \"estimatedCommisioningDateByRegion\" is not null and \"estimatedCommisioningDateByCustomer\" - interval '60 day' >=:startDate and \"estimatedCommisioningDateByCustomer\" - interval '60 day' <= :endDate ))
         AND ( \"firstPqSiteWalkCustomerResponse\" <> 'Reject' or \"firstPqSiteWalkInvestigationStatus\" <> 'Pass' or \"secondPqSiteWalkCustomerResponse\" <> 'Reject' or \"secondPqSiteWalkRequestLetterDate\" is not null )
         ORDER BY \"planningAheadId\" desc ";
            /*pa.replySlipSentDate>= startDate1 and pa.replySlipSentDate <=endDate1  and pa.replySlipReturnLink */
            //$sth = $database->prepare($sql);

            $sth = Yii::app()->db->createCommand($sql);
            $sth->bindParam(':startDate',$startDate, PDO::PARAM_STR);
            $sth->bindParam(':endDate',$endDate, PDO::PARAM_STR);

            /*
            $result = $sth->execute();
            if (!$result) {
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
                $List['projectTitle'] = Encoding::escapleAllCharacter($row['projectTitle']);
                $List['schemeNumber'] = $row['schemeNumber'];
                $List['projectRegion'] = Encoding::escapleAllCharacter($row['projectRegion']);
                $List['projectAddress'] = Encoding::escapleAllCharacter($row['projectAddress']);
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
                $List['bms'] = $row['bms'];
                $List['changeoverScheme'] = $row['changeoverScheme'];
                $List['chillerPlant'] = $row['chillerPlant'];
                $List['escalator'] = $row['escalator'];
                $List['hidLamp'] = $row['hidLamp'];
                $List['lift'] = $row['lift'];
                $List['sensitiveMachine'] = $row['sensitiveMachine'];
                $List['telcom'] = $row['telcom'];
                $List['acbTripping'] = $row['acbTripping'];
                $List['buildingWithHighPenetrationEquipment'] = $row['buildingWithHighPenetrationEquipment'];
                $List['re'] = $row['re'];
                $List['ev'] = $row['ev'];
                /*  $List['criticalEquipment1'] = $row['criticalEquipment1'];
                $List['criticalEquipment2'] = $row['criticalEquipment2'];
                $List['criticalEquipment3'] = $row['criticalEquipment3'];
                $List['criticalEquipment4'] = $row['criticalEquipment4'];
                $List['criticalEquipment5'] = $row['criticalEquipment5'];*/
                $List['estimatedLoad'] = $row['estimatedLoad'];
                $List['pqisNumber'] = $row['pqisNumber'];
                //pqwalk
                $List['pqSiteWalkProjectRegion'] = Encoding::escapleAllCharacter($row['pqSiteWalkProjectRegion']);
                $List['pqSiteWalkProjectAddress'] = Encoding::escapleAllCharacter($row['pqSiteWalkProjectAddress']);
                $List['sensitiveEquipment'] = Encoding::escapleAllCharacter($row['sensitiveEquipment']);
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
                $List['consultantInformationRemark'] = Encoding::escapleAllCharacter($row['consultantInformationRemark']);
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
                $List['findingsFromReplySlip'] = Encoding::escapleAllCharacter($row['findingsFromReplySlip']);
                $List['replySlipfollowUpActionFlag'] = $row['replySlipfollowUpActionFlag'];
                $List['replySlipfollowUpAction'] = Encoding::escapleAllCharacter($row['replySlipfollowUpAction']);
                $List['replySlipRemark'] = Encoding::escapleAllCharacter($row['replySlipRemark']);
                //reply slip reply slip
                $List['replySlipSendLink'] = $row['replySlipSendLink'];
                $List['replySlipReturnLink'] = $row['replySlipReturnLink'];
                $List['replySlipGradeId'] = $row['replySlipGradeId'];
                $List['dateOfRequestedForReturnReplySlip'] = isset($row['dateOfRequestedForReturnReplySlip']) ? date('Y-m-d', strtotime($row['dateOfRequestedForReturnReplySlip'])) : '';
                //additional
                $List['receiveComplaint'] = Encoding::escapleAllCharacter($row['receiveComplaint']);
                $List['followUpAction'] = Encoding::escapleAllCharacter($row['followUpAction']);
                $List['remark'] = Encoding::escapleAllCharacter($row['remark']);
                $List['active'] = $row['active'];

                $List['buildingTypeName'] = Encoding::escapleAllCharacter($row['buildingTypeName']);
                $List['projectTypeName'] = Encoding::escapleAllCharacter($row['projectTypeName']);
                $List['consultantCompanyName'] = Encoding::escapleAllCharacter($row['consultantCompanyName']);
                $List['consultantName'] = Encoding::escapleAllCharacter($row['consultantName']);
                $List['regionPlannerName'] = Encoding::escapleAllCharacter($row['regionPlannerName']);
                $List['replySlipGradeName'] = Encoding::escapleAllCharacter($row['replySlipReturnGradeName']);

                array_push($PlanningAheadList, $List);
            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $PlanningAheadList;
    }

    public function getPlanningAheadReplySlipReturnRateChartByDateRange($startYear, $endYear)
    {
        $List = array();
        $PlanningAheadList = array();
        try {
            $sql = "SELECT * FROM ( ";
            for ($i = $startYear; $i <= $endYear; $i++) {
                $sql .= "SELECT SUM(CASE WHEN \"replySlipReturnLink\" is null THEN 0 ELSE 1 END)/count(*) AS \"returnRate\" , $i AS year FROM \"TblPlanningAhead\" WHERE (\"regionLetterIssueDate\" is not null and date_part('year',\"regionLetterIssueDate\") = $i ) ";
                if ($i != $endYear) {
                    $sql .= "UNION ";
                }

            }
            $sql .= ") as a ORDER BY \"year\"::NUMERIC ASC ";

            //$sth = $database->prepare($sql);
            $sth = Yii::app()->db->createCommand($sql);

            /*
            $result = $sth->execute();
            if (!$result) {
                throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);

            }
            */
            $result = $sth->queryAll();

            //while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            foreach($result as $row) { 

                $List['returnRate'] = $row['returnRate'];
                $List['year'] = $row['year'];

                array_push($PlanningAheadList, $List);
            }

        } catch (PDOException $e) {
            echo "Exception " . $e->getMessage();
        }
        return $PlanningAheadList;
    }
 
#endregion planningAhead
}
