<?php

namespace App\Services;

use App\Interfaces\ProductSizeInterface;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Auth;

class ProductSizeService implements ProductSizeInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createOrFetch(array $arr = []): array
    {
        $name = strtolower($arr['size'] ?? '');
        $currentUser = Auth::user();

        if(empty($name)){
            return [];
        }

        $res = ProductSize::firstOrCreate(['name' => $name], [
            'created_by' => $currentUser->id
        ]);

        return $res ? $res->toArray() : [];
    }
}
