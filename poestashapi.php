<?php
$url = "http://api.pathofexile.com/public-stash-tabs";

function fetchstashes($changeid) {
    $client = curl_init($GLOBALS["url"] . "?id=:" . $changeid);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($client);
    $result = json_decode($response);
    return $result;
}

$changeid = 0;
for ($x = 0; $x <= 100; $x++) {
    $result = fetchstashes($changeid);

    if ($result->next_change_id == $changeid) {
        echo "Nothing Found!";
        break;
    } else {
        $changeid = $result->next_change_id;
    }

    $currencystashes = array_filter($results->stashes, function ($stash) {
        return $stash["stashType"] == "CurrencyStash";
    });

    if (!empty($currencystashes)) {
        echo json_encode($currencystashes[0]);
        break;
    }
}
?>