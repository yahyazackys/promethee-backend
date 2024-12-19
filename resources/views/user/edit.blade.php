@extends('template')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header justify-content-between d-flex mt-2">
                        <h4>Edit Data User</h4>
                        <a href="{{ route('user') }}"class="btn btn-sm btn-primary text-xs font-weight-bold">Kembali</a>
                    </div>
                    <div class="card-body pt-0">
                        <form action="{{ route('user-update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputSpesifikasi4">Nama</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $data->name }}" placeholder="Nama...">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputSpesifikasi4">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $data->email }}" placeholder="Email...">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputSpesifikasi4">Password</label>
                                        <input type="password" name="password" class="form-control"
                                            value="{{ $data->password }}" placeholder="Password...">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputSpesifikasi4">No HP</label>
                                        <input type="text" name="no_hp" class="form-control"
                                            value="{{ $data->no_hp }}" placeholder="No HP...">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="exampleSelectGender">Role</label>
                                        <select class="form-control" id="" name="role">
                                            <option value="0"
                                                @if ($data->role == 'admin') {{ 'selected' }} @endif>Admin
                                            </option>
                                            <option value="1"
                                                @if ($data->role == 'pelaksana_proyek') {{ 'selected' }} @endif>Pelaksana
                                                Proyek
                                            </option>
                                            <option value="2"
                                                @if ($data->role == 'direktur') {{ 'selected' }} @endif>Direktur
                                            </option>
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
@endsection
