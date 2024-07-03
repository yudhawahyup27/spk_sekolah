@extends('layouts.app')
@section('title', 'Tambah Kelas')
@section('content')

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Kelas</h1>
        </div>

        <div class="card card-body">
            <form action="{{ route('group.addG') }}" method="POST" id="form">
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-12 mb-2">
                        <label class="form-label">Kelas<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control desimal-input" name="grade"required>
                    </div>
                    <input type="hidden" name="grade-submit">
                    <button type="submit" name="grade-submit" class="btn btn-primary mt-2 mx-2 w-100">Tambah</button>
                    <button type="reset" class="btn btn-danger my-2 mx-2 w-100">Clear</button>
                </div>
            </form>
        </div>
    </div>
@endsection
