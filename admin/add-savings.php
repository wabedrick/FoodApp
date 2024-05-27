<?php
session_start();
if (!isset($_SESSION["username"])) {
    header('location: ../index.php');
    exit; // Add exit here to stop further execution
}

include 'connection/db_connection.php';

?>

<?php include 'header_aside.php'; ?>

<!--main content-->
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Add Savings</h1>
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
                <form action="add-savings.php" method="post" class="row g-3 mt-2">

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

                    <div class="col-md-6">
                        <label for="inputAddress2" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="inputAmount" name="amount" placeholder="Amount">
                    </div>

                    <div class="col-md-6">
                        <label for="inputDate" class="form-label">Date Saved</label>
                        <input type="date" class="form-control" name="date-saved" id="inputDate">
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
    </div>
    </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include 'footer.php'; ?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $borrower = isset($_POST['borrower']) ? mysqli_real_escape_string($conn, $_POST['borrower']) : null;
        $amount = isset($_POST['amount']) ? mysqli_real_escape_string($conn, $_POST['amount']) : null;
        $date_saved = isset($_POST['date-saved']) ? mysqli_real_escape_string($conn, $_POST['date-saved']) : null;

        if (!$borrower || !$amount || !$date_saved) {
            throw new Exception("Required fields are missing.");
        }

        $sql_total = "SELECT SUM(amount) AS amount,SUM(amount_withdrew) AS amount_withdrew, 
        total_amount FROM savings WHERE borrower = '$borrower' ORDER BY savings_id LIMIT 1";
        $result = $conn->query($sql_total);
        $row = mysqli_fetch_assoc($result);

        $total_amount = $row['total_amount'];
        if ($total_amount === null) {
            // $existingValue = $row['amount'];
            $total_amount =  $amount;
        } else {
            // $existingValue = $row['total_amount'];
            $total_amount += $amount;
        }
        if($row['amount'] - $row['amount_withdrew']==0){
            $balance = $total_amount;
        }
        else{
        $balance = ($row['amount'] + $amount) - $row['amount_withdrew'];
        }

        $query = "INSERT INTO savings(borrower, amount, total_amount, date_saved, balance)
            VALUES('$borrower', '$amount','$total_amount', '$date_saved', '$balance')";

        if ($conn->query($query) === TRUE) {
            session_start();
            $_SESSION['message'] = "Savings added successfully";
            echo "<script>window.location.href = 'view-savings.php';</script>";
            exit;
        } else {
            throw new Exception("Error: Failed to add the savings.");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
