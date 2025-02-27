<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class OrderByScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $defaultOrderColumn = 'created_at';
        $defaultOrderDirection = 'desc';

        $orderBy = request()->get('order_by', $defaultOrderColumn);
        $orderDirection = request()->get('order', $defaultOrderDirection);

        if (in_array($orderBy, array_merge(['updated_at'], $model->getFillable())) && in_array(strtolower($orderDirection), ['asc', 'desc'])) {
            $builder->orderBy($model->getTable() . '.' . $orderBy, $orderDirection);
        }
    }
}
