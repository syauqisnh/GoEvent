@extends('layouts.app')

@section('title', 'Peserta Event')

@section('content')
<div class="container mt-4">
    <div>
        <div class="table-responsive">
            @if($events->count())
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Event</th>
                        <th>Jumlah Peserta</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                    <tr>
                        <td>{{ $event['event_name'] }}</td>
                        <td>{{ $event['participant_count'] }}</td>
                        <td class="text-nowrap">
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#modal-{{ $event['id'] }}">
                                Lihat Peserta
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-center">Belum ada peserta terdaftar.</p>
            @endif
        </div>
    </div>

    @foreach ($events as $event)
    <!-- Modal -->
    <div class="modal fade" id="modal-{{ $event['id'] }}" tabindex="-1" aria-labelledby="modalLabel-{{ $event['id'] }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel-{{ $event['id'] }}">
                        Daftar Peserta: {{ $event['event_name'] }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    @if($event['participants']->count())
                    <ul class="list-group">
                        @foreach ($event['participants'] as $participant)
                        <li class="list-group-item">{{ $participant }}</li>
                        @endforeach
                    </ul>
                    @else
                    <p>Tidak ada peserta terdaftar untuk event ini.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection