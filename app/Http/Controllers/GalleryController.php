<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $gallery = Gallery::all();
        return view('gallery', compact('gallery'));
    }

    public function create()
    {
        return view('gallery');
    }

    public function store(Request $request)
    {
         Gallery::create([
            'image_url' => $request->file('image')->store('galleries'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'created_by' => $request->input('created_by'),
            'updated_by' => $request->input('updated_by'),
            'like_id' => 'like_id',
            'comment_id' => 'comment_id'
        ]);

        return redirect('/galeri');
    }

    public function show(Gallery $gallery)
    {
        return view('gallery.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        return view('gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('galleries');
        }

        $gallery->update($validated);

        return redirect()->route('gallery.index')->with('success', 'Gallery updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Gallery deleted successfully.');
    }
}
