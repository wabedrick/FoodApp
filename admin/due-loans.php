<?php
session_start();
if(!isset($_SESSION["username"])){
    header('location: ../index.php');
}
?>

<?php
include 'connection/db_connection.php';

$current_date = date('Y-m-d');


$sql = "SELECT SUM(amount_collected) AS total_amount_collected,loans.borrower, amount_approved, loan_period,
interest_rate, total_amount_tobe_paid, due_date, loan_number, firstname, balance  FROM loans LEFT JOIN borrowers 
ON loans.borrower = borrowers.ninNumber LEFT JOIN repayments ON repayments.loan=loans.loan_number 
WHERE loans.loan_status = 'Expired'";
$result = $conn->query($sql);


?>
<?php include 'header_aside.php'; ?>


<!--main content-->
  <main id="main" class="main">

    <?php if(isset($_SESSION['message'])) {?>
    <div class="container" id="message-container">
        <div class="row">
            <div class="col-md-12">
            <div class="alert alert-success d-flex justify-content-between align-items-center">
                   <?php echo $_SESSION['message']; ?>
                   <!-- add button for removing the alert message -->
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    <?php } unset($_SESSION['message']); ?>


  <section>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <h2>List of Due Loans</h2>
        <hr>
      </div>
  
    <table class="table datatable table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Edit</th>
          <th scope="col">Loan Number</th>
          <th scope="col">Borrower</th>
          <th scope="col">Amount Taken</th>
          <th scope="col">Loan Period</th>
          <th scope="col">Interest Rate</th>
          <th scope="col">Amount to Be Paid</th>
          <th scope="col">Amount Paid</th>
          <th scope="col">Balance</th>
          <th scope="col">Time Due</th>
          
        </tr>
      </thead>
      <tbody>

        <?php while ($loan = $result -> fetch_assoc()) { ?>
          <tr>
          <td scope="row">
              <!-- <a href="#" title="Delete" class="text-primary"><i class="bi bi-eye-fill"></i></a> -->
              <a href="edit-dueLoan.php?loan_number=<?php echo $loan['loan_number'];?>" title="Edit" 
                  class="text-success"><i class="bi bi-pencil-square"></i></a>
            </td>
            <td><?php echo $loan['loan_number']; ?></td>
            <td><?php echo $loan['firstname']." - ". $loan['borrower']; ?>
            <td><?php echo $loan['amount_approved']; ?></td>
            <td><?php echo $loan['loan_period']; ?></td>
            <td><?php echo $loan['interest_rate']; ?></td>
            <td><?php echo $loan['total_amount_tobe_paid']; ?></td>
            <td><?php echo $loan['total_amount_collected']; ?></td>
            <td><?php echo $loan['balance']; ?></td>
            <td><?php 
            try {
              // Code that may throw a null value exception
              $time_due = $loan['due_date'];
          
              // if ($time_due === null) {
              //     throw new Exception('Null value encountered');
                
              // }
              // Code that continues execution if $variable is not null
              echo $time_due; 
              
          } catch (Exception $e) {
              // Exception handling code
              echo 'Exception caught: ' . $e->getMessage();
              // Additional error handling or logging can be performed here
          }
          
            ?></td>

          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  </div>

  </section>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
<?php include 'footer.php'; ?>