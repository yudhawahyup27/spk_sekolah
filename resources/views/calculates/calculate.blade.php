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
                    @foreach ($result['normalize_matrix'] as $matrix)
                        <tr>
                            <td>{{ $matrix['name'] }}</td>
                            @foreach ($matrix['normal'] as $normal)
                                <td>{{ $normal }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <form method="POST" action="{{ route('calculate.process') }}">
                @csrf
                <div class="form-group">
                    <label for="calculate_type">Calculation Type:</label>
                    <select class="form-control" id="calculate_type" name="calculate_type">
                        <option value="1">SAW</option>
                        <option value="2">SMART</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Calculate</button>
            </form>
        @endif
    </div>
@endsection
