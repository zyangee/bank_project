<?php
session_start();
include "../dbconn.php";
$user_num = $_SESSION['user_num'];
try {
    $sql = "SELECT balance FROM accounts WHERE user_num = '$user_num'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode(['balance' => $result['balance']]);
    } else {
        echo json_encode(['balance' => 0]);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}


$conn = null;
exit();
?>