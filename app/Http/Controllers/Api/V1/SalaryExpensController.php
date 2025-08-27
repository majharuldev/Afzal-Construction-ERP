<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\BranchLedger;
use Illuminate\Http\Request;
use App\Models\SalaryExpense;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SalaryExpensController extends Controller
{


    public function index()
    {
        $model = SalaryExpense::latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $model
        ], 200);
    }
    public function show($id)
    {
        $expense = SalaryExpense::find($id);

        if (!$expense) {
            return response()->json([
                'status' => 'error',
                'message' => ' not found'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $expense
        ], 201);
    }
    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            // Insert into trips table
            $dailyExp = SalaryExpense::create([
                'date' => $request->date,
                'employee_name'  => $request->employee_name,
                'pay_amount'  => $request->pay_amount,
                'payment_category' => $request->payment_category,
                'branch_name' => $request->branch_name,
                'remarks' => $request->remarks,


            ]);

            // Insert into branch_ledgers
            BranchLedger::create([
                'date'               => $request->date,
                'expense_id' => $dailyExp->id,
                'cash_out'           => $request->pay_amount,
                'branch_name'           => $request->branch_name,
                'remarks' => $request->remarks,

            ]);



            DB::commit();

            return response()->json([
                'success' => true,
                'message' => ' created successfully',
                'data'    => $dailyExp
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Update SalaryExpense
            $dailyExp = SalaryExpense::findOrFail($id);
            $dailyExp->update([
                'date'              => $request->date,
                'employee_name'           => $request->employee_name,
                'pay_amount'        => $request->pay_amount,
                'payment_category'  => $request->payment_category,
                'branch_name'       => $request->branch_name,
                'remarks'           => $request->remarks,
            ]);

            // Update related Branch_Ledger
            BranchLedger::where('expense_id', $dailyExp->id)->update([
                'date'         => $request->date,
                'cash_out'     => $request->pay_amount,
                'branch_name'  => $request->branch_name,
                'remarks'      => $request->remarks,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data updated successfully.',
                'data'    => $dailyExp
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update data.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
