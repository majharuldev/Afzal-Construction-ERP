<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $data = Employee::latest()->get();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = Employee::create($request->all());
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $data = Employee::findOrFail($id);
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = Employee::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        $data = Employee::findOrFail($id)->delete();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ]);
    }
}
