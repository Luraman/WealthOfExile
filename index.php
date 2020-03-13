<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>The biggest of stonks</title>

    <script>
    function stashsearch() {
        $accountName = encodeURIComponent(document.getElementById("accountNameInput").value);
        document.getElementById("searchButton").setAttribute("disabled", true);
        document.getElementById("stashtabdata").innerHTML = "Searching...";
        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = searchcallback
            xmlhttp.open("GET", `accountlookup.php?account=${$accountName}`, true);
            xmlhttp.send();
    }

    function searchcallback() {
        var message = ""
        if (this.readyState == 4 && this.status == 200) {
            message = this.responseText;
        } else {
            message = `<p>Connection failed - Status Code: ${this.status.toString()} </p>`;
        }
        document.getElementById("stashtabdata").innerHTML = message;
        document.getElementById("searchButton").removeAttribute("disabled");
    }
    </script>
</head>
<body>
<div id="alert">
    <h2>Notice: Expect bugs</h2>
</div>
<div id="instructions">
    <p>This site will aggregate the wealth of a given exile.<br>
    The current iteration of this site shows the currencies of an account in Metamorph league.<br>
    Use the form below to find an account.</p>
</div>
<form>
  <input type="text" value="Account Name" id="accountNameInput" name="accountNameInput">
  <select id="leagues">
      <option value="standard">Standard</option>
      <option value="hardcore">Hardcore</option>
  </select>
  <input type="button" value="Search" id="searchButton" name="searchButton" onclick=stashsearch()>
</form>
<div id="stashtab">
    <span id=stashtabdata><p>Click the button to start</p></span>
</div>
</body>
</html>