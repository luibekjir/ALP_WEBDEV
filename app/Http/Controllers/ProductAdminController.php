<?php

namespace App\Http\Controllers;

use App\Models\ProductAdmin;
use Illuminate\Http\Request;

class ProductAdminController extends Controller
{
    public function index()
    {
        $items = ProductAdmin::all();
        return view('product_admins.index', compact('items'));
    }

    public function create()
    {
        return view('product_admins.create');
    }

    public function store(Request $request)
    {
        // TODO: validate and store
        return redirect()->route('product_admins.index')->with('success', 'ProductAdmin created (placeholder)');
    }

    public function show(ProductAdmin $productAdmin)
    {
        return view('product_admins.show', compact('productAdmin'));
    }

    public function edit(ProductAdmin $productAdmin)
    {
        return view('product_admins.edit', compact('productAdmin'));
    }

    public function update(Request $request, ProductAdmin $productAdmin)
    {
        // TODO: validate and update
        return redirect()->route('product_admins.index')->with('success', 'ProductAdmin updated (placeholder)');
    }

    public function destroy(ProductAdmin $productAdmin)
    {
        $productAdmin->delete();
        return redirect()->route('product_admins.index')->with('success', 'ProductAdmin deleted');
    }
}
