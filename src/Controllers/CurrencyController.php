<?php

namespace app\Controllers;

use app\Services\CurrencyDataFetcher;
use app\Services\FileManager;
use app\Models\CurrencyPair;

class CurrencyController
{
    private $fetcher;
    private $fileManager;
    private $cacheDuration = 600; // check 10 mins old for data.json with tickers

    public function __construct(CurrencyDataFetcher $fetcher, FileManager $fileManager)
    {
        $this->fetcher = $fetcher;
        $this->fileManager = $fileManager;
    }

    public function getCurrencyPairs(string $filter = ''): array
    {
        $data = $this->fileManager->load();
        $currencyPairs = [];

        if ($data) {
            foreach ($data as $item) {
                if (isset($item['symbol']) && isset($item['price'])) {
                    $currencyPairs[] = new CurrencyPair($item['symbol'], (float)$item['price']);
                }
            }

            if ($filter) {
                $currencyPairs = array_filter($currencyPairs, function ($pair) use ($filter) {
                    return stripos($pair->getSymbol(), $filter) !== false;
                });
            }
        }

        return $currencyPairs;
    }

    public function updateCurrencyData()
    {
        $filePath = $this->fileManager->getFilePath();
        $fileExists = file_exists($filePath);
        $fileIsOld = $fileExists && (time() - filemtime($filePath) > $this->cacheDuration);

        if (!$fileExists || $fileIsOld) {
            $data = $this->fetcher->fetch();
            if ($data) {
                $this->fileManager->save($data);
            }
        }
    }
}
