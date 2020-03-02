<?php
function countCurrencies($items) {
    return array_reduce($items
                      , function($result, $item) {
                            if ($item->catagory == "currency") {
                                if (!isset($result[$item->group])) {
                                    $result[$item->group] = array();
                                }
                                $result[$item->group][$item->name] = ($result[$item->group][$item->name] ?? 0) + $item->count;
                            }
                            return $result;
                     }, array());
}
?>