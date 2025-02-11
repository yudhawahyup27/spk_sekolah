@extends('layouts.app')
@section('title', 'Siswa')
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Siswa</h1>
        </div>

        @if(Auth::user()->role == 1)
        <div class="w-100 d-flex justify-content-lg-end justify-content-center mb-3 gap-2">
            <a href="{{ route('student.viewAdd') }}" class="btn btn-primary px-5"> <i
                    class='bx bx-plus-medical pe-2'></i>Tambah</a>
        </div>
        @endif

        <div class="card mb-5">
            <div class="card-header text-primary">
                <i class="fa fa-table" aria-hidden="true"></i>
                Tabel Data Siswa
            </div>
            <div class="card-body table-responsive table-bordered">
                <table class="table table-sm table-striped table-hover" id="student-table">
                    <thead class=" text-white">
                        <tr>
                            <th class="text-center">NISN</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Jenis Kelamin</th>
                            <th class="text-center">Kelas</th>
                            <th class="text-center">Semester</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach ($studentData as $student)
                            <tr>
                                <td class="text-center">{{ $student->code }}</td>
                                <td class="text-center">{{ $student->name }}</td>
                                <td class="text-center">{{ $student->gender }}</td>
                                <td class="text-center">{{ $student->grade }}</td>
                                <td class="text-center">{{ $student->semester  }}</td> <!-- Assuming 'year' represents semester -->
                                <td>
                                    @if (Auth::user()->role == 1)
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('student.viewEdit', $student->id) }}" class="btn btn-warning"><i
                                                class='bx bxs-message-edit'></i> Edit</a> ||
                                        <form onsubmit="return confirm('Data pengguna akan dihapus ?')"
                                            action=" {{ route('student.delete', $student->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type=" submit" class="btn btn-danger"><i class='bx bxs-trash'></i>
                                                Hapus</button>
                                        </form>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Import Data Siswa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data" action="{{ route('student.students.import.post') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="file" name="user_excel" class="form-control" accept=".xls, .xlsx">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import Data</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
@endsection
@section('custom-js')
    <script>
        $(document).ready(function() {
            $('#student-table').DataTable();
        })
    </script>
@endsection
