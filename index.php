<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>The biggest of stonks</title>

    <script>
    function httprequest(url, callbackExec) {
        print("httprequest");
        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {httpcallback(callbackExec);};
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
    }

    function httpcallback(callbackExec) {
        print("httpcallback");
        if (this.readyState == 4 && this.status == 200) {
            callbackExec(false, this.responseText);
        } else {
            callbackExec(true, this.responseText);
        }
    }

    function getaccountlookup() {
        print("getaccountlookup");
        $accountName = encodeURIComponent(document.getElementById("accountNameInput").value);
        document.getElementById("searchButton").setAttribute("disabled", true);
        document.getElementById("stashtabdata").innerHTML = "Searching...";
        httprequest(`accountlookup.php?account=${$accountName}`, execaccountlookup);
    }

    function execaccountlookup(success, response) {
        print("execaccountlookup");
        var message = ""
        if (success) {
            message = response;
        } else {
            message = `<p>Connection failed - Status Code: ${this.status.toString()} </p>`;
        }
        document.getElementById("stashtabdata").innerHTML = message;
        document.getElementById("searchButton").removeAttribute("disabled");
    }

    function getleagues() {
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
  <select id="leaguesDropdown" beforeprint=getleagues()>
      <option value="Loading">Loading...</option>
  </select>
  <input type="button" value="Search" id="searchButton" name="searchButton" onclick=getaccountlookup()>
</form>
<div id="stashtab">
    <span id=stashtabdata><p>Click the button to start</p></span>
</div>
</body>
</html>