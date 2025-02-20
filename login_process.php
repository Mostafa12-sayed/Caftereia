<?php
session_start();
require_once('./connection_db.php'); // تأكد من تضمين ملف الاتصال

$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (validateInput($email, $password)) {
  authenticateUser($email, $password);
} else {
  header("location: login.php");
  exit;
}

// دالة التحقق من صحة الإدخال
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

function authenticateUser($email, $password)
{
  global $pdo;

  try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if (password_verify($password, $user['password'])) {
        // بدء الجلسة وتخزين بيانات المستخدم
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['profile_image'] = $user['profile_image'];
        $_SESSION['login'] = true;
        if ($user['role'] == "admin") {

          header("location: myorders_admin.php");
        } else {
          header("location: myorders_user.php");
        }
        exit;
      } else {
        $_SESSION['password_err'] = "Incorrect password";
      }
    } else {
      $_SESSION['email_err'] = "Email not found";
    }

    header("location: login.php");
    exit;
  } catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
  }
}
