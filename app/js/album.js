function checkAlbum(str) {
  if (str === "NULL") {
    document.getElementById("artist_name").value = "";
    document.getElementById("artist_name").disabled = false;
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("artist_name").value = this.responseText;
        // document.getElementById("artist_name").disabled = true;
      }
    };
    xmlhttp.open("GET", "checkAlbum.php?q=" + str, true);
    xmlhttp.send();
  }
}
