<?php

namespace App\Services;

use App\Models\Ingredient;
use App\Models\IngredientProductType;
use Illuminate\Support\Facades\Auth;

class IngredientService
{
    public function store(array $array = [], string $productTypeId = ''): bool
    {
        if(empty($array) || empty($productTypeId)){
            return true;
        }

        $currentUser = Auth::user();

        try {
            foreach ($array as $value) {
                $storedIngredient = Ingredient::create([
                    'name' => $value,
                    'created_by' => $currentUser->id
                ]);
                
                IngredientProductType::create([
                    'product_type_id' => $productTypeId,
                    'ingredient_id' => $storedIngredient->id
                ]);

            }
        } catch (\Throwable $th) {
            return false;
        }

        return true;
    }
}
