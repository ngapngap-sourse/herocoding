<?php
include 'db_connection.php';

$id = $_GET['id'];
$sql = "SELECT * FROM transactions WHERE id=$id";
$result = $conn->query(query: $sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $name = $_POST['name'];
    $amount = $_POST['amount'];
    $transaction_date = $_POST['transaction_date'];

    if (!empty($type) && !empty($name) && !empty($amount) && !empty($transaction_date)) {
        $sql = "UPDATE transactions SET type='$type', name='$name', amount='$amount', transaction_date='$transaction_date' WHERE id=$id";

        if ($conn->query(query: $sql) === TRUE) {
            echo "<p>ปรับปรุงข้อมูลสำเร็จ <a href='index.php'>กลับไปยังรายการ</a></p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>กรุณากรอกข้อมูลให้ครบถ้วน</p>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขรายการ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f4;
        }
        form {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="number"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>แก้ไขรายการ</h1>
    <form action="edit_transaction.php?id=<?= $id ?>" method="post">
        <label for="type">ประเภท:</label>
        <select name="type" id="type">
            <option value="income" <?= $row['type'] == 'income' ? 'selected' : '' ?>>รายรับ</option>
            <option value="expense" <?= $row['type'] == 'expense' ? 'selected' : '' ?>>รายจ่าย</option>
        </select>

        <label for="name">ชื่อรายการ:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($row['name']) ?>">

        <label for="amount">จำนวนเงิน:</label>
        <input type="number" step="0.01" name="amount" id="amount" value="<?= number_format($row['amount'], 2) ?>">

        <label for="transaction_date">วันที่ใช้จ่าย:</label>
        <input type="date" name="transaction_date" id="transaction_date" value="<?= $row['transaction_date'] ?>">

        <input type="submit" value="ปรับปรุง">
    </form>
    <a href="index.php">กลับไปยังรายการ</a>
</body>
</html>
