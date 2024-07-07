<!-- resources/views/calculates/calculate.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Hasil Perhitungan</h1>
        <table id="result_table" class="display table table-bordered table-sm" style="width:100%">
            <thead class="bg-primary" style="color: white">
                <tr>
                    <th class="text-center align-middle">Ranking</th>
                    <th class="text-center align-middle">Candidate Id</th>
                    <th class="text-center align-middle">Candidate Name</th>
                    <th class="text-center align-middle">Nilai Akademik (C1)</th>
                    <th class="text-center align-middle">Nilai Ekstrakulikuler(C2)</th>
                    <th class="text-center align-middle">Prestasi (C3)</th>
                    <th class="text-center align-middle">Absen Kehadiran (C4)</th>
                    <th class="text-center align-middle">Skor Akhir</th>
                    <th class="text-center align-middle">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $index = 1 ?>
                @foreach ($resultData as $key => $dt)
                    <tr>
                        <td class="text-center">{{ $index }}</td>
                        <td class="text-center">{{ $dt[0]->candidate_id}}</td>
                        <td class="text-center">{{ $dt[0]->name}}</td>
                        @foreach ($dt as $d)
                            <td class="text-center">{{ $d->value }} ({{ $d->criteria_name }})</td>
                        @endforeach
                        <td class="text-center">{{ $dt[0]->score}}</td>
                        <td>
                            <form onsubmit="return confirm('Apakah anda yakin?')" action="{{ route('calculate.delete', $dt[0]->id_hasil) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn  btn-danger my-2"><i class="bx bxs-trash "
                                        aria-hidden="true"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php $index++ ?>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            $('#result_table').DataTable({
                dom: '<"d-flex justify-content-between align-items-center"lfB>rtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        className: 'btn bg-warning mb-2',
                        filename: 'Hasil_Perhitungan',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        }
                    }
                ],
            });

            // Move pagination to the right
            $('#result_table_paginate').addClass('float-end');
        });
    </script>
@endsection
