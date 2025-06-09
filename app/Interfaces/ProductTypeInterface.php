<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductTypeInterface
{
    public function createOrFetch(array $arr = []): array;
    public function bulkInsert(Request $request): array;
}
