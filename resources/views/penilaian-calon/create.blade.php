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
                    <h4 class="card-title">Tambah Kriteria</h4>
                    <form action="{{ route('kriteria-store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Kriteria</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama Kriteria" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                        <a href="{{ route('kriteria') }}" class="btn btn-secondary mt-3">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
