<?php

namespace App\Http\Controllers;

use App\Models\GalleryComment;
use Illuminate\Http\Request;

class GalleryCommentController extends Controller
{
    public function index()
    {
        $comments = GalleryComment::all();
        return view('gallery_comments.index', compact('comments'));
    }

    public function create()
    {
        return view('gallery_comments.create');
    }

    public function store(Request $request)
    {
        // TODO: validate and store comment
        return redirect()->route('gallery_comments.index')->with('success', 'Comment created (placeholder)');
    }

    public function show(GalleryComment $galleryComment)
    {
        return view('gallery_comments.show', compact('galleryComment'));
    }

    public function edit(GalleryComment $galleryComment)
    {
        return view('gallery_comments.edit', compact('galleryComment'));
    }

    public function update(Request $request, GalleryComment $galleryComment)
    {
        // TODO: validate and update
        return redirect()->route('gallery_comments.index')->with('success', 'Comment updated (placeholder)');
    }

    public function destroy(GalleryComment $galleryComment)
    {
        $galleryComment->delete();
        return redirect()->route('gallery_comments.index')->with('success', 'Comment deleted');
    }
}
