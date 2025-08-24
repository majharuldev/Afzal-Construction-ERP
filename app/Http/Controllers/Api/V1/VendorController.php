<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendorController extends Controller
{
     public function index()
    {
        $data = Vendor::all();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = Vendor::create($request->all());
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $data = Vendor::findOrFail($id);
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = Vendor::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        $data = Vendor::findOrFail($id)->delete();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }
}
