function setValueFromPopup(value) {
  document.getElementById("select_bank").value = value;
}

function popupBank() {
  window.open("popup.html", "popupWindow", "width=300, height=200");
}

let currentBalance;
//잔액 조회 함수
function myAccount() {
  const user_num = document.getElementById("out_account").value;
  fetch(`../api/check_account.php?user_num=${user_num}`, {
    method: "GET",
  })
    .then((response) => response.json())
    // .then((response) => {
    //   console.log("res", response);
    // })
    .then((data) => {
      if (data.balance !== undefined) {
        currentBalance = parseFloat(data.balance);
        document.getElementById(
          "balance"
        ).innerHTML = `잔액: ${currentBalance}원`;
        console.log("잔액: " + currentBalance);
        console.log(data.balance);
      } else {
        document.getElementById("balance").innerHTML =
          "잔액 정보를 가져올 수 없습니다.";
        console.log("잔액 정보 오류");
      }
    })
    .catch((error) => {
      console.error("Error: ", error);
      document.getElementById("balance").innerHTML =
        "잔액 정보를 가져오는 중 오류가 발생하였습니다.";
    });
}

//이체 실행 함수
function transferSubmit() {
  const account_number_out = document.getElementById("out_account").value; //출금 계좌
  const account_number_in = document.getElementById("in_account").value; //입금 계좌
  const transferAmount = parseFloat(
    document.getElementById("transfer_amount").value
  );
  console.log("출금 계좌: ", account_number_out);
  console.log("입금 계좌: ", account_number_in);
  console.log("이체 금액: ", transferAmount);
  //서버로 이체 요청
  fetch(`../api/transfer_account.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      account_number_out: account_number_out,
      account_number_in: account_number_in,
      transfer_amount: transferAmount,
    }),
  })
    .then((response) => response.json())
    // .then((response) => {
    //   console.log("res", response);
    // })
    .then((data) => {
      console.log("서버응답:", data);
      if (data.success) {
        alert("이체가 완료되었습니다.");
        myAccount(account_number_out);
      } else {
        alert("이체에 실패했습니다." + data.message);
      }
    })
    .catch((error) => {
      console.log("오류: ", error);
    });

  return false;
}
