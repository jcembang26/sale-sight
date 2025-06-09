<?php

namespace App\Interfaces;

interface IngredientInterface
{
    public function store(array $array = [], string $productTypeId = ''): bool;
}
