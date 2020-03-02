<?php
function countCurrencies($stash) {
    return array_reduce($stash->items, function($result, $item) {
        $result[$item->typeLine] = $item->stackSize ?? 1;
        return $result;
                     }, array());
}
?>