<?php
include "dbconn.php";
include "api/random_account.php";
?>

<!DOCTYPE html>
<html>

<head>

</head>

<body>
    <div>
        <h2><?php echo $_SESSION['username'] . "님의 " ?>계좌생성</h2>
        <form action="" onsubmit="firstForm(event)" method="POST">
            <div id="section">
                <!-- <div>
                    <input type="hidden" name="account_id" value="<?php echo $_SESSION['account_id']; ?>">
                </div> -->
                <div>
                    <label>이름</label> <!--DB에 있는 이름 그대로 가져오기-->
                    <input type="text" id="username" name="username" value="<?php echo $_SESSION['username'] ?>"
                        readonly>
                </div>
                <div>
                    <label>주민번호</label>
                    <input type="text" id="resident-number1" name="resident-number1"
                        value="<?php echo ($resident_number1) ?>"> -
                    <input type="text" id="resident-number2" name="resident-number2" required>
                </div>
                <div>
                    <label>초기 금액</label>
                    <input type="number" id="balance" name="balance" required>
                </div>
                <div><!--인증번호-->

                </div>
                <div> <!--숫자만 입력되게, 자리수는 4자리-->
                    <label>통장 비밀번호</label>
                    <input type="password" id="account-password" name="account-password" required>
                </div>
                <div><!--계좌 사용용도-->
                    <label>계좌 사용용도</label>
                    <select required>
                        <option>선택해주세요.</option>
                        <option>급여 및 아르바이트</option>
                        <option>생활비 관리</option>
                        <option>적금 자동이체</option>
                        <option>예금 가입</option>
                        <option>대출신청</option>
                    </select>
                </div>
                <div> <!--체크옵션 1-->
                    <p>타인으로부터 통장대여 요청을 받은 사실이 있나요?</p>
                    <div>
                        <input type="radio" name="check1">예
                        <input type="radio" name="check1">아니오
                    </div>
                </div>
                <div> <!--체크옵션 2-->
                    <p>타인으로부터 통장개설을 요청받은 사실이 있나요?</p>
                    <div>
                        <input type="radio" name="check2">예
                        <input type="radio" name="check2">아니오
                    </div>
                </div>
            </div>
            <input type="submit" value="계좌 생성">
        </form>
    </div>
</body>

</html>