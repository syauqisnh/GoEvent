@extends('layouts.app')

@section('title', 'Kelola Event')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Event & Buat Baru</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3 text-end">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createEventModal">
            + Buat Event Baru
        </button>
    </div>

    @if($events->count())
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Lokasi</th>
                    <th>Tanggal</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>{{ $event->event_name }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($event->event_desc, 60) }}</td>
                    <td>{{ $event->location }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y, H:i') }}</td>
                    <td>
                        @if($event->image_url)
                            <img src="{{ asset('storage/' . $event->image_url) }}" width="80">
                        @else
                            <small class="text-muted">-</small>
                        @endif
                    </td>
                    <td class="text-nowrap">
                        {{-- Edit Button --}}
                        <button class="btn btn-sm btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#editEventModal{{ $event->id }}">
                            ✏️ Edit
                        </button>

                        {{-- Delete Button --}}
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">🗑 Hapus</button>
                        </form>
                    </td>
                </tr>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editEventModal{{ $event->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Event: {{ $event->event_name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="event_name" class="form-control" value="{{ $event->event_name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="event_desc" class="form-control" rows="4" required>{{ $event->event_desc }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input type="datetime-local" name="event_date" class="form-control" value="{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Lokasi</label>
                                        <input type="text" name="location" class="form-control" value="{{ $event->location }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Gambar Baru (opsional)</label>
                                        <input type="file" name="image_url" class="form-control" accept="image/*">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="alert alert-info">Belum ada event.</div>
    @endif
</div>

{{-- Modal Create --}}
<div class="modal fade" id="createEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Buat Event Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="event_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="event_desc" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="datetime-local" name="event_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="location" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar (opsional)</label>
                        <input type="file" name="image_url" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Event</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if ($errors->any())
<script>
    // Buka modal otomatis jika ada error validasi (di create)
    var createModal = new bootstrap.Modal(document.getElementById('createEventModal'));
    createModal.show();
</script>
@endif
@endpush
