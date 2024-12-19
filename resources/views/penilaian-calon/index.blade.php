@extends('template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h4>Data Penilaian Pelaksana</h4>
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
                                            Nama Pelaksana</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama Bidang</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama Proyek</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td class="text-center">{{ $loop->index + 1 }}</td>
                                            <td class="text-center">{{ $data->pelaksana->calonpelaksana->nama }}</td>
                                            <td class="text-center">{{ $data->pelaksana->subbidang->nama_bidang }}</td>
                                            <td class="text-center">{{ $data->pelaksana->proyek->nama_proyek }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-info text-xs font-weight-bold"
                                                    onclick="showModal({{ $data->id }})">Detail</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h4>Detail Pelaksana</h4>
            <div id="modal-body" class="modal-body">
                <!-- Content will be loaded here via JavaScript -->
            </div>


        </div>
    </div>

    <style>
        /* Modal CSS */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%;
            max-width: 800px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            animation: animateTop 0.4s;
            border-radius: 10px;
        }

        @keyframes animateTop {
            from {
                top: -300px;
                opacity: 0;
            }

            to {
                top: 0;
                opacity: 1;
            }
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-body {
            display: flex;
            flex-wrap: wrap;
        }

        .modal-body p {
            margin: 10px 0;
            flex: 1 1 45%;
            box-sizing: border-box;
        }

        .modal-body p:last-child {
            flex-basis: 100%;
        }

        .modal-body p strong {
            display: inline-block;
            width: 150px;
        }
    </style>

    <script>
        function showModal(id) {
            console.log('Show modal called with id:', id);
            const data = @json($datas);
            const subKriteria = @json($subKriteria);

            const selectedData = data.find(item => item.id === id);

            if (selectedData) {
                const modalBody = document.getElementById('modal-body');
                modalBody.innerHTML = `
                    <p><strong>Nama Pelaksana:</strong> ${selectedData.pelaksana.calonpelaksana.nama}</p>
                    <p><strong>Nama Bidang:</strong> ${selectedData.pelaksana.subbidang.nama_bidang}</p>
                    <p><strong>Nama Proyek:</strong> ${selectedData.pelaksana.proyek.nama_proyek}</p>
                    <p><strong>No Kontrak:</strong> ${selectedData.pelaksana.no_kontrak}</p>
                    <p><strong>Nilai Kontrak:</strong> ${selectedData.pelaksana.nilai_kontrak}</p>
                    <p><strong>Tanggal Kontrak:</strong> ${selectedData.pelaksana.tanggal_kontrak}</p>
                    <div class="details" style="width:50%;">
                        <p><strong>k1:</strong> ${selectedData.k1}</p>
                        <p><strong>bobot k1:</strong> ${getBobot(1, selectedData.k1)}</p>
                    </div>
                    <div class="details" style="width:50%;">
                        <p><strong>k2:</strong> ${selectedData.k2}</p>
                        <p><strong>bobot k2:</strong> ${getBobot(2, selectedData.k2)}</p>
                    </div>
                    <div class="details" style="width:50%;">
                        <p><strong>k3:</strong> ${selectedData.k3}</p>
                        <p><strong>bobot k3:</strong> ${getBobot(3, selectedData.k3)}</p>
                    </div>
                    <div class="details" style="width:50%;">
                        <p><strong>k4:</strong> ${selectedData.k4}</p>
                        <p><strong>bobot k4:</strong> ${getBobot(4, selectedData.k4)}</p>
                    </div>
                    <form action="{{ route('penilaian.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="pelaksana_id" value="${selectedData.pelaksana.id}">
                        <input type="hidden" name="k1" placeholder="Enter k1 value" value=" ${getBobot(1, selectedData.k1)} ">
                        <input type="hidden" name="k2" placeholder="Enter k2 value" value=" ${getBobot(2, selectedData.k2)} ">
                        <input type="hidden" name="k3" placeholder="Enter k3 value" value=" ${getBobot(3, selectedData.k3)} ">
                        <input type="hidden" name="k4" placeholder="Enter k4 value" value=" ${getBobot(4, selectedData.k4)} ">
                        <button type="submit" class="btn btn-primary">Verifikasi Penilaian</button>
                    </form>
                `;
            }

            document.getElementById('detailModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('detailModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('detailModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }

        function getBobot(kriteria_id, value) {
            const subKriteria = @json($subKriteria);
            const kriteria = subKriteria[kriteria_id] || [];

            let bobot = 'N/A';

            kriteria.forEach(item => {
                if (item.nama.startsWith('>=') && parseFloat(value) >= parseFloat(item.nama.substring(2).trim())) {
                    bobot = item.bobot;
                } else if (item.nama.startsWith('<=') && parseFloat(value) <= parseFloat(item.nama.substring(2)
                        .trim())) {
                    bobot = item.bobot;
                } else if (item.nama.includes('-')) {
                    const [min, max] = item.nama.split('-').map(num => parseFloat(num.trim()));
                    if (parseFloat(value) >= min && parseFloat(value) <= max) {
                        bobot = item.bobot;
                    }
                } else if (item.nama === value) {
                    bobot = item.bobot;
                }
            });

            return bobot;
        }
    </script>
@endsection
