<?php

namespace App\Interfaces;

interface ProductCategoryInterface
{
    public function createOrFetch(array $product = []): array;
}
