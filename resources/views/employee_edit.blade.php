@extends('layout.app')

@section('css')
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Karyawan</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Karyawan</li>
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
        <form action="{{ route('employee.update', $employees['employee']->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
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
                        <input type="text" class="form-control" name="name" value="{{ old('name', $employees['employee']->name) }}" placeholder="Masukkan Nama Karyawan">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">NIP</label>
                        <input type="text" class="form-control" name="nip" value="{{ old('nip', $employees['employee']->nip) }}" placeholder="Masukkan NIP">
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="birth_date" value="{{ old('birth_date', $employees['employee']->birth_date) }}" placeholder="Masukkan Tanggal Lahir">
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
                            <option value="{{ $jabatan['id'] }}" {{ ($jabatan['id'] === old('position_id', $employees['employee']->position_id)) ? 'selected' : ''  }}>{{ $jabatan['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Departemen</label>
                        <input type="text" class="form-control" name="department" value="{{ old('department', $employees['employee']->department) }}" placeholder="Masukkan Departemen">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Nomor Telepon</label>
                        <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number', $employees['employee']->phone_number) }}" placeholder="Masukkan Nomor Telepon">
                    </div>          
                    <div class="form-group">
                        <label class="font-weight-bold">Foto KTP</label>
                        <input type="file" class="form-control" name="id_card_photo">
                    </div>          
                    <div class="form-group">
                        <label class="font-weight-bold">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">Pilih Status</option>
                            <option value="1" {{ (old('status', $employees['employee']->status == '1')) ? 'selected' : ''  }}>Aktif</option>
                            <option value="0" {{ (old('status', $employees['employee']->status == '0')) ? 'selected' : ''  }}>Tidak Aktif</option>
                        </select>
                    </div>          
                </div>
                <div class="col-md-12">
                    <label class="font-weight-bold">Agama</label><br>                    
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="religion" id="inlineRadio1" value="Islam" {{ (old('religion', $employees['employee']->religion == 'Islam')) ? 'checked' : ''  }}/>
                        <label class="form-check-label" for="inlineRadio1">Islam</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="religion" id="religion" value="Kristen" {{ (old('religion', $employees['employee']->religion == 'Kristen')) ? 'checked' : ''  }}/>
                        <label class="form-check-label" for="religion">Kristen</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="religion" id="religion" value="Katolik" {{ (old('religion', $employees['employee']->religion == 'Katolik')) ? 'checked' : ''  }}/>
                        <label class="form-check-label" for="religion">Katolik</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="religion" id="religion" value="Hindu" {{ (old('religion', $employees['employee']->religion == 'Hindu')) ? 'checked' : ''  }}/>
                        <label class="form-check-label" for="religion">Hindu</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="religion" id="religion" value="Budha" {{ (old('religion', $employees['employee']->religion == 'Budha')) ? 'checked' : ''  }}/>
                        <label class="form-check-label" for="religion">Budha</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="religion" id="religion" value="Konghucu" {{ (old('religion', $employees['employee']->religion == 'Konghucu')) ? 'checked' : ''  }}/>
                        <label class="form-check-label" for="religion">Konghucu</label>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Alamat</label>
                        <textarea name="address" class="form-control" id="address" rows="5">{{ old('address', $employees['employee']->address) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
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

        var year_value = {{ old('name', $employees['employee']->birth_year) }};
 
        //Determine the Current Year.
        var currentYear = (new Date()).getFullYear();
 
        //Loop and add the Year values to DropDownList.
        for (var i = 1950; i <= currentYear; i++) {
            var option = document.createElement("OPTION");
            option.innerHTML = i;
            option.value = i;
            if(year_value == i){
                option.selected = true;
            } else {
                option.selected = false;
            }
            ddlYears.appendChild(option);
        }
    };
</script>
@endpush
