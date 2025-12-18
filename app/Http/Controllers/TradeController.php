<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware; 

class TradeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return  [
            new Middleware('permission:view trades', only: ['index']),
            new Middleware('permission:edit trades', only: ['edit']),
            new Middleware('permission:create trades', only: ['create']),
            new Middleware('permission:delete trades', only: ['destroy'])
        ];
    }

    public function index()
    {
        $trades = Trade::all();
        return view('trades.index', compact('trades'));
    }

    public function create()
    {
        return view('trades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:trades,name'
        ]);

        Trade::create([
            'name'     => $request->name,
            'trade_id' => 'custom',
        ]);

        return redirect()->route('trades.index')->with('success', 'Trade created successfully.');
    }


    public function edit(Trade $trade)
    {
        return view('trades.edit', compact('trade'));
    }

    public function update(Request $request, Trade $trade)
    {
        $request->validate([
            'name' => "required|string|max:255|unique:trades,name,$trade->id",
            'description' => 'nullable|string'
        ]);

        $trade->update($request->all());

        return redirect()->route('trades.index')->with('success', 'Trade updated successfully.');
    }

    public function destroy(Trade $trade)
    {
        $jobs = Job::whereHas('trades', function ($query) use ($trade) {
            $query->where('trades.id', $trade->id);
        })->get();

        if ($jobs->isNotEmpty()) {
            return redirect()->route('trades.index')->with('error', 'Cannot delete trade. It is associated with existing jobs.');
        }
                              
        $trade->delete();
        return redirect()->route('trades.index')->with('success', 'Trade deleted successfully.');
    }
}
