<?php
require "datacleanup.php";

$url = "https://api.poe.watch";
$league = "Metamorph";

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

$currencyGroups = countCurrencies(fetchitems($league, $account));

$prices = array();
foreach (array("currency", "card", "map") as $category) {
    $prices[$category] = buildPriceLookup(fetchprices($league, $category));
}

$combinedPrice = 0.0;

echo "<h2>Results for {$account}:</h2>";
foreach ($currencyGroups as $currencyGroup => $currencies) {
    echo "<h4>{$currencyGroup}:</h4><ul>";
    foreach ($currencies as $currencyName => $currencyCount) {
        $price = $prices[grouptocategory($currencyGroup)][$currencyName];
        $combinedPrice += $price;
        $formattedPrice = number_format($price,1);
        echo "<li>{$currencyName}: {$currencyCount} - {$price}c</li>";
    }
    echo "</ul>";
}
$formattedCombinedPrice = number_format($combinedPrice,1);
echo "<h2>{$account} has a networth of: {$formattedCombinedPrice}c</h2>"
?>