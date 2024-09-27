<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>대출 신청</title>
    <link rel="stylesheet" type="text/css" href="loans2.css">
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
                            <li><a href="#">대출 신청</a></li>
                            <li><a href="#">대출 진행 현황</a></li>
                            <li><a href="#">대출 관리</a></li>
                        </ul>
                    </li>
                    <li><a href="#">마이페이지</a></li>
                    <li><a href="#">로그아웃</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="main">
            <h1>대출 신청</h1>
            <form>
                <label for="loanType">대출 종류</label>
                <select id="loanType" name="loanType">
                  <option value="default">선택</option>
                  <option value="credit">신용대출</option>
                  <option value="mortgage">담보대출</option>
                  <option value="auto">자동차대출</option>
                  <option value="business">사업자대출</option>
                </select>

                <label for="loanAmount">대출 금액</label>
                    <input type="number" id="loanAmount" name="loanAmount" min="0" max="" oninput="validateLoanAmount()" />
                              
                <label for="loanPurpose">대출 용도</label>
                <select id="loanPurpose" name="loanPurpose">
                  <option value="default">선택</option>
                  <option value="homePurchase">주택구입자금</option>
                  <option value="rentalDeposit">주거목적임차자금</option>
                  <option value="livingExpenses">생활자금</option>
                  <option value="debtRepayment">부채상환</option>
                  <option value="relocation">이주비</option>
                  <option value="interimPayment">중도금대출</option>
                  <option value="realEstatePurchase">부동산구입자금</option>
                </select>
              
                <label for="totalAssets">총 자산</label>
                <select id="totalAssets" name="totalAssets">
                  <option value="default">선택</option>
                  <option value="lessThan1B">1억원 미만</option>
                  <option value="1Bto5B">1억원 이상 5억원 미만</option>
                  <option value="5Bto10B">5억원 이상 10억원 미만</option>
                  <option value="moreThan10B">10억원 이상</option>
                </select>
              
                <label for="totalIncome">총 소득</label>
                <select id="totalIncome" name="totalIncome">
                  <option value="default">선택</option>
                  <option value="lessThan25M">2천5백만원 미만</option>
                  <option value="25Mto50M">2천5백만원 이상 5천만원 미만</option>
                  <option value="50Mto100M">5천만원 이상 1억원 미만</option>
                  <option value="moreThan100M">1억원 이상</option>
                </select>
              
                <label for="totalDebt">총 부채</label>
                <select id="totalDebt" name="totalDebt">
                  <option value="default">선택</option>
                  <option value="lessThan50M">5천만원 미만</option>
                  <option value="50Mto100M">5천만원 이상 1억원 미만</option>
                  <option value="100Mto500M">1억원 이상 5억원 미만</option>
                  <option value="moreThan500M">5억원 이상</option>
                </select>
              
                <label for="fixedExpenses">고정지출</label>
                <select id="fixedExpenses" name="fixedExpenses">
                  <option value="default">선택</option>
                  <option value="lessThan30">연간소득의 30% 미만</option>
                  <option value="30to50">연간소득의 30% 이상 50% 미만</option>
                  <option value="50to70">연간소득의 50% 이상 70% 미만</option>
                  <option value="moreThan70">연간소득의 70% 이상</option>
                </select>
              
                <label for="loanRepaymentIncome">대출상환소득</label>
                <select id="loanRepaymentIncome" name="loanRepaymentIncome">
                  <option value="default">선택</option>
                  <option value="salary">근로소득</option>
                  <option value="businessIncome">사업소득</option>
                  <option value="rentalIncome">임대소득</option>
                  <option value="pension">연금소득</option>
                  <option value="other">기타소득</option>
                </select>
              
                <label>피성년/피한정 후견인(법원의 후견인 심판을 받은 경우)</label>
                <input type="radio" id="guardianYes" name="guardian" value="yes">
                <label for="guardianYes">예</label>
                <input type="radio" id="guardianNo" name="guardian" value="no">
                <label for="guardianNo">아니요</label>
              
                <label>대출 신청 및 적합성 확인 결과 안내 수단</label>
                <input type="radio" id="contactEmail" name="contactMethod" value="email">
                <label for="contactEmail">이메일</label>
                <input type="radio" id="contactMobile" name="contactMethod" value="mobile">
                <label for="contactMobile">모바일</label>
<!--                <script>
                    function updateLoanAmountLimit() {
                        const loanType = document.getElementById("loanType").value;
                        const loanAmountInput = document.getElementById("loanAmount");
                        let maxAmount;

                        switch (loanType) {
                            case "credit":
                                maxAmount = 300000000; // 3억
                                break;
                            case "mortgage":
                                maxAmount = 1000000000; // 10억
                                break;
                            case "auto":
                                maxAmount = 60000000; // 6000만
                                break;
                            case "business":
                                maxAmount = 500000000; // 5억
                                break;
                            default:
                                maxAmount = "";
                        }

                        loanAmountInput.max = maxAmount;
                        loanAmountInput.value = ""; // 기존 입력값 초기화
                        loanAmountInput.placeholder = maxAmount ? `최대 ${maxAmount.toLocaleString()} 원` : "";
                        loanAmountInput.setCustomValidity(""); // 초기화
                    }

                    function validateLoanAmount() {
                        const loanAmountInput = document.getElementById("loanAmount");
                        const maxAmount = loanAmountInput.max;

                        if (loanAmountInput.value > maxAmount) {
                            loanAmountInput.setCustomValidity(`최대 ${maxAmount.toLocaleString()} 원까지 입력 가능합니다.`);
                        } else {
                            loanAmountInput.setCustomValidity(""); // 유효성 초기화
                        }
                        loanAmountInput.reportValidity(); // 오류 메시지 표시
                    }
                </script> -->
                <button type="submit" id="submitButton" /*disabled*/>확인</button>
              </form>
        </div>
    </div>
</body>
</html>
