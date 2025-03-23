<?php
session_start();
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
   
    // 查詢用戶
    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // 驗證舊密碼
        if (password_verify($old_password, $hashed_password)) {
            // 更新密碼
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $hashed_new_password, $id);
            if ($update_stmt->execute()) {
                echo "密碼已成功修改。";
                header("refresh:2;url=login.php");
            } else {
                echo "修改密碼時發生錯誤。";
                header("refresh:2;url=login.php");
            }
        } else {
            echo "舊密碼錯誤。";
            header("refresh:2;url=change_password.php");
        }
    } else {
        echo "用戶名不存在。";
    }

    $stmt->close();
}

$conn->close();
?>

