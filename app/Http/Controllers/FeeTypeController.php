<?php

namespace App\Http\Controllers;

use App\Models\FeeType;
use Illuminate\Http\Request;

class FeeTypeController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:fee_types,name|max:255',
        ]);

        $feeType = FeeType::create($validated);

        return response()->json($feeType);
    }
}
