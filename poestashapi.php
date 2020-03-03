<?php
require "datacleanup.php";

$url = "https://api.poe.watch";
$league = "Metamorph";

function fetch($url) {
    $client = curl_init($url);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($client);
    $result = json_decode($response);
    return $result;
}

function fetchItems($league, $account) {
    return fetch($GLOBALS["url"] . "/listings?league=$league&account=$account");
}

function fetchPrices($league, $category) {
    return fetch($GLOBALS["url"] . "/get?league=$league&category=$category");
}

function grouptocategory($group) {
    if ($group == "card") {
        return "card";
    } elseif ($group == "fragment" || $group == "scarab") {
        return "map";
    } else {
        return "currency";
    }
}

$account = filter_var($_GET["account"], FILTER_SANITIZE_STRING);

$currencyGroups = countCurrencies(fetchItems($league, $account));

$prices = array();
foreach (array("currency", "card", "map") as $category) {
    $prices[$category] = buildPriceLookup(fetchPrices($league, $category));
}

$exaltPrice = $prices["currency"]["Exalted Orb"];

$combinedPrice = 0.0;

echo "<h2>Results for {$account}:</h2>";
foreach ($currencyGroups as $currencyGroup => $currencies) {
    echo "<h4>{$currencyGroup}:</h4><ul>";
    foreach ($currencies as $currencyName => $currencyCount) {
        $price = $prices[grouptocategory($currencyGroup)][$currencyName];
        $combinedPrice += $price * $currencyCount;
        $formattedPrice = number_format($price, 1);
        echo "<li>{$currencyName}: {$currencyCount} - {$formattedPrice}c</li>";
    }
    echo "</ul>";
}
$formattedCombinedPriceInChaos = number_format($combinedPrice, 1);
$formattedCombinedPriceInExalts = number_format($combinedPrice / $exaltPrice, 1);

echo "<h2>{$account} has a networth of: {$formattedCombinedPriceInChaos}c or ${formattedCombinedPriceInExalts}ex</h2>";
?>