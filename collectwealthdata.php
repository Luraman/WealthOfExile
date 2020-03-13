<?php
//require "credentials.php";
require "poestashapi.php";
$user = "fake";
$pass = "fake";

$conn = new mysqli("localhost", $user, $pass, "woedb");

if ($conn->connect_error) {
    echo "Connection failed: {$conn->connect_error}</p>";
    die();
}

echo "<p>Connected successfully</p>";

//$leagues = listActiveLeagues(fetchLeagues());
?>