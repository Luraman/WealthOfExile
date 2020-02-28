<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>The biggest of stonks</title>

    <script>
    function stashsearch() {
        document.getElementById("searchButton").setAttribute("disabled", true);
        document.getElementById("stashtabdata").innerHTML = "Searching...";
        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = searchcallback
            xmlhttp.open("GET", "poestashapi.php", true);
            xmlhttp.send();
    }

    function searchcallback() {
        var message = ""
        if (this.readyState == 4 && this.status == 200) {
            message = this.responseText;
        } else {
            message = "Connection failed - Status Code: " + this.status.toString();
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
    <p>This site will look up the wealth of a given exiles currency tab.<br>
    The first iteration of this site will simply yield the first currency tab it can find.<br>
    Use the button below to find a currency tab.</p>
</div>
<form>
  <input type="button" value="Search" id="searchButton" name="searchButton" onclick=stashsearch()>
</form> 
<div id="stashtab">
    <p><span id=stashtabdata>Click the button to start</span></p>
</div>
</body>
</html>