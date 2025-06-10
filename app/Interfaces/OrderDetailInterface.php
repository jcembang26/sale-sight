<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface OrderDetailInterface
{
    /**
     * Bulk insert data from CSV to table
     *
     * @param Request $request
     * @return array
     */
    public function bulkInsert(Request $request): array;
}
