<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $name = $_POST['name'];
    $amount = $_POST['amount'];
    $transaction_date = $_POST['transaction_date'];

    if (!empty($type) && !empty($name) && !empty($amount) && !empty($transaction_date)) {
        $sql = "INSERT INTO transactions (type, name, amount, transaction_date) 
                VALUES ('$type', '$name', '$amount', '$transaction_date')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>บันทึกข้อมูลสำเร็จ <a href='index.php'>กลับไปยังรายการ</a></p>";
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
    <title>เพิ่มรายการ</title>
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
    <h1>เพิ่มรายการ</h1>
    <form action="add_transaction.php" method="post">
        <label for="type">ประเภท:</label>
        <select name="type" id="type">
            <option value="income">รายรับ</option>
            <option value="expense">รายจ่าย</option>
        </select>

        <label for="name">ชื่อรายการ:</label>
        <input type="text" name="name" id="name">

        <label for="amount">จำนวนเงิน:</label>
        <input type="number" step="0.01" name="amount" id="amount">

        <label for="transaction_date">วันที่ใช้จ่าย:</label>
        <input type="date" name="transaction_date" id="transaction_date">

        <input type="submit" value="บันทึก">
    </form>
    <a href="index.php">กลับไปยังรายการ</a>
</body>
</html>
