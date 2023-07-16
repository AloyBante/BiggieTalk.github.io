<?php
//$servername = "127.0.0.1:3306";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oabeldb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$success = false;
// create users table
$sqlUsers = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    email VARCHAR(50),
    is_active TINYINT(1) DEFAULT 1,
    is_deleted TINYINT(1) DEFAULT 0,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// create employees table
$sqlEmployees = "CREATE TABLE IF NOT EXISTS employees (
    id VARCHAR(20) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100),
    email VARCHAR(50),
    address VARCHAR(200),
    birthday DATE,
    phone_number VARCHAR(20),
    marital_status VARCHAR(20),
    department VARCHAR(100),
    position VARCHAR(250),
    gender VARCHAR(6),
    nationality VARCHAR(50),
    basic_salary INT(100),
    emp_photo_url VARCHAR(200),
    is_active TINYINT(1) DEFAULT 1,
    is_deleted TINYINT(1) DEFAULT 0,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// create attendance table
$sqlAttendance = "CREATE TABLE IF NOT EXISTS attendance (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    emp_id VARCHAR(20),
    dte DATE,
    status VARCHAR(50),
    time_from TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    time_to TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    hours_worked INT(2)
)";

// create payroll table
$sqlPayroll = "CREATE TABLE IF NOT EXISTS payroll (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    emp_id VARCHAR(20),
    basic_salary INT(100),
    days_worked INT(100),
    overtime_pay INT(100),
    holiday_pay INT(100),
    allowance INT(100),
    sss INT(100),
    pag_ibig INT(100),
    philhealth INT(100),
    other_deductions INT(100),
    gross_pay INT(100),
    net_pay INT(100),
    date_from DATE,
    date_to DATE,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$tablesToCreate = [$sqlUsers, $sqlEmployees, $sqlAttendance, $sqlPayroll];

foreach($tablesToCreate as $t => $sql){
    $query = @$conn->query($sql);

    if(!$query)
        $success = false;
    else
        $success = true;
}

if($success)
    echo json_encode(array('message' => 'Table Creation Successful', 'success' => true));
else
    echo json_encode(array('message' => mysqli_error($conn), 'success' => false));

$conn->close();
?>