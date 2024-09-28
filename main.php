<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>은행</title>
    <!-- <link rel="stylesheet" href="main.css"> -->
</head>

<body>
    <header>
        <div class="container">
            <div class="logo">
                <h1>은행</h1>
            </div>
            <nav>
                <div id="yu">
                    <ul>
                        <li><a href="#">홈</a></li>
                        <li>|</li>
                        <li><a href="#">서비스</a></li>
                        <li>|</li>
                        <li><a href="#">고객센터</a></li>
                        <li>|</li>
                        <?php
                        include "dbconn.php";
                        if (isset($_SESSION['username'])): ?>
                            <!-- 로그인이 되어있을 때 -->
                            <li><a href="#"><?php echo $_SESSION['username']; ?></a>님</li>
                            <li><a href="logout.php">로그아웃</a></li>
                        <?php else: ?>
                            <!-- 로그인이 안 되어있을 때 -->
                            <li><a href="login.php">로그인</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <main>
        <section class="hero">
            <div class="container">
                <h2>안녕하세요, 은행입니다.</h2>
                <p>최고의 금융 서비스를 제공합니다.</p>
                <!-- <a href="#" class="cta-button">서비스 보기</a> -->

                <section class="search">
                    <h3>검색</h3>
                    <form action="search.php" method="get">
                        <input type="text" name="query" placeholder="검색어를 입력하세요" required>
                        <button type="submit">검색</button>
                    </form>
                </section>

            </div>
        </section>
        <section class="features">
            <ul id="n_bar">
                <li class="dropdown">
                    <a href="1"> 계좌</a>
                </li>
                <ul class="dropdown-menu">
                    <li>계좌 생성</li>
                    <li>계좌유형 조회</li>
                    <li>잔액 조회</li>
                </ul>
            </ul>
            <ul id="n_bar2">
                <li class="dropdown2">
                    <a href="2"> 이체조회</a>
                </li>
                <ul class="dropdown-menu2">
                    <li>이체내역 조회</li>
                    <li>이체 유형 조회</li>
                    <li>거래 일자 조회</li>
                </ul>
            </ul>

            <ul id="n_bar3">
                <li class="dropdown3">
                    <a href="3"> 대출</a>
                </li>
                <ul class="dropdown-menu3">
                    <li>대출상품안내</li>
                    <li>대출신청</li>
                    <li>대출조회</li>
                </ul>
            </ul>
        </section>
        <aside>
            <div class="list">
                <h2>금융상품</h2>
            </div>
            <div class="list_menu">
                <ul>
                    <li>예적금</li>
                    <li>대출</li>
                    <li>외환</li>
                    <li>카드</li>
                    <li>인증센터</li>

                </ul>
            </div>
        </aside>
        <footer>
            <div class="new">
                <h4>새소식</h4>
            </div>
            <div class="new_list">
                <ul>
                    <li>보안관리 안내</li>
                    <li>보안취약점 확인</li>
                    <li>보안강화 프로그램 안내 </li>
                </ul>
            </div>
        </footer>
    </main>
</body>

</html>