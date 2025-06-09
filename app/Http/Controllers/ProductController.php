<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(ProductInterface $productInterface, Request $request): object
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required',
            'products.*.productTypeId' => 'required',
            'products.*.size' => 'required',
            'products.*.price' => 'required|numeric',
        ]);

        $res = $productInterface->bulkInsert($request);

        return response()->json([
            'message' => 'Successfully inserted products',
            'failed' => $res['failed']
        ]);
    }
}
