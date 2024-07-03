@extends('layouts.app')
@section('title', 'Kelola Kelompok')
@section('content')
    <div class="container-fluid">
        <div class= "mb-2 ">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Data Kelas</h1>
            </div>

            <div class="w-100 d-flex justify-content-lg-end justify-content-center mb-3">
                <a href="{{ route('group.viewAddGrade') }}" class="btn btn-primary px-5"> <i
                        class='bx bx-plus-medical pe-2'></i>Tambah</a>
            </div>

            <div class="card mb-5">
                <div class="card-header text-primary">
                    <i class="fa fa-table" aria-hidden="true"></i>
                    Tabel Data Kelas
                </div>
                <div class="card-body table-responsive table-bordered">
                    <table class="table table-sm table-striped table-hover" id="grade-table">
                        <thead class=" text-white">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i = 1)
                            @foreach ($gradeData as $grade)
                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td class="text-center">{{ $grade->grade }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('group.viewEditGrade', $grade->id) }}"
                                                class="btn btn-warning"><i class='bx bxs-message-edit'></i> Edit</a> ||
                                            <form onsubmit="return confirm('Data pengguna akan dihapus ?')"
                                                action=" {{ route('group.deleteG', $grade->id) }}" method="POST">
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
        <div class= "mt-2 ">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Data Angkatan</h1>
            </div>

            <div class="w-100 d-flex justify-content-lg-end justify-content-center mb-3">
                <a href="{{ route('group.viewAddYear') }}" class="btn btn-primary px-5"> <i
                        class='bx bx-plus-medical pe-2'></i>Tambah</a>
            </div>

            <div class="card mb-5">
                <div class="card-header text-primary">
                    <i class="fa fa-table" aria-hidden="true"></i>
                    Tabel Data Angkatan
                </div>
                <div class="card-body table-responsive table-bordered">
                    <table class="table table-sm table-striped table-hover" id="year-table">
                        <thead class=" text-white">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Angkatan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i = 1)
                            @foreach ($yearData as $year)
                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td class="text-center">{{ $year->year }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('group.viewEditYear', $year->id) }}"
                                                class="btn btn-warning"><i class='bx bxs-message-edit'></i> Edit</a> ||
                                            <form onsubmit="return confirm('Data pengguna akan dihapus ?')"
                                                action="{{ route('group.deletey', $year->id) }}" method="POST">
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
    </div>
@endsection
@section('custom-js')
    <script>
        $(document).ready(function() {
            $('#grade-table').DataTable();
        })
        $(document).ready(function() {
            $('#year-table').DataTable();
        })
    </script>
@endsection
