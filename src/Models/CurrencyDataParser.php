<?php

namespace app\Models;

class CurrencyDataParser
{
    public static function parse(string $json): array
    {
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Error parsing JSON: ' . json_last_error_msg());
        }

        $currencyPairs = [];
        foreach ($data as $item) {
            if (isset($item['symbol']) && isset($item['price'])) {
                $currencyPairs[] = new CurrencyPair($item['symbol'], (float)$item['price']);
            }
        }

        return $currencyPairs;
    }
}
