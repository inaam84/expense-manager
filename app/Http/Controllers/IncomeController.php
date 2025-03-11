<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Services\FilepondService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Plank\Mediable\Facades\MediaUploader;

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

        $income = Income::create([
            'vehicle_id' => $request->vehicle_id,
            'amount' => $request->income_amount,
            'income_date' => $request->income_date,
            'details' => $request->income_details,
        ]);

        if ($request->has('income_file')) {
            $file = $request->file('income_file'); 
            $extension = $file->getClientOriginalExtension(); 
            $incomeFileNameAndExtension = Str::random(12) . '.' . $extension;
            $dir = "users/" . auth()->user()->id . "/incomes/" . $income->id;
            $fullPath = $dir . "/" . $incomeFileNameAndExtension;
    
            if (!File::exists(Storage::disk('public')->path($dir))) {
                File::makeDirectory(Storage::disk('public')->path($dir), 0755, true, true);
            }
    
            if ($request->has('income_file')) {
                $media = MediaUploader::fromSource($request->file('income_file'))
                    ->toDirectory($dir)
                    ->useFilename($incomeFileNameAndExtension)
                    ->makePrivate()
                    ->upload();

                $income->attachMedia($media, 'income_file');
            }
        }

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
