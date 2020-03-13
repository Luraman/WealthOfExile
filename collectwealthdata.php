<?php
require "credentials.php";
require "poestashapi.php";

$conn = new mysqli("woedb", $user, $pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

//$leagues = listActiveLeagues(fetchLeagues());
?>