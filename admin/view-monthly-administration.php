<?php
session_start();
if (!isset($_SESSION["username"])) {
  header('location: ../index.php');
}

include 'connection/db_connection.php';

$sql = "SELECT * FROM administrative ORDER BY administrative_id DESC";
$result = $conn->query($sql);



//Getting the actual recoveries from the recoveries table in the month of the year
$sql_repayments = "SELECT SUM(amount_collected) AS total_repayments FROM repayments";

$result_repayments = $conn->query($sql_repayments);
$row_repayments = mysqli_fetch_assoc($result_repayments);

$total_repayments = $row_repayments['total_repayments'];

//Getting the month's Gross Profit

$gross_profit = round(($total_repayments / 1.3) * 0.35);

// Getting the total application fees
$sql_fees = "SELECT SUM(application_fee) AS total_application FROM loans";
$result_fees = $conn->query($sql_fees);
$row_fees = mysqli_fetch_assoc($result_fees);
$total_application_fee = $row_fees['total_application'];

// Getting the total processing fees
$sql_processing_fees = "SELECT SUM(processing_fee) AS total_processing FROM loans";
$result_processing_fees = $conn->query($sql_processing_fees);
$row_processing_fees = mysqli_fetch_assoc($result_processing_fees);
$total_processing_fee = $row_processing_fees['total_processing'];

// Getting the total expenses
$sql_expenses = "SELECT SUM(expense_amount) AS total_expenses FROM expenses";
$result_expenses = $conn->query($sql_expenses);
$row_expenses = mysqli_fetch_assoc($result_expenses);
$total_expenses = $row_expenses['total_expenses'];

// Getting the profit before tax
$profit_before_tax = ($gross_profit + $total_application_fee + $total_processing_fee) -
  ($total_expenses);

// Getting the taxes
$taxes = round($profit_before_tax * 0.18);

// Getting the  tithe
$tithe = round(($profit_before_tax - $taxes) * 0.1);

//Calculating the net profit
$net_profit = $profit_before_tax - $taxes - $tithe;

//Getting the amount each household gets at the end of the month known as the administrative cost

$sql = "SELECT SUM(investment) as total_amount_invested, investment FROM administrative 
WHERE date_stored >= DATE(NOW()) - INTERVAL 30 DAY";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
$amount_invested = $row['investment'];
$total_amount_invested = $row['total_amount_invested'];

try{

$administrative_cost_percent = intdiv($amount_invested , $total_amount_invested) * 100;

} catch(DivisionByZeroError $e){
  echo "Error".$e->getMessage();
}

$administrative_cost = $administrative_cost_percent * $net_profit;

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
              <th scope="col">Total Amount Invested</th>
              <th scope="col">Total Recoveries</th>
              <th scope="col">Gross Profit</th>
              <th scope="col">Profit</th>
              <th scope="col">Taxes</th>
              <th scope="col">Tithe</th>
              <th scope="col">Net Profit</th>
              <th scope="col">Administrative Cost</th>


            </tr>
          </thead>
          <tbody>

            <?php while ($admin = $result->fetch_assoc()) { ?>
              <tr>

                <td scope="row"><?php echo $admin['year_month']; ?></td>
                <td><?php echo $admin['amount_invested']; ?></td>
                <td><?php echo $total_repayments; ?></td>
                <td><?php echo $gross_profit; ?></td>
                <td><?php echo $profit_before_tax; ?></td>
                <td><?php echo $taxes; ?></td>
                <td><?php echo $tithe; ?></td>
                <td><?php echo $net_profit; ?></td>
                <td><?php echo $administrative_cost?></td>
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