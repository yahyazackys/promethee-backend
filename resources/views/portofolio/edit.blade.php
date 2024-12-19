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
    <h1>Edit Portofolio</h1>
    <form action="{{ route('portofolio.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="pelaksana_id">Pelaksana</label>
            <select class="form-control" name="pelaksana_id" id="pelaksana_id"
                                    @if (auth()->user()->role == 'pelaksana_proyek' || 'admin') disabled @endif>
                                    <option value="">Pilih Pelaksana</option>
                                    @foreach ($pelaksanas as $pelaksana)
                                        <option value="{{ $pelaksana->id }}"
                                            {{ $data->pelaksana_id == $pelaksana->id ? 'selected' : '' }}>
                                            {{ $pelaksana->calonpelaksana->nama }}
                                        </option>
                                    @endforeach
                                </select>
        </div>
        <div class="form-group">
            <label for="k1">K1</label>
            <input type="text" class="form-control" id="k1" name="k1" value="{{ $data->k1 }}" required>
        </div>
        <div class="form-group">
            <label for="k2">K2</label>
            <input type="text" class="form-control" id="k2" name="k2" value="{{ $data->k2 }}" required>
        </div>
        <div class="form-group">
            <label for="k3">K3</label>
            <input type="text" class="form-control" id="k3" name="k3" value="{{ $data->k3 }}" required>
        </div>
        <div class="form-group">
            <label for="k4">K4</label>
            <input type="text" class="form-control" id="k4" name="k4" value="{{ $data->k4 }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
    </div>


@endsection
