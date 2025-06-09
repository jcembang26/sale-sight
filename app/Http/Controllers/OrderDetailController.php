<?php

namespace App\Http\Controllers;

use App\Interfaces\OrderDetailInterface;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    protected $rules = [];

    public function __construct()
    {
        $this->rules = [
            'requiredNumeric' => 'required|numeric'
        ];
    }


    public function store(OrderDetailInterface $orderDetailInterface, Request $request): object
    {

        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => $this->rules['requiredNumeric'],
            'orders.*.orderId' => $this->rules['requiredNumeric'],
            'orders.*.productId' => 'required',
            'orders.*.quantity' => $this->rules['requiredNumeric'],
        ]);

        $res = $orderDetailInterface->bulkInsert($request);

        return response()->json([
            'message' => 'Successfully inserted orders',
            'failed' => $res['failed']
        ]);
    }
}
