@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Event Saya</h2>

        @if ($events->isEmpty())
            <div class="alert alert-info">Kamu belum membuat event apa pun.</div>
        @else
            <div class="row">
                @foreach ($events as $event)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            @if ($event->image_url)
                                <img src="{{ asset('storage/' . $event->image_url) }}" class="card-img-top" alt="Event Image">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->event_name }}</h5>
                                <p class="card-text">{{ $event->event_desc }}</p>
                                <p class="card-text"><small class="text-muted">{{ $event->event_date }}</small></p>
                                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
