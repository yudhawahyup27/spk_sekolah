<!-- resources/views/calculates/calculate.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Calculation Results</h1>

        @if ($isCalculate)
            <h2>SAW Calculation</h2>
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

            <h2>Normalized Matrix</h2>
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
                    @foreach ($result['normalize_matrix'] as $candidate)
                        <tr>
                            <td>{{ $candidate['name'] }}</td>
                            @foreach ($candidate['normal'] as $value)
                                <td>{{ round($value, 4) }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No calculation performed yet.</p>
        @endif
    </div>
@endsection
