<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$current_file = basename($_SERVER['PHP_SELF']);

// a페이지나 b페이지가 아닐 경우 로그인 페이지로 다시 이동
// if ($current_file != 'login.php' && $current_file != 'register.php' && $current_file != 'main.php') {
//     echo "<script>alert('로그인이 필요합니다');</script>";

//     echo "<script>location.href='login.php';</script>"; //로그인 후 이동할 페이지
//     exit;
// }
?>

<?php
$serverName = "localhost";
$database = "bank";

$uid = "bankuser1";
$pwd = "Bankuser1!";

try {
    $conn = new PDO("mysql:host=$serverName;dbname=$database", $uid, $pwd);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to mysql");
}
?>