@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Event Saya</h2>

    @if ($events->isEmpty())
    <div class="alert alert-info">Kamu belum mendaftar event apapun.</div>
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
                    <p class="card-text">
                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y, H:i') }}
                        </small>
                    </p>
                    <p class="card-text"><strong>Lokasi:</strong> {{ $event->location }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection