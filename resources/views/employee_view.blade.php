@extends('layout.app')

@section('css')
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Karyawan</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('employee.index') }}">Karyawan</a></li>
      <li class="breadcrumb-item active" aria-current="page">Add</li>
    </ol>
</div>
@endsection
@section('content')
<div class="card sm mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Profil Karyawan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive p-3">
            <table class="table align-items-center table-flush" id="dataTable">
              <tr>
                <th>Nama</th>
                <td>{{ $employees['name'] }}</td>
              </tr>
              <tr>
                <th>NIP</th>
                <td>{{ $employees['nip'] }}</td>
              </tr>
              <tr>
                <th>Departemen</th>
                <td>{{ $employees['department'] }}</td>
              </tr>
              <tr>
                <th>Tanggal Lahir</th>
                <td>{{ date('d/m/Y', strtotime($employees['birth_date'])) }}</td>
              </tr>
              <tr>
                <th>Agama</th>
                <td>{{ $employees['religion'] }}</td>
              </tr>
              <tr>
                <th>Nomor Handphone</th>
                <td>{{ $employees['phone_number'] }}</td>
              </tr>
              <tr>
                <th>Alamat</th>
                <td>{{ $employees['address'] }}</td>
              </tr>
              <tr>
                <th>Status Karyawan</th>
                <td><?= (($employees['status'] == '1') ? "<span class='badge badge-success'>Aktif</span>" : "<span class='badge badge-danger'>Tidak Aktif</span>") ?></td>
              </tr>
            </table>
              <a href="{{ route('employee.index') }}" class="btn btn-danger btn-icon-split btn-sm">
                <span class="icon text-white-50">
                  <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Kembali</span>
              </a>
          </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endpush
