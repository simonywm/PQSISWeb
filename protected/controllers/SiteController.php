<?php

class SiteController extends Controller
{
    public function filters()
    {
        return array(
            array(
                'application.filters.AccessControlFilter - AjaxLogin, Landing, UpdateSystem',
            ),
        );
    }
    public function actionAjaxGetCalWorkingDate(){
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        parse_str(parse_url($url, PHP_URL_QUERY), $param);
        $numberOfWorkingDay = $param['numberOfWorkingDay'];
        $retJson['status'] = 'OK';
        if ($_POST['txHolidayDate'] == '') {
            $holidayDate = null;
        } else {
            $holidayDate = trim($_POST['txHolidayDate']);
        }
        $endDate= Yii::app()->commonUtil->GetDateAfterParaWorkingDay($holidayDate,$numberOfWorkingDay);
        $retJson['Date']= $endDate;
        echo json_encode($retJson);
    }
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        Yii::app()->runController('FirstForm/Landing');
    }

    public function actionLanding()
    {
        $this->frame = "//layouts/main";
        $this->render("index");
    }
    public function actionUpdateSystem()
    {
        $this->frame = "//layouts/main";
        $this->render("indexUpdate");
    }
    public function actionAjaxLogin()
    {
        // get the user from db
        $username = isset($_POST['loginId']) ? $_POST['loginId'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $editable = $_POST['editable'] == "on" ? true : false;
        $retJson['status'] = 'OK';
        if (empty($username)) {
            $retJson['status'] = 'FAIL';
            $retJson['retMessage'] = "Username could not be empty";
        } else {
            $userModel = Yii::app()->formDao->getUser($username);
            $status = isset($userModel['status']) ? $userModel['status'] : '';
            if (!empty($status) && $status != 'Success') { // connect User Db error
                $retJson['status'] = 'FAIL';
                //$retJson['retMessage'] = "Connect DB Error, Check the Data Base PATH:<br/>" . Yii::app()->params['database_path'];
                $retJson['retMessage'] = "Connect DB Error, Check the Database Connection:<br/>";
            } else {
                if (empty($userModel)) // userName not found
                {
                    $retJson['status'] = 'FAIL';
                    $retJson['retMessage'] = "User not found";
                } else {
                    if ($password != $userModel['password']) {
                        $retJson['status'] = 'FAIL';
                        $retJson['retMessage'] = "Password is not correct";
                    } else { //password correct

                        $editRight = Yii::app()->formDao->getEditRight();
                        if ($editRight['status'] == 'Success') //get edit right table success
                        {
                            if ($editable) { // want Edit Right
                                if ($editRight['editRightOnUse'] == false || ($editRight['editRightUserId'] == $userModel['userId'] && $editRight['editRightOnUse'] == true)) { // edit right not on use
                                    $editStatus = Yii::app()->formDao->updateEditRight($userModel['userId'], true);
                                    if ($editStatus == 'Success') {
                                        $userModel["editRight"] = true;
                                    } else {
                                        $userModel["editRight"] = false;
                                        $retJson['status'] = 'updateEditRightError';
                                        $retJson['retMessage'] = "Update EditRight Error. Check Your DB";
                                    }
                                } else if ($editRight['editRightOnUse'] == true) { //edit right on use
                                    if ($editRight['editRightLastEditTime'] < date("Y-m-d H:i:s", strtotime("-30 minutes"))) { // edit right expire 30min
                                        $editStatus = Yii::app()->formDao->updateEditRight($userModel['userId'], true);
                                        if ($editStatus == 'Success') {
                                            $userModel["editRight"] = true;
                                        } else {
                                            $retJson['status'] = 'updateEditRightError';
                                            $retJson['retMessage'] = "Update EditRight Error. Check Your DB";
                                            $userModel["editRight"] = false;
                                        }
                                    } // edit Right not expire
                                    else {
                                        $userModel["editRight"] = false;
                                        $retJson['status'] = 'EditRightNotExpired';
                                        $retJson['retMessage'] = "EditRight is on Used. You don't have Edit Right";
                                    }
                                }
                            } else // don't want Edit Right
                            {
                                if ($editRight['editRightOnUse'] == true && $editRight['editRightUserId'] == $userModel['userId']) {
                                    $editStatus = Yii::app()->formDao->updateEditRight(0, false);

                                }
                                $userModel["editRight"] = false;
                            }

                        } else {
                            $retJson['status'] = 'GetEditRightError';
                            $retJson['retMessage'] = "EditRight Not Found. Check Your DB";
                        }

                        if ($retJson['status'] == 'OK') {
                            $tokenHash = Yii::app()->commonUtil->getGeneratedId();

                            $userModel["username"] = $username;
                            $userModel['token_hash'] = $tokenHash;
                            $retJson['tblUserDo'] = $userModel['roleId'];
                            Yii::app()->session['tblUserDo'] = $userModel;
                        }

                    }
                }
            }
        }
        echo json_encode($retJson);

    }

    public function actionLogout()
    {
        $editRight = Yii::app()->formDao->getEditRight();
        $userModel = Yii::app()->session['tblUserDo'];
        if ($userModel['userId'] == $editRight['editRightUserId']) {
            $editStatus = Yii::app()->formDao->updateEditRight(0, false);
        }

        session_unset();
        session_destroy();

        $this->frame = "//layouts/main";
        $this->render("index");
    }

    public function actionAjaxActivateAcc()
    {
        $retJson = array();

        // get the user from db
        $userName = isset($_POST['username']) ? $_POST['username'] : '';

        if (empty($userName)) {
            $retJson['status'] = 'FAIL';
            $retJson['retMessage'] = "Username could not be empty";
        } else {
            $userModel = TblUser::model()->findByAttributes(array('user_name' => $userName));

            if (strtoupper($userName) != "ADMIN") {
                $userModel = TblUser::model()->findByAttributes(array('user_name' => $userName));
            }

            if (empty($userModel)) {
                $retJson['status'] = 'FAIL';
                $retJson['retMessage'] = "User not found";
            } else {
                $currentTime = strtotime(date("Y-m-d H:i:s"));
                $accActivateTime = strtotime($userModel['acc_activate_time']);

                // check if the acc already used
                if ($userModel['login_count'] >= Yii::app()->params['maxLoginCount']) {
                    $retJson['status'] = "FAIL";
                    $retJson['retMessage'] = "Account is already locked";
                } else {
                    // activate account
                    if (empty($accActivateTime) || ($accActivateTime + 60 * Yii::app()->params['accExpiryTime'] < $currentTime && $userModel["password_index"] < 3)) {
                        // activate account
                        $sql = "update tbl_user set acc_activate_time = now(), password_index = :passwordInd where sys_user_id = :sysUserId;";
                        $sysUserId = $userModel["sys_user_id"];
                        $passwordInd = $userModel["password_index"] + 1;

                        $command = Yii::app()->db->createCommand($sql);
                        $command->bindParam(':passwordInd', $passwordInd, PDO::PARAM_INT);
                        $command->bindParam(':sysUserId', $sysUserId, PDO::PARAM_INT);

                        $command->execute();
                        $retJson['status'] = 'ACT';

                        // send SMS to user
                        if (ctype_digit($userName)) {
                            $password = $userModel['password1'];

                            if ($passwordInd == 2) {
                                $password = $userModel['password2'];
                            } else if ($passwordInd == 3) {
                                $password = $userModel['password3'];
                            }

                            $sendContent = "Your account is activated. You have 5 minutes to login the web site. Please use the following information to Login: Username:" . $userModel['user_name'] . ", Password:" . $password;
                            $sendResult = Yii::app()->SMSUtil->sendSms($userName, $sendContent);

                            if ($sendResult == "ERROR") {
                                $retJson['status'] = 'FAIL';
                                $retJson['retMessage'] = "Error in sending SMS";
                            }
                        }
                    } else if (!empty($accActivateTime) && $accActivateTime + 60 * Yii::app()->params['accExpiryTime'] > $currentTime) {
                        // just go input password
                        $retJson['status'] = 'OK';
                    } else {
                        $retJson['status'] = 'FAIL';
                        $retJson['retMessage'] = "Please contact admin to reset password.";
                    }
                }
            }
        }

        echo json_encode($retJson);
    }

    // https://mobiforge.com/design-development/content-delivery-mobile-devices
    public function rangeDownload($file)
    {
        $fp = @fopen($file, 'rb');

        $size = filesize($file); // File size
        $length = $size; // Content length
        $start = 0; // Start byte
        $end = $size - 1; // End byte
        // Now that we've gotten so far without errors we send the accept range header
        /* At the moment we only support single ranges.
         * Multiple ranges requires some more work to ensure it works correctly
         * and comply with the spesifications: http://www.w3.org/Protocols/rfc2616/rfc2616-sec19.html#sec19.2
         *
         * Multirange support annouces itself with:
         * header('Accept-Ranges: bytes');
         *
         * Multirange content must be sent with multipart/byteranges mediatype,
         * (mediatype = mimetype)
         * as well as a boundry header to indicate the various chunks of data.
         */
        header("Accept-Ranges: 0-$length");
        // header('Accept-Ranges: bytes');
        // multipart/byteranges
        // http://www.w3.org/Protocols/rfc2616/rfc2616-sec19.html#sec19.2
        if (isset($_SERVER['HTTP_RANGE'])) {

            $c_start = $start;
            $c_end = $end;
            // Extract the range string
            list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
            // Make sure the client hasn't sent us a multibyte range
            if (strpos($range, ',') !== false) {

                // (?) Shoud this be issued here, or should the first
                // range be used? Or should the header be ignored and
                // we output the whole content?
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $start-$end/$size");
                // (?) Echo some info to the client?
                exit;
            }
            // If the range starts with an '-' we start from the beginning
            // If not, we forward the file pointer
            // And make sure to get the end byte if spesified
            if ($range == '-') {

                // The n-number of the last bytes is requested
                $c_start = $size - substr($range, 1);
            } else {

                $range = explode('-', $range);
                $c_start = $range[0];
                $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
            }
            /* Check the range and make sure it's treated according to the specs.
             * http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
             */
            // End bytes can not be larger than $end.
            $c_end = ($c_end > $end) ? $end : $c_end;
            // Validate the requested range and return an error if it's not correct.
            if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {

                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $start-$end/$size");
                // (?) Echo some info to the client?
                exit;
            }
            $start = $c_start;
            $end = $c_end;
            $length = $end - $start + 1; // Calculate new content length
            fseek($fp, $start);
            header('HTTP/1.1 206 Partial Content');
        }
        // Notify the client the byte range we'll be outputting
        header("Content-Range: bytes $start-$end/$size");
        header("Content-Length: $length");

        // Start buffered download
        $buffer = 1024 * 8;
        while (!feof($fp) && ($p = ftell($fp)) <= $end) {

            if ($p + $buffer > $end) {

                // In case we're only outputtin a chunk, make sure we don't
                // read past the length
                $buffer = $end - $p + 1;
            }
            set_time_limit(0); // Reset time limit for big files
            echo fread($fp, $buffer);
            flush(); // Free up memory. Otherwise large files will trigger PHP's memory limit.
        }

        fclose($fp);
    }

    public function actionGetVideo()
    {
        $video = Yii::getPathOfAlias('application') . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "site" . DIRECTORY_SEPARATOR . "video" . DIRECTORY_SEPARATOR;

        $video = $video . "video1120.mp4";

        header('Content-Type: video/mp4');
        header('Accept-Ranges: bytes');

        try {
            if (isset($_SERVER['HTTP_RANGE'])) { // do it for any device that supports byte-ranges not only iPhone
                $this->rangeDownload($video);
            } else {
                header("Content-Length: " . filesize($video));
                readfile($video);
            }
        } catch (Exception $e) {
            echo $e;
        }

    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }

        }
    }
}
