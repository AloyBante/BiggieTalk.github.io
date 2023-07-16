<?php
$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$dbname = "oabeldb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['register'])) {
  if (isset($_POST['email'])) {  $email = $_POST['email']; }
  if (isset($_POST["userName"])) { $userName = $_POST['userName']; } 
  if (isset($_POST["password"])) {  $password = $_POST['password']; }
  //if (isset($_POST["lastEmpId"])) {  $lastEmpId = $_POST['lastEmpId']; }
  $password= md5($password);

  $sqlUser = "INSERT INTO users (username, password, email, is_active,
    is_deleted, date_created, date_updated)
    VALUES ('$userName', '$password', '$email', 1, 0, CURDATE(), CURDATE())";
  
  if (!mysqli_query($conn, $sqlUser)) {
    echo json_encode(array('message' => mysqli_error($conn), 'success' => false));
  } else {
    echo json_encode(array('message' => 'Registration Successful', 'success' => true));
  }
  // if (isset($_POST['firstName'])) {  $firstName = $_POST['firstName']; } 
  // if (isset($_POST['lastName'])) {  $lastName = $_POST['lastName']; } 
  // if (isset($_POST['middleName'])) {  $middleName = $_POST['middleName']; } 
  // if (isset($_POST['address'])) {  $address = $_POST['address']; } 
  // if (isset($_POST['birthday'])) {  $birthday = $_POST['birthday']; } 
  // if (isset($_POST['maritalStatus'])) {  $maritalStatus = $_POST['maritalStatus']; } 
  // if (isset($_POST['gender'])) {  $gender = $_POST['gender']; } 
  // if (isset($_POST['nationality'])) {  $nationality = $_POST['nationality']; }
  // if (isset($_POST['email'])) {  $email = $_POST['email']; }

  // 	$sqlEmp = "INSERT INTO employees (first_name, last_name, middle_name, email, address, birthday,
  //     marital_status, gender, nationality, is_active, is_deleted, date_created, date_updated) 
  //     VALUES ('$firstName', '$lastName', '$middleName', '$email', '$address',
  //     '$birthday', '$maritalStatus', '$gender', '$nationality', 1, 0, CURDATE(), CURDATE())";
    
  // 	if (mysqli_query($conn, $sqlEmp)) {
  //     $lastempId = mysqli_insert_id($conn);
  //     echo json_encode(array('message' => 'Added to employees', 'success' => true, 'lastEmpId' => $lastempId));
  // 	} else {
  // 	  echo json_encode(array('message' => mysqli_error($conn), 'success' => false));
  //   }
  }

  // user's table
  // function addUser($lastempId, $userName, $password, $email){
  //   $password = md5($password);

  //   $sqlUser = "INSERT INTO user (emp_id, username, password, email, is_active,
  //     is_deleted, date_created, date_updated) 
  //   VALUES ( '$lastempId', '$userName', '$password', '$email', 1, 0, CURDATE(), CURDATE())";
    
  //   if (!mysqli_query($conn, $sqlUser)) {
  //     echo json_encode(array('message' => mysqli_error($conn), 'success' => false));
  //   } else {
  //     echo json_encode(array('message' => 'Registration Successful', 'success' => true));
  //   }
  // }
if (isset($_POST['login'])) {
  if (isset($_POST["userName"])) { $userName = $_POST['userName']; }
  if (isset($_POST["password"])) {  $password = $_POST['password']; }
  $password= md5($password);
  
  $check=mysqli_query($conn,"select * from users where username='$userName' and password='$password'");
  if (mysqli_num_rows($check) > 0)
  {
    echo json_encode(array('message' => 'Login Successful', 'success' => true));
  }
  else{
    echo json_encode(array('message' => mysqli_error($conn), 'success' => false));
  }
}

if (isset($_POST['addEmployee'])) {
  if (isset($_POST['empId'])) {  $empId = $_POST['empId']; } 
  if (isset($_POST['firstName'])) {  $firstName = $_POST['firstName']; } 
  if (isset($_POST['lastName'])) {  $lastName = $_POST['lastName']; } 
  if (isset($_POST['middleName'])) {  $middleName = $_POST['middleName']; } 
  if (isset($_POST['address'])) {  $address = $_POST['address']; } 
  if (isset($_POST['birthday'])) {  $birthday = $_POST['birthday']; } 
  if (isset($_POST['maritalStatus'])) {  $maritalStatus = $_POST['maritalStatus']; } 
  if (isset($_POST['gender'])) {  $gender = $_POST['gender']; } 
  if (isset($_POST['nationality'])) {  $nationality = $_POST['nationality']; }
  if (isset($_POST['email'])) {  $email = $_POST['email']; }
  if (isset($_POST['position'])) {  $position = $_POST['position']; }
  if (isset($_POST['department'])) {  $department = $_POST['department']; }
  if (isset($_POST['empPhotoUrl'])) {  $empPhotoUrl = $_POST['empPhotoUrl']; }

  	$sqlEmp = "INSERT INTO employees (id, first_name, last_name, middle_name, email, address, birthday,
      marital_status, department, position, gender, nationality, emp_photo_url, is_active, is_deleted, date_created, date_updated) 
      VALUES ('$empId', '$firstName', '$lastName', '$middleName', '$email', '$address',
      '$birthday', '$maritalStatus', '$department', '$position', '$gender', '$nationality', '$empPhotoUrl', 1, 0, CURDATE(), CURDATE())";
    
  	if (mysqli_query($conn, $sqlEmp)) {
      echo json_encode(array('message' => 'Added to employees', 'success' => true));
  	} else {
  	  echo json_encode(array('message' => mysqli_error($conn), 'success' => false));
    }
}

if (isset($_POST['updateEmployee'])) {
  if (isset($_POST['empId'])) {  $empId = $_POST['empId']; } 
  if (isset($_POST['firstName'])) {  $firstName = $_POST['firstName']; } 
  if (isset($_POST['lastName'])) {  $lastName = $_POST['lastName']; } 
  if (isset($_POST['middleName'])) {  $middleName = $_POST['middleName']; } 
  if (isset($_POST['address'])) {  $address = $_POST['address']; } 
  if (isset($_POST['birthday'])) {  $birthday = $_POST['birthday']; } 
  if (isset($_POST['maritalStatus'])) {  $maritalStatus = $_POST['maritalStatus']; } 
  if (isset($_POST['gender'])) {  $gender = $_POST['gender']; } 
  if (isset($_POST['nationality'])) {  $nationality = $_POST['nationality']; }
  if (isset($_POST['email'])) {  $email = $_POST['email']; }
  if (isset($_POST['position'])) {  $position = $_POST['position']; }
  if (isset($_POST['department'])) {  $department = $_POST['department']; }

  	$sqlEmp = "UPDATE employees 
      SET 
      first_name = '$firstName', last_name = '$lastName', middle_name = '$middleName'
      , address = '$address', email = '$email', birthday = '$birthday'
      , marital_status = '$maritalStatus', gender = '$gender', nationality = '$nationality'
      , position = '$position', department = '$department', date_updated = CURDATE()
      WHERE id = '$empId'";
    
  	if (mysqli_query($conn, $sqlEmp)) {
      echo json_encode(array('message' => 'Employee Updated', 'success' => true));
  	} else {
  	  echo json_encode(array('message' => mysqli_error($conn), 'success' => false));
    }
}

if (isset($_POST['deleteEmployee'])) {
  if (isset($_POST['empId'])) {  $empId = $_POST['empId']; } 
  
  $sqlEmp = "DELETE FROM employees WHERE id='$empId'";
  if (mysqli_query($conn, $sqlEmp)) {
    echo json_encode(array('message' => 'Employee Data Deleted', 'success' => true));
  } else {
    echo json_encode(array('message' => mysqli_error($conn), 'success' => false));
  }
}

if (isset($_POST['timeIn'])) {
  if (isset($_POST['empId'])) { $empId = $_POST['empId']; } 
  if (isset($_POST['timeFrom'])) { $timeFrom = $_POST['timeFrom']; } 
  if (isset($_POST['dte'])) { $dte = $_POST['dte']; } 
  
  $sqlAtt = "INSERT INTO attendance(emp_id, dte, status, time_from) VALUES('$empId', '$dte', 'PRESENT', '$timeFrom')";

  if (mysqli_query($conn, $sqlAtt)) {
    echo json_encode(array('message' => 'Time-in Success', 'success' => true));
  } else {
    echo json_encode(array('message' => mysqli_error($conn), 'success' => false));
  }
}

if (isset($_POST['timeOut'])) {
  if (isset($_POST['empId'])) { $empId = $_POST['empId']; } 
  if (isset($_POST['timeTo'])) { $timeTo = $_POST['timeTo']; } 
  if (isset($_POST['dte'])) { $dte = $_POST['dte']; } 
  
  $sqlAtt = "UPDATE attendance SET time_to='$timeTo' WHERE dte='$dte' AND emp_id='$empId'";

  if (mysqli_query($conn, $sqlAtt)) {
    echo json_encode(array('message' => 'Time-in Success', 'success' => true));
  } else {
    echo json_encode(array('message' => mysqli_error($conn), 'success' => false));
  }
}

if (isset($_POST['hoursWorked'])) {
  if (isset($_POST['empId'])) { $empId = $_POST['empId']; } 
  if (isset($_POST['dte'])) { $dte = $_POST['dte']; } 
  
  $sqlAtt = "UPDATE attendance SET hours_worked=HOUR(SUBTIME(DATE_FORMAT(time_from,'%H:%i:%s'), DATE_FORMAT(time_to,'%H:%i:%s'))) WHERE dte='$dte' AND emp_id='$empId'";

  if (mysqli_query($conn, $sqlAtt)) {
    echo json_encode(array('message' => 'Time-out Success', 'success' => true));
  } else {
    echo json_encode(array('message' => mysqli_error($conn), 'success' => false));
  }
}

if (isset($_POST['savePayroll'])) {
  if (isset($_POST['empId'])) {  $empId = $_POST['empId']; } 
  if (isset($_POST['basicSalary'])) {  $basicSalary = $_POST['basicSalary']; } 
  if (isset($_POST['daysWorked'])) {  $daysWorked = $_POST['daysWorked']; } 
  if (isset($_POST['overtimePay'])) {  $overtimePay = $_POST['overtimePay']; } 
  if (isset($_POST['holidayPay'])) {  $holidayPay = $_POST['holidayPay']; } 
  if (isset($_POST['allowance'])) {  $allowance = $_POST['allowance']; } 
  if (isset($_POST['sss'])) {  $sss = $_POST['sss']; } 
  if (isset($_POST['pagibig'])) {  $pagibig = $_POST['pagibig']; } 
  if (isset($_POST['philhealth'])) {  $philhealth = $_POST['philhealth']; }
  if (isset($_POST['otherDeductions'])) {  $otherDeductions = $_POST['otherDeductions']; }
  if (isset($_POST['grossPay'])) {  $grossPay = $_POST['grossPay']; }
  if (isset($_POST['netPay'])) {  $netPay = $_POST['netPay']; }
  if (isset($_POST['dateFrom'])) {  $dateFrom = $_POST['dateFrom']; }
  if (isset($_POST['dateTo'])) {  $dateTo = $_POST['dateTo']; }

  	$sqlPayroll = "INSERT INTO payroll (emp_id, basic_salary, days_worked, overtime_pay, holiday_pay, allowance,
      sss, pag_ibig, philhealth, other_deductions, gross_pay, net_pay, date_from, date_to, date_created) 
      VALUES ('$empId', '$basicSalary', '$daysWorked', '$overtimePay', '$holidayPay',
      '$allowance', '$sss', '$pagibig', '$philhealth', '$otherDeductions', '$grossPay', '$netPay', '$dateFrom', '$dateTo', CURDATE())";
    
  	if (mysqli_query($conn, $sqlPayroll)) {
      echo json_encode(array('message' => 'Payroll saved!', 'success' => true));
  	} else {
  	  echo json_encode(array('message' => mysqli_error($conn), 'success' => false));
    }
}

if (isset($_POST['addFile'])) {
  $dir = '../images/';
  if (isset($_FILES['empPhoto'])) {  $empPhoto = $_FILES['empPhoto']; } 
  move_uploaded_file($_FILES["empPhoto"]["tmp_name"], $dir. $_FILES["empPhoto"]["name"]);
  echo $dir. $_FILES["empPhoto"]["name"];
}

$conn->close();
?>