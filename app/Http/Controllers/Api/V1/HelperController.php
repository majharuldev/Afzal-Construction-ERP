<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Helper;
use Illuminate\Http\Request;

class HelperController extends Controller
{
      public function index()
    {
        $data = Helper::all();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = Helper::create($request->all());
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $data = Helper::findOrFail($id);
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = Helper::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        $data = Helper::findOrFail($id)->delete();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }
}
