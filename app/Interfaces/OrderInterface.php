<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface OrderInterface
{
    public function bulkInsert(Request $request): array;
    public function ordersPerDay(): array;
}
