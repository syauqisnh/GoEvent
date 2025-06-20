@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <form method="GET" action="{{ route('dashboard') }}" class="row row-cols-lg-auto g-3 align-items-center mb-4">
        <div class="col-12 flex-grow-1">
            <input type="text" name="search" class="form-control" placeholder="🔍 Cari event seru..." value="{{ request('search') }}">
        </div>

        <div class="col-12">
            <select name="sort" class="form-select">
                <option value="terbaru" {{ request('sort') === 'terbaru' ? 'selected' : '' }}>📅 Terbaru</option>
                <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>📆 Terlama</option>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">🔎 Filter</button>
        </div>
    </form>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Event List --}}
    @if($events->count())
    <div class="row row-cols-1 g-4">
        @foreach($events as $event)
        <div class="col">
            <div class="card shadow-sm border rounded-4 overflow-hidden">
                @if($event->image_url)
                <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->event_name }}"
                    class="card-img-top" style="height: 200px; object-fit: cover;">
                @else
                <img src="https://via.placeholder.com/600x200?text=No+Image"
                    class="card-img-top" style="height: 200px; object-fit: cover;" alt="No Image">
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{ $event->event_name }}</h5>

                    @php
                    $shortDesc = Str::limit($event->event_desc, 150);
                    @endphp

                    <p class="card-text">
                        <span class="short-desc">{{ $shortDesc }}</span>
                        <span class="full-desc d-none">{{ $event->event_desc }}</span>
                        @if(strlen($event->event_desc) > 150)
                        <a href="javascript:void(0)" class="toggle-desc text-primary text-decoration-underline ms-1">Baca selengkapnya</a>
                        @endif
                    </p>

                    <p class="card-text">
                        <small class="text-muted">📍 {{ $event->location }}</small><br>
                        <small class="text-muted">📅 {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y, H:i') }}</small>
                    </p>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        @if(in_array($event->id, $registeredEventIds ?? []))
                        <button class="btn btn-secondary" disabled>Sudah Terdaftar</button>
                        @else
                        <button class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#registerModal"
                            data-event-id="{{ $event->id }}"
                            data-event-name="{{ $event->event_name }}">
                            Daftar Sekarang
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="alert alert-info">Belum ada event yang tersedia.</div>
    @endif
</div>

{{-- 🔽 Modal Daftar Event --}}
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="" id="registerForm">
            @csrf
            <div class="modal-content rounded-4">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Konfirmasi Pendaftaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah kamu yakin ingin mendaftar ke event <strong id="eventNamePreview">event</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle deskripsi
        document.querySelectorAll('.toggle-desc').forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const cardText = this.closest('.card-text');
                const shortDesc = cardText.querySelector('.short-desc');
                const fullDesc = cardText.querySelector('.full-desc');

                if (fullDesc.classList.contains('d-none')) {
                    fullDesc.classList.remove('d-none');
                    shortDesc.classList.add('d-none');
                    this.textContent = 'Tampilkan lebih sedikit';
                } else {
                    fullDesc.classList.add('d-none');
                    shortDesc.classList.remove('d-none');
                    this.textContent = 'Baca selengkapnya';
                }
            });
        });

        // Modal pendaftaran event
        var registerModal = document.getElementById('registerModal');
        registerModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var eventId = button.getAttribute('data-event-id');
            var eventName = button.getAttribute('data-event-name');

            document.getElementById('eventNamePreview').textContent = eventName;
            document.getElementById('registerForm').action = '/events/' + eventId + '/register';
        });
    });
</script>
@endpush