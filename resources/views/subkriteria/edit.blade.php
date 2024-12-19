@extends('template')

@section('content')
<div class="content">
    @if (Session::has('success'))
    <div id="success-alert" class="alert alert-success position-fixed" style="margin-left: 40%; margin-top: 100px;">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (Session::has('error'))
    <div id="error-alert" class="alert alert-danger position-fixed" style="margin-left: 40%; margin-top: 100px;">
        {{ Session::get('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Subkriteria</h4>
                    <form action="{{ route('subkriteria.update', $subkriteria->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="kriteria_id">Kriteria</label>
                            <select name="kriteria_id" id="kriteria_id" class="form-control" required>
                                <option value="">Pilih Kriteria</option>
                                @foreach ($kriteria as $kt)
                                <option value="{{ $kt->id }}" {{ $kt->id == $subkriteria->kriteria_id ? 'selected' : '' }}>
                                    {{ $kt->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Subkriteria</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ $subkriteria->nama }}" placeholder="Masukkan Nama Subkriteria" required>
                        </div>
                        <div class="form-group">
                            <label for="bobot">Bobot</label>
                            <input type="number" step="0.01" name="bobot" id="bobot" class="form-control" value="{{ $subkriteria->bobot }}" placeholder="Masukkan Bobot" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                        <a href="{{ route('subkriteria.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
