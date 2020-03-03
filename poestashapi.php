<?php
require "datacleanup.php";

$url = "https://api.poe.watch";
$league = "Metamorph";
$account = filter_var($_GET["account"], FILTER_SANITIZE_STRING);

function fetchitems($league, $account) {
    $client = curl_init($GLOBALS["url"] . "/listings?league=$league&account=$account");
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($client);
    $result = json_decode($response);
    return $result;
}

function fetchprices($league, $category) {
    $client = curl_init($GLOBALS["url"] . "/get?league=$league&category=$category");
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($client);
    $result = json_decode($response);
    return $result;
}

$result = fetchitems($league, $account);

$currencyGroups = countCurrencies($result);

echo "<h2>Results for {$account}:</h2><br>";
foreach ($currencyGroups as $currencyGroup => $currencies) {
    echo "<h4>{$currencyGroup}:</h4><ul>";
    foreach ($currencies as $currencyName => $currencyCount) {
        echo "<li>{$currencyName}: {$currencyCount}</li>";
    }
    echo "</ul>";
}
?>