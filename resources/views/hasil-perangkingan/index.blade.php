@extends('template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-4">
                        <h4>Data Hasil dan Perangkingan</h4>
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
                                            Nama</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Net Flow</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Rangking</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $index => $data)
                                        <tr>
                                            <td class="text-center text-xs font-weight-bold">{{ $index + 1 }}</td>
                                            <td class="text-center text-xs font-weight-bold">
                                                {{ $data->pelaksana->calonpelaksana->nama }}</td>
                                            <td class="text-center text-xs font-weight-bold">{{ $data->net }}</td>
                                            <td class="text-center text-xs font-weight-bold">{{ $index + 1 }}</td>
                                            <td class="text-center text-xs font-weight-bold">
                                                @if ($data->status == 'proses')
                                                    @if (auth()->user()->role == 'admin')
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="openModal('statusModal-{{ $data->id }}')">Proses</button>
                                                    @else
                                                        <button class="btn btn-danger btn-sm" disabled>Proses</button>
                                                    @endif
                                                @elseif ($data->status == 'diajukan')
                                                    @if (auth()->user()->role == 'direktur')
                                                        <button class="btn btn-info btn-sm"
                                                            onclick="openModal('statusModal-{{ $data->id }}')">Diajukan</button>
                                                    @else
                                                        <button class="btn btn-info btn-sm" disabled>Diajukan</button>
                                                    @endif
                                                @else
                                                    <button class="btn btn-success btn-sm" disabled>Diterima</button>
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Modal -->
                                        <div id="statusModal-{{ $data->id }}" class="modal" style="display: none;">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Ubah Status</h5>
                                                    <span class="close"
                                                        onclick="closeModal('statusModal-{{ $data->id }}')">&times;</span>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($data->status == 'proses')
                                                        Apakah Anda yakin ingin mengubah status menjadi diajukan?
                                                    @elseif ($data->status == 'diajukan')
                                                        Apakah Anda yakin ingin mengubah status menjadi diterima?
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary"
                                                        onclick="closeModal('statusModal-{{ $data->id }}')">Batal</button>
                                                    <form action="{{ route('hasil-perangkingan.updateStatus', $data->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-warning">Ubah Status</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CSS untuk Modal -->
    <style>
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 500px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.25rem;
        }

        .close {
            cursor: pointer;
            font-size: 1.5rem;
            color: #000;
        }
    </style>

    <!-- JavaScript untuk Modal -->
    <script>
        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>
@endsection
