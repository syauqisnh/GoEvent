<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Registrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Events::query();

        if ($request->filled('search')) {
            $query->where('event_name', 'like', '%' . $request->search . '%');
        }

        if ($request->sort === 'terlama') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $events = $query->get();

        return view('dashboard', compact('events'));
    }

    public function create()
    {
        $events = Events::orderBy('created_at', 'desc')->get();
        return view('events.create', compact('events'));
    }

    public function edit($id)
    {
        $event = Events::findOrFail($id);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'event_name' => 'required|max:255',
            'event_desc' => 'required',
            'event_date' => 'required|date',
            'location' => 'required',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $event = Events::findOrFail($id);
        $event->event_name = $request->event_name;
        $event->event_desc = $request->event_desc;
        $event->event_date = $request->event_date;
        $event->location = $request->location;

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('events_images', 'public');
            $event->image_url = $path;
        }

        $event->save();

        return redirect()->route('events.create')->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $event = Events::findOrFail($id);
        $event->delete();

        return redirect()->route('events.create')->with('success', 'Event berhasil dihapus!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|max:255',
            'event_desc' => 'required',
            'event_date' => 'required|date',
            'location' => 'required',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $event = new Events();
        $event->event_name = $request->event_name;
        $event->event_desc = $request->event_desc;
        $event->event_date = $request->event_date;
        $event->location = $request->location;
        $event->user_id = Auth::id();

        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $path = $image->store('events_images', 'public');
            $event->image_url = $path;
        }

        $event->save();

        return redirect()->route('events.create')->with('success', 'Event berhasil dibuat!');
    }

    public function register($eventId)
    {
        $user = Auth::user();

        $existing = Registrations::where('user_id', $user->id)
            ->where('event_id', $eventId)
            ->first();

        if ($existing) {
            return back()->with('error', 'Kamu sudah terdaftar pada event ini.');
        }

        Registrations::create([
            'user_id' => $user->id,
            'event_id' => $eventId,
        ]);

        return back()->with('success', 'Berhasil mendaftar event!');
    }

    public function participants($id)
    {
        $event = Events::with(['registrations.user'])->findOrFail($id);

        if (Auth::id() !== $event->user_id) {
            return redirect()->route('dashboard')->with('error', 'Kamu tidak punya akses.');
        }

        return view('events.participants', compact('event'));
    }
}
