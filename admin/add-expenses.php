<?php
session_start();
if (!isset($_SESSION["username"])) {
  header('location: ../index.php');
}
?>

<?php
include 'connection/db_connection.php';

?>

<?php include 'header_aside.php'; ?>

<!--main content-->
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Add Expenses</h1>
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
        <form action="add-expenses.php" method="post" class="row g-3 mt-2">

          <div class="form-group mt-1">

            <label for="inputCity" class="form-label">Expense Type</label>
            <input type="text" class="form-control" name="expenseType" id="expenseType" placeholder="Enter expense" required>
            <!-- <select class="form-select" name="expenseType" required>
              <option selected>Accommodation</option>
              <option value="Transport">Transport</option>
              <option value="Electricity Bill">Electricity Bills</option>
              <option value="Water Bills">Water Bills</option>
              <option value="Computer Software">Computer Software</option>
              <option value="Computer Hardware">Computer Hardware</option>
              <option value="Office Equipments">Office Equipments</option>
              <option value="Office Rent">Office Rent</option>
              <option value="Stationary">Stationery</option>
              <option value="Cell Phone">Cell Phone</option>
              <option value="Printing">Printing</option>
              <option value="Bank/Finance Charges">Bank/Finance Charges</option>
            </select> -->

          </div>

          <div class="col-md-6">
            <label for="inputAddress2" class="form-label">Expense Amount</label>
            <input type="number" class="form-control" id="inputAmount" name="expenseAmount" placeholder="Expense Amount" required>
          </div>

          <div class="col-md-6">
            <label for="inputDate" class="form-label">Expense Date</label>
            <input type="date" class="form-control" name="expenseDate" id="inputDate" required>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary">Add Expense</button>

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

<!-- ======= Footer ======= -->
<?php include 'footer.php'; ?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $expenseType = mysqli_real_escape_string($conn, $_POST['expenseType']);
  $expenseAmount =  mysqli_real_escape_string($conn, $_POST['expenseAmount']);
  $expenseDate = mysqli_real_escape_string($conn, $_POST['expenseDate']);


  $query = "INSERT INTO expenses(expense_type, expense_amount, expense_date)
VALUES('$expenseType', '$expenseAmount','$expenseDate')";

  if ($conn->query($query) === TRUE) {
    session_start();
    $_SESSION['message'] = "Savings added successfully";
    echo "<script>window.location.href = 'view-expenses.php';</script>";

    exit;
  } else {
    echo "Error: Failed to Add the Expense.......";
  }
}
?>