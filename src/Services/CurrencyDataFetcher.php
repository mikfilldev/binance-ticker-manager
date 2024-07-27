<?php

namespace app\Services;

class CurrencyDataFetcher
{
    private $apiUrl;

    public function __construct(string $apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }
    function fetch(): ?array
    {
        $url = $this->apiUrl;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
            curl_close($ch);
            return null;
        }

        curl_close($ch);
        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo 'JSON error: ' . json_last_error_msg();
            return null;
        }

        return $data;
    }
}
