<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>main</title>
    <link rel="stylesheet" href="css/back.css">
    <style>
        .category-container {
            display: flex;
            justify-content: center;
            margin-top: 100px;
            flex-wrap: wrap;
        }

        .category {
            margin: 20px;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 15px;
            width: 250px;
            text-align: center;
            background-color: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            /*마우스 올렸을 때 애니메이션 효과 */
        }

        .category:hover {
            transform: translateY(-10px);
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        }

        .category ul {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        .category ul li {
            margin: 10px 0;
            font-size: 1em;
            color: #333;
            text-decoration: none;
        }

        .category ul li a {
            text-decoration: none;
            color: black;
        }

        .category ul a:hover {
            color: #ffb900;
            cursor: pointer;

        }

        .category-header {
            font-size: 1.5em;
            font-weight: bold;
            color: #444;
            margin-bottom: 10px;
            padding: 10px 0;
            border-bottom: 2px solid #ccc;
        }
    </style>
</head>

<body>
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

    <div class="category-container" id="category-container">
        <div class="category">
            <div class="category-header">계좌</div>
            <ul>
                <li><a href="accountAdd.php">계좌 생성</a></li>
                <li><a href="transfer.php">송금</a></li>
                <li><a href="transactions.php">거래 내역</a></li>
            </ul>
        </div>
        <div class="category">
            <div class="category-header">대출</div>
            <ul>
                <li><a href="loans2.php">대출 신청</a></li>
                <li><a href="loans3.php">대출 조회</a></li>
                <li><a href="loans.php">대출 상품 조회</li>
            </ul>
        </div>
        <div class="category">
            <div class="category-header">계정</div>
            <ul>
                <li><a href="users.php">계좌 정보</a></li>
                <li><a href="changePassword.php">비밀번호 변경</a></li>
            </ul>
        </div>
    </div>
</body>

</html>