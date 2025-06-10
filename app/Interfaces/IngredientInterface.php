<?php

namespace App\Interfaces;

interface IngredientInterface
{
    /**
     * Store data to table
     *
     * @param array $array
     * @param string $productTypeId
     * @return boolean
     */
    public function store(array $array = [], string $productTypeId = ''): bool;
}
