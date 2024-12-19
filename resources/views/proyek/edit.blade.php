@extends('template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header justify-content-between d-flex mt-2">
                        <h4>Edit Data Proyek</h4>
                        <a href="{{ route('proyek.index') }}"
                            class="btn btn-sm btn-primary text-xs font-weight-bold">Kembali</a>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('proyek.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="nama_proyek">Nama Proyek</label>
                                        <input type="text" name="nama_proyek" class="form-control"
                                            value="{{ $data->nama_proyek }}" placeholder="Nama Proyek...">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="progress">Progress</label>
                                        <input type="text" name="progress" class="form-control"
                                            value="{{ $data->progress }}" placeholder="Progress...">
                                    </div>
                                </div>
                                @for ($i = 1; $i <= 4; $i++)
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>Bukti {{ $i }}</label>
                                            <div class="input-group col-xs-12">
                                                <input type="file" name="bukti{{ $i }}"
                                                    class="btn btn-primary"
                                                    onchange="previewImage(event, 'preview-image-{{ $i }}')">
                                            </div>
                                            @if ($data->{'bukti' . $i})
                                                <img id="preview-image-{{ $i }}"
                                                    src="{{ asset('storage/' . $data->{'bukti' . $i}) }}" width="100px">
                                            @else
                                                <img id="preview-image-{{ $i }}" width="100px">
                                            @endif
                                        </div>
                                    </div>
                                @endfor

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label>Laporan Lapangan Bersama</label>
                                        <div class="input-group col-xs-12">
                                            <input type="file" name="laporan_lapangan_bersama" class="btn btn-primary"
                                                onchange="previewImage(event, 'preview-image-laporan')">
                                        </div>
                                        @if ($data->laporan_lapangan_bersama)
                                            <img id="preview-image-laporan"
                                                src="{{ asset('storage/' . $data->laporan_lapangan_bersama) }}"
                                                width="100px">
                                        @else
                                            <img id="preview-image-laporan" width="100px">
                                        @endif
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

    <script>
        function previewImage(event, previewId) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function() {
                var preview = document.getElementById(previewId);
                preview.src = reader.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
