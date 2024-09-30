<?php
session_start();
include "dbconn.php";
if (!isset($_SESSION["userid"]) || !isset($_SESSION["username"])) {
    echo "로그인이 필요합니다.";
}
$select_user_num = $_SESSION['user_num'];
?>

<!DOCTYPE html>
<html>

<head>
    <script src="javascript/transfer.js"></script>
    <link rel="stylesheet" href="css/back.css">
</head>

<body>
    <form method="POST">
        <div class="navbar">
            <span>00은행</span>
            <ul>
                <?php
                include "dbconn.php";
                if (isset($_SESSION['username'])): ?>
                    <li><a href="#"><?php echo $_SESSION['username']; ?></a>님</li>
                    <li>|</li>
                    <li><a href="logout.php">로그아웃</a></li>
                <?php else: ?>
                    <li><a href="login.php">로그인</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div> <!--출금계좌선택-->
            <label>출금계좌번호</label>
            <select id="out_account" name="out_account">
                <option value="">선택하세요</option>
                <?php
                if ($select_user_num) {
                    $query = "SELECT * FROM accounts WHERE user_num = :select_user_num";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(":select_user_num", $select_user_num);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <option value="<?= $row['account_number'] ?>"><?= $row['account_number'] ?></option>
                            <?php
                        }
                    } else {
                        echo "<option value=''>계좌가 없습니다.</option>";
                    }

                } else {
                    echo "<option value=''>user_num이 전달되지 않았습니다.</option>";
                } ?>
            </select>
            <div>
                <button type="button" onclick="myAccount()">출금가능금액 조회</button>
                <div id="balance">잔액: 0원</div>
            </div>
        </div>
        <div> <!--입금계좌번호 입력-->
            <label>입금계좌번호</label>
            <input type="text" id="in_account" name="in_account" required>
        </div>
        <div> <!--이체금액 입력-->
            <label>이체금액</label>
            <input type="number" id="transfer_amount" name="transfer_amount" required>
        </div>
        <div><!--비밀번호 입력-->
            <label>계좌 비밀번호 입력</label>
            <input type="password" id="input_password" name="input_password" required>
        </div>
        <button type="submit" onclick="transferSubmit()">이체하기</button>
    </form>
</body>

</html>