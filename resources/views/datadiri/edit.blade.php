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
                        <h4 class="card-title">Edit Data Diri</h4>
                        <form class="forms-sample" action="{{ route('datadiri.update', $dataDiri->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="exampleInputEmail3">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" id="exampleInputEmail3"
                                    value="{{ $dataDiri->nama }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword4">Email</label>
                                <input type="email" name="email" class="form-control" id="exampleInputPassword4"
                                    value="{{ $dataDiri->email }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword4">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" id="exampleInputPassword4"
                                    value="{{ $dataDiri->tempat_lahir }}" placeholder="Masukkan Tempat Lahir..">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword4">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" id="exampleInputPassword4"
                                    value="{{ $dataDiri->tanggal_lahir }}" placeholder="Pilih Tanggal Lahir..">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword4">Alamat</label>
                                <input type="text" name="alamat" class="form-control" id="exampleInputPassword4"
                                    value="{{ $dataDiri->alamat }}" placeholder="Masukkan Alamat Lengkap..">
                            </div>

                            <div class="form-group">
                                <label>Foto NPWP</label>
                                <input type="file" name="npwp" class="form-control" id="npwpInput"
                                    onchange="previewImage(event, 'npwpPreview')">
                                <div id="npwpPreviewContainer">
                                    @if ($dataDiri->npwp)
                                        <img id="npwpPreview" src="{{ asset('storage/' . $dataDiri->npwp) }}" alt="Preview"
                                            style="max-width: 100px; margin-top: 10px;">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Foto Ijazah</label>
                                <input type="file" name="ijazah" class="form-control" id="ijazahInput"
                                    onchange="previewImage(event, 'ijazahPreview')">
                                <div id="ijazahPreviewContainer">
                                    @if ($dataDiri->ijazah)
                                        <img id="ijazahPreview" src="{{ asset('storage/' . $dataDiri->ijazah) }}"
                                            alt="Preview" style="max-width: 100px; margin-top: 10px;">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Surat Sertifikat</label>
                                <input type="file" name="sertifikat" class="form-control" id="sertifikatInput"
                                    onchange="previewImage(event, 'sertifikatPreview')">
                                <div id="sertifikatPreviewContainer">
                                    @if ($dataDiri->sertifikat)
                                        <img id="sertifikatPreview" src="{{ asset('storage/' . $dataDiri->sertifikat) }}"
                                            alt="Preview" style="max-width: 100px; margin-top: 10px;">
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function previewImage(event, previewId) {
                var input = event.target;
                var reader = new FileReader();
                var preview = document.getElementById(previewId);

                reader.onload = function() {
                    preview.src = reader.result;
                    if (!preview.parentElement) {
                        var container = document.createElement('div');
                        container.id = previewId + 'Container';
                        container.style.marginTop = '10px';
                        preview.style.maxWidth = '100px';
                        container.appendChild(preview);
                        input.parentElement.appendChild(container);
                    }
                };

                if (input.files && input.files[0]) {
                    reader.readAsDataURL(input.files[0]);
                } else {
                    if (preview) {
                        preview.src = '';
                    }
                }
            }
        </script>
    @endpush
@endsection
