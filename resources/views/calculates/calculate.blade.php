<!-- resources/views/calculates/calculate.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Calculation Process</h1>
        <form method="POST" action="{{ route('calculate.process') }}">
            @csrf
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <select class="form-control" id="calculate_type" name="calculate_type">
                            <option value="1">SAW</option>
                        </select>
                    </div>
                </div>
                <div class="col"></div>
                <div class="col-3">
                    <button type="submit" class=" float-end btn btn-primary">Calculate</button>
                </div>
            </div>
        </form>

        <div class="mb-3"></div>

        <h3>Calculation Result</h3>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Candidate Id</th>
                    <th class="text-center">Candidate Name</th>
                    <th class="text-center">Nilai Akademik (C1)</th>
                    <th class="text-center">Nilai Ekstrakulikuler(C2)</th>
                    <th class="text-center">Prestasi (C3)</th>
                    <th class="text-center">Absen Kehadiran (C4)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataToCalculate as $dt)
                    <tr>
                        <td class="text-center">{{ $dt[0]->candidate_id}}</td>
                        <td class="text-center">{{ $dt[0]->name}}</td>
                        @foreach ($dt as $k => $d)
                            <td class="text-center">{{ $k === 0 ? $d->nilai_akademik : $d->value }} ({{ $d->criteria_name }})</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mb-3"></div>
        @if ($isCalculate)
            <h3>Normalization Result</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Candidate Name</th>
                        @foreach ($data['criteria'] as $criterion)
                            <th>{{ $criterion->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result['normalize_matrix'] as $matrix)
                        <tr>
                            <td>{{ $matrix['name'] }}</td>
                            @foreach ($matrix['normalized_data'] as $normal)
                                <td>{{ $normal }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mb-3"></div>
            <h3>Accumulation Result</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Candidate Name</th>
                        @foreach ($data['criteria'] as $criterion)
                            <th>{{ $criterion->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result['normalize_matrix'] as $matrix)
                        <tr>
                            <td>{{ $matrix['name'] }}</td>
                            @foreach ($matrix['akumulasi_data'] as $normal)
                                <td>{{ $normal }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mb-3"></div>
            <h3>Rangking</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Candidate Name</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result['ranking'] as $ranking)
                        <tr>
                            <td>{{ $ranking['rank'] }}</td>
                            <td>{{ $ranking['name'] }}</td>
                            <td>{{ $ranking['score'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            
            
        @endif
    </div>
@endsection
