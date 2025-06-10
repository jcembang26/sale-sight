<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface OrderInterface
{
    /**
     * Bulk insert data from CSV to table
     *
     * @param Request $request
     * @return array
     */
    public function bulkInsert(Request $request): array;

    /**
     * Get order group by day
     *
     * @return array
     */
    public function ordersPerDay(): array;
}
