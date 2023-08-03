<?php
session_start();
if (!isset($_SESSION["username"])) {
  header('location: ../index.php');
}
?>

<?php
include 'connection/db_connection.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
  $expenseID = $conn->real_escape_string($_GET['id']);
   
  try{
  $sql = "SELECT * FROM expenses WHERE expense_id='$expenseID' ";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  } catch(mysqli_sql_exception $e){
    echo "Error".$e->getMessage();
  }
} 

// $sql = "SELECT * FROM expenses";
// $result = $conn->query($sql);
// $row = $result->fetch_assoc();

?>

<?php include 'header_aside.php'; ?>

<!--main content-->
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Edit/Update Expenses</h1>
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
        <form action="edit-expenses.php" method="post" class="row g-3 mt-2">

          <div class="form-group mt-1">

            <label for="inputCity" class="form-label">Expense Type</label>
            <input type="text" class="form-control" name="expenseType" 
            value="<?php $row['expense_type']; ?>" id="inputAmount" required>

          </div>

          <div class="col-md-6">
            <label for="inputAddress2" class="form-label">Expense Amount</label>
            <input type="number" class="form-control" value="<?php $row['expense_amount']; ?>" id="inputAmount" name="expenseAmount" required>
          </div>

          <div class="col-md-6">
            <label for="inputDate" class="form-label">Expense Date</label>
            <input type="date" class="form-control" value="<?php $row['expense_date']; ?>" name="expenseDate" id="inputDate" required>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary">Update Expense</button>

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