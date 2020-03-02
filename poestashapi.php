<?php
require "datacleanup.php";

$url = "http://api.pathofexile.com/public-stash-tabs";

function fetchstashes($changeid) {
    echo "Fetching $changeid<br>";
    $client = curl_init($GLOBALS["url"] . "?id=$changeid");
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($client);
    $result = json_decode($response);
    return $result;
}

$changeid = "";
for ($x = 0; $x <= 100; $x++) {
    $result = fetchstashes($changeid);

    if ($result->next_change_id == $changeid) {
        echo "Nothing Found!";
        break;
    } else {
        $changeid = $result->next_change_id;
    }

    $currencystashes = array_filter($result->stashes, function ($stash) {
        return $stash->stashType == "CurrencyStash" && $stash->public == true;
    });

    if (empty($currencystashes)) {
        continue;
    }

    $firstStash = reset($currencystashes);
    $currencies = countCurrencies($firstStash);

    echo "Account name: $stach->accountName<br>";
    foreach ($currencies as $currencyName => $currencyCount) {
        echo "$currencyName: $currencyCount<br>";
    }
    break;
}
?>