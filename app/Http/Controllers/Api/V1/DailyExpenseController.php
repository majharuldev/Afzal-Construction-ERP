<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\BranchLedger;
use App\Models\DailyExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DailyExpenseController extends Controller
{
     public function index()
    {
        $model = DailyExpense::all();

        return response()->json([
            'status' => 'success',
            'data' => $model
        ], 200);
    }
    public function show($id)
    {
        $expense = DailyExpense::find($id);

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
            $dailyExp = DailyExpense::create([
                'date' => $request->date,
                'paid_to'  => $request->paid_to,
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
        // Update DailyExpense
        $dailyExp = DailyExpense::findOrFail($id);
        $dailyExp->update([
            'date'              => $request->date,
            'paid_to'           => $request->paid_to,
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


    public function destroy($id)
    {
        $model = DailyExpense::find($id);
        $model->delete();

        return response()->json([
            'status' => 'Success',
            'message' => ' Deleted Successfully',
            'data' => $model
        ], 201);
    }
}


