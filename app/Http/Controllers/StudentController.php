<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function viewImport()
    {
        return view('student.import');
    }

    public function view()
    {
        $kelas = Auth::user()->grade_id;
        $semester = DB::table('semester')->get();  // Assuming 'years' table contains semester information
        $studentData = DB::table('students')
            ->join('grades', 'students.grade_id', '=', 'grades.id')
            ->join('semester', 'students.year_id', '=', 'semester.id')
            ->select('students.*', 'grades.grade', 'semester.semester')
            ->get();
        if (Auth::user()->role !== 1){
            $studentData = DB::table('students')
                ->join('grades', 'students.grade_id', '=', 'grades.id')
                ->join('semester', 'students.year_id', '=', 'semester.id')
                ->select('students.*', 'grades.grade', 'semester.semester')
                ->where('students.grade_id', $kelas)
                ->get();
        }

        return view('student.student', compact('studentData', 'semester'));
    }
    public function viewAdd()
    {
        $gradeData = Grade::all();
        $semester =  DB::table('semester')->get();
        return view('student.add-student', compact('gradeData', 'semester'));
    }

    public function add(Request $request)
    {
        // Validasi input
        $request->validate([
            'code' => 'required|digits:10', // Validasi 10 angka
            'name' => 'required|string|max:255',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'grade_id' => 'required|exists:grades,id',
            'year_id' => 'required|exists:semester,id',
        ]);

        Student::create($request->all());
        return redirect(route('student.view'))->with('success', 'Data user berhasil ditambahkan');
    }

    public function viewEdit(Student $student)
    {
        $gradeData = Grade::all();
        $semester =  DB::table('semester')->get();
        return view('student.edit-student', compact('student', 'gradeData', 'semester'));
    }

    public function edit(Student $student, Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'code' => 'required|digits:10', // Validasi 10 angka
            'name' => 'required|string|max:255',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'grade_id' => 'required|exists:grades,id',
            'year_id' => 'required|exists:semester,id',
        ]);

        $student->update($validatedData);
        return redirect(route('student.view'))->with('success', 'Data user berhasil diubah');
    }

    public function delete(Student $student)
    {
        $student->delete();
        return redirect(route('student.view'))->with('success', 'Data user berhasil dihapus');
    }

    public function importStudent(Request $request)
    {
        $request->validate([
            'user_excel' => 'required|mimes:xls,xlsx',
        ]);

        $file = $request->file('user_excel');
        $data = Excel::toArray([], $file);
        $rows = $data[0];

        // Menampilkan hasil
        echo '<pre>';
        var_dump($rows);
        echo '</pre>';

        // Uncomment the following lines to process each row
        // foreach ($rows as $row) {
        //     Student::create([
        //         'code' => $row['code'],
        //         'name' => $row['name'],
        //         'gender' => $row['gender'],
        //         'grade_id' => $row['grade_id'],
        //         'year_id' => $row['year_id'],
        //     ]);
        // }
    }
}

