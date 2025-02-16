<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::latest()
            ->whereHas('vehicle', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->with('vehicle')
            ->paginate(25);

        return view('incomes.index', compact('incomes'));
    }

    public function show(Income $income)
    {
        if ($income->vehicle->user_id !== auth()->user()->id) {
            return response()->json(['errors' => 'You cannot view this record.'], 401);
        }

        return response()->json($income);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|in:'.auth()->user()->vehicles()->pluck('id')->implode(','),
            'income_amount' => 'required|numeric|min:0',
            'income_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Income::create([
            'vehicle_id' => $request->vehicle_id,
            'amount' => $request->income_amount,
            'income_date' => $request->income_date,
        ]);

        return response()->json(['message' => 'Income saved successfully'], 200);
    }

    public function update(Income $income, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|in:'.auth()->user()->vehicles()->pluck('id')->implode(','),
            'income_amount' => 'required|numeric|min:0',
            'income_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $income->update([
                'vehicle_id' => $request->vehicle_id,
                'amount' => $request->income_amount,
                'income_date' => $request->income_date,
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(['errors' => 'Server is unable to complete the task.'], 500);
        }

        return response()->json(['message' => 'Income updated successfully'], 200);
    }

    public function destroy(Income $income)
    {
        $income->delete();

        return redirect()
            ->back()
            ->with('success', 'Income record deleted successfully.');
    }
}
