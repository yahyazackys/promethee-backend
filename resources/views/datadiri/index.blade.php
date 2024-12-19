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

                        <div class="container">
                            <center>
                                <h4 class="card-title">Data Diri Calon Pelaksana Proyek</h4>
                            </center>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td>{{ $dataDiri->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Lengkap</td>
                                        <td>:</td>
                                        <td>{{ $dataDiri->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tempat Lahir</td>
                                        <td>:</td>
                                        <td>{{ $dataDiri->tempat_lahir }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Lahir</td>
                                        <td>:</td>
                                        <td>{{ $dataDiri->tanggal_lahir }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td>{{ $dataDiri->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <td>Foto Ijazah</td>
                                        <td>:</td>
                                        <td>
                                            @if ($dataDiri->ijazah)
                                                @if (Str::endsWith($dataDiri->ijazah, ['.jpg', '.jpeg', '.png', '.gif']))
                                                    <center><img src="{{ asset('storage/' . $dataDiri->ijazah) }}"
                                                            width="200px"></center>
                                                @elseif (Str::endsWith($dataDiri->ijazah, ['.pdf']))
                                                    <center><embed src="{{ asset('storage/' . $dataDiri->ijazah) }}"
                                                            width="200px" type="application/pdf"></center>
                                                @else
                                                    <a href="{{ asset('storage/' . $dataDiri->ijazah) }}">Lihat File</a>
                                                @endif
                                            @else
                                                Tidak ada file
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Foto NPWP</td>
                                        <td>:</td>
                                        <td>
                                            @if ($dataDiri->npwp)
                                                @if (Str::endsWith($dataDiri->npwp, ['.jpg', '.jpeg', '.png', '.gif']))
                                                    <center><img src="{{ asset('storage/' . $dataDiri->npwp) }}"
                                                            width="200px"></center>
                                                @elseif (Str::endsWith($dataDiri->npwp, ['.pdf']))
                                                    <center><embed src="{{ asset('storage/' . $dataDiri->npwp) }}"
                                                            width="200px" type="application/pdf"></center>
                                                @else
                                                    <a href="{{ asset('storage/' . $dataDiri->npwp) }}">Lihat File</a>
                                                @endif
                                            @else
                                                Tidak ada file
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Foto Sertifikat</td>
                                        <td>:</td>
                                        <td>
                                            @if ($dataDiri->sertifikat)
                                                @if (Str::endsWith($dataDiri->sertifikat, ['.jpg', '.jpeg', '.png', '.gif']))
                                                    <center><img src="{{ asset('storage/' . $dataDiri->sertifikat) }}"
                                                            width="200px"></center>
                                                @elseif (Str::endsWith($dataDiri->sertifikat, ['.pdf']))
                                                    <center><embed src="{{ asset('storage/' . $dataDiri->sertifikat) }}"
                                                            width="200px" type="application/pdf"></center>
                                                @else
                                                    <a href="{{ asset('storage/' . $dataDiri->sertifikat) }}">Lihat
                                                        File</a>
                                                @endif
                                            @else
                                                Tidak ada file
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

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
