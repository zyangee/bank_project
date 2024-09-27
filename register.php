<?php
include 'dbconn.php';

//회원가입 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST['userid'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone1'] . '-' . $_POST['phone2'] . '-' . $_POST['phone3'];
    $birth = $_POST['birth'];

    try {
        $sql = "INSERT INTO users(userid, username, password, email, phone_number, date_of_birth) VALUES('$userid', '$username', '$password', '$email', '$phone_number', '$birth')";

        //쿼리 실행
        $conn->exec($sql);

        echo "회원가입이 완료되었습니다."; //성공 메시지 출력
        header('Location: login.php'); //로그인 페이지 이동
    } catch (PDOException $e) {
        //쿼리 실행 실패 시 오류 메시지 출력
        die("회원가입 중 오류가 발생했습니다: " . $e->getMessage());
    }
}
?>
<html>

<head>
    <script src="javascript/register.js"></script>
    <link rel="stylesheet" href="css/register.css">
</head>

<body>
    <!--회원가입 폼-->
    <form id="signForm" method="POST">
        <div> <!--아이디 입력-->
            <label>사용자 ID:</label>
            <input type="text" name="userid" maxlength="20" id="userid" placeholder="아이디를 입력해주세요." required>
            <button type="button" onclick="checkUserID()">중복체크</button>
            <div id="idError" class="error"></div> <!--입력 값 확인 메시지 출력-->
            <span id="useridFeedback"></span> <!--중복체크 메시지 출력-->
        </div>
        <div> <!--이름 입력-->
            <label>사용자 이름:</label>
            <input type="text" name="username" maxlength="10" id="username" placeholder="이름을 입력해주세요." required>
            <div id="nameError" class="error"></div> <!--입력 값 확인 메시지 출력-->
        </div>
        <div> <!--비밀번호 입력-->
            <label>비밀번호:</label>
            <input type="password" name="password" maxlength="20" id="password" placeholder="영문, 숫자, 특수문자 포함 8자리 이상 입력"
                required>
            <div id="passError" class="error"></div> <!--입력 값 확인 메시지 출력-->
        </div>
        <div> <!--이메일 입력-->
            <label>이메일:</label>
            <input type="text" name="email" maxlength="20" id="email" placeholder="이메일을 입력해주세요." required>
            <div id="emailError" class="error"></div> <!--입력 값 확인 메시지 출력-->
        </div>
        <div> <!--핸드폰 번호 입력-->
            <label>핸드폰 번호:</label>
            <div id="phoneNum">
                <input type="text" name="phone1" size="3" id="phone1" maxlength="3" oninput="nextPhone1()" required> -
                <input type="text" name="phone2" size="6" id="phone2" maxlength="4" oninput="nextPhone2()" required> -
                <input type="text" name="phone3" size="6" id="phone3" maxlength="4" required>
            </div>
            <div id="phoneError" class="error"></div> <!--입력 값 확인 메시지 출력-->
        </div>
        <div> <!--생년월일 입력-->
            <label>생년월일:</label>
            <input type="text" name="birth" id="birth" maxlength="6" placeholder="주민번호 앞 6자리 입력" required>
            <div id="birthError" class="error"></div> <!--입력 값 확인 메시지 출력-->
        </div>
        <button type="button" id="signUp" onclick="signupCheck()">회원가입</button>
    </form>
</body>

</html>