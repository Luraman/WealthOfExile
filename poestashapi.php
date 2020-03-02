<?php
require "datacleanup.php";

$url = "https://api.poe.watch/listings";

function fetchitems($league, $account) {
    $client = curl_init($GLOBALS["url"] . "?league=$league&account=$account");
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($client);
    $result = json_decode($response);
    return $result;
}

$result = fetchitems("Metamorph", "Luraman");

$currencyGroups = countCurrencies($result);

echo "<h2>Results:</h2><br>";
foreach ($currencyGroups as $currencyGroup => $currencies) {
    echo "<h4>{$currencyGroup}s</h4>:<br><ul>";
    foreach ($currencies as $currencyName => $currencyCount) {
        echo "<li>{$currencyName}: {$currencyCount}</li>";
    }
    echo "</ul>";
}
?>