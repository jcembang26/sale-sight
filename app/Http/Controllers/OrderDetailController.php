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

    /**
     * Store data from CSV using OrderDetailService
     *
     * @param OrderDetailInterface $orderDetailInterface
     * @param Request $request
     * @return object
     */
    public function store(OrderDetailInterface $orderDetailInterface, Request $request): object
    {

        $request->validate([
            'data' => 'required|array',
            'data.*.id' => $this->rules['requiredNumeric'],
            'data.*.orderId' => $this->rules['requiredNumeric'],
            'data.*.productId' => 'required',
            'data.*.quantity' => $this->rules['requiredNumeric'],
        ]);

        $res = $orderDetailInterface->bulkInsert($request);

        return response()->json([
            'message' => 'Successfully inserted orders',
            'failed' => $res['failed']
        ]);
    }
}
