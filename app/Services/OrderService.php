<?php

namespace App\Services;

use App\Interfaces\OrderInterface;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderService implements OrderInterface
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
        $orders = $request->orders ?? [];

        if(empty($orders)){
            return [
                'message' => 'No record to insert',
                'failed' => []
            ];
        }

        $payload = $this->processOrders($orders);
        $invalidPayload = $payload['invalid'];
        unset($payload['invalid']);

        foreach ($payload['valid'] as $load) {
            try {
                Order::updateOrCreate(['id' => $load['id']], $load);
            } catch (\Throwable $th) {
                dd($th->getMessage());
                $invalidOnUpsert[] = $load;
            }
        }
        
        return [
            'message' => 'Successfully insert orders',
            'failed' => $invalidPayload
        ];
    }

    private function processOrders(array $orders = []): array
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
                    'date' => $order['date'],
                    'time' => $order['time'],
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
            'id' => 'required',
            'date' => $this->rules['requiredMinString'],
            'time' => $this->rules['requiredMinString']
        ]);
        
        if (!$validator->fails()) {
            $res = true;
        }
        
        return $res;
    }
}
