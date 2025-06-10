<?php

namespace App\Interfaces;

interface ProductCategoryInterface
{
    /**
     * Creates a new product record if it doesn't exist,
     * otherwise fetches the existing product data.
     *
     * @param array $product
     * @return array
     */
    public function createOrFetch(array $product = []): array;
}
