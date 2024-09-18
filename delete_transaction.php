<?php
include 'db_connection.php';

$id = $_GET['id'];
$sql = "DELETE FROM transactions WHERE id=$id";

if ($conn->query(query: $sql) === TRUE) {
    echo "ลบข้อมูลสำเร็จ <a href='index.php'>กลับไปยังรายการ</a>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
