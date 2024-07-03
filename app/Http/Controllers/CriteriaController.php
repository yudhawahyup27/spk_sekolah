<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    //
    public function view(Criteria $criteria)
    {
        $criteriaData = $criteria->get();
        return view('criteria.criteria', compact('criteriaData'));
    }

    public function viewAdd()
    {
        return view('criteria.add-criteria');
    }
    public function add(Criteria $criteria, Request $criteriaRequest)
    {
        $data = $criteriaRequest->all();
        $criteria->create($data);
        return redirect(route('criteria.view'))->with('success', 'Data kelas berhasil ditambahkan');
    }
    public function viewEdit(Criteria $criteria)
    {
        return view('criteria.edit-criteria', compact('criteria'));
    }
    public function edit(Criteria  $criteria, Request $Request)
    {
        $data = $Request->all();
        $criteria->update($data);
        return redirect(route('criteria.view'))->with('success', 'Data criteria berhasil diubah');
    }
    public function delete(Criteria $criteria)
    {
        $criteria->delete();
        return redirect(route('criteria.view'))->with('success', 'Data kelas berhasil dihapus');
    }
}
