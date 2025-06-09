<?php

namespace App\Services;

use App\Interfaces\ProductTypeInterface;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductTypeService implements ProductTypeInterface
{
    protected $rules = [];

    public function __construct()
    {
        $this->rules = [
            'requiredMinString' => 'required|min:1'
        ];
    }

    public function createOrFetch(array $arr = []): array
    {
        $productTypeId = $arr['productTypeId'] ?? '';
        $currentUser = Auth::user();

        if(empty($productTypeId)){
            return [];
        }

        $res = ProductType::firstOrCreate(['product_type_id' => $productTypeId], [
            'product_type_id' => $productTypeId,
            'name' => '',
            'category_id' => 0,
            'created_by' => $currentUser->id
        ]);

        return $res ? $res->toArray() : [];
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
                ProductType::updateOrCreate(['product_type_id' => $load['product_type_id']], $load);
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
        $productCategoryService = app(ProductCategoryService::class);

        if(empty($products)){
            return [
                'valid' => $valid,
                'inValid' => $inValid,
            ];
        }

        foreach ($products as $product) {
            if($this->isValid($product)){
                $catDetails = $productCategoryService->createOrFetch($product);

                $payload = [
                    'product_type_id' => $product['productTypeId'],
                    'name' => $product['name'],
                    'category_id' => $catDetails['id']
                ];

                if($this->isExist($product['productTypeId'])){
                    $payload['updated_by'] = $currentUser->id;
                }else{
                    $payload['created_by'] = $currentUser->id;
                }

                $valid[] = $payload;
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
            'productTypeId' => $this->rules['requiredMinString'],
            'name' => $this->rules['requiredMinString'],
            'category' => $this->rules['requiredMinString'],
            'ingredients' => 'required|array|min:1'
        ]);



        if (!$validator->fails()) {
            $res = true;
        }
        
        return $res;
    }

    private function isExist(string $typeId = ''): bool
    {
        return ProductType::where('product_type_id',$typeId)->count() > 0 ? true : false;
    }
}
