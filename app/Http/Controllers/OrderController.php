<?php

namespace App\Http\Controllers;

use App\Interfaces\OrderInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(OrderInterface $orderInterface, Request $request): object
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required',
            'orders.*.date' => 'required',
            'orders.*.time' => 'required'
        ]);

        $res = $orderInterface->bulkInsert($request);

        return response()->json([
            'message' => 'Successfully inserted orders',
            'failed' => $res['failed']
        ]);
    }
}
