<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductInterface
{
    public function index(Request $request): object;
    public function bulkInsert(Request $request): array;
}
