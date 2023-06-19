const btnOpenEye = document.querySelectorAll(".open_eye");
const btnClosedEye = document.querySelectorAll(".closed_eye");

btnOpenEye.forEach((btn) => {
  btn.onclick = function () {
    let boxActionsPass = this.parentElement;
    let input = boxActionsPass
      .closest(".box_password_auth")
      .getElementsByTagName("input")[0];

    let btnCloseEye = boxActionsPass.querySelector(".closed_eye");

    this.style.display = "none";
    btnCloseEye.style.display = "block";

    input.type = "text";
  };
});

btnClosedEye.forEach((btn) => {
  btn.onclick = function () {
    let boxActionsPass = this.parentElement;
    let input = boxActionsPass
      .closest(".box_password_auth")
      .getElementsByTagName("input")[0];

    let btnOpenEye = boxActionsPass.querySelector(".open_eye");

    this.style.display = "none";
    btnOpenEye.style.display = "block";

    input.type = "password";
  };
});
