@extends('layout.app')

@section('css')
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Karyawan</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Karyawan</li>
    </ol>
</div>
@endsection
@section('content')
<div class="card sm mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
        <a href="#" class="btn btn-primary">+ Tambah</a>
    </div>
    <div class="card-body">
        <div class="table-responsive p-3">
            <table class="table align-items-center table-flush" id="dataTable">
              <thead class="thead-light">
                <tr>
                  <th>No.</th>
                  <th>Nama</th>
                  <th>NIP</th>
                  <th>Departemen</th>
                  <th>Jabatan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($employees AS $emp)
                <tr>
                    <td>1</td>
                    <td>{{ $emp['name'] }}</td>
                    <td>{{ $emp['nip'] }}</td>
                    <td>{{ $emp['department'] }}</td>
                    <td>{{ $emp['position_id'] }}</td>
                    <td>
                        
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $('#dataTable').DataTable({
        // processing: true,
        // serverSide: true,
        // ajax: "{{ route('employee.index') }}",
        // columns: [
        //     { data: 'DT_RowIndex', orderable: false, searchable: false, className: "text-center"},
        //     { data: 'name' },
        //     { data: 'nip' },
        //     { data: 'department' },
        //     { data: 'position_id' },
        //     {
        //         targets: -1,
        //         data: null,
        //         defaultContent: '<button>Click!</button>',
        //     }
        // ]
    })
</script>
@endpush
