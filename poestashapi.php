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

class AccountWealth {
    public $currencyGroups;
    public $combinedPrice;
    public $combinedPriceExalts;

    public function __construct($accountName, &$prices) {
        $this->combinedPrice = 0;
        $this->currencyGroups = countCurrencies(fetchItems($GLOBALS["league"], $accountName));
        foreach ($this->currencyGroups as $currencyGroup => $currencies) {
            foreach ($currencies as $currencyName => $currencyCount) {
                $price = $prices[grouptocategory($currencyGroup)][$currencyName];
                $this->combinedPrice += $price * $currencyCount;
            }
        }
        $this->combinedPriceExalts = $this->combinedPrice / $prices["currency"]["Exalted Orb"];
    }
}

$account = filter_var($_GET["account"], FILTER_SANITIZE_STRING);

$prices = array();
foreach (array("currency", "card", "map") as $category) {
    $prices[$category] = buildPriceLookup(fetchPrices($league, $category));
}

$wealth = new AccountWealth($account, $prices);

$formattedCombinedPriceInChaos = number_format($wealth->combinedPrice, 1);
$formattedCombinedPriceInExalts = number_format($wealth->combinedPrice / $prices["currency"]["Exalted Orb"], 1);

echo "<h2>{$account} has a networth of: {$formattedCombinedPriceInChaos}c or ${formattedCombinedPriceInExalts}ex</h2>";

echo "<h2>Results for {$account}:</h2>";
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