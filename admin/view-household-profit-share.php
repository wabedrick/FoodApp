<?php
session_start();
if (!isset($_SESSION["username"])) {
  header('location: ../index.php');
}

include 'connection/db_connection.php';

$sql = "SELECT * FROM administrative ORDER BY administrative_id DESC";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

//Amount shared by each House hold
// if($row['year_month']=='July'){
$query1 = "SELECT SUM(investment) AS total_amount_invested, investment 
FROM administrative WHERE date_stored >= DATE(NOW()) - INTERVAL 30 DAY";
$result = $conn->query($query1);

$row1 = $result->fetch_assoc();
$share_percent = ($row1['investment'] / $row1['total_amount_invested']) * 100;


$sql2 = "SELECT SUM(processing_fee) AS total_process_month FROM loans
WHERE release_date >= DATE(NOW()) - INTERVAL 30 DAY";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
$totalProcessingFees = $row2['total_process_month'];

//Total amount of application fee received this month
$sql3 = "SELECT SUM(application_fee) AS total_apply_month FROM loans
WHERE release_date >= DATE(NOW()) - INTERVAL 30 DAY";
$result3 = mysqli_query($conn, $sql3);
$row3 = mysqli_fetch_assoc($result3);
$totalApplicationFees = $row3['total_apply_month'];

// Total amount of repayment made this month
$sql4 = "SELECT COUNT(*) AS total_repayments_month FROM repayments 
WHERE collection_date >= DATE(NOW()) - INTERVAL 30 DAY";
$result4 = mysqli_query($conn, $sql4);
$row4 = mysqli_fetch_assoc($result4);
$totalRepaymentCount = $row4['total_repayments_month'];

// Total repayment made this month
$sql5 = "SELECT SUM(amount_collected) AS total_recoveries_month FROM repayments 
WHERE collection_date >= DATE(NOW()) - INTERVAL 30 DAY";
$result5 = mysqli_query($conn, $sql5);
$row5 = mysqli_fetch_assoc($result5);
$totalRepayment = $row5['total_recoveries_month'];

//Getting the gross profit
$gross_profit = round(($totalRepayment / 1.3) * 0.35);

//Total expenses in a month
$sql_expenses = "SELECT SUM(expense_amount) AS total_expenses FROM expenses
WHERE expense_date >= DATE(NOW()) - INTERVAL 30 DAY";
$result_expenses = $conn->query($sql_expenses);
$row_expenses = mysqli_fetch_assoc($result_expenses);
$total_expenses = $row_expenses['total_expenses'];

//Total amount of processing and application fees received this month
$totalFeesMonth = $totalProcessingFees + $totalApplicationFees;

// Getting the profit before tax
$profit_before_tax = ($gross_profit + $totalFeesMonth) -($total_expenses);

// Getting the taxes
$taxes = round($profit_before_tax * 0.18);

// Getting the  tithe
$tithe = round(($profit_before_tax - $taxes) * 0.1);

//Calculating the net profit
$net_profit = $profit_before_tax - $taxes - $tithe;

//Amount each house hold gets at the end of the month
$administrative_cost = $share_percent * $net_profit;

//}

?>

<?php include 'header_aside.php'; ?>

<!--main-->
<main id="main" class="main">

  <?php if (isset($_SESSION['message'])) { ?>
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
  <?php }
  unset($_SESSION['message']); ?>


  <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
        <h2>View all the monthly administrative Costs Here</h2>
        <hr>
        </div>
        
        <table class="table datatable table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Month</th>
              <th scope="col">Household</th>
              <!-- <th scope="col">Amount Invested</th> -->
              <th scope="col">Profit</th>

            </tr>
          </thead>
          <tbody>

            <?php while ($admin = $result->fetch_assoc()) { ?>
              <tr>

                <td scope="row"><?php echo $admin['year_month']; ?></td>
                <td><?php echo $admin['household']; ?></td>
                <td><?php echo $admin['investment']; ?></td>
                <td><?php echo $admin['date_stored']; ?></td>
                <td><?php echo $administrative_cost ?></td>

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