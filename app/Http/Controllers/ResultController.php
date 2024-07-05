<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Criteria;
use App\Models\Rating;
use App\Models\hasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function calculateView(Request $request)
    {
        $kelas = Auth::user()->grade_id;
        $isCalculate = false;

        $dataToCalculate = DB::table('ratings')
            ->join('candidates', 'ratings.candidate_id', '=', 'candidates.id')
            ->join('sub_criteria', 'ratings.sub_criteria_id', '=', 'sub_criteria.id')
            ->join('students', 'candidates.student_id', '=', 'students.id')
            ->select('ratings.*', 'candidates.*', 'sub_criteria.*', 'sub_criteria.name as criteria_name', 'students.*')
            ->orderBy('candidates.id', 'asc')->orderBy('sub_criteria.criteria_id')
            ->get();
        if (Auth::user()->role !== 1){
            $dataToCalculate = DB::table('ratings')
                ->join('candidates', 'ratings.candidate_id', '=', 'candidates.id')
                ->join('sub_criteria', 'ratings.sub_criteria_id', '=', 'sub_criteria.id')
                ->join('students', 'candidates.student_id', '=', 'students.id')
                ->select('ratings.*', 'candidates.*', 'sub_criteria.*', 'sub_criteria.name as criteria_name', 'students.*')
                ->where('students.grade_id', $kelas)
                ->orderBy('candidates.id', 'asc')->orderBy('sub_criteria.criteria_id')
                ->get();
        }
        

        $dataToCalculate = $dataToCalculate->groupBy('candidate_id');

        return view('calculates.calculate', compact('dataToCalculate', 'isCalculate'));
    }

    public function calculate(Request $request)
    {
        $kelas = Auth::user()->grade_id;
        $data = [
            'criteria' => Criteria::all(),
            'candidates' => Candidate::with(['rating.subCriteria', 'student'])->get(),
        ];
        if (Auth::user()->role !== 1) {
            $data['candidates'] = Candidate::with(['rating.subCriteria', 'student'])
                                ->whereHas('student', function($query) use ($kelas) {
                                    $query->where('grade_id', $kelas);
                                })
                                ->get();
        }

        $isCalculate = true;

        // if ($request->calculate_type == 1) {
            $result = $this->calculateWithSAW($data);
            $this->saveResults($result['ranking'], 1);
        // } else {
        //     $result = $this->calculateWithSmart($data);
        //     $this->saveResults($result['ranking'], 2);
        // }

        return view('calculates.calculate', compact('isCalculate', 'data', 'result'));
    }

    private function calculateWithSAW($data)
    {
        $criteria = $data['criteria'];
        $candidates = $data['candidates'];

        // Normalize criteria weights
        $normalizeCrit = $criteria->map(function ($item) {
            return $item->weight / 100;
        });

        // Calculate min-max values for each criterion per candidate
        $critData = $candidates->flatMap(function ($candidate) {
            return $candidate->rating->map(function ($rating) {
                return $rating->subCriteria;
            });
        });

        $groupCrit = $critData->groupBy('criteria_id');

        $max = $groupCrit->map(function ($group) {
            return $group->max('value');
        })->values();

        $min = $groupCrit->map(function ($group) {
            return $group->min('value');
        })->values();

        // Normalize each candidate/alternative against criteria
        $normalizeCandidates = $candidates->map(function ($candidate) use ($min, $max) {
            return [
                'name' => $candidate->student->name,
                'candidate_id' => $candidate->id,
                'normal' => $candidate->rating->map(function ($rating, $index) use ($min, $max) {
                    if (isset($max[$index]) && isset($min[$index])) {
                        return $rating->subCriteria['value'] / $max[$index];
                    }
                    return null;
                })->filter()->values()
            ];
        });

        // Calculate ranking of each candidate
        $ranking = $normalizeCandidates->map(function ($candidate) use ($normalizeCrit) {
            return [
                'name' => $candidate['name'],
                'candidate_id' => $candidate['candidate_id'],
                'result' => $candidate['normal']->map(function ($normal, $index) use ($normalizeCrit) {
                    return round($normal * $normalizeCrit[$index], 4);
                })->sum()
            ];
        });

        $sortedRanking = $ranking->sortByDesc('result')->values();

        return [
            'normalize_matrix' => $normalizeCandidates,
            'ranking' => $sortedRanking->map(function ($item, $index) {
                return [
                    'name' => $item['name'],
                    'candidates_id' => $item['candidate_id'],
                    'rank' => $index + 1,
                    'score' => $item['result']
                ];
            })
        ];
    }

    // private function calculateWithSmart($data)
    // {
    //     $criteria = $data['criteria'];
    //     $candidates = $data['candidates'];

    //     // Normalize criteria weights
    //     $normalizeCrit = $criteria->map(function ($item) {
    //         return $item->weight / 100;
    //     });

    //     // Calculate min-max values for each criterion per candidate
    //     $critData = $candidates->flatMap(function ($candidate) {
    //         return $candidate->rating->map(function ($rating) {
    //             return $rating->subCriteria;
    //         });
    //     });

    //     $groupCrit = $critData->groupBy('criteria_id');

    //     $max = $groupCrit->map(function ($group) {
    //         return $group->max('value');
    //     })->values();

    //     $min = $groupCrit->map(function ($group) {
    //         return $group->min('value');
    //     })->values();

    //     // Normalize each candidate/alternative against criteria
    //     $normalizeCandidates = $candidates->map(function ($candidate) use ($min, $max) {
    //         return [
    //             'name' => $candidate->student->name,
    //             'candidate_id' => $candidate->id,
    //             'normal' => $candidate->rating->map(function ($rating, $index) use ($min, $max) {
    //                 if (isset($max[$index]) && isset($min[$index])) {
    //                     return (($rating->subCriteria['value'] - $min[$index]) / ($max[$index] - $min[$index]));
    //                 }
    //                 return null;
    //             })->filter(function ($value) {
    //                 return !is_null($value);
    //             })->values()
    //         ];
    //     });

    //     // Calculate ranking of each candidate
    //     $ranking = $normalizeCandidates->map(function ($candidate) use ($normalizeCrit) {
    //         return [
    //             'name' => $candidate['name'],
    //             'candidate_id' => $candidate['candidate_id'],
    //             'result' => $candidate['normal']->map(function ($normal, $index) use ($normalizeCrit) {
    //                 return round($normal * $normalizeCrit[$index], 4);
    //             })->sum()
    //         ];
    //     });

    //     $sortedRanking = $ranking->sortByDesc('result')->values();

    //     return [
    //         'normalize_matrix' => $normalizeCandidates,
    //         'ranking' => $sortedRanking->map(function ($item, $index) {
    //             return [
    //                 'name' => $item['name'],
    //                 'candidates_id' => $item['candidate_id'],
    //                 'rank' => $index + 1,
    //                 'score' => $item['result']
    //             ];
    //         })
    //     ];
    // }

    private function saveResults($results, $category)
    {
        hasil::where('category', $category)->delete();

        $resultInsertData = collect($results)->map(function ($item) use ($category) {
            return [
                'candidates_id' => $item['candidates_id'],
                'category' => $category,
                'rank' => $item['rank'],
                'score' => $item['score']
            ];
        })->toArray();

        hasil::insert($resultInsertData);
    }
}

