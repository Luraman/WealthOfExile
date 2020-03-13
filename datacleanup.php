<?php
function countCurrencies($items) {
    return array_reduce($items
                      , function($result, $item) {
                            if (currencyFilter($item)) {
                                if (!isset($result[$item->group])) {
                                    $result[$item->group] = array();
                                }
                                $result[$item->group][$item->name] = ($result[$item->group][$item->name] ?? 0) + $item->count;
                            }
                            return $result;
                     }, array());
}

function currencyFilter($item) {
    return $item->category == "card" ||
           $item->category == "currency" ||
          ($item->category == "map"   && ($item->group == "fragment" || $item->group == "scarab"));
}

function buildPriceLookup($items) {
    return array_reduce($items
                      , function($result, $item) {
                            if (currencyFilter($item)) {
                                $result[$item->name] = $item->mean;
                            }
                            return $result;
                     }, array());
}

function listActiveLeagues($leagues) {
    return array_reduce($leagues
                      , function($result, $league) {
                          if ($league->active) {
                              $result[] = $league->name;
                          }
                          return $result;
                     }, array());
}
?>