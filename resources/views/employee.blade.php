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
        <a href="{{ route('employee.create') }}" class="btn btn-primary">+ Tambah</a>
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
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($employees AS $emp)
                <?php $no=0; ?>
                <tr>
                    <td><?= $no; $no++; ?></td>
                    <td>{{ $emp['name'] }}</td>
                    <td>{{ $emp['nip'] }}</td>
                    <td>{{ $emp['department'] }}</td>
                    <td>{{ $emp['jabatan'] }}</td>
                    <td>
                      <!-- {{ $emp['status'] }} -->
                      <div class="custom-control custom-switch">
                        @if($emp['status'] == '1')
                          <input type="checkbox" class="custom-control-input" id="switch_status_{{ $emp['id'] }}" value="{{ $emp['id'] }}"  onchange="switchFunction(this)" checked>
                          <label class="custom-control-label" for="switch_status_{{ $emp['id'] }}" id="label_switch_{{ $emp['id'] }}">Aktif</label>
                        @else
                          <input type="checkbox" class="custom-control-input" id="switch_status_{{ $emp['id'] }}" value="{{ $emp['id'] }}" onchange="switchFunction(this)">
                          <label class="custom-control-label" for="switch_status_{{ $emp['id'] }}" id="label_switch_{{ $emp['id'] }}">Tidak Aktif</label>
                        @endif
                      </div>
                    </td>
                    <td>
                        <a href="{{ route('employee.edit', $emp['id']) }}" class="btn btn-sm btn-warning">Update</a>
                        <form method="post" action="{{ route('employee.destroy', $emp['id']) }}">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php $no++; ?>
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
    $('#dataTable').DataTable();

    function switchFunction(key) {
      var key_id = key.id.split("_")[2];
      var id = key.id;
      var check = $('#'+id).is(':checked');

      if(check == true){

        $('#label_switch_'+key_id).html('Aktif');

        $.ajax({
          url: "{{ url('employee/update_status') }}",
          type: "POST",
          data: {
            id: key_id,
            status: "1",
            _token: '{{csrf_token()}}'
          },
          dataType: 'json',
          success: function (res) {
            swal({
                title: "Berhasil",
                type: "success",
                text: "Status berhasil diubah",
            });
          }
        });
      } else {

        $('#label_switch_'+key_id).html('Tidak Aktif');

        $.ajax({
          url: "{{ url('employee/update_status') }}",
          type: "POST",
          data: {
            id: key_id,
            status: "0",
            _token: '{{csrf_token()}}'
          },
          dataType: 'json',
          success: function (res) {
            swal({
                title: "Berhasil",
                type: "success",
                text: "Status berhasil diubah",
            });
          }
        });        
      }
    };
</script>
@endpush
