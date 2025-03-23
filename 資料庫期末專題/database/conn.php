<?php
// 連接到資料庫
$servername = "localhost";
$username = "root";
$password = ""; // 根據您的設置修改
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}
?>