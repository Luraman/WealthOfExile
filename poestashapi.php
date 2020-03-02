<?php
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
for ($x = 0; $x <= 1; $x++) {
    $result = fetchstashes($changeid);

    if ($result->next_change_id == $changeid) {
        echo "Nothing Found!";
        break;
    } else {
        $changeid = $result->next_change_id;
    }

    echo $result->stashes[0] . "<br>";

    $currencystashes = array_filter($results->stashes, function ($stash) {
        return $stash->stashType == "PremiumStash";
    });

    if (!empty($currencystashes)) {
        echo json_encode($currencystashes[0]);
        break;
    }
}
?>