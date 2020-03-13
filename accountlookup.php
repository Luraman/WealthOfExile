<?php
require "poestashapi.php";

$account = filter_var($_POST["accountName"], FILTER_SANITIZE_STRING);
$league = filter_var($_POST["league"], FILTER_SANITIZE_STRING);

$prices = array();
foreach (array("currency", "card", "map") as $category) {
    $prices[$category] = buildPriceLookup(fetchPrices($league, $category));
}

$wealth = new AccountWealth($account, $prices);

$formattedCombinedPriceInChaos = number_format($wealth->combinedPrice, 1);
$formattedCombinedPriceInExalts = number_format($wealth->combinedPriceExalts, 1);

echo "<h2>{$league} - {$account} has a networth of: {$formattedCombinedPriceInChaos}c or ${formattedCombinedPriceInExalts}ex</h2>";

echo "<h2>Listed items from {$account}:</h2>";
foreach ($wealth->currencyGroups as $currencyGroup => $currencies) {
    echo "<h4>{$currencyGroup}:</h4><ul>";
    foreach ($currencies as $currencyName => $currencyCount) {
        $price = $prices[grouptocategory($currencyGroup)][$currencyName];
        $formattedPrice = number_format($price, 1);
        echo "<li>{$currencyName}: {$currencyCount} - {$formattedPrice}c</li>";
    }
    echo "</ul>";
}
?>