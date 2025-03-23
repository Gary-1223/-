<?php
session_start();
include 'conn.php';
// 登入驗證
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// 取得所有商品
$sql = "SELECT * FROM product join category where product.categoryID=category.categoryID";
$result = $conn->query($sql);

// 處理搜尋條件
$search = isset($_GET['search']) ? $_GET['search'] : '';

// 取得所有商品或根據搜尋條件過濾商品
if ($search) {
    $sql = "SELECT * FROM product JOIN category ON product.categoryID = category.categoryID WHERE productName LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM product JOIN category ON product.categoryID = category.categoryID";
}
$result = $conn->query($sql);

// 顯示購物介面
?>

<!DOCTYPE html>
<html>
<head>
    <title>購物車</title>
</head>
<body>
    <h1>歡迎 <?php echo $_SESSION['username']; ?> 購物</h1>

    <!-- 搜尋表單 -->
    <form method="GET" action="">
        <input type="text" name="search" placeholder="搜尋商品名稱" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">搜尋</button>
        <?php if ($search): ?>
            <a href="main.php"><button type="button">取消搜尋</button></a>
        <?php endif; ?>
    </form>

    <h2>商品列表</h2>
    <tr>
        <th>類別</th>
        <th>商品名稱</th>
        <th>價格</th>
        <th>數量</th>
        <th>操作</th><br>
    </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td>
                <form action="update_cart.php" method="POST">
                <td><?php echo $row['categoryName']; ?></td>
                <td><?php echo $row['productName']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <input type="hidden" name="productID" value="<?php echo $row['productID']; ?>">
                <input type="number" name="quantity" value="1" min="1">
                <button type="submit">加入購物車</button>
                </form>
            </td>            
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="logout.php">登出</a>
    <a href="car.php">查看購物車</a>
</body>
</html>

<?php
$conn->close();
?>