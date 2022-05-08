<?php

namespace App\Services;

use App\Infrastructure\Contracts\SmsSenderInterface;
use Illuminate\Support\Collection;
use Melipayamak\MelipayamakApi;

class MeliPayamak implements SmsSenderInterface
{

    protected MelipayamakApi $instance;

    protected string $from;

    private const CONFIG = "sms.providers.melipayamak";

    public function __construct()
    {
        $this->instance = new MelipayamakApi(
            config(self::CONFIG . 'username'),
            config(self::CONFIG . 'password')
        );
    }

    public function send(string $to): bool
    {
        return true;
    }

    public function setFrom(?string $from = null)
    {
        $this->from = $from ?? config(self::CONFIG . 'from');

        return $this;
    }
}
