<?php
$db_username = ''; //username
$db_password = ''; //password

//path to database file
$database_path = "\\\\192.168.0.120\\ShareFolder\\JKTech\\Project\\CLP\\PQSIS\\test.mdb";
//$database_path = "D:/Project/CLP/PQSIS/sample/bootstrapSample/test.mdb";

//check file exist before we proceed
if (!file_exists($database_path)) {
    die("Access database file not found !");
}

//create a new PDO object
$database = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$database_path; Uid=$db_username; Pwd=$db_password;");

$sql  = "SELECT * FROM test";
$result = $database->query($sql);
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo $row["name"];
}
?>