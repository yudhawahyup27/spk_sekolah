@extends('layouts.app')
@section('title', 'Kriteria')
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Kriteria</h1>
        </div>

        <div class="w-100 d-flex justify-content-lg-end justify-content-center mb-3">
            <a href="{{ route('criteria.viewAdd') }}" class="btn btn-primary px-5"> <i
                    class='bx bx-plus-medical pe-2'></i>Tambah</a>
        </div>

        <div class="card mb-5">
            <div class="card-header text-primary">
                <i class="fa fa-table" aria-hidden="true"></i>
                Tabel Data Kriteria
            </div>
            <div class="card-body table-responsive table-bordered">
                <table class="table table-sm table-striped table-hover" id="criteria-table">
                    <thead class=" text-white">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Kode Kriteria</th>
                            <th class="text-center">Kriteria</th>
                            <th class="text-center">Bobot</th>
                            <th class="text-center">Attribut</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach ($criteriaData as $criteria)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td class="text-center">{{ $criteria->code }}</td>
                                <td class="text-center">{{ $criteria->name }}</td>
                                <td class="text-center">{{ $criteria->weight }}</td>
                                @if ($criteria->attribute == 1)
                                    <td>Benefit</td>
                                @endif
                                @if ($criteria->attribute == 2)
                                    <td>Cost</td>
                                @endif
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('criteria.viewEdit', $criteria->id) }}" class="btn btn-warning"><i
                                                class='bx bxs-message-edit'></i> Edit</a> ||
                                        <form onsubmit="return confirm('Data pengguna akan dihapus ?')"
                                            action=" {{ route('criteria.delete', $criteria->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type=" submit" class="btn btn-danger"><i class='bx bxs-trash'></i>
                                                Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('custom-js')
    <script>
        $(document).ready(function() {
            $('#criteria-table').DataTable();
        })
    </script>
@endsection
