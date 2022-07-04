<?php

namespace App\Api\Shared\Infrastructure\Cache;


use App\Api\Shared\Domain\Repository\Cache\ICacheRepository;
use Symfony\Component\Cache\Adapter\FilesystemTagAwareAdapter;

class FileCache implements ICacheRepository
{
    /* @var $cache FilesystemTagAwareAdapter */
    private $cache;

    public function __construct(string $projectDir, string $env)
    {
        $this->cache = new FilesystemTagAwareAdapter(
            // a string used as the subdirectory of the root cache directory, where cache
            // items will be stored
            'FilesystemCache',
            // the default lifetime (in seconds) for cache items that do not define their
            // own lifetime, with a value 0 causing items to be stored indefinitely (i.e.
            // until the files are deleted)
            $TTL = 3600,
            // the main cache directory (the application needs read-write permissions on it)
            // if none is specified, a directory is created inside the system temporary directory
            $projectDir . DIRECTORY_SEPARATOR . "var/cache/$env"
        );
    }

    public function getCacheDriver(): self
    {
        return $this;
    }

    public function getItemIfExists(string $key)
    {
        $cacheItem = $this->cache->getItem($key);

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        } else {
            return false;
        }
    }

    public function get(string $key)
    {
        return $this->cache->getItem($key)->get();
    }

    public function set(string $key, $value)
    {
        $cacheItem = $this->cache->getItem($key);
        $cacheItem->set($value);
        $this->cache->save($cacheItem);
    }

    public function deletCache(string $key)
    {
        $this->cache->deleteItem($key);
    }
}
