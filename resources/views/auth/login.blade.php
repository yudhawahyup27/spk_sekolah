@extends('layouts.app2')
@section('title', 'Login User')
@section('content')
    <div class="bg-gradient-primary min-vh-100">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Login Account</h1>
                            </div>

                            @if($status = Session::get('status'))
                                @if($message = Session::get('message'))
                                    <div class="alert alert-{{ $status }} alert-dismissible fade show mb-3" role="alert">
                                        {{ $message }}
                                    </div>
                                @endif
                            @endif

                            <form class="user" method="post" action="{{ route('dashboard.login.auth') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control form-control-user" id="exampleInputname" aria-describedby="emailHelp" placeholder="Enter name Address..." required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
@section('custom-js')
@endsection

