<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Year;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function view(Grade $grade, Year $year)
    {
        $gradeData = $grade->get();
        $yearData = $year->get();
        return view('group.groupView', compact('gradeData', 'yearData'));
    }
    public function viewAddGrade()
    {
        return view('group.grade.add-grade');
    }
    public function addG(Grade $grade, Request $gradeRequest)
    {
        $data = $gradeRequest->all();
        $grade->create($data);
        return redirect(route('group.view'))->with('success', 'Data kelas berhasil ditambahkan');
    }
    public function viewEditGrade(Grade $grade)
    {

        return view('group.grade.edit-grade', compact('grade'));
    }
    public function editG(Grade $grade, Request $Request)
    {
        $data = $Request->all();
        $grade->update($data);
        return redirect(route('group.view'))->with('success', 'Data kelas berhasil diubah');
    }
    public function deleteG(Grade $grade)
    {
        $grade->delete();
        return redirect(route('group.view'))->with('success', 'Data kelas berhasil dihapus');
    }
    public function viewAddYear()
    {
        return view('group.year.add-year');
    }
    public function addY(Year $year, Request $yearRequest)
    {
        $data = $yearRequest->all();
        $year->create($data);
        return redirect(route('group.view'))->with('success', 'Data kelas berhasil ditambahkan');
    }
    public function viewEditYear(Year $year)
    {

        return view('group.year.edit-year', compact('year'));
    }
    public function editY(Year $year, Request $Request)
    {
        $data = $Request->all();
        $year->update($data);
        return redirect(route('group.view'))->with('success', 'Data kelas berhasil diubah');
    }
    public function deletey(Year $year)
    {

        $year->delete();
        return redirect(route('group.view'))->with('success', 'Data Angkatan berhasil dihapus');
    }
}
