<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PharmacyItem;

class PharmacyController extends Controller
{
    public function index(Request $request)
    {
        $query = PharmacyItem::query()->latest();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($sq) use ($q) {
                $sq->where('name', 'like', "%{$q}%")
                   ->orWhere('generic_name', 'like', "%{$q}%");
            });
        }

        $medicines = $query->paginate(15);
        return view('admin.pharmacy.index', compact('medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'stock_qty' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'generic_name' => 'nullable|string',
        ]);

        PharmacyItem::create($request->all());

        return back()->with('success', 'Medicine added to stock.');
    }

    public function update(Request $request, PharmacyItem $pharmacy)
    {
        $request->validate([
            'stock_qty' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $pharmacy->update($request->only('stock_qty', 'unit_price'));

        return back()->with('success', 'Medicine stock updated.');
    }

    public function destroy(PharmacyItem $pharmacy)
    {
        $pharmacy->delete();
        return back()->with('success', 'Medicine removed from inventory.');
    }
}
