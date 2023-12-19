<?php
// app/Traits/Searchable.php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeSearch(Builder $query, $searchTerm, $searchableColumns, $status = null)
    {
        $query->where(function ($query) use ($searchTerm, $searchableColumns) {
            foreach ($searchableColumns as $column) {
                $query->orWhere($column, 'LIKE', "%$searchTerm%");
            }
        });

        if ($status !== null) {
            $query->where('status', '=', $status);
        }

        return $query;
    }
}
