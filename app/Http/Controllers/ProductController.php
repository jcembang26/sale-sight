<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(ProductInterface $productInterface, Request $request): object
    {
        $res = $productInterface->index($request);
        
        return response()->json($res);
    }

    public function store(ProductInterface $productInterface, Request $request): object
    {
        $request->validate([
            'data' => 'required|array',
            'data.*.id' => 'required',
            'data.*.productTypeId' => 'required',
            'data.*.size' => 'required',
            'data.*.price' => 'required|numeric',
        ]);

        $res = $productInterface->bulkInsert($request);

        return response()->json([
            'message' => 'Successfully inserted products',
            'failed' => $res['failed']
        ]);
    }
}
