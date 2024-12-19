@extends('template')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tambah Data Proyek</h4>
                        <p class="card-description">
                            <a href="{{ route('proyek.index') }}" class="btn btn-sm btn-primary">Kembali</a>
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
                        <form class="forms-sample" action="{{ route('proyek.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="nama_proyek">Nama Proyek</label>
                                        <input type="text" name="nama_proyek" class="form-control"
                                            placeholder="Nama Proyek...">
                                        @error('nama_proyek')
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
