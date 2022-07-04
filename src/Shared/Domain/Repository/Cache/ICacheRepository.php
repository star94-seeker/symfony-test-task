<?php

namespace App\Api\Shared\Domain\Repository\Cache;

interface ICacheRepository
{   
    public function getItemIfExists(string $key);
    public function get(string $key);
    public function getCacheDriver(): self;
}