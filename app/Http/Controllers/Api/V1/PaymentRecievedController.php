<?php

namespace App\Http\Controllers\Api\V1;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PaymentRecivedService;

class PaymentRecievedController extends Controller
{

    private $service;

    public function __construct(PaymentRecivedService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json([
            'status' => 'Success',
            'data' => $this->service->getAll()
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $data = $this->service->store($request->all());
            return response()->json(['success' => true, 'data' => $data], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
