<?php
Yii::import('application.vendor.PHPExcel', true);
Yii::import('application.vendor.autoload', true);
class FunctionController extends Controller
{

    public function filters()
    {
        return array(
            array(
                'application.filters.AccessControlFilter',

            ),
        );
    }
    public function actionIncidentReportPdfSearch()
    {

        $this->render("//site/function/IncidentReportPdfSearch");
    }

    public function actionIncidentReportPdfMatch()
    {
        $exePath = dirname(dirname(__dir__)) . '/incidentPdfExe/POneFpsCodeVerifier/bin/Debug/POneFpsCodeVerifier.exe';
        $exePath= str_replace("\\","/",$exePath);
        $inPath = dirname(dirname(__dir__)) . '/incidentPdfExe/Incoming';
        $inPath= str_replace("\\","/",$inPath);
        $tmpPath = dirname(dirname(__dir__)) . '/incidentPdfExe/tmp';
        $tmpPath= str_replace("\\","/",$tmpPath);
       $argument = "{IN_PATH:'$inPath',TMP_PATH:'$tmpPath'}";
       $argument= str_replace("\\","/",$argument);
       $command = $exePath." ".$argument;
        exec( $command, $output);
       //exec( "D:/Project/clp/PQSIS/xampp/xampp/htdocs/PQSIS/incidentPdfExe/POneFpsCodeVerifier/bin/Debug/POneFpsCodeVerifier.exe {IN_PATH:'D:/Project/clp/PQSIS/xampp/xampp/htdocs/PQSIS/incidentPdfExe/Incoming',TMP_PATH:'D:/Project/clp/PQSIS/xampp/xampp/htdocs/PQSIS/incidentPdfExe/tmp'}", $output);
       $retJson['status'] = 'OK';
       $retJson['retMessage'] = '';
       $idrOrderIdList = $output;
        foreach($idrOrderIdList as $idrOrderId){
            $idrOrderId = explode(";", $idrOrderId);

        try {

            //We start our transaction.
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();

            //Query 1: Attempt to insert the payment record into our database.
            $sql = 'UPDATE "TblVoltageReport" set "ourRef" = ? WHERE "idrNo" = ?';
            //$stmt = $pdo->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);
            $result = $stmt->execute(array(
                $idrOrderId[1],$idrOrderId[0]
            ));
            /*
            if (!$result) {
                throw new Exception($stmt->errorInfo()[2],$stmt->errorInfo()[1]);

            }
            */
            $count = $stmt->rowCount();
            if($count>=1){
                $retJson['retMessage'] .= "Updated OurRef: $idrOrderId[1] with IdrOrderId: $idrOrderId[0] <br/>";
            }
            else{
                $retJson['retMessage'] .= "Not Found Data OurRef: $idrOrderId[1] with IdrOrderId: $idrOrderId[0] <br/>";
            };
            $lastUpdatedTime = date("Y-m-d H:i");
            $sql = 'UPDATE "TblEditRight" set "editRightLastEditTime" = ? ';
            //$stmt = $pdo->prepare($sql);
            $stmt = Yii::app()->db->createCommand($sql);
            $stmt->execute(array(
                $lastUpdatedTime,
            )
            );

            //We've got this far without an exception, so commit the changes.
            //$pdo->commit();
            $transaction->commit();
        }
        //Our catch block will handle any exceptions that are thrown.
         catch (Exception $e) {

            //An exception has occured, which means that one of our database queries
            //failed.
            //Print out the error message.
            $retJson['status'] = 'NOTOK';
            $retJson['retMessage'] .=  "error ".$e->getMessage();
            //Rollback the transaction.
            //$pdo->rollBack();
            $transaction->rollBack();
        }

        }
        $retJson['retMessage'] .= "Matching Finished";
        echo json_encode($retJson);
    }

    public function actionIncidentReportSearch()
    {

        $this->render("//site/function/IncidentReportSearch");
    }

    public function actionIncidentReportUpload()
    {
        $message= '';
        $resultMessage = '';
        $startUploadFlag = false;
        $waitingFolderPath = dirname(dirname(__dir__)) . '/upload/incident/waiting/';
        $successFolderPath = dirname(dirname(__dir__)) . '/upload/incident/success/';
        $failFolderPath =  dirname(dirname(__dir__)) . '/upload/incident/fail/';
         if (!is_dir($waitingFolderPath)) {
            mkdir($waitingFolderPath, 0777, true);
        }
        if (!is_dir($successFolderPath)) {
            mkdir($successFolderPath, 0777, true);
        }
        if (!is_dir($failFolderPath)) {
            mkdir($failFolderPath, 0777, true);
        }
        $upload_files = glob( $waitingFolderPath. '*');
        
        $fileId = 1;
        foreach ($upload_files as $upload_file) { //For each excel
            $recordCount =0;
            $recordInsertCount1 =0;
            $recordUpdateCount1= 0;
            $recordInsertCount2 =0;
            $recordUpdateCount2= 0;
            $startUploadFlag = false;
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();
            $resultMessage = '';
            $inputFilePath = $upload_file;
            $inputFileName = basename($upload_file);
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($inputFilePath);

            //sheet 0
            $objPHPExcel->setActiveSheetIndex(0);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $objWorksheet->getHighestRow();
            $highestColumn = $objWorksheet->getHighestColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $rows = array();
            $rowInsert1 = array();
            $rowUpdate1 = array();
            $rowInsert2 = array();
            $rowUpdate2 = array();
            for ($row = 1; $row <= $highestRow; ++$row) { // Foreach row
                for ($col = 0; $col <= $highestColumnIndex; ++$col) { // Foreach col
                    $rows[$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                }
                if ($startUploadFlag && $rows[2]!=null) {

                    $idrNo = $rows[1];
                    if ($rows[2] != null && $rows[2] != null) {
                        $incidentDate = $rows[2] . " " . $rows[3];
                    } else {
                        $incidentDate = $rows[2];
                    }
                    $voltage = $rows[4];
                    $circuit = $rows[5];
                    $durations = $rows[7];
                    $vL1 = $rows[8];
                    $vL2 = $rows[9];
                    $vL3 = $rows[10];
                    $retJson['status'] = 'OK';

                    try {

                        //We start our transaction.
                        $sqlSearch = "SELECT count(*) FROM \"TblVoltageReport\" WHERE \"idrNo\" = '$idrNo' ";
                        /*
                        $result = $pdo->query($sqlSearch);
                        $count = $result->fetchColumn();
                        */
                        $stmt = Yii::app()->db->createCommand($sqlSearch);
                        $result = $stmt->queryRow();
                        $count = $result['count'];
                        //Query 1: Attempt to insert the payment record into our database.
                        if($count==0){
                        $sql = 'INSERT INTO "TblVoltageReport" ("idrNo","incidentDate","voltage","circuit","durations","vL1","vL2","vL3") ';
                        $sql = $sql . " VALUES (?,?,?,?,?,?,?,?)";
                        //$stmt = $pdo->prepare($sql);
                        $stmt = Yii::app()->db->createCommand($sql);

                        $result = $stmt->execute(array(
                            $idrNo, $incidentDate, $voltage, $circuit, $durations, $vL1, $vL2, $vL3));
                        if (!$result) {
                            //throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
                            if($resultMessage ==''){
                                $resultMessage .= 'FILE '.$fileId.' EXCEL NAME: ' . $inputFileName .'  HAS ERROR <br/>';
                            }
                            $resultMessage .= 'SHEET 1 RECORD ROW' . $row . ' HAS ERROR IN INSERT ' . $sth->errorInfo()[1] . '<br/>';
                        }
                        $recordInsertCount1 +=1;
                        $rowInsert1[]=$row;
                        }
                        else{
                            $sql = "UPDATE \"TblVoltageReport\" set \"idrNo\" = ?, \"incidentDate\"= ? , \"voltage\" =?,\"circuit\" = ?, \"durations\"=?,\"vL1\"=?,\"vL2\"=?,\"vL3\"=? WHERE \"idrNo\" ='$idrNo' ";
                            //$stmt = $pdo->prepare($sql);
                            $stmt = Yii::app()->db->createCommand($sql);

                            $result = $stmt->execute(array(
                                $idrNo, $incidentDate, $voltage, $circuit, $durations, $vL1, $vL2, $vL3));
                            if (!$result) {
                                //throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
                                if($resultMessage ==''){
                                    $resultMessage .= 'FILE '.$fileId.' EXCEL NAME: ' . $inputFileName .'  HAS ERROR <br/>';
                                }
                                $resultMessage .= 'SHEET 1 RECORD ROW' . $row . ' HAS ERROR IN UPDATE ' . $sth->errorInfo()[1] . '<br/>';
                            }
                        $recordUpdateCount1 +=1;
                        $rowUpdate1[]=$row;
                        }



                        $recordCount= $recordCount+1;

                        //Query 2: Attempt to update the user's profile.
                        /*    $sql = "UPDATE users SET credit = credit + ? WHERE id = ?";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(array(
                        $paymentAmount,
                        $userId
                        )
                        ); */

                        //We've got this far without an exception, so commit the changes.

                    }
                    //Our catch block will handle any exceptions that are thrown.
                     catch (Exception $e) {

                        //An exception has occured, which means that one of our database queries
                        //failed.
                        //Print out the error message.
                        $retJson['status'] = 'NOTOK';
                       
                        //Rollback the transaction.
                        
                    }
                }
                if ($rows[0] == 'No.' && $rows[1] == 'IDR No.' && $rows[2] == 'Date (dd/mm/yyyy)') {
                    $startUploadFlag = true;
                }

            }
            //sheet 1
            $startUploadFlag = false;
            $objPHPExcel->setActiveSheetIndex(1);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $objWorksheet->getHighestRow();
            $highestColumn = $objWorksheet->getHighestColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $rows = array();
            $rowInsert = array();
            $rowUpdate = array();
            
            for ($row = 1; $row <= $highestRow; ++$row) { // Foreach row
                for ($col = 0; $col <= $highestColumnIndex; ++$col) { // Foreach col
                    $rows[$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                }
                if ($startUploadFlag && $rows[2]!=null) {

                    $idrNo = $rows[1];
                    if ($rows[2] != null && $rows[2] != null) {
                        $incidentDate = $rows[2] . " " . $rows[3];
                    } else {
                        $incidentDate = $rows[2];
                    }
                    $voltage = $rows[4];
                    $circuit = $rows[5];
                    $durations = $rows[7];
                    $vL1 = $rows[8];
                    $vL2 = $rows[9];
                    $vL3 = $rows[10];
                    $retJson['status'] = 'OK';

                    try {

                        //We start our transaction.
                        $sqlSearch = "SELECT count(*) FROM \"TblVoltageReport\" WHERE \"idrNo\" = '$idrNo' ";
                        /*
                        $result = $pdo->query($sqlSearch);
                        $count = $result->fetchColumn();
                        */
                        $stmt = Yii::app()->db->createCommand($sqlSearch);
                        $result = $stmt->queryRow();
                        $count = $result['count'];
                        //Query 1: Attempt to insert the payment record into our database.
                        if($count==0){
                        $sql = 'INSERT INTO "TblVoltageReport" ("idrNo","incidentDate","voltage","circuit","durations","vL1","vL2","vL3") ';
                        $sql = $sql . " VALUES (?,?,?,?,?,?,?,?)";
                        //$stmt = $pdo->prepare($sql);
                        $stmt = Yii::app()->db->createCommand($sql);

                        $result = $stmt->execute(array(
                            $idrNo, $incidentDate, $voltage, $circuit, $durations, $vL1, $vL2, $vL3));
                        if (!$result) {
                            //throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
                            if($resultMessage ==''){
                                $resultMessage .= 'FILE '.$fileId.' EXCEL NAME: ' . $inputFileName .'  HAS ERROR <br/>';
                            }
                            $resultMessage .= 'SHEET 2 RECORD ROW' . $row . ' HAS ERROR IN INSERT ' . $sth->errorInfo()[1] . '<br/>';
                        }
                        $recordInsertCount2 +=1;
                        $rowInsert2[]=$row;
                        }
                        else{
                            $sql = "UPDATE \"TblVoltageReport\" set \"idrNo\" = ?, \"incidentDate\"= ? , \"voltage\" =?,\"circuit\" = ?, \"durations\"=?,\"vL1\"=?,\"vL2\"=?,\"vL3\"=? WHERE \"idrNo\" ='$idrNo' ";
                            //$stmt = $pdo->prepare($sql);
                            $stmt = Yii::app()->db->createCommand($sql);

                            $result = $stmt->execute(array(
                                $idrNo, $incidentDate, $voltage, $circuit, $durations, $vL1, $vL2, $vL3));
                            if (!$result) {
                                //throw new Exception($sth->errorInfo()[2], $sth->errorInfo()[1]);
                                if($resultMessage ==''){
                                    $resultMessage .= 'FILE '.$fileId.' EXCEL NAME: ' . $inputFileName .'  HAS ERROR <br/>';
                                }
                                $resultMessage .= 'SHEET 2 RECORD ROW' . $row . ' HAS ERROR IN UPDATE ' . $sth->errorInfo()[1] . '<br/>';
                            }
                        $recordUpdateCount2 +=1;
                        $rowUpdate2[]=$row;
                        }



                        $recordCount= $recordCount+1;

                        //Query 2: Attempt to update the user's profile.
                        /*    $sql = "UPDATE users SET credit = credit + ? WHERE id = ?";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(array(
                        $paymentAmount,
                        $userId
                        )
                        ); */

                        //We've got this far without an exception, so commit the changes.

                    }
                    //Our catch block will handle any exceptions that are thrown.
                     catch (Exception $e) {

                        //An exception has occured, which means that one of our database queries
                        //failed.
                        //Print out the error message.
                        $retJson['status'] = 'NOTOK';
                       
                        //Rollback the transaction.
                        
                    }
                }
                if ($rows[0] == 'No.' && $rows[1] == 'IDR No.' && $rows[2] == 'Date (dd/mm/yyyy)') {
                    $startUploadFlag = true;
                }

            }
            if($resultMessage !=''){
                
                //$pdo->rollBack();
                $transaction->rollBack();
                $message .= $resultMessage . ' ';
                if (!file_exists($failFolderPath.date("Ymd").'/')) {
                    mkdir($failFolderPath.date("Ymd").'/', 0777, true);
                }
                rename($inputFilePath, $failFolderPath.date("Ymd").'/'.$inputFileName);
            }
            else{

                //$pdo->commit();
                $transaction->commit();
                $message .= 'FILE '.$fileId.' EXCEL NAME: ' . $inputFileName . ' WITH ' .$recordCount. ' RECORD UPLOADED SUCCESSFULLY <br/>';
                $message .= 'SHEET 1 INSERTED '.  $recordInsertCount1 . ' Record in row ' ; 
                foreach($rowInsert1 as $row){
                    $message .= $row.',';
                }
                $message.= '<br/>';
                $message .= 'SHEET 1 UPDATED '.  $recordUpdateCount1 . ' Record in row ' ; 
                foreach($rowUpdate1 as $row){
                    $message .= $row.',';
                }
                $message.= '<br/>';
                $message .= 'SHEET 2 INSERTED '.  $recordInsertCount2 . ' Record in row ' ; 
                foreach($rowInsert2 as $row){
                    $message .= $row.',';
                }
                $message.= '<br/>';

                $message .= 'SHEET 2 UPDATED '.  $recordUpdateCount2 . ' Record in row ' ; 
                foreach($rowUpdate2 as $row){
                    $message .= $row.',';
                }
                $message.= '<br/>';
                if (!file_exists($successFolderPath.date("Ymd").'/')) {
                    mkdir($successFolderPath.date("Ymd").'/', 0777, true);
                }
                rename($inputFilePath, $successFolderPath.date("Ymd").'/'.Date('YmdHHmmii').$inputFileName);
            }
            $fileId =($fileId +1);
        }
        if($message==''){
            $message.= 'NO REPORT IS WAITING FOR UPLOAD';   
        }
        $retJson['resultMessage'] = $message;
        echo json_encode($retJson);
        
    }

    public function actionVoltageReportSearch()
    {

        $this->render("//site/function/VoltageReportSearch");
    }
    public function actionVoltageReportUpload()
    {
        $message= '';
        $resultMessage = '';
        $startUploadFlag = false;
        $waitingFolderPath = dirname(dirname(__dir__)) . '/upload/voltage/waiting/';
        $successFolderPath = dirname(dirname(__dir__)) . '/upload/voltage/success/';
        $failFolderPath =  dirname(dirname(__dir__)) . '/upload/voltage/fail/';
         if (!is_dir($waitingFolderPath)) {
            mkdir($waitingFolderPath, 0777, true);
        }
        if (!is_dir($successFolderPath)) {
            mkdir($successFolderPath, 0777, true);
        }
        if (!is_dir($failFolderPath)) {
            mkdir($failFolderPath, 0777, true);
        }
        $upload_files = glob( $waitingFolderPath. '*');
        
        $fileId = 1;
        foreach ($upload_files as $upload_file) { //For each word
            $recordCount =0;
            $recordInsertCount1 =0;
            $recordUpdateCount1= 0;
            $recordInsertCount2 =0;
            $recordUpdateCount2= 0;
            $startUploadFlag = false;
            //$pdo->beginTransaction();
            $transaction = Yii::app()->db->beginTransaction();
            $resultMessage = '';
            $inputFilePath = $upload_file;
            $inputFileName = basename($upload_file);
            $objPHPword = \PhpOffice\PhpWord\IOFactory::load($inputFilePath,"Word2007");
            // Make sure you have `dompdf/dompdf` in your composer dependencies.
            \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
            // Any writable directory here. It will be ignored.
            \PhpOffice\PhpWord\Settings::setPdfRendererPath('.');
            $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($objPHPword, 'PDF');
            $xmlWriter->save($successFolderPath.'/'.$inputFileName.'.pdf');
            $sections = $objPHPword->getSections();
            foreach ($sections[0]->getElements() as $el)
            {
                if ($el instanceof PhpOffice\PhpWord\Element\Table)
                {
                    foreach ($el->getRows() as $row)
                    {
                        foreach ($row->getCells() as $cell)
                        {
                            foreach($cell->getElements() as $element){
                                if($element instanceof PhpOffice\PhpWord\Element\TextRun){
                                foreach($element->getElements() as $element2){
                                    $thing = $element2->getText();
                                    $resultMessage .= $thing;
                                }
                                if($element instanceof PhpOffice\PhpWord\Element\TextBreak){
                                    $resultMessage .= '</br>';
                                }
                            }

                            }
                            //$thing = $cell->getElements()[0]->getText();
                            //$thing = $cell->getElements()[0]->getText().'***';
                            
                        }
                    }
                }
            }
        }

                    $retJson['status'] = 'OK';

                 
        if($message==''){
            $message.= 'NO REPORT IS WAITING FOR UPLOAD';   
        }
        
        $retJson['resultMessage'] = $resultMessage;
        echo json_encode($retJson);
        
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
