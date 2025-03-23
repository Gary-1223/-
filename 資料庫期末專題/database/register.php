<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>註冊</title>
    <!-- 添加內嵌樣式表，用於美化表單 -->
    <style>
      /* 設置整體頁面的樣式 */
      body {
          font-family: Arial, sans-serif; /* 設置字體 */
          background-color: #4472CA; /* 設置背景顏色 */
          display: flex; /* 使用 flexbox 進行布局 */
          justify-content: center; /* 水平居中 */
          align-items: center; /* 垂直居中 */
          height: 100vh; /* 設置高度為視窗高度 */
          margin: 0; /* 去除默認的頁面邊距 */
      }
      /* 設置表單容器的樣式 */
      .container {
          background-color: #fff; /* 設置背景顏色為白色 */
          padding: 20px 40px; /* 設置內邊距 */
          border-radius: 10px; /* 設置圓角邊框 */
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* 添加陰影效果 */
      }
      /* 設置標題樣式 */
      h2 {
          text-align: center; /* 居中對齊 */
          margin-bottom: 20px; /* 底部外邊距 */
          color: #333; /* 設置文字顏色 */
      }
      /* 設置標籤樣式 */
      label {
          font-weight: bold; /* 設置字體加粗 */
          display: block; /* 設置為塊級元素 */
          margin-bottom: 5px; /* 底部外邊距 */
          color: #555; /* 設置文字顏色 */
      }
      /* 設置文本輸入框和密碼輸入框的樣式 */
      input[type="text"], input[type="password"] {
          width: 100%; /* 設置寬度為100% */
          padding: 10px; /* 設置內邊距 */
          margin-bottom: 20px; /* 底部外邊距 */
          border: 1px solid #ccc; /* 設置邊框 */
          border-radius: 5px; /* 設置圓角邊框 */
          box-sizing: border-box; /* 包括內邊距和邊框在內的盒模型 */
      }
      /* 設置提交按鈕的樣式 */
      input[type="submit"] {
          width: 100%; /* 設置寬度為100% */
          padding: 10px; /* 設置內邊距 */
          background-color: #4CAF50; /* 設置背景顏色 */
          color: white; /* 設置文字顏色 */
          border: none; /* 去除邊框 */
          border-radius: 5px; /* 設置圓角邊框 */
          cursor: pointer; /* 設置鼠標樣式 */
          font-size: 16px; /* 設置字體大小 */
      }
      /* 設置提交按鈕懸停效果 */
      input[type="submit"]:hover {
          background-color: #45a049; /* 改變背景顏色 */
      }
  </style>
</head>
<body>
  <!-- 表單容器 -->
  <div class="container">
      <!-- 表單標題 -->
      <h2>註冊</h2>
      <!-- 註冊表單 -->
      <form action="register.php" method="post">
          <!-- 用戶名標籤和輸入框 -->
          <label for="username">用戶名：</label>
          <input type="text" id="username" name="username" required><br>
          <!-- 密碼標籤和輸入框 -->
          <label for="password">密碼：</label>
          <input type="password" id="password" name="password" required><br>
          <!-- 提交按鈕 -->
          <input type="submit" value="註冊">
          <input type="submit" value="返回">
      </form>
  </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conn.php';

        $new_username = $_POST['username'];
        $new_password = $_POST['password'];

        // 檢查用戶名是否已存在
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $new_username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "用戶名已存在，請選擇其他用戶名。";
        } else {
            // 密碼加密
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // 插入用戶
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $new_username, $hashed_password);

            if ($stmt->execute()) {
                echo "<p>新用戶創建成功！2秒後跳轉到登入頁面。</p>";
                header("refresh:2;url=login.php");
            } else {
                echo "錯誤: " . $stmt->error;
            }
        }
        $stmt->close();
        $conn->close();  
    }
    ?>
</body>
</html>
