<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Year;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function viewImport()
    {
        return view('student.import');
    }

    // public function import(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,xls,csv',
    //     ]);

    //     Excel::import(new StudentsImport, $request->file('file'));

    //     return redirect(route('student.view'))->with('success', 'Data berhasil diimpor');
    // }

    public function view(Student $student)
    {

        $studentData = Student::with(['grade', 'year'])->get();
        return view('student.student', compact('studentData'));
    }

    public function viewAdd(Grade $grade, Year $year)
    {
        $gradeData = $grade->get();
        $yearData = $year->get();
        return view('student.add-student', compact('gradeData', 'yearData'));
    }
    public function add(Student $student, Request $request)
    {
        // Validasi input
        $request->validate([
            'code' => 'required|digits:10', // Validasi 10 angka
            'name' => 'required|string|max:255',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'grade_id' => 'required|exists:grades,id',
            'year_id' => 'required|exists:years,id',
        ]);

        $data = $request->all();
        $student->create($data);

        return redirect(route('student.view'))->with('success', 'Data user berhasil ditambahkan');
    }
    public function viewEdit(Student $student,Grade $grade, Year $year, Request $request)
    {

        $gradeData = $grade->get();
        $yearData = $year->get();
        return view('student.edit-student', compact('student','gradeData', 'yearData'));
    }
    public function edit(Student $student, Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|digits:10', // Validasi 10 angka
            'name' => 'required|string|max:255',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'grade_id' => 'required|exists:grades,id',
            'year_id' => 'required|exists:years,id',
        ]);
        $student->update($validatedData);
        return redirect(route('student.view'))->with('success', 'Data user berhasil diubah');
    }
    public function delete(Student $student)
    {
        $student->delete();
        return redirect(route('student.view'))->with('success', 'Data user berhasil diubah');
    }
    public function importStudent(Request $request){

        $request->validate([
            'user_excel' => 'required|mimes:xls,xlsx',
        ]);

        $file = $request->file('user_excel');

        $data = Excel::toArray([], $file);
        
        // Mengambil sheet pertama
        $rows = $data[0];

        // Menampilkan hasil
        echo '<pre>';
        var_dump($rows);
        echo '</pre>';

        // foreach ($excel_data as $key => $value) {
        //     echo '<pre>';
        //     print_r($value);
        //     echo '</pre>';
        // }

    }
}
