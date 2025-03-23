<?php
session_start();

if(isset($_POST['total'])) {
    $total = $_POST['total'];
    // 顯示已付款小計的金額
    echo "<h2>已付款小計： $total</h2>";
    unset($_SESSION['cart']);
    header("refresh:2;url=main.php");
    exit();
} else {
    echo "<h2>無法獲取小計</h2>";
}
?>

