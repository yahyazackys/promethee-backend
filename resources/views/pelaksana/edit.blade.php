@extends('template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header justify-content-between d-flex mt-2">
                        <h4>Edit Data Pelaksana Proyek</h4>
                        <a href="{{ route('pelaksana.index') }}"
                            class="btn btn-sm btn-primary text-xs font-weight-bold">Kembali</a>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('pelaksana.update', $pelaksana->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="calon_pelaksana_id">Calon Pelaksana</label>
                                        <select name="calon_pelaksana_id" class="form-control">
                                            @foreach ($calonpelaksanas as $calon)
                                                <option value="{{ $calon->id }}"
                                                    {{ $pelaksana->calon_pelaksana_id == $calon->id ? 'selected' : '' }}>
                                                    {{ $calon->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="sub_bidang_id">Sub Bidang</label>
                                        <select name="sub_bidang_id" class="form-control">
                                            @foreach ($subbidangs as $subbidang)
                                                <option value="{{ $subbidang->id }}"
                                                    {{ $pelaksana->sub_bidang_id == $subbidang->id ? 'selected' : '' }}>
                                                    {{ $subbidang->nama_bidang }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="proyek_id">Proyek</label>
                                        <select name="proyek_id" class="form-control">
                                            @foreach ($proyeks as $proyek)
                                                <option value="{{ $proyek->id }}"
                                                    {{ $pelaksana->proyek_id == $proyek->id ? 'selected' : '' }}>
                                                    {{ $proyek->nama_proyek }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="no_kontrak">No Kontrak</label>
                                        <input type="text" name="no_kontrak" class="form-control"
                                            value="{{ $pelaksana->no_kontrak }}" placeholder="No Kontrak...">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="nilai_kontrak">Nilai Kontrak</label>
                                        <input type="number" name="nilai_kontrak" class="form-control"
                                            value="{{ $pelaksana->nilai_kontrak }}" placeholder="Nilai Kontrak...">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="tanggal_kontrak">Tanggal Mulai Kontrak</label>
                                        <input type="date" name="tanggal_kontrak" class="form-control"
                                            value="{{ $pelaksana->tanggal_kontrak }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="tanggal_kontrak">Tanggal Selesai Kontrak</label>
                                        <input type="date" name="tanggal_selesai_kontrak" class="form-control"
                                            value="{{ $pelaksana->tanggal_selesai_kontrak }}">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
