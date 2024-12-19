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

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Data Anggaran</h4>
                        <form action="{{ route('anggaran.update', $data->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="pelaksana_id">Pelaksana Proyek</label>
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
                                @error('pelaksana_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Proyek Dropdown -->
                            <div class="form-group">
                                <label for="proyek_id">Proyek</label>
                                <select class="form-control" name="proyek_id" id="proyek_id"
                                    @if (auth()->user()->role == 'pelaksana_proyek' || 'admin') disabled @endif>
                                    <option value="">Pilih Proyek</option>
                                    @foreach ($pelaksanas as $pelaksana)
                                        <option value="{{ $pelaksana->id }}"
                                            {{ $data->pelaksana_id == $pelaksana->id ? 'selected' : '' }}>
                                            {{ $pelaksana->proyek->nama_proyek }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('proyek_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="total_anggaran">Total Anggaran</label>
                                <input type="text" name="total_anggaran" id="total_anggaran" class="form-control"
                                    placeholder="Masukkan Total Anggaran"
                                    value="{{ old('total_anggaran', $data->total_anggaran) }}" required maxlength="12"
                                    @if (auth()->user()->role == 'pelaksana_proyek') disabled @endif>
                            </div>
                            @for ($i = 1; $i <= 4; $i++)
                                <div class="form-group">
                                    <label for="termin{{ $i }}">Termin {{ $i }}</label>
                                    <input type="text" name="termin{{ $i }}" id="termin{{ $i }}"
                                        class="form-control" placeholder="Masukkan Termin {{ $i }}"
                                        value="{{ old('termin' . $i, $data->{'termin' . $i}) }}" maxlength="12">
                                </div>
                                <div class="form-group">
                                    <label>Bukti Termin {{ $i }}</label>
                                    <div class="input-group col-xs-12">
                                        <input type="file" name="termin{{ $i }}_bukti"
                                            class="btn btn-primary"
                                            onchange="previewImage(event, 'preview-image-{{ $i }}')">
                                    </div>
                                    @if ($data->{'termin' . $i . '_bukti'})
                                        <img id="preview-image-{{ $i }}"
                                            src="{{ asset('storage/' . $data->{'termin' . $i . '_bukti'}) }}"
                                            width="100px">
                                    @else
                                        <img id="preview-image-{{ $i }}" width="100px">
                                    @endif
                                </div>
                            @endfor

                            <button type="submit" class="btn btn-primary mt-3">Update</button>
                            <a href="{{ route('anggaran.index') }}" class="btn btn-secondary mt-3">Kembali</a>
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
