
<?php
// Include the database configuration file
include 'connection/db_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] ==='POST') {
  // Validate and sanitize the form input
  $collection_date = $conn->real_escape_string($_POST['collectionDate']);
  $borrower = $conn->real_escape_string($_POST['borrower']);
  $loan = $conn->real_escape_string($_POST['loan']);
  $collected_by = $conn->real_escape_string($_POST['collectedBy']);
  $amount_collected = $conn->real_escape_string($_POST['amountCollected']);

  //Adding the amount collected by each borrower
    $sql = "SELECT SUM(amount_collected) AS total_amount_collected FROM repayments WHERE loan='$loan' AND borrower='$borrower'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_amount_collected = $row['total_amount_collected'];

    if($total_amount_collected===0){
    $total_amount_collected = $amount_collected;
    }
    else{
      $total_amount_collected += $amount_collected;
    }
    
  //Storing the balance remaining to clear the loan
    
    $sql = "SELECT * FROM loans WHERE loan_number='$loan' AND borrower='$borrower'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $amount_tobe_paid = $row['total_amount_tobe_paid'];


    //Calculate the balance remaining
    $balance_remaining = $amount_tobe_paid - $total_amount_collected;


$sql =  "INSERT INTO repayments(collection_date, borrower, loan, collected_by, amount_collected,
total_amount_collected, balance)
VALUES ('$collection_date','$borrower','$loan','$collected_by','$amount_collected','$total_amount_collected', '$balance_remaining')";

if ($conn->query($sql) === TRUE) {
  session_start();
echo "<script>window.location.href = 'view-repayments.php';</script>";

exit;
} else {
  echo "Error: Failed to add it to the database.......";
}

}

?>