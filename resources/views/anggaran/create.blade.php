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
                        <h4 class="card-title">Tambah Data Anggaran</h4>
                        <form action="{{ route('anggaran.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="pelaksana_id">Pelaksana Proyek</label>
                                <select class="form-control" name="pelaksana_id" id="pelaksana_id">
                                    @foreach ($pelaksanas as $pelaksana)
                                        <option value="{{ $pelaksana->id }}">
                                            {{ $pelaksana->calonpelaksana->nama . '-' . $pelaksana->proyek->nama_proyek }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pelaksana_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <label for="total_anggaran">Total Anggaran</label>
                                <input type="text" name="total_anggaran" id="total_anggaran" class="form-control"
                                    placeholder="Masukkan Total Anggaran" required>
                            </div> --}}
                            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                            <a href="{{ route('anggaran.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
