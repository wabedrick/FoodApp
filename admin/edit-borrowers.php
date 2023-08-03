<?php
session_start();
if (!isset($_SESSION["username"])) {
  header('location: ../index.php');
}

include 'connection/db_connection.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ninNumber'])) {
  $ninNumber = $conn->real_escape_string($_GET['ninNumber']);

  $sql = "SELECT * FROM borrowers WHERE ninNumber='$ninNumber'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
} 

?>

<?php include 'header_aside.php'; ?>

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
  <form method="POST" action="edit-borrowers.php" class="col-lg-6">
    <div>
      <h1 class="h3 mb-4 text-gray-800">Edit From Here</h1>
    </div>
    <div class="form-group">
      <label for="firstname">First Name:</label>
      <input type="text" name="firstname" id="firstname" value="<?php echo $row['firstname'] ?>" class="form-control form-control-user" required>
    </div>

    <div class="form-group mt-1">
      <label for="lastname">Last Name:</label>
      <input type="text" name="lastname" id="lastname" value="<?php echo $row['lastname'] ?>" class="form-control form-control-user" required>
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
      <input type="text" name="ninNumber" id="ninNumber" value="<?php echo $row['ninNumber'] ?>" class="form-control form-control-user" required>
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
      <input type="text" name="phone" id="phone" value="<?php echo $row['phone'] ?>" class="form-control form-control-user" required>
    </div>


    <div class="form-group mt-1">
      <label for="title">Second Number:</label>
      <input type="text" name="phone1" id="phone1" value="<?php echo $row['phone1'] ?>" class="form-control form-control-user">
    </div>

    <div class="form-group mt-1">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" value="<?php echo $row['email'] ?>" class="form-control form-control-user"
      placeholder="example@exaple.com">
    </div>

    <div class="form-group mt-1">
      <label for="location">Location/Place:</label>
      <input type="text" name="location" id="location" value="<?php echo $row['location'] ?>" class="form-control form-control-user" required>
    </div>

    <div class="form-group mt-1">
      <label for="district">District:</label>
      <input type="text" name="district" id="district" value="<?php echo $row['district'] ?>" class="form-control form-control-user" required>
    </div>

    <div class="form-group mt-2">
      <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="Update">
    </div>

  </form>
</section>

</main>

<?php include 'footer.php'; ?>


<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Escape the values to prevent SQL injection (optional but recommended)
$ninNumber = $conn->real_escape_string($_POST['ninNumber']);
$firstname = $conn->real_escape_string($_POST['firstname']);
$lastname = $conn->real_escape_string( $_POST['lastname']);
$gender = $conn->real_escape_string($_POST['gender']);
$phone = $conn->real_escape_string($_POST['phone']);
$phone1 = $conn->real_escape_string($_POST['phone1']);
$email = $conn->real_escape_string($email);
$location = $conn->real_escape_string($_POST['location']);
$district = $conn->real_escape_string($_POST['district']);

// Update the record in the database
$sql = "UPDATE borrowers SET firstname='$firstname', lastname='$lastname', gender='$gender',
phone='$phone', phone1='$phone1',email = '$email', location='$location', district='$district'
WHERE ninNumber = '$ninNumber'";
if ($conn->query($sql)) {
    // Record updated successfully
    echo "<script>window.location.href = 'view-borrowers.php';</script>";
    // header("Location: view-borrowers.php");
    exit();
} else {
    // Error occurred while updating the record
    echo "Error: " . $mysqli->error;
}

// Close the database connection
$mysqli->close();
}
?>
