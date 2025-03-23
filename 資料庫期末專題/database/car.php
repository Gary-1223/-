<?php
session_start();
include 'conn.php'; // 假設這個文件包含連接資料庫的代碼

// 檢查購物車是否存在
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<h2>您的購物車無商品,2秒後跳回主畫面</h2>";
    header("Refresh: 2; URL=main.php"); // 2 秒後跳轉到 main.php
    exit();
}

// 從購物車中獲取商品ID和數量
$cart = $_SESSION['cart'];
$productIDs = array_keys($cart);

// 創建一個查詢來獲取這些商品的詳細信息
$idPlaceholders = implode(',', array_fill(0, count($productIDs), '?'));
$sql = "SELECT * FROM product 
        JOIN category ON product.categoryID = category.categoryID 
        WHERE productID IN ($idPlaceholders)";
$stmt = $conn->prepare($sql);

// 綁定商品ID
$stmt->bind_param(str_repeat('i', count($productIDs)), ...$productIDs);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <title>購物車</title>
</head>
<body>
    <h1><?php echo $_SESSION['username']; ?> 的購物車</h1>
    <table border="1">
        <tr>
            <th>類別</th>
            <th>商品名稱</th>
            <th>價格</th>
            <th>數量</th>
            <th>小計</th>
            <th>操作</th>
        </tr>
        <?php 
        $total = 0;
        while($row = $result->fetch_assoc()): 
            $productID = $row['productID'];
            $quantity = intval($cart[$productID]); // 確保數量是整數類型
            $price = floatval($row['price']); // 確保價格是數字類型
            $subtotal = $price * $quantity;
            $total += $subtotal;
        ?>
        <tr>
            <td><?php echo $row['categoryName']; ?></td>
            <td><?php echo $row['productName']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $quantity; ?></td>
            <td><?php echo $subtotal; ?></td>
            <!-- 添加刪除按鈕 -->
            <td><a href="remove_from_cart.php?id=<?php echo $productID; ?>">刪除</a></td> <!-- 添加刪除按鈕 -->
        </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan="4" align="right">總計</td>
            <td><?php echo $total; ?></td>
        </tr>
    </table>
    <br>
    <!-- 清空購物車按鈕 -->
    
    <form action="clear_cart.php" method="post">
        <input type="submit" value="清空購物車">
    </form>
    <form action="main.php" method="post">
        <input type="submit" value="繼續購物">
    </form>
    <!-- 結帳按鈕 -->
    <form action="checkout.php" method="post">
        <input type="hidden" name="total" value="<?php echo $total; ?>">
        <input type="submit" value="結帳">
    </form>
    
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>


