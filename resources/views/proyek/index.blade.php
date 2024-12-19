@extends('template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h4>Data Proyek</h4>
                        @if (auth()->user()->role == 'admin')
                            <a href="{{ route('proyek.create') }}"
                                class="btn btn-sm btn-primary text-xs font-weight-bold mt-4">Add</a>
                        @endif
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0 mx-4">
                            <table class="table align-items-center mb-0" id="datatables">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama Proyek</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Progress</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Bukti 1</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Bukti 2</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Bukti 3</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Bukti 4</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Laporan Lapangan Bersama</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                @if (auth()->user()->role == 'pelaksana_proyek')
                                    <tbody>
                                        @foreach ($data1 as $data)
                                            <tr>
                                                <td>
                                                    <h6 class="text-secondary font-weight-bold text-xs text-center">
                                                        {{ $loop->iteration }}
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-secondary font-weight-bold text-xs text-center">
                                                        {{ $data->pelaksana->proyek->nama_proyek }}
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-secondary font-weight-bold text-xs text-center">
                                                        {{ $data->pelaksana->proyek->progress }}
                                                    </h6>
                                                </td>
                                                @for ($i = 1; $i <= 4; $i++)
                                                    <td>
                                                        <h6 class="text-secondary font-weight-bold text-xs text-center">
                                                            @if ($data->pelaksana->proyek->{'bukti' . $i})
                                                                @if (Str::endsWith($data->pelaksana->proyek->{'bukti' . $i}, ['.jpg', '.jpeg', '.png', '.gif']))
                                                                    <img src="{{ asset('storage/' . $data->pelaksana->proyek->{'bukti' . $i}) }}"
                                                                        width="200px">
                                                                @elseif (Str::endsWith($data->pelaksana->proyek->{'bukti' . $i}, ['.pdf']))
                                                                    <embed
                                                                        src="{{ asset('storage/' . $data->pelaksana->proyek->{'bukti' . $i}) }}"
                                                                        width="100px" height="100px"
                                                                        type="application/pdf">
                                                                @else
                                                                    <a
                                                                        href="{{ asset('storage/' . $data->pelaksana->proyek->{'bukti' . $i}) }}">Lihat
                                                                        File</a>
                                                                @endif
                                                            @else
                                                                Tidak ada file
                                                            @endif
                                                        </h6>
                                                    </td>
                                                @endfor
                                                <td>
                                                    <h6 class="text-secondary font-weight-bold text-xs text-center">
                                                        @if ($data->pelaksana->proyek->laporan_lapangan_bersama)
                                                            @if (Str::endsWith($data->pelaksana->proyek->laporan_lapangan_bersama, ['.jpg', '.jpeg', '.png', '.gif']))
                                                                <img src="{{ asset('storage/' . $data->pelaksana->proyek->laporan_lapangan_bersama) }}"
                                                                    width="200px">
                                                            @elseif (Str::endsWith($data->pelaksana->proyek->laporan_lapangan_bersama, ['.pdf']))
                                                                <embed
                                                                    src="{{ asset('storage/' . $data->pelaksana->proyek->laporan_lapangan_bersama) }}"
                                                                    width="100px" height="100px" type="application/pdf">
                                                            @else
                                                                <a
                                                                    href="{{ asset('storage/' . $data->pelaksana->proyek->laporan_lapangan_bersama) }}">Lihat
                                                                    File</a>
                                                            @endif
                                                        @else
                                                            Tidak ada file
                                                        @endif
                                                    </h6>
                                                </td>
                                                <td class="align-middle text-center">
                                                    {{-- @if (auth()->user()->role == 'pelaksana_proyek') --}}
                                                    <a href="{{ route('proyek.edit', $data->pelaksana->proyek->id) }}"
                                                        class="btn btn-sm btn-info text-xs font-weight-bold">Edit</a>
                                                    {{-- @endif --}}
                                                    @if (auth()->user()->role == 'admin')
                                                        <a href="{{ route('proyek.delete', $data->pelaksana->proyek->id) }}"
                                                            onclick="return confirm('Yakin hapus data ini?')"
                                                            class="btn btn-sm btn-danger text-xs font-weight-bold">Hapus</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                                @if (auth()->user()->role == 'admin')
                                    <tbody>
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td>
                                                    <h6 class="text-secondary font-weight-bold text-xs text-center">
                                                        {{ $loop->iteration }}
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-secondary font-weight-bold text-xs text-center">
                                                        {{ $data->nama_proyek }}
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-secondary font-weight-bold text-xs text-center">
                                                        {{ $data->progress }}
                                                    </h6>
                                                </td>
                                                @for ($i = 1; $i <= 4; $i++)
                                                    <td>
                                                        <h6 class="text-secondary font-weight-bold text-xs text-center">
                                                            @if ($data->{'bukti' . $i})
                                                                @if (Str::endsWith($data->{'bukti' . $i}, ['.jpg', '.jpeg', '.png', '.gif']))
                                                                    <img src="{{ asset('storage/' . $data->{'bukti' . $i}) }}"
                                                                        width="200px">
                                                                @elseif (Str::endsWith($data->{'bukti' . $i}, ['.pdf']))
                                                                    <embed
                                                                        src="{{ asset('storage/' . $data->{'bukti' . $i}) }}"
                                                                        width="100px" height="100px"
                                                                        type="application/pdf">
                                                                @else
                                                                    <a
                                                                        href="{{ asset('storage/' . $data->{'bukti' . $i}) }}">Lihat
                                                                        File</a>
                                                                @endif
                                                            @else
                                                                Tidak ada file
                                                            @endif
                                                        </h6>
                                                    </td>
                                                @endfor
                                                <td>
                                                    <h6 class="text-secondary font-weight-bold text-xs text-center">
                                                        @if ($data->laporan_lapangan_bersama)
                                                            @if (Str::endsWith($data->laporan_lapangan_bersama, ['.jpg', '.jpeg', '.png', '.gif']))
                                                                <img src="{{ asset('storage/' . $data->laporan_lapangan_bersama) }}"
                                                                    width="200px">
                                                            @elseif (Str::endsWith($data->laporan_lapangan_bersama, ['.pdf']))
                                                                <embed
                                                                    src="{{ asset('storage/' . $data->laporan_lapangan_bersama) }}"
                                                                    width="100px" height="100px" type="application/pdf">
                                                            @else
                                                                <a
                                                                    href="{{ asset('storage/' . $data->laporan_lapangan_bersama) }}">Lihat
                                                                    File</a>
                                                            @endif
                                                        @else
                                                            Tidak ada file
                                                        @endif
                                                    </h6>
                                                </td>
                                                <td class="align-middle text-center">
                                                    {{-- @if (auth()->user()->role == 'pelaksana_proyek') --}}
                                                    <a href="{{ route('proyek.edit', $data->id) }}"
                                                        class="btn btn-sm btn-info text-xs font-weight-bold">Edit</a>
                                                    {{-- @endif --}}
                                                    @if (auth()->user()->role == 'admin')
                                                        <a href="{{ route('proyek.delete', $data->id) }}"
                                                            onclick="return confirm('Yakin hapus data ini?')"
                                                            class="btn btn-sm btn-danger text-xs font-weight-bold">Hapus</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection