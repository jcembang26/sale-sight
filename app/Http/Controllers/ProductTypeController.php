<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductTypeInterface;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function store(ProductTypeInterface $productTypeInterface, Request $request): object
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.productTypeId' => 'required',
            'products.*.name' => 'required',
            'products.*.category' => 'required',
            'products.*.ingredients' => 'required|array',
        ]);

        $res = $productTypeInterface->bulkInsert($request);

        return response()->json([
            'message' => 'Successfully inserted products',
            'failed' => $res['failed']
        ]);
    }
}
