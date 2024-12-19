@extends('template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header justify-content-between d-flex mt-2">
                        <h4>Edit Data Jobs</h4>
                        <a href="{{ route('job') }}"class="btn btn-sm btn-primary text-xs font-weight-bold">Kembali</a>
                    </div>
                    <div class="card-body pt-0">
                    <form action="{{ route('job-update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <input type="hidden" name="id" value="{{ $jobs->id }}">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="exampleInputSpesifikasi4">Nama Pekerjaan</label>
                <input type="text" name="nama_pekerjaan" class="form-control" value="{{ $jobs->nama_pekerjaan }}" placeholder="Nama Pekerjaan...">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="exampleInputSpesifikasi4">Keterangan</label>
                <textarea name="keterangan" class="form-control" id="editor" cols="30" rows="10">{{ $jobs->keterangan }}</textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="exampleSelectGender">Status</label>
                <select class="form-control" id="" name="status">
                    <option value="0" @if ($jobs->status == '0') selected @endif>Publish</option>
                    <option value="1" @if ($jobs->status == '1') selected @endif>Unpublish</option>
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
