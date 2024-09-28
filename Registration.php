<?php
session_start();

$nameError = $emailError = $phoneError = $passwordError = $confirmPasswordError = $genderError = $countryError = $skillsError = $bioError = "";
$isValid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name = filter_var(trim($_POST['name']),);
    $email = filter_var(trim($_POST['email']),);
    $phone = filter_var(trim($_POST['phone']),);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $gender = $_POST['gender'];
    $country = $_POST['country'];
    $skills = isset($_POST['skills']) ? $_POST['skills'] : [];
    $biography = filter_var(trim($_POST['biography']),);

    // Validation
    if (empty($name) || !preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $nameError = "Name is required and must contain only letters and spaces.";
        $isValid = false;
    }
    
    if (empty($email) || !filter_var($email,)) {
        $emailError = "A valid email is required.";
        $isValid = false;
    }

    if (empty($phone) || !preg_match("/^\d+$/", $phone)) { // Check if phone is numeric
        $phoneError = "A valid phone number is required and must be numeric.";
        $isValid = false;
    }

    if (empty($password) || strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password)) {
        $passwordError = "Password must be at least 8 characters long and contain at least 1 uppercase letter and 1 number.";
        $isValid = false;
    }

    if ($confirm_password !== $password) {
        $confirmPasswordError = "Passwords do not match.";
        $isValid = false;
    }

    if (empty($gender)) {
        $genderError = "Gender is required.";
        $isValid = false;
    }

    if (empty($country)) {
        $countryError = "Country is required.";
        $isValid = false;
    }

    if (empty($skills)) {
        $skillsError = "At least one skill must be selected.";
        $isValid = false;
    }

    if (empty($biography) || strlen($biography) > 200) {
        $bioError = "Biography is required and cannot exceed 200 characters.";
        $isValid = false;
    }

    // Process data if valid
    if ($isValid) {
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['gender'] = $gender;
        $_SESSION['country'] = $country;
        $_SESSION['skills'] = implode(", ", $skills);
        $_SESSION['biography'] = $biography;

        header('Location: about.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Registration Form</h2>
        <form action="registration.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                <div class="text-danger"><?php echo $nameError ?? ''; ?></div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <div class="text-danger"><?php echo $emailError ?? ''; ?></div>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone No.</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                <div class="text-danger"><?php echo $phoneError ?? ''; ?></div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <div class="text-danger"><?php echo $passwordError ?? ''; ?></div>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                <div class="text-danger"><?php echo $confirmPasswordError ?? ''; ?></div>
            </div>
            <div class="mb-3">
                <label>Gender</label><br>
                <input type="radio" name="gender" value="male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'male') ? 'checked' : ''; ?>> Male<br>
                <input type="radio" name="gender" value="female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'female') ? 'checked' : ''; ?>> Female<br>
                <div class="text-danger"><?php echo $genderError ?? ''; ?></div>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <select class="form-select" id="country" name="country">
                    <option value="">Select Country</option>
                    <option value="Philippines " <?php echo (isset($_POST['country']) && $_POST['country'] == 'USA') ? 'selected' : ''; ?>>Philippines</option>
                    <option value="China" <?php echo (isset($_POST['country']) && $_POST['country'] == 'Canada') ? 'selected' : ''; ?>>China</option>
                    <option value="Japan" <?php echo (isset($_POST['country']) && $_POST['country'] == 'UK') ? 'selected' : ''; ?>>Japan</option>
                </select>
                <div class="text-danger"><?php echo $countryError ?? ''; ?></div>
            </div>
            <div class="mb-3">
                <label>Skills</label><br>
                <input type="checkbox" name="skills[]" value="PHP" <?php echo (isset($_POST['skills']) && in_array('PHP', $_POST['skills'])) ? 'checked' : ''; ?>> PHP<br>
                <input type="checkbox" name="skills[]" value="JavaScript" <?php echo (isset($_POST['skills']) && in_array('JavaScript', $_POST['skills'])) ? 'checked' : ''; ?>> JavaScript<br>
                <input type="checkbox" name="skills[]" value="Python" <?php echo (isset($_POST['skills']) && in_array('Python', $_POST['skills'])) ? 'checked' : ''; ?>> Python<br>
                <div class="text-danger"><?php echo $skillsError ?? ''; ?></div>
            </div>
            <div class="mb-3">
                <label for="biography" class="form-label">Biography</label>
                <textarea class="form-control" id="biography" name="biography"><?php echo isset($_POST['biography']) ? htmlspecialchars($_POST['biography']) : ''; ?></textarea>
                <div class="text-danger"><?php echo $bioError ?? ''; ?></div>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>
</html>
