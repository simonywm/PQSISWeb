<?php
$reportPath = Yii::app()->params['report_save_path'];
/*$thisReportPath = $reportPath . "\\" . $year . "\\" . $month.".xlsx";
if (!file_exists($thisReportPath)) {

    if (!file_exists($reportPath)) {
        mkdir($reportPath, 0777, true);
    }
} */
$file = $reportPath ."\\" . "CaseReport.xlsx";

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    flush();
    readfile($file);
    exit;
}
/*if (file_exists($file)) {
    ob_end_clean();
    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename='.basename($file));
    header("Content-Disposition: attachment; filename=\"".basename($file)."\"");
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    readfile($file);
} else {
    http_response_code(404);
    die();
}*/
?>