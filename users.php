<?php
session_start();

include "dbconn.php";

// 사용자 ID는 세션에서 가져온다고 가정합니다.
$user_num = '2'; // 여기 user_num으로 수정하면서 24, 87, 91, 157 수정함. 157이 id일떄 안됨

// 사용자 정보를 가져오는 SQL 쿼리
$sql = "SELECT * FROM users WHERE user_num = :user_num";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_num', $user_num);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // 사용자 정보 변수 설정
        $username = $user['username'];
        $phone_number = $user['phone_number'];
        $email = $user['email'];
        $dob = $user['date_of_birth'];
        $join_date = $user['account_created_at'];
        $last_login = $user['last_login'];
        $plainPassword = $user['password']; // 저장된 평문 비밀번호
    } else {
        die("사용자 정보를 찾을 수 없습니다.");
    }
} catch (Exception $e) {
    echo "쿼리 오류: " . $e->getMessage();
    exit;
}

// 비밀번호 변경 처리
$passwordChangeMessage = ""; // 기본값 설정

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['oldPassword'])) {
    $currentPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // 현재 비밀번호 확인
    if ($currentPassword === $plainPassword) { // 평문 비교
        // 새 비밀번호와 확인 비밀번호가 일치하는지 확인
        if ($newPassword !== $confirmPassword) {
            $passwordChangeMessage = "새 비밀번호와 확인 비밀번호가 일치하지 않습니다.";
        } else {
            // 비밀번호 업데이트 쿼리
            $updateSql = "UPDATE users SET password = :password WHERE userid = :userid";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bindParam(':password', $newPassword); // 평문 비밀번호로 업데이트
            $updateStmt->bindParam(':userid', $user_id);

            if ($updateStmt->execute()) {
                $passwordChangeMessage = "비밀번호가 성공적으로 변경되었습니다.";
            } else {
                $passwordChangeMessage = "비밀번호 변경 중 오류가 발생했습니다.";
            }
        }
    } else {
        $passwordChangeMessage = "현재 비밀번호가 올바르지 않습니다.";
    }
}

// 모달 표시 조건
$showErrorModal = !empty($passwordChangeMessage);
?>

<?php
// 계좌 정보를 가져오는 SQL 쿼리
$sqlAccounts = "SELECT account_number, balance, created_at FROM accounts WHERE user_num = :user_num";

try {
    $stmtAccounts = $conn->prepare($sqlAccounts);
    $stmtAccounts->bindParam(':user_num', $user_num); // user_id를 user_num으로 사용
    $stmtAccounts->execute();

    $accounts = $stmtAccounts->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "계좌 조회 오류: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>계정 관리</title>
    <!-- <link rel="stylesheet" type="text/css" href="users.css"> -->
</head>

<body>
    <header>
        <div class="container">
            <h1>은행 계정 관리</h1>
            <nav>
                <ul>
                    <li><a href="#">메인</a></li>
                    <li>
                        <a href="#">조회</a>
                        <ul>
                            <li><a href="#">계좌 조회</a></li>
                            <li><a href="#">거래내역 조회</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">이체</a>
                        <ul>
                            <li><a href="#">계좌 이체</a></li>
                            <li><a href="#">이체결과 조회</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">대출</a>
                        <ul>
                            <li><a href="#">대출 신청</a></li>
                            <li><a href="#">대출진행현황</a></li>
                            <li><a href="#">대출관리</a></li>
                        </ul>
                    </li>
                    <li><a href="#">로그아웃</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="main">
            <h1>계정 관리</h1>
            <div class="account-info">
                <h2>계정 정보</h2>
                <table class="info-table">
                    <tr>
                        <th>이름</th>
                        <td><?php echo ($username); ?></td>
                        <th>핸드폰 번호</th>
                        <td><?php echo ($phone_number); ?></td>
                    </tr>
                    <tr>
                        <th>사용자 ID</th>
                        <td><?php echo ($user_num); ?></td>
                        <th>비밀번호 변경</th>
                        <td><a href="#" id="changePasswordLink">비밀번호 변경</a></td>
                    </tr>
                    <tr>
                        <th>이메일</th>
                        <td><?php echo ($email); ?></td>
                        <th>생년월일</th>
                        <td><?php echo ($dob); ?></td>
                    </tr>
                    <tr>
                        <th>회원가입일</th>
                        <td><?php echo ($join_date); ?></td>
                        <th>마지막 로그인</th>
                        <td><?php echo ($last_login); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="account-info">
        <h2>계좌 정보</h2>
        <table class="info-table">
            <tr>
                <th>계좌번호</th>
                <th>잔액</th>
                <th>생성일</th>
            </tr>
            <?php if ($accounts): ?>
                <?php foreach ($accounts as $account): ?>
                    <tr>
                        <td><?php echo ($account['account_number']); ?></td>
                        <td><?php echo ($account['balance']); ?> 원</td>
                        <td><?php echo ($account['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">계좌 정보가 없습니다.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <!-- 비밀번호 변경 모달 -->
    <div id="myModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>비밀번호 변경</h2>
            <form method="POST" action="">
                <label for="oldPassword">현재 비밀번호:</label><br>
                <input type="password" id="oldPassword" name="oldPassword" required><br><br>
                <label for="newPassword">새 비밀번호:</label><br>
                <input type="password" id="newPassword" name="newPassword" required><br><br>
                <label for="confirmPassword">새 비밀번호 확인:</label><br>
                <input type="password" id="confirmPassword" name="confirmPassword" required><br><br>
                <button type="submit">비밀번호 변경</button>
            </form>
        </div>
    </div>

    <!-- 오류 메시지 모달 -->
    <div id="errorModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="closeError">&times;</span>
            <h2>안내 메시지</h2>
            <p id="errorMessage"></p>
        </div>
    </div>

    <script>
        // 모달 열기
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("changePasswordLink");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function (event) {
            event.preventDefault();
            modal.style.display = "block";
        }

        // 오류 메시지 모달 열기
        var errorModal = document.getElementById("errorModal");
        var closeErrorModalBtn = document.getElementsByClassName("closeError")[0];

        if (<?php echo $showErrorModal ? 'true' : 'false'; ?>) {
            document.getElementById('errorMessage').innerText = '<?php echo addslashes($passwordChangeMessage); ?>';
            errorModal.style.display = "block"; // 오류 메시지 모달 열기
        }

        closeErrorModalBtn.onclick = function () {
            errorModal.style.display = "none"; // 오류 메시지 모달 닫기
        }

        // 모달 닫기
        span.onclick = function () {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
            if (event.target == errorModal) {
                errorModal.style.display = "none";
            }
        }
    </script>
</body>

</html>