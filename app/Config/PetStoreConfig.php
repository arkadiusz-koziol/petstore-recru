<?php

namespace App\Config;

class PetStoreConfig
{
    public function __construct(protected array $config)
    {
    }

    public function apiUrl(): string
    {
        return $this->config['api_url'];
    }
}
