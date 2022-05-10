<?php

namespace App\Infrastructure\Contracts;

use Closure;

interface CacheableRepositoryInterface extends RepositoryInterface
{

    public function cache(mixed|Closure $data, ?int $ttl);

    public function clear(string $key);
}
