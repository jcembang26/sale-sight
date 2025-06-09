<?php

namespace App\Services;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\ProductTypeService;

class ProductService implements ProductInterface
{
    protected $rules = [];

    public function __construct()
    {
        $this->rules = [
            'requiredMinString' => 'required|min:1'
        ];
    }

    public function bulkInsert(Request $request): array
    {
        $products = $request->products ?? [];

        if(empty($products)){
            return [
                'message' => 'No record to insert',
                'failed' => []
            ];
        }

        $payload = $this->processProducts($products);
        $invalidPayload = $payload['invalid'];
        unset($payload['invalid']);

        foreach ($payload['valid'] as $load) {
            try {
                Product::updateOrCreate(['product_id' => $load['product_id']], $load);
            } catch (\Throwable $th) {
                $invalidOnUpsert[] = $load;
            }
        }
        
        return [
            'message' => 'Successfully insert products',
            'failed' => $invalidPayload
        ];
    }

    private function processProducts(array $products = []): array
    {
        $valid = [];
        $inValid = [];
        $currentUser = Auth::user();
        $productTypeService = app(ProductTypeService::class);
        $productSizeService = app(ProductSizeService::class);

        if(empty($products)){
            return [
                'valid' => $valid,
                'inValid' => $inValid,
            ];
        }

        foreach ($products as $product) {

            $projectTypeDetails = $productTypeService->createOrFetch($product);
            $projectSizeDetails = $productSizeService->createOrFetch($product);

            if($this->isValid($product)){
                $valid[] = [
                    'product_id' => $product['id'],
                    'product_type_id' => $projectTypeDetails['product_type_id'],
                    'size_id' => $projectSizeDetails['id'],
                    'price' => $product['price'],
                    'created_by' => $currentUser->id
                ];
            }else{
                $inValid[] = $product;
            }
        }
        
        return [
            'valid' => $valid,
            'invalid' => $inValid
        ];
    }

    private function isValid(array $product = []): bool
    {
        $res = false;

        if(empty($product)){
            return $res;
        }
        
        $validator = Validator::make($product, [
            'id' => $this->rules['requiredMinString'],
            'productTypeId' => $this->rules['requiredMinString'],
            'size' => $this->rules['requiredMinString'],
            'price' => 'required|numeric|min:0'
        ]);



        if (!$validator->fails()) {
            $res = true;
        }
        
        return $res;
    }
}
