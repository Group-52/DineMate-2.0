document.addEventListener("DOMContentLoaded", () => {
  const verifyInputs = document.querySelectorAll(".verify-input");
  verifyInputs.forEach((input) => {
    input.onkeyup = (e) => {
      if (e.target.value.length >= 1 && e.target.nextElementSibling) {
        let codeInput = e.target;
        let code = codeInput.value;
        while (code.length > 0) {
          codeInput.value = code[0];
          code = code.slice(1);
          codeInput = codeInput.nextElementSibling;
        }
        if (codeInput) {
          codeInput.focus();
        }
      } else if (
        e.target.value.length === 0 &&
        e.target.previousElementSibling
      ) {
        e.target.previousElementSibling.focus();
      }
    };
  });

  const resendLink = document.getElementById("resend-code");
  const message = document.getElementById("message");
  resendLink.onclick = () => {
    fetch(ROOT + "/api/profile/resendOTP")
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success") {
          message.innerHTML = "Verification code sent to your email";
        } else {
          message.innerHTML = "Something went wrong";
        }
      });
  };

  const verifyForm = document.getElementById("verify-form");
  verifyForm.onsubmit = (e) => {
    e.preventDefault();
    let otp = "";
    verifyInputs.forEach((input) => {
      otp += input.value.trim();
    });
    fetch(ROOT + "/api/profile/verify", {
      method: "POST",
      body: JSON.stringify({ otp }),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success") {
          message.innerHTML = "Email verified successfully";
          setTimeout(() => {
            window.location.href = ROOT + "/profile";
          }, 2000);
        } else {
          message.innerHTML = "Invalid verification code";
        }
      })
      .catch((err) => {
        message.innerHTML = "Something went wrong";
      });
  };
});
