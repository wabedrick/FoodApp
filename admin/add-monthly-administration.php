<?php
session_start();
if (!isset($_SESSION["username"])) {
  header('location: ../index.php');
}

include 'connection/db_connection.php';
?>

<?php include 'header_aside.php'; ?>


<!-- main -->
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Add Monthly Administrative Fees</h1>
    <nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-8">



        <div class="card">
          <div class="card-body">

            <!-- Multi Columns Form -->
            <form action="form1.php" method="post" class="row g-3 mt-3">

              <div class="form-group mt-1">
                <label for="inputCity" class="form-label">Month</label>
                <select class="form-select" name="month" required>
                  <option selected>January</option>
                  <option value="Febrary">Febrary</option>
                  <option value="March">March</option>
                  <option value="Apri">Apri</option>
                  <option value="May">May</option>
                  <option value="June">June</option>
                  <option value="July">July</option>
                  <option value="August">August</option>
                  <option value="September">September</option>
                  <option value="October">October</option>
                  <option value="November">November</option>
                  <option value="December">December</option>
                </select>

              </div>

              <!-- <div>Enter the investment for this month</div> -->

               <div class="form-group mt-1">
                        <label for="group">Household</label>
                        <select name="household" id="household" class="form-control form-control-user" required>
                            <option value="">Select Household</option>

                            <?php
                            $query = "SELECT * FROM household ORDER BY id ASC";
                            $households = $conn->query($query);
                            while ($household = $households->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $household['id'] ?>"> 
                                <?php echo 'NabHH00'. $household['id'] . " - " . $household['name'] ?> 
                              </option>
                            <?php
                            }
                            ?>

                        </select>
                    </div>

              <div class="col-mt-1">
                <label for="inputAddress2" class="form-label">Amount Invested</label>
                <input type="number" class="form-control" id="amountInvested" name="amountInvested" required>
              </div>

              <div class="col-md-6">
                <label for="inputDate" class="form-label">Date</label>
                <input type="date" class="form-control" name="date" id="inputDate">
              </div>


              <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>

              </div>
            </form><!-- End Multi Columns Form -->

          </div>
        </div>

      </div>

    </div>

  </section>

</main><!-- End #main -->

<?php include 'footer.php'; ?> 



