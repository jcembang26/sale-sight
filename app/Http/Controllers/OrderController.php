<?php

namespace App\Http\Controllers;

use App\Interfaces\OrderInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Store data from CSV using OrderService
     *
     * @param OrderInterface $orderInterface
     * @param Request $request
     * @return object
     */
    public function store(OrderInterface $orderInterface, Request $request): object
    {
        $request->validate([
            'data' => 'required|array',
            'data.*.id' => 'required',
            'data.*.date' => 'required',
            'data.*.time' => 'required'
        ]);

        $res = $orderInterface->bulkInsert($request);

        return response()->json([
            'message' => 'Successfully inserted orders',
            'failed' => $res['failed']
        ]);
    }
}
