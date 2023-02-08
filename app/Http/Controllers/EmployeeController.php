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
            'name'              => 'string',
            'nip'               => 'unique:employees,nip',
            'phone_number'      => 'numeric',
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
    
            return redirect()->route('employee.index')->with('success', 'Created successfully!');
        } catch (\Exception $e){
            return redirect()->route('employee.index')->with('error', 'Error during the creation!');
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
        //
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
            'name'              => 'string',
            'phone_number'      => 'numeric',
            'id_card_photo'     => 'image|mimes:png,jpg',
        ]);

        // $employee = Employee::findOrFail($employee->id);

        
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
            // $image = $request->file('id_card_photo');
            $fileName = $request->file('id_card_photo')->hashName();  

            $type = $request->id_card_photo->getClientMimeType();
            $size = $request->id_card_photo->getSize();
    
            $request->id_card_photo->move(public_path('upload'), $fileName);

            // $image->storeAs('public/upload', $image->hashName());

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
        return redirect()->route('employee.index')->with('success', 'Updated successfully!');
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

        return redirect()->route('employee.index');
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
