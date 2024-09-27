<?php
session_start();
include "dbconn.php"; // 데이터베이스 연결

// 조회 결과 저장할 변수 초기화
$transactions = [];

// 검색 폼에서 데이터가 제출된 경우
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accountNumber = $_POST['account-number'];
    $startDate = $_POST['start-date'];
    $endDate = $_POST['end-date'];
    $viewOption = $_POST['view-option'];
    $order = $_POST['order'];

    // 기본 조회 쿼리 작성 (계좌번호와 기간에 따라 거래 내역 조회)
    $sql = "SELECT t.transaction_id, t.transaction_date, tt.type AS transaction_type, 
                   a.account_number, t.receiver_account, t.amount, t.amount_after 
            FROM transactions t
            JOIN accounts a ON t.account_id = a.account_id
            LEFT JOIN transaction_types tt ON t.transaction_type_id = tt.id
            WHERE a.account_number = '$accountNumber'
            AND t.transaction_date BETWEEN '$startDate' AND '$endDate'";

    // 거래 유형에 따른 필터링
    if ($viewOption == 'deposit') {
        $sql .= " AND tt.type = '입금'";
    } elseif ($viewOption == 'interest') {
        $sql .= " AND tt.type = '출금'";
    }

    // 정렬 기준 추가
    if ($order == 'recent') {
        $sql .= " ORDER BY t.transaction_date DESC";
    } else {
        $sql .= " ORDER BY t.transaction_date ASC";
    }

    // 쿼리 실행
    $stmt = $conn->query($sql);

    // 결과 가져오기
    if ($stmt) {
        // 결과가 0개일 경우 메시지 추가
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $transactions[] = $row; // 거래 내역을 배열에 추가
            }
        } else {
            // 쿼리 결과가 없으면 메시지 추가
            $transactions[] = ['message' => '조회된 거래내역이 없습니다.'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>거래내역 조회</title>
    <link rel="stylesheet" href="transaction2.css">
</head>

<body>
    <div class="container">
        <h1>거래내역 조회</h1>
        <div class="search-box">
            <form method="post" action="transactions.php">
                <div>
                    <?php echo $_SESSION["username"]; ?>님
                </div>
                <!-- 계좌번호 입력 -->
                <div class="search-group">
                    <label for="account-number">조회 계좌번호:</label>
                    <!-- <input type="text" id="account-number" name="account-number" required> -->
                    <select id="select_account" name="select_account">
                        <option value="">선택하세요</option>
                        <?php
                        include "dbconn.php";

                        $select_user_num = $_SESSION['user_num'];
                        if ($select_user_num) {
                            $query = "SELECT * FROM accounts WHERE user_num = :select_user_num";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(":select_user_num", $select_user_num);
                            $stmt->execute();

                            $selected_account = $_POST['select_account'] ?? '';
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = ($row['account_number'] == $selected_account) ? 'selected' : '';
                                    ?>
                                    <option value="<?= $row['account_number'] ?>" <?= $selected ?>><?= $row['account_number'] ?>
                                    </option>
                                    <?php
                                }
                            } else {
                                echo "<option value=''>계좌가 없습니다.</option>";
                            }

                        } else {
                            echo "<option value=''>user_num이 전달되지 않았습니다.</option>";
                        } ?>
                    </select>
                </div>

                <!-- 조회기간 선택 -->
                <div class="search-group">
                    <label>조회기간:</label>
                    <input type="date" name="start-date" required>
                    <span>~</span>
                    <input type="date" name="end-date" required>
                </div>

                <div class="options">
                    <div class="radio-group">
                        <label>조회내용 :</label>
                        <input type="radio" id="all" name="view-option" value="all" checked>
                        <label for="all">전체(입금+출금)</label>
                        <input type="radio" id="deposit" name="view-option" value="deposit">
                        <label for="deposit">입금내역</label>
                        <input type="radio" id="interest" name="view-option" value="interest">
                        <label for="interest">출금내역</label>
                    </div>

                    <!-- 조회결과 정렬 -->
                    <div class="search-group">
                        <label>조회결과 순서:</label>
                        <input type="radio" name="order" id="recent" value="recent" checked>
                        <label for="recent">최근거래순</label>
                        <input type="radio" name="order" id="past" value="past">
                        <label for="past">과거거래순</label>
                    </div>

                    <!-- 조회 버튼 -->
                    <div class="search-group">
                        <button type="submit" class="search-btn">조회</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- 결과 테이블 -->
        <div class="result-box">
            <table>
                <thead>
                    <tr>
                        <th>번호</th>
                        <th>거래 일자</th>
                        <th>거래유형</th>
                        <th>계좌번호</th>
                        <th>수신계좌번호</th>
                        <th>거래 금액</th>
                        <th>거래 후 잔액</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transactions) && !isset($transactions[0]['message'])): ?>
                        <?php foreach ($transactions as $index => $transaction): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $transaction['transaction_date'] ?></td>
                                <td><?= $transaction['transaction_type'] ?? '없음' ?></td>
                                <td><?= $transaction['account_number'] ?></td>
                                <td><?= $transaction['receiver_account'] ?></td>
                                <td><?= number_format($transaction['amount']) ?></td>
                                <td><?= number_format($transaction['amount_after']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7"><?= $transactions[0]['message'] ?? '조회된 거래내역이 없습니다.'; ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>