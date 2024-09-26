<?php
session_start();
include "dbconn.php";
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>거래내역 조회</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>거래내역 조회</h1>

        <div class="search-box">
            <form method="POST" action="transaction.php">
                <div>
                    <?php echo $_SESSION["username"]; ?>님
                </div>
                <div class="search-group">
                    <label for="account-number">조회 계좌번호:</label>
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
                <div class="search-group">
                    <label>조회기간:</label>
                    <input type="date" name="start-date" value="<?= $_POST['start-date'] ?? '' ?>">
                    <span>~</span>
                    <input type="date" name="end-date" value="<?= $_POST['end-date'] ?? '' ?>">
                </div>
                <div class="search-group">
                    <button type="submit">조회</button>
                </div>
            </form>
        </div>

        <div class="result-box">
            <table>
                <thead>
                    <tr>
                        <th>번호</th>
                        <th>거래 일자 및 시간</th>
                        <th>거래유형</th>
                        <th>계좌번호</th>
                        <th>수신계좌번호</th>
                        <th>거래 금액</th>
                        <th>거래 후 잔액</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        $account_number = $_POST['select_account'];
                        $start_date = $_POST['start-date'];
                        $end_date = $_POST['end-date'];

                        //end-date가 선택된 경우, 시간 추가
                        if ($end_date) {
                            $end_date .= ' 23:59:59'; //종료 날짜에 시간을 추가
                        }

                        if ($account_number) {
                            //해당 계좌의 거래 내역 조회
                            $query = "SELECT * FROM transactions 
                            INNER JOIN transaction_types ON (transactions.transaction_type_id = transaction_types.id)
                            INNER JOIN accounts ON (transactions.account_id = accounts.account_id)
                            WHERE accounts.account_number = :account_number";

                            //조건 추가
                            if ($start_date && $end_date) {
                                $query .= " AND transactions.transaction_date BETWEEN :start_date AND :end_date";
                            } elseif ($start_date) {
                                $query .= " AND transactions.transaction_date >= :start_date";
                            } elseif ($end_date) {
                                $query .= " AND transactions.transaction_date <= :end_date";
                            }

                            //정렬 추가
                            $query .= " ORDER BY transactions.transaction_id DESC";

                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(":account_number", $account_number);
                            if ($start_date) {
                                $stmt->bindParam(":start_date", $start_date);
                            }
                            if ($end_date) {
                                $stmt->bindParam(":end_date", $end_date);
                            }
                            $stmt->execute();

                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            //결과 출력
                            if ($result) {
                                for ($i = 0; $i < count($result); $i++) {
                                    echo "<tr>
                                        <td>{$result[$i]['transaction_id']}</td>
                                        <td>{$result[$i]['transaction_date']}</td>
                                        <td>{$result[$i]['type']}</td>
                                        <td>{$result[$i]['account_number']}</td>
                                        <td>{$result[$i]['receiver_account']}</td>
                                        <td>{$result[$i]['amount']}</td>
                                        <td>{$result[$i]['amount_after']}</td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>거래 내역이 없습니다.</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>계좌번호가 선택되지 않았습니다.</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>