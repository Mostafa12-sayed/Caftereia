<?php
session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header('Location: myorders_admin.php');
    exit;
}

$error = '';
if (!empty($_SESSION['email_err'])) {
    $error_email = '<span class=" alert-danger m-0" >' . $_SESSION['email_err'] . '</span>';
    unset($_SESSION['email_err']);
}
if (!empty($_SESSION['password_err'])) {
    $error_password = '<span class=" alert-danger m-0" >' . $_SESSION['password_err'] . '</span>';
    unset($_SESSION['password_err']);
}
if (!empty($_SESSION['error'])) {
    $error = '<span class=" alert-danger m-0" >' . $_SESSION['error'] . '</span>';
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/framwork.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container mobile-block">
        <div class="left-section">
            <img src="assets/images/login-1.jpg" class="active" id="image-1">
            <img src="assets/images/login-2.jpg" id="image-2">
        </div>
        <div class="right-section">
            <?= $error ?>

            <span class="fs-14 fw-bold">Welcome To</span>
            <h1 class="m-0 mb-20">Cafeteria</h1>
            <form action="login_process.php" method="POST">

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="text" id="email" name="email" placeholder="Enter your email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    <?php if (isset($error_email)) {
                        echo $error_email;
                    } ?>
                </div>

                <!-- Display error messages -->

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="p-relative">
                        <input type="password" id="password" name="password" placeholder="Enter your password">
                        <i class="fas fa-eye toggle-password" id="toggle-password"></i>
                    </div>
                    <div>
                        <?php if (isset($error_password)) {
                            echo $error_password;
                        } ?>
                    </div>
                </div>

                <div class="form-group txt-c mt-10">
                    <button type="submit" class="btn mb-20">Login</button>
                    <a href="forget_password.php">Forget Password?</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Image slider
        const images = document.querySelectorAll('.left-section img');
        let currentIndex = 0;

        function changeImage() {
            images[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % images.length;
            images[currentIndex].classList.add('active');
        }
        setInterval(changeImage, 5000); // Change image every 5 seconds

        // Password toggle
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('toggle-password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.classList.toggle('fa-eye-slash');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>