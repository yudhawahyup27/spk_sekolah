<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    // View all grades and semesters
    public function view()
    {
        $gradeData = DB::table('grades')->get();
        $semester = DB::table('semester')->get();
        return view('group.groupView', compact('gradeData', 'semester'));
    }

    // View form to add a new grade
    public function viewAddGrade()
    {
        return view('group.grade.add-grade');
    }

    // Add a new grade
    public function addGrade(Request $request)
    {
        DB::table('grades')->insert($request->only(['name', 'description'])); // Adjust columns as needed
        return redirect(route('group.view'))->with('success', 'Data kelas berhasil ditambahkan');
    }

    // View form to edit an existing grade
    public function viewEditGrade($id)
    {
        $grade = DB::table('grades')->where('id', $id)->first();
        return view('group.grade.edit-grade', compact('grade'));
    }

    // Edit an existing grade
    public function editGrade(Request $request, $id)
    {
        DB::table('grades')->where('id', $id)->update($request->only(['name', 'description'])); // Adjust columns as needed
        return redirect(route('group.view'))->with('success', 'Data kelas berhasil diubah');
    }

    // Delete an existing grade
    public function deleteGrade($id)
    {
        DB::table('grades')->where('id', $id)->delete();
        return redirect(route('group.view'))->with('success', 'Data kelas berhasil dihapus');
    }

    // View form to add a new semester
    public function viewAddYear()
    {
        return view('group.year.add-year');
    }

    // Add a new semester
    public function addY(Request $request)
    {
        DB::table('semester')->insert(['semester' => $request->semester]);

        return redirect(route('group.view'))->with('success', 'Data semester berhasil ditambahkan');
    }

    // View form to edit an existing semester
    public function viewEditYear($id)
    {
        $semester = DB::table('semester')->where('id', $id)->first();
        return view('group.year.edit-year', compact('semester'));
    }

    // Edit an existing semester
    public function editY(Request $request, $id)
    {
        DB::table('semester')->where('id', $id)->update($request->only(['semester', 'description'])); // Adjust columns as needed
        return redirect(route('group.view'))->with('success', 'Data semester berhasil diubah');
    }

    // Delete an existing semester
    public function deletey($id)
    {
        DB::table('semester')->where('id', $id)->delete();
        return redirect(route('group.view'))->with('success', 'Data semester berhasil dihapus');
    }
}
