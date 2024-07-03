@extends('layouts.app')
@section('title', 'Edit Kriteria')
@section('content')

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Kriteria</h1>
        </div>

        <div class="card card-body">
            <form action="{{ route('criteria.edit', $criteria->id) }}" method="POST" id="form">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-lg-12 col-12 mb-2">
                        <label class="form-label">Kode <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control desimal-input"value="{{ $criteria->code }}"
                            name="code"required>
                    </div>
                    <div class="col-lg-12 col-12 mb-2">
                        <label class="form-label">Nama Kriteria <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control desimal-input" value="{{ $criteria->name }}"
                            name="name"required>
                    </div>
                    <div class="col-lg-12 col-12 mb-2">
                        <label class="form-label">Bobot<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control desimal-input" value="{{ $criteria->weight }}"
                            name="weight"required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="attribute" class="form-label">Atribut Kriteria <sup class="text-warning">*</sup></label>
                        <select name="attribute" id="attribute" class="form-control" required>
                            <option value="">--- pilih atribut kriteria ---</option>
                            <option value="1">Benefit</option>
                            <option value="2">Cost</option>
                        </select>
                    </div>
                    <input type="hidden" name="criteria-submit">
                    <button type="submit" name="criteria-submit" class="btn btn-primary mt-2 mx-2 w-100">Tambah</button>
                    <button type="reset" class="btn btn-danger my-2 mx-2 w-100">Clear</button>
                </div>
            </form>
        </div>
    </div>
@endsection
