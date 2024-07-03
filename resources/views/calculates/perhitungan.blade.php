@extends('layouts.app')
@section('title', 'Kalkulasi Hasil')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><i class="fa fa-calculator" aria-hidden="true"></i> Perhitungan</h1>

    <div class="card mb-5">
        <div class="card-header text-primary">
            <i class="fa fa-calculator" aria-hidden="true"></i>
            Perhitungan sesuai metode
        </div>
        <div class="card-body">
            <form action="{{ route('calculate.process') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="calculate_type">Metode Perhitungan</label>
                    <select name="calculate_type" id="calculate_type" required class="form-control">
                        <option value="">-- pilih metode --</option>
                        <option value="1">Metode SAW</option>
                        <option value="2">Metode SMART</option>
                    </select>
                </div>
                <button class="btn btn-primary w-100">Hitung</button>
            </form>
        </div>
    </div>

    @if($isCalculate)
        <div class="card mb-3">
            <div class="card-header text-primary">
                <i class="fa fa-table" aria-hidden="true"></i>
                Matrix Keputusan (X)
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Alternatif</th>
                            @foreach($data['criteria'] as $criteria)
                                <th class="text-center">{{ $criteria->code }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach($data['candidate'] as $candidate)
                            <tr>
                                <td class="text-center">{{$i++}}</td>
                                <td class="text-center">{{$candidate->name}}</td>
                                @foreach($candidate->rating as $rating)
                                    <td class="text-center">{{ $rating->subCriteria->value }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header text-primary">
                <i class="fa fa-table" aria-hidden="true"></i>
                Matrix Ternormalisasi (R)
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Alternatif</th>
                        @foreach($data['criteria'] as $criteria)
                            <th class="text-center">{{ $criteria->code }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @php($i = 1)
                    @foreach($data['candidate'] as $index => $candidate)
                        <tr>
                            <td class="text-center">{{$i++}}</td>
                            <td class="text-center">{{$candidate->name}}</td>
                            @foreach($result['normalize_matrix'][$index]['normal'] as $normal)
                                <td class="text-center">{{ $normal }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header text-primary">
                <i class="fa fa-table" aria-hidden="true"></i>
                Bobot kriteria (W)
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead class="bg-primary text-white">
                    <tr>
                        @foreach($data['criteria'] as $criteria)
                            <th class="text-center">{{ $criteria->code }} (@if($criteria->attribute == 1) {{"Benefit"}} @else {{"Cost"}} @endif )</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @php($i = 1)
                    @foreach($data['criteria'] as $criteria)
                        <td class="text-center">{{ $criteria->weight }}</td>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header text-primary">
                <i class="fa fa-table" aria-hidden="true"></i>
                Perhitungan Nilai (Vi)
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Alternatif</th>
                        <th class="text-center">Nilai Vi</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach($result['ranking'] as $ranking)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td class="text-center">{{ $ranking['name'] }}</td>
                                <td class="text-center">{{ $ranking['result'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@endsection
@section('custom-js')
@endsection
