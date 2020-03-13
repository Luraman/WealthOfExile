<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>The biggest of stonks</title>

    <script>
    function main() {
        document.getElementById("lookupForm").onsubmit = function(event) {
            getaccountlookup();
            return false;
        }
        getleagueslookup();
    }
    
    function httprequest(url, callbackExec, formdata=null) {
        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    callbackExec(this.status == 200, this.responseText);
                }
            };
            xmlhttp.open("POST", url, true);
            if (formdata) {
                xmlhttp.send(formdata);
            } else {
                xmlhttp.send();
            }
    }

    function getaccountlookup() {
        var formData = new FormData(document.getElementById("lookupForm"));
        for (var key of formData.keys) {
            alert("".concat(key, ": ", formData[key]));
            alert(key);
        }
        document.getElementById("searchButton").setAttribute("disabled", true);
        document.getElementById("stashtabdata").innerHTML = "<p>Searching...</p>";
        httprequest(`accountlookup.php`, execaccountlookup, formData);
    }

    function execaccountlookup(success, response) {
        var message = "";
        if (success) {
            message = response;
        } else {
            message = `<p>Connection failed</p>`;
        }
        document.getElementById("stashtabdata").innerHTML = message;
        document.getElementById("searchButton").removeAttribute("disabled");
    }

    function getleagueslookup() {
        httprequest(`leagueslookup.php`, execleagueslookup);
    }

    function execleagueslookup(success, response) {
        var message = "";
        if (success) {
            message = response;
        } else {
            message = `<option value="">No current leagues</option>`;
        }
        document.getElementById("leaguesDropdown").innerHTML = message;
    }
    </script>
</head>

<body onload="main()">
<div id="alert">
    <h2>Notice: Expect bugs</h2>
</div>
<div id="instructions">
    <p>This site will aggregate the wealth of a given exile.<br>
    The current iteration of this site shows the currencies of an account in Metamorph league.<br>
    Use the form below to find an account.</p>
</div>
<form id="lookupForm">
  <input type="text" value="Account Name" id="accountName" name="accountName">
  <select id="leaguesDropdown" form="lookupForm">
      <option value="Loading">Loading...</option>
  </select>
  <input type="submit" value="Search" id="searchButton" name="searchButton">
</form>
<div id="stashtab">
    <span id=stashtabdata><p>Click the button to start</p></span>
</div>
</body>
</html>