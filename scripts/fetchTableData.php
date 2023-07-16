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

if (isset($_GET['dashboardDataLoad'])) {
  if (isset($_GET['dte'])) {  $dte = $_GET['dte']; } 

  $query=mysqli_query($conn,"SELECT a.id, CONCAT(e.last_name,', ',e.first_name) as name, e.email,
    a.status, DATE_FORMAT(a.time_from,'%H:%i:%s') as time_from, DATE_FORMAT(a.time_to,'%H:%i:%s') as time_to,
    HOUR(SUBTIME(DATE_FORMAT(a.time_from,'%H:%i:%s'), DATE_FORMAT(a.time_to,'%H:%i:%s'))) as hours_worked, dte
    FROM attendance a JOIN employees e ON e.id = a.emp_id WHERE a.dte='$dte' ORDER BY a.time_from");
  if (mysqli_num_rows($query) > 0)
  {
    // output data of each row
    while($row = $query->fetch_assoc()) {
      $result = "<tr>";
      $result .= "<td>". $row["id"]."</td>";
      $result .= "<td>". $row["name"]."</td>";
      $result .= "<td>". $row["email"]."</td>";
      $result .= "<td>". $row["status"]."</td>";
      $result .= "<td>". $row["dte"]."</td>";
      $result .= "<td>". $row["time_from"]."</td>";
      $result .= "<td>". $row["time_to"]."</td>";
      $result .= "<td>". $row["hours_worked"]."</td>";
      $result .= "</tr>";
      echo $result;
    }
  } else {
    //echo "0 results";
  }
}

if (isset($_GET['employeeCount'])) {
  $sql = "SELECT * FROM employees";
  $mysqliStatus = $conn->query($sql);
  $rows_count_value = mysqli_num_rows($mysqliStatus);
  echo $rows_count_value; 
}

if (isset($_GET['presentEmployees'])) {
  if (isset($_GET['dte'])) {  $dte = $_GET['dte']; } 
  $sql = "SELECT * FROM attendance where status='PRESENT' and dte='$dte'";
  $mysqliStatus = $conn->query($sql);
  $rows_count_value = mysqli_num_rows($mysqliStatus);
  echo $rows_count_value; 
}

if (isset($_GET['absentEmployees'])) {
  if (isset($_GET['dte'])) {  $dte = $_GET['dte']; } 
  $sql = "SELECT * FROM attendance where status in('ABSENT', '', null) and dte='$dte'";
  $mysqliStatus = $conn->query($sql);
  $rows_count_value = mysqli_num_rows($mysqliStatus);
  echo $rows_count_value; 
}

if (isset($_GET['searchEmployeeTime'])) {
  if (isset($_GET['lastName'])) {  $lastName = $_GET['lastName']; }
  if (isset($_GET['dte'])) {  $dte = $_GET['dte']; } 

  $query=mysqli_query($conn,"SELECT a.id, CONCAT(e.last_name,', ',e.first_name) as name, e.email,
    a.status, DATE_FORMAT(a.time_from,'%H:%i:%s') as time_from, DATE_FORMAT(a.time_to,'%H:%i:%s') as time_to,
    HOUR(SUBTIME(DATE_FORMAT(a.time_from,'%H:%i:%s'), DATE_FORMAT(a.time_to,'%H:%i:%s'))) as hours_worked, dte
    FROM attendance a JOIN employees e ON e.id = a.emp_id WHERE e.last_name='$lastName' AND a.dte='$dte' ORDER BY a.time_from");
  if (mysqli_num_rows($query) > 0)
  {
    while($row = $query->fetch_assoc()) {
      $result = "<tr>";
      $result .= "<td>". $row["id"]."</td>";
      $result .= "<td>". $row["name"]."</td>";
      $result .= "<td>". $row["email"]."</td>";
      $result .= "<td>". $row["status"]."</td>";
      $result .= "<td>". $row["dte"]."</td>";
      $result .= "<td>". $row["time_from"]."</td>";
      $result .= "<td>". $row["time_to"]."</td>";
      $result .= "<td>". $row["hours_worked"]."</td>";
      $result .= "</tr>";
      echo $result;
    }
  } else {
  }
}

if (isset($_GET['searchEmployee'])) {
  if (isset($_GET['id'])) {  $id = $_GET['id']; }

  $query=mysqli_query($conn,"SELECT * FROM employees WHERE id='$id'");
  if (mysqli_num_rows($query) > 0)
  {
    while($row = $query->fetch_assoc()) {
      $result = "<tr>";
      //$result .= "<td><button onClick='editEmployee($row[id])' id='btnEdit' type='button' class='btn btn-warning'><i class='fa fa-pencil'></i></button></td>";
      $result .= "<td><button onClick='deleteEmployee(\"".$row["id"]."\")' id='btnDelete' type='button' class='btn btn-danger'><i class='fa fa-trash'></i></button></td>";
      $result .= "<td>". $row["id"]."</td>";
      $result .= "<td>". $row["last_name"]."</td>";
      $result .= "<td>". $row["first_name"]."</td>";
      $result .= "<td>". $row["middle_name"]."</td>";
      $result .= "<td>". $row["email"]."</td>";
      $result .= "<td>". $row["department"]."</td>";
      $result .= "<td>". $row["position"]."</td>";
      $result .= "<td>". $row["address"]."</td>";
      $result .= "<td>". $row["birthday"]."</td>";
      $result .= "<td>". $row["marital_status"]."</td>";
      $result .= "<td>". $row["gender"]."</td>";
      $result .= "<td>". $row["nationality"]."</td>";
      //$result .= "<td>". $row["basic_salary"]."</td>";
      $result .= "<td>". $row["is_active"]."</td>";
      $result .= "<td>". $row["is_deleted"]."</td>";
      $result .= "<td>". $row["date_created"]."</td>";
      $result .= "<td>". $row["date_updated"]."</td>";
      $result .= "</tr>";
      echo $result;
    }
  } else {
  }
}

if (isset($_GET['editEmployee'])) {
  if (isset($_GET['id'])) {  $id = $_GET['id']; }

  $query=mysqli_query($conn,"SELECT * FROM employees WHERE id='$id'");
  if (mysqli_num_rows($query) > 0)
  {
    while($row = $query->fetch_assoc()) {
      $result = "<tr>";
      $result .= "<td><button onClick='saveEmployee(\"".$row["id"]."\")' type='button' class='btn btn-success'><i class='fa fa-save'></i></button></td>";
      $result .= "<td>". $row["id"]."</td>";
      $result .= "<td><input class='form-control' id='last_name' type='text' value='$row[last_name]' placeholder='Last Name'></td>";
      // $result .= "<td>". $row["last_name"]."</td>";
      $result .= "<td><input class='form-control' id='first_name' type='text' value='$row[first_name]' placeholder='First Name'></td>";
      //$result .= "<td>". $row["first_name"]."</td>";
      $result .= "<td><input class='form-control' id='middle_name' type='text' value='$row[middle_name]' placeholder='Middle Name'></td>";
      //$result .= "<td>". $row["middle_name"]."</td>";
      $result .= "<td><input class='form-control' id='email_adress' type='text' value='$row[email]' placeholder='Email'></td>";
      $result .= "<td><input class='form-control' id='dept' type='text' value='$row[department]' placeholder='Department'></td>";
      $result .= "<td><input class='form-control' id='posit' type='text' value='$row[position]' placeholder='Position'></td>";
      //$result .= "<td>". $row["email"]."</td>";
      $result .= "<td><input class='form-control' id='full_address' type='text' value='$row[address]' placeholder='Address'></td>";
      //$result .= "<td>". $row["address"]."</td>";
      $result .= "<td><input class='form-control' id='birthDate' type='text' value='$row[birthday]' placeholder='Birthday'></td>";
      //$result .= "<td>". $row["birthday"]."</td>";
      $result .= "<td><input class='form-control' id='marital' type='text' value='$row[marital_status]' placeholder='Marital Status'></td>";
      // $result .= "<td>". $row["marital_status"]."</td>";
      $result .= "<td><input class='form-control' id='gender_e' type='text' value='$row[gender]' placeholder='Gender'></td>";
      //$result .= "<td>". $row["gender"]."</td>";
      $result .= "<td><input class='form-control' id='nat' type='text' value='$row[nationality]' placeholder='Nationality'></td>";
      //$result .= "<td>". $row["nationality"]."</td>";
      //$result .= "<td>". $row["basic_salary"]."</td>";
      $result .= "<td>". $row["is_active"]."</td>";
      $result .= "<td>". $row["is_deleted"]."</td>";
      $result .= "<td>". $row["date_created"]."</td>";
      $result .= "<td>". $row["date_updated"]."</td>";
      $result .= "</tr>";
      echo $result;
    }
  } else {
  }
}

if (isset($_GET['loadEmployeeData'])) {

  $query=mysqli_query($conn,"SELECT * FROM employees");
  if (mysqli_num_rows($query) > 0)
  {
    while($row = $query->fetch_assoc()) {
      $result = "<tr>";
      // $result .= "<td><button onClick='editEmployee($row[id])' id='btnEdit' type='button' class='btn btn-warning'><i class='fa fa-pencil'></i></button></td>";
      $result .= "<td><button onClick='deleteEmployee(\"".$row["id"]."\")' id='btnDelete' type='button' class='btn btn-danger'><i class='fa fa-trash'></i></button></td>";
      $result .= "<td>". $row["id"]."</td>";
      $result .= "<td>". $row["last_name"]."</td>";
      $result .= "<td>". $row["first_name"]."</td>";
      $result .= "<td>". $row["middle_name"]."</td>";
      $result .= "<td>". $row["email"]."</td>";
      $result .= "<td>". $row["department"]."</td>";
      $result .= "<td>". $row["position"]."</td>";
      $result .= "<td>". $row["address"]."</td>";
      $result .= "<td>". $row["birthday"]."</td>";
      $result .= "<td>". $row["marital_status"]."</td>";
      $result .= "<td>". $row["gender"]."</td>";
      $result .= "<td>". $row["nationality"]."</td>";
      // $result .= "<td>". $row["basic_salary"]."</td>";
      $result .= "<td>". $row["is_active"]."</td>";
      $result .= "<td>". $row["is_deleted"]."</td>";
      $result .= "<td>". $row["date_created"]."</td>";
      $result .= "<td>". $row["date_updated"]."</td>";
      $result .= "</tr>";
      echo $result;
    }
  } else {
  }
}

if (isset($_GET['searchEmployeeAttendance'])) {
  if (isset($_GET['empId'])) {  $empId = $_GET['empId']; }
  $query=mysqli_query($conn,"SELECT e.id, CONCAT(e.last_name,', ',e.first_name) as name FROM employees e WHERE id = '$empId'");
  if (mysqli_num_rows($query) > 0)
  {
    while($row = $query->fetch_assoc()) {
      $result = "<tr>";
      $result .= "<td>". $row["id"]."</td>";
      $result .= "<td>". $row["name"]."</td>";
      $result .= "<td><div class='d-flex justify-content-center'><input class='form-control' id='timeFrom' type='text' placeholder='Time-in'>&nbsp;<button id='btimTimeIn' type='button' class='btn btn-success')'><i class='fa fa-clock-o'></i></button></div></td>";
      $result .= "<td><div class='d-flex justify-content-center'><input class='form-control' id='timeTo' type='text' placeholder='Time-out'>&nbsp;<button id='btimTimeOut' type='button' class='btn btn-warning')'><i class='fa fa-clock-o'></i></button></div></td>";
      $result .= "</tr>";
      echo $result;
    }
  } else {
  }
}

if (isset($_GET['employeePayroll'])) {
  if (isset($_GET['empId'])) { $empId = $_GET['empId']; }
  $query=mysqli_query($conn,"SELECT e.department, e.position, CONCAT(e.last_name,', ',e.first_name) as name FROM employees e WHERE id = '$empId'");
  if (mysqli_num_rows($query) > 0)
  {
    while($row = $query->fetch_assoc()) {
      echo json_encode(array(
        'success' => true,
        'name' => $row["name"],
        'department' => $row["department"],
        'position' => $row["position"],
      ));
    }
  } else {
    echo json_encode(array(
      'success' => false
    ));
  }
  
}

if (isset($_GET['daysWorked'])) {
  if (isset($_GET['empId'])) { $empId = $_GET['empId']; }
  if (isset($_GET['dteFrom'])) { $dteFrom = $_GET['dteFrom']; }
  if (isset($_GET['dteTo'])) { $dteTo = $_GET['dteTo']; }
  $query=mysqli_query($conn,"SELECT COUNT(*) as days_worked FROM `attendance` WHERE emp_id = '$empId' AND dte BETWEEN '$dteFrom' AND '$dteTo'");
  if (mysqli_num_rows($query) > 0)
  {
    while($row = $query->fetch_assoc()) {
      echo json_encode(array(
        'success' => true,
        'days_worked' => $row["days_worked"]
      ));
    }
  } else {
    echo json_encode(array(
      'success' => false
    ));
  }
  
}

if (isset($_GET['payrollSummary'])) {
  if (isset($_GET['empId'])) { $empId = $_GET['empId']; }
  $query=mysqli_query($conn,
  "SELECT p.emp_id, CONCAT(e.last_name,', ',e.first_name) as name, p.basic_salary, p.days_worked,
      p.overtime_pay, p.holiday_pay, p.allowance, p.sss, p.pag_ibig, p.philhealth, p.other_deductions,
      p.gross_pay, p.net_pay, p.date_from, p.date_to
   FROM payroll p JOIN employees e
   ON p.emp_id = e.id WHERE p.emp_id = '$empId'");

if (mysqli_num_rows($query) > 0)
{
  while($row = $query->fetch_assoc()) {
    $result = "<tr>";
    $result .= "<td>". $row["emp_id"]."</td>";
    $result .= "<td>". $row["name"]."</td>";
    $result .= "<td>". $row["basic_salary"]."</td>";
    $result .= "<td>". $row["days_worked"]."</td>";
    $result .= "<td>". $row["overtime_pay"]."</td>";
    $result .= "<td>". $row["holiday_pay"]."</td>";
    $result .= "<td>". $row["allowance"]."</td>";
    $result .= "<td>". $row["sss"]."</td>";
    $result .= "<td>". $row["pag_ibig"]."</td>";
    $result .= "<td>". $row["philhealth"]."</td>";
    $result .= "<td>". $row["other_deductions"]."</td>";
    $result .= "<td>". $row["gross_pay"]."</td>";
    $result .= "<td>". $row["net_pay"]."</td>";
    $result .= "<td>". $row["date_from"]."</td>";
    $result .= "<td>". $row["date_to"]."</td>";
    $result .= "</tr>";
    echo $result;
  }
} else {
}
  
}

if (isset($_GET['allPayrollSummary'])) {
  $query=mysqli_query($conn, "SELECT p.emp_id, CONCAT(e.last_name,', ',e.first_name) as name, p.basic_salary, p.days_worked,
      p.overtime_pay, p.holiday_pay, p.allowance, p.sss, p.pag_ibig, p.philhealth, p.other_deductions,
      p.gross_pay, p.net_pay, p.date_from, p.date_to
   FROM payroll p JOIN employees e
   ON p.emp_id = e.id");

if (mysqli_num_rows($query) > 0)
  {
    while($row = $query->fetch_assoc()) {
      $result = "<tr>";
      $result .= "<td><button id='btnPrint' type='button' class='btn btn-success' onClick='printPayroll(\"".$row["emp_id"]."\", \"".$row["date_from"]."\", \"".$row["date_to"]."\")'><i class='fa fa-print'></i></button></td>";
      $result .= "<td>". $row["emp_id"]."</td>";
      $result .= "<td>". $row["name"]."</td>";
      $result .= "<td>". $row["basic_salary"]."</td>";
      $result .= "<td>". $row["days_worked"]."</td>";
      $result .= "<td>". $row["overtime_pay"]."</td>";
      $result .= "<td>". $row["holiday_pay"]."</td>";
      $result .= "<td>". $row["allowance"]."</td>";
      $result .= "<td>". $row["sss"]."</td>";
      $result .= "<td>". $row["pag_ibig"]."</td>";
      $result .= "<td>". $row["philhealth"]."</td>";
      $result .= "<td>". $row["other_deductions"]."</td>";
      $result .= "<td>". $row["gross_pay"]."</td>";
      $result .= "<td>". $row["net_pay"]."</td>";
      $result .= "<td>". $row["date_from"]."</td>";
      $result .= "<td>". $row["date_to"]."</td>";
      $result .= "</tr>";
      echo $result;
    }
  } else {
  }
  
}

if (isset($_GET['printPayrollSummary'])) {
  if (isset($_GET['empId'])) { $empId = $_GET['empId']; }
  if (isset($_GET['dteFrom'])) { $dteFrom = $_GET['dteFrom']; }
  if (isset($_GET['dteTo'])) { $dteTo = $_GET['dteTo']; }
  $query=mysqli_query($conn, "SELECT p.emp_id, CONCAT(e.last_name,', ',e.first_name) as name, p.basic_salary, p.days_worked,
      e.department, e.position, p.overtime_pay, p.holiday_pay, p.allowance, p.sss, p.pag_ibig, p.philhealth, p.other_deductions,
      p.gross_pay, p.net_pay, p.date_from, p.date_to
   FROM payroll p JOIN employees e
   ON p.emp_id = e.id WHERE p.emp_id = '$empId' AND p.date_from = '$dteFrom' AND p.date_to = '$dteTo'");

if (mysqli_num_rows($query) > 0)
  {
    while($row = $query->fetch_assoc()) {
      $result = "<html><head><link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'><title></title></head>
      <body><br><br><div class='vertical-center'><div class='container'>";
      $result .= "<div class='container'>
      <div class='row'>
          <div class='col-sm-3'>
              <label style='border:none' class='form-control'><h5>Payroll Period: </h5></label>
          </div>
          <div class='col-sm-3'>
              <label style='margin-left:-120px' class='form-control' aria-describedby='basic-addon'>". $row["date_from"]." - ". $row["date_to"]."</label>
          </div>
      </div>
      <br>
      <div class='row'>
          <div class='col-sm-6'>
              <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id='basic-addon'>Employee ID</span>
                  </div>
                  <label class='form-control' aria-describedby='basic-addon'>". $row["emp_id"]."</label>
              </div>
              <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id='basic-addon1'>Employee Name</span>
                  </div>
                  <label class='form-control' aria-describedby='basic-addon1'>". $row["name"]."</label>
              </div>
              
              <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id='basic-addon2'>Department</span>
                  </div>
                  <label class='form-control' aria-describedby='basic-addon2'>". $row["department"]."</label>
              </div> 
              <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id='basic-addon3'>Position</span>
                  </div>
                  <label class='form-control' aria-describedby='basic-addon3'>". $row["position"]."</label>
              </div>
              <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id='basic-addon5'>Basic Salary</span>
                  </div>
                  <label class='form-control' aria-describedby='basic-addon3'>". $row["basic_salary"]."</label>
              </div>
              <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id='basic-addon4'>Days Worked</span>
                  </div>
                  <label class='form-control' aria-describedby='basic-addon3'>". $row["days_worked"]."</label>
              </div>
              <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id='basic-addon6'>Overtime Pay</span>
                  </div>
                  <label class='form-control' aria-describedby='basic-addon3'>". $row["overtime_pay"]."</label>
              </div>
              <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id='basic-addon7'>Holiday Pay</span>
                  </div>
                  <label class='form-control' aria-describedby='basic-addon3'>". $row["holiday_pay"]."</label>
              </div>
              <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id='basic-addon8'>Allowance</span>
                  </div>
                  <label class='form-control' aria-describedby='basic-addon3'>". $row["allowance"]."</label>
              </div>
          </div>
          <div class='col-sm-6'>
              <h5>Deductions</h5>
              <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id='basic-addon9'>SSS</span>
                  </div>
                  <label class='form-control' aria-describedby='basic-addon3'>". $row["sss"]."</label>
              </div>
              <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id='basic-addon10'>PAG-IBIG</span>
                  </div>
                  <label class='form-control' aria-describedby='basic-addon3'>". $row["pag_ibig"]."</label>
              </div>
              <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id='basic-addon11'>Philhealth</span>
                  </div>
                  <label class='form-control' aria-describedby='basic-addon3'>". $row["philhealth"]."</label>
              </div>
              <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id='basic-addon11'>Others</span>
                  </div>
                  <label class='form-control' aria-describedby='basic-addon3'>". $row["other_deductions"]."</label>
              </div><br><br><br><br>
              <h5>Total</h5>
              <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id='basic-addon12'>Gross Pay</span>
                  </div>
                  <label id='gross' class='form-control' aria-describedby='basic-addon12'>". $row["gross_pay"]."</label>
              </div>
              <div class='input-group mb-3'>
                  <div class='input-group-prepend'>
                  <span class='input-group-text' id='basic-addon13'>Net Pay</span>
                  </div>
                  <label id='net' class='form-control' aria-describedby='basic-addon13'>". $row["net_pay"]."</label>
              </div>
		
      </div>";
      $result .= "</div></div></div></div></body></html>";
      echo $result;
	
    }
  } else {
  }
  
}

$conn->close();
?>
