@extends('layouts.app')

@section('title', 'Peserta Event')

@section('content')
<div class="container">
    <h2 class="mb-4">Peserta untuk Event: {{ $event->event_name }}</h2>

    @if($event->registrations->count())
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Peserta</th>
                    <th>Waktu Daftar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($event->registrations as $index => $registration)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $registration->user->name }}</td>
                    <td>{{ $registration->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info">Belum ada peserta yang mendaftar.</div>
    @endif

    <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">⬅ Kembali</a>
</div>
@endsection
