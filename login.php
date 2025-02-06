<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/login.css" />
    <link rel="stylesheet" href="assets/css/framwork.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>

    <div class="container mobile-block">
        <div class="left-section">
            <img src="assets/images/login-1.jpg" class="active" id="image-1">
            <img src="assets/images/login-2.jpg" id="image-2">
        </div>
        <div class="right-section">
            <span class="fs-14 fw-blod">Welcome To</span>
            <h1 class="m-0 mb-20">Caftereia</h1>
            <form action="{{ route('login') }}" method="POST">
                <div class="form-group">
                    <label for="email">E-mail Or Username</label>
                    <input type="text" id="email" name="email_or_username" placeholder="Enter your email or username"
                        value="">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password">
                    <i class="fas fa-eye toggle-password" id="toggle-password"></i>
                </div>
                <div class="form-group txt-c">
                    <button type="submit" class="btn mb-20">Login</button>
                    <a href="forget_password.php">Forget Password ?</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const images = document.querySelectorAll('.left-section img');
        let currentIndex = 0;

        function changeImage() {
            images[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % images.length;
            images[currentIndex].classList.add('active');
        }

        setInterval(changeImage, 5000); // Change image every 5 seconds

        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('toggle-password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.classList.toggle('fa-eye-slash');
        });
    </script>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</html>