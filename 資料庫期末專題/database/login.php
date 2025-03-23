<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 查詢用戶
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        // 驗證密碼
        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['username'] = $username;
            header("Location: main.php");
        } else {
            echo "密碼錯誤。";
        }
    } else {
        echo "用戶名不存在。";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入頁面</title>
</head>
<body>
    <h2>登入</h2>
    <form action="login.php" method="post">
        <label for="username">用戶名：</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">密碼：</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="登入">
    </form>
    <p>還沒有帳號？ <a href="register.php">點擊這裡註冊</a></p>
    <p>忘記密碼？ <a href="change_password.php">點擊這裡取得</a></p>
    <input type="submit" value="返回">
</body>
</html>