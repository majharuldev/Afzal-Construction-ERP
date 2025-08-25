<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
     public function index()
    {
        $data = Office::all();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = Office::create($request->all());
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $data = Office::findOrFail($id);
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = Office::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        $data = Office::findOrFail($id)->delete();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }
}
