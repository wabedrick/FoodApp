<?php
session_start();
if (!isset($_SESSION["username"])) {
    header('location: ../index.php');
}

include 'connection/db_connection.php';
?>

<?php include 'header_aside.php'; ?>

<!--main content-->
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Adding Repayments From the Borrower</h1>
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
                <form action="process_form1.php" method="post" class="row g-3">


                    <div class="col-md-6">
                        <label for="inputDate" class="form-label">Collection Date</label>
                        <input type="date" class="form-control" name="collectionDate" id="inputDate">
                    </div>

                    <div class="form-group mt-1">
                        <label for="group">Borrower</label>
                        <select name="borrower" id="borrower" class="form-control form-control-user" required>
                            <option value="">Select Borrower</option>

                            <?php
                            $borrowerQuery = "SELECT * FROM borrowers LEFT JOIN loans ON borrowers.ninNumber = 
                            loans.borrower WHERE loan_status = 'Active' ORDER BY firstname ASC";
                            $borrowerss = $conn->query($borrowerQuery);
                            while ($borrower = $borrowerss->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $borrower['ninNumber'] ?>">
                                    <?php echo $borrower['firstname'] . " " . $borrower['lastname'] . " - " . $borrower['ninNumber'] ?>
                                </option>
                                <?php
                            }
                            ?>

                        </select>
                    </div>

                    <div class="form-group mt-1">
                        <label for="group">Loan Number</label>
                        <select name="loan" id="loan" class="form-control form-control-user" required>
                            <option value="">Select Loan Number</option>

                            <?php
                
                            $loanQuery = "SELECT * FROM loans LEFT JOIN borrowers 
                            ON loans.borrower = borrowers.ninNumber WHERE loan_status='Active'";
                            $loans = $conn->query($loanQuery);
                            while ($loan = $loans->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $loan['loan_number'] ?>">
                                    <?php echo $loan['loan_number']."-".$loan['borrower'] ?>
                                </option>
                                <?php
                            }
                            ?>

                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="inputEmail3" class="form-label">Collected By</label>
                        <input type="text" class="form-control" id="inputEmail3" name="collectedBy" placeholder="Collected By">
                    </div>

                    <div class="col-md-6">
                        <label for="inputAddress2" class="form-label">Amount Collected</label>
                        <input type="number" class="form-control" id="inputRequested" name="amountCollected" placeholder="Amount Collected">
                    </div>


                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Handle borrower selection change event
        $('#borrower').on('change', function () {
            var borrowerId = $(this).val();

            // Make an AJAX request to fetch the loans for the selected borrower
            $.ajax({
                url: 'fetch_loans.php',
                method: 'POST',
                data: {borrowerId: borrowerId},
                success: function (response) {
                    $('#loan').html(response);
                }
            });
        });
    });
</script>
