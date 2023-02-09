@extends('layout.app')

@section('css')
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Karyawan</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('employee.index') }}">Karyawan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add</li>
    </ol>
</div>
@endsection
@section('content')
<div class="card sm mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
    </div>
    <div class="card-body">
        <form action="{{ route('employee.store') }}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="row">
                <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Karyawan</label>
                        <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Karyawan">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">NIP</label>
                        <input type="text" class="form-control" name="nip" placeholder="Masukkan NIP">
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="birth_date" placeholder="Masukkan Tanggal Lahir">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Tahun Lahir</label>
                        <select class="form-control" name="birth_year" id="ddlYears">
                            <option value="">Pilih Tahun</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Jabatan</label>
                        <select class="form-control" name="position" id="position">
                            <option value="">Pilih Jabatan</option>
                            @foreach($positions AS $jabatan)
                            <option value="{{ $jabatan['id'] }}">{{ $jabatan['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Departemen</label>
                        <input type="text" class="form-control" name="department" placeholder="Masukkan Departemen">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Nomor Telepon</label>
                        <input type="text" class="form-control" name="phone_number" placeholder="Masukkan Nomor Telepon">
                    </div>          
                    <div class="form-group">
                        <label class="font-weight-bold">Foto KTP</label>
                        <input type="file" class="form-control" name="id_card_photo">
                    </div>          
                    <div class="form-group">
                        <label class="font-weight-bold">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">Pilih Status</option>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>          
                </div>
                <div class="col-md-12">
                    <label class="font-weight-bold">Agama</label><br>                    
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="religion" id="inlineRadio1" value="Islam" />
                        <label class="form-check-label" for="inlineRadio1">Islam</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="religion" id="religion" value="Kristen" />
                        <label class="form-check-label" for="religion">Kristen</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="religion" id="religion" value="Katolik" />
                        <label class="form-check-label" for="religion">Katolik</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="religion" id="religion" value="Hindu" />
                        <label class="form-check-label" for="religion">Hindu</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="religion" id="religion" value="Budha" />
                        <label class="form-check-label" for="religion">Budha</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="religion" id="religion" value="Konghucu" />
                        <label class="form-check-label" for="religion">Konghucu</label>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Alamat</label>
                        <textarea name="address" class="form-control" id="address" rows="5"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <a href="{{ route('employee.index') }}" class="btn btn-md btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-md btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#position').select2();
        $('#ddlYears').select2();
    });
</script>
<script type="text/javascript">
    window.onload = function () {
        //Reference the DropDownList.
        var ddlYears = document.getElementById("ddlYears");
 
        //Determine the Current Year.
        var currentYear = (new Date()).getFullYear();
 
        //Loop and add the Year values to DropDownList.
        for (var i = currentYear; i >= 1950; i--) {
            var option = document.createElement("OPTION");
            option.innerHTML = i;
            option.value = i;
            ddlYears.appendChild(option);
        }
    };
</script>
@endpush
