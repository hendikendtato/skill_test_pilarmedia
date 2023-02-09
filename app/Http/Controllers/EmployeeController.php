<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFileRequest;
use RealRashid\SweetAlert\Facades\Alert;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::join('positions', 'positions.id', '=', 'employees.position_id')->get(['employees.*','positions.name AS jabatan']);
        
        // if(request()->ajax()) {
        //     return datatables($employees)
        //         ->addIndexColumn()
        //         ->toJson();
        // }
        return view('employee', [
            "employees" => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Position::all();
        return view('employee_add', [
            "positions" => $positions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required|string',
            'nip'               => 'required|unique:employees,nip',
            'department'        => 'required',
            'birth_date'        => 'required',
            'birth_year'        => 'required',
            'address'           => 'required',
            'religion'          => 'required',
            'status'            => 'required',
            'phone_number'      => 'required|numeric',
            'id_card_photo'     => 'required|image|mimes:png,jpg',
        ]);

        try{
            $fileName = $request->file('id_card_photo')->hashName();  
    
            $type = $request->id_card_photo->getClientMimeType();
            $size = $request->id_card_photo->getSize();
    
            $request->id_card_photo->move(public_path('upload'), $fileName);
    
            Employee::create([
                'name'          => $request->name,
                'nip'           => $request->nip,
                'birth_date'    => $request->birth_date,
                'birth_year'    => $request->birth_year,
                'position_id'   => $request->position,
                'department'    => $request->department,
                'phone_number'  => $request->phone_number,
                'religion'      => $request->religion,
                'id_card_photo' => $fileName,
                'status'        => $request->status,
                'address'       => $request->address
            ]);
    
            return redirect()->route('employee.index')->with('success', 'Berhasil Tambah Data');
        } catch (\Exception $e){
            return redirect()->route('employee.index')->with('error', 'Gagal Tambah Data');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $employees = Employee::join('positions', 'positions.id', '=', 'employees.position_id')
            ->where('employees.id', $employee->id)
            ->first(['employees.*','positions.name AS jabatan']);

        return view('employee_view', [
            "employees" => $employees
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $positions = Position::all();
        return view('employee_edit', [
            'employees' => compact('employee'),
            "positions" => $positions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $this->validate($request, [
            'name'              => 'required|regex:/^[\pL\s]+$/u|min:3',
            'phone_number'      => 'numeric',
            'id_card_photo'     => 'image|mimes:png,jpg',
        ]);
        
        if($request->file('id_card_photo') == "") {
            
            Employee::where('id', $employee->id)
                    ->update([
                        'name'          => $request->name,
                        'nip'           => $request->nip,
                        'birth_date'    => $request->birth_date,
                        'birth_year'    => $request->birth_year,
                        'position_id'   => $request->position,
                        'department'    => $request->department,
                        'phone_number'  => $request->phone_number,
                        'religion'      => $request->religion,
                        'status'        => $request->status,
                        'address'       => $request->address
                    ]);

        } else {
            //hapus old image
            Storage::disk('local')->delete('upload'.$employee->id_card_photo);
            
            //upload image
            $fileName = $request->file('id_card_photo')->hashName();  

            $type = $request->id_card_photo->getClientMimeType();
            $size = $request->id_card_photo->getSize();
    
            $request->id_card_photo->move(public_path('upload'), $fileName);

            Employee::where('id', $employee->id)
                    ->update([
                        'name'          => $request->name,
                        'nip'           => $request->nip,
                        'birth_date'    => $request->birth_date,
                        'birth_year'    => $request->birth_year,
                        'position_id'   => $request->position,
                        'department'    => $request->department,
                        'phone_number'  => $request->phone_number,
                        'religion'      => $request->religion,
                        'id_card_photo' => $fileName,
                        'status'        => $request->status,
                        'address'       => $request->address
                    ]);
        }
        return redirect()->route('employee.index')->with('success', 'Berhasil Update Data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        Employee::where('id', $employee->id)->delete();

        return redirect()->route('employee.index')->with('success', 'Berhasil Hapus Data');
    }

    public function update_status(Request $request, Employee $employee)
    {
        Employee::where('id', $request->id)
            ->update([
                'status' => $request->status
            ]);
        
        return response()->json(['status' => 'Success']);
    }
}
