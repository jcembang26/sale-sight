<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface OrderDetailInterface
{
    public function bulkInsert(Request $request): array;
}
