@extends('layouts.app')
@section('title', 'Edit user')
@section('content')

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit user</h1>
        </div>

        <div class="card card-body">
            <form action="{{ route('dashboard.edit', $user->id) }}" method="POST" id="form">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-lg-12 col-12 mb-2">
                        <label class="form-label">Username <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control desimal-input" placeholder="ex: 123"
                            value="{{ $user->name }}" name="name"required>
                    </div>
                    <div class="col-lg-12 col-12 mb-2">
                        <label class="form-label">Password <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control desimal-input" placeholder="ex: Andi"
                            value="{{ $user->password }}"name="password" required>
                    </div>
                    <div class="col-lg-12 col-12 mb-2">
                        <label class="form-label">Role <sup class="text-danger">*</sup></label>
                        <select class="form-select" id="inputGroupSelect01" name="role"required>
                            <option selected>Choose...</option>
                            <option value="1"@if ($user->role == 1) selected @endif>Admin</option>
                            <option value="2"@if ($user->role == 2) selected @endif>Guru</option>
                        </select>
                    </div>
                    <div class="col-lg-12 col-12 mb-2">
                        <label class="form-label">Kelas <sup class="text-danger"></sup></label>
                        <select name="grade_id" class="form-select" id="inputGroupSelect01">
                            <option selected>Choose...</option>
                            @foreach ($gradeData as $grade)
                                <option value="{{ $grade->id }}"@if($grade->id == $user->grade_id) selected @endif>{{ $grade->grade }} </option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="user-submit">
                    <button type="submit" name="user-submit" class="btn btn-primary mt-2 mx-2 w-100">Edit</button>
                    <button type="reset" class="btn btn-danger my-2 mx-2 w-100">Clear</button>
                </div>
            </form>
        </div>
    </div>

@endsection
