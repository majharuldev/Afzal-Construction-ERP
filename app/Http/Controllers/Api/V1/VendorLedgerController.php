<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\VendorLedger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendorLedgerController extends Controller
{
     public function index()
    {

        $data = VendorLedger::all();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }
}
