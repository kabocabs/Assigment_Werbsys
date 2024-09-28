<?php
session_start();

if (!isset($_SESSION['name'])) {
    header('Location: registration.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
    <h2>User Details</h2>
       <p>Personal Information:</p>
       <p><strong>Name:</strong> <?php echo $_SESSION['name']; ?></p>
       <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
       <p><strong>Phone No:</strong> <?php echo $_SESSION['phone']; ?></p>
       <p><strong>Gender:</strong> <?php echo $_SESSION['gender']; ?></p>
       <p><strong>Country:</strong> <?php echo $_SESSION['country']; ?></p>
       <p><strong>Skills:</strong> <?php echo $_SESSION['skills']; ?></p>
       <p><strong>Biography:</strong> <?php echo $_SESSION['biography']; ?></p>

        <a href="registration.php" class="btn btn-primary">Back</a>
    </div>
</body>
</html>
