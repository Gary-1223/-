<?php
session_start();

if(isset($_GET['id'])) {
    $productID = $_GET['id'];
    
    // 從購物車中刪除指定商品
    unset($_SESSION['cart'][$productID]);

    // 返回購物車頁面或其他頁面
    header('Location: car.php');
    exit();
} else {
    // 如果未提供商品ID，返回購物車頁面或其他頁面
    header('Location: car.php');
    exit();
}
?>
