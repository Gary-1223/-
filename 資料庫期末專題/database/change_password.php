

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改密碼</title>
</head>
<body>
    <h2>修改密碼</h2>
    <form action="change_password_process.php" method="post">
        <label for="username">帳號：</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="old_password">舊密碼：</label>
        <input type="password" id="old_password" name="old_password" required><br><br>
        <label for="new_password">新密碼：</label>
        <input type="password" id="new_password" name="new_password" required><br><br>
        <input type="submit" value="確認修改">
    </form>
    <a href="login.php">返回</a>
</body>
</html>
