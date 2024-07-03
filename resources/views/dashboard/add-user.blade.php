@extends('layouts.app')
@section('title', 'Tambah User')
@section('content')

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah User</h1>
        </div>

        <div class="card card-body">
            <form action="{{ route('dashboard.add') }}" method="POST" id="form">
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-12 mb-2">
                        <label class="form-label">Username<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control desimal-input" name="name"required>
                    </div>
                    <div class="col-lg-12 col-12 mb-2">
                        <label class="form-label">Password <sup class="text-danger">*</sup></label>
                        <input type="password" class="form-control desimal-input" name="password"required>
                    </div>
                    <div class="col-lg-12 col-12 mb-2">
                        <label class="form-label">Role <sup class="text-danger">*</sup></label>
                        <select id="role" name="role" class="form-select" id="inlineFormCustomSelectPref"required>
                             <option selected value="">Pilih...</option>
                             <option value="1">Admin</option>
                             <option value="2">Guru</option>
                        </select>
                   </div>
                    <div class="col-lg-12 col-12 mb-2" id="guru">
                        <label class="form-label">Kelas <sup class="text-danger"></sup></label>
                        <select name="grade_id" class="form-select" id="inputGroupSelect01">
                            <option selected>Choose...</option>
                            @foreach ($gradeData as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="user-submit">
                    <button type="submit" name="user-submit" class="btn btn-primary mt-2 mx-2 w-100">Tambah</button>
                    <button type="reset" class="btn btn-danger my-2 mx-2 w-100">Clear</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function (){
            //making serverName Dropdown box disabled by default.
            $('#guru').addClass('d-none');

            $('#role').on("change",function ()
            {

                if($(this).val() == "1"){
                    $('#guru').val = "1";
                    $('#guru').addClass('d-none');
                    $('[name=grade_id]').attr('required', false);


                    $('[name=grade_id]').val('');
                    return;
                }if($(this).val() === "2"){
                    $('#guru').removeClass('d-none');
                    $('[name=grade_id]').attr('required', true);
                    return;
                }
            });

        });
    </script>
@endsection
