<?php

namespace App\Services;

use App\Interfaces\DashboardInterface;
use Illuminate\Http\Request;
use App\Traits\CountsUniqueRecords;

class DashboardService implements DashboardInterface
{
    use CountsUniqueRecords;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function summary(Request $request): array
    {
        $orderService = app(OrderService::class);

        return [
            'totalProducts' => $this->countUnique(\App\Models\Product::class, 'product_id'),
            'totalProductTypes' => $this->countUnique(\App\Models\ProductType::class, 'product_type_id'),
            'totalOrders' => $this->countUnique(\App\Models\Order::class, 'id'),
            'totalOrderDetails' => $this->countUnique(\App\Models\OrderDetail::class, 'id'),
            'activeUsers' => $this->countUnique(\App\Models\User::class, 'id'),
            'ordersPerDay' => $orderService->ordersPerDay()
        ];
    }
}
