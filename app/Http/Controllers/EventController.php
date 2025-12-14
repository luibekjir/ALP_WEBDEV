<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('date', 'desc')->paginate(12);
        return view('event', compact('events'));
    }

    public function create()
    {
        return view('event');
    }

    public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'date' => 'required|date',
        'price' => 'nullable|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Upload gambar jika ada
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('events', 'public');
        $validated['image_url'] = $imagePath;
    }

    // Simpan ke database
    Event::create($validated);

    return redirect()->back()->with('success', 'Event berhasil ditambahkan!');
}

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }

    public function register(Event $event)
{
    Auth::user()->events()->syncWithoutDetaching($event->id);

    return back()->with('success', 'Berhasil mendaftar acara');
}
}
