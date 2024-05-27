<?php
session_start();
if(!isset($_SESSION["username"])){
    header('location: ../index.php');
}

include 'connection/db_connection.php';
?>

<?php include 'header_aside.php'; ?>


<!--main content-->
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Add Loan</h1>
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
              <form action="add-loan-form.php" method="post" class="row g-3" enctype="multipart/form-data">
                <div class="col-md-12">
                  <label for="inputName5" class="form-label">Loan Type</label>
                  <input type="text" class="form-control" name="loanType" id="loanType" required>
                  <!-- <select class="form-select" name="loanType" id="floatingSelect" aria-label="State" required>
                      <option selected>Business Loan</option>
                      <option value="Personal Loan">Personal Loan</option>
                      <option value="Student Loan">Student Loan</option>
                    </select> -->
                </div>

                
                <div class="form-group mt-1">
          <label for="group">Borrower</label>
          <select name="borrower" id="borrower" class="form-control form-control-user" required>
            <option value="">Select Borrower</option>

            <?php
                $borrowerQuery = "SELECT * FROM borrowers INNER JOIN loans ON borrowers.ninNumber = 
                loans.borrower WHERE loan_status != 'Active' AND loan_status != 'Expired'
                ORDER BY firstname ASC";
                $borrowerss= $conn -> query($borrowerQuery);
                while($borrower = $borrowerss->fetch_assoc()) {
                  ?>
                  <option value="<?php echo $borrower['ninNumber'] ?>" > <?php echo $borrower['firstname']." - ".$borrower['ninNumber'] ?> </option>
                  <?php
                }
            ?>

          </select>
        </div>
            
                <div style="color:blue"><h3>Loan Terms</h3></div>
                <div class="col-md-6">
                  <label for="inputEmail3" class="form-label">Distributed By</label>
                  <select class="form-select" name="distributedBy" required>
                  <option selected>Cash</option>
                      <option value="Cheque">Cheque</option>
                    </select>
                </div>

                <div class="col-md-6">
                  <label for="inputDate" class="form-label">Loan Release date</label>
                  <input type="date" class="form-control" name="loanReleaseDate" id="inputDate" required>
                </div>

                <div class="col-md-6">
                  <label for="inputAddress2" class="form-label">Amount Requested</label>
                  <input type="number" class="form-control" id="inputRequested" 
                  name="amountRequested" placeholder="Amount Requested" required>
                </div>

                <div class="col-md-6">
                  <label for="inputAddress2" class="form-label">Processing Fees</label>
                  <input type="number" class="form-control" id="inputProcessing" value=5000 
                  name="processingFee" required>
                </div>

                <div class="col-md-6">
                  <label for="inputAddress2" class="form-label">Amount Approved</label>
                  <input type="number" class="form-control" id="inputApproved" name="amountApproved"
                   placeholder="Amount Approved" required>
                </div>

                <div class="col-md-6">
                  <label for="inputAddress2" class="form-label">Application Fees</label>
                  <input type="number" class="form-control" id="inputProcessing" value=15000 
                  name="applicationFee" Required>
                </div>

                <div class="col-md-6">
                  <label for="inputCity" class="form-label">Loan Period(Months)</label>
                  <select class="form-select" name="loanPeriod" required>
                  <option selected>1</option>
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
                  <select class="form-select"name="interestRate" required>
                  <option value="5" selected>5</option>
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
              <input type="text" class="form-control" id="collateralName" name="collateralName" placeholder="Collateral Name" required>
            </div>

            <div class="col-md-6">
              <label for="inputAddress2" class="form-label">Serial Number</label>
              <input type="text" class="form-control" id="inputSerial" name="serialNumber" placeholder="Serial Number" required>
            </div> 

            <div class="col-mt-1">
              <label for="inputAddress2" class="form-label">Upload photo</label>
              <input type="file" class="form-control" id="inputApproved" name="photo" accept="image/*" required>
            </div>

            <div style="color:blue"><h3>Trustee's Information</h3></div>

           <div class="col-md-6">
            <label for="inputEmail3" class="form-label">Trustee Name</label>
            <input type="text" class="form-control" id="trusteeName" name="trusteeName" placeholder="Trustee Name" required>
           </div>

           <div class="col-md-6">
            <label for="inputAddress2" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="trusteeNumber" name="trusteeNumber" placeholder="Phone Number" required>
           </div>

                 <!-- <hr>
                <div class="col-md-6" text-align:center>
                <a href="register-collateral.php" style="font-family: bold; font-size: 12pt;">ADD COLLATERAL</a>
                </div>
                <hr>  -->

               
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
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

  <!-- ======= Footer ======= -->
  <?php include 'footer.php'; ?>
