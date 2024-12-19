@extends('template')

@section('content')
<div class="content">
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
                <h4 class="card-title">Tambah Data Data Diri</h4>
                    <form class="forms-sample" action="{{ route('datadiri-store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail3">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" id="exampleInputEmail3" value="{{ old('name', Auth::user()->name) }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword4">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" id="exampleInputPassword4" placeholder="Masukkan Tempat Lahir..">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword4">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" id="exampleInputPassword4" placeholder="Pilih Tanggal Lahir..">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword4">Alamat</label>
                            <input type="text" name="alamat" class="form-control" id="exampleInputPassword4" placeholder="Masukkan Alamat Lengkap..">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword4">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" id="exampleInputPassword4" placeholder="Masukkan Kecamatan..">
                        </div>
                        <div class="form-group">
                            <label for="exampleSelectGender">Jenis Kelamin</label>
                            <select class="form-control" id="exampleSelectGender" name="jenis_kelamin">
                                <option value="">--Pilih Jenis Kelamin--</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword4">Email</label>
                            <input type="email" name="email" class="form-control" id="exampleInputPassword4" value="{{ old('email', Auth::user()->email) }} " readonly>
                        </div>
                        <div class="form-group">
                            <label>Foto NPWP</label>
                            <input type="file" name="npwp" class="form-control" id="exampleInputJudul">
                        </div>
                        <div class="form-group">
                            <label>Foto Ijazah</label>
                            <input type="file" name="ijazah" class="form-control" id="exampleInputJudul">
                        </div>
                        <div class="form-group">
                            <label>Surat Sertifikat</label>
                            <input type="file" name="sertifikat" class="form-control" id="exampleInputJudul">
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection