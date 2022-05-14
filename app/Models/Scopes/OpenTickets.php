<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Carbon;

class OpenTickets implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {

        $builder->where('must_close_at')
            ->orWhere('must_close_at', '>', Carbon::now(TIMEZONE));
        // $builder->where('must_close_at', '>', Carbon::now(TIMEZONE))
        //     ->orWhere(function (Builder $query) {
        //         $query->where('must_close_at', '<=', Carbon::now(TIMEZONE))
        //             ->whereHas('messages');
        //     });
    }
}
