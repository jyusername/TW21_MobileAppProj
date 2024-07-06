<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $gender = strtolower(trim($_POST['gender']));
    $age = $_POST['age'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $postal_code = $_POST['postal_code'];

    // Validation
    $errors = [];

    if (!in_array($gender, ['male', 'female'])) {
        $errors['gender'] = "Value must be Male or Female.";
    }

    if ($age < 12 || $age > 98) {
        $errors['age'] = "Age must be a valid number between 12 and 98.";
    }

    if (!preg_match("/^[0-9]{11}$/", $contact_number)) {
        $errors['contact_number'] = "Contact number must be an 11-digit number.";
    }

    if (!preg_match("/^[0-9]{4}$/", $postal_code)) {
        $errors['postal_code'] = "Postal code must be a 4-digit number.";
    }

    if (empty($name)) {
        $errors['name'] = "Name is required.";
    }

    if (empty($username)) {
        $errors['username'] = "Username is required.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    }

    if (empty($address)) {
        $errors['address'] = "Address is required.";
    }

    if (empty($errors)) {

        $_SESSION['user'] = [
            'name' => $name,
            'username' => $username,
            'password' => $password,
            'gender' => ucfirst($gender),
            'age' => $age,
            'contact_number' => $contact_number,
            'address' => $address,
            'postal_code' => $postal_code,
        ];

        // Redirect to a success page or login page
        header("Location: login.php");
        exit;
    } else {
        // Handle errors
        $_SESSION['errors'] = $errors;
        header("Location: signup.php");
        exit;
    }
}
?>
