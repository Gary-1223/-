<?php
session_start();

// 清空購物車
unset($_SESSION['cart']);

// 跳轉回購物車頁面或其他頁面
header('Location: car.php');
exit();
?>

