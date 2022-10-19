<?php

class AccessControlFilter extends CFilter
{
    public $viewBag = array();
    protected function preFilter($filterChain)
    {
        $systemVersionPath = Yii::app()->params['system_version_path'];
        $latestVersionPath = Yii::app()->params['latest_version_path'];
        $file = fopen($latestVersionPath, "r");
        $latestVersion = 0;
        if ($file) {
            while (!feof($file)) {
                $lineText = fgets($file);
                if ((strpos($lineText, "version:")) !== false) {
                    $pos = strpos($lineText, ":");
                    $latestVersion = substr($lineText, $pos + 1);
                }
            }
            fclose($file);
        }
        $file = fopen($systemVersionPath, "r");
        $systemVersion = 0;
        if ($file) {
            while (!feof($file)) {
                $lineText = fgets($file);
                if ((strpos($lineText, "version:")) !== false) {
                    $pos = strpos($lineText, ":");
                    $systemVersion = substr($lineText, $pos + 1);
                }
            }
            fclose($file);
        }
        if ($latestVersion != 0 && $systemVersion != 0 && $latestVersion != $systemVersion) {
            Yii::app()->runController('Site/UpdateSystem');
            return false;
        }

        // check if user in session
        if (!isset(Yii::app()->session['tblUserDo'])) {
            Yii::app()->runController('Site/Landing');
            return false;
        } else {
            $editRight = Yii::app()->formDao->getEditRight();
            $userModel = Yii::app()->session['tblUserDo'];
            if (!($userModel['userId'] == $editRight['editRightUserId'] && $editRight['editRightOnUse'] = true)) {
                $userModel['editRight'] = false;
                Yii::app()->session['tblUserDo'] = $userModel;

            } else {
                $userModel['editRight'] = true;
                Yii::app()->session['tblUserDo'] = $userModel;
            }
        }

        //check db backup
        $fullDate = date("Y/m/d");
        $year = date("Y");
        $month = date("m");
        $d = date("d");
        /*
        $dbPath = Yii::app()->params['database_path'];
        $dbBackUpPath = Yii::app()->params['database_path_backup'];
        $fullPath = $dbBackUpPath . "\\" . $year . "\\" . $month;
        if (!file_exists($fullPath . "\\" . $year . $month . $d . ".mdb")) {

            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0777, true);
            }
            copy($dbPath, $fullPath . "\\" . $year . $month . $d . ".mdb");
        }
        */
        //check holiday insert
        $nextYearHolidayCheckingMonth = Yii::app()->commonUtil->getConfigValueByConfigName('nextYearHolidayCheckingMonth');
        $viewBag['thisYear'] = $year;
        $viewBag['nextYear'] = ($year + 1);
        $viewBag['thisYearHolidayFlag'] = "hidden";
        $viewBag['nextYearHolidayFlag'] = "hidden";
        $thisYearHolidayCount = Yii::app()->commonUtil->getHolidayCountByYear($year);
        if ($thisYearHolidayCount <= 0) {
            $viewBag['thisYearHolidayFlag'] = "";
        }
        if ($month == $nextYearHolidayCheckingMonth["configValue"]) {
            $nextYearHolidayCount = Yii::app()->commonUtil->getHolidayCountByYear(($year + 1));
            if ($thisYearHolidayCount <= 0) {
                $viewBag['nextYearHolidayFlag'] = "";
            }
        }
        Yii::app()->session['HolidayFlag'] = $viewBag;
        return true;
    }

    protected function postFilter($filterChain)
    {
        // logic being applied after the action is executed
    }
}
