<?php

namespace App\Interfaces;

interface ProductSizeInterface
{
    public function createOrFetch(array $arr = []): array;
}
