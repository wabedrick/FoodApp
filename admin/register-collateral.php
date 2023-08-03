<?php
session_start();
if(!isset($_SESSION["username"])){
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
      <h1>Add Loan's Collateral</h1>
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
          <form action="form.php" method="post" class="row g-3 mt-3" enctype="multipart/form-data">
            <div class="form-group mt-1">
              <label for="group">Borrower</label>
              <select name="borrower" id="borrower" class="form-control form-control-user" required>
                <option value="">Select Borrower</option>
                <?php
                $borrowerQuery = "SELECT * FROM borrowers ORDER BY firstname ASC";
                $borrowerss = $conn->query($borrowerQuery);
                while ($borrower = $borrowerss->fetch_assoc()) {
                ?>
                  <option value="<?php echo $borrower['ninNumber'] ?>"> <?php echo $borrower['firstname'] . " - " . $borrower['ninNumber'] ?> </option>
                <?php
                }
                ?>
              </select>
            </div>


            <div class="col-mt-1">
              <label for="inputAddress2" class="form-label">Loan Number</label>
              <select name="loan" id="loan" class="form-control form-control-user" required>
                <option value="">Select Loan</option>
              </select>
            </div>
            
            <?php
            $loanQuery = "SELECT * FROM loans";
            $loans = $conn->query($loanQuery);
            $loanData = [];
            while ($loan = $loans->fetch_assoc()) {
            $loanData[$loan['borrower']][] = $loan; // Store the entire loan data for each borrower
            }
            ?>

            <script>
              document.addEventListener("DOMContentLoaded", () => {
                const borrowerSelect = document.getElementById("borrower");
                const loanSelect = document.getElementById("loan");
                const loanData = <?php echo json_encode($loanData); ?>;

                borrowerSelect.addEventListener("change", () => {
                  const selectedBorrower = borrowerSelect.value;
                  loanSelect.innerHTML = "<option value=''>Select Loan</option>";

                  if (selectedBorrower !== "") {
                    const borrowerLoans = loanData[selectedBorrower];
                    borrowerLoans.forEach((loan) => {
                      const option = document.createElement("option");
                      option.value = loan.loan_number;
                      option.textContent = loan.loan_number + " - " + loan.borrower;
                      loanSelect.appendChild(option);
                    });
                  }
                });
              });
            </script>


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
              <input type="file" class="form-control" id="inputApproved" name="photo" 
              accept="image/*" required>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>


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