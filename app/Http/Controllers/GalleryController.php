<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\GalleryComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $gallery = Gallery::all();
    return view('gallery', compact('gallery'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'required|image|max:2048',
        ]);

        $gallery = new Gallery();
        $gallery->title = $request->title;
        $gallery->description = $request->description ?? '';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('gallery', 'public');
            $gallery->image_url = $path;
        }

        $gallery->save();

        return redirect()->back()->with('success', 'Koleksi berhasil ditambahkan!');
    }

    public function show(Gallery $gallery)
    {
        $gallery->load(['comments.user', 'likedByUsers']);
        return view('gallery-detail', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        return view('gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        // Pastikan description tidak null karena kolom di DB tidak nullable
        if (! array_key_exists('description', $validated) || $validated['description'] === null) {
            $validated['description'] = '';
        }

        // 🔴 HAPUS FOTO LAMA JIKA ADA
        if ($request->hasFile('image')) {
            if ($gallery->image_url && Storage::disk('public')->exists($gallery->image_url)) {
                Storage::disk('public')->delete($gallery->image_url);
            }

            // ✅ SIMPAN KE storage/app/public/gallery
            $validated['image_url'] = $request->file('image')
                ->store('gallery', 'public');
        }

        $gallery->update($validated);

        return back()->with('success', 'Koleksi berhasil diperbarui');
    }

    public function destroy(Gallery $gallery)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        if ($gallery->image_url && Storage::disk('public')->exists($gallery->image_url)) {
            Storage::disk('public')->delete($gallery->image_url);
        }

        $gallery->delete();

        return back()->with('success', 'Koleksi berhasil dihapus');
    }

    public function storeComment(Request $request, Gallery $gallery)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $gallery->comments()->create([
            'user_id' => Auth::user()->id,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function deleteComment(GalleryComment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'Komentar berhasil dihapus');
    }
}
