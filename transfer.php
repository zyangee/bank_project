<?php
session_start();
if (!isset($_SESSION["userid"]) || !isset($_SESSION["username"])) {
    echo "로그인이 필요합니다.";
}
?>

<!DOCTYPE html>
<html>

<head>
    <script src="javascript/transfer.js"></script>
</head>

<body>
    <form method="POST">
        <div>
            <?php echo $_SESSION["username"]; ?>님
            <a href="#"> <!--로그아웃 페이지-->
                <button>로그아웃</button>
            </a>
        </div>
        <div> <!--출금계좌선택-->
            <label>출금계좌번호</label>
            <select id="out_account" name="out_account">
                <option value="">선택하세요</option>
                <?php
                include "dbconn.php";

                $select_user_num = $_SESSION['user_num'];
                if ($select_user_num) {
                    $query = "SELECT * FROM accounts WHERE user_num = $select_user_num";
                    $stmt = $conn->prepare($query);
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
        <!-- <div> 
            <label>입금기관</label>
            <input type="text" id="select_bank" name="select_bank" readonly>
            <button type="button" onclick="popupBank()">기관선택</button>
        </div> -->
        <div> <!--입금계좌번호 입력-->
            <label>입금계좌번호</label>
            <input type="text" id="in_account" name="in_account" required>
        </div>
        <div> <!--이체금액 입력-->
            <label>이체금액</label>
            <input type="number" id="transfer_amount" name="transfer_amount" required>
        </div>
        <button type="submit" onclick="transferSubmit()">이체하기</button>
    </form>
</body>

</html>