<?php
include "dbconn.php";
// 사용자 ID는 세션에서 가져온다고 가정합니다.
$user_num = '2'; // 예시로 사용자 num을 설정

// 대출 정보를 가져오는 SQL 쿼리
$sql = "SELECT *
        FROM loans l
        JOIN loan_types lt ON l.loan_type_id = lt.id
        JOIN loan_statuses ls ON l.loan_status_id = ls.id
        WHERE l.user_num = :user_num";

try {
    $stmt = $conn->prepare($sql); // SQL 쿼리 준비
    $stmt->bindParam(':user_num', $user_num); // 사용자 번호 바인딩
    $stmt->execute(); // 쿼리 실행

    $loans = $stmt->fetchAll(PDO::FETCH_ASSOC); // 모든 결과 가져오기
} catch (Exception $e) {
    echo "쿼리 오류: " . $e->getMessage(); // 쿼리 실행 오류 처리
    exit; // 스크립트 종료
}

// 연결 종료
$conn = null; // 연결 종료
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>대출 내역 조회</title>
    <link rel="stylesheet" type="text/css" href="loans3.css">
</head>

<body>
    <header>
        <div class="container">
            <h1>00은행</h1>
            <nav>
                <ul>
                    <li><a href="#">메인</a></li>
                    <li>
                        <a href="#">조회</a>
                        <ul>
                            <li><a href="#">계좌 조회</a></li>
                            <li><a href="#">거래 내역 조회</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">이체</a>
                        <ul>
                            <li><a href="#">계좌 이체</a></li>
                            <li><a href="#">이체 결과 조회</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">대출</a>
                        <ul>
                            <li><a href="#">대출 상품</a></li>
                            <li><a href="#">대출 신청</a></li>
                            <li><a href="#">대출 조회</a></li>
                        </ul>
                    </li>
                    <li><a href="#">마이페이지</a></li>
                    <li><a href="#">로그아웃</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container2">
        <h1>대출 내역 조회</h1>
        <table>
            <thead>
                <tr>
                    <th>대출 종류</th>
                    <th>총 대출액</th>
                    <th>적용 금리</th>
                    <th>대출 시작일</th>
                    <th>대출 종료일</th>
                    <th>대출 상태</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($loans): ?>
                    <?php foreach ($loans as $loan): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($loan['loan_type']); ?></td>
                            <td><?php echo number_format($loan['loan_amount']); ?>원</td>
                            <td><?php echo htmlspecialchars($loan['interest_rate']); ?>%</td>
                            <td><?php echo htmlspecialchars($loan['loan_start_date']); ?></td>
                            <td><?php echo htmlspecialchars($loan['loan_end_date']); ?></td>
                            <td><?php echo htmlspecialchars($loan['loan_status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">대출 정보가 없습니다.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>