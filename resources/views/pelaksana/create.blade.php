@extends('template')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tambah Data Pelaksana</h4>
                        <p class="card-description">
                            <a href="{{ route('pelaksana.index') }}" class="btn btn-sm btn-primary">Kembali</a>
                        </p>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form class="forms-sample" action="{{ route('pelaksana.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="calon_pelaksana_id">Nama Pelaksana</label>
                                        <select class="form-control" name="calon_pelaksana_id" id="calon_pelaksana_id">
                                            @foreach ($calonpelaksanas as $calon)
                                                <option value="{{ $calon->id }}">{{ $calon->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('calon_pelaksana_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="sub_bidang_id">Sub Bidang</label>
                                        <select class="form-control" name="sub_bidang_id">
                                            @foreach ($subbidangs as $subbidang)
                                                <option value="{{ $subbidang->id }}">{{ $subbidang->nama_bidang }}</option>
                                            @endforeach
                                        </select>
                                        @error('sub_bidang_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="proyek_id">Nama Proyek</label>
                                        <select class="form-control" name="proyek_id">
                                            @foreach ($proyeks as $proyek)
                                                <option value="{{ $proyek->id }}">{{ $proyek->nama_proyek }}</option>
                                            @endforeach
                                        </select>
                                        @error('proyek_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="no_kontrak">No Kontrak</label>
                                        <input type="text" name="no_kontrak" class="form-control"
                                            placeholder="No Kontrak..." value="{{ old('no_kontrak') }}">
                                        @error('no_kontrak')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="nilai_kontrak">Nilai Kontrak</label>
                                        <input type="text" name="nilai_kontrak" class="form-control"
                                            placeholder="Nilai Kontrak..." value="{{ old('nilai_kontrak') }}">
                                        @error('nilai_kontrak')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="tanggal_kontrak">Tanggal Mulai Kontrak</label>
                                        <input type="date" name="tanggal_kontrak" class="form-control"
                                            value="{{ old('tanggal_kontrak') }}">
                                        @error('tanggal_kontrak')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="tanggal_kontrak">Tanggal Selesai Kontrak</label>
                                        <input type="date" name="tanggal_selesai_kontrak" class="form-control"
                                            value="{{ old('tanggal_selesai_kontrak') }}">
                                        @error('tanggal_selesai_kontrak')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
