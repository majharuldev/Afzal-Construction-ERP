<?php

namespace App\Services;

use App\Models\PaymentRecieve;
use App\Models\BranchLedger;
use App\Models\CustomerLedger;
use Illuminate\Support\Facades\DB;

class PaymentRecivedService
{
    public function getAll()
    {
        return PaymentRecieve::all();
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $payment = PaymentRecieve::create($data);

            BranchLedger::create([
                'date' => $data['date'],
                'payment_rec_id' => $payment->id,
                'customer' => $data['customer_name'],
                'branch_name' => $data['branch_name'],
                'cash_in' => $data['amount'],
                'created_by' => $data['created_by'],
            ]);

            CustomerLedger::create([
                'bill_date' => $data['date'],
                'payment_rec_id' => $payment->id,
                'customer_name' => $data['customer_name'],
                'rec_amount' => $data['amount'],
                'created_by' => $data['created_by'],
            ]);

            DB::commit();
            return $payment;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // Update method
    public function update($id, $data)
    {
        DB::beginTransaction();
        try {
            $payment = PaymentRecieve::findOrFail($id);
            $payment->update($data);

            BranchLedger::where('payment_rec_id', $id)->update([
                'date' => $data['date'],
                'customer' => $data['customer_name'],
                'cash_in' => $data['amount'],
                'branch_name' => $data['branch_name'],
                'created_by' => $data['created_by'],
            ]);

            CustomerLedger::where('payment_rec_id', $id)->update([
                'bill_date' => $data['date'],
                'customer_name' => $data['customer_name'],
                'rec_amount' => $data['amount'],
                'created_by' => $data['created_by'],
            ]);

            DB::commit();
            return $payment;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // Delete method
    public function delete($id)
    {
        $payment = PaymentRecieve::findOrFail($id);
        $payment->delete();
        return $payment;
    }
}
