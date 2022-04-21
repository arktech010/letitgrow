<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lecturer;
use App\Models\Faculty;
use App\Models\Module;
use App\Models\Lecturer_module;
use Illuminate\Support\Facades\DB;
use DataTables;

class LecturerController extends Controller
{
    public function index()
    {
        $finalresult = [];
        $faculty = Faculty::all();

        $finalresult['faculty'] = $faculty;
        return view('form', compact('finalresult'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'phone_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|numeric|digits:10',
            'email' => 'required|unique:lecturers,email',
            'address' => 'required',
            'nationality' => 'required',
            'dob' => 'required',
            'faculty' => 'required',
        ]);

        $lecturer = new Lecturer;
        $lecturer->lecturer_name = str_replace(array( '\'', '"', ',' , ';', '<', '>', '!','?','&lt;' ), ' ',$request['name']);
        $lecturer->gender = str_replace(array( '\'', '"', ',' , ';', '<', '>', '!','?','&lt;' ), ' ',$request['gender']);
        $lecturer->phone_no = str_replace(array( '\'', '"', ',' , ';', '<', '>', '!','?','&lt;' ), ' ',$request['phone_no']);
        $lecturer->email = str_replace(array( '\'', '"', ',' , ';', '<', '>', '!','?','&lt;' ), ' ',$request['email']);
        $lecturer->address = str_replace(array( '\'', '"', ';', '<', '>', '!','?','&lt;' ), ' ',$request['address']);
        $lecturer->nationality = str_replace(array( '\'', '"', ';', '<', '>', '!','?','&lt;' ), ' ',$request['nationality']);
        $lecturer->dob = str_replace(array( '\'', '"', ';', '<', '>', '!','?','&lt;' ), ' ',$request['dob']);
        $lecturer->faculty_id = str_replace(array( '\'', '"', ';', '<', '>', '!','?','&lt;' ), ' ',$request['faculty']);
        $lecturer->save();

        foreach($request['module'] as $m)
        {
            $module = new Lecturer_module;
            $module->lecturer_id = $lecturer['id'];
            $module->module_id = $m;
            $module->save();
        }
        
        

        return redirect('/')->with('message', 'Lecturer Added Successfully!!!');

    }

    public function show()
    {
        $m=[];
        $lecturer = Lecturer::paginate(5);
        foreach($lecturer as $lecture)
        {
            $faculty = Faculty::where('id', $lecture['faculty_id'])->get()->first();
            $modules = Lecturer_module::where('lecturer_id', $lecture['id'])->get();
            
            foreach($modules as $key => $module)
            {
                $mod = Module::where('id', $module['module_id'])->get()->first();
                $m[$key] = $mod['module_name'];
                
                

            }
            $lecture['faculty'] = $faculty['faculty_name'];
            $lecture['module'] = implode(",", $m);
        }
        return view('table', compact('lecturer'));
    }


    public function export(Request $request)
    {
        $fileName = 'lecturer.csv';
        $lecturer = Lecturer::all();
        $m = [];
        foreach($lecturer as $lecture)
        {
            $faculty = Faculty::where('id', $lecture['faculty_id'])->get()->first();
            $modules = Lecturer_module::where('lecturer_id', $lecture['id'])->get();
            
            foreach($modules as $key => $module)
            {
                $mod = Module::where('id', $module['module_id'])->get()->first();
                $m[$key] = $mod['module_name'];
            }
            $lecture['faculty'] = $faculty['faculty_name'];
            $lecture['module'] = implode(",", $m);
        }
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Name', 'Gender', 'Phone_no', 'Email', 'Address', 'Nationality', 'DOB', 'Faculty', 'Modules');

        $callback = function() use($lecturer, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($lecturer as $lect) {
                $row['Name']  = $lect->lecturer_name;
                $row['Gender']    = $lect->gender;
                $row['Phone_no']    = $lect->phone_no;
                $row['Email']  = $lect->email;
                $row['Address']  = $lect->address;
                $row['Nationality']  = $lect->nationality;
                $row['DOB']  = $lect->dob;
                $row['Faculty']  = $lect->faculty;
                $row['Modules']  = $lect->module;




                fputcsv($file, array($row['Name'], $row['Gender'], $row['Phone_no'], $row['Email'], $row['Address'], $row['Nationality'], $row['DOB'], $row['Faculty'], $row['Modules']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function module($id)
    {
        $module = Module::where('faculty_id', $id)->get()->toArray();
        return $module;
    }
}
