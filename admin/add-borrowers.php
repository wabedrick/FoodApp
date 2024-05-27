<?php
include 'connection/db_connection.php';
session_start();
if(!isset($_SESSION["username"])){
    header('location: ../index.php');
}
?>

<?php include 'header_aside.php'; ?>

<!--main content-->
  <main id="main" class="main">

    <?php if (isset($_SESSION['message'])) { ?>
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
    <?php }
    unset($_SESSION['message']); ?>

    <section class="section">
      <!--form for adding borrowers-->
      <form method="POST" action="add-borrowers.php" class="col-lg-6" enctype="multipart/form-data">
        <div>
          <h1 class="h3 mb-4 text-gray-800">Fill the form bellow to add a borrower</h1>
        </div>
        <div class="form-group">
          <label for="firstname">First Name:</label>
          <input type="text" name="firstname" id="firstname" class="form-control form-control-user" required>
        </div>

        <div class="form-group mt-1">
          <label for="lastname">Last Name:</label>
          <input type="text" name="lastname" id="lastname" class="form-control form-control-user" required>
        </div>

        <div class="form-group mt-1">
          <label for="group">Group</label>
          <select name="group" id="group" class="form-control form-control-user" required>
            <option value="">Select Group</option>

            <?php
            $groupQuery = "SELECT * FROM borrower_groups";
            $groups = $conn->query($groupQuery);
            while ($group = $groups->fetch_assoc()) {
            ?>
              <option value="<?php echo $group['id'] ?>"> <?php echo $group['name'] ?> </option>
            <?php
            }
            ?>

          </select>
        </div>


        <div class="form-group mt-1 ">
          <label for="ninNumber">NIN Number:</label>
          <input type="text" name="ninNumber" id="ninNumber" class="form-control form-control-user" required>
        </div>

        <div class="form-group mt-1">
          <label for="gender">Gender:</label>
          <select name="gender" id="gender" class="form-control form-control-user" required>
            <option value="">Select</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>

        <div class="form-group mt-1">
          <label for="phone">Phone Number:</label>
          <input type="text" name="phone" id="phone" class="form-control form-control-user" required>
        </div>


        <div class="form-group mt-1">
          <label for="title">Second Number:</label>
          <input type="text" name="phone1" id="phone1" class="form-control form-control-user">
        </div>

        <div class="form-group mt-1">
          <label for="email">Email:</label>
          <input type="email" name="email" id="email" class="form-control form-control-user"
          placeholder="example@exaple.com">
        </div>

        <div class="form-group mt-1">
          <label for="location">Location/Place:</label>
          <input type="text" name="location" id="location" class="form-control form-control-user" required>
        </div>

        <div class="form-group mt-1">
          <label for="district">District:</label>
          <input type="text" name="district" id="district" class="form-control form-control-user" required>
        </div>

        <div class="col-mt-1">
          <label for="inputAddress2" class="form-label">Add Photo</label>
          <input type="file" class="form-control" id="inputApproved" name="photo" accept="image/*" required>
        </div>

        <div class="form-group mt-2">
          <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="Register">
        </div>

      </form>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include 'footer.php'; ?>


<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Validate and sanitize the form input
  $firstname = $conn->real_escape_string($_POST['firstname']);
  $lastname = $conn->real_escape_string($_POST['lastname']);
  $ninNumber = $conn->real_escape_string($_POST['ninNumber']);
  $group_id = $conn->real_escape_string($_POST['group']);
  // $title = $conn->real_escape_string($_POST['title']);
  $gender = $conn->real_escape_string($_POST['gender']);
  $phone = $conn->real_escape_string($_POST['phone']);
  $phone1 = $conn ->real_escape_string($_POST['phone1']);
  $email = $conn->real_escape_string($_POST['email']);
  $location = $conn->real_escape_string($_POST['location']);
  $district = mysqli_real_escape_string($conn, $_POST['district']);

  $photoName = $_FILES['photo']['name'];
  $imageFileType = strtolower(pathinfo($photoName, PATHINFO_EXTENSION));
  $photoTempPath = $_FILES['photo']['tmp_name'];
  $photoUploadPath = '../uploads/' . $firstname . "_" . $ninNumber.".".$imageFileType; 

    // Move the uploaded photo to the desired location
    move_uploaded_file($photoTempPath, $photoUploadPath);


  $ninQuery = "SELECT * FROM borrowers WHERE ninNumber = '$ninNumber'";
  $ninResult = $conn->query($ninQuery);
  if ($ninResult->num_rows > 0) {
    $_SESSION['message'] = "Borrower NIN already exists in the database.";
    echo "<script>window.location.href = 'add-borrowers.php';</script>";
    exit;
  }

  $phoneQuery = "SELECT * FROM borrowers WHERE phone = '$phone'";
  $phoneResult = $conn->query($phoneQuery);
  if ($phoneResult->num_rows > 0) {
    $_SESSION['message'] = "Phone number already exists";
    echo "<script>window.location.href = 'add-borrowers.php';</script>";
    exit;
  }

  $sql =  "INSERT INTO borrowers
  (firstname,lastname,ninNumber,gender,phone, phone1, email, location, district, group_id, photo) 
  VALUES('$firstname','$lastname','$ninNumber','$gender','$phone', '$phone1', '$email', '$location', 
  '$district', '$group_id', '$photoUploadPath')";

  if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "Borrower added successfully";
    echo "<script>window.location.href = 'view-borrowers.php';</script>";
    exit;
  } else {
    echo "Error: " . $conn->error;
  }
}
?>