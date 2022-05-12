<?php

namespace App\Infrastructure\Contracts\Repository;

interface ObservableRepository
{
    public function created();

    public function updated();

    public function deleted();
}
