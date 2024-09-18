<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานสรุป</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f4;
        }
        form {
            margin: 20px 0;
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
    <h1>รายงานสรุป</h1>

    <form method="get">
        <label for="month">เลือกเดือน:</label>
        <select name="month" id="month">
            <?php for ($i = 1; $i <= 12; $i++): ?>
                <option value="<?= sprintf("%02d", $i) ?>" <?= isset($_GET['month']) && $_GET['month'] == sprintf("%02d", $i) ? 'selected' : '' ?>>
                    <?= sprintf("%02d", $i) ?>
                </option>
            <?php endfor; ?>
        </select>
        <input type="submit" value="ดูรายงาน">
    </form>

    <?php
    include 'db_connection.php';

    $month = isset($_GET['month']) ? $_GET['month'] : date('m');

    $sql_income = "SELECT SUM(amount) AS total_income FROM transactions WHERE type='income' AND MONTH(transaction_date) = '$month'";
    $sql_expense = "SELECT SUM(amount) AS total_expense FROM transactions WHERE type='expense' AND MONTH(transaction_date) = '$month'";

    $result_income = $conn->query(query: $sql_income);
    $total_income = $result_income->fetch_assoc()['total_income'] ?? 0;

    $result_expense = $conn->query(query: $sql_expense);
    $total_expense = $result_expense->fetch_assoc()['total_expense'] ?? 0;

    $balance = $total_income - $total_expense;

    $conn->close();
    ?>

    <h2>รายงานสรุปสำหรับเดือน <?= $month ?></h2>
    <p>รายรับรวม: <?= number_format($total_income, 2) ?> บาท</p>
    <p>รายจ่ายรวม: <?= number_format($total_expense, 2) ?> บาท</p>
    <p>ยอดคงเหลือ: <?= number_format($balance, 2) ?> บาท</p>
    <a href="index.php">
        <input type="button" value="กล้บไปหน้าแรก">
    </a>
</body>
</html>
