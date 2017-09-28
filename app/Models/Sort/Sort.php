<?php

namespace App\Models\Sort;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

abstract class Sort
{
    /**
     * @var Builder
     */
    protected $query;
    /**
     * @var Model
     */
    protected $model;
    protected $only = ['created_at', 'updated_at'];

    public function __construct($model, $query)
    {
        $this->query = $query;
        $this->model = $model;
    }

    public function work($order, $direction)
    {
        $order = $this->formatOrderName($order);
        if (method_exists($this, $order)) {
            return $this->{$order}($direction);
        }

        if (!in_array(Str::snake($order), $this->only)) {
            return $this->query;
        }

        return $this->query->orderBy(Str::snake($order), $direction);
    }

    private function formatOrderName($order)
    {
        return Str::camel(
            str_replace(['.', '|', '-'], '_', $order)
        );
    }
}
