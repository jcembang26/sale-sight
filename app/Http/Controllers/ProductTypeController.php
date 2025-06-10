<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductTypeInterface;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Store data from CSV using ProductTypeService
     *
     * @param ProductTypeInterface $productTypeInterface
     * @param Request $request
     * @return object
     */
    public function store(ProductTypeInterface $productTypeInterface, Request $request): object
    {
        $request->validate([
            'data' => 'required|array',
            'data.*.productTypeId' => 'required',
            'data.*.name' => 'required',
            'data.*.category' => 'required',
            'data.*.ingredients' => 'required|array',
        ]);

        $res = $productTypeInterface->bulkInsert($request);

        return response()->json([
            'message' => 'Successfully inserted products',
            'failed' => $res['failed']
        ]);
    }
}
