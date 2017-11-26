<?php

namespace App\Models\Traits;

trait Sortable
{
    public function scopeOrdered($query, $orderOverride = null)
    {
        $order = request('orderby') ?: $orderOverride ?: $this->orderby;
        if ($order) {

            $order = explode(',', $order);
            $directioin = isset($order[1]) ? $order[1] : 'asc';

            $orderName = "\\App\\Models\\Sort\\" . class_basename($this). "Sort";
            if (class_exists($orderName)) {
                $query = (new $orderName($this, $query))->work($order[0], $directioin);

                return $query;
            }

            return $query->orderBy($order[0], $directioin);
        }

        return $query;
    }
}
