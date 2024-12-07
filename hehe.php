<?php 
    include './connect.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập Admin</title>
    <link rel="icon" href="img/logos.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(45deg, #2196f3, #ff4685);
}

.login-container {
    position: relative;
    width: 380px;
    height: 480px;
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 25px rgba(0,0,0,0.2);
}

.login-container::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 380px;
    height: 480px;
    background: linear-gradient(60deg, transparent, #2196f3, #2196f3);
    transform-origin: bottom right;
    animation: animate 6s linear infinite;
}

.login-container::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 380px;
    height: 480px;
    background: linear-gradient(60deg, transparent, #ff4685, #ff4685);
    transform-origin: bottom right;
    animation: animate 6s linear infinite;
    animation-delay: -3s;
}

@keyframes animate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

.login-form {
    position: absolute;
    inset: 2px;
    border-radius: 15px;
    background: #fff;
    z-index: 10;
    padding: 40px;
    display: flex;
    flex-direction: column;
}

.login-form h2 {
    color: #2196f3;
    font-size: 35px;
    font-weight: 600;
    text-align: center;
    margin-bottom: 30px;
}

.input-box {
    position: relative;
    margin-bottom: 30px;
}

.input-box input {
    width: 100%;
    padding: 15px 10px 10px;
    background: transparent;
    border: none;
    outline: none;
    color: #23242a;
    font-size: 1em;
    letter-spacing: 0.05em;
    border-bottom: 2px solid #2196f3;
}

.input-box label {
    position: absolute;
    left: 0;
    padding: 15px 0;
    font-size: 1em;
    color: #8f8f8f;
    pointer-events: none;
    transition: 0.5s;
}

.input-box input:valid ~ label,
.input-box input:focus ~ label {
    color: #2196f3;
    transform: translateY(-25px);
    font-size: 0.85em;
}

.error-message {
    color: #ff4685;
    font-size: 0.9em;
    margin-bottom: 20px;
    text-align: center;
}

.submit-btn {
    border: none;
    outline: none;
    background: #2196f3;
    padding: 15px 25px;
    width: 100%;
    margin-top: 10px;
    border-radius: 25px;
    color: #fff;
    font-size: 1em;
    font-weight: 600;
    cursor: pointer;
    transition: 0.5s;
}

.submit-btn:hover {
    background: #ff4685;
}

.back-home {
    text-align: center;
    margin-top: 20px;
}

.back-home a {
    color: #2196f3;
    text-decoration: none;
    font-size: 0.9em;
    transition: 0.3s;
}

.back-home a:hover {
    color: #ff4685;
}
</style>

<body>
    <div class="login-container">
        <form class="login-form" method="post">
            <h2>Đăng Nhập</h2>
            
            <?php
            if (isset($_POST["dangnhap"])) {
                $email = ($_POST["email"]);
                $matkhau = ($_POST["matkhau"]);
                if (rowCount("SELECT * FROM taikhoan WHERE taikhoan='$email' && matkhau='$matkhau' && status =0") == 1) {
                    setcookie('user', $email, time() + (86400 * 30), "/");
                    header('location:admin/index.php');
                } 
                else if (rowCount("SELECT * FROM taikhoan WHERE status =1") == 1){
                    $error = 'Tài khoản của bạn đã bị khóa';
                }
                else{
                    $error = 'Thông tin đăng nhập không chính xác';
                }
            }
            ?>

            <?php if (isset($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <div class="input-box">
                <input type="text" name="email" required>
                <label>Tài khoản</label>
            </div>

            <div class="input-box">
                <input type="password" name="matkhau" required>
                <label>Mật khẩu</label>
            </div>

            <button type="submit" name="dangnhap" class="submit-btn">
                Đăng Nhập
            </button>

        </form>
    </div>
</body>
</html>