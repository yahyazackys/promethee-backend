@extends('template')

@section('content')
<div class="container">
    <h1>Proses Seleksi</h1>

    @if (session('message'))
    <div class="alert alert-info">
        {{ session('message') }}
    </div>
    @endif

    <form id="proses-form" action="{{ route('proses-seleksi.index') }}" method="GET" class="mb-4">
        @csrf
        <div class="form-group">
            <label for="dari_tgl">Dari Tanggal:</label>
            <input type="date" name="dari_tgl" id="dari_tgl" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="sampai_tgl">Sampai Tanggal:</label>
            <input type="date" name="sampai_tgl" id="sampai_tgl" class="form-control" required>
        </div>
        <button type="submit" name="cari" class="btn btn-primary">Cari</button>
    </form>

    @if (isset($data_calon_pelaksanas) && isset($data_kriteria) && isset($nil))
    <!-- Data Nilai Alternatif -->
    <h4>Data Nilai Alternatif</h4>
    <div class="table-responsive pt-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kriteria / Alternatif</th>
                    @foreach ($data_calon_pelaksanas as $calon)
                    <th>{{ ucwords($calon->nama) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($data_kriteria as $kriteria)
                <tr>
                    <td><b>{{ ucwords($kriteria->nama) }}</b></td>
                    @foreach ($data_calon_pelaksanas as $calon)
                    <td>{{ $nil[$calon->id][$kriteria->id] ?? 0 }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tabel Perbandingan -->
    <h4>Tabel Perbandingan</h4>
    <div class="table-responsive pt-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kriteria / Alternatif</th>
                    @foreach ($data_calon_pelaksanas as $calon1)
                    @foreach ($data_calon_pelaksanas as $calon2)
                    @if ($calon1->id != $calon2->id)
                    <th>{{ ucwords($calon1->nama) }} vs {{ ucwords($calon2->nama) }}</th>
                    @endif
                    @endforeach
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($data_kriteria as $kriteria)
                <tr>
                    <td><b>{{ ucwords($kriteria->nama) }}</b></td>
                    @foreach ($data_calon_pelaksanas as $calon1)
                    @foreach ($data_calon_pelaksanas as $calon2)
                    @if ($calon1->id != $calon2->id)
                    <td>{{ $nilai_perbandingan[$kriteria->id][$calon1->id][$calon2->id] }}</td>
                    @endif
                    @endforeach
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Nilai Preferensi -->
    <h4>Nilai Preferensi</h4>
    <div class="table-responsive pt-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kriteria / Alternatif</th>
                    @foreach ($data_calon_pelaksanas as $calon1)
                    @foreach ($data_calon_pelaksanas as $calon2)
                    @if ($calon1->id != $calon2->id)
                    <th>{{ ucwords($calon1->nama) }} vs {{ ucwords($calon2->nama) }}</th>
                    @endif
                    @endforeach
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($data_kriteria as $kriteria)
                <tr>
                    <td><b>{{ ucwords($kriteria->nama) }}</b></td>
                    @foreach ($data_calon_pelaksanas as $calon1)
                    @foreach ($data_calon_pelaksanas as $calon2)
                    @if ($calon1->id != $calon2->id)
                    <td>{{ $nilai_preferensi[$kriteria->id][$calon1->id][$calon2->id] ?? 0 }}</td>
                    @endif
                    @endforeach
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Preferensi Multikriteria -->
    <h4>Preferensi Multikriteria</h4>
    <div class="table-responsive pt-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    @foreach ($rankings1 as $key => $value)
                    <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($rankings1 as $key => $value)
                <tr>
                    <td>{{ $key }}</td>
                    @foreach ($value as $ranking)
                    <td>{{ round($ranking, 3) }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h4>Data LEV, ENT, NET</h4>
<div class="table-responsive pt-3">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Calon</th>
                <th>Nama Calon</th>
                <th>Leaving</th>
                <th>Entering</th>
                <th>Net Flow</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_calon_pelaksanas as $calon)
            <tr>
                <td>{{ $calon->id }}</td>
                <td>{{ $calon->nama }}</td>
                <td>{{ $hasil[$calon->id]['leaving'] ?? 'Not found' }}</td>
                <td>{{ $hasil[$calon->id]['entering'] ?? 'Not found' }}</td>
                <td>{{ $hasil[$calon->id]['net_flow'] ?? 'Not found' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Tombol Simpan -->
@if (auth()->user()->role == 'admin')
<form action="{{ route('proses-seleksi') }}" method="POST" class="mt-4">
    @csrf
    <input type="hidden" name="dari1" value="{{ request('dari_tgl') }}">
    <input type="hidden" name="sampai1" value="{{ request('sampai_tgl') }}">
    @foreach ($data_calon_pelaksanas as $calon)
        <input type="hidden" name="lev_{{ $calon->id }}" value="{{ $hasil[$calon->id]['leaving'] ?? 0 }}">
        <input type="hidden" name="ent_{{ $calon->id }}" value="{{ $hasil[$calon->id]['entering'] ?? 0 }}">
        <input type="hidden" name="net_{{ $calon->id }}" value="{{ $hasil[$calon->id]['net_flow'] ?? 0 }}">
    @endforeach
    <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
</form>
@endif
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#proses-form').on('submit', function(event) {
            var dariTgl = $('#dari_tgl').val();
            var sampaiTgl = $('#sampai_tgl').val();
            var today = new Date().toISOString().split('T')[0];

            // if (dariTgl > sampaiTgl) {
            //     alert('Tanggal mulai tidak bisa lebih besar dari tanggal akhir.');
            //     event.preventDefault();
            // }

            // if (dariTgl > today || sampaiTgl > today) {
            //     alert('Tanggal tidak bisa lebih besar dari hari ini.');
            //     event.preventDefault();
            // }
        });
    });
</script>
@endsection