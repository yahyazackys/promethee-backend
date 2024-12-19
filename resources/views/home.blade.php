@extends('template')

@section('content')
<div class="container-fluid py-4">
    @if (auth()->user()->role == 'pelaksana_proyek')
    <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="d-flex flex-column h-100">
                                <p class="mb-1 pt-2 text-bold">Selamat Anda Terpilih Untuk Gabung Dalam Project</p>

                                <h5 class="font-weight-bolder">
                                    @if ($data1)
                                    <div>
                                        @if ($data1->calonPelaksana)
                                        <p>Nama Calon Pelaksana: {{ $data1->calonPelaksana->nama }}</p>
                                        @endif

                                        @if ($data1->proyek)
                                        <p>Nama Proyek: {{ $data1->proyek->nama_proyek }}</p>
                                        @endif
                                    </div>
                                    @else
                                    <p>Tidak ada data terbaru yang ditemukan.</p>
                                    @endif
                                </h5>
                            </div>

                        </div>
                        <div class="col-lg-5 ms-auto text-center mt-5 mt-lg-0">
                            <div class="bg-gradient-primary border-radius-lg h-100">
                                <img src="../assets/img/shapes/waves-white.svg" class="position-absolute h-100 w-50 top-0 d-lg-block d-none" alt="waves">
                                <div class="position-relative d-flex align-items-center justify-content-center h-100">
                                    <img class="w-100 position-relative z-index-2 pt-4" src="../assets/img/illustrations/rocket-white.png" alt="rocket">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div>
        @if (auth()->user()->role == 'admin')
        <canvas id="myChart"></canvas>
        @endif
    </div>
    <footer class="footer pt-3  ">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6 mb-lg-0 mb-4">
                    <div class="copyright text-center text-sm text-muted text-lg-start">
                        ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>,
                        made with <i class="fa fa-heart"></i> by
                        <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Clarisya
                            Paraswida
                        </a>

                    </div>
                </div>
                {{-- <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative
                                    Tim</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted"
                                    target="_blank">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/blog" class="nav-link text-muted"
                                    target="_blank">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted"
                                    target="_blank">License</a>
                            </li>
                        </ul>
                    </div> --}}
            </div>
        </div>
    </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Proyek', 'Total Calon Anggota', 'Total Portofolio'],
            datasets: [{
                label: 'Total',
                data: [<?php echo json_encode($totalProyek); ?>, <?php echo json_encode($totalCalonPelaksana); ?>, <?php echo json_encode($totalPortofolio); ?>],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection