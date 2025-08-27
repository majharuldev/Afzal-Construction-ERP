<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\BranchLedger;
use App\Models\FundTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FundsTransferController extends Controller
{

    public function index()
    {
        $data = FundTransfer::latest()->get();

        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            // Insert into trips table
            $account = FundTransfer::create([
                'date' => $request->date,
                'branch_name'  => $request->branch_name,
                'person_name'  => $request->person_name,
                'type' => $request->type,
                'amount' => $request->amount,
                'bank_name' => $request->bank_name,
                'remarks' => $request->remarks,
                'created_by'   => $request->created_by,

            ]);

            // Insert into branch_ledgers
            BranchLedger::create([
                'date'        => $request->date,
                'accounts_id' => $account->id,
                'branch_name' => $request->branch_name,
                'cash_in'     => $request->amount,
                'created_by'  => $request->created_by,
            ]);


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => ' created successfully',
                'data'    => $account
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




    public function show($id)
    {
        $data = FundTransfer::findOrFail($id);

        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Find the Account record
            $account = FundTransfer::findOrFail($id);

            // Update Account
            $account->update([
                'date'        => $request->date,
                'branch_name'      => $request->branch_name,
                'person_name' => $request->person_name,
                'type'        => $request->type,
                'amount'      => $request->amount,
                'bank_name'   => $request->bank_name,
                'remarks'     => $request->remarks,
                'created_by'  => $request->created_by,

            ]);

            // Update Branch_Ledger
            BranchLedger::where('accounts_id', $account->id)
                ->update([
                    'date'        => $request->date,
                    'branch_name' => $request->branch_name,
                    'cash_in'     => $request->amount,
                    'created_by'  => $request->created_by,
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Updated successfully',
                'data'    => $account
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }



    public function destroy($id)
    {
        $data = FundTransfer::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }
}
