<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Infrastructure\Contracts\CacheableRepositoryInterface;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

abstract class AbstractCacheRepository implements CacheableRepositoryInterface
{

    protected string $key;

    protected int $ttl;

    protected static Model $cashed;

    public function __construct(protected Model $model)
    {
        if (empty(static::$cashed))
            static::$cashed = Cache::remember(
                $this->key,
                $this->ttl,
                $this->source("all")
            );
    }

    public function find(int|array $id)
    {
        $result = is_array($id)
            ? $this->get()->findMany($id)
            : $this->get()->find($id);

        if (empty($result)) {
            $result = $this->source(__FUNCTION__, $id);
            if ($result)
                $this->cache($result, $this->ttl);
        }

        return $result;
    }

    public function cache(mixed $data, ?int $ttl = null)
    {
        $data = $data instanceof Closure
            ? $data()
            : $data;

        $ttl ?
            $this->model = Cache::remember($this->key, $ttl, fn () => $data)

            : $this->model = Cache::rememberForever($this->key, fn () => $data);

        return;
    }

    public function clear(string $key)
    {
        return Cache::forget($key);
    }

    public function get()
    {
        return static::$cashed;
    }

    public function source(?string $method, ...$args)
    {
        if ($method)
            return $this->model->{$method}(...$args);

        return $this->model;
    }
}
