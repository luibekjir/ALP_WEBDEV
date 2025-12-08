<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $ratings = Rating::all();
        return view('ratings.index', compact('ratings'));
    }

    public function create()
    {
        return view('ratings.create');
    }

    public function store(Request $request)
    {
        // TODO: validate and store
        return redirect()->route('ratings.index')->with('success', 'Rating created (placeholder)');
    }

    public function show(Rating $rating)
    {
        return view('ratings.show', compact('rating'));
    }

    public function edit(Rating $rating)
    {
        return view('ratings.edit', compact('rating'));
    }

    public function update(Request $request, Rating $rating)
    {
        // TODO: validate and update
        return redirect()->route('ratings.index')->with('success', 'Rating updated (placeholder)');
    }

    public function destroy(Rating $rating)
    {
        $rating->delete();
        return redirect()->route('ratings.index')->with('success', 'Rating deleted');
    }
}
