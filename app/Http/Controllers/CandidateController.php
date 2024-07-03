<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Criteria;
use App\Models\Rating;
use App\Models\Student;
use App\Models\SubCriteria;
use Illuminate\Http\Request;

class CandidateController extends Controller
{ public function candidateView()
    {
        $studentData=Student::get();
        $candidateData = Candidate::with('rating.subCriteria.criteria')->get();
        $criteriaData = Criteria::with('subCriteria')->get();
        $subCriteriaData = SubCriteria::all();
        return view('candidate.candidate', compact('candidateData', 'studentData','criteriaData', 'subCriteriaData'));
    }

    public function candidateAdd(Request $request, Candidate $candidate, Rating $rating)
    {
        // create candidate
        $data = [
            'student_id' => $request->student_id
        ];
        $candidateID = $candidate->create($data);

        // create rating
        $ratingData = collect($request->sub_criteria_id)->map(function($item) use ($candidateID) {
            return [
                'sub_criteria_id' => $item,
                'candidate_id' => $candidateID->id
            ];
        })->toArray();

        $rating->insert($ratingData);


        return redirect()->route('candidate.view');

    }

    public function candidateEdit(Rating $rating, Candidate $candidate, Request $request)
    {
        $data = [
          'student_id' => $request->student_id
        ];

        $candidateID = $candidate->id;

        $candidate->update($data);

        $rating->where('candidate_id', $candidateID)->delete();

        // recreate rating data
        // create rating
        $ratingData = collect($request->sub_criteria_id)->map(function($item) use ($candidateID) {
            return [
                'sub_criteria_id' => $item,
                'candidate_id' => $candidateID
            ];
        })->toArray();

        $rating->insert($ratingData);


        return redirect()->route('candidate.view');
    }

    public function candidateDelete(Candidate $candidate, Request $request)
    {
        $candidate->delete();

        return redirect()->route('candidate.view');
    }

    //
}
