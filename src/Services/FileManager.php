<?php

namespace app\Services;

class FileManager
{
    private $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function save(array $data): bool
    {
        $json_data = json_encode($data, JSON_PRETTY_PRINT);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo 'JSON encoding error: ' . json_last_error_msg();
            return false;
        }

        return file_put_contents($this->filePath, $json_data) !== false;
    }

    public function load(): ?array
    {
        if (!file_exists($this->filePath)) {
            return null;
        }
        $json = file_get_contents($this->filePath);
        return json_decode($json, true);
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }
}
