@extends('template')

@section('content')
<div class="container">
    <h1>Portofolio</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (auth()->user()->role == 'admin')
    <a href="{{ route('portofolio.create') }}" class="btn btn-primary mb-3">Tambah Portofolio</a>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Pelaksana</th>
                <th>K1</th>
                <th>K2</th>
                <th>K3</th>
                <th>K4</th>
                @if (auth()->user()->role == 'admin')
                <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @if (auth()->user()->role == 'admin')
            @foreach($data1 as $data)
            <tr>
                <td>{{ $data->pelaksana->calonpelaksana->nama ? : 'N/A' }}</td>
                <td>{{ $data->k1 }}</td>
                <td>{{ $data->k2 }}</td>
                <td>{{ $data->k3 }}</td>
                <td>{{ $data->k4 }}</td>
                @if (auth()->user()->role == 'admin')
                <td>
                    <a href="{{ route('portofolio.edit', $data->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('portofolio.delete', $data->id) }}"
                                                            onclick="return confirm('Yakin hapus data ini?')"
                                                            class="btn btn-sm btn-danger text-xs font-weight-bold">Hapus</a>
                </td>
                @endif
            </tr>
            @endforeach
            @endif
            @if (auth()->user()->role == 'pelaksana_proyek')
            @foreach($datas as $data)
            <tr>
                <td>{{ $data->pelaksana->calonpelaksana->nama ? : 'N/A' }}</td>
                <td>{{ $data->k1 }}</td>
                <td>{{ $data->k2 }}</td>
                <td>{{ $data->k3 }}</td>
                <td>{{ $data->k4 }}</td>
                @if (auth()->user()->role == 'admin')
                <td>
                    <a href="{{ route('portofolio.edit', $data->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('portofolio.delete', $data->id) }}"
                                                            onclick="return confirm('Yakin hapus data ini?')"
                                                            class="btn btn-sm btn-danger text-xs font-weight-bold">Hapus</a>
                </td>
                @endif
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection
