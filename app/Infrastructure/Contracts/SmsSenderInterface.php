<?php

namespace App\Infrastructure\Contracts;

use Illuminate\Support\Collection;

interface SmsSenderInterface
{

    public function setFrom(?string $from = null);

    public function send(string $to): bool;
}
