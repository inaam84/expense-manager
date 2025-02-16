<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::latest()
            ->whereHas('vehicle', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->with('vehicle')
            ->paginate(25);

        return view('expenses.index', compact('expenses'));
    }

    public function show(Expense $expense)
    {
        if ($expense->vehicle->user_id !== auth()->user()->id) {
            return response()->json(['errors' => 'You cannot view this record.'], 401);
        }

        return response()->json($expense);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|in:'.auth()->user()->vehicles()->pluck('id')->implode(','),
            'expense_amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Expense::create([
            'vehicle_id' => $request->vehicle_id,
            'amount' => $request->expense_amount,
            'expense_date' => $request->expense_date,
        ]);

        return response()->json(['message' => 'Expense saved successfully'], 200);
    }

    public function update(Expense $expense, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|in:'.auth()->user()->vehicles()->pluck('id')->implode(','),
            'expense_amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $expense->update([
                'vehicle_id' => $request->vehicle_id,
                'amount' => $request->expense_amount,
                'expense_date' => $request->expense_date,
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(['errors' => 'Server is unable to complete the task.'], 500);
        }

        return response()->json(['message' => 'Expense updated successfully'], 200);
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()
            ->back()
            ->with('success', 'Expense record deleted successfully.');
    }
}
