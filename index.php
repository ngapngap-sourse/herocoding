<?php
include 'db_connection.php';

// ตรวจสอบว่าเดือนถูกเลือกหรือไม่ ถ้าไม่ ใช้เดือนปัจจุบัน
$month = isset($_GET['month']) ? $_GET['month'] : date('m');

// คำสั่ง SQL เพื่อดึงข้อมูลที่กรองตามเดือนและเรียงตามวันที่ใช้จ่ายจากเก่ามาใหม่
$sql = "SELECT * FROM transactions WHERE MONTH(transaction_date) = '$month' ORDER BY transaction_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกรายรับรายจ่าย</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
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
    <h1>บันทึกรายรับรายจ่าย</h1>

    <form method="get">
        <label for="month">เลือกเดือน:</label>
        <select name="month" id="month">
            <?php for ($i = 1; $i <= 12; $i++): ?>
                <option value="<?= sprintf("%02d", $i) ?>" <?= $month == sprintf("%02d", $i) ? 'selected' : '' ?>><?= sprintf("%02d", $i) ?></option>
            <?php endfor; ?>
        </select>
        <input type="submit" value="ค้นหา">
    </form>

    <table>
        <thead>
            <tr>
                <th>เลขที่</th>
                <th>ประเภท</th>
                <th>ชื่อรายการ</th>
                <th>จำนวนเงิน</th>
                <th>วันที่ใช้จ่าย</th>
                <th>วันเวลาที่บันทึกข้อมูล</th>
                <th>วันเวลาที่ปรับปรุงข้อมูลล่าสุด</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1; 
            while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $counter++ ?></td>
                <td><?= ucfirst(string: $row['type']) ?></td>
                <td><?= htmlspecialchars(string: $row['name']) ?></td>
                <td><?= number_format(num: $row['amount'], decimals: 2) ?> บาท</td>
                <td><?= $row['transaction_date'] ?></td>
                <td><?= $row['created_at'] ?></td>
                <td><?= $row['updated_at'] ?></td>
                <td>
                    <a href="edit_transaction.php?id=<?= $row['id'] ?>">แก้ไข</a> |
                    <a href="delete_transaction.php?id=<?= $row['id'] ?>" onclick="return confirm('คุณแน่ใจว่าต้องการลบรายการนี้?')">ลบ</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="add_transaction.php">
    <input type="button" value="เพิ่มข้อมูล">
    </a>

    <a href="summary_report.php">
        <input type="button" value="ดูรายงานสรุป">
    </a>
</body>
</html>
