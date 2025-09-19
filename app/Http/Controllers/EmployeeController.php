<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeesImport;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function AllEmployee()
    {
        return view('backend.employee.all_employee');
    }

    public function GetEmployee(Request $request){

        if ($request->ajax()) {
            $data = Employee::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){


                      return   '<div class="d-flex align-items-center justify-content-between flex-wrap">
                      <div class="d-flex align-items-center">
                        
                          <div class="d-flex align-items-center">
                              <div class="actions dropdown">
                                  <a href="#" data-bs-toggle="dropdown"> ••• </a>
                                  <div class="dropdown-menu" role="menu">
                                    
                                  
                                          <a href="javascript:void(0)"
                                              class="dropdown-item editEmployee" data-id="'.$row->id.'"> &nbsp; Edit</a>
                                   
                          
                                          <a href="javascript:void(0)"
                                              class="dropdown-item text-danger deleteEmployee"
                                           data-id="'.$row->id.'"> &nbsp; Delete</a>
                                   

                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>';

                    })

                    // ->addColumn('qr_code', function($row){ return QrCode::size(30)->generate($row->nik);})

                    ->rawColumns(['action'])

                    ->make(true);
                 

        }

    }

    public function CheckEmployee(Request $request)

    {

        $nik = $request->input('nik');
        $user = Employee::where('nik',$nik)->first();

        if ($user) {        
            return response()->json($user);
        } else {
            return response()->json(['nama' => 'NIK tidak ditemukan']);
        }

        // return response()->json($user);

    }

    public function GetEmployeeCount()
    {
        // Hitung jumlah total karyawan
        $employeeCount = Employee::count();

        // Return the total employee count as a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Total employee count retrieved successfully',
            'data' => [
                'employee_count' => $employeeCount
            ]
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function StoreEmployee(Request $request)
    {
        if( $request->employee_id == ""){

            $request->validate([
                'nik' => 'required|unique:employees|integer',
                'name' => 'required',
                'department' => 'required',
    
            ]);

            $post = Employee::updateOrCreate([

   
                'id' => $request->employee_id
        
                 ],[
                    'nik' => $request->nik,
                    'name' => $request->name,
                    'department' => $request->department,
        
                ]);
        
        
                //return response
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Disimpan!',
                    'data'    => $post,
                    'alert-type' => 'success'  
                ]);
    

        }
        else{
            $request->validate([
                'nik' => 'required',
                'name' => 'required',
                'department' => 'required',
    
            ]);

            $post = Employee::updateOrCreate([

   
                'id' => $request->employee_id
        
                 ],[
                    'nik' => $request->nik,
                    'name' => $request->name,
                    'department' => $request->department,
        
                ]);
        
        
                //return response
                return response()->json([
                    'success' => true,
                    'message' => 'Data Berhasil Disimpan!',
                    'data'    => $post,
                    'alert-type' => 'success'  
                ]);
    
        }
      
    }

    public function ImportEmployees()
    {
        return view('backend.employee.import_employee');
    }


    public function ImportEmployee(Request $request)
    {
        $cek = Excel::import(new EmployeesImport, $request->file('import_file'));

    
            $notification = array(
                'message' => 'Import Successfully',
                'alert-type' => 'success'
            );
   
    
        return redirect()->route('all.employee')->with($notification);
    } //end method

    /**
     * Display the specified resource.
     */
    // public function show(Employee $employee)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function EditEmployee($id)
    {
        $employees = Employee::find($id);
        return response()->json($employees);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */


     public function DeleteEmployee($id)
     {
         Employee::findOrFail($id)->delete();
         return response()->json([
             'success' => true,
             'message' => 'Data Post Berhasil Dihapus!.',
         ]);
     }



    public function destroy(Employee $employee)
    {
        //
    }






    public function exportPDF()
{
    $employees = Employee::all();

    // $this->generateQrCodeUrls($employees);

    foreach ($employees as $employee) {
        $qrCode = QrCode::size(100)->generate($employee->nik);
        $employee->qr_code = $qrCode;

    }

    // $pdf = PDF::loadView('backend.employee.pdf', compact('employees'));

    // return $pdf->download('employee_report.pdf');



    return view('backend.employee.pdf', compact('employees'));
}
}
