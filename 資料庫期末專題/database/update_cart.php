<?php
session_start();
include 'conn.php'; // 假設這個文件包含連接資料庫的代碼

// 檢查表單提交
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productID = $_POST['productID'];
    $quantity = $_POST['quantity'];

    // 確保購物車存在
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // 更新購物車中的商品數量
    $_SESSION['cart'][$productID] = $quantity;

    // 重新導向到購物車頁面
    header('Location: car.php');
    exit();
}
?>
