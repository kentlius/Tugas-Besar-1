function checkUsername(str) {
  if (str.length == 0) {
    document.getElementById("usernameErr").innerHTML = "";
    document.getElementById("username").style.borderColor = "#333333";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText === "green") {
          document.getElementById("username").style.borderColor =
            this.responseText;
          document.getElementById("usernameErr").innerHTML = "";
        } else {
          document.getElementById("username").style.borderColor = "#333333";
          document.getElementById("usernameErr").innerHTML = this.responseText;
        }
      }
    };
    xmlhttp.open("GET", "checkUsername.php?q=" + str, true);
    xmlhttp.send();
  }
}

function checkEmail(str) {
  if (str.length == 0) {
    document.getElementById("emailErr").innerHTML = "";
    document.getElementById("email").style.borderColor = "#333333";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText === "green") {
          document.getElementById("email").style.borderColor =
            this.responseText;
          document.getElementById("emailErr").innerHTML = "";
        } else {
          document.getElementById("email").style.borderColor = "#333333";
          document.getElementById("emailErr").innerHTML = this.responseText;
        }
      }
    };
    xmlhttp.open("GET", "checkEmail.php?q=" + str, true);
    xmlhttp.send();
  }
}
