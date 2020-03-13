<?php
require "poestashapi.php";

$leagues = listActiveLeagues(fetchLeagues());

foreach ($leagues as $league) {
    echo "<option value='$league'>$league</option>\n";
}
?>