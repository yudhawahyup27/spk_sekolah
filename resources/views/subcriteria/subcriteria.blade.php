@extends('layouts.app')
@section('title', 'Sub Kriteria')
@section('content')
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-fw fa-chart-area"></i> Data Sub Kriteria</h1>

    @if ($status = Session::get('status'))
        @if ($message = Session::get('message'))
            <div class="alert alert-{{ $status }} alert-dismissible fade show mb-3" role="alert">
                {{ $message }}
            </div>
        @endif
    @endif

    @php($j = 0)
    @foreach ($criteriaData as $data)
        <div class="card mb-3">
            <div class="card-header text-primary">
                <i class="fa fa-table" aria-hidden="true"></i>
                {{ $data->name }} ({{ $data->code }})
            </div>
            <div class="card-body table-responsive">
                <div class="w-100 d-flex justify-content-lg-end justify-content-center mb-3">
                    <button type="button" class="btn btn-primary px-5" data-toggle="modal"
                        data-target="#addSubModal{{ $data->code }}"> <i class="fa fa-plus" aria-hidden="true"></i>
                        Tambah</button>
                </div>
                <table class="table table-sm table-striped table-hover table-bordered"
                    id="criteria-table-{{ $j }}">
                    <thead class=" text-white">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Kode</th>
                            <th class="text-center">Nama Sub Kriteria</th>
                            <th class="text-center">Nilai</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i = 1)
                        @foreach ($data->subCriteria as $subCriteria)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td class="text-center">{{ $subCriteria->code }}</td>
                                <td class="text-center">{{ $subCriteria->name }}</td>
                                <td class="text-center">{{ $subCriteria->value }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                        data-target="#editData{{ $data->code }}{{ $subCriteria->id }}modal"><i
                                            class="bx bxs-message-edit" aria-hidden="true"></i>
                                    </button>
                                    <form action="{{ route('subcriteria.delete', $subCriteria->id) }}" method="POST">
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
        @php($j++)
    @endforeach
    {{-- generate datatable --}}
    <input type="hidden" name="total_criteria" value="{{ $j }}">


    {{-- generate modal add --}}
    @foreach ($criteriaData as $data)
        <div class="modal fade" id="addSubModal{{ $data->code }}">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Data
                            Kriteria {{ $data->code }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('subcriteria.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="criteria_id" value="{{ $data->id }}">
                            <div class="form-group mb-3">
                                <label for="code" class="form-label">Kode <sup class="text-warning">*</sup></label>
                                <input type="text" name="code" id="code" class="form-control"
                                    placeholder="ex: C123" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Nama Sub Kriteria <sup
                                        class="text-warning">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="ex: Serti" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="value" class="form-label">Nilai Sub Kriteria <sup
                                        class="text-warning">*</sup></label>
                                <input type="number" name="value" id="value" class="form-control"
                                    placeholder="ex: 1000" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Tambah Sub Kriteria</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- generate modal edit --}}
    @foreach ($criteriaData as $data)
        @foreach ($data->subCriteria as $sub)
            <div class="modal fade" id="editData{{ $data->code }}{{ $sub->id }}modal">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-primary"><i class="fa fa-edit" aria-hidden="true"></i> Edit Data
                                Kriteria {{ $data->code }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('subcriteria.edit', $sub->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Nama Sub Kriteria <sup
                                            class="text-warning">*</sup></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="ex: Lama Pekerjaan" required value="{{ $sub->name }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="value" class="form-label">Nilai Sub Kriteria <sup
                                            class="text-warning">*</sup></label>
                                    <input type="number" name="value" id="value" class="form-control"
                                        placeholder="ex: 1000" required value="{{ $sub->value }}">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Tambah Sub Kriteria</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
@endsection
@section('custom-js')
    <script>
        $(document).ready(function() {
            //generate datatable
            let totalCriteria = $('input[name=total_criteria]').val();
            for (let i = 0; i < totalCriteria; i++) {
                $("#criteria-table-" + i).DataTable();

            }
        })
    </script>
@endsection
