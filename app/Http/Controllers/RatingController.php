<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Criteria;
use App\Models\Rating;
use App\Models\Student;
use App\Models\SubCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RatingController extends Controller
{
    public function view()
    {   $studentData=Student::get();
        $candidateData = Candidate::with('rating.subCriteria')->get();
        $criteriaData = Criteria::with('subCriteria')->get();
        $subCriteriaData = SubCriteria::all();

        return view('rating.rating', compact('candidateData','studentData', 'criteriaData','subCriteriaData'));
    }
    public function add(Rating $rating,Candidate $candidate, SubCriteria $subCriteria, Request $request,)
    {


         // create candidate
        $data = [
            'student_id' => $request->student_id
        ];

        $imagePath = null; // Inisialisasi $imagePath dengan nilai null
        if ($request->hasFile('gambar_kriteria_prestasi')) {
            $file = $request->file('gambar_kriteria_prestasi');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            $file->move(public_path('images'), $fileName);
            $imagePath = 'images/' . $fileName; // Simpan path relatif
        }
        $data['gambar_kriteria'] = $imagePath;

        $candidateID = $candidate->create($data);

        $nilaiAkademik = floatval($request->criteria_c1);
        $nilaiAkademikHuruf = '';
        if ($nilaiAkademik > 90) {
            $nilaiAkademikHuruf = 'A';
        } elseif ($nilaiAkademik > 75 && $nilaiAkademik <= 90) {
            $nilaiAkademikHuruf = 'B';
        } elseif ($nilaiAkademik >= 60 && $nilaiAkademik <= 75) {
            $nilaiAkademikHuruf = 'C';
        } else {
            $nilaiAkademikHuruf = 'D';
        }

        $subCriteriaResult = $subCriteria->where('name', $nilaiAkademikHuruf)->where('criteria_id', 1)->first();
        // create rating
        $ratingData = collect($request->sub_criteria_id)->map(function($item) use ($candidateID) {
            return [
                'sub_criteria_id' => $item,
                'candidate_id' => $candidateID->id
            ];
        })->toArray();

        array_push($ratingData, [
            'sub_criteria_id' => $subCriteriaResult->id,
            'candidate_id' => $candidateID->id
        ]);

        $rating->insert($ratingData);
        return redirect()->route('rating.view');
    }
    public function edit(Rating $rating,Candidate $candidate ,Request $request){

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

        return redirect()->route('rating.view');
    }
    public function delete(Candidate $candidate, Request $request){
        $candidate->delete();
        return redirect()->route('rating.view');
    }


}
