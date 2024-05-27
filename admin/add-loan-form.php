<?php
include 'connection/db_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
  // Calculate the total amount to be paid back for the loan
  $total_amount_tobe_paid = $amount_approved * (1 + ($loan_period * $interest_rate)/100);

  $num_weeks = $loan_period * 4;
  $weekly_recovery = $total_amount_tobe_paid / $num_weeks;
  $current_date = date('Y-m-d');

  $dueDate = date('Y-m-d', strtotime($release_date . " + $loan_period months"));

  // if($dueDate<$current_date){
  //   $status = 'Expired';
  // }
  // else{
  // $status = 'Active';
  // }

  $status = $dueDate < $current_date? 'Expired': 'Active';

  // Check if the borrower has an unpaid loan still running or expired
  $check_loan = "SELECT * FROM loans WHERE borrower = '$borrower'";
  $result = $conn->query($check_loan);

  if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  
  if ($row['loan_status'] == 'Active' || $row['loan_status'] == 'Expired') {
    echo "<script>alert('You still have an unpaid loan. Please first clear it.')</script>";
    echo "<script>window.location.href = 'add-Loan.php';</script>";
    exit();
  }
  }
  
  // Insert the loan details into the loans table
  $sql =  "INSERT INTO loans(loan_type, borrower, distributed_by, amount_requested,
    amount_approved, processing_fee, application_fee, total_fee, loan_period, interest_rate, release_date,
    collateral_name, serial_number, collateral_photo, weekly_recovery, total_amount_tobe_paid, due_date,
    loan_status, trustee, trustee_number)
    VALUES ('$loan_type', '$borrower', '$distributed_by', '$amount_requested', '$amount_approved', '$processing_fee',
    '$application_fee', '$total_fee', '$loan_period', '$interest_rate', '$release_date', '$collateral_name',
    '$serial_number', '$photoUploadPath', '$weekly_recovery', '$total_amount_tobe_paid', '$dueDate',
    '$status', '$trustee_name', '$trustee_number')";

  if ($conn->query($sql) === TRUE) { 

    $status_query = "SELECT SUM(amount_collected) AS total_amount_repaid, due_date, total_amount_tobe_paid FROM loans 
    INNER JOIN repayments ON loans.loan_number=repayments.loan WHERE loans.borrower=repayments.borrower";

    $result = $conn->query($status_query);

    $current_date = date("Y-m-d");

    while ($row = $result->fetch_assoc()) {
    if ($row['total_amount_repaid'] >= $row['total_amount_tobe_paid']) {
        $status = "Cleared";
    } else if ($row['total_amount_repaid'] < $row['total_amount_tobe_paid'] 
    && ($row['due_date'] > $current_date)) {
        $status = "Active";
    } else if ($row['total_amount_repaid'] < $row['total_amount_tobe_paid'] 
    && ($row['due_date'] < $current_date)) {
        $status = "Expired";
    } else {
        // Handle any other conditions or set a default status if necessary
        $status = "Unknown";
    }

    $loan_number = $row['loan_number'];
    $update_query = "UPDATE loans SET loan_status='$status' WHERE loan_number='$loan_number'";
    if ($conn->query($update_query) === TRUE) {
        // echo "Loan status updated successfully.";
    } else {
        echo "Error updating loan status: " . $conn->error;
    }
}

    session_start();
    $_SESSION['message'] = "Loan added successfully";
    echo "<script>window.location.href = 'view-loans.php';</script>";

  } else {
    echo "Error: Failed to add the loan to the database.";
  }
}

?>
