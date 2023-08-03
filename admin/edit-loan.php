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
} 

?>

<?php include 'header_aside.php' ?>

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
          <form action="edit-loan.php" method="post" class="row g-3" name="editForm" id="editForm">

            <div class="col-md-12">
              <label for="inputName5" class="form-label">Loan Type</label>
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
         <input type="text" class="form-control" value="<?php echo $loan['borrower']; ?>" 
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
              <label for="inputAddress2" class="form-label">Amount Requested</label>
              <input type="number" class="form-control" id="inputRequested" 
              name="amountRequested" placeholder="Amount Requested" value="<?php echo $loan['amount_requested']; ?>" required>
            </div>

            <div class="col-md-6">
              <label for="inputAddress2" class="form-label">Processing Fees</label>
              <input type="number" class="form-control" id="inputProcessing" value=5000 
              name="processingFee" required>
            </div>

            <div class="col-md-6">
              <label for="inputAddress2" class="form-label">Amount Approved</label>
              <input type="number" class="form-control" id="inputApproved" name="amountApproved"
               placeholder="Amount Approved" value="<?php echo $loan['amount_approved']; ?>" required>
            </div>

            <div class="col-md-6">
              <label for="inputAddress2" class="form-label">Application Fees</label>
              <input type="number" class="form-control" id="inputProcessing" value=15000 
              name="applicationFee" Required>
            </div>

            <div class="col-md-6">
              <label for="inputCity" class="form-label">Loan Period(Months)</label>
              <select class="form-select"  name="loanPeriod" required>
              <option value="<?php echo $loan['loan_period']; ?>" ><?php echo $loan['loan_period']; ?></option>
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
              <option value="<?php echo $loan['interest_rate']; ?>" selected><?php echo $loan['interest_rate']; ?></option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                </select>
            </div>

            <div style="color:blue"><h3>Add Collateral</h3></div>

        <div class="col-md-6">
          <label for="inputEmail3" class="form-label">Collateral Name</label>
          <input type="text" class="form-control" id="collateralName" name="collateralName" 
          placeholder="Collateral Name" value="<?php echo $loan['collateral_name']; ?>" required>
        </div>

        <div class="col-md-6">
          <label for="inputAddress2" class="form-label">Serial Number</label>
          <input type="text" class="form-control" id="inputSerial" name="serialNumber" 
          placeholder="Serial Number" value="<?php echo $loan['serial_number']; ?>" required>
        </div>

        <!-- <div class="col-mt-1">
          <label for="inputAddress2" class="form-label">Upload photo</label>
          <input type="file" class="form-control" id="inputApproved" name="photo" accept="image/*" required>
        </div> -->
     
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Update Loan</button>
             <!-- <button type="reset" class="btn btn-secondary">Reset</button> -->
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

<?php include 'footer.php' ?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $loan_number = $conn->real_escape_string($_POST['loanNumber']);
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

  // $photoName = $_FILES['photo']['name'];
  // $imageFileType = strtolower(pathinfo($photoName, PATHINFO_EXTENSION));
  // $photoTempPath = $_FILES['photo']['tmp_name'];
  // $photoUploadPath = '../uploads/' . $release_date . "_" . $borrower.".".$imageFileType; 

  //   // Move the uploaded photo to the desired location
  //   move_uploaded_file($photoTempPath, $photoUploadPath);

    $total_amount_tobe_paid = $amount_approved * (1 + ($interest_rate * $loan_period)/100);
    $num_weeks = $loan_period * 4;
    $weekly_recovery = $total_amount_tobe_paid / $num_weeks;


    $query = "UPDATE loans SET loan_type='$loan_type', borrower='$borrower', distributed_by='$distributed_by',
    amount_requested='$amount_requested', amount_approved='$amount_approved', processing_fee='$processing_fee',
    application_fee='$application_fee', loan_period='$loan_period', interest_rate='$interest_rate',
    release_date='$release_date', collateral_name='$collateral_name', serial_number='$serial_number',
    weekly_recovery='$weekly_recovery', total_amount_tobe_paid='$total_amount_tobe_paid' 
    WHERE loan_number='$loan_number'";

  if ($conn->query($query) === TRUE) {
    session_start();
    // $_SESSION['message'] = "Loan Updated successfully";
    echo "<script>window.location.href = 'view-loans.php';</script>";
    exit;
  } else {
    echo "Error: " . $query . "<br>" . $conn->error;
  }
}

?>





