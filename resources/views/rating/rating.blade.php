@extends('layouts.app')
@section('title', 'Data Calon')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><i class="fa fa-users" aria-hidden="true"></i> Data Calon</h1>

    <div class="w-100 d-flex justify-content-lg-end justify-content-center mb-3">
        <button type="button" class="btn btn-primary px-5" data-toggle="modal" data-target="#addRatingModal"> <i class="fa fa-plus" aria-hidden="true"></i> Tambah</button>
    </div>


    <div class="card mb-5">
        <div class="card-header text-primary">
            <i class="fa fa-table" aria-hidden="true"></i>
            Tabel Penilaian
        </div>
        <div class="card-body table-responsive table-bordered">
            <table class="table table-sm table-striped table-hover" id="rating-table">
                <thead class="bg-primary text-white">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Siswa</th>
                    <th class="text-center">Gambar Kriteria Prestasi</th>
                    <th class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @php($i = 1)
                @foreach($candidateData as $candidate)
                    <tr>
                        <td class="text-center">{{ $i++ }}</td>
                        <td class="text-center">{{ $candidate->student->name}}</td>
                        <td class="text-center">
                            @if ($candidate->gambar_kriteria)
                                <img src="{{asset($candidate->gambar_kriteria)}}" alt="{{$candidate->gambar_kriteria}}" width="150px" height="150px">
                            @else 
                                -
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#editDataRating{{$candidate->id}}Modal"><i class="bx bxs-message-edit" aria-hidden="true"></i>
                            </button>
                            <form action="{{ route('rating.delete', $candidate->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn  btn-danger my-2"><i class="bx bxs-trash "
                                        aria-hidden="true"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- add student modal --}}
    <div class="modal fade" id="addRatingModal" tabindex="-1" role="dialog" aria-labelledby="addRatingModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Data Penilaianan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('rating.add')}}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="col-lg-12 col-12 mb-2">
                            <label class="form-label">Nama <sup class="text-danger">*</sup></label>
                            <select name="student_id" class="form-select" id="inputGroupSelect01">
                                <option selected>Choose...</option>
                                @foreach ($studentData as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @foreach($criteriaData as $criteria)
                            <div class="form-group mb-3">
                                @if ($criteria->code === 'C1')
                                <label for="criteria_c1" class="form-label">{{ $criteria->name }} ({{$criteria->code}})<sup class="text-warning">*</sup></label>
                                <input type="number" id="criteria_c1" name="criteria_c1" class="form-control" max="100" step="0.1" required>
                                @else
                                <label for="sub_criteria_id" class="form-label">{{ $criteria->name }} ({{$criteria->code}})<sup class="text-warning">*</sup></label>
                                <select name="sub_criteria_id[]" id="sub_criteria_id" class="form-control" required>
                                    <option value="">--- pilih sub kriteria ---</option>
                                    @foreach($criteria->subCriteria as $subCriteria)
                                        <option value="{{ $subCriteria->id }}">{{ $subCriteria->name }}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        @endforeach
                        <div class="form-group mb-3">
                            <label for="formFile" class="form-label">Gambar Kriteria Prestasi</label>
                            <input class="form-control" type="file" id="formFile" name="gambar_kriteria_prestasi" accept=".img, .jpg, .png" required>
                            <small>Accept : .img, .jpg, .png</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Tambah Data {penilaian}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
{{-- edit candidate modal --}}
@foreach($candidateData as $candidate)
<div class="modal fade" id="editDataRating{{ $candidate->id }}Modal" tabindex="-1" role="dialog" aria-labelledby="addRatingModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><i class="fa fa-plus" aria-hidden="true"></i> Edit Data Calon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('rating.edit', $candidate->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="col-lg-12 col-12 mb-2">
                        <label class="form-label">Nama <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" value="{{ $candidate->student['name'] }}" readonly>
                    </div>
                    @foreach($criteriaData as $criteria)
                        <div class="form-group mb-3">
                            @if ($criteria->code === 'C1')
                            <label for="criteria_c1" class="form-label">{{ $criteria->name }} ({{$criteria->code}})<sup class="text-warning">*</sup></label>
                            <input type="number" id="criteria_c1" name="criteria_c1" class="form-control" value="{{ $candidate->nilai_akademik }}" max="100" step="0.1" required>
                            @else
                            <label for="sub_criteria_id" class="form-label">{{ $criteria->name }} ({{$criteria->code}})<sup class="text-warning">*</sup></label>
                            <select name="sub_criteria_id[]" id="sub_criteria_id" class="form-control" required>
                                <option value="">--- pilih sub kriteria ---</option>
                                @foreach($criteria->subCriteria as $subCriteria)
                                    <option value="{{ $subCriteria->id }}"
                                        @foreach($candidate->rating as $cr)
                                            @if($cr['sub_criteria_id'] == $subCriteria->id)
                                                selected
                                            @endif
                                        @endforeach
                                    >{{ $subCriteria->name }}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                    @endforeach
                    <div class="form-group mb-3">
                        <label for="formFile" class="form-label">Gambar Kriteria Prestasi</label>
                        <input class="form-control" type="file" id="formFile" name="gambar_kriteria_prestasi" accept=".img, .jpg, .png">
                        <small>Accept : .img, .jpg, .png (Kosongi jika tidak ingin merubah)</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Edit Data Kriteria</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
@section('custom-js')
    <script>
        $(document).ready(function() {
            $('#rating-table').DataTable();
        })
    </script>
@endsection
