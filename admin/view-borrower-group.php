<?php
include 'connection/db_connection.php';
session_start();
if (!isset($_SESSION["username"])) {
    header('location: ../index.php');
}

require_once('header_aside.php');

$id = $_GET['id'];
$sql = "SELECT * FROM borrower_groups WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $request_error = 0;
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $location = $row['location'];
    $group_leader = $row['leader'];
    $group_id = $row['id'];
    // $group = $conn->query("SELECT * FROM borrower_groups 
    // WHERE id = $group_id")->fetch_assoc()['name'] ?? 'Undefined Group';
} else {
    $request_error = 1;
}

//Returning the number of borrowers the group has
// $repays = "SELECT * FROM borrowers WHERE group_id = '$id' ORDER BY borrrower_id DESC";
// $result1 = $conn->query($repays);

$repays = "SELECT * FROM borrowers WHERE group_id = '$id' ORDER BY borrower_id DESC";
$result1 = $conn->query($repays);

if ($result1 === false) {
    // Query execution failed, display the error message
    echo "Query failed: " . $conn->error;
} 

//Sum of amount collected

// $repay_repay = "SELECT SUM(amount_collected) as amountCollected FROM repayments WHERE group_id = '$id'";
// $result_repay = $conn->query($repay_repay);
// $row_repay = $result_repay->fetch_assoc();

// $repay_repay = "SELECT SUM(amount_collected) as amountCollected FROM repayments WHERE group_id = '$id'";
// // $result_repay = $conn->query($repay_repay);

// if ($conn->query($repay_repay) === false) {
//     // Query execution failed, display the error message
//     echo "Query failed: " . $conn->error;
// } else {
//     $row_repay = $result_repay->fetch_assoc();
//     // Process the query result
//     // ...
// }


// Total loans Taken by the members of his group
try{
$sql1 = "SELECT COUNT(*) AS loanCount FROM loans LEFT JOIN borrowers ON loans.borrower=borrowers.ninNumber
WHERE borrowers.group_id = '$id'";
$result1 =  $conn->query($sql1);

if ($result1->num_rows > 0) {
    $row_total1 = $result1->fetch_assoc();
    $loanCount = $row_total1['loanCount'];
  
} else {
    // Handle the case when there are no rows returned
    $loanCount =  0;
}

}

catch (mysqli_sql_exception $e) {
    // Handle the error
    echo "Query failed: " . $e->getMessage();
}


// Total loans That were taken and are still active
try{
    $sql4 = "SELECT COUNT(*) AS loanCount1 FROM loans LEFT JOIN borrowers ON loans.borrower=borrowers.ninNumber
    WHERE borrowers.group_id = '$id' AND loans.loan_status='Active' ";
    $result4 =  $conn->query($sql4);
    
    if ($result4->num_rows > 0) {
        $row_total4 = $result4->fetch_assoc();
        $loanCount1 = $row_total4['loanCount1'];
      
    } else {
        // Handle the case when there are no rows returned
        $loanCount1 =  0;
    }
    
    }
    
    catch (mysqli_sql_exception $e) {
        // Handle the error
        echo "Query failed: " . $e->getMessage();
    }

    // Total loans That were taken and are Cleared Already
    try{
        
    $sql5 = "SELECT COUNT(*) AS loanCount2 FROM loans LEFT JOIN borrowers ON loans.borrower=borrowers.ninNumber
    WHERE borrowers.group_id = '$id' AND loans.loan_status='Cleared' ";
    $result5 =  $conn->query($sql5);
    
    if ($result5->num_rows > 0) {
        $row_total5 = $result5->fetch_assoc();
        $loanCount2 = $row_total5['loanCount2'];
      
    } else {
        // Handle the case when there are no rows returned
        $loanCount2 =  0;
    }
    
    }
    
    catch (mysqli_sql_exception $e) {
        // Handle the error
        echo "Query failed: " . $e->getMessage();
    }

// Amount of Loan taken by the borrowers in this group
try{
    $sql2 = "SELECT SUM(total_amount_tobe_paid) AS total_amount_taken FROM loans LEFT JOIN borrowers 
    ON loans.borrower=borrowers.ninNumber WHERE borrowers.group_id = '$id' AND loans.loan_status='Active'";
    $result2 =  $conn->query($sql2);
    
    if ($result2 !== null) {
        $row_total2 = $result2->fetch_assoc();
        $total_amount_taken = $row_total2['total_amount_taken'];
      
    } else {
        // Handle the case when there are no rows returned
        $total_amount_taken =  0;
    }
    
    }
    
    catch (mysqli_sql_exception $e) {
        // Handle the error
        echo "Query failed: " . $e->getMessage();
    }
    
//Total amount repaid by the members of this group
    try{
        $sql3 = "SELECT SUM(amount_collected) AS total_amount_collected FROM repayments LEFT JOIN loans 
        ON repayments.loan=loans.loan_number LEFT JOIN borrowers ON loans.borrower=borrowers.ninNumber
        WHERE borrowers.group_id = '$id' AND loans.loan_status='Active'";
        $result3 =  $conn->query($sql3);
        
        if ($result3 !== null) {
            $row_total3 = $result3->fetch_assoc();
            $total_amount_collected = $row_total3['total_amount_collected'];
          
        } else {
            // Handle the case when there are no rows returned
            $total_amount_collected =  0;
        }
        
        }
        
        catch (mysqli_sql_exception $e) {
            // Handle the error
            echo "Query failed: " . $e->getMessage();
        }
        
        // Retrieve the list of borrowers from the database
        try{
            $borrower_sql = "SELECT * FROM borrowers WHERE group_id='$id'
            ORDER BY created_at DESC";
            $borrower_result = $conn->query($borrower_sql);
            
            }
            
            catch (mysqli_sql_exception $e) {
                // Handle the error
                echo "Query failed: " . $e->getMessage();
            }



$sql = 'SELECT * FROM borrowers ORDER BY created_at DESC';
$result = $conn->query($sql);

//Starting and end month times
$starting_month_date = date('Y-m-01');
$ending_month_date = date('Y-m-t');


?>

<!-- Main Content -->
<main id="main" class="main">

    <!-- align pagetitle on the left and button on the right -->
    <div class="d-flex justify-content-between">
        <div class="pagetitle float-left">
            <h1>View Borrower Group</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">View Borrower group</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <div class="mt-2">
            <?php
            if ($request_error == 1) {
            ?>
                <h4 class="text-muted">Borrower Not Found</h4>
            <?php
                include 'footer.php';
                exit();
            }
            ?>
            <h4 class="text-dark">
                <?php
                echo $name . "        " . $location . "        " ."NabGroup100".$group_id
                ?>
            </h4>
        </div>

        <div class="mt-2">
            <h5 class="text-muted">Group Leadr:<?php echo $group_leader ?></h5>
        </div>
    </div>
    </div>

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-xxl-4 col-xl-12 mt-3">

                        <div class="card info-card customers-card">

                            <div class="card-body">
                                <h5 class="card-title">Current Loans details <span>
                                <?php echo $starting_month_date . " to " . $ending_month_date; ?>
                                </span></h5>

                    <div class="progress">
                    <?php
                    // $percentage = round((40 / 90) * 100, 1);
                    set_error_handler(function(){
                        throw new Exception('Dividing By Zero Occured');
                    });
                    try{
                        $percent = intdiv($total_amount_collected, $total_amount_taken);
                        $percentage = round( $percent* 100, 1);
                    } catch(Exception $e){
                        echo "This group has no any loans yet taken";
                        $percent = 0;
                        $percentage = round( $percent * 100, 1);
                    }

                    restore_error_handler();
                    ?>
                    <div class="progress-bar" role="progressbar" style="<?php echo 'width: ' . $percentage . '%';  ?>" 
                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><?php echo $percentage ?></div>
                  </div>
                                </div>
                                <div class="d-flex justify-content-between" style="font-size: 15px;">
                                    <p class="text-left mt-2 h5">Total Amount Taken: <?php echo $total_amount_taken ?> <br> 
                                   </p>
                                    <p class="text-center mt-2 h5">Total Amount Repaid: <?php echo $total_amount_collected ?> <br>
                                    </p>
                                    <p class=" text-right mt-2 h5 text-danger">Balance: <?php echo ($total_amount_taken - $total_amount_collected) ?> <br> 
                                    </p>
                                </div>

                                <!-- <h4 class="text-center mt-5 text-primary">Repayments</h4> -->

                            </div>
                        </div>
                    </div><!-- End Customers Card -->

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-4 mt-3">
                        <div class="card info-card sales-card">

                            <div class="card-body">
                                <h5 class="card-title">Total Loans Taken By Borrowers In this Group</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cash"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo $loanCount?></h6>
                            
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-4 mt-3">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Cleared Loans By the Borrowers</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <!-- <span class="fs-4">UGX</span> -->
                                        <i class="bi bi-cash"></i>
                                    </div>
                                    <div class="ps-3">
                                    <h6><?php echo $loanCount2?></h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-4 mt-3">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Loans that are Still Active</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center text-warning">
                                        <i class="bi bi-cash"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo $loanCount1?></h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <h2 class="text-center text-muted mt-3">Borrowers That Belong To This Group</h2>

                    <table class="table datatable table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Actions</th>
              <th scope="col">Account Number</th>
              <th scope="col">NIN</th>
              <th scope="col">Name</th>
              <!-- <th scope="col">Last_Name</th> -->
              <!-- <th scope="col">Gender</th> -->
              <th scope="col">Tel</th>
              <!-- <th scope="col">Email</th> -->
              <th scope="col">Location</th>
              <th scope="col">District</th>
              <!-- <th scope="col">Group</th> -->
              <th scope="col">Your Photo</th>
              <!-- <th scope="col">Add Loan</th> -->
            </tr>
          </thead>
          <tbody>

            <?php while ($borrower = $borrower_result->fetch_assoc()) { ?>
              <tr>
                <td scope="row">
                  <a href="view-borrower.php?ninNumber=<?php echo $borrower['ninNumber']; ?>" title="Delete" class="text-danger"><i class="bi bi-eye-fill"></i></a>
                  <a href="edit-borrowers.php?ninNumber=<?php echo $borrower['ninNumber']; ?>" title="Edit" class="text-success"><i class="bi bi-pencil-square"></i></a>
                </td>
                <td><?php echo "NabreBorrowerNB00" . $borrower['borrower_id']; ?></td>
                <td><?php echo $borrower['ninNumber']; ?></td>
                <td><?php echo $borrower['firstname']." ".$borrower['lastname']; ?></td>
                
                <td><?php echo $borrower['phone'] . ", " . $borrower['phone1']; ?></td>
                
                <td><?php echo $borrower['location']; ?></td>
                <td><?php echo $borrower['district']; ?></td>
                <td><?php echo "<a href='" . $borrower['photo'] . "' target='_blank'>View photo</a>"; ?></td>

                <td><a href="add-Loan.php" class="btn btn-success">Add Loan</a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
                    
                </div>
            </div><!-- End Left side columns -->


        </div>
    </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include('footer.php'); ?>