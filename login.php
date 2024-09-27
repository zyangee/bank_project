<?php
session_start();
include "dbconn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = $_POST['userid'];
    $password = $_POST['password'];

    try {
        //SQL쿼리: 사용자 정보를 조회
        $sql = "SELECT * FROM users WHERE userid = '$userid'";
        $stmt = $conn->query($sql); //쿼리 실행

        $user = $stmt->fetch(PDO::FETCH_ASSOC); //사용자 정보 조회

        //비밀번호가 일치하는지 확인
        if ($user && $user['password'] === $password) {
            $_SESSION['userid'] = $user['userid']; //세션에 사용자 ID 저장
            $_SESSION['username'] = $user['username']; //세션에 사용자 이름 저장
            $_SESSION['user_num'] = $user['user_num'];
            echo "로그인 성공";
            echo "<script>location.href='transfer.php';</script>";
        } else {
            echo "로그인 실패: 사용자 ID 또는 비밀번호가 잘못되었습니다."; //로그인 실패 메시지 출력
        }
    } catch (PDOException $e) {
        //쿼리 실행 실패 시 오류 메시지 출력
        die("로그인 중 오류가 발생했습니다: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>로그인</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="login-container">
        <h3>로그인</h3>
        <form method="POST" action="login.php">
            <div class="input-group">
                <label>사용자 ID: </label>
                <input type="text" name="userid">
            </div>
            <div class="input-group">
                <label>비밀번호: </label>
                <input type="password" name="password">
            </div>
            <div class="button-group">
                <button type="submit">로그인</button>
                <a href="register.php">회원가입</a>
            </div>
            <div class="footer">
                <a href="#">비밀번호를 잊으셨나요?</a>
            </div>
        </form>
    </div>
</body>

</html>