<?php

namespace App\Services;

use App\Interfaces\ProductCategoryInterface;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;

class ProductCategoryService implements ProductCategoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    
    public function createOrFetch(array $product = []): array
    {
        $name = strtolower($product['category'] ?? '');
        $currentUser = Auth::user();

        if(empty($name)){
            return [];
        }

        $categoryId = 0;
        $ingredientId = 0;

        $res = ProductCategory::firstOrCreate(['name' => $name], [
            'name' => $name,
            'category_id' => $categoryId,
            'ingredients_id' => $ingredientId,
            'created_by' => $currentUser->id
        ]);

        return $res ? $res->toArray() : [];
    }
}
