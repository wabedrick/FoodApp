<?php
session_start();
if (!isset($_SESSION["username"])) {
  header('location: ../index.php');
}

include 'connection/db_connection.php';

if($_SERVER['REQUEST_METHOD']='GET' && isset($conn, $_GET['id'])){
    $administrative_id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT * FROM administrative WHERE administrative_id=$administrative_id";
    $result = $conn ->query($sql);
    $row = $result->fetch_assoc();

}
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
            <form action="test.php" method="post" class="row g-3 mt-3">s

              <div class="form-group mt-1">
                <label for="inputCity" class="form-label">Month</label>
                <select class="form-select" name="month" required>
                  <option value="<?php $row['year_month']?>" selected><?php echo $row['year_month']?></option>
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
                            <option 
                            <?php  
                            $query = "SELECT * FROM household ORDER BY id ASC";
                            $households = $conn->query($query);
                            $house = $households->fetch_assoc();
                            ?>
                            value="<?php echo $house['id'] ?>">
                            <?php echo 'NabHH00'. $house['id'] . " - " . $house['name'];  ?>
                           
                            </option>

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
                <label for="inputAddress2"  class="form-label">Amount Invested</label>
                <input type="number" value="<?php echo $row['investment']?>" class="form-control" id="amountInvested" name="amountInvested" required>
              </div>

              <div class="col-md-6">
                <label for="inputDate"  class="form-label">Date</label>
                <input type="date" value="<?php echo $row['date_stored']?>" class="form-control" name="date" id="inputDate">
              </div>


              <div class="text-center">
                <button type="submit" class="btn btn-primary">Update</button>

              </div>
            </form><!-- End Multi Columns Form -->

          </div>
        </div>

      </div>

    </div>

  </section>

</main><!-- End #main -->

<?php include 'footer.php'; ?> 

<?php

if($_SERVER['REQUEST_METHOD'] ==='POST'){
    // include 'connection/db_connection.php';
   
    $month = mysqli_real_escape_string($conn,$_POST['month']);
    $household = mysqli_real_escape_string($conn,$_POST['household']);
    $amountInvested =  mysqli_real_escape_string($conn,$_POST['amountInvested']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    // echo $month;
    // echo $household;
    // echo $amountInvested;
    // echo $date;
    // exit;
    $query = "UPDATE administrative SET `year_month`='$month', `household`='$household', 
    `investment`='$amountInvested', `date_stored`='$date'
    WHERE administrative_id='$administrative_id'";
    
   if ($conn->query($query) === TRUE) {
   session_start();
   $_SESSION['message'] = "Record Updated";
   echo "<script>window.location.href = 'view-monthly-investments.php';</script>";

   exit;
   } else {
  echo "Error: Failed to Add the Record.......";
}

}
?>




