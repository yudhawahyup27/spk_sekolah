@extends('layouts.app')
@section('title', 'Edit Kelas')
@section('content')

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Kelas</h1>
        </div>

        <div class="card card-body">
            <form action="{{ route('group.editG', $grade->id) }}" method="POST" id="form">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-lg-12 col-12 mb-2">
                        <label class="form-label">Kelas<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control desimal-input" value="{{ $grade->grade }}"name="grade"
                            required>
                    </div>
                    <input type="hidden" name="grade-submit">
                    <button type="submit" name="grade-submit" class="btn btn-primary mt-2 mx-2 w-100">Edit</button>
                    <button type="reset" class="btn btn-danger my-2 mx-2 w-100">Clear</button>
                </div>
            </form>
        </div>
    </div>
@endsection
