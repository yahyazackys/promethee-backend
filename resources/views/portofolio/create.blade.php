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

    <div class="container">
        <h1>Tambah Portofolio</h1>
        <form action="{{ route('portofolio.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="pelaksana_id">Pelaksana Proyek</label>
                <select class="form-control" name="pelaksana_id" id="pelaksana_id">
                    @foreach ($pelaksanas as $pelaksana)
                    <option value="{{ $pelaksana->id }}">
                        {{ $pelaksana->calonpelaksana->nama }}
                    </option>
                    @endforeach
                </select>
                @error('pelaksana_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="k1">K1</label>
                <input type="text" class="form-control" id="k1" name="k1" required>
            </div>
            <div class="form-group">
                <label for="k2">K2</label>
                <input type="text" class="form-control" id="k2" name="k2" required>
            </div>
            <div class="form-group">
                <label for="k3">K3</label>
                <input type="text" class="form-control" id="k3" name="k3" required>
            </div>
            <div class="form-group">
                <label for="k4">K4</label>
                <input type="text" class="form-control" id="k4" name="k4" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection