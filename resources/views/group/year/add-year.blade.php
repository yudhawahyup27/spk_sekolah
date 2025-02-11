@extends('layouts.app')

@section('title', 'Tambah Semester')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Semester</h1>
        </div>

        <div class="card card-body">
            <form action="{{ route('group.addY') }}" method="POST" id="form">
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-12 mb-2">
                        <label class="form-label">Semester<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" name="semester" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 mx-2 w-100">Tambah</button>
                    <button type="reset" class="btn btn-danger my-2 mx-2 w-100">Clear</button>
                </div>
            </form>
        </div>
    </div>
@endsection
