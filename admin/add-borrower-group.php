<?php
session_start();
if(!isset($_SESSION["username"])){
    header('location: ../index.php');
}
?>

<?php include 'header_aside.php'; ?>

  <main id="main" class="main">

  <?php if(isset($_SESSION['message'])) {?>
    <div class="container" id="message-container">
        <div class="row">
            <div class="col-md-12">
            <div class="alert alert-danger d-flex justify-content-between align-items-center">
                   <?php echo $_SESSION['message']; ?>
                   <!-- add button for removing the alert message -->
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    <?php } unset($_SESSION['message']); ?>

  <section class="section">
      <!--form for adding borrowers-->
      <form method="POST" action="add-borrower-group.php" class="col-lg-6">
        <div>
          <h1 class="h3 mb-4 text-gray-800">Fill the form bellow to add a borrower group</h1>
        </div>

  
  <div class="form-group mt-2">
    <label for="group_name">Group Name</label>
    <input type="text" name="group_name" id="lastname" class="form-control form-control-user" required>
  </div>
  
  <div class="form-group mt-2">
    <label for="ninNumber">Location</label>
    <input type="text" name="location" id="location" class="form-control form-control-user" required>
  </div>

   
  <div class="form-group mt-2">
    <label for="ninNumber">District</label>
    <input type="text" name="district" id="district" class="form-control form-control-user" required>
  </div>
  
  <div class="form-group mt-2">
    <label for="title">Contact</label>
    <input type="text" placeholder="Phone Number: 0700000000" pattern="[0]{1}[7]{1}[0-9]{8}" name="contact" id="title" class="form-control form-control-user">
  </div>

  <div class="form-group mt-2">
    <label for="title">Group leader</label>
    <input type="text" name="leader" id="title" class="form-control form-control-user">
  </div>
  
  <div class="form-group mt-2">
  <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="Register Group">
  </div>

</form>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
<?php include 'footer.php'; ?>



<?php
include 'connection/db_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $group_name = $conn->real_escape_string($_POST['group_name']);
  $location = $conn->real_escape_string($_POST['location']);
  $district = $conn->real_escape_string($_POST['district']);
  $contact = $conn->real_escape_string($_POST['contact']);
  $leader = $conn->real_escape_string($_POST['leader']);



  $nameQuery = "SELECT * FROM borrower_groups WHERE `name` = '$group_name'";
  $nameResult = $conn->query($nameQuery);
  if ($nameResult->num_rows > 0) {
    $_SESSION['message'] = "Group name already exists";
    echo "<script>window.location.href = 'view-borrower-groups.php';</script>";
    exit;
  }

$sql =  "INSERT INTO borrower_groups (name, location, district, contact, leader) 
VALUES('$group_name','$location', '$district', '$contact','$leader')";

  if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "Borrower group added successfully";
    echo "<script>window.location.href = 'view-borrower-groups.php';</script>";
    exit;
  } else {
    echo "Error: " . $conn->error;
  }
}
?>