<?php
include 'connection/db_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] ==='POST') {
  // Validate and sanitize the form input
  $loan_type = $conn->real_escape_string($_POST['loanType']);
  $borrower = $conn->real_escape_string($_POST['borrower']);
  $distributed_by = $conn->real_escape_string($_POST['distributedBy']);
  $amount_requested = $conn->real_escape_string($_POST['amountRequested']);
  $amount_approved = $conn->real_escape_string($_POST['amountApproved']);
  $processing_fee = $conn->real_escape_string($_POST['processingFee']);
  $application_fee = $conn->real_escape_string($_POST['applicationFee']);
  $loan_period = $conn->real_escape_string($_POST['loanPeriod']);
  $interest_rate = $conn->real_escape_string($_POST['interestRate']);
  $release_date = $conn->real_escape_string($_POST['loanReleaseDate']);
  $collateral_name = mysqli_real_escape_string($conn, $_POST['collateralName']);
  $serial_number = mysqli_real_escape_string($conn, $_POST['serialNumber']);
  $trustee_name = mysqli_real_escape_string($conn, $_POST['trusteeName']);
  $trustee_number = mysqli_real_escape_string($conn, $_POST['trusteeNumber']);

  $photoName = $_FILES['photo']['name'];
  $imageFileType = strtolower(pathinfo($photoName, PATHINFO_EXTENSION));
  $photoTempPath = $_FILES['photo']['tmp_name'];
  $photoUploadPath = '../uploads/' . $serial_number . "_" . $borrower.".".$imageFileType; 

    // Move the uploaded photo to the desired location
    move_uploaded_file($photoTempPath, $photoUploadPath);

  $total_fee = $processing_fee + $application_fee;

  //Calculating the total amount to be paid back for the loan
  $total_amount_tobe_paid = $amount_approved * (1 + ($loan_period * $interest_rate)/100);

  $num_weeks = $loan_period * 4;
  $weekly_recovery = $total_amount_tobe_paid / $num_weeks;
  $current_date = date('Y-m-d');

  $dueDate = date('Y-m-d', strtotime($release_date . " + $loan_period months"));

  $status_query = "SELECT * FROM loans INNER JOIN repayments ON loans.loan_number=repayments.loan
  WHERE loans.borrower=repayments.borrower";

  $result = $conn->query($status_query);
  $row = $result->fetch_assoc();
   
  //Check if the borrower has un paid loan still running or expired
  $check_loan = "SELECT * FROM loans WHERE borrower = '$borrower'";
  $result = $conn->query($check_loan);
  $row = $result->fetch_assoc();

  if($row['loan_status']=='Active' OR $row['loan_status']=='Expired'){
    echo "<script>alert('You still have un paid Loan, Please first Clear')</script>";

    echo "<script>window.location.href = 'add-Loan.php';</script>";
    exit();
  }

  $status = 'Active';

 $sql =  "INSERT INTO loans(loan_type, borrower, distributed_by, amount_requested,
 amount_approved, processing_fee,application_fee, total_fee, loan_period, interest_rate,release_date,
 collateral_name, serial_number, collateral_photo, weekly_recovery,total_amount_tobe_paid, due_date, 
 loan_status, trustee, trustee_number)
 VALUES ('$loan_type','$borrower','$distributed_by','$amount_requested','$amount_approved','$processing_fee',
 '$application_fee','$total_fee','$loan_period','$interest_rate','$release_date', '$collateral_name', 
 '$serial_number', '$photoUploadPath', '$weekly_recovery', '$total_amount_tobe_paid', '$dueDate', 
 '$status', '$trustee_name', '$trustee_number')";

if ($conn->query($sql) === TRUE) {

  session_start();
  $_SESSION['message'] = "Loan added successfully";
  echo "<script>window.location.href = 'view-loans.php';</script>";

  exit;
  } else {
  echo "Error: Failed to add it to the database.......";
 }

}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>