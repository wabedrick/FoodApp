<?php
session_start();
if(!isset($_SESSION["username"])){
    header('location: ../index.php');
}

include 'connection/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['loan_number'])) {
    $loan_number = $conn->real_escape_string($_GET['loan_number']);
    // $borrower = $conn->real_escape_string($_GET['borrower']);

    $sql = "SELECT * FROM loans INNER JOIN borrowers ON loans.borrower=borrowers.ninNumber 
    WHERE loan_number='$loan_number'";
    $result = $conn->query($sql);
    $loan = $result->fetch_assoc();
    

    //Storing the Original Data before it is edited
    $loan_type = $loan['loan_type'];
    $borrower = $loan['borrower'];
    $distributed_by = $loan['distributed_by'];
    $amount_requested = $loan['amount_requested'];
    $amount_approved = $loan['amount_approved'];
    $processing_fee = $loan['processing_fee'];
    $application_fee = $loan['application_fee'];
    $loan_period = $loan['loan_period'];
    $interest_rate = $loan['interest_rate'];
    $release_date = $loan['release_date'];
    $collateral_name = $loan['collateral_name'];
    $serial_number = $loan['serial_number'];
    $collateral_photo = $loan['collateral_photo'];
    $weekly_recovery = $loan['weekly_recovery'];
    $total_amount_tobe_paid = $loan['total_amount_tobe_paid'];
    $due_date = $loan['due_date'];
    $loan_status = 'UpdatedDueLoan';
    $trustee = $loan['trustee'];
    $trustee_number = $loan['trustee_number'];

    $old_sql = "INSERT INTO loan_history(loan_number, loan_type, borrower, distributed_by, amount_requested,
    amount_approved, processing_fee, application_fee, loan_period, interest_rate, release_date,
    collateral_name, serial_number, collateral_photo, weekly_recovery, total_amount_tobe_paid,
    due_date, loan_status, trustee, trustee_number) 
    VALUES('$loan_number','$loan_type', '$borrower', '$distributed_by','$amount_requested',
    '$amount_approved', '$processing_fee', '$application_fee', '$loan_period', '$interest_rate', 
    '$release_date', '$collateral_name', '$serial_number', '$collateral_photo', '$weekly_recovery',
    '$total_amount_tobe_paid', '$due_date', '$loan_status', '$trustee', '$trustee_number')";

    if ($conn->query($old_sql) === TRUE) {

    //  echo "<script>window.location.href = 'view-loans.php';</script>";

      // exit;
    } else {
      // echo "Error: Failed to Save the Due Loan.";
    }
} 

?>
  <link href="../assets/img/logo.png" rel="icon">
  <link href="../assets/img/logo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">


<link href="../assets/css/style.css" rel="stylesheet">


<!--main content-->
<main id="main" class="main">

<div class="pagetitle">
  <!-- <h1>Add Loan</h1> -->
  <nav>

</div><!-- End Page Title -->
<section class="section">
  <div class="row">
    <div class="col-lg-6">

        </div>
      </div>

      <div class="card">
        <div class="card-body">

          <!-- Multi Columns Form -->
          <form action="edit-dueLoan.php" method="post" class="row g-3">

             <div class="col-md-12">
              <label for="inputName5" class="form-label">Loan Number</label>
              <input type="text" class="form-control" value="<?php echo $loan['loan_number']; ?>" 
               name="loanNumber" id="loanNumber" required>
            </div>

            <div class="col-md-12">
              <label for="inputName5" class="form-label">Loan Type</label>
              <input type="text" class="form-control" value="<?php echo $loan['loan_type']; ?>" 
               name="loanType" id="loanType" required>
            </div>

            
        <div class="form-group mt-1">
         <label for="group">Borrower</label>
         <input type="text" class="form-control" value="<?php echo $loan['firstname'].' '. $loan['borrower']; ?>" 
         name="borrower" id="inputBorrower" required>

         </div>
        
            <div style="color:blue"><h3>Loan Terms</h3></div>
            <div class="col-md-6">
              <label for="inputEmail3" value="<?php echo $loan['distributed_by']; ?>" class="form-label">Distributed By</label>
              <select class="form-select" name="distributedBy" required>
              <option selected><?php echo $loan['distributed_by']; ?></option>
                 <option value="Cash">Cash</option>
                  <option value="Cheque">Cheque</option>
                </select>
            </div>

            <div class="col-md-6">
              <label for="inputDate" class="form-label">Loan Release date</label>
              <input type="date" class="form-control" value="<?php echo $loan['release_date']; ?>" name="loanReleaseDate" id="inputDate" required>
            </div>


            <div class="col-md-6">
              <label for="inputCity" class="form-label">Loan Period(Months)</label>
              <select class="form-select"  name="loanPeriod" required>
              <option value="<?php echo $loan['loan_period']; ?>" ><?php echo $loan['loan_period']; ?></option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>
            </div>
        
            <div class="col-md-6">
              <label for="inputCity" class="form-label">Interest Rate(%age)</label>
              <select class="form-select"name="interestRate"  required>
              <option value="<?php echo $loan['interest_rate']; ?>" selected>
              <?php echo $loan['interest_rate']; ?></option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                </select>
            </div>
     
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Update Loan</button>
            </div>
          </form><!-- End Multi Columns Form -->

        </div>
      </div>

    </div>

        </div>
      </div>

    </div>
  </div>
</section>

</main><!-- End #main -->

<?php

// include 'connection/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $loan_period = $conn->real_escape_string($_POST['loanPeriod']);
  $interest_rate = $conn->real_escape_string($_POST['interestRate']);
  $release_date = $conn->real_escape_string($_POST['loanReleaseDate']);
  $loan_number = $conn->real_escape_string($_POST['loanNumber']);

    //Calculating the total amount to be paid back for the loan
    $amount_query = "SELECT SUM(amount_collected) AS total_amount_collected FROM repayments 
    WHERE loan='$loan_number' ";
    $amount_result = $conn->query($amount_query);
    $total_amount_collected_row = $amount_result->fetch_assoc();
    $total_amount_collected = $total_amount_collected_row['total_amount_collected'];

    //delete after
    $sql = "SELECT * FROM loans INNER JOIN borrowers ON loans.borrower=borrowers.ninNumber 
    WHERE loan_number='$loan_number'";
    $result = $conn->query($sql);
    $loan = $result->fetch_assoc();

    $balance = $loan['total_amount_tobe_paid'] - $total_amount_collected;
    $total_amount_tobe_paid = $balance + (0.1 * $balance);

    $new_amount_tobe_paid = $total_amount_tobe_paid * (1 + ($loan_period * $interest_rate)/100);

    $number_of_weeks = $loan_period * 4;                                                   
    $weekly_recovery = $new_amount_tobe_paid / $number_of_weeks;
    $dueDate = date('Y-m-d', strtotime($release_date . " + $loan_period months"));
    $status = 'Active';

    $processing_fee = $loan['processing_fee'] + 5000;
 
    $query = "UPDATE loans SET loan_period='$loan_period', interest_rate='$interest_rate',
    release_date='$release_date', total_amount_tobe_paid='$new_amount_tobe_paid', 
    weekly_recovery='$weekly_recovery', due_date='$dueDate', amount_approved = '$total_amount_tobe_paid'
    ,loan_status='$status', processing_fee='$processing_fee' 
    WHERE loan_number='$loan_number'";

    
  if ($conn->query($query) === TRUE) {
    session_start();
    // $_SESSION['message'] = "Due Loan Updated successfully";
    echo "<script>window.location.href = 'view-loans.php';</script>";

    exit;
  } else {
    echo "Error: Failed to Update the Due Loan.";
  }
}
?>
