<?php

namespace App\Services;

use App\Interfaces\OrderDetailInterface;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OrderDetailService implements OrderDetailInterface
{
    protected $rules = [];

    public function __construct()
    {
        $this->rules = [
            'requiredNumeric' => 'required|numeric'
        ];
    }

    public function bulkInsert(Request $request): array
    {
        $orders = $request->data ?? [];

        if(empty($orders)){
            return [
                'message' => 'No record to insert',
                'failed' => []
            ];
        }

        $payload = $this->processData($orders);
        $invalidPayload = $payload['invalid'];
        unset($payload['invalid']);

        foreach ($payload['valid'] as $load) {
            try {
                OrderDetail::updateOrCreate(['id' => $load['id']], $load);
            } catch (\Throwable $th) {
                dd($th->getMessage(), $load);
                $invalidOnUpsert[] = $load;
            }
        }
        
        return [
            'message' => 'Successfully insert order',
            'failed' => $invalidPayload
        ];
    }

    private function processData(array $orders = []): array
    {
        $valid = [];
        $inValid = [];
        $currentUser = Auth::user();

        if(empty($orders)){
            return [
                'valid' => $valid,
                'inValid' => $inValid,
            ];
        }

        foreach ($orders as $order) {

            if($this->isValid($order)){
                $valid[] = [
                    'id' => $order['id'],
                    'order_id' => $order['orderId'],
                    'product_id' => $order['productId'],
                    'quantity' => $order['quantity'],
                    'created_by' => $currentUser->id
                ];
            }else{
                $inValid[] = $order;
            }
        }
        
        return [
            'valid' => $valid,
            'invalid' => $inValid
        ];
    }

    private function isValid(array $order = []): bool
    {
        $res = false;

        if(empty($order)){
            return $res;
        }
        
        $validator = Validator::make($order, [
            'id' => $this->rules['requiredNumeric'],
            'orderId' => $this->rules['requiredNumeric'],
            'productId' => 'required|min:1',
            'quantity' => $this->rules['requiredNumeric']
        ]);
        
        if (!$validator->fails()) {
            $res = true;
        }
        
        return $res;
    }
}
