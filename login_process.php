<?php
session_start();
require_once('./db/db_connection.php');

$con = OpenCon();

// Sanitize input
$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (validateInput($email, $password)) {
  authenticateUser($email, $password, $con);
} else {
  header("location: login.php");
}



// Function to validate input
function validateInput($email, $password)
{
  $isValid = true;

  if (empty($email)) {
    $_SESSION['email_err'] = "Email is required";
    $isValid = false;
  }

  if (empty($password)) {
    $_SESSION['password_err'] = "Password is required";
    $isValid = false;
  }

  return $isValid;
}

// Function to authenticate user
function authenticateUser($email, $password, $con)
{
  $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      // Set session variables
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['name'] = $user['name'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['role'] = $user['role'];
      $_SESSION['profile_image'] = $user['profile_image'];
      $_SESSION['login'] = true;
      header("location: myorders_admin.php");
      exit;
    } else {
      $_SESSION['password_err'] = "Incorrect password";
    }
  } else {
    $_SESSION['email_err'] = "Email not found";
  }

  $stmt->close();
  header("location: login.php");
  exit;
}
