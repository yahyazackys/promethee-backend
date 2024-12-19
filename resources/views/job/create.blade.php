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
                        <h4 class="card-title">Tambah Data Jobs</h4>
                        <p class="card-description">
                            <a href="{{ route('job') }}" class="btn btn-sm btn-primary">Kembali</a>
                        </p>
                        <form class="forms-sample" action="{{ route('job-store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mt-3">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="exampleInputSpesifikasi4">Nama Pekerjaan</label>
                <input type="text" name="nama_pekerjaan" class="form-control" placeholder="Nama Pekerjaan...">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="exampleInputSpesifikasi4">Keterangan</label>
                <textarea name="keterangan" class="form-control" id="editor" cols="30" rows="10"></textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="exampleSelectGender">Status</label>
                <select class="form-control" id="" name="status">
                    <option value="0">Publish</option>
                    <option value="1">Unpublish</option>
                </select>
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

    <script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
