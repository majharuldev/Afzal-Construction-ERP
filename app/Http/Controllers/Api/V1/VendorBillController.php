<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\VendorBill;
use App\Models\BranchLedger;
use App\Models\VendorLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class VendorBillController extends Controller
{
   

  public function index(){

    $bill= VendorBill::all();

     
return response()->json([
        'status' => 'Success',
        'data' => $bill
    ], 200);


  }








    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            // Insert into trips table
            $dailyExp = VendorBill::create([
                'date' => $request->date,
                'vendor_name'  => $request->vendor_name,
                'branch_name'  => $request->branch_name,
                'bill_ref' => $request->bill_ref,
                'amount' => $request->amount,
                'note' => $request->note,
                'cash_type' => $request->cash_type,
                'status' => $request->status,


            ]);

            // Insert into branch_ledgers
            BranchLedger::create([
                'date'               => $request->date,
                'bill_id'           => $dailyExp->id,
                'cash_out'           => $request->amount,
                'branch_name'           => $request->branch_name,
                'remarks'               => $request->remarks,

            ]);

            VendorLedger::create([
                'date'                    => $request->date,
                'bill_id'               => $dailyExp->id,
                'pay_amount'           => $request->amount,
                'vendor_name'  => $request->vendor_name,
                'branch_name'           => $request->branch_name,


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
    public function show($id)
    {
        $data = VendorBill::findOrFail($id);
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Update VendorBill
            $vendorBill = VendorBill::findOrFail($id);
            $vendorBill->update([
                'date'         => $request->date,
                'vendor_name'  => $request->vendor_name,
                'branch_name'  => $request->branch_name,
                'bill_ref'     => $request->bill_ref,
                'amount'       => $request->amount,
                'note'         => $request->note,
                'cash_type'    => $request->cash_type,
                'status'       => $request->status,
            ]);

            // Update Branch_Ledger where bill_id matches
            BranchLedger::where('bill_id', $vendorBill->id)->update([
                'date'         => $request->date,
                'cash_out'     => $request->amount,
                'branch_name'  => $request->branch_name,
                'remarks'      => $request->remarks,
            ]);

            // Update VendorLedger where bill_id matches
            VendorLedger::where('bill_id', $vendorBill->id)->update([
                'date'         => $request->date,
                'pay_amount'   => $request->amount,
                'vendor_name'  => $request->vendor_name,
                'branch_name'  => $request->branch_name,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data updated successfully.',
                'data'    => $vendorBill
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
        $data = VendorBill::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }
}
