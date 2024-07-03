<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Http\Request;

class SubCriteriaController extends Controller
{
    public function view()
    {
        $criteriaData = Criteria::with('subCriteria')->get();
        return view('subcriteria.subcriteria', compact('criteriaData'));
    }

    public function add(SubCriteria $subCriteria, Request $request)
    {
        $subCriteria->create($request->all());
        return redirect()->route('subcriteria.view');
    }

    public function  subCriteriaedit(SubCriteria $subCriteria, Request $request)
    {
        $subCriteria->update($request->all());
        return redirect()->route('subcriteria.view');
    }

    public function subCriteriaDelete(SubCriteria $subCriteria, Request $request)
    {
        $subCriteria->delete();
        return redirect()->route('subcriteria.view');
    }
}
