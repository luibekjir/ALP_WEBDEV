<?php

namespace App\Http\Controllers;

use App\Mail\AddEventMail;
use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('date', 'desc')->paginate(12);
        return view('event', compact('events'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            // 'price' => 'nullable|numeric|min:0',
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image_url) {
                Storage::disk('public')->delete($event->image_url);
            }
            $validated['image_url'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        return back()->with('success', 'Acara berhasil diperbarui');
    }

    public function destroy(Event $event)
    {
        if ($event->image_url) {
            Storage::disk('public')->delete($event->image_url);
        }

        $event->delete();
        return back()->with('success', 'Acara berhasil dihapus');
    }
    public function addToCalendar(Event $event)
    {
        $user = Auth::user();

        if ($user->events()->where('event_id', $event->id)->exists()) {
            return back()->with('error', 'Anda sudah mendaftar event ini');
        }

        $user->events()->attach($event->id);

        $start = Carbon::parse($event->start)->format('Ymd\THis');
        $end   = Carbon::parse($event->end)->format('Ymd\THis');

        $linkParams = [
            'action'  => 'TEMPLATE',
            'text'    => $event->title,        // Judul
            'details' => $event->description,  // Deskripsi
            'dates'   => $start . '/' . $end,  // Start / End
            'ctz'     => 'Asia/Jakarta',
        ];

        $googleCalendarLink = 'https://calendar.google.com/calendar/render?' . http_build_query($linkParams);

        Mail::to($user->email)->send(new AddEventMail($event, $googleCalendarLink));

        return back()->with('success', 'Berhasil mendaftar ke event! Tambahkan event ke Google Calendarmu melalui email yang kita kirim!');
    }
}
